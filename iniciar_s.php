<?php
session_start();
// Si ya inició sesión, redirigir directo al panel
if (isset($_SESSION['id_dueno'])) {
    header("Location: panel_de_control.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - AnimalCare</title>
    <link rel="stylesheet" href="static/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="static/js/iniciar_s.js?v=999" defer></script>
</head>
<body>

    <main class="login-container">
        <div class="login-card">
            <div class="card-header">
                <img src="static/img/image.png" alt="Logo AnimalCare" class="logo-img">
                <h2>Iniciar Sesión</h2>
            </div>

            <!-- El   formulario apunta al archivo PHP que procesa el login -->
            <form id="login-Form" class="login-Form" action="procesar_login.php" method="POST">
                <div class="input-group">
                    <label for="email">Correo Electrónico</label>
                    <div class="input-field">
                        <i class="fa-regular fa-envelope"></i>
                        <input type="email" id="email" name="email" placeholder="tu@email.com" required>
                    </div>
                </div>

                <div class="input-group">
                    <label for="password">Contraseña</label>
                    <div class="input-field">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    Iniciar Sesion <i class="fa-solid fa-arrow-right"></i>
                </button>
                <div class="forgot-link" style="margin-bottom: 15px; text-align: right;">
    <a href="#" style="font-size: 14px; color: #0080ff; text-decoration: none;">¿Olvidaste tu contraseña?</a>
</div>
 <div class="Form-link" style="margin-bottom: 15px; text-align: right;">
    <a href="login_vet.php" style="font-size: 14px; color: #0080ff; text-decoration: none;">¿Eres veterinari@?</a>
</div>
            </form>

            <div class="card-footer">
                <p>¿No tienes una cuenta? <a href="crear_c.php">Regístrate aquí</a></p>
            </div>
        </div>
    </main>

</body>
</html>