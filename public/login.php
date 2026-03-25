<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedicarFlow - Login</title>
    <link rel="stylesheet" href="assets/libs/bootstrap.min.css">
    <link rel="stylesheet" href="assets/libs/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/globals/base.css">
    <link rel="stylesheet" href="assets/css/globals/login.css">
</head>

<body class="bg-dark d-flex align-items-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow-lg border-0 p-4 login-card">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold">MEDICAR<span class="text-neon">FLOW</span></h2>
                        <p class="text-muted">Módulo de Nómina - Esteban Bedoya</p>
                    </div>

                    <form action="app/controllers/AuthController.php?action=login" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Usuario:</label>
                            <input type="text" name="username" class="form-control" placeholder="Ej: admin_ana" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Contraseña:</label>
                            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                        </div>

                        <button type="submit" class="btn btn-neon w-100 fw-bold mt-2">
                            INGRESAR <i class="bi bi-box-arrow-in-right"></i>
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="#" class="text-decoration-none small text-muted">¿Olvidó su contraseña?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


<script src="assets/libs/bootstrap.bundle.min.js"></script>
<script src="assets/libs/sweetalert2.all.min.js"></script>
<script src="assets/libs/chartjs/chart.umd.min.js"></script>

</body>

</html>