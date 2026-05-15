<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}

$id      = $_SESSION['id_usuario'];
$mensaje = "";

// Registrar pago del carrito
if ($_POST) {
    $metodo = $_POST['metodo_pago'];
    $fecha  = date('Y-m-d');

    // Buscar el carrito abierto del usuario
    $sql_carrito = "SELECT id_carrito, total FROM carrito_compra
                    WHERE id_usuario = '$id' AND estado = 'abierto'";
    $res_carrito = $conexion->query($sql_carrito);

    if ($res_carrito->num_rows > 0) {
        $carrito = $res_carrito->fetch_assoc();
        $id_carrito = $carrito['id_carrito'];
        $total      = $carrito['total'];

        // Insertar el pago
        $sql_pago = "INSERT INTO pago (id_carrito, fecha_pago, metodo_pago, monto, estado)
                     VALUES ('$id_carrito', '$fecha', '$metodo', '$total', 'aprobado')";
        $conexion->query($sql_pago);

        // Cerrar el carrito
        $sql_cerrar = "UPDATE carrito_compra SET estado = 'cerrado' WHERE id_carrito = '$id_carrito'";
        $conexion->query($sql_cerrar);

        $mensaje = "¡Compra realizada con éxito!";
    } else {
        $mensaje = "No tenés un carrito abierto.";
    }
}

// Mostrar carrito abierto del usuario con JOIN a tienda
$sql = "SELECT c.id_carrito, c.fecha_creacion, c.total, c.estado, t.nombre AS tienda
        FROM carrito_compra c
        JOIN tienda t ON c.id_tienda = t.id_tienda
        WHERE c.id_usuario = '$id'";

$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito — GaiShop</title>
</head>
<body>
    <h2>🛒 Mi Carrito</h2>

    <p style="color: green;"><b><?php echo $mensaje; ?></b></p>

    <?php if ($resultado->num_rows > 0): ?>
        <table border="1" cellpadding="8">
            <tr>
                <th>Tienda</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Estado</th>
            </tr>
            <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?php echo $fila['tienda']; ?></td>
                <td><?php echo $fila['fecha_creacion']; ?></td>
                <td>$<?php echo $fila['total']; ?></td>
                <td><?php echo $fila['estado']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>

        <br>
        <h3>Finalizar Compra</h3>
        <form method="POST" action="carrito.php">
            <label>Método de pago:</label><br>
            <select name="metodo_pago">
                <option value="tarjeta">Tarjeta</option>
                <option value="mercadopago">MercadoPago</option>
                <option value="transferencia">Transferencia</option>
                <option value="cripto">Cripto</option>
            </select><br><br>
            <button type="submit">Pagar</button>
        </form>
    <?php else: ?>
        <p>Tu carrito está vacío.</p>
    <?php endif; ?>

    <br>
    <a href="inicio.php">← Volver al inicio</a>
</body>
</html>
