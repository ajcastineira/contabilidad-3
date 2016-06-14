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


logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
       " ||||Mis Presupuestos->Modificación/Baja||");

date_default_timezone_set('Europe/Madrid');
$fechaForm=date('d/m/Y');

$fechaUltimaFactura = $clsCNContabilidad->fechaUltimaFactura();

$arResult = $clsCNContabilidad->ListadoPedidosAFacturar($_GET['strNomContacto'],$_GET['estado'],$_GET['filtroFecha']);
//var_dump($arResult);die;
$tipoContador = $clsCNContabilidad->Parametro_general('Tipo Contador',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));


//aqui dirijo a la presentacion en PC o Movil (APP)
if($_SESSION['navegacion']==='movil'){
    html_paginaMovil($arResult,$tipoContador,$fechaUltimaFactura);
}else{
    html_pagina($arResult,$tipoContador,$fechaUltimaFactura);
}



function funciones_auxiliares(){
?>    
<script type="text/javascript">
function indicarAccion(objeto,IdPedido){
    if(objeto.checked === true){
        document.getElementById('accionTxt'+IdPedido).style.display = "block";
    }else{
        document.getElementById('accionTxt'+IdPedido).style.display = "none";
        //desactivo el radio
        document.getElementById('programada'+IdPedido).checked = false;
        document.getElementById('hoy'+IdPedido).checked = false;
    }
}


function generarTarea(){
    //veo los check seleccionados y los guardo en un array
    //y ahora guardo todos los check marcados (:checked)
    var checkON = 0;
    var pedido = [];
    var fechaHoy = [];
    $("input[type='radio']:checked").each(function(){
        var elemento=this;
        if(elemento.checked===true){
            pedido[checkON]=elemento.name;
            //ahora guardo la fecha
            var IdPedido = elemento.name.substring(6);
            var fecha = document.getElementById('fhoy'+IdPedido).value;
            fechaHoy[checkON] = fecha;
            checkON++;
            //cambio el estado checked a false, para que no se seleccione por defecto a la proxima vez
            elemento.checked = false;
        }
    });

    if(pedido.length === 0){
        //error
        alert('No hay seleccionado ningún pedido.');
    }else{
        alert('Se van a generar la/s facturas seleccionadas');

        //se van a generar las facturas mediante AJAX
        for(var i=0; i<pedido.length; i++){
            facturarPedido(pedido[i],fechaHoy[i]);
        } 
    }
}

function facturarPedido(IdPedido,fechaHoy){
    var pedido = IdPedido.substring(6);
    //se desactiva el boton
    document.getElementById("cmdTarea").value = "Generando Tarea...";
    document.getElementById("cmdTarea").disabled = true;

    $.ajax({
        data:{"IdPedido":pedido,"fechaHoy":fechaHoy},  
        url: '../vista/facturarPedidoAJAX.php',
        async: false,
        type:"get",
        success: function(data) {
            document.getElementById('accionRespuesta'+pedido).style.display = "block";
            document.getElementById('accionTxt'+pedido).style.display = "none";
            if(data.trim() === "NO"){
                //no se ha hecho, se deja el texto que hay
                $('#accionRespuestaTxt'+pedido).html('HA FALLADO, volver a intentarlo');
            }else{
                $('#accionRespuestaTxt'+pedido).html(data);
                $('#facturaTxt'+pedido).html("<div align='center'><strong>Terminado</strong></div>");
            }
        }
    });

    //se vuelve a activar el boton
    document.getElementById("cmdTarea").value = "Generar Tarea";
    document.getElementById("cmdTarea").disabled = false;
}

function verFacturas(IdPedido){
    window.open ("../vista/facturasPedido.php?IdPedido="+IdPedido,"nueva","resizable=yes, scrollbars=yes, width=400,height=450");
}


function activarFecha(IdPedido){
    if(document.getElementById('hoy'+IdPedido).checked === true){
        $('#fhoy'+IdPedido).prop('disabled', false);
        var d = new Date();
        var mes = d.getMonth()+1;
        if(mes < 10){
            mes = '0' + mes;
        }
        var strDate = d.getDate() + "/" + mes + "/" + d.getFullYear();
        document.getElementById('fhoy'+IdPedido).value = strDate;
    }else{
        $('#fhoy'+IdPedido).prop('disabled', true);
        document.getElementById('fhoy'+IdPedido).value = '';
    }
}

</script>



<?php    
}





function html_pagina($arResult,$tipoContador,$fechaUltimaFactura){
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="../images/q.ico">
        <title>Generar Facturas de Pedidos</title>
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
                    "aaSorting": [[ 2, "asc" ]],
                    "aoColumns": [
			{ "sType": 'string' },
			{ "sType": 'string' },
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
    
    <?php funciones_auxiliares(); ?>
    
    </head>
    <body>
    <?php require_once '../vista/cabecera2.php'; ?>
<table align="center">
    <tr>
        <td>

<h3 align="center" color="#FFCC66"><font size="3px">Generar Facturas de Pedidos</font></h3> 
<form name="form1" action="../vista/facturar_pedido.php" method="get">
    <table align="center" border="0" width="954">
        <tr></tr>
        <tr><td>
    <label class="filtroTexto" align="center" onclick="onOff_filtro(document.getElementById('filtros'));">Filtros</label> 
    <div id="filtros" style="display: none;">
    <table class="filtro" align="center" border="0" width="945">
    <tr>
        <td width="12%"></td>
        <td width="21%"></td>
        <td width="12%"></td>
        <td width="22%"></td>
        <td width="12%"></td>
        <td width="21%"></td>
    </tr>    
    <tr> 
      <td class="nombreCampo"><div align="right">Cliente:</div></td>
      <td>
          <div align="right">
              <input class="textbox1" style="width:100%" type="text" name="strNomContacto" maxlength="150" value="<?php if(isset($_GET['strNomContacto'])){echo $_GET['strNomContacto'];}?>"
                                    onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"  onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
          </div>
      </td>
      <td class="nombreCampo"><div align="right">Estado:</div></td>
      <td>
          <div align="left">
            <select name="estado" class="textbox1" tabindex="5">
                <option value=""></option>
                <option value="Aceptado" <?php if($_GET['estado']==='Aceptado'){echo 'selected';}?>>Aceptado</option>
                <option value="Cancelado" <?php if($_GET['estado']==='Cancelado'){echo 'selected';}?>>Cancelado</option>
            </select>
          </div>
      </td>
      <td class="nombreCampo"><div align="right">Fecha:</div></td>
      <td>
          <div align="left">
            <select name="filtroFecha" class="textbox1" tabindex="6">
                <option value="30dias" selected>30 próximos días</option>
                <option value="todos">Todos</option>
            </select>
          </div>
      </td>
    </tr>
    
    <tr> 
      <td colspan="8"><hr align="left"></td>
    </tr>
     <tr align="center">
         <td colspan="8">
             <input type="Reset" class="button" value="Vaciar Datos" name="cmdReset" />
             <input type="submit" class="button" value="Consultar" name="cmdConsultar" />
             <input name="cmdListar" type="hidden" value="OK"/>
         </td>
     </tr>
     </table>
    </div>
    </td></tr>
    <tr></tr>
    </table>   
     </form>
    
            <br/>
            <table id="datatablesMod" class="display">
                <thead>
                    <tr>
                        <th width="5%">Numero Pedido</th>
                        <th width="22%">Cliente</th>
                        <th width="6%">Fecha &nbsp;&nbsp;Próxima&nbsp;&nbsp; Factura</th>
                        <th width="6%">Importe</th>
                        <th width="13%">Facturar</th>
                        <th width="44%">Acción a realizar</th>
                        <th width="4%">Fact. Ant.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(is_array($arResult)){
                        for ($i = 0; $i < count($arResult); $i++) {
                            //los que no vengan con accion=Terminado y Estado=Aceptado
                            if(isset($arResult[$i]['accion']) && $arResult[$i]['accion'] !== 'Terminado' && $arResult[$i]['Estado'] === 'Aceptado'){
                                $ejercicio=substr($arResult[$i]['NumPedido'],0,4);
                                $numero=substr($arResult[$i]['NumPedido'],4,4);

                                $numero4cifras=$numero;
                                while(substr($numero,0,1)==='0'){
                                    $numero=substr($numero,1);
                                }

                                //ahora segun el tipo de contador presento el numero del pedido
                                $numeroPedido = numeroDesformateado($arResult[$i]['NumPedido'],$tipoContador);

                                //preparo el importe en texto y sin decimales, y una cifra de 20 digitos, asi puedo ordenarlo bien por importe
                                $importeTxt=$arResult[$i]['totalImporte']*100;
                                while(strlen($importeTxt)<20){
                                    $importeTxt='0'.$importeTxt;
                                }

                                $link="";

                                //fecha para ordenar
                                $fecha = explode('/',$arResult[$i]['FechaProximaFacturaPeriodica']);
                                $fechaTxt = $fecha[2].$fecha[1].$fecha[0];
                                
                                $fechaDATETIME = fecha_to_DATETIME($arResult[$i]['FechaProximaFacturaPeriodica']);
                                
                                //ahora vamos a ver si esta fecha esta fuera de plazo, esta dentro de los 5 dias a hoy de plazo, o a mas de 5 dias 
                                $hoy = date("Y-n-j H:i:s");
                                
                                $dif = strtotime($fechaDATETIME) - strtotime($hoy);
                                
                                // 5 dias en segundos = 5 x 24 x 60 x 60 = 432000 segundos/5 dia
                                // si es negativo se a pasado el plazo
                                // como el dia de hoy tambien cuenta como plazo se suma 86400 a $dif
                                $dif= $dif + 86400;
                                if($dif < 0){
                                    //estamos fuera de plazo, color rojo
                                    $color = '#ffaf87';
                                }else
                                if($dif >= 0 && $dif < 432000){
                                    //estamos en los ultimos cinco dias, color amarillo
                                    $color = '#f4ff5b';
                                }else{
                                    //el resto, estamos por encima de los cinco dias
                                    $color = '';
                                }
                                
                                if($color ===''){
                                    $style = '';
                                }else{
                                    $style = "background:$color;";
                                }
                                
                                ?>
                                <tr>
                                    <td onClick="<?php echo $link; ?>"><?php echo "<!-- ".$arResult[$i]['NumPedido']." -->".$numeroPedido; ?></td>
                                    <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['nombreContacto']; ?></td>
                                    <td style="<?php echo $style;?>" onClick="<?php echo $link; ?>"><?php echo "<!-- $fechaTxt -->".$arResult[$i]['FechaProximaFacturaPeriodica']; ?></td>
                                    <td align="right" onClick="<?php echo $link; ?>"><?php echo "<!-- $importeTxt -->".formateaNumeroContabilidad($arResult[$i]['totalImporte']); ?></td>
                                    <td align="right" onClick="<?php echo $link; ?>">
                                        <span id="facturaTxt<?php echo $arResult[$i]['IdPedido']; ?>"><?php echo $arResult[$i]['accion']; ?></span>
                                    </td>
                                    <td onClick="<?php echo $link; ?>">
                                        <div id="accionTxt<?php echo $arResult[$i]['IdPedido']; ?>" style="display: none;">
                                            <table><tr><td><font color='#ed0000'><input type='radio' id='programada<?php echo $arResult[$i]['IdPedido']; ?>' name='pedido<?php echo $arResult[$i]['IdPedido']; ?>' onchange="activarFecha('<?php echo $arResult[$i]['IdPedido']; ?>');comprobarFechaFactura('<?php echo $arResult[$i]['FechaProximaFacturaPeriodica']; ?>','<?php echo $fechaUltimaFactura; ?>');" />Fecha Programada &nbsp;|<input type='radio' id='hoy<?php echo $arResult[$i]['IdPedido']; ?>' name='pedido<?php echo $arResult[$i]['IdPedido']; ?>' onchange="activarFecha('<?php echo $arResult[$i]['IdPedido']; ?>');" />Fecha de hoy</font></td><td width='70px'><input type='text' class='textbox1' id='fhoy<?php echo $arResult[$i]['IdPedido']; ?>' name='fhoy<?php echo $arResult[$i]['IdPedido']; ?>' value='' onKeyUp='this.value=formateafechaEntrada(this.value);' style='text-align: right;' disabled /></td></tr></table>
                                        </div>
                                        <?php
                                        datepicker_español('fhoy'.$arResult[$i]['IdPedido']);
                                        ?>
                                        <script>
                                        $('#fhoy<?php echo $arResult[$i]['IdPedido']; ?>').datepicker({
                                            onSelect: function(fSeleccionada) {
                                                var fechaUltimaFactura = '<?php echo $fechaUltimaFactura; ?>';
                                                var fechaSeleccionada = fSeleccionada.split('/');
                                                fechaSeleccionada = fechaSeleccionada[2]+'-'+fechaSeleccionada[1]+'-'+fechaSeleccionada[0];

                                                if(Date.parse(fechaSeleccionada) < Date.parse(fechaUltimaFactura)){
                                                    var fechaU = fechaUltimaFactura.split('-');
                                                    alert ('Existe alguna factura con fecha posterior a la indicada.\nLa fecha de la última factura emitida es '+fechaU[2]+'/'+fechaU[1]+'/'+fechaU[0]);
                                                }
                                            }
                                        });
                                        </script>
                                        <div id="accionRespuesta<?php echo $arResult[$i]['IdPedido']; ?>" style="display: none;">
                                            <span id="accionRespuestaTxt<?php echo $arResult[$i]['IdPedido']; ?>"></span>
                                        </div>
                                    </td>
                                    <td align="center"><?php echo '<a href="javascript:verFacturas('.$arResult[$i]['IdPedido'] . ');"><img src="../images/cal.png" width="14" height="14" border="0"/></a>'; ?></td>
                                </tr>
                                <?php
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>
            
            <table align="center" border="0" width="945">
                <tr> 
                    <td>
                        <input type="button" class="button" value="Generar Tarea" id="cmdTarea" name="cmdTarea" onclick="generarTarea();" />
                    </td> 
                    <td width="50px">
                        <table border="0">
                            <tr>
                                <td style="background: #F4FF5B;width: 50px; height: 20px;"></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <label class="nombreCampo">Queda menos de 5 días para generar la factura</label>
                    </td>
                </tr>
                <tr> 
                    <td>
                    </td> 
                    <td width="50px">
                        <table border="0">
                            <tr>
                                <td style="background: #ffaf87;width: 50px; height: 20px;"></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <label class="nombreCampo">Esta fuera de plazo para generar la factura</label>
                    </td>
                </tr>
            </table>
            <br/><br/>
            
            <?php include '../vista/IndicacionIncidencia.php'; ?>
        </td>
        </tr>
        </table>
    </body>
</html>
<?php
}

function html_paginaMovil($arResult,$tipoContador,$fechaUltimaFactura){
?>    
<!DOCTYPE html>
<html>
<head>
<TITLE>Listado de Facturas</TITLE>

<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
funciones_auxiliares();
?>
<script type="text/javascript">
function indicarAccionMovil(IdPedido){
    $('#accionTxt'+IdPedido).toggle('500');
}
</script>
</head> 
    <body>
    <div data-role="page" id="facturar_pedido">
<?php
eventosInputText();
?>

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>
        
    <div data-role="content" data-theme="a">
        <h3 align="center" color="#FFCC66"><font size="3px">Generar Facturas de Pedidos</font></h3>
        <br/>
        
        <table border="0" style="width: 100%;">
            <tbody>
                <tr>
                    <td style="width: 15%;"></td>
                    <td style="width: 85%;"></td>
                </tr>
                <tr>
                    <td>
                        <label><font style="background: #f4ff5b;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></label>
                    </td>
                    <td>
                        <label>Queda menos de 5 días para generar la factura</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label><font style="background: #ffaf87;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></label>
                    </td>
                    <td>
                        <label>Esta fuera de plazo para generar la factura</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="button" id="cmdTarea" 
                               value="Generar Tarea" name="cmdTarea" 
                               data-icon="star" data-iconpos="right" data-theme="a"
                               onclick="generarTarea();" />
                    </td>
                </tr>
            </tbody>
        </table>
        
        <br/>
        
        
        <ul data-role="listview" data-dividertheme="a" data-filter="true" data-filter-placeHolder="Buscar">
            <?php
            if(is_array($arResult)){
                for ($i = 0; $i < count($arResult); $i++) {
                    //los que no vengan con accion=Terminado y Estado=Aceptado
                    if(isset($arResult[$i]['accion']) && $arResult[$i]['accion'] !== 'Terminado' && $arResult[$i]['Estado'] === 'Aceptado'){
                        $ejercicio=substr($arResult[$i]['NumPedido'],0,4);
                        $numero=substr($arResult[$i]['NumPedido'],4,4);

                        $numero4cifras=$numero;
                        while(substr($numero,0,1)==='0'){
                            $numero=substr($numero,1);
                        }

                        //ahora segun el tipo de contador presento el numero del pedido
                        $numeroPedido = numeroDesformateado($arResult[$i]['NumPedido'],$tipoContador);

                        //preparo el importe en texto y sin decimales, y una cifra de 20 digitos, asi puedo ordenarlo bien por importe
                        $importeTxt=$arResult[$i]['totalImporte']*100;
                        while(strlen($importeTxt)<20){
                            $importeTxt='0'.$importeTxt;
                        }

                        $link="";

                        //fecha para ordenar
                        $fecha = explode('/',$arResult[$i]['FechaProximaFacturaPeriodica']);
                        $fechaTxt = $fecha[2].$fecha[1].$fecha[0];

                        $fechaDATETIME = fecha_to_DATETIME($arResult[$i]['FechaProximaFacturaPeriodica']);

                        //ahora vamos a ver si esta fecha esta fuera de plazo, esta dentro de los 5 dias a hoy de plazo, o a mas de 5 dias 
                        $hoy = date("Y-n-j H:i:s");

                        $dif = strtotime($fechaDATETIME) - strtotime($hoy);

                        // 5 dias en segundos = 5 x 24 x 60 x 60 = 432000 segundos/5 dia
                        // si es negativo se a pasado el plazo
                        // como el dia de hoy tambien cuenta como plazo se suma 86400 a $dif
                        $dif= $dif + 86400;
                        if($dif < 0){
                            //estamos fuera de plazo, color rojo
                            $color = '#ffaf87';
                        }else
                        if($dif >= 0 && $dif < 432000){
                            //estamos en los ultimos cinco dias, color amarillo
                            $color = '#f4ff5b';
                        }else{
                            //el resto, estamos por encima de los cinco dias
                            $color = '';
                        }

                        if($color ===''){
                            $style = '';
                        }else{
                            $style = "background:$color;";
                        }
                    
                        ?>
                        <li onClick="<?php echo $link; ?>">
                            <a href="#" data-ajax="false">
                                <style>
                                .checkBoxLeft{
                                    position: absolute; 
                                    right: 1px; 
                                    top: 40%;
                                }
                                input[type=checkbox]
                                {
                                  /* Double-sized Checkboxes */
                                  -ms-transform: scale(2); /* IE */
                                  -moz-transform: scale(2); /* FF */
                                  -webkit-transform: scale(2); /* Safari and Chrome */
                                  -o-transform: scale(2); /* Opera */
                                  padding: 15px;
                                }
                                </style>    
                                <?php echo '<font color="30a53b">Número: </font>'."<!-- ".$arResult[$i]['NumPedido']." -->".$numeroPedido. '   <font color="3ba5ba">'.$arResult[$i]['FechaProximaFacturaPeriodica'].'</font>   <font style="'. $style . '">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font><br/>'; ?>
                                <?php echo '<font color="30a53b">Cliente: </font><br/>'; ?>
                                <?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$arResult[$i]['nombreContacto'].'<br/>'; ?>
                                <?php echo '<font color="30a53b">Importe: </font>'."<!-- $importeTxt -->".formateaNumeroContabilidad($arResult[$i]['totalImporte']).'<br/>'; ?>
                                <?php 
                                //veo si $arResult[$i]['accion'] es Periodica o Puntual
                                if(strpos($arResult[$i]['accion'],'Periodica') !== false){
                                    $txtTipoFactura = 'Periodica';
                                }else{
                                    $txtTipoFactura = 'Puntual';
                                }
                                
                                ?>
                                <font color="30a53b">Factura: </font><?php echo $txtTipoFactura; ?>
                                <br/><br/>
                                <span id="facturaTxt<?php echo $arResult[$i]['IdPedido']; ?>">
                                    <input data-mini="true" type="button" id="cmdTarea" value="Facturar" name="cmdTarea" onclick="indicarAccionMovil(<?php echo $arResult[$i]['IdPedido']; ?>);" /><br/>
                                </span>
                                
                                <div id="accionTxt<?php echo $arResult[$i]['IdPedido']; ?>" style="display: none;">
                                    <fieldset data-role="controlgroup">
                                        <input type='radio' value="Fecha Programada" id='programada<?php echo $arResult[$i]['IdPedido']; ?>' name='pedido<?php echo $arResult[$i]['IdPedido']; ?>' onchange="activarFecha('<?php echo $arResult[$i]['IdPedido']; ?>');comprobarFechaFactura('<?php echo $arResult[$i]['FechaProximaFacturaPeriodica']; ?>','<?php echo $fechaUltimaFactura; ?>');" />
                                        <label for="programada<?php echo $arResult[$i]['IdPedido']; ?>">Fecha Programada</label>
                                        <input type='radio' value="Fecha de hoy" id='hoy<?php echo $arResult[$i]['IdPedido']; ?>' name='pedido<?php echo $arResult[$i]['IdPedido']; ?>' onchange="activarFecha('<?php echo $arResult[$i]['IdPedido']; ?>');" />
                                        <label for="hoy<?php echo $arResult[$i]['IdPedido']; ?>">Fecha de hoy</label>
                                    </fieldset>
                                    <div class="ui-grid-c">
                                        <input type='text' id='fhoy<?php echo $arResult[$i]['IdPedido']; ?>' name='fhoy<?php echo $arResult[$i]['IdPedido']; ?>' value='' onKeyUp='this.value=formateafechaEntrada(this.value);' style='text-align: right;' />
                                    </div>
                                </div>
                                <?php
                                datepicker_español('fhoy'.$arResult[$i]['IdPedido']);
                                ?>
                                <script>
                                $('#fhoy<?php echo $arResult[$i]['IdPedido']; ?>').datepicker({
                                    onSelect: function(fSeleccionada) {
                                        var fechaUltimaFactura = '<?php echo $fechaUltimaFactura; ?>';
                                        var fechaSeleccionada = fSeleccionada.split('/');
                                        fechaSeleccionada = fechaSeleccionada[2]+'-'+fechaSeleccionada[1]+'-'+fechaSeleccionada[0];

                                        if(Date.parse(fechaSeleccionada) < Date.parse(fechaUltimaFactura)){
                                            var fechaU = fechaUltimaFactura.split('-');
                                            alert ('Existe alguna factura con fecha posterior a la indicada.\nLa fecha de la última factura emitida es '+fechaU[2]+'/'+fechaU[1]+'/'+fechaU[0]);
                                        }
                                    }
                                });
                                </script>
                                <div id="accionRespuesta<?php echo $arResult[$i]['IdPedido']; ?>" style="display: none;">
                                    <label><span id="accionRespuestaTxt<?php echo $arResult[$i]['IdPedido']; ?>"></span></label>
                                </div>
                            </a>
                        </li>
                        <?php
                    }
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
<?php    
}
?>