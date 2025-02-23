<?php
session_start();

// Si el administrador ya ha iniciado sesión, redirigir al dashboard
if (!isset($_SESSION["admin_id"])) {
    echo '<script>window.location.href = "admin_login.php";</script>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.16.0/dist/sweetalert2.min.css">
    <style>
        body {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        .sidebar {
            width: 250px;
            background: #343a40;
            color: white;
            padding-top: 20px;
        }

        .sidebar a {
            color: white;
            padding: 12px;
            display: block;
            text-decoration: none;
            border-left: 4px solid transparent;
            transition: all 0.3s ease;
        }

        .sidebar a:hover {
            background: #495057;
        }

        /* 🔹 Estilo para el enlace activo */
        .sidebar .active {
            background: #495057;
            border-left: 4px solid white;
        }

        .content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .header {
            background: #007bff;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .main-content {
            flex-grow: 1;
            overflow-y: auto;
            padding: 20px;
            background: #f8f9fa;
        }

        .footer {
            background: #343a40;
            color: white;
            text-align: center;
            padding: 10px;
            position: sticky;
            bottom: 0;
        }

        .info-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center"> <img src="assets/img/logo.png" alt="logopng" width="60"> Menú</h4>
        <a href="#" class="active">Dashboard</a>
        <a href="admin_pedidos.php">Pedidos</a>
        <a href="admin_admins.php">Administradores</a>
    </div>

    <!-- Contenido Principal -->
    <div class="content">
        <!-- Header con usuario -->
        <div class="header">
            <h3>Panel de Administración</h3>
            <!-- Menú de usuario -->
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                    Usuario
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                    <li><a id="btnSalir" class="dropdown-item" href="#">Cerrar Sesión</a></li>
                </ul>
            </div>
        </div>

        <!-- Contenido -->
        <div class="main-content">
            <h2>Bienvenido al Dashboard</h2>
            <p>En esta seccion se visualizan los datos mas relevantes de la empresa.</p>
            <div class="container mt-5">
                <h2 class="text-center mb-4">Información Relevante</h2>
                <div class="row">
                    <!-- Tarjeta 1 -->
                    <div class="col-md-4">
                        <div class="card info-card text-white bg-primary mb-3" style="height: 180px;">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-people"></i> Clientes Registrados</h5>
                                <p class="card-text">Actualmente hay <strong id="clientesRegistrados"></strong> clientes registrados en la plataforma.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta 2 -->
                    <div class="col-md-4">
                        <div class="card info-card text-white bg-warning mb-3" style="height: 180px;">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-file-earmark-text"></i> Administradores registrados</h5>
                                <p class="card-text">Actualmente hay <strong id="adminsRegistrados"></strong> administradores registrados en la plataforma.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta 3 -->
                    <div class="col-md-4">
                        <div class="card info-card text-white bg-success mb-3" style="height: 180px;">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-cash"></i> Ventas del día</h5>
                                <p>Fecha: <strong id="fechaActual"></strong></p>
                                <p>Total de pedidos completados <strong id="totalPedidos"></strong></p>
                                <p class="card-text">Los ingresos totales del día son de <strong>S/</strong><strong id="totalMonto"></strong>.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; 2025 Pollería El Deleite | Todos los derechos reservados.</p>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.16.0/dist/sweetalert2.all.min.js"></script>
        <script src="global.js"></script>
        <script src="js/admin_dashboard.js"></script>
    </div>
</body>

</html>