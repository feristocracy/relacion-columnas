<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jugador extends Model
{
    use HasFactory;

    // Permitir asignación masiva
    protected $fillable = ['nombre', 'correo'];

    // Relación con resultados (opcional pero útil)
    public function resultados()
    {
        return $this->hasMany(Resultado::class);
    }
}
