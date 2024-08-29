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
            $table->renameColumn('start_date', 'overtime_start');
            $table->dateTime('overtime_start')->nullable()->change();
            $table->dateTime('overtime_end')->nullable()->after('overtime_start');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('overtimes', function (Blueprint $table) {
            $table->renameColumn('overtime_start', 'start_date');
            $table->date('start_date')->change();
            $table->dropColumn('overtime_end');
        });
    }
};
