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
       " ||||Operaciones->Cobrar Facturas||");


//recojo los datos serializados de el listado
$listadoFacturas = $_SESSION['listadoFacturas']; 
unset($_SESSION['listadoFacturas']);


//aqui dirijo a la presentacion en PC o Movil (APP)
if($_SESSION['navegacion']==='movil'){
    html_paginaCobrarFacturaProcesoMovil($listadoFacturas);
}else{
    html_paginaCobrarFacturaProceso($listadoFacturas);
}


function html_paginaCobrarFacturaProceso($listadoFacturas){
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="../images/q.ico">
        <title>Cobrar Facturas - Proceso</title>
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
function cobrar(idFactura){
//    alert(idFactura.numeroFactura+'-'+idFactura.cantidad+'-'+idFactura.pendiente);
    $.ajax({
      data:{"idFactura":idFactura.numeroFactura,"cantidad":idFactura.cantidad,"pendiente":idFactura.pendiente,"fecha":"<?php echo $_GET['fecha'];?>","cuenta57":"<?php echo $_GET['cuenta57'];?>"},  
      url: '../vista/cobrarFactura.php',
      type:"get",
      success: function(data) {
        //recuperamos el valor del texto
        var val = document.getElementById("numValue");
        //actualizamos el indicador visual con el texto
        val.innerHTML = data+val.innerHTML;
      }
    });
}

var idFacturas=new Array();
<?php
for($i=0;$i<count($listadoFacturas);$i++){
    ?>
    var factura = {numeroFactura:"<?php echo $listadoFacturas[$i]['numeroFactura'];?>", cantidad:<?php echo $listadoFacturas[$i]['cantidad'];?>, pendiente:<?php echo $listadoFacturas[$i]['pendiente'];?>};
    idFacturas[<?php echo $i;?>] = factura;
    <?php
}
?>

//progreso actual
var currProgress = 0;
//esta la tarea completa
var done = false;
//cantidad total de progreso
var total = <?php echo count($listadoFacturas);?>;

function startProgress() {
    //ejecuto la funcion que llama por AJAX la los procedimientos para guardar la factura    
    cobrar(idFacturas[currProgress]);

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
    window.location='../vista/cobrar_facturas.php';
}

</script>

</head>
<body onload="startProgress();">
<?php require_once '../vista/cabecera2.php'; ?>
<table align="center" border="0"  width="954">
    <tr>
        <td>
            <h3 align="center" color="#FFCC66"><font size="3px">Facturas pendientes de Cobrar. Proceso...</font></h3> 
            <table id="indicacion" align="center" border="0" width="500">
                <tr>
                    <td align="center">
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
<?php
}

function html_paginaCobrarFacturaProcesoMovil($listadoFacturas){
?>    


<!DOCTYPE html>
<html>
<head>
<TITLE>Cobro Facturas</TITLE>

<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>
</head> 
    <body onload="startProgress();">
    <div data-role="page" id="cobrar_facturas">

<script LANGUAGE="JavaScript"> 
//vble. general para llevar el contador de las variables peticions terminadas AJAX    
var petTerminadas = {count: 0}

function sumPetTerminadas(petTerminadas){
    petTerminadas.count ++;
}    
    
function cobrar(idFactura,petTerminadas){
    $.ajax({
      data:{"idFactura":idFactura.numeroFactura,"cantidad":idFactura.cantidad,"pendiente":idFactura.pendiente,"fecha":"<?php echo $_GET['fecha'];?>","cuenta57":"<?php echo $_GET['cuenta57'];?>"},  
      url: '../vista/cobrarFactura.php',
      type:"get",
      success: function(data) {
        sumPetTerminadas(petTerminadas); 
        //recuperamos el valor del texto
        var val = document.getElementById("numValue");
        //actualizamos el indicador visual con el texto
        val.innerHTML = data+val.innerHTML;
        if(petTerminadas.count === <?php echo count($listadoFacturas);?>){
            val.innerHTML = '<b>Proceso TERMINADO</b><br/><br/>'+val.innerHTML;
        }
      }
    });
}

var idFacturas=new Array();
<?php
for($i=0;$i<count($listadoFacturas);$i++){
    ?>
    var factura = {numeroFactura:"<?php echo $listadoFacturas[$i]['numeroFactura'];?>", cantidad:<?php echo $listadoFacturas[$i]['cantidad'];?>, pendiente:<?php echo $listadoFacturas[$i]['pendiente'];?>};
    idFacturas[<?php echo $i;?>] = factura;
    <?php
}
?>

//progreso actual
var currProgress = 0;
//esta la tarea completa
var done = false;
//cantidad total de progreso
var total = <?php echo count($listadoFacturas);?>;

function startProgress() {
    //ejecuto la funcion que llama por AJAX la los procedimientos para guardar la factura    
    cobrar(idFacturas[currProgress],petTerminadas);

    ////incrementamos el valor del progreso cada vez que la funcion se ejecuta
    currProgress++;
    //comprobamos si hemos terminado
    if(currProgress>(idFacturas.length-1)){
        done=true;
    }
    // sino hemos terminado, volvemos a llamar a la funcion despues de un tiempo
    if(!done)
    {
        setTimeout("startProgress()",0);
    }  
}

function inicio(){
    window.location='../vista/cobrar_facturas.php';
}

</script>

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>
        
    <div data-role="content" data-theme="a">
        <h3 align="center" color="#FFCC66"><font size="3px">Facturas pendientes de Cobrar. Proceso...</font></h3>
        
        <table border="0" style="width: 100%;">
            <tbody>
                <tr>
                    <td style="width: 25%;"></td>
                    <td style="width: 50%;"></td>
                    <td style="width: 25%;"></td>
                </tr>
                <tr>
                    <td colspan="2" height="20px"></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <div id="numValue"></div>
                    </td>
                </tr>
<!--                <tr>
                    <td></td>
                    <td>
                        <div id="botonVolver" style="display: none;">
                            <input data-theme="b" data-mini="true" id="startBtn" type="button" name="eleccion" value="Volver" onclick="inicio();" />
                        </div>
                    </td>
                </tr>-->
            </tbody>
        </table>
        
    </div>  
    </div>    
    </body>
</html>


<?php
}
?>