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
    
    //anchos de columnas
    public $columCantidad;
    public $columConcepto;
    public $columPrecio;
    public $columImporte;
    public $columIva;
    public $columCuota;
    public $columTotal;
    
    public $totalImporte;
    public $totalCuota;
    
    public $IRPFCuota;
    public $totalFinal;
    
function setDatosPresupuesto($datos){
    $this->datosPresupuesto=$datos;
}

function setDatosNuestraEmpresa($datos){
    $this->datosNuestraEmpresa=$datos;
}    
    
    
    
// Cabecera de página
function Header()
{
    $this->Ln(10);
    // Logo
    if($_SESSION['imprimeDoc']==='on'){
        $this->Image("../images/".$_SESSION['logo'],10,22,36,18);//  36/18 proporcional a 140/70 tamaño de la imagen
    }
    // Arial bold 14
    $this->SetFont('Arial','B',14);
    // Movernos a la derecha
    $this->Cell(150);
    // Título
    $this->Cell(30,20,utf8_decode('FACTURA Nº ').utf8_decode($this->datosPresupuesto['NumFactura']),0,0,'R');
    // Salto de línea
    $this->Ln(25);
}

// Pie de página
function Footer()
{
    
    //por último los subtotales y totales
    // Posición: a 1,5 cm del final
    $Y = -58;
    $this->SetY($Y);
    $altura = 6;

    $this->SetFillColor(240,248,255);
    $this->SetLineWidth(0.1);
    $this->SetFont('Arial','B',9);
    $this->Cell(($this->columCantidad+$this->columConcepto+$this->columPrecio-0.2), $altura, 'Subtotales','LT','L', 'R',true);
    $this->Cell($this->columImporte, $altura, formateaNumeroContabilidad($this->totalImporte),'T','L', 'R',true);
    $this->Cell(($this->columIva+$this->columCuota), $altura, formateaNumeroContabilidad($this->totalCuota),'T','L', 'R',true);
    $this->Cell($this->columTotal, $altura, formateaNumeroContabilidad($this->totalImporte+$this->totalCuota),'TR','L', 'R',true);
    $this->Ln();
    $Y = $Y + 6;
    $this->SetY($Y);
    $this->IRPFCuota=$this->totalImporte*$this->datosPresupuesto['Retencion']/100;
    $this->totalFinal=$this->totalImporte+$this->totalCuota-$this->IRPFCuota;
    if($this->datosPresupuesto['Retencion']<>'0'){
        $this->Cell(145-0.2, $altura, utf8_decode('Retención %'),'L','L', 'R',true);
        $this->Cell(15, $altura, $this->datosPresupuesto['Retencion'],0,'L', 'R',true);
        $this->Cell(25, $altura, formateaNumeroContabilidad($this->IRPFCuota),'R','L', 'R',true);
        $this->Ln();
        $Y = $Y + 6;
        $this->SetY($Y);
    }
    $this->Cell(160-0.2, $altura, utf8_decode('TOTAL '),'LB','L', 'R',true);
    $this->Cell(25, $altura, formateaNumeroContabilidad($this->totalFinal),'BR','L', 'R',true);
    $this->Ln();
    $this->Ln();
    $Y = $Y + 9;
    $this->SetY($Y);

    //forma de pago y validez presupuesto
    $this->SetFillColor(232,232,232);
    $this->Cell(25, $altura, 'Forma de Pago:',0,'L', 'R');
    $this->Cell(35, $altura, utf8_decode($this->datosPresupuesto['FormaPago']),0,'R', 'L',true);
    $this->Cell(40, $altura, 'Vencimiento:',0,'L', 'R');
    $this->Cell(10, $altura, $this->datosPresupuesto['Validez'],0,'R', 'C',true);
    $this->Cell(10, $altura, utf8_decode('días f.f.'),0,'L', 'L');
    $this->Ln();
    $this->Cell(25, $altura, '',0,'L', 'R');
    if($this->datosPresupuesto['FormaPago'] === 'Transferencia'){
        $this->Cell(35, $altura, utf8_decode($this->datosPresupuesto['CC_Trans']),0,'R', 'L');
    }
    $this->Ln();
    
    
    
    
    $this->SetFillColor(255,255,255);
    $this->SetTextColor(120,120,120);
    // Posición: a 1,5 cm del final
    $this->SetY(-25);
    // Arial italic 8
    $this->SetFont('Arial','',8);
    //calculo las palabras que tiene el texto
    $numPalabras=explode(' ',utf8_decode($this->datosPresupuesto['TxtPie']));
    
    $textoLinea='';
    $altura=0;
    for($i=0;$i<count($numPalabras);$i++){
        //voy rellenando la linea de palabras
        $textoLinea=$textoLinea.$numPalabras[$i].' ';
        //compruebo que no paso de un limite
        if(strlen($textoLinea)>125){
            $this->Cell(180, $altura,$textoLinea,0,0,'C',false);
            $textoLinea='';
            $altura=$altura+8;
            $this->Ln();
        }
    }
    //imprimo la ultima linea sino esta vacia
    if(strlen($textoLinea)>0){
        $this->Cell(180, $altura,$textoLinea,0,0,'C',false);
    }
    
    // Posición: a 1,5 cm del final
    $this->SetY(-18);
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
    $altura = 5;
    
    // Datos nuestros: 1 linea
    $this->SetFont('Arial','B',10);
    $this->Cell(55, $altura, utf8_decode($this->datosNuestraEmpresa['strSesion']),0,'L', 'L');
    $this->Cell(30, $altura, ' ',0,0, 0);
    $this->Ln();
    // Datos nuestros: 2 linea
    $this->Cell(55, $altura, utf8_decode($this->datosNuestraEmpresa['direccion']),0,'L', 'L');
    $this->Cell(30, $altura, ' ',0,0, 0);
    // Datos Cliente: 1 linea
    $this->SetFont('Arial','',9);
    $this->Cell(25, $altura, utf8_decode("Att de D./Dña: "),'LT', 0, 'R',true);
    $this->Cell(75, $altura, utf8_decode($this->datosPresupuesto['ContactoEmpresa']),'TR', 0, 'L');
    $this->Ln();
    // Datos nuestros: 3 linea
    $this->Cell(55, $altura, $this->datosNuestraEmpresa['CP'].' - '.utf8_decode($this->datosNuestraEmpresa['municipio']),0,'L', 'L');
    $this->Cell(30, $altura, ' ',0,0, 0);
    // Datos Cliente: 2 linea
    $this->Cell(25, $altura, "Cliente: ",'L', 0, 'R',true);
    $this->Cell(75, $altura, utf8_decode($this->datosPresupuesto['NombreEmpresa']),'R', 0, 'L');
    $this->Ln();
    // Datos nuestros: 4 linea
    $this->Cell(55, $altura, utf8_decode($this->datosNuestraEmpresa['provincia']),0,'L', 'L');
    $this->Cell(30, $altura, ' ',0,0, 0);
    // Datos Cliente: 3 linea
    $this->Cell(25, $altura, "CIF: ",'L', 0, 'R',true);
    $this->Cell(75, $altura, $this->datosPresupuesto['CIFEmpresa'],'R', 0, 'L');
    $this->Ln();
    // Datos nuestros: 5 linea
    $this->Cell(55, $altura, 'CIF: '.utf8_decode($this->datosNuestraEmpresa['strCIF']),0,'L', 'L');
    $this->Cell(30, $altura, ' ',0,0, 0);
    // Datos Cliente: 4 linea
    $this->Cell(25, $altura, utf8_decode("Dirección: "),'L', 0, 'R',true);
    $this->Cell(75, $altura, utf8_decode($this->datosPresupuesto['DireccionEmpresa']),'R', 0, 'L');
    $this->Ln();
    // Datos nuestros: 6 linea
    $this->Cell(55, $altura, utf8_decode('Teléfono: ').$this->datosNuestraEmpresa['telefono'],0,'L', 'L');
    $this->Cell(30, $altura, ' ',0,0, 0);
    // Datos Cliente: 5 linea
    $this->Cell(25, $altura, utf8_decode("Población: "),'L', 0, 'R',true);
    $this->Cell(75, $altura, utf8_decode($this->datosPresupuesto['PoblacionEmpresa']),'R', 0, 'L');
    $this->Ln();
    // Datos nuestros: vacio
    $this->Cell(85, $altura, ' ',0,0, 0);
    // Datos Cliente: 6 linea
    $this->Cell(25, $altura, "Provincia: ",'LB', 0, 'R',true);
    $this->Cell(75, $altura, utf8_decode($this->datosPresupuesto['ProvinciaEmpresa']),'BR', 0, 'L');
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
$pdf->SetAutoPageBreak(true,60);
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
//    $pdf->columCantidad=18;
//    $pdf->columConcepto=54;
//    $pdf->columPrecio=23;
//    $pdf->columImporte=25;
//    $pdf->columIva=10;
//    $pdf->columCuota=25;
//    $pdf->columTotal=30;
    
    $pdf->columCantidad=15;
    $pdf->columConcepto=75;
    $pdf->columPrecio=20;
    $pdf->columImporte=20;
    $pdf->columIva=10;
    $pdf->columCuota=20;
    $pdf->columTotal=25;
    
    //Cuadro del presupuesto
    //cabecera
    $pdf->SetFillColor(240,248,255);
    $pdf->SetDrawColor(200,200,200);
    $pdf->SetLineWidth(0.1);
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell($pdf->columCantidad+0.1, 6, 'Cantidad','LTBR',0,'R',true);
    $pdf->SetLineWidth(0.1);
    $pdf->Cell(0.1, 6, '','R',0,'R');
    $pdf->SetLineWidth(0.1);
    $pdf->Cell($pdf->columConcepto-0.1, 6, '  Concepto','BTR',0,'L',true);
    $pdf->SetLineWidth(0.1);
    $pdf->Cell(0.1, 6, '','R',0,'R');
    $pdf->SetLineWidth(0.1);
    $pdf->Cell($pdf->columPrecio-0.1, 6, 'Precio','BTR',0,'R',true);
    $pdf->SetLineWidth(0.1);
    $pdf->Cell(0.1, 6, '','R',0,'R');
    $pdf->SetLineWidth(0.1);
    $pdf->Cell($pdf->columImporte-0.1, 6, 'Importe','BTR',0,'R',true);
    $pdf->SetLineWidth(0.1);
    $pdf->Cell(0.1, 6, '','R',0,'R');
    $pdf->SetLineWidth(0.1);
    $pdf->Cell($pdf->columIva-0.1, 6, 'IVA','BTR',0,'R',true);
    $pdf->SetLineWidth(0.1);
    $pdf->Cell(0.1, 6, '','R',0,'R');
    $pdf->SetLineWidth(0.1);
    $pdf->Cell($pdf->columCuota-0.1, 6, 'Cuota','BTR',0,'R',true);
    $pdf->SetLineWidth(0.1);
    $pdf->Cell(0.1, 6, '','R',0,'R');
    $pdf->SetLineWidth(0.1);
    $pdf->Cell($pdf->columTotal-0.2, 6, 'Total','TBR',0,'R',true);
    $pdf->Ln();

    //las lineas del cuerpo
    $altura=6;
    $pdf->totalImporte=0;
    $pdf->totalCuota=0;
    for ($i=0;$i<count($pdf->datosPresupuesto['DetalleFactura']);$i++){
        //metemos las palabras que hay en el texto en un array
        $palabras = explode(' ',($pdf->datosPresupuesto['DetalleFactura'][$i]['concepto']));
        //prepararmos un array con las lineas de texto rellenas de palabras que no sobrepasen 40 caracteres
        $linea='';
        $k=0;//indice de $palabras
        $lineas=array();
        while($k<count($palabras)){
            $lineaAux=$linea.' '.$palabras[$k];
            if(strlen($lineaAux)<53){
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
                $pdf->Cell($pdf->columCantidad+0.1, $altura, formateaNumeroContabilidad($pdf->datosPresupuesto['DetalleFactura'][$i]['cantidad']),'L',0,'R',$pdf->fill);
            }else{
                $pdf->Cell($pdf->columCantidad+0.1, $altura, '','L',0,'R',$pdf->fill);
            }
            $pdf->SetLineWidth(0.1);
            $lineas[$j] = str_replace("€","Euro",$lineas[$j]);
            if($j==0){
                $pdf->Cell($pdf->columConcepto, $altura, utf8_decode(trim($lineas[$j])) ,'L',0,'L',$pdf->fill);
            }else{
                $pdf->Cell($pdf->columConcepto, $altura, utf8_decode(trim($lineas[$j])) ,'L',0,'L',$pdf->fill);
            }
            if($j==0){
                if($pdf->datosPresupuesto['DetalleFactura'][$i]['precio']==='0'){
                    $pdf->datosPresupuesto['DetalleFactura'][$i]['precio']='';
                }
                $pdf->Cell($pdf->columPrecio, $altura, formateaNumeroContabilidad($pdf->datosPresupuesto['DetalleFactura'][$i]['precio']),'L',0,'R',$pdf->fill);
            }else{
                $pdf->Cell($pdf->columPrecio, $altura,'' ,'L',0,'R',$pdf->fill);
            }
            if($j==0){
                $pdf->Cell($pdf->columImporte, $altura, formateaNumeroContabilidad($pdf->datosPresupuesto['DetalleFactura'][$i]['importe']),'L',0,'R',$pdf->fill);
            }else{
                $pdf->Cell($pdf->columImporte, $altura, '','L',0,'R',$pdf->fill);
            }
            if($j==0){
                $pdf->Cell($pdf->columIva, $altura, $pdf->datosPresupuesto['DetalleFactura'][$i]['iva']." %",'L',0,'R',$pdf->fill);
            }else{
                $pdf->Cell($pdf->columIva, $altura,'' ,'L',0,'R',$pdf->fill);
            }
            if($j==0){
                $pdf->Cell($pdf->columCuota, $altura, formateaNumeroContabilidad($pdf->datosPresupuesto['DetalleFactura'][$i]['cuota']),'L',0,'R',$pdf->fill);
            }else{
                $pdf->Cell($pdf->columCuota, $altura,'' ,'L',0,'R',$pdf->fill);
            }
            if($j==0){  
                $pdf->Cell($pdf->columTotal-0.2, $altura, formateaNumeroContabilidad($pdf->datosPresupuesto['DetalleFactura'][$i]['total']),'L',0,'R',$pdf->fill);
                $pdf->SetLineWidth(0.1);
                $pdf->Cell(0.1, 6, '','R',0,'R');
            }else{
                $pdf->Cell($pdf->columTotal-0.2, $altura,'' ,'L',0,'R',$pdf->fill);
                $pdf->SetLineWidth(0.1);
                $pdf->Cell(0.1, 6, '','R',0,'R');
            }
            $pdf->Ln();
        }
        //sumas de importe y cuota
        $pdf->totalImporte=$pdf->totalImporte+$pdf->datosPresupuesto['DetalleFactura'][$i]['importe'];
        $pdf->totalCuota=$pdf->totalCuota+$pdf->datosPresupuesto['DetalleFactura'][$i]['cuota'];
    }
    //linea inferior
    $pdf->Cell(185, 0,'','B',0,'R');
    $pdf->Ln();

}else{//no van las columnas de cantidad y precio

    //anchos de columnas
//    $columCantidad=18;
    $pdf->columConcepto=110;
//    $columPrecio=23;
    $pdf->columImporte=20;
    $pdf->columIva=10;
    $pdf->columCuota=20;
    $pdf->columTotal=25;

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
    $pdf->Cell($pdf->columConcepto-0.1, 6, '  Concepto','LBTR',0,'L',true);
    $pdf->SetLineWidth(0.1);
    $pdf->Cell(0.1, 6, '','R',0,'R');
    $pdf->SetLineWidth(0.1);
//    $pdf->Cell($columPrecio-0.1, 6, 'Precio','BTR',0,'R',true);
//    $pdf->SetLineWidth(0.1);
//    $pdf->Cell(0.1, 6, '','R',0,'R');
//    $pdf->SetLineWidth(0.1);
    $pdf->Cell($pdf->columImporte-0.1, 6, 'Importe','BTR',0,'R',true);
    $pdf->SetLineWidth(0.1);
    $pdf->Cell(0.1, 6, '','R',0,'R');
    $pdf->SetLineWidth(0.1);
    $pdf->Cell($pdf->columIva-0.1, 6, 'IVA','BTR',0,'R',true);
    $pdf->SetLineWidth(0.1);
    $pdf->Cell(0.1, 6, '','R',0,'R');
    $pdf->SetLineWidth(0.1);
    $pdf->Cell($pdf->columCuota-0.1, 6, 'Cuota','BTR',0,'R',true);
    $pdf->SetLineWidth(0.1);
    $pdf->Cell(0.1, 6, '','R',0,'R');
    $pdf->SetLineWidth(0.1);
    $pdf->Cell($pdf->columTotal-0.2, 6, 'Total','TBR',0,'R',true);
    $pdf->Ln();

    //las lineas del cuerpo
    $altura=6;
    $totalImporte=0;
    $totalCuota=0;
    for ($i=0;$i<count($pdf->datosPresupuesto['DetalleFactura']);$i++){
        //metemos las palabras que hay en el texto en un array
        $palabras=  explode(' ',($pdf->datosPresupuesto['DetalleFactura'][$i]['concepto']));
        //prepararmos un array con las lineas de texto rellenas de palabras que no sobrepasen 40 caracteres
        $linea='';
        $k=0;//indice de $palabras
        $lineas=array();
        while($k<count($palabras)){
            $lineaAux=$linea.' '.$palabras[$k];
            if(strlen($lineaAux)<75){
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
                $lineas[$j] = str_replace("€","Euro",$lineas[$j]);
                $pdf->Cell($pdf->columConcepto-0.1, $altura, utf8_decode(trim($lineas[$j])) ,'L',0,'L',$pdf->fill);
            }else{
                $pdf->Cell($pdf->columConcepto-0.1, $altura, utf8_decode(trim($lineas[$j])) ,'L',0,'L',$pdf->fill);
            }
//            if($j==0){
//                $pdf->Cell($columPrecio, $altura, formateaNumeroContabilidad($pdf->datosPresupuesto['DetalleFactura'][$i]['precio']),'L',0,'R',$pdf->fill);
//            }else{
//                $pdf->Cell($columPrecio, $altura,'' ,'L',0,'R',$pdf->fill);
//            }
            if($j==0){
                $pdf->Cell($pdf->columImporte, $altura, formateaNumeroContabilidad($pdf->datosPresupuesto['DetalleFactura'][$i]['importe']),'L',0,'R',$pdf->fill);
            }else{
                $pdf->Cell($pdf->columImporte, $altura, '','L',0,'R',$pdf->fill);
            }
            if($j==0){
                $pdf->Cell($pdf->columIva, $altura, $pdf->datosPresupuesto['DetalleFactura'][$i]['iva']." %",'L',0,'R',$pdf->fill);
            }else{
                $pdf->Cell($pdf->columIva, $altura,'' ,'L',0,'R',$pdf->fill);
            }
            if($j==0){
                $pdf->Cell($pdf->columCuota, $altura, formateaNumeroContabilidad($pdf->datosPresupuesto['DetalleFactura'][$i]['cuota']),'L',0,'R',$pdf->fill);
            }else{
                $pdf->Cell($pdf->columCuota, $altura,'' ,'L',0,'R',$pdf->fill);
            }
            if($j==0){  
                $pdf->Cell($pdf->columTotal-0.2, $altura, formateaNumeroContabilidad($pdf->datosPresupuesto['DetalleFactura'][$i]['total']),'L',0,'R',$pdf->fill);
                $pdf->SetLineWidth(0.1);
                $pdf->Cell(0.1, 6, '','R',0,'R');
            }else{
                $pdf->Cell($pdf->columTotal-0.2, $altura,'' ,'L',0,'R',$pdf->fill);
                $pdf->SetLineWidth(0.1);
                $pdf->Cell(0.1, 6, '','R',0,'R');
            }
            $pdf->Ln();
        }
        //sumas de importe y cuota
        $pdf->totalImporte=$pdf->totalImporte+$pdf->datosPresupuesto['DetalleFactura'][$i]['importe'];
        $pdf->totalCuota=$pdf->totalCuota+$pdf->datosPresupuesto['DetalleFactura'][$i]['cuota'];
    }
    //linea inferior
    $pdf->Cell(185, 0,'','B',0,'R');
    $pdf->Ln();
    
}

//LO ESTOY CAMBIANDO DE SITIO AL FOOTER 21/7/2015

////por último los subtotales y totales
//$pdf->SetFillColor(240,248,255);
//$pdf->SetLineWidth(0.1);
//$pdf->SetFont('Arial','B',9);
//$pdf->Cell(($pdf->columCantidad+$pdf->columConcepto+$pdf->columPrecio-0.2), $altura, 'Subtotales','LT','L', 'R',true);
//$pdf->Cell($pdf->columImporte, $altura, formateaNumeroContabilidad($pdf->totalImporte),'T','L', 'R',true);
//$pdf->Cell(($pdf->columIva+$pdf->columCuota), $altura, formateaNumeroContabilidad($pdf->totalCuota),'T','L', 'R',true);
//$pdf->Cell($pdf->columTotal, $altura, formateaNumeroContabilidad($pdf->totalImporte+$pdf->totalCuota),'TR','L', 'R',true);
//$pdf->Ln();
//$pdf->IRPFCuota=$pdf->totalImporte*$pdf->datosPresupuesto['Retencion']/100;
//$pdf->totalFinal=$pdf->totalImporte+$pdf->totalCuota-$pdf->IRPFCuota;
//if($pdf->datosPresupuesto['Retencion']<>'0'){
//    $pdf->Cell(145-0.2, $altura, utf8_decode('Retención %'),'L','L', 'R',true);
//    $pdf->Cell(10, $altura, $pdf->datosPresupuesto['Retencion'],0,'L', 'R',true);
//    $pdf->Cell(30, $altura, formateaNumeroContabilidad($pdf->IRPFCuota),'R','L', 'R',true);
//    $pdf->Ln();
//}
//$pdf->Cell(155-0.2, $altura, utf8_decode('TOTAL '),'LB','L', 'R',true);
//$pdf->Cell(30, $altura, formateaNumeroContabilidad($pdf->totalFinal),'BR','L', 'R',true);
//$pdf->Ln();
//$pdf->Ln();
//
////forma de pago y validez presupuesto
//$pdf->SetFillColor(232,232,232);
//$pdf->Cell(25, $altura, 'Forma de Pago:',0,'L', 'R');
//$pdf->Cell(35, $altura, utf8_decode($pdf->datosPresupuesto['FormaPago']),0,'R', 'L',true);
//$pdf->Cell(40, $altura, 'Vencimiento:',0,'L', 'R');
//$pdf->Cell(10, $altura, $pdf->datosPresupuesto['Validez'],0,'R', 'C',true);
//$pdf->Cell(10, $altura, utf8_decode('días f.f.'),0,'L', 'L');
//$pdf->Ln();


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

