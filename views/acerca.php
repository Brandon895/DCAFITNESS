<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acerca de - DCAFitness Center</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Estilo del body */
        body {
            background: url('../assets/img/imgdcafitness.jpg.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #ffffff;
            font-size: 18px;
            text-align: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: linear-gradient(45deg, #28a745, #ffc107); 
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            transition: all 0.3s ease;
            width: 70%;
            margin-left: auto;
            margin-right: auto;
            text-align: left; 
        }

        .container:hover {
            transform: translateY(-10px);
            box-shadow: 0px 15px 50px rgba(0, 0, 0, 0.2);
        }

        h2, h5 {
            font-weight: bold;
            color: #ffffff;
            font-size: 24px; 
        }

        .btn-container {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .btn-info {
            background-color: #007bff;
            border: none;
            border-radius: 10px;
            padding: 14px 30px;
            font-size: 18px;
            transition: all 0.3s ease;
            color: white;
            display: flex;
            align-items: center; 
            justify-content: center;
        }

        .btn-info:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .btn-info i {
            margin-right: 10px; 
        }

        ul {
            font-size: 20px;
            line-height: 1.8;
            margin: 0 auto;
            width: 70%;
        }

        li {
            padding: 5px 0;
        }

        p {
            font-size: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="titulo-icono"><i class="bi bi-info-circle"></i> Acerca de DCAFitness Center</h2>
        <p>
            El sistema de gestión para <strong>DCAFitness Center</strong> fue creado con el objetivo de facilitar el control interno del gimnasio, mejorando la eficiencia administrativa y brindando una mejor experiencia tanto al personal como a los clientes.
        </p>

        <h5>🧩 Funcionalidades principales</h5>
        <ul>
            <li>Gestión de usuarios, clientes y sus accesos</li>
            <li>Creación de rutinas y seguimiento físico</li>
            <li>Control de ventas, productos y facturación</li>
            <li>Bitácoras de actividades</li>
            <li>Reportes de rendimiento</li>
        </ul>

        <h5>👨‍💻 Desarrollado por</h5>
        <p>Este sistema fue desarrollado por Brandon Zuñiga Zuñiga como parte de un proyecto profesional de la Universidad Tecnológica Costarricense.</p>

        <h5>🛠 Versión</h5>
        <p>Versión 1.0 - Año 2025</p>

        <div class="btn-container">
            <a href="dashboard.php" class="btn btn-info">
                <i class="bi bi-arrow-left-circle"></i> Regresar al Menú Principal
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.js"></script>
</body>
</html>
