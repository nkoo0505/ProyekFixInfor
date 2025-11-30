<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengurus', function (Blueprint $table) {
            if (!Schema::hasColumn('pengurus', 'nama_panggilan')) {
                $table->string('nama_panggilan', 100)->nullable()->after('nama');
            }

            if (!Schema::hasColumn('pengurus', 'tahun_jabatan')) {
                $table->string('tahun_jabatan', 50)->nullable()->after('jabatan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pengurus', function (Blueprint $table) {
            if (Schema::hasColumn('pengurus', 'tahun_jabatan')) {
                $table->dropColumn('tahun_jabatan');
            }

            if (Schema::hasColumn('pengurus', 'nama_panggilan')) {
                $table->dropColumn('nama_panggilan');
            }
        });
    }
};
