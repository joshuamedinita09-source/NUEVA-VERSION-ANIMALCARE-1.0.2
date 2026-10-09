<?php
// 1. Incluir la conexión a la base de datos y arrancar la sesión
require_once "conexion.php"; // O el nombre del archivo donde tengas tu conexión PDO
session_start();

// 2. Verificar que el dueño haya iniciado sesión, si no, mandarlo al login
if (!isset($_SESSION['id_dueno'])) {
    header("Location: iniciar_s.php");
    exit;
}

$id_dueno = $_SESSION['id_dueno'];
$nombre_usuario = $_SESSION['nombre_usuario'] ?? 'Usuario';

// 3. CONSULTA CON EL JOIN A LA TABLA INTERMEDIA
$stmt = $pdo->prepare("
    SELECT m.* 
    FROM mascota m 
    INNER JOIN dueno_mascota dm ON m.id_mascota = dm.id_mascota 
    WHERE dm.id_dueno = ?
");
$stmt->execute([$id_dueno]);
$mis_mascotas = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control - AnimalCare</title>
    <link rel="stylesheet" href="static/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="static/js/panel_de_control.js" defer></script>
</head>
<body>

    <!-- NAVEGACIÓN SUPERIOR -->
    <header class="navbar">
        <div class="logo-container">
            <img src="static/img/image.png" alt="Logo AnimalCare" class="logo-img">
        </div>
        <nav class="nav-links">
            <a href="panel_de_control.php" class="nav-btn active"><i class="fa-solid fa-house"></i> Inicio</a>
            <a href="calendario.php" class="nav-btn"><i class="fa-regular fa-calendar"></i> Calendario</a>
            <a href="citas.php" class="nav-btn"><i class="fa-regular fa-clipboard"></i> Citas</a>
            <a href="logout.php" class="nav-btn logout">
                <i class="fa-solid fa-right-from-bracket"></i> Salir
            </a>
        </nav>
    </header>

    <main class="dashboard-container">
        
        <!-- BANNER BIENVENIDA -->
        <section class="welcome-banner">
            <h1>¡HOLA, <?= htmlspecialchars($nombre_usuario) ?>!</h1>
            <p>Bienvenido a tu panel de control</p>
        </section>

        <!-- MIS MASCOTAS -->
        <section class="section-block">
            <div class="section-header">
                <h2 class="section-title">Mis mascotas</h2>
                <a href="agregar_mascota.php" class="btn-add-pet"><i class="fa-solid fa-plus"></i> Agregar Mascota</a>
            </div>

            <div class="pets-grid">
                <?php if (count($mis_mascotas) > 0): ?>
                    <?php foreach ($mis_mascotas as $mascota): ?>
                        <!-- Bucle dinámico para mostrar cada mascota real del dueño -->
                        <div class="pet-card">
                            <div class="pet-card-header blue-bg">
                                <div class="pet-info">
                                    <h3><?= htmlspecialchars($mascota['nombre_m']) ?></h3>
                                    <p class="breed"><?= htmlspecialchars($mascota['raza']) ?></p>
                                    <p class="species">Edad: <?= htmlspecialchars($mascota['edad']) ?> años • Peso: <?= htmlspecialchars($mascota['peso']) ?> kg</p>
                                </div>
                            </div>
                            <div class="pet-card-body">
                                <div class="pet-actions">
                                    <a href="historial.php?id=<?= $mascota['id_mascota'] ?>" class="pet-btn pink"><i class="fa-regular fa-file-lines"></i> Historial</a>
                                    <a href="citas.php?id=<?= $mascota['id_mascota'] ?>" class="pet-btn green"><i class="fa-regular fa-calendar"></i> Citas</a>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="grid-column: 1 / -1; text-align: center; color: #666;">Aún no tienes mascotas registradas. ¡Agrega una para comenzar!</p>
                <?php endif; ?>
            </div>
        </section>

    </main>

</body>
</html>