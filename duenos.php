<?php
require 'conexion.php';

// Obtener todos los dueños registrados en la base de datos
$query = $conexion->query("SELECT * FROM dueno");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dueños registrados - AnimalCare</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 90%;
            margin: 30px auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #343a40;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

    <h1>Dueños registrados en AnimalCare</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Dirección</th>
        </tr>

        <?php while ($fila = $query->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?= htmlspecialchars($fila['id_dueno']) ?></td>
                <td><?= htmlspecialchars($fila['nombre_d']) ?></td>
                <td><?= htmlspecialchars($fila['apellido_d']) ?></td>
                <td><?= htmlspecialchars($fila['telefono_d']) ?></td>
                <td><?= htmlspecialchars($fila['correo_d']) ?></td>
                <td><?= htmlspecialchars($fila['direccion_d']) ?></td>
            </tr>
        <?php endwhile; ?>

    </table>

</body>
</html>