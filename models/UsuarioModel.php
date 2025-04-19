<?php
// models/UsuarioModel.php
require_once('C:/laragon/www/mi_gimnasio/DCAFITNESS/Proyecto/models/db.php');
// Se ajusta la ruta según la estructura

class UsuarioModel {

    // Registrar nuevo usuario
    public static function registrarUsuario($nombrecompleto, $nombreusuario, $contrasena, $rol) {
        global $conn; // Usamos la variable de conexión global

        // Hash de la contraseña para mayor seguridad
        $passwordHash = password_hash($contrasena, PASSWORD_DEFAULT);

        // Consulta SQL para insertar un nuevo usuario
        $sql = "INSERT INTO usuarios (nombrecompleto, nombreusuario, contrasena, rol) VALUES (?, ?, ?, ?)";

        // Preparar y ejecutar la consulta
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nombrecompleto, $nombreusuario, $passwordHash, $rol);

        // Ejecutar la consulta y retornar el resultado
        return $stmt->execute();
    }

    // Editar usuario
    public static function editarUsuario($id, $nombrecompleto, $nombreusuario, $contrasena, $rol) {
        global $conn;

        // Si la contraseña no está vacía, la actualizamos
        if (!empty($contrasena)) {
            $passwordHash = password_hash($contrasena, PASSWORD_DEFAULT);
            $sql = "UPDATE usuarios SET nombrecompleto = ?, nombreusuario = ?, contrasena = ?, rol = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $nombrecompleto, $nombreusuario, $passwordHash, $rol, $id);
        } else {
            // Si no hay nueva contraseña, no actualizamos la contraseña
            $sql = "UPDATE usuarios SET nombrecompleto = ?, nombreusuario = ?, rol = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $nombrecompleto, $nombreusuario, $rol, $id);
        }

        // Ejecutar la consulta y retornar el resultado
        return $stmt->execute();
    }

    // Inactivar (Eliminar) usuario
    public static function inactivarUsuario($id) {
        global $conn;

        // Consulta SQL para eliminar un usuario
        $sql = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        
        // Ejecutar la consulta y retornar el resultado
        return $stmt->execute();
    }

    // Obtener todos los usuarios
    public static function obtenerUsuarios() {
        global $conn;
        $sql = "SELECT * FROM usuarios";  // Consulta para obtener todos los usuarios
        $result = $conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);  // Devuelve los resultados como un array asociativo
    }
}
?>
