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

$arResult=$clsCNContabilidad->ListadoEmpleados('');


?>

<!DOCTYPE html>
<html>
<head>
<TITLE>Incidencias de Empleados</TITLE>

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

function copiarFin(objetoACopiar,objetoDondeCopia){
    objetoDondeCopia.value=objetoACopiar.value;
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
        document.form2.opcionBoton.value='cerrar';
        document.getElementById("cmdCerrarInc").value = "Procensando...";
        document.getElementById("cmdCerrarInc").disabled = true;
        document.form2.submit();
    }else{
        alert('No ha seleccionado ningun empleado.');
    }
}

function nuevaIncidencia(){
    //comprobamos que este un empleado seleccionado
    var hayEmpleado='false';
    
    $('#datatablesMod').find(":checkbox").each(function(){
        var elemento=this;
        if(elemento.checked===true){
            hayEmpleado='true';
        }
    });
    
    if(hayEmpleado==='true'){
        document.form2.opcionBoton.value='nueva';
        document.getElementById("cmdNuevaInc").value = "Procensando...";
        document.getElementById("cmdNuevaInc").disabled = true;
        document.form2.submit();
    }else{
        alert('No ha seleccionado ningun empleado.');
    }
}

</script>

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>
        
    <div data-role="content" data-theme="a">
        <h3 align="center" color="#FFCC66"><font size="3px">Incidencias de Empleados</font></h3>
        <br/>
        
        <form name="form2" action="../vista/incNomina_nueva.php" method="post">
        <ul id="datatablesMod" data-role="listview" data-dividertheme="a" data-filter="true" data-filter-placeHolder="Buscar">
            <?php
            if(is_array($arResult)){
                for ($i = 0; $i < count($arResult); $i++) {
                    $link="javascript:document.location.href='../movil/incNominaEmpleado.php?IdEmpleado=".$arResult[$i]['IdEmpleado']."';";
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
                    <li>
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
                        <div class="checkBoxLeft"><input type="checkbox" name="id<?php echo $arResult[$i]['IdEmpleado']; ?>" id="check<?php echo $arResult[$i]['IdEmpleado']; ?>" class="ui-li-a" /></div>
                        <a href="<?php echo $link; ?>" data-ajax="false">
                        <?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$arResult[$i]['nombre'].' '.$arResult[$i]['apellido1'].' '.$arResult[$i]['apellido2'].''; ?>
                        <span class="ui-li-count"><?php echo $arResult[$i]['Numero']; ?></span>
                        </a>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
        
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
            </tbody>
        </table>

        <table border="0" style="width: 100%;">
            <tbody>
                <tr>
                    <td style="width: 22%;"></td>
                    <td style="width: 23%;"></td>
                    <td style="width: 23%;"></td>
                    <td style="width: 22%;"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input data-mini="true" type="button" id="cmdNuevaInc" value="Nueva Incidencia" onclick="nuevaIncidencia();" />
                    </td>
                    <td colspan="2">
                        <?php 
                        if(substr($_SESSION['cargo'],0,6) === 'Asesor'){
                        ?>
                            <input data-mini="true" type="button" id="cmdCerrarInc" value="Cerrar Incidencias" onclick="cerrarIncidencias();" />
                        <?php 
                        }
                        ?>
                        <input type="hidden" name="opcionBoton" />
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
