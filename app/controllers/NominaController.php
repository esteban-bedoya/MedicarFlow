<?php
// medicarflow/app/controllers/NominaController.php

class NominaController
{
    private function requireAdmin()
    {
        if (!isset($_SESSION['rol'])) {
            header('Location: /login');
            exit;
        }
    }

    public function index()
    {
        $this->requireAdmin();

        // Lógica de Routing por Rol
        if ($_SESSION['rol'] == 1) {
        // Carga la vista de Administrador
            include __DIR__ . '/../views/admin/nomina.php';
        } else {
        // Carga la vista de Operativo
            include __DIR__ . '/../views/oper/nomina.php';
        }
    }
}
