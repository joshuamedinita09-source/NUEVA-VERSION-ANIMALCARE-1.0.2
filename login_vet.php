<?php
session_start();
if (isset($_SESSION['id_veterinario'])) {
    header("Location: panel_veterinario.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Veterinarios - AnimalCare</title>
    <link rel="stylesheet" href="static/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- 1. Incluir SweetAlert2 CSS y JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="auth-body">

    <div class="login-container">
        <div class="login-card">
            <div class="card-header">
                <div class="logo-container" style="justify-content: center; margin-bottom: 15px;">
                    <img src="static/img/image.png" alt="Logo AnimalCare" class="logo-img" style="max-width: 80px; border-radius: 50%;">
                </div>
                <h2>Portal Veterinarios</h2>
                <p class="subtitle">Ingresa tus credenciales para gestionar citas</p>
            </div>

            <!-- Este formulario envía los datos a tu archivo procesar_login_vet.php -->
            <form action="procesar_login_vet.php" method="POST">
                <div class="input-group">
                    <label for="correo">Correo electrónico</label>
                    <div class="input-field">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" id="correo" name="correo" required placeholder="ejemplo@animalcare.com">
                    </div>
                </div>

                <div class="input-group" style="margin-bottom: 25px;">
                    <label for="password">Contraseña</label>
                    <div class="input-field">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="password" name="password" required placeholder="********">
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-right-to-bracket"></i> Iniciar Sesión
                </button>
            </form>

            <div class="card-footer" style="margin-top: 25px;">
                <a href="iniciar_s.php" style="color: #666; font-weight: normal;">&larr; Volver al inicio de sesión de dueños</a>
            </div>
        </div>
    </div>

    <!-- 2. Script para mostrar SweetAlert si hay un error -->
    <?php if (isset($_GET['error'])): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: '¡Oops!',
            text: 'Correo o contraseña incorrectos.',
            confirmButtonColor: '#0080ff'
        });
    </script>
    <?php endif; ?>

</body>
</html>