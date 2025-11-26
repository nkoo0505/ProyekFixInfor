<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('balas_pertanyaan', function (Blueprint $table) {
            $table->id('balasan_id'); // Sesuai ERD [cite: 1, 2]
            
            // Foreign key ke tabel pendapat [cite: 1, 2]
            $table->foreignId('pendapat_id')->constrained('pendapat', 'pendapat_id')->onDelete('cascade');
            
            $table->text('isi_balasan'); // Sesuai ERD [cite: 1, 2]
            $table->timestamp('waktu_kirim')->nullable(); // Sesuai ERD [cite: 1, 2]
            
            // Asumsi 'dibalas_oleh' adalah ID User yang login (admin)
            // dan 'ormawa_id' adalah ID Ormawa yang diwakili admin tsb
            $table->foreignId('dibalas_oleh')->constrained('users', 'id'); // ERD tidak jelas, ini asumsi 
            $table->foreignId('ormawa_id')->constrained('ormawa', 'id'); // Sesuai ERD [cite: 1, 2]
            
            // $table->timestamps(); // Hapus jika tidak perlu
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('balas_pertanyaan');
    }
};