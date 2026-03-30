<?php
// medicarflow/app/controllers/ReportesController.php

class ReportesController
{
    private function requireAdmin()
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
        $this->requireAdmin();
        include __DIR__ . '/../views/admin/reportes.php';
    }
}