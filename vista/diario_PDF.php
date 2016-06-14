<?php
session_start();
require_once '../general/funcionesGenerales.php';


//extraigo la consulta de esta tabla
require_once '../CN/clsCNContabilidad.php';
$clsCNContabilidad=new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['dbContabilidad']);
$clsCNContabilidad->setStrBDCliente($_SESSION['mapeo']);


//$arResult=$clsCNContabilidad->ListadoFacturasDetalleIVA($_GET);
$arResult=$clsCNContabilidad->diario($_GET);
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
        $this->Cell(0,0,"Diario",0,0,'C');
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
$pdf->Ln();
$pdf->SetFont('Arial','',10);
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



$columAsiento = 20;
$columFecha = 20;
$columCuenta = 25;
$columConcepto = 70;
$columDebe = 25;
$columHaber = 25;


//Cuadro del presupuesto
//cabecera
$pdf->SetFillColor(240,248,255);
$pdf->SetDrawColor(200,200,200);
$pdf->SetFont('Arial','B',9);
$pdf->Cell($columAsiento+0.1, $altura, utf8_decode('Nº Asiento'),'LTBR',0,'R',true);
$pdf->Cell(0.1, $altura, '','R',0,'R');
$pdf->Cell($columFecha-0.1, $altura, 'Fecha','BTR',0,'L',true);
$pdf->Cell(0.1, $altura, '','R',0,'R');
$pdf->Cell($columCuenta-0.1, $altura, 'Cuenta','BTR',0,'L',true);
$pdf->Cell(0.1, $altura, '','R',0,'R');
$pdf->Cell($columConcepto-0.1, $altura, 'Concepto','BTR',0,'R',true);
$pdf->Cell(0.1, $altura, '','R',0,'R');
$pdf->Cell($columDebe-0.1, $altura, 'Debe','BTR',0,'R',true);
$pdf->Cell(0.1, $altura, '','R',0,'R');
$pdf->Cell($columHaber-0.1, $altura, 'Haber','BTR',0,'R',true);
$pdf->Ln();


//$tipoContador=$clsCNContabilidad->Parametro_general('Tipo Contador',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));

//sumas
$sumaDebe = 0;
$sumaHaber = 0;

//ahora recorro el array
if(is_array($arResult)){
    for ($i = 0; $i < count($arResult); $i++) {
        if($i%2 === 0){
            $fill = false;
        }else{
            $fill = true;
        }
        //$numeroFactura = numeroDesformateado($arResult[$i]['NumFactura'],$tipoContador);
        
        $pdf->SetFillColor(244,244,244);
        $pdf->SetFont('Arial','',9);
        $pdf->Cell($columAsiento+0.1, $altura, $arResult[$i]['asiento'],'L',0,'R',$fill);
        $pdf->Cell($columFecha, $altura, $arResult[$i]['Fecha'] ,'L',0,'L',$fill);
        $pdf->Cell($columCuenta, $altura, $arResult[$i]['idCuenta'],'L',0,'R',$fill);
        $pdf->Cell($columConcepto, $altura, utf8_decode($arResult[$i]['concepto']),'L',0,'L',$fill);
        $pdf->Cell($columDebe, $altura, formateaNumeroContabilidad($arResult[$i]['Debe']),'L',0,'R',$fill);
        $pdf->Cell($columHaber-0.2, $altura, formateaNumeroContabilidad($arResult[$i]['Haber']),'L',0,'R',$fill);
        $pdf->SetLineWidth(0.1);
        $pdf->Cell(0.1, $altura, '','R',0,'R');
        $pdf->Ln();

        $sumaDebe = $sumaDebe + (float)$arResult[$i]['Debe'];
        $sumaHaber = $sumaHaber + (float)$arResult[$i]['Haber'];
    }
    //linea inferior
    $pdf->Cell(185, 0,'','B',0,'R');
    $pdf->Ln();
}

//suma abajo
$pdf->SetFillColor(240,248,255);
//$pdf->SetDrawColor(200,200,200);
$pdf->SetFont('Arial','B',9);
$pdf->Cell($columAsiento+$columFecha+$columCuenta+$columConcepto-0.1, $altura, utf8_decode('Suma'),'LTBR',0,'R',true);
$pdf->Cell(0.1, $altura, '','R',0,'R');
$pdf->Cell($columDebe-0.1, $altura, formateaNumeroContabilidad($sumaDebe),'BTR',0,'R',true);
$pdf->Cell(0.1, $altura, '','R',0,'R');
$pdf->Cell($columHaber-0.1, $altura, formateaNumeroContabilidad($sumaHaber),'BTR',0,'R',true);
$pdf->Ln();














//se renderiza el PDF
$pdf->Output();
