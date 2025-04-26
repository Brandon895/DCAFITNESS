<?php
include 'models/db.php'; 
function registrarMovimiento($usuario, $accion) {
    global $conn;

    $query = "INSERT INTO bitacora_movimientos (usuario, accion) VALUES (?, ?)";
    
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("ss", $usuario, $accion);
        return $stmt->execute(); 
    } else {
        return false;
    }
}
?>
