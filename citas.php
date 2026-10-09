<?php
require_once "conexion.php";
session_start();

if (!isset($_SESSION['id_dueno'])) {
    header("Location: iniciar_s.php");
    exit;
}

$id_dueno = $_SESSION['id_dueno'];
$nombre_usuario = $_SESSION['nombre_usuario'] ?? 'Usuario';

// Obtener las mascotas del dueño actual para los filtros[cite: 4]
$stmt_m = $pdo->prepare("
    SELECT m.* 
    FROM mascota m 
    INNER JOIN dueno_mascota dm ON m.id_mascota = dm.id_mascota 
    WHERE dm.id_dueno = ?
");
$stmt_m->execute([$id_dueno]);
$mis_mascotas = $stmt_m->fetchAll();

// 1. MODIFICACIÓN: Añadimos v.nombre_v y v.apellido_v haciendo un LEFT JOIN con la tabla veterinario
$stmt_c = $pdo->prepare("
    SELECT c.*, m.nombre_m, v.nombre_v, v.apellido_v 
    FROM cita c
    INNER JOIN mascota m ON c.id_mascota = m.id_mascota
    INNER JOIN dueno_mascota dm ON m.id_mascota = dm.id_mascota
    LEFT JOIN veterinario v ON c.id_veterinario = v.id_veterinario
    WHERE dm.id_dueno = ?
");
$stmt_c->execute([$id_dueno]);
$mis_citas = $stmt_c->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamiento de Citas - AnimalCare</title>
    <link rel="stylesheet" href="static/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="static/js/citas.js ?v=1.0.1"></script>
</head>
<body>

    <!-- NAVBAR -->
    <header class="navbar">
        <div class="logo-container">
            <img src="static/img/image.png" alt="Logo AnimalCare" class="logo-img">
        </div>
        <nav class="nav-links">
            <a href="panel_de_control.php" class="nav-btn"><i class="fa-solid fa-house"></i> Inicio</a>
            <a href="calendario.php" class="nav-btn"><i class="fa-regular fa-calendar"></i> Calendario</a>
            <a href="citas.php" class="nav-btn active"><i class="fa-regular fa-clipboard"></i> Citas</a>
            <a href="logout.php" class="nav-btn logout"><i class="fa-solid fa-right-from-bracket"></i> Salir</a>
        </nav>
    </header>

    <main class="appointments-container">
        <div class="page-header">
            <div>
                <h1>Agendamiento de Citas</h1>
                <p class="subtitle">Gestiona las citas de tus mascotas</p>
            </div>
            <a href="agendar_cita.php" class="btn-schedule"><i class="fa-regular fa-calendar-plus"></i> Agendar Cita</a>
        </div>

        <!-- PRÓXIMAS CITAS -->
        <section class="section-block">
            <h2 class="section-title">Próximas Citas</h2>
            <div class="upcoming-grid">
                <?php if (count($mis_citas) > 0): ?>
                    <?php foreach ($mis_citas as $cita): ?>
                        <div class="appointment-card blue-theme">
                            <div class="card-header">
                                <div class="pet-profile">
                                    <div>
                                        <h3><?= htmlspecialchars($cita['motivo']) ?></h3>
                                        <span class="pet-name">Mascota: <?= htmlspecialchars($cita['nombre_m']) ?></span>
                                    </div>
                                </div>
                                <span class="status-badge green"><i class="fa-solid fa-check"></i> <?= htmlspecialchars($cita['estado'] ?? 'Confirmada') ?></span>
                                <div class="card-actions" style="margin-top: 10px;">
                                    <a href="reagendar_cita.php?id_cita=<?= $cita['id_cita'] ?>" class="btn-action" style="padding: 6px 12px; background: #0080ff; color: #fff; text-decoration: none; border-radius: 4px; font-size: 13px;">
                                        <i class="fa-regular fa-calendar-days"></i> Reagendar
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="detail-row"><i class="fa-regular fa-calendar"></i> Fecha: <?= htmlspecialchars($cita['fecha_hora']) ?></div>
                                <!-- 2. MODIFICACIÓN: Mostramos el nombre del veterinario asignado -->
                                <div class="detail-row" style="margin-top: 5px;">
                                    <i class="fa-solid fa-user-doctor"></i> Veterinario: 
                                    <?= !empty($cita['nombre_v']) ? 'Dr(a). ' . htmlspecialchars($cita['nombre_v'] . ' ' . $cita['apellido_v']) : 'No asignado' ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="grid-column: 1/-1; text-align: center; color: #666;">No tienes citas programadas por ahora.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>

</body>
</html>