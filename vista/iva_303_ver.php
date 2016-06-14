<?php
session_start ();
require_once '../CN/clsCNContabilidad.php';
require_once '../CN/clsCNUsu.php';
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



//print_r($_SESSION);
$clsCNContabilidad=new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['mapeo']);
$clsCNUsu=new clsCNUsu();
$clsCNUsu->setStrBD($_SESSION['dbContabilidad']);


//codigo principal


logger('info','iva_303_ver.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
       " ||||Consultas->I.V.A.|| Liquidaciones Presentadas");

$datosUsuario=$clsCNUsu->DatosUsuario($_SESSION['usuario']);

$textos=$clsCNContabilidad->LeeArchivoIVA303($_GET['IdFichero']);

//los datos los incluiremos en un array
$datosPresentar=array(
    "01"=>$clsCNContabilidad->pasarNumeroFichero(substr($textos,71,17)),
    "02"=>$clsCNContabilidad->pasarNumeroFichero(substr($textos,88,5)),
    "03"=>$clsCNContabilidad->pasarNumeroFichero(substr($textos,93,17)),
    "04"=>$clsCNContabilidad->pasarNumeroFichero(substr($textos,110,17)),
    "05"=>$clsCNContabilidad->pasarNumeroFichero(substr($textos,127,5)),
    "06"=>$clsCNContabilidad->pasarNumeroFichero(substr($textos,132,17)),
    "07"=>$clsCNContabilidad->pasarNumeroFichero(substr($textos,149,17)),
    "08"=>$clsCNContabilidad->pasarNumeroFichero(substr($textos,166,5)),
    "09"=>$clsCNContabilidad->pasarNumeroFichero(substr($textos,171,17)),
    "27"=>$clsCNContabilidad->pasarNumeroFichero(substr($textos,339,17)),
    "28"=>$clsCNContabilidad->pasarNumeroFichero(substr($textos,356,17)),
    "29"=>$clsCNContabilidad->pasarNumeroFichero(substr($textos,373,17)),
    "46"=>$clsCNContabilidad->pasarNumeroFichero(substr($textos,628,17)),
    "67"=>$clsCNContabilidad->pasarNumeroFichero(substr($textos,667,17)),
    "71"=>$clsCNContabilidad->pasarNumeroFichero(substr($textos,786,17)),
    "Ejercicio"=>substr($textos,65,4),
    "Trimestre"=>substr($textos,69,2)
);

//print_r($datosPresentar);die;

html_pagina($datosPresentar,$datosUsuario);



function html_pagina($datosPresentar,$datosUsuario){
    
?>
<!DOCTYPE html>
<HTML>
<HEAD>
<?php
//estas funciones son generales
librerias_jQuery();
eventosInputText();
?>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../images/q.ico">
<TITLE>Autoliquidación. Impuesto sobre el Valor Añadido</TITLE>

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
$tituloForm='AUTOLIQUIDACIÓN<br/>IMPUESTO SOBRE EL VALOR AÑADIDO';
$cabeceraNumero='030102';
$paginaForm='';
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
    <form name="form1" method="post" action="../vista/iva_303.php">

      <table width="640" border="0" class="zonaactivaiva">
        <tr>
            <td width="10%"></td>
            <td width="20%"></td>
            <td width="2%"></td>
            <td width="5%"></td>
            <td width="5%"></td>
            <td width="20%"></td>
            <td width="2%"></td>
            <td width="5%"></td>
            <td width="31%"></td>
        </tr>
        
        <tr>
            <td></td>
            <td>
              <div align="right">
                <label class="nombreCampo">Ejercicio</label>
              </div>
            </td>
            <td></td>
            <td>
                <input class="textbox1" type="text" style="text-align:right;"
                       value="<?php echo $datosPresentar['Ejercicio'];?>" readonly />
            </td>
            <td></td>
            <td>
              <div align="right">
                <label class="nombreCampo">Periodo</label>
              </div>
            </td>
            <td></td>
            <td>
                <input class="textbox1" type="text" style="text-align:right;"
                       value="<?php echo $datosPresentar['Trimestre'];?>" readonly />
            </td>
            <td></td>
        </tr>
      </table>  

        
      <table width="640" border="0" class="zonaactivaiva">
        <tr> 
          <td class="subtitulo" colspan="11">&nbsp;IVA Devengado</td>
        </tr>
        <tr>
            <td width="30%"></td>
            <td width="15%"></td>
            <td width="5%"></td>
            <td width="10%"></td>
            <td width="5%"></td>
            <td width="15%"></td>
            <td width="20%"></td>
        </tr>
        
        <tr>
            <td></td>
            <td>
                <label>Base imponible</label>
            </td>
            <td></td>
            <td>
                <label>Tipo %</label>
            </td>
            <td></td>
            <td>
                <label>Cuota</label>
            </td>
            <td></td>
        </tr>
        
        <tr>
            <td>
                <label><div align="right">01</div></label>
            </td>
            <td>
                <input class="textbox1" type="text" style="text-align:right;"
                       value="<?php echo $datosPresentar['01'];?>" readonly />
            </td>
            <td>
                <label><div align="right">02</div></label>
            </td>
            <td>
                <input class="textbox1" type="text" style="text-align:right;"
                       value="<?php echo $datosPresentar['02'];?>" readonly />
            </td>
            <td>
                <label><div align="right">03</div></label>
            </td>
            <td>
                <input class="textbox1" type="text" style="text-align:right;"
                       value="<?php echo $datosPresentar['03'];?>" readonly />
            </td>
            <td></td>
        </tr>
        
        <tr>
            <td>
                <label><div align="right">04</div></label>
            </td>
            <td>
                <input class="textbox1" type="text" style="text-align:right;"
                       value="<?php echo $datosPresentar['04'];?>" readonly />
            </td>
            <td>
                <label><div align="right">05</div></label>
            </td>
            <td>
                <input class="textbox1" type="text" style="text-align:right;"
                       value="<?php echo $datosPresentar['05'];?>" readonly />
            </td>
            <td>
                <label><div align="right">06</div></label>
            </td>
            <td>
                <input class="textbox1" type="text" style="text-align:right;"
                       value="<?php echo $datosPresentar['06'];?>" readonly />
            </td>
            <td></td>
        </tr>
        
        <tr>
            <td>
                <label><div align="right">07</div></label>
            </td>
            <td>
                <input class="textbox1" type="text" style="text-align:right;"
                       value="<?php echo $datosPresentar['07'];?>" readonly />
            </td>
            <td>
                <label><div align="right">08</div></label>
            </td>
            <td>
                <input class="textbox1" type="text" style="text-align:right;"
                       value="<?php echo $datosPresentar['08'];?>" readonly />
            </td>
            <td>
                <label><div align="right">09</div></label>
            </td>
            <td>
                <input class="textbox1" type="text" style="text-align:right;"
                       value="<?php echo $datosPresentar['09'];?>" readonly />
            </td>
            <td></td>
        </tr>

        <tr>
            <td height="5px"></td>
        </tr>
        
        <tr>
            <td>
                <label class="nombreCampo"><div align="right">Total</div></label>
            </td>
            <td>
            </td>
            <td>
                <label><div align="right"></div></label>
            </td>
            <td>
            </td>
            <td>
                <label><div align="right">21</div></label>
            </td>
            <td>
                <input class="textbox1" type="text" style="text-align:right;"
                       value="<?php echo $datosPresentar['21'];?>" readonly />
            </td>
            <td></td>
        </tr>
        
        <tr>
            <td height="15px"></td>
        </tr>
      </table>
        
      <table width="640" border="0" class="zonaactivaiva">
        <tr> 
          <td class="subtitulo" colspan="11">&nbsp;IVA Deducible</td>
        </tr>
        <tr>
            <td width="30%"></td>
            <td width="15%"></td>
            <td width="5%"></td>
            <td width="10%"></td>
            <td width="5%"></td>
            <td width="15%"></td>
            <td width="20%"></td>
        </tr>
        
        <tr>
            <td></td>
            <td>
                <label>Base</label>
            </td>
            <td></td>
            <td>
            </td>
            <td></td>
            <td>
                <label>Cuota</label>
            </td>
            <td></td>
        </tr>
        <tr>
            <td height="5px"></td>
        </tr>
        
        <tr>
            <td>
                <label class="nombreCampo"><div align="right">Total &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 22</div></label>
            </td>
            <td>
                <input class="textbox1" type="text" style="text-align:right;"
                       value="<?php echo $datosPresentar['22'];?>" readonly />
            </td>
            <td>
                <label><div align="right"></div></label>
            </td>
            <td>
            </td>
            <td>
                <label><div align="right">23</div></label>
            </td>
            <td>
                <input class="textbox1" type="text" style="text-align:right;"
                       value="<?php echo $datosPresentar['23'];?>" readonly />
            </td>
            <td></td>
        </tr>
        
        <tr>
            <td height="15px"></td>
        </tr>
      </table>
        
      <table width="640" border="0" class="zonaactivaiva">
        <tr> 
          <td class="subtitulo" colspan="11">&nbsp;</td>
        </tr>
        <tr>
            <td width="20%"></td>
            <td width="40%"></td>
            <td width="5%"></td>
            <td width="15%"></td>
            <td width="20%"></td>
        </tr>

        <tr>
            <td></td>
            <td>
                <label class="nombreCampo"><div align="right">Diferencia</div></label>
            </td>
            <td><label><div align="right">38</div></label></td>
            <td>
                <input class="textbox1" type="text" style="text-align:right;"
                       value="<?php echo $datosPresentar['38'];?>" readonly />
            </td>
            <td></td>
        </tr>
        
        <tr>
            <td></td>
            <td>
                <label class="nombreCampo"><div align="right">Cuotas a compensar de periodos anteriores</div></label>
            </td>
            <td><label><div align="right">41</div></label></td>
            <td>
                <input class="textbox1" type="text" style="text-align:right;"
                       value="<?php echo $datosPresentar['41'];?>" readonly />
            </td>
            <td></td>
        </tr>
        
        <tr>
            <td></td>
            <td>
                <label class="nombreCampo"><div align="right">Resultado de la liquidación</div></label>
            </td>
            <td><label><div align="right">48</div></label></td>
            <td>
                <input class="textbox1" type="text" style="text-align:right;"
                       value="<?php echo $datosPresentar['48'];?>" readonly />
            </td>
            <td></td>
        </tr>
        
        <tr>
            <td height="15px"></td>
        </tr>
      </table>
        
        
      <table width="640" border="0" class="zonaactivaiva">
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
        
      <table width="640" border="0" class="zonaactivaiva">
          <tr>
              <td>
                  <div align="center">
                      <a href="../vista/consultar_iva.php"><input type="button" class="buttonAzul" value="Volver" /></a>
                  </div>
              </td>
          </tr>
          <tr>
              <td height="15px"></td>
          </tr>
      </table>
        
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

?>
