<?php
// medicarflow/public/perfil.php
session_start();

require_once __DIR__ . '/../app/controllers/PerfilController.php';

// Instanciamos el controlador y ejecutamos el método principal
$controller = new PerfilController();
$controller->index();