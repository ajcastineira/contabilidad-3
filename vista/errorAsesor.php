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


?>
 
<HTML>
<HEAD>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../images/q.ico">
<link href="../css/Estilos_Qualidad.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../css/calidad2.css" type="text/css">
<TITLE>CALIDAD -OPERACI&Oacute;N NO SE REALIZ&Oacute;</TITLE>
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
<SCRIPT language="JavaScript" SRC="/include/frames.js"> 
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
 
<table width="780" border="0" >
  <tr>
    <td height="90" width="780" background="../images/cabecera.jpg">
	</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" align ="center" valign="top">
	  <br><br>
	   <h3 align="center"><font color="#FF0000">¡¡SE HA PRODUCIDO UN ERROR!!</font></h3>
		<hr  class="txtgeneral">
		<br><br>
		<p><strong><u><font size="+1">Disculpe las molestias</font></u></strong></p>
   
	    <p>
            <?php
            echo $_GET['id'];
            ?>
	   </p>
	   <br><br>
       <?php if(isset($_SESSION['logo'])){ ?>
          <div align="center"><a href="../vista/defaultAsesor.php"><IMG height=67 alt="Ir al menú" src="../images/<?php echo $_SESSION["logo"]; ?>" width=132 border="0"></a></div></td> 
       <?php }else{ ?>
          <div align="center"><a href="../vista/defaultAsesor.php"><IMG height=67 alt="Ir al menú" src="../images/logo-Qualidad.JPG" width=132 border="0"></a></div></td> 
       <?php } ?>
     </td> 
  </tr>
  <tr><td height="20%"></td></tr>
</table>
 
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
<>
 
 
  
