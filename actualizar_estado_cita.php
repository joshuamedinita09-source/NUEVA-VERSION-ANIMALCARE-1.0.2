<?php
require_once "conexion.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cita = $_POST['id_cita'] ?? null;
    $nuevo_estado = $_POST['nuevo_estado'] ?? null;

    if ($id_cita && $nuevo_estado) {
        $stmt = $pdo->prepare("UPDATE cita SET estado = ? WHERE id_cita = ?");
        $stmt->execute([$nuevo_estado, $id_cita]);
    }

    header("Location: panel_veterinario.php");
    exit;
}