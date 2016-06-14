<?php
session_start();
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


require_once '../CN/clsCNContabilidad.php';
$clsCNContabilidad=new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['dbContabilidad']);
$clsCNContabilidad->setStrBDCliente($_SESSION['mapeo']);

                
logger('info','ventas_listado_contabilizando.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
       " ||||Ventas->Listado General||");


//recojo los check para saber que debo contabilizar
$ckVentas = $_POST['contabilizarVentas'];
$ckCaja = $_POST['contabilizarCaja'];
$ckBancos = $_POST['contabilizarBancos'];
$listadoBancos = '';
$tipoTarjetas = '';
$listadoTarjetas = '';
$listadoVentas = '';
foreach($_POST as $prop=>$valor){
    //ahora vamos a guardar en distintos arrays los datos que nos vienen
    //bancos
    if(substr($prop,0,12) === 'IdBancoFecha'){
        $iTabla = substr($prop,12);
        if($_POST['IdBanco'.$iTabla] !== ''){
            $listadoBanco['IdBanco'] = $_POST['IdBanco'.$iTabla];
            $listadoBanco['CuentaBanco'] = $_POST['CuentaBanco'.$iTabla];
            $listadoBanco['Cantidad'] = $_POST['Cantidad'.$iTabla];
            $listadoBanco['Fecha'] = $valor;
            $listadoBancos[] = $listadoBanco;
        }
    }
    //tipoTarjetas
    if(substr($prop,0,4) === 'tarj'){
        if($valor === 'SI'){
            $tipoTarjetas[] = substr($prop,4);
        }
    }
    //tarjetas
    if(substr($prop,0,14) === 'IdTarjetaFecha'){
        $iTabla = substr($prop,14);
        if($_POST['IdTarjeta'.$iTabla] !== ''){
            $listadoTarjeta['Fecha'] = $valor;
            $listadoTarjeta['IdTarjeta'] = $_POST['IdTarjeta'.$iTabla];
            $listadoTarjeta['CuentaTarjeta'] = $_POST['CuentaTarjeta'.$iTabla];
            $listadoTarjeta['Bruto'] = $_POST['Bruto'.$iTabla];
            $listadoTarjeta['Comision'] = $_POST['Comision'.$iTabla];
            $listadoTarjeta['Liquido'] = $_POST['Liquido'.$iTabla];
            $listadoTarjetas[] = $listadoTarjeta;
        }
    }
    //ventas
    if(substr($prop,0,13) === 'AsientoVentas'){
        if($valor === 'P'){
            $iTabla = substr($prop,13);
            $listadoVenta['IdVenta'] = $_POST['IdVenta'.$iTabla];
            $listadoVenta['BaseI'] = $_POST['BaseI'.$iTabla];
            $listadoVenta['IVA'] = $_POST['IVA'.$iTabla];
            $listadoVenta['Ventas'] = $_POST['Ventas'.$iTabla];
            $listadoVenta['fecha'] = $_POST['fecha'.$iTabla];
            $listadoVentas[] = $listadoVenta;
        }
    }
}

//var_dump($listadoVentas);die;

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="../images/q.ico">
        <title>Ventas - Contabilizar - Proceso</title>
        <script language="JavaScript">
            var txt="-    Sistema de Gestión de la Calidad    ";
            var espera=120;
            var refresco=null;
 
            function rotulo_status() {
                window.status=txt;
                txt=txt.substring(1,txt.length)+txt.charAt(0);        
                refresco=setTimeout("rotulo_status()",espera);
            }
        </script>
        <link href="../css/Estilos_Qualidad.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="../css/calidad2.css" type="text/css">

        <!--            HE INCLUIDO AQUI ESTAS LIBRERIAS DE jQuery PACO-->
        <?php
        librerias_jQuery_listado();
        ?>
        <!--       FIN     HE INCLUIDO AQUI ESTAS LIBRERIAS DE jQuery PACO-->

<script LANGUAGE="JavaScript"> 

////comntrolar que solo se introduce datos numericos en el campo
// function Solo_Numerico(variable){
//    Numer=parseInt(variable);
//    if (isNaN(Numer)){
//        return "";
//    }
//    return Numer;
//}
//
//function ValNumero(Control){
//    Control.value=Solo_Numerico(Control.value);
//}

</script>
<script languaje="JavaScript"> 

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


<script languaje="JavaScript"> 
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
<script type="text/javascript">
function contabilizarVentas(ventas){
    if(ventas !== undefined && ventas.BaseI !== ''){
        $.ajax({
          data:{"IdVenta":ventas.IdVenta,"BaseI":ventas.BaseI,"IVA":ventas.IVA,"Ventas":ventas.Ventas,"fecha":ventas.Fecha},  
          url: '../vista/ventas_contVentas_AJAX.php',
          async: false,
          type:"get",
          success: function(data) {
            $('#numValue').html(data+$('#numValue').html());
          }
        });
    }
}

function contabilizarBancos(asiento,tipo){
    //veo si la cuenta es 0 o distinta
    var tipoC = 'caja';
    if(asiento.CuentaBanco !== '0'){
        tipoC = 'banco';
    }
    if(asiento !== undefined && tipo === tipoC && asiento.Cantidad !== ''){//
        $.ajax({
          data:{"IdBanco":asiento.IdBanco,"CuentaBanco":asiento.CuentaBanco,"Cantidad":asiento.Cantidad,"fecha":asiento.Fecha},  
          url: '../vista/ventas_contBancos_AJAX.php',
          async: false,
          type:"get",
          success: function(data) {
            $('#numValue').html(data+$('#numValue').html());
          }
        });
    }
}

function contabilizarTarjeta(objeto){
    if(objeto.AsientoTarjeta === 'P'){
        $.ajax({
          data:{"IdTarjeta":objeto.IdTarjeta,"CuentaTarjeta":objeto.CuentaTarjeta,"Bruto":objeto.Bruto,"Comision":objeto.Comision,"Liquido":objeto.Liquido,"TipoTarjeta":objeto.TipoTarjeta,"nombreTarjeta":objeto.nombreTarjeta,"fecha":objeto.Fecha},  
          url: '../vista/ventas_contTarjetas_AJAX.php',
          async: false,
          type:"get",
          success: function(data) {
            $('#numValue').html(data+$('#numValue').html());
          }
        });
    }
}

function contabilizarCheque(objeto){
    if(objeto.AsientoTarjeta === 'P'){
        $.ajax({
          data:{"IdTarjeta":objeto.IdTarjeta,"CuentaTarjeta":objeto.CuentaTarjeta,"Bruto":objeto.Bruto,"Comision":objeto.Comision,"Liquido":objeto.Liquido,"TipoTarjeta":objeto.TipoTarjeta,"nombreTarjeta":objeto.nombreTarjeta,"fecha":objeto.Fecha},  
          url: '../vista/ventas_contCheque_AJAX.php',
          async: false,
          type:"get",
          success: function(data) {
            $('#numValue').html(data+$('#numValue').html());
          }
        });
    }
}


//ahora preparo los arrays de los distintos procesos de contabilizar
//listado de ventas
var listadoVentas = new Array();
<?php
if(is_array($listadoVentas)){
    for($i=0;$i<count($listadoVentas);$i++){
        ?>
        var listadoVenta = new Array();
        listadoVenta["IdVenta"] = '<?php echo $listadoVentas[$i]['IdVenta']; ?>';
        listadoVenta["BaseI"] = '<?php echo $listadoVentas[$i]['BaseI']; ?>';
        listadoVenta["IVA"] = '<?php echo $listadoVentas[$i]['IVA']; ?>';
        listadoVenta["Ventas"] = '<?php echo $listadoVentas[$i]['Ventas']; ?>';
        listadoVenta["fecha"] = '<?php echo $listadoVentas[$i]['fecha']; ?>';
        listadoVentas[<?php echo $i;?>] = listadoVenta;
        <?php
    }
}
?>


//listado de Caja
var listadoCaja = new Array();
//listado de Bancos
var listadoBancos = new Array();
<?php
if(is_array($listadoBancos)){
    $contBanco = 0;
    $contCaja = 0;
    for($i=0;$i<count($listadoBancos);$i++){
        if((int)$listadoBancos[$i]['CuentaBanco'] !== 0){
        ?>
            listadoBancos[<?php echo $contBanco;?>]={"IdBanco":"<?php echo $listadoBancos[$i]['IdBanco'];?>","Fecha":"<?php echo $listadoBancos[$i]['Fecha'];?>","CuentaBanco":"<?php echo $listadoBancos[$i]['CuentaBanco'];?>","Cantidad":"<?php echo $listadoBancos[$i]['Cantidad'];?>"};
        <?php
            $contBanco++;
        }else{
        ?>
            listadoCaja[<?php echo $contCaja;?>]={"IdBanco":"<?php echo $listadoBancos[$i]['IdBanco'];?>","Fecha":"<?php echo $listadoBancos[$i]['Fecha'];?>","CuentaBanco":"<?php echo $listadoBancos[$i]['CuentaBanco'];?>","Cantidad":"<?php echo $listadoBancos[$i]['Cantidad'];?>"};
        <?php
            $contCaja++;
        }
    }
}
?>
    
//*****************************************************************
//OTRA FORMA, SERIA HACER UN ARRAY QUE RECOJA TODOS LOS ASIENTOS SIGUIENDO EL ORDEN DE LOS DIAS
//GUARDAR TANTOS SUB-ARRAYS COMO TIPOS SELECCIONADOS 

var listadoTotal = new Array();
<?php
foreach($_POST as $prop=>$valor){
    //filtro por IdBancoFecha
    if(substr($prop,0,12) === 'IdBancoFecha'){
        $iTabla = substr($prop,12);
        ?>
        listadoTotal[<?php echo $iTabla;?>]={"Fecha":"<?php echo $valor;?>","IdVenta":"<?php echo $_POST['IdVenta'.$iTabla];?>","BaseI":"<?php echo $_POST['BaseI'.$iTabla];?>","IVA":"<?php echo $_POST['IVA'.$iTabla];?>","Ventas":"<?php echo $_POST['Ventas'.$iTabla];?>","AsientoVentas":"<?php echo $_POST['AsientoVentas'.$iTabla];?>",
                                             "IdBanco":"<?php echo $_POST['IdBanco'.$iTabla];?>","CuentaBanco":"<?php echo $_POST['CuentaBanco'.$iTabla];?>","Cantidad":"<?php echo $_POST['Cantidad'.$iTabla];?>","AsientoBanco":"<?php echo $_POST['AsientoBanco'.$iTabla];?>",
                                             "IdTarjeta":"<?php echo $_POST['IdTarjeta'.$iTabla];?>","CuentaTarjeta":"<?php echo $_POST['CuentaTarjeta'.$iTabla];?>","Bruto":"<?php echo $_POST['Bruto'.$iTabla];?>","Comision":"<?php echo $_POST['Comision'.$iTabla];?>","Liquido":"<?php echo $_POST['Liquido'.$iTabla];?>","AsientoTarjeta":"<?php echo $_POST['AsientoTarjeta'.$iTabla];?>","TipoTarjeta":"<?php echo $_POST['TipoTarjeta'.$iTabla];?>","nombreTarjeta":"<?php echo $_POST['nombreTarjeta'.$iTabla];?>"
                                            };
        
        <?php
        
        
    }
}
?>

//NO VALE 3/3/2016
//function startTotal() {
//    //voy recorriendo el array
//    for(dia in listadoTotal){
//        //segun vengan los datos donde tengo que contabilizarlo
//        alert('dia: '+dia.Fecha);
//    }
//    
//}

//OTRA FORMA, SERIA HACER UN ARRAY QUE RECOJA TODOS LOS ASIENTOS SIGUIENDO EL ORDEN DE LOS DIAS
//GUARDAR TANTOS SUB-ARRAYS COMO TIPOS SELECCIONADOS 
//*****************************************************************





//Ventas
//progreso actual 
var currVentas = 0;
//esta la tarea completa
var doneVentas = false;

//BORRAR
//funcion para contabilizar las ventas
function startVentas() {
    //ejecuto la funcion que llama por AJAX la los procedimientos para contabilizar las ventas
    
    // ventas
    contabilizarVentas(listadoVentas[currVentas]);

    ////incrementamos el valor del progreso cada vez que la funciÃ³n se ejecuta
    currVentas++;
    //comprobamos si hemos terminado
    if(currVentas>(listadoVentas.length-1)){
        doneVentas = true;
    }
    // sino hemos terminado, volvemos a llamar a la funciÃ³n despuÃ©s de un tiempo
    if(!doneVentas)
    {
        document.getElementById("startBtn").disabled = true;
        setTimeout("startVentas()",0);
    }  
    //tarea terminada, habilitar el botón
    else{   
//        var val = document.getElementById("numValue");
//        //actualizamos el indicador visual con el texto
//        val.innerHTML = "<br/>Ventas contabilizadas<br/>" + val.innerHTML;
        //enabled boton
        document.getElementById("startBtn").disabled = false;
    }
}

//Caja
//progreso actual 
var currCaja = 0;
//esta la tarea completa
var doneCaja = false;

//BORRAR
//funcion para contabilizar la caja
function startCaja() {
    //ejecuto la funcion que llama por AJAX la los procedimientos para contabilizar las ventas

    //control
    //if(doneVentas === true){
        // ventas
        contabilizarBancos(listadoCaja[currCaja]);

        //incrementamos el valor del progreso cada vez que la funciÃ³n se ejecuta
        currCaja++;
        //comprobamos si hemos terminado
        if(currCaja>(listadoCaja.length-1)){
            doneCaja = true;
        }
        // sino hemos terminado, volvemos a llamar a la funciÃ³n despuÃ©s de un tiempo
        if(!doneCaja)
        {
            document.getElementById("startBtn").disabled = true;
            setTimeout("startCaja()",0);
        }  
        //tarea terminada, habilitar el botón
        else{   
    //        var val = document.getElementById("numValue");
    //        //actualizamos el indicador visual con el texto
    //        val.innerHTML = "<br/>Caja contabilizadas<br/>" + val.innerHTML;
            //enabled boton
            document.getElementById("startBtn").disabled = false;
        }
    //}
}

//Bancos
//progreso actual 
var currBanco = 0;
//esta la tarea completa
var doneBanco = false;

//BORRAR
//funcion para contabilizar la caja
function startBancos() {
    //ejecuto la funcion que llama por AJAX la los procedimientos para contabilizar las ventas
    
    // ventas
    contabilizarBancos(listadoBancos[currBanco]);

    //incrementamos el valor del progreso cada vez que la funciÃ³n se ejecuta
    currBanco++;
    //comprobamos si hemos terminado
    if(currBanco>(listadoBancos.length-1)){
        doneBanco = true;
    }
    // sino hemos terminado, volvemos a llamar a la funciÃ³n despuÃ©s de un tiempo
    if(!doneBanco)
    {
        document.getElementById("startBtn").disabled = true;
        setTimeout("startBancos()",0);
    }  
    //tarea terminada, habilitar el botón
    else{   
        //enabled boton
        document.getElementById("startBtn").disabled = false;
    }
}

//funcion para contabilizar las ventas
function startVentas2() {
    //recorro el array
    for(i in listadoTotal){
        contabilizarVentas(listadoTotal[i]);
        setInterval('', 10);  
    }
    //enabled boton
    document.getElementById("startBtn").disabled = false;
}

//funcion para contabilizar la caja
function startCaja2() {
    //recorro el array
    for(i in listadoTotal){
        contabilizarBancos(listadoTotal[i],'caja');
        setInterval('', 10);  
    }
    //enabled boton
    document.getElementById("startBtn").disabled = false;
}

//funcion para contabilizar los bancos
function startBancos2() {
    //recorro el array
    for(i in listadoTotal){
        contabilizarBancos(listadoTotal[i],'banco');
        setInterval('', 10);  
    }
    //enabled boton
    document.getElementById("startBtn").disabled = false;
}

//funcion para contabilizar la tarjeta
function startTarjetas(TipoTarjeta) {
    //recorro el array
    for(i in listadoTotal){
        //vamos viendo el TipoTarjeta
        if(listadoTotal[i].TipoTarjeta === TipoTarjeta){
            contabilizarTarjeta(listadoTotal[i]);
            setInterval('', 10);  
        }
    }
    //enabled boton
    document.getElementById("startBtn").disabled = false;
}

//funcion para contabilizar los cheques
function startCheques(TipoTarjeta) {
    //recorro el array
    for(i in listadoTotal){
        //vamos viendo el TipoTarjeta
        if(listadoTotal[i].TipoTarjeta === TipoTarjeta){
            contabilizarCheque(listadoTotal[i]);
            setInterval('', 10);  
        }
    }
    //enabled boton
    document.getElementById("startBtn").disabled = false;
}


function inicio(){
    window.location='../vista/ventas_listado.php';
}



</script>

</head>
<body>
<table id="prueba" align="center" border="0" width="701" height="148">
    <tr> 
        <td width="954" height="100" align="middle" valign="top" nowrap>
            <p><img height="100" src="../images/cabecera.jpg" width="954" id="cabecera" border="0"></p>
        </td>
    </tr>
</table>
<table align="center" border="0"  width="954">
    <tr>
        <td>
            <h3 align="center" color="#FFCC66"><font size="3px">Contabilizar.</font></h3> 
            <table id="indicacion" align="center" border="0" width="600">
                <tr>
                    <td align="center">
                        <div id="contador" align="center" style="width:700px;"></div><br/><br/>
                        <div id="numValue"></div>
                    </td>
                </tr>
            </table>   
            <div align="center">
                <input class="button" id="startBtn" type="button" name="eleccion" value="Volver" onclick="inicio();" disabled />
            </div>

            <br/><br/><br/>
            <?php //include '../vista/IndicacionIncidencia.php'; ?>
        </td>
        </tr>
        </table>
    
<script type="text/javascript">

$(document).ready(function() {
<?php
//compruebo si contabilizo las ventas
if($ckVentas === 'SI'){
echo "startVentas2();";
}
?>
});

$(document).ready(function() {
<?php
//compruebo si contabilizo caja
if($ckCaja === 'SI'){
echo "startCaja2();";
}
?>
});

$(document).ready(function() {
<?php
//compruebo si contabilizo bancos
if($ckBancos === 'SI'){
echo "startBancos2();";
}
?>
});
        
//tarjetas y cheques        
$(document).ready(function() {
    <?php 
    for ($i = 0; $i < count($tipoTarjetas); $i++) { 
        if(substr($tipoTarjetas[$i],0,4) === '5750'){//tarjetas
        ?>
        startTarjetas('<?php echo $tipoTarjetas[$i]; ?>');
        <?php 
        }else if(substr($tipoTarjetas[$i],0,4) === '4100'){//cheques
        ?>
        startCheques('<?php echo $tipoTarjetas[$i]; ?>');
        <?php 
            
        }
    } 
    ?>
});

</script>

    </body>
</html>
