<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}

// Workshops con el juego al que pertenecen (JOIN)
$sql = "SELECT w.id_workshop, w.titulo, w.descripcion, w.archivo, j.nombre AS juego
        FROM workshop w
        JOIN juego j ON w.id_juego = j.id_licencia";

$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Workshops — GaiShop</title>
</head>
<body>
    <h2>🛠️ Workshops</h2>

    <?php if ($resultado->num_rows > 0): ?>
        <table border="1" cellpadding="8">
            <tr>
                <th>Título</th>
                <th>Descripción</th>
                <th>Archivo</th>
                <th>Juego</th>
            </tr>
            <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?php echo $fila['titulo']; ?></td>
                <td><?php echo $fila['descripcion']; ?></td>
                <td><?php echo $fila['archivo']; ?></td>
                <td><?php echo $fila['juego']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No hay workshops disponibles.</p>
    <?php endif; ?>

    <br>
    <a href="inicio.php">← Volver al inicio</a>
</body>
</html>
