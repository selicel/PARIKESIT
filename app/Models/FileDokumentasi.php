<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileDokumentasi extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'nama_file',
        'tipe_file',
        'dokumentasi_kegiatan_id',
    ];


    public function dokumentasi()
    {
        return $this->belongsTo(DokumentasiKegiatan::class);
    }
}
