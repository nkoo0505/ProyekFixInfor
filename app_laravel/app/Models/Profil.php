<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    use HasFactory;
    protected $tables = 'ormawa';
    protected $primaryKeys = 'ormawa_id';
    public $timestamps = false;
    protected $fillable = [
        'ormawa_id',
        'judul',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'linkPendaftaran_url',
        'poster',
    ];
}
