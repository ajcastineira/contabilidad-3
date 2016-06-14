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


logger('info','nominas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
       " ||||Laboral->Nóminas||");


//recojo la vble lngEjercicio que venga por GET (si viene) o del año actual
if(isset($_GET['lngEjercicio'])){
    $lngEjercicio=$_GET['lngEjercicio'];
    $datosPresentar = $clsCNContabilidad->calculoDatosNominas($lngEjercicio);
    
    //calcular los datos a presentar en la grafica(si vienen datos)
    //1º devengos
    if(isset($datosPresentar['TOTAL DEVENGOS']['Enero'])){
        $enero = desFormateaNumeroContabilidad($datosPresentar['TOTAL DEVENGOS']['Enero']);
    }else{
        $enero = '0';
    }
    if(isset($datosPresentar['TOTAL DEVENGOS']['Febrero'])){
        $febrero = desFormateaNumeroContabilidad($datosPresentar['TOTAL DEVENGOS']['Febrero']);
    }else{
        $febrero = '0';
    }
    if(isset($datosPresentar['TOTAL DEVENGOS']['Marzo'])){
        $marzo = desFormateaNumeroContabilidad($datosPresentar['TOTAL DEVENGOS']['Marzo']);
    }else{
        $marzo = '0';
    }
    if(isset($datosPresentar['TOTAL DEVENGOS']['Abril'])){
        $abril = desFormateaNumeroContabilidad($datosPresentar['TOTAL DEVENGOS']['Abril']);
    }else{
        $abril = '0';
    }
    if(isset($datosPresentar['TOTAL DEVENGOS']['Mayo'])){
        $mayo = desFormateaNumeroContabilidad($datosPresentar['TOTAL DEVENGOS']['Mayo']);
    }else{
        $mayo = '0';
    }
    if(isset($datosPresentar['TOTAL DEVENGOS']['Junio'])){
        $junio = desFormateaNumeroContabilidad($datosPresentar['TOTAL DEVENGOS']['Junio']);
    }else{
        $junio = '0';
    }
    if(isset($datosPresentar['TOTAL DEVENGOS']['Julio'])){
        $julio = desFormateaNumeroContabilidad($datosPresentar['TOTAL DEVENGOS']['Julio']);
    }else{
        $julio = '0';
    }
    if(isset($datosPresentar['TOTAL DEVENGOS']['Agosto'])){
        $agosto = desFormateaNumeroContabilidad($datosPresentar['TOTAL DEVENGOS']['Agosto']);
    }else{
        $agosto = '0';
    }
    if(isset($datosPresentar['TOTAL DEVENGOS']['Septiembre'])){
        $septiembre = desFormateaNumeroContabilidad($datosPresentar['TOTAL DEVENGOS']['Septiembre']);
    }else{
        $septiembre = '0';
    }
    if(isset($datosPresentar['TOTAL DEVENGOS']['Octubre'])){
        $octubre = desFormateaNumeroContabilidad($datosPresentar['TOTAL DEVENGOS']['Octubre']);
    }else{
        $octubre = '0';
    }
    if(isset($datosPresentar['TOTAL DEVENGOS']['Noviembre'])){
        $noviembre = desFormateaNumeroContabilidad($datosPresentar['TOTAL DEVENGOS']['Noviembre']);
    }else{
        $noviembre = '0';
    }
    if(isset($datosPresentar['TOTAL DEVENGOS']['Diciembre'])){
        $diciembre = desFormateaNumeroContabilidad($datosPresentar['TOTAL DEVENGOS']['Diciembre']);
    }else{
        $diciembre = '0';
    }

    $devengos = "[$enero,$febrero,$marzo,$abril,$mayo,$junio,$julio,$agosto,$septiembre,$octubre,$noviembre,$diciembre]";

    
    //Sº Coste SS
    if(isset($datosPresentar['TOTAL COSTE S.S.']['Enero'])){
        $enero = desFormateaNumeroContabilidad($datosPresentar['TOTAL COSTE S.S.']['Enero']);
    }else{
        $enero = '0';
    }
    if(isset($datosPresentar['TOTAL COSTE S.S.']['Febrero'])){
        $febrero = desFormateaNumeroContabilidad($datosPresentar['TOTAL COSTE S.S.']['Febrero']);
    }else{
        $febrero = '0';
    }
    if(isset($datosPresentar['TOTAL COSTE S.S.']['Marzo'])){
        $marzo = desFormateaNumeroContabilidad($datosPresentar['TOTAL COSTE S.S.']['Marzo']);
    }else{
        $marzo = '0';
    }
    if(isset($datosPresentar['TOTAL COSTE S.S.']['Abril'])){
        $abril = desFormateaNumeroContabilidad($datosPresentar['TOTAL COSTE S.S.']['Abril']);
    }else{
        $abril = '0';
    }
    if(isset($datosPresentar['TOTAL COSTE S.S.']['Mayo'])){
        $mayo = desFormateaNumeroContabilidad($datosPresentar['TOTAL COSTE S.S.']['Mayo']);
    }else{
        $mayo = '0';
    }
    if(isset($datosPresentar['TOTAL COSTE S.S.']['Junio'])){
        $junio = desFormateaNumeroContabilidad($datosPresentar['TOTAL COSTE S.S.']['Junio']);
    }else{
        $junio = '0';
    }
    if(isset($datosPresentar['TOTAL COSTE S.S.']['Julio'])){
        $julio = desFormateaNumeroContabilidad($datosPresentar['TOTAL COSTE S.S.']['Julio']);
    }else{
        $julio = '0';
    }
    if(isset($datosPresentar['TOTAL COSTE S.S.']['Agosto'])){
        $agosto = desFormateaNumeroContabilidad($datosPresentar['TOTAL COSTE S.S.']['Agosto']);
    }else{
        $agosto = '0';
    }
    if(isset($datosPresentar['TOTAL COSTE S.S.']['Septiembre'])){
        $septiembre = desFormateaNumeroContabilidad($datosPresentar['TOTAL COSTE S.S.']['Septiembre']);
    }else{
        $septiembre = '0';
    }
    if(isset($datosPresentar['TOTAL COSTE S.S.']['Octubre'])){
        $octubre = desFormateaNumeroContabilidad($datosPresentar['TOTAL COSTE S.S.']['Octubre']);
    }else{
        $octubre = '0';
    }
    if(isset($datosPresentar['TOTAL COSTE S.S.']['Noviembre'])){
        $noviembre = desFormateaNumeroContabilidad($datosPresentar['TOTAL COSTE S.S.']['Noviembre']);
    }else{
        $noviembre = '0';
    }
    if(isset($datosPresentar['TOTAL COSTE S.S.']['Diciembre'])){
        $diciembre = desFormateaNumeroContabilidad($datosPresentar['TOTAL COSTE S.S.']['Diciembre']);
    }else{
        $diciembre = '0';
    }
    
    $costeSS = "[$enero,$febrero,$marzo,$abril,$mayo,$junio,$julio,$agosto,$septiembre,$octubre,$noviembre,$diciembre]";
}

//calculo los datos que se presentan en esta consulta
logger('traza','nominas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
       " clsCNContabilidad->calculoDatosNominas($lngEjercicio)>");

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="../images/q.ico">
        <title>Nóminas</title>
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

        <!-- graficas -->
        <script src="../js/highcharts/highcharts.js"></script>
        <script src="../js/highcharts/themes/sand-signika.js"></script>
        
<style type="text/css">
/* para que no salga el rectangulo inferior */        
.ui-widget-content {
    border: 0px solid #AAAAAA;
}
</style>      

<script LANGUAGE="JavaScript"> 
//generacion de la grafica
$(function () {
    Highcharts.setOptions({
    lang: {
        decimalPoint: ',',
        thousandsSep: '.',
        valueDecimals: 2 // If you want to add 2 decimals
    }
    });
    
    $('#grafica').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Nóminas <?php echo $lngEjercicio; ?>'
        },
        xAxis: {
            categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
        },
        credits: {
            enabled: false
        },        
        yAxis: {
            min: 0,
            title: {
                text: 'Conceptos'
            },
            stackLabels: {
                enabled: true,
                formatter: function(){
                   return Highcharts.numberFormat(this.total, 2, ',', '.');
                },
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'qualidad'
                }
            }
        },
        legend: {
            align: 'right',
            x: -30,
            verticalAlign: 'top',
            y: 25,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.background) || 'white',
            borderColor: '#CCC',
            borderWidth: 1,
            shadow: false
        },
        tooltip: {
            formatter: function () {
                return '<b>' + this.x + '</b><br/>' +
                    this.series.name + ': ' + this.y + '<br/>' +
                    'Total: ' + Math.round(this.point.stackTotal * 100) / 100;
            }
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                    style: {
                        textShadow: '0 0 3px black'
                    }
                }
            }
        },
        series: [{
            name: 'Coste S.S.',
            data: <?php echo $costeSS; ?>
        }, {
            name: 'Total Devengos',
            data: <?php echo $devengos; ?>
        }]
    });
});
</script>                            

<script LANGUAGE="JavaScript"> 

function Volver(){
    window.location='../vista/default2.php';
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
<table align="center" border="0">
    <tr>
        <td>
            <?php require_once '../vista/cabecera2.php'; ?>
        </td>
    </tr>
    <tr>
        <td>
            <h3 align="center" color="#FFCC66">Nóminas</h3>

            <form name="form1" action="../vista/nominas.php" method="get">
                <table class="filtro" align="center" border="0" width="954">
                    <tr></tr>
                    <tr><td>
                <table class="filtro" align="center" border="0" width="300">
                    <tr> 
                      <td class="nombreCampo">
                          <div align="right">
                            <h3 color="#FFCC66"><font size="3px">Ejercicio:</font></h3>
                          </div>
                    </td>
                    <td width="60">
                        <div align="left">
                            <select name="lngEjercicio" class="textbox1">
                            <?php 
                            //extraigo los ejercicios y archivos
                            $ejercicios = $clsCNContabilidad->ejerciciosNominas(); 
                            
                            //preparo el litado de las opciones
                            for ($i = 0; $i < count($ejercicios); $i++) {
                                $selected = '';
                                if($lngEjercicio === $ejercicios[$i]['ejercicio']){
                                    $selected = 'selected';
                                }
                                echo "<option value='".$ejercicios[$i]['ejercicio']."' $selected>".$ejercicios[$i]['ejercicio']."</option>";
                            }
                            ?>  
                            </select>
                        </div>
                    </td>
                    <td>
                        <input type="submit" class="button" value="Consultar" />
                    </td>
                    </tr>
                </table>
                </td></tr>
                <tr></tr>
                </table>   
            </form> 
            <br/><br/><br/>
            <div align="center">
                
                <!-- grafica de barras acumuladas (stacked column) -->
                <div id="grafica">
                </div>
                <br/><br/>
                <!-- tabla de presentar resultados -->
                <div id="tabla" style="display: none;"> 
                <p><b>Cuadro de Resultados</b></p>    
                <br/>
                <table class="tablaNominas" border="0">
                    <thead>
                        <tr>
                            <th style="width:13%"></th>
                            <th class="tablaNominasCasillaTh" style="width:6.5%; text-align: center;">Enero</th>
                            <th class="tablaNominasCasillaTh" style="width:6.5%; text-align: center;">Febrero</th>
                            <th class="tablaNominasCasillaTh" style="width:6.5%; text-align: center;">Marzo</th>
                            <th class="tablaNominasCasillaTh" style="width:6.5%; text-align: center;">Abril</th>
                            <th class="tablaNominasCasillaTh" style="width:6.5%; text-align: center;">Mayo</th>
                            <th class="tablaNominasCasillaTh" style="width:6.5%; text-align: center;">Junio</th>
                            <th class="tablaNominasCasillaTh" style="width:6.5%; text-align: center;">Julio</th>
                            <th class="tablaNominasCasillaTh" style="width:6.5%; text-align: center;">Agosto</th>
                            <th class="tablaNominasCasillaTh" style="width:6.5%; text-align: center;">Septiembre</th>
                            <th class="tablaNominasCasillaTh" style="width:6.5%; text-align: center;">Octubre</th>
                            <th class="tablaNominasCasillaTh" style="width:6.5%; text-align: center;">Noviembre</th>
                            <th class="tablaNominasCasillaTh" style="width:6.5%; text-align: center;">Diciembre</th>
                            <th style="width: 10px;" style="width:2.5%"></th>
                            <th class="tablaNominasCasillaTh" style="width:6.5%">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        //recojo los nombres de los meses (esta escritos en las hojas de excel
                        //por lo que vendran con los nombres no exactamente escritos
                        //(puede que vengan en mayusculas, minusculas o la priera mayusculas, etc..)
                        
                        foreach ($datosPresentar as $key => $value) {
                            $txtTitulo = '';
                            $txtColor = '';
                            switch ($key) {
                                case 'TOTAL DEVENGOS':
                                    $txtTitulo = 'DEVENGOS';
                                    break;
                                case 'TOTAL LIQUIDO':
                                    $txtTitulo = 'LIQUIDO';
                                    break;
                                case 'TOTAL COSTE S.S.':
                                    $txtTitulo = 'SEG. SOC. EMPRESA';
                                    break;
                                case 'TOTAL':
                                    $txtColor = 'style="font-weight: bold;"';
                                    $txtTitulo = 'TOTAL COSTE';
                                    break;
                                case 'DEDUCCIONES S.S.':
                                    $txtColor = 'style="color: #FF0000;"';
                                case 'RETENCION IRPF':
                                    $txtColor = 'style="color: #FF0000;"';
                                default:
                                    $txtTitulo = $key;
                                    break;
                            }
                            $total = desFormateaNumeroContabilidad($value['Enero']) +
                                     desFormateaNumeroContabilidad($value['Febrero']) +
                                     desFormateaNumeroContabilidad($value['Marzo']) +
                                     desFormateaNumeroContabilidad($value['Abril']) +
                                     desFormateaNumeroContabilidad($value['Mayo']) +
                                     desFormateaNumeroContabilidad($value['Junio']) +
                                     desFormateaNumeroContabilidad($value['Julio']) +
                                     desFormateaNumeroContabilidad($value['Agosto']) +
                                     desFormateaNumeroContabilidad($value['Septiembre']) +
                                     desFormateaNumeroContabilidad($value['Octubre']) +
                                     desFormateaNumeroContabilidad($value['Noviembre']) +
                                     desFormateaNumeroContabilidad($value['Diciembre']);
                            ?>
                            <tr <?php echo $txtColor; ?>>
                                <td class="tablaNominasCasilla" style="text-align: left;"><b><?php echo $txtTitulo; ?></b></td>
                                <td class="tablaNominasCasilla"><?php echo $value['Enero']; ?></td>
                                <td class="tablaNominasCasilla"><?php echo $value['Febrero']; ?></td>
                                <td class="tablaNominasCasilla"><?php echo $value['Marzo']; ?></td>
                                <td class="tablaNominasCasilla"><?php echo $value['Abril']; ?></td>
                                <td class="tablaNominasCasilla"><?php echo $value['Mayo']; ?></td>
                                <td class="tablaNominasCasilla"><?php echo $value['Junio']; ?></td>
                                <td class="tablaNominasCasilla"><?php echo $value['Julio']; ?></td>
                                <td class="tablaNominasCasilla"><?php echo $value['Agosto']; ?></td>
                                <td class="tablaNominasCasilla"><?php echo $value['Septiembre']; ?></td>
                                <td class="tablaNominasCasilla"><?php echo $value['Octubre']; ?></td>
                                <td class="tablaNominasCasilla"><?php echo $value['Noviembre']; ?></td>
                                <td class="tablaNominasCasilla"><?php echo $value['Diciembre']; ?></td>
                                <td></td>
                                <td class="tablaNominasCasilla"><?php echo formateaNumeroContabilidad($total); ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <td colspan="15">
                                <div align="center">
                                    <br/>
                                    <input type="button" class="button" value="Volver" onclick="Volver();" />
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </div>
                
            </div>
            <br/><br/><br/>
            <?php include '../vista/IndicacionIncidencia.php'; ?>
        </td>
        </tr>
        </table>
        <script>
        $(document).ready(function() {
            <?php 
            if(isset($datosPresentar)){
                echo "document.getElementById('tabla').style.display= 'block';";
            } 
            ?>
        });
        </script>
    </body>
</html>
