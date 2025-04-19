<?php
require_once '../models/BitacoraAccesosModel.php';

class BitacoraAccesosController {

    // Método para registrar el inicio de sesión
    public function registrarInicioSesion($id_usuario, $nombreusuario) {
        $accion = 'Inicio de sesión';
        BitacoraAccesosModel::registrarAcceso($id_usuario, $nombreusuario, $accion);
    }

    // Método para registrar el cierre de sesión
    public function registrarCierreSesion() {
        if (isset($_SESSION['id']) && isset($_SESSION['nombreusuario'])) {
            $id_usuario = $_SESSION['id'];
            $nombreusuario = $_SESSION['nombreusuario'];

            // Registra el cierre de sesión en la bitácora
            $accion = 'Cierre de sesión';
            BitacoraAccesosModel::registrarAcceso($id_usuario, $nombreusuario, $accion);
        }
    }

    // Método para mostrar la bitácora
    public function mostrarBitacora() {
        $bitacora = BitacoraAccesosModel::obtenerBitacora();
        require_once 'loguin.php';
    }
}
?>
