<?php
// medicarflow/app/controllers/PerfilController.php

class PerfilController
{
    private function requireSession()
    {
        if (!isset($_SESSION['rol'])) {
            header('Location: /login');
            exit;
        }
    }

    public function index()
    {
        $this->requireSession();

        // Lógica de Routing por Rol
        if ($_SESSION['rol'] == 1) {
        // Carga la vista de Administrador
            include __DIR__ . '/../views/admin/perfil.php';
        } else {
        // Carga la vista de Operativo
            include __DIR__ . '/../views/oper/perfil.php';
        }
    }
}
