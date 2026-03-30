<?php
// medicarflow/public/usuarios.php
session_start();

require_once __DIR__ . '/../app/controllers/UsuarioController.php';

// Instanciamos el controlador y ejecutamos el método principal
$controller = new UsuarioController();
$controller->index();