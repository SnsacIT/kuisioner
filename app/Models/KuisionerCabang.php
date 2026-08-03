<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuisionerCabang extends Model
{
    use HasFactory;

    protected $table = 'kuisioner_cabang';

    protected $fillable = [
        'kuisioner_id',
        'dealercabang_id',
        'start_date',
        'end_date',
        'mess',
        'mekanik',
        'atl',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function kuisioner()
    {
        return $this->belongsTo(Kuisioner::class, 'kuisioner_id');
    }

    public function jawaban()
    {
        return $this->hasOne(KuisionerJawaban::class, 'kuisioner_cabang_id');
    }

    public function dealerCabang()
    {
        return $this->belongsTo(DealerCabang::class, 'dealercabang_id');
    }
}
