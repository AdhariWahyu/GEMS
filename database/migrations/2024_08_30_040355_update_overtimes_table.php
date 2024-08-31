<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('overtimes', function (Blueprint $table) {
            $table->date('date')->after('user_id');
            $table->dropColumn('overtime_end');
            $table->time('start_time')->after('date')->nullable();
            $table->time('end_time')->after('start_time')->nullable();
            $table->integer('duration')->after('end_time')->nullable();
            $table->dropColumn('reason');
            $table->renameColumn('note', 'task_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('overtimes', function (Blueprint $table) {
            $table->dropColumn('date');
            $table->dropColumn('start_time');
            $table->dropColumn('end_time');
            $table->dropColumn('duration');
            $table->text('reason')->after('user_id');
            $table->renameColumn('task_description', 'note');
            $table->dateTime('overtime_end')->after('overtime_start');
        });
    }
};
