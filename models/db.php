<?php
$databaseUrl = getenv('DATABASE_URL'); // Obtiene la variable de entorno
$dsn = parse_url($databaseUrl); // Parseamos la URL
$dbConnection = new mysqli($dsn['host'], $dsn['user'], $dsn['pass'], ltrim($dsn['path'], '/'));

if ($dbConnection->connect_error) {
    die("Connection failed: " . $dbConnection->connect_error);
}
echo "Connected successfully!";
?>
