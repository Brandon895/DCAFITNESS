<?php
require_once __DIR__ . "/../models/db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_GET["action"]) && $_GET["action"] === "registrarIngreso") {
    header('Content-Type: application/json');

    $cedula = trim($_POST["cedula"] ?? '');

    if (empty($cedula)) {
        echo json_encode(["status" => "error", "mensaje" => "Debe ingresar una cédula."]);
        exit;
    }

    $sql = "SELECT id_cliente, fecha_vencimiento, nombre, apellidos FROM clientes WHERE cedula = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $cedula);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $id_cliente = $row['id_cliente'];
        $fecha_vencimiento = $row['fecha_vencimiento'];
        $nombre = $row['nombre'];
        $apellidos = $row['apellidos'];

        // Verificar si la membresía está vencida
        if ($fecha_vencimiento !== null && strtotime($fecha_vencimiento) < time()) {
            echo json_encode([
                "status" => "vencida",
                "mensaje" => "Membresía vencida. Por favor renovar la mensualidad."
            ]);
            exit;
        }

        // Registrar ingreso
        $sqlInsert = "INSERT INTO accesos (id_cliente, fecha_hora_entrada) VALUES (?, NOW())";
        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bind_param("i", $id_cliente);

        if ($stmtInsert->execute()) {
            echo json_encode([
                "status" => "exito",
                "mensaje" => "✅ Bienvenido $nombre $apellidos a DCAFitness Center. ¡Que disfrutes tu estadía!"
            ]);
        } else {
            echo json_encode(["status" => "error", "mensaje" => "Error al registrar el ingreso."]);
        }

        $stmtInsert->close();
    } else {
        echo json_encode(["status" => "error", "mensaje" => "Cliente no encontrado."]);
    }

    $stmt->close();
    $conn->close();
}
