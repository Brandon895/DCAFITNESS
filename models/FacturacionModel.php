<?php
class FacturacionModel {

    private $conn;  

    // Constructor que inicializa la conexión
    public function __construct() {
        
        $this->conn = new mysqli("localhost", "root", "0895Gazuniga", "dcafitness");
        if ($this->conn->connect_error) {
            die("Conexión fallida: " . $this->conn->connect_error);
        }
    }

    // Obtener todas las facturas
    public function obtenerFacturas() {
        $query = "SELECT * FROM facturas";
        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);  // Devuelve las facturas como un arreglo asociativo
        } else {
            return [];  // No se encontraron facturas
        }
    }

    // Obtener una factura por ID
    public function obtenerFacturaPorId($id_factura) {
        $query = "SELECT * FROM facturas WHERE id_factura = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_factura);  // Vincular el parámetro ID de la factura
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Crear una nueva factura
    public function crearFactura($id_cliente, $fecha_emision, $fecha_vencimiento, $total_servicios, $total_productos, $total_iva, $total_a_pagar, $metodo_pago) {
        $query = "INSERT INTO facturas (id_cliente, fecha_emision, fecha_vencimiento, total_servicios, total_productos, total_iva, total_a_pagar, metodo_pago) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        // Prepara la consulta
        $stmt = $this->conn->prepare($query);
        
        $stmt->bind_param(
            'issdddds', 
            $id_cliente,    
            $fecha_emision, 
            $fecha_vencimiento, 
            $total_servicios,  
            $total_productos,  
            $total_iva,        
            $total_a_pagar,   
            $metodo_pago       
        );
        
        // Ejecuta la consulta
        return $stmt->execute();
    }
    
}
?>
