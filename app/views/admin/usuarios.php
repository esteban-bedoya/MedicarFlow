<?php $activePage = 'usuarios'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios - Administrador</title>
</head>

<body>

    <?php
    // Determinar qué header cargar según el rol guardado en el login
    if ($_SESSION['rol'] == 1) {
        include __DIR__ . '/../components/header_administrador.php';
    }
    ?>

    <h1>Usuarios como administrador</h1>
</body>

</html>