<?php
session_start();
include 'conexion.php';
$mensaje = "";

if ($_POST) {
    $email      = $_POST['email'];
    $contrasena = $_POST['contrasena'];

    $sql       = "SELECT * FROM usuario WHERE email = '$email' AND contrasena = '$contrasena'";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['nombre']     = $usuario['nombre'];
        header("Location: inicio.php");
        exit();
    } else {
        $mensaje = "Email o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login — GaiShop</title>
</head>
<body>
    <h2>Iniciar Sesión — GaiShop</h2>

    <p style="color: red;"><b><?php echo $mensaje; ?></b></p>

    <form method="POST" action="index.php">
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Contraseña:</label><br>
        <input type="password" name="contrasena" required><br><br>

        <button type="submit">Entrar</button>
    </form>
    <br>
    <a href="registro.php">¿No tenés cuenta? Registrate acá</a>
</body>
</html>
