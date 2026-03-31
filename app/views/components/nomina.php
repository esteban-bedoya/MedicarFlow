<?php
$mensajeEmergente = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$usuarioEsAdmin = (int) ($_SESSION['rol'] ?? 0) === 1;
$registroEnEdicion = isset($editingNomina) && is_array($editingNomina);

$accionFormulario = $registroEnEdicion
    ? '/medicarflow/public/nomina.php?action=update'
    : '/medicarflow/public/nomina.php?action=store';

$tituloFormulario = $registroEnEdicion ? 'Editar registro de nómina' : 'Registrar nuevo cargo';
$textoBotonGuardar = $registroEnEdicion ? 'Actualizar registro' : 'Guardar registro';
$mensajeEmergenteJson = $mensajeEmergente ? json_encode($mensajeEmergente, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : 'null';
?>

<main class="container py-4">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1 text-dark">Módulo de nómina</h1>
            <p class="text-secondary mb-0">
                Gestiona cargos, sueldos y faltas del personal.
            </p>
        </div>
        <div class="text-lg-end text-secondary small">
            <div>Usuario actual: <?= htmlspecialchars($_SESSION['nombre'] ?? 'Usuario', ENT_QUOTES, 'UTF-8') ?></div>
            <div>Rol actual: <?= $usuarioEsAdmin ? 'Administrador' : 'Operativo' ?></div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-xl-4">
            <div class="card bg-dark text-white border border-neon shadow-sm h-100">
                <div class="card-header border-bottom border-secondary">
                    <h2 class="h5 mb-0">
                        <i class="bi bi-cash-stack text-neon"></i>
                        <?= $tituloFormulario ?>
                    </h2>
                </div>
                <div class="card-body">
                    <form action="<?= $accionFormulario ?>" method="POST" novalidate data-nomina-form>
                        <?php if ($registroEnEdicion): ?>
                            <input type="hidden" name="id_nom" value="<?= (int) $editingNomina['id_nom'] ?>">
                        <?php endif; ?>

                        <div class="mb-3">
                            <label for="cargo" class="form-label">Cargo</label>
                            <input
                                type="text"
                                id="cargo"
                                name="cargo"
                                class="form-control"
                                maxlength="50"
                                value="<?= htmlspecialchars($registroEnEdicion ? $editingNomina['cargo'] : '', ENT_QUOTES, 'UTF-8') ?>"
                                placeholder="Ej: Secretaria"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="sueldo" class="form-label">Sueldo</label>
                            <input
                                type="number"
                                id="sueldo"
                                name="sueldo"
                                class="form-control"
                                min="0"
                                step="0.01"
                                value="<?= htmlspecialchars($registroEnEdicion ? (string) $editingNomina['sueldo'] : '', ENT_QUOTES, 'UTF-8') ?>"
                                placeholder="Ej: 1800000"
                                required
                            >
                        </div>

                        <div class="mb-4">
                            <label for="faltas" class="form-label">Faltas</label>
                            <input
                                type="number"
                                id="faltas"
                                name="faltas"
                                class="form-control"
                                min="0"
                                step="1"
                                value="<?= htmlspecialchars($registroEnEdicion ? (string) $editingNomina['faltas'] : '', ENT_QUOTES, 'UTF-8') ?>"
                                placeholder="Ej: 0"
                                required
                            >
                        </div>

                        <div class="d-flex gap-2 flex-wrap">
                            <button type="submit" class="btn btn-outline-info">
                                <i class="bi bi-floppy"></i>
                                <?= $textoBotonGuardar ?>
                            </button>

                            <?php if ($registroEnEdicion): ?>
                                <a href="/medicarflow/public/nomina.php" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle"></i>
                                    Cancelar edición
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-8">
            <div class="card bg-dark text-white border border-neon shadow-sm">
                <div class="card-header border-bottom border-secondary d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h2 class="h5 mb-0">
                        <i class="bi bi-table text-neon"></i>
                        Registros actuales
                    </h2>
                    <span class="text-white-50 small">
                        Total: <?= count($nominas) ?>
                    </span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cargo</th>
                                    <th>Sueldo</th>
                                    <th>Faltas</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($nominas)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-white-50 py-4">
                                            No hay registros de nómina disponibles.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($nominas as $registroNomina): ?>
                                        <tr>
                                            <td><?= (int) $registroNomina['id_nom'] ?></td>
                                            <td><?= htmlspecialchars($registroNomina['cargo'], ENT_QUOTES, 'UTF-8') ?></td>
                                            <td>$<?= number_format((float) $registroNomina['sueldo'], 2, ',', '.') ?></td>
                                            <td><?= (int) $registroNomina['faltas'] ?></td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                                    <a href="/medicarflow/public/nomina.php?edit=<?= (int) $registroNomina['id_nom'] ?>" class="btn btn-sm btn-outline-warning">
                                                        <i class="bi bi-pencil-square"></i>
                                                        Editar
                                                    </a>

                                                    <?php if ($usuarioEsAdmin): ?>
                                                        <form action="/medicarflow/public/nomina.php?action=delete" method="POST" class="m-0" data-delete-form>
                                                            <input type="hidden" name="id_nom" value="<?= (int) $registroNomina['id_nom'] ?>">
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                <i class="bi bi-trash3"></i>
                                                                Eliminar
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
<script src="assets/libs/bootstrap/bootstrap.bundle.min.js"></script>
<script>
    const mensajeDelSistema = <?= $mensajeEmergenteJson ?>;
    const formularioNomina = document.querySelector('[data-nomina-form]');
    const formulariosDeEliminacion = document.querySelectorAll('[data-delete-form]');

    const estilosBaseAlerta = {
        background: '#0f172a',
        color: '#f8fafc',
        confirmButtonColor: '#39FF14',
        customClass: {
            popup: 'shadow-lg'
        }
    };

    if (mensajeDelSistema) {
        const iconosPorTipo = {
            success: 'success',
            error: 'error',
            warning: 'warning',
            info: 'info'
        };

        Swal.fire({
            ...estilosBaseAlerta,
            icon: iconosPorTipo[mensajeDelSistema.type] || 'info',
            title: mensajeDelSistema.title || 'Información',
            text: mensajeDelSistema.message
        });
    }

    if (formularioNomina) {
        formularioNomina.addEventListener('submit', function (eventoFormulario) {
            const campoCargo = document.getElementById('cargo');
            const campoSueldo = document.getElementById('sueldo');
            const campoFaltas = document.getElementById('faltas');

            if (!campoCargo.value.trim()) {
                eventoFormulario.preventDefault();
                Swal.fire({
                    ...estilosBaseAlerta,
                    icon: 'warning',
                    title: '¡Cuidado!',
                    text: 'Olvidaste escribir el nombre del cargo.'
                });
                campoCargo.focus();
                return;
            }

            if (campoSueldo.value.trim() === '' || campoFaltas.value.trim() === '') {
                eventoFormulario.preventDefault();
                Swal.fire({
                    ...estilosBaseAlerta,
                    icon: 'warning',
                    title: '¡Cuidado!',
                    text: 'Todos los campos son obligatorios.'
                });
                return;
            }

            if (Number.isNaN(Number(campoSueldo.value)) || Number.isNaN(Number(campoFaltas.value))) {
                eventoFormulario.preventDefault();
                Swal.fire({
                    ...estilosBaseAlerta,
                    icon: 'error',
                    title: '¡Solo Números!',
                    text: 'En sueldo y faltas no puedes poner letras.'
                });
                return;
            }
        });
    }

    formulariosDeEliminacion.forEach(function (formularioEliminar) {
        formularioEliminar.addEventListener('submit', function (eventoEliminar) {
            eventoEliminar.preventDefault();

            Swal.fire({
                ...estilosBaseAlerta,
                icon: 'warning',
                title: '¿Estás seguro?',
                    text: 'Si borras esto, desaparecerá para siempre.',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d'
            }).then(function (result) {
                if (result.isConfirmed) {
                    formularioEliminar.submit();
                }
            });
        });
    });
</script>
