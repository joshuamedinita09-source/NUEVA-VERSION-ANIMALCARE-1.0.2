<?php
require_once "conexion.php";
session_start();

if (!isset($_SESSION['id_dueno'])) {
    header("Location: iniciar_s.php");
    exit;
}

$id_dueno = $_SESSION['id_dueno'];

// Obtener las citas de las mascotas del dueño actual junto con el nombre de la mascota
$stmt_c = $pdo->prepare("
    SELECT c.fecha_hora, c.motivo, c.tipo_cita, m.nombre_m 
    FROM cita c
    INNER JOIN mascota m ON c.id_mascota = m.id_mascota
    INNER JOIN dueno_mascota dm ON m.id_mascota = dm.id_mascota
    WHERE dm.id_dueno = ?
");
$stmt_c->execute([$id_dueno]);
$mis_citas = $stmt_c->fetchAll(PDO::FETCH_ASSOC);

// Convertir las citas a formato JSON para que JavaScript pueda usarlas fácilmente
$citas_json = json_encode($mis_citas);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario de Salud - AnimalCare</title>
    <link rel="stylesheet" href="static/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="static/js/calendario.js?v=1.0.3" defer></script>
</head>
<body>

    <!-- Variable global en JS con las citas de la base de datos -->
    <script>
        const citasUsuario = <?= $citas_json; ?>;
        console.log("Citas cargadas en el calendario:", citasUsuario);
    </script>

    <header class="navbar">
        <div class="logo-container">
            <img src="static/img/image.png" alt="Logo AnimalCare" class="logo-img">
        </div>
        <nav class="nav-links">
            <a href="panel_de_control.php" class="nav-btn"><i class="fa-solid fa-house"></i> Inicio</a>
            <a href="calendario.php" class="nav-btn active"><i class="fa-regular fa-calendar"></i> Calendario</a>
            <a href="citas.php" class="nav-btn"><i class="fa-regular fa-clipboard"></i> Citas</a>
            <a href="logout.php" class="nav-btn logout"><i class="fa-solid fa-right-from-bracket"></i> Salir</a>
        </nav>
    </header>

    <main class="calendar-container">
        <div class="page-header">
            <h1>Calendario de Salud</h1>
            <a href="agendar_cita.php" class="btn-add-event">
                <i class="fa-solid fa-plus"></i> Agregar Evento
            </a>
        </div>

        <section class="calendar-card">
            <div class="month-navigation">
                <button class="nav-arrow">&lt;</button>
                <h2>Octubre</h2>
                <button class="nav-arrow">&gt;</button>
            </div>
            <div class="weekdays-grid">
                <span>Dom</span><span>Lun</span><span>Mar</span><span>Mié</span><span>Jue</span><span>Vie</span><span>Sáb</span>
            </div>
            <!-- Aquí el JavaScript de tu calendario se encargará de pintar los días y cruzar los datos de 'citasUsuario' -->
            <div class="days-grid">
                <div class="day-cell empty"></div>
                <div class="day-cell"><span>1</span></div>
                <div class="day-cell"><span>2</span></div>
                <div class="day-cell"><span>3</span></div>
                <div class="day-cell"><span>4</span></div>
                <div class="day-cell"><span>5</span></div>
                <div class="day-cell"><span>6</span></div>
                <div class="day-cell"><span>7</span></div>
            </div>
        </section>
    </main>

</body>
</html>