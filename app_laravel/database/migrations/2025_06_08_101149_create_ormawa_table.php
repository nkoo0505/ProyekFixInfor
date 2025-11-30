<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ormawa', function (Blueprint $table) {
            $table->id(); // INI MEMBUAT KOLOM 'id' (BigInteger)
            
            // Kolom lainnya...
            $table->string('nama');
            $table->string('singkatan')->nullable();
            $table->string('logo')->nullable();
            $table->text('deskripsi')->nullable();
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->string('username')->nullable();
            $table->string('password_has')->nullable();
            $table->string('role')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ormawa');
    }
};