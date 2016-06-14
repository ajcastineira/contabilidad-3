<?php
session_start ();
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



//codigo principal
//comprobamos si se ha submitido el formulario y que valor viene en 'cmdAlta' y 'optTipoAsiento'
if(isset($_POST['optTipoAsiento'])){
    logger('info','gastos_entrada.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
           " ||||Operaciones->Compras y Gastos||(Submitido)");

    
    if($_POST['optTipoAsiento'] === 'General'){
        header('Location: ../'.$_SESSION['navegacion'].'/gastos_entrada1.php');
    }else
    if($_POST['optTipoAsiento'] === 'Nomina'){
        header('Location: ../vista/gastos_nomina.php');
    }


    
//    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/gastos_SF.php?esAbono='.$_POST['optAbono'].'">';
//    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/gastos_entrada2.php?pag=gastos_SF&esAbono='.$_POST['optAbono'].'">';

}else{
logger('info','gastos_entrada.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
       " ||||Operaciones->Compras y Gastos||(Menu eleccion)");

?>
<!DOCTYPE html>
<HTML>
<head>
<?php
//estas funciones son generales
librerias_jQuery();
eventosInputText();
?>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../images/q.ico">
<TITLE>Alta de Gastos - Opciones</TITLE>

<script language="JavaScript">

function ActivaForm(objeto){
    if(objeto.value==='ConFactura'){
        document.getElementById('formOpciones').style.display='block';
    }else{
        document.getElementById('formOpciones').style.display='none';
        alert("Salvo excepciones, la entrega de productos y servicios debe realizarse mediante la correspondiente factura. Mediante esta opción podrá contabilizar gastos no sujetos a la obligación de expedir factura (ej.: impuestos, seguros, etc.). ");
    }
}

</script>
<script language="JavaScript">
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
<script languaje="JavaScript"  type="text/JavaScript">
function Modificar(menu)
{

		document.form1.strTipReclamacion.value = menu.options[menu.selectedIndex].text
}
</script>
<link href="../css/Estilos_Qualidad.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../css/calidad2.css" type="text/css">
<SCRIPT LANGUAGE="JavaScript">
function desactivaBoton() {
	if (this.form1.cmdAlta.value == "Anular") {
	  alert("Está intentando dar de alta dos veces");
  this.form1.strDescripcion.name="";
	}else{
		this.form1.cmdAlta.value = "Anular";
	}
}
</SCRIPT> 
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
clock.innerHTML = movingtime;
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
<body bgColor=#ffffff leftMargin=0 topMargin=0 rightMargin=0 bottomMargin=0 marginwidth="0" marginheight="0"  background="<?php echo FONDO; ?>" onLoad="rotulo_status();">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<!-- Cabecera-->
  <tr>
   <td width="40%" height="100%" border="0"></td>
   <td  width="780" height="35" border="0" alt="" bgcolor="#FFFFFF"  class="Text2">
   <table border="<?php echo MARCO_BORDER; ?>" cellpadding="0" cellspacing="0" width="780">

   <tr>
   <!-- contenido pagina -->
   <td width="768" height="854" border="0" alt="" valign="top">
   <br><p></p>

<center>
    
<?php
$tituloForm='CONTABILIZAR GASTOS';
$cabeceraNumero='0203';
$paginaForm='';
//require_once 'CodFormat.php';
//$codFormat=new CodFormat();
//$codFormat->setStrBD($_SESSION['dbContabilidad']);
//$formatoForm=$codFormat->SelectFormato(60);
$formatoForm='';
$numeroForm='';
$disabledForm='disabled';
date_default_timezone_set('Europe/Madrid');
$fechaForm=date('d/m/Y');
$fechaYear=date('Y');
require_once 'cabeceraForm.php';
?>
  <div class="doc"> 
    <hr color = "#FF9900">
    <br/>
    <form name="form1" method="post" action="../vista/gastos_entrada.php">
	
        
        <table width="640" border="0" class="zonaactiva">
            <tr> 
                <td class="subtitulo" colspan="4">&nbsp;Tipo de Asiento</td>
            </tr>
            <tr>
                <td height="15px"></td>
            </tr>
            <tr>
                <td width="15%"></td>
                <td width="40%"></td>
                <td width="10%"></td>
                <td></td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <div align="right">
                        <label class="nombreCampo">Asiento General</label>
                    </div>
                </td>
                <td>
                    <div align="left">
                        <input class="txtgeneral" type="radio" name="optTipoAsiento" value="General" checked />
                    </div>
                </td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <div align="right">
                        <label class="nombreCampo">Nómina</label>
                    </div>
                </td>
                <td>
                    <div align="left">
                        <input class="txtgeneral" type="radio" name="optTipoAsiento" value="Nomina" />
                    </div>
                </td>
            </tr>

            <tr>
                <td height="15px"></td>
            </tr>
        </table>

        

      <P>
        <input type="submit" class="button" value = "Continuar" /> 
      </P>
        
      <?php include '../vista/IndicacionIncidencia.php'; ?>
    </form>
  </div>
</center>

   </td>
   <!-- contenido pagina -->
  </tr>
  </table>
</td>
    <td  width="40%" height="100%" border="0" alt=""  ></td>
  </tr>
<!-- presentacion-->   
</table>
</body>
</html>
<?php
}//fin del else principal
?>