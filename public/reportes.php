<?php
// medicarflow/public/reportes.php
session_start();

require_once __DIR__ . '/../app/controllers/ReportesController.php';

$controller = new ReportesController();
$controller->index();
