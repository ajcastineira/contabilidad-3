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

//borro la vble de session
unset($_SESSION['presupuestoActivo']);
unset($_SESSION['ingresos_CFIVA1SIRPFVC']);


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
<html>
<head>
	<TITLE>Q-Conta</TITLE>
<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>
        
        
</head>
<body>

<div data-role="page" id="default2">
<?php
eventosInputText();
?>

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>

    <div data-role="content" data-theme="a">
        <ul data-role="listview" data-dividertheme="a">
            <li data-role="list-divider"><?php echo $textos['0801']; ?></li>
            <li><a href="<?php echo urlNavegacion($ficheros['080101'],$listFicherosMovil,$navegacion); ?>" data-ajax="false"><?php echo $textos['080101']; ?></a></li>
            <li><a href="<?php echo urlNavegacion($ficheros['080102'],$listFicherosMovil,$navegacion); ?>" data-ajax="false"><?php echo $textos['080102']; ?></a></li>

            <li data-role="list-divider"><?php echo $textos['0802']; ?></li>
            <li><a href="<?php echo urlNavegacion($ficheros['080201'],$listFicherosMovil,$navegacion); ?>" data-ajax="false"><?php echo $textos['080201']; ?></a></li>
            <li><a href="<?php echo urlNavegacion($ficheros['080202'],$listFicherosMovil,$navegacion); ?>" data-ajax="false"><?php echo $textos['080202']; ?></a></li>

            <li><a href="<?php echo urlNavegacion($ficheros['0803'],$listFicherosMovil,$navegacion); ?>" data-ajax="false"><?php echo $textos['0803']; ?></a></li>
            <li><a href="<?php echo urlNavegacion($ficheros['0804'],$listFicherosMovil,$navegacion); ?>" data-ajax="false"><?php echo $textos['0804']; ?></a></li>

            <li data-role="list-divider"><?php echo $textos['04']; ?></li>
            <li><a href="<?php echo urlNavegacion($ficheros['0402'],$listFicherosMovil,$navegacion); ?>" data-ajax="false"><?php echo $textos['0402']; ?></a></li>
        </ul>
    </div>
</div>
</body>
</html>
