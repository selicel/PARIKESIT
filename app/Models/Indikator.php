<?php

namespace App\Models;

use App\Models\Aspek;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Indikator extends Model
{
    use HasFactory;

    protected $fillable = [
        'aspek_id',
        'nama_indikator',
        'bobot_indikator',
        'level_1_kriteria',
        'level_2_kriteria',
        'level_3_kriteria',
        'level_4_kriteria',
        'level_5_kriteria'
    ];


    public function aspek()
    {
        return $this->belongsTo(Aspek::class);
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'indikator_id');
    }
}
