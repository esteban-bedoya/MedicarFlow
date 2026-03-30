<?php
// medicarflow/public/nomina.php

session_start();

require_once __DIR__ . '/../app/controllers/NominaController.php';

$controller = new NominaController();
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
