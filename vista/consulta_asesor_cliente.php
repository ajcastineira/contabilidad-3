<?php
session_start();
//require_once '../general/funcionesGenerales.php';
require_once '../CN/clsCNUsu.php';
$clsCNUsu=new clsCNUsu();
$clsCNUsu->setStrBD($_SESSION['dbContabilidad']);

//extraigolos datos del usuario
$datosUsuario=$clsCNUsu->DatosUsuario($_SESSION['usuario']);
logger('traza','consulta_asesor_cliente.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
       " Comunicaciones->Consulta Asesor|| Veo permiso: ".$datosUsuario['Permiso']);

//compruebo los permisos que tiene
//veo la variable de sesion 'cargo', si es 'Asesor' entro por el lado de asesor, sino como cliente
if(substr($_SESSION['cargo'],0,6)==='Asesor'){
    //vamos a extraer un listado de todas las preguntas
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/consulta_list_preguntas.php">';
}else{
    //vamos al listado de preguntas del usuario
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/consulta_asesor.php">';
}
?>
