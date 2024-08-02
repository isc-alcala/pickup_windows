<x-app-layout title="Forms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subida de Archivo</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<div class="container px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Plan de Producción
    </h2>

    <!-- Grid con dos columnas -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Primer formulario -->
        <div class="w-full max-w-sm mx-auto bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-xl font-bold mb-4">PLAN POR NUMERO DE PARTE</h2>
        <form id="uploadForm" action="{{ url('import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="fileInput1">Subir archivo</label>
                <input type="file" id="fileInput1" name="file" class="pl-3 pr-4 py-2 border rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <button type="submit" class="w-full bg-purple-600 text-white py-2 rounded hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Importar</button>
        </form>
    </div>
        <!-- Segundo formulario -->
        <div class="w-full max-w-sm mx-auto bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-xl font-bold mb-4">PLAN MENSUAL</h2>
            <form id="uploadForm2" action="{{ url('import2') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="fileInput2">Subir archivo</label>
                    <input type="file" id="fileInput2" name="file2" class="pl-3 pr-4 py-2 border rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <button type="submit" class="w-full bg-purple-600 text-white py-2 rounded hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Importar</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal de Éxito 1 -->
<div id="successModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm mx-auto">
        <h2 class="text-lg font-bold mb-4">Éxito</h2>
        <p id="successMessage" class="mb-4">Los datos se han importado correctamente.</p>
        <button id="closeModal" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 focus:outline-none 
        focus:ring-2 focus:ring-blue-500">Cerrar</button>
    </div>
</div>

<!-- Modal de Éxito 2 -->
<div id="successModal2" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm mx-auto">
        <h2 class="text-lg font-bold mb-4">Éxito</h2>
        <p id="successMessage2" class="mb-4">Los datos se han importado correctamente.</p>
        <button id="closeModal2" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 focus:outline-none 
        focus:ring-2 focus:ring-blue-500">Cerrar</button>
    </div>
</div>

<!-- Scripts -->
<script>
document.getElementById('uploadForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Evitar el envío del formulario por defecto

    const formData = new FormData(this);
    
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Mostrar el modal de éxito
            document.getElementById('successModal').classList.remove('hidden');
            document.getElementById('successMessage').textContent = data.message || 'Los datos se han importado correctamente.';
        } else {
            // Manejar errores si es necesario
            alert('Error al importar datos: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al importar datos.');
    });
});

// Cerrar el modal
document.getElementById('closeModal').addEventListener('click', function() {
    document.getElementById('successModal').classList.add('hidden');
});
</script>


<!-- Scripts 2-->
<script>
document.getElementById('uploadForm2').addEventListener('submit', function(event) {
    event.preventDefault(); // Evitar el envío del formulario por defecto

    const formData = new FormData(this);
    
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Mostrar el modal de éxito
            document.getElementById('successModal2').classList.remove('hidden');
            document.getElementById('successMessage2').textContent = data.message || 'Los datos se han importado correctamente.';
        } else {
            // Manejar errores si es necesario
            alert('Error al importar datos: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al importar datos.');
    });
});

// Cerrar el modal
document.getElementById('closeModal2').addEventListener('click', function() {
    document.getElementById('successModal2').classList.add('hidden');
});
</script>

        
</div>
</x-app-layout>

