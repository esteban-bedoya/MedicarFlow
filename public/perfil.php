<?php
// medicarflow/public/perfil.php

session_start();

require_once __DIR__ . '/../app/controllers/PerfilController.php';

$controller = new PerfilController();
$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'update_password':
        $controller->updatePassword();
        break;

    case 'index':
    default:
        $controller->index();
        break;
}
