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
    <title>Gestión de Pedidos</title>
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
            <h2>Editar información de Administrador</h2>
            <p>En esta sección usted podrá editar la informacion de un administrador.</p>
            <main class="container mt-4">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-dark text-white text-center">
                                <h4>Editar información de Administrador</h4>
                            </div>
                            <div class="card-body">
                                <form id="form-registrar-admin" data-idAdmin="<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>" novalidate>
                                    <!-- Nombre -->
                                    <div class="mb-3">
                                        <label for="nombre" class="form-label">Nombre *</label>
                                        <input type="text" class="form-control" id="nombre" name="admin_nombre"
                                            value="<?php echo isset($_GET['nombre']) ? $_GET['nombre'] : ''; ?>" required>

                                        <div class="invalid-feedback">Por favor ingrese el nombre.</div>
                                    </div>

                                    <!-- Apellido -->
                                    <div class="mb-3">
                                        <label for="apellido" class="form-label">Apellido</label>
                                        <input type="text" class="form-control" id="apellido" name="admin_apellido"
                                            value="<?php echo isset($_GET['apellido']) ? htmlspecialchars($_GET['apellido']) : ''; ?>" required>

                                    </div>

                                    <!-- Usuario -->
                                    <div class="mb-3">
                                        <label for="usuario" class="form-label">Usuario *</label>
                                        <input type="text" class="form-control" id="usuario" name="admin_user"
                                            value="<?php echo isset($_GET['username']) ? htmlspecialchars($_GET['username']) : ''; ?>" required>

                                        <div class="invalid-feedback">Por favor ingrese un nombre de usuario.</div>
                                    </div>


                                    <!-- Botón de Enviar -->
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">Editar Información</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; 2025 Pollería El Deleite | Todos los derechos reservados.</p>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.16.0/dist/sweetalert2.all.min.js"></script>
    <script src="global.js"></script>
    <script src="js/admin_editar.js"></script>
</body>

</html>