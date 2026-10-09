<?php
require_once "conexion.php";
session_start();

// Validar que sea un veterinario autenticado[cite: 10]
if (!isset($_SESSION['id_veterinario'])) {
    header("Location: login_vet.php");
    exit;
}

$id_mascota = $_GET['id_mascota'] ?? null;
$id_cita = $_GET['id_cita'] ?? null; // Capturamos el id_cita para actualizar su estado

if (!$id_mascota) {
    header("Location: panel_veterinario.php?error=Mascota no especificada");
    exit;
}

// Obtener datos de la mascota[cite: 10]
$stmt_m = $pdo->prepare("SELECT * FROM mascota WHERE id_mascota = ?");
$stmt_m->execute([$id_mascota]);
$mascota = $stmt_m->fetch();

if (!$mascota) {
    echo "Mascota no encontrada.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $observaciones  = trim($_POST['observaciones'] ?? '');
    $estado_mascota = trim($_POST['estado_mascota'] ?? '');
    $medicamentos   = trim($_POST['medicamentos'] ?? '');
    $dosis          = trim($_POST['dosis'] ?? '');
    $alimentacion   = trim($_POST['alimentacion'] ?? '');
    $cuidados       = trim($_POST['cuidados'] ?? '');
    $recomendaciones= trim($_POST['recomendaciones'] ?? '');
    $fecha_h        = date('Y-m-d H:i:s');

    if (!empty($observaciones) && !empty($estado_mascota)) {
        try {
            $pdo->beginTransaction();

            // 1. Insertar el Historial Clínico[cite: 10]
            $stmt_h = $pdo->prepare("INSERT INTO historial_clinico (fecha_h, observaciones, estado_mascota, id_mascota) VALUES (?, ?, ?, ?)");
            $stmt_h->execute([$fecha_h, $observaciones, $estado_mascota, $id_mascota]);
            $id_historial = $pdo->lastInsertId();

            // 2. Insertar el Diagnóstico vinculado al Historial[cite: 10]
            $stmt_d = $pdo->prepare("INSERT INTO diagnostico (medicamentos, cuidados, alimentacion, dosis, recomendaciones, id_historial) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt_d->execute([$medicamentos, $cuidados, $alimentacion, $dosis, $recomendaciones, $id_historial]);

            // 3. Cambiar el estado de la cita a 'Realizada' automáticamente
            if ($id_cita) {
                $stmt_c = $pdo->prepare("UPDATE cita SET estado = 'Realizada' WHERE id_cita = ?");
                $stmt_c->execute([$id_cita]);
            }

            $pdo->commit();
            header("Location: panel_veterinario.php?mensaje=Historial y diagnóstico guardados exitosamente");
            exit;

        } catch (Exception $e) {
            $pdo->rollBack();
            $error = "Error al guardar el diagnóstico en la base de datos.";
        }
    } else {
        $error = "Por favor completa las observaciones y el estado de la mascota.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Diagnóstico e Historial - AnimalCare</title>
    <link rel="stylesheet" href="static/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body style="padding: 40px;">
    <div class="contenedor" style="max-width: 600px; margin: auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <h2><i class="fa-solid fa-stethoscope"></i> Historial Clínico y Diagnóstico</h2>
        <p class="subtitle" style="margin-bottom: 20px;">Paciente: <strong><?= htmlspecialchars($mascota['nombre_m']) ?></strong> (Raza: <?= htmlspecialchars($mascota['raza']) ?>)</p>

        <?php if (isset($error)): ?>
            <p style="color: red; font-size: 14px; margin-bottom: 15px;"><?= $error ?></p>
        <?php endif; ?>

        <!-- Mantenemos tanto el id_mascota como el id_cita en la URL del formulario -->
        <form action="crear_diagnostico.php?id_mascota=<?= $id_mascota ?>&id_cita=<?= $id_cita ?>" method="POST">
            
            <h3 style="font-size: 15px; color: #0080ff; margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 5px;">Datos del Historial Clínico</h3>
            
            <label for="estado_mascota">Estado general de la mascota:</label>
            <input type="text" name="estado_mascota" id="estado_mascota" placeholder="Ej. Estable, En recuperación, Crítico..." required style="width:100%; padding:10px; margin-top:5px; margin-bottom:15px; box-sizing: border-box; border-radius: 6px; border: 1px solid #ccc;">

            <label for="observaciones">Observaciones médicas:</label>
            <textarea name="observaciones" id="observaciones" rows="3" required style="width:100%; padding:10px; margin-top:5px; margin-bottom:20px; box-sizing: border-box; border-radius: 6px; border: 1px solid #ccc; resize: none;"></textarea>

            <h3 style="font-size: 15px; color: #0080ff; margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 5px;">Prescripción y Diagnóstico</h3>

            <div style="display: flex; gap: 10px;">
                <div style="flex: 1;">
                    <label for="medicamentos">Medicamentos:</label>
                    <input type="text" name="medicamentos" id="medicamentos" placeholder="Ej. Amoxicilina" style="width:100%; padding:10px; margin-top:5px; margin-bottom:15px; box-sizing: border-box; border-radius: 6px; border: 1px solid #ccc;">
                </div>
                <div style="flex: 1;">
                    <label for="dosis">Dosis:</label>
                    <input type="text" name="dosis" id="dosis" placeholder="Ej. 1 cada 8 horas" style="width:100%; padding:10px; margin-top:5px; margin-bottom:15px; box-sizing: border-box; border-radius: 6px; border: 1px solid #ccc;">
                </div>
            </div>

            <label for="alimentacion">Indicaciones de alimentación:</label>
            <input type="text" name="alimentacion" id="alimentacion" placeholder="Ej. Dieta blanda por 5 días" style="width:100%; padding:10px; margin-top:5px; margin-bottom:15px; box-sizing: border-box; border-radius: 6px; border: 1px solid #ccc;">

            <label for="cuidados">Cuidados especiales en casa:</label>
            <textarea name="cuidados" id="cuidados" rows="2" style="width:100%; padding:10px; margin-top:5px; margin-bottom:15px; box-sizing: border-box; border-radius: 6px; border: 1px solid #ccc; resize: none;"></textarea>

            <label for="recomendaciones">Recomendaciones generales:</label>
            <textarea name="recomendaciones" id="recomendaciones" rows="2" style="width:100%; padding:10px; margin-top:5px; margin-bottom:20px; box-sizing: border-box; border-radius: 6px; border: 1px solid #ccc; resize: none;"></textarea>

            <button type="submit" style="width:100%; background:#0080ff; padding: 12px; border:none; color:white; border-radius:5px; cursor:pointer; font-weight: bold;">Guardar Diagnóstico y Finalizar Cita</button>
            <a href="panel_veterinario.php" style="display:block; text-align:center; margin-top:15px; color:#6c757d; text-decoration:none;">Cancelar</a>
        </form>
    </div>
</body>
</html>