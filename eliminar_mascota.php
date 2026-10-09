<?php
require_once "conexion.php";
session_start();

if (!isset($_SESSION['id_dueno'])) {
    header("Location: iniciar_s.php");
    exit;
}

$id_mascota = $_GET['id'] ?? null;
$id_dueno = $_SESSION['id_dueno'];

if ($id_mascota && is_numeric($id_mascota)) {
    // Como usas tabla intermedia, primero eliminamos la relación o la mascota (según prefieras)
    // Borrar de la tabla intermedia y de la mascota usando transacciones o dependencias por CASCADE
    $stmt = $pdo->prepare("DELETE FROM mascota WHERE id_mascota = ?");
    $stmt->execute([$id_mascota]);
}

header("Location: panel_de_control.php?mensaje=Mascota eliminada correctamente");
exit;