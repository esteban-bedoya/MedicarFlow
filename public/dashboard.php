<?php
// medicarflow/public/dashboard.php
session_start();

// 1. Seguridad: Si no está logueado, al login
if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
    header("Location: login.php");
    exit;
}

// 2. Redirección por Rol (Servir la vista sin cambiar la URL)
// Esto se llama "Routing" básico.
if ($_SESSION['rol'] == 1) {
    // Es Admin: Le mostramos la vista de admin
    include __DIR__ . '/../app/views/admin/dashboard.php';
} // else {
    // Es Operativo: Le mostramos su vista
  //  include __DIR__ . '/../app/views/operativo/dashboard.php';
//}