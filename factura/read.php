<?php

require_once "../configuracion.php";

$param_id = trim($_GET["id"]);
if (!is_numeric($param_id)) {
    throw new Exception("ID inválido");
}

$sql = "SELECT c.*, p.*, a.* FROM clientes c JOIN infoadmin a ON c.id = a.idCliente 
                                             JOIN productos p ON p.id = c.idProduct 
                                             WHERE c.id = :id";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $param_id, PDO::PARAM_INT);
$stmt->execute();

function validarFecha($fechaProgramado, $formato = 'Y-m-d') {
    $d = DateTime::createFromFormat($formato, $fechaProgramado);
    return $d && $d->format($formato) === $fechaProgramado;
}

if ($stmt->rowCount()) {
    $row = $stmt->fetch();

    $fechaActual = date('Y-m-d');
    $fechaI = $row["fechaProgramado"]; 

    if (validarFecha($fechaI) && validarFecha($fechaActual)) {
        $date1 = new DateTime($fechaI);
        $date2 = new DateTime($fechaActual);
        $diff = $date1->diff($date2);
    } else {
        echo "Una de las fechas no es válida.";
    }

    echo '<div class="encabezado">';
    echo '<div class="orden">';
    echo ' <h3>Maestro de Pedidos/Órdenes</h3>';
    echo ' <div class="pedido-orden">';
    echo '<p>Pedido/Orden: <span id="pedido-orden">'.$param_id.'</span></p>';
    echo '<p>Fecha Actual: <span id="fecha-actual">'.$fechaActual.'</span></p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';

    echo '<div class="datos-pedido">';
    echo ' <h3>Datos del Pedido</h3>';
    echo ' <div class="datos-grid">';
    echo '  <p>Fecha Pedido: <span id="fecha-pedido">'.$row["fechaProgramado"] .'</span></p>';
    echo '<p>Cliente: <span id="cliente">'. $row["nombre"] . '</span></p>';
    echo '<p>Dirección Envío: <span id="direccion-envio">'.$row["direccion"] .'</span></p>';
    echo '  <p>Ciudad: <span id="ciudad">'.$row["ciudad"] .'</span></p>';
    echo '  <p>Valor del Pedido: <span id="valor-pedido">'.number_format($row["valor"] * $row["cantidad"]).'</span></p>';
    echo ' </div>';

    echo ' <div class="antiguedad-cumplimiento">';
    echo '   <div class="antiguedad">';
    echo '      <p>Días antigüedad: <span id="dias-antiguedad">'. $diff->days .'</span></p>';
    echo '      <p>Cumplimiento: <span id="cumplimiento">'.$row["progressValue"] .'%</span></p>';
    echo '  </div>';
    echo ' <div class="cumplimiento-porcentaje">';
    echo '    <div class="progress-circle" id="progressCircle">'.$row["progressValue"] .'%</div>';
    echo ' </div>';
    echo '</div>';
    echo ' </div>';

    echo ' <div class="proceso-interno">';
    echo '  <h3>Proceso Interno</h3>';
    echo '  <div class="proceso-grid">';
    echo '   <p>Programado: <span id="programado">'.$row["fechaProgramado"] .'</span></p>';
    echo '  <p>Diseño: <span id="diseno">'.$row["fechaDisenio"] .'</span></p>';
    echo '  <p>Corte: <span id="corte">'.$row["fechaCorte"] .'</span></p>';
    echo ' <p>Confección: <span id="confeccion">'.$row["fechaConfeccon"] .'</span></p>';
    echo '  <p>Rev Final: <span id="rev-final">'.$row["fechaRevfinal"] .'</span></p>';
    echo ' </div>';
    echo '  </div>';

    echo ' <div class="logistica">';
    echo '  <h3>Logística</h3>';
    echo '  <div class="logistica-grid">';
    echo ' <p>Factura: <span id="factura">F'.$row["idA"] .'</span></p>';
    echo '  <p>Transportadora: <span id="transportadora">'.$row["transportadora"] .'</span></p>';
    echo '   <p>Fecha Despacho: <span id="fecha-despacho">'.$row["fechaDespacho"] .'</span></p>';
    echo '    <p>Fecha Recibido: <span id="fecha-recibido">'.$row["fechaRecibido"] .'</span></p>';
    echo ' </div>';
    echo ' </div>';

    echo ' <div class="detalles-producto">';
    echo '  <h3>Detalles del Producto</h3>';
    echo '  <div class="producto-grid">';
    echo '     <p>Cantidad: <span id="cantidad">'.$row["cantidad"] .'</span></p>';
    echo '    <p>Referencia Producto: <span id="referencia-producto">'.$row["idProduct"] .'</span></p>';
    echo '    <p>Nombre del Producto: <span id="nombre-producto">'.$row["nombreProducto"] .'</span></p>';
    echo '  </div>';
    echo '</div>';
    echo '</div>';

    // Botón para generar PDF
    echo '<button class="btn btn-custom btn-pdf" type="button" onclick="window.open(\'../pdf/generate_pdf_facturaa.php?id='.$param_id.'\', \'_blank\')">Generar PDF</button>';
}

// cerrar el resultado
unset($stmt);

?>