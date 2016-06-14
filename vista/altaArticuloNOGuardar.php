<?php
session_start();
require_once '../CN/clsCNContabilidad.php';

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

$clsCNContabilidad = new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['dbContabilidad']);
$clsCNContabilidad->setStrBDCliente($_SESSION['mapeo']);


logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
       " ||||Mis Presupuestos->Guardar Linea Presupuesto IdArticulo=0||");

$IdFacturaLinea = $_GET['IdFacturaLinea'];
$IdPedidoLinea = $_GET['IdPedidoLinea'];
$IdPresupLinea = $_GET['IdPresupLinea'];
$Id = $_GET['Id'];
$tipo = $_GET['tipo'];

if($tipo === 'p'){
    $varRes = $clsCNContabilidad->ArticuloIdArticuloACeroEnPresupuesto($IdPresupLinea);
    $IdLinea = $IdPresupLinea;
    $keyLinea = 'IdPresupLineas';
    $respId = 'pid';
}else if($tipo === 'f'){
    $varRes = $clsCNContabilidad->ArticuloIdArticuloACeroEnFactura($IdFacturaLinea);
    $IdLinea = $IdFacturaLinea;
    $keyLinea = 'IdFacturaLineas';
    $respId = 'fid';
}else if($tipo === 'pe'){
    $varRes = $clsCNContabilidad->ArticuloIdArticuloACeroEnPedido($IdPedidoLinea);//HACER 10/5/2015
    $IdLinea = $IdPedidoLinea;
    $keyLinea = 'IdPedidoLineas';
    $respId = 'peid';
}

if($varRes == true){
    //ahora a la vble. $_SESSION['lineasArticulosSinGuardar'] le quito la linea que ya
    //hemos guardado y volvemos a cargar la pagina
    //recorremos el array
    for ($i = 0; $i < count($_SESSION['lineasArticulosSinGuardar']); $i++) {
        if($tipo === 'p'){
            $comparar = $IdPresupLinea;
        }else if($tipo === 'f'){
            $comparar = $IdFacturaLinea;
        }
        
        if($_SESSION['lineasArticulosSinGuardar'][$i][$keyLinea] === $comparar){
            unset($_SESSION['lineasArticulosSinGuardar'][$i]);
        }
    }
    $_SESSION['lineasArticulosSinGuardar'] = array_values($_SESSION['lineasArticulosSinGuardar']);
}

//redirecciono al listado de guardar articulos
echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/articulosSinGuardar.php?'.$respId.'='.$Id.'">';

?>