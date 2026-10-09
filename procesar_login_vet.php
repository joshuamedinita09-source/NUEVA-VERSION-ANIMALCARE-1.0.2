<?php
session_start();
require_once 'conexion.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = trim($_POST['correo'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($correo) || empty($password)) {
        header("Location: login_vet.php?error=Por favor completa todos los campos.");
        exit;
    }

    // Cambiamos $conexion por $pdo
    $sql = "SELECT id_veterinario, nombre_v, apellido_v, password FROM veterinario WHERE correo = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$correo]);
    $veterinario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($veterinario && password_verify($password, $veterinario['password'])) {
        $_SESSION['id_veterinario'] = $veterinario['id_veterinario'];
        $_SESSION['nombre_v'] = $veterinario['nombre_v'] . ' ' . $veterinario['apellido_v'];
        
        header("Location: panel_veterinario.php");
        exit;
    } else {
        header("Location: login_vet.php?error=Correo o contraseña incorrectos.");
        exit;
    }
}
?>