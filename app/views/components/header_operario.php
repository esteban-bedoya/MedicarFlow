    <link rel="stylesheet" href="assets/libs/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="assets/libs/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/globals/base.css">
    <link rel="stylesheet" href="assets/css/globals/header.css">


    <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-neon">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/medicarflow/public/nomina.php">
                <i class="bi bi-person-badge text-neon"></i>

                <span class="text-white">Medicar</span><span class="text-neon">Flow</span>

                <small class="text-white-50 text-uppercase ms-2" style="font-size: 10px; letter-spacing: 1px;">
                    Operario
                </small>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navOp">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navOp">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= $activePage == 'nomina' ? 'active text-neon' : '' ?>" href="/medicarflow/public/nomina.php">
                            <i class="bi bi-pencil-square"></i> Registrar Nómina
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $activePage == 'mi_perfil' ? 'active text-neon' : '' ?>" href="perfil.php">
                            <i class="bi bi-person-circle"></i> Mi Perfil
                        </a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-outline-danger btn-sm mt-1" href="../app/controllers/Logout.php">
                            <i class="bi bi-box-arrow-right"></i> Salir
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>