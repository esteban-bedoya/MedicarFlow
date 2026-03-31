    <link rel="stylesheet" href="assets/libs/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="assets/libs/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/globals/base.css">
    <link rel="stylesheet" href="assets/css/globals/header.css">


    <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-neon">
        <div class="container">
            <a class="navbar-brand fw-bold" href="dashboard.php">
                <i class="bi bi-shield-lock text-neon"></i>
                <span class="text-white">Medicar</span><span class="text-neon">Flow</span>
                <small class="text-white-50 text-uppercase ms-2" style="font-size: 10px; letter-spacing: 1px;">
                    Admin
                </small>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navAdmin">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navAdmin">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= $activePage == 'dashboard' ? 'active text-neon' : '' ?>" href="/medicarflow/public/dashboard.php">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $activePage == 'usuarios' ? 'active text-neon' : '' ?>" href="/medicarflow/public/usuarios.php">
                            <i class="bi bi-people"></i> Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $activePage == 'nomina' ? 'active text-neon' : '' ?>" href="/medicarflow/public/nomina.php">
                            <i class="bi bi-table"></i> Nómina
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $activePage == 'reportes' ? 'active text-neon' : '' ?>" href="/medicarflow/public/reportes.php">
                            <i class="bi bi-file-earmark-pdf"></i> Reportes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $activePage == 'perfil' ? 'active text-neon' : '' ?>" href="/medicarflow/public/perfil.php">
                            <i class="bi bi-file-earmark-pdf"></i> Mi perfil
                        </a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-outline-danger btn-sm mt-1" href="/medicarflow/public/logout.php">
                            <i class="bi bi-box-arrow-right"></i> Salir
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
