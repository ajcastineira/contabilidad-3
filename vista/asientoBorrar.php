<?php
session_start();
require_once '../CN/clsCNContabilidad.php';
require_once '../CAD/clsCADContabilidad.php';
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



$clsCNContabilidad=new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['mapeo']);
$clsCADContabilidad=new clsCADContabilidad();
$clsCADContabilidad->setStrBD($_SESSION['mapeo']);

//borramos este cliente/proveedor (cambiamos el campo borrado a 1)
$id=$_GET['id'];
logger('traza','cliprovBorrar.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
       " Comienzo clsCNUsu->cliprovBorrar($id)>");

if($clsCNContabilidad->DarBajaAsiento($id)){
    $clsCADContabilidad->actualizar_tbacumulados();
    //si se ha borrado
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/exito.php?Id=Se ha borrado el Asiento de la base de datos">';
}else{
    $clsCADContabilidad->actualizar_tbacumulados();
    //si no se ha borrado
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/error.php?id=NO se ha borrado el Asiento de la base de datos">';
}
?>
