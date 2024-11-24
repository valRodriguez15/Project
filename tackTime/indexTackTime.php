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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tack Time</title>
       <!-- Bootstrap CSS -->
    <link href="../css/bootstrap-5.1.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet">
    <!-- JavaScript Bootstrap -->
    <script src="../css/bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js"></script>

    <link href="../css/style1.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                <i class="fa fa-calendar" aria-hidden="true"></i> TACK TIME
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
                        <a class="nav-link mx-2" href="../productos/indexProductos.php" id="productosLink"><i class="fas fa-box pe-2"></i>Inventario de Productos</a>
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
    <br>
    <div class="container p-2">
        <div class="card mt-3 mx-3 mt-n7 shadow-lg" style="border-radius: 10px; border-left:8px blue solid;">

            <h3 class="text-primary text-uppercase ms-4 mt-3">Ingreso de datos</h3>

            <div class="card-body" id="card">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="formTackTime" name="formTackTime" method="post">
                    <div class="row">
                        <div class="col">
                            <label for="datee">Fecha del Registro</label>
                            <input class="form-control" type="date" id="datee" name="datee">
                        </div>

                        <div class="col">
                            <label for="dayss">Días de Fabricación</label>
                            <input min=0 max=31 class="form-control" type="number" id="dayss" name="dayss">
                        </div>

                        <div class="col">
                            <label class="required-field" for="idProducto">Producto Requerido</label>
                            <select name="idProducto" id="idProducto" class="form-control" required>
                                <option value="">Seleccione un producto</option>
                                <?php foreach ($productos as $producto): ?>
                                    <option value="<?php echo $producto['id']; ?>"><?php echo $producto['nombreProducto']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col">
                            <label for="turnoo">Cantidad de Turnos</label>
                            <select name="turnoo" id="turnoo" class="form-control" required>
                                <option value="">Seleccione un turno</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>
                    </div>
                    <div class="ms-3 row">
                        <div class="col">
                            <label for="demandaa">Demanda Requerida</label>
                            <input min=0 class="form-control" type="number" id="demandaa" name="demandaa">
                        </div>

                        <div class="col">
                            <label for="calidadd">% de Calidad</label>
                            <input min=0 max=100 class="form-control" type="number" id="calidadd" name="calidadd">
                        </div>

                        <div class="col">
                            <label for="eficienciaa">% de Eficiencia</label>
                            <input min=0 max=100 class="form-control" type="number" id="eficienciaa" name="eficienciaa">
                        </div>
                    </div>
                    <br />
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-danger">Enviar Datos</button>
                        <button type="button" id="generateReportBtn" class="btn btn-primary">Generar Reporte</button>
                    </div>
                </form>
                <button id="generatePdfBtn" class="btn btn-info mt-3" onclick="window.open('../pdf/generate_pdf_tacktime.php', '_blank')">Generar PDF</button>
                <br />
            </div>
            </div>
            <div class="card mt-5">
            <div class="card-body">
            <div class="tableFixHead" id="tackTimeTable">
                <?php
                require_once "read.php";
                ?>
            </div>
            </div></div>

        
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Evento para el botón "Generar Reporte"
            document.getElementById('generateReportBtn').addEventListener('click', function() {
                // Abrir la nueva página en una nueva ventana
                window.open('reporteGrafico.php', '_blank');
            });
            // Evento para el envío del formulario usando AJAX
            document.getElementById('read.php').addEventListener('submit', function(event) {
                event.preventDefault(); // Evitar el envío del formulario por defecto

                const formData = new FormData(this);

                fetch('create.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        // Actualizar la tabla con el último registro
                        document.getElementById('tackTimeTable').innerHTML = data;
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    </script>

</body>

</html>