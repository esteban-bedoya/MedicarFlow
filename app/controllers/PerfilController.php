<?php
// medicarflow/app/controllers/PerfilController.php

require_once __DIR__ . '/../models/User.php';

class PerfilController
{
    private function requireSession()
    {
        if (!isset($_SESSION['id_user'])) {
            header('Location: /medicarflow/public/login.php');
            exit;
        }
    }

    private function getRedirectUrl()
    {
        return '/medicarflow/public/perfil.php';
    }

    private function setFlash($type, $title, $message)
    {
        $_SESSION['flash_perfil'] = [
            'type' => $type,
            'title' => $title,
            'message' => $message,
        ];
    }

    private function getViewPath()
    {
        return (int) ($_SESSION['rol'] ?? 0) === 1
            ? __DIR__ . '/../views/admin/perfil.php'
            : __DIR__ . '/../views/oper/perfil.php';
    }

    public function index()
    {
        $this->requireSession();

        $datosUsuario = User::findById((int) $_SESSION['id_user']);

        if (!$datosUsuario) {
            $this->setFlash('error', '¡Error!', 'Ups, algo salió mal con la conexión o el usuario no existe.');
            header('Location: /medicarflow/public/logout.php');
            exit;
        }

        include $this->getViewPath();
    }

    public function updatePassword()
    {
        $this->requireSession();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . $this->getRedirectUrl());
            exit;
        }

        $contrasenaActual = trim($_POST['current_password'] ?? '');
        $contrasenaNueva = trim($_POST['new_password'] ?? '');
        $confirmacionContrasena = trim($_POST['confirm_password'] ?? '');

        if ($contrasenaActual === '' || $contrasenaNueva === '' || $confirmacionContrasena === '') {
            $this->setFlash('warning', '¡Cuidado!', 'Todos los campos de contraseña son obligatorios.');
            header('Location: ' . $this->getRedirectUrl());
            exit;
        }

        if ($contrasenaNueva !== $confirmacionContrasena) {
            $this->setFlash('warning', '¡Cuidado!', 'La nueva contraseña y su confirmación no coinciden.');
            header('Location: ' . $this->getRedirectUrl());
            exit;
        }

        if (strlen($contrasenaNueva) < 5) {
            $this->setFlash('warning', '¡Cuidado!', 'La nueva contraseña debe tener al menos 5 caracteres.');
            header('Location: ' . $this->getRedirectUrl());
            exit;
        }

        $datosUsuario = User::findById((int) $_SESSION['id_user']);

        if (!$datosUsuario || !password_verify($contrasenaActual, $datosUsuario['password'])) {
            $this->setFlash('error', '¡Error!', 'La contraseña actual no es correcta.');
            header('Location: ' . $this->getRedirectUrl());
            exit;
        }

        if (User::updatePasswordById((int) $_SESSION['id_user'], $contrasenaNueva)) {
            $this->setFlash('success', '¡Guardado!', 'Tu contraseña fue actualizada correctamente.');
        } else {
            $this->setFlash('error', '¡Error!', 'Ups, algo salió mal con la conexión.');
        }

        header('Location: ' . $this->getRedirectUrl());
        exit;
    }
}
