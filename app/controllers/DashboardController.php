<?php
// medicarflow/app/controllers/DashboardController.php

require_once __DIR__ . '/../models/Nomina.php';

class DashboardController
{
    private function requireSessionAdmin()
    {
        if (!isset($_SESSION['id_user'])) {
            header('Location: /medicarflow/public/login.php');
            exit;
        }

        if ((int) ($_SESSION['rol'] ?? 0) !== 1) {
            http_response_code(403);
            die('No tienes permisos para acceder al dashboard.');
        }
    }

    public function index()
    {
        $this->requireSessionAdmin();

        $resumenDashboard = Nomina::getDashboardSummary();
        $datosPorCargo = Nomina::getChartDataByCargo();

        $etiquetasGraficas = [];
        $datosSueldos = [];
        $datosFaltas = [];
        $datosPremios = [];

        foreach ($datosPorCargo as $filaCargo) {
            $etiquetasGraficas[] = $filaCargo['cargo'];
            $datosSueldos[] = (float) $filaCargo['sueldo_promedio'];
            $datosFaltas[] = (int) $filaCargo['total_faltas'];
            $datosPremios[] = (int) $filaCargo['total_premiados'];
        }

        $resumenGraficoJson = json_encode([
            'etiquetas' => $etiquetasGraficas,
            'sueldos' => $datosSueldos,
            'faltas' => $datosFaltas,
            'premios' => $datosPremios,
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        include __DIR__ . '/../views/admin/dashboard.php';
    }
}
