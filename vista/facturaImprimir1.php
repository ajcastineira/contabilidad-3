<?php
session_start ();
require_once '../CN/clsCNContabilidad.php';
require_once '../general/funcionesGenerales.php';


//Control de Sesion
ControlaLoginTimeOut();

//Control de Permisos. Hay que incluirlo en todas las páginas
/**************************************************************/
$strPagina=dameURL();
$strCargo = trim($_SESSION['cargo']);   //Esto es el puesto al que le hacemos un trim

$lngPermiso = AccesoUsuarioPagina ($strPagina, $strCargo);  // Le pasamos la página y el cargo. 

if ($lngPermiso==-1)
{//Se ha producido un error de base. TENDREMOS QUE PASAR A LA FUNCION ERROR
    ControlErrorPermiso();
    die;
}
if ($lngPermiso==0)
{//El usuario no tiene permisos por tanto mostramos error
    ControlAvisoPermiso();
    die;
}

//Si devuelve 1 entonces que siga el flujo 
/**************************************************************/


require('../general/PDF/fpdf.php');

$clsCNContabilidad=new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['dbContabilidad']);
$clsCNContabilidad->setStrBDCliente($_SESSION['mapeo']);

$datosPresupuesto=$clsCNContabilidad->datosPresupuesto($_GET['IdFactura']);
//print_r($datosPresupuesto);die;


class PDF extends FPDF
{
    public $datosPresupuesto;
    public $datosNuestraEmpresa;
    public $fill;
    
function setDatosPresupuesto($datos){
    $this->datosPresupuesto=$datos;
}

function setDatosNuestraEmpresa($datos){
    $this->datosNuestraEmpresa=$datos;
}    
    
    
    
// Cabecera de página
function Header()
{
    // Logo
    if($_SESSION['imprimeDoc']==='on'){
        $this->Image("../images/".$_SESSION['logo'],10,12,36,18);//  36/18 proporcional a 140/70 tamaño de la imagen
    }
    // Arial bold 14
    $this->SetFont('Arial','B',14);
    // Movernos a la derecha
    $this->Cell(150);
    // Título
    $this->Cell(30,20,utf8_decode('FACTURA Nº: ').utf8_decode($this->datosPresupuesto['NumFactura']),0,0,'R');
    // Salto de línea
    $this->Ln(25);
}

// Pie de página
function Footer()
{
    $this->SetFillColor(255,255,255);
    $this->SetTextColor(120,120,120);
    // Posición: a 1,5 cm del final
    $this->SetY(-20);
    // Arial italic 8
    $this->SetFont('Arial','',6);
    //calculo las palabras que tiene el texto
    $numPalabras=explode(' ',utf8_decode($this->datosPresupuesto['TxtPie']));
    
    $textoLinea='';
    $altura=0;
    for($i=0;$i<count($numPalabras);$i++){
        //voy rellenando la linea de palabras
        $textoLinea=$textoLinea.$numPalabras[$i].' ';
        //compruebo que no paso de un limite
        if(strlen($textoLinea)>170){
            $this->Cell(180, $altura,$textoLinea,0,0,'C',false);
            $textoLinea='';
            $altura=$altura+4;
            $this->Ln();
        }
    }
    //imprimo la ultima linea sino esta vacia
    if(strlen($textoLinea)>0){
        $this->Cell(180, $altura,$textoLinea,0,0,'C',false);
    }
    
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','',9);
    // Número de página
    $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
}

// Una tabla más completa
function DatosNuestrosYCliente()
{
    $this->SetFillColor(244,244,244);
    $this->SetDrawColor(200,200,200);
    
    // Datos nuestros: 1 linea
    $this->SetFont('Arial','B',10);
    $this->Cell(55, 4, utf8_decode($this->datosNuestraEmpresa['strSesion']),0,'L', 'L');
    $this->Cell(30, 4, ' ',0,0, 0);
    // Datos Cliente: 1 linea
    $this->SetFont('Arial','',9);
    $this->Cell(25, 4, utf8_decode("Att de D./Dña: "),'LT', 0, 'R',true);
    $this->Cell(75, 4, utf8_decode($this->datosPresupuesto['ContactoEmpresa']),'TR', 0, 'L');
    $this->Ln();
    // Datos nuestros: 2 linea
    $this->Cell(55, 4, utf8_decode($this->datosNuestraEmpresa['direccion']),0,'L', 'L');
    $this->Cell(30, 4, ' ',0,0, 0);
    // Datos Cliente: 2 linea
    $this->Cell(25, 4, "Cliente: ",'L', 0, 'R',true);
    $this->Cell(75, 4, utf8_decode($this->datosPresupuesto['NombreEmpresa']),'R', 0, 'L');
    $this->Ln();
    // Datos nuestros: 3 linea
    $this->Cell(55, 4, $this->datosNuestraEmpresa['CP'].' - '.utf8_decode($this->datosNuestraEmpresa['municipio']),0,'L', 'L');
    $this->Cell(30, 4, ' ',0,0, 0);
    // Datos Cliente: 3 linea
    $this->Cell(25, 4, "CIF: ",'L', 0, 'R',true);
    $this->Cell(75, 4, $this->datosPresupuesto['CIFEmpresa'],'R', 0, 'L');
    $this->Ln();
    // Datos nuestros: 4 linea
    $this->Cell(55, 4, utf8_decode($this->datosNuestraEmpresa['provincia']),0,'L', 'L');
    $this->Cell(30, 4, ' ',0,0, 0);
    // Datos Cliente: 4 linea
    $this->Cell(25, 4, utf8_decode("Dirección: "),'L', 0, 'R',true);
    $this->Cell(75, 4, utf8_decode($this->datosPresupuesto['DireccionEmpresa']),'R', 0, 'L');
    $this->Ln();
    // Datos nuestros: 5 linea
    $this->Cell(55, 4, 'CIF: '.utf8_decode($this->datosNuestraEmpresa['strCIF']),0,'L', 'L');
    $this->Cell(30, 4, ' ',0,0, 0);
    // Datos Cliente: 5 linea
    $this->Cell(25, 4, utf8_decode("Población: "),'L', 0, 'R',true);
    $this->Cell(75, 4, utf8_decode($this->datosPresupuesto['PoblacionEmpresa']),'R', 0, 'L');
    $this->Ln();
    // Datos nuestros: 6 linea
    $this->Cell(55, 4, utf8_decode('Teléfono: ').$this->datosNuestraEmpresa['telefono'],0,'L', 'L');
    $this->Cell(30, 4, ' ',0,0, 0);
    // Datos Cliente: 6 linea
    $this->Cell(25, 4, "Provincia: ",'LB', 0, 'R',true);
    $this->Cell(75, 4, utf8_decode($this->datosPresupuesto['ProvinciaEmpresa']),'BR', 0, 'L');
    $this->Ln();
}
}



// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->setDatosPresupuesto($clsCNContabilidad->datosFactura($_GET['IdFactura']));
$pdf->setDatosNuestraEmpresa($clsCNContabilidad->datosNuestraEmpresaPresupuesto());
//print_r($pdf->datosPresupuesto);die;
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',9);
$pdf->DatosNuestrosYCliente();
$pdf->SetDrawColor(0,0,0);
$pdf->Ln();
$pdf->Cell(180, 4, 'Referencia: '.utf8_decode($pdf->datosPresupuesto['Referencia']));
$pdf->Ln();
$pdf->Ln();
$fecha=explode('/',$pdf->datosPresupuesto['FechaFactura']);
//escribir mes en texto
switch ($fecha[1]) {
    case '01':
        $mes='Enero';
        break;
    case '02':
        $mes='Febrero';
        break;
    case '03':
        $mes='Marzo';
        break;
    case '04':
        $mes='Abril';
        break;
    case '05':
        $mes='Mayo';
        break;
    case '06':
        $mes='Junio';
        break;
    case '07':
        $mes='Julio';
        break;
    case '08':
        $mes='Agosto';
        break;
    case '09':
        $mes='Septiembre';
        break;
    case '10':
        $mes='Octubre';
        break;
    case '11':
        $mes='Noviembre';
        break;
    case '12':
        $mes='Diciembre';
        break;
}
$pdf->Cell(180, 4, utf8_decode($pdf->datosNuestraEmpresa['municipio'].', '.$fecha[2].' de '.$mes.' de '.$fecha[0]),0, 0, 'L');

$pdf->Ln();
$pdf->Ln();

//aqui conpruebo si todos los valores de Cantidad y Precio son 0, entonces estas dos columnas no las pongo en
//la factura
$cantidadEsCero='SI';
$precioEsCero='SI';

for($i=0;$i<count($pdf->datosPresupuesto['DetalleFactura']);$i++){
    if($pdf->datosPresupuesto['DetalleFactura'][$i]['cantidad']<>'0'){
        $cantidadEsCero='NO';
        break;
    }
    if($pdf->datosPresupuesto['DetalleFactura'][$i]['precio']<>'0'){
        $precioEsCero='NO';
        break;
    }
}

//si $cantidadEsCero o $precioEsCero es NO hacemos la factura con las columnas de cantidad y precio, sino
//no se incluyen estas columnas

$CONcolumnas='NO';
if($cantidadEsCero==='NO' || $precioEsCero==='NO'){
    $CONcolumnas='SI';
}

if($CONcolumnas==='SI'){// van las columnas de cantidad y precio

    //anchos de columnas
    $columCantidad=18;
    $columConcepto=54;
    $columPrecio=23;
    $columImporte=25;
    $columIva=10;
    $columCuota=25;
    $columTotal=30;

    //Cuadro del presupuesto
    //cabecera
    $pdf->SetFillColor(240,248,255);
    $pdf->SetDrawColor(200,200,200);
    $pdf->SetLineWidth(0.1);
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell($columCantidad+0.1, 6, 'Cantidad','LTBR',0,'R',true);
    $pdf->SetLineWidth(0.1);
    $pdf->Cell(0.1, 6, '','R',0,'R');
    $pdf->SetLineWidth(0.1);
    $pdf->Cell($columConcepto-0.1, 6, '  Concepto','BTR',0,'L',true);
    $pdf->SetLineWidth(0.1);
    $pdf->Cell(0.1, 6, '','R',0,'R');
    $pdf->SetLineWidth(0.1);
    $pdf->Cell($columPrecio-0.1, 6, 'Precio','BTR',0,'R',true);
    $pdf->SetLineWidth(0.1);
    $pdf->Cell(0.1, 6, '','R',0,'R');
    $pdf->SetLineWidth(0.1);
    $pdf->Cell($columImporte-0.1, 6, 'Importe','BTR',0,'R',true);
    $pdf->SetLineWidth(0.1);
    $pdf->Cell(0.1, 6, '','R',0,'R');
    $pdf->SetLineWidth(0.1);
    $pdf->Cell($columIva-0.1, 6, 'IVA','BTR',0,'R',true);
    $pdf->SetLineWidth(0.1);
    $pdf->Cell(0.1, 6, '','R',0,'R');
    $pdf->SetLineWidth(0.1);
    $pdf->Cell($columCuota-0.1, 6, 'Cuota','BTR',0,'R',true);
    $pdf->SetLineWidth(0.1);
    $pdf->Cell(0.1, 6, '','R',0,'R');
    $pdf->SetLineWidth(0.1);
    $pdf->Cell($columTotal-0.2, 6, 'Total','TBR',0,'R',true);
    $pdf->Ln();

    //las lineas del cuerpo
    $altura=6;
    $totalImporte=0;
    $totalCuota=0;
    for ($i=0;$i<count($pdf->datosPresupuesto['DetalleFactura']);$i++){
        //metemos las palabras que hay en el texto en un array
        $palabras=  explode(' ',utf8_decode($pdf->datosPresupuesto['DetalleFactura'][$i]['concepto']));
        //prepararmos un array con las lineas de texto rellenas de palabras que no sobrepasen 40 caracteres
        $linea='';
        $k=0;//indice de $palabras
        $lineas=array();
        while($k<count($palabras)){
            $lineaAux=$linea.' '.$palabras[$k];
            if(strlen($lineaAux)<35){
                //es menor de 30 caracteres, se incluye
                $linea=$lineaAux;
            }else{
                //es mayor o igual , no se incluye
                $lineas[]=$linea;
                $linea=$palabras[$k];
            }
            $k++;
        }

        //alternar en sombreados por lineas
        if($i%2 == 0){
            $pdf->fill=false;
        }else{
            $pdf->fill=true;
        }

        //se guarda las ultimas palabras
        $lineas[]=$linea;

        //recorrer lineas
        for($j=0;$j<count($lineas);$j++){
            $altura2=6;
            $pdf->SetFillColor(244,244,244);
            $pdf->SetLineWidth(0.1);
            $pdf->SetFont('Arial','',9);
            if($j==0){
                if($pdf->datosPresupuesto['DetalleFactura'][$i]['cantidad']==='0'){
                    $pdf->datosPresupuesto['DetalleFactura'][$i]['cantidad']='';
                }
                $pdf->Cell($columCantidad+0.1, $altura, formateaNumeroContabilidad($pdf->datosPresupuesto['DetalleFactura'][$i]['cantidad']),'L',0,'R',$pdf->fill);
            }else{
                $pdf->Cell($columCantidad+0.1, $altura, '','L',0,'R',$pdf->fill);
            }
            $pdf->SetLineWidth(0.1);
            if($j==0){
                $pdf->Cell($columConcepto, $altura, trim($lineas[$j]) ,'L',0,'L',$pdf->fill);
            }else{
                $pdf->Cell($columConcepto, $altura, trim($lineas[$j]) ,'L',0,'L',$pdf->fill);
            }
            if($j==0){
                if($pdf->datosPresupuesto['DetalleFactura'][$i]['precio']==='0'){
                    $pdf->datosPresupuesto['DetalleFactura'][$i]['precio']='';
                }
                $pdf->Cell($columPrecio, $altura, formateaNumeroContabilidad($pdf->datosPresupuesto['DetalleFactura'][$i]['precio']),'L',0,'R',$pdf->fill);
            }else{
                $pdf->Cell($columPrecio, $altura,'' ,'L',0,'R',$pdf->fill);
            }
            if($j==0){
                $pdf->Cell($columImporte, $altura, formateaNumeroContabilidad($pdf->datosPresupuesto['DetalleFactura'][$i]['importe']),'L',0,'R',$pdf->fill);
            }else{
                $pdf->Cell($columImporte, $altura, '','L',0,'R',$pdf->fill);
            }
            if($j==0){
                $pdf->Cell($columIva, $altura, $pdf->datosPresupuesto['DetalleFactura'][$i]['iva'],'L',0,'R',$pdf->fill);
            }else{
                $pdf->Cell($columIva, $altura,'' ,'L',0,'R',$pdf->fill);
            }
            if($j==0){
                $pdf->Cell($columCuota, $altura, formateaNumeroContabilidad($pdf->datosPresupuesto['DetalleFactura'][$i]['cuota']),'L',0,'R',$pdf->fill);
            }else{
                $pdf->Cell($columCuota, $altura,'' ,'L',0,'R',$pdf->fill);
            }
            if($j==0){  
                $pdf->Cell($columTotal-0.2, $altura, formateaNumeroContabilidad($pdf->datosPresupuesto['DetalleFactura'][$i]['total']),'L',0,'R',$pdf->fill);
                $pdf->SetLineWidth(0.1);
                $pdf->Cell(0.1, 6, '','R',0,'R');
            }else{
                $pdf->Cell($columTotal-0.2, $altura,'' ,'L',0,'R',$pdf->fill);
                $pdf->SetLineWidth(0.1);
                $pdf->Cell(0.1, 6, '','R',0,'R');
            }
            $pdf->Ln();
        }
        //sumas de importe y cuota
        $totalImporte=$totalImporte+$pdf->datosPresupuesto['DetalleFactura'][$i]['importe'];
        $totalCuota=$totalCuota+$pdf->datosPresupuesto['DetalleFactura'][$i]['cuota'];
    }
    //linea inferior
    $pdf->Cell(185, 0,'','B',0,'R');
    $pdf->Ln();

}else{//no van las columnas de cantidad y precio

    //anchos de columnas
//    $columCantidad=18;
    $columConcepto=95;
//    $columPrecio=23;
    $columImporte=25;
    $columIva=10;
    $columCuota=25;
    $columTotal=30;

    //Cuadro del presupuesto
    //cabecera
    $pdf->SetFillColor(240,248,255);
    $pdf->SetDrawColor(200,200,200);
    $pdf->SetLineWidth(0.1);
    $pdf->SetFont('Arial','B',9);
//    $pdf->Cell($columCantidad+0.1, 6, 'Cantidad','LTBR',0,'R',true);
//    $pdf->SetLineWidth(0.1);
//    $pdf->Cell(0.1, 6, '','R',0,'R');
//    $pdf->SetLineWidth(0.1);
    $pdf->Cell($columConcepto-0.1, 6, '  Concepto','LBTR',0,'L',true);
    $pdf->SetLineWidth(0.1);
    $pdf->Cell(0.1, 6, '','R',0,'R');
    $pdf->SetLineWidth(0.1);
//    $pdf->Cell($columPrecio-0.1, 6, 'Precio','BTR',0,'R',true);
//    $pdf->SetLineWidth(0.1);
//    $pdf->Cell(0.1, 6, '','R',0,'R');
//    $pdf->SetLineWidth(0.1);
    $pdf->Cell($columImporte-0.1, 6, 'Importe','BTR',0,'R',true);
    $pdf->SetLineWidth(0.1);
    $pdf->Cell(0.1, 6, '','R',0,'R');
    $pdf->SetLineWidth(0.1);
    $pdf->Cell($columIva-0.1, 6, 'IVA','BTR',0,'R',true);
    $pdf->SetLineWidth(0.1);
    $pdf->Cell(0.1, 6, '','R',0,'R');
    $pdf->SetLineWidth(0.1);
    $pdf->Cell($columCuota-0.1, 6, 'Cuota','BTR',0,'R',true);
    $pdf->SetLineWidth(0.1);
    $pdf->Cell(0.1, 6, '','R',0,'R');
    $pdf->SetLineWidth(0.1);
    $pdf->Cell($columTotal-0.2, 6, 'Total','TBR',0,'R',true);
    $pdf->Ln();

    //las lineas del cuerpo
    $altura=6;
    $totalImporte=0;
    $totalCuota=0;
    for ($i=0;$i<count($pdf->datosPresupuesto['DetalleFactura']);$i++){
        //metemos las palabras que hay en el texto en un array
        $palabras=  explode(' ',utf8_decode($pdf->datosPresupuesto['DetalleFactura'][$i]['concepto']));
        //prepararmos un array con las lineas de texto rellenas de palabras que no sobrepasen 40 caracteres
        $linea='';
        $k=0;//indice de $palabras
        $lineas=array();
        while($k<count($palabras)){
            $lineaAux=$linea.' '.$palabras[$k];
            if(strlen($lineaAux)<62){
                //es menor de 30 caracteres, se incluye
                $linea=$lineaAux;
            }else{
                //es mayor o igual , no se incluye
                $lineas[]=$linea;
                $linea=$palabras[$k];
            }
            $k++;
        }

        //alternar en sombreados por lineas
        if($i%2 == 0){
            $pdf->fill=false;
        }else{
            $pdf->fill=true;
        }

        //se guarda las ultimas palabras
        $lineas[]=$linea;

        //recorrer lineas
        for($j=0;$j<count($lineas);$j++){
            $altura2=6;
            $pdf->SetFillColor(244,244,244);
//            $pdf->SetLineWidth(0.1);
            $pdf->SetFont('Arial','',9);
//            if($j==0){
//                $pdf->Cell($columCantidad+0.1, $altura, formateaNumeroContabilidad($pdf->datosPresupuesto['DetalleFactura'][$i]['cantidad']),'L',0,'R',$pdf->fill);
//            }else{
//                $pdf->Cell($columCantidad+0.1, $altura, '','L',0,'R',$pdf->fill);
//            }
//            $pdf->SetLineWidth(0.1);
            if($j==0){
                $pdf->Cell($columConcepto-0.1, $altura, trim($lineas[$j]) ,'L',0,'L',$pdf->fill);
            }else{
                $pdf->Cell($columConcepto-0.1, $altura, trim($lineas[$j]) ,'L',0,'L',$pdf->fill);
            }
//            if($j==0){
//                $pdf->Cell($columPrecio, $altura, formateaNumeroContabilidad($pdf->datosPresupuesto['DetalleFactura'][$i]['precio']),'L',0,'R',$pdf->fill);
//            }else{
//                $pdf->Cell($columPrecio, $altura,'' ,'L',0,'R',$pdf->fill);
//            }
            if($j==0){
                $pdf->Cell($columImporte, $altura, formateaNumeroContabilidad($pdf->datosPresupuesto['DetalleFactura'][$i]['importe']),'L',0,'R',$pdf->fill);
            }else{
                $pdf->Cell($columImporte, $altura, '','L',0,'R',$pdf->fill);
            }
            if($j==0){
                $pdf->Cell($columIva, $altura, $pdf->datosPresupuesto['DetalleFactura'][$i]['iva'],'L',0,'R',$pdf->fill);
            }else{
                $pdf->Cell($columIva, $altura,'' ,'L',0,'R',$pdf->fill);
            }
            if($j==0){
                $pdf->Cell($columCuota, $altura, formateaNumeroContabilidad($pdf->datosPresupuesto['DetalleFactura'][$i]['cuota']),'L',0,'R',$pdf->fill);
            }else{
                $pdf->Cell($columCuota, $altura,'' ,'L',0,'R',$pdf->fill);
            }
            if($j==0){  
                $pdf->Cell($columTotal-0.2, $altura, formateaNumeroContabilidad($pdf->datosPresupuesto['DetalleFactura'][$i]['total']),'L',0,'R',$pdf->fill);
                $pdf->SetLineWidth(0.1);
                $pdf->Cell(0.1, 6, '','R',0,'R');
            }else{
                $pdf->Cell($columTotal-0.2, $altura,'' ,'L',0,'R',$pdf->fill);
                $pdf->SetLineWidth(0.1);
                $pdf->Cell(0.1, 6, '','R',0,'R');
            }
            $pdf->Ln();
        }
        //sumas de importe y cuota
        $totalImporte=$totalImporte+$pdf->datosPresupuesto['DetalleFactura'][$i]['importe'];
        $totalCuota=$totalCuota+$pdf->datosPresupuesto['DetalleFactura'][$i]['cuota'];
    }
    //linea inferior
    $pdf->Cell(185, 0,'','B',0,'R');
    $pdf->Ln();
    
}

//por último los subtotales y totales
$pdf->SetFillColor(240,248,255);
$pdf->SetLineWidth(0.1);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(($columCantidad+$columConcepto+$columPrecio-0.2), $altura, 'Subtotales','LT','L', 'R',true);
$pdf->Cell($columImporte, $altura, formateaNumeroContabilidad($totalImporte),'T','L', 'R',true);
$pdf->Cell(($columIva+$columCuota), $altura, formateaNumeroContabilidad($totalCuota),'T','L', 'R',true);
$pdf->Cell($columTotal, $altura, formateaNumeroContabilidad($totalImporte+$totalCuota),'TR','L', 'R',true);
$pdf->Ln();
$IRPFCuota=$totalImporte*$pdf->datosPresupuesto['Retencion']/100;
$totalFinal=$totalImporte+$totalCuota-$IRPFCuota;
if($pdf->datosPresupuesto['Retencion']<>'0'){
    $pdf->Cell(145-0.2, $altura, utf8_decode('Retención %'),'L','L', 'R',true);
    $pdf->Cell(10, $altura, $pdf->datosPresupuesto['Retencion'],0,'L', 'R',true);
    $pdf->Cell(30, $altura, formateaNumeroContabilidad($IRPFCuota),'R','L', 'R',true);
    $pdf->Ln();
}
$pdf->Cell(155-0.2, $altura, utf8_decode('TOTAL '),'LB','L', 'R',true);
$pdf->Cell(30, $altura, formateaNumeroContabilidad($totalFinal),'BR','L', 'R',true);
$pdf->Ln();
$pdf->Ln();

//forma de pago y validez presupuesto
$pdf->SetFillColor(232,232,232);
$pdf->Cell(25, $altura, 'Forma de Pago:',0,'L', 'R');
$pdf->Cell(35, $altura, utf8_decode($pdf->datosPresupuesto['FormaPago']),0,'R', 'L',true);
$pdf->Cell(40, $altura, 'Vencimiento:',0,'L', 'R');
$pdf->Cell(10, $altura, $pdf->datosPresupuesto['Validez'],0,'R', 'C',true);
$pdf->Cell(10, $altura, utf8_decode('días f.f.'),0,'L', 'L');
$pdf->Ln();
$pdf->Cell(25, $altura, '',0,'L', 'R');
if($pdf->datosPresupuesto['FormaPago'] === 'Transferencia'){
    $pdf->Cell(35, $altura, utf8_decode($pdf->datosPresupuesto['CC_Trans']),0,'R', 'L');
}
$pdf->Ln();


if($_GET['opcion']==='imprimir'){
    //se renderiza el PDF
    $pdf->Output();
}else{
    //se renderiza el PDF y se guarda
    $ejercicio=substr($pdf->datosPresupuesto['NumFacturaBBDD'],0,4);
    $numero=substr($pdf->datosPresupuesto['NumFacturaBBDD'],4,4);
//    $pdf->Output("../facturasEnviadas/Factura_".$_SESSION['idEmp'].'-'.$ejercicio.'-'.$numero.".pdf","F");
    $pdf->Output("../facturasEnviadas/Factura_".$_SESSION['idEmp'].'-'.$pdf->datosPresupuesto['NumFacturaBBDD'].".pdf","F");
    $pdf->Close();
}

?>

