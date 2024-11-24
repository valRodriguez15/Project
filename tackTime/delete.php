<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET["id"])) {
    $id = $_GET["id"];

    eliminarRegistro($id);
}



function eliminarRegistro($id){
    require_once "../configuracion.php";
    $sql = "DELETE FROM infosalida WHERE idS= :idpar";

    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam("idpar", $id);
        if ($stmt->execute()) {
            //si el resultado es exitoso se compreuba que si obtengamso registros
            header("location: indexTackTime.php");
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