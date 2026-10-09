<?php
require_once "conexion.php";
session_start();

// 1. Verificar sesión activa
if (!isset($_SESSION['id_dueno'])) {
    header("Location: iniciar_s.php");
    exit;
}

$id_dueno = $_SESSION['id_dueno'];
$id_mascota = $_GET['id'] ?? null;

if (!$id_mascota || !is_numeric($id_mascota)) {
    die("ID de mascota inválido.");
}

// 2. Verificar que la mascota pertenezca al dueño (seguridad)
$stmt_check = $pdo->prepare("
    SELECT m.* 
    FROM mascota m 
    INNER JOIN dueno_mascota dm ON m.id_mascota = dm.id_mascota 
    WHERE m.id_mascota = ? AND dm.id_dueno = ?
");
$stmt_check->execute([$id_mascota, $id_dueno]);
$mascota = $stmt_check->fetch();

if (!$mascota) {
    die("No tienes permisos para ver el historial de esta mascota o la mascota no existe.");
}

// 3. Obtener el historial clínico y sus diagnósticos relacionados
$stmt_historial = $pdo->prepare("
    SELECT h.*, d.* 
    FROM historial_clinico h 
    LEFT JOIN diagnostico d ON h.id_historial = d.id_historial 
    WHERE h.id_mascota = ? 
    ORDER BY h.fecha_h DESC
");
$stmt_historial->execute([$id_mascota]);
$registros = $stmt_historial->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial Clínico - <?= htmlspecialchars($mascota['nombre_m']) ?></title>
    <link rel="stylesheet" href="static/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

    <!-- NAVEGACIÓN SUPERIOR -->
    <header class="navbar">
        <div class="logo-container">
            <img src="static/img/image.png" alt="Logo AnimalCare" class="logo-img">
        </div>
        <nav class="nav-links">
            <a href="panel_de_control.php" class="nav-btn"><i class="fa-solid fa-house"></i> Inicio</a>
            <a href="calendario.php" class="nav-btn"><i class="fa-regular fa-calendar"></i> Calendario</a>
            <a href="citas.php" class="nav-btn"><i class="fa-regular fa-clipboard"></i> Citas</a>
            <a href="logout.php" class="nav-btn logout"><i class="fa-solid fa-right-from-bracket"></i> Salir</a>
        </nav>
    </header>

    <main class="dashboard-container">
        
        <!-- ENCABEZADO DE LA MASCOTA -->
        <section class="welcome-banner" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
            <div>
                <h1>Historial Clínico de <?= htmlspecialchars($mascota['nombre_m']) ?></h1>
                <p>Raza: <?= htmlspecialchars($mascota['raza']) ?> • Edad: <?= htmlspecialchars($mascota['edad']) ?> años • Peso: <?= htmlspecialchars($mascota['peso']) ?> kg</p>
            </div> 
            <a href="panel_de_control.php" style="background: white; color: #0080ff; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-flex; align-items: center; gap: 8px; width: auto; flex-shrink: 0; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <i class="fa-solid fa-arrow-left"></i> Volver
            </a>
        </section>

        <!-- LISTA DE HISTORIALES -->
        <section class="section-block">
            <div class="section-header">
                <h2 class="section-title">Registros Médicos</h2>
            </div>

            <div class="pets-grid" style="grid-template-columns: 1fr;">
                <?php if (count($registros) > 0): ?>
                    <?php foreach ($registros as $reg): ?>
                        <div class="pet-card" style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 15px;">
                            <div style="border-bottom: 2px solid #f0f0f0; padding-bottom: 10px; margin-bottom: 15px; display: flex; justify-content: space-between;">
                                <span style="font-weight: bold; color: #0080ff;"><i class="fa-regular fa-calendar"></i> Fecha: <?= htmlspecialchars($reg['fecha_h']) ?></span>
                                <span style="background: #e6f2ff; color: #0080ff; padding: 4px 10px; border-radius: 20px; font-size: 0.9rem;">Estado: <?= htmlspecialchars($reg['estado_mascota'] ?? 'No especificado') ?></span>
                            </div>
                            
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                                <div>
                                    <p><strong>Observaciones:</strong> <?= htmlspecialchars($reg['observaciones'] ?? 'Ninguna') ?></p>
                                    <p><strong>Medicamentos:</strong> <?= htmlspecialchars($reg['medicamentos'] ?? 'Ninguno') ?></p>
                                    <p><strong>Dosis:</strong> <?= htmlspecialchars($reg['dosis'] ?? 'N/A') ?></p>
                                </div>
                                <div>
                                    <p><strong>Cuidados:</strong> <?= htmlspecialchars($reg['cuidados'] ?? 'Ninguno') ?></p>
                                    <p><strong>Alimentación:</strong> <?= htmlspecialchars($reg['alimentacion'] ?? 'Normal') ?></p>
                                    <p><strong>Recomendaciones:</strong> <?= htmlspecialchars($reg['recomendaciones'] ?? 'Ninguna') ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align: center; color: #666; padding: 30px;">Aún no hay registros en el historial clínico para esta mascota.</p>
                <?php endif; ?>
            </div>
        </section>

    </main>

</body>
</html>