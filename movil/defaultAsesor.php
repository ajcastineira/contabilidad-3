<?php
session_start();
require_once '../CAD/clsCADLogin.php';
$clsCADLogin=new clsCADLogin();

require_once '../CN/clsCNDefault2.php';
require_once '../general/funcionesGenerales.php';

//Control de Sesion
ControlaLoginTimeOut();

//Control de Permisos. Hay que incluirlo en todas las páginas
/**************************************************************/
$strPagina=dameURL();
$strCargo = trim($_SESSION['cargo']);   //Esto es el puesto al que le hacemos un trim

$lngPermiso = AccesoUsuarioPagina ($strPagina, $strCargo);  // Le pasamos la página y el cargo. 
logger('warning',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
       "  lngPermiso : ".$lngPermiso);

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



//print_r($_SESSION);

$clsCNDefault2 = new clsCNDefault2();
//extraigo los arrays de los ficheros y los textos de los menus
$ficheros = array();
$ficheros = $clsCNDefault2->extraeNombreFicheros();

$textos = array();
$textos = $clsCNDefault2->extraeTextosMenu();
$claseEmpresa=$clsCNDefault2->claseEmpresa($_SESSION['idEmp']);

require_once '../CN/clsCNUsu.php';
$clsCNUsu = new clsCNUsu();
$clsCNUsu->setStrBD($_SESSION['dbContabilidad']);
$datosUsuario = $clsCNUsu->DatosEmpleado($_SESSION['usuario'], 0);
//print_r($datosUsuario);

//extraer listado de ficheros en carpeta 'movil'
$listFicherosMovil=$clsCADLogin->listFicheros("../movil/");

function urlNavegacion($fichero,$array,$navegacion){
    $encontrado='no';
    for($i=0;$i<count($array);$i++){
        if($array[$i]===$fichero){
            $encontrado='si';
            break;
        }
    }

    //ahora si existe fichero ($encontrado=si) le pongo la ruta que me marca en $url
    if($encontrado==='si'){
        $url=$navegacion.$fichero;
    }else{
        $url='../vista/'.$fichero;
    }
    
    
    return $url;
}

?>
<!DOCTYPE html>
<!DOCTYPE html>
<html>
<head>
	<TITLE>Q-Conta</TITLE>
<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>
        
        
</head>
<body>

<div data-role="page" id="defaultAsesor">
<?php
eventosInputText();
?>

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>

    <div data-role="content" data-theme="a">
        <ul data-role="listview" data-dividertheme="a" data-filter="true" data-filter-placeHolder="Buscar">
            <li><?php echo 'Documentación'; ?>
                <ul data-role="listview" data-dividertheme="a">
                    <li><a href="<?php echo '../vista/alta_documento.php'; ?>" data-ajax="false"><?php echo 'Alta Documento'; ?></a></li>
                    <li><a href="<?php echo '../vista/listado_documento.php'; ?>" data-ajax="false"><?php echo 'Listado Documentación'; ?></a></li>
                    <li></li>
                    <li><input type="button" value="Volver" onclick="javascript:history.back(1)"  data-theme="a" /></li>
                </ul>
            </li>
            <li><?php echo 'Incidencias'; ?>
                <ul data-role="listview" data-dividertheme="a">
                    <li><a href="<?php echo '../vista/incidencias.php'; ?>" data-ajax="false"><?php echo 'Alta Incidencia'; ?></a></li>
                    <li><a href="<?php echo '../vista/consulta_list_preguntas.php'; ?>" data-ajax="false"><?php echo 'Listado Incidencias'; ?></a></li>
                    <li></li>
                    <li><input type="button" value="Volver" onclick="javascript:history.back(1)"  data-theme="a" /></li>
                </ul>
            </li>
        </ul>
    </div>
    
    <input type="button" value="Volver Principal" onclick="javascript:window.location.href ='../<?php echo $_SESSION['navegacion'];?>/default2.php';"  data-theme="a" />
    
    <input type="button" value="Salir" onclick="javascript:window.location.href ='../<?php echo $_SESSION['navegacion'];?>/login.php';"  data-theme="a" />


</div>
</body>
</html>
