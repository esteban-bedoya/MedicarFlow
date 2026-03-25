<?php
// medicarflow/app/controllers/AuthController.php

require_once __DIR__ . '/../../config/db.php'; // Asegúrate de que este archivo exista
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    public function login()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: ../../index.php");
            exit;
        }

        // Cambiamos 'correo' por 'username' según tu nueva DB
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        // Buscamos al usuario por su username
        $user = User::findByUsername($username);

        // IMPORTANTE: En tu volcado SQL las claves son '12345' (texto plano).
        // Si no has encriptado, comparamos directo. Si ya usas hash, usa password_verify.
        if ($user && ($password === $user['password'])) {
            
            $_SESSION['logged'] = true;
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['nombre'] = $user['nombre_completo'];
            $_SESSION['rol'] = $user['fk_rol'];

            // Redirección según Roles de hospital_pro: 1: Admin, 2: Operativo
            if ($user['fk_rol'] == 1) {
                header("Location: ../../views/admin/dashboard.php");
            } else {
                header("Location: ../../views/operativo/dashboard.php");
            }
            exit;
        }

        $_SESSION['error'] = "Usuario o contraseña incorrectos";
        header("Location: ../../index.php");
        exit;
    }
}