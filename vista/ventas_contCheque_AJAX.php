<?php
//funcion AJAX que es llamada por 'ventas_listado_contabilizando.php'
session_start();
//carga la conexion
//require_once '../general/'.$_SESSION['mapeo'];
//$db = new Db();


require_once '../CN/clsCNContabilidad.php';
$clsCNContabilidad = new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['dbContabilidad']);
$clsCNContabilidad->setStrBDCliente($_SESSION['mapeo']);



$datos['IdTarjeta'] = $_GET['IdTarjeta'];
$datos['TipoTarjeta'] = $_GET['TipoTarjeta'];
$datos['CuentaTarjeta'] = $_GET['CuentaTarjeta'];
$datos['nombreTarjeta'] = $_GET['nombreTarjeta'];
$datos['Bruto'] = $_GET['Bruto'];
$datos['Comision'] = $_GET['Comision'];
$datos['Liquido'] = $_GET['Liquido'];
$fecha = explode('/',$_GET['fecha']);
$datos['fecha'] = $fecha[2] . '-' . $fecha[1] . '-' . $fecha[0];

//contabilizo esta linea de bancos/caja
$OK = $clsCNContabilidad->contabilizarCheque($datos);

if($OK === false){
    $respuesta = 'Tarjeta '.$datos['nombreTarjeta'].' del dia '.$_GET['fecha'] . '...ERROR<br>';
}else if(is_numeric($OK)){
    $respuesta = 'Tarjeta '.$datos['nombreTarjeta'].' del dia '.$_GET['fecha'] . '...Contabilizada: Asiento Nº '.$OK.'<br>';
}else if($OK === 'EstaContabilizada'){
    $respuesta = 'Tarjeta '.$datos['nombreTarjeta'].' del dia '.$_GET['fecha'] . '...YA ESTÁ Contabilizada<br>';
}

echo $respuesta;


