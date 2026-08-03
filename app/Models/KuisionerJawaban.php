<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuisionerJawaban extends Model
{
    use HasFactory;

    protected $table = 'kuisioner_jawaban';

    protected $fillable = [
        'kuisioner_cabang_id',
        'is_melakukan',
        'is_mengetahui',
    ];

    protected $casts = [
        'is_melakukan' => 'boolean',
        'is_mengetahui' => 'boolean',
    ];

    public function kuisionerCabang()
    {
        return $this->belongsTo(KuisionerCabang::class, 'kuisioner_cabang_id');
    }

    public function items()
    {
        return $this->hasMany(KuisionerJawabanItem::class, 'jawaban_id');
    }
}
