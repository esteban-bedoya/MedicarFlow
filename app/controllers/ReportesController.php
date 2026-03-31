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

    private function getReportConfig($tipoReporte)
    {
        $configuraciones = [
            'general' => [
                'titulo' => 'Reporte general de nomina',
                'descripcion' => 'Muestra todos los registros de nomina disponibles para consulta e impresion.',
            ],
            'sueldos_altos' => [
                'titulo' => 'Reporte de sueldos altos',
                'descripcion' => 'Incluye cargos con sueldo igual o superior a 2.000.000.',
            ],
            'secretarias' => [
                'titulo' => 'Reporte de secretarias',
                'descripcion' => 'Filtra los registros cuyo cargo corresponde a secretaria.',
            ],
            'premios' => [
                'titulo' => 'Reporte de premios',
                'descripcion' => 'Reconoce al personal con cero faltas.',
            ],
            'faltas' => [
                'titulo' => 'Reporte de faltas',
                'descripcion' => 'Lista los registros que tienen una o mas faltas.',
            ],
        ];

        return $configuraciones[$tipoReporte] ?? $configuraciones['general'];
    }

    public function index()
    {
        $this->requireSessionAdmin();

        $tipoReporte = $_GET['tipo'] ?? 'general';
        $reportesPermitidos = ['general', 'sueldos_altos', 'secretarias', 'premios', 'faltas'];

        if (!in_array($tipoReporte, $reportesPermitidos, true)) {
            $tipoReporte = 'general';
        }

        $configuracionReporte = $this->getReportConfig($tipoReporte);
        $registrosReporte = Nomina::getReportData($tipoReporte);
        $fechaGeneracion = date('d/m/Y H:i');

        include __DIR__ . '/../views/admin/reportes.php';
    }
}
