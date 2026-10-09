<?php
session_start();
// Opcional: puedes validar aquí si hay un correo temporal en sesión para verificar
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Email - AnimalCare</title>
    <!-- CSS -->
    <link rel="stylesheet" href="static/css/style.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="static/js/verificacion.js" defer></script>
</head>

<body>

    <div class="verify-container">
        <div class="verify-card">

            <!-- ENCABEZADO -->
            <div class="card-header">
                <img src="static/img/image.png" alt="AnimalCare" class="logo-img">
                <h2>Verificación de Email</h2>
                <p class="subtitle">Verifica tu correo electrónico</p>
            </div>

            <!-- BARRA DE PROGRESO -->
            <div class="progress-section">
                <div class="progress-labels">
                    <span>Registro</span>
                    <span>Verificación</span>
                </div>
                <div class="progress-bar-bg">
                    <div class="progress-bar-fill"></div>
                </div>
            </div>

            <!-- ICONO DE EMAIL -->
            <div class="email-icon-container">
                <div class="email-icon-circle">
                    <i class="fa-solid fa-envelope"></i>
                </div>
            </div>

            <!-- MENSAJE -->
            <div class="verify-message">
                <h3>Revisa tu correo</h3>
                <p>
                    Hemos enviado un código de verificación a tu correo electrónico. 
                    Ingresa el código de 6 dígitos para verificar tu cuenta de AnimalCare.
                </p>
            </div>

            <!-- CÓDIGO OTP -->
            <form id="formVerificacion" action="procesar_verificacion.php" method="POST">
                <div class="otp-container">
                    <input type="text" class="otp-input" name="otp1" maxlength="1" inputmode="numeric" autocomplete="one-time-code" id="otp1" required>
                    <input type="text" class="otp-input" name="otp2" maxlength="1" inputmode="numeric" id="otp2" required>
                    <input type="text" class="otp-input" name="otp3" maxlength="1" inputmode="numeric" id="otp3" required>
                    <input type="text" class="otp-input" name="otp4" maxlength="1" inputmode="numeric" id="otp4" required>
                    <input type="text" class="otp-input" name="otp5" maxlength="1" inputmode="numeric" id="otp5" required>
                    <input type="text" class="otp-input" name="otp6" maxlength="1" inputmode="numeric" id="otp6" required>
                </div>

                <!-- REENVIAR CÓDIGO -->
                <div class="resend-link">
                    <a href="#" id="reenviarCodigo">¿No recibiste el código? Reenviar</a>
                </div>

                <!-- BOTÓN -->
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-circle-check"></i>
                    Verificar correo
                </button>
            </form>

            <!-- FOOTER -->
            <div class="card-footer">
                ¿Ya verificaste tu correo? <a href="iniciar_s.php">Iniciar sesión</a>
            </div>

            <!-- VOLVER AL INICIO -->
            <div class="back-home">
                <a href="index.php">
                    <i class="fa-solid fa-arrow-left"></i>
                    Volver al inicio
                </a>
            </div>

        </div>
    </div>

</body>
</html>