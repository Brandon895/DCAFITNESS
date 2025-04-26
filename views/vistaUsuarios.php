<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            background: url('../assets/img/imgdcafitness.jpg.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #ffffff; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            background: linear-gradient(45deg, #28a745, #ffc107); 
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            transition: all 0.3s ease;
        }

        .container:hover {
            transform: translateY(-10px);
            box-shadow: 0px 15px 50px rgba(0, 0, 0, 0.2);
        }

        .table thead {
            background-color: #28a745; 
            color: white;
            border-radius: 10px;
        }

        .table tbody tr:nth-of-type(odd) {
            background-color: #e2f9e2; 
        }

        .table tbody tr:nth-of-type(even) {
            background-color: #fff; 
        }

        .table tbody tr:hover {
            background-color: #d3f5d3; 
        }

        /* Botones personalizados */
        .btn-blue {
            background-color: #007bff; 
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            font-size: 16px;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-blue:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .btn-green {
            background-color: #28a745; 
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            font-size: 16px;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-green:hover {
            background-color: #1e7e34;
            transform: scale(1.05);
        }

        .btn-yellow {
            background-color: #ffc107; 
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            font-size: 16px;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-yellow:hover {
            background-color: #e0a800;
            color: white; 
            transform: scale(1.05);
        }

        .btn-danger {
            background-color: #dc3545; 
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            font-size: 16px;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #c82333;
            transform: scale(1.05);
        }

        .btn-sm {
            padding: 8px 18px;
        }

        h2, h5 {
            font-weight: bold;
            text-transform: uppercase;
            color: #ffffff; 
        }

        .d-flex {
            justify-content: space-between;
            margin-bottom: 25px;
        }

        .badge {
            font-size: 14px;
        }

        /* Efecto de borde redondeado para la tabla */
        .table-bordered {
            border-radius: 15px;
            overflow: hidden;
        }

        .table-bordered th, .table-bordered td {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
        }

        .table-responsive {
            margin-top: 30px;
        }

    </style>
</head>
<body>

    <div class="container">
        <h2 class="text-center mb-4">
            <i class="bi bi-people-fill"></i> Gestión de Usuarios
        </h2>

        <!-- Botón para volver al dashboard -->
        <div class="d-flex justify-content-between mb-3">
            <a href="dashboard.php" class="btn btn-blue">
                <i class="bi bi-house-door-fill"></i> Regresar al menu principal
            </a>
            <h5 class="text-muted">Lista de Usuarios</h5>
            <a href="registrar_usuario.php" class="btn btn-green">
                <i class="bi bi-person-plus-fill"></i> Registrar Usuario
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre Completo</th> 
                        <th>Nombre Usuario</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once '../models/UsuarioModel.php';
                    $usuarios = UsuarioModel::obtenerUsuarios();

                    if ($usuarios) {
                        foreach ($usuarios as $usuario) {
                            echo "<tr>";
                            echo "<td><i class='bi bi-person-circle'></i> " . htmlspecialchars($usuario['id'] ?? 'No disponible') . "</td>";
                            echo "<td>" . htmlspecialchars($usuario['nombrecompleto'] ?? 'No disponible') . "</td>"; 
                            echo "<td>" . htmlspecialchars($usuario['nombreusuario'] ?? 'No disponible') . "</td>";
                            echo "<td><span class='badge bg-success'>" . htmlspecialchars($usuario['rol'] ?? 'No disponible') . "</span></td>";
                            echo "<td>
                                    <a href='editar_usuario.php?id=" . htmlspecialchars($usuario['id'] ?? '') . "' class='btn btn-yellow btn-sm'>
                                        <i class='bi bi-pencil-square'></i> Editar
                                    </a>
                                    <a href='inactivarUsuario.php?id=" . htmlspecialchars($usuario['id'] ?? '') . "' class='btn btn-danger btn-sm'>
                                        <i class='bi bi-x-circle'></i> Inactivar
                                    </a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center text-danger'>No hay usuarios registrados.</td></tr>"; 
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

