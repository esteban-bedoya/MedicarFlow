<?php
require_once 'config/db.php'; // Asegúrate de que aquí se define $pdo

try {
    // 1. Traemos los usuarios que tienen claves cortas (sin encriptar)
    $usuarios = $pdo->query("SELECT id_user, password FROM usuarios")->fetchAll();

    foreach ($usuarios as $user) {
        // Solo encriptamos si la clave no parece un hash (los hashes tienen 60 caracteres)
        if (strlen($user['password']) < 20) {
            $nuevoHash = password_hash($user['password'], PASSWORD_DEFAULT);
            $update = $pdo->prepare("UPDATE usuarios SET password = ? WHERE id_user = ?");
            $update->execute([$nuevoHash, $user['id_user']]);
            echo "Usuario ID {$user['id_user']} actualizado.<br>";
        }
    }
    echo "¡Encriptación completada!";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}