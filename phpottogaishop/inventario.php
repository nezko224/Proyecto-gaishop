<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}

$id = $_SESSION['id_usuario'];

// Inventario completo del usuario con JOIN a cromos, cosmeticos y puntos
$sql = "SELECT cr.nombre AS cromo, cr.rareza,
               co.nombre AS cosmetico, co.precio,
               p.puntos_acumulados
        FROM inventario i
        JOIN cromos     cr ON i.id_cromos     = cr.id_cromo
        JOIN cosmeticos co ON i.id_cosmeticos = co.id_cosmeticos
        JOIN puntos     p  ON i.id_puntos     = p.id_puntos
        WHERE i.id_usuario = '$id'";

$resultado = $conexion->query($sql);

// Puntos totales del usuario
$sql_puntos = "SELECT SUM(p.puntos_acumulados) AS total_puntos
               FROM inventario i
               JOIN puntos p ON i.id_puntos = p.id_puntos
               WHERE i.id_usuario = '$id'";
$res_puntos  = $conexion->query($sql_puntos);
$fila_puntos = $res_puntos->fetch_assoc();
$total_puntos = $fila_puntos['total_puntos'] ?? 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario — GaiShop</title>
</head>
<body>
    <h2>📦 Mi Inventario</h2>
    <p><b>Puntos totales acumulados: <?php echo $total_puntos; ?></b></p>

    <?php if ($resultado->num_rows > 0): ?>
        <table border="1" cellpadding="8">
            <tr>
                <th>Cromo</th>
                <th>Rareza</th>
                <th>Cosmetico</th>
                <th>Precio Cosmetico</th>
                <th>Puntos</th>
            </tr>
            <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?php echo $fila['cromo']; ?></td>
                <td><?php echo $fila['rareza']; ?></td>
                <td><?php echo $fila['cosmetico']; ?></td>
                <td>$<?php echo $fila['precio']; ?></td>
                <td><?php echo $fila['puntos_acumulados']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Tu inventario está vacío.</p>
    <?php endif; ?>

    <br>
    <a href="inicio.php">← Volver al inicio</a>
</body>
</html>
