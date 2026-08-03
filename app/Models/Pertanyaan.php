<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan';

    protected $fillable = [
        'category',
        'type',
        'list_jawaban',
        'need_description_on',
        'desciption_hint',
        'pertanyaan'
    ];

    public function jawabanItems()
    {
        return $this->hasMany(KuisionerJawabanItem::class, 'pertanyaan_id');
    }
}
