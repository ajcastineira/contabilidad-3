<?php
session_start();
require_once '../general/funcionesGenerales.php';
require '../general/phpmailer/PHPMailerAutoload.php';


//borramos los datos de la vble de session $_SESSION['facturasCobradas']
unset($_SESSION['facturasCobradas']);

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
       " ||||Operaciones->Modificar Asiento||");

date_default_timezone_set('Europe/Madrid');
$fechaForm=date('d/m/Y');


//CORREO A EL CLIENTE (1 correo) y al Usuario Copia (1 correo)
function EnviaCorreoAlCliente($Usuario,$strMail, $from,$txtBody){
    
    $to=$strMail;

    $mail = new PHPMailer();
    //Correo desde donde se envía (from)
    $mail->setFrom($from, '');
    //Correo de envío (to)
    $mail->addAddress($to, '');
    $mail->addCC($from, '');
    $mail->CharSet = "UTF-8";
    $mail->Subject = "Facturas Pendientes de ".$Usuario;

    $html='<!DOCTYPE html>
            <html>
                <head>
                    <title>Q-Conta</title>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width">
                    <style>
                    .tablaFacturas{
                        text-align: right;
                    }
                    .tablaFacturas tr td{
                        width: 100px;
                    }
                    </style>
                </head>
                <body>
                
                    '.$txtBody.'

                </body>
            </html>';

    //Lee un HTML message body desde un fichero externo,
    //convierte HTML un plain-text básico 
    $mail->msgHTML($html);

    if (!$mail->send()) {
        logger('traza',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['srtBD'].', SesionID: '.  session_id().
               " Correo NO Enviado.");
    } else {
        logger('traza',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['srtBD'].', SesionID: '.  session_id().
               " Correo Enviado CORRECTAMENTE.");
    }
}

//calculos de importe de facturas cobradas para el grafico inicial
$calculosGrafica = $clsCNContabilidad->FacturasCobrosGrafica();



//navegacion principal
if(isset($_POST['opcion']) && $_POST['opcion']==='reclamar'){
    //extraigo el correo de quien lo envia
    $from = $clsCNContabilidad->ParametrosGenerales_email();
    //recojo el listado de facturas que se van a reclamar
    $listadoFacturas = '';
    foreach ($_POST as $key => $value) {
        if(substr($key,0,5) === 'recla'){
            $Facturas['numeroFactura'] = substr($key,5);
            //busco el cliente de esta factura
            $datosFactura = $clsCNContabilidad->datosFactura($Facturas['numeroFactura']);
            $Facturas['NumFactura'] = $datosFactura['NumFactura'];
            $Facturas['Cliente'] = $datosFactura['Cliente'];
            $Facturas['NombreEmpresa'] = $datosFactura['NombreEmpresa'];
            $Facturas['Correo'] = $datosFactura['Correo'];
            
            $Facturas['Importe'] = $_POST['importe'.$Facturas['numeroFactura']];
            $Facturas['Pendiente'] = $_POST['pendiente'.$Facturas['numeroFactura']];
            $Facturas['Vencimiento'] = $_POST['vtoFactura'.$Facturas['numeroFactura']];
            
            //por ultimo añado estos datos al array
            $listadoFacturas[] = $Facturas;
        }
    }

    //ahora preparo este array para que salga organizado de esta forma:
    //Cliente->numeroFactura
    $listadoClientes = '';
    for ($i = 0; $i < count($listadoFacturas); $i++) {
        //compruebo si este cliente existe en el array
        $listfacturas = '';
        $cliente = array(
            "NombreEmpresa" => $listadoFacturas[$i]['NombreEmpresa'],
            "Correo" => $listadoFacturas[$i]['Correo'],
        );
        if (array_key_exists($listadoFacturas[$i]['Cliente'], $listadoClientes)) {
            $listadoClientes[$listadoFacturas[$i]['Cliente']]['facturas'][] = array(
                "NumFactura"=>$listadoFacturas[$i]['NumFactura'],
                "Importe"=>$listadoFacturas[$i]['Importe'],
                "Pendiente"=>$listadoFacturas[$i]['Pendiente'],
                "Vencimiento"=>$listadoFacturas[$i]['Vencimiento']
            );
        }else{
            $listfacturas["datosCliente"] = $cliente;
            $listfacturas["facturas"][] = array(
                "NumFactura"=>$listadoFacturas[$i]['NumFactura'],
                "Importe"=>$listadoFacturas[$i]['Importe'],
                "Pendiente"=>$listadoFacturas[$i]['Pendiente'],
                "Vencimiento"=>$listadoFacturas[$i]['Vencimiento']
            );
            $listadoClientes[$listadoFacturas[$i]['Cliente']] = $listfacturas;
        }        
        
    }
    
    //por ultimo hago los envios de correos segun el listado de clientes
    foreach ($listadoClientes as $key => $value) {
        //primero peparo el texto donde indico en el correo las facturas que se estan reclamando
        $txtBody = '<p>Estimado cliente, de acuerdo con nuestra información se encuentran pendientes de pago las siguientes facturas:</p>';
        $txtBody = $txtBody . '<br/>';
        $txtBody = $txtBody . '<table class="tablaFacturas"><tr><th>Factura&nbsp;&nbsp;&nbsp;</th><th>Importe&nbsp;&nbsp;</th><th>Pendiente&nbsp;</th><th>Vencimiento</th></tr>';
        for ($i = 0; $i < count($value['facturas']); $i++) {
            $txtBody = $txtBody . '<tr><td>'.$value['facturas'][$i]['NumFactura'].'&nbsp;&nbsp;&nbsp;</td><td>'.formateaNumeroContabilidad($value['facturas'][$i]['Importe']).'&#8364;&nbsp;&nbsp;</td><td>'.formateaNumeroContabilidad($value['facturas'][$i]['Pendiente']).'&#8364;&nbsp;</td><td>'.$value['facturas'][$i]['Vencimiento'].'</td></tr>';
        }
        $txtBody = $txtBody . '</table>';
        $txtBody = $txtBody . '<br/>';
        $txtBody = $txtBody . '<p>Le rogamos su cancelación a la mayor brevedad posible.</p>';
        $txtBody = $txtBody . '<br/>';
        $txtBody = $txtBody . '<p>Saludos cordiales.</p>';

        logger('traza',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['srtBD'].', SesionID: '.  session_id().
               " Enviar Correo".$value['datosCliente']['NombreEmpresa'].'-'. $value['datosCliente']['Correo']);
        EnviaCorreoAlCliente($value['datosCliente']['NombreEmpresa'], $value['datosCliente']['Correo'], $from, $txtBody);
    }
 
    //una vez terminado se manda a exito
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/exito.php?Id=Se han enviado los correos de las reclamaciones de la facturas">';
    
}else
if(isset($_POST['opcion']) && $_POST['opcion']==='cobrar'){
    //recojo el listado de facturas que se van a reclamar
    $listadoFacturas = '';
    foreach ($_POST as $key => $value) {
        if(substr($key,0,8) === 'cantidad'){
            $Facturas['numeroFactura'] = substr($key,8);
            $Facturas['cantidad'] = desFormateaNumeroContabilidad($value);
            $Facturas['pendiente'] = $_POST['pendiente'.substr($key,8)];
            //por ultimo añado estos datos al array
            $listadoFacturas[] = $Facturas;
        }
    }
    
    //envio los datos a 'cobrar_facturas_proceso.php' para hacerlo por ajax
    //guardo este listado por session para enviarlo
    $_SESSION['listadoFacturas'] = $listadoFacturas;
    
    //ahora regojo los datos de datFecha y strCuentaBancos
    //si viene por PC vendran en el POST, si vienen por Movil es en SESSION
    //si vienen por SESSION cojo estos, sino cojo los del POST
    if(isset($_SESSION['datFecha']) && $_SESSION['datFecha'] !== '' && 
       isset($_SESSION['strCuentaBancos']) && $_SESSION['strCuentaBancos'] !== ''){
        $fecha = $_SESSION['datFecha'];
        $cuenta = $_SESSION['strCuentaBancos'];
        //borro estas vbles. de session temporal
        unset($_SESSION['datFecha']);
        unset($_SESSION['strCuentaBancos']);
    }else{
        $fecha = $_POST['datFecha'];
        $cuenta = $_POST['strCuentaBancos'];
    }
    
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/cobrar_facturas_proceso.php?fecha='.$fecha.'&cuenta57='.$cuenta.'">';die;
    
}else{

    //aqui dirijo a la presentacion en PC o Movil (APP)
    if($_SESSION['navegacion']==='movil'){
        html_paginaCobrarFacturaMovil($clsCNContabilidad,$calculosGrafica);
    }else{
        html_paginaCobrarFactura($clsCNContabilidad,$calculosGrafica);
    }
}

//calculos para la grafica
function MesTxt($mes){
    switch ($mes) {
        case '1':
            return 'Ene';
        case '2':
            return 'Feb';
        case '3':
            return 'Mar';
        case '4':
            return 'Abr';
        case '5':
            return 'May';
        case '6':
            return 'Jun';
        case '7':
            return 'Jul';
        case '8':
            return 'Ago';
        case '9':
            return 'Sep';
        case '10':
            return 'Oct';
        case '11':
            return 'Nov';
        case '12':
            return 'Dic';
        default:
            break;
    }
}

function html_paginaCobrarFactura($clsCNContabilidad,$calculosGrafica){

    $categories = "";
    $cobros = "";
    $contador = 12;
    for ($i = count($calculosGrafica); $i > 0; $i--) {
        if($contador > 0){
            $categories = "'" . MesTxt($calculosGrafica[$i-1]['Mes']) . '/' . $calculosGrafica[$i-1]['Ejercicio'] . "'," . $categories;
            $cobros = "" . $calculosGrafica[$i-1]['cantidad'] . "," . $cobros;
            $contador--;
        }else{
            break;
        }
    }
    $categories = trim($categories, ',');
    $categories = "[" . $categories . "]";
    $cobros = trim($cobros, ',');
    $cobros = "[" . $cobros . "]";

    
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="../images/q.ico">
        <title>Cobrar Facturas - Listado</title>
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
        
        <!-- graficas -->
        <script src="../js/highcharts/highcharts.js"></script>
        <script src="../js/highcharts/themes/sand-signika.js"></script>

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
			null,
			null,
			null,
			{ "sType": 'string' },
			{ "sType": 'string' },
			null,
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
            text: 'Importe de Cobro'
        },
        xAxis: {
            categories: <?php echo $categories; ?>
        },
        credits: {
            enabled: false
        },        
        yAxis: {
            min: 0,
            title: {
                text: 'Importe'
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
                    this.series.name + ': ' + 'Total: ' + Highcharts.numberFormat(this.point.stackTotal, 2, ',', '.');
            }
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: false,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                    style: {
                        textShadow: '0 0 3px black'
                    }
                }
            }
        },
        series: [{
            name: 'Importe',
            data: <?php echo $cobros; ?>
        }]
    });
});
</script>                            



<script LANGUAGE="JavaScript"> 

function desFormateaCantidad(objeto){
    objeto.value=desFormateaNumeroContabilidad(objeto.value);
}

//formateo de numeros
function formateaCantidad(objeto){
    objeto.value=formateaNumeroContabilidad(objeto.value);
}    

function reclamar(){
    //comprobamos que este alguna factura seleccionada
    var hayRecla='false';
    $('#datatablesMod').find(":checkbox").each(function(){
        var elemento=this;
        if(elemento.checked===true){
            var nombre = elemento.name;
            var recla = nombre.substr(0,5);
            if(recla === 'recla'){
                hayRecla='true';
            }
        }
    });
    
    if(hayRecla==='true'){
        alert('Comienza el proceso de reclamar facturas.');
        document.form2.opcion.value = 'reclamar';
        document.getElementById("cmdReclamar").value = "Procensando...";
        document.getElementById("cmdReclamar").disabled = true;
        document.form2.submit();
    }else{
        alert('No hay seleccionada ninguna factura para reclamar.');
        return false;
    }
}

function cobrar(){
    //comprobamos que este alguna factura seleccionada
    var hayCobro=false;
    var textoError = '';
    $('#datatablesMod').find(":checkbox").each(function(){
        var elemento=this;
        if(elemento.checked===true){
            var nombre = elemento.name;
            var cobro = nombre.substr(0,5);
            if(cobro === 'cobro'){
                hayCobro = true;
            }
        }
    });
    
    if(hayCobro === false){
        textoError=textoError+"No hay seleccionada ninguna factura para cobrar.\n";
    }
    
    
    //comprobacion del campo 'datFecha'
    if (document.form2.datFecha.value === ''){ 
      textoError=textoError+"Es necesario introducir la fecha del cobro.\n";
      document.form2.datFecha.style.borderColor='#FF0000';
      document.form2.datFecha.title ='Se debe introducir la fecha del cobro';
      hayCobro = false;
    }
    
    //comprobacion del campo 'strCuentaBancos'
    if (document.form2.strCuentaBancos.value === ''){ 
      textoError=textoError+"Es necesario introducir la forma de cobro.\n";
      document.form2.strCuentaBancos.style.borderColor='#FF0000';
      document.form2.strCuentaBancos.title ='Se debe introducir la forma de cobro';
      hayCobro = false;
    }
    
    if (!hayCobro){
            alert(textoError);
    }
    
    //comprobar que la cuenta de 'strCuentaBancos' sea correcta, se comprueba en 'okStrCuentaBancos'
    if(document.getElementById("okStrCuentaBancos").value === "NO"){
        hayCobro = false;
//        alert("La cuenta introducida no existe");
    }
    
    if(hayCobro === true){
        alert('Comienza el proceso de cobro de facturas.');
        document.form2.opcion.value = 'cobrar';
        document.getElementById("cmdCobrar").value = "Procensando...";
        document.getElementById("cmdCobrar").disabled = true;
        document.form2.submit();
    }else{
        return false;
    }
}

function activarImporte(IdFactura,pendiente){
    if($("#cobro"+IdFactura).is(':checked')) {  
        $("#cantidad"+IdFactura).attr('disabled', false); 
        $("#cantidad"+IdFactura).val(pendiente); 
    } else {  
        $("#cantidad"+IdFactura).attr('disabled', true); 
        $("#cantidad"+IdFactura).val(''); 
    }      
}

function comprobarSuperaPendiente(casilla,pendiente){
    //desformatear el numero de casilla
    var valorCasilla = desFormateaNumeroContabilidad(casilla.value);
    //ahora compruebo si la cantidad de asilla supera a pendiente, esto no puede ser, 
    //se le indica y se pone el valor de pendiente
    if(parseFloat(valorCasilla) > parseFloat(pendiente)){
        alert('No puede ser superior a ' + formateaNumeroContabilidad(pendiente));
        casilla.value = formateaNumeroContabilidad(pendiente);
    }
    //si el valor esta vacio o es 0,00 le indico el valor pendiente (no es congruente un valor 0 a cobrar
    if(valorCasilla === '' || valorCasilla === '0.00'){
        casilla.value = formateaNumeroContabilidad(pendiente);
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
        <td align="center">
            <!-- grafica de barras (stacked column) -->
            <div id="grafica" style="width: 800px; height: 250px;">
                <img src="../images/cargar.gif" height="50" width="50" />
            </div>
        </td>
    </tr>
    <tr>
        <td>

<h3 align="center" color="#FFCC66"><font size="3px">Facturas pendientes de Cobrar</font></h3> 

        <div id="cargandoListado" width="954" align="center">
            <br><br><br><br>
            <img src="../images/cargar.gif" height="100" width="100" />
        </div>
            <?php
            //extraigo la consulta de esta tabla
            $arResult=$clsCNContabilidad->ListadoFacturasACobrar();
            ?>
            <script LANGUAGE="JavaScript"> 
                $('#cargandoListado').hide();
            </script>
            <br/>
            <form name="form2" action="../vista/cobrar_facturas.php" method="post">
            <table id="datatablesMod" class="display">
                <thead>
                    <tr>
                        <th width="6%">Reclamar</th>
                        <th width="6%">Numero Factura</th>
                        <th width="40%">Cliente</th>
                        <th width="6%">&nbsp;&nbsp;&nbsp;&nbsp;Fecha&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th width="6%">Vencimiento</th>
                        <th width="6%">Estado</th>
                        <th width="7%">Importe</th>
                        <th width="7%">Pendiente Cobro</th>
                        <th width="6%">Cobrar</th>
                        <th width="10%">Importe a Cobrar</th>
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
                            
                            //ahora segun el tipo de contador presento el numero de la factura
                            $numeroFactura = numeroDesformateado($arResult[$i]['NumFactura'],$tipoContador);
                            
                            //preparo el importe en texto y sin decimales, y una cifra de 20 digitos, asi puedo ordenarlo bien por importe
                            $importeTxt=$arResult[$i]['totalImporte']*100;
                            while(strlen($importeTxt)<20){
                                $importeTxt='0'.$importeTxt;
                            }
                            
                            //preparo el importe en texto y sin decimales, y una cifra de 20 digitos, asi puedo ordenarlo bien por importe
                            $importePend = $arResult[$i]['pendiente']*100;
                            while(strlen($importePend)<20){
                                $importePend='0'.$importePend;
                            }

                            
                            //preparo el array de $arResult[$i] para enviar por url
                            //$link="javascript:document.location.href='../vista/altafactura.php?IdFactura=".$arResult[$i]['IdFactura']."';";
                            $link="";
                            ?>
                            <tr>
                                <td onClick="<?php echo $link; ?>">
                                    <div align="center">
                                        <input type="checkbox" id="recla<?php echo $arResult[$i]['IdFactura']; ?>" name="recla<?php echo $arResult[$i]['IdFactura']; ?>" class="nombreCampo" />
                                    </div>
                                    </td>
                                <td onClick="<?php echo $link; ?>"><?php echo "<!-- ".$arResult[$i]['NumFactura']." -->".$numeroFactura; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['nombreContacto']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['FechaFactura']; ?></td>
                                <td onClick="<?php echo $link; ?>">
                                    <?php echo $arResult[$i]['FechaVtoFactura']; ?>
                                    <input type="hidden" name="vtoFactura<?php echo $arResult[$i]['IdFactura']; ?>" value="<?php echo $arResult[$i]['FechaVtoFactura']; ?>" />
                                </td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['Estado']; ?></td>
                                <td align="right" onClick="<?php echo $link; ?>">
                                    <?php echo "<!-- $importeTxt -->".formateaNumeroContabilidad($arResult[$i]['totalImporte']); ?>
                                    <input type="hidden" name="importe<?php echo $arResult[$i]['IdFactura']; ?>" value="<?php echo $arResult[$i]['totalImporte']; ?>" />
                                </td>
                                <td align="right" onClick="<?php echo $link; ?>">
                                    <?php echo "<!-- $importePend -->".formateaNumeroContabilidad($arResult[$i]['pendiente']); ?>
                                    <input type="hidden" name="pendiente<?php echo $arResult[$i]['IdFactura']; ?>" value="<?php echo $arResult[$i]['pendiente']; ?>" />
                                </td>
                                <td onClick="<?php echo $link; ?>">
                                    <div align="center">
                                        <input type="checkbox" id="cobro<?php echo $arResult[$i]['IdFactura']; ?>" name="cobro<?php echo $arResult[$i]['IdFactura']; ?>" 
                                               class="nombreCampo" onclick="activarImporte('<?php echo $arResult[$i]['IdFactura']; ?>','<?php echo formateaNumeroContabilidad($arResult[$i]['pendiente']); ?>');" />
                                    </div>
                                </td>
                                <td onClick="<?php echo $link; ?>">
                                    <input type="text" id="cantidad<?php echo $arResult[$i]['IdFactura']; ?>" name="cantidad<?php echo $arResult[$i]['IdFactura']; ?>" 
                                           onkeypress="return solonumeros(event);" class="textbox1" style="text-align:right;" disabled
                                           onblur="formateaCantidad(this);comprobarSuperaPendiente(this,'<?php echo $arResult[$i]['pendiente']; ?>');" onfocus="desFormateaCantidad(this);" />
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
            
            <table align="center" border="0" width="954">
                <tbody>
                    <tr>
                        <td align="center" style="width: 30%;">
                            <input class="button" type="button" id="cmdReclamar" value="Reclamar Facturas" onclick="reclamar();" />
                        </td>
                        <td style="width: 40%;"></td>
                        <td align="center" style="width: 30%;">
                            <table>
                                <tr>
                                    <td>
                                       <label class="nombreCampo">Fecha de cobro</label>
                                    </td>
                                    <td>
                                      <?php
                                      datepicker_español('datFecha');
                                      ?>
                                      <style type="text/css">
                                      /* para que no salga el rectangulo inferior */        
                                      .ui-widget-content {
                                          border: 0px solid #AAAAAA;
                                      }
                                      </style>
                                      <div align="left" style="width: 70%;">
                                        <input class="textbox1" type="text" id="datFecha" name="datFecha" maxlength="38"
                                               onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                                               onKeyUp="this.value=formateafechaEntrada(this.value);" 
                                               onfocus="onFocusInputText(this);" size="10"
                                               onblur="onBlurInputText(this);"
                                               />
                                       </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       <label class="nombreCampo">Forma de cobro</label>
                                    </td>
                                    <td>
                                        <div align="left">
                                        <?php
                                        autocomplete_cuentas_SubGrupo4('strCuentaBancos',57);
                                        ?>
                                        <input class="textbox1" type="text" id="strCuentaBancos" name="strCuentaBancos" 
                                           onKeyUp="" 
                                           onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" 
                                           onfocus="onFocusInputText(this);"
                                           onblur="onBlurInputText(this);comprobarCuentaBlur(this,document.getElementById('okStrCuentaBancos'));"
                                           />
                                        <input type="hidden" name="okStrCuentaBancos" id="okStrCuentaBancos" value="NO" />
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <input class="button" type="button" id="cmdCobrar" value="Cobrar Factura" onclick="cobrar();" />
                        </td>
                    </tr>
                <tbody>
            </table>
            <input type="hidden" value="" name="opcion" />
                
                
            </form>

            <br/><br/><br/>
            <?php include '../vista/IndicacionIncidencia.php'; ?>
        </td>
        </tr>
        </table>
    </body>
</html>
<?php
}

function html_paginaCobrarFacturaMovil($clsCNContabilidad,$calculosGrafica){
    
    $categories = "";
    $cobros = "";
    $contador = 6;
    for ($i = count($calculosGrafica); $i > 0; $i--) {
        if($contador > 0){
            $categories = "'" . MesTxt($calculosGrafica[$i-1]['Mes']) . '/' . $calculosGrafica[$i-1]['Ejercicio'] . "'," . $categories;
            $cobros = "" . $calculosGrafica[$i-1]['cantidad'] . "," . $cobros;
            $contador--;
        }else{
            break;
        }
    }
    $categories = trim($categories, ',');
    $categories = "[" . $categories . "]";
    $cobros = trim($cobros, ',');
    $cobros = "[" . $cobros . "]";

?>

<!DOCTYPE html>
<html>
<head>
<TITLE>Cobro Facturas</TITLE>

<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>
<!-- graficas -->
<script src="../js/highcharts/highcharts.js"></script>
<script src="../js/highcharts/themes/sand-signika.js"></script>
        
</head> 
    <body>
    <div data-role="page" id="cobrar_facturas">
<?php
eventosInputText();
?>
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
            text: 'Importe de Cobro'
        },
        xAxis: {
            categories: <?php echo $categories; ?>
        },
        credits: {
            enabled: false
        },        
        yAxis: {
            min: 0,
            title: {
                text: 'Importe'
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
                    this.series.name + ': ' + 'Total: ' + Highcharts.numberFormat(this.point.stackTotal, 2, ',', '.');
            }
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: false,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                    style: {
                        textShadow: '0 0 3px black'
                    }
                }
            }
        },
        series: [{
            name: 'Importe',
            data: <?php echo $cobros; ?>
        }]
    });
});

function desFormateaCantidad(objeto){
    objeto.value=desFormateaNumeroContabilidad(objeto.value);
}

//formateo de numeros
function formateaCantidad(objeto){
    objeto.value=formateaNumeroContabilidad(objeto.value);
}    

function reclamar(){
    //comprobamos que este alguna factura seleccionada
    var hayRecla='false';
    $('#datatablesMod').find(":checkbox").each(function(){
        var elemento=this;
        if(elemento.checked===true){
            var nombre = elemento.name;
            var recla = nombre.substr(0,5);
            if(recla === 'recla'){
                hayRecla='true';
            }
        }
    });
    
    if(hayRecla==='true'){
        alert('Comienza el proceso de reclamar facturas.');
        document.form2.opcion.value = 'reclamar';
        document.getElementById("cmdReclamar").value = "Procensando...";
        document.getElementById("cmdReclamar").disabled = true;
        document.form2.submit();
    }else{
        alert('No hay seleccionada ninguna factura para reclamar.');
        return false;
    }
}

function cobrarForm(){
    $('#cobrarForm').toggle('1000');
}

function cobrarM(){
    //comprobamos que este alguna factura seleccionada
    var hayCobro=false;
    var textoError = '';
    $('#datatablesMod').find(":checkbox").each(function(){
        var elemento=this;
        if(elemento.checked===true){
            var nombre = elemento.name;
            var cobro = nombre.substr(0,5);
            if(cobro === 'cobro'){
                hayCobro = true;
            }
        }
    });
    
    if(hayCobro === false){
        textoError=textoError+"No hay seleccionada ninguna factura para cobrar.\n";
    }
    
    //comprobar que la cuenta de 'strCuentaBancos' sea correcta, se comprueba en 'okStrCuentaBancos'
    if(document.getElementById("okStrCuentaBancos").value === "NO"){
        hayCobro = false;
        textoError=textoError+"La cuenta introducida no existe.\n";
    }
    
    //comprobacion del campo 'datFechaF'
    if (document.form3.datFechaF.value === ''){ 
      textoError=textoError+"Es necesario introducir la fecha del cobro.\n";
      document.form3.datFechaF.style.borderColor='#FF0000';
      document.form3.datFechaF.title ='Se debe introducir la fecha del cobro';
      hayCobro = false;
    }
    
//    //comprobacion del campo 'strCuentaBancos'
//    if (document.form2.strCuentaBancos.value === ''){ 
//      textoError=textoError+"Es necesario introducir la forma de cobro.\n";
//      document.form2.strCuentaBancos.style.borderColor='#FF0000';
//      document.form2.strCuentaBancos.title ='Se debe introducir la forma de cobro';
//      hayCobro = false;
//    }
    
    if (!hayCobro){
            alert(textoError);
    }
    
    if(hayCobro === true){
        //se guarda por SESSION temporalmente datfecha y strCuentaBancos (por AJAX)
        $.ajax({
          data:{"datFecha":document.form3.datFechaF.value,"strCuentaBancos":document.form3.strCuentaBancosF.value},  
          url: '../vista/ajax/cobrar_facturas_vbles_session.php',
          type:"get",
          success: function(data) {
            //recuperamos el valor del texto
            var val = document.getElementById("numValue");
            //actualizamos el indicador visual con el texto
            val.innerHTML = data+val.innerHTML;
          }
        });
        
        
        
        alert('Comienza el proceso de cobro de facturas.');
        document.form2.opcion.value = 'cobrar';
        document.getElementById("cmdCobrar").value = "Procensando...";
        document.getElementById("cmdCobrar").disabled = true;
        document.form2.submit();
    }else{
        return false;
    }
}

function activarImporte(IdFactura,pendiente){
    if($("#cobro"+IdFactura).is(':checked')) {  
        $("#cantidad"+IdFactura).textinput('enable'); 
        $("#cantidad"+IdFactura).val(pendiente); 
    } else {  
        $("#cantidad"+IdFactura).textinput('disable'); 
        $("#cantidad"+IdFactura).val(''); 
    }      
}

function comprobarSuperaPendiente(casilla,pendiente){
    //desformatear el numero de casilla
    var valorCasilla = desFormateaNumeroContabilidad(casilla.value);
    //ahora compruebo si la cantidad de asilla supera a pendiente, esto no puede ser, 
    //se le indica y se pone el valor de pendiente
    if(parseFloat(valorCasilla) > parseFloat(pendiente)){
        alert('No puede ser superior a ' + formateaNumeroContabilidad(pendiente));
        casilla.value = formateaNumeroContabilidad(pendiente);
    }
    //si el valor esta vacio o es 0,00 le indico el valor pendiente (no es congruente un valor 0 a cobrar
    if(valorCasilla === '' || valorCasilla === '0.00'){
        casilla.value = formateaNumeroContabilidad(pendiente);
    }
}

function actualizaFecha(){
    document.form2.datFecha.value = document.form3.datFechaF.value;
}

function actualizaCuenta(){
    document.form2.strCuentaBancos.value = document.form3.strCuentaBancosF.value;
}


</script>

    <?php
    include_once '../movil/cabeceraMovil.php';
//    include_once '../movil/cobrar_factura_menu_lateral.php';
    ?>
        
    <div data-role="content" data-theme="a">
        
        <div id="grafica">
<!--            <img src="../images/cargar.gif" height="50" width="50" />-->
        </div>
        
        
        <style>
        .checkBoxLeft{
            position: absolute; 
            left: 1px; 
            top: 25%;
        }
        input[type=checkbox]
        {
          /* Double-sized Checkboxes */
          -ms-transform: scale(2); /* IE */
          -moz-transform: scale(2); /* FF */
          -webkit-transform: scale(2); /* Safari and Chrome */
          -o-transform: scale(2); /* Opera */
          padding: 10px;
        }
        </style> 
        
        <?php
        //extraigo la consulta de esta tabla
        $arResult=$clsCNContabilidad->ListadoFacturasACobrar();
        $tipoContador=$clsCNContabilidad->Parametro_general('Tipo Contador',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));
        ?>
        
        <h3 align="center" color="#FFCC66"><font size="3px">Facturas pendientes de Cobrar</font></h3>
        <form name="form2" action="../vista/cobrar_facturas.php" method="post">
            
            <input type="hidden" name="datFecha" id="datFecha" value="" />
            <input type="hidden" name="strCuentaBancos" id="strCuentaBancos" value="" />
            <input type="hidden" name="okStrCuentaBancos" id="okStrCuentaBancos" value="SI" />
            <input type="hidden" value="" name="opcion" />
            
        <br/>
        
        <style>
        .checkBoxLeft2{
            position: absolute; 
            left:100px; 
            top: 135px;
        }
        .checkBoxLeft4{
            position: absolute; 
            left: 120px; 
            top: 135px;
        }
        
        .checkBoxLeft3{
            position: absolute; 
            left: 240px; 
            top: 135px;
        }
        </style>
        
        <ul id="datatablesMod" data-role="listview" data-dividertheme="a" data-filter="true" data-filter-placeHolder="Buscar">
            <?php
            if(is_array($arResult)){
                for ($i = 0; $i < count($arResult); $i++) {
                    $ejercicio=substr($arResult[$i]['NumFactura'],0,4);
                    $numero=substr($arResult[$i]['NumFactura'],4,4);

                    $numero4cifras=$numero;
                    while(substr($numero,0,1)==='0'){
                        $numero=substr($numero,1);
                    }

                    //ahora segun el tipo de contador presento el numero de la factura
                    $numeroFactura='';
                    $numeroFactura = numeroDesformateado($arResult[$i]['NumFactura'],$tipoContador);
//                    switch ($tipoContador) {
//                        case 'simple':
//                            $numeroFactura=$arResult[$i]['NumFactura'];
//                            break;
//                        case 'compuesto1':
//                            $numeroFactura=$numero.'/'.$ejercicio;
//                            break;
//                        case 'compuesto2':
//                            $numeroFactura=$ejercicio.'/'.$numero;
//                            break;
//                        default://ningun contador
//                            $numeroFactura=$arResult[$i]['NumFactura'];
//                            break;
//                    }

                    //preparo el importe en texto y sin decimales, y una cifra de 20 digitos, asi puedo ordenarlo bien por importe
                    $importeTxt=$arResult[$i]['totalImporte']*100;
                    while(strlen($importeTxt)<20){
                        $importeTxt='0'.$importeTxt;
                    }

                    //preparo el importe en texto y sin decimales, y una cifra de 20 digitos, asi puedo ordenarlo bien por importe
                    $importePend = $arResult[$i]['pendiente']*100;
                    while(strlen($importePend)<20){
                        $importePend='0'.$importePend;
                    }


                    //preparo el array de $arResult[$i] para enviar por url
                    //$link="javascript:document.location.href='../vista/altafactura.php?IdFactura=".$arResult[$i]['IdFactura']."';";
                    $link="#";
                    ?>
                    <li>
                        <a href="<?php echo $link; ?>" data-ajax="false">
                        <?php echo '&nbsp;&nbsp;&nbsp;&nbsp;<font color="30a53b">Cliente: </font>'.'<br/>'; ?>
                        <?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$arResult[$i]['nombreContacto'].'<br/>'; ?>
                        <?php echo '&nbsp;&nbsp;&nbsp;&nbsp;<font color="30a53b">Factura: </font>'.$numeroFactura.'<br/>'; ?>
                        <?php echo '&nbsp;&nbsp;&nbsp;&nbsp;<font color="30a53b">Vencimiento: </font>'.$arResult[$i]['FechaVtoFactura'].'<br/>'; ?>
                        <?php echo '&nbsp;&nbsp;&nbsp;&nbsp;<font color="30a53b">Pend. Cobro: </font>'.formateaNumeroContabilidad($arResult[$i]['pendiente']).'<br/><hr/>'; ?>
                        <input type="hidden" name="pendiente<?php echo $arResult[$i]['IdFactura']; ?>" value="<?php echo $arResult[$i]['pendiente']; ?>" />
                        <input type="hidden" name="vtoFactura<?php echo $arResult[$i]['IdFactura']; ?>" value="<?php echo $arResult[$i]['FechaVtoFactura']; ?>" />
                        <input type="hidden" name="importe<?php echo $arResult[$i]['IdFactura']; ?>" value="<?php echo $arResult[$i]['totalImporte']; ?>" />
                        <?php echo '&nbsp;&nbsp;&nbsp;&nbsp;<font color="30a53b">Cobrar:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Reclamar: </font><br/><hr/>'; ?>
                        <?php echo '&nbsp;&nbsp;&nbsp;&nbsp;<font color="30a53b">Importe: </font><br/>&nbsp;'; ?>
                        </a>
                        <div class="checkBoxLeft2">
                            <input type="checkbox" name="cobro<?php echo $arResult[$i]['IdFactura']; ?>" id="cobro<?php echo $arResult[$i]['IdFactura']; ?>" class="ui-li-a" 
                                   onclick="activarImporte('<?php echo $arResult[$i]['IdFactura']; ?>','<?php echo formateaNumeroContabilidad($arResult[$i]['pendiente']); ?>');" />
                        </div>
                        <div class="checkBoxLeft4">
                            <br/>
                            <input type="text" id="cantidad<?php echo $arResult[$i]['IdFactura']; ?>" name="cantidad<?php echo $arResult[$i]['IdFactura']; ?>" 
                                   onfocus="onFocusInputTextM(this);desFormateaCantidad(this);" style="text-align:right;" size="15" disabled
                                   onblur="solonumerosM(this);formateaCantidad(this);comprobarSuperaPendiente(this,'<?php echo $arResult[$i]['pendiente']; ?>');" />
                        </div>
                        <div class="checkBoxLeft3">
                            <input type="checkbox" name="recla<?php echo $arResult[$i]['IdFactura']; ?>" id="recla<?php echo $arResult[$i]['IdFactura']; ?>" class="ui-li-a" />
                        </div>
                        </li>
                    <?php
                }
            }
            ?>
        </ul>
        </form>
        </div>  

        <div data-role="footer" data-theme="a" data-position="fixed">
        <form name="form3" action="../vista/cobrar_facturas.php" method="post">
        <table border="0" style="width: 100%;">
            <tbody>
                <tr>
                    <td style="width: 45%;"></td>
                    <td style="width: 45%;"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div id="cobrarForm" style="display: none;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="width: 45%;"></td>
                                    <td style="width: 45%;"></td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Fecha de cobro</label>
                                        <?php
                                        datepicker_español('datFechaF');
                                        ?>
                                        <input type="text" id="datFechaF" name="datFechaF" maxlength="38" 
                                               onKeyUp="this.value=formateafechaEntrada(this.value);"
                                               onfocus=""
                                               onblur="actualizaFecha(this.value);"
                                               onchange="" />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <label>Forma de cobro</label>
                                        <?php
                                        //extraigo un listado de las cuentas 57
                                        $listado = $clsCNContabilidad->listadoCuentas('57');
                                        
                                        ?>
                                        <select id="strCuentaBancosF" name="strCuentaBancosF" data-native-menu="false" 
                                                data-theme='a' data-mini="true" onchange="actualizaCuenta(this.value);" onload="actualizaCuenta(this.value);">
                                        <?php
                                        for ($i = 0; $i < count($listado); $i++) {
                                            echo "<option value='".$listado[$i]['cuenta']."'>".$listado[$i]['cuenta']."</option>";
                                        }
                                        ?>    
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input data-theme="a" data-mini="true" type="button" id="cmdCobrar" value="Conf. Cobro" onclick="cobrarM();" />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" height="20px"></td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <input data-theme="a" data-mini="true" type="button" id="cmdReclamar" value="Cobrar Fras." onclick="cobrarForm();" />
                    </td>
                    <td>
                        <input data-theme="a" data-mini="true" type="button" id="cmdReclamar" value="Conf. Reclamación" onclick="reclamar();" />
                    </td>
                </tr>
            </tbody>
        </table>
        </form>
        </div>
    </div>  
        
    </body>
</html>

<?php 
} 
?>
