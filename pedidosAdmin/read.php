<?php

require_once "../configuracion.php";

$sql = "SELECT c.*, a.*, p.nombreProducto, p.valor FROM clientes c JOIN productos p ON c.idProduct = p.id
                                                            JOIN infoadmin a ON a.idCliente = c.id";

if ($resultado = $pdo->query($sql)) {
    if ($resultado->rowCount()) {
        $count = 0;
        while ($row = $resultado->fetch()) {
            if ($count % 3 == 0) {
                if ($count != 0) {
                    echo "</div>"; // Cierra la fila anterior
                }
                echo "<div class='row'>"; // Abre una nueva fila
            }

            echo "<div class='col-lg-4 col-md-4 col-sm-6 col-xs-12'>";
            echo "<div class='pricing-table'>";
            echo "<div class='pricing-table-title'>";
            echo "<h5 class='pricing-title bg-info-hover text-white'>" . $row["nombre"] . "</h5>";
            echo "</div>";

            echo "<div class='pricing-table-price text-center bg-info'>";
            echo "<p class='title-font'>";
            echo "<span class='pricing-period text-white mr-1'>Precio:</span>";
            echo ' ';
            echo "<span class='pricing-currency text-white'>$</span>";
            echo "<span class='pricing-price text-white'>".number_format($row["valor"] * $row["cantidad"])."</span>";
            echo "<span class='pricing-period text-white'>COP.</span>";
            echo "</p>";
            echo "</div>";

            echo "<div class='pricing-table-content'>";
            echo "<ul>";
            echo "<li><strong>Producto Solicitado: " . $row["nombreProducto"] . "</strong></li>";
            echo "<li><strong>Cantidad de ". $row["nombreProducto"] .": " . $row["cantidad"] . "</strong></li>";
            echo "<li><strong>Ciudad de Entrega: " . $row["ciudad"] . "</strong></li>";
            if ( $row["progressValue"] == 100 ){
            echo "<li><strong> Completado ". $row["progressValue"] . "%</strong></li>";
            }else{
                echo "<li><strong> Pendiente ". $row["progressValue"] ."%</strong></li>";
            }
            echo "</ul>";

            if ( $row["progressValue"] == 100 ){
            echo "<div class='pricing-table-button'>";
            echo '<a href="../factura/factura.php?id='. $row["id"] .'" class="btn btn-outline-warning"><span>Generar Factura</span></a>';
            echo ' ';
            }else{
                echo '<a href="./create.php?idA='.$row["idA"] .'" class="btn btn-success"><span>Aceptar Pedido</span></a>';
                echo ' ';
                echo '<a href="./delete.php?idA='.$row["idA"].'" class="btn btn-danger"><span>Declinar Pedido</span></a>';
            }            

            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            
            $count++;
        }
        echo "</div>"; // Cierra la última fila
    }else {
        echo '<div class="alert alert-danger"><em>No hay pedidos en la fila.</em></div>';
    }
}else {
    echo "Lo siento! Se ha presentado un error.";
}
?>