<?php
//VER ERRORES
//error_reporting(E_ALL); 


session_start ();
require_once '../CN/clsCNDatosVentas.php';
require_once '../CAD/clsCADLogin.php';
require_once '../general/funcionesGenerales.php';


////Control de Sesion
//ControlaLoginTimeOut();
//
////Control de Permisos. Hay que incluirlo en todas las páginas
///**************************************************************/
//$strPagina=dameURL();
//$strCargo = trim($_SESSION['cargo']);   //Esto es el puesto al que le hacemos un trim
//
//$lngPermiso = AccesoUsuarioPagina ($strPagina, $strCargo);  // Le pasamos la página y el cargo. 
//
//if ($lngPermiso==-1)
//{//Se ha producido un error de base. TENDREMOS QUE PASAR A LA FUNCION ERROR
//    ControlErrorPermiso();
//    die;
//}
//if ($lngPermiso==0)
//{//El usuario no tiene permisos por tanto mostramos error
//    ControlAvisoPermiso();
//    die;
//}

//Si devuelve 1 entonces que siga el flujo 
/**************************************************************/

$clsCNDatosVentas = new clsCNDatosVentas();
$clsCNDatosVentas->setStrBD($_SESSION['dbContabilidad']);
$clsCNDatosVentas->setStrBDCliente($_SESSION['mapeo']);

$clsCADLogin = new clsCADLogin();
//primero busco la variable de 'IvaGenerico' de la tabla 'tbparametros_generales'
$IvaGenerico = $clsCADLogin->Parametro_general('IvaGenerico',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));


logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
       " ||||entrada Datos de Ventas");


$listadoTarjetas = $clsCNDatosVentas->ListadoTarjetas();

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="../images/q.ico">
        <title>Ventas</title>
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
        <link rel="stylesheet" type="text/css" media="all" href="../js/jQuery/fancybox/style.css">
        <link rel="stylesheet" type="text/css" media="all" href="../js/jQuery/fancybox/jquery.fancybox.css">
        <script type="text/javascript" src="../js/jQuery/fancybox/jquery.fancybox.js?v=2.0.6"></script>
        <script type="text/javascript" src="../js/jQuery/autoresize/textareaAutoResize.js"></script>
        <!--       FIN     HE INCLUIDO AQUI ESTAS LIBRERIAS DE jQuery PACO-->

        <style>
            *{
                /*font-family: arial;*/
            }
        </style>
        <script type="text/javascript" charset="utf-8">
            //var editor; 
            
            $(document).ready(function(){
//                //formatear y traducir los datos de la tabla
//                $('#datatablesMod').dataTable({
//                    "bProcessing": true,
//                    "sPaginationType":"full_numbers",
//                    "oLanguage": {
//                        "sLengthMenu": "Ver _MENU_ registros por pagina",
//                        "sZeroRecords": "No se han encontrado registros",
//                        "sInfo": "Ver _START_ al _END_ de _TOTAL_ Registros",
//                        "sInfoEmpty": "Ver 0 al 0 de 0 registros",
//                        "sInfoFiltered": "(filtrados _MAX_ total registros)",
//                        "sSearch": "Busqueda:"
//                    },
//                    "bSort":true,
//                    "aaSorting": [[ 0, "asc" ]],
//                    "aoColumns": [
//			{ "sType": 'string' },
//			{ "sType": 'string' },
//			{ "sType": 'string' },
//			{ "sType": 'string' },
//			{ "sType": 'string' },
//			null,
//			{ "sType": 'string' },
//			{ "sType": 'string' },
//			{ "sType": 'string' },
//			{ "sType": 'string' },
//			{ "sType": 'string' },
//			{ "sType": 'string' },
//			{ "sType": 'string' }
//                    ],                    
//                    "bJQueryUI":true,
//                    "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]]
//                });
                
                
                
                
            });
        </script>
<style type="text/css">
/* para que no salga el rectangulo inferior */        
/*.ui-widget-content {
    border: 0px solid #AAAAAA;
}*/
</style>      

<script LANGUAGE="JavaScript"> 
//formatear valores numericos con puntos de miles y comas para decimales
function formateaNumContabilidad(objeto) {
    var numero = objeto.value;
    decimales=2;
    separador_decimal=',';
    separador_miles='.';
    numero=parseFloat(numero);
    if(isNaN(numero)){
        return "";
    }

    if(decimales!==undefined){
        // Redondeamos
        numero=numero.toFixed(decimales);
    }

    // Convertimos el punto en separador_decimal
    numero=numero.toString().replace(".", separador_decimal!==undefined ? separador_decimal : ",");

    if(separador_miles){
        // Añadimos los separadores de miles
        var miles=new RegExp("(-?[0-9]+)([0-9]{3})");
        while(miles.test(numero)) {
            numero=numero.replace(miles, "$1" + separador_miles + "$2");
        }
    }

    //actualizo el valor del objeto que se para por referencia
    objeto.value = numero;
    return true;
}

function desFormateaNumContabilidad(objeto) {
    var numero = objeto.value;
    //contar los puntos que hay
    var punto=".";
    var cont=0;
    for(i=0;i<numero.length;i++){
        var let=numero.substring(i,(i+1));
        if(punto===let){
            cont=cont + 1;
        }
    }
    //quitar los puntos de miles
    for (j=0;j<cont;j++){
        numero=numero.replace(".", "");
    }
    //cambiar la coma de decimales por punto
    numero=numero.replace(",", ".");
    
    //actualizo el valor del objeto que se para por referencia
    objeto.value = numero;
    return true;
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
            
            
    <?php require_once '../vista/cabecera2Asesor.php'; ?>
        
    <div align="center"><h3>Listado</h3></div>

    <form name="form1" action="../vista/ventas_listado.php" method="get">
    <table align="center" border="0" width="">
        <tr></tr>
        <tr><td>
    <div id="filtros" style="display: block;">
    <table class="filtro" align="center" border="0" width="725">
    <tr>
        <td width="150"></td>
        <td width="200"></td>
        <td width="100"></td>
        <td width="100"></td>
        <td width="200"></td>
        <td width=""></td>
    </tr>    
    <tr> 
      <td class="nombreCampo"><div align="right">Mes:</div></td>
      <td>
          <div align="left">
            <select name="mes" class="textbox1" tabindex="5">
                <option value=""></option>
                <option value="01" <?php if((isset($_GET['mes']) && $_GET['mes']==='01')){echo 'selected';}?>>Enero</option>
                <option value="02" <?php if((isset($_GET['mes']) && $_GET['mes']==='02')){echo 'selected';}?>>Febrero</option>
                <option value="03" <?php if((isset($_GET['mes']) && $_GET['mes']==='03')){echo 'selected';}?>>Marzo</option>
                <option value="04" <?php if((isset($_GET['mes']) && $_GET['mes']==='04')){echo 'selected';}?>>Abril</option>
                <option value="05" <?php if((isset($_GET['mes']) && $_GET['mes']==='05')){echo 'selected';}?>>Mayo</option>
                <option value="06" <?php if((isset($_GET['mes']) && $_GET['mes']==='06')){echo 'selected';}?>>Junio</option>
                <option value="07" <?php if((isset($_GET['mes']) && $_GET['mes']==='07')){echo 'selected';}?>>Julio</option>
                <option value="08" <?php if((isset($_GET['mes']) && $_GET['mes']==='08')){echo 'selected';}?>>Agosto</option>
                <option value="09" <?php if((isset($_GET['mes']) && $_GET['mes']==='09')){echo 'selected';}?>>Septiembre</option>
                <option value="10" <?php if((isset($_GET['mes']) && $_GET['mes']==='10')){echo 'selected';}?>>Octubre</option>
                <option value="11" <?php if((isset($_GET['mes']) && $_GET['mes']==='11')){echo 'selected';}?>>Noviembre</option>
                <option value="12" <?php if((isset($_GET['mes']) && $_GET['mes']==='12')){echo 'selected';}?>>Diciembre</option>
            </select>
          </div>
      </td>
      <td></td>
      <td class="nombreCampo"><div align="right">Ejercicio:</div></td>
      <td>
          <div align="left">
            <select name="ejercicio" class="textbox1" tabindex="5">
                <?php
                $selec2015 = '';
                $selec2016 = '';
                $selec2017 = '';
                $selec2018 = '';
                if(isset($_GET['ejercicio'])){
                    if($_GET['ejercicio']==='2015'){
                        $selec2015 = 'selected';
                    }else
                    if($_GET['ejercicio']==='2016'){
                        $selec2016 = 'selected';
                    }else
                    if($_GET['ejercicio']==='2017'){
                        $selec2017 = 'selected';
                    }else
                    if($_GET['ejercicio']==='2018'){
                        $selec2018 = 'selected';
                    }
                }else{
                    if(date('Y') === '2015'){
                        $selec2015 = 'selected';
                    }else
                    if(date('Y') === '2016'){
                        $selec2016 = 'selected';
                    }else
                    if(date('Y') === '2017'){
                        $selec2017 = 'selected';
                    }else
                    if(date('Y') === '2018'){
                        $selec2018 = 'selected';
                    }
                }
                ?>
                <option value="2015" <?php echo $selec2015; ?>>2015</option>
                <option value="2016" <?php echo $selec2016; ?>>2016</option>
                <option value="2017" <?php echo $selec2017; ?>>2017</option>
                <option value="2018" <?php echo $selec2018; ?>>2018</option>
            </select>
          </div>
      </td>
      <td class="nombreCampo" rowspan="2" colspan="2" nowrap>
      </td>
    </tr>
    
    <tr> 
      <td colspan="8"><hr align="left"></td>
    </tr>
     <tr align="center">
         <td colspan="8">
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
    
            <?php
                $arResult = $clsCNDatosVentas->ListadoVentas($_GET);
                //var_dump($arResult);die;
            ?>

            <br/>
            <style>
                .inputDatos{
                    background-color: transparent;
                    border: 0px solid;
                    width: 90px;
                    text-align:right;
                }
                .inputDatosTarjeta{
                    background-color: transparent;
                    border: 0px solid;
                    width: 150px;
                }
                .labelDatos{
                    font-size: 14px;
                }
                
                /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
                 * DataTables display
                 */
                table.tablaExcel {
                    margin: 0 auto;
                    clear: both;
                    border-collapse: collapse;
                    font-size: 12px;
                }

                table.tablaExcel thead th {
                    padding: 2px 2px 2px 5px;
                    font-weight: bold;
                    font-size: 13px;
                }

                table.tablaExcel tr.heading2 td {
/*                        border-bottom: 1px solid #aaa;*/
                }

                table.tablaExcel td {
                    padding: 2px 5px;
                }

                table.tablaExcel td.center {
                        /*text-align: center;*/
                }
                
                
                
                
            </style>
            
            <script type="text/javascript">
                function actEstadoAsiento(iTabla,valor){
                    //recupero el valor de IdVenta
                    var IdVenta = $('#IdVenta'+iTabla).val();
                    var fecha = $('#fecha'+iTabla).val();
                    
                    //actualizo el valor en la BBDD
                    $.ajax({
                        data:{"iTabla":iTabla,"IdVenta":IdVenta,"Asiento":valor,"fecha":fecha},
                        url: '../vista/ajax/ventas_ventas_actAsiento.php',
                        type:"get",
                        success: function(data) {
                            var datos = JSON.parse(data);
                            //actualizo el campo de IdVenta (por si se a insertado este valor en la tabla)
                            $('#IdVenta'+datos.iTabla).val(datos.IdVenta);
                        }
                    });
                    
                }
                
            </script>            
            <form id="formBancos" name="form2" method="post" action="../vista/ventas_listado_contabilizando.php">
            <?php
            //voy a recorrer todos los dias del mes y ejercicio
            //$mes = date('m');
            if(isset($_GET['mes'])){
                $mes = $_GET['mes'];
            }
            $mesTxt = '';
            switch ($mes) {
                case '01':
                    $mesTxt = 'Enero';
                    break;
                case '02':
                    $mesTxt = 'Febrero';
                    break;
                case '03':
                    $mesTxt = 'Marzo';
                    break;
                case '04':
                    $mesTxt = 'Abril';
                    break;
                case '05':
                    $mesTxt = 'Mayo';
                    break;
                case '06':
                    $mesTxt = 'Junio';
                    break;
                case '07':
                    $mesTxt = 'Julio';
                    break;
                case '08':
                    $mesTxt = 'Agosto';
                    break;
                case '09':
                    $mesTxt = 'Septiembre';
                    break;
                case '10':
                    $mesTxt = 'Octubre';
                    break;
                case '11':
                    $mesTxt = 'Noviembre';
                    break;
                case '12':
                    $mesTxt = 'Diciembre';
                    break;
            }
            
            $ejercicio = date('Y');
            if(isset($_GET['ejercicio'])){
                $ejercicio = $_GET['ejercicio'];
            }
            ?>
            <?php if(isset($mes) && $mes !== ''){  ?>
            <h4 align="center"><?php echo $mesTxt . ' - ' . $ejercicio; ?></h4>
            <table id="datatablesMod" class="tablaExcel" border="1">
                <thead>
                    <tr>
                        <th colspan="6">Bancos</th>
                        <th colspan="6">Tarjetas/Cheques</th>
                        <th colspan="5">Ventas</th>
                    </tr>
                    <tr>
                        <th width="5%">Fecha</th>
                        <th width="10%">C.Distribuir</th>
                        <th width="5%">D</th>
                        <th width="10%">Cantidad</th>
                        <th width="10%">Banco</th>
                        <th width="5%">Asiento</th>
                        <th width="10%">Tarjeta</th>
                        <th width="10%">Bruto</th>
                        <th width="10%">Comisión</th>
                        <th width="10%">Liquido</th>
                        <th width="10%">Banco</th>
                        <th width="5%">Asiento</th>
                        <th width="5%">Base I.</th>
                        <th width="5%">IVA(<?php echo $IvaGenerico;?>%)</th>
                        <th width="5%">Ventas</th>
                        <th width="5%">Asiento</th>
                        <th width="5%">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //compruebo si hay datos
                    if(is_array($arResult)){
                        //voy a recorrer todos los dias del mes y ejercicio
                        $mes = date('m');
                        if(isset($_GET['mes'])){
                            $mes = $_GET['mes'];
                        }
                        $ejercicio = date('Y');
                        if(isset($_GET['ejercicio'])){
                            $ejercicio = $_GET['ejercicio'];
                        }
                        
                        //indico el recorrido por los dias del mes 
                        $fechaInicio = 1;
                        $month = $ejercicio.'-'.$mes;
                        $aux = date('Y-m-d', strtotime("{$month} + 1 month"));
                        $fechaFin = date('d', strtotime("{$aux} - 1 day"));
                        
                        $par = 'NO';
                        //vbles de sumas parciales de ventas
                        $ventas_dia = 0;
                        $BaseI_dia = 0;
                        $IVA_dia = 0;
                        $dia_calculo = '';
                        
                        $sumaBaseI = 0;
                        $sumaIVA = 0;
                        $sumaVentas = 0;
                        
                        $sumaBruto = 0;
                        $sumaComision = 0;
                        $sumaLiquido = 0;
                        
                        for($i = $fechaInicio; $i <= $fechaFin; $i++){
                            //preparo el array de $arResult[$i] para enviar por url
                            $link="";
                            
                            $dia = $i.'/'.$mes.'/'.$ejercicio;
                            if(strlen($dia)<10){
                                $dia = '0' . $dia;
                            }
                            
                            for ($ii = 0; $ii < count($arResult); $ii++) {
                                if($dia === $arResult[$ii]['Fecha']){
                                    $fecha = explode('/',$dia);
                                    $fecha = $fecha[2].$fecha[1].$fecha[0];
                                    $dia_calculo = $arResult[$ii]['Fecha'];
                                    $dia_calculo_anterior = $arResult[$ii+1]['Fecha'];
                                    
                                    $colorBkgd = 'ffffff';
                                    if($par === 'NO'){
                                        $colorBkgd = 'e8f4ff';
                                        $par = 'SI';
                                    }else{
                                        $par = 'NO';
                                    }
                                    
                                    //suma parcial
                                    $sumaDistribuir = (float)$sumaDistribuir + (float)$arResult[$ii]['Cantidad_distribuir'];
                                    $sumaCantidades = (float)$sumaCantidades + (float)$arResult[$ii]['Cantidad'];
                                    $sumaDiferencia = $sumaDistribuir - $sumaCantidades;
                                    
                                    $sumaBruto = (float)$sumaBruto + (float)$arResult[$ii]['Bruto'];
                                    $sumaComision = (float)$sumaComision + (float)$arResult[$ii]['Comision'];
                                    $sumaLiquido = (float)$sumaLiquido + (float)$arResult[$ii]['Liquido'];
                                    
                                ?>
                                <tr style="background-color: #<?php echo $colorBkgd; ?>;">
                                    <!-- Banco  -->
                                    <td onClick="<?php echo $link; ?>">
                                        <label class="labelDatos"><?php echo $dia; ?></label>
                                    </td>
                                    <td onClick="<?php echo $link; ?>">
                                        <div align="right">
                                            <label class="labelDatos"><?php echo formateaNumeroContabilidad($arResult[$ii]['Cantidad_distribuir']); ?></label>
                                        </div>
                                    </td>
                                    <td onClick="<?php echo $link; ?>">
                                        <div align="center">
                                            <input type="checkbox" name="Distribuir<?php echo $ii;?>" value="<?php echo $arResult[$ii]['Distribuir']; ?>" <?php if($arResult[$ii]['Distribuir'] === '1'){echo 'checked';}?> tabindex="<?php echo $ii;?>0003" disabled />
                                        </div>
                                    </td>
                                    <td onClick="<?php echo $link; ?>">
                                        <div align="right">
                                            <label class="labelDatos"><?php echo formateaNumeroContabilidad($arResult[$ii]['Cantidad']); ?></label>
                                        </div>
                                    </td>
                                    <td onClick="<?php echo $link; ?>">
                                        <div style="width: 120px;">
                                            <label class="labelDatos">
                                                <?php 
                                                echo $clsCNDatosVentas->nombreCuenta($arResult[$ii]['Cuenta']); 
                                                ?>
                                            </label>
                                        </div>
                                    </td>
                                    <td onClick="<?php echo $link; ?>" style="background-color: #f7f7f7;">
                                        <div align="center">
                                            <label class="labelDatos"><?php echo $arResult[$ii]['AsientoBanco']; ?></label>
                                            <?php
                                            $IdBanco = '';
                                            if($arResult[$ii]['AsientoBanco'] === 'P'){
                                                $IdBanco = $arResult[$ii]['IdBanco'];
                                            }
                                            ?>
                                            <input type="hidden" id="AsientoBanco<?php echo $ii; ?>" name="AsientoBanco<?php echo $ii; ?>" value="<?php echo $arResult[$ii]['AsientoBanco']; ?>" />
                                            <input type="hidden" id="IdBanco<?php echo $ii; ?>" name="IdBanco<?php echo $ii; ?>" value="<?php echo $IdBanco; ?>" />
                                            <input type="hidden" id="IdBancoFecha<?php echo $ii; ?>" name="IdBancoFecha<?php echo $ii; ?>" value="<?php echo $arResult[$ii]['Fecha']; ?>" />
                                            <input type="hidden" id="CuentaBanco<?php echo $ii; ?>" name="CuentaBanco<?php echo $ii; ?>" value="<?php echo $arResult[$ii]['Cuenta']; ?>" />
                                            <input type="hidden" id="Cantidad<?php echo $ii; ?>" name="Cantidad<?php echo $ii; ?>" value="<?php echo $arResult[$ii]['Cantidad']; ?>" />
                                        </div>
                                    </td>
                                    
                                    <!-- Tarjeta  -->
                                    <td onClick="<?php echo $link; ?>">
                                        <div  style="width: 120px;">
                                            <label class="labelDatos"><?php echo $clsCNDatosVentas->nombreTarjeta($arResult[$ii]['TipoTarjeta']); ?></label>
                                        </div>
                                    </td>
                                    <td onClick="<?php echo $link; ?>">
                                        <div align="right">
                                            <label class="labelDatos"><?php echo formateaNumeroContabilidad($arResult[$ii]['Bruto']); ?></label>
                                        </div>
                                    </td>
                                    <td onClick="<?php echo $link; ?>">
                                        <div align="right">
                                            <label class="labelDatos"><?php echo formateaNumeroContabilidad($arResult[$ii]['Comision']); ?></label>
                                        </div>
                                    </td>
                                    <td onClick="<?php echo $link; ?>">
                                        <div align="right">
                                            <label class="labelDatos"><?php echo formateaNumeroContabilidad($arResult[$ii]['Liquido']); ?></label>
                                        </div>
                                    </td>
                                    <td onClick="<?php echo $link; ?>">
                                        <div style="width: 120px;">
                                            <label class="labelDatos"><?php echo $clsCNDatosVentas->nombreCuenta($arResult[$ii]['CuentaTarjeta']); ?></label>
                                        </div>
                                    </td>
                                    <td onClick="<?php echo $link; ?>" style="background-color: #f7f7f7;">
                                        <div align="center">
                                            <label class="labelDatos"><?php echo $arResult[$ii]['AsientoTarjeta']; ?></label>
                                            <?php
                                            $IdTarjeta = '';
                                            if($arResult[$ii]['AsientoTarjeta'] === 'P'){
                                                $IdTarjeta = $arResult[$ii]['IdTarjeta'];
                                            }
                                            ?>
                                            <input type="hidden" id="nombreTarjeta<?php echo $ii; ?>" name="nombreTarjeta<?php echo $ii; ?>" value="<?php echo $clsCNDatosVentas->nombreTarjeta($arResult[$ii]['TipoTarjeta']); ?>" />
                                            <input type="hidden" id="AsientoTarjeta<?php echo $ii; ?>" name="AsientoTarjeta<?php echo $ii; ?>" value="<?php echo $arResult[$ii]['AsientoTarjeta']; ?>" />
                                            <input type="hidden" id="IdTarjeta<?php echo $ii; ?>" name="IdTarjeta<?php echo $ii; ?>" value="<?php echo $IdTarjeta; ?>" />
                                            <input type="hidden" id="IdTarjetaFecha<?php echo $ii; ?>" name="IdTarjetaFecha<?php echo $ii; ?>" value="<?php echo $arResult[$ii]['Fecha']; ?>" />
                                            <input type="hidden" id="TipoTarjeta<?php echo $ii; ?>" name="TipoTarjeta<?php echo $ii; ?>" value="<?php echo $arResult[$ii]['TipoTarjeta']; ?>" />
                                            <input type="hidden" id="CuentaTarjeta<?php echo $ii; ?>" name="CuentaTarjeta<?php echo $ii; ?>" value="<?php echo $arResult[$ii]['CuentaTarjeta']; ?>" />
                                            <input type="hidden" id="Bruto<?php echo $ii; ?>" name="Bruto<?php echo $ii; ?>" value="<?php echo $arResult[$ii]['Bruto']; ?>" />
                                            <input type="hidden" id="Comision<?php echo $ii; ?>" name="Comision<?php echo $ii; ?>" value="<?php echo $arResult[$ii]['Comision']; ?>" />
                                            <input type="hidden" id="Liquido<?php echo $ii; ?>" name="Liquido<?php echo $ii; ?>" value="<?php echo $arResult[$ii]['Liquido']; ?>" />
                                        </div>
                                    </td>
                                    <?php
                                    //Ventas
                                    //1º veo si hay datos guardado (vienen en el array $arResult)
                                    //veo $arResult[$ii]['DatoALeerDe'] != 'BBDD'
                                    //si es asi, escribo los datos del array (de la BBDD)
                                    //sino los calculo de los datos de las tablas "tbventas_bancos" y "tbventas_tarjetas"
                                    if($arResult[$ii]['DatoALeerDe'] === 'BBDD'){
                                        //escribo del array de la BBDD
                                        $ventas = $arResult[$ii]['Ventas'];
                                        $BaseI = $arResult[$ii]['BaseI'];
                                        $IVA = $arResult[$ii]['IVA'];
                                    }else{
                                        //hago los calculos necesarios para los campos de Base I. IVA y Ventas
                                        //Ventas = C.Distribuir + Bruto
                                        //BaseI = Ventas /(1+IVA)
                                        //IVA = Ventas - BaseI
                                        $ventas = $arResult[$ii]['Cantidad_distribuir'] + $arResult[$ii]['Bruto'];
                                        $BaseI = round($ventas / (($IvaGenerico / 100) + 1),2);
                                        $IVA = $ventas - $BaseI;
                                    }
                                        
                                    //sumo a las vbles parciales
                                    $ventas_dia = (float)$ventas_dia + (float)$ventas;
                                    $BaseI_dia = (float)$BaseI_dia + (float)$BaseI;
                                    $IVA_dia = (float)$IVA_dia + (float)$IVA;
                                    
                                    
                                    //ahora compruebo si el dia de hoy es distinto o no al anterior
                                    //si es distinto, escribo stos valores en el cuadro
                                    $txtBaseI = '';
                                    $txtIVA = '';
                                    $txtVentas = '';
                                    if($dia_calculo !== $dia_calculo_anterior){
                                        //escribo las sumas en el cuadro
                                        $txtBaseI = $BaseI_dia;
                                        if($txtBaseI === (float)0){
                                            $txtBaseI = '';
                                        }
                                        $txtIVA = $IVA_dia;
                                        if($txtIVA === (float)0){
                                            $txtIVA = '';
                                        }
                                        $txtVentas = $ventas_dia;
                                        if($txtVentas === (float)0){
                                            $txtVentas = '';
                                        }
                                        //las sumas
                                        $sumaBaseI = (float)$sumaBaseI + (float)$BaseI_dia;
                                        $sumaIVA =  (float)$sumaIVA + (float)$IVA_dia;
                                        $sumaVentas =  (float)$sumaVentas + (float)$ventas_dia;
                                        
                                        //pongo las vbles a 0
                                        $BaseI_dia = 0;
                                        $IVA_dia = 0;
                                        $ventas_dia = 0;
                                    }
                                    
                                    
                                    ?>
                                    <!-- Ventas  -->
                                    <td onClick="<?php echo $link; ?>">
                                        <div align="right">
                                            <label class="labelDatos"><?php echo formateaNumeroContabilidad($txtBaseI); ?></label>
                                            <input type="hidden" id="BaseI<?php echo $ii; ?>" name="BaseI<?php echo $ii; ?>" value="<?php echo $txtBaseI; ?>" />
                                        </div>
                                    </td>
                                    <td onClick="<?php echo $link; ?>">
                                        <div align="right">
                                            <label class="labelDatos"><?php echo formateaNumeroContabilidad($txtIVA); ?></label>
                                            <input type="hidden" id="IVA<?php echo $ii; ?>" name="IVA<?php echo $ii; ?>" value="<?php echo $txtIVA; ?>" />
                                        </div>
                                    </td>
                                    <td onClick="<?php echo $link; ?>">
                                        <div align="right">
                                            <label class="labelDatos"><?php echo formateaNumeroContabilidad($txtVentas); ?></label>
                                            <input type="hidden" id="Ventas<?php echo $ii; ?>" name="Ventas<?php echo $ii; ?>" value="<?php echo $txtVentas; ?>" />
                                        </div>
                                    </td>
                                    <td onClick="<?php echo $link; ?>" style="background-color: #f7f7f7;">
                                        <div align="center">
                                        <?php
                                        //leo de la BBDD $arRsult, si viene dato se lo casco, 
                                        //sino le pongo el select con P por defecto
                                        if($txtVentas !== ''){
                                            if($arResult[$ii]['AsientoVentas'] === 'P' || $arResult[$ii]['AsientoVentas'] === 'X' || $arResult[$ii]['AsientoVentas'] === ''){
                                                $html = "<select id='AsientoVentas".$ii."' name='AsientoVentas".$ii."' tabindex='".$ii."00001' onchange='actEstadoAsiento(".$ii.",this.value);'>";
                                                $seleP = '';
                                                $seleX = '';
                                                if($arResult[$ii]['AsientoVentas'] === 'X'){
                                                    $seleX = 'selected';
                                                }else{
                                                    $seleP = 'selected';
                                                }
                                                $html = $html . '<option value="P" '.$seleP.'>P</option>';
                                                $html = $html . '<option value="X" '.$seleX.'>X</option>';
                                                $html = $html . '</select>';

                                                echo $html;
                                            }else{
                                                echo '<label class="labelDatos">' . $arResult[$ii]['AsientoVentas'] . '</label>';
                                            }
                                        }
                                        ?>
                                            <input type="hidden" id="IdVenta<?php echo $ii; ?>" name="IdVenta<?php echo $ii; ?>" value="<?php echo $arResult[$ii]['IdVenta']; ?>" />
                                            <input type="hidden" id="fecha<?php echo $ii; ?>" name="fecha<?php echo $ii; ?>" value="<?php echo $arResult[$ii]['Fecha']; ?>" />
                                        </div>
                                    </td>
                                    <td onClick="<?php echo $link; ?>">
                                        <label class="labelDatos"><?php echo $dia; ?></label>
                                    </td>
                                </tr>
                                <?php
                                }
                            }
                            
                        }
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td align="right">
                            <span id="sumaCD" class="labelDatos"><b><?php echo formateaNumeroContabilidad($sumaDistribuir); ?></b></span>
                        </td>
                        <td align="right">
                            <span id="diferencia" class="labelDatos"><b><?php echo formateaNumeroContabilidad($sumaDiferencia); ?></b></span>
                        </td>
                        <td align="right">
                            <span id="sumaCantidad" class="labelDatos"><b><?php echo formateaNumeroContabilidad($sumaCantidades); ?></b></span>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td align="right">
                            <span id="sumaCantidad" class="labelDatos"><b><?php echo formateaNumeroContabilidad($sumaBruto); ?></b></span>
                        </td>
                        <td align="right">
                            <span id="sumaCantidad" class="labelDatos"><b><?php echo formateaNumeroContabilidad($sumaComision); ?></b></span>
                        </td>
                        <td align="right">
                            <span id="sumaCantidad" class="labelDatos"><b><?php echo formateaNumeroContabilidad($sumaLiquido); ?></b></span>
                        </td>
                        <td></td>
                        <td></td>
                        <td align="right">
                            <span id="sumaCantidad" class="labelDatos"><b><?php echo formateaNumeroContabilidad($sumaBaseI); ?></b></span>
                        </td>
                        <td align="right">
                            <span id="sumaCantidad" class="labelDatos"><b><?php echo formateaNumeroContabilidad($sumaIVA); ?></b></span>
                        </td>
                        <td align="right">
                            <span id="sumaCantidad" class="labelDatos"><b><?php echo formateaNumeroContabilidad($sumaVentas); ?></b></span>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
            <br/><br/>
            <div align="center">
                <a class="modalbox" href="#inlineCont" onclick="contabilizar();"><input type="button" class="button" value="Contabilizar"></a>
            </div>
<!--            <a onclick="refrescar();"><input type="button" class="button" value="Refrescar Tabla"></a>-->
            <?php } ?>
            
            <script type="text/javascript">
                function contabilizar(){
                    
                    //aparece el formulario emergente
                    $(".modalbox").fancybox();
                    
                    //document.form1.submit();
                }
                
                function EnviarForm(){
                    //envio el formulario
                    document.getElementById('calculando').style.display = 'block';
                    document.form2.submit();
                }
                
                function cambiar(objeto){
                    var nombreObjeto = objeto.name;
                    
                    if(nombreObjeto.substr(0,2) === 'ct'){
                        var numero = nombreObjeto.substr(2);
                        var cuenta = 'tarj' + numero;
                        if(objeto.checked === true){
                            $('#'+cuenta).val('SI');
                        }else{
                            $('#'+cuenta).val('NO');
                        }
                    }
                    
                    switch(nombreObjeto) {
                        case 'contVentas':
                            if(objeto.checked === true){
                                $('#contabilizarVentas').val('SI');
                            }else{
                                $('#contabilizarVentas').val('NO');
                            }
                            break;
                        case 'contCaja':
                            if(objeto.checked === true){
                                $('#contabilizarCaja').val('SI');
                            }else{
                                $('#contabilizarCaja').val('NO');
                            }
                            break;
                        case 'contBancos':
                            if(objeto.checked === true){
                                $('#contabilizarBancos').val('SI');
                            }else{
                                $('#contabilizarBancos').val('NO');
                            }
                            break;
                        default:
                            break;
                    }                    

                }
            </script>
            <br/><br/><br/>
            <?php include '../vista/IndicacionIncidencia.php'; ?>

    <!--datos en hidden del formulario-->
    <input type="hidden" id="contabilizarVentas" name="contabilizarVentas" value="SI" />
    <input type="hidden" id="contabilizarCaja" name="contabilizarCaja" value="SI" />
    <input type="hidden" id="contabilizarBancos" name="contabilizarBancos" value="SI" />
    <?php
    for ($i = 0; $i < count($listadoTarjetas); $i++) {
    ?>
    <input type="hidden" id="tarj<?php echo $listadoTarjetas[$i]['NumCuenta']; ?>" name="tarj<?php echo $listadoTarjetas[$i]['NumCuenta']; ?>" value="SI" />
    <?php
    }
    ?>
    
    <!--formulario para seleccionar que se contabiliza   -->
    <style>
        #inlineCont { display: none; width: 400px; }
    </style>
    <div id="inlineCont" align="center">
        <h2>Contabilizar</h2>
        <table>
            <tr>
                <td>
                    <input type="checkbox" name="contVentas" checked onchange="cambiar(this);" />
                </td>
                <td>
                    <label class="nombreCampo">&nbsp;&nbsp;Ventas</label><br/>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="checkbox" name="contCaja" checked  onchange="cambiar(this);" />
                </td>
                <td>
                    <label class="nombreCampo">&nbsp;&nbsp;Caja</label><br/>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="checkbox" name="contBancos" checked  onchange="cambiar(this);" />
                </td>
                <td>
                    <label class="nombreCampo">&nbsp;&nbsp;Bancos</label><br/>
                </td>
            </tr>
        
        <?php
        for ($i = 0; $i < count($listadoTarjetas); $i++) {
            ?>
            <tr>
                <td>
                    <input type="checkbox" id="ct<?php echo $listadoTarjetas[$i]['NumCuenta']; ?>" name="ct<?php echo $listadoTarjetas[$i]['NumCuenta']; ?>" checked  onchange="cambiar(this);" />
                </td>
                <td>
                    <label class="nombreCampo">&nbsp;&nbsp;<?php echo $listadoTarjetas[$i]['Nombre']; ?></label><br/>
                </td>
            </tr>
            <?php
            }
        ?>
        </table>
        
        <br/><br/><br/>
        <input type="button" id="send" class="button" onclick="EnviarForm();" value="Comenzar" />
        <div id="calculando" align="center" style="display: none;"><img src="../images/cargar.gif" width="30" height="30" border="0"/></div>
    </div>
    </form>
            
        </td>
        </tr>
        </table>
        
    </body>
</html>
