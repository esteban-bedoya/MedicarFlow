<?php
// medicarflow/public/usuarios.php

session_start();

require_once __DIR__ . '/../app/controllers/UsuarioController.php';

$controller = new UsuarioController();
$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'store':
        $controller->store();
        break;

    case 'update':
        $controller->update();
        break;

    case 'delete':
        $controller->delete();
        break;

    case 'index':
    default:
        $controller->index();
        break;
}
