<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Relacionar Columnas</title>
    @vite('resources/css/app.css')
    <style>
        .masonry-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-auto-rows: 1px;
            grid-row-gap: 1rem;
            grid-column-gap: 1rem;
        }
        .masonry-item {
            grid-row-end: span var(--rows);
            height: fit-content;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .masonry-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-7xl">
        <h1 class="mb-6 flex justify-center items-center">
            <img src="/images/logo.jpg" alt="logo de la empresa" class="mx-auto">
        </h1>
        <h2 class="text-2xl font-bold text-center mb-6">Arrastra la respuesta a la pregunta que le corresponde</h2>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <!-- Preguntas -->
            <div class="col-span-2">
                <h3 class="font-semibold mb-4 text-center text-xl">Preguntas</h3>
                <div id="preguntas" class="masonry-grid">
                    @foreach(["¿Qué debe contener el programa anual de adquisiciones, arrendamientos y servicios?", "¿Cuál es su fecha límite de publicación del programa anual?", "¿Qué funciones principales tienen los Comités de Adquisiciones en las dependencias?",  "¿Qué artículo habla sobre las funciones de los comités de adquisiciones?", "¿Quién preside el Comité de Adquisiciones?", "¿Cuál es la función del Comité de Adquisiciones de Hacienda?", "¿Qué artículo habla sobre los criterios que deben guiar el gasto público en contrataciones?",  "¿Qué sucede si una dependencia desea formalizar contratos antes de contar con presupuesto autorizado?",  "¿Qué tipos de procedimientos de contratación reconoce la ley?", "¿En qué artículo se menciona la participación de testigos sociales?", "¿Qué reglas rigen la presentación de proposiciones por los licitantes?", "¿Qué función tiene la Secretaría respecto a los medios de identificación electrónica?" ] as $pregunta)
                    <div class="masonry-item p-4 bg-blue-100 rounded-lg font-medium text-center" data-texto-original="{{ $pregunta }}">
                        {{ $pregunta }}
                    </div>
                    @endforeach

                </div>
                <div id="respuestas-libres" class="hidden"></div>
            </div>

            <!-- Respuestas -->
            <div class="col-span-2">
                <h3 class="font-semibold mb-4 text-center text-xl">Respuestas</h3>
                <div id="respuestas" class="masonry-grid min-h-[240px] text-center font-semibold">
                    @foreach(collect([
                    "Adquisiciones previstas para el siguiente ejercicio fiscal",
                    "A más tardar el 31 de diciembre del año en curso en la Plataforma. ",
                    "Revisar programas y presupuestos, dictaminar excepciones a licitaciones públicas, analizar resultados trimestrales, autorizar subcomités y aprobar manuales de funcionamiento.",
                    "Artículo 30",
                    "El titular de la Unidad de Administración o equivalente",
                    "Realizar procedimientos de contratación consolidados y revisar suficiencia presupuestal ",
                    "Artículo 32",
                    "Puede solicitar autorización a Hacienda, pero su vigencia estará sujeta a la disponibilidad presupuestaria del ejercicio fiscal correspondiente.",
                    "Licitación pública, invitación a tres personas, adjudicación directa, diálogo competitivo, adjudicación con estrategia de negociación, contratos derivados de acuerdo marco y órdenes de suministro.",
                    "Artículo 38",
                    "En formato digital, por medio de la Plataforma, firma electrónica. No pueden modificarse ni retirarse una vez entregadas.",
                    "Opera y certifica los medios de firma electrónica, asegurando su validez legal y su equivalencia con la firma autógrafa. "
                    ])->shuffle() as $respuesta)
                    <div class="masonry-item respuesta draggable p-4 bg-green-100 rounded-lg cursor-move" draggable="true">
                        {{ $respuesta }}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <button onclick="finalizarJuego()"
            class="mt-6 w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
            Finalizar
        </button>
    </div>

    <form id="formularioEnvio" method="POST" action="{{ url('/resultado/' . $jugador->id) }}">
        @csrf
        <input type="hidden" name="resultado" id="resultado">
    </form>

    <script>
    // Función para calcular el tamaño de los elementos masonry
    function resizeAllMasonryItems() {
        resizeMasonryItems(document.querySelector('#preguntas'));
        resizeMasonryItems(document.querySelector('#respuestas'));
    }
    
    // Función para calcular el tamaño de los elementos masonry en un contenedor específico
    function resizeMasonryItems(grid) {
        if (!grid) return;
        
        const rowHeight = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-auto-rows'));
        const rowGap = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-row-gap'));
        
        const items = grid.querySelectorAll('.masonry-item');
        items.forEach(item => {
            const contentHeight = item.getBoundingClientRect().height;
            const rowSpan = Math.ceil((contentHeight + rowGap) / (rowHeight + rowGap));
            item.style.setProperty('--rows', rowSpan);
        });
    }

    // Ejecutar al cargar la página
    window.addEventListener('load', resizeAllMasonryItems);
    
    // Ejecutar al cambiar el tamaño de la ventana
    window.addEventListener('resize', resizeAllMasonryItems);
    
    // Observar cambios en el DOM para recalcular
    const preguntasObserver = new MutationObserver(() => resizeMasonryItems(document.querySelector('#preguntas')));
    preguntasObserver.observe(document.getElementById('preguntas'), { childList: true, subtree: true });
    
    const respuestasObserver = new MutationObserver(() => resizeMasonryItems(document.querySelector('#respuestas')));
    respuestasObserver.observe(document.getElementById('respuestas'), { childList: true, subtree: true });
    
    const relacionesCorrectas = {
        "¿Qué debe contener el programa anual de adquisiciones, arrendamientos y servicios?": "Adquisiciones previstas para el siguiente ejercicio fiscal",
        "¿Cuál es su fecha límite de publicación del programa anual?": "A más tardar el 31 de diciembre del año en curso en la Plataforma. ",
        "¿Qué funciones principales tienen los Comités de Adquisiciones en las dependencias?": "Revisar programas y presupuestos, dictaminar excepciones a licitaciones públicas, analizar resultados trimestrales, autorizar subcomités y aprobar manuales de funcionamiento.",
        "¿Qué artículo habla sobre las funciones de los comités de adquisiciones?": "Artículo 30",
        "¿Quién preside el Comité de Adquisiciones?": "El titular de la Unidad de Administración o equivalente",
        "¿Cuál es la función del Comité de Adquisiciones de Hacienda?":"Realizar procedimientos de contratación consolidados y revisar suficiencia presupuestal ",
        "¿Qué artículo habla sobre los criterios que deben guiar el gasto público en contrataciones?":"Artículo 32",
        "¿Qué sucede si una dependencia desea formalizar contratos antes de contar con presupuesto autorizado?":"Puede solicitar autorización a Hacienda, pero su vigencia estará sujeta a la disponibilidad presupuestaria del ejercicio fiscal correspondiente.",
        "¿Qué tipos de procedimientos de contratación reconoce la ley?":"Licitación pública, invitación a tres personas, adjudicación directa, diálogo competitivo, adjudicación con estrategia de negociación, contratos derivados de acuerdo marco y órdenes de suministro.",
        "¿En qué artículo se menciona la participación de testigos sociales?":"Artículo 38",
        "¿Qué reglas rigen la presentación de proposiciones por los licitantes?":"En formato digital, por medio de la Plataforma, firma electrónica. No pueden modificarse ni retirarse una vez entregadas.",
        "¿Qué función tiene la Secretaría respecto a los medios de identificación electrónica?":"Opera y certifica los medios de firma electrónica, asegurando su validez legal y su equivalencia con la firma autógrafa."
    };

    const respuestas = document.querySelectorAll('.draggable');
    const preguntas = document.querySelectorAll('#preguntas > div');
    const contenedorRespuestas = document.getElementById('respuestas');

    // DRAG START – Preparar para arrastrar
    respuestas.forEach(resp => {
        resp.addEventListener('dragstart', e => {
            e.dataTransfer.setData('text/plain', e.target.textContent.trim());

            // Imagen de arrastre real
            const img = e.target.cloneNode(true);
            img.style.position = 'absolute';
            img.style.top = '-1000px';
            document.body.appendChild(img);
            e.dataTransfer.setDragImage(img, 0, 0);
            setTimeout(() => document.body.removeChild(img), 0);
        });
    });

    // DROP SOBRE PREGUNTA
    preguntas.forEach(preg => {
        preg.addEventListener('dragover', e => e.preventDefault());

        preg.addEventListener('drop', e => {
            e.preventDefault();

            // Prevenir doble asignación
            if (preg.querySelector('.respuesta-asignada')) return;

            const textoRespuesta = e.dataTransfer.getData('text/plain');
            const respuestaOriginal = Array.from(document.querySelectorAll('.draggable')).find(div => div.textContent.trim() === textoRespuesta);

            if (!respuestaOriginal) return;

            // Marcar la pregunta
            preg.dataset.respuesta = textoRespuesta;
            preg.classList.add('bg-yellow-100', 'border-yellow-400', 'border-2');

            // Desactivar la respuesta original
            respuestaOriginal.classList.add('bg-gray-300', 'text-gray-600', 'line-through', 'opacity-50');
            respuestaOriginal.setAttribute('draggable', false);

            // Crear clon visible con botón X
            const asignada = respuestaOriginal.cloneNode(true);
            asignada.classList.add('respuesta-asignada');
            asignada.classList.remove('cursor-move');
            asignada.classList.remove('opacity-50');
            asignada.classList.remove('line-through');

            // Crear botón ❌
            const botonX = document.createElement('button');
            botonX.textContent = '❌';
            botonX.classList.add(
                'ml-2', 'text-red-600', 'bg-red-100', 'hover:bg-red-200',
                'rounded', 'px-2', 'py-1', 'text-sm', 'cursor-pointer', 'transition'
            );

            botonX.onclick = function () {
                // Liberar pregunta
                preg.innerHTML = preg.dataset.textoOriginal;
                delete preg.dataset.respuesta;
                preg.classList.remove('bg-yellow-100', 'border-yellow-400', 'border-2');

                // Reactivar la respuesta original
                respuestaOriginal.classList.remove('bg-gray-300', 'text-gray-600', 'line-through', 'opacity-50');
                respuestaOriginal.setAttribute('draggable', true);
                
                // Recalcular el tamaño después de quitar respuesta
                setTimeout(resizeAllMasonryItems, 10);
            };

            // Mostrar en la pregunta
            preg.innerHTML = '';
            preg.appendChild(document.createTextNode(preg.dataset.textoOriginal + ' ➜ '));
            preg.appendChild(asignada);
            asignada.appendChild(botonX);
            
            // Recalcular el tamaño después de asignar respuesta
            setTimeout(resizeAllMasonryItems, 10);
        });
    });

    // PERMITIR DEVOLVER AL ÁREA DE RESPUESTAS
    contenedorRespuestas.addEventListener('dragover', e => e.preventDefault());

    contenedorRespuestas.addEventListener('drop', e => {
        e.preventDefault();
        const textoRespuesta = e.dataTransfer.getData('text/plain');

        const pregunta = Array.from(preguntas).find(p => p.dataset.respuesta === textoRespuesta);
        if (!pregunta) return;

        const respuestaOriginal = Array.from(document.querySelectorAll('.draggable')).find(div => div.textContent.trim() === textoRespuesta);
        if (!respuestaOriginal) return;

        // Restaurar pregunta
        pregunta.innerHTML = pregunta.dataset.textoOriginal;
        delete pregunta.dataset.respuesta;
        pregunta.classList.remove('bg-yellow-100', 'border-yellow-400', 'border-2');

        // Restaurar respuesta original
        respuestaOriginal.classList.remove('bg-gray-300', 'text-gray-600', 'line-through', 'opacity-50');
        respuestaOriginal.setAttribute('draggable', true);

        contenedorRespuestas.appendChild(respuestaOriginal);
        
        // Recalcular el tamaño después de devolver respuesta
        setTimeout(resizeAllMasonryItems, 10);
    });

    // FINALIZAR JUEGO
    function finalizarJuego() {
        let correctas = 0;

        preguntas.forEach(preg => {
            const pregunta = preg.dataset.textoOriginal;
            const respuesta = preg.dataset.respuesta;
            if (respuesta && relacionesCorrectas[pregunta] === respuesta) {
                correctas++;
            }
        });

        document.getElementById('resultado').value = correctas;
        document.getElementById('formularioEnvio').submit();
    }
</script>

</body>

</html>