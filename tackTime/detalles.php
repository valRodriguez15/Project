<?php

// Se comprueba que si venga el id del registro como parametro antes de proceder
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
   // desde este archivo se va a acceder a base de datos es necesario incluir la conenfiguracion y conexion a base de datos
    require_once "../configuracion.php";    

    
$sql = "SELECT i.*, p.* FROM inforecibida i INNER JOIN productos p ON p.id = i.idProducto
WHERE p.id = :id";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $param_id, PDO::PARAM_INT);
$stmt->execute();

// Se contruye la sentencia esql en una variable
    //se prepara la sentencia sql
   if($stmt = $pdo -> prepare($sql)){ 
        // se entrega el id copmo parametro
        $param_id = trim($_GET["id"]);
 // Se ejecuta la sentencia para obtener los varoles, si el resultado es true, se contruye la tabla y se pintan los varores
         if($stmt ->execute([$param_id])){ 
             //si el resultado es exitoso se compreuba que si obtengamso registros
            if($stmt ->rowCount() == 1){
                //dado que se obendria solo un registro porque se busca por ID, no es necesario hacer un siclo, el fet devuelve un array asociativo
                $row = $stmt -> fetch();
                // se recuperan los valores en cada variable
                $date = $row["fecha"];
                $days = $row["dias"];
                $idProduct = $row["idProducto"];
                $nombreProducto = $row["nombreProducto"];
                $turno = $row["turno"];
                $demanda = $row["demanda"]/100;
                $calidad = $row["calidad"]/100;
            } 
        } else{
            echo "Lo siento! Se ha presentado un error.";
        }
    }
   // cerrrar la variable stmt
    unset($stmt);
    // cerrar la conexion a la base de datos
    unset($mysqli);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles </title>
    <link href="../css/bootstrap-5.1.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../css/bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/style1.css">
</head>

<body>
    <h1>Detalles de los registros</h1>

    <div>
        <table class="tableFixHead">
            <tr>
                <th for="rdate">Fecha</th>
                <th for="rproducto">Producto</th>
                <th for="rhoras">Horas</th>
                <th for="rminutos">Minutos</th>
                <th for="rsegundos">Segundos</th>
                <th for="rtacktime">Nuevo Tack Time</th>
                <th for="rnewDemandaCalidad">Nueva demanda requerida</th>
                <th for="rnewDemandaEficiencia">Tack Time Final</th>
            </tr>
            <tr>
                <td id="rdate"  >
                   <?php
                   echo $row["fecha"]
                   ?> 
                </td>
                <td id="rproducto">
                <?php
                   echo 'El producto solicitado: '.$row["nombreProducto"]
                   ?> 
                </td>
                <td id="rhoras">
                <?php
                   echo 'Tiempo disponible de realización: '.$row["dias"]
                   ?> 
                </td>
                <td id="rminutos">
                <?php
                if ($turno == 1 ){
                    echo $row["turno"]. ' tuno diario';
                }else{
                    echo $row["turno"]. ' tunos diarios';
                }
                   ?>
                </td>
                <td id="rsegundos">
                <?php
                   echo 'Demanda solicitada ' . $row["demanda"]
                   ?> 
                </td>
                <td id="rtacktime">
                <?php
                   echo 'Porcentaje de calidad: '. $row["calidad"] . '%'
                   ?> 
                </td>
                <td id="rnewDemandaCalidad">
                <?php
                    echo 'Porcentaje de calidad: '. $row["eficiencia"] . '%'
                   ?> 
                </td>
            </tr>
            <button class="btn btn-primary"><a href="./indexTackTime.php">Regresar</a></button>
        </table>

        <script>
            window.onload = verDetalles();
        </script>
</body>

</html>