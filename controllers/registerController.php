<?php
include('../models/UserModel.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (UserModel::registerUser($username, $password)) {
        header("Location: ../views/loguin.php?success=Usuario registrado con éxito");
    } else {
        header("Location: ../views/register.php?error=Error al registrar usuario");
    }
}
?>
