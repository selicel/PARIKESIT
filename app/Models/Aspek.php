<?php

namespace App\Models;

use App\Models\Domain;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aspek extends Model
{
    use HasFactory;

    protected $fillable = [
        'domain_id',
        'nama_aspek',
        'bobot_aspek',
    ];

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }

    public function indikator()
    {
        return $this->hasMany(Indikator::class);
    }
}
