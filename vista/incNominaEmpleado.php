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


logger('info','empleados_list.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
       " ||||Laboral->Incidencias Nominas->Listado Incidencias un Empleado||");

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="../images/q.ico">
        <title>Incidencias del EMPLEADO</title>
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

////comntrolar que solo se introduce datos numericos en el campo
// function Solo_Numerico(variable){
//    Numer=parseInt(variable);
//    if (isNaN(Numer)){
//        return "";
//    }
//    return Numer;
//}
//function ValNumero(Control){
//    Control.value=Solo_Numerico(Control.value);
//}
//
//function copiarFin(objetoACopiar,objetoDondeCopia){
//    objetoDondeCopia.value=objetoACopiar.value;
//}

function volver(){
    location.href="../vista/incNomina.php";
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

<table align="center" width="954">
    <tr>
        <td>
    <h3 align="center" color="#FFCC66">
        <font size="3px">Incidencias del Empleado <?php echo $empleado['nombre'].' '.$empleado['apellido1'].' '.$empleado['apellido2'];?></font>
    </h3> 
            
<!--  CAMBIAR TODOS LOS FILTROS          -->
<!--<form name="form1" action="../vista/empleados_list.php" method="get">
    <table align="center" border="0" width="954">
        <tr></tr>
        <tr><td>
    <label class="filtroTexto" align="center" onclick="onOff_filtro(document.getElementById('filtros'));">Filtros</label> 
    <div id="filtros" style="display: none;">
    <table class="filtro" align="center" border="0" width="945">
    <tr> 
      <td class="nombreCampo"><div align="right">DNI-NIE:</div></td>
      <td width="250">
          <div align="right">
              <input class="textbox1" type="text" name="strDNINIE" maxlength="30" tabindex="1"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
          </div>
      </td>
      <td class="nombreCampo"> <div align="right">Tipo Contrato:</div></td>
      <td>
          <div align="right">
              <input class="textbox1" type="text" name="strTipoContrato" maxlength="40" tabindex="4"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
          </div>
      </td>
    </tr>
    <tr> 
      <td class="nombreCampo"><div align="right">Nº Seg. Social:</div></td>
      <td width="150">
          <div align="right">
              <input class="textbox1" type="text" name="strNumSS" maxlength="30" tabindex="2"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
          </div>
      </td>
      <td class="nombreCampo"> <div align="right">Duración Contrato:</div></td>
      <td>
          <div align="right">
              <input class="textbox1" type="text" name="strDuracionContrato" maxlength="20" tabindex="5"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
          </div>
      </td>
    </tr>
    <tr> 
      <td class="nombreCampo"><div align="right">Nombre y Apellidos:</div></td>
      <td width="150">
          <div align="right">
              <input class="textbox1" type="text" name="strNomApellidos" maxlength="100" tabindex="3"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
          </div>
      </td>
      <td class="nombreCampo"> <div align="right">Categoría Profesional:</div></td>
      <td>
          <div align="right">
              <input class="textbox1" type="text" name="strCategProfesional" maxlength="40" tabindex="6"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
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
</form>-->
    
            <?php
                //extraigo la consulta de esta tabla
                $arResult=$clsCNContabilidad->ListadoIncidenciasEmpleado($_GET['IdEmpleado']);
            ?>
            <br/>
            <table border="0" id="datatablesMod" class="display">
                <thead>
                    <tr>
                        <th width="10%">Fecha Inicio</th>
                        <th width="10%">Fecha Fin</th>
                        <th width="20%">Tipo Incidencia</th>
                        <th width="55%">Observaciones</th>
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
                            
                            //ahora indico si esta cerrada o no
                            $cerrada = 'SI';
                            if($arResult[$i]['cerrada'] === '0'){
                                $cerrada = 'NO';
                            }
                            ?>
                            <tr>
                                <td onClick="<?php echo $link; ?>"><?php echo '<!-- '.$fechaInicioOrdenada.' -->'.$fechaInicio; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo '<!-- '.$fechaFinOrdenada.' -->'.$fechaFin; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['tipo']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['observaciones']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $cerrada; ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
                
            <form name="form2" action="../vista/incNomina_nueva.php" method="post">
            <table align="center" border="0" width="40%">
                <tbody>
                    <tr>
                        <td align="center">
                            <input class="buttonAzul" type="button" value="Volver" onclick="volver();" />
                            <input type="hidden" name="<?php echo 'id'.$_GET['IdEmpleado']; ?>" />
                        </td>
                        <td align="center">
                            <input class="button" type="button" id="cmdContabilizar" value="Nueva Incidencia" onclick="nuevaIncidencia();" />
                        </td>
                    </tr>
                <tbody>
            </table>
            </form>
            <?php
//            }//fin de la condicion if
            ?>
            <?php include '../vista/IndicacionIncidencia.php'; ?>
        </td>
        </tr>
        </table>
    </body>
</html>
