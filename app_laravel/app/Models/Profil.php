<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    use HasFactory;
    protected $tables = 'ormawa';
    protected $primaryKey = 'ormawa_id';
    public $timestamps = false;
    protected $fillable = [
        'ormawa_id',
        'password_hash',
        'visi',
        'misi',
        'deskripsi_profil',
        'kontak_person',
        'logo_url',
        'periode',
        'nama_ormawa',
        'gambar_kegiatan',
    ];
    

    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class, 'ormawa_id', 'ormawa_id');
    }

   
}
