<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Pengurus
 *
 * @property int $id
 * @property int $ormawa_id
 * @property string $nama
 * @property string $jabatan
 * @property string $foto
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ormawa $ormawa
 * @method static \Illuminate\Database\Eloquent\Builder|Pengurus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pengurus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pengurus query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pengurus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pengurus whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pengurus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pengurus whereJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pengurus whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pengurus whereOrmawaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pengurus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Pengurus extends Model
{
   use HasFactory;
    
    protected $table = 'pengurus';
    
    protected $fillable = [
        'ormawa_id',
        'nama',
        'jabatan',
        'nama_panggilan', // 🔥 Tambahkan ini
        'tahun_jabatan',  // 🔥 Tambahkan ini (Jika tipe data di DB String/Tahun)
        'foto' 
    ];

    public function ormawa()
    {
        // Pastikan nama Foreign Key-nya 'ormawa_id'
        return $this->belongsTo(Ormawa::class, 'ormawa_id');
    }
}