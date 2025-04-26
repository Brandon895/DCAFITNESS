<?php
class PagoModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Registrar el pago en la base de datos
    public function registrarPago($id_cliente, $monto, $metodo_pago, $descripcion, $fecha_pago) {
        $sql = "INSERT INTO pagos (id_cliente, fecha_pago, monto, metodo_pago, descripcion) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('isdss', $id_cliente, $fecha_pago, $monto, $metodo_pago, $descripcion);
        $stmt->execute();
        $stmt->close();
    }

    // Actualizar la fecha de vencimiento de la membresía
    public function actualizarFechaVencimiento($id_cliente, $nuevo_vencimiento) {
        $sql = "UPDATE clientes SET fecha_vencimiento = ? WHERE id_cliente = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('si', $nuevo_vencimiento, $id_cliente);
        $stmt->execute();
        $stmt->close();
    }
}
?>
