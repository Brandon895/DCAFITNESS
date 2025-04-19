<?php
$servername = "localhost";  // Servidor de base de datos
$username = "root";         // Usuario de la base de datos (ajústalo si es diferente)
$password = "0895Gazuniga";             // Contraseña de la base de datos (ajústala si es diferente)
$database = "dcafitness";  // Nombre de tu base de datos

$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

?>
