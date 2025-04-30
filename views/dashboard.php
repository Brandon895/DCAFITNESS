<?php
include_once(__DIR__ . '/../controllers/dashboardcontroller.php');

include __DIR__ . '/../controllers/ClienteController.php';



$clienteController = new ClienteController();

// Obtener la cantidad de clientes registrados
$total_clientes = $clienteController->obtenerClientes();

$dashboard = new DashboardController();
$dashboard->verificarSesion();
$rol = $dashboard->obtenerRol();
$usuario = ($rol == 'administrador') ? 'Administrador' : 'Entrenador'; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <style>
        /* Sidebar */
        .header-custom {
            background-color: yellow !important;
            color: #28a745 !important;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }
        .header-custom .logo-text {
            font-size: 30px;
            font-weight: bold;
        }
        .header-custom .user-role {
            font-size: 18px;
            color: #28a745;
            font-weight: bold;
            cursor: pointer;
        }
        .header-custom .social-icons a {
            color: black;
            margin-left: 10px;
            font-size: 20px;
        }*/

        /* Estilo de las opciones del dropdown */
        .dropdown-menu {
            background-color: yellow;
            color: black;
        }

        .sidebar {
            background-color: yellow; /* Amarillo */
            top: 75px; 
            left: 0;
            height: calc(100% - 60px);
            padding: 20px;
            color: #28a745;
            position: fixed;
            width: 250px;
            overflow-y: auto; 
            max-height: 100vh; 

            
        }

        .sidebar::-webkit-scrollbar {
            width: 8px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #28a745; 
            border-radius: 4px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: black; 
        }

        .sidebar h2 {
            text-align: center;
            font-size: 22px;
            margin-bottom: 20px;
            color: #333;
            background-color: #28a745;
            padding: 10px;
            border-radius: 10px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
            padding: 12px;
            margin-bottom: 10px;
            background-color: #28a745;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .sidebar a i {
            margin-right: 10px;
        }

        .sidebar a:hover {
            background-color: black;
            transform: scale(1.05);
        }

        /* Contenido Principal */
        .content {
            margin-left: 260px;
            padding: 20px;
            background-image: url('../assets/img/imgdcafitness.jpg.jpg'); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .card-custom {
            border-radius: 10px;
            box-shadow: 6px 6px 6px 6px #28a745;
            transition: all 0.3s ease;
            color: black;
        }

        .card-custom:hover {
            transform: translateY(-5px);
        }

        /* Botón Personalizado */
        .btn-custom {
            background-color: black; 
            color: white;
            border: none;
        }

        .btn-custom:hover {
            background-color: #28a745;
            color: white;
        }
        


        /* Footer */
        .footer {
            margin-top: 480px;
            text-align: center;
            font-size: 20px;
            color: #555;
        }
    
    .dropdown-item:hover {
        background-color:black;
        color: #28a745;
        border: none;
    }
     
    .social-icons {
    position: relative;
    top: 02px;  
    right: 10px; 
    display: flex;
    gap: 03px; 
}

.social-icons a {
    width: 35px;
    height: 35px;
    background-color: #25D366; 
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-size: 24px;
    text-decoration: none;
    box-shadow: 2px 2px 5px rgba(0,0,0,0.3);
    transition: background 0.3s;
}

.social-icons a.facebook {
    background-color: #1877f2; 
}

.social-icons a.whatsapp:hover {
    background-color: #1ebe57; 
}

.social-icons a.facebook:hover {
    background-color: #0d5dbb;
}
.social-icons a.instagram {
    background: linear-gradient(45deg, #fccc63, #bc1888, #e1306c); 
}

.social-icons a.instagram:hover {
    background: linear-gradient(45deg, #e4405f, #bc2a8d, #fd1d1d);
}


    </style>
</head>
<body>

<header class="header-custom text-dark text-center py-3">
    
    <h2><i class="fas fa-dumbbell"></i>DCA FITNESS CENTER</h2>
    <div class="dropdown">
    <span class="user-role dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
        <?php echo $usuario; ?> 
    </span>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <li><a class="dropdown-item" href="#" onclick="redirigirLogin()">Cambiar Usuario</a></li>
    </ul>
</div>



    <!-- Iconos de redes sociales después del nombre de usuario -->
    <div class="social-icons">
    <a href="https://wa.me/50687933468" target="_blank" class="whatsapp">
        <i class="fab fa-whatsapp"></i>
    </a>
    <a href="https://www.facebook.com/brandon.zunigazuniga" target="_blank" class="facebook">
        <i class="fab fa-facebook"></i>
    </a>
    <a href="https://www.instagram.com/tu.usuario" target="_blank" class="instagram">
        <i class="fab fa-instagram"></i>
    </a>
</div>
        
    </div>
</header>

<div class="container-fluid">
    <div class="row">
    <nav class="sidebar">    
    <a href="#"><i class="fas fa-home"></i> Inicio</a>
    <?php if ($rol == 'administrador'): ?>
        <a href="vistaUsuarios.php"><i class="fas fa-users"></i> Gestión de Usuarios</a>
        <a href="Vista_Reportes.php"><i class="fas fa-chart-bar"></i> Reportes</a>
        <a href="VistaProductos.php"><i class="fas fa-box"></i> Productos</a>
    <?php endif; ?>
    <?php if ($rol == 'entrenador' || $rol == 'administrador'): ?>
        <a href="VistaProgresoFisico.php"><i class="fas fa-running"></i> Progreso Físico</a>
        <a href="Clientes.php"><i class="fas fa-user"></i> Clientes</a>
        <a href="VistaRutinas.php"><i class="fas fa-dumbbell"></i> Rutinas</a>
        <a href="VistaMedidas.php"><i class="fas fa-ruler"></i> Medidas</a>
    <?php endif; ?>

    <?php if ($rol == 'administrador'): ?>
        <a href="Vistarealizar_pago.php"><i class="fas fa-file-invoice"></i>Pagos</a>
        <a href="VistaFacturacion.php"><i class="fas fa-file-invoice"></i> Facturacion</a>
        <a href="VistaVentaProducto.php"><i class="fa-solid fa-boxes-stacked"></i> Ventas de Productos</a>
        <a href="Vistabitacora.php"><i class="fas fa-history"></i> Bitácora de Movimientos</a>
        <a href="VistaIngreso.php"><i class="fas fa-lock"></i> Acceso</a>
        <a href="Bitacora_Accesos.php"><i class="fas fa-lock"></i> Bitácora de Accesos</a>
    <?php endif; ?>

    <a href="acerca.php"><i class="fas fa-info-circle"></i> Acerca de</a>
    <a href="/mi_gimnasio/DCAFITNESS/Proyecto/assets/PDF/manual_usuario.pdf" target="_blank">
  <i class="fas fa-question-circle"></i> Ayuda
</a>


 <a href="../views/logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>

    <a href="#" onclick="cerrarSesion()"><i class="fas fa-door-open"></i> Salir</a>
</nav>

</a>

            
        </nav>

        <!-- Contenido principal -->
        <main class="col content">
            <h3 class="mb-4">Módulos disponibles:</h3>

            <div class="row">
            <div class="col-md-4">
    <div class="card card-custom p-3">
        <h5><i class="fas fa-user"></i> Clientes Registrados</h5>
        <p>Actualmente hay <strong><?php echo count($total_clientes); ?></strong> clientes activos.</p>
    </div>
</div>


               <!-- <div class="col-md-4">
                    <div class="card card-custom p-3">
                        <h5><i class="fas fa-dumbbell"></i> Rutinas realizadas</h5>
                        <p>Hoy hay <strong></strong> Rutinas Realizadas.</p>
                        <button class="btn btn-custom">Ver más</button>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-custom p-3">
                        <h5><i class="fas fa-chart-line"></i> Estadísticas</h5>
                        <p>Reporte semanal actualizado.</p>
                        <button class="btn btn-custom">Ver más</button>
                    </div>
                </div>
            </div>-->

            <div class="footer">
                <p>&copy; 2025 DCA FITNESS CENTER. Todos los derechos reservados.</p>
            </div>
        </main>
    </div>
</div>

<!-- Scripts de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script para redirigir al login -->
    <script>
    function redirigirLogin() {
        window.location.href = "logout.php"; // O la página de login
    }
    </script>

<!--Script para redirigir al index por parte del boton salir-->
    <script>
    function cerrarSesion() {
        fetch('/mi_gimnasio/DCAFITNESS/Proyecto/views/logout.php', { method: 'GET' })  // Llamada a logout.php para cerrar sesión
            .then(response => {
                if (response.ok) {  // Si la respuesta es correcta
                    window.location.href = "/mi_gimnasio/DCAFITNESS/Proyecto/index.php";  // Redirige al index
                } else {
                    // Si la respuesta no es OK, mostrar el código de estado
                    alert("Error al cerrar sesión. Código de estado: " + response.status);
                }
            })
            .catch(error => {
                // Mostrar detalles del error si la solicitud fetch falla
                alert("Error al intentar cerrar la sesión: " + error.message);
            });
    }
    </script>


</body>
</html>
