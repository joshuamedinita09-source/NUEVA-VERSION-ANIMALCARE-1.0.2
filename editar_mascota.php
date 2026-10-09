<?php
require_once "conexion.php";
session_start();

if (!isset($_SESSION['id_dueno'])) {
    header("Location: iniciar_s.php");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID inválido.");
}
$id_mascota = (int) $_GET['id'];
$id_dueno = $_SESSION['id_dueno'];

// Verificar que la mascota pertenezca al dueño actual mediante la tabla intermedia
$sql = "SELECT m.* FROM mascota m 
        INNER JOIN dueno_mascota dm ON m.id_mascota = dm.id_mascota 
        WHERE m.id_mascota = :id_mascota AND dm.id_dueno = :id_dueno";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_mascota' => $id_mascota, ':id_dueno' => $id_dueno]);
$mascota = $stmt->fetch();

if (!$mascota) {
    die("La mascota no existe o no tienes permisos para editarla.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Mascota - AnimalCare</title>
    <link rel="stylesheet" href="static/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <main class="register-container">
        <div class="register-card" style="max-width: 500px;">
            <div class="card-header">
                <h2>Editar Mascota</h2>
                <p class="subtitle">Actualiza los datos de tu mascota</p>
            </div>

            <form action="actualizar_mascota.php" method="POST">
                <input type="hidden" name="id_mascota" value="<?= htmlspecialchars($mascota['id_mascota']) ?>">

                <div class="input-group">
                    <label for="nombre_m">Nombre</label>
                    <div class="input-field">
                        <i class="fa-solid fa-paw"></i>
                        <input type="text" id="nombre_m" name="nombre_m" value="<?= htmlspecialchars($mascota['nombre_m']) ?>" required>
                    </div>
                </div>

                <div class="input-group">
                    <label for="raza">Raza</label>
                    <div class="input-field">
                        <i class="fa-solid fa-dog"></i>
                        <input type="text" id="raza" name="raza" value="<?= htmlspecialchars($mascota['raza']) ?>" required>
                    </div>
                </div>

                <div class="input-group">
                    <label for="edad">Edad (años)</label>
                    <div class="input-field">
                        <i class="fa-solid fa-calendar"></i>
                        <input type="number" id="edad" name="edad" value="<?= htmlspecialchars($mascota['edad']) ?>" required>
                    </div>
                </div>

                <div class="input-group">
                    <label for="peso">Peso (kg)</label>
                    <div class="input-field">
                        <i class="fa-solid fa-weight-scale"></i>
                        <input type="text" id="peso" name="peso" value="<?= htmlspecialchars($mascota['peso']) ?>" required>
                    </div>
                </div>

                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <button type="submit" class="btn-submit">Actualizar</button>
                    <a href="panel_de_control.php" class="btn-action secondary" style="display: flex; align-items: center; justify-content: center; text-decoration: none;">Cancelar</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>