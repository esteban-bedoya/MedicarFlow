<?php
// medicarflow/public/reportes.php
session_start();

require_once __DIR__ . '/../app/controllers/ReportesController.php';

// Instanciamos el controlador y ejecutamos el método principal
$controller = new ReportesController();
$controller->index();