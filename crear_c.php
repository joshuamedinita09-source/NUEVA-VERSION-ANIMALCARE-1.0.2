<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta - AnimalCare</title>
    <!-- Rutas corregidas sin "../" -->
    <link rel="stylesheet" href="static/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="static/js/crear_c.js" defer></script>
</head>
<body>

    <main class="register-container">
        <div class="register-card">
            <div class="card-header">
                <!-- Ruta de imagen corregida sin "../" -->
                <img src="static/img/image.png" alt="Logo AnimalCare" class="logo-img">
                <h2>Crear Cuenta</h2>
                <p class="subtitle">Paso 1: Datos Personales</p>
            </div>

            <!-- Apunta directamente a tu archivo procesador crear_c2.php -->
            <form action="crear_c2.php" method="POST" onsubmit="validarRegistro(event)">         
                <div class="input-group">
                    <label for="nombre">Nombre</label>
                    <div class="input-field">
                        <i class="fa-regular fa-user"></i>
                        <input type="text" id="nombre" name="nombre" placeholder="Juan" required>
                    </div>
                </div>

                <div class="input-group">
                    <label for="apellido">Apellido</label>
                    <div class="input-field">
                        <i class="fa-regular fa-user"></i>
                        <input type="text" id="apellido" name="apellido" placeholder="Perez" required>
                    </div>
                </div>

                <div class="input-group">
                    <label for="email">Correo Electrónico</label>
                    <div class="input-field">
                        <i class="fa-regular fa-envelope"></i>
                        <input type="email" id="email" name="email" placeholder="tu@email.com" required>
                    </div>
                </div>

                <div class="input-group">
                    <label for="telefono">Teléfono</label>
                    <div class="input-field">
                        <i class="fa-solid fa-phone"></i>
                        <input type="tel" id="telefono" name="telefono" placeholder="+57 123 456 7890" required>
                    </div>
                </div>

                <div class="input-group">
                    <label for="direccion">Dirección</label>
                    <div class="input-field">
                        <i class="fa-solid fa-location-dot"></i>
                        <input type="text" id="direccion" name="direccion" placeholder="Ej: Calle 123" required>
                    </div>
                </div>

                <div class="input-group">
                    <label for="password">Contraseña</label>
                    <div class="input-field">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                    </div>
                </div>

                <div class="input-group">
                    <label for="confirm-password">Confirmar contraseña</label>
                    <div class="input-field">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="confirm-password" name="confirmPassword" placeholder="••••••••" required>
                    </div>
                </div>

                 <div class="Form-link" style="margin-bottom: 15px; text-align: right;">
    <a href="register_vet.php" style="font-size: 14px; color: #0080ff; text-decoration: none;">¿Eres veterinari@?</a>
</div>

                <button type="submit" class="btn-submit">
                    Continuar <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>

            <div class="card-footer">
                <p>¿Ya tienes una cuenta? <a href="iniciar_s.php">Inicia sesión</a></p>
            </div>
        </div>
    </main>

</body>
</html>