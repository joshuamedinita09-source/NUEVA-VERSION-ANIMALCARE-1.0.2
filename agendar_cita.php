<?php
require_once "conexion.php";
session_start();

if (!isset($_SESSION['id_dueno'])) {
    header("Location: iniciar_s.php");
    exit;
}

$id_dueno = $_SESSION['id_dueno'];

// Obtener las mascotas del dueño actual usando la tabla intermedia correcta
$stmt_m = $pdo->prepare("
    SELECT m.id_mascota, m.nombre_m 
    FROM mascota m 
    INNER JOIN dueno_mascota dm ON m.id_mascota = dm.id_mascota 
    WHERE dm.id_dueno = ?
");
$stmt_m->execute([$id_dueno]);
$mis_mascotas = $stmt_m->fetchAll();

// 1. Obtener la lista de veterinarios disponibles para la selección
$stmt_v = $pdo->query("SELECT id_veterinario, nombre_v, apellido_v FROM veterinario");
$veterinarios = $stmt_v->fetchAll();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_mascota     = $_POST['id_mascota'] ?? null;
    $fecha_cita     = $_POST['fecha_cita'] ?? null;
    $motivo         = trim($_POST['motivo'] ?? '');
    $tipo_cita      = $_POST['tipo_cita'] ?? 'CONTROL';
    $id_veterinario = $_POST['id_veterinario'] ?? null; // 2. Capturar el veterinario seleccionado

    // 3. Validar que todos los campos, incluido el veterinario, estén completos
    if (!$id_mascota || !$fecha_cita || empty($motivo) || !$id_veterinario) {
        echo "<script>alert('Por favor completa todos los campos.'); window.history.back();</script>";
        exit;
    }

    // 4. Insertar en la tabla 'cita' incluyendo el id_veterinario y el estado 'Pendiente'[cite: 2]
    $sql = "INSERT INTO cita (id_mascota, fecha_hora, motivo, tipo_cita, id_veterinario, estado) VALUES (?, ?, ?, ?, ?, 'Pendiente')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_mascota, $fecha_cita, $motivo, $tipo_cita, $id_veterinario]);

    header("Location: panel_de_control.php?mensaje=Cita agendada exitosamente");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agendar Cita - AnimalCare</title>
    <link rel="stylesheet" href="static/css/style.css">
    <link rel="stylesheet" href="static/js/citas.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body style="padding: 40px;">
    <div class="contenedor" style="max-width: 500px; margin: auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <h2><i class="fa-regular fa-calendar-plus"></i> Agendar Nueva Cita</h2>
        <form action="agendar_cita.php" method="POST" style="margin-top: 20px;">
            
            <label for="id_mascota">Selecciona tu mascota:</label>
            <select name="id_mascota" id="id_mascota" required style="width:100%; padding:10px; margin-top:5px; margin-bottom:15px; box-sizing: border-box; border-radius: 6px; border: 1px solid #ccc;">
                <option value="">-- Seleccionar --</option>
                <?php foreach ($mis_mascotas as $m): ?>
                    <option value="<?= $m['id_mascota'] ?>"><?= htmlspecialchars($m['nombre_m']) ?></option>
                <?php endforeach; ?>
            </select>

            <!-- NUEVO: Selector de Veterinario -->
            <label for="id_veterinario">Selecciona el Veterinario:</label>
            <select name="id_veterinario" id="id_veterinario" required style="width:100%; padding:10px; margin-top:5px; margin-bottom:15px; box-sizing: border-box; border-radius: 6px; border: 1px solid #ccc;">
                <option value="">-- Seleccionar Veterinario --</option>
                <?php foreach ($veterinarios as $vet): ?>
                    <option value="<?= $vet['id_veterinario'] ?>">Dr(a). <?= htmlspecialchars($vet['nombre_v'] . ' ' . $vet['apellido_v']) ?></option>
                <?php endforeach; ?>
            </select>

            <label for="tipo_cita">Tipo de Cita:</label>
            <select name="tipo_cita" id="tipo_cita" required style="width:100%; padding:10px; margin-top:5px; margin-bottom:15px; box-sizing: border-box; border-radius: 6px; border: 1px solid #ccc;">
                <option value="CONTROL">Control General</option>
                <option value="VACUNACIÓN">Vacunación</option>
                <option value="ESTERILIZACION">Esterilización</option>
            </select>

            <label for="fecha_cita">Fecha y Hora:</label>
            <input type="datetime-local" name="fecha_cita" id="fecha_cita" required style="width:100%; padding:10px; margin-top:5px; margin-bottom:15px; box-sizing: border-box; border-radius: 6px; border: 1px solid #ccc;">

            <label for="motivo">Motivo de la consulta:</label>
            <textarea name="motivo" id="motivo" rows="3" required style="width:100%; padding:10px; margin-top:5px; margin-bottom:20px; box-sizing: border-box; border-radius: 6px; border: 1px solid #ccc; resize: none;"></textarea>

            <button type="submit" style="width:100%; background:#0080ff; padding: 12px; border:none; color:white; border-radius:5px; cursor:pointer; font-weight: bold;">Confirmar Cita</button>
            <a href="panel_de_control.php" style="display:block; text-align:center; margin-top:15px; color:#6c757d; text-decoration:none;">Cancelar</a>
        </form>
    </div>
</body>
</html>