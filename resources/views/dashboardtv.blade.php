<x-guest-layout title="Dashboard">
    @if (Route::has('login'))
    <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
        @auth
            <a href="{{ url('/trucks') }}" class="text-sm text-gray-700 underline">Menu</a>
        @else
            <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Login</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
            @endif
        @endif
    </div>
@endif
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
         Seguimiento ventanas
        </h2>
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Camion</th>
                            <th class="px-4 py-3">Contenedor</th>
                            <th class="px-4 py-3">Operadore(s)</th>
                            <th class="px-4 py-3">Ruta</th>
                            <th class="px-4 py-3">ETA</th>
                            <th class="px-4 py-3">Estatus</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach ($trucks as $truck)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3">
                                    <div class="flex items-center text-sm">
                                        <div>
                                            <p class="font-semibold">Carrier {{ $truck->relaciones->carrier->nombre }}
                                            </p>
                                            <p class="font-semibold">Tracto: {{ $truck->number_truck }}</p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                            <p class="font-semibold">Placas: {{ $truck->trailer_plates }}</p>
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $truck->number_container }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center text-sm">
                                        <div>
                                            <p class="font-semibold"> {{ $truck->operator_name }}</p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                            <p class="font-semibold"> {{ $truck->back_operator_name }}</p>
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center text-sm">
                                        <div>
                                            <p class="font-semibold"> {{ $truck->relaciones->rutas->nombre }}</p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                            <p class="font-semibold"> {{ $truck->relaciones->cliente->nombre }}</p>
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $truck->ETA }}
                                </td>
                                <td class="px-4 py-3 text-xs">
                                    <span   class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                        {{ $truck->latestbitcora->estatus->nombre }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $trucks->links() }}
        </div>
    </div>


</x-guest-layout>
