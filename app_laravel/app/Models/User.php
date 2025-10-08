<?php

// app/Models/OrmawaUser.php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $table = 'ormawa';
    protected $primaryKey = 'ormawa_id';
    public $timestamps = false;

    protected $fillable = [
        'username',
        'password_has',
        'ROLE',
    ];

    protected $hidden = ['password_has'];

    // Laravel akan menggunakan field ini sebagai password
    public function getAuthPassword()
    {
        return $this->password_has;
    }

}
