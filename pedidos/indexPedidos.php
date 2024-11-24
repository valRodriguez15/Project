<?php
include "create.php";

require_once "../configuracion.php";

// Obtener productos de la base de datos
function obtenerProductos()
{
    global $pdo;
    $sql = "SELECT id, nombreProducto FROM productos";
    if ($stmt = $pdo->prepare($sql)) {
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            echo "Error al ejecutar la consulta.";
            return [];
        }
    }
    unset($stmt);
}

$productos = obtenerProductos();


function getProducts($conn)
{
    $sql = "SELECT id, nombreProducto, valor FROM productos";
    $result = $conn->query($sql);

    $products = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
    return $products;
}
?>

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
    <link rel="stylesheet" href="../css/stylePedidos.css">
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
    <title>Pedidos</title>
    <style>
        /* Asegurar que el cuerpo ocupe toda la pantalla y no permita scroll */
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden; /* Evitar scroll en la página */
        }

        #page-content {
            height: 80vh;
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

        /* Estilo para el apartado de detalles del registro */
        #tablecontact {
            max-height: 80vh; /* Ajusta la altura máxima según sea necesario */
            overflow-y: auto; /* Permitir scroll solo en este apartado */
        }
    </style>
</head>

<body>
    <div id="page-content">
        <h1>Módulo de Pedidos</h1>

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <i class="fas fa-box-open"></i> PEDIDOS
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link mx-2" href="#!" id="productosLink"><i class="fas fa-box pe-2"></i>Productos</a>
                        </li>
                    </ul>
                    <div class="d-flex">
                        <button id="logoutBtn" class="btn btn-danger fa fa-users btn btn-danger" onclick="window.location.href='../index.html'"> Cerrar sesión</button>
                    </div>
                </div>
            </div>
        </nav>

        <br>
        <br>
        <br>
        <br>
        <br>

        <section id="about-section" class="pt-5 pb-5">
            <div class="container wrapabout">
                <div class="row">
                    <div class="col-lg-6 align-items-center justify-content-left d-flex mb-5 mb-lg-0">
                        <div class="blockabout">
                            <div class="blockabout-inner text-center text-sm-start">
                                <div class="title-big pb-3 mb-3">
                                    <h4>INGRESE SU PEDIDO</h4>
                                </div>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="contact-form form-validate" novalidate="novalidate">
                                    <div class="row">
                                        <div class="col-sm-6 mb-3">
                                            <div class="form-group">
                                                <label class="required-field" for="fechaProgramado">Fecha</label>
                                                <input type="date" name="fechaProgramado" id="fechaProgramado" class="form-control" value="<?php echo $fechaProgramado ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <div class="form-group">
                                                <label class="required-field" for="nombre">Nombre del cliente</label>
                                                <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo $nombre ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <div class="form-group">
                                                <label class="required-field" for="direccion">Dirección</label>
                                                <input type="text" name="direccion" id="direccion" class="form-control" value="<?php echo $direccion ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                        <div class="form-group">
                                                <label class="required-field" for="idProduct">Producto</label>
                                                <select name="idProduct" id="idProduct" class="form-control" required>
                                                    <option value="">Seleccione un producto</option>
                                                    <?php foreach ($productos as $producto): ?>
                                                        <option value="<?php echo $producto['id']; ?>"><?php echo $producto['nombreProducto']; ?></option>
                                                    <?php endforeach; ?>
                                                    <input name="idProducto" id="idProducto" class="form-control" value="<?php echo $idProduct?>"readonly>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <div class="form-group">
                                                <label class="required-field" for="cantidad">Cantidad</label>
                                                <input type="number" name="cantidad" id="cantidad" class="form-control" min=0 value="<?php echo $cantidad ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <div class="form-group">
                                                <label class="required-field" for="ciudad">Ciudad</label>
                                                <input type="text" name="ciudad" id="ciudad" class="form-control" value="<?php echo $ciudad ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mb-3">
                                            <button class="btn btn-primary w-100" style="border-radius:0px" type="submit">Guardar</button>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <button type="submit" formaction="../pdf/generate_pdf_pedidos.php" formtarget="_blank" class="btn-primary" style="border-radius:0px">Generar PDF</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 contact-info__wrapper gradient-brand-color p-5 order-lg-2" id="tablecontact">
                        <h3 class='mt-9 mb-3'>HISTORIAL DE PEDIDOS</h3>
                        <?php
                        require_once "read.php";
                        ?>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal para productos -->
    <div id="productsModal" class="modal fade" tabindex="-1" aria-labelledby="productsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productsModalLabel">Productos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    require_once "../productos/read.php"
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" id="card-close" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para pedidos realizados -->
    <div id="pedidosModal" class="modal fade" tabindex="-1" aria-labelledby="pedidosModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pedidosModalLabel">Pedidos Realizados</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="pedidosContent">
                        <!-- Aquí se cargarán los pedidos realizados -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de ver pedido -->
    <div id="card-container" class="card-container">
        <div id="card" class="card">
            
            <div id="card-header" class="card-header"></div>
            <div id="card-body" class="card-body"></div>
            <div class="card-footer">
                <button id="generatePdfBtn" class="btn btn-primary">Generar PDF</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cardContainer = document.getElementById('card-container');
            const cardClose = document.getElementById('card-close');
            const cardHeader = document.getElementById('card-header');
            const cardBody = document.getElementById('card-body');
            const pageContent = document.getElementById('page-content');
            let currentOrderId = null;

            // Ocultar el modal al cargar la página
            cardContainer.style.display = 'none';


            // Evento para el botón de "Productos"
            document.getElementById('productosLink').addEventListener('click', function() {
                const productsModal = new bootstrap.Modal(document.getElementById('productsModal'));
                productsModal.show();
                pageContent.classList.add('blur');
            });


            // Evento para los botones de "ver pedido"
            document.addEventListener('click', function(event) {
                if (event.target.classList.contains('view-order')) {
                    event.preventDefault();
                    currentOrderId = event.target.getAttribute('data-id');
                    fetch(`./detalles.php?id=${currentOrderId}`)
                        .then(response => response.text())
                        .then(data => {
                            cardHeader.innerHTML = `Pedido Número: ${currentOrderId}`;
                            cardBody.innerHTML = data;
                            cardContainer.style.display = 'flex';
                            // Aplicar desenfoque al fondo
                            pageContent.classList.add('blur');
                        });
                }
            });

            // Evento para el botón "Generar PDF"
            document.getElementById('generatePdfBtn').addEventListener('click', function() {
                if (currentOrderId) {
                    window.open(`../pdf/generate_pdf_factura.php?id=${currentOrderId}`, '_blank');
                }
            });

            // Cerrar el modal al hacer clic en el botón de cerrar
            cardClose.addEventListener('click', function() {
                cardContainer.style.display = 'none';
                // Eliminar desenfoque al fondo
                pageContent.classList.remove('blur');
            });

            // Cerrar el modal de productos y eliminar el desenfoque
            document.querySelectorAll('.btn-close').forEach(function(button) {
                button.addEventListener('click', function() {
                    pageContent.classList.remove('blur'); // Quita la clase de desenfoque
                });
            });
            // Agregar clase blur al abrir el modal
        var productosModal = document.getElementById('productosModal');
        productosModal.addEventListener('show.bs.modal', function () {
            document.body.classList.add('blur');
        });

        // Eliminar clase blur al cerrar el modal
        productosModal.addEventListener('hidden.bs.modal', function () {
            document.body.classList.remove('blur');
        });
        });
    </script>

</body>

</html>


