<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faq', function (Blueprint $table) {
            $table->id('faq_id'); // Sesuai ERD [cite: 1, 2]
            
            // Foreign key ke tabel ormawa [cite: 1, 2]
            $table->foreignId('ormawa_id')->constrained('ormawa', 'id'); 
            
            $table->text('pertanyaan_faq'); // Sesuai ERD [cite: 1, 2]
            $table->text('jawaban_faq'); // Sesuai ERD [cite: 1, 2]
            $table->timestamp('waktu_input')->nullable(); // Sesuai ERD [cite: 1, 2]
            // $table->timestamps(); // Hapus jika tidak perlu
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faq');
    }
};