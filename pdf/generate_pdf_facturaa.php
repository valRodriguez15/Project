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
        $this->Cell(30,10,'Factura',0,1,'C');
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

    // Sección estilizada
    function SectionTitle($title)
    {
        $this->SetFont('Arial','B',12);
        $this->SetFillColor(200,220,255);
        $this->Cell(0,10,$title,0,1,'L', true);
        $this->Ln(2);
    }

    // Información estilizada
    function SectionContent($label, $value)
    {
        $this->SetFont('Arial','',12);
        $this->SetFillColor(240,240,240);
        $this->Cell(50,10,$label.':',0,0,'L', true);
        $this->SetFont('Arial','B',12);
        $this->Cell(0,10,$value,0,1,'L', true);
        $this->Ln(2);
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
        $w = array(40, 35, 40, 45);
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
            $this->Cell($w[0],6,$row['fechaProgramado'],'LR',0,'L',$fill);
            $this->Cell($w[1],6,$row['nombre'],'LR',0,'L',$fill);
            $this->Cell($w[2],6,$row['direccion'],'LR',0,'L',$fill);
            $this->Cell($w[3],6,$row['ciudad'],'LR',0,'L',$fill);
            $this->Ln();
            $fill = !$fill;
        }
        // Línea de cierre
        $this->Cell(array_sum($w),0,'','T');
    }
}

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

    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial','',12);

    // Sección: Datos del Pedido
    $pdf->SectionTitle('Datos del Pedido');
    $pdf->SectionContent('Fecha Pedido', $row['fechaProgramado']);
    $pdf->SectionContent('Cliente', $row['nombre']);
    $pdf->SectionContent('Valor del Pedido', $row['valor'] * $row['cantidad']);
    $pdf->SectionContent('Dirección Envío', $row['direccion']);
    $pdf->SectionContent('Ciudad', $row['ciudad']);

    // Sección: Antigüedad y Cumplimiento
    $pdf->SectionTitle('Antigüedad y Cumplimiento');
    $pdf->SectionContent('Días antigüedad', $diff->days);
    $pdf->SectionContent('Cumplimiento', '0%');

    // Sección: Proceso Interno
    $pdf->SectionTitle('Proceso Interno');
    $pdf->SectionContent('Programado', $row['fechaProgramado']);
    $pdf->SectionContent('Disenio', $row['fechaDisenio']);
    $pdf->SectionContent('Corte', $row['fechaCorte']);
    $pdf->SectionContent('Confección', $row['fechaConfeccon']);
    $pdf->SectionContent('Rev Final', $row['fechaRevfinal']);

    // Sección: Logística
    $pdf->SectionTitle('Logística');
    $pdf->SectionContent('Factura', $row['id']);
    $pdf->SectionContent('Transportadora', $row['transportadora']);
    $pdf->SectionContent('Fecha Despacho', $row['fechaDespacho']);
    $pdf->SectionContent('Fecha Recibido', $row['fechaRecibido']);

    // Sección: Detalles del Producto
    $pdf->SectionTitle('Detalles del Producto');
    $pdf->SectionContent('Cantidad', $row['cantidad']);
    $pdf->SectionContent('Referencia Producto', $row['idProduct']);
    $pdf->SectionContent('Nombre del Producto', $row['nombreProducto']);

    $pdf->Output();
} else {
    echo "No se encontraron datos para el ID proporcionado.";
}

function validarFecha($fechaProgramado, $formato = 'Y-m-d') {
    $d = DateTime::createFromFormat($formato, $fechaProgramado);
    return $d && $d->format($formato) === $fechaProgramado;
}
?>