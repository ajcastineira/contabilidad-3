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



logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
       " ||||Mis Presupuestos->Modificación/Baja||");

date_default_timezone_set('Europe/Madrid');
$fechaForm=date('d/m/Y');


require_once '../CN/clsCNContabilidad.php';
$clsCNContabilidad=new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['dbContabilidad']);
$clsCNContabilidad->setStrBDCliente($_SESSION['mapeo']);
$arResult=$clsCNContabilidad->ListadoEmpleados($_GET);


?>

<!DOCTYPE html>
<html>
<head>
<TITLE>Consulta de Empleados</TITLE>

<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>
</head> 
    <body>
    <div data-role="page" id="empladoslist">
<?php
eventosInputText();
?>
<script LANGUAGE="JavaScript"> 

//function soloVer(IdPresupuesto){
//    //visualizamos el presupuesto
//    alert('Este presupuesto tiene facturas emitidas.');
//    document.location.href='../movil/altapresupuesto.php?IdPresupuesto='+IdPresupuesto;
//}

</script>

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>
        
    <div data-role="content" data-theme="a">
        <h3 align="center" color="#FFCC66"><font size="3px">Consulta de Empleados</font></h3>
        <br/>
        <ul data-role="listview" data-dividertheme="a" data-filter="true" data-filter-placeHolder="Buscar">
            <?php
            if(is_array($arResult)){
                for ($i = 0; $i < count($arResult); $i++) {
                    $link="javascript:document.location.href='../vista/empleados.php?IdEmpleado=".$arResult[$i]['IdEmpleado']."';";
                    $vtoContrato='';
                    if(isset($arResult[$i]['fechaVtoContrato']) && $arResult[$i]['fechaVtoContrato']<>'0000-00-00 00:00:00'){
                        $time = strtotime($arResult[$i]['fechaVtoContrato']);
                        $vtoContrato = date("d/m/Y", $time);                            
                    }

                    $num = $arResult[$i]['NumEmpleado'];
                    while(strlen($num) < 3){
                        $num = '0' . $num;
                    }

                    ?>
                    <li onClick="<?php echo $link; ?>">
                        <a href="#" data-ajax="false">
                        <?php echo '<font color="30a53b">Empleado: </font><br/>'; ?>
                        <?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$arResult[$i]['nombre'].' '.$arResult[$i]['apellido1'].' '.$arResult[$i]['apellido2'].'<br/>'; ?>
                        <?php echo '<font color="30a53b">Tipo y Nº Doc.: </font>'.$arResult[$i]['tipoDocumento'].'-'.$arResult[$i]['numDocumento'].'<br/>'; ?>
                        <?php echo '<font color="30a53b">Tipo Contrato: </font>'.$arResult[$i]['tipoContrato'].'<br/>';?>
                        <?php echo '<font color="30a53b">Categoría: </font>'.$arResult[$i]['Categoria'].'<br/>';?>
                        <?php echo '<font color="30a53b">Vto. Contrato: </font>'.$vtoContrato.'<br/>';?>
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
