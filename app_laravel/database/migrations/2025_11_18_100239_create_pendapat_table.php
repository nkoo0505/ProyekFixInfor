<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendapat', function (Blueprint $table) {
            $table->id('pendapat_id'); // Sesuai ERD [cite: 1, 2]
            $table->string('nama', 100)->nullable(); // Sesuai ERD (bisa anonim) [cite: 1, 2]
            $table->text('pesan'); // 'pesan' di ERD [cite: 1, 2]
            $table->timestamp('waktu_kirim')->nullable(); // Sesuai ERD [cite: 1, 2]
            $table->string('status', 20)->default('pending'); // Kolom status di ERD [cite: 1, 2]
            // $table->timestamps(); // Hapus jika tidak perlu
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendapat');
    }
};