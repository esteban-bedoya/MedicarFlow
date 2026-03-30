<?php
// medicarflow/app/controllers/UsuarioController.php

class UsuarioController
{
    private function requireSessionAdmin()
    {

        if (!isset($_SESSION['rol'])) {
            header('Location: /login');
            exit;
        }

        if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
            die('No tienes permisos para esta accion.');
        }
    }

    public function index()
    {
        $this->requireSessionAdmin();
        include __DIR__ . '/../views/admin/usuarios.php';
    }
}
