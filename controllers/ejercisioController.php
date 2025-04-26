<?php
require_once '../models/EjercisioModel.php';

class EjercicioController {

    private $model;

    public function __construct() {
        $this->model = new EjercicioModel();
    }

    // Método para crear ejercicios
    public function crearEjercicio($cedula, $ejercicios_data) {
        // Llamar al método del modelo para insertar
        return $this->model->insertarEjercicio($cedula, $ejercicios_data);
    }

    // Método para obtener ejercicios por cédula
    public function obtenerEjercicios($cedula) {
        return $this->model->obtenerEjerciciosPorCedula($cedula);
    }
}
?>
