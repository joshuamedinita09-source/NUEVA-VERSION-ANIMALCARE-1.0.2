<?php
session_start();

// Si no hay sesión iniciada como veterinario, lo mandamos al login
if (!isset($_SESSION['id_veterinario'])) {
    header("Location: login_vet.php");
    exit;
}

$id_veterinario_actual = $_SESSION['id_veterinario'];
$nombre_veterinario = $_SESSION['nombre_v'];

require_once 'conexion.php';

// Consultamos las citas asignadas a este veterinario usando 'm.raza' correctamente
$sql = "SELECT c.*, m.nombre_m, m.raza, m.edad, m.sexo
        FROM cita c 
        JOIN mascota m ON c.id_mascota = m.id_mascota 
        WHERE c.id_veterinario = ?
        ORDER BY c.fecha_hora ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_veterinario_actual]);
$citas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?> 

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del Veterinario - AnimalCare</title>
    <link rel="stylesheet" href="static/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

    <!-- NAVBAR SUPERIOR -->
    <header class="navbar">
        <div class="logo-container">
            <img src="static/img/image.png" alt="Logo AnimalCare" class="logo-img">
        </div>
        <nav class="nav-links">
            <a href="panel_veterinario.php" class="nav-btn active"><i class="fa-solid fa-house"></i> Panel</a>
            <a href="logout.php" class="nav-btn logout"><i class="fa-solid fa-right-from-bracket"></i> Salir</a>
        </nav>
    </header>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="dashboard-container">
        
        <!-- BANNER DE BIENVENIDA -->
        <div class="welcome-banner">
            <h1>Bienvenido, Dr(a). <?= htmlspecialchars($nombre_veterinario); ?></h1>
            <p>Aquí puedes gestionar y visualizar las citas programadas por tus pacientes.</p>
        </div>

        <!-- SECCIÓN DE CITAS ENTRANTES -->
        <section class="section-block">
            <div class="section-header">
                <h2 class="section-title"><i class="fa-regular fa-clipboard"></i> Tus Próximas Citas</h2>
            </div>

            <div class="upcoming-grid">
                <?php if (count($citas) > 0): ?>
                    <?php foreach ($citas as $cita): ?>
                        <?php 
                            // Obtenemos el estado de la cita de forma individual dentro del foreach
                            $estado_cita = $cita['estado'] ?? 'Pendiente';
                            $es_realizada = (strcasecmp($estado_cita, 'Realizada') === 0);
                        ?>
                        <div class="appointment-card blue-theme">
                            <div class="card-header">
                                <div class="pet-profile">
                                    <div>
                                        <h3><?= htmlspecialchars($cita['motivo']) ?></h3>
                                        <span class="pet-name">Mascota: <?= htmlspecialchars($cita['nombre_m']) ?></span>
                                    </div>
                                </div>
                                <span class="status-badge <?= $es_realizada ? 'green' : 'orange' ?>" style="<?= $es_realizada ? '' : 'background: #fff3cd; color: #856404;' ?>">
                                    <i class="fa-solid <?= $es_realizada ? 'fa-check' : 'fa-clock' ?>"></i> <?= htmlspecialchars($estado_cita) ?>
                                </span> 
                            </div>
                            
                            <div class="card-body">
                                <div class="detail-row">
                                    <i class="fa-regular fa-calendar blue-icon"></i> 
                                    <strong>Fecha y Hora:</strong> <?= htmlspecialchars($cita['fecha_hora']) ?>
                                </div>
                                <div class="detail-row">
                                    <i class="fa-solid fa-paw blue-icon"></i> 
                                    <strong>Raza:</strong> <?= htmlspecialchars($cita['raza'] ?? 'No especificada') ?>
                                </div>
                                <div class="detail-row">
                                    <i class="fa-solid fa-tag blue-icon"></i> 
                                    <strong>Tipo de Cita:</strong> <?= htmlspecialchars($cita['tipo_cita'] ?? 'Control') ?>
                                </div>
                            </div>
                            <div class="card-actions" style="margin-top: 15px; display: flex; gap: 8px;">
                                <a href="reagendar_cita.php?id_cita=<?= $cita['id_cita'] ?>" class="btn-action secondary" style="text-decoration: none; padding: 8px;">
                                    <i class="fa-regular fa-calendar-days"></i> Reagendar
                                </a>
                                <!-- Aquí ya viaja correctamente el id_cita y el id_mascota -->
                                <a href="crear_diagnostico.php?id_mascota=<?= $cita['id_mascota'] ?>&id_cita=<?= $cita['id_cita'] ?>" class="btn-action primary" style="text-decoration: none; padding: 8px; background: #388e3c; color: white;">
                                    <i class="fa-solid fa-notes-medical"></i> Atender / Diagnóstico
                                </a>    
                            </div> 
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div style="grid-column: 1/-1; background: white; padding: 30px; border-radius: 16px; text-align: center; color: #666; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                        <i class="fa-regular fa-calendar-xmark" style="font-size: 32px; color: #ccc; margin-bottom: 10px;"></i>
                        <p>No tienes citas asignadas por el momento.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>

    </main>

</body>
</html>