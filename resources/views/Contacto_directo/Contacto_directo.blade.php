<x-app-layout title="Forms">
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Contacto Directo
        </h2>

        <!-- General elements -->
        <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
            Datos
        </h4>
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <form action="{{ route('contactodirecto.nuevo') }}" method="post" enctype="multipart/form-data">
                @csrf
                <label class="block text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Name</span>
                    <input
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        id="nombre" name='nombre' placeholder="" required/>

                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Descripción</span>
                        <input
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                            id="descripcion" name='descripcion' placeholder="" required/>

                    </label>
                    <div class="mt-2">
                        <button
                            class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                            Guardar
                        </button>
                    </div>
            </form>
        </div>

    </div>

    <div class="container grid px-6 mx-auto">
        <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
            Table with actions
        </h4>
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Nombre</th>
                            <th class="px-4 py-3">Descripcion</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">

                        @foreach ($Objs as $cliente)
                            <tr class="text-gray-700 dark:text-gray-400">

                                <td class="px-4 py-3 text-sm">
                                    {{ $cliente->nombre }}
                                </td>
                                <td class="px-4 py-3 text-xs">
                                    <span
                                        class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                        {{ $cliente->descripcion }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-4 text-sm">

                                        <form action="{{ route('contactodirecto.destroy', $cliente->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                                aria-label="Delete" type="submit">
                                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
            {{ $Objs->links() }}
        </div>
        {{--
        <!-- General elements -->
        <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
            Nuevo contacto
        </h4>
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Name</span>
                <input
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="" />
            </label>
            <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Telefono</span>
                <input type='phone'
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="" />
            </label>
            <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Correo</span>
                <input type='mail'
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="" />
            </label>



        </div>
        <div>
            <button
                class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                Regular
            </button>
        </div> --}}
    </div>
</x-app-layout>
