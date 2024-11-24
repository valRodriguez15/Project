<?php
$id = 0;
$date = '';
$idProduct = '';
$days = 0;
$turno = '';
$demanda = 0;
$calidad = 0;
$eficiencia = 0;
$nombreProducto = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    capturarDatos();
   
}

function capturarDatos(){

    require_once "../configuracion.php";

    $totalTurno = 8;
    $minuto = 60;
    $segundo = 60;
    $newCalidad = 0;
    $newEficiencia = 0;


    $date = $_POST["datee"];
    $idProduct = $_POST["idProducto"];
    $days = $_POST["dayss"];
    $turno = intval($_POST["turnoo"]);
    $demanda = $_POST["demandaa"];
    $calidad = $_POST["calidadd"];
    $eficiencia = $_POST["eficienciaa"];

    $totalJornada = $totalTurno * $turno;
    $totalHoras = $totalJornada * $days;
    $totalMinutos = $totalHoras * $minuto;
    $totalSegundos = $totalMinutos * $segundo;
    $tackTime = (($totalSegundos) / $demanda);
    $newCalidad = $tackTime * ($calidad/ 100);
    $newEficiencia = $newCalidad * ($eficiencia/ 100);
    $newDemandaCalidad = $totalSegundos / $newCalidad;
    $newDemandaEficiencia = $totalSegundos / $newEficiencia;

    $sql = "INSERT INTO infosalida (fechaS, producto, turno, demanda, calidad, eficiencia, horas, minutos, segundos, newTacktime, newCalidad, newEficiencia) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $pdo->prepare($sql)) {
        if ($stmt->execute([$date, $idProduct, $turno, $demanda, $calidad, $eficiencia, $totalHoras, $totalMinutos, $totalSegundos, $tackTime, $newDemandaCalidad, $newEficiencia])) {
            header("location: indexTackTime.php");
            exit();
        } else {
            echo "Ha ocurrido un error";
        }
    };

    unset($stmt);

    unset($pdo);
    
}