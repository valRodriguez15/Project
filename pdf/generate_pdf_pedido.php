<?php
require('../fpdf/fpdf.php');
require_once "../configuracion.php";

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo
       // $this->Image('../assets/images/logo.png',10,8,33);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->Cell(30,10,'Reporte de Pedido',0,1,'C');
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
        $w = array(30, 50, 50, 30, 30); // Anchos de las columnas ajustados
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
            $this->Cell($w[0],6,$row['id'],'LR',0,'C',$fill);
            $this->Cell($w[1],6,$row['fecha'],'LR',0,'C',$fill);
            $this->Cell($w[2],6,$row['nombre'],'LR',0,'C',$fill);
            $this->Cell($w[3],6,$row['nombreProducto'],'LR',0,'C',$fill);
            $this->Cell($w[4],6,$row['cantidad'],'LR',0,'C',$fill);
            $this->Ln();
            $fill = !$fill;
        }
        // Línea de cierre
        $this->Cell(array_sum($w),0,'','T');
    }
}

// Obtener el ID del pedido desde la URL
$idPedido = $_GET['id'];

// Consulta para obtener los datos del pedido específico
$sql = "SELECT c.id, c.fecha, c.nombre, p.nombreProducto, c.cantidad 
        FROM clientes c 
        INNER JOIN productos p ON c.idProduct = p.id 
        WHERE c.id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $idPedido, PDO::PARAM_INT);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Creación del objeto de la clase heredada con orientación horizontal (L)
$pdf = new PDF('L', 'mm', 'A5');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);

// Títulos de las columnas
$header = array('ID', 'Fecha', 'Nombre', 'Producto', 'Cantidad');

$pdf->FancyTable($header, $data);
$pdf->Output();
?>