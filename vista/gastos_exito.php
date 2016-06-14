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




//paso los datos y los guardo
//$datosFormulario=stripslashes ($_GET['datos']);
//$datosFormulario=unserialize($datosFormulario);

//veo si he pulsado algun boton
//print_r($datosFormulario);
//print_r($_GET);

//aqui dirijo a la presentacion en PC o Movil (APP)
if($_SESSION['navegacion']==='movil'){
    html_paginaMovil();
}else{
    html_pagina();
}

function html_pagina(){
?>

<HTML>
<HEAD>
<TITLE>CALIDAD -OPERACI&Oacute;N REALIZADA CON &Eacute;XITO</TITLE>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../images/q.ico">
<link href="../css/Estilos_Qualidad.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../css/calidad2.css" type="text/css">
<script language="JavaScript">
function inicio(){
    window.location='../vista/default2.php';
}
//function volver(){
//    op='<?php //echo $_GET['op'];?>';
//    if(op==='SF'){
//        window.location='../vista/gastos_SF.php?datos=<?php //echo $_GET['datos'];?>&esAbono=<?php //echo $_GET['esAbono'];?>';
//    }else if(op==='CFIVA1SIRPF'){
//        window.location='../vista/gastos_CFIVA1SIRPF.php?datos=<?php //echo $_GET['datos'];?>&esAbono=<?php //echo $_GET['esAbono'];?>';
//    }else if(op==='CFIVA1CIRPF'){
//        window.location='../vista/gastos_CFIVA1CIRPF.php?datos=<?php //echo $_GET['datos'];?>&esAbono=<?php //echo $_GET['esAbono'];?>';
//    }else if(op==='CFIVAV'){
//        window.location='../vista/gastos_CFIVAV.php?datos=<?php //echo $_GET['datos'];?>&esAbono=<?php //echo $_GET['esAbono'];?>';
//    }    
//}

function nuevoAsiento(){
    op='<?php echo $_GET['op'];?>';
    if(op==='SF'){
        window.location='../vista/gastos_SF.php?esAbono=NO&tipo=<?php echo $_GET['tipo'];?>';
    }else if(op==='CFIVA1SIRPF'){
        window.location='../vista/gastos_CFIVA1SIRPF.php?esAbono=NO&tipo=<?php echo $_GET['tipo'];?>';
    }else if(op==='CFIVA1CIRPF'){
        window.location='../vista/gastos_CFIVA1CIRPF.php?esAbono=NO&tipo=<?php echo $_GET['tipo'];?>';
    }else if(op==='CFIVAV'){
        window.location='../vista/gastos_CFIVAV.php?esAbono=NO&tipo=<?php echo $_GET['tipo'];?>';
    }else if(op==='CFIVAVCIRPF'){
        window.location='../vista/gastos_CFIVAVCIRPF.php?esAbono=NO&tipo=<?php echo $_GET['tipo'];?>';
    }else if(op==='2'){
        window.location='../vista/ingresos_gastos.php';
    }else if(op==='3'){
        window.location='../vista/gastos_nomina.php';
    }    
}



</script>
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

// -->
</script>
<SCRIPT language="JavaScript" SRC="/include/frames.js">
</SCRIPT>

</HEAD>
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

<form name="form1" method="post" action="../vista/gastos_exito.php">
<table width="780" border="0">
  <tr>
      <td colspan="3" height="90" width="780" background="../images/cabecera.jpg"></td>
  </tr>
  <tr>
    <td colspan="3" bgcolor="#FFFFFF" align ="center" valign="top">
	  <br><br>	
	   <h3 align="center">OPERACI&Oacute;N REALIZADA CON &Eacute;XITO</h3>
		<hr class="txtgeneral">
	</td>	
 </tr>
 <tr> 	 		
    <td colspan="3" height="20" align = center valign="top">
    <br><br>			
		<p><strong>La informaci&oacute;n enviada ha sido recibida en la Base de Datos 
					del Sistema de Gesti&oacute;n de Calidad</strong></p>
   
<?php
if(isset($_GET['Id'])){echo trim($_GET['Id']);}

?>	    
    </td>
  </tr>
  <tr height="40">
      <td width="40%">
          <div align="right">
              <input class="button" type="button" name="eleccion" value="Inicio" onclick="inicio();" />
          </div>
      </td>
      <td width="20%">
          <div align="center">
              <input class="buttonDesactivado" type="button" name="eleccion" value="Volver" onclick="volver();" disabled />
          </div>
      </td>
      <td width="40%">
          <div align="lef">
              <input class="button" type="button" name="eleccion" value="Nuevo Asiento" onclick="nuevoAsiento();"/>
          </div>
      </td>
  </tr>
  <tr>        
     <td colspan="3" align = center>
       <br><br>	
          <div align="center"><IMG height=67 alt="Ir al menú" src="../images/<?php echo $_SESSION["logo"]; ?>" width=132 border="0"></div></td> 
      </td> 
  </tr>

</table>
</form>
   
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
}


function html_paginaMovil(){
?>
<!DOCTYPE html>
<html>
<head>
<TITLE>CALIDAD -OPERACI&Oacute;N REALIZADA CON &Eacute;XITO</TITLE>

<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>

        
</head>
<body>
           
<div data-role="page" id="exito">
<?php
eventosInputText();
?>
<script language="JavaScript">
function inicio(){
    window.location='../movil/default2.php';
}

function nuevoAsiento(){
    op='<?php echo $_GET['op'];?>';
    if(op==='SF'){
        window.location='../vista/gastos_SF.php?esAbono=NO&tipo=<?php echo $_GET['tipo'];?>';
    }else if(op==='CFIVA1SIRPF'){
        window.location='../vista/gastos_CFIVA1SIRPF.php?esAbono=NO&tipo=<?php echo $_GET['tipo'];?>';
    }else if(op==='CFIVA1CIRPF'){
        window.location='../vista/gastos_CFIVA1CIRPF.php?esAbono=NO&tipo=<?php echo $_GET['tipo'];?>';
    }else if(op==='CFIVAV'){
        window.location='../vista/gastos_CFIVAV.php?esAbono=NO&tipo=<?php echo $_GET['tipo'];?>';
    }else if(op==='CFIVAVCIRPF'){
        window.location='../vista/gastos_CFIVAVCIRPF.php?esAbono=NO&tipo=<?php echo $_GET['tipo'];?>';
    }else if(op==='2'){
        window.location='../vista/ingresos_gastos.php';
    }else if(op==='3'){
        window.location='../vista/gastos_nomina.php';
    }    
}
</script>
    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>

    <div data-role="content" data-theme="a">
        <p><strong>La informaci&oacute;n se a actualizado correctamente en su Base de Datos</strong>
        </p>
<?php
if(isset($_GET['Id'])){echo trim($_GET['Id']);}
?>
        <table border="0" style="width: 100%;">
            <tbody>
                <tr>
                    <td style="width: 50%;"></td>
                    <td style="width: 50%;"></td>
                </tr>
                <tr>
                    <td>
                        <input type="button" data-theme="a" name="eleccion" value="Inicio" onclick="inicio();" />
                    </td>
                    <td>
                        <input type="button" data-theme="a" name="eleccion" value="Nuevo Asiento" onclick="nuevoAsiento();"/>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <div align="center">
            <IMG height=70 alt="Ir al menú" src="../images/<?php echo $_SESSION["logo"]; ?>" width=140 border="0">
        </div>
    </div>
</div>
</body>
</html>
<?php
}
?>
  
   