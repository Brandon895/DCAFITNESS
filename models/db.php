<?php
$databaseUrl = getenv('DATABASE_URL');

// Convertir la URL en partes
$components = parse_url($databaseUrl);

$servername = $components['host'];
$username   = $components['user'];
$password   = $components['pass'];
$database   = ltrim($components['path'], '/');
$port       = $components['port'];

// Crear la conexión usando las variables correctas
$conn = new mysqli($servername, $username, $password, $database, $port);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
