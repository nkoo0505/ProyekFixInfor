<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Ormawa extends Authenticatable
{
    protected $table = 'ormawa';

    protected $fillable = [
        'nama',
        'singkatan',
        'logo',
        'deskripsi',
        'visi',
        'misi',
    ];
}
