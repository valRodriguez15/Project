<?php
$id = 0;
$fechaProgramado = '';
$nombre = '';
$direccion = '';
$idProduct = '';
$cantidad = 0;
$ciudad = '';
$valorTotal = 0;

//En este bloque if se valida si se esta modificando o eliminando un cotnacto.
//la vairable $_SESSION es una super variable que esta disponible para todos los scrips
//inicia la variable session $_SESSION
session_start();
// row es la clave del objeto que se ha guardado en la super variable $_SESSION cuando se selecciona editar el registro
if (isset($_SESSION) && !empty($_SESSION)) {
    
    $id = $_SESSION["row"]["id"];
    $nombre =  $_SESSION["row"]["nombre"];
    $direccion =   $_SESSION["row"]["direccion"];
    $idProduct =  $_SESSION["row"]["idProduct"];
    $cantidad =    $_SESSION["row"]["cantidad"];
    $ciudad =   $_SESSION["row"]["ciudad"];
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET["id"])  ) {
    $id = $_GET["id"];
   readForUpdate($id);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    processContactForm();
}

function processContactForm()
{
    require_once "../configuracion.php";

  
// Verificar si las claves existen en el array $_POST
if (!isset($_POST['nombre']) || !isset($_POST['direccion']) || !isset($_POST['idProduct']) || !isset($_POST['cantidad']) || !isset($_POST['ciudad'])) {
    // Redirigir a otra vista en caso de error
    header("Location: ../error.php");
    exit();
}
    $fechaProgramado = isset($_POST["fechaProgramado"]) ? $_POST["fechaProgramado"] : '';
    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : '';
    $direccion = isset($_POST["direccion"]) ? $_POST["direccion"] : '';
    $idProduct = isset($_POST["idProduct"]) ? $_POST["idProduct"] : '';
    $cantidad = isset($_POST["cantidad"]) ? $_POST["cantidad"] : '';
    $ciudad = isset($_POST["ciudad"]) ? $_POST["ciudad"] : '';
    

    $id = isset($_SESSION["row"]["id"]) ? $_SESSION["row"]["id"] : '';


    if (!empty($id)) {
        $sql = "UPDATE clientes SET  nombre = :nombre, direccion = :direccion, idProduct = :idProduct, cantidad = :cantidad, ciudad = :ciudad WHERE id = :idpar";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":nombre", $nombre);
            $stmt->bindParam(":direccion", $direccion);
            $stmt->bindParam(":idProduct", $idProduct);
            $stmt->bindParam(":cantidad", $cantidad);
            $stmt->bindParam(":ciudad", $ciudad);
            $stmt->bindParam(":idpar", $id);
            if ($stmt->execute()) {
                header("location: indexPedidos.php");
                limpiarFormulario();
                exit();
            } else {
                echo "Lo siento! Se ha presentado un error.";
            }
        }
    } else {


        $sql2 = "INSERT INTO clientes (nombre, direccion, idProduct, cantidad, ciudad) VALUES (?, ?, ?, ?, ?)";
        if ($stmt2 = $pdo->prepare($sql2)) {
            if ($stmt2->execute([$nombre, $direccion, $idProduct, $cantidad, $ciudad])) {
                $idInfoAdmin = $pdo->lastInsertId();
                // Insertar otros datos en la tabla clientes
                $sql1 = "INSERT INTO infoadmin (fechaProgramado, idCliente) VALUES (?, ?)";
                if ($stmt1 = $pdo->prepare($sql1)) {
                    if ($stmt1->execute([$fechaProgramado, $idInfoAdmin])) {
                        header("location: indexPedidos.php");
                        limpiarFormulario();
                        exit();
                    } else {
                        echo "Lo siento! Se ha presentado un error en la tabla clientes.";
                    }
                }
            } else {
                echo "Lo siento! Se ha presentado un error en la tabla infoadmin.";
            }
        }
        
        unset($stmt1);
        unset($stmt2);
        unset($pdo);
    }
       
    }



//Esta funcion consulta en la base de datos $la informacion de los contactos.
function readForUpdate($id)
{
    //Estamos usando la variable session para almacenar los valores que recupera es necesario limpiarla antes de ir a busar datos.
    // desde este archivo se va a acceder a base de datos es necesario incluir la conenfiguracion y conexion a base de datos
    require_once "../configuracion.php";
    // Se contruye la sentencia esql en una variable
    $sql = "SELECT * FROM clientes WHERE id = :id";
    //se prepara la sentencia sql
    if ($stmt = $pdo->prepare($sql)) {
        // Se ejecuta la sentencia para obtener los varoles, si el resultado es true, se contruye la tabla y se pintan los varores
        if ($stmt->execute([$id])) {
            if ($stmt->rowCount() == 1) {
                //si el resultado es exitoso se compreuba que si obtengamso registros
                $row = $stmt->fetch();
                //dado que se obendria solo un registro porque se busca por ID, no es necesario hacer un siclo, el fech devuelve un array asociativo
                //se guardan los valores en la super variabel global  $_SESSION para ser accedidos desde el bloque superior que los asigna a las variabels individuales
                $_SESSION["row"] = $row;
                // Si la consulta es exitosa se redirige a la vista de contacto
                header("location: indexPedidos.php");
                // cerrrar la variable stmt
                unset($stmt);
                exit();
            } else {
                // si no viene el id se redirige a la vista de error
                header("location: ../error.php");
                exit();
            }
        } else {
            echo "Lo siento! Se ha presentado un error.";
        }
    }

    $sql3 = "SELECT fechaProgramado FROM infoadmin WHERE idCliente = :idInfoAdmin";
    //se prepara la sentencia sql
    if ($stmt = $pdo->prepare($sql3)) {
        // Se ejecuta la sentencia para obtener los varoles, si el resultado es true, se contruye la tabla y se pintan los varores
        if ($stmt->execute([$id])) {
            if ($stmt->rowCount() == 1) {
                //si el resultado es exitoso se compreuba que si obtengamso registros
                $row = $stmt->fetch();
                //dado que se obendria solo un registro porque se busca por ID, no es necesario hacer un siclo, el fech devuelve un array asociativo
                //se guardan los valores en la super variabel global  $_SESSION para ser accedidos desde el bloque superior que los asigna a las variabels individuales
                $_SESSION["row"] = $row;
                // Si la consulta es exitosa se redirige a la vista de contacto
                header("location: indexPedidos.php");
                // cerrrar la variable stmt
                unset($stmt);
                exit();
            } else {
                // si no viene el id se redirige a la vista de error
                header("location: ../error.php");
                exit();
            }
        } else {
            echo "Lo siento! Se ha presentado un error.";
        }
    }
    // cerrar la conexion a la base de datos
    unset($pdo);
}

function limpiarformulario(){
    unset($_SESSION["row"]);
    $id = 0;
    $fechaProgramado = '';
    $nombre = '';
    $direccion = '';
    $idProduct = 0;
    $cantidad = 0;
    $ciudad = '';
}



