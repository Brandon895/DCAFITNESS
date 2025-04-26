<?php
class ReporteModel {

    // Método para obtener los tipos de reportes disponibles
    public function obtenerTiposDeReportes() {
        return [
            'Clientes' => 'reporte_clientes.php',
            'Facturas' => 'reporte_facturas.php',
            'Rutinas' => 'reporte_rutinas.php',
            'Facturas Generales' => 'reporte_facturas_general.php'
        ];
    }
}
?>
