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
       " ||||Consultas->Diario||");

date_default_timezone_set('Europe/Madrid');
$fechaForm=date('d/m/Y');


//extraigo la consulta de esta tabla
require_once '../CN/clsCNContabilidad.php';
$clsCNContabilidad=new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['dbContabilidad']);
$clsCNContabilidad->setStrBDCliente($_SESSION['mapeo']);

$ejercicios=$clsCNContabilidad->verEjerciciosFacturas();

function listadoEjercicios($ejercicios,$ejercicio){
    if($ejercicio === null){
        $ejercicio = date('Y');
    }
?>
<select name="ejercicio" class="textbox1" onchange="">
    <?php
    for ($i = 0; $i < count($ejercicios); $i++) {
    ?>
        <option value="<?php echo $ejercicios[$i];?>" <?php if($ejercicios[$i] === $ejercicio){echo 'selected';}?>><?php echo $ejercicios[$i];?></option>
    <?php
    }
    ?>
</select>
<?php
}

function listadoEstados($opcion,$IdFactura){
?>
<select name="estadoNuevo" class="textbox1" onchange="actualizarEstadoFactura(<?php echo $IdFactura; ?>,this.value);">
    <option value="Emitida" <?php if($opcion==='Emitida'){echo 'selected';}?>>Emitida</option>
    <option value="Anulada" <?php if($opcion==='Anulada'){echo 'selected';}?>>Anulada</option>
</select>
<?php
}

function listadoSituacion($opcion,$IdFactura){
?>
<select name="situacionNueva" class="textbox1" onchange="actualizarSituacionFactura(<?php echo $IdFactura; ?>,this.value);">
    <option value="En plazo" <?php if($opcion==='En plazo'){echo 'selected';}?>>En plazo</option>
    <option value="Vencida" <?php if($opcion==='Vencida'){echo 'selected';}?>>Vencida</option>
    <option value="Cobro parcial" <?php if($opcion==='Cobro parcial'){echo 'selected';}?>>Cobro parcial</option>
    <option value="Cobrada" <?php if($opcion==='Cobrada'){echo 'selected';}?>>Cobrada</option>
</select>
<?php
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="../images/q.ico">
        <title>Diario</title>
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
                    "bPaginate": false,
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
function copiarFin(objetoACopiar,objetoDondeCopia){
//    objetoDondeCopia.value=objetoACopiar.value;
}

//function actualizarEstadoFactura(IdFactura,opcion){
//    $.ajax({
//      url: '../vista/ajax/actualizarEstadoFactura.php?IdFactura='+IdFactura+'&opcion='+opcion,
//      type:"get"
//    });
//}
//
//function actualizarSituacionFactura(IdFactura,opcion){
//    $.ajax({
//      url: '../vista/ajax/actualizarSituacionFactura.php?IdFactura='+IdFactura+'&opcion='+opcion,
//      type:"get"
//    });
//}
    </script>
<?php
//Funciones generales - carga las funciones auxiliares de eventos de los input text
    eventosInputText();
?>
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
    </head>
    <body>
<table border="0" align="center">
    <tr>
        <td>
    <?php require_once '../vista/cabecera2.php'; ?>

<h3 align="center" color="#FFCC66"><font size="3px">Diario</font></h3> 
<form name="form1" action="../vista/diario.php" method="get">
    <table align="center" border="0" width="800">
        <tr></tr>
        <tr><td>
<!--    <label class="filtroTexto" align="center" onclick="onOff_filtro(document.getElementById('filtros'));">Filtros</label> -->
    <div id="filtros" style="display: block;">
    <table class="filtro" align="center" border="0" width="800">
    <tr>
        <td width="15%"></td>
        <td width="15%"></td>
        <td width="3%"></td>
        <td width="15%"></td>
        <td width="15%"></td>
        <td width="3%"></td>
        <td width="15%"></td>
        <td width="15%"></td>
        <td width="3%"></td>
    </tr>    
<!--    <tr> 
      <td class="nombreCampo"><div align="right">Cliente:</div></td>
      <td>
          <div align="right">
              <input class="textbox1" style="width:100%" type="text" name="strNomContacto" maxlength="150" value="<?php //if(isset($_GET['strNomContacto'])){echo $_GET['strNomContacto'];}?>"
                                    onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"  onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
          </div>
      </td>
      <td></td>
      <td class="nombreCampo"><div align="right">Estado:</div></td>
      <td>
          <div align="left">
            <select name="estado" class="textbox1" tabindex="5">
                <option value=""></option>
                <option value="Emitida" <?php //if($_GET['estado']==='Emitida'){echo 'selected';}?>>Emitida</option>
                <option value="Contabilizada" <?php //if($_GET['estado']==='Contabilizada'){echo 'selected';}?>>Contabilizada</option>
                <option value="Anulada" <?php //if($_GET['estado']==='Anulada'){echo 'selected';}?>>Anulada</option>
            </select>
          </div>
      </td>
      <td></td>
      <td class="nombreCampo"><div align="right">Ejercicio:</div></td>
      <td>
          <div align="left">
              <?php
              //echo listadoEjercicios($ejercicios,$_GET['ejercicio']);
              ?>
          </div>
      </td>
      <td></td>
    </tr>
    <tr> 
      <td colspan="8"><hr align="left"></td>
    </tr>-->
    <tr>
      <?php
      datepicker_español('datFechaInicio');
      datepicker_español('datFechaFin');
      ?>
      <td></td>
      <td class="nombreCampo"><div align="right">Fecha Desde:</div></td>
      <td colspan="2">
          <input class="textbox1" type="text" name="datFechaInicio" id="datFechaInicio" size="12" maxlength="38" value="<?php if(isset($_GET['datFechaInicio'])){echo $_GET['datFechaInicio'];}?>"
               onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
               onKeyUp="this.value=formateafechaEntrada(this.value);" 
               onfocus="onFocusInputText(this);" onchange="copiarFin(this,document.form1.datFechaFin);"
               onblur="onBlurInputText(this);"
               />
      </td>
      <td class="nombreCampo"><div align="right">Fecha Hasta:</div></td>
      <td colspan="2">
          <input class="textbox1" type="text" name="datFechaFin" id="datFechaFin" size="12" maxlength="38" value="<?php if(isset($_GET['datFechaFin'])){echo $_GET['datFechaFin'];}?>"
               onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
               onKeyUp="this.value=formateafechaEntrada(this.value);" 
               onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"
               />
      </td>
        
    </tr>
    
    <tr> 
      <td colspan="8"><hr align="left"></td>
    </tr>
     <tr align="center">
         <td colspan="8">
             <input type="Reset" class="button" value="Vaciar Datos" name="cmdReset"/>
             <input type="submit" class="button" value="Consultar" name="cmdConsultar"  />
             <input name="cmdListar" type="hidden" value="OK"/>
         </td>
     </tr>
     </table>
    </div>
    </td></tr>
    <tr height="15px"></tr>
    <tr>
        <td>
            
    
            <?php
            if(isset($_GET) && !empty($_GET)){
                if($_GET['datFechaInicio'] !== '' && $_GET['datFechaFin'] !== ''){
                    $arResult=$clsCNContabilidad->diario($_GET);
                    //var_dump($arResult);die;
                ?>

                <br/>
                <table id="datatablesMod" class="display">
                <!--<table id="" class="tablaExcel" border="1">-->
                    <thead>
                        <tr>
                            <th width="10%">Nº Asiento</th>
                            <th width="10%">&nbsp;&nbsp;&nbsp;Fecha&nbsp;&nbsp;&nbsp;&nbsp;</th>
                            <th width="10%">Cuenta</th>
                            <th width="50%">Concepto</th>
                            <th width="10%">Debe</th>
                            <th width="10%">Haber</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //$tipoContador=$clsCNContabilidad->Parametro_general('Tipo Contador',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));

                        //sumas
                        $sumaDebe = 0;
                        $sumaHaber = 0;
                        if(is_array($arResult)){
                            for ($i = 0; $i < count($arResult); $i++) {
                                //$numeroFactura = numeroDesformateado($arResult[$i]['NumFactura'],$tipoContador);

                                $sumaDebe = $sumaDebe + (float)$arResult[$i]['Debe'];
                                $sumaHaber = $sumaHaber + (float)$arResult[$i]['Haber'];

                                //preparo el array de $arResult[$i] para enviar por url
                                //$link="javascript:document.location.href='../vista/altafactura.php?IdFactura=".$arResult[$i]['IdFactura']."';";
                                $link="";
                                $fecha = explode('/',$arResult[$i]['Fecha']);
                                
                                //al numero de asiento le formateo para que tenga 6 digitos, sino tiene le pongo 0 a la izquierda
                                $numAsiento = $arResult[$i]['asiento'];
                                while(strlen($numAsiento) < 7){
                                    $numAsiento = '0' . $numAsiento; 
                                }
                                ?>
                                <tr>
                                    <td align="right" onClick="<?php echo $link; ?>"><?php echo "<!--".$numAsiento." -->".$arResult[$i]['asiento']; ?></td>
                                    <td onClick="<?php echo $link; ?>"><?php echo "<!-- ".$fecha[2].$fecha[1].$fecha[0]." -->".$arResult[$i]['Fecha']; ?></td>
                                    <td align="right" onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['idCuenta']; ?></td>
                                    <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['concepto']; ?></td>
                                    <td align="right" onClick="<?php echo $link; ?>"><?php echo "<!-- $cIVATxt -->".formateaNumeroContabilidad($arResult[$i]['Debe']); ?></td>
                                    <td align="right" onClick="<?php echo $link; ?>"><?php echo "<!-- $importeTxt -->".formateaNumeroContabilidad($arResult[$i]['Haber']); ?></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th align="left" colspan="2"></th>
                            <th align="right"></th>
                            <th align="right"></th>
                            <th align="right"><b><?php echo formateaNumeroContabilidad($sumaDebe);?></b>&nbsp;&nbsp;&nbsp;</th>
                            <th align="right"><b><?php echo formateaNumeroContabilidad($sumaHaber);?></b>&nbsp;&nbsp;&nbsp;</th>
                        </tr>
                    </tfoot>
                </table>
            <script>
            function generarPDF(){
                var datos = 'datFechaInicio=<?php echo $_GET['datFechaInicio']; ?>&';
                datos = datos + 'datFechaFin=<?php echo $_GET['datFechaFin']; ?>&';

                window.open("../vista/diario_PDF.php?"+datos, '', 'scrollbars=yes,menubar=no,height=600,width=800,resizable=yes,toolbar=no,status=no,location=no');
            }

            </script>
            <?php
                }
            }//fin de la condicion if
            ?>
            
        </td>
    </tr>
    </table>   
     </form>
    <br/>
    <?php
    if(isset($_GET) && !empty($_GET)){
        if($_GET['datFechaInicio'] !== '' && $_GET['datFechaFin'] !== ''){
        ?>
        <div align="center">
            <button class="button" onclick='generarPDF();'>Generar PDF</button>
        </div>
        <?php
        }
    }//fin de la condicion if
    ?>
            
            <br/><br/><br/>
            <?php include '../vista/IndicacionIncidencia.php'; ?>
        </td>
        </tr>
        </table>
    </body>
</html>
