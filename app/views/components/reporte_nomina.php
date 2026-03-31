<?php
$usuarioEsAdmin = (int) ($_SESSION['rol'] ?? 0) === 1;
$nombreUsuario = $_SESSION['nombre'] ?? 'Usuario';
$tipoReporteActual = $_GET['tipo'] ?? 'general';

$opcionesReporte = [
    'general' => 'Reporte general',
    'sueldos_altos' => 'Sueldos altos',
    'secretarias' => 'Secretarias',
    'premios' => 'Premios',
    'faltas' => 'Faltas',
];
?>

<main class="container py-4">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1 text-white"><?= htmlspecialchars($configuracionReporte['titulo'], ENT_QUOTES, 'UTF-8') ?></h1>
            <p class="text-white-50 mb-0"><?= htmlspecialchars($configuracionReporte['descripcion'], ENT_QUOTES, 'UTF-8') ?></p>
        </div>
        <div class="text-lg-end text-white-50 small">
            <div>Generado por: <?= htmlspecialchars($nombreUsuario, ENT_QUOTES, 'UTF-8') ?></div>
            <div>Fecha: <?= htmlspecialchars($fechaGeneracion, ENT_QUOTES, 'UTF-8') ?></div>
            <div>Rol: <?= $usuarioEsAdmin ? 'Administrador' : 'Operativo' ?></div>
        </div>
    </div>

    <div class="card bg-dark text-white border border-neon shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-12 col-lg-4">
                    <label for="tipo_reporte" class="form-label">Tipo de reporte</label>
                    <select id="tipo_reporte" class="form-select" onchange="window.location.href=this.value;">
                        <?php foreach ($opcionesReporte as $valorReporte => $textoReporte): ?>
                            <option value="/medicarflow/public/reportes.php?tipo=<?= urlencode($valorReporte) ?>" <?= $tipoReporteActual === $valorReporte ? 'selected' : '' ?>>
                                <?= htmlspecialchars($textoReporte, ENT_QUOTES, 'UTF-8') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-12 col-lg-4">
                    <label for="buscador_tabla" class="form-label">Buscar en la tabla</label>
                    <input type="text" id="buscador_tabla" class="form-control" placeholder="Escribe un cargo, sueldo o numero de faltas">
                </div>

                <div class="col-12 col-lg-4 d-flex gap-2 flex-wrap justify-content-lg-end">
                    <a href="/medicarflow/public/nomina.php" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left-circle"></i>
                        Volver a nomina
                    </a>
                    <button type="button" class="btn btn-outline-info" id="boton_imprimir">
                        <i class="bi bi-printer"></i>
                        Imprimir reporte
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-dark text-white border border-neon shadow-sm" id="zona_reporte">
        <div class="card-header border-bottom border-secondary">
            <h2 class="h5 mb-0">
                <i class="bi bi-file-earmark-text text-neon"></i>
                Tabla del reporte
            </h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0" id="tabla_reporte_nomina">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cargo</th>
                            <th>Sueldo</th>
                            <th>Faltas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($registrosReporte)): ?>
                            <tr>
                                <td colspan="4" class="text-center text-white-50 py-4">
                                    No hay datos para este reporte.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($registrosReporte as $filaReporte): ?>
                                <tr>
                                    <td><?= (int) $filaReporte['id_nom'] ?></td>
                                    <td><?= htmlspecialchars($filaReporte['cargo'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td>$<?= number_format((float) $filaReporte['sueldo'], 2, ',', '.') ?></td>
                                    <td><?= (int) $filaReporte['faltas'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<style>
    @media print {
        nav,
        #tipo_reporte,
        #buscador_tabla,
        #boton_imprimir,
        .btn,
        label {
            display: none !important;
        }

        body,
        .card,
        .table {
            background: #ffffff !important;
            color: #000000 !important;
        }

        .card {
            border: 1px solid #cccccc !important;
            box-shadow: none !important;
        }

        .table th,
        .table td {
            color: #000000 !important;
        }
    }
</style>

<script src="assets/libs/bootstrap/bootstrap.bundle.min.js"></script>
<script>
    const campoBuscadorTabla = document.getElementById('buscador_tabla');
    const tablaReporteNomina = document.getElementById('tabla_reporte_nomina');
    const botonImprimirReporte = document.getElementById('boton_imprimir');

    if (campoBuscadorTabla && tablaReporteNomina) {
        campoBuscadorTabla.addEventListener('keyup', function () {
            const textoBuscado = campoBuscadorTabla.value.toLowerCase();
            const filasTabla = tablaReporteNomina.querySelectorAll('tbody tr');

            filasTabla.forEach(function (filaActual) {
                const textoFila = filaActual.textContent.toLowerCase();
                filaActual.style.display = textoFila.includes(textoBuscado) ? '' : 'none';
            });
        });
    }

    if (botonImprimirReporte) {
        botonImprimirReporte.addEventListener('click', function () {
            window.print();
        });
    }
</script>
