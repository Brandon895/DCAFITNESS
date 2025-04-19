<?php
// Conexión a la base de datos
$mysqli = new mysqli("localhost", "root", "0895Gazuniga", "dcafitness");

if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

// Obtener productos desde la base de datos
$productos = [];
$query = "SELECT idProducto, nom_producto, precio_venta FROM productos";
$result = $mysqli->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
}

// Incluir el helper para la bitácora
require_once '../helpers/BitacoraHelper.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom_producto = $_POST['producto'];
    $cantidad = $_POST['cantidad'];
    $precio_venta = $_POST['precio_venta'];
    $fecha_venta = date('Y-m-d H:i:s');

    $sql = "INSERT INTO ventas_productos (nom_producto, cantidad, precio_venta, fecha_venta) 
            VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sdds", $nom_producto, $cantidad, $precio_venta, $fecha_venta);
    $stmt->execute();

    $accion = "Registró una venta del producto: $nom_producto, Cantidad: $cantidad, Precio: $precio_venta";
    BitacoraHelper::registrarMovimiento('Venta', $accion);

    header("Location: VistaVentaProducto.php?success=1");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Venta Producto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Cargar los iconos de Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* Estilo general del cuerpo */
        body {
            background-image: url('https://via.placeholder.com/1920x1080'); /* Aquí pon la URL de la imagen de fondo */
            background-size: cover;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            max-width: 700px;
            width: 100%;
            z-index: 1;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            background: linear-gradient(135deg, #f5b500, #43d74f);
            animation: fadeIn 1s ease-in-out;
        }

        .card-header {
            background-color: transparent;
            color: white;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            padding: 30px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .card-body {
            background-color: #ffffff;
            border-radius: 0 0 15px 15px;
            padding: 40px 30px;
        }

        .form-label {
            font-weight: bold;
            font-size: 16px;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 12px;
            margin-bottom: 20px;
            width: 100%;
        }

        .form-control:focus {
            border-color: #43d74f;
            box-shadow: 0 0 5px rgba(67, 215, 79, 0.5);
        }

        .btn {
            font-weight: bold;
            border: none;
            padding: 20px 60px;
            font-size: 18px;
            border-radius: 12px;
            transition: background-color 0.3s ease;
            text-align: center;
            display: inline-block;
            margin: 15px;
        }

        .btn-custom {
            background-color: #43d74f;
            color: white;
        }

        .btn-custom:hover {
            background-color: #34c34f;
        }

        .btn-cancel {
            background-color: #e74c3c;
            color: white;
            text-decoration: none;
        }

        .btn-cancel:hover {
            background-color: #c0392b;
        }

        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">Registrar Venta de Producto</div>
            <div class="card-body">
                <form method="POST" action="RegistrarVentaProducto.php">
                    <label class="form-label" for="producto">Seleccionar Producto:</label>
                    <select class="form-control" name="producto" id="producto" onchange="actualizarPrecio()" required>
                        <option value="">Seleccione un producto</option>
                        <?php foreach ($productos as $producto): ?>
                            <option value="<?= $producto['nom_producto'] ?>" data-precio="<?= $producto['precio_venta'] ?>">
                                <?= $producto['nom_producto'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <label class="form-label" for="cantidad">Cantidad:</label>
                    <input type="number" class="form-control" id="cantidad" name="cantidad" value="1" min="1" required>

                    <label class="form-label" for="precio_venta">Precio de Venta:</label>
                    <input type="text" class="form-control" id="precio_venta" name="precio_venta" readonly>

                    <label class="form-label" for="total">Total:</label>
                    <input type="text" class="form-control" id="total" name="total" readonly>

                    <button type="submit" class="btn btn-custom">
                        <i class="fas fa-check-circle"></i> Registrar Venta
                    </button>
                    <a href="VistaVentaProducto.php" class="btn btn-cancel">
                        <i class="fas fa-times-circle"></i> Cancelar
                    </a>
                </form>
            </div>
        </div>
    </div>

    <script>
        function actualizarPrecio() {
            var productoSeleccionado = document.getElementById("producto").selectedOptions[0];
            var precioVenta = productoSeleccionado.getAttribute("data-precio");
            document.getElementById("precio_venta").value = precioVenta;
            calcularTotal();
        }

        function calcularTotal() {
            var cantidad = document.getElementById("cantidad").value;
            var precioVenta = document.getElementById("precio_venta").value;
            var total = cantidad * precioVenta;
            document.getElementById("total").value = total.toFixed(2);
        }

        document.getElementById("cantidad").addEventListener("input", calcularTotal);
    </script>
</body>
</html>
