<?php
session_start();
require_once '../CN/clsCNContabilidad.php';
require_once '../general/funcionesGenerales.php';

$clsCNContabilidad=new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['dbContabilidad']);
$clsCNContabilidad->setStrBDCliente($_SESSION['mapeo']);


//generamos en la BBDD una factura copiando los datos de este
$numeroNuevaFactura = $clsCNContabilidad->NumeroNuevaFacturaRectificativa();

//echo $numeroNuevaFactura;echo '<br/>';

$tipoContador=$clsCNContabilidad->Parametro_general('Tipo Contador',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));

//preparo el numero de la forma '20140005' para guardar
$numFactura = numeroFormateado($numeroNuevaFactura,$tipoContador);

//echo $numFactura;die;

$FacturaRectificativa = $clsCNContabilidad->datosDuplicarFacturaRectificativa($_GET['IdFactura'],$numFactura);
if($FacturaDuplicada === 'false'){
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/error.php?id=No se a podido duplicar la factura">';die;
}else{
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/altafactura.php?IdFactura='.$FacturaRectificativa.'">';die;
}
