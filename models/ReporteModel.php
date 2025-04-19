<?php
// ReporteModel.php
class ReporteModel {

    // Método para obtener los tipos de reportes disponibles
    public function obtenerTiposDeReportes() {
        // En este caso, los reportes son estáticos, pero podrías hacer consultas a la base de datos
        return [
            'Clientes' => 'reporte_clientes.php',
            'Facturas' => 'reporte_facturas.php',
            'Rutinas' => 'reporte_rutinas.php',
            'Facturas Generales' => 'reporte_facturas_general.php'
        ];
    }
}
?>
