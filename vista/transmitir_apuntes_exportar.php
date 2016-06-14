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



logger('info','empleados_list.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
       " ||||Comunicaciones->Transmitir Apuntes- Exportar||");

$clsCNContabilidad=new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['mapeo']);


//recojo los parametros
$parametros = $_POST; 

//extraigo un listado de todos los movimientos filtrados segun las fechas
$listadoAsientos=$clsCNContabilidad->listadoMovimientosContabil2($parametros);

//borro los datos que haya en la tabla Contabil.movimientos
$NumeroProceso = $clsCNContabilidad->NuevoNumeroProcesoContabil();

//CONTROL DEL ERROR $OK

//borro los datos que haya en la tabla Contabil.movimientos
$OK1=$clsCNContabilidad->BorrarMovimientosContabil();

//CONTROL DEL ERROR $OK1

//borro los datos que haya en la tabla Contabil.movimientosFactura
$OK2=$clsCNContabilidad->BorrarFacturasContabil();

//CONTROL DEL ERROR $OK2

//extraigo un listado de todos los movimientos_IVA filtrados segun las fechas
$listadoMovimientosIva=$clsCNContabilidad->listadoMovimientosIvaContabil2($post);

//borro los datos que haya en la tabla Contabil.movimientosIva
$OK3=$clsCNContabilidad->BorrarMovimientosIvasContabil();

//CONTROL DEL ERROR $OK3


?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="../images/q.ico">
        <title>Transmitir Apuntes Exportar</title>
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
        <link rel="stylesheet" type="text/css" media="all" href="../js/jQuery/fancybox/style.css">
        <link rel="stylesheet" type="text/css" media="all" href="../js/jQuery/fancybox/jquery.fancybox.css">
        <script type="text/javascript" src="../js/jQuery/fancybox/jquery.fancybox.js?v=2.0.6"></script>

<script type="text/javascript">
function insertarAsientoContabil(idAsiento,color,currProgress,total){
    $.ajax({
      data:{"idAsiento":idAsiento,"backgroundcolor":color,"numeroProceso":<?php echo $NumeroProceso;?>},  
      url: '../vista/insertarAsientoContabil.php',
      type:"get",
      success: function(data) {
        if((currProgress+1)==total){
            document.getElementById('btnEnviar').disabled=false;
        }
        var contador = parseInt(document.getElementById('contadorParcial').value);
        contador++;
        document.getElementById('contadorParcial').value = contador;
        document.getElementById('contador').innerHTML='Exportado '+(contador)+' de '+total;
        var val = document.getElementById("numValue");
        //actualizamos el indicador visual con el texto
        val.innerHTML = val.innerHTML+data;
      }
    });
}

var idAsiento=new Array();
<?php
for($i=0;$i<count($listadoAsientos);$i++){
    ?>
    idAsiento[<?php echo $i;?>]=<?php echo $listadoAsientos[$i]['asiento'];?>;
    <?php
}
?>

//progreso actual
var currProgress = 0;
//esta la tarea completa
var done = false;
//cantidad total de progreso
var total = <?php echo count($listadoAsientos);?>;

//colores de fondo
colorpar='#DDDDDD';
colorimpar='#FFFFFF';


function startProgress() {
    if(currProgress%2){
        color=colorpar;
    }else{
        color=colorimpar;
    }
    //ejecuto la funcion que llama por AJAX la los procedimientos para guardar la factura    
    insertarAsientoContabil(idAsiento[currProgress],color,currProgress,total);

    ////incrementamos el valor del progreso cada vez que la función se ejecuta
    currProgress++;
    //comprobamos si hemos terminado
    if(currProgress>(idAsiento.length-1)){
        done=true;
    }
    // sino hemos terminado, volvemos a llamar a la función después de un tiempo
    if(!done)
    {
        setTimeout("startProgress()",0);
    }  
}

function Enviar(){
    //aparece el formulario emergente
    $(".modalbox").fancybox();
}

function EnviarForm(){
    esValido=true;
    textoError='';

    //comprobacion del campo 'email'
    if (document.contact.email.value === ''){ 
        textoError=textoError+"Es necesario introducir un email.\n";
        document.contact.email.style.borderColor='#FF0000';
        document.contact.email.title ='Es necesario introducir un email';
        esValido=false;
    }

    if(esValido===true){
        document.getElementById("send").value = "Enviando...";
        document.getElementById("send").disabled = true;
        document.contact.submit();
    }else{
        alert(textoError);
        return false;
    }  
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
</head>
<body onload="startProgress();">
    <?php require_once '../vista/cabecera2.php'; ?>
<table align="center">
    <tr>
        <td>
        <table class="filtro" align="center" border="0" width="700">
        <tr>
            <td>
                <h3 align="center" color="#FFCC66">
                    <font size="3px">Transmitir Apuntes. Preparado fichero 'Contabil.Mdb'</font>
                    <input type="hidden" id="contadorParcial" value="0" />
                </h3> 
            </td>
        </tr>
        <tr>
            <td align='center'>
            <a class="modalbox" href="#inline"><input type="button" id="btnEnviar" name="enviar" value = "Enviar fichero Contabil.Mdb (zip)" 
                                                      onclick="javascript:Enviar();" class="button" disabled="true"/></a>
            </td>
        </tr>
        </table>

    <table align="center" border="0" width="954">
        <tr></tr>
        <tr><td>
    <table align="center" border="0" width="900">
    <tr> 
      <td colspan="5"></td>
    </tr>
    <tr>
        <td>
            <div id="contador" align="center" style="width:700;"></div><br/><br/>
            <table id="numValue" class="filtro" align="center" border="0" width="700">
                
            </table>
        </td>
    </tr>
    </table>    
    </td></tr>
    <tr></tr>
    </table>
            <?php include '../vista/IndicacionIncidencia.php'; ?>
            
        </td>
        </tr>
        </table>
        
<!--formulario emergente envio Contabil.Mdb    -->
<div id="inline">
	<h2>Envio fichero 'Contabil.Mdb' (zip)</h2>

        <form id="contact" name="contact" action="../MovimientosImpExp/contabilEnviar.php" method="post">
            <label class="nombreCampo" for="email">Para</label><br/>
            <input type="email" id="email" name="email" class="textbox1"><br/>
            <label class="nombreCampo" for="email">C.C.</label><br/>
            <input type="email" id="emailCC" name="emailCC" class="textbox1"><br/>
            <br>
            <label class="nombreCampo" for="msg">Mensaje</label>
            <textarea id="msg" name="msg" class="textbox1area" rows="5"></textarea>

            <input type="button" id="send" class="button" onclick="EnviarForm();" value="Envio" />
	</form>
</div>
    </body>
</html>
