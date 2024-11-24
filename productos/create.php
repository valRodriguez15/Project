<?php
$id = 0;
$nombreProducto = "";
$valor = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    capturarDatos();
}

function capturarDatos(){

    require_once "../configuracion.php";

    $nombreProducto = $_POST["product"];
    $valor = $_POST["valor"];

    $sql = "INSERT INTO productos (nombreProducto, valor) VALUES (?, ?)";

    if ($stmt = $pdo->prepare($sql)) {
        if ($stmt->execute([$nombreProducto, $valor])) {
            header("location: indexProductos.php");
            exit();
        } else {
            echo "Ha ocurrido un error";
        }
    };
    unset($stmt);

    unset($pdo);
}
