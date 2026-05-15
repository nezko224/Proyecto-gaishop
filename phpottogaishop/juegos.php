<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}

$id = $_SESSION['id_usuario'];

// Listar juegos del usuario con JOIN a usuario
$sql = "SELECT j.id_licencia, j.nombre, j.empresa, j.categoria, j.calificacion, j.fecha_compra, j.estado
        FROM juego j
        JOIN usuario u ON j.id_usuario = u.id_usuario
        WHERE j.id_usuario = '$id'";

$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Juegos — GaiShop</title>
</head>
<body>
    <h2>🎮 Mis Juegos</h2>

    <?php if ($resultado->num_rows > 0): ?>
        <table border="1" cellpadding="8">
            <tr>
                <th>Nombre</th>
                <th>Empresa</th>
                <th>Categoría</th>
                <th>Calificación</th>
                <th>Fecha de Compra</th>
                <th>Estado</th>
            </tr>
            <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?php echo $fila['nombre']; ?></td>
                <td><?php echo $fila['empresa']; ?></td>
                <td><?php echo $fila['categoria']; ?></td>
                <td><?php echo $fila['calificacion']; ?></td>
                <td><?php echo $fila['fecha_compra']; ?></td>
                <td><?php echo $fila['estado']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No tenés juegos comprados todavía.</p>
    <?php endif; ?>

    <br>
    <a href="inicio.php">← Volver al inicio</a>
</body>
</html>
