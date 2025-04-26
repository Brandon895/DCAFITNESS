<?php
require_once '../models/RutinaModel.php'; 

class RutinaController {
    private $model;

    public function __construct() {
        $this->model = new RutinaModel();
    }

    // Método para obtener todas las rutinas
    public function listarRutinas() {
        return $this->model->obtenerRutinas(); // Llamamos al modelo para obtener las rutinas
    }

    // Método para guardar una rutina
    public function guardarRutina() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Recibimos y limpiamos los datos del formulario
            $cedula = trim($_POST['cedula']);
            $nomrutina = trim($_POST['nomrutina']);
            $cantidadsesiones = (int) $_POST['cantidadsesiones'];

            // Validación básica de los datos
            if (empty($cedula) || empty($nomrutina) || $cantidadsesiones <= 0) {
                echo "<p style='color: red;'>❌ Todos los campos son obligatorios.</p>";
                return;
            }

            // Llamamos al modelo para insertar la rutina
            $resultado = $this->model->insertarRutina($cedula, $nomrutina, $cantidadsesiones);

            if ($resultado) {
                // Si todo salió bien, redirigimos a la página de listado
                header("Location: VistaRutinas.php"); // Redirigir a la vista de rutinas
                exit();
            } else {
                echo "<p style='color: red;'>❌ Error al guardar la rutina.</p>";
            }
        }
    }
    public function verificarClienteInscrito($cedula) {
        global $conn;  
        
        // Consulta para verificar si el cliente está inscrito
        $consulta = "SELECT COUNT(*) FROM clientes WHERE cedula = ?";
        
        // Preparar y ejecutar la consulta
        if ($stmt = $conn->prepare($consulta)) {
            // Asociamos el parámetro
            $stmt->bind_param("s", $cedula);  // "s" indica que es un parámetro tipo string
            
            // Ejecutar la consulta
            $stmt->execute();
            
            // Obtener el resultado
            $stmt->bind_result($count);  
            $stmt->fetch();
            
            // Si el contador es mayor que 0, significa que el cliente está inscrito
            return $count > 0;
            
            $stmt->close();
        } else {
            // Si hubo un error en la preparación de la consulta
            echo "Error al preparar la consulta: " . $conn->error;
            return false;
        }
    }
    

    // Método para obtener una rutina por su ID
    public function obtenerRutinaPorId($id_rutina) {
        return $this->model->obtenerRutinaPorId($id_rutina);
    }

    // Método para actualizar una rutina
    public function actualizarRutina() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_rutina'])) {
            $id_rutina = (int) $_POST['id_rutina'];
            $cedula = trim($_POST['cedula']);
            $nomrutina = trim($_POST['nomrutina']);
            $cantidadsesiones = (int) $_POST['cantidadsesiones'];

            if (empty($cedula) || empty($nomrutina) || $cantidadsesiones <= 0) {
                echo "<p style='color: red;'>❌ Todos los campos son obligatorios para actualizar.</p>";
                return;
            }

            $resultado = $this->model->actualizarRutina($id_rutina, $cedula, $nomrutina, $cantidadsesiones);

            if ($resultado) {
                header("Location: VistaRutinas.php");
                exit();
            } else {
                echo "<p style='color: red;'>❌ Error al actualizar la rutina.</p>";
            }
        }
    }
    // Método para eliminar una rutina
    public function eliminarRutina($id_rutina) {
        // Llamamos al modelo para eliminar la rutina
        return $this->model->eliminarRutina($id_rutina);
    }
}
?>
