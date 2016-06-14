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

                
logger('info','contabilizar_facturas_proceso.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
       " ||||Operaciones->Modificar Asiento||");


//extraigo los id de los check (son las IdFactura a contabilizar) del POST
$IdFacturas='';
foreach($_POST as $prop=>$valor){
    if(substr($prop,0,2)==='id'){
        $IdFactura=substr($prop,2);
        $IdFacturas[]=$IdFactura;
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="../images/q.ico">
        <title>Contabilizar Facturas - Proceso</title>
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
function contabilizar(idFactura,currProgress,total){
    $.ajax({
      data:{"idFactura":idFactura},  
      url: '../vista/contabilizarFactura.php',
      async: false,
      type:"get",
      success: function(data) {
        var contador = parseInt(document.getElementById('contadorParcial').value);
        contador++;
        document.getElementById('contadorParcial').value = contador;
        document.getElementById('contador').innerHTML='Contabilizada '+(contador)+' de '+total;
        //recuperamos el valor del texto
        var val = document.getElementById("numValue");
        //actualizamos el indicador visual con el texto
        val.innerHTML = data+val.innerHTML;
      }
    });
}

var idFacturas=new Array();
<?php
for($i=0;$i<count($IdFacturas);$i++){
    ?>
    idFacturas[<?php echo $i;?>]=<?php echo $IdFacturas[$i];?>;
    <?php
}
?>

//progreso actual
var currProgress = 0;
//esta la tarea completa
var done = false;
//cantidad total de progreso
var total = <?php echo count($IdFacturas);?>;

function startProgress() {
    //ejecuto la funcion que llama por AJAX la los procedimientos para guardar la factura    
    contabilizar(idFacturas[currProgress],currProgress,total);

    ////incrementamos el valor del progreso cada vez que la funciÃ³n se ejecuta
    currProgress++;
    //comprobamos si hemos terminado
    if(currProgress>(idFacturas.length-1)){
        done=true;
    }
    // sino hemos terminado, volvemos a llamar a la funciÃ³n despuÃ©s de un tiempo
    if(!done)
    {
        document.getElementById("startBtn").disabled = true;
        setTimeout("startProgress()",0);
    }  
    //tarea terminada, habilitar el botón
    else{   
        document.getElementById("startBtn").disabled = false;
    }
}

function inicio(){
    window.location='../vista/contabilizar_facturas.php';
}

</script>

</head>
<body onload="startProgress();">
<?php require_once '../vista/cabecera2.php'; ?>
<table align="center" border="0"  width="954">
    <tr>
        <td>
            <h3 align="center" color="#FFCC66"><font size="3px">Facturas pendientes de Contabilizar. Proceso...</font></h3> 
            <table id="indicacion" align="center" border="0" width="500">
                <tr>
                    <td align="center">
                        <div id="contador" align="center" style="width:700;"></div><br/><br/>
                        <input type="hidden" id="contadorParcial" value="0" />
<!--                        <progress id="prog" value="0" max="<?php //echo count($IdFacturas);?>"></progress> -->
                        <div id="numValue"></div>
                    </td>
                </tr>
            </table>   
            <div align="center">
                <input class="button" id="startBtn" type="button" name="eleccion" value="Volver" onclick="inicio();" disabled />
            </div>

            <br/><br/><br/>
            <?php include '../vista/IndicacionIncidencia.php'; ?>
        </td>
        </tr>
        </table>
    </body>
</html>
