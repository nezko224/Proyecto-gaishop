<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "gaishop";

$conn = new mysqli($host, $user, $pass, $db);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    http_response_code(500);
    die(json_encode(["error" => $conn->connect_error]));
}
