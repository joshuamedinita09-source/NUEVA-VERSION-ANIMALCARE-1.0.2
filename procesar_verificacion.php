<?php
session_start();
require "conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recoger los 6 dígitos del código OTP ingresados por el usuario
    $otp1 = trim($_POST["otp1"] ?? "");
    $otp2 = trim($_POST["otp2"] ?? "");
    $otp3 = trim($_POST["otp3"] ?? "");
    $otp4 = trim($_POST["otp4"] ?? "");
    $otp5 = trim($_POST["otp5"] ?? "");
    $otp6 = trim($_POST["otp6"] ?? "");

    // Unir los dígitos en un solo código completo de 6 caracteres
    $codigo_ingresado = $otp1 . $otp2 . $otp3 . $otp4 . $otp5 . $otp6;

    // Validar que se hayan llenado todos los campos
    if (strlen($codigo_ingresado) < 6) {
        echo "<script>
                alert('Por favor completa todos los dígitos del código.');
                window.history.back();
              </script>";
        exit;
    }

    // Aquí puedes agregar tu lógica de validación (por ejemplo, compararlo con un código 
    // guardado previamente en la base de datos o en la sesión $_SESSION).
    // Por ahora, simularemos que la verificación es exitosa:

    // Redirigir al inicio de sesión o al panel de control una vez verificado
    header("Location: iniciar_s.php");
    exit;

} else {
    // Si intentan acceder directamente por la URL
    echo "<script>
            alert('Acceso no válido.');
            window.location.href = 'index.php';
          </script>";
    exit;
}
?>