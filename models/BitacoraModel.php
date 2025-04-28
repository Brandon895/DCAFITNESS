<?php
class BitacoraModel {
    private $db;

    public function __construct() {
        // Obtener la URL de la base de datos desde la variable de entorno
        $database_url = getenv('DATABASE_URL');

        // Parsear la URL para obtener los detalles de la conexión
        $parsed_url = parse_url($database_url);

        // Extraer los datos de la URL
        $servername = $parsed_url['host'];      // sql206.infinityfree.com
        $username = $parsed_url['user'];       // if0_38849919
        $password = $parsed_url['pass'];       // 0895Gazuniga
        $database = ltrim($parsed_url['path'], '/'); // if0_38849919_XXX

        // Establecer la conexión
        $this->db = new mysqli($servername, $username, $password, $database);

        // Verificar la conexión
        if ($this->db->connect_error) {
            die("Error en la conexión: " . $this->db->connect_error);
        }
    }

    // Método para registrar un movimiento
    public function registrarMovimiento($usuario, $accion) {
        $stmt = $this->db->prepare("INSERT INTO BITACORA_MOVIMIENTOS (usuario, accion) VALUES (?, ?)");
        $stmt->bind_param("ss", $usuario, $accion);
        $stmt->execute();
        $stmt->close();
    }

    // Método para obtener todos los movimientos
    public function obtenerMovimientos() {
        $sql = "SELECT * FROM BITACORA_MOVIMIENTOS ORDER BY fecha DESC";
        return $this->db->query($sql);
    }
}
?>
