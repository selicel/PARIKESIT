<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjadwalan extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'nama_pemateri',
        // 'pemateri_id',
        'judul_jadwal',
        'tanggal_jadwal',
        'waktu_mulai',
        'keterangan_jadwal',
        // 'pemateri_jadwal',
        'lokasi',

    ];



    // public function pemateri(){
    //     return $this->belongsTo(User::class,'pemateri_id');
    // }


    public function peserta_pembinaan()
    {
        return $this->hasMany(PesertaPembinaan::class);
    }

    public function pembinaan()
    {
        return $this->hasOne(Pembinaan::class);
    }
    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by');
    }



    protected $casts = [
        'created_by' => 'integer',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = auth()->id();
        });
    }
}
