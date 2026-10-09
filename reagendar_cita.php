<?php
require_once "conexion.php";
session_start();

// Validar que haya sesión de dueño o veterinario según quién tenga permitido reagendar
if (!isset($_SESSION['id_dueno']) && !isset($_SESSION['id_veterinario'])) {
    header("Location: iniciar_s.php");
    exit;
}

$id_cita = $_GET['id_cita'] ?? $_POST['id_cita'] ?? null;

if (!$id_cita) {
    header("Location: panel_de_control.php");
    exit;
}

// Si se envió el formulario para actualizar la fecha
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nueva_fecha = $_POST['fecha_hora'] ?? null;
    $nuevo_motivo = trim($_POST['motivo'] ?? '');

    if ($nueva_fecha && !empty($nuevo_motivo)) {
        $stmt = $pdo->prepare("UPDATE cita SET fecha_hora = ?, motivo = ? WHERE id_cita = ?");
        $stmt->execute([$nueva_fecha, $nuevo_motivo, $id_cita]);

        // Redirigir dependiendo de quién hizo el cambio (dueño o veterinario)
        if (isset($_SESSION['id_veterinario'])) {
            header("Location: panel_veterinario.php?mensaje=Cita reagendada exitosamente");
        } else {
            header("Location: citas.php?mensaje=Cita reagendada exitosamente");
        }
        exit;
    } else {
        $error = "Por favor completa todos los campos.";
    }
}

// Consultar los datos actuales de la cita
$stmt = $pdo->prepare("SELECT * FROM cita WHERE id_cita = ?");
$stmt->execute([$id_cita]);
$cita = $stmt->fetch();

if (!$cita) {
    echo "Cita no encontrada.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reagendar Cita - AnimalCare</title>
    <link rel="stylesheet" href="static/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body style="padding: 40px;">
    <div class="contenedor" style="max-width: 500px; margin: auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <h2><i class="fa-regular fa-calendar-days"></i> Reagendar Cita</h2>
        
        <?php if (isset($error)): ?>
            <p style="color: red; font-size: 14px;"><?= $error ?></p>
        <?php endif; ?>

        <form action="reagendar_cita.php?id_cita=<?= $id_cita ?>" method="POST" style="margin-top: 20px;">
            <input type="hidden" name="id_cita" value="<?= $id_cita ?>">

            <label for="fecha_hora">Nueva Fecha y Hora:</label>
            <input type="datetime-local" name="fecha_hora" id="fecha_hora" value="<?= date('Y-m-d\TH:i', strtotime($cita['fecha_hora'])) ?>" required style="width:100%; padding:10px; margin-top:5px; margin-bottom:15px; box-sizing: border-box; border-radius: 6px; border: 1px solid #ccc;">

            <label for="motivo">Motivo / Observación:</label>
            <textarea name="motivo" id="motivo" rows="3" required style="width:100%; padding:10px; margin-top:5px; margin-bottom:20px; box-sizing: border-box; border-radius: 6px; border: 1px solid #ccc; resize: none;"><?= htmlspecialchars($cita['motivo']) ?></textarea>

            <button type="submit" style="width:100%; background:#0080ff; padding: 12px; border:none; color:white; border-radius:5px; cursor:pointer; font-weight: bold;">Guardar Cambios</button>
            <a href="citas.php" style="display:block; text-align:center; margin-top:15px; color:#6c757d; text-decoration:none;">Cancelar</a>
        </form>
    </div>
</body>
</html>