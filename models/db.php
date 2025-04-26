<?php
$servername = "localhost";  
$username = "root";         
$password = "0895Gazuniga";            
$database = "dcafitness";  

$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

?>
