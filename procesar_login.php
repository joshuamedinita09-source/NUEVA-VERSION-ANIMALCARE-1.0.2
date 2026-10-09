<?php
require_once "conexion.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo = trim($_POST["email"] ?? "");
    $contrasena = $_POST["password"] ?? "";

    if (empty($correo) || empty($contrasena)) {
        echo "<script>
                alert('Por favor completa todos los campos.');
                window.history.back();
              </script>";
        exit;
    }

    try {
        // Buscar el usuario por su correo en la tabla dueno
        $stmt = $pdo->prepare("SELECT * FROM dueno WHERE correo_d = ?");
        $stmt->execute([$correo]);
        $usuario = $stmt->fetch();

        // Verificar si el usuario existe y si la contraseña coincide con el hash guardado
        if ($usuario && password_verify($contrasena, $usuario['contrasena_d'])) {
            
            // Guardar los datos del usuario en la sesión de PHP
            $_SESSION['id_dueno'] = $usuario['id_dueno'];
            $_SESSION['nombre_usuario'] = $usuario['nombre_d'];

            // Redirigir al panel de control real
            header("Location: panel_de_control.php");
            exit;

        } else {
            echo "<script>
                    alert('Correo o contraseña incorrectos.');
                    window.history.back();
                  </script>";
            exit;
        }

    } catch (PDOException $e) {
        echo "<script>
                alert('Error en el sistema: " . addslashes($e->getMessage()) . "');
                window.history.back();
              </script>";
        exit;
    }
} else {
    header("Location: iniciar_s.php");
    exit;
}
?>