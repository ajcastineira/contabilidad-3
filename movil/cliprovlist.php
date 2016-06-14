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



//codigo principal
if($_GET['tipo']=='cliente'){
    logger('info','cliprovlist.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
           " ||||Configuracion->Mis Clientes->Consulta/Modificacion||");
}else{
    logger('info','cliprovlist.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
           " ||||Configuracion->Mis Proveedores->Consulta/Modificacion||");
}



date_default_timezone_set('Europe/Madrid');
$fechaForm=date('d/m/Y');

//extraigo la consulta de esta tabla
require_once '../CN/clsCNUsu.php';
$clsCNUsu=new clsCNUsu();
$clsCNUsu->setStrBD($_SESSION['dbContabilidad']);
$clsCNUsu->setStrBDCliente($_SESSION['mapeo']);
$arResult=$clsCNUsu->ListadoCliProv($_GET['tipo'],$_GET['strNombre'],$_GET['strCIF']);


?>
<!DOCTYPE html>
<html>
<head>
<TITLE>Consulta de <?php echo $_GET['tipo'];?></TITLE>

<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>
</head> 
    <body>
    <div data-role="page" id="cliprovlist">
    <?php
    eventosInputText();
    ?>

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>
        
    <div data-role="content" data-theme="a">
        <h3 align="center" color="#FFCC66">
            <font size="3px">
                <?php
                if($_GET['tipo']=='cliente'){
                    echo 'Consulta de Cliente';
                }else{
                    echo 'Consulta de Proveedor';
                }
                ?>
            </font>
        </h3>
        <br/>
        <ul data-role="listview" data-dividertheme="a" data-filter="true" data-filter-placeHolder="Buscar">
            <li data-role="list-divider">Código&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nombre</li>
            <?php
            if(is_array($arResult)){
                for ($i = 0; $i < count($arResult); $i++) {
                    //preparo el array de $arResult[$i] para enviar por url
                    $link="javascript:document.location.href='../".$_SESSION['navegacion']."/consultacliprov.php?IdRelacionCliProv=".$arResult[$i]['IdRelacionCliProv']."&tipo=".$_GET['tipo']."';";
                    ?>
                    <li onClick="<?php echo $link; ?>">
                        <a href="#" data-ajax="false">
                        <?php echo '<font color="30a53b">'.$arResult[$i]['Codigo'].'</font> - '; ?>
                        <?php echo $arResult[$i]['nombre']; ?>
                        </a>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
    </div>            
            
    </div>    
    <script type="text/javascript" charset="utf-8">
    </script>
    </body>
</html>
