<?php
// medicarflow/app/controllers/UsuarioController.php

require_once __DIR__ . '/../models/User.php';

class UsuarioController
{
    // Listar usuarios
    public function index()
    {
        $usuarios = User::all(); // Método simple para traer los usuarios actuales
        include __DIR__ . '/../views/admin/usuarios.php';
    }

    // Crear usuario (Simplificado a tu DB)
    public function store()
    {
        session_start();
        $nombre   = trim($_POST['nombre_completo'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $rol      = $_POST['fk_rol'] ?? 2;

        if (empty($nombre) || empty($username) || empty($password)) {
            $_SESSION['error'] = "Todos los campos son obligatorios.";
            header("Location: ../../views/admin/usuarios.php?modal=agregar");
            exit;
        }

        // Registro en la DB
        User::create($nombre, $username, $password, $rol);

        $_SESSION['success'] = "Usuario creado con éxito.";
        header("Location: ../../views/admin/usuarios.php");
        exit;
    }

    // Eliminar (Punto crítico: Solo si el rol es Admin)
    public function delete()
    {
        session_start();
        if ($_SESSION['rol'] != 1) {
            die("No tienes permisos para esta acción.");
        }

        $id = $_GET['id'];
        User::delete($id);

        header("Location: ../../views/admin/usuarios.php");
        exit;
    }
}