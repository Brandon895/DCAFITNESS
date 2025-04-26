<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class ReporteController {

    // Función que carga la vista principal con los botones
    public function index() {
        include($_SERVER['DOCUMENT_ROOT'] . '/mi_gimnasio/DCAFITNESS/Proyecto/views/vista_reportes.php');
    }

    // Función para el reporte de clientes
    public function reporteClientes() {
        echo "<h1>Reporte de Clientes</h1>";
        echo "<p>Aquí va la lógica para mostrar el reporte de clientes.</p>";
    }

    // Función para el reporte de facturas
    public function reporteFacturas() {
        echo "<h1>Reporte de Facturas</h1>";
        echo "<p>Aquí va la lógica para mostrar el reporte de facturas.</p>";
    }

    // Función para el reporte de rutinas
    public function reporteRutinas() {
        echo "<h1>Reporte de Rutinas</h1>";
        echo "<p>Aquí va la lógica para mostrar el reporte de rutinas.</p>";
    }

    // Función para el reporte general de facturas
    public function reporteFacturasGenerales() {
        echo "<h1>Reporte General de Facturas</h1>";
        echo "<p>Aquí va la lógica para mostrar el reporte general de facturas.</p>";
    }
}
?>
