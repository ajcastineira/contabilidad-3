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


logger('info','listado_asientos.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
       " ||||Operaciones->Modificar Asiento||");


//recojo los parametros enviados por GET
$cuenta = stripslashes($_GET['cuenta']); 
$cuenta = urldecode($cuenta); 
$cuenta = unserialize($cuenta);
$parametros = stripslashes($_GET['parametros']); 
$parametros = urldecode($parametros); 
$parametros = unserialize($parametros);

//extraigo la consulta de esta tabla
require_once '../CN/clsCNContabilidad.php';
$clsCNContabilidad = new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['mapeo']);
$arResult = $clsCNContabilidad->ListadoAsientosCuenta($cuenta,$parametros);




//aqui dirijo a la presentacion en PC o Movil (APP)
if($_SESSION['navegacion'] === 'movil'){
    html_paginaMovil($arResult);
}else{
    html_pagina($arResult);
}


function html_pagina($arResult){
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="../images/q.ico">
        <title>Modificar Asiento - Listar Asientos de Cuenta</title>
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
                    "bFilter":false,
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
                    "bSort":false,
//                    "aaSorting": [[ 0, "asc" ]],
//                    "aoColumns": [
//			{ "sType": 'string' },
//			null,
//			null,
//			null,
//			null,
//			null,
//			null
//                    ],                    
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
<table align="center" border="0" width="701">
    <tr>
        <td>
            <h3 align="center" color="#FFCC66"><font size="3px">Listado de Asientos de Cuenta <?php echo $cuenta['Cuenta'].' - '.$cuenta['Nombre'];?></font></h3>
            
            <table id="datatablesMod" class="display">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Asiento</th>
                        <th>Concepto</th>
                        <th>Debe</th>
                        <th>Haber</th>
                        <th>Saldo</th>
                        <th>Borrar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //sumas de debe y haber
                    $totalDebe=0;
                    $totalHaber=0;
                    //$saldo=0;
                    if(is_array($arResult)){
                        for ($i = 0; $i < count($arResult); $i++) {
                            //la fecha la dividimos en dias , meses y años
                            $fecha=explode('/',$arResult[$i]['Fecha']);
                            $link="javascript:document.location.href='../vista/gastos_editar.php?Asiento=".$arResult[$i]['Asiento']."&TipoAsiento=".$arResult[$i]['TipoAsiento']."'";
                            //si debe = 0.00 lo indico en blanco
                            if($arResult[$i]['Debe']<>0){
                                $debe=$arResult[$i]['Debe'];
                            }else{
                                $debe='';
                            }
                            //si haber = 0.00 lo indico en blanco
                            if($arResult[$i]['Haber']<>0){
                                $haber=$arResult[$i]['Haber'];
                            }else{
                                $haber='';
                            }
                            ?>
                            <tr>
                                <td onClick="<?php echo $link; ?>"><?php echo '<!-- '.$fecha[2].$fecha[1].$fecha[0].' -->'.$arResult[$i]['Fecha']; ?></td>
                                <td align="center" onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['Asiento']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['Concepto']; ?></td>
                                <td align="right" onClick="<?php echo $link; ?>"><?php echo formateaNumeroContabilidad($debe); ?></td>
                                <td align="right" onClick="<?php echo $link; ?>"><?php echo formateaNumeroContabilidad($haber); ?></td>
                                <td align="right" onClick="<?php echo $link; ?>"><?php echo formateaNumeroContabilidad($arResult[$i]['Saldo']); ?></td>
                                <td align="center"><?php echo '<a href="../vista/gastos_editar.php?Asiento=' . $arResult[$i]['Asiento'] ."&TipoAsiento=".$arResult[$i]['TipoAsiento'].'&borrar=si"><img src="../images/error.png" width="10" height="10" border="0"/></a>'; ?></td>
                            </tr>
                            <?php
                            //aqui sumo los debe y haber y saldo de esta cuenta para presentarlo al final
                            $totalDebe=$totalDebe+$arResult[$i]['Debe'];
                            $totalHaber=$totalHaber+$arResult[$i]['Haber'];
                        }
                    }
                    ?>
                </tbody>
            </table>
            <div align="center">
                <script languaje="JavaScript"> 
                    function volver(){
                        javascript:history.back();
                    }
                </script>
                <input class="button" type="button" value="Volver" onclick="volver();" />
                <table>
                    <thead>
                        <tr bgColor="#DFDFDF">
                            <th>Total Debe</th>
                            <th>Total Haber</th>
                            <th>Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr bgColor="#A8D3F5">
                            <td width="140" align="center"><?php echo formateaNumeroContabilidad($totalDebe); ?></td>
                            <td width="140" align="center"><?php echo formateaNumeroContabilidad($totalHaber); ?></td>
                            <td width="140" align="center"><?php echo formateaNumeroContabilidad($totalDebe-$totalHaber); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <br/><br/><br/>
            <?php include '../vista/IndicacionIncidencia.php'; ?>
        </td>
        </tr>
        </table>
    </body>
</html>
<?php
}


function html_paginaMovil($arResult){
?>
<!DOCTYPE html>
<html>
<head>
<TITLE>Modificar Asiento - Listar Asientos de Cuenta</TITLE>

<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>
</head> 
    <body>
    <div data-role="page" id="listado_asientos2">
    <?php
    eventosInputText();
    ?>

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>
        
    <div data-role="content" data-theme="a">
        <h3 align="center" color="#FFCC66">
            <font size="3px">Modificar Asiento - Listado</font>
        </h3>
        <br/>
        <ul data-role="listview" data-dividertheme="a" data-filter="true" data-filter-placeHolder="Buscar">
            <li data-role="list-divider">Código&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nombre</li>
            <?php
            //sumas de debe y haber
            $totalDebe=0;
            $totalHaber=0;
            
            if(is_array($arResult)){
                for ($i = 0; $i < count($arResult); $i++) {
                    //la fecha la dividimos en dias , meses y años
                    $fecha=explode('/',$arResult[$i]['Fecha']);
                    $link="javascript:document.location.href='../vista/gastos_editar.php?Asiento=".$arResult[$i]['Asiento']."&TipoAsiento=".$arResult[$i]['TipoAsiento']."'";
                    //si debe = 0.00 lo indico en blanco
                    if($arResult[$i]['Debe']<>0){
                        $debe=$arResult[$i]['Debe'];
                    }else{
                        $debe='';
                    }
                    //si haber = 0.00 lo indico en blanco
                    if($arResult[$i]['Haber']<>0){
                        $haber=$arResult[$i]['Haber'];
                    }else{
                        $haber='';
                    }
                    ?>
                    <li onClick="<?php echo $link; ?>">
                        <a href="#" data-ajax="false">
                        <?php echo '<font color="30a53b">Fecha: </font>'."<!-- ".$fecha[2].$fecha[1].$fecha[0].' -->'.$arResult[$i]['Fecha']. '   <font color="3ba5ba">Asiento: '.$arResult[$i]['Asiento'].'</font><br/>'; ?>
                        <?php echo '<font color="30a53b">Concepto: </font><br/>'; ?>
                        <?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$arResult[$i]['Concepto'].'<br/><br/>'; ?>
                        <?php echo '<table border="0" align="center">'; ?>
                        <?php echo '<tr><td style="width: 30%;"><font color="30a53b">Debe:</font></td>'; ?>
                        <?php echo '<td style="width: 30%;"><font color="30a53b">Haber:</font></td>'; ?>
                        <?php echo '<td style="width: 30%;"><font color="30a53b">Saldo:</font></td></tr>'; ?>
                        <?php echo '<tr><td colspan="3"><hr/></td></tr>'; ?>
                        <?php echo '<tr><td><font color="">'.formateaNumeroContabilidad($debe).'</font></td>'; ?>
                        <?php echo '<td><font color="">'.formateaNumeroContabilidad($haber).'</font></td>'; ?>
                        <?php echo '<td><font color="">'.formateaNumeroContabilidad($arResult[$i]['Saldo']).'</font></td></tr>'; ?>
                        <?php echo '</table>'; ?>
                        </a>
                    </li>
                    <?php
                    //aqui sumo los debe y haber y saldo de esta cuenta para presentarlo al final
                    $totalDebe=$totalDebe+$arResult[$i]['Debe'];
                    $totalHaber=$totalHaber+$arResult[$i]['Haber'];
                }
            }
            ?>
        </ul>
    </div>   
    <br/><br/>    
    <div align="center">
        <script languaje="JavaScript"> 
            function volver(){
                javascript:history.back();
            }
        </script>
        <input class="button" type="button" value="Volver" onclick="volver();" />
        <br/><br/>    
        <table>
            <thead>
                <tr bgColor="#DFDFDF">
                    <th>Total Debe</th>
                    <th>Total Haber</th>
                    <th>Saldo</th>
                </tr>
            </thead>
            <tbody>
                <tr bgColor="#A8D3F5">
                    <td width="140" align="center"><?php echo formateaNumeroContabilidad($totalDebe); ?></td>
                    <td width="140" align="center"><?php echo formateaNumeroContabilidad($totalHaber); ?></td>
                    <td width="140" align="center"><?php echo formateaNumeroContabilidad($totalDebe-$totalHaber); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
            
    </div>    
    <script type="text/javascript" charset="utf-8">
    </script>
    </body>
</html>
<?php
}
?>