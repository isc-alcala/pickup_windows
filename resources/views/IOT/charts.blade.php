<x-app-layout title="Charts">
    <div class="container grid px-6 mx-auto">
        <div class="grid gap-6 mb-8 center">
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
                    PRODUCCION
                </h4>
                <div class="w-full overflow-hidden rounded-lg shadow-xs">
                    <div class="w-full overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
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
                                                <p class="font-semibold text-9xl">15000</p>

                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-7xl">
                                        {{ $turnoact }}
                                    </td>
                                    <td class="px-4 py-3 text-xs text-7xl">
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                            5000
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
                                        {{ $turnoant }}
                                    </td>
                                    <td class="px-4 py-3 text-xs">
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full dark:text-white dark:bg-orange-600">
                                            30000
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid gap-6 mb-8 md:grid-cols-1">
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                    Grafica golpes
                </h4>
                <canvas id="bars1"></canvas>
                <div class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400">
                    <!-- Chart legend -->
                    <div class="flex items-center">
                        <span class="inline-block w-3 h-3 mr-1 bg-teal-500 rounded-full"></span>
                        <span>Diferencia</span>
                    </div>
                    <div class="flex items-center">
                        <span class="inline-block w-3 h-3 mr-1 bg-purple-600 rounded-full"></span>
                        <span>Golpes</span>
                    </div>
                </div>
            </div>
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                    Grafica golpes
                </h4>
                <canvas id="bars2"></canvas>

            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('bars1').getContext('2d');
            var ctx1 = document.getElementById('bars2').getContext('2d');
            var data = @json($dataall); // Convertir los datos PHP a JSON
            var data1= @json($dias); // Convertir los datos PHP a JSON

            // Suponiendo que data tiene las propiedades 'label', 'shoes', y 'bags'

            var modelo = data.map(item => item['hora']);
            var produccion = data.map(item => item.total_piezas);
            var bagsData = data.map(item => item.bags);
            var lineData = data.map(item => item.plan);
            var lineData1 = data.map(item => item.plan1);
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
                            beginAtZero: true
                        }
                    }
                }
            });

            var modelo1 = data.map(item => item.dia);
            var dias = data1.map(item => item.dia);
            var produccion1 = data1.map(item => item.golpes);
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: modelo1,
                    datasets: [{
                            label: 'Golpes',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1,
                            data: produccion1,
                            stack: 'combined'
                        },
                        {
                            label: 'Plan', // Etiqueta para los datos de la línea
                            type: 'line',
                            fill: false,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 2,
                            data: dias,
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
