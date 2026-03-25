<?php $activePage = 'nomina'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nomina - Administrador</title>
</head>

<body>

    <?php
    // Determinar qué header cargar según el rol guardado en el login
    if ($_SESSION['rol'] == 1) {
        include __DIR__ . '/../components/header_administrador.php';
    } else {
        include __DIR__ . '/../components/header_operario.php';
    }
    ?>

    <h1>Logueo como administrador</h1>
</body>

</html>