<?php

namespace App\Models;

use App\Models\Formulir;
use App\Models\Indikator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penilaian extends Model
{
    use HasFactory;

    protected $fillable = [
        'indikator_id',
        'formulir_id',

        'nilai',
        'catatan',
        'tanggal_penilaian',
        'user_id',
        'bukti_dukung',
        'dikerjakan_by',


        'nilai_diupdate',
        'catatan_koreksi', // Catatan penjelasan koreksi dari walidata
        'diupdate_by',
        'tanggal_diperbarui',

        'nilai_koreksi',
        'dikoreksi_by',
        'evaluasi',
        'tanggal_dikoreksi',
        // 'created_by_id', // Add this line
    ];

    public function indikator()
    {
        return $this->belongsTo(Indikator::class, 'indikator_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function formulir()
    {
        return $this->belongsTo(Formulir::class);
    }

    public function dikerjakan_by()
    {
        return $this->belongsTo(User::class, 'dikerjakan_by');
    }


    public function diupdate_by()
    {
        return $this->belongsTo(User::class, 'diupdate_by');
    }


    public function dikoreksi_by()
    {
        return $this->belongsTo(User::class, 'dikoreksi_by');
    }

    // public function created_by()
    // {
    //     return $this->belongsTo(User::class, 'created_by_id');
    // }


    protected $casts = [
        'user_id' => 'integer',
    ];

    // public static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         $model->user_id = auth()->id();
    //     });
    // }
}
