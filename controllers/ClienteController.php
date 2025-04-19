<?php
require_once '../models/ClienteModel.php';
require_once '../helpers/BitacoraHelper.php'; // Asegúrate de incluir el helper

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

    // Método para eliminar un cliente
    public function eliminarCliente($id_cliente) {
        // Registrar movimiento en la bitácora antes de eliminar el cliente
        BitacoraHelper::registrarMovimiento('se elimino un cliente', 'Cliente', 'Se eliminó un cliente con ID: ' . $id_cliente);

        // Conectar a la base de datos (ajusta según tu configuración)
        $conn = new mysqli('localhost', 'root', '0895Gazuniga', 'dcafitness');
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // 1. Eliminar los pagos relacionados con el cliente
        $sqlPagos = "DELETE FROM pagos WHERE id_cliente = ?";
        $stmtPagos = $conn->prepare($sqlPagos);
        $stmtPagos->bind_param("i", $id_cliente);
        $stmtPagos->execute();

        // Verificar si se eliminaron los pagos correctamente
        if ($stmtPagos->affected_rows > 0) {
            echo "Registros de pagos eliminados correctamente.<br>";
        } else {
            echo "No se encontraron pagos relacionados para eliminar.<br>";
        }

        // 2. Ahora eliminar el cliente de la tabla clientes
        $sqlCliente = "DELETE FROM clientes WHERE id_cliente = ?";
        $stmtCliente = $conn->prepare($sqlCliente);
        $stmtCliente->bind_param("i", $id_cliente);
        $stmtCliente->execute();

        // Verificar si el cliente fue eliminado
        if ($stmtCliente->affected_rows > 0) {
            // Cerrar las sentencias y conexión
            $stmtCliente->close();
            $stmtPagos->close();
            $conn->close();
            
            // Retornar éxito
            echo "Cliente eliminado correctamente.<br>";
            return true;
        } else {
            // Si no se pudo eliminar el cliente
            $stmtCliente->close();
            $stmtPagos->close();
            $conn->close();
            
            echo "No se pudo eliminar el cliente. Puede que tenga pagos pendientes o restricciones.<br>";
            return false;
        }
    }

    // Método para buscar clientes por nombre o cédula
    public function buscarClientes($term) {
        return $this->clienteModel->buscarClientes($term);
    }
}
?>
