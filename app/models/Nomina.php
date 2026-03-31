<?php
// medicarflow/app/models/Nomina.php

require_once __DIR__ . '/../../config/db.php';

class Nomina
{
    public static function all()
    {
        global $pdo;

        $stmt = $pdo->query("
            SELECT id_nom, cargo, sueldo, faltas
            FROM nomina_pers
            ORDER BY id_nom DESC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findById($id)
    {
        global $pdo;

        $stmt = $pdo->prepare("
            SELECT id_nom, cargo, sueldo, faltas
            FROM nomina_pers
            WHERE id_nom = ?
            LIMIT 1
        ");
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($cargo, $sueldo, $faltas)
    {
        global $pdo;

        $stmt = $pdo->prepare("
            INSERT INTO nomina_pers (cargo, sueldo, faltas)
            VALUES (?, ?, ?)
        ");

        return $stmt->execute([$cargo, $sueldo, $faltas]);
    }

    public static function updateById($id, $cargo, $sueldo, $faltas)
    {
        global $pdo;

        $stmt = $pdo->prepare("
            UPDATE nomina_pers
            SET cargo = ?, sueldo = ?, faltas = ?
            WHERE id_nom = ?
        ");

        return $stmt->execute([$cargo, $sueldo, $faltas, $id]);
    }

    public static function delete($id)
    {
        global $pdo;

        $stmt = $pdo->prepare("DELETE FROM nomina_pers WHERE id_nom = ?");

        return $stmt->execute([$id]);
    }

    public static function getReportData($tipoReporte = 'general')
    {
        global $pdo;

        $consultaBase = "
            SELECT id_nom, cargo, sueldo, faltas
            FROM nomina_pers
        ";

        switch ($tipoReporte) {
            case 'sueldos_altos':
                $consulta = $consultaBase . " WHERE sueldo >= 2000000 ORDER BY sueldo DESC";
                break;

            case 'secretarias':
                $consulta = $consultaBase . " WHERE cargo LIKE 'Secretaria%' ORDER BY cargo ASC";
                break;

            case 'premios':
                $consulta = $consultaBase . " WHERE faltas = 0 ORDER BY cargo ASC";
                break;

            case 'faltas':
                $consulta = $consultaBase . " WHERE faltas > 0 ORDER BY faltas DESC, cargo ASC";
                break;

            case 'general':
            default:
                $consulta = $consultaBase . " ORDER BY id_nom DESC";
                break;
        }

        $stmt = $pdo->query($consulta);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
