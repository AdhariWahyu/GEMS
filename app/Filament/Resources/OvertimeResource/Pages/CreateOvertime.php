<?php

namespace App\Filament\Resources\OvertimeResource\Pages;

use App\Filament\Resources\OvertimeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Auth;

class CreateOvertime extends CreateRecord
{
    protected static string $resource = OvertimeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['status'] = 'pending';

    if (isset($data['start_time']) && isset($data['end_time'])) {
        $startTime = \Carbon\Carbon::parse($data['start_time']);
        $endTime = \Carbon\Carbon::parse($data['end_time']);
        $data['duration'] = $startTime->diff($endTime)->format('%H jam %I menit');
    } elseif (isset($data['start_time'])) {
        $data['duration'] = $data['start_time'] . ' - Selesai';
    }

    return $data;
    }

}
