<x-app-layout title="Charts">
    <div class="container grid px-6 mx-auto">

        <h4 class= "mb-4 font-semibold text-gray-600 dark:text-gray-300">
            PRODUCCION
        </h4>
        <div class="w-full max-h-180">
            <div class="w-full overflow-x-auto">
                {{-- <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">PLAN</th>
                            <th class="px-4 py-3">ACTUAL</th>
                            <th class="px-4 py-3">DIFERENCA</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">
                                <div class="flex items-center text-sm">
                                    <!-- Avatar with inset shadow -->

                                    <div>
                                        <p class="font-semibold">{{ $plandia }}</p>

                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $turnoact }}
                            </td>
                            <td class="px-4 py-3 text-xs">
                                <span
                                    class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                    {{ $plandia - $turnoact }}
                                </span>
                            </td>
                        </tr>
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">
                                <div class="flex items-center text-sm">
                                    <!-- Avatar with inset shadow -->

                                    <div>
                                        <p class="font-semibold">13000</p>

                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $contadorp->contadorTotal_ProduccionReal }}
                            </td>
                            <td class="px-4 py-3 text-xs">
                                <span
                                    class="px-2 py-1 font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full dark:text-white dark:bg-orange-600">
                                    30000
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table> --}}
                @livewire('refresh-div')

            </div>
        </div>
        <div class="w-full max-h-100">
            <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                Grafica golpes
            </h4>
            <canvas id="bars1" height="50"></canvas>
        </div>
        <div class="w-full max-h-100">
            <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                Grafica golpes
            </h4>
            <canvas id="bars2" height="50"></canvas>
        </div>


    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('bars1').getContext('2d');
            var ctx1 = document.getElementById('bars2').getContext('2d');
            var data = @json($dataall); // Convertir los datos PHP a JSON
            var data1 = @json($dias); // Convertir los datos PHP a JSON


            // Suponiendo que data tiene las propiedades 'label', 'shoes', y 'bags'

            var modelo = data.map(item => item['hora']);
            var produccion = data.map(item => item.total_piezas);
            var bagsData = data.map(item => item.bags);
            var lineData = data.map(item => item.plan);
            var dif = data.map(item => item.dif);
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: modelo,
                    datasets: [{
                            label: 'Golpes',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1,
                            data: produccion,
                            stack: 'combined'
                        },
                        {
                            label: 'Diferencia',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                            data: dif,
                            stack: 'combined'
                        },
                        {
                            label: 'Plan', // Etiqueta para los datos de la línea
                            type: 'line',
                            fill: false,

                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 2,
                            data: lineData,

                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,


                        }
                    }
                }
            });
            var dia = data1.map(item => item.diames);
            var golpes = data1.map(item => item.golpes);
            var golpesplan = data1.map(item => item.plan);
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: dia,
                    datasets: [{
                            label: 'Golpes',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1,
                            data: golpes,
                            stack: 'combined'
                        },
                        {
                            label: 'Plan', // Etiqueta para los datos de la línea
                            type: 'line',
                            fill: false,

                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 2,
                            data: golpesplan,

                        }
                    ]

                },
                options: {

                    scales: {
                        y: {
                            beginAtZero: true,

                        }
                    }

                }
            });
        });
    </script>



</x-app-layout>
