<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 p-6">

    <div class="max-w-6xl mx-auto bg-white p-8 rounded-xl shadow-md">
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">Resultados de Jugadores</h1>

        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="bg-blue-600 text-white">
                    <th class="p-3 text-left">Nombre</th>
                    <th class="p-3 text-left">Correo</th>
                    <th class="p-3 text-left">Fecha</th>
                    <th class="p-3 text-left">Respuestas Correctas</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse ($resultados as $resultado)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="p-3">{{ $resultado->jugador->nombre }}</td>
                        <td class="p-3">{{ $resultado->jugador->correo }}</td>
                        <td class="p-3">{{ $resultado->created_at->format('d/m/Y h:i A') }}</td>
                        <td class="p-3">{{ $resultado->total_correctas }}/12</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center p-4">No hay resultados aún.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</body>
</html>
