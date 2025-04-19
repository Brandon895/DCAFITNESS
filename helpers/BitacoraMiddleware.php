<?php
require_once '../models/BitacoraModel.php';

// Esta función será llamada automáticamente antes de cualquier acción importante.
function registrarMovimientoAutomático() {
    // Verificar si la sesión está iniciada
    if (session_status() == PHP_SESSION_NONE) {
        session_start();  // Iniciar la sesión si no está iniciada
    }

    // Verificar si el usuario está autenticado (existe en la sesión)
    if (isset($_SESSION['usuario_id'])) {
        // Si el usuario está autenticado, obtener el ID y registrar el movimiento
        $usuario_id = $_SESSION['usuario_id'];
        $accion = obtenerAccionActual(); // Función que determina la acción realizada (por ejemplo, eliminar cliente, etc.)

        // Registrar el movimiento automáticamente
        $bitacora = new BitacoraModel();
        $bitacora->registrarMovimiento($usuario_id, $accion);
    } else {
        // Si no hay usuario autenticado, puedes manejar este caso según desees
        echo "No se puede registrar el movimiento. Usuario no autenticado.";
    }
}

// Esta función se encargaría de determinar la acción realizada. Ejemplo: "Se eliminó un cliente".
// Podrías tener diferentes tipos de acciones según el flujo de tu aplicación.
function obtenerAccionActual() {
    // Aquí puedes definir diferentes tipos de acción, dependiendo de lo que estés haciendo en cada momento
    // Por ejemplo, si se elimina un cliente o si se realiza alguna otra acción importante.
    
    // Este ejemplo asume que estás eliminando un cliente
    if (isset($_GET['accion']) && $_GET['accion'] == 'eliminar_cliente') {
        return "Se eliminó un cliente con ID: " . $_GET['id_cliente'];
    }
    
    // Otras acciones que podrían estar en tu aplicación (puedes agregar más condiciones aquí)
    return "Acción no definida";
}
