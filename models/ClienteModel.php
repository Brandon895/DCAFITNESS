<?php
class ClienteModel {
    private $conn;

    public function __construct() {
        $host = "sql3.freesqldatabase.com";
        $user = "sql3776084";
        $password = "vqri3ry8GD";
        $dbname = "sql3776084";

        $this->conn = new mysqli($host, $user, $password, $dbname, 3306);

        if ($this->conn->connect_error) {
            die("Error de conexión a la base de datos: " . $this->conn->connect_error);
        }
    }

    public function obtenerTodosLosClientes() {
        $sql = "SELECT * FROM clientes";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerClientePorCedula($cedula) {
        $sql = "SELECT * FROM clientes WHERE cedula = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $cedula);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function obtenerClientePorId($id_cliente) {
        $sql = "SELECT * FROM clientes WHERE id_cliente = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_cliente);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function actualizarCliente($id_cliente, $data) {
        $sql = "UPDATE clientes SET 
                    cedula = ?, nombre = ?, apellidos = ?, direccion = ?, telefono = ?, 
                    correo_electronico = ?, fecha_nacimiento = ?, estado_membresia = ?, 
                    tipo_membresia = ?, fecha_vencimiento = ? 
                WHERE id_cliente = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssssssssi", 
            $data['cedula'], $data['nombre'], $data['apellidos'], $data['direccion'], 
            $data['telefono'], $data['correo_electronico'], $data['fecha_nacimiento'], 
            $data['estado_membresia'], $data['tipo_membresia'], $data['fecha_vencimiento'], 
            $id_cliente);
        return $stmt->execute();
    }

    public function insertarCliente($data) {
        // Validación del estado de membresía
        $estado_membresia = in_array($data['estado_membresia'], ["activo", "inactivo", "expirado"]) 
                            ? $data['estado_membresia'] : "activo";

        $sql = "INSERT INTO clientes 
                (cedula, nombre, apellidos, direccion, telefono, correo_electronico, 
                 fecha_nacimiento, estado_membresia, tipo_membresia, fecha_vencimiento) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Error al preparar la consulta: " . $this->conn->error); // Si no puede preparar la consulta
        }

        $stmt->bind_param("ssssssssss", 
            $data['cedula'], $data['nombre'], $data['apellidos'], $data['direccion'], 
            $data['telefono'], $data['correo_electronico'], $data['fecha_nacimiento'], 
            $estado_membresia, $data['tipo_membresia'], $data['fecha_vencimiento']);

        if ($stmt->execute()) {
            return true; // Inserción exitosa
        } else {
            // Mostrar el error detallado
            error_log("Error al ejecutar la consulta: " . $stmt->error); // Registra el error en el log
            return false; // Inserción fallida
        }
    }

    public function registrarPago($id_cliente, $monto, $metodo_pago, $descripcion) {
        $fecha_pago = date("Y-m-d H:i:s");
        $sql = "INSERT INTO pagos (id_cliente, monto, metodo_pago, descripcion, fecha_pago) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iisss", $id_cliente, $monto, $metodo_pago, $descripcion, $fecha_pago);
        return $stmt->execute();
    }

    public function verificarMembresia($cedula) {
        $sql = "SELECT nombre, fecha_vencimiento FROM clientes WHERE cedula = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $cedula);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();

        if (!$resultado) {
            return ["status" => "error", "mensaje" => "Cliente no encontrado"];
        }

        if (strtotime($resultado['fecha_vencimiento']) < time()) {
            return ["status" => "denegado", "mensaje" => "Acceso denegado: Mensualidad vencida"];
        }

        return ["status" => "permitido", "mensaje" => "Bienvenido, " . $resultado['nombre']];
    }

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

        return $stmt->execute()
            ? ["status" => "exito", "mensaje" => $estado['mensaje']]
            : ["status" => "error", "mensaje" => "Error al registrar el acceso"];
    }

    public function eliminarCliente($id_cliente) {
        // Eliminar primero los pagos relacionados
        $sqlPagos = "DELETE FROM pagos WHERE id_cliente = ?";
        $stmtPagos = $this->conn->prepare($sqlPagos);
        $stmtPagos->bind_param("i", $id_cliente);
        $stmtPagos->execute();
        $stmtPagos->close();

        // Luego eliminar el cliente
        $sqlCliente = "DELETE FROM clientes WHERE id_cliente = ?";
        $stmtCliente = $this->conn->prepare($sqlCliente);
        $stmtCliente->bind_param("i", $id_cliente);
        $stmtCliente->execute();
        $success = $stmtCliente->affected_rows > 0;
        $stmtCliente->close();

        return $success;
    }

    public function buscarClientes($term) {
        $termLike = '%' . $term . '%';
        $sql = "SELECT * FROM clientes WHERE nombre LIKE ? OR cedula LIKE ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $termLike, $termLike);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

?>
