<?php
session_start();
require_once '../models/db.php';  
require_once '../models/BitacoraAccesosModel.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, nombreusuario, contrasena, rol FROM usuarios WHERE nombreusuario = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error al preparar SQL: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verifica si el usuario existe y la contraseña es correcta
    if ($user && password_verify($password, $user['contrasena'])) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['usuario'] = $user['nombreusuario'];
        $_SESSION['rol'] = $user['rol'];

        // Registra el acceso en la bitácora
        BitacoraAccesosModel::registrarAcceso($_SESSION['id'], $_SESSION['usuario'], "Inicio de sesión");

        // Redirige al dashboard
        header("Location: ../views/dashboard.php");
        exit();
    } else {
        // Redirige al login con un mensaje de error
        header("Location: ../views/loguin.php?error=Usuario o contraseña incorrectos");
        exit();
    }
}
?>
