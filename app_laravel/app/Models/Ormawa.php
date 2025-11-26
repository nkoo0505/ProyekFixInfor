<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Ormawa
 *
 * @property int $id
 * @property string $nama
 * @property string|null $singkatan
 * @property string|null $logo
 * @property string|null $deskripsi
 * @property string|null $visi
 * @property string|null $misi
 * @property string|null $username
 * @property string|null $password_has
 * @property string|null $role
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Kegiatan> $kegiatan
 * @property-read int|null $kegiatan_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Pengurus> $pengurus
 * @property-read int|null $pengurus_count
 * @method static \Illuminate\Database\Eloquent\Builder|Ormawa newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ormawa newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ormawa query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ormawa whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ormawa whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ormawa whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ormawa whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ormawa whereMisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ormawa whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ormawa wherePasswordHas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ormawa whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ormawa whereSingkatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ormawa whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ormawa whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ormawa whereVisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ormawa withLatestPengurusImage()
 * @mixin \Eloquent
 */
class Ormawa extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $table = 'ormawa';
    // PK adalah 'id' default Laravel, sesuai dengan migrasi Anda.
    protected $primaryKey = 'id'; 
    public $timestamps = true;

    protected $fillable = [
        'nama',
        'singkatan',
        'logo',
        'deskripsi',
        'visi',
        'misi',
        'username',     
        'password_has', 
        'role',
        'kontak_person', 
        'periode',
    ];

    // RELASI: Satu Ormawa punya banyak Pengurus
    public function pengurus()
    {
        // Pastikan nama Foreign Key-nya 'ormawa_id'
        return $this->hasMany(Pengurus::class, 'ormawa_id');
    }
    
    // RELASI: Satu Ormawa punya banyak Kegiatan
    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class, 'ormawa_id');
    }

    // SCOPE LOKAL (Opsional: Memudahkan query yang sering digunakan)
    public function scopeWithLatestPengurusImage($query)
    {
        // Asumsi kita hanya perlu 1 image (struktur BPH) untuk profil show
        // Kita bisa ambil pengurus pertama dan fotonya
        return $query->with(['pengurus' => function($q) {
            $q->select('ormawa_id', 'foto'); // Ambil hanya kolom yang diperlukan
        }]);
    }

    
}
