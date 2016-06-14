<?php
session_start();
require_once '../CAD/clsCADLogin.php';

$clsCADLogin=new clsCADLogin();

//compruebo si he pulsado el boton de 'Nueva empresa' (me he logeado como asesor, logicamente)
if(isset($_POST['nuevaEmpresa']) && $_POST['nuevaEmpresa']==='SI'){
    //asigno vbles sesion del asesor
    //la variable del usuario
    $_SESSION['strUsuario'] = $_POST['usuario'];

    //voy a la pagina de dar de alta la empresa
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/altaempresa.php">';die;
}


//comprobacion si existe empresa y clave y si esta en fecha correcta (no vencida)
//compruebo si vengo por post la empresa (vengo de asesor)
//si no vengo lo busco
if(isset($_POST['nombre_empresa']) && $_POST['nombre_empresa']===''){
//    logger('traza','clsCNLogin.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
//            " POST[nombre_empresa]=''");
    $nombre_empresa=$clsCADLogin->nombreEmpresaPorUsuario($_POST['usuario'],$_SESSION['dbContabilidad']);
//    logger('traza','clsCNLogin.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
//            ' $nombre_empresa='.$nombre_empresa);
}else{
//    logger('traza','clsCNLogin.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
//            " POST[nombre_empresa]<>''");
    $nombre_empresa=$_POST['nombre_empresa'];
//    logger('traza','clsCNLogin.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
//            ' $nombre_empresa='.$nombre_empresa);
}

$comprobacion=$clsCADLogin->asignacionVblesSesion($_SESSION['dbContabilidad'], $nombre_empresa,$_POST['usuario']);

//si el valor de $comprobacion es true redireciona a la página 'default2.php'
//si el valor es false (es que la aplicación a esta empresa ha pasado la fecha de vencimiento)
//la redireciono a la página de error indicandolo
if($comprobacion){
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/default2.php">';
}else{
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/errorVencimiento.php">';
    die;
}

//distintas funciones de mantenimiento de la BBDD de Contabilidad
$clsCADLogin->MantenimientoDb_tbconsulta_pregunta($_SESSION['dbContabilidad']);
$clsCADLogin->MantenimientoDb_tbmisfacturas($_SESSION['mapeo']);

?>