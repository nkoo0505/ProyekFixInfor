<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Kegiatan
 *
 * @property int $id
 * @property int $ormawa_id
 * @property string $nama_kegiatan
 * @property string $deskripsi
 * @property string $tanggal_mulai
 * @property string $tanggal_selesai
 * @property string|null $poster
 * @property string $link_daftar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ormawa $ormawa
 * @method static \Illuminate\Database\Eloquent\Builder|Kegiatan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Kegiatan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Kegiatan query()
 * @method static \Illuminate\Database\Eloquent\Builder|Kegiatan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kegiatan whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kegiatan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kegiatan whereLinkDaftar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kegiatan whereNamaKegiatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kegiatan whereOrmawaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kegiatan wherePoster($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kegiatan whereTanggalMulai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kegiatan whereTanggalSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kegiatan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
