<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET["idA"])) {
    $idA = $_GET["idA"];

    eliminarRegistro($idA);
}



function eliminarRegistro($idA){
    require_once "../configuracion.php";
    $sql = "DELETE FROM infoadmin WHERE idA= :idpar";

    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam("idpar", $idA);
        if ($stmt->execute()) {
            //si el resultado es exitoso se compreuba que si obtengamso registros
            header("location: indexAdmin.php");
            exit();
    } else {
        echo "Lo siento! Se ha presentado un error.";
    }
}else{
    header("location: ../error.php");
    exit();
}

unset($stmt);

unset($pdo);
}

?>