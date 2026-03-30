<?php
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$isAdmin = (int) ($_SESSION['rol'] ?? 0) === 1;
$isEditing = isset($editingNomina) && is_array($editingNomina);

$formAction = $isEditing
    ? '/medicarflow/public/nomina.php?action=update'
    : '/medicarflow/public/nomina.php?action=store';

$formTitle = $isEditing ? 'Editar registro de nomina' : 'Registrar nuevo cargo';
$submitLabel = $isEditing ? 'Actualizar registro' : 'Guardar registro';
?>

<main class="container py-4">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1 text-white">Modulo de Nomina</h1>
            <p class="text-white-50 mb-0">
                Gestiona cargos, sueldos y faltas del personal. El rol operativo puede crear y actualizar registros.
            </p>
        </div>
        <div class="text-lg-end">
            <span class="badge text-bg-dark border border-neon px-3 py-2">
                <i class="bi bi-lightning-charge-fill text-neon"></i>
                Rol actual: <?= $isAdmin ? 'Administrador' : 'Operativo' ?>
            </span>
        </div>
    </div>

    <?php if ($flash): ?>
        <div class="alert alert-<?= htmlspecialchars($flash['type'], ENT_QUOTES, 'UTF-8') ?> alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($flash['message'], ENT_QUOTES, 'UTF-8') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-12 col-xl-4">
            <div class="card bg-dark text-white border border-neon shadow-sm h-100">
                <div class="card-header border-bottom border-secondary">
                    <h2 class="h5 mb-0">
                        <i class="bi bi-cash-stack text-neon"></i>
                        <?= $formTitle ?>
                    </h2>
                </div>
                <div class="card-body">
                    <form action="<?= $formAction ?>" method="POST" novalidate>
                        <?php if ($isEditing): ?>
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
                                value="<?= htmlspecialchars($isEditing ? $editingNomina['cargo'] : '', ENT_QUOTES, 'UTF-8') ?>"
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
                                value="<?= htmlspecialchars($isEditing ? (string) $editingNomina['sueldo'] : '', ENT_QUOTES, 'UTF-8') ?>"
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
                                value="<?= htmlspecialchars($isEditing ? (string) $editingNomina['faltas'] : '', ENT_QUOTES, 'UTF-8') ?>"
                                placeholder="Ej: 0"
                                required
                            >
                        </div>

                        <div class="d-flex gap-2 flex-wrap">
                            <button type="submit" class="btn btn-outline-info">
                                <i class="bi bi-floppy"></i>
                                <?= $submitLabel ?>
                            </button>

                            <?php if ($isEditing): ?>
                                <a href="/medicarflow/public/nomina.php" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle"></i>
                                    Cancelar edicion
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
                                            No hay registros de nomina disponibles.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($nominas as $nomina): ?>
                                        <tr>
                                            <td><?= (int) $nomina['id_nom'] ?></td>
                                            <td><?= htmlspecialchars($nomina['cargo'], ENT_QUOTES, 'UTF-8') ?></td>
                                            <td>$<?= number_format((float) $nomina['sueldo'], 2, ',', '.') ?></td>
                                            <td><?= (int) $nomina['faltas'] ?></td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                                    <a href="/medicarflow/public/nomina.php?edit=<?= (int) $nomina['id_nom'] ?>" class="btn btn-sm btn-outline-warning">
                                                        <i class="bi bi-pencil-square"></i>
                                                        Editar
                                                    </a>

                                                    <?php if ($isAdmin): ?>
                                                        <form action="/medicarflow/public/nomina.php?action=delete" method="POST" class="m-0">
                                                            <input type="hidden" name="id_nom" value="<?= (int) $nomina['id_nom'] ?>">
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Esta accion eliminara el registro de nomina. ¿Deseas continuar?');">
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

<script src="assets/libs/bootstrap/bootstrap.bundle.min.js"></script>
