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

    if ($user) {
        if (password_verify($password, $user['contrasena'])) {
            // Todo correcto, guardamos los datos en la sesión
            $_SESSION['id'] = $user['id'];
            $_SESSION['usuario'] = $user['nombreusuario'];
            $_SESSION['rol'] = $user['rol'];

            // Registrar el acceso en la bitácora
            BitacoraAccesosModel::registrarAcceso($_SESSION['id'], $_SESSION['usuario'], "Inicio de sesión");

            // Redireccionamos al dashboard
            header("Location: ../views/dashboard.php");
            exit();
        } else {
            // Contraseña incorrecta
            header("Location: ../views/loguin.php?error=contraseña_incorrecta");
            exit();
        }
    } else {
        // Usuario no encontrado
        header("Location: ../views/loguin.php?error=usuario_no_encontrado");
        exit();
    }
}
?>
