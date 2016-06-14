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



logger('info','empleados_list.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
       " ||||Comunicaciones->Empleados->Modificacion/Baja||");

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="../images/q.ico">
        <title>Modificar datos del EMPLEADO</title>
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
<!--        <SCRIPT language="JavaScript" SRC="/include/frames.js"> 
        </SCRIPT>-->
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
                    "aaSorting": [[ 0, "asc" ]],
                    "aoColumns": [
			{ "sType": 'string' },
			{ "sType": 'string' },
			{ "sType": 'string' },
			{ "sType": 'string' },
			{ "sType": 'string' },
			{ "sType": 'string' },
			{ "sType": 'string' },
			{ "sType": 'string' },
			{ "sType": 'string' }
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
        <font size="3px">Consulta de Empleados</font>
    </h3> 
            
<form name="form1" action="../vista/empleados_list.php" method="get">
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
        datepicker_español('fechaAltaDesde');
        datepicker_español('fechaAltaHasta');
        datepicker_español('VtoContratoDesde');
        datepicker_español('VtoContratoHasta');
        date_default_timezone_set('Europe/Madrid');
        ?>
        <style type="text/css">
        /* para que no salga el rectangulo inferior */        
        .ui-widget-content {
            border: 0px solid #AAAAAA;
        }
        </style>
          <div align="right">
              <input class="textbox1" type="text" id="fechaAltaDesde" name="fechaAltaDesde" maxlength="38" tabindex="1"
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
              <input class="textbox1" type="text" id="fechaAltaHasta" name="fechaAltaHasta" maxlength="38" tabindex="2"
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
      <td width="90" class="nombreCampo" rowspan="2"><div align="right">Vto. Contrato</div></td>
      <td width="50" class="nombreCampo"><div align="right">Desde:</div></td>
      <td>
          <div align="right">
              <input class="textbox1" type="text" id="VtoContratoDesde" name="VtoContratoDesde" maxlength="38" tabindex="3"
                     onKeyUp="this.value=formateafechaEntrada(this.value);" 
                     value="<?php if(isset($_GET['VtoContratoDesde'])){echo $_GET['VtoContratoDesde'];} ?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
          </div>
      </td>
    </tr>
    <tr>
      <td class="nombreCampo"><div align="right">Hasta:</div></td>
      <td>
          <div align="right">
              <input class="textbox1" type="text" id="VtoContratoHasta" name="VtoContratoHasta" maxlength="38" tabindex="4"
                     onKeyUp="this.value=formateafechaEntrada(this.value);" 
                     value="<?php if(isset($_GET['VtoContratoHasta'])){echo $_GET['VtoContratoHasta'];} ?>"
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
      <td colspan="2" class="nombreCampo"><div align="right">Tipo Contrato:</div></td>
      <td>
          <div align="right">
            <select name="tipoContrato" class="textbox1" tabindex="5"
                    onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);">
                <option value = "" <?php if($_GET['tipoContrato'] === ''){echo '';} ?>></option>
                <option value = "Indefinido" <?php if($_GET['tipoContrato'] === 'Indefinido'){echo 'selected';} ?>>Indefinido</option>
                <option value = "Temporal" <?php if($_GET['tipoContrato'] === 'Temporal'){echo 'selected';} ?>>Temporal</option>
                <option value = "Practicas" <?php if($_GET['tipoContrato'] === 'Practicas'){echo 'selected';} ?>>Prácticas</option>
                <option value = "Formacion" <?php if($_GET['tipoContrato'] === 'Formacion'){echo 'selected';} ?>>Formación</option>
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
                //extraigo la consulta de esta tabla
                require_once '../CN/clsCNContabilidad.php';
                $clsCNContabilidad=new clsCNContabilidad();
                $clsCNContabilidad->setStrBD($_SESSION['mapeo']);
                
                $arResult=$clsCNContabilidad->ListadoEmpleados($_GET);
            ?>
            <br/>
            <table id="datatablesMod" class="display">
                <thead>
                    <tr>
                        <th>Nombre y Apellidos</th>
                        <th>Tipo y Nº Doc</th>
                        <th>Nº Afiliación S.S.</th>
                        <th>Tipo Contrato</th>
                        <th>Categoría</th>
                        <th>Fecha Alta</th>
                        <th>Fecha Baja</th>
                        <th>Vto Contrato</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(is_array($arResult)){
                        for ($i = 0; $i < count($arResult); $i++) {
                            $link="javascript:document.location.href='../vista/empleados.php?IdEmpleado=".$arResult[$i]['IdEmpleado']."';";
                            $fechaAlta='';
                            if(isset($arResult[$i]['fechaAlta']) && $arResult[$i]['fechaAlta']<>'0000-00-00 00:00:00'){
                                $time = strtotime($arResult[$i]['fechaAlta']);
                                $fechaAlta = date("d/m/Y", $time);                            
                            }
                            
                            $fechaBaja='';
                            if(isset($arResult[$i]['fechaBaja']) && $arResult[$i]['fechaBaja']<>'0000-00-00 00:00:00'){
                                $time = strtotime($arResult[$i]['fechaBaja']);
                                $fechaBaja = date("d/m/Y", $time);                            
                            }
                            
                            $vtoContrato='';
                            if(isset($arResult[$i]['fechaVtoContrato']) && $arResult[$i]['fechaVtoContrato']<>'0000-00-00 00:00:00'){
                                $time = strtotime($arResult[$i]['fechaVtoContrato']);
                                $vtoContrato = date("d/m/Y", $time);                            
                            }
                            
                            $num = $arResult[$i]['NumEmpleado'];
                            while(strlen($num) < 3){
                                $num = '0' . $num;
                            }
                            
                            //ver si a sido hecha la tarea por el asesor o no
                            //(ver campo chatActualizado = 0 no esta hecho y 1 si esta)
                            $imgActualizado = '';
                            if($arResult[$i]['chatActualizado']==='0'){
                                $imgActualizado = '<img src="../images/edit_add.png" width="12" height="11" border="0"/>';
                            }else{
                                $imgActualizado = '<img src="../images/ok.png" width="12" height="11" border="0"/>';
                            }
                            ?>
                            <tr>
                                <td onClick="<?php echo $link; ?>"><?php echo "<!-- $num  -->  ".$arResult[$i]['NumEmpleado'].' - '.$arResult[$i]['nombre'].' '.$arResult[$i]['apellido1'].' '.$arResult[$i]['apellido2']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['tipoDocumento'].'-'.$arResult[$i]['numDocumento']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['numAfiliacion']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['tipoContrato']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['Categoria']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $fechaAlta; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $fechaBaja; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $vtoContrato; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $imgActualizado; ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
            <?php
//            }//fin de la condicion if
            ?>
            <?php include '../vista/IndicacionIncidencia.php'; ?>
        </td>
        </tr>
        </table>
    </body>
</html>
