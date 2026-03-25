<?php
// medicarflow/public/nomina.php
session_start();

require_once __DIR__ . '/../app/controllers/NominaController.php';

// Instanciamos el controlador y ejecutamos el método principal
$controller = new NominaController();
$controller->index();