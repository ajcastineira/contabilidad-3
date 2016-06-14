<?php
session_start();
require_once '../general/funcionesGenerales.php';


//extraigo la consulta de esta tabla
require_once '../CN/clsCNContabilidad.php';
$clsCNContabilidad=new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['dbContabilidad']);
$clsCNContabilidad->setStrBDCliente($_SESSION['mapeo']);


$arResult=$clsCNContabilidad->ListadoFacturasDetalleIVA($_GET);
//var_dump($arResult);die;

require('../general/PDF/fpdf.php');

class PDF extends FPDF
{
    
    // Cabecera de página
    function Header()
    {
        $this->Ln(1);
        // Arial 12
        $this->SetFont('Arial','B',12);
        // Movernos a la derecha
        $this->Cell(50);
        // Título
        $this->SetX(0);
        $this->Cell(0,0,"Listado de Facturas",0,0,'C');
        // Salto de línea
        $this->Ln(10);
    }
    
    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-18);
        // Arial italic 8
        $this->SetFont('Arial','',9);
        // Número de página
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
    }
}


// Creación del objeto de la clase heredada
$pdf = new PDF();

$altura = 6;
$colum50 = 50;
$colum75 = 75;
$colum25 = 25;

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetAutoPageBreak(true,25);

//$X = 15;
//$pdf->SetX($X);



$pdf->SetFillColor(240,248,255);
$pdf->SetDrawColor(200,200,200);
$pdf->SetFont('Arial','',10);
$pdf->Cell($colum25+0.1, $altura, "Empresa: ",0,'R',true);
$pdf->Cell(0.1, $altura, '','R',0,'R');
$pdf->Cell($colum75-0.1, $altura, utf8_decode($_SESSION['sesion']),'BTR',0,'L',true);
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','B',12);
$pdf->Cell(90, $altura, "Filtros",0,'R',true);
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell($colum50+0.1, $altura, "Cliente: ",0,'R',true);
$pdf->Cell(0.1, $altura, '','R',0,'R');
$pdf->Cell($colum50-0.1, $altura, utf8_decode($_GET['strNomContacto']),'BTR',0,'L',true);
$pdf->Ln();
$pdf->Cell($colum50+0.1, $altura, "Estado: ",0,'R',true);
$pdf->Cell(0.1, $altura, '','R',0,'R');
$pdf->Cell($colum50-0.1, $altura, utf8_decode($_GET['estado']),'BTR',0,'L',true);
$pdf->Cell(0.1, $altura, '','R',0,'R');
$pdf->Cell($colum25+0.1, $altura, "Ejercicio: ",0,'R',true);
$pdf->Cell(0.1, $altura, '','R',0,'R');
$pdf->Cell($colum50-0.1, $altura, utf8_decode($_GET['ejercicio']),'BTR',0,'L',true);
$pdf->Ln();
$pdf->Cell($colum50+0.1, $altura, "Fecha Desde: ",0,'R',true);
$pdf->Cell(0.1, $altura, '','R',0,'R');
$pdf->Cell($colum50-0.1, $altura, utf8_decode($_GET['datFechaInicio']),'BTR',0,'L',true);
$pdf->Cell(0.1, $altura, '','R',0,'R');
$pdf->Cell($colum25+0.1, $altura, "Fecha Hasta: ",0,'R',true);
$pdf->Cell(0.1, $altura, '','R',0,'R');
$pdf->Cell($colum50-0.1, $altura, utf8_decode($_GET['datFechaFin']),'BTR',0,'L',true);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();



$columFactura = 20;
$columCliente = 70;
$columFecha = 20;
$columBI = 25;
$columCuota = 25;
$columTotal = 25;


//Cuadro del presupuesto
//cabecera
$pdf->SetFillColor(240,248,255);
$pdf->SetDrawColor(200,200,200);
$pdf->SetFont('Arial','B',9);
$pdf->Cell($columFactura+0.1, $altura, utf8_decode('Nº Factura'),'LTBR',0,'R',true);
$pdf->Cell(0.1, $altura, '','R',0,'R');
$pdf->Cell($columCliente-0.1, $altura, '  Cliente','BTR',0,'L',true);
$pdf->Cell(0.1, $altura, '','R',0,'R');
$pdf->Cell($columFecha-0.1, $altura, 'Fecha','BTR',0,'L',true);
$pdf->Cell(0.1, $altura, '','R',0,'R');
$pdf->Cell($columBI-0.1, $altura, 'Base Imponible','BTR',0,'R',true);
$pdf->Cell(0.1, $altura, '','R',0,'R');
$pdf->Cell($columCuota-0.1, $altura, 'Cuota IVA','BTR',0,'R',true);
$pdf->Cell(0.1, $altura, '','R',0,'R');
$pdf->Cell($columTotal-0.1, $altura, 'Total','BTR',0,'R',true);
$pdf->Ln();


$tipoContador=$clsCNContabilidad->Parametro_general('Tipo Contador',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));

//sumas
$contarF = 0;
$sumaBI = 0;
$sumaCuotaIVA = 0;
$sumaTotal = 0;

//ahora recorro el array
if(is_array($arResult)){
    for ($i = 0; $i < count($arResult); $i++) {
        if($i%2 === 0){
            $fill = false;
        }else{
            $fill = true;
        }
        $numeroFactura = numeroDesformateado($arResult[$i]['NumFactura'],$tipoContador);
        
        $pdf->SetFillColor(244,244,244);
        $pdf->SetFont('Arial','',9);
        $pdf->Cell($columFactura+0.1, $altura, $numeroFactura,'L',0,'R',$fill);
        $pdf->Cell($columCliente, $altura, utf8_decode($arResult[$i]['Cliente']) ,'L',0,'L',$fill);
        $pdf->Cell($columFecha, $altura, $arResult[$i]['FechaFactura'],'L',0,'R',$fill);
        $pdf->Cell($columBI, $altura, formateaNumeroContabilidad($arResult[$i]['BaseImponible']),'L',0,'R',$fill);
        $pdf->Cell($columCuota, $altura, formateaNumeroContabilidad($arResult[$i]['cuotaIVA']),'L',0,'R',$fill);
        $pdf->Cell($columTotal-0.2, $altura, formateaNumeroContabilidad($arResult[$i]['totalImporte']),'L',0,'R',$fill);
        $pdf->SetLineWidth(0.1);
        $pdf->Cell(0.1, $altura, '','R',0,'R');
        $pdf->Ln();

        $sumaTotal = $sumaTotal + (float)$arResult[$i]['totalImporte'];
        $sumaBI = $sumaBI + (float)$arResult[$i]['BaseImponible'];
        $sumaCuotaIVA = $sumaCuotaIVA + (float)$arResult[$i]['cuotaIVA'];
    }
    //linea inferior
    $pdf->Cell(185, 0,'','B',0,'R');
    $pdf->Ln();
}

//suma abajo
$pdf->SetFillColor(240,248,255);
//$pdf->SetDrawColor(200,200,200);
$pdf->SetFont('Arial','B',9);
$pdf->Cell($columFactura+$columCliente+$columFecha-0.1, $altura, utf8_decode('Suma'),'LTBR',0,'R',true);
$pdf->Cell(0.1, $altura, '','R',0,'R');
$pdf->Cell($columBI-0.1, $altura, formateaNumeroContabilidad($sumaBI),'BTR',0,'R',true);
$pdf->Cell(0.1, $altura, '','R',0,'R');
$pdf->Cell($columCuota-0.1, $altura, formateaNumeroContabilidad($sumaCuotaIVA),'BTR',0,'R',true);
$pdf->Cell(0.1, $altura, '','R',0,'R');
$pdf->Cell($columTotal-0.1, $altura, formateaNumeroContabilidad($sumaTotal),'BTR',0,'R',true);
$pdf->Ln();














//se renderiza el PDF
$pdf->Output();
