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


logger('info','plantActual.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
       " ||||Laboral->Plantilla Actual||");


//extraigo un listado de los empleados que la fechaAlta <= hoy
$listadoEmpleado = $clsCNContabilidad->listadoEmpleadosInicial();

//preparo los distintos listados
//A listado de tipos de contrato
$tiposContrato = array(
    "Indefinido"=>0,
    "Temporal"=>0,
    "Practicas"=>0,
    "Formacion"=>0
);
//B listado de tipos de jornada
$tiposJornada = array(
    "Completa"=>0,
    "Parcial"=>0
);
//1º listado empleados Indefinido
$empleadosIndefinido = '';
//2º listado empleados Temporal
$empleadosTemporal = '';
//3º listado empleados Practicas
$empleadosPracticas = '';
//4º listado empleados Formacion
$empleadosFormacion = '';
//5º listado empleados Completa
$empleadosCompleta = '';
//6º listado empleados Parcial
$empleadosParcial = '';

for ($i = 0; $i < count($listadoEmpleado); $i++) {
    //A, 1º, 2º, 3º y 4º
    switch ($listadoEmpleado[$i]['tipoContrato']) {
        case 'Indefinido':
            $tiposContrato['Indefinido'] = $tiposContrato['Indefinido'] + 1;
            $empleadosIndefinido[] = $listadoEmpleado[$i];
            break;
        case 'Temporal':
            $tiposContrato['Temporal'] = $tiposContrato['Temporal'] + 1;
            $empleadosTemporal[] = $listadoEmpleado[$i];
            break;
        case 'Practicas':
            $tiposContrato['Practicas'] = $tiposContrato['Practicas'] + 1;
            $empleadosPracticas[] = $listadoEmpleado[$i];
            break;
        case 'Formacion':
            $tiposContrato['Formacion'] = $tiposContrato['Formacion'] + 1;
            $empleadosFormacion[] = $listadoEmpleado[$i];
            break;
    }
    
    //B, 5º y 6º
    switch ($listadoEmpleado[$i]['tipoJornada']) {
        case 'Completa':
            $tiposJornada['Completa'] = $tiposJornada['Completa'] + 1;
            $empleadosCompleta[] = $listadoEmpleado[$i];
            break;
        case 'Parcial':
            $tiposJornada['Parcial'] = $tiposJornada['Parcial'] + 1;
            $empleadosParcial[] = $listadoEmpleado[$i];
            break;
    }
}

//preparo las dos series de datos JSON para las graficas
$JSONtipos = '';
foreach ($tiposContrato as $key => $value) {
    $JSONtipos = $JSONtipos . "['$key',$value],";
}
//quitamos la ultima coma
$JSONtipos = trim($JSONtipos, ',');

$JSONjornada = '';;
foreach ($tiposJornada as $key => $value) {
    $JSONjornada = $JSONjornada . "['$key',$value],";
}
//quitamos la ultima coma
$JSONjornada = trim($JSONjornada, ',');

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="../images/q.ico">
        <title>Plantilla Actual</title>
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
    
    $('#graficaIndefinido').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 1,//null,
            plotShadow: false
        },
        title: {
            text: 'Tipo de Contrato'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        credits: {
            enabled: false
        },        
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.y:.0f}',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                },
                events:{
                    click: function(e){
                        ver(e.point.name);
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: ' ',
            data: [
                <?php echo $JSONtipos; ?>
            ]
        }]
    });
});


$(function () {
    Highcharts.setOptions({
    lang: {
        decimalPoint: ',',
        thousandsSep: '.',
        valueDecimals: 2 // If you want to add 2 decimals
    }
    });
    
    $('#graficaCompleto').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 1,//null,
            plotShadow: false
        },
        title: {
            text: 'Tipo de Jornada'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        credits: {
            enabled: false
        },        
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.y:.0f}',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                },
                events:{
                    click: function(e){
                        ver(e.point.name);
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: ' ',
            data: [
                <?php echo $JSONjornada; ?>
            ]
        }]
    });
});

//activar los distintos listados
function ver(name){
    //segun el tipo aparacere un listado u otro
    switch(name){
        case 'Indefinido':
            $('#listado1').slideDown(1000);
            $('#listado2').slideUp(1000);
            $('#listado3').slideUp(1000);
            $('#listado4').slideUp(1000);
            $('#listado5').slideUp(1000);
            $('#listado6').slideUp(1000);
            break;
        case 'Temporal':
            $('#listado1').slideUp(1000);
            $('#listado2').slideDown(1000);
            $('#listado3').slideUp(1000);
            $('#listado4').slideUp(1000);
            $('#listado5').slideUp(1000);
            $('#listado6').slideUp(1000);
            break;
        case 'Practicas':
            $('#listado1').slideUp(1000);
            $('#listado2').slideUp(1000);
            $('#listado3').slideDown(1000);
            $('#listado4').slideUp(1000);
            $('#listado5').slideUp(1000);
            $('#listado6').slideUp(1000);
            break;
        case 'Formacion':
            $('#listado1').slideUp(1000);
            $('#listado2').slideUp(1000);
            $('#listado3').slideUp(1000);
            $('#listado4').slideDown(1000);
            $('#listado5').slideUp(1000);
            $('#listado6').slideUp(1000);
            break;
        case 'Completa':
            $('#listado1').slideUp(1000);
            $('#listado2').slideUp(1000);
            $('#listado3').slideUp(1000);
            $('#listado4').slideUp(1000);
            $('#listado5').slideDown(1000);
            $('#listado6').slideUp(1000);
            break;
        case 'Parcial':
            $('#listado1').slideUp(1000);
            $('#listado2').slideUp(1000);
            $('#listado3').slideUp(1000);
            $('#listado4').slideUp(1000);
            $('#listado5').slideUp(1000);
            $('#listado6').slideDown(1000);
            break;
    }
}




//para cada uno de los listados
$(document).ready(function(){
    //formatear y traducir los datos de la tabla
    //1º
    $('#datatables1').dataTable({
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
        "bJQueryUI":true,
        "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]]
    });
    //2º
    $('#datatables2').dataTable({
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
        "bJQueryUI":true,
        "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]]
    });
    //3º
    $('#datatables3').dataTable({
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
        "bJQueryUI":true,
        "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]]
    });
    //4º
    $('#datatables4').dataTable({
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
        "bJQueryUI":true,
        "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]]
    });
    //5º
    $('#datatables5').dataTable({
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
        "bJQueryUI":true,
        "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]]
    });
    //6º
    $('#datatables6').dataTable({
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
        "bJQueryUI":true,
        "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]]
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
            <div align="center">
                <!-- grafica contratos Indefinidos/Temporales (Pie chart) -->
                <div id="graficaIndefinido" style="width: 45%;display: inline-block;"></div>
                <!-- grafica contratos Tiempo Completo/Parcial (Pie chart) -->
                <div id="graficaCompleto" style="width: 45%;display: inline-block;"></div>
                <br/><br/><br/>
                
                <!-- Listados que aparecen cuando se pincha en las graficas -->
                <!-- Tipo: Indefinido -->
                <div id="listado1" style="display: none;">
                    <h3>Contrato Indefinido</h3>
                    <table id="datatables1" class="display">
                        <thead>
                            <tr>
                                <th width="5%">Nº Empleado</th>
                                <th width="30%">Nombre y Apellidos</th>
                                <th width="15%;">Categoria</th>
                                <th width="15%;">Vencimiento Contrato</th>
                                <th width="15%;">Tipo Contrato</th>
                                <th width="20%;">Tipo Jornada</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(is_array($empleadosIndefinido)){
                                for ($i = 0; $i < count($empleadosIndefinido); $i++) {
                                    //preparo el array de $arResult[$i] para enviar por url
                                    //$link="javascript:document.location.href='../vista/altacontacto.php?IdContacto=".$arResult[$i]['IdContacto']."';";
                                    $link="";
                                    //compruebo si VtoContrato viene 00/00/0000
                                    //si es asi lo pongo vacio
                                    $txtVtoContrato = $empleadosIndefinido[$i]['VtoContrato'];
                                    if($txtVtoContrato === '00/00/0000'){
                                        $txtVtoContrato = '';
                                    }
                                    //y ahora extraigo la informacion de tipoJornada
                                    $txtTipoJornada = $empleadosIndefinido[$i]['tipoJornada'];
                                    //si tipoJornada='Parcial' xtraemos los datos de las horas
                                    if($txtTipoJornada === 'Parcial'){
                                        $horas = explode (' ',$empleadosIndefinido[$i]['Horas']);
                                        $txtTipoJornada = $txtTipoJornada . '<br/>'. $horas[0];
                                        if($horas[1] === 's'){
                                            $txtTipoJornada = $txtTipoJornada . ' horas semanales';
                                        }else if($horas[1] === 'd'){
                                            $txtTipoJornada = $txtTipoJornada . ' horas diarias';
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td style="text-align: right;" onClick="<?php echo $link; ?>"><?php echo $empleadosIndefinido[$i]['NumEmpleado']; ?></td>
                                        <td onClick="<?php echo $link; ?>"><?php echo $empleadosIndefinido[$i]['empleado']; ?></td>
                                        <td onClick="<?php echo $link; ?>"><?php echo $empleadosIndefinido[$i]['Categoria']; ?></td>
                                        <td onClick="<?php echo $link; ?>"><?php echo $txtVtoContrato; ?></td>
                                        <td onClick="<?php echo $link; ?>"><?php echo $empleadosIndefinido[$i]['tipoContrato']; ?></td>
                                        <td onClick="<?php echo $link; ?>"><?php echo $txtTipoJornada; ?></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Tipo: Temporal -->
                <div id="listado2" style="display: none;">
                    <h3>Contrato Temporal</h3>
                    <table id="datatables2" class="display">
                        <thead>
                            <tr>
                                <th width="5%">Nº Empleado</th>
                                <th width="30%">Nombre y Apellidos</th>
                                <th width="15%;">Categoria</th>
                                <th width="15%;">Vencimiento Contrato</th>
                                <th width="15%;">Tipo Contrato</th>
                                <th width="20%;">Tipo Jornada</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(is_array($empleadosTemporal)){
                                for ($i = 0; $i < count($empleadosTemporal); $i++) {
                                    //preparo el array de $arResult[$i] para enviar por url
                                    //$link="javascript:document.location.href='../vista/altacontacto.php?IdContacto=".$arResult[$i]['IdContacto']."';";
                                    $link="";
                                    //compruebo si VtoContrato viene 00/00/0000
                                    //si es asi lo pongo vacio
                                    $txtVtoContrato = $empleadosTemporal[$i]['VtoContrato'];
                                    if($txtVtoContrato === '00/00/0000'){
                                        $txtVtoContrato = '';
                                    }
                                    //y ahora extraigo la informacion de tipoJornada
                                    $txtTipoJornada = $empleadosTemporal[$i]['tipoJornada'];
                                    //si tipoJornada='Parcial' xtraemos los datos de las horas
                                    if($txtTipoJornada === 'Parcial'){
                                        $horas = explode (' ',$empleadosTemporal[$i]['Horas']);
                                        $txtTipoJornada = $txtTipoJornada . '<br/>'. $horas[0];
                                        if($horas[1] === 's'){
                                            $txtTipoJornada = $txtTipoJornada . ' horas semanales';
                                        }else if($horas[1] === 'd'){
                                            $txtTipoJornada = $txtTipoJornada . ' horas diarias';
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td style="text-align: right;" onClick="<?php echo $link; ?>"><?php echo $empleadosTemporal[$i]['NumEmpleado']; ?></td>
                                        <td onClick="<?php echo $link; ?>"><?php echo $empleadosTemporal[$i]['empleado']; ?></td>
                                        <td onClick="<?php echo $link; ?>"><?php echo $empleadosTemporal[$i]['Categoria']; ?></td>
                                        <td onClick="<?php echo $link; ?>"><?php echo $txtVtoContrato; ?></td>
                                        <td onClick="<?php echo $link; ?>"><?php echo $empleadosTemporal[$i]['tipoContrato']; ?></td>
                                        <td onClick="<?php echo $link; ?>"><?php echo $txtTipoJornada; ?></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Tipo: Practicas -->
                <div id="listado3" style="display: none;">
                    <h3>Contrato Prácticas</h3>
                    <table id="datatables3" class="display">
                        <thead>
                            <tr>
                                <th width="5%">Nº Empleado</th>
                                <th width="30%">Nombre y Apellidos</th>
                                <th width="15%;">Categoria</th>
                                <th width="15%;">Vencimiento Contrato</th>
                                <th width="15%;">Tipo Contrato</th>
                                <th width="20%;">Tipo Jornada</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(is_array($empleadosPracticas)){
                                for ($i = 0; $i < count($empleadosPracticas); $i++) {
                                    //preparo el array de $arResult[$i] para enviar por url
                                    //$link="javascript:document.location.href='../vista/altacontacto.php?IdContacto=".$arResult[$i]['IdContacto']."';";
                                    $link="";
                                    //compruebo si VtoContrato viene 00/00/0000
                                    //si es asi lo pongo vacio
                                    $txtVtoContrato = $empleadosPracticas[$i]['VtoContrato'];
                                    if($txtVtoContrato === '00/00/0000'){
                                        $txtVtoContrato = '';
                                    }
                                    //y ahora extraigo la informacion de tipoJornada
                                    $txtTipoJornada = $empleadosPracticas[$i]['tipoJornada'];
                                    //si tipoJornada='Parcial' xtraemos los datos de las horas
                                    if($txtTipoJornada === 'Parcial'){
                                        $horas = explode (' ',$empleadosPracticas[$i]['Horas']);
                                        $txtTipoJornada = $txtTipoJornada . '<br/>'. $horas[0];
                                        if($horas[1] === 's'){
                                            $txtTipoJornada = $txtTipoJornada . ' horas semanales';
                                        }else if($horas[1] === 'd'){
                                            $txtTipoJornada = $txtTipoJornada . ' horas diarias';
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td style="text-align: right;" onClick="<?php echo $link; ?>"><?php echo $empleadosPracticas[$i]['NumEmpleado']; ?></td>
                                        <td onClick="<?php echo $link; ?>"><?php echo $empleadosPracticas[$i]['empleado']; ?></td>
                                        <td onClick="<?php echo $link; ?>"><?php echo $empleadosPracticas[$i]['Categoria']; ?></td>
                                        <td onClick="<?php echo $link; ?>"><?php echo $txtVtoContrato; ?></td>
                                        <td onClick="<?php echo $link; ?>"><?php echo $empleadosPracticas[$i]['tipoContrato']; ?></td>
                                        <td onClick="<?php echo $link; ?>"><?php echo $txtTipoJornada; ?></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Tipo: Formacion -->
                <div id="listado4" style="display: none;">
                    <h3>Contrato Formación</h3>
                    <table id="datatables4" class="display">
                        <thead>
                            <tr>
                                <th width="5%">Nº Empleado</th>
                                <th width="30%">Nombre y Apellidos</th>
                                <th width="15%;">Categoria</th>
                                <th width="15%;">Vencimiento Contrato</th>
                                <th width="15%;">Tipo Contrato</th>
                                <th width="20%;">Tipo Jornada</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(is_array($empleadosFormacion)){
                                for ($i = 0; $i < count($empleadosFormacion); $i++) {
                                    //preparo el array de $arResult[$i] para enviar por url
                                    //$link="javascript:document.location.href='../vista/altacontacto.php?IdContacto=".$arResult[$i]['IdContacto']."';";
                                    $link="";
                                    //compruebo si VtoContrato viene 00/00/0000
                                    //si es asi lo pongo vacio
                                    $txtVtoContrato = $empleadosFormacion[$i]['VtoContrato'];
                                    if($txtVtoContrato === '00/00/0000'){
                                        $txtVtoContrato = '';
                                    }
                                    //y ahora extraigo la informacion de tipoJornada
                                    $txtTipoJornada = $empleadosFormacion[$i]['tipoJornada'];
                                    //si tipoJornada='Parcial' xtraemos los datos de las horas
                                    if($txtTipoJornada === 'Parcial'){
                                        $horas = explode (' ',$empleadosFormacion[$i]['Horas']);
                                        $txtTipoJornada = $txtTipoJornada . '<br/>'. $horas[0];
                                        if($horas[1] === 's'){
                                            $txtTipoJornada = $txtTipoJornada . ' horas semanales';
                                        }else if($horas[1] === 'd'){
                                            $txtTipoJornada = $txtTipoJornada . ' horas diarias';
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td style="text-align: right;" onClick="<?php echo $link; ?>"><?php echo $empleadosFormacion[$i]['NumEmpleado']; ?></td>
                                        <td onClick="<?php echo $link; ?>"><?php echo $empleadosFormacion[$i]['empleado']; ?></td>
                                        <td onClick="<?php echo $link; ?>"><?php echo $empleadosFormacion[$i]['Categoria']; ?></td>
                                        <td onClick="<?php echo $link; ?>"><?php echo $txtVtoContrato; ?></td>
                                        <td onClick="<?php echo $link; ?>"><?php echo $empleadosFormacion[$i]['tipoContrato']; ?></td>
                                        <td onClick="<?php echo $link; ?>"><?php echo $txtTipoJornada; ?></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Tipo: Completa -->
                <div id="listado5" style="display: none;">
                    <h3>Jornada Completa</h3>
                    <table id="datatables5" class="display">
                        <thead>
                            <tr>
                                <th width="5%">Nº Empleado</th>
                                <th width="30%">Nombre y Apellidos</th>
                                <th width="15%;">Categoria</th>
                                <th width="15%;">Vencimiento Contrato</th>
                                <th width="15%;">Tipo Contrato</th>
                                <th width="20%;">Tipo Jornada</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(is_array($empleadosCompleta)){
                                for ($i = 0; $i < count($empleadosCompleta); $i++) {
                                    //preparo el array de $arResult[$i] para enviar por url
                                    //$link="javascript:document.location.href='../vista/altacontacto.php?IdContacto=".$arResult[$i]['IdContacto']."';";
                                    $link="";
                                    //compruebo si VtoContrato viene 00/00/0000
                                    //si es asi lo pongo vacio
                                    $txtVtoContrato = $empleadosCompleta[$i]['VtoContrato'];
                                    if($txtVtoContrato === '00/00/0000'){
                                        $txtVtoContrato = '';
                                    }
                                    //y ahora extraigo la informacion de tipoJornada
                                    $txtTipoJornada = $empleadosCompleta[$i]['tipoJornada'];
                                    //si tipoJornada='Parcial' xtraemos los datos de las horas
                                    if($txtTipoJornada === 'Parcial'){
                                        $horas = explode (' ',$empleadosCompleta[$i]['Horas']);
                                        $txtTipoJornada = $txtTipoJornada . '<br/>'. $horas[0];
                                        if($horas[1] === 's'){
                                            $txtTipoJornada = $txtTipoJornada . ' horas semanales';
                                        }else if($horas[1] === 'd'){
                                            $txtTipoJornada = $txtTipoJornada . ' horas diarias';
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td style="text-align: right;" onClick="<?php echo $link; ?>"><?php echo $empleadosCompleta[$i]['NumEmpleado']; ?></td>
                                        <td onClick="<?php echo $link; ?>"><?php echo $empleadosCompleta[$i]['empleado']; ?></td>
                                        <td onClick="<?php echo $link; ?>"><?php echo $empleadosCompleta[$i]['Categoria']; ?></td>
                                        <td onClick="<?php echo $link; ?>"><?php echo $txtVtoContrato; ?></td>
                                        <td onClick="<?php echo $link; ?>"><?php echo $empleadosCompleta[$i]['tipoContrato']; ?></td>
                                        <td onClick="<?php echo $link; ?>"><?php echo $txtTipoJornada; ?></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Tipo: Parcial -->
                <div id="listado6" style="display: none;">
                    <h3>Jornada Parcial</h3>
                    <table id="datatables6" class="display">
                        <thead>
                            <tr>
                                <th width="5%">Nº Empleado</th>
                                <th width="30%">Nombre y Apellidos</th>
                                <th width="15%;">Categoria</th>
                                <th width="15%;">Vencimiento Contrato</th>
                                <th width="15%;">Tipo Contrato</th>
                                <th width="20%;">Tipo Jornada</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(is_array($empleadosParcial)){
                                for ($i = 0; $i < count($empleadosParcial); $i++) {
                                    //preparo el array de $arResult[$i] para enviar por url
                                    //$link="javascript:document.location.href='../vista/altacontacto.php?IdContacto=".$arResult[$i]['IdContacto']."';";
                                    $link="";
                                    //compruebo si VtoContrato viene 00/00/0000
                                    //si es asi lo pongo vacio
                                    $txtVtoContrato = $empleadosParcial[$i]['VtoContrato'];
                                    if($txtVtoContrato === '00/00/0000'){
                                        $txtVtoContrato = '';
                                    }
                                    //y ahora extraigo la informacion de tipoJornada
                                    $txtTipoJornada = $empleadosParcial[$i]['tipoJornada'];
                                    //si tipoJornada='Parcial' xtraemos los datos de las horas
                                    if($txtTipoJornada === 'Parcial'){
                                        $horas = explode (' ',$empleadosParcial[$i]['Horas']);
                                        $txtTipoJornada = $txtTipoJornada . '<br/>'. $horas[0];
                                        if($horas[1] === 's'){
                                            $txtTipoJornada = $txtTipoJornada . ' horas semanales';
                                        }else if($horas[1] === 'd'){
                                            $txtTipoJornada = $txtTipoJornada . ' horas diarias';
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td style="text-align: right;" onClick="<?php echo $link; ?>"><?php echo $empleadosParcial[$i]['NumEmpleado']; ?></td>
                                        <td onClick="<?php echo $link; ?>"><?php echo $empleadosParcial[$i]['empleado']; ?></td>
                                        <td onClick="<?php echo $link; ?>"><?php echo $empleadosParcial[$i]['Categoria']; ?></td>
                                        <td onClick="<?php echo $link; ?>"><?php echo $txtVtoContrato; ?></td>
                                        <td onClick="<?php echo $link; ?>"><?php echo $empleadosParcial[$i]['tipoContrato']; ?></td>
                                        <td onClick="<?php echo $link; ?>"><?php echo $txtTipoJornada; ?></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                
            </div>
            <?php include '../vista/IndicacionIncidencia.php'; ?>
        </td>
        </tr>
        </table>
    </body>
</html>
