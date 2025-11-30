<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    use HasFactory;

    protected $table = 'faq';
    protected $primaryKey = 'faq_id';
    public $timestamps = false;

    protected $fillable = [
        'ormawa_id',
        'pertanyaan_faq',
        'jawaban_faq',
        'waktu_input',
    ];
}
