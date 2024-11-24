<?php

include "create.php";

require_once "../configuracion.php";

// Obtener pedidos de la base de datos
function obtenerPedidos()
{
    global $pdo;
    $sql = "SELECT id, nombre FROM clientes";
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

$pedidos = obtenerPedidos();

//Función validar fecha actual

function validarFecha($fecha, $formato = 'Y-m-d')
{
    $d = DateTime::createFromFormat($formato, $fecha);
    return $d && $d->format($formato) === $fecha;
}

$errores = [];
$fechaActual = date('Y-m-d');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fechaProgramado = $_POST["fechaProgramado"];
    $fechaDisenio = $_POST["fechaDisenio"];
    $fechaCorte = $_POST["fechaCorte"];
    $fechaConfeccon = $_POST["fechaConfeccon"];
    $fechaRevfinal = $_POST["fechaRevfinal"];
    $fechaDespacho = $_POST["fechaDespacho"];
    $fechaRecibido = $_POST["fechaRecibido"];

    if (!validarFecha($fechaProgramado) || $fechaProgramado < $fechaActual) {
        $errores[] = "La fecha de Programado no es válida o es anterior a la fecha actual.";
    }
    if (!validarFecha($fechaDisenio) || $fechaDisenio < $fechaProgramado) {
        $errores[] = "La fecha de Diseño no es válida o es anterior a la fecha actual.";
    }
    if (!validarFecha($fechaCorte) || $fechaCorte < $fechaDisenio) {
        $errores[] = "La fecha de Corte no es válida o es anterior a la fecha actual.";
    }
    if (!validarFecha($fechaConfeccon) || $fechaConfeccon < $fechaCorte) {
        $errores[] = "La fecha de Confección no es válida o es anterior a la fecha actual.";
    }
    if (!validarFecha($fechaRevfinal) || $fechaRevfinal < $fechaConfeccon) {
        $errores[] = "La fecha de Revisión Final no es válida o es anterior a la fecha actual.";
    }
    if (!validarFecha($fechaDespacho) || $fechaDespacho < $fechaRevfinal) {
        $errores[] = "La fecha de Revisión Final no es válida o es anterior a la fecha actual.";
    }
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
    <link rel="stylesheet" href="../css/styleNew.css">
    <title>Pedidos</title>
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

        .progress-circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5em;
            color: white;
            background: conic-gradient(green 0%, lightgray 0% 100%);
            margin: 20px auto;
            /* Centrar horizontalmente */
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
                    <i class="fas fa-box-open"></i>ACTUALIZACIÓN DEL PEDIDO
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto">

                        <li class="nav-item">
                            <a class="nav-link mx-2" href="#!" id="productosLink"><i class="fas fa-box pe-2"></i>Productos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-2" href="#!" id="misPedidosLink"><i class="fas fa-heart pe-2"></i>Mis Pedidos</a>
                        </li>
                    </ul>
                    <div class="d-flex">
                        <button id="logoutBtn" class="btn btn-danger" onclick="window.location.href='../index.html'">Cerrar sesión</button>
                    </div>
                </div>
            </div>
        </nav>
        <div class="container-contact100">
            <div class="wrap-contact100">
                <script>
                    function obtenerDatos(idA) {
                        if (idA) {
                            window.location.href = 'create.php?idA=' + idA;
                        } else {
                            alert('ID no proporcionado.');
                        }
                    }
                </script>
                </head>

                <body>
                    <?php

                    require_once '../configuracion.php';

                    // Consulta SQL
                    $sql = "SELECT * FROM infoadmin WHERE idA = :idA";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':idA', $idA, PDO::PARAM_INT);
                    $stmt->execute();

                    // Obtener el resultado
                    $row = $stmt->fetch();
                    ?>
                        <form class="contact100-form validate-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" name="formAdmin" id="formAdmin" method="post" target="_self">
                            <div class="title-big pb-3 mb-3">
                                <h4>Actualice el Estado del Pedido</h4>
                            </div>
                            <div class="row gutters containerEstados">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <h6 class="mb-3 text-primary">Proceso Interno</h6>
                                </div>
                                <input type="hidden" name="idA" value="<?php echo htmlspecialchars($row['idA']); ?>">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="fechaProgramado">Estado 1: Programado</label>
                                        <input class="form-control" id="fechaProgramado" name="fechaProgramado" value="<?php echo $fechaProgramado; ?>" readonly onclick="changeEstado1()"></input>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="fechaDisenio">Estado 2: Diseño</label>
                                        <input class="box2 form-control" type="date" id="fechaDisenio" name="fechaDisenio" value="<?php echo htmlspecialchars($row['fechaDisenio']); ?>" min="<?php echo $fechaActual; ?>" onclick="changeEstado2()">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="fechaCorte">Estado 3: Corte</label>
                                        <input class="box3 form-control" type="date" id="fechaCorte" name="fechaCorte" value="<?php echo htmlspecialchars($row['fechaCorte']); ?>" min="<?php echo $fechaActual; ?>" onclick="changeEstado3()">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="fechaConfeccon">Estado 4: Confección</label>
                                        <input class="box5 form-control" type="date" id="fechaConfeccon" name="fechaConfeccon" value="<?php echo htmlspecialchars($row['fechaConfeccon']); ?>" min="<?php echo $fechaActual; ?>" onclick="changeEstado5()">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="fechaRevfinal">Estado 5: Revisión final</label>
                                        <input class="box4 form-control" type="date" id="fechaRevfinal" name="fechaRevfinal" value="<?php echo htmlspecialchars($row['fechaRevfinal']); ?>" min="<?php echo $fechaActual; ?>" onclick="changeEstado4()">
                                    </div>
                                </div>
                            </div>
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <h6 class="mb-3 text-primary">Logística del Pedido</h6>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="idCliente">Pedido</label>
                                        <input class="form-control" id="idCliente" name="idCliente" value="<?php echo $idCliente; ?>" readonly onclick="changeEstado1()"></input>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <label for="transportadora">Transportadora</label>
                                    <select name="transportadora" id="transportadora" class="form-control">
                                        <option value="<?php echo htmlspecialchars($row['transportadora']); ?>"></option>
                                        <option value="Servientrega">Servientrega</option>
                                        <option value="Envía">Envía</option>
                                        <option value="Colvanes">Colvanes</option>
                                        <option value="T Torres">T Torres</option>
                                        <option value="Interrapidísimo">Interrapidísimo</option>
                                        <option value="Aldia Logística">Aldia Logística</option>
                                    </select>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="fechaDespacho">Fecha Despacho</label>
                                        <input type="date" class="form-control" id="fechaDespacho" name="fechaDespacho" value="<?php echo htmlspecialchars($row['fechaDespacho']); ?>" min="<?php echo $fechaActual; ?>">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="fechaRecibido">Fecha Recibido</label>
                                        <input type="date" class="form-control" id="fechaRecibido" name="fechaRecibido" value="<?php echo htmlspecialchars($row['fechaRecibido']); ?>" min="<?php echo $fechaActual; ?>">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="text-right">

                                        <script src="./changeColor.js"></script>

                                        <button class="btn btn-primary" style="border-radius:0px">Actualizar Pedido</button>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="progressValue" name="progressValue" value="0">
                            <div class="progress-circle" id="progressCircle">0%</div>
                        </form>
                        <a  href="./indexAdmin.php" class="btn btn-secondary">Regresar</a>
            </div>
            <script>
                document.getElementById('formAdmin').addEventListener('submit', function(event) {
                    const fechas = [
                        document.getElementById('fechaProgramado').value,
                        document.getElementById('fechaDisenio').value,
                        document.getElementById('fechaCorte').value,
                        document.getElementById('fechaConfeccon').value,
                        document.getElementById('fechaRevfinal').value
                    ];

                    let completed = 0;
                    fechas.forEach(fecha => {
                        if (fecha !== '') {
                            completed++;
                        }
                    });

                    const progress = (completed / fechas.length) * 100;
                    const progressCircle = document.getElementById('progressCircle');
                    progressCircle.textContent = `${progress}%`;
                    progressCircle.style.background = `conic-gradient(green ${progress}%, lightgray ${progress}% 100%)`;

                    // Actualiza el campo oculto con el valor del progreso
                    document.getElementById('progressValue').value = progress;
                });
            </script>
</body>

</html>