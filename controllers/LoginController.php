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

    // Debug: Verifica si encontró el usuario y si la contraseña es válida
    if ($user) {
        if (password_verify($password, $user['contrasena'])) {
            echo "✅ Contraseña correcta para el usuario: " . htmlspecialchars($user['nombreusuario']);
            // Elimina este exit cuando confirmes que funciona
            exit();
        } else {
            echo "❌ Contraseña incorrecta para el usuario: " . htmlspecialchars($user['nombreusuario']);
            exit();
        }
    } else {
        echo "❌ Usuario no encontrado.";
        exit();
    }

    // Código real que solo se ejecutará cuando estés seguro de que funciona
    $_SESSION['id'] = $user['id'];
    $_SESSION['usuario'] = $user['nombreusuario'];
    $_SESSION['rol'] = $user['rol'];

    BitacoraAccesosModel::registrarAcceso($_SESSION['id'], $_SESSION['usuario'], "Inicio de sesión");

    header("Location: ../views/dashboard.php");
    exit();
}
?>
