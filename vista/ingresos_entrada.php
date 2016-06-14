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
//comprobamos si se ha submitido el formulario y que que valor viene en 'cmdAlta'
//aqui viene los tres valores indicados en la anterior pantalla
//las distintas convinaciones son:
//  SinFactura+IVA1                         = Caso 1
//  ConFactura+IVA1+SinRetencionIRPF        = Caso 2
//  ConFactura+IVA1+ConRetencionIRPF        = Caso 3 
//  ConFactura+IVA_Varios+SinRetencionIRPF  = Caso 4
//  ConFactura+IVA_Varios+ConRetencionIRPF  = Caso 5

//Aqui redireccionamos a la pagina de gastos segun las opciones elegidas

//aqui hay que ver si la variable optTipoIVA viene con los valores IVA1 o IVA_Varios
//si el valor es IVA_Varios, sale este cuadro con 4 lineas mas y la suma al final
if(isset($_POST['optFactura']) && $_POST['optFactura']=='SinFactura'){
    logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
           " ||||Operaciones->Mis Ingresos||(Sin Factura)");
    
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/ingresos_SF.php?esAbono='.$_POST['optAbono'].'">';
}else
if(isset($_POST['optFactura']) && $_POST['optFactura']=='ConFactura' && 
   isset($_POST['optTipoIVA']) && $_POST['optTipoIVA']=='IVA_Varios' &&
   isset($_POST['optRetIRPF']) && $_POST['optRetIRPF']=='SinRetencionIRPF'){ 
    logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
           " ||||Operaciones->Mis Ingresos||(Con Factura + Varios IVAs + Sin Retencion IRPF)");
    
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/ingresos_CFIVAV.php?esAbono='.$_POST['optAbono'].'">';
}else
if(isset($_POST['optFactura']) && $_POST['optFactura']=='ConFactura' && 
   isset($_POST['optTipoIVA']) && $_POST['optTipoIVA']=='IVA1' &&
   isset($_POST['optRetIRPF']) && $_POST['optRetIRPF']=='SinRetencionIRPF'){ 
    logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
           " ||||Operaciones->Mis Ingresos||(Con Factura + 1 IVA + Sin Retencion IRPF)");
    
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/ingresos_CFIVA1SIRPF.php?esAbono='.$_POST['optAbono'].'">';
}else
if(isset($_POST['optFactura']) && $_POST['optFactura']=='ConFactura' && 
   isset($_POST['optTipoIVA']) && $_POST['optTipoIVA']=='IVA_Varios' &&
   isset($_POST['optRetIRPF']) && $_POST['optRetIRPF']=='ConRetencionIRPF'){ 
    logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
           " ||||Operaciones->Mis Ingresos||(Con Factura + 1 IVA + Con Retencion IRPF)");
    
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/ingresos_CFIVAVCIRPF.php?esAbono='.$_POST['optAbono'].'">';
}else
if(isset($_POST['optFactura']) && $_POST['optFactura']=='ConFactura' && 
   isset($_POST['optTipoIVA']) && $_POST['optTipoIVA']=='IVA1' &&
   isset($_POST['optRetIRPF']) && $_POST['optRetIRPF']=='ConRetencionIRPF'){ 
    logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
           " ||||Operaciones->Mis Ingresos||(Con Factura + 1 IVA + Con Retencion IRPF)");
    
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/ingresos_CFIVA1CIRPF.php?esAbono='.$_POST['optAbono'].'">';
    
}else{
logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
       " ||||Operaciones->Mis Ingresos||(Menu eleccion)");

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
<TITLE>Alta de Ingresos - Opciones</TITLE>

<script language="JavaScript">

function ActivaForm(objeto){
    if(objeto.value==='ConFactura'){
        document.getElementById('formOpciones').style.display='block';
    }else{
        document.getElementById('formOpciones').style.display='none';
    }
}

//function enabledIVAs(){
//    document.form1.optRetIRPF[1].disabled=false;
//}
//function disabledIVAs(){
//    document.form1.optRetIRPF[0].checked=true;
//    document.form1.optRetIRPF[1].disabled=true;
//}


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
<SCRIPT LANGUAGE="JavaScript" SRC="../js/valida.js">
<!--
	alert('Error en el fichero valida.js');
// -->
</SCRIPT>
<link href="../css/Estilos_Qualidad.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../css/calidad2.css" type="text/css">
<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
    //eventosInputText();
?>
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
<SCRIPT language="JavaScript" SRC="../js/car_valido.js">

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
$tituloForm='CONTABILIZAR INGRESOS';
$cabeceraNumero='0202';
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
    <form name="form1" method="post" action="../vista/ingresos_entrada.php">
	
        
      <table width="640" border="0" class="zonaactiva">
        <tr> 
          <td class="subtitulo" colspan="4">&nbsp;Factura</td>
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
                <label class="nombreCampo">Con Factura</label>
                </div>
            </td>
            <td>
                <div align="left">
                <input class="txtgeneral" type="radio" name="optFactura" value="ConFactura" checked onClick="ActivaForm(this);" />
                </div>
            </td>
        </tr>
        
        <tr>
            <td></td>
            <td>
                <div align="right">
                <label class="nombreCampo">Sin Factura</label>
                </div>
            </td>
            <td>
                <div align="left">
                <input class="txtgeneral" type="radio" name="optFactura" value="SinFactura" onClick="ActivaForm(this);" />
                </div>
            </td>
        </tr>
        
        <tr>
            <td height="15px"></td>
        </tr>
      </table>
        
      <div id="formOpciones" style="display:block">

        <table width="640" border="0" class="zonaactiva">
          <tr> 
            <td class="subtitulo" colspan="4">&nbsp;IVA</td>
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
                  <label class="nombreCampo">1 sólo tipo de IVA</label>
                  </div>
              </td>
              <td>
                  <div align="left">
                  <input class="txtgeneral" type="radio" name="optTipoIVA" value="IVA1" checked />
                  </div>
              </td>
          </tr>

          <tr>
              <td></td>
              <td>
                  <div align="right">
                  <label class="nombreCampo">Varios tipos de IVA</label>
                  </div>
              </td>
              <td>
                  <div align="left">
                  <input class="txtgeneral" type="radio" name="optTipoIVA" value="IVA_Varios" />
                  </div>
              </td>
          </tr>

          <tr>
              <td height="15px"></td>
          </tr>
        </table>

        <table width="640" border="0" class="zonaactiva">
          <tr> 
            <td class="subtitulo" colspan="4">&nbsp;IRPF</td>
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
                  <label class="nombreCampo">Factura sin retención IRPF</label>
                  </div>
              </td>
              <td>
                  <div align="left">
                  <input class="txtgeneral" type="radio" name="optRetIRPF" value="SinRetencionIRPF" checked />
                  </div>
              </td>
          </tr>

          <tr>
              <td></td>
              <td>
                  <div align="right">
                  <label class="nombreCampo">Factura con retención IRPF</label>
                  </div>
              </td>
              <td>
                  <div align="left">
                  <input class="txtgeneral" type="radio" name="optRetIRPF" value="ConRetencionIRPF" />
                  </div>
              </td>
          </tr>

          <tr>
              <td height="15px"></td>
          </tr>
        </table>
          
      </div>
        
        <table width="640" border="0" class="zonaactiva">
          <tr> 
            <td class="subtitulo" colspan="4">&nbsp;Abono (Factura negativa)</td>
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
                  <label class="nombreCampo">No</label>
                  </div>
              </td>
              <td>
                  <div align="left">
                  <input class="txtgeneral" type="radio" name="optAbono" value="NO" checked />
                  </div>
              </td>
          </tr>

          <tr>
              <td></td>
              <td>
                  <div align="right">
                  <label class="nombreCampo">Si</label>
                  </div>
              </td>
              <td>
                  <div align="left">
                  <input class="txtgeneral" type="radio" name="optAbono" value="SI" />
                  </div>
              </td>
          </tr>

          <tr>
              <td height="15px"></td>
          </tr>
        </table>

      <P>
        <input type="submit" class="button" value = "Continuar" /> 
<!--        <input type="hidden"  name="cmdAlta" value="Aceptar" />-->
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