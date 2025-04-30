<?php
// 👇 Asegúrate de que NO haya espacios ni líneas antes de esta etiqueta PHP
session_start();
include('../models/DashboardModel.php');

class DashboardController {
    private $dashboardModel;

    public function __construct() {
        $this->dashboardModel = new DashboardModel(); // Instancia el modelo
    }

    // Verifica que la sesión esté activa
    public function verificarSesion() {
        if (!isset($_SESSION['usuario'])) {
            // 👇 header debe ejecutarse antes de cualquier salida
            header("Location: dashboard.php");
            exit();
        }
    }

    // Obtiene el rol del usuario
    public function obtenerRol() {
        return $_SESSION['rol'];
    }

    // Obtiene los datos del dashboard, como el total de clientes
    public function obtenerDatosDashboard() {
        return $this->dashboardModel->obtenerDatosDashboard();
    }

    // Obtiene más estadísticas desde el modelo
    public function obtenerEstadisticas() {
        return $this->dashboardModel->obtenerEstadisticas(); // Llama al método del modelo
    }

    // Obtener el número de rutinas realizadas hoy
    public function obtenerRutinasHoy() {
        return $this->dashboardModel->obtenerRutinasHoy();
    }
}
?>
