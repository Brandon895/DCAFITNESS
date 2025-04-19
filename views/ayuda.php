<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ayuda - DCAFitness Center</title>
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
        }

        .container {
            background: linear-gradient(45deg, #28a745, #ffc107); /* Colores verde y amarillo */
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .container:hover {
            transform: translateY(-10px);
            box-shadow: 0px 15px 50px rgba(0, 0, 0, 0.2);
        }

        h2, h5 {
            text-align: center;
            font-weight: bold;
            color: #ffffff;
        }

        .btn-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .btn-info {
            background-color: #007bff;
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            font-size: 16px;
            transition: all 0.3s ease;
            color: white;
            display: flex;
            align-items: center; /* Alinea el icono y el texto */
            justify-content: center;
        }

        .btn-info:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .btn-info i {
            margin-right: 10px; /* Espacio entre el icono y el texto */
        }

        ul {
            font-size: 18px;
            line-height: 1.6;
            margin: 20px 0;
        }

        li {
            padding: 5px 0;
        }

        p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .section-title {
            margin-top: 30px;
            font-size: 22px;
            font-weight: bold;
        }

        .section-content {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="titulo-icono"><i class="bi bi-question-circle"></i> Ayuda del Sistema</h2>

        <div class="section-content">
            <h5 class="section-title">✅ ¿Cómo navegar por el sistema?</h5>
            <ul>
                <li><strong>Inicio:</strong> Página principal para ingresar al sistema.</li>
                <li><strong>Login:</strong> Ingreso seguro con usuario y contraseña.</li>
                <li><strong>Menú Principal:</strong> Desde ahí accedés a todas las funciones del sistema.</li>
            </ul>
        </div>

        <div class="section-content">
            <h5 class="section-title">📘 Asistencia por módulo</h5>
            <ul>
                <li><strong>Usuarios:</strong> Administración de accesos y permisos.</li>
                <li><strong>Clientes:</strong> Registro y modificación de datos de clientes.</li>
                <li><strong>Rutinas:</strong> Asignación y modificación de planes de ejercicio.</li>
                <li><strong>Medidas:</strong> Registro de peso, grasa corporal y más.</li>
                <li><strong>Productos:</strong> Gestión de inventario y ventas.</li>
                <li><strong>Pagos y Facturación:</strong> Registro de pagos, control de ingresos.</li>
                <li><strong>Reportes:</strong> Generación de reportes por fechas o cliente.</li>
                <li><strong>Bitácoras:</strong> Visualización de entradas, salidas y cambios.</li>
            </ul>
        </div>

        <div class="section-content">
            <h5 class="section-title">🛟 ¿Problemas comunes?</h5>
            <ul>
                <li>Verificá que tus credenciales sean correctas.</li>
                <li>Revisá tu conexión a internet o el navegador.</li>
                <li>Si el sistema no responde, contactá a soporte.</li>
            </ul>
        </div>

        <div class="section-content">
            <h5 class="section-title">📩 Contacto</h5>
            <p>Para más ayuda escribí a: <strong>papadoo19@yahoo.com</strong></p>
        </div>

        <div class="btn-container">
            <a href="dashboard.php" class="btn btn-info">
                <i class="bi bi-arrow-left-circle"></i> Regresar al Menú Principal
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.js"></script>
</body>
</html>
