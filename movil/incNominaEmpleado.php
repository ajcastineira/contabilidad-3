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
       " ||||Laboral->Incidencias Nominas->Listado Incidencias un Empleado||");

date_default_timezone_set('Europe/Madrid');
$fechaForm=date('d/m/Y');




require_once '../CN/clsCNContabilidad.php';
$clsCNContabilidad=new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['mapeo']);

//extraigo el nombre y apellidos del empleado
$empleado=$clsCNContabilidad->datosEmpleado($_GET['IdEmpleado']);

//extraigo la consulta de esta tabla
$arResult=$clsCNContabilidad->ListadoIncidenciasEmpleado($_GET['IdEmpleado']);


?>

<!DOCTYPE html>
<html>
<head>
<TITLE>Incidencias del EMPLEADO</TITLE>

<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>
</head> 
    <body>
    <div data-role="page" id="incNominaEmpleado">
<?php
eventosInputText();
?>
<script LANGUAGE="JavaScript"> 

function volver(){
    location.href="../movil/incNomina.php";
}

function nuevaIncidencia(){
    //
    
    //alert('Comienza el proceso de contabilizar facturas.');
    document.getElementById("cmdContabilizar").value = "Procensando...";
    document.getElementById("cmdContabilizar").disabled = true;
    document.form2.submit();
}

</script>

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>
        
    <div data-role="content" data-theme="a">
        <h3 align="center" color="#FFCC66"><font size="3px">Incidencias del Empleado <br/><?php echo $empleado['nombre'].' '.$empleado['apellido1'].' '.$empleado['apellido2'];?></font></h3>
        <br/>
        
        <ul data-role="listview" data-dividertheme="a" data-filter="true" data-filter-placeHolder="Buscar">
            <?php
            if(is_array($arResult)){
                for ($i = 0; $i < count($arResult); $i++) {
                    $link="javascript:document.location.href='../vista/incNominaEmpleadoIncidencia.php?IdIncidencia=".$arResult[$i]['IdIncidencia']."';";
                    $fechaInicio='';
                    if(isset($arResult[$i]['fechaInicio']) && $arResult[$i]['fechaInicio']<>'0000-00-00 00:00:00'){
                        $time = strtotime($arResult[$i]['fechaInicio']);
                        $fechaInicio = date("d/m/Y", $time);                            
                    }
                    //fecha en forma 2014-12-29 para ordenar por fecha
                    $fechaInicioOrdenada=explode('/',$fechaInicio);
                    $fechaInicioOrdenada=$fechaInicioOrdenada[2].$fechaInicioOrdenada[1].$fechaInicioOrdenada[0];

                    $fechaFin='';
                    if(isset($arResult[$i]['fechaFin']) && $arResult[$i]['fechaFin']<>'0000-00-00 00:00:00'){
                        $time = strtotime($arResult[$i]['fechaFin']);
                        $fechaFin = date("d/m/Y", $time);                            
                    }
                    $fechaFinOrdenada=explode('/',$fechaFin);
                    $fechaFinOrdenada=$fechaFinOrdenada[2].$fechaFinOrdenada[1].$fechaFinOrdenada[0];

                    //ahora indico si esta cerrada o no
                    $cerrada = 'SI';
                    if($arResult[$i]['cerrada'] === '0'){
                        $cerrada = 'NO';
                    }

                    ?>
                    <li onClick="<?php echo $link; ?>">
                        <a href="#" data-ajax="false">
                        <?php echo '<font color="30a53b">F. Inicio: </font>'.'<!-- '.$fechaInicioOrdenada.' -->'.$fechaInicio.'<br/>'; ?>
                        <?php echo '<font color="30a53b">F. Fin: </font>'.'<!-- '.$fechaFinOrdenada.' -->'.$fechaFin.'<br/>'; ?>
                        <?php echo '<font color="30a53b">Tipo Incidencia: </font>'.$arResult[$i]['tipo'].'<br/>'; ?>
                        <?php echo '<font color="30a53b">Observaciones: </font><br/>';?>
                        <?php echo '&nbsp;&nbsp;&nbsp;'.$arResult[$i]['observaciones'].'<br/>';?>
                        <?php echo '<font color="30a53b">Cerrada: </font>'.$cerrada.'<br/>';?>
                        </a>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
        
        <form name="form2" action="../vista/incNomina_nueva.php" method="post">
        <table border="0" style="width: 100%;">
            <tbody>
                <tr>
                    <td style="width: 22%;"></td>
                    <td style="width: 23%;"></td>
                    <td style="width: 23%;"></td>
                    <td style="width: 22%;"></td>
                </tr>
                <tr>
                    <td height="20px"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input data-mini="true" type="button" value="Volver" onclick="volver();" />
                        <input type="hidden" name="<?php echo 'id'.$_GET['IdEmpleado']; ?>" />
                    </td>
                    <td colspan="2">
                        <input data-mini="true" type="button" id="cmdContabilizar" value="Nueva Incidencia" onclick="nuevaIncidencia();" />
                    </td>
                </tr>
        
            </tbody>
        </table>
        </form>
            
    </div>    
    </div>    
    <script type="text/javascript" charset="utf-8">
    </script>
    </body>
</html>
