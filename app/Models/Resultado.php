<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resultado extends Model
{
    use HasFactory;

    protected $fillable = ['jugador_id', 'total_correctas'];

    public function jugador()
    {
        return $this->belongsTo(Jugador::class);
    }
}
