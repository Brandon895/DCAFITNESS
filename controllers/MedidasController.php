<?php
include($_SERVER['DOCUMENT_ROOT'] . '/mi_gimnasio/DCAFITNESS/Proyecto/models/MedidasModel.php'); // Incluye el modelo de Medidas

class MedidasController {
    private $medidasModel;

    public function __construct() {
        $this->medidasModel = new MedidasModel(); // Inicializa el modelo de Medidas
    }

    // Obtener todas las medidas
    public function obtenerMedidas() {
        return $this->medidasModel->obtenerMedidas();
    }

    // Obtener una medida por ID (para editar)
    public function obtenerMedidaPorId($idMedida) {
        return $this->medidasModel->obtenerMedidaPorId($idMedida);
    }

    // Crear una nueva medida
    public function crearMedida($cedula, $fecha_medicion, $peso, $altura, $porcentaje_grasa, $circunferencia_cintura, $circunferencia_biceps, $circunferencia_triceps, $circunferencia_muslo, $circunferencia_pantorrilla) {
        $conexion = new mysqli("localhost", "root", "0895Gazuniga", "dcafitness");

        if ($conexion->connect_error) {
            die("Conexión fallida: " . $conexion->connect_error);
        }

        $query = "SELECT cedula FROM clientes WHERE cedula = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("s", $cedula);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado && $resultado->num_rows > 0) {
            return $this->medidasModel->crearMedida($cedula, $fecha_medicion, $peso, $altura, $porcentaje_grasa, $circunferencia_cintura, $circunferencia_biceps, $circunferencia_triceps, $circunferencia_muslo, $circunferencia_pantorrilla);
        } else {
            return false;
        }
    }

    // Actualizar una medida existente
    public function actualizarMedida($idMedida, $cedula, $fecha_medicion, $peso, $altura, $porcentaje_grasa, $circunferencia_cintura, $circunferencia_biceps, $circunferencia_triceps, $circunferencia_muslo, $circunferencia_pantorrilla) {
        $conexion = new mysqli("localhost", "root", "0895Gazuniga", "dcafitness");

        if ($conexion->connect_error) {
            die("Conexión fallida: " . $conexion->connect_error);
        }

        $query = "SELECT cedula FROM clientes WHERE cedula = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("s", $cedula);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado && $resultado->num_rows > 0) {
            $resultado = $this->medidasModel->actualizarMedida($idMedida, $cedula, $fecha_medicion, $peso, $altura, $porcentaje_grasa, $circunferencia_cintura, $circunferencia_biceps, $circunferencia_triceps, $circunferencia_muslo, $circunferencia_pantorrilla);
            
            if ($resultado) {
                header("Location: VistaMedidas.php");
                exit();
            }
            return $resultado;
        } else {
            return false;
        }
    }

    // Nueva función para eliminar una medida
    public function eliminarMedida($idMedida) {
        return $this->medidasModel->eliminarMedida($idMedida);
    }
}
?>
