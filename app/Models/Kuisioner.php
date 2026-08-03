<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kuisioner extends Model
{
    use HasFactory;

    protected $table = 'kuisioner';

    protected $fillable = [
        'nip',
        'date',
        'confirm_statement',
        'is_bersalah',
        'signature',
        'saran_perbaikan',
    ];

    protected $casts = [
        'date' => 'date',
        'confirm_statement' => 'boolean',
        'is_bersalah' => 'boolean',
    ];

    public function cabang()
    {
        return $this->hasMany(KuisionerCabang::class, 'kuisioner_id');
    }
}
