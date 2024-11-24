<?php
require_once "../configuracion.php";

// Consulta para obtener los datos de la demanda, calidad y eficiencia de productos
$sql = "SELECT p.nombreProducto, SUM(s.demanda) as totalDemanda, AVG(s.calidad) as avgCalidad, AVG(s.eficiencia) as avgEficiencia 
        FROM infosalida s 
        INNER JOIN productos p ON s.producto = p.id 
        GROUP BY p.nombreProducto";
$resultado = $pdo->query($sql);

$labels = [];
$demandaData = [];
$calidadData = [];
$eficienciaData = [];
if ($resultado->rowCount()) {
    while ($row = $resultado->fetch()) {
        $labels[] = $row["nombreProducto"];
        $demandaData[] = $row["totalDemanda"];
        $calidadData[] = $row["avgCalidad"];
        $eficienciaData[] = $row["avgEficiencia"];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Gráfico</title>
    <link href="../css/bootstrap-5.1.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../css/bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Ajustar el tamaño del contenedor canvas */
        canvas {
            max-width: 90%;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h3 class="text-primary text-uppercase ms-4 mt-4">Reporte Gráfico</h3>
        <div class="row">
            <?php foreach ($labels as $index => $label): ?>
                <div class="col-md-6">
                    <h4><?php echo htmlspecialchars($label); ?></h4>
                    <canvas id="chart-<?php echo $index; ?>"></canvas>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Verificar que los datos se están pasando correctamente
            console.log("Labels:", <?php echo json_encode($labels); ?>);
            console.log("Demanda Data:", <?php echo json_encode($demandaData); ?>);
            console.log("Calidad Data:", <?php echo json_encode($calidadData); ?>);
            console.log("Eficiencia Data:", <?php echo json_encode($eficienciaData); ?>);

            // Crear gráficos de torta para cada producto
            <?php foreach ($labels as $index => $label): ?>
                const data<?php echo $index; ?> = {
                    labels: ['Demanda', 'Calidad', 'Eficiencia'],
                    datasets: [{
                        label: '<?php echo htmlspecialchars($label); ?>',
                        data: [<?php echo $demandaData[$index]; ?>, <?php echo $calidadData[$index]; ?>, <?php echo $eficienciaData[$index]; ?>],
                        backgroundColor: [
                            'rgb(54, 162, 235)',
                            'rgb(75, 192, 192)',
                            'rgb(255, 205, 86)'
                        ],
                        hoverOffset: 4
                    }]
                };

                const config<?php echo $index; ?> = {
                    type: 'pie',
                    data: data<?php echo $index; ?>,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: '<?php echo htmlspecialchars($label); ?>'
                            }
                        }
                    },
                };

                const chart<?php echo $index; ?> = new Chart(
                    document.getElementById('chart-<?php echo $index; ?>'),
                    config<?php echo $index; ?>
                );
            <?php endforeach; ?>
        });
    </script>
</body>

</html>