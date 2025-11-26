<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FAQ
 *
 * @property int $faq_id
 * @property int $ormawa_id
 * @property string $pertanyaan_faq
 * @property string $jawaban_faq
 * @property string|null $waktu_input
 * @property-read \App\Models\Ormawa $ormawa
 * @method static \Illuminate\Database\Eloquent\Builder|FAQ newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FAQ newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FAQ query()
 * @method static \Illuminate\Database\Eloquent\Builder|FAQ whereFaqId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FAQ whereJawabanFaq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FAQ whereOrmawaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FAQ wherePertanyaanFaq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FAQ whereWaktuInput($value)
 * @mixin \Eloquent
 */
class FAQ extends Model
{
    use HasFactory;

    // Menunjuk ke tabel 'faq' sesuai ERD Anda [cite: 1, 2]
    protected $table = 'faq'; 
    
    // Asumsi 'faq_id' adalah primary key
    protected $primaryKey = 'faq_id'; 

    protected $fillable = [
        'ormawa_id',
        'pertanyaan_faq',
        'jawaban_faq',
        'waktu_input',
    ];

    // Nonaktifkan timestamps bawaan Laravel jika tidak ada
    // 'created_at' & 'updated_at' di tabel 'faq' Anda
    public $timestamps = false; 

    // Relasi ke Ormawa (jika diperlukan) [cite: 1, 2]
    public function ormawa()
    {
        return $this->belongsTo(Ormawa::class, 'ormawa_id');
    }
}