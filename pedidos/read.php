<?php
require_once "../configuracion.php";  

$sql = "SELECT c.*, p.nombreProducto, p.valor, a.progressValue FROM clientes c JOIN productos p ON c.idProduct = p.id
                                                                JOIN infoadmin a ON a.idCliente = c.id";

if($resultado = $pdo -> query($sql)){
    if($resultado -> rowCount()){ 
        while ($row = $resultado -> fetch()) {

           

if (isset($_SESSION['alert'])) {
    echo "<div class='alert'>" . $_SESSION['alert'] . "</div>";
    unset($_SESSION['alert']);
}
            echo '<hr/>';
            echo "<h5>Pedido Número: ".$row["id"]."</h5>";   
            echo "<h5>A nombre de: ".$row["nombre"]."</h5>";   
            $valorTotal = $row["valor"] * $row["cantidad"];
            if ($row["progressValue"] <20 ){
                echo "<h5>Avance: No hay actualizaciones. </h5>"; 
            }else{
                echo "<h5>Avance: ".$row["progressValue"]."%</h5>"; 
            }
              

            
            echo '<a href="#" class="p-2 view-order" data-id="'.$row["id"].'">Ver Pedido</a>';   
           
            

            if ($row["progressValue"] < 100) {
                echo '<a href="./create.php?id='.$row["id"].'" class="p-2">Modificar Pedido</a>'; 
                echo '<a href="./delete.php?id='.$row["id"].'" class="p-2">Eliminar Pedido</a>';
            } else {
                echo '<br>';
                echo "Nota: Este pedido está completado y no puede ser modificado ni eliminado.<br>";
            }
           
        }
        unset($resultado); // cerrar el resultado
    } else {
        echo '<div class="alert alert-danger"><em>No hay pedidos en la fila.</em></div>';
    }
} else {
    echo "Lo siento! Se ha presentado un error.";
}

?>