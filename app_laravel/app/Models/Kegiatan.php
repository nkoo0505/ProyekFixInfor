<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;
    protected $table = 'kegiatan';
    protected $fillable = [
        'ormawa_id',
        'nama_kegiatan',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'link_daftar',
        'poster',
    ];

    public function ormawa()
    {
        return $this->belongsTo(Ormawa::class, 'ormawa_id');
    }
}
