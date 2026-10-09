<?php
require_once "conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_v = trim($_POST['nombre_v'] ?? '');
    $apellido_v = trim($_POST['apellido_v'] ?? '');
    $especialidad = trim($_POST['especialidad'] ?? '');
    $redes_vta = trim($_POST['redes_vta'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validaciones básicas
    if (empty($nombre_v) || empty($apellido_v) || empty($correo) || empty($password)) {
        header("Location: register_vet.php?error=Por favor completa los campos obligatorios.");
        exit;
    }

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        header("Location: register_vet.php?error=El correo electrónico no es válido.");
        exit;
    }

    try {
        // Verificar si el correo ya está registrado
        $stmtCheck = $pdo->prepare("SELECT id_veterinario FROM veterinario WHERE correo = ?");
        $stmtCheck->execute([$correo]);
        if ($stmtCheck->rowCount() > 0) {
            header("Location: register_vet.php?error=El correo ya se encuentra registrado.");
            exit;
        }

        // Cifrar la contraseña de forma segura
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Insertar el nuevo veterinario en la base de datos
        $stmt = $pdo->prepare("
            INSERT INTO veterinario (nombre_v, apellido_v, especialidad, redes_vta, correo, password) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$nombre_v, $apellido_v, $especialidad, $redes_vta, $correo, $passwordHash]);

        // Redirigir al login con éxito
        header("Location: login_vet.php?registro=exitoso");
        exit;

    } catch (PDOException $e) {
        header("Location: register_vet.php?error=Error en el servidor. Inténtalo más tarde.");
        exit;
    }
} else {
    header("Location: register_vet.php");
    exit;
}