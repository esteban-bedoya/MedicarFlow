<?php
// medicarflow/app/controllers/DashboardController.php

class DashboardController
{

    public function index()
    {
        // 1. Verificar sesión (Seguridad centralizada)
        if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
            header("Location: login.php");
            exit;
        }

        // 2. Lógica de Routing por Rol
        if ($_SESSION['rol'] == 1) {
            // Carga la vista de Administrador
            include __DIR__ . '/../views/admin/dashboard.php';
        }
    }
}
