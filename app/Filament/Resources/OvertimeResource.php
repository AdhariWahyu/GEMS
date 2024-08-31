<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OvertimeResource\Pages;
use App\Models\Overtime;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;

class OvertimeResource extends Resource
{
    protected static ?string $model = Overtime::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationLabel(): string
    {
        return 'Lembur';
    }

    public static function form(Form $form): Form
    {
        $schema = [
            Forms\Components\Section::make('Detail')
                ->schema([
                    Forms\Components\Select::make('user_id')
                        ->relationship('user', 'name')
                        ->searchable()
                        ->required(),
                    Forms\Components\TextInput::make('position')
                        ->datalist([
                            'Junior Piping Engineer',
                            'Creative Associate',
                            'Accounting & Finance',
                            'Graphic Design',
                        ])
                        ->columnSpanFull()
                        ->required(),
                    Forms\Components\DatePicker::make('date')
                        ->required(),
                    Forms\Components\Group::make([
                        Forms\Components\TimePicker::make('start_time')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $startTime = $get('start_time');
                                $endTime = $get('end_time');
                                if ($endTime) {
                                    $duration = Carbon::parse($startTime)->diff(Carbon::parse($endTime))->format('%H jam %I menit');
                                } else {
                                    $duration = $startTime . ' - Selesai';
                                }
                                $set('duration', $duration);
                            }),
                        Forms\Components\TimePicker::make('end_time')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $startTime = $get('start_time');
                                $endTime = $get('end_time');
                                if ($startTime && $endTime) {
                                    $duration = Carbon::parse($startTime)->diff(Carbon::parse($endTime))->format('%H jam %I menit');
                                    $set('duration', $duration);
                                }
                            }),
                    ])
                    ->columns(2),
                    Forms\Components\TextInput::make('duration')
                        ->disabled()
                        ->helperText('Durasi Terhitung Otomatis'),
                    Forms\Components\Textarea::make('task_description')
                        ->columnSpanFull(),
                ]),
        ];

        if (Auth::user()->hasRole('super_admin')) {
            $schema[] = Forms\Components\Section::make('Approval')
                ->schema([
                    Forms\Components\Select::make('status')
                        ->options([
                            'Approved' => 'Approved',
                            'Rejected' => 'Rejected'
                        ]),
                    Forms\Components\Textarea::make('note')
                        ->columnSpanFull(),
                ]);
        }

        return $form->schema($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $is_super_admin = Auth::user()->hasRole('super_admin');

                if (!$is_super_admin) {
                    $query->where('user_id', Auth::user()->id);
                }
            })
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('position')
                    ->searchable(),
                Tables\Columns\TextColumn::make('duration')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match($state) {
                        'pending' => 'gray',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOvertimes::route('/'),
            'create' => Pages\CreateOvertime::route('/create'),
            'edit' => Pages\EditOvertime::route('/{record}/edit'),
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::user()->id;
        $data['status'] = 'pending';

        if ($data['start_time'] && $data['end_time']) {
            $startTime = Carbon::parse($data['start_time']);
            $endTime = Carbon::parse($data['end_time']);
            $data['duration'] = $startTime->diff($endTime)->format('%H jam %I menit');
        } elseif ($data['start_time']) {
            $data['duration'] = $data['start_time'] . ' - Selesai';
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($data['start_time'] && $data['end_time']) {
            $startTime = Carbon::parse($data['start_time']);
            $endTime = Carbon::parse($data['end_time']);
            $data['duration'] = $startTime->diff($endTime)->format('%H jam %I menit');
        } elseif ($data['start_time']) {
            $data['duration'] = $data['start_time'] . ' - Selesai';
        }

        return $data;
    }
}
