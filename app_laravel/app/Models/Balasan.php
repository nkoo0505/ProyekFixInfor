<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Balasan
 *
 * @property int $balasan_id
 * @property int $pendapat_id
 * @property string $isi_balasan
 * @property string|null $waktu_kirim
 * @property int $dibalas_oleh
 * @property int $ormawa_id
 * @property-read \App\Models\User $admin
 * @property-read \App\Models\Ormawa $ormawa
 * @property-read \App\Models\Pendapat $pendapat
 * @method static \Illuminate\Database\Eloquent\Builder|Balasan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Balasan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Balasan query()
 * @method static \Illuminate\Database\Eloquent\Builder|Balasan whereBalasanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Balasan whereDibalasOleh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Balasan whereIsiBalasan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Balasan whereOrmawaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Balasan wherePendapatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Balasan whereWaktuKirim($value)
 * @mixin \Eloquent
 */
class Balasan extends Model
{
    use HasFactory;

    protected $table = 'balas_pertanyaan';
    protected $primaryKey = 'balasan_id';

    protected $fillable = [
        'pendapat_id',
        'isi_balasan',
        'waktu_kirim',
        'dibalas_oleh', // ID User/Admin
        'ormawa_id',    // ID Ormawa
    ];
    public $timestamps = false;

    // Relasi ke User (Admin yang membalas)
    public function admin()
    {
        // ASUMSI: kolom 'dibalas_oleh' di tabel balas_pertanyaan menyimpan ID User (Admin)
        return $this->belongsTo(User::class, 'dibalas_oleh', 'id');
    }

    // Relasi ke Ormawa (Ormawa yang diwakilkan)
    public function ormawa()
    {
        return $this->belongsTo(Ormawa::class, 'ormawa_id', 'id');
    }

    // Relasi ke Pendapat
    public function pendapat()
    {
        return $this->belongsTo(Pendapat::class, 'pendapat_id');
    }
}