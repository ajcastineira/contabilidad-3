<?php
session_start();
require_once '../general/funcionesGenerales.php';
require_once '../CN/clsCNContabilidad.php';


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



$clsCNContabilidad=new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['mapeo']);


Const ANCHO=950;

//comprobamos fecha
if(isset($_POST['datFecha'])){
    $fechaForm=$_POST['datFecha'];
}
//sino venimos de submitirnos sacamos la fecha de hoy
else{
    date_default_timezone_set('Europe/Madrid');
    $fechaForm=date('d/m/Y');
}

//funcion para calcular ingresos, gastos y resultado
function calculoResultados($resultados,&$ingresos,&$gastos,&$resultadoFinal){
    //calculos los ingresos y gastos y extraigo el resultado (ingreso-gasto)
    //recorro el array y voy guardando los valores
    $ingresos=0;
    if(is_array($resultados['ingresos'])){
        for($i=0;$i<count($resultados['ingresos']);$i++){
            $ingresos=$ingresos+$resultados['ingresos'][$i]['cantidad'];
        }
    }
    $gastos=0;
    if(is_array($resultados['gastos'])){
        for($i=0;$i<count($resultados['gastos']);$i++){
            $gastos=$gastos+$resultados['gastos'][$i]['cantidad'];
        }
    }
    $resultadoFinal=$ingresos-$gastos;
}

function resultadosPresentar($resultados){
    $ingresos=-$resultados['ingresosTotal'];
    $gastos=$resultados['gastosTotal'];
    $resultadoFinal=$ingresos-$gastos;
    
    //calculoResultados($resultados,$ingresos,$gastos,$resultadoFinal);
    
?>    
<div align="center">
    <table class="tablaResultados" witdh="100%" border="0">
        <tr>
            <td height="20"></td>
        </tr>
        <tr style="color: #0063DC;">
            <th>
                <div align="left">
                Resultado
                </div>
            </th>
            <th>
                <div align="right">
                <?php echo formateaNumeroContabilidad($resultadoFinal); ?>
                </div>
            </th>
        </tr>
        <tr>
            <td height="20"></td>
        </tr>
        <tr>
            <td colspan="2" onClick="pulsar(document.getElementById('cuadroIngreso'),'ingresos');" class="tablaResultados_td">
                <div style="float: left;">
                    <strong>Ingresos</strong>
                </div>
                <div style="float: right;">
                    <strong><?php echo formateaNumeroContabilidad($ingresos); ?></strong>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan='2'>
                <div id='cuadroIngreso' style="display:none;">
                    <table width="100%">
                        <?php
                        if(is_array($resultados['ingresos'])){
                            for($j=0;$j<count($resultados['ingresos']);$j++){
                            ?>
                            <tr style="background-color: #EDF2F7;">
                                <td>
                                    <div style="float: left;">
                                    <?php echo substr($resultados['ingresos'][$j]['nombre'],0,26); ?>
                                    </div>
                                    <div style="float: right;">
                                    <?php echo formateaNumeroContabilidad($resultados['ingresos'][$j]['cantidad']); ?>
                                    </div>
                                </td>
                            </tr>
                            <?php
                            }
                        }
                        ?>
                    </table>
                </div>
            </td>
        </tr>
        <tr>
            <td height="10"></td>
        </tr>
        <tr>
            <td colspan="2" onClick="pulsar(document.getElementById('cuadroGastos'),'gastos');" class="tablaResultados_td">
                <div style="float: left;">
                    <strong>Gastos</strong>
                </div>
                <div style="float: right;">
                    <strong><?php echo formateaNumeroContabilidad($gastos); ?></strong>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan='2'>
                <div id='cuadroGastos' style="display:none;">
                    <table width="100%">
                        <?php
                        if(is_array($resultados['gastos'])){
                            for($j=0;$j<count($resultados['gastos']);$j++){
                            ?>
                            <tr style="background-color: #EDF2F7;">
                                <td>
                                    <div style="float: left;">
                                    <?php echo $resultados['gastos'][$j]['nombre']; ?>
                                    </div>
                                    <div style="float: right;">
                                    <?php echo formateaNumeroContabilidad($resultados['gastos'][$j]['cantidad']); ?>
                                    </div>
                                </td>
                            </tr>
                            <?php
                            }
                        }
                        ?>
                    </table>
                </div>
            </td>
        </tr>
        <tr>
            <td height="10"></td>
        </tr>
    </table>
</div>
<?php
}


function tesoreriaPresentar($tesoreria){
    //saco las sumas de caja y bancos
    $caja=$tesoreria['caja'];
    $bancos=$tesoreria['bancos'];
    $total=$caja+$bancos;
    
?>
<div align="center">
    <table class="tablaResultados" witdh="100%" border="0">
        <tr>
            <td height="20"></td>
        </tr>
        <tr style="color: #FF0000;">
            <th>
                <div align="left">
                Tesorería
                </div>
            </th>
            <th>
                <div align="right">
                <?php echo formateaNumeroContabilidad($total); ?>
                </div>
            </th>
        </tr>
        <tr>
            <td height="10"></td>
        </tr>
        <tr>
            <th>
                <div align="left">
                Caja
                </div>
            </th>
            <th>
                <div align="right">
                <?php echo formateaNumeroContabilidad($caja); ?>
                </div>
            </th>
        </tr>
        <tr>
            <td height="10"></td>
        </tr>
        <tr>
            <th>
                <div align="left">
                Bancos
                </div>
            </th>
            <th>
                <div align="right">
                <?php echo formateaNumeroContabilidad($bancos); ?>
                </div>
            </th>
        </tr>
        <tr>
            <td height="10"></td>
        </tr>
        <tr>
            <td height="10"></td>
        </tr>
    </table>
</div>

<?php
}

function impuestosPresentar($impuestos,$resultados,$alquileres,$pagos){
    require_once '../CN/clsCNContabilidad.php';
    $clsCNContabilidad=new clsCNContabilidad();
    $clsCNContabilidad->setStrBD($_SESSION['mapeo']);
    
    
    $ingresos=0;
    $gastos=0;
    $resultadoFinal=0;
    
    calculoResultados($resultados,$ingresos,$gastos,$resultadoFinal);
    
    //$cuota=$clsCNContabilidad->calcularCuota('Pagos Cuenta','01/01/2012','31/12/2020');//REVISAR FECHAS
    //$pagosCuenta=$cuota*$resultadoFinal;
//    if($pagosCuenta<0){
//        $pagosCuenta=0;
//    }
    
    
?>

<div align="center">
    <table class="tablaResultados" witdh="100%" border="0">
        <tr>
            <td height="20"></td>
        </tr>
        <tr style="color: green;">
            <th colspan="2">
                <div align="left">
                Impuestos a Pagar
                </div>
            </th>
        </tr>
        <tr>
            <td height="10"></td>
        </tr>
        <tr>
            <th>
                <div align="left">
                IVA
                </div>
            </th>
            <td>
                <table border="0">
                    <tr style="background-color: #baf3fc;text-align: center;">
                        <td>
                            Trimestre Anterior
                        </td>
                        <td>
                            Trimestre Actual
                        </td>
                    </tr>
                    <tr style="background-color: #baf3fc;text-align: center;">
                        <td>
                            <?php echo $impuestos['IVA']['TrimestreAnterior']; ?>
                        </td>
                        <td>
                            <?php echo $impuestos['IVA']['TrimestreActual']; ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">
            </td>
        </tr>
        <tr>
            <td height="10"></td>
        </tr>
        <tr>
            <th>
                <div align="left">
                IRPF
                </div>
            </th>
            <th>
                <div align="right">
                <?php //echo formateaNumeroContabilidad($impuestos['IRPF'][0]['cantidad']); ?>
                </div>
            </th>
        </tr>
        <tr>
            <td height="10"></td>
        </tr>
        <tr>
            <th>
                <div align="left">
                Alquileres 
                </div>
            </th>
            <th>
                <div align="right">
                <?php //echo formateaNumeroContabilidad($alquileresYPagosC['alquileres'][0]['cantidad']); ?>
                </div>
            </th>
        </tr>
        <tr>
            <td height="10"></td>
        </tr>
        <tr>
            <th>
                <div align="left">
                <?php echo $pagos['tituloPagos']; ?> 
                </div>
            </th>
            <td>
                <div align="right">
                <?php echo $pagos['tituloPagos']; ?>
                </div>
            </td>
        </tr>
        <tr>
            <td height="10"></td>
        </tr>
    </table>
</div>

<?php
}

function GraficaBarras($resultados){
    //calculos los ingresos y gastos y extraigo el resultado (ingreso-gasto)
    //recorro el array y voy guardando los valores
    $ingresos=0;
    if(is_array($resultados['ingresos'])){
        for($i=0;$i<count($resultados['ingresos']);$i++){
            $ingresos=$ingresos+$resultados['ingresos'][$i]['cantidad'];
        }
    }
    $gastos=0;
    if(is_array($resultados['gastos'])){
        for($i=0;$i<count($resultados['gastos']);$i++){
            $gastos=$gastos+$resultados['gastos'][$i]['cantidad'];
        }
    }
    
?>

<script type="text/javascript">
$(function () {
        $('#containerBarra').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Resultados'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: [
                    'Ingresos',
                    'Gastos'
                ]
            },
            yAxis: {
                min: 0,
                title: {
                    text: '(Euros)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                             '<td style="padding:0"><b>{point.y:.1f} Euros</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Ingresos',
                data: [<?php echo $ingresos; ?>]
    
            }, {
                name: 'Gastos',
                data: [<?php echo $gastos; ?>],
                color: '#FF777A'
            }]
        });
    });
</script>
                
<script src="../js/highcharts/highcharts.js"></script>
<!--<script src="http://code.highcharts.com/highcharts.js"></script>-->

<div id="containerBarra" style="min-width: 400px; height: 300px; margin: 0 0"></div>


<?php
}

function GraficaTarta2($resultados,$opcion){

?>
<!--<script type="text/javascript" src="../js/jQuery/query.min.chart.js"></script>-->
<script type="text/javascript">
$(function () {
    	
    	// Radialize the colors
		Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function(color) {
		    return {
		        radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
		        stops: [
		            [0, color],
		            [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
		        ]
		    };
		});
		
		// Build the chart
        $('#container<?php echo $opcion; ?>').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: '<?php echo $opcion; ?>'
            },
            tooltip: {
        	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ Math.round((this.percentage*10000)/10000) +' %';
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: ' ',
                data: [
                <?php
                if(is_array($resultados)){
                    //gamas de colores
                    $colores=array(
                        '01'=>'#0DA068',
                        '02'=>'#194E9C',
                        '03'=>'#ED9C13',
                        '04'=>'#ED5713',
                        '05'=>'#057249',
                        '06'=>'#497666'
                    );
                    
                    for($i=0;$i<count($resultados);$i++){
                    $color=($i % 6)+1;
                    switch ($color){
                        case 1:
                            $color=$colores['01'];
                            break;
                        case 2:
                            $color=$colores['02'];
                            break;
                        case 3:
                            $color=$colores['03'];
                            break;
                        case 4:
                            $color=$colores['04'];
                            break;
                        case 5:
                            $color=$colores['05'];
                            break;
                        case 6:
                            $color=$colores['06'];
                            break;
                    }
                    ?>
                    {color:'<?php echo $color; ?>',name:'<?php echo $resultados[$i]['nombre'];?>',y:<?php echo $resultados[$i]['cantidad'];?>},
                    <?php
                    }
                }
                ?>
                ]
            }]
        });
    });
    

		</script>
<script src="highcharts.js"></script>

<div id="container<?php echo $opcion; ?>" style="min-width: 750px; height: 400px; margin: 0 auto"></div>
    
<?php    
}

function CobrosPagosPendientesPresentar($CobrosPend,$opcion){
    require_once '../CN/clsCNContabilidad.php';
    $clsCNContabilidad=new clsCNContabilidad();
    $clsCNContabilidad->setStrBD($_SESSION['mapeo']);
    
    //calculo la suma total de los cobros o pagos
    $suma=0;
    if(is_array($CobrosPend)){
        for($i=0;$i<count($CobrosPend);$i++){
            $suma=$suma+$CobrosPend[$i]['diferencia'];
        }
    }
?>    
    
<div align="center">
    <table class="tablaResultados" witdh="100%" border="0">
    <tr>
        <td height="20"></td>
    </tr>
    <th>
        <div align="left">
        <?php echo $opcion; ?> Pendientes
        </div>
    </th>
    <th>
        <div align="right">
            <?php echo formateaNumeroContabilidad($suma); ?>
        </div>
    </th>
    <tr>
        <td height="15"></td>
    </tr>
    <?php
    if(is_array($CobrosPend)){
        for($j=0;$j<count($CobrosPend);$j++){
            if(($CobrosPend[$j]['diferencia']>0 && $opcion==='Cobros') || ($CobrosPend[$j]['diferencia']<0 && $opcion==='Pagos')){
                //preparo los parametros de la cuenta
                $cuenta=$clsCNContabilidad->DatosCuentaParaResultados($CobrosPend[$j]);
                $cuenta= serialize($cuenta);
                $cuenta = urlencode($cuenta);

                $parametrosBusqueda=array("Periodo"=>null,
                                          "Ejercicio"=>null,
                                          "FechaInicio"=>null,
                                          "FechaFin"=>null,
                                          "Opcion"=>null,
                                          "Cantidad"=>null
                                          );
                $parametrosBusqueda= serialize($parametrosBusqueda);
                $parametrosBusqueda = urlencode($parametrosBusqueda);

                $link="javascript:document.location.href='../vista/listado_asientos2.php?cuenta=".$cuenta."&parametros=".$parametrosBusqueda."';";

                ?>
                <tr style="background-color: #EDF2F7;" height="30px">
                    <td style="cursor: pointer; " onClick="<?php echo $link; ?>">
                        <div style="float: left;">
                        <?php echo substr($CobrosPend[$j]['cuenta'],0,40); ?>
                        </div>
                    </td>
                    <td>
                        <div style="float: right;">
                        <?php echo formateaNumeroContabilidad($CobrosPend[$j]['diferencia']); ?>
                        </div>
                    </td>
                </tr>
                <?php
                //compruebo que si llego a 5 registro salgo del for (solo se imprimen los 5 primeros registros)
                if($j>=4){
                    break;
                }
            }
        }
        ?>
        <tr>
            <td height="15"></td>
        </tr>
        <?php
    }
    ?>
</table>
</div>    
<?php    
}

logger('info','consulta_iva.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
       " ||||Consulta->Resultados||");


//reviso si vengo de pulsar algun boton de cierre de trimestre
if(isset($_GET['Cierre']) && $_GET['Cierre']=='Cierre1T'){
}

$resultados=$clsCNContabilidad->LeeResultados($fechaForm);
$tesoreria=$clsCNContabilidad->LeeTesoreria($fechaForm);
$impuestos=$clsCNContabilidad->LeeImpuestos($fechaForm);//FALTA IRPF (27/11/2014)
$alquileres=$clsCNContabilidad->LeeAlquileres($fechaForm);//FALTA HACER (27/11/2014)
$pagos=$clsCNContabilidad->LeePagos($fechaForm);//Pagos a Cuenta [Autonomos], Sociedades(Ej. Actual) [Sociedades, etc..] 
$CobrosPend=$clsCNContabilidad->CobrosPagosPendientes('43',$fechaForm);
$PagosPend=$clsCNContabilidad->CobrosPagosPendientes('40/41',$fechaForm);


//print_r($CobrosPend);die;

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="../images/q.ico">
        <title>Resultados</title>
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
<style type="text/css">
/* para que no salga el rectangulo inferior */        
.ui-widget-content {
    border: 0px solid #AAAAAA;
}
</style>      

<script type="text/javascript">
$(document).ready(function() {
    $('#resultados').corner("round 15px");
});
$(document).ready(function() {
    $('#tesoreria').corner("round 15px");
});
$(document).ready(function() {
    $('#impuestos').corner("round 15px");
});
$(document).ready(function() {
    $('#CobrosPend').corner("round 15px");
});
$(document).ready(function() {
    $('#PagosPend').corner("round 15px");
});
</script>
<?php
//Funciones generales - carga las funciones auxiliares de eventos de los input text
    eventosInputText();
?>
<script language='JavaScript'>
function pulsar(objeto,opcion){
    if(objeto.style.display==='none'){
        $(objeto).slideDown(1000);
        //cierra el grafico de barras
        $('#Barras').slideUp(1000);
        //abre el grafico de Tarta
        if(opcion==='ingresos'){
            $('#TartaIngresos').slideDown(1000);
        }else{
            $('#TartaGastos').slideDown(1000);
        }
    }else{
        $(objeto).slideUp(1000);
        //abres el grafico de barras
        $('#Barras').slideDown(1000);
        $('#TartaIngresos').slideUp(1000);
        $('#TartaGastos').slideUp(1000);
    }
}
</script>
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
    <table>
        <tr>
            <td align="center">
    <div align="center">
    <?php require_once '../vista/cabecera2.php'; ?>
    </div>
        <h3 align="center" color="#FFCC66">Resultados</h3>
        <table align="center" border="0" width="100%">
        <tr>
            <td align="center">
                <form action="../vista/resultados.php" method="POST">
                <?php
                datepicker_español('datFecha');

                //funcion general
                activarPlaceHolder();
                ?>
                <div align="center" width="100%"> 
                <label class="nombreCampo">Fecha</label><br/>
                <input class="textbox1" type="text" id="datFecha" name="datFecha" maxlength="38" style="width:10%;"
                       onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" tabindex="1"
                       onKeyUp="this.value=formateafechaEntrada(this.value);" value="<?php if(isset($datos['datFecha'])){echo $datos['datFecha'];}else {echo $fechaForm;}?>"
                       onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
                <input type="submit" class="button" value="Calcular"/>
                </div>
                </form>
                <br/>
                <div align="center">
                    <table border="0" width="1300">
                        <tbody>
                            <tr>
                                <td width="35%" valign="top">
                                    <div id="resultados" class="cuadros">
                                        <?php
                                        //tabla de resultados
                                        resultadosPresentar($resultados);
                                        ?>
                                    </div>
                                    <div class="entreCuadros"></div>
                                    <div id="tesoreria" class="cuadros">
                                        <?php
                                        //tabla Tesoreria
                                        tesoreriaPresentar($tesoreria);
                                        ?>
                                    </div>
                                    <div class="entreCuadros"></div>
                                    <div id="impuestos" class="cuadros">
                                        <?php
                                        //tabla Impuestos a Pagar
                                        impuestosPresentar($impuestos,$resultados,$alquileres,$pagos);
                                        ?>
                                    </div>
                                </td>
                                <td width="5%"></td>
                                <td width="60%" valign="top" align="center">
                                    <div id="Barras">
                                    <?php
                                    GraficaBarras($resultados);
                                    ?>
                                    </div>
                                    <div id="TartaIngresos" style="display: none;">
                                    <?php
                                    GraficaTarta2($resultados['ingresos'],'ingresos');
                                    ?>
                                    </div>
                                    <div id="TartaGastos" style="display: none;">
                                    <?php
                                    GraficaTarta2($resultados['gastos'],'gastos');
                                    ?>
                                    </div>
                                    <br/>
                                    <div id="CobrosPend" class="cuadros" style="width:70%">
                                    <?php
                                    //tabla Cobros Pendientes
                                    CobrosPagosPendientesPresentar($CobrosPend,'Cobros');
                                    ?>
                                    </div>
                                    <div class="entreCuadros"></div>
                                    <div id="PagosPend" class="cuadros" style="width:70%">
                                    <?php
                                    //tabla Cobros Pendientes
                                    CobrosPagosPendientesPresentar($PagosPend,'Pagos');
                                    ?>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <br/><br/><br/>
                <?php include '../vista/IndicacionIncidencia.php'; ?>
            </td>
        </tr>
        </table>
            </td>
        </tr>
    </table>
    </body>
</html>
