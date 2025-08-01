<?php

namespace App\Models;

use App\Models\FileDokumentasi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DokumentasiKegiatan extends Model
{
    use HasFactory;


    protected $fillable = [
        'created_by_id',
        'directory_dokumentasi',
        'judul_dokumentasi',
        'bukti_dukung_undangan_dokumentasi',
        'daftar_hadir_dokumentasi',
        'materi_dokumentasi',
        'notula_dokumentasi',
    ];


   public function profile()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function file_dokumentasi()
    {
        return $this->hasMany(FileDokumentasi::class);
    }
}
