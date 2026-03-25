<?php
// medicarflow/app/controllers/AuthController.php

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    public function login()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: ../../index.php");
            exit;
        }

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = User::findByUsername($username);

        // Verificamos con password_verify porque ya corrimos el script de encriptación
        if ($user && password_verify($password, $user['password'])) {

            $_SESSION['logged'] = true;
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['nombre'] = $user['nombre_completo'];
            $_SESSION['rol'] = $user['fk_rol'];

            // Redirección limpia según el rol de tu DB
            if ($user['fk_rol'] == 1) {
                header("Location: /medicarflow/public/dashboard.php");
            } else {
                header("Location: /medicarflow/public/nomina.php");
            }
            exit;
        } else {
            // Si falla la clave o no existe el usuario
            $_SESSION['error'] = "Usuario o contraseña incorrectos";
            header("Location: ../../index.php");
            exit;
        }
    }
}