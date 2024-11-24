<?php

require_once "../configuracion.php";


$param_id = trim($_GET["id"]);
if (!is_numeric($param_id)) {
    header("location: ../infoEnviada.php");
}

$sql = "SELECT i.*, p.* FROM inforecibida i INNER JOIN productos p ON p.id = i.idProducto
                                                 WHERE i.id = :id";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $param_id, PDO::PARAM_INT);
$stmt->execute();

if ($stmt->rowCount()) {
    $row = $stmt->fetch();

    
    echo '<div class="container-fluid">';
    echo '<div class="row">';
        echo '<div class="col-md-12">';
            echo '<h1 class="mt-5 mb-3">Detalles del registro</h1>';
    
            echo '<div class="form-group">';
                echo '<label  for="onames">Fecha: </label>';
                echo '<p id="onames" class="fw-bold">'.$row["fecha"].'</p>';
            echo '</div>';
            echo '<div class="form-group">';
                echo '<label for="rnombre">Producto solicitado:</label>';
                echo '<p id="rnombre" name="rnombre" class="fw-bold">'.$row["nombreProducto"].'</p>';
            echo '</div>';
            echo '<div class="form-group">';
                echo '<label for="rdireccion">Demanda solicitada:</label>';
                echo '<p id="rdireccion" name="rdireccion" class="fw-bold">'.$row["demanda"].'</p>';
            echo '</div>';
            echo '<div class="form-group">';
                echo '<label for="rciudad">Turnos diarios:</label>';
                echo '<p id="rciudad" name="rciudad" class="fw-bold">'.$row["turno"].'</p>';
            echo '</div>';
            echo '<div class="form-group">';
                echo '<label for="rdireccion">Porcentaje de calidad:</label>';
                echo '<p id="rdireccion" name="rdireccion" class="fw-bold">'.$row["calidad"].'%</p>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="rdireccion">Porcentaje de eficiencia:</label>';
            echo '<p id="rdireccion" name="rdireccion" class="fw-bold">'.$row["eficiencia"].'%</p>';
        echo '</div>';
            echo '<p><a href="./indexPedidos.php" class="btn btn-primary">Regresar</a></p>';
        echo '</div>';
    echo '</div>  ';      
echo '</div>';

 
}

// cerrar el resultado
unset($stmt);


?>