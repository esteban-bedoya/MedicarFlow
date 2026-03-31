<?php
$mensajeEmergente = $_SESSION['flash_perfil'] ?? null;
unset($_SESSION['flash_perfil']);

$mensajeEmergenteJson = $mensajeEmergente ? json_encode($mensajeEmergente, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : 'null';
$rolActualTexto = (int) ($datosUsuario['fk_rol'] ?? 0) === 1 ? 'Administrador' : 'Operativo';
?>

<main class="container py-4">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1 text-dark">Mi perfil</h1>
            <p class="text-soft-dark mb-0">
                Consulta tus datos de acceso y cambia la contraseña de tu sesión actual.
            </p>
        </div>
        <div class="text-soft-dark small text-lg-end">
            <div>Usuario actual: <?= htmlspecialchars($datosUsuario['nombre_completo'], ENT_QUOTES, 'UTF-8') ?></div>
            <div>Rol actual: <?= htmlspecialchars($rolActualTexto, ENT_QUOTES, 'UTF-8') ?></div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-xl-5">
            <div class="card bg-dark text-white border border-neon shadow-sm h-100">
                <div class="card-header border-bottom border-secondary">
                    <h2 class="h5 mb-0 text-neon">
                        <i class="bi bi-person-vcard text-neon"></i>
                        Datos del perfil
                    </h2>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-5 text-white">Nombre completo</dt>
                        <dd class="col-sm-7"><?= htmlspecialchars($datosUsuario['nombre_completo'], ENT_QUOTES, 'UTF-8') ?></dd>

                        <dt class="col-sm-5 text-white">Usuario</dt>
                        <dd class="col-sm-7"><?= htmlspecialchars($datosUsuario['username'], ENT_QUOTES, 'UTF-8') ?></dd>

                        <dt class="col-sm-5 text-white">Rol</dt>
                        <dd class="col-sm-7"><?= htmlspecialchars($rolActualTexto, ENT_QUOTES, 'UTF-8') ?></dd>

                        <dt class="col-sm-5 text-white">Fecha de registro</dt>
                        <dd class="col-sm-7"><?= htmlspecialchars($datosUsuario['fecha_registro'], ENT_QUOTES, 'UTF-8') ?></dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-7">
            <div class="card bg-dark text-white border border-neon shadow-sm h-100">
                <div class="card-header border-bottom border-secondary">
                    <h2 class="h5 mb-0 text-neon">
                        <i class="bi bi-key text-neon"></i>
                        Cambiar contraseña
                    </h2>
                </div>
                <div class="card-body">
                    <form action="/medicarflow/public/perfil.php?action=update_password" method="POST" novalidate data-formulario-perfil>
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Contraseña actual</label>
                            <input type="password" id="current_password" name="current_password" class="form-control" placeholder="Ingresa tu contraseña actual" required>
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">Nueva contraseña</label>
                            <input type="password" id="new_password" name="new_password" class="form-control" placeholder="Escribe tu nueva contraseña" required>
                        </div>

                        <div class="mb-4">
                            <label for="confirm_password" class="form-label">Confirmar nueva contraseña</label>
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Repite la nueva contraseña" required>
                        </div>

                        <button type="submit" class="btn btn-outline-info">
                            <i class="bi bi-shield-lock"></i>
                            Actualizar contraseña
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
<script src="assets/libs/bootstrap/bootstrap.bundle.min.js"></script>
<script>
    const mensajeDelSistema = <?= $mensajeEmergenteJson ?>;
    const formularioPerfil = document.querySelector('[data-formulario-perfil]');

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

    if (formularioPerfil) {
        formularioPerfil.addEventListener('submit', function (eventoFormulario) {
            const campoContrasenaActual = document.getElementById('current_password');
            const campoContrasenaNueva = document.getElementById('new_password');
            const campoConfirmacion = document.getElementById('confirm_password');

            if (!campoContrasenaActual.value.trim() || !campoContrasenaNueva.value.trim() || !campoConfirmacion.value.trim()) {
                eventoFormulario.preventDefault();
                Swal.fire({
                    ...estilosBaseAlerta,
                    icon: 'warning',
                    title: '¡Cuidado!',
                    text: 'Todos los campos de contraseña son obligatorios.'
                });
                return;
            }

            if (campoContrasenaNueva.value !== campoConfirmacion.value) {
                eventoFormulario.preventDefault();
                Swal.fire({
                    ...estilosBaseAlerta,
                    icon: 'warning',
                    title: '¡Cuidado!',
                    text: 'La nueva contraseña y su confirmación no coinciden.'
                });
                return;
            }
        });
    }
</script>
