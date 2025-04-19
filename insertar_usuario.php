<?php
include('models/db.php');  // Conectar a la base de datos

// Crear un nombre de usuario y una contraseña
$usuario = 'entrenador';  // Nombre de usuario (puede ser 'admin' o 'entrenador')
$contrasena = 'ent123';  // Contraseña en texto plano (será cifrada)

// Usamos password_hash para encriptar la contraseña
$contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

// Definir el rol (puede ser 'administrador' o 'entrenador')
$rol = 'entrenador';  // Cambiar a 'entrenador' si es necesario

// Insertar el usuario en la base de datos
$sql = "INSERT INTO usuarios (nombreusuario, contrasena, rol) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $usuario, $contrasena_hash, $rol);
$stmt->execute();

echo "Usuario insertado correctamente.";
?>
