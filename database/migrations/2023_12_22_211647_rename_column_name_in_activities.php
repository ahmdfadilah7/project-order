<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::table('activities', function (Blueprint $table) {
        //     $table->renameColumn('judul_aktfitas', 'judul_aktivitas');
        // });
        DB::statement('ALTER TABLE activities CHANGE judul_aktfitas judul_aktivitas TEXT');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            //
        });
    }
};
