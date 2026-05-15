<?php
$conexion = new mysqli("localhost", "root", "", "gaishop");

if ($conexion->connect_error) {
    die("Error conectando a la base de datos.");
}
?>
