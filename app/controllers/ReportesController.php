<?php
// medicarflow/app/controllers/ReportesController.php

class ReportesController
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
        include __DIR__ . '/../views/admin/reportes.php';
    }
}