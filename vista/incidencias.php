<?php
session_start ();
require_once '../CN/clsCNUsu.php';
require_once '../CN/clsCNConsultas.php';
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

$clsCNUsu=new clsCNUsu();
$clsCNUsu->setStrBD($_SESSION['dbContabilidad']);
$clsCNConsultas=new clsCNConsultas();
$clsCNConsultas->setStrBD($_SESSION['dbContabilidad']);

$datosUsuario=$clsCNUsu->DatosUsuario($_SESSION['usuario']);


//funcion de envio de correo a asesoria@qualidad.com
function EnviaCorreo($strCorreoUsuario,$Usuario,$strConsulta){
    $from = $strCorreoUsuario;
    $soporte = "asesoria@qualidad.com";
    $jm = "jm.ortega@qualidad.com";
    
    
    //codigo del html
    $strHTML = '<table width="440"  border="0" height="22" class="txtgeneral">'; 

    $strHTML = $strHTML . "<tr><td>Ese correo a sido enviado por el Cliente: $Usuario</td></tr>";
    $strHTML = $strHTML . "<tr><td>El enunciado de la incidencia es:</td></tr>";
    $strHTML = $strHTML . "<tr><td></td></tr>";
    $strHTML = $strHTML . "<tr><td></td></tr>";
    $strHTML = $strHTML . "<tr><td><i>$strConsulta</i></td></tr>";
    $strHTML = $strHTML . "<tr><td></td></tr>";
    $strHTML = $strHTML . "<tr><td></td></tr>";
    $strHTML = $strHTML . '<tr><td>Departamento de Calidad</td></tr>';
    $strHTML = $strHTML . '<tr><td><center><IMG SRC="https://www.qualidad.es/contabilidad/images/'.$_SESSION['logo']. '" BORDER="0" width="132" height="67"></center>';				
    $strHTML = $strHTML . '</td></tr>';
    $strHTML = $strHTML . '</table>';

    $strHTML ='<HTML><BODY><font face=""Verdana, Arial, Helvetica, sans-serif"" size=""-1"">'.$strHTML.'</font></BODY></HTML>';
    $content  = nl2br($strHTML);

    $to = $soporte;
    $Cc=$jm;
    $subject = 'Sistema de Calidad';
    //datos del presupuesto

    $semi_rand = md5(time());
    $mime_boundary = "==TecniBoundary_x{$semi_rand}x";

    $headers = "From: $from\r\n";
//    $headers .= "Cc: $Cc\r";
    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";

    $message = $content;
    $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"utf-8\"\r\n" .
    "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n";

    $message .= "--{$mime_boundary}--";
    mail($from, $subject, $message, $headers);
}


//codigo principal
//pulso el boton cmdAlta
if(isset($_POST['opcion'])){
    logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
           " ||||Incidencias(Pulsado 'Alta Incidencia')||");
    
    //Añado el nombre del fichero al comienzo de la descripción
    $descripcion="<u>Descripción de la Incidencia:</u>\r\n".$_POST['descripcion']."\r\n"."\r\n<u>Pagina: </u>".$_POST['pagina'];
    
    //doy de alta la incidencia en la tabla 'tbconsulta_pregunta' de la BBDD contabilidad
    $IdPregunta=$clsCNConsultas->AltaPregunta($_SESSION['usuario'], $descripcion, "");
    
    //si $varRes==1 es exito voy a exito, sino a error
    if($IdPregunta==false){
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/error.php?id='.$IdPregunta.'">';
    }else{
        //ahora actualizo la clasificacion=Técnico y estado=Abierto
        $OK=$clsCNConsultas->ActualizarPregunta($IdPregunta,"Técnico","Abierto");
        EnviaCorreo($datosUsuario['strCorreo'],$datosUsuario['strNombre'].' '.$datosUsuario['strApellidos'],$descripcion);
        if($OK<>1){
            echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/error.php?id='.$OK.'">';
        }else{
            echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/exito.php?Id=La incidencia a sido registrada correctamente.<br/>Puede seguir el curso de esta incidencia en COMUNICACIONES->CONSULTAS AL ASESOR.<br>">';
        }
    }
}
//comienzo del else principal
else{
    logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
           " ||||Incidencias||");
?>
<!DOCTYPE html>
<html>
<head>
<?php
//estas funciones son generales
librerias_jQuery();
eventosInputText();
?>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../images/q.ico">
<TITLE>Redacción de Incidencias</TITLE>

<script language="JavaScript">

function validar2()
{
  esValido=true;
  textoError='';
  
  //comprobacion del campo 'pagina'
  if (document.form1.pagina.value === ''){ 
    textoError=textoError+"Es necesario introducir la página donde se generó el error.\n";
    document.form1.pagina.style.borderColor='#FF0000';
    document.form1.pagina.title ='Es necesario introducir la página donde se generó el error';
    esValido=false;
  }

  //comprobacion del campo 'descripcion'
  if (document.form1.descripcion.value === ''){ 
    textoError=textoError+"Es necesario introducir la descripción de la incidencia.\n";
    document.form1.descripcion.style.borderColor='#FF0000';
    document.form1.descripcion.title ='Es necesario introducir la descripción de la incidencia';
    esValido=false;
  }


  //indicar el mensaje de error si es 'esValido' false
  if (!esValido){
          alert(textoError);
  }

  if(esValido==true){
      document.form1.cmdAlta.value = "Enviando...";
      document.form1.cmdAlta.disabled = true;
      document.form1.submit();
  }else{
      return false;
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
<body bgColor=#ffffff leftMargin=0 topMargin=0 rightMargin=0 bottomMargin=0 marginwidth="0" marginheight="0"  background="<?php echo FONDO; ?>"
      onLoad="rotulo_status();">
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
$tituloForm='Envío de Incidencias';
$cabeceraNumero='incidenc';
$paginaForm='';
$formatoForm='';
$numeroForm='';
$disabledForm='disabled';
date_default_timezone_set('Europe/Madrid');
$fechaForm=date('d/m/Y');
$pathAnterior=$_SERVER['HTTP_REFERER'];
$ficheroAnterior=explode('/',$pathAnterior);
$ficheroAnterior=$ficheroAnterior[count($ficheroAnterior)-1];
if($ficheroAnterior==='defaultAsesor.php'){
    require_once 'cabeceraFormAsesor.php';
}else{
    require_once 'cabeceraForm.php';
}
?>
  <div class="doc"> 
    <hr color = "#FF9900">
    <br/>
    <h2>El envío de este formulario nos ayuda a mejorar la aplicación</h2>
    <form name="form1" method="post" action="../vista/incidencias.php" onSubmit="desactivaBoton();">
        
      <table width="640" border="0" class="zonaactiva">
        <tr> 
          <td class="subtitulo" colspan="10">&nbsp;Datos de la Incidencia</td>
        </tr>
        <tr>
            <td width="18%"></td>
            <td width="5%"></td>
            <td width="17%"></td>
            <td width="5%"></td>
            <td width="5%"></td>
            <td width="17%"></td>
            <td width="5%"></td>
            <td width="5%"></td>
            <td width="18%"></td>
            <td width="5%"></td>
        </tr>
<!--        <tr> 
            <td>
              <div align="left">
              <label class="nombreCampo">Tipo de Incidencia</label>
              </div>
            </td>
            <td></td>
            <td>
              <div align="right">
              <label class="nombreCampo">Código Fuente</label>
              </div>
            </td>
            <td class="txtgeneral">
                <input name="tipo" type="radio" value="1" checked="true" />
            </td>
            <td></td>
            <td>
              <div align="right">
              <label class="nombreCampo">Aspecto Visual</label>
              </div>
            </td>
            <td class="txtgeneral">
              <input name="tipo" type="radio" value="2" />
            </td>
            <td></td>
            <td>
              <div align="right">
              <label class="nombreCampo">Error de Servidor</label>
              </div>
            </td>
            <td class="txtgeneral">
              <input name="tipo" type="radio" value="3" />
            </td>
        </tr>-->
        <tr>
            <td height="15px"></td>
        </tr>
        <tr> 
          <td colspan="2">
              <div align="left">
              <label class="nombreCampo">Página de Incidencia</label>
              </div>
          </td>
          <td colspan="4">
              <input class="textbox1" type="text" name="pagina"
                     value="<?php echo $_GET['pag']; ?>"
                     <?php
                     if(isset($_GET['pag'])){
                         echo 'readonly';
                     }else{
                        echo 'onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" ';
                        echo 'onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"';
                     }
                     ?> />
          </td>
          <td></td>
<!--          <td> 
              <div align="right">
              <label class="nombreCampo">Estado</label>
              </div>
          </td>
          <td colspan="3">
              <div align="left">
              <select name="estado">
                  <option value="Abierta">Abierta</option>
                  <option value="Cerrada">Cerrada</option>
                  <option value="Resuelta">Resuelta</option>
              </select>
              </div>
          </td>-->
          <td></td>
        </tr>
        <tr>
            <td height="15px"></td>
        </tr>
      </table>
        
      <table width="640" border="0" class="zonaactiva">
        <tr> 
          <td class="subtitulo" colspan="9">&nbsp;Descripción de la Incidencia</td>
        </tr>
        <tr>
            <td width="3%"></td>
            <td width="20%"></td>
            <td width="8%"></td>
            <td width="20%"></td>
            <td width="8%"></td>
            <td width="15%"></td>
            <td width="8%"></td>
            <td width="15%"></td>
            <td width="3%"></td>
        </tr>
        <tr>
          <td></td>
          <td colspan="7">
              <div align="left">
                <textarea class="textbox1area" name="descripcion" rows=4 
                      cols="20" onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                      onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"></textarea> 
              </div>
          </td>
        </tr>
        <tr>
            <td height="15px"></td>
        </tr>
      </table>
        
      <table width="640" border="0" class="zonaactiva">
        <tr> 
          <td class="subtitulo">&nbsp;Usuario</td>
          <td class="subtitulo">&nbsp;Fecha</td>
        </tr>
        
        <tr>
            <td width="70%">
                <div align="left">
                   <label class="nombreCampo"><?php echo $datosUsuario['strNombre'].' '.$datosUsuario['strApellidos'];?></label>
                </div>
            </td>
            <td width="30%">
                <div align="left">
                   <label class="nombreCampo">
                      <?php echo $fechaForm;?>
                   </label>
                </div>
            </td>
        </tr>        
        
        <tr>
            <td height="15px"></td>
        </tr>
      </table>
        
      <P>
        <?php if(isset($_GET['IdContacto'])){?>
        <script languaje="JavaScript"> 
            function volver(){
                javascript:history.back();
            }
        </script>
        <input class="button" type="button" value="Volver" onclick="volver();" />
        <?php }?>
        <input type="Reset" class="button" value="<?php if(isset($_GET['lngId'])){echo 'Restaurar Original';}else{echo 'Vaciar Datos';} ?>" name="cmdReset"/>
        <input type="button" name="cmdAlta" class="button" value = "Alta Incidencia" onclick="javascript:validar2();" />
        <input type="hidden" name="opcion" value="enviar" />
      </P>
        
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