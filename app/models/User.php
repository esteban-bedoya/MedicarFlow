<?php
// medicarflow/app/models/User.php

require_once __DIR__ . '/../../config/db.php';

class User
{
    public static function all()
    {
        global $pdo;
        // Ajustado a las columnas reales de hospital_pro
        $stmt = $pdo->query("SELECT id_user, nombre_completo, username, fk_rol, fecha_registro FROM usuarios");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findByUsername($username)
    {
        global $pdo;
        // En hospital_pro usamos username para el login
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($nombre, $username, $password, $rol)
    {
        global $pdo;
        // Usamos password_hash para cumplir con seguridad si decides encriptar, 
        // o guarda $password directo si prefieres mantener el '12345' del SQL inicial.
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("
            INSERT INTO usuarios (nombre_completo, username, password, fk_rol, fecha_registro)
            VALUES (?, ?, ?, ?, NOW())
        ");

        return $stmt->execute([$nombre, $username, $hashed, $rol]);
    }

    public static function updateById($id, $nombre, $username, $rol, $password = null)
    {
        global $pdo;

        if ($password === null || trim($password) === '') {
            $stmt = $pdo->prepare("
                UPDATE usuarios
                SET nombre_completo = ?, username = ?, fk_rol = ?
                WHERE id_user = ?
            ");
            return $stmt->execute([$nombre, $username, $rol, $id]);
        }

        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("
            UPDATE usuarios
            SET nombre_completo = ?, username = ?, password = ?, fk_rol = ?
            WHERE id_user = ?
        ");
        return $stmt->execute([$nombre, $username, $hashed, $rol, $id]);
    }

    public static function delete($id)
    {
        global $pdo;
        // En tu DB la llave primaria es id_user
        $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id_user = ?");
        return $stmt->execute([$id]);
    }

    public static function findById($id)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id_user = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updatePasswordById($id, $password)
    {
        global $pdo;

        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("
            UPDATE usuarios
            SET password = ?
            WHERE id_user = ?
        ");

        return $stmt->execute([$hashed, $id]);
    }
} 
