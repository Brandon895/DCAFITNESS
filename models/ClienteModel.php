<?php
class ClienteModel {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "0895Gazuniga", "dcafitness");

        if ($this->conn->connect_error) {
            die("Conexión fallida: " . $this->conn->connect_error);
        }
    }

    // ✅ Obtener todos los clientes
    public function obtenerTodosLosClientes() {
        $sql = "SELECT * FROM clientes";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // ✅ Obtener cliente por cédula
    public function obtenerClientePorCedula($cedula) {
        $sql = "SELECT * FROM clientes WHERE cedula = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $cedula);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // ✅ Obtener cliente por ID
    public function obtenerClientePorId($id_cliente) {
        $sql = "SELECT * FROM clientes WHERE id_cliente = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_cliente);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();  // Devuelve un solo cliente por ID
    }

    // ✅ Actualizar cliente
    public function actualizarCliente($id_cliente, $data) {
        $sql = "UPDATE clientes SET 
                    cedula = ?, 
                    nombre = ?, 
                    apellidos = ?, 
                    direccion = ?, 
                    telefono = ?, 
                    correo_electronico = ?, 
                    fecha_nacimiento = ?, 
                    estado_membresia = ?, 
                    tipo_membresia = ?, 
                    fecha_vencimiento = ? 
                WHERE id_cliente = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "ssssssssssi", 
            $data['cedula'], 
            $data['nombre'], 
            $data['apellidos'], 
            $data['direccion'], 
            $data['telefono'], 
            $data['correo_electronico'], 
            $data['fecha_nacimiento'], 
            $data['estado_membresia'], 
            $data['tipo_membresia'], 
            $data['fecha_vencimiento'],
            $id_cliente
        );

        return $stmt->execute();
    }

    // ✅ Insertar nuevo cliente (con validación de estado_membresia)
    public function insertarCliente($data) {
        $estados_permitidos = ["activo", "inactivo", "expirado"];
        $estado_membresia = in_array($data['estado_membresia'], $estados_permitidos) ? $data['estado_membresia'] : "activo";

        $sql = "INSERT INTO clientes (cedula, nombre, apellidos, direccion, telefono, correo_electronico, fecha_nacimiento, estado_membresia, tipo_membresia, fecha_vencimiento) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "ssssssssss", 
            $data['cedula'], 
            $data['nombre'], 
            $data['apellidos'], 
            $data['direccion'], 
            $data['telefono'], 
            $data['correo_electronico'], 
            $data['fecha_nacimiento'], 
            $estado_membresia, 
            $data['tipo_membresia'], 
            $data['fecha_vencimiento']
        );

        return $stmt->execute();
    }
    public function registrarPago($id_cliente, $monto, $metodo_pago, $descripcion) {
        $fecha_pago = date("Y-m-d H:i:s"); // Obtener la fecha y hora actual
        
        // Insertar el pago en la base de datos
        $sql = "INSERT INTO pagos (id_cliente, monto, metodo_pago, descripcion, fecha_pago) 
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iisss", $id_cliente, $monto, $metodo_pago, $descripcion, $fecha_pago);

        // Ejecutar la consulta y verificar si fue exitosa
        if ($stmt->execute()) {
            return true; // Pago registrado exitosamente
        } else {
            return false; // Error al registrar el pago
        }
    }

    // ✅ Verificar membresía
    public function verificarMembresia($cedula) {
        $sql = "SELECT nombre, fecha_vencimiento FROM clientes WHERE cedula = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $cedula);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();

        if (!$resultado) {
            return ["status" => "error", "mensaje" => "Cliente no encontrado"];
        }

        $nombre = $resultado['nombre'];
        $fecha_vencimiento = $resultado['fecha_vencimiento'];

        if (strtotime($fecha_vencimiento) < time()) {
            return ["status" => "denegado", "mensaje" => "Acceso denegado: Mensualidad vencida"];
        }

        return ["status" => "permitido", "mensaje" => "Bienvenido, $nombre"];
    }

    // ✅ Registrar acceso del cliente
    public function registrarAcceso($cedula) {
        $estado = $this->verificarMembresia($cedula);
        if ($estado['status'] !== "permitido") {
            return $estado;
        }

        $sql = "SELECT id_cliente FROM clientes WHERE cedula = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $cedula);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();

        if (!$resultado) {
            return ["status" => "error", "mensaje" => "Cliente no encontrado"];
        }

        $id_cliente = $resultado['id_cliente'];
        $fecha_hora_entrada = date("Y-m-d H:i:s");

        $sql = "INSERT INTO accesos (id_cliente, fecha_hora_entrada) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("is", $id_cliente, $fecha_hora_entrada);
        
        if ($stmt->execute()) {
            return ["status" => "exito", "mensaje" => $estado['mensaje']];
        } else {
            return ["status" => "error", "mensaje" => "Error al registrar el acceso"];
        }
    }

    // ✅ Eliminar cliente (y pagos asociados)
    public function eliminarCliente($id_cliente) {
        // 1. Eliminar los pagos relacionados con el cliente
        $sqlPagos = "DELETE FROM pagos WHERE id_cliente = ?";
        $stmtPagos = $this->conn->prepare($sqlPagos);
        $stmtPagos->bind_param("i", $id_cliente);
        $stmtPagos->execute();

        // Verificar si se eliminaron los pagos correctamente
        if ($stmtPagos->affected_rows > 0) {
            // Eliminación exitosa
        } else {
            // No se encontraron pagos relacionados para eliminar
        }

        // 2. Eliminar el cliente de la tabla clientes
        $sqlCliente = "DELETE FROM clientes WHERE id_cliente = ?";
        $stmtCliente = $this->conn->prepare($sqlCliente);
        $stmtCliente->bind_param("i", $id_cliente);
        $stmtCliente->execute();

        // Verificar si el cliente fue eliminado
        if ($stmtCliente->affected_rows > 0) {
            // Cliente eliminado correctamente
            return true;
        } else {
            // Si no se pudo eliminar el cliente
            return false;
        }
    }
    // ✅ Buscar clientes por nombre (o parte del nombre)
    public function buscarClientes($nombre) {
        $sql = "SELECT * FROM clientes WHERE nombre LIKE ?";
        $stmt = $this->conn->prepare($sql);
        $busqueda = "%" . $nombre . "%";  // Buscar por parte del nombre
        $stmt->bind_param("s", $busqueda);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
