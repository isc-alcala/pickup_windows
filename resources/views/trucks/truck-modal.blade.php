<x-app-layout title="Dashboard">



    <div class="mt-4 mb-6 mx-auto max-w-lg p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <p class="mb-4 text-lg font-semibold text-gray-700 dark:text-gray-300 text-center">
            Actualización de estatus
        </p>
        <p class="text-gray-700 dark:text-gray-300 text-center">
            El viaje pasara del esatus
        </p>
        <div class='text-center'>
            <p>

                <span
                    class=" px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                    {{ $truck->latestbitcora->estatus->nombre }}
                </span>
                a
                <span
                    class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                    {{ $estatus->nombre }}
                </span>
            </p>
        </div>

        <div class="p-4 mb-4 bg-gray-100 rounded-lg shadow-md dark:bg-gray-900">
            <div class="flex justify-between">
                <p class="font-semibold text-gray-700 dark:text-gray-300">Tracto:</p>
                <p class="text-gray-700 dark:text-gray-300">{{ $truck->number_truck }}</p>
            </div>
        </div>

        <div class="p-4 mb-4 bg-gray-100 rounded-lg shadow-md dark:bg-gray-900">
            <div class="flex justify-between">
                <p class="font-semibold text-gray-700 dark:text-gray-300">Remolque:</p>
                <p class="text-gray-700 dark:text-gray-300">{{ $truck->number_container }}</p>
            </div>
        </div>

        <div class="p-4 mb-4 bg-gray-100 rounded-lg shadow-md dark:bg-gray-900">
            <div class="flex justify-between">
                <p class="font-semibold text-gray-700 dark:text-gray-300">Operador 1:</p>
                <p class="text-gray-700 dark:text-gray-300">{{ $truck->operator_name }}</p>
            </div>
        </div>

        <div class="p-4 mb-4 bg-gray-100 rounded-lg shadow-md dark:bg-gray-900">
            <div class="flex justify-between">
                <p class="font-semibold text-gray-700 dark:text-gray-300">Operador 2:</p>
                <p class="text-gray-700 dark:text-gray-300">{{ $truck->back_operator_name }}</p>
            </div>
        </div>

        <div class="p-4 mb-4 bg-gray-100 rounded-lg shadow-md dark:bg-gray-900">
            <div class="flex justify-between">
                <p class="font-semibold text-gray-700 dark:text-gray-300">Carrier:</p>
                <p class="text-gray-700 dark:text-gray-300">{{ $truck->relaciones->carrier->nombre }}</p>
            </div>
        </div>

        <div class="p-4 bg-gray-100 rounded-lg shadow-md dark:bg-gray-900">

                <form action="{{ route('truck.status') }}" method="post" enctype="multipart/form-data">
                    @csrf
                <div class="mb-4">
                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Comentario</span>
                        <textarea name='comentario' id='comentario'
                            class="block w-full mt-1 text-sm form-textarea dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"></textarea>
                    </label>
                </div>

                    <input id='id' name='id' type="hidden" value='{{$truck->id}}'>
                    <input id='idstatus' name='idestatus' type="hidden" value='{{$estatus->id}}'>
                <div class="flex justify-end">
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium leading-5 text-white bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        Guardar
                    </button>
                </div>

                </form>

        </div>
    </div>
</x-app-layout>
