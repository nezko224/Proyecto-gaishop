<?php
session_start();
include 'conexion.php';

if (isset($_GET['salir'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}

$id = $_SESSION['id_usuario'];
$nombre = $_SESSION['nombre'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio — GaiShop</title>
</head>
<body>
    <h1>¡Bienvenido, <?php echo $nombre; ?>!</h1>
    <hr>
    <ul>
        <li><a href="juegos.php">🎮 Mis Juegos</a></li>
        <li><a href="cosmeticos.php">✨ Cosméticos</a></li>
        <li><a href="cromos.php">🃏 Mis Cromos</a></li>
        <li><a href="workshops.php">🛠️ Workshops</a></li>
        <li><a href="carrito.php">🛒 Carrito</a></li>
        <li><a href="inventario.php">📦 Mi Inventario</a></li>
        <li><a href="perfil.php">👤 Mi Perfil</a></li>
        <li><a href="tiendas.php">🏪 Tiendas</a></li>
    </ul>
    <br>
    <a href="inicio.php?salir=true" style="color: red;">Cerrar Sesión</a>
</body>
</html>
