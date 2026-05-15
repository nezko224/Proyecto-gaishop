<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}

$id      = $_SESSION['id_usuario'];
$mensaje = "";

// Guardar cambios del perfil
if ($_POST) {
    $nombre    = $_POST['nombre'];
    $telefono  = $_POST['telefono'];

    $sql = "UPDATE usuario SET nombre = '$nombre', telefono = '$telefono'
            WHERE id_usuario = '$id'";

    if ($conexion->query($sql) === TRUE) {
        $_SESSION['nombre'] = $nombre;
        $mensaje = "Perfil actualizado correctamente.";
    } else {
        $mensaje = "Error al actualizar el perfil.";
    }
}

// Traer datos actuales del usuario
$sql      = "SELECT * FROM usuario WHERE id_usuario = '$id'";
$resultado = $conexion->query($sql);
$usuario  = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil — GaiShop</title>
</head>
<body>
    <h2>👤 Mi Perfil</h2>

    <p style="color: green;"><b><?php echo $mensaje; ?></b></p>

    <form method="POST" action="perfil.php">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" value="<?php echo $usuario['nombre']; ?>" required><br><br>

        <label>Email (no editable):</label><br>
        <input type="email" value="<?php echo $usuario['email']; ?>" disabled><br><br>

        <label>Teléfono:</label><br>
        <input type="text" name="telefono" value="<?php echo $usuario['telefono']; ?>"><br><br>

        <label>Miembro desde:</label><br>
        <input type="text" value="<?php echo $usuario['fecha_registro']; ?>" disabled><br><br>

        <button type="submit">Guardar Cambios</button>
    </form>

    <br>
    <a href="inicio.php">← Volver al inicio</a>
</body>
</html>
