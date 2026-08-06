<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuisionerJawabanItem extends Model
{
    use HasFactory;

    protected $table = 'kuisioner_jawaban_item';

    protected $fillable = [
        'jawaban_id',
        'pertanyaan_id',
        'jawaban',
        'description',
    ];

    public function kuisionerJawaban()
    {
        return $this->belongsTo(KuisionerJawaban::class, 'jawaban_id');
    }

    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class, 'pertanyaan_id');
    }
}
