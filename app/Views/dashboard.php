<main class="col-md-9 col-lg-10 ms-sm-auto px-md-4 vh-100 dashboard">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
    </div>

    <!-- Atalhos rápidos -->
    <div class="row pb-2 mb-3" id="atalhos">
<!--        
        <div class="col">
            <a href="<?= base_url('/clientes/add/1') ?>" class="btn btn-personal btn-sm" title="Adiciona um novo cliente">
                <i class="fas fa-user-friends"></i> Adicionar cliente</a>
        </div>
-->
    </div>
    <!-- Atalhos rápidos -->

    <div class="row">
        <h2>Engajamento</h2>
        <div class="col-12 col-md-6 col-lg-3 chart">
            <canvas id="DAUMAU"></canvas>
        </div>
        <div class="col-12 col-md-6 col-lg-3 chart">
            <canvas id="taxa_retencao"></canvas>
        </div>
        <div class="col-12 col-md-6 col-lg-3 chart">
            <canvas id="distribuicao_steaks"></canvas>
        </div>
        <div class="col-12 col-md-6 col-lg-3 chart">
            <canvas id="horario_pico"></canvas>
        </div>
    </div>

    <div class="row">
        <h2>Aprendizado</h2>
        <div class="col-12 col-md-6 col-lg-3 chart">
            <canvas id="taxa_conclusao"></canvas>
        </div>
        <div class="col-12 col-md-6 col-lg-3 chart">
            <canvas id="mais_erradas"></canvas>
        </div>
        <div class="col-12 col-md-6 col-lg-3 chart">
            <canvas id="tmp_licao"></canvas>
        </div>
        <div class="col-12 col-md-6 col-lg-3 chart">
            <canvas id="progresso_trilha"></canvas>
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
                labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul'],
                datasets: [
                    {
                    label: 'Daily Active Users',
                    data: [12,8,25,3,6,4,2],
                    borderColor: 'rgb(255, 99, 132)',
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    },
                    {
                    label: 'Monthly Active Users',
                    data: [5,8,12,3,2,1,4],
                    borderColor: 'rgb(54, 162, 235)',
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
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
                    data: [50],
                    borderColor: 'rgb(255, 99, 132)',
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    },
                    {
                    label: 'D+7',
                    data: [38],
                    borderColor: 'rgb(54, 162, 235)',
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    },
                    {
                    label: 'D+30',
                    data: [26],
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

        const distribuicao_steaks_chart = new Chart(
            document.getElementById("distribuicao_steaks"),
            {
            type: 'bar',
            data: {
                labels: [''],
                datasets: [
                    {
                    label: '1-3 dias',
                    data: [22],
                    borderColor: 'rgb(255, 99, 132)',
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    },
                    {
                    label: '4-7 dias',
                    data: [12],
                    borderColor: 'rgb(54, 162, 235)',
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    },
                    {
                    label: '14+ dias',
                    data: [6],
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
                        text: 'Quantidade de usuários em ofensiva'
                    }
                }
            }
        });

        const horario_pico_chart = new Chart(
            document.getElementById("horario_pico"),
            {
                type: 'bubble',
                data: {
                    datasets: [{
                        label: 'Volume de Lições',
                        data: [
                            // x = Dia (0=Seg, 1=Ter...), y = Hora, r = Tamanho da bolha
                            { x: 'Seg', y: 10, r: 6 },
                            { x: 'Seg', y: 11, r: 8 },
                            { x: 'Seg', y: 12, r: 1 },
                            { x: 'Seg', y: 14, r: 12 },
                            { x: 'Seg', y: 18, r: 8 },

                            { x: 'Dom', y: 20, r: 10 }
                        ],
                        borderColor: 'rgb(255, 99, 132)',
                        backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    }],
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
                                padding: 15,
                            }
                        }
                    },
                    plugins: {
                        legend: { position: 'top' },
                        title: {
                            display: true,
                            text: 'Janelas de tempo com maior volume de lições iniciadas'
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
                labels: ['Iniciaram a Lição', 'Chegaram ao Meio', 'Concluíram (Sucesso)'],
                datasets: [{
                    label: 'Quantidade de Alunos',
                    // Exemplo de dados: 1000 começaram, 850 mantiveram, 700 terminaram
                    data: [1000, 850, 700], 
                    backgroundColor: [
                        'rgba(28, 176, 246, 0.6)', // Azul (Início)
                        'rgba(255, 150, 0, 0.6)',  // Laranja (Meio)
                        'rgba(88, 204, 2, 0.6)'    // Verde (Fim - Estilo Duolingo)
                    ],
                    borderColor: [
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
                    'O que é um Resistor?', 
                    'Lei de Ohm: Cálculo de Tensão', 
                    'Símbolo do Capacitor', 
                    'Cálculo de Corrente em Série', 
                    'Identificação de Diodos'
                ],
                datasets: [{
                    label: 'Total de Erros',
                    // Quantidade de vezes que a questão foi respondida incorretamente
                    data: [145, 112, 89, 74, 45], 
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

        const tempoLicaoChart = new Chart(
            document.getElementById('tmp_licao').getContext('2d'), 
            {
            type: 'scatter',
            data: {
                datasets: [{
                    label: 'Tempo de Conclusão (min)',
                    // x = ID ou Ordem da Lição, y = Tempo em minutos
                    data: [
                        { x: 1, y: 3.5 },
                        { x: 2, y: 4.2 },
                        { x: 3, y: 8.0 }, // Lição lenta/difícil
                        { x: 4, y: 5.1 },
                        { x: 5, y: 3.8 },
                        { x: 6, y: 12.5 }, // Alerta: muito fora do microlearning
                        { x: 7, y: 4.5 }
                    ],
                    backgroundColor: 'rgba(28, 176, 246, 0.6)', // Azul
                    borderColor: 'rgb(28, 176, 246)',
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Tempo Médio de Conclusão por Lição',
                        font: { size: 16 }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `Lição ${context.raw.x}: ${context.raw.y} min`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        type: 'linear',
                        position: 'bottom',
                        title: { display: true, text: 'Ordem das Lições na Trilha' },
                        ticks: { stepSize: 1 }
                    },
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'Minutos' },
                        // Linha de alerta: destaca se passar de 10 min
                        grid: {
                            color: function(context) {
                                if (context.tick.value >= 10) return 'rgba(255, 0, 0, 0.2)';
                                return 'rgba(0, 0, 0, 0.1)';
                            }
                        }
                    }
                }
            }
        });

        const progressoTrilhaChart = new Chart(
            document.getElementById('progresso_trilha').getContext('2d'), 
            {
            type: 'doughnut',
            data: {
                labels: ['Concluído', 'Em Andamento', 'Não Iniciado'],
                datasets: [{
                    label: 'Status dos Alunos',
                    data: [300, 450, 250], // Exemplo de distribuição
                    backgroundColor: [
                        'rgba(88, 204, 2, 0.7)',   // Verde (Sucesso)
                        'rgba(28, 176, 246, 0.7)',  // Azul (Em curso)
                        'rgba(229, 229, 229, 0.7)'  // Cinza (Não iniciado)
                    ],
                    hoverOffset: 15, // Efeito de destaque ao passar o mouse
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%', // Aumenta o "furo" da rosca para um visual mais elegante
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true, // Bolinhas em vez de quadrados na legenda
                            padding: 20
                        }
                    },
                    title: {
                        display: true,
                        text: 'Progresso Geral na Trilha',
                        font: { size: 16 }
                    }
                }
            }
        });


    };
</script>
