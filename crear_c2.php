<?php
require "conexion.php";

// Verificar que el formulario fue enviado por método POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Recibir y limpiar los datos del formulario (coinciden con los name de crear_c.html)
    $nombre     = trim($_POST["nombre"] ?? "");
    $apellido   = trim($_POST["apellido"] ?? "");
    $correo     = trim($_POST["email"] ?? "");
    $telefono   = trim($_POST["telefono"] ?? "");
    $direccion  = trim($_POST["direccion"] ?? "");
    $contrasena = $_POST["password"] ?? "";
    $confirmar  = $_POST["confirmPassword"] ?? "";

    // Validar que no haya campos vacíos
    if (
        empty($nombre) ||
        empty($apellido) ||
        empty($correo) ||
        empty($telefono) ||
        empty($direccion) ||
        empty($contrasena) ||
        empty($confirmar)
    ) {
        echo "<script>
                alert('Por favor completa todos los campos.');
                window.history.back();
              </script>";
        exit;
    }

    // Verificar que las contraseñas coincidan
    if ($contrasena !== $confirmar) {
        echo "<script>
                alert('Las contraseñas no coinciden.');
                window.history.back();
              </script>";
        exit;
    }

    try {
        // Verificar si el correo ya se encuentra registrado en la base de datos (usando $pdo)
        $consulta = $pdo->prepare("SELECT id_dueno FROM dueno WHERE correo_d = ?");
        $consulta->execute([$correo]);

        if ($consulta->fetch()) {
            echo "<script>
                    alert('Este correo electrónico ya está registrado.');
                    window.history.back();
                  </script>";
            exit;
        }

        // Encriptar la contraseña de forma segura
        $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

        // Insertar los datos en la tabla dueno usando consultas preparadas
        $sql = "INSERT INTO dueno (nombre_d, apellido_d, telefono_d, correo_d, contrasena_d, direccion_d) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $insertar = $pdo->prepare($sql);
        $insertar->execute([
            $nombre,
            $apellido,
            $telefono,
            $correo,
            $contrasena_hash,
            $direccion
        ]);

        // Redirigir a la pantalla de verificación de correo que tienes en tus HTMLs
        header("Location: verificacion.php");
        exit;

    } catch (PDOException $e) {
        echo "<script>
                alert('Error al registrar en la base de datos: " . addslashes($e->getMessage()) . "');
                window.history.back();
              </script>";
        exit;
    }

} else {
    // Si intentan ingresar directamente por la URL del navegador
    echo "<script>
            alert('Acceso no válido.');
            window.history.back();
          </script>";
    exit;
}
?>