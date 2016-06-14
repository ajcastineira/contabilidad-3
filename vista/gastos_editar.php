<?php
session_start();
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



//vemos la variable $_GET[TipoAsiento] y decide a que formulario ir y cargar los datos
//si es 00N es Gasto sin factura Normal
if(isset($_GET['TipoAsiento']) && $_GET['TipoAsiento']==='00N'){
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/gastos_SF.php?editar=SI&Asiento='.$_GET['Asiento'].'&borrar='.$_GET['borrar'].'&esAbono=NO">';
}else
//si es 00A es Gasto sin factura Abono
if(isset($_GET['TipoAsiento']) && $_GET['TipoAsiento']==='00A'){
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/gastos_SF.php?editar=SI&Asiento='.$_GET['Asiento'].'&borrar='.$_GET['borrar'].'&esAbono=SI">';
}else
//si es 01N es Gasto con 1 IVA
if(isset($_GET['TipoAsiento']) && $_GET['TipoAsiento']==='01N'){
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/gastos_CFIVA1SIRPF.php?editar=SI&Asiento='.$_GET['Asiento'].'&borrar='.$_GET['borrar'].'&esAbono=NO">';
}else
//si es 01A es Gasto con 1 IVA Abono
if(isset($_GET['TipoAsiento']) && $_GET['TipoAsiento']==='01A'){
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/gastos_CFIVA1SIRPF.php?editar=SI&Asiento='.$_GET['Asiento'].'&borrar='.$_GET['borrar'].'&esAbono=SI">';
}else
//si es 02N es Gasto con 1 IVA + IRPF
if(isset($_GET['TipoAsiento']) && $_GET['TipoAsiento']==='02N'){
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/gastos_CFIVA1CIRPF.php?editar=SI&Asiento='.$_GET['Asiento'].'&borrar='.$_GET['borrar'].'&esAbono=NO">';
}else
//si es 02A es Gasto con 1 IVA + IRPF Abono
if(isset($_GET['TipoAsiento']) && $_GET['TipoAsiento']==='02A'){
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/gastos_CFIVA1CIRPF.php?editar=SI&Asiento='.$_GET['Asiento'].'&borrar='.$_GET['borrar'].'&esAbono=SI">';
}else
//si es 03N es Gasto con Varios IVAs Sin IRPF
if(isset($_GET['TipoAsiento']) && $_GET['TipoAsiento']==='03N'){
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/gastos_CFIVAV.php?editar=SI&Asiento='.$_GET['Asiento'].'&borrar='.$_GET['borrar'].'&esAbono=NO">';
}else
//si es 03A es Gasto con Varios IVAs Sin IRPF Abono 
if(isset($_GET['TipoAsiento']) && $_GET['TipoAsiento']==='03A'){
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/gastos_CFIVAV.php?editar=SI&Asiento='.$_GET['Asiento'].'&borrar='.$_GET['borrar'].'&esAbono=SI">';
}else
//si es 04N es Gasto con Varios IVAs Con IRPF
if(isset($_GET['TipoAsiento']) && $_GET['TipoAsiento']==='04N'){
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/gastos_CFIVAVCIRPF.php?editar=SI&Asiento='.$_GET['Asiento'].'&borrar='.$_GET['borrar'].'&esAbono=NO">';
}else
//si es 04A es Gasto con Varios IVAs Con IRPF Abono 
if(isset($_GET['TipoAsiento']) && $_GET['TipoAsiento']==='04A'){
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/gastos_CFIVAVCIRPF.php?editar=SI&Asiento='.$_GET['Asiento'].'&borrar='.$_GET['borrar'].'&esAbono=SI">';
}

//si es 10N es Ingreso sin factura Normal
if(isset($_GET['TipoAsiento']) && $_GET['TipoAsiento']==='10N'){
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/ingresos_SF.php?editar=SI&Asiento='.$_GET['Asiento'].'&borrar='.$_GET['borrar'].'&esAbono=NO">';
}else
//si es 10A es Ingreso sin factura Abono
if(isset($_GET['TipoAsiento']) && $_GET['TipoAsiento']==='10A'){
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/ingresos_SF.php?editar=SI&Asiento='.$_GET['Asiento'].'&borrar='.$_GET['borrar'].'&esAbono=SI">';
}else
//si es 11N es Ingreso con 1 IVA
if(isset($_GET['TipoAsiento']) && $_GET['TipoAsiento']==='11N'){
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/ingresos_CFIVA1SIRPF.php?editar=SI&Asiento='.$_GET['Asiento'].'&borrar='.$_GET['borrar'].'&esAbono=NO">';
}else
//si es 11A es Ingreso con 1 IVA Abono
if(isset($_GET['TipoAsiento']) && $_GET['TipoAsiento']==='11A'){
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/ingresos_CFIVA1SIRPF.php?editar=SI&Asiento='.$_GET['Asiento'].'&borrar='.$_GET['borrar'].'&esAbono=SI">';
}else
//si es 12N es Ingreso con 1 IVA + IRPF
if(isset($_GET['TipoAsiento']) && $_GET['TipoAsiento']==='12N'){
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/ingresos_CFIVA1CIRPF.php?editar=SI&Asiento='.$_GET['Asiento'].'&borrar='.$_GET['borrar'].'&esAbono=NO">';
}else
//si es 12A es Ingreso con 1 IVA + IRPF Abono
if(isset($_GET['TipoAsiento']) && $_GET['TipoAsiento']==='12A'){
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/ingresos_CFIVA1CIRPF.php?editar=SI&Asiento='.$_GET['Asiento'].'&borrar='.$_GET['borrar'].'&esAbono=SI">';
}else
//si es 13N es Ingreso con Varios IVAs Sin IRPF
if(isset($_GET['TipoAsiento']) && $_GET['TipoAsiento']==='13N'){
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/ingresos_CFIVAV.php?editar=SI&Asiento='.$_GET['Asiento'].'&borrar='.$_GET['borrar'].'&esAbono=NO">';
}else
//si es 13A es Ingresos con Varios IVAs Sin IRPF Abono 
if(isset($_GET['TipoAsiento']) && $_GET['TipoAsiento']==='13A'){
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/ingresos_CFIVAV.php?editar=SI&Asiento='.$_GET['Asiento'].'&borrar='.$_GET['borrar'].'&esAbono=SI">';
}else
//si es 14N es Ingreso con Varios IVAs Con IRPF
if(isset($_GET['TipoAsiento']) && $_GET['TipoAsiento']==='14N'){
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/ingresos_CFIVAVCIRPF.php?editar=SI&Asiento='.$_GET['Asiento'].'&borrar='.$_GET['borrar'].'&esAbono=NO">';
}else
//si es 14A es Ingresos con Varios IVAs Con IRPF Abono 
if(isset($_GET['TipoAsiento']) && $_GET['TipoAsiento']==='14A'){
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/ingresos_CFIVAVCIRPF.php?editar=SI&Asiento='.$_GET['Asiento'].'&borrar='.$_GET['borrar'].'&esAbono=SI">';
}else
//si es 15N es Ingreso con 1 IVA (Varias Cuentas)
if(isset($_GET['TipoAsiento']) && $_GET['TipoAsiento']==='15N' || $_GET['TipoAsiento']==='15N2'){
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/ingresos_CFIVA1SIRPFVC.php?editar=SI&Asiento='.$_GET['Asiento'].'&borrar='.$_GET['borrar'].'&esAbono=NO">';
}else
//si es 15A es Ingreso con 1 IVA (Varias Cuentas) Abono
if(isset($_GET['TipoAsiento']) && $_GET['TipoAsiento']==='15A' || $_GET['TipoAsiento']==='15A2'){
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/ingresos_CFIVA1SIRPFVC.php?editar=SI&Asiento='.$_GET['Asiento'].'&borrar='.$_GET['borrar'].'&esAbono=SI">';
}else
//si es 16N es Ingreso con 1 IVA (Varias Cuentas)
if(isset($_GET['TipoAsiento']) && $_GET['TipoAsiento']==='16N' || $_GET['TipoAsiento']==='16N2'){
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/ingresos_CFIVA1SIRPFVC.php?editar=SI&Asiento='.$_GET['Asiento'].'&borrar='.$_GET['borrar'].'&esAbono=NO">';
}else
//si es 17N es Ingreso con 1 IVA (Varias Cuentas)
if(isset($_GET['TipoAsiento']) && $_GET['TipoAsiento']==='17N' || $_GET['TipoAsiento']==='17N2'){
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/ingresos_CFIVA1SIRPFVC.php?editar=SI&Asiento='.$_GET['Asiento'].'&borrar='.$_GET['borrar'].'&esAbono=NO">';
}else
//si es 18N es Ingreso con 1 IVA (Varias Cuentas)
if(isset($_GET['TipoAsiento']) && $_GET['TipoAsiento']==='18N' || $_GET['TipoAsiento']==='18N2'){
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/ingresos_CFIVA1SIRPFVC.php?editar=SI&Asiento='.$_GET['Asiento'].'&borrar='.$_GET['borrar'].'&esAbono=NO">';
}

//si es 2 es asiento Manual (Mis Movimientos)
if(isset($_GET['TipoAsiento']) && $_GET['TipoAsiento']==='2'){
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/ingresos_gastos.php?Asiento='.$_GET['Asiento'].'&borrar='.$_GET['borrar'].'">';
}

//si es 3 es asiento Nóminas
if(isset($_GET['TipoAsiento']) && $_GET['TipoAsiento'] === '3N'){
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/gastos_nomina.php?Asiento='.$_GET['Asiento'].'&borrar='.$_GET['borrar'].'&esAbono=NO">';
}
if(isset($_GET['TipoAsiento']) && $_GET['TipoAsiento'] === '3A'){
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/gastos_nomina.php?Asiento='.$_GET['Asiento'].'&borrar='.$_GET['borrar'].'&esAbono=SI">';
}

?>
