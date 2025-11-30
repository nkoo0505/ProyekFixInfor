<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalasPertanyaan extends Model
{
    use HasFactory;

    protected $table = 'balas_pertanyaan';
    protected $primaryKey = 'balasan_id';
    public $timestamps = false;

    protected $fillable = [
        'pendapat_id',
        'isi_balasan',
        'waktu_kirim',
        'dibalas_oleh',
        'tanggal_balasan',
    ];

    public function pendapat()
    {
        return $this->belongsTo(Pendapat::class, 'pendapat_id', 'pendapat_id');
    }
}
