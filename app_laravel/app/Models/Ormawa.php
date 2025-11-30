<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class Ormawa extends Authenticatable
{
    use Notifiable;

    protected $table = 'ormawa'; // tabel yang digunakan
    protected $primaryKey = 'ormawa_id';
    public $timestamps = false;

    protected $fillable = [
        'username',
        'password_has',
        'ROLE',
    ];

    // Laravel akan menggunakan field ini sebagai password
    public function getAuthPassword()
    {
        return $this->password_has;
    }

    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class, 'ormawa_id', 'ormawa_id');
    }
}
