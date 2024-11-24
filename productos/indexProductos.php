<?php
    include "create.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Base de datos productos</title>
      <!-- Bootstrap CSS -->
      <link href="../css/bootstrap-5.1.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet">
    <!-- JavaScript Bootstrap -->
    <script src="../css/bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js"></script>
    <link href="../css/style1.css" rel="stylesheet">
 
    
    <script>
        // Verificar si el usuario ha iniciado sesión
        document.addEventListener('DOMContentLoaded', function() {
            if (!sessionStorage.getItem('loggedIn')) {
                document.body.classList.add('blur');
                alert('Debe iniciar sesión primero.');
                window.location.href = '../index.html';
            }
        });
    </script>
</head>

<style>
    .navbar {
        position: fixed;
        width: 100%;
        top: 0;
    }

    .navbar {
        background-color: #343a40;
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

    .navbar-toggler {
        border-color: rgba(255, 255, 255, 0.1);
    }

    .navbar-toggler-icon {
        color: #ffffff;
    }

    .navbar-collapse {
        justify-content: center;
    }
</style>

<body class="bg-dark">
       <!-- Navbar -->
       <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fa fa-calendar" aria-hidden="true"></i> INVENTARIO DE PRODUCTOS 
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
                </ul>
                <div class="d-flex">
                <button id="logoutBtn" class="fa fa-users btn btn-danger" onclick="window.location.href='../index.html'"> Cerrar Sesión</button>
                </div>
            </div>
        </div>
    </nav>

    <br>
    <br>

    <div class="container p-4">
        <h1 class="text-primary text-center mb-4">Inventario de Productos</h1>
        <div class="card shadow-lg mt-5" style="border-radius: 10px; border-left: 8px solid blue;">
            <div class="card-header bg-primary text-white">
                <h3 class="text-uppercase ms-4 my-3">Ingreso de productos</h3>
            </div>
            <div class="card-body">
                <!-- Formulario -->
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="formProductos" method="post">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="product" class="form-label">Nombre del Producto</label>
                            <input type="text" class="form-control" id="product" name="product" placeholder="Nombre del producto" required>
                        </div>
                        <div class="col-md-6">
                            <label for="valor" class="form-label">Valor por Unidad</label>
                            <input type="number" class="form-control" id="valor" name="valor" min=0 placeholder="Valor" required>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary btn-lg me-2">Enviar Datos</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabla de la base de datos -->
        <div class="card mt-5">
            <div class="card-body">
                <h3 class="card-title">Lista de Productos</h3>
                <div id="tableFixHead" class="tableFixHead">
                    <?php
                    require_once "readAdmin.php";
                    ?>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
