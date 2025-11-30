<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendapat extends Model
{
    use HasFactory;

    protected $table = 'pendapat';
    protected $primaryKey = 'pendapat_id';
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'pesan',
        'waktu_kirim',
        'STATUS',
    ];

    public function balasan()
    {
        // Satu pendapat bisa punya beberapa balasan
        return $this->hasMany(BalasPertanyaan::class, 'pendapat_id', 'pendapat_id');
    }
}
