<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Juego de Relacionar Columnas</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">


    <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md">
        @if (session('mensaje'))
        <div class="max-w-md mx-auto mb-6">
            <div class="bg-green-100 text-green-800 border border-green-400 rounded-lg px-4 py-3 shadow-md text-center">
                {{ session('mensaje') }}
            </div>
        </div>
        @endif
        <h1 class="mb-6"><img src="/images/logo.jpg" alt="logo de la empresa"></h1>
        <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Relacionar Columnas</h1>

        <form method="POST" action="{{ url('/iniciar') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-gray-700 mb-1">Nombre</label>
                <input type="text" name="nombre" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-300">
            </div>
            <div>
                <label class="block text-gray-700 mb-1">Correo electrónico</label>
                <input type="email" name="correo" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-300">
            </div>
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                Iniciar Juego
            </button>
        </form>
        <footer class="w-100 text-center mt-5">Desarrollado por: 🖥Tecno Glitch</footer>
    </div>

</body>

</html>