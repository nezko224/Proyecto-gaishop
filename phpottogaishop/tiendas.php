<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}

// Listar todas las tiendas disponibles
$sql       = "SELECT * FROM tienda";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tiendas — GaiShop</title>
</head>
<body>
    <h2>🏪 Tiendas Disponibles</h2>

    <?php if ($resultado->num_rows > 0): ?>
        <table border="1" cellpadding="8">
            <tr>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Email</th>
            </tr>
            <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?php echo $fila['nombre']; ?></td>
                <td><?php echo $fila['direccion']; ?></td>
                <td><?php echo $fila['telefono']; ?></td>
                <td><?php echo $fila['email']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No hay tiendas registradas.</p>
    <?php endif; ?>

    <br>
    <a href="inicio.php">← Volver al inicio</a>
</body>
</html>
