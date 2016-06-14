<?php
session_start ();
require_once '../CN/clsCNUsu.php';
require_once '../general/funcionesGenerales.php';

$clsCNUsu=new clsCNUsu();
$clsCNUsu->setStrBD($_SESSION['mapeo']);

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
//comprobamos si se ha submitido el formulario
if(isset($_POST['cmdAlta']) && $_POST['cmdAlta']=='Aceptar'){
    logger('info','consultacuentas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
           " ||||Configuracion->Mis Cuentas->Consulta/Modificación|| Ha pulsado 'Modificar'");
    
    $varRes=$clsCNUsu->ModificarCuentas($_POST['IdCuenta'],$_POST['strNombre']);
    
    if($varRes<>1){
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/error.php?id='.$varRes.'">';
    }else{
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/exito.php">';
    }
    
    
    
}else{//comienzo del else principal
    logger('info','consultacuentas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
           " ||||Configuracion->Mis Cuentas->Consulta/Modificación||");
    //cargar los datos del cliente/proveedor
    $datosCuenta=$clsCNUsu->DatosCuenta($_GET['IdCuenta']);
    
?>
<!DOCTYPE html>
<HTML>
<HEAD>
<?php
//estas funciones son generales
librerias_jQuery();
?>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../images/q.ico">
<TITLE>Cuenta - Editar</TITLE>

<script language="JavaScript">

function validar()
{
  esValido=true;
  textoError='';
  //comprobacion del campo 'strNombre'
  if (document.form1.strNombre.value == ''){ 
    textoError=textoError+"Es necesario introducir el nombre.\n";
    document.form1.strNombre.style.borderColor='#FF0000';
    document.form1.strNombre.title ='Se debe introducir el nombre';
    esValido=false;
  }
  
  
  //indicar el mensaje de error si es 'esValido' false
  if (!esValido){
          alert(textoError);
  }

  if(esValido==true){
      document.form1.submit();
  }else{
      return false;
  }  
}

//borrar cliente/proveedor
function borrarCuenta(id){
    if (confirm("¿Desea borrar el registro del usuario de la base de datos?"))
    {
        window.location='../vista/cuentaBorrar.php?id='+id;
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
<SCRIPT LANGUAGE="JavaScript" SRC="../js/valida.js">
<!--
	alert('Error en el fichero valida.js');
// -->
</SCRIPT>
<link href="../css/Estilos_Qualidad.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../css/calidad2.css" type="text/css">
<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
    eventosInputText();
?>
</HEAD>
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
<BODY bgColor=#ffffff leftMargin=0 topMargin=0 rightMargin=0 bottomMargin=0 marginwidth="0" marginheight="0"  background="<?php echo FONDO; ?>"
      onLoad="rotulo_status();<?php if(isset($_GET['borrar'])&& $_GET['borrar']=='si'){
                                       echo 'borrarCuenta('. $_GET['IdCuenta'].');';
                                       }?>">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<!-- Cabecera-->
  <tr>
   <td width="40%" height="100%" border="0"></td>
   <td  width="780" height="35" border="0" alt="" bgcolor="#FFFFFF"  class="Text2">
   <table border="0" cellpadding="0" cellspacing="0" width="780">

   <tr>
   <!-- contenido pagina -->
   <td width="768" height="854" border="0" alt="" valign="top">
   <br><p></p>

<center>
    
<?php
$tituloForm="CONSULTA DE CUENTAS";
$cabeceraNumero='010402';
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
require_once 'cabeceraForm.php';
?>
  <div class="doc"> 
    <hr color = "#FF9900">
    <br/>
    <form name="form1" method="post" action="../vista/consultacuentas.php" onSubmit="desactivaBoton()">
	
      <table width="640" border="0" class="zonaactiva">
        <tr> 
          <td class="subtitulo" colspan="10">&nbsp;Datos de la Cuenta</td>
        </tr>
        <tr>
            <td width="20%"></td>
            <td width="50%"></td>
            <td width="30%"></td>
        </tr>
        <tr>
            <td></td>
            <td>
              <div align="left">
              <label class="nombreCampo">Número:</label>
              <input class="textbox1" type="text" name="lngNumCuenta" maxlength="9" readonly
                     value="<?php echo $datosCuenta['NumCuenta'];?>" />
              </div>
            </td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>
              <div align="left">
              <label class="nombreCampo">Nombre:</label>
              <input class="textbox1" type="text" name="strNombre" maxlength="50"
                     value="<?php echo $datosCuenta['Nombre'];?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
            </td>
            <td></td>
        </tr>
        <tr>
            <td height="15px"></td>
        </tr>
      </table>

        
      <P>
        <input type="button" class="button" name="cmdAlta" id="cmdAlta" value = "Grabar" onclick="javascript:validar();" /> 
        <input class="buttonAzul" type="button" value="Volver" onclick="javascript:history.back();" />
        <input type="button" class="buttonAzul"  value="Eliminar" name="cmdBorrar" onclick="javascript:borrarCuenta(<?php echo $_GET['IdCuenta']; ?>);" />
        <input type="Reset" class="button" value="Vaciar Datos" name="cmdReset"/>
        <input type="hidden"  name="cmdAlta" value="Aceptar" />
        <input name="IdCuenta" type="hidden" value="<?php echo $_GET['IdCuenta'];?>"/>
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