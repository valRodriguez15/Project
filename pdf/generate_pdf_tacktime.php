<?php
require_once "../configuracion.php";
require('../fpdf/fpdf.php');

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image('../assets/images/logo.jpeg',10,8,33);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->Cell(120,10,'Reporte de Tack Time',0,1,'C');
        // Salto de línea
        $this->Ln(20);
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'C');
    }

    // Tabla estilizada
    function FancyTable($header, $data)
    {
        // Colores, ancho de línea y fuente en negrita
        $this->SetFillColor(255,0,0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128,0,0);
        $this->SetLineWidth(.3);
        $this->SetFont('','B');
        // Cabecera
        $w = array(30, 62, 63, 58, 70);
        for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
        $this->Ln();
        // Restauración de colores y fuentes
        $this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Datos
        $fill = false;
        foreach($data as $row)
        {
            $this->Cell($w[0],6,$row['fechaS'],'LR',0,'L',$fill);
            $this->Cell($w[1],6,$row['demanda'].' '.$row['nombreProducto'],'LR',0,'L',$fill);
            $this->Cell($w[2],6,$row['calidad'].'% calidad / '.$row['newTacktime'].' Segundos','LR',0,'L',$fill);
            $this->Cell($w[3],6,$row['newCalidad'].' '.$row['nombreProducto'],'LR',0,'L',$fill);
            $this->Cell($w[4],6,$row['eficiencia'].'% eficiencia / '.$row['newEficiencia'].' Segundos','LR',0,'L',$fill);
            $this->Ln();
            $fill = !$fill;
        }
        // Línea de cierre
        $this->Cell(array_sum($w),0,'','T');
    }
}

// Obtener los datos de la tabla infosalida
$sql = "SELECT s.*, p.nombreProducto FROM infosalida s INNER JOIN productos p ON s.producto = p.id ORDER BY s.fechaS DESC";
$result = $pdo->query($sql);
$data = $result->fetchAll(PDO::FETCH_ASSOC);

$pdf = new PDF('L', 'mm', 'A4'); // Orientación horizontal
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);

// Títulos de las columnas
$header = array('Fecha', 'Demanda y Nombre Producto', 'New Tack Time', 'Nueva demanda requerida', 'Tack Time Final');
$pdf->FancyTable($header, $data);
$pdf->Output();
?>