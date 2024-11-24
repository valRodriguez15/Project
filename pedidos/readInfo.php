<?php
session_start();
require_once "../configuracion.php";


$param_id = trim($_GET["id"]);
if (!is_numeric($param_id)) {
    header("location: ../infoEnviada.php");
}

$sql = "SELECT c.*, p.*, a.* FROM clientes c JOIN infoadmin a ON c.id = a.idCliente 
                                             JOIN productos p ON p.id = c.idProduct 
                                             WHERE c.id = :id";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $param_id, PDO::PARAM_INT);
$stmt->execute();

if ($stmt->rowCount()) {
    $row = $stmt->fetch();

    echo '<div class="card-header">';
                echo 'FECHA: ';
                echo '<strong>'.$row["fechaProgramado"].'</strong>';
            echo '</div>';
            echo '<div class="card-header">';
            echo 'CLIENTE: ';
            echo '<strong>'.$row["nombre"].'</strong>';
        echo '</div>';
        if ($row['progressValue'] < 100) {
            echo '<div class="card-header">';
            echo 'ESTADO: ';
            echo '<strong>Pendiente '.$row["progressValue"].'%</strong>';
        echo '</div>';
        } else {
            echo '<div class="card-header">';
            echo 'ESTADO: ';
            echo '<strong>Completado '.$row["progressValue"].'%</strong>';
        echo '</div>';
        }
       
                echo '<div class="table-responsive-sm">';
                    echo '<table border="1" class="table table-sm table-striped">';
                        echo '<thead>';
                            echo '<tr>';
                                echo '<th scope="col" width="2%" class="center">#</th>';
                                echo '<th scope="col" width="20%">PRODUCTO</th>';
                                echo '<th scope="col" width="10%" class="text-right">P. UNIDAD</th>';
                                echo '<th scope="col" width="8%" class="text-right">CANTIDAD</th>';
                                echo '<th scope="col" width="8%" class="text-right">DIRECCIÓN</th>';
                            echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                            echo '<tr>';
                                echo '<td class="text-left">1</td>';
                                echo '<td class="item_name">'.$row["nombreProducto"].'</td>';
                                echo '<td class="text-right">$'.number_format($row["valor"]).'</td>';
                                echo '<td class="text-right">'.$row["cantidad"].'</td>';
                                echo '<td class="text-right">'.$row["direccion"].'</td>';
                            echo '</tr>';
                        echo '</tbody>';
                    echo '</table>';
                echo '</div>';
               
                echo '<div class="row">';
                    echo '<div class="col-lg-4 col-sm-5">';
                    echo '</div>';

                    echo '<div class="col-lg-4 col-sm-5 ml-auto">';
                        echo '<table class="table table-sm table-clear">';
                            echo '<tbody>';
                                echo '<tr>';
                                    echo '<td class="left">';
                                        echo '<strong>Total</strong>';
                                    echo '</td>';
                                    echo '<td class="text-right bg-light">';
                                        echo '<strong>$'.number_format($row["valor"] * $row["cantidad"]).'</strong>';
                                    echo '</td>';
                                echo '</tr>';
                            echo '</tbody>';
                        echo '</table>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
            echo '<p><a href="./indexPedidos.php" class="btn btn-primary">Regresar</a></p>';
 
}

// cerrar el resultado
unset($stmt);


?>