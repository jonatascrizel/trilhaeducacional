<main class="col-md-9 col-lg-10 ms-sm-auto px-md-4 vh-100 dashboard">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
    </div>

    <!-- Atalhos rápidos -->
    <div class="row pb-2 mb-3" id="atalhos">
        <div class="col">
            <a href="<?= base_url('/dashboard/geraStats') ?>" onclick="setTimeout(function() { location.reload();}, 3000);" class="btn btn-personal btn-sm" title="Atualiza estatísticas" target="_blank">
                <i class="fas fa-sync"></i> Atualizar</a>
        </div>

    </div>
    <!-- Atalhos rápidos -->

    <div class="row">
        <h2>Engajamento</h2>
        <div class="col-12 col-md-6 col-lg-4 chart">
            <canvas id="DAUMAU"></canvas>
        </div>
        <div class="col-12 col-md-6 col-lg-4 chart">
            <canvas id="taxa_retencao"></canvas>
        </div>
        <div class="col-12 col-md-6 col-lg-4 chart">
            <canvas id="horario_pico"></canvas>
        </div>
    </div>

    <div class="row">
        <h2>Aprendizado</h2>
        <div class="col-12 col-md-6 col-lg-9 chart">
            <canvas id="mais_erradas"></canvas>
        </div>
        <div class="col-12 col-md-6 col-lg-3 chart">
            <canvas id="taxa_conclusao"></canvas>
        </div>
    </div>


</main>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    window.onload = function() {  
        const DAUMAU_chart = new Chart(
            document.getElementById("DAUMAU"),
            {
            type: 'line',
            data: {
                labels: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                datasets: [
                    {
                    label: 'Acessos por dia',
                    data: [<?=$dayofweek[1]?>,<?=$dayofweek[2]?>,<?=$dayofweek[3]?>,<?=$dayofweek[4]?>,<?=$dayofweek[5]?>,<?=$dayofweek[6]?>,<?=$dayofweek[7]?>],
                    borderColor: 'rgb(255, 99, 132)',
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    },
                ],                
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Flutuação diária e mensal de acessos'
                    }
                }
            }
        });

        const taxa_retencao_chart = new Chart(
            document.getElementById("taxa_retencao"),
            {
            type: 'bar',
            data: {
                labels: [''],
                datasets: [
                    {
                    label: 'D+1',
                    data: [<?=$sobrevivencia['acessos_D1']?>],
                    borderColor: 'rgb(255, 99, 132)',
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    },
                    {
                    label: 'D+7',
                    data: [<?=$sobrevivencia['acessos_D5']?>],
                    borderColor: 'rgb(54, 162, 235)',
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    },
                    {
                    label: 'D+30',
                    data: [<?=$sobrevivencia['acessos_D10']?>],
                    borderColor: 'rgb(60, 235, 54)',
                    backgroundColor: 'rgba(45, 148, 13, 0.5)',
                    },
                ],                
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Sobrevivência do usuário no app após o cadastro'
                    }
                }
            }
        });


        const horario_pico_chart = new Chart(
            document.getElementById("horario_pico"),
            {
                type: 'bubble',
                data: {
                    datasets: [
                            <?php
                                // Encontra o volume máximo para o escalonamento
                                $all_volumes = [];
                                foreach($volume_respostas as $k => $v) {
                                    foreach($v as $k2 => $v2) {
                                        $all_volumes[] = $v2;
                                    }
                                }
                                $maxVolume = count($all_volumes) > 0 ? max($all_volumes) : 1; // Evita divisão por zero

                                // Define o tamanho máximo desejado do raio da bolha em pixels
                                $targetMaxRadius = 30; // Ajuste conforme necessário

                                // Define os limites dos intervalos de volume (33% e 66%)
                                $limitLow = $maxVolume * 0.33;
                                $limitMedium = $maxVolume * 0.66;

                                // Inicializa os três novos arrays de dados para o JS
                                $data_baixa = [];
                                $data_media = [];
                                $data_alta = [];

                                // Processa os dados, escalona e distribui nos novos arrays
                                foreach($volume_respostas as $k => $v) {
                                    foreach($v as $k2 => $v2) {
                                        // Aplica a fórmula de escalonamento proporcional
                                        $scaledR = ($v2 / $maxVolume) * $targetMaxRadius;
                                        
                                        // Define o dado para o JS
                                        $dataPoint = "{ x: '{$daysofweek[$k]}', y: {$k2}, r: {$scaledR} },";

                                        // Distribui no dataset correto baseado no volume original ($v2)
                                        if ($v2 < $limitLow) {
                                            $data_baixa[] = $dataPoint;
                                        } elseif ($v2 < $limitMedium) {
                                            $data_media[] = $dataPoint;
                                        } else {
                                            $data_alta[] = $dataPoint;
                                        }
                                    }
                                }

                                // Prepara as strings para o JS
                                $data_baixa_js = implode('', $data_baixa);
                                $data_media_js = implode('', $data_media);
                                $data_alta_js = implode('', $data_alta);
                            ?>
                            // Dataset 1: Baixo Volume (Cinza)
                            {
                                label: 'Baixo Volume',
                                data: [
                                    <?php echo $data_baixa_js; ?>
                                ],
                                borderColor: 'rgb(211, 211, 211)', // LightGray
                                backgroundColor: 'rgba(211, 211, 211, 0.6)',
                            },
                            // Dataset 2: Volume Médio (Amarelo)
                            {
                                label: 'Volume Médio',
                                data: [
                                    <?php echo $data_media_js; ?>
                                ],
                                borderColor: 'rgb(241, 196, 15)', // Flat Yellow
                                backgroundColor: 'rgba(241, 196, 15, 0.6)',
                            },
                            // Dataset 3: Alto Volume (Vermelho)
                            {
                                label: 'Alto Volume',
                                data: [
                                    <?php echo $data_alta_js; ?>
                                ],
                                borderColor: 'rgb(231, 76, 60)', // Flat Red
                                backgroundColor: 'rgba(231, 76, 60, 0.6)',
                            }
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            type: 'category',
                            position: 'bottom',
                            offset: true, 
                            grid: {
                                display: true,
                                drawOnChartArea: true
                            },
                            labels: ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab', 'Dom'],
                        },
                        y: {
                            title: { display: true, text: 'Hora do Dia' },
                            min: 0,
                            max: 25,
                            type: 'linear',
                            ticks: {
                                stepSize: 1,
                                //padding: 15,
                            }
                        }
                    },
                    plugins: {
                        legend: { position: 'top' },
                        title: {
                            display: true,
                            text: 'Lições ao longo do dia'
                        }
                    }
                }
            }
        );

        const taxaConclusaoChart = new Chart(
            document.getElementById('taxa_conclusao').getContext('2d'), 
            {
            type: 'bar',
            data: {
                // As etapas do funil de microlearning
                labels: ['Não iciou', 'Iniciaram as lições', 'Chegaram ao aeio', 'Concluíram a trilha'],
                datasets: [{
                    label: 'Quantidade de Alunos',
                    // Exemplo de dados: 1000 começaram, 850 mantiveram, 700 terminaram
                    data: [<?=$taxa_conclusao['naoiniciou']?>, <?=$taxa_conclusao['iniciou']?>, <?=$taxa_conclusao['metade']?>, <?=$taxa_conclusao['concluido']?>], 
                    backgroundColor: [
                        'rgba(246, 28, 28, 0.6)', // Azul (Início)
                        'rgba(28, 176, 246, 0.6)', // Azul (Início)
                        'rgba(255, 150, 0, 0.6)',  // Laranja (Meio)
                        'rgba(88, 204, 2, 0.6)'    // Verde (Fim - Estilo Duolingo)
                    ],
                    borderColor: [
                        'rgb(255, 1, 1)',
                        'rgb(28, 176, 246)',
                        'rgb(255, 150, 0)',
                        'rgb(88, 204, 2)'
                    ],
                    borderWidth: 1,
                    barPercentage: 0.7, // Deixa as barras um pouco mais finas e elegantes
                }]
            },
            options: {
                indexAxis: 'y', // Transforma em barras horizontais (estilo funil)
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Esconde a legenda pois os nomes já estão no eixo Y
                    },
                    title: {
                        display: true,
                        text: 'Conclusão das Lições (%)',
                        font: { size: 16 }
                    },
                    tooltip: {
                        callbacks: {
                            // Mostra a porcentagem em relação ao total ao passar o mouse
                            label: function(context) {
                                let total = context.dataset.data[0];
                                let valor = context.parsed.x;
                                let percentual = ((valor / total) * 100).toFixed(1);
                                return ` ${valor} alunos (${percentual}%)`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        title: { display: true, text: 'Número de Usuários' },
                        grid: { display: false } // Remove linhas verticais para um visual mais clean
                    },
                    y: {
                        grid: { display: false } // Mantém apenas a linha base
                    }
                }
            }
        });

        const maisErradasChart = new Chart(
            document.getElementById('mais_erradas').getContext('2d'), 
            {
            type: 'bar',
            data: {
                // Aqui entrarão os textos das perguntas (ou resumos delas)
                labels: [
                    <?php
                    $dt = [];
                    foreach($mais_erradas as $k => $v) {
                        $dt[] = $v;
                        echo '"'.$k.'", 
                        ';
                    }
                    ?>
                ],
                datasets: [{
                    label: 'Total de Erros',
                    // Quantidade de vezes que a questão foi respondida incorretamente
                    data: [<?=implode(',',$dt)?>], 
                    backgroundColor: 'rgba(255, 75, 75, 0.7)', // Vermelho Duolingo (Erro)
                    borderColor: 'rgb(255, 75, 75)',
                    borderWidth: 1,
                    borderRadius: 5, // Arredonda as pontas das barras (mais moderno)
                    barThickness: 25 // Largura fixa para manter o padrão visual
                }]
            },
            options: {
                indexAxis: 'y', // Transforma em barras horizontais
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Dispensa legenda, o título já explica
                    },
                    title: {
                        display: true,
                        text: 'Top 5 Questões com Maior Índice de Erro',
                        font: { size: 16, weight: 'bold' },
                        padding: { bottom: 20 }
                    },
                    tooltip: {
                        enabled: true,
                        backgroundColor: 'rgba(0, 0, 0, 0.8)'
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        title: { display: true, text: 'Número de Erros' },
                        grid: { color: '#f0f0f0' }
                    },
                    y: {
                        // Ajuste para perguntas longas não serem cortadas
                        ticks: {
                            font: { size: 12 },
                            autoSkip: false // Força a exibição de todas as perguntas
                        },
                        grid: { display: false }
                    }
                }
            }
        });

        function atualizar(){

        }
    };
</script>
