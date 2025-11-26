<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * ... (DocBlock dari IntelliSense) ...
 */
class Pendapat extends Model
{
    use HasFactory;
    
    protected $table = 'pendapat'; 
    protected $primaryKey = 'pendapat_id'; 
    public $timestamps = false;
    // 🔥 Pastikan 'tipe' dan 'ormawa_asal_id' ada di sini jika Anda sudah menjalankan migrasi
    protected $fillable = ['nama', 'pesan', 'waktu_kirim', 'status', 'tipe', 'ormawa_asal_id']; 
    
    // Relasi ke Balasan
    public function balasan()
    {
        // Satu Pendapat memiliki satu Balasan
        return $this->hasOne(Balasan::class, 'pendapat_id', 'pendapat_id'); 
    }
    
    // 🔥 PERBAIKAN: Tambahkan relasi ormawaAsal
    // Relasi ke Ormawa Asal (untuk pertanyaan internal antar pengurus)
    public function ormawaAsal()
    {
        // ASUMSI: ormawa_asal_id merujuk ke PK 'id' di tabel Ormawa
        return $this->belongsTo(Ormawa::class, 'ormawa_asal_id', 'id');
    }
}