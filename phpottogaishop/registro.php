<?php
include 'conexion.php';
$mensaje = "";

if ($_POST) {
    $nombre     = $_POST['nombre'];
    $email      = $_POST['email'];
    $contrasena = $_POST['contrasena'];
    $telefono   = $_POST['telefono'];
    $fecha      = date('Y-m-d');

    $sql = "INSERT INTO usuario (nombre, email, contrasena, telefono, fecha_registro)
            VALUES ('$nombre', '$email', '$contrasena', '$telefono', '$fecha')";

    if ($conexion->query($sql) === TRUE) {
        $mensaje = "¡Registro exitoso! Ahora podés loguearte.";
    } else {
        $mensaje = "Error al registrar. Quizás el email ya existe.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro — GaiShop</title>
</head>
<body>
    <h2>Crear Cuenta — GaiShop</h2>

    <p style="color: green;"><b><?php echo $mensaje; ?></b></p>

    <form method="POST" action="registro.php">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Contraseña:</label><br>
        <input type="password" name="contrasena" required><br><br>

        <label>Teléfono:</label><br>
        <input type="text" name="telefono"><br><br>

        <button type="submit">Crear Cuenta</button>
    </form>
    <br>
    <a href="index.php">¿Ya tenés cuenta? Iniciá sesión</a>
</body>
</html>
