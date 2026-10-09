<?php
session_start();
// Si el usuario ya inició sesión, lo mandamos directo al panel de control
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
    <title>AnimalCare</title>
    <link rel="stylesheet" href="static/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="static/js/crear_c.js" defer></script>
</head>
<body>

    <!-- ENCABEZADO -->
    <header>
        <div class="logo">
            <img src="static/img/image.png" alt="Logo">
        </div>

        <h1>Bienvenido a <span>Animal</span><strong>Care</strong></h1>
        <h3>Cuidamos a tu mascota</h3>

        <p class="descripcion">
            La plataforma completa para gestionar la salud y bienestar de tus mascotas
        </p>

        <div class="botones">
            <a href="crear_c.php" class="btn-crear">Crear cuenta</a>
            <a href="iniciar_s.php" class="btn-iniciar">Iniciar Sesión</a>
        </div>
    </header>

    <!-- SERVICIOS -->
    <main>
        <section class="servicios">
            <h2>¿Qué puedes hacer con Animal Care?</h2>
            <p>Todo lo que necesitas para cuidar mejor a tu mascota</p>

            <div class="tarjetas">
                <div class="tarjeta">
                    <div class="icono azul"><i class="fa-solid fa-calendar"></i></div>
                    <h3>Calendario de Salud</h3>
                    <p>Mantén el control de vacunas, desparasitación y chequeos médicos</p>
                </div>

                <div class="tarjeta">
                    <div class="icono rosado"><i class="fa-solid fa-notes-medical"></i></div>
                    <h3>Historial Médico</h3>
                    <p>Accede al historial médico de tu mascota en cualquier momento</p>
                </div>

                <div class="tarjeta">
                    <div class="icono morado"><i class="fa-solid fa-heart"></i></div>
                    <h3>Alimentación Personalizada</h3>
                    <p>Recibe recomendaciones de nutrición según la raza y edad</p>
                </div>

                <div class="tarjeta">
                    <div class="icono verde"><i class="fa-solid fa-shield-heart"></i></div>
                    <h3>Cuidados Específicos</h3>
                    <p>Consejos personalizados para el cuidado de tu mascota</p>
                </div>

                <div class="tarjeta">
                    <div class="icono amarillo"><i class="fa-solid fa-clock"></i></div>
                    <h3>Recordatorios</h3>
                    <p>Nunca olvides una cita o medicamento importante</p>
                </div>

                <div class="tarjeta">
                    <div class="icono naranja"><i class="fa-solid fa-paw"></i></div>
                    <h3>Perfil de Mascota</h3>
                    <p>Crea perfiles completos para todas tus mascotas</p>
                </div>
            </div>
        </section>
    </main>

    <!-- CTA -->
    <section class="comenzar">
        <h2>¿Listo para comenzar?</h2>
        <p>Únete a miles de dueños que ya confían en Animal Care para el cuidado de sus mascotas</p><br>
        <a href="crear_c.php" class="btn-iniciar">Comenzar ahora</a>
    </section>

    <!-- FOOTER -->
    <footer>
        <p>© 2026 Animal Care. Todos los derechos reservados.</p>
        <p>Cuidamos a tu mascota</p>
    </footer>

</body>
</html>