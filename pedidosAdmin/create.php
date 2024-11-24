<?php
$idA = 0;
$fechaProgramado = '';
$fechaDisenio = '';
$fechaCorte = '';
$fechaConfeccon = '';
$fechaRevfinal = '';
$progressValue = '';
$idCliente = '';
$transportadora = '';
$fechaDespacho = '';
$fechaRecibido = '';
//En este bloque if se valida si se esta modificando o eliminando un cotnacto.
//la vairable $_SESSION es una super variable que esta disponible para todos los scrips
//inicia la variable session $_SESSION
session_start();
// row es la clave del objeto que se ha guardado en la super variable $_SESSION cuando se selecciona editar el registro
if (isset($_SESSION["row"]) && !empty($_SESSION["row"])) {
    $idA = $_SESSION["row"]["idA"];
    $fechaProgramado = $_SESSION["row"]["fechaProgramado"];
    $fechaDisenio = $_SESSION["row"]["fechaDisenio"];
    $fechaCorte = $_SESSION["row"]["fechaCorte"];
    $fechaConfeccon = $_SESSION["row"]["fechaConfeccon"];
    $fechaRevfinal = $_SESSION["row"]["fechaRevfinal"];
    $idCliente = $_SESSION["row"]["idCliente"];
    $transportadora = $_SESSION["row"]["transportadora"];
    $fechaDespacho = $_SESSION["row"]["fechaDespacho"];
    $fechaRecibido = $_SESSION["row"]["fechaRecibido"];
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET["idA"])) {
    $idA = $_GET["idA"];
    readForUpdate($idA);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    processContactForm();
}

function processContactForm() {
    require_once "../configuracion.php";

    
    $fechaDisenio = isset($_POST['fechaDisenio']) ? $_POST['fechaDisenio'] : '';
    $fechaCorte = isset($_POST['fechaCorte']) ? $_POST['fechaCorte'] : '';
    $fechaConfeccon = isset($_POST['fechaConfeccon']) ? $_POST['fechaConfeccon'] : '';
    $fechaRevfinal = isset($_POST['fechaRevfinal']) ? $_POST['fechaRevfinal'] : '';
    $progressValue = isset($_POST['progressValue']) ? $_POST['progressValue'] : '';
 
    $transportadora = isset($_POST['transportadora']) ? $_POST['transportadora'] : '';
    $fechaDespacho = isset($_POST['fechaDespacho']) ? $_POST['fechaDespacho'] : '';
    $fechaRecibido = isset($_POST['fechaRecibido']) ? $_POST['fechaRecibido'] : '';

    $idA = $_SESSION["row"]["idA"];

    if (!empty($idA)) {
        $sql = "UPDATE infoadmin SET fechaDisenio = :fechaDisenio, fechaCorte = :fechaCorte, fechaConfeccon = :fechaConfeccon, fechaRevfinal = :fechaRevfinal, progressValue = :progressValue, transportadora = :transportadora, fechaDespacho = :fechaDespacho, fechaRecibido = :fechaRecibido WHERE idA = :idpar";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":fechaDisenio", $fechaDisenio);
            $stmt->bindParam(":fechaCorte", $fechaCorte);
            $stmt->bindParam(":fechaConfeccon", $fechaConfeccon);
            $stmt->bindParam(":fechaRevfinal", $fechaRevfinal);
            $stmt->bindParam(":progressValue", $progressValue);
            $stmt->bindParam(":transportadora", $transportadora);
            $stmt->bindParam(":fechaDespacho", $fechaDespacho);
            $stmt->bindParam(":fechaRecibido", $fechaRecibido);
            $stmt->bindParam(":idpar", $idA);
            if ($stmt->execute()) {
                echo "<script>alert('Los datos han sido enviados');</script>";
                header("location: formAdmin.php");
                limpiarFormulario();
                exit();
            } else {
                echo "Lo siento! Se ha presentado un error.";
            }
        }
    } 
    unset($stmt);
    unset($pdo);
}

function readForUpdate($idA) {
    require_once "../configuracion.php";

    $sql = "SELECT * FROM infoadmin WHERE idA = :idA";
    if ($stmt = $pdo -> prepare($sql)) {
        if ($stmt->execute([':idA' => $idA])) {
            if ($stmt->rowCount() == 1) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION["row"] = $row;
                echo "<script>alert('Los datos han sido enviados');</script>";
                header("location: formAdmin.php");
                unset($stmt);
                exit();
            }
        } else {
            echo "Lo siento! Se ha presentado un error.";
        }
    }
    unset($pdo);
}

function limpiarFormulario() {
    unset($_SESSION["row"]);
    $idA = 0;
    $fechaDisenio = '';
    $fechaCorte = '';
    $fechaConfeccon = '';
    $progressValue = '';
    $fechaRevfinal = '';
    
    $transportadora = '';
    $fechaDespacho = '';
    $fechaRecibido = '';
}
?>
