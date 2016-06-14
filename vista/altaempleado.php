<?php
session_start ();
require_once '../CN/clsCNUsu.php';
require_once '../general/funcionesGenerales.php';

$clsCNUsu=new clsCNUsu();
$clsCNUsu->setStrBD($_SESSION['dbContabilidad']);

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
    logger('info','altaempleado.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id(). " ||||Configuracion->Mis Usuario->Alta|| Ha pulsado 'Guardar Datos'");
    $num=$clsCNUsu->IdUsuarioNuevo();
    //ahora compruebo si vengo por GET la variable 'idEmp'
    //si es asi es la empresa que debo insertar al usuario
    //sino es la empresa actual (sesion)
    $idEmpresa=$_SESSION['idEmp'];
    if(isset($_POST['idEmpresa']) && $_POST['idEmpresa']<>''){
        $idEmpresa=$_POST['idEmpresa'];
    }
    
    $varRes=$clsCNUsu->Alta($num,$idEmpresa,$_POST['strNombre'],$_POST['strApellidos'],$_POST['lngTelefono'],
                            $_POST['lngMovil'],$_POST['strCorreos'],$_POST['strUsuario'],$_POST['strPassword']);
    if($varRes<>1){
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/error.php?id='.$varRes.'">';
    }else{
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/exito.php">';
    }
    
    
    
}else{//comienzo del else principal
    logger('info','altaempleado.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id(). " ||||Configuracion->Mis Usuario->Alta|| ");
    
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
<TITLE>Empleado - ALTA</TITLE>

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
  //comprobacion del campo 'strApellidos'
  if (document.form1.strApellidos.value == ''){ 
    textoError=textoError+"Es necesario introducir los apellidos.\n";
    document.form1.strApellidos.style.borderColor='#FF0000';
    document.form1.strApellidos.title ='Se deben introducir los apellidos';
    esValido=false;
  }
  //comprobacion del campo 'strCorreos'
  if (document.form1.strCorreos.value == ''){ 
    textoError=textoError+"Es necesario introducir un E-mail.\n";
    document.form1.strCorreos.style.borderColor='#FF0000';
    document.form1.strCorreos.title ='Se debe introducir un E-mail';
    esValido=false;
  }else{
    //compruebo que el e-mail tenga un formato correcto 'admin@admin.com'  
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(document.form1.strCorreos.value) ){
        textoError=textoError+"El E-mail " + document.form1.strCorreos.value + " es incorrecto.\n";
        document.form1.strCorreos.style.borderColor='#FF0000';
        document.form1.strCorreos.title ='El E-mail es incorrecto';
        esValido=false;
    }
  }
  //comprobacion del campo 'strUsuario'
  if (document.form1.strUsuario.value == ''){ 
    textoError=textoError+"Es necesario introducir el nombre.\n";
    document.form1.strUsuario.style.borderColor='#FF0000';
    document.form1.strUsuario.title ='Se debe introducir el nombre';
    esValido=false;
  }
  //comprobacion del campo 'strPassword'
  if (document.form1.strPassword.value == ''){ 
    textoError=textoError+"Es necesario introducir la contraseña.\n";
    document.form1.strPassword.style.borderColor='#FF0000';
    document.form1.strPassword.title ='Se debe introducir la contraseña';
    esValido=false;
  }
  //comprobacion del campo 'strPassword2'
  if (document.form1.strPassword2.value == ''){ 
    textoError=textoError+"Es necesario introducir la repetición de la contraseña.\n";
    document.form1.strPassword2.style.borderColor='#FF0000';
    document.form1.strPassword2.title ='Se debe introducir repetición de la contraseña';
    esValido=false;
  }
  //comprobacion del campo 'strPassword' y 'strPassword2' son iguales
  if ((document.form1.strPassword.value != '')&&(document.form1.strPassword2.value != '') &&
       (document.form1.strPassword.value != document.form1.strPassword2.value) ){ 
    textoError=textoError+"La contraseña debe coincidir en los campos contraseña y repetir contraseña.\n";
    document.form1.strPassword.style.borderColor='#FF0000';
    document.form1.strPassword2.style.borderColor='#FF0000';
    document.form1.strPassword.title ='Esta contraseña debe coincidir con la del campo repetir';
    document.form1.strPassword2.title ='Esta repetición de contraseña debe coincidor con la del campo contraseña';
    esValido=false;
  }

  //comprobacion de que el nombre de usuario no esta repetido
  texto=document.getElementById("txt_usuario").innerHTML;
  if (texto.indexOf('error') != -1){
    textoError=textoError+"El nombre de usuario ya existe.\n";
    document.form1.strUsuario.style.borderColor='#FF0000';
    esValido=false;
  }
  
  
  //indicar el mensaje de error si es 'esValido' false
  if (!esValido){
          alert(textoError);
  }

  if(esValido==true){
      document.getElementById("cmdAlta").value = "Enviando...";
      document.getElementById("cmdAlta").disabled = true;
      document.form1.submit();
  }else{
      return false;
  }  
}

//AJAX jQuery chequea usuario exista en la BD
function check_usuario(str){
    $.ajax({
      data:{"q":str},  
      url: '../vista/ajax/buscar_usuario.php',
      type:"get",
      success: function(data) {
        $('#txt_usuario').html(data);
      }
    });
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
<BODY bgColor=#ffffff leftMargin=0 topMargin=0 rightMargin=0 bottomMargin=0 marginwidth="0" marginheight="0"  background="<?php echo FONDO; ?>" onLoad="rotulo_status();">
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
$tituloForm="ALTA DE USUARIOS";
$cabeceraNumero='010101';
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
    <form name="form1" method="post" action="../vista/altaempleado.php" onSubmit="desactivaBoton()">
	
      <table width="640" border="0" class="zonaactiva">
        <tr> 
          <td class="subtitulo" colspan="10">&nbsp;Datos del Usuario</td>
        </tr>
        <tr>
            <td width="10%"></td>
            <td width="10%"></td>
            <td width="10%"></td>
            <td width="10%"></td>
            <td width="10%"></td>
            <td width="10%"></td>
            <td width="10%"></td>
            <td width="10%"></td>
            <td width="10%"></td>
        </tr>
        <tr> 
            <td colspan="7">
              <div align="left">
              <label class="nombreCampo">Nombre</label>
              <input class="textbox1" type="text" name="strNombre" maxlength="30"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
          </td>
        </tr>
        <tr>
          <td colspan="7">
              <div align="left">
              <label class="nombreCampo">Apellidos</label>
              <input class="textbox1" type="text" name="strApellidos" maxlength="30"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
        </tr>
        <tr> 
          <td colspan="2"> 
              <div align="left">
              <label class="nombreCampo">Teléfono</label>
              <input class="textbox1" type="text" name="lngTelefono" maxlength="12" onkeypress="javascript:return solonumeros(event);"  
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
          <td></td>
          <td colspan="2">
              <div align="left"> 
              <label class="nombreCampo">Movil</label>
              <input class="textbox1" type="text" name="lngMovil" maxlength="20" onkeypress="javascript:return solonumeros(event);" 
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
          <td></td>
          <td colspan="3">
              <div align="left">
              <label class="nombreCampo">E-mail</label>
              <input class="textbox1" type="text" name="strCorreos" maxlength="50"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
          <td width="5%"></td>
        </tr>
        <tr>
            <td height="15px"></td>
        </tr>
      </table>

        
      <table width="640" border="0" class="zonaactiva">
          <tr>
              <td height="5" width="10%"></td>
              <td width="30%"></td>
              <td width="20%"></td>
              <td width="30%"></td>
              <td width="10%"></td>
          </tr>  
        <tr> 
          <td class="subtitulo" colspan="10">&nbsp;Datos de Sesión del Usuario</td>
        </tr>
        <tr>
          <td></td>
          <td>
              <div align="left">
              <label class="nombreCampo">Nombre de Usuario</label>
              <input class="textbox1" type="text" name="strUsuario" maxlength="30" onKeyUp="check_usuario(this.value);"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);" onblur="check_usuario(this.value);onBlurInputText(this);"/>
              </div>
          </td>
          <td>
              <table border="0">
                  <tr>
                      <td height="5">&nbsp;</td>
                  </tr>
                  <tr>
                      <td height="20">
                         <span valign="top" id="txt_usuario"></span>
                      </td>
                  </tr>
                  <tr>
                      <td></td>
                  </tr>
                  <tr>
                      <td></td>
                  </tr>
              </table>
          <td>
              <div align="left">
                  <label class="nombreCampo" style="font-size:11px;">NOTA: El nombre de usuario y la contraseña serán de 10 caracteres como máximo </label>
              </div>
          </td>
          <td></td>
        </tr>
        <tr>
          <td></td>
          <td>
              <div align="left">
              <label class="nombreCampo">Contraseña</label>
              <input class="textbox1" type="password" name="strPassword" maxlength="10"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
          <td></td>
          <td>
              <div align="left">
              <label class="nombreCampo">Repetir Contraseña</label>
              <input class="textbox1" type="password" name="strPassword2" maxlength="10"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
          <td></td>
        </tr>
        <tr>
            <td height="15px"></td>
        </tr>
      </table>
      <P>
        <input type="Reset" class="buttonAzul" value="Vaciar Datos" name="cmdReset"/>
        <input type="button" class="button" name="cmdAlta" id="cmdAlta" value = "Proceder al Alta" onclick="javascript:validar();" /> 
        <input type="hidden"  name="cmdAlta" value="Aceptar" />
        <input type="hidden"  name="idEmpresa" value="<?php if(isset($_GET['idEmp'])){echo $_GET['idEmp'];}?>" />
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