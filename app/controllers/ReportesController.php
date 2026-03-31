<?php
// medicarflow/app/controllers/ReportesController.php

require_once __DIR__ . '/../models/Nomina.php';

class ReportesController
{
    private function requireSessionAdmin()
    {
        if (!isset($_SESSION['id_user'])) {
            header('Location: /medicarflow/public/login.php');
            exit;
        }

        if ((int) ($_SESSION['rol'] ?? 0) !== 1) {
            http_response_code(403);
            die('No tienes permisos para acceder a los reportes.');
        }
    }

    public function index()
    {
        $this->requireSessionAdmin();

        $tipoReporte = $_GET['tipo'] ?? 'general';
        $cargoSeleccionado = trim($_GET['cargo'] ?? '');
        $reportesPermitidos = ['general', 'sueldos_altos', 'cargo', 'premios', 'faltas'];

        if (!in_array($tipoReporte, $reportesPermitidos, true)) {
            $tipoReporte = 'general';
        }

        $listaDeCargos = Nomina::getAvailableCargos();

        if ($tipoReporte === 'cargo') {
            if ($cargoSeleccionado !== '' && in_array($cargoSeleccionado, $listaDeCargos, true)) {
                $registrosReporte = Nomina::getReportDataByCargo($cargoSeleccionado);
            } else {
                $cargoSeleccionado = '';
                $registrosReporte = [];
            }
        } else {
            $registrosReporte = Nomina::getReportData($tipoReporte);
        }

        $fechaGeneracion = date('d/m/Y H:i');

        include __DIR__ . '/../views/admin/reportes.php';
    }
}
