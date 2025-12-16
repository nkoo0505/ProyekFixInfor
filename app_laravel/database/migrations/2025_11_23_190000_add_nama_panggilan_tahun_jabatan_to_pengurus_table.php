<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pengurus', function (Blueprint $table) {
            $table->string('nama_panggilan', 50)->nullable()->after('jabatan');
            $table->string('tahun_jabatan', 20)->nullable()->after('nama_panggilan');
        });
    }

    public function down()
    {
        Schema::table('pengurus', function (Blueprint $table) {
            $table->dropColumn(['nama_panggilan', 'tahun_jabatan']);
        });
    }
};
