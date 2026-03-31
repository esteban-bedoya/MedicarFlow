<?php
$activePage = 'dashboard';
$datosGraficas = $resumenGraficoJson ?? '{}';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Administrador</title>
    <link rel="stylesheet" href="assets/css/administrador/dashboard.css">
</head>
<body>
    <?php include __DIR__ . '/../components/header_administrador.php'; ?>

    <main class="container py-4">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
            <div>
                <h1 class="h3 mb-1 text-dark">Dashboard de nómina</h1>
                <p class="text-soft-dark mb-0">
                    Vista general del módulo para revisar el estado de cargos, sueldos, faltas y personal premiado.
                </p>
            </div>
            <div class="text-soft-dark small text-lg-end">
                <div>Usuario actual: <?= htmlspecialchars($_SESSION['nombre'] ?? 'Usuario', ENT_QUOTES, 'UTF-8') ?></div>
                <div>Rol actual: Administrador</div>
            </div>
        </div>

        <div class="card bg-dark text-white border border-neon shadow-sm mb-4">
            <div class="card-body">
                <h2 class="h5 text-neon">Lectura rápida del dashboard</h2>
                <p class="mb-0 text-white-50">
                    Este panel permite identificar cuántos registros de nómina existen, cuántos cargos distintos están activos, qué cargos pueden considerarse premiados por no tener faltas y revisar qué tan frecuentes son estas.<br>
                    Las gráficas ayudan a comparar sueldos, faltas y premios por cargo para tomar decisiones rápidas desde el rol administrador.
                </p>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-12 col-md-6 col-xl-3">
                <div class="card bg-dark text-white border border-neon shadow-sm card-stats h-100">
                    <div class="card-body">
                        <span class="text-white-50 small d-block mb-2">Total registros</span>
                        <h2 class="display-6 mb-0 text-neon"><?= (int) ($resumenDashboard['total_registros'] ?? 0) ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <div class="card bg-dark text-white border border-neon shadow-sm card-stats h-100">
                    <div class="card-body">
                        <span class="text-white-50 small d-block mb-2">Cargos diferentes</span>
                        <h2 class="display-6 mb-0 text-neon"><?= (int) ($resumenDashboard['total_cargos'] ?? 0) ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <div class="card bg-dark text-white border border-neon shadow-sm card-stats h-100">
                    <div class="card-body">
                        <span class="text-white-50 small d-block mb-2">Con faltas</span>
                        <h2 class="display-6 mb-0 text-neon"><?= (int) ($resumenDashboard['total_con_faltas'] ?? 0) ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <div class="card bg-dark text-white border border-neon shadow-sm card-stats h-100">
                    <div class="card-body">
                        <span class="text-white-50 small d-block mb-2">Premiados</span>
                        <h2 class="display-6 mb-0 text-neon"><?= (int) ($resumenDashboard['total_premiados'] ?? 0) ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12 col-xl-6">
                <div class="card bg-dark text-white border border-neon shadow-sm h-100">
                    <div class="card-body">
                        <h2 class="h5 mb-3 text-neon">Gráfica de barras: sueldo promedio por cargo</h2>
                        <canvas id="grafica_barras"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-6">
                <div class="card bg-dark text-white border border-neon shadow-sm h-100">
                    <div class="card-body">
                        <h2 class="h5 mb-3 text-neon">Gráfica de área: faltas acumuladas por cargo</h2>
                        <canvas id="grafica_area"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card bg-dark text-white border border-neon shadow-sm h-100">
                    <div class="card-body">
                        <h2 class="h5 mb-3 text-neon">Gráfica radar: comparación entre faltas y premios</h2>
                        <div style="max-width: 520px; margin: 0 auto;">
                            <canvas id="grafica_radar"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="assets/libs/chartjs/chart.umd.min.js"></script>
    <script src="assets/libs/bootstrap/bootstrap.bundle.min.js"></script>
    <script>
        const datosDashboard = <?= $datosGraficas ?>;
        const colorNeon = '#39FF14';
        const colorAzul = '#38bdf8';
        const colorRojo = '#f87171';
        const colorFondo = 'rgba(57, 255, 20, 0.15)';

        const configuracionComun = {
            responsive: true,
            plugins: {
                legend: {
                    labels: {
                        color: '#f8fafc'
                    }
                }
            },
            scales: {
                x: {
                    ticks: { color: '#f8fafc' },
                    grid: { color: 'rgba(255,255,255,0.08)' }
                },
                y: {
                    ticks: { color: '#f8fafc' },
                    grid: { color: 'rgba(255,255,255,0.08)' }
                }
            }
        };

        const configuracionEnteros = {
            responsive: true,
            plugins: {
                legend: {
                    labels: {
                        color: '#f8fafc'
                    }
                }
            },
            scales: {
                x: {
                    ticks: { color: '#f8fafc' },
                    grid: { color: 'rgba(255,255,255,0.08)' }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#f8fafc',
                        stepSize: 1,
                        precision: 0
                    },
                    grid: { color: 'rgba(255,255,255,0.08)' }
                }
            }
        };

        new Chart(document.getElementById('grafica_barras'), {
            type: 'bar',
            data: {
                labels: datosDashboard.etiquetas || [],
                datasets: [{
                    label: 'Sueldo promedio',
                    data: datosDashboard.sueldos || [],
                    backgroundColor: colorNeon,
                    borderColor: colorNeon,
                    borderWidth: 1
                }]
            },
            options: configuracionEnteros
        });

        new Chart(document.getElementById('grafica_area'), {
            type: 'line',
            data: {
                labels: datosDashboard.etiquetas || [],
                datasets: [{
                    label: 'Total faltas',
                    data: datosDashboard.faltas || [],
                    backgroundColor: colorFondo,
                    borderColor: colorAzul,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: configuracionComun
        });

        new Chart(document.getElementById('grafica_radar'), {
            type: 'radar',
            data: {
                labels: datosDashboard.etiquetas || [],
                datasets: [
                    {
                        label: 'Premiados',
                        data: datosDashboard.premios || [],
                        backgroundColor: 'rgba(57, 255, 20, 0.2)',
                        borderColor: colorNeon,
                        pointBackgroundColor: colorNeon
                    },
                    {
                        label: 'Faltas',
                        data: datosDashboard.faltas || [],
                        backgroundColor: 'rgba(248, 113, 113, 0.15)',
                        borderColor: colorRojo,
                        pointBackgroundColor: colorRojo
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                aspectRatio: 1.5,
                plugins: {
                    legend: {
                        labels: {
                            color: '#f8fafc'
                        }
                    }
                },
                scales: {
                    r: {
                        angleLines: { color: 'rgba(255,255,255,0.08)' },
                        grid: { color: 'rgba(255,255,255,0.08)' },
                        pointLabels: { color: '#f8fafc' },
                        ticks: {
                            color: '#f8fafc',
                            backdropColor: 'transparent',
                            stepSize: 1,
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
