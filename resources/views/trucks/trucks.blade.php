<x-app-layout title="Forms">
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Nueva ventana
        </h2>

        <!-- General elements -->
        <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
            Datos
        </h4>
        <form action="{{ route('truck.create') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <label class="block text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Número de Tractocamion<pan>
                            <input
                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                id='truck' name='truck'
                                placeholder="" />
                </label>
                <label class="block text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Número de contenedor </span>
                    <input
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        id='container' name='container'
                        placeholder="" />
                </label>
                <label class="block text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Placas</span>
                    <input
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        id='placas' name='placas'
                        placeholder="" />
                </label>
                <label class="block text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Nombre del Operador</span>
                    <input
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        id='OP' name='OP'
                        placeholder="" />
                </label>
                <label class="block text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Nombre del 2 Operador</span>
                    <input
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                       id='BOP' name='BOP'
                        placeholder="Opcional" />
                </label>
                <label class="block text-sm">
                    <span class="text-gray-700 dark:text-gray-400">ETA</span>
                    <div class="flex space-x-4 mt-1">
                        <input type="datetime-local"
                            class="w-1/2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                           id='fecha' name='fecha'
                            placeholder="Opcional" />

                    </div>

                </label>
                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">
                        Relacion
                    </span>

                    <select
                        class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray
                        "
                        id='relaciones' name='relaciones'>
                        @foreach ($relaciones as $relacion)
                            <option value={{ $relacion->id }}>{{ $relacion->rutas->nombre }}/
                                {{ $relacion->contactodirecto->nombre }}/ {{ $relacion->cliente->nombre }}/</option>
                        @endforeach
                    </select>

                </label>

                <div class="mt-2">
                    <button
                        class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        Guardar
                    </button>
                </div>

        </form>

    </div>
</x-app-layout>
