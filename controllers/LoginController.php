<?php
session_start();
require_once '../models/db.php';  
require_once '../models/BitacoraAccesosModel.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consulta preparada
    $sql = "SELECT id, nombreusuario, contrasena, rol FROM usuarios WHERE nombreusuario = ?";
    $stmt = $conn->prepare($sql);

    // Verificar si la preparación fue exitosa
    if (!$stmt) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verificar contraseña 
    if ($user && password_verify($password, $user['contrasena'])) {  
        $_SESSION['id'] = $user['id'];
        $_SESSION['usuario'] = $user['nombreusuario'];
        $_SESSION['rol'] = $user['rol'];

        // Registrar en la bitácora
        BitacoraAccesosModel::registrarAcceso($_SESSION['id'], $_SESSION['usuario'], "Inicio de sesión");

        header("Location: ../views/dashboard.php");
        exit();
    } else {
        header("Location: ../views/loguin.php?error=Usuario o contraseña incorrectos");
        exit();
    }
}
?>

