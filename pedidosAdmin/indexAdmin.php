

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="../css/bootstrap-5.1.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet">
    <!-- JavaScript Bootstrap -->
    <script src="../css/bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/styleAdmin.css">
    <script>
        // Verificar si el usuario ha iniciado sesión
        document.addEventListener('DOMContentLoaded', function() {
            if (!sessionStorage.getItem('loggedIn')) {
                alert('Debe iniciar sesión primero.');
                window.location.href = '../index.html';
            }
        });
    </script>
    <title>Administrador</title>
</head>

<style>
    /* Estilo para el contenido */
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    .navbar {
        position: fixed;
        width: 100%;
        top: 0;
        background-color: #343a40;
        z-index: 1030;
    }

    .navbar-brand img {
        height: 40px;
    }

    .navbar-nav .nav-link {
        color: #ffffff;
        font-weight: bold;
    }

    .navbar-nav .nav-link:hover {
        color: #f8f9fa;
        background-color: #495057;
        border-radius: 5px;
    }

    h2 {
        margin-top: 100px;
        text-align: center;
    }

    #pedidoContent {
        margin-top: 20px;
    }

    .spacer {
        margin: 20px 0;
    }
</style>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-box-open"></i> ADMINISTRAR PEDIDOS
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link mx-2" href="../modulos/modulos.html"><i class="fas fa-box-open"></i> Módulos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-2" href="../modulos/subModulos.html"><i class="fa fa-cubes"></i> Submódulos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-2" href="../productos/indexProductos.php"><i class="fas fa-box pe-2"></i> Inventario de productos</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <button class="fa fa-users btn btn-danger" onclick="window.location.href='../index.html'"> Cerrar Sesión</button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container">
        <h2>HISTORIAL DE PEDIDOS REALIZADOS</h2>
        <div class="d-flex justify-content-center my-4">
            <button type="button" class="btn btn-success mx-2" id="completadosBtn">Completados</button>
            <button type="button" class="btn btn-danger mx-2" id="pendientesBtn">Pendientes</button>
        </div>

        <!-- Sección dinámica para mostrar los pedidos -->
        <div id="pedidoContent" class="container">
            <div class="alert alert-info text-center" role="alert">
                Seleccione una opción para cargar los pedidos.
            </div>
        </div>

        <div class="container">
            <div class="spacer spacer-line border-primary">&nbsp;
                <?php
require_once "read.php";
                ?>
            </div>
        </div>
    </div>

    <script>
        // Manejo de los botones para cargar pedidos
        document.getElementById('completadosBtn').addEventListener('click', function() {
            fetch('./readCompletados.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('pedidoContent').innerHTML = data;
                })
                .catch(error => {
                    document.getElementById('pedidoContent').innerHTML = `
                        <div class="alert alert-danger" role="alert">
                            Ocurrió un error al cargar los pedidos completados. Por favor, intente de nuevo.
                        </div>
                    `;
                    console.error('Error al cargar los pedidos completados:', error);
                });
        });

        document.getElementById('pendientesBtn').addEventListener('click', function() {
            fetch('./readPendientes.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('pedidoContent').innerHTML = data;
                })
                .catch(error => {
                    document.getElementById('pedidoContent').innerHTML = `
                        <div class="alert alert-danger" role="alert">
                            Ocurrió un error al cargar los pedidos pendientes. Por favor, intente de nuevo.
                        </div>
                    `;
                    console.error('Error al cargar los pedidos pendientes:', error);
                });
        });
    </script>
</body>

</html>