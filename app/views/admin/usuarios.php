<?php
$activePage = 'usuarios';
$mensajeEmergente = $_SESSION['flash_usuarios'] ?? null;
unset($_SESSION['flash_usuarios']);

$registroEnEdicion = isset($usuarioEnEdicion) && is_array($usuarioEnEdicion);
$accionFormulario = $registroEnEdicion
    ? '/medicarflow/public/usuarios.php?action=update'
    : '/medicarflow/public/usuarios.php?action=store';
$tituloFormulario = $registroEnEdicion ? 'Editar usuario del sistema' : 'Registrar nuevo usuario';
$textoBotonGuardar = $registroEnEdicion ? 'Actualizar usuario' : 'Guardar usuario';
$mensajeEmergenteJson = $mensajeEmergente ? json_encode($mensajeEmergente, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : 'null';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios - Administrador</title>
</head>
<body>
    <?php include __DIR__ . '/../components/header_administrador.php'; ?>

    <main class="container py-4">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
            <div>
                <h1 class="h3 mb-1 text-dark">Módulo de usuarios</h1>
                <p class="text-secondary mb-0">
                    Este espacio permite crear, editar y eliminar los usuarios que pueden entrar al sistema.
                </p>
            </div>
            <div class="text-secondary small text-lg-end">
                <div>Usuario actual: <?= htmlspecialchars($_SESSION['nombre'] ?? 'Usuario', ENT_QUOTES, 'UTF-8') ?></div>
                <div>Rol actual: Administrador</div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12 col-xl-4">
                <div class="card bg-dark text-white border border-neon shadow-sm h-100">
                    <div class="card-header border-bottom border-secondary">
                        <h2 class="h5 mb-0">
                            <i class="bi bi-person-plus text-neon"></i>
                            <?= $tituloFormulario ?>
                        </h2>
                    </div>
                    <div class="card-body">
                        <form action="<?= $accionFormulario ?>" method="POST" novalidate data-usuarios-form>
                            <?php if ($registroEnEdicion): ?>
                                <input type="hidden" name="id_user" value="<?= (int) $usuarioEnEdicion['id_user'] ?>">
                            <?php endif; ?>

                            <div class="mb-3">
                                <label for="nombre_completo" class="form-label">Nombre completo</label>
                                <input
                                    type="text"
                                    id="nombre_completo"
                                    name="nombre_completo"
                                    class="form-control"
                                    maxlength="100"
                                    value="<?= htmlspecialchars($registroEnEdicion ? $usuarioEnEdicion['nombre_completo'] : '', ENT_QUOTES, 'UTF-8') ?>"
                                    placeholder="Ej: Ana Garcia"
                                    required
                                >
                            </div>

                            <div class="mb-3">
                                <label for="username" class="form-label">Nombre de usuario</label>
                                <input
                                    type="text"
                                    id="username"
                                    name="username"
                                    class="form-control"
                                    maxlength="50"
                                    value="<?= htmlspecialchars($registroEnEdicion ? $usuarioEnEdicion['username'] : '', ENT_QUOTES, 'UTF-8') ?>"
                                    placeholder="Ej: admin_ana"
                                    required
                                >
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    Contraseña <?= $registroEnEdicion ? '(solo si deseas cambiarla)' : '' ?>
                                </label>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="form-control"
                                    placeholder="Ingresa la contraseña"
                                    <?= $registroEnEdicion ? '' : 'required' ?>
                                >
                            </div>

                            <div class="mb-4">
                                <label for="fk_rol" class="form-label">Rol</label>
                                <select id="fk_rol" name="fk_rol" class="form-select" required>
                                    <option value="">Selecciona un rol</option>
                                    <option value="1" <?= $registroEnEdicion && (int) $usuarioEnEdicion['fk_rol'] === 1 ? 'selected' : '' ?>>Administrador</option>
                                    <option value="2" <?= $registroEnEdicion && (int) $usuarioEnEdicion['fk_rol'] === 2 ? 'selected' : '' ?>>Operativo</option>
                                </select>
                            </div>

                            <div class="d-flex gap-2 flex-wrap">
                                <button type="submit" class="btn btn-outline-info">
                                    <i class="bi bi-floppy"></i>
                                    <?= $textoBotonGuardar ?>
                                </button>

                                <?php if ($registroEnEdicion): ?>
                                    <a href="/medicarflow/public/usuarios.php" class="btn btn-outline-secondary">
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
                            <i class="bi bi-people text-neon"></i>
                            Usuarios registrados
                        </h2>
                        <span class="text-white-50 small">Total: <?= count($usuarios) ?></span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-dark table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre completo</th>
                                        <th>Usuario</th>
                                        <th>Rol</th>
                                        <th>Fecha</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($usuarios)): ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-white-50 py-4">
                                                No hay usuarios registrados.
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($usuarios as $registroUsuario): ?>
                                            <tr>
                                                <td><?= (int) $registroUsuario['id_user'] ?></td>
                                                <td><?= htmlspecialchars($registroUsuario['nombre_completo'], ENT_QUOTES, 'UTF-8') ?></td>
                                                <td><?= htmlspecialchars($registroUsuario['username'], ENT_QUOTES, 'UTF-8') ?></td>
                                                <td><?= (int) $registroUsuario['fk_rol'] === 1 ? 'Administrador' : 'Operativo' ?></td>
                                                <td><?= htmlspecialchars($registroUsuario['fecha_registro'], ENT_QUOTES, 'UTF-8') ?></td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                                                        <a href="/medicarflow/public/usuarios.php?edit=<?= (int) $registroUsuario['id_user'] ?>" class="btn btn-sm btn-outline-warning">
                                                            <i class="bi bi-pencil-square"></i>
                                                            Editar
                                                        </a>

                                                        <?php if ((int) $registroUsuario['id_user'] !== (int) ($_SESSION['id_user'] ?? 0)): ?>
                                                            <form action="/medicarflow/public/usuarios.php?action=delete" method="POST" class="m-0" data-delete-user-form>
                                                                <input type="hidden" name="id_user" value="<?= (int) $registroUsuario['id_user'] ?>">
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
        const formularioUsuarios = document.querySelector('[data-usuarios-form]');
        const formulariosEliminarUsuario = document.querySelectorAll('[data-delete-user-form]');

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

        if (formularioUsuarios) {
            formularioUsuarios.addEventListener('submit', function (eventoFormulario) {
                const campoNombreCompleto = document.getElementById('nombre_completo');
                const campoNombreUsuario = document.getElementById('username');
                const campoRol = document.getElementById('fk_rol');

                if (!campoNombreCompleto.value.trim()) {
                    eventoFormulario.preventDefault();
                    Swal.fire({
                        ...estilosBaseAlerta,
                        icon: 'warning',
                        title: '¡Cuidado!',
                        text: 'Olvidaste escribir el nombre completo.'
                    });
                    campoNombreCompleto.focus();
                    return;
                }

                if (!campoNombreUsuario.value.trim() || !campoRol.value) {
                    eventoFormulario.preventDefault();
                    Swal.fire({
                        ...estilosBaseAlerta,
                        icon: 'warning',
                        title: '¡Cuidado!',
                        text: 'Todos los campos obligatorios deben estar completos.'
                    });
                }
            });
        }

        formulariosEliminarUsuario.forEach(function (formularioEliminarUsuario) {
            formularioEliminarUsuario.addEventListener('submit', function (eventoEliminar) {
                eventoEliminar.preventDefault();

                Swal.fire({
                    ...estilosBaseAlerta,
                    icon: 'warning',
                    title: '¿Estás seguro?',
                    text: 'Si borras este usuario, desaparecerá para siempre.',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d'
                }).then(function (resultado) {
                    if (resultado.isConfirmed) {
                        formularioEliminarUsuario.submit();
                    }
                });
            });
        });
    </script>
</body>
</html>
