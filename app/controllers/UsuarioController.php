<?php
// medicarflow/app/controllers/UsuarioController.php

require_once __DIR__ . '/../models/User.php';

class UsuarioController
{
    private function requireAdmin()
    {
        if (!isset($_SESSION['id_user'])) {
            header('Location: /medicarflow/public/login.php');
            exit;
        }

        if ((int) ($_SESSION['rol'] ?? 0) !== 1) {
            http_response_code(403);
            die('No tienes permisos para administrar usuarios.');
        }
    }

    private function getRedirectUrl(array $params = [])
    {
        $base = '/medicarflow/public/usuarios.php';

        if (empty($params)) {
            return $base;
        }

        return $base . '?' . http_build_query($params);
    }

    private function setFlash($type, $title, $message)
    {
        $_SESSION['flash_usuarios'] = [
            'type' => $type,
            'title' => $title,
            'message' => $message,
        ];
    }

    private function sanitizeInput()
    {
        $nombreCompleto = trim($_POST['nombre_completo'] ?? '');
        $nombreUsuario = trim($_POST['username'] ?? '');
        $contrasena = trim($_POST['password'] ?? '');
        $rolUsuario = trim($_POST['fk_rol'] ?? '');

        return [$nombreCompleto, $nombreUsuario, $contrasena, $rolUsuario];
    }

    private function validateUserData($nombreCompleto, $nombreUsuario, $rolUsuario, $contrasena = null, $esEdicion = false)
    {
        if ($nombreCompleto === '' || $nombreUsuario === '' || $rolUsuario === '') {
            return 'Todos los campos obligatorios deben estar completos.';
        }

        if (!in_array((int) $rolUsuario, [1, 2], true)) {
            return 'El rol seleccionado no es válido.';
        }

        if (!$esEdicion && trim((string) $contrasena) === '') {
            return 'La contraseña es obligatoria para crear usuarios.';
        }

        return null;
    }

    public function index()
    {
        $this->requireAdmin();

        $usuarios = User::all();
        $usuarioEnEdicion = null;

        if (isset($_GET['edit'])) {
            $idUsuario = filter_input(INPUT_GET, 'edit', FILTER_VALIDATE_INT);

            if ($idUsuario) {
                $usuarioEnEdicion = User::findById($idUsuario);

                if (!$usuarioEnEdicion) {
                    $this->setFlash('error', '¡Error!', 'Ups, algo salió mal con la conexión o el usuario no existe.');
                    header('Location: ' . $this->getRedirectUrl());
                    exit;
                }
            }
        }

        include __DIR__ . '/../views/admin/usuarios.php';
    }

    public function store()
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . $this->getRedirectUrl());
            exit;
        }

        [$nombreCompleto, $nombreUsuario, $contrasena, $rolUsuario] = $this->sanitizeInput();
        $error = $this->validateUserData($nombreCompleto, $nombreUsuario, $rolUsuario, $contrasena, false);

        if ($error !== null) {
            $this->setFlash('warning', '¡Cuidado!', $error);
            header('Location: ' . $this->getRedirectUrl());
            exit;
        }

        if (User::findByUsername($nombreUsuario)) {
            $this->setFlash('error', '¡Error!', 'Ese nombre de usuario ya existe en el sistema.');
            header('Location: ' . $this->getRedirectUrl());
            exit;
        }

        if (User::create($nombreCompleto, $nombreUsuario, $contrasena, (int) $rolUsuario)) {
            $this->setFlash('success', '¡Guardado!', '¡Listo! Los datos ya están en la base de datos.');
        } else {
            $this->setFlash('error', '¡Error!', 'Ups, algo salió mal con la conexión.');
        }

        header('Location: ' . $this->getRedirectUrl());
        exit;
    }

    public function update()
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . $this->getRedirectUrl());
            exit;
        }

        $idUsuario = filter_input(INPUT_POST, 'id_user', FILTER_VALIDATE_INT);
        [$nombreCompleto, $nombreUsuario, $contrasena, $rolUsuario] = $this->sanitizeInput();

        if (!$idUsuario) {
            $this->setFlash('error', '¡Error!', 'Ups, algo salió mal con la conexión.');
            header('Location: ' . $this->getRedirectUrl());
            exit;
        }

        $error = $this->validateUserData($nombreCompleto, $nombreUsuario, $rolUsuario, $contrasena, true);

        if ($error !== null) {
            $this->setFlash('warning', '¡Cuidado!', $error);
            header('Location: ' . $this->getRedirectUrl(['edit' => $idUsuario]));
            exit;
        }

        $usuarioActual = User::findById($idUsuario);

        if (!$usuarioActual) {
            $this->setFlash('error', '¡Error!', 'Ups, algo salió mal con la conexión o el usuario no existe.');
            header('Location: ' . $this->getRedirectUrl());
            exit;
        }

        $usuarioConMismoUsername = User::findByUsername($nombreUsuario);

        if ($usuarioConMismoUsername && (int) $usuarioConMismoUsername['id_user'] !== $idUsuario) {
            $this->setFlash('error', '¡Error!', 'Ese nombre de usuario ya existe en el sistema.');
            header('Location: ' . $this->getRedirectUrl(['edit' => $idUsuario]));
            exit;
        }

        if (User::updateById($idUsuario, $nombreCompleto, $nombreUsuario, (int) $rolUsuario, $contrasena)) {
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

        $idUsuario = filter_input(INPUT_POST, 'id_user', FILTER_VALIDATE_INT);

        if (!$idUsuario) {
            $this->setFlash('error', '¡Error!', 'Ups, algo salió mal con la conexión.');
            header('Location: ' . $this->getRedirectUrl());
            exit;
        }

        if ((int) $_SESSION['id_user'] === $idUsuario) {
            $this->setFlash('warning', '¡Cuidado!', 'No puedes eliminar tu propio usuario mientras estás en sesión.');
            header('Location: ' . $this->getRedirectUrl());
            exit;
        }

        if (User::delete($idUsuario)) {
            $this->setFlash('success', '¡Guardado!', '¡Listo! Los datos ya están en la base de datos.');
        } else {
            $this->setFlash('error', '¡Error!', 'Ups, algo salió mal con la conexión.');
        }

        header('Location: ' . $this->getRedirectUrl());
        exit;
    }
}
