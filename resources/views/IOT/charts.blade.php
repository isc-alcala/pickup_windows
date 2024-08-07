<x-app-layout title="Grafica prensa 2500">
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
        {{-- <div class="w-full max-h-100 pt-6">
            <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300 text-2xl">
                Grafica Golpes Historico
            </h4>
            <canvas id="bars3" height="50"></canvas>
        </div> --}}


    </div>


    <script>
        var ctx = document.getElementById('bars1').getContext('2d');
        var datacontroller = @json($dataall); // Convertir los datos PHP a JSON


        var modelo = datacontroller.map(item => item['hora']);
        var produccion = datacontroller.map(item => item.total_piezas);
        var bagsData = datacontroller.map(item => item.bags);
        var lineData = datacontroller.map(item => item.plan);
        var dif = datacontroller.map(item => item.dif);
        var maxValue = Math.max(
            Math.max(...produccion),
            Math.max(...dif)
        );

        var datagarf1 = {
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
        };
        var myChart2 = new Chart(ctx, {
            type: 'bar',
            data: datagarf1,
            options: {
                animation: {
                    onComplete: function() {
                        var chartInstance = this.chart,
                            ctx = chartInstance.ctx;

                        ctx.font = Chart.helpers.fontString(
                            Chart.defaults.global.defaultFontSize,
                            Chart.defaults.global.defaultFontStyle,
                            Chart.defaults.global.defaultFontFamily
                        );
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';
                        ctx.fillStyle = 'black'; // Asegurando que el color del texto sea negro


                        this.data.datasets.forEach(function(dataset, i) {
                            // Verifica si el tipo de dataset es 'bar'
                            if (dataset.label === 'Golpes') { // Solo mostrar valores de la barra verde
                                var meta = chartInstance.controller.getDatasetMeta(i);
                                meta.data.forEach(function(bar, index) {
                                    var data = dataset.data[index];


                                    ctx.fillText(data, bar._model.x, bar._model.y - 10);
                                });
                            }
                        });
                    }
                },

                tooltips: {
                    enabled: false
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        display: false,
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: 'black',
                            display: false
                        }
                    },
                }
            }
        });
    </script>
    <script>
        var ctx1 = document.getElementById('bars2').getContext('2d');
        var data1 = @json($dias); // Convertir los datos PHP a JSON
        var dia = data1.map(item => item.diames);
        var golpes = data1.map(item => item.golpes);
        var label1 = data1.map(item => item.label1);
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
                    },
                    {
                        label: 'cantidad',
                        backgroundColor: 'rgba(255, 99, 71,0 )',
                        data: label1,
                        type: 'line',
                        borderWidth: 0.2,
                        fill: false,
                    }
                ]
            },
            options: {
                animation: {
                    onComplete: function() {
                        var chartInstance = this.chart,
                            ctx = chartInstance.ctx;
                            ctx.font = Chart.helpers.fontString(
                            Chart.defaults.global.defaultFontSize,
                            Chart.defaults.global.defaultFontStyle,
                            Chart.defaults.global.defaultFontFamily
                        );
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';
                        ctx.fillStyle = 'black'; // Asegurando que el color del texto sea negro
                        this.data.datasets.forEach(function(dataset, i) {
                            // Verifica si el tipo de dataset es 'bar'
                            if (dataset.label === 'cantidad') { // Solo mostrar valores de la barra verde
                                var meta = chartInstance.controller.getDatasetMeta(i);
                                meta.data.forEach(function(bar, index) {
                                    var data = dataset.data[index];
                                    ctx.fillText(data, bar._model.x, bar._model.y - 20);
                                });
                            }
                        });
                    }
                },

                tooltips: {
                    enabled: false
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        display: false,
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: 'black',
                            display: false
                        }
                    },
                }
            }

        });
    </script>
 <script>
    // Recargar la página cada 30 minutos (1800000 milisegundos)
    setTimeout(function() {
        location.reload();
    }, 18000000); // 30 minutos en milisegundos
</script>


    </body>

</x-app-layout>
