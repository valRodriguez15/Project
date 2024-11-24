
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
                document.body.classList.add('blur');
                alert('Debe iniciar sesión primero.');
                window.location.href = '../index.html';
            }
        });
    </script>
    <title>Administrador</title>
</head>
<style>
        /* Asegurar que el cuerpo ocupe toda la pantalla y no permita scroll */
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #page-content {
            height: 100vh;
            /* Ocupar toda la ventana */
            display: flex;
            flex-direction: column;
            justify-content: center;
            /* Centrar contenido verticalmente */
            align-items: center;
        }

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
        section {
            flex-grow: 1;
            /* Permitir que la sección ocupe el resto del espacio disponible */
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        /* Estilo para el desenfoque de fondo */
        .blur {
            filter: blur(5px);
            transition: filter 0.3s ease-in-out;
        }

        .card-container {
            display: none;
            /* Oculto inicialmente */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Fondo semi-transparente */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .card {
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 80%;
            max-width: 600px;
            max-height: 90vh;
            /* Para asegurar que no se salga de la pantalla */
            overflow-y: auto;
            /* Para manejar contenido largo */
        }

        .card-header {
            font-size: 1.5em;
            margin-bottom: 10px;
        }

        .card-body {
            margin-bottom: 20px;
        }

        .card-close {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }
        .modal-lg {
            max-width: 80% !important;
        }
        .modal-body {
            max-height: 80vh;
            overflow-y: auto;
        }
    </style>

<body>
    <h1>Módulo de Pedidos</h1>
    
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
                            <a class="nav-link mx-2" href="../productos/indexProductos.php" id="productosLink"><i class="fas fa-box pe-2"></i>Inventario de productos</a>
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
        

    <section id="pricing" class="bg-white">
        <div class="container">
            <h2 class="text-center">HISTORIAL DE PEDIDOS COMPLETADOS</h2>
            <div class="spacer spacer-line border-primary">&nbsp;</div>
            <?php

require_once "../configuracion.php";

$sql = "SELECT c.*, a.*, p.nombreProducto, p.valor FROM clientes c JOIN productos p ON c.idProduct = p.id
                                                            JOIN infoadmin a ON a.idCliente = c.id";

if ($resultado = $pdo->query($sql)) {
    if ($resultado->rowCount()) {
        $count = 0;
        while ($row = $resultado->fetch()) {
            if ($count % 3 == 0) {
                if ($count != 0) {
                    echo "</div>"; // Cierra la fila anterior
                }
                echo "<div class='row'>"; // Abre una nueva fila
            }
            if ( $row["progressValue"] == 100 ){

            echo "<div class='col-lg-4 col-md-4 col-sm-6 col-xs-12'>";
            echo "<div class='pricing-table'>";
            echo "<div class='pricing-table-title'>";
            echo "<h5 class='pricing-title bg-info-hover text-white'>" . $row["nombre"] . "</h5>";
            echo "</div>";

            echo "<div class='pricing-table-price text-center bg-info'>";
            echo "<p class='title-font'>";
            echo "<span class='pricing-period text-white mr-1'>Precio:</span>";
            echo ' ';
            echo "<span class='pricing-currency text-white'>$</span>";
            echo "<span class='pricing-price text-white'>".number_format($row["valor"] * $row["cantidad"])."</span>";
            echo "<span class='pricing-period text-white'>COP.</span>";
            echo "</p>";
            echo "</div>";

            echo "<div class='pricing-table-content'>";
            echo "<ul>";
            echo "<li><strong>Producto Solicitado: " . $row["nombreProducto"] . "</strong></li>";
            echo "<li><strong>Cantidad de ". $row["nombreProducto"] .": " . $row["cantidad"] . "</strong></li>";
            echo "<li><strong>Ciudad de Entrega: " . $row["ciudad"] . "</strong></li>";
            if ( $row["progressValue"] == 100 ){
                echo "<li><strong> Completado ". $row["progressValue"] . "%</strong></li>";
                }else{
                    echo "<li><strong> Pendiente ". $row["progressValue"] . "%</strong></li>";
                }
            echo "</ul>";

           
            echo "<div class='pricing-table-button'>";
            echo '<a href="../factura/factura.php?id='. $row["id"] .'" class="btn btn-outline-warning"><span>Generar Factura</span></a>';
            echo ' ';
            echo ' ';

            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        
            

            $count++;
        }
        }
        echo "</div>"; // Cierra la última fila
    }else{
        echo '<div class="alert alert-danger"><em>No hay pedidos en la fila.</em></div>';
    }
}else {
    echo "Lo siento! Se ha presentado un error.";
}
?>
        </div>
    </section>
</html>
