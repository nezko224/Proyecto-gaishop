<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}

$id = $_SESSION['id_usuario'];

// Cromos del usuario con JOIN al juego que los generó
$sql = "SELECT cr.nombre, cr.serie, cr.rareza, cr.descripcion, cr.fecha_lanzamiento, j.nombre AS juego
        FROM inventario i
        JOIN cromos  cr ON i.id_cromos    = cr.id_cromo
        JOIN juego   j  ON cr.id_licencia = j.id_licencia
        WHERE i.id_usuario = '$id'";

$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Cromos — GaiShop</title>
</head>
<body>
    <h2>🃏 Mis Cromos</h2>

    <?php if ($resultado->num_rows > 0): ?>
        <table border="1" cellpadding="8">
            <tr>
                <th>Nombre</th>
                <th>Serie</th>
                <th>Rareza</th>
                <th>Descripción</th>
                <th>Juego</th>
                <th>Lanzamiento</th>
            </tr>
            <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?php echo $fila['nombre']; ?></td>
                <td><?php echo $fila['serie']; ?></td>
                <td><?php echo $fila['rareza']; ?></td>
                <td><?php echo $fila['descripcion']; ?></td>
                <td><?php echo $fila['juego']; ?></td>
                <td><?php echo $fila['fecha_lanzamiento']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No tenés cromos en tu colección todavía.</p>
    <?php endif; ?>

    <br>
    <a href="inicio.php">← Volver al inicio</a>
</body>
</html>
