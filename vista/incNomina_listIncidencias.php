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

require_once '../CN/clsCNContabilidad.php';
$clsCNContabilidad=new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['mapeo']);
                
//extraigo el nombre y apellidos del empleado
$empleado=$clsCNContabilidad->datosEmpleado($_GET['IdEmpleado']);


logger('info','incNomina_listIncidencias.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
       " ||||Laboral->Incidencias Nominas->Listado Incidencias un Empleado||");

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="../images/q.ico">
        <title>Incidencias</title>
        <script language="JavaScript">
            <!-- //
            var txt="-    Sistema de Gestión de la Calidad    ";
            var espera=120;
            var refresco=null;
 
            function rotulo_status() {
                window.status=txt;
                txt=txt.substring(1,txt.length)+txt.charAt(0);        
                refresco=setTimeout("rotulo_status()",espera);
            }
 
            // --></script>
        <SCRIPT language="JavaScript" src="../js/car_valido.js"> 
        </SCRIPT>
        <SCRIPT languaje="JavaScript" src="../js/valida.js"> 
            <!--
            alert('Error en el fichero valida.js');
            // -->
        </SCRIPT>
        <link href="../css/Estilos_Qualidad.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="../css/calidad2.css" type="text/css">

        <!--            HE INCLUIDO AQUI ESTAS LIBRERIAS DE jQuery PACO-->
        <?php
        librerias_jQuery_listado();
        ?>
        <!--       FIN     HE INCLUIDO AQUI ESTAS LIBRERIAS DE jQuery PACO-->

        <style>
            *{
                /*font-family: arial;*/
            }
        </style>
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function(){
                //formatear y traducir los datos de la tabla
                $('#datatablesMod').dataTable({
                    "bProcessing": true,
                    "bStateSave": true,
                    "iCookieDuration": 60, //1 minuto
                    "sPaginationType":"full_numbers",
                    "oLanguage": {
                        "sLengthMenu": "Ver _MENU_ registros por pagina",
                        "sZeroRecords": "No se han encontrado registros",
                        "sInfo": "Ver _START_ al _END_ de _TOTAL_ Registros",
                        "sInfoEmpty": "Ver 0 al 0 de 0 registros",
                        "sInfoFiltered": "(filtrados _MAX_ total registros)",
                        "sSearch": "Busqueda:"
                    },
                    "bSort":true,
                    "aaSorting": [[ 1, "desc" ]],
                    "aoColumns": [
			null,
			{ "sType": 'string' },
			{ "sType": 'string' },
			null,
			null,
			null,
			null
                    ],                    
                    "bJQueryUI":true,
                    "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]]
                });
            });
        </script>
<style type="text/css">
/* para que no salga el rectangulo inferior */        
.ui-widget-content {
    border: 0px solid #AAAAAA;
}
</style>      

<script LANGUAGE="JavaScript"> 

//comntrolar que solo se introduce datos numericos en el campo
 function Solo_Numerico(variable){
    Numer=parseInt(variable);
    if (isNaN(Numer)){
        return "";
    }
    return Numer;
}
function ValNumero(Control){
    Control.value=Solo_Numerico(Control.value);
}

function copiarFin(objetoACopiar,objetoDondeCopia){
    objetoDondeCopia.value=objetoACopiar.value;
}


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
//Funciones generales - carga las funciones auxiliares de eventos de los input text
    eventosInputText();
?>
    </head>
    <SCRIPT LANGUAGE="JavaScript"> 
 
        <!-- Inicio
        function MakeArrayday(size) {
            this.length = size;
            for(var i = 1; i <= size; i++) {
                this[i] = ""
            }
            return this
        }
 
        function funClock() {
            if (!document.layers && !document.all)
                return;
            var runTime = new Date()
            var hours = runTime.getHours()
            var minutes = runTime.getMinutes()
            var seconds = runTime.getSeconds()
            var dn = "am";
 
 
            if (minutes <= 9) {
                minutes = "0" + minutes;
            }
            if (seconds <= 9) {
                seconds = "0" + seconds;
            }
            movingtime = "<b>"+ hours + ":" + minutes + ":" + seconds + " " +  "</b>";
            if (document.layers) {
                document.layers.clock.document.write(movingtime);
                document.layers.clock.document.close();
            }
            else if (document.all) {
               // clock.innerHTML = movingtime;
            }
            setTimeout("funClock()", 1000)
        }
        window.onload = funClock;
        //  Fin -->
    </script>


    <SCRIPT LANGUAGE="JavaScript"> 
        <!-- Hide from JavaScript-Impaired Browsers
        function initArray() {
            for(i=0;i<initArray.arguments.length; i++)
            this[i] = initArray.arguments[i];
        }
 
        var isnMonths=new initArray("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre")
        var isnDays= new initArray("Domingo","Lunes","Martes","Mi&eacute;rcoles","Jueves","Viernes","Sabado","Domingo")
        today=new Date()
        hrs=today.getHours()
        min=today.getMinutes()
        sec=today.getSeconds()
        clckh=""
        clckm=""
        clcks=""
        clck=""
 
        var stnr=""
        var ns="0123456789"
        var a="";
        // End Hiding -->
    </script>
    
    <body>
    <?php require_once '../vista/cabecera2.php'; ?>

<table align="center">
    <tr>
        <td>
    <h3 align="center" color="#FFCC66">
        <font size="3px">Incidencias de los Empleados</font>
    </h3> 
            
    <form name="form1" action="../vista/incNomina_listIncidencias.php" method="get">
    <table align="center" border="0" width="954">
        <tr></tr>
        <tr><td>
    <label class="filtroTexto" align="center" onclick="onOff_filtro(document.getElementById('filtros'));">Filtros</label> 
    <div id="filtros" style="display: none;">
    <table class="filtro" align="center" border="0" width="300">
    <tr> 
      <td width="70" class="nombreCampo" rowspan="2"><div align="right">Fecha Alta</div></td>
      <td width="70" class="nombreCampo"><div align="right">Desde:</div></td>
      <td>
        <?php
        datepicker_español('fechaInicioDesde');
        datepicker_español('fechaInicioHasta');
        datepicker_español('fechaFinDesde');
        datepicker_español('fechaFinHasta');
        date_default_timezone_set('Europe/Madrid');
        ?>
        <style type="text/css">
        /* para que no salga el rectangulo inferior */        
        .ui-widget-content {
            border: 0px solid #AAAAAA;
        }
        </style>
          <div align="right">
              <input class="textbox1" type="text" id="fechaInicioDesde" name="fechaInicioDesde" maxlength="38" tabindex="1"
                     onKeyUp="this.value=formateafechaEntrada(this.value);"
                     value="<?php if(isset($_GET['fechaAltaDesde'])){echo $_GET['fechaAltaDesde'];} ?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
          </div>
      </td>
    </tr>
    <tr>
      <td class="nombreCampo"><div align="right">Hasta:</div></td>
      <td>
          <div align="right">
              <input class="textbox1" type="text" id="fechaInicioHasta" name="fechaInicioHasta" maxlength="38" tabindex="2"
                     onKeyUp="this.value=formateafechaEntrada(this.value);" 
                     value="<?php if(isset($_GET['fechaAltaHasta'])){echo $_GET['fechaAltaHasta'];} ?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
          </div>
      </td>
    </tr>
    <tr>
        <td colspan="5">
            <hr/>
        </td>
    </tr>
    <tr> 
      <td width="90" class="nombreCampo" rowspan="2"><div align="right">Fecha Fin</div></td>
      <td width="50" class="nombreCampo"><div align="right">Desde:</div></td>
      <td>
          <div align="right">
              <input class="textbox1" type="text" id="fechaFinDesde" name="fechaFinDesde" maxlength="38" tabindex="3"
                     onKeyUp="this.value=formateafechaEntrada(this.value);" 
                     value="<?php if(isset($_GET['fechaFinDesde'])){echo $_GET['fechaFinDesde'];} ?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
          </div>
      </td>
    </tr>
    <tr>
      <td class="nombreCampo"><div align="right">Hasta:</div></td>
      <td>
          <div align="right">
              <input class="textbox1" type="text" id="fechaFinHasta" name="fechaFinHasta" maxlength="38" tabindex="4"
                     onKeyUp="this.value=formateafechaEntrada(this.value);" 
                     value="<?php if(isset($_GET['fechaFinHasta'])){echo $_GET['fechaFinHasta'];} ?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
          </div>
      </td>
    </tr>
    <tr>
        <td colspan="5">
            <hr/>
        </td>
    </tr>
    <tr> 
      <td colspan="2" class="nombreCampo"><div align="right">Tipo Incidencia:</div></td>
      <td>
          <div align="right">
            <select name="tipoIncidencia" class="textbox1" tabindex="5"
                    onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);">
                <option value = "" <?php if($_GET['tipoIncidencia'] === ''){echo 'selected';} ?>></option>
                <option value = "enfermedad" <?php if($_GET['tipoIncidencia'] === 'enfermedad'){echo 'selected';} ?>>Enfermedad</option>
                <option value = "accidente" <?php  if($_GET['tipoIncidencia'] === 'accidente'){echo 'selected';} ?>>Accidente</option>
                <option value = "ausencia" <?php  if($_GET['tipoIncidencia'] === 'ausencia'){echo 'selected';} ?>>Ausencia</option>
                <option value = "maternidad" <?php  if($_GET['tipoIncidencia'] === 'maternidad'){echo 'selected';} ?>>Maternidad</option>
            </select>
          </div>
      </td>
    </tr>
    <tr>
        <td colspan="5">
            <hr/>
        </td>
    </tr>
    <tr> 
      <td colspan="2" class="nombreCampo"><div align="right">Cerrada:</div></td>
      <td>
          <div align="right">
            <select name="cerrada" class="textbox1" tabindex="6"
                    onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);">
                <option value = "" <?php if($_GET['cerrada'] === ''){echo 'selected';} ?>></option>
                <option value = "0" <?php if($_GET['cerrada'] === '0'){echo 'selected';} ?>>No</option>
                <option value = "1" <?php if($_GET['cerrada'] === '1'){echo 'selected';} ?>>Si</option>
            </select>
          </div>
      </td>
    </tr>
    <tr> 
      <td colspan="5"></td>
    </tr>
     <tr align="center">
         <td colspan="5">
             <input type="Reset" class="button" value="Vaciar Datos" name="cmdReset"/>
             <input type="submit" class="button" value="Consultar" name="cmdConsultar" tabindex="7" />
             <input name="cmdListar" type="hidden" value="OK"/>
         </td>
     </tr>
     </table>
    </div>
    </td></tr>
    <tr></tr>
    </table>   
</form>
    
            <?php
            //extraigo la consulta de las incidencias
            $arResult=$clsCNContabilidad->ListadoIncidencias($_GET);
            ?>
            <br/>
            <form name="form2" action="../vista/incNomina_nueva.php" method="post">
            <table border="0" id="datatablesMod" class="display">
                <thead>
                    <tr>
                        <th width="5%"></th>
                        <th width="10%">Fecha Inicio</th>
                        <th width="10%">Fecha Fin</th>
                        <th width="15%">Tipo Incidencia</th>
                        <th width="50%">Observaciones</th>
                        <th width="5%">Nº Empleados</th>
                        <th width="5%">Cerrada</th>
                    </tr>
                </thead>
                <tbody>
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
                            
                            //preparo el texto HTML que va en el title (el listado de los empleados)
                            $txtTitle = '';
                            for($j=0;$j<count($list);$j++){
                                $txtTitle = $txtTitle . $list[$j]['Empleado'].' - ';//salto de carro
                            }
                            //quito el ultimo salto de carro
                            $txtTitle = substr($txtTitle,0,strlen($txtTitle)-3);
                            
                            $txtListadoEmpleados="<font class='circulo' title='$txtTitle'><b>&nbsp;".count($list)."&nbsp;</b></font>";
                            
                            //vemos si esta cerrada o abierta
                            $cerrada = 'SI';
                            if($arResult[$i]['cerrada'] === '0'){
                                $cerrada = 'NO';
                            }
                            ?>
                            <tr>
                                <td onClick=""><input type="checkbox" id="check<?php echo $arResult[$i]['IdIncidencia']; ?>" name="id<?php echo $arResult[$i]['IdIncidencia']; ?>" class="nombreCampo" /></td>
                                <td onClick="<?php echo $link; ?>"><?php echo '<!-- '.$fechaInicioOrdenada.' -->'.$fechaInicio; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo '<!-- '.$fechaFinOrdenada.' -->'.$fechaFin; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['tipo']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['observaciones']; ?></td>
                                <td onClick="<?php echo $link; ?>" style="text-align: center;"><?php echo $txtListadoEmpleados; ?></td>
                                <td onClick="<?php echo $link; ?>" style="text-align: center;"><?php echo $cerrada; ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
            
            <?php 
            if(substr($_SESSION['cargo'],0,6) === 'Asesor'){
            ?>
            <table align="center" border="0" width="100%">
                <tbody>
                    <tr>
                        <td width="30px" align="center">
                            <input type="checkbox" id="chkTodos" name="chkTodos" class="nombreCampo" onclick="seleccionar(this);" />
                        </td>
                        <td class="nombreCampo">Seleccionar/Quitar Todo</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td align="center">
                                <input class="button" type="button" id="cmdCerrarInc" value="Cerrar Incidencias" onclick="cerrarIncidencias();" />
                            <input type="hidden" name="opcionBoton" />
                        </td>
                    </tr>
                <tbody>
            </table>
            <?php 
            }
            ?>
            </form>
            
            <br/><br/><br/><br/>
            <?php
//            }//fin de la condicion if
            ?>
            <?php include '../vista/IndicacionIncidencia.php'; ?>
        </td>
        </tr>
        </table>
    </body>
</html>
