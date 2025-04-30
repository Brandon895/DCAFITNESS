<?php
$host = "sql3.freesqldatabase.com"; // correcto
$user = "sql3776084";
$password = "vqri3ry8GD";  // cambialo por la contraseña real
$dbname = "sql3776084";

$conn = new mysqli($host, $user, $password, $dbname, 3306);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
