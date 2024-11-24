<?php

require_once "../configuracion.php";

$sql = "SELECT s.*, p.nombreProducto FROM infosalida s INNER JOIN productos p ON s.producto = p.id ORDER BY s.fechaS DESC";


$nombreProducto = "";
if ($resultado = $pdo->query($sql)) {
    if ($resultado->rowCount()) {
        echo '<table class="table table-hover table-bordered table-striped">';
        echo "<thead class='table-dark'>";
        echo "<tr>";       
        echo "<th scope='col'>Fecha</th>";
        echo "<th scope='col'>Demanda y Producto</th>";
        echo "<th scope='col'>Turno</th>";
        echo "<th scope='col'>Horas</th>";
        echo "<th scope='col'>Minutos</th>";
        echo "<th scope='col'>Segundos</th>";
        echo "<th scope='col'>New Tack Time</th>";
        echo "<th scope='col'>Nueva demanda requerida</th>";
        echo "<th scope='col'>Tack Time Final</th>";
        echo "<th scope='col'>Acción</th>";
        echo "</tr>";
        echo "</thead>";

        while ($row = $resultado->fetch()) {
            echo "<tr>";
            echo "<td>".$row["fechaS"]."</td>";
            echo "<td>".$row["demanda"]." ".$row["nombreProducto"]."</td>";
            echo "<td>".$row["turno"]."</td>";
            echo "<td>".$row["horas"]."</td>";
            echo "<td>".$row["minutos"]."</td>";
            echo "<td>".$row["segundos"]."</td>";
            echo "<td>".$row["calidad"]."% calidad / ".$row["newTacktime"]." Segundos</td>";
            echo "<td>".$row["newCalidad"]." ".$row["nombreProducto"]." </td>";
            echo "<td>".$row["eficiencia"]."% eficiencia / ".$row["newEficiencia"]." Segundos</td>";
           
            echo "<td>";
            echo '<a href="./delete.php?id='.$row["idS"].'" class="btn btn-danger btn-sm"> Eliminar</a>';
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
        unset($resultado);
     
    } else {
        echo '<div class="alert alert-danger"><em>No hay registros.</em></div>';
    }
}else {
    echo "Lo siento! Se ha presentado un error.";
}
?>

