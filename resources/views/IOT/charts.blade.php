<x-app-layout title="Charts">
    <div class="container grid px-6 mx-auto">

        <div class="w-full max-h-180">
            <div class="w-full overflow-x-auto">
                @livewire('refresh-div')

            </div>
        </div>
        <div class="w-full max-h-100 pt-6">
            <p class="mb-4 font-semibold text-gray-800 dark:text-gray-300 text-2xl">
                Grafica Golpes Turno
            </p>
            <canvas id="bars1" height="50"></canvas>
        </div>
        <div class="w-full max-h-100 pt-6">
            <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300 text-2xl">
                Grafica Golpes Historico
            </h4>
            <canvas id="bars2" height="50"></canvas>
        </div>


    </div>
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx1 = document.getElementById('bars2').getContext('2d');
            var data1 = @json($dias); // Convertir los datos PHP a JSON
            var dia = data1.map(item => item.diames);
            var golpes = data1.map(item => item.golpes);
            var golpesno = data1.map(item => item.golpesno);
            var golpesplan = data1.map(item => item.plan);
            var golpesplan1 = data1.map(item => item.plan1);

            // Registro del plugin ChartDataLabels
             Chart.register(ChartDataLabels);

            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: dia,
                    datasets: [{
                            label: 'Golpes',
                            backgroundColor: 'rgba(0, 128, 0, 0.5)', // Verde fuerte con opacidad
                            borderColor: 'rgba(0, 128, 0, 1)', // Verde fuerte sin opacidad
                            borderWidth: 1,
                            data: golpes,
                            stack: 'combined'
                        },
                        {
                            label: 'No plan',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                            data: golpesno,
                            stack: 'combined'
                        },
                        {
                            label: 'Requerimiento Int', // Etiqueta para los datos de la línea
                            type: 'line',
                            fill: false,
                            borderColor: 'rgba(0, 0, 128, 1)', // color azul
                            borderWidth: 2,
                            data: golpesplan,
                            tension: 0
                        },
                        {
                            label: 'Requerimiento Obj', // Etiqueta para los datos de la línea
                            type: 'line',
                            fill: false,
                            borderColor: 'rgba(255, 165, 0, 1)', // color naranja
                            borderWidth: 2,
                            data: golpesplan1,
                            tension: 0
                        }
                    ]
                },
                options: {
                    plugins: {
                        datalabels: {
                            color: 'black', // Color del texto de las etiquetas
                            anchor: 'end',
                            align: 'top',
                            formatter: (value, context) => {
                                return value;
                            },
                            font: {
                                weight: 'bold',
                                size: 12 // Tamaño del texto de las etiquetas
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('bars1').getContext('2d');
            var data = @json($dataall); // Convertir los datos PHP a JSON
            var ctx1 = document.getElementById('bars2').getContext('2d');
            var data1 = @json($dias); // Convertir los datos PHP a JSON

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
                            backgroundColor: 'rgba(0, 128, 0, 0.5)', // Verde fuerte con opacidad
                            borderColor: 'rgba(0, 128, 0, 1)', // Verde fuerte sin opacidad
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
                            label: 'Requerimiento Int', // Etiqueta para los datos de la línea
                            type: 'line',
                            fill: false,

                            borderColor: 'rgba(0, 0, 128, 1)',
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
                },
            });


            var dia = data1.map(item => item.diames);
            var golpes = data1.map(item => item.golpes);
            var golpesno = data1.map(item => item.golpesno);
            var golpesplan = data1.map(item => item.plan);
            var golpesplan1 = data1.map(item => item.plan1);


            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: dia,
                    datasets: [{
                            label: 'Golpes',
                            backgroundColor: 'rgba(0, 128, 0, 0.5)', // Verde fuerte con opacidad
                            borderColor: 'rgba(0, 128, 0, 1)', // Verde fuerte sin opacidad
                            borderWidth: 1,
                            data: golpes,

                        },
                        {
                            label: 'No plan',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                            data: golpesno,

                        },
                        {
                            label: 'Requerimiento Int', // Etiqueta para los datos de la línea
                            type: 'line',
                            fill: false,
                            borderColor: 'rgba(0, 0, 128, 1)', // color azul
                            borderWidth: 2,
                            data: golpesplan,
                            tension: 0
                        },
                        {
                            label: 'Requerimiento Obj', // Etiqueta para los datos de la línea
                            type: 'line',
                            fill: false,
                            borderColor: 'rgba(255, 165, 0, 1)', // color naranja
                            borderWidth: 2,
                            data: golpesplan1,
                            tension: 0
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

    {{-- <script>
        const ctx = document.getElementById('bars1').getContext('2d');
        const graficoturno = new Chart(ctx, {
            type: 'bar', // Tipo de gráfico principal
            data: {
                labels: [], // Etiquetas iniciales
                datasets: [
                    {
                        label: 'Golpes',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        data: [], // Datos de producción
                        stack: 'combined'
                    },
                    {
                        label: 'Diferencia',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                        data: [], // Datos de diferencia
                        stack: 'combined'
                    },
                    {
                        label: 'Plan',
                        type: 'line', // Tipo de gráfico secundario
                        fill: false,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        data: [], // Datos del plan
                    }
                ]
            },
            options: {
                scales: {
                    x: {
                        stacked: true, // Apilar los gráficos de barras
                    },
                    y: {
                        beginAtZero: true,
                        stacked: true, // Apilar los gráficos de barras
                    }
                }
            }
        });

        function updateChart() {
            fetch('/api/get-data')
                .then(response => response.json())
                .then(data => {
                    const modelo = data.labels;
                    const produccion = data.produccion;
                    const lineData = data.lineData;
                    const dif = data.dif;

                    graficoturno.data.labels = modelo;
                    graficoturno.data.datasets[0].data = produccion; // Datos de 'Golpes'
                    graficoturno.data.datasets[1].data = dif; // Datos de 'Diferencia'
                    graficoturno.data.datasets[2].data = lineData; // Datos de 'Plan'
                    graficoturno.update();
                })
                .catch(error => console.error('Error al obtener datos:', error));
        }

        // Actualiza la gráfica cada minuto
        setInterval(updateChart, 60000);

        // Actualiza la gráfica al cargar la página
        updateChart();
    </script> --}}
    </body>

</x-app-layout>
