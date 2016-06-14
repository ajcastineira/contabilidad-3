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
       " ||||Laboral->Incidencias Nómina/Alta||");

date_default_timezone_set('Europe/Madrid');
$fechaForm=date('d/m/Y');


require_once '../CN/clsCNContabilidad.php';
$clsCNContabilidad=new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['mapeo']);

//extraigo la consulta de las incidencias
$arResult=$clsCNContabilidad->ListadoIncidencias('');


?>

<!DOCTYPE html>
<html>
<head>
<TITLE>Incidencias</TITLE>

<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>
</head> 
    <body>
    <div data-role="page" id="incNomina">
<?php
eventosInputText();
?>
<script LANGUAGE="JavaScript"> 

function seleccionar(objeto){
    if(objeto.checked){
        //esta seleccionado, lo deselecciono
        $(document).ready(function(){
            $('#datatablesMod').find(":checkbox").each(function(){
                var elemento=this;
                elemento.checked=true;
            });
        });
    }else{
        //esta deseleccionado, lo selecciono
        $(document).ready(function(){
            $('#datatablesMod').find(":checkbox").each(function(){
                var elemento=this;
                elemento.checked=false;
            });
        });
    }
}

function cerrarIncidencias(){
    //comprobamos que este un empleado seleccionado
    var hayEmpleado='false';
    
    $('#datatablesMod').find(":checkbox").each(function(){
        var elemento=this;
        if(elemento.checked===true){
            hayEmpleado='true';
        }
    });
    
    if(hayEmpleado==='true'){
        document.form2.opcionBoton.value='cerrarIncidencias';
        document.getElementById("cmdCerrarInc").value = "Procensando...";
        document.getElementById("cmdCerrarInc").disabled = true;
        document.form2.submit();
    }else{
        alert('No ha seleccionado ninguna incidencia.');
    }
}

</script>

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>
        
    <div data-role="content" data-theme="a">
        <h3 align="center" color="#FFCC66"><font size="3px">Incidencias de Empleados</font></h3>
        <br/>
        
        <style>
        .checkBoxLeft{
            position: absolute; 
            left: 1px; 
            top: 45%;
        }
        input[type=checkbox]
        {
          /* Double-sized Checkboxes */
          -ms-transform: scale(2); /* IE */
          -moz-transform: scale(2); /* FF */
          -webkit-transform: scale(2); /* Safari and Chrome */
          -o-transform: scale(2); /* Opera */
          padding: 10px;
        }
        </style> 
        
        <form name="form2" action="../vista/incNomina_nueva.php" method="post">
        <ul id="datatablesMod" data-role="listview" data-dividertheme="a" data-filter="true" data-filter-placeHolder="Buscar">
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

                    //ahora saco el listado de los empleados de esta incidencia
                    $list=$clsCNContabilidad->ListadoEmpleadosIncidencia($arResult[$i]['IdIncidencia']);

                    //vemos si esta cerrada o abierta
                    $cerrada = 'SI';
                    if($arResult[$i]['cerrada'] === '0'){
                        $cerrada = 'NO';
                    }

                    ?>
                    <li>
                        <!-- <?php echo $fechaInicioOrdenada; ?> -->
                        <div class="checkBoxLeft"><input type="checkbox" name="id<?php echo $arResult[$i]['IdIncidencia']; ?>" id="check<?php echo $arResult[$i]['IdIncidencia']; ?>" class="ui-li-a" /></div>
                        <a href="<?php echo $link; ?>" data-ajax="false">
                        <?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="30a53b">F. Inicio: </font>'.$fechaInicio.'<br/>'; ?>
                        <?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="30a53b">F. Fin: </font>'.$fechaFin.'<br/>'; ?>
                        <?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="30a53b">Tipo Incidencia: </font>'.'<br/>'; ?>
                        <?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$arResult[$i]['tipo'].'<br/>'; ?>
                        <?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="30a53b">Observaciones: </font>'.'<br/>'; ?>
                        <?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$arResult[$i]['observaciones'].'<br/>'; ?>
                        <?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="30a53b">Cerrada: </font>'.$cerrada.'<br/>'; ?>
                        <span class="ui-li-count"><?php echo count($list); ?></span>
                        </a>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
        
        <?php 
        if(substr($_SESSION['cargo'],0,6) === 'Asesor'){
        ?>
        <table border="0" style="width: 100%;">
            <tbody>
                <tr>
                    <td style="width: 15%;"></td>
                    <td style="width: 75%;"></td>
                </tr>
                <tr>
                    <td colspan="2" height="20px"></td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" id="chkTodos" name="chkTodos" class="nombreCampo" onclick="seleccionar(this);" />
                    </td>
                    <td class="nombreCampo">Seleccionar/Quitar Todo</td>
                </tr>
                    <tr>
                        <td></td>
                        <td align="center">
                                <input class="button" data-mini="true" type="button" id="cmdCerrarInc" value="Cerrar Incidencias" onclick="cerrarIncidencias();" />
                            <input type="hidden" name="opcionBoton" />
                        </td>
                    </tr>
            </tbody>
        </table>
        <?php 
        }
        ?>

        </form>
            
    </div>    
    </div>    
    <script type="text/javascript" charset="utf-8">
    </script>
    </body>
</html>
