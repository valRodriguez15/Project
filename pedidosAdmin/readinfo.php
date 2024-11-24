<?php

require_once "../configuracion.php";
$param_id = trim($_GET["idA"]);
if (!is_numeric($param_id)) {
    throw new Exception("ID inválido");
};
echo 'id'.$param_id;
$sql = "SELECT c.*, p.*, a.* FROM clientes c JOIN infoadmin a ON c.id = a.idCliente 
                                             JOIN productos p ON p.id = c.idProduct 
                                             WHERE c.id = :id";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $param_id, PDO::PARAM_INT);
$stmt->execute();


if ($stmt->rowCount()) {
    $row = $stmt->fetch();
            echo "<h5>Pedido Número: ".$param_id."</h5>";   
            echo "<h5>A nombre de: ".$row["nombre"]."</h5>";   
            
            echo '<a href="#" class="p-2 view-order" data-id="'.$row["id"].'">Ver Pedido</a>';   
            echo '<a href="./create.php?idA='.$row["idA"].'" class="p-2">Modificar Pedido</a>'; 
            echo '<a href="./delete.php?idA='.$row["idA"].'" class="p-2">Eliminar Pedido</a>';
        }
        unset($resultado); // cerrar el resultado

?>