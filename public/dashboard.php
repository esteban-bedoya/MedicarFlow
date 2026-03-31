<?php
// medicarflow/public/dashboard.php
session_start();

require_once __DIR__ . '/../app/controllers/DashboardController.php';

// Instanciamos el controlador y ejecutamos el método principal
$controller = new DashboardController();
$controller->index();