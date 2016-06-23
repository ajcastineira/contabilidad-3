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

require_once '../CN/clsCNContabilidad.php';
$clsCNContabilidad = new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['mapeo']);

$tieneArticulos = $clsCNContabilidad->Parametro_general('articulo', date('Y-m-d H:i:s'), date('Y-m-d H:i:s'));

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

    
    <div data-demo-html="true">
        <ul data-role="listview" data-dividertheme="a" data-filter="true" data-filter-placeHolder="Buscar">
            <li data-role="list-divider"><?php echo $textos['01']; ?></li>
            <li><a href="<?php echo urlNavegacion($ficheros['0106'],$listFicherosMovil,$navegacion); ?>" data-ajax="false"><?php echo $textos['0106']; ?></a></li>
            <li data-role="list-divider"><?php echo $textos['0105']; ?></li>
            <li><a href="<?php echo urlNavegacion($ficheros['010501'],$listFicherosMovil,$navegacion); ?>" data-ajax="false"><?php echo $textos['010501']; ?></a></li>
            <li><a href="<?php echo urlNavegacion($ficheros['010502'],$listFicherosMovil,$navegacion); ?>" data-ajax="false"><?php echo $textos['010502']; ?></a></li>
            <li data-role="list-divider"><?php echo $textos['0103']; ?></li>
            <li><a href="<?php echo urlNavegacion($ficheros['010301'],$listFicherosMovil,$navegacion).'?tipo=proveedor'; ?>" data-ajax="false"><?php echo $textos['010301']; ?></a></li>
            <li><a href="<?php echo urlNavegacion($ficheros['010302'],$listFicherosMovil,$navegacion).'?tipo=proveedor'; ?>" data-ajax="false"><?php echo $textos['010302']; ?></a></li>
            <li data-role="list-divider"><?php echo $textos['0104']; ?></li>
            <li><a href="<?php echo urlNavegacion($ficheros['010401'],$listFicherosMovil,$navegacion); ?>" data-ajax="false"><?php echo $textos['010401']; ?></a></li>
            <li><a href="<?php echo urlNavegacion($ficheros['010402'],$listFicherosMovil,$navegacion); ?>" data-ajax="false"><?php echo $textos['010402']; ?></a></li>
            <li data-role="list-divider"><?php echo $textos['0101']; ?></li>
            <?php if(substr($_SESSION['cargo'],0,6)==='Asesor'){// es asesor ?>
            <li><a href="<?php echo urlNavegacion($ficheros['010101'],$listFicherosMovil,$navegacion); ?>" data-ajax="false"><?php echo $textos['010101']; ?></a></li>
            <li><a href="<?php echo urlNavegacion($ficheros['010103'],$listFicherosMovil,$navegacion); ?>" data-ajax="false"><?php echo $textos['010103']; ?></a></li>
            <?php }else{//es usuario, sale deshabilitadas estas opciones ?>
            <li><a href="<?php echo urlNavegacion($ficheros['010103'],$listFicherosMovil,$navegacion); ?>" data-ajax="false"><?php echo $textos['010103']; ?></a></li>
            <?php } ?>
            <li data-role="list-divider"><?php echo $textos['05']; ?></li>
            <li><a href="<?php echo urlNavegacion($ficheros['0501'],$listFicherosMovil,$navegacion); ?>" data-ajax="false"><?php echo $textos['0501']; ?></a></li>
            <li><a href="<?php echo urlNavegacion($ficheros['0502'],$listFicherosMovil,$navegacion); ?>" data-ajax="false"><?php echo $textos['0502']; ?></a></li>
            <li><a href="<?php echo urlNavegacion($ficheros['0503'],$listFicherosMovil,$navegacion); ?>" data-ajax="false"><?php echo $textos['0503']; ?></a></li>

            <li data-role="list-divider"><?php echo $textos['06']; ?></li>
            <li><a href="<?php echo urlNavegacion($ficheros['0601'],$listFicherosMovil,$navegacion); ?>" data-ajax="false"><?php echo $textos['0601']; ?></a></li>
            <li><a href="<?php echo urlNavegacion($ficheros['0602'],$listFicherosMovil,$navegacion); ?>" data-ajax="false"><?php echo $textos['0602']; ?></a></li>
            <li><a href="<?php echo urlNavegacion($ficheros['0603'],$listFicherosMovil,$navegacion); ?>" data-ajax="false"><?php echo $textos['0603']; ?></a></li>
            <li><a href="<?php echo urlNavegacion($ficheros['0603b'],$listFicherosMovil,$navegacion); ?>" data-ajax="false"><?php echo "Facturas Periódicas"; ?></a></li>
            <li><a href="<?php echo urlNavegacion($ficheros['0206'],$listFicherosMovil,$navegacion); ?>" data-ajax="false"><?php echo $textos['0206']; ?></a></li>
            <li><a href="<?php echo urlNavegacion($ficheros['0607'],$listFicherosMovil,$navegacion); ?>" data-ajax="false"><?php echo $textos['0607']; ?></a></li>

            <li data-role="list-divider"><?php echo $textos['02']; ?></li>
            <li><a href="<?php echo urlNavegacion($ficheros['0202'],$listFicherosMovil,$navegacion); ?>" data-ajax="false"><?php echo $textos['0202']; ?></a></li>
            <li><a href="<?php echo urlNavegacion($ficheros['0203'],$listFicherosMovil,$navegacion); ?>" data-ajax="false"><?php echo $textos['0203']; ?></a></li>
            <li><a href="<?php echo urlNavegacion($ficheros['0204'],$listFicherosMovil,$navegacion); ?>" data-ajax="false"><?php echo $textos['0204']; ?></a></li>
            <li><a href="<?php echo urlNavegacion($ficheros['0205'],$listFicherosMovil,$navegacion); ?>" data-ajax="false"><?php echo $textos['0205']; ?></a></li>

            <li data-role="list-divider"><?php echo $textos['03']; ?></li>
            <li><a href="<?php echo urlNavegacion($ficheros['0304'],$listFicherosMovil,$navegacion); ?>" data-ajax="false"><?php echo $textos['0304']; ?></a></li>
            <li><a href="<?php echo urlNavegacion($ficheros['0305'],$listFicherosMovil,$navegacion); ?>" data-ajax="false"><?php echo $textos['0305']; ?></a></li>
            <li><a href="<?php echo urlNavegacion($ficheros['0306'],$listFicherosMovil,$navegacion); ?>" data-ajax="false"><?php echo $textos['0306']; ?></a></li>
            <li><a href="<?php echo urlNavegacion($ficheros['0307'],$listFicherosMovil,$navegacion); ?>" data-ajax="false"><?php echo $textos['0307']; ?></a></li>


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
    
    <?php if(substr($_SESSION['cargo'],0,6)==='Asesor'){// es asesor ?>
        <input type="button" value="Acceso Asesor" onclick="javascript:window.location.href ='../<?php echo $_SESSION['navegacion'];?>/defaultAsesor.php';"  data-theme="e" />
    <?php } ?>
    
    <input type="button" value="Salir" onclick="javascript:window.location.href ='../';"  data-theme="a" />


</div>
</body>
</html>
