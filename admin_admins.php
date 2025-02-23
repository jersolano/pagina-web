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
    <title>Gestión de Administradores</title>
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
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center"> <img src="assets/img/logo.png" alt="logopng" width="60"> Menú</h4>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="admin_pedidos.php">Pedidos</a>
        <a href="admin_admins.php" class="active">Administradores</a>
    </div>

    <!-- Contenido Principal -->
    <div class="content">
        <!-- Header con usuario -->
        <div class="header">
            <h3>Panel de Administración</h3>
            <!-- Menú de usuario -->
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                    <span id="nombreAdmin">Cargando...</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                    <li><a class="dropdown-item" href="#" id="btnSalir">Cerrar Sesión</a></li>
                </ul>
            </div>
        </div>

        <!-- Contenido -->
        <div class="main-content">
            <h2>Gestión de Administradores</h2>
            <p>Esta sección permite gestionar los administradores que tienen permisos en el sistema.</p>
            <main class="container mt-4">
                <div class="d-flex justify-content-between">
                    <h2>Lista de Administradores</h2>
                    <button class="btn btn-primary fw-bold" onclick="window.location.href='admin_registro.php'">
                        + Agregar Administrador
                    </button>
                </div>

                <div class="table-responsive mt-3">
                    <table class="table table-bordered" id="tablaAdmins">
                        <thead class="table-dark">
                            <tr>
                                <th>ID Administrador</th>
                                <th>Nombre de Usuario</th>
                                <th>Administrador</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Aquí se llenarán los administradores con AJAX -->
                        </tbody>
                    </table>
                </div>
            </main>


            <!-- Modal -->
            <div class="modal fade" id="modalPedido" tabindex="-1" aria-labelledby="modalPedidoLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalPedidoLabel">Detalles del Pedido</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p id="productosPedido"></p> <!-- Aquí se llenará el contenido de productos -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; 2025 Pollería El Deleite | Todos los derechos reservados.</p>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.16.0/dist/sweetalert2.all.min.js"></script>
    <script src="global.js"></script>
    <script script src="js/admin_admins.js"></script>
</body>

</html>