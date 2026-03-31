<?php
// medicarflow/app/controllers/NominaController.php

require_once __DIR__ . '/../models/Nomina.php';

class NominaController
{
    private function requireSession()
    {
        if (!isset($_SESSION['id_user'])) {
            header('Location: /medicarflow/public/login.php');
            exit;
        }
    }

    private function requireWriteAccess()
    {
        $this->requireSession();

        if (!isset($_SESSION['rol']) || !in_array((int) $_SESSION['rol'], [1, 2], true)) {
            http_response_code(403);
            die('No tienes permisos para acceder a esta sección.');
        }
    }

    private function requireAdmin()
    {
        $this->requireSession();

        if ((int) ($_SESSION['rol'] ?? 0) !== 1) {
            http_response_code(403);
            die('Solo el administrador puede eliminar registros de nómina.');
        }
    }

    private function getRedirectUrl(array $params = [])
    {
        $base = '/medicarflow/public/nomina.php';

        if (empty($params)) {
            return $base;
        }

        return $base . '?' . http_build_query($params);
    }

    private function setFlash($type, $title, $message)
    {
        $_SESSION['flash'] = [
            'type' => $type,
            'title' => $title,
            'message' => $message,
        ];
    }

    private function sanitizeInput()
    {
        $cargo = trim($_POST['cargo'] ?? '');
        $sueldo = trim($_POST['sueldo'] ?? '');
        $faltas = trim($_POST['faltas'] ?? '');

        return [$cargo, $sueldo, $faltas];
    }

    private function validateNominaData($cargo, $sueldo, $faltas)
    {
        if ($cargo === '' || $sueldo === '' || $faltas === '') {
            return 'Todos los campos son obligatorios.';
        }

        if (!is_numeric($sueldo) || (float) $sueldo < 0) {
            return 'El sueldo debe ser un número válido mayor o igual a 0.';
        }

        if (filter_var($faltas, FILTER_VALIDATE_INT) === false || (int) $faltas < 0) {
            return 'Las faltas deben ser un número entero mayor o igual a 0.';
        }

        return null;
    }

    private function getViewPath()
    {
        return (int) $_SESSION['rol'] === 1
            ? __DIR__ . '/../views/admin/nomina.php'
            : __DIR__ . '/../views/oper/nomina.php';
    }

    public function index()
    {
        $this->requireSession();

        $nominas = Nomina::all();
        $editingNomina = null;

        if (isset($_GET['edit'])) {
            $editId = filter_input(INPUT_GET, 'edit', FILTER_VALIDATE_INT);

            if ($editId) {
                $editingNomina = Nomina::findById($editId);

                if (!$editingNomina) {
                    $this->setFlash('error', '¡Error!', 'Ups, algo salió mal con la conexión o el registro no existe.');
                    header('Location: ' . $this->getRedirectUrl());
                    exit;
                }
            }
        }

        include $this->getViewPath();
    }

    public function store()
    {
        $this->requireWriteAccess();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . $this->getRedirectUrl());
            exit;
        }

        [$cargo, $sueldo, $faltas] = $this->sanitizeInput();
        $error = $this->validateNominaData($cargo, $sueldo, $faltas);

        if ($error !== null) {
            $this->setFlash('warning', '¡Cuidado!', $error);
            header('Location: ' . $this->getRedirectUrl(['form' => 'create']));
            exit;
        }

        if (Nomina::create($cargo, (float) $sueldo, (int) $faltas)) {
            $this->setFlash('success', '¡Guardado!', '¡Listo! Los datos ya están en la base de datos.');
        } else {
            $this->setFlash('error', '¡Error!', 'Ups, algo salió mal con la conexión.');
        }

        header('Location: ' . $this->getRedirectUrl());
        exit;
    }

    public function update()
    {
        $this->requireWriteAccess();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . $this->getRedirectUrl());
            exit;
        }

        $id = filter_input(INPUT_POST, 'id_nom', FILTER_VALIDATE_INT);
        [$cargo, $sueldo, $faltas] = $this->sanitizeInput();

        if (!$id) {
            $this->setFlash('error', '¡Error!', 'Ups, algo salió mal con la conexión.');
            header('Location: ' . $this->getRedirectUrl());
            exit;
        }

        $error = $this->validateNominaData($cargo, $sueldo, $faltas);

        if ($error !== null) {
            $this->setFlash('warning', '¡Cuidado!', $error);
            header('Location: ' . $this->getRedirectUrl(['edit' => $id]));
            exit;
        }

        if (Nomina::updateById($id, $cargo, (float) $sueldo, (int) $faltas)) {
            $this->setFlash('success', '¡Guardado!', '¡Listo! Los datos ya están en la base de datos.');
        } else {
            $this->setFlash('error', '¡Error!', 'Ups, algo salió mal con la conexión.');
        }

        header('Location: ' . $this->getRedirectUrl());
        exit;
    }

    public function delete()
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . $this->getRedirectUrl());
            exit;
        }

        $id = filter_input(INPUT_POST, 'id_nom', FILTER_VALIDATE_INT);

        if (!$id) {
            $this->setFlash('error', '¡Error!', 'Ups, algo salió mal con la conexión.');
            header('Location: ' . $this->getRedirectUrl());
            exit;
        }

        if (Nomina::delete($id)) {
            $this->setFlash('success', '¡Guardado!', '¡Listo! Los datos ya están en la base de datos.');
        } else {
            $this->setFlash('error', '¡Error!', 'Ups, algo salió mal con la conexión.');
        }

        header('Location: ' . $this->getRedirectUrl());
        exit;
    }
}
