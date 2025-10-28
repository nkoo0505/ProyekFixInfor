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
        'password_hash',
        'visi',
        'misi',
        'deskripsi_profil',
        'kontak_person',
        'logo_url',
        'periode',
        'nama_ormawa',
    ];

    public function profil()
    {
        return $this->belongsTo(Ormawa::class, 'ormawa_id');
    }
}
