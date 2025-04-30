<?php
$host = "sql3.freesqldatabase.com";
$user = "sql3776084";
$password = "vqri3ry8GD";  // reemplaza por tu contraseña real
$dbname = "sql3776084";       // ¡esto debe ser exacto!

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
