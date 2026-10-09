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
    <title>Registro Veterinarios - AnimalCare</title>
    <link rel="stylesheet" href="static/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Incluir SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="auth-body">

    <div class="login-container">
        <div class="login-card" style="max-width: 480px;">
            <div class="card-header">
                <div class="logo-container" style="justify-content: center; margin-bottom: 15px;">
                    <img src="static/img/image.png" alt="Logo AnimalCare" class="logo-img" style="max-width: 70px; border-radius: 50%;">
                </div>
                <h2>Registro de Veterinarios</h2>
                <p class="subtitle">Únete a AnimalCare para gestionar tus citas médicas</p>
            </div>

            <form action="procesar_register_vet.php" method="POST">
                <div style="display: flex; gap: 12px;">
                    <div class="input-group" style="flex: 1;">
                        <label for="nombre_v">Nombre</label>
                        <div class="input-field">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" id="nombre_v" name="nombre_v" required placeholder="Tu nombre">
                        </div>
                    </div>
                    <div class="input-group" style="flex: 1;">
                        <label for="apellido_v">Apellido</label>
                        <div class="input-field">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" id="apellido_v" name="apellido_v" required placeholder="Tu apellido">
                        </div>
                    </div>
                </div>

                <div class="input-group">
                    <label for="especialidad">Especialidad</label>
                    <div class="input-field">
                        <i class="fa-solid fa-stethoscope"></i>
                        <input type="text" id="especialidad" name="especialidad" placeholder="Ej. Medicina General, Cirugía...">
                    </div>
                </div>

                <div class="input-group">
                    <label for="redes_vta">Redes o Contacto</label>
                    <div class="input-field">
                        <i class="fa-solid fa-share-nodes"></i>
                        <input type="text" id="redes_vta" name="redes_vta" placeholder="@tuusuario">
                    </div>
                </div>

                <div class="input-group">
                    <label for="correo">Correo electrónico</label>
                    <div class="input-field">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" id="correo" name="correo" required placeholder="correo@animalcare.com">
                    </div>
                </div>

                <div class="input-group" style="margin-bottom: 25px;">
                    <label for="password">Contraseña</label>
                    <div class="input-field">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="password" name="password" required placeholder="Mínimo 6 caracteres">
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-user-plus"></i> Registrarse
                </button>
            </form>

            <div class="card-footer">
                <a href="login_vet.php">¿Ya tienes cuenta? Inicia sesión aquí</a>
            </div>
        </div>
    </div>

    <!-- Script para alertas SweetAlert -->
    <?php if (isset($_GET['error'])): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error de Registro',
            text: '<?= htmlspecialchars($_GET['error']); ?>',
            confirmButtonColor: '#0080ff'
        });
    </script>
    <?php endif; ?>

</body>
</html>