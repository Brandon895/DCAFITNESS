<?php
// Obtener la URL de la base de datos desde la variable de entorno
$database_url = getenv('DATABASE_URL');

// Parsear la URL para obtener los detalles de la conexión
$parsed_url = parse_url($database_url);

// Extraer los datos de la URL
$servername = $parsed_url['host'];      // sql206.infinityfree.com
$username = $parsed_url['user'];       // if0_38849919
$password = $parsed_url['pass'];       // 0895Gazuniga
$database = ltrim($parsed_url['path'], '/'); // if0_38849919_XXX

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

echo "Conexión exitosa a la base de datos!";
?>
