<?php
require_once '../models/ClienteModel.php';
require_once '../helpers/BitacoraHelper.php'; 

class ClienteController {
    private $clienteModel;

    public function __construct() {
        $this->clienteModel = new ClienteModel();
    }

    // ✅ Obtener todos los clientes
    public function obtenerClientes() {
        return $this->clienteModel->obtenerTodosLosClientes();
    }

    // ✅ Obtener cliente por cédula
    public function obtenerClientePorCedula($cedula) {
        return $this->clienteModel->obtenerClientePorCedula($cedula);
    }

    // ✅ Agregar nuevo cliente
    public function agregarCliente($data) {
        // Registrar movimiento en la bitácora antes de agregar el cliente
        $mensajeBitacora = "Cliente registrado con cédula: " . $data['cedula'];
        BitacoraHelper::registrarMovimiento('Cliente agregado', 'Cliente', $mensajeBitacora);
        
        // Luego agregar el cliente
        return $this->clienteModel->insertarCliente($data);
    }

    // ✅ Verificar membresía
    public function verificarMembresia($cedula) {
        return $this->clienteModel->verificarMembresia($cedula);
    }

    // ✅ Registrar acceso
    public function registrarAcceso($cedula) {
        return $this->clienteModel->registrarAcceso($cedula);
    }

    // ✅ Método para eliminar un cliente con pagos relacionados
    public function eliminarCliente($id_cliente) {
        // Registrar en la bitácora antes de eliminar
        BitacoraHelper::registrarMovimiento('Cliente eliminado', 'Cliente', 'Se intentó eliminar el cliente con ID: ' . $id_cliente);

        $conn = new mysqli('localhost', 'root', '0895Gazuniga', 'dcafitness');
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Iniciar transacción
        $conn->begin_transaction();

        try {
            // 1. Eliminar pagos relacionados
            $sqlPagos = "DELETE FROM pagos WHERE id_cliente = ?";
            $stmtPagos = $conn->prepare($sqlPagos);
            $stmtPagos->bind_param("i", $id_cliente);
            $stmtPagos->execute();
            $stmtPagos->close();

            // 2. Eliminar cliente
            $sqlCliente = "DELETE FROM clientes WHERE id_cliente = ?";
            $stmtCliente = $conn->prepare($sqlCliente);
            $stmtCliente->bind_param("i", $id_cliente);
            $stmtCliente->execute();

            if ($stmtCliente->affected_rows > 0) {
                $conn->commit();
                $stmtCliente->close();
                $conn->close();
                echo "Cliente y sus pagos relacionados fueron eliminados correctamente.<br>";
                return true;
            } else {
                $conn->rollback();
                $stmtCliente->close();
                $conn->close();
                echo "No se encontró el cliente o no se pudo eliminar.<br>";
                return false;
            }

        } catch (Exception $e) {
            $conn->rollback();
            echo "Error al eliminar el cliente: " . $e->getMessage() . "<br>";
            return false;
        }
    }

    // ✅ Buscar clientes por nombre o cédula
    public function buscarClientes($term) {
        return $this->clienteModel->buscarClientes($term);
    }
}
?>
