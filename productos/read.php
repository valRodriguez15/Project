<?php

require_once "../configuracion.php";

$sql = "SELECT * FROM productos";

if ($resultado = $pdo->query($sql)) {
    if ($resultado->rowCount()) {
        echo '<table class="table table-hover table-bordered table-striped">';
        echo "<thead class='table-dark'>";
        echo "<tr>";
        echo "<th scope='col'>ID</th>";
        echo "<th scope='col'>Nombre del Producto</th>";
        echo "<th scope='col'>Valor del Producto</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($row = $resultado->fetch()) {
            echo "<tr>";
            echo "<td>".$row["id"]."</td>";
            echo "<td>".$row["nombreProducto"]."</td>";
            echo "<td>$".number_format($row["valor"], 2)."</td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";

        // Liberar el resultado
        unset($resultado);
    } else {
        echo "<p class='alert alert-warning text-center'>No hay productos registrados</p>";
    }
} else {
    echo "<p class='alert alert-danger text-center'>Algo ha salido mal</p>";
}
?>
