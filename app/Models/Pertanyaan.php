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
        'pertanyaan',
    ];

    public function jawabanItems()
    {
        return $this->hasMany(KuisionerJawabanItem::class, 'pertanyaan_id');
    }
}
