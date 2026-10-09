<?php
require_once "conexion.php";
session_start();

// Verificar que el usuario haya iniciado sesión
if (!isset($_SESSION['id_dueno'])) {
    header("Location: iniciar_s.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre_m    = trim($_POST["nombre_m"] ?? "");
    $raza        = trim($_POST["raza"] ?? "");
    $edad        = intval($_POST["edad"] ?? 0);
    $sexo        = $_POST["sexo"] ?? "macho";
    $peso        = floatval($_POST["peso"] ?? 0);
    $tipo_sangre = trim($_POST["tipo_sangre"] ?? "");
    $id_dueno    = $_SESSION['id_dueno'];

    if (empty($nombre_m) || empty($raza)) {
        echo "<script>alert('Por favor completa los campos obligatorios.'); window.history.back();</script>";
        exit;
    }

    try {
        // Usar transacciones para asegurar que ambas inserciones ocurran correctamente
        $pdo->beginTransaction();

        // 1. Insertar la nueva mascota en la tabla mascota
        $sql_mascota = "INSERT INTO mascota (nombre_m, raza, edad, sexo, peso, tipo_sangre) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql_mascota);
        $stmt->execute([$nombre_m, $raza, $edad, $sexo, $peso, $tipo_sangre]);
        
        // Obtener el ID de la mascota recién insertada
        $id_mascota = $pdo->lastInsertId();

        // 2. Insertar la relación en la tabla intermedia dueno_mascota
        $sql_relacion = "INSERT INTO dueno_mascota (id_dueno, id_mascota, parentesco_rol) VALUES (?, ?, 'Propietario')";
        $stmt_relacion = $pdo->prepare($sql_relacion);
        $stmt_relacion->execute([$id_dueno, $id_mascota]);

        $pdo->commit();

        // Redirigir al panel de control con éxito
        header("Location: panel_de_control.php");
        exit;

    } catch (Exception $e) {
        $pdo->rollBack();
        echo "<script>alert('Error al registrar la mascota: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Mascota - AnimalCare</title>
    <link rel="stylesheet" href="static/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <main class="register-container">
        <div class="register-card" style="max-width: 500px;">
            <div class="card-header">
                <h2>Registrar Mascota</h2>
                <p class="subtitle">Agrega un nuevo peludito a tu cuenta</p>
            </div>

            <form action="agregar_mascota.php" method="POST">
                <div class="input-group">
                    <label for="nombre_m">Nombre</label>
                    <div class="input-field">
                        <i class="fa-solid fa-paw"></i>
                        <input type="text" id="nombre_m" name="nombre_m" required placeholder="Ej: Firulais">
                    </div>
                </div>

                <div class="input-group">
                    <label for="raza">Raza</label>
                    <div class="input-field">
                        <i class="fa-solid fa-dog"></i>
                        <input type="text" id="raza" name="raza" required placeholder="Ej: Criollo / Labrador">
                    </div>
                </div>

                <div class="input-group">
                    <label for="edad">Edad (años)</label>
                    <div class="input-field">
                        <i class="fa-solid fa-calendar"></i>
                        <input type="number" id="edad" name="edad" min="0" required placeholder="Ej: 3">
                    </div>
                </div>

                <div class="input-group">
                    <label for="sexo">Sexo</label>
                    <div class="input-field">
                        <i class="fa-solid fa-venus-mars"></i>
                        <select id="sexo" name="sexo" style="width: 100%; border: none; outline: none; background: transparent;">
                            <option value="macho">Macho</option>
                            <option value="hembra">Hembra</option>
                        </select>
                    </div>
                </div>

                <div class="input-group">
                    <label for="peso">Peso (kg)</label>
                    <div class="input-field">
                        <i class="fa-solid fa-weight-scale"></i>
                        <input type="number" step="0.01" id="peso" name="peso" required placeholder="Ej: 8.5">
                    </div>
                </div>

                <div class="input-group">
                    <label for="tipo_sangre">Tipo de Sangre</label>
                    <div class="input-field">
                        <i class="fa-solid fa-droplet"></i>
                        <input type="text" id="tipo_sangre" name="tipo_sangre" placeholder="Ej: A, B, DEA 1.1">
                    </div>
                </div>

                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <button type="submit" class="btn-submit">Guardar Mascota</button>
                    <a href="panel_de_control.php" class="btn-action secondary" style="display: flex; align-items: center; justify-content: center; text-decoration: none;">Cancelar</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>