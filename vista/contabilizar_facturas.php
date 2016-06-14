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
$clsCNContabilidad->setStrBD($_SESSION['dbContabilidad']);
$clsCNContabilidad->setStrBDCliente($_SESSION['mapeo']);

                
logger('info','contabilizar_facturas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
       " ||||Mis Facturas->Contabilizar Factura||");

date_default_timezone_set('Europe/Madrid');
$fechaForm=date('d/m/Y');

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="../images/q.ico">
        <title>Contabilizar Facturas - Listado</title>
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
 
            // -->
        </script>
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
                    "aaSorting": [[ 1, "asc" ]],
                    "aoColumns": [
			null,
			{ "sType": 'string' },
			{ "sType": 'string' },
			{ "sType": 'string' },
			{ "sType": 'string' },
			{ "sType": 'string' },
			{ "sType": 'string' },
			{ "sType": 'string' },
			null
                    ],                    
                    "bJQueryUI":true
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

function contabilizar(){
    //comprobamos que este alguna factura seleccionada
    var hayFactura='false';
    $('#datatablesMod').find(":checkbox").each(function(){
        var elemento=this;
        if(elemento.checked===true){
            hayFactura='true';
        }
    });
    
    if(hayFactura==='true'){
        alert('Comienza el proceso de contabilizar facturas.');
        document.getElementById("cmdContabilizar").value = "Procensando...";
        document.getElementById("cmdContabilizar").disabled = true;
        document.form2.submit();
    }else{
        alert('No hay seleccionada ninguna factura.');
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
<table align="center" border="0">
    <tr>
        <td>

<h3 align="center" color="#FFCC66"><font size="3px">Facturas pendientes de Contabilizar</font></h3> 
<form name="form1" action="../vista/contabilizar_facturas.php" method="get">
    <table align="center" border="0" width="954">
        <tr></tr>
        <tr><td>
    <label class="filtroTexto" align="center" onclick="onOff_filtro(document.getElementById('filtros'));">Filtros</label> 
    <div id="filtros" style="display: none;">
    <table class="filtro" align="center" border="0" width="945">
    <tr> 
      <td class="nombreCampo" rowspan="2" width="150"><div align="right"><I>Fecha:</I></div></td>
      <td class="nombreCampo" width="80"><div align="right">Desde:</div></td>
      <?php
      datepicker_español('datFechaInicio');
      datepicker_español('datFechaFin');
      ?>
      <td width="90">
          <input class="textbox1" type="text" name="datFechaInicio" id="datFechaInicio" size="12" maxlength="38" value="<?php if(isset($_GET['datFechaInicio'])){echo $_GET['datFechaInicio'];}?>"
               onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
               onKeyUp="this.value=formateafechaEntrada(this.value);" 
               onfocus="onFocusInputText(this);" onchange="copiarFin(this,document.form1.datFechaFin);"
               onblur="onBlurInputText(this);comprobarVacioFecha(this,'<?php echo $fechaForm;?>');"
               />
      </td>
      <td class="nombreCampo" rowspan="2" colspan="2" width="81" nowrap>
          <font color="#FF0000">(dd/mm/yyyy)</font>
      </td>
      <td></td>
    </tr>
    <tr> 
      <td class="nombreCampo"> <div align="right">Hasta:</div></td>
      <td>
          <input class="textbox1" type="text" name="datFechaFin" id="datFechaFin" size="12" maxlength="38" value="<?php if(isset($_GET['datFechaFin'])){echo $_GET['datFechaFin'];}else{echo date('d/m/Y');}?>"
                 onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                 onKeyUp="this.value=formateafechaEntrada(this.value);" 
                 onfocus="onFocusInputText(this);"
                 onblur="onBlurInputText(this);comprobarVacioFecha(this,'<?php echo $fechaForm;?>');"
                 />
      </td>
      <td class="nombreCampo"> <div align="right">Periodo:</div></td>
      <td colspan="2">
          <div align="right">
              <select name="lngPeriodo" class="textbox1"
                      onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);">
                    <option value= "" <?php if(isset($_GET['lngPeriodo']) && $_GET['lngPeriodo']===''){echo 'selected';}?>></option>  
                    <option VALUE = "1" <?php if(isset($_GET['lngPeriodo']) && $_GET['lngPeriodo']==1){echo 'selected';} ?>>ENERO</option>
                    <option VALUE = "2" <?php if(isset($_GET['lngPeriodo']) && $_GET['lngPeriodo']==2){echo 'selected';} ?>>FEBRERO</option>
                    <option VALUE = "3" <?php if(isset($_GET['lngPeriodo']) && $_GET['lngPeriodo']==3){echo 'selected';} ?>>MARZO</option>
                    <option VALUE = "4" <?php if(isset($_GET['lngPeriodo']) && $_GET['lngPeriodo']==4){echo 'selected';} ?>>ABRIL</option>
                    <option VALUE = "5" <?php if(isset($_GET['lngPeriodo']) && $_GET['lngPeriodo']==5){echo 'selected';} ?>>MAYO</option>
                    <option VALUE = "6" <?php if(isset($_GET['lngPeriodo']) && $_GET['lngPeriodo']==6){echo 'selected';} ?>>JUNIO</option>
                    <option VALUE = "7" <?php if(isset($_GET['lngPeriodo']) && $_GET['lngPeriodo']==7){echo 'selected';} ?>>JULIO</option>
                    <option VALUE = "8" <?php if(isset($_GET['lngPeriodo']) && $_GET['lngPeriodo']==8){echo 'selected';} ?>>AGOSTO</option>
                    <option VALUE = "9" <?php if(isset($_GET['lngPeriodo']) && $_GET['lngPeriodo']==9){echo 'selected';} ?>>SEPTIEMBRE</option>
                    <option VALUE = "10" <?php if(isset($_GET['lngPeriodo']) && $_GET['lngPeriodo']==10){echo 'selected';} ?>>OCTUBRE</option>
                    <option VALUE = "11" <?php if(isset($_GET['lngPeriodo']) && $_GET['lngPeriodo']==11){echo 'selected';} ?>>NOVIEMBRE</option>
                    <option VALUE = "12" <?php if(isset($_GET['lngPeriodo']) && $_GET['lngPeriodo']==12){echo 'selected';} ?>>DICIEMBRE</option>
              </select>
          </div>
      </td>
    </tr>
      <td class="nombreCampo" rowspan="2" width="150"><div align="right"><I>Nº Factura:</I></div></td>
      <td class="nombreCampo" width="80"><div align="right">Desde:</div></td>
      <td width="90">
          <input class="textbox1" type="text" name="strNFacturaIni" size="12" maxlength="38" value="<?php if(isset($_GET['strNFacturaIni'])){echo $_GET['strNFacturaIni'];}?>"
               onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
               onfocus="onFocusInputText(this);" onchange="copiarFin(this,document.form1.strNFacturaFin);" 
               onblur="onBlurInputText(this);"
               />
      </td>
      <td class="nombreCampo" rowspan="2" colspan="2" width="81" nowrap>
<?php
//vamos a comprobar el tipo de contador para presentar en rojo la forma de escribir el numero de factura
$tipoContador=$clsCNContabilidad->Parametro_general('Tipo Contador',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));

switch ($tipoContador) {
    case 'simple':
        $txtFormato='(numero)';
        break;
    case 'compuesto1':
        $txtFormato='(numero/ejercicio)';
        break;
    case 'compuesto2':
        $txtFormato='(ejercicio/numero)';
        break;
    default://ningun contador
        $txtFormato='(numero)';
        break;
}

?>          
          <font color="#FF0000"><?php echo $txtFormato; ?></font>
      </td>
      <td></td>
    </tr>
    <tr> 
      <td class="nombreCampo"> <div align="right">Hasta:</div></td>
      <td>
          <input class="textbox1" type="text" name="strNFacturaFin" size="12" maxlength="38" value="<?php if(isset($_GET['strNFacturaFin'])){echo $_GET['strNFacturaFin'];} ?>"
                 onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                 onfocus="onFocusInputText(this);"
                 onblur="onBlurInputText(this);"
                 />
      </td>
      <td colspan="2">
          <div align="right">
          </div>
      </td>
    </tr>
    <tr> 
      <td width="150"></td>
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
    <tr></tr>
    </table>   
     </form>
        <div id="cargandoListado" width="954" align="center">
            <br><br><br><br>
            <img src="../images/cargar.gif" height="100" width="100" />
        </div>
            <?php
//            if(isset($_GET['cmdListar'])&&$_GET['cmdListar']=='OK'){
                //extraigo la consulta de esta tabla
                $arResult=$clsCNContabilidad->ListadoFacturasAContabilizar($_GET['datFechaInicio'],$_GET['datFechaFin']
                                                                           ,$_GET['lngPeriodo'],$_GET['strNFacturaIni'],$_GET['strNFacturaFin']);
                //print_r($arResult);die;
            ?>
            <script LANGUAGE="JavaScript"> 
                $('#cargandoListado').hide();
            </script>
            
<!--            <h3 align="center" color="#FFCC66"><font size="3px">Listado de Facturas</font></h3>-->
            
            <br/>
            <form name="form2" action="../vista/contabilizar_facturas_proceso.php" method="post">
            <table id="datatablesMod" class="display">
                <thead>
                    <tr>
                        <th width="5%"></th>
                        <th width="9%">Numero Factura</th>
                        <th width="9%">Numero Presupuesto</th>
                        <th width="36%">Cliente</th>
                        <th width="9%">&nbsp;&nbsp;&nbsp;&nbsp;Fecha&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th width="9%">Vencimiento</th>
                        <th width="9%">Importe</th>
                        <th width="9%">Estado</th>
                        <th width="5%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $tipoContador=$clsCNContabilidad->Parametro_general('Tipo Contador',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));

                    if(is_array($arResult)){
                        for ($i = 0; $i < count($arResult); $i++) {
//                            $ejercicio=substr($arResult[$i]['NumFactura'],0,4);
//                            $numero=substr($arResult[$i]['NumFactura'],4,4);
//        
//                            $numero4cifras=$numero;
//                            while(substr($numero,0,1)==='0'){
//                                $numero=substr($numero,1);
//                            }
                            
                            //ahora segun el tipo de contador presento el numero del presupuesto
//                            $numeroFactura='';
                            $numeroFactura = numeroDesformateado($arResult[$i]['NumFactura'],$tipoContador);
//                            switch ($tipoContador) {
//                                case 'simple':
//                                    $numeroFactura=$arResult[$i]['NumFactura'];
//                                    break;
//                                case 'compuesto1':
//                                    $numeroFactura=$numero.'/'.$ejercicio;
//                                    break;
//                                case 'compuesto2':
//                                    $numeroFactura=$ejercicio.'/'.$numero;
//                                    break;
//                                default://ningun contador
//                                    $numeroFactura=$arResult[$i]['NumFactura'];
//                                    break;
//                            }
                            
                            //preparo el importe en texto y sin decimales, y una cifra de 20 digitos, asi puedo ordenarlo bien por importe
                            $importeTxt=$arResult[$i]['totalImporte']*100;
                            while(strlen($importeTxt)<20){
                                $importeTxt='0'.$importeTxt;
                            }

                            if($arResult[$i]['NumPresupuesto']<>'0'){
//                                $ejercicio=substr($arResult[$i]['NumPresupuesto'],0,4);
//                                $numero=substr($arResult[$i]['NumPresupuesto'],4,4);
//
//                                $numero4cifras=$numero;
//                                while(substr($numero,0,1)==='0'){
//                                    $numero=substr($numero,1);
//                                }

                                //ahora segun el tipo de contador presento el numero del presupuesto
                                $numeroPresupuesto = numeroDesformateado($arResult[$i]['NumPresupuesto'],$tipoContador);
//                                switch ($tipoContador) {
//                                    case 'simple':
//                                        $numeroPresupuesto=$arResult[$i]['NumPresupuesto'];
//                                        break;
//                                    case 'compuesto1':
//                                        $numeroPresupuesto=$numero.'/'.$ejercicio;
//                                        break;
//                                    case 'compuesto2':
//                                        $numeroPresupuesto=$ejercicio.'/'.$numero;
//                                        break;
//                                    default://ningun contador
//                                        $numeroPresupuesto=$arResult[$i]['NumPresupuesto'];
//                                        break;
//                                }
                            }else{
                                $numeroPresupuesto='';
                            }
                            
                            //preparo la fecha para que salga ordenada
                            $fechaFactura = explode('/',$arResult[$i]['FechaFactura']);
                            $fechaFactura = $fechaFactura[2].$fechaFactura[1].$fechaFactura[0];
                            
                            //preparo la fecha para que salga ordenada
                            $FechaVtoFactura = explode('/',$arResult[$i]['FechaVtoFactura']);
                            $FechaVtoFactura = $FechaVtoFactura[2].$FechaVtoFactura[1].$FechaVtoFactura[0];
                            
                            
                            //preparo el array de $arResult[$i] para enviar por url
                            //$link="javascript:document.location.href='../vista/altafactura.php?IdFactura=".$arResult[$i]['IdFactura']."';";
                            $link="";
                            ?>
                            <tr>
                                <td onClick="<?php echo $link; ?>"><input type="checkbox" id="check<?php echo $arResult[$i]['IdFactura']; ?>" name="id<?php echo $arResult[$i]['IdFactura']; ?>" class="nombreCampo" /></td>
                                <td onClick="<?php echo $link; ?>"><?php echo "<!-- ".$arResult[$i]['NumFactura']." -->".$numeroFactura; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo "<!-- ".$arResult[$i]['NumPresupuesto']." -->".$numeroPresupuesto; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['nombreContacto']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo "<!-- ".$fechaFactura." -->".$arResult[$i]['FechaFactura']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo "<!-- ".$FechaVtoFactura." -->".$arResult[$i]['FechaVtoFactura']; ?></td>
                                <td align="right" onClick="<?php echo $link; ?>"><?php echo "<!-- $importeTxt -->".formateaNumeroContabilidad($arResult[$i]['totalImporte']); ?></td>
                                <td><?php echo $arResult[$i]['Estado']; ?></td>
                                <td align="center"><?php echo '<a href="javascript:verCuentas('.$arResult[$i]['IdFactura'] . ');"><img src="../images/cal.png" width="14" height="14" border="0"/></a>'; ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
            <script>
            function verCuentas(idFactura) 
            {
              window.open ("../vista/facturaCuentas.php?IdFactura="+idFactura,"nueva","resizable=yes, scrollbars=yes, width=650,height=450");
            }
            </script>
            <table align="center" border="0" width="954">
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
                            <input class="button" type="button" id="cmdContabilizar" value="Contabilizar" onclick="contabilizar();" />
                        </td>
                    </tr>
                <tbody>
            </table>
            </form>

            <br/><br/><br/>
            <?php include '../vista/IndicacionIncidencia.php'; ?>
        </td>
        </tr>
        </table>
    </body>
</html>
