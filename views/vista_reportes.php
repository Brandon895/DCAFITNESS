<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Puedes agregar la lógica de PHP si necesitas aquí
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes</title>
    <!-- Agregar Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilo general del cuerpo */
        body {
            background-image: url('../assets/img/imgdcafitness.jpg.jpg'); /* Verifica que el path sea correcto */
            background-size: cover;
            background-position: center center;
            background-attachment: fixed;
            color: #333;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            margin: 0;
        }

        /* Contenedor principal */
        .container {
            max-width: 700px;
            margin-top: 80px;
        }

        /* Estilo de la tarjeta */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            background: linear-gradient(135deg, #f5b500, #43d74f);
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

        /* Estilo de los campos de formulario */
        .form-label {
            font-weight: bold;
            font-size: 16px;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 12px;
            margin-bottom: 20px;
        }

        .form-control:focus {
            border-color: #43d74f;
            box-shadow: 0 0 5px rgba(67, 215, 79, 0.5);
        }

        /* Botón de reportes */
        .btn-custom {
            background-color: #43d74f;
            color: white;
            font-weight: bold;
            border: none;
            padding: 12px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #34c34f;
        }

        /* Botón de regresar al menú principal (Celeste) */
        .btn-regresar {
            background-color: #17a2b8; /* Celeste */
            color: white;
            font-weight: bold;
            border: none;
            padding: 12px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
            width: 50%;
            text-align: center;
        }

        .btn-regresar:hover {
            background-color: #138496; /* Celeste más oscuro */
        }

        /* Animación de entrada para la tarjeta */
        .card {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Contenedor centrado para el botón de regresar */
        .btn-regresar-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h2>Seleccione un Reporte</h2>
        </div>
        <div class="card-body">
            <!-- Formulario con botones para redirigir a cada tipo de reporte -->
            <form action="#" method="POST">
                <a href="VistaReporteClientes.php?controller=reporte&action=reporteClientes" class="btn btn-custom btn-lg w-100 mb-3">Reporte de Clientes</a>
                <a href="VistaReporteFacturas.php?controller=reporte&action=reporteFacturas" class="btn btn-custom btn-lg w-100 mb-3">Reporte de Facturas</a>
                <a href="vistareporterutinas.php?controller=reporte&action=reporteRutinas" class="btn btn-custom btn-lg w-100 mb-3">Reporte de Rutinas</a>
                <a href="VistaReporteProducto.php?controller=reporte&action=reporteproducto" class="btn btn-custom btn-lg w-100 mb-3">Reporte De Productos</a>
                
                <!-- Botón para regresar al menú principal con color celeste -->
                <div class="btn-regresar-container">
                    <a href="dashboard.php" class="btn btn-regresar">Regresar al Menú Principal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Agregar Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
