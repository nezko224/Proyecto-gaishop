<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}

$mensaje = "";

// Agregar cosmetico al inventario
if ($_POST) {
    $id_cosmetico = $_POST['id_cosmeticos'];
    $id_usuario   = $_SESSION['id_usuario'];

    $sql = "INSERT INTO inventario (id_usuario, id_cosmeticos)
            VALUES ('$id_usuario', '$id_cosmetico')";

    if ($conexion->query($sql) === TRUE) {
        $mensaje = "¡Cosmetico agregado a tu inventario!";
    } else {
        $mensaje = "Error al agregar el cosmetico.";
    }
}

// Listar todos los cosmeticos disponibles
$sql       = "SELECT * FROM cosmeticos WHERE stock > 0";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cosméticos — GaiShop</title>
</head>
<body>
    <h2>✨ Cosméticos Disponibles</h2>

    <p style="color: green;"><b><?php echo $mensaje; ?></b></p>

    <?php if ($resultado->num_rows > 0): ?>
        <table border="1" cellpadding="8">
            <tr>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Acción</th>
            </tr>
            <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?php echo $fila['nombre']; ?></td>
                <td>$<?php echo $fila['precio']; ?></td>
                <td><?php echo $fila['stock']; ?></td>
                <td>
                    <form method="POST" action="cosmeticos.php">
                        <input type="hidden" name="id_cosmeticos" value="<?php echo $fila['id_cosmeticos']; ?>">
                        <button type="submit">Agregar</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No hay cosmeticos disponibles.</p>
    <?php endif; ?>

    <br>
    <a href="inicio.php">← Volver al inicio</a>
</body>
</html>
