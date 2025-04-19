<?php
include('db.php'); // Incluimos la conexión a la base de datos

class UserModel {
    
    // Método para verificar el login del usuario
    public static function checkLogin($username, $password) {
        global $conn;

        $sql = "SELECT * FROM usuarios WHERE nombreusuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Verificamos la contraseña cifrada
            if (password_verify($password, $user['contrasena'])) {
                return $user;
            }
        }
        return false;
    }

    // Método para registrar un nuevo usuario
    public static function registerUser($username, $password, $rol = 'cliente') {
        global $conn;

        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Ciframos la contraseña
        $sql = "INSERT INTO usuarios (nombreusuario, contrasena, rol) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $hashed_password, $rol);

        return $stmt->execute();
    }
}
?>
