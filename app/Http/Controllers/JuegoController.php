<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jugador;
use App\Models\Resultado;

class JuegoController extends Controller
{
    public function landing()
    {
        return view('landing');
    }

    public function iniciar(Request $request)
    {
        // Valida los datos
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|max:255',
        ]);

        // Crea o actualiza al jugador
        $jugador = Jugador::updateOrCreate(
            ['correo' => $data['correo']],
            ['nombre' => $data['nombre']]
        );

        // Redirige al juego
        return redirect()->to('/juego/' . $jugador->id);
    }

    public function jugar($jugadorId)
    {
        $jugador = Jugador::findOrFail($jugadorId);
        return view('juego', compact('jugador'));
    }

   public function guardarResultado(Request $request, $jugadorId)
{
    $jugador = Jugador::findOrFail($jugadorId);

    Resultado::create([
        'jugador_id' => $jugador->id,
        'total_correctas' => $request->input('resultado'),
    ]);

    return redirect('/')->with('mensaje', '¡Gracias por jugar!');
}

    public function scores()
{
    $resultados = Resultado::with('jugador')->latest()->get();

    return view('scores', compact('resultados'));
}
}
