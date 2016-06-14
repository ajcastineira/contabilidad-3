<?php
session_start ();
require_once '../CN/clsCNContabilidad.php';
require_once '../CN/clsCNUsu.php';
require_once '../general/funcionesGenerales.php';

$clsCNContabilidad=new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['mapeo']);
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
logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
       " ||||Consultas->Pagos a Cuenta|| Presentados");

$datosUsuario=$clsCNUsu->DatosUsuario($_SESSION['usuario']);

$textos=$clsCNContabilidad->LeeArchivoAutonomo130($_GET['IdFichero']);
//print_r($textos);die;
//los datos los incluiremos en un array
$datosPresentar=array(
    "01"=>$clsCNContabilidad->pasarNumeroFichero(substr($textos,77,13)),
    "02"=>$clsCNContabilidad->pasarNumeroFichero(substr($textos,90,13)),
    "03"=>$clsCNContabilidad->pasarNumeroFichero(substr($textos,103,13)),
    "04"=>$clsCNContabilidad->pasarNumeroFichero(substr($textos,116,13)),
    "05"=>$clsCNContabilidad->pasarNumeroFichero(substr($textos,129,13)),
    "06"=>$clsCNContabilidad->pasarNumeroFichero(substr($textos,142,13)),
    "19"=>$clsCNContabilidad->pasarNumeroFichero(substr($textos,311,13)),
    "Ejercicio"=>substr($textos,71,4),
    "Trimestre"=>substr($textos,75,2)
);

//print_r($datosPresentar);die;

html_pagina($datosPresentar['Ejercicio'],$datosPresentar['Trimestre'],$datosPresentar,$datosUsuario);

function html_pagina($lngEjercicio,$Periodo,$datosPresentar,$datosUsuario){
    
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
<TITLE>Autoliquidación. Pagos a Cuenta</TITLE>

<script language="JavaScript">

//formateo de numeros
function formateaCantidad(objeto){
    objeto.value=formateaNumeroContabilidad(objeto.value);
}    

function activaCampoCBanco(objeto){
    if(objeto.checked===true){
        document.form1.SeDomicilia.value='SI';
        document.form1.cuentaBanco_Entidad.disabled=false;
        document.form1.cuentaBanco_Oficina.disabled=false;
        document.form1.cuentaBanco_DC.disabled=false;
        document.form1.cuentaBanco_NCuenta.disabled=false;
    }else{
        document.form1.SeDomicilia.value='NO';
        document.form1.cuentaBanco_Entidad.disabled=true;
        document.form1.cuentaBanco_Oficina.disabled=true;
        document.form1.cuentaBanco_DC.disabled=true;
        document.form1.cuentaBanco_NCuenta.disabled=true;
    }
}

function Actividad(objeto){
    if(objeto.checked===true){
        document.form1.SinActividad.value='SI';
    }else{
        document.form1.SinActividad.value='NO';
    }
}

function Transmitir(objeto){
    if(objeto.checked===true){
        if (confirm("¿Quieres preparar los ficheros para transmitir a la Agencia Tributaria?\nSe enviará a su correo el fichero generado para poder presentarlo.\n Este fichero deberá tenerlo en una carpeta AEAT para poder hacer la transmisión"))
        {
            document.form1.TransmitoImp.value='SI';
        }else{
            document.form1.TransmitoImp.value='NO';
            document.form1.chkTransmitir.checked=false;
        }
    }else{
    }   
}

function submitir(objeto){
    if (confirm("¿Desea cerrar este periodo?"))
    {
        objeto.submit();
    }
}

function entradaCantidad(objeto){
    objeto.value='';
}

function volver(){
    window.location='../vista/consultar_autonomo130.php';
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
$tituloForm='AUTOLIQUIDACIÓN<br/>PAGOS A CUENTA';
$cabeceraNumero='0303a02';
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
    <form name="form1" method="post" action="../vista/presentar_autonomo130.php">

      <table width="640" border="0" class="zonaactiva">
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
                       value="<?php echo $lngEjercicio;?>" readonly />
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
                       value="<?php echo $Periodo;?>" readonly />
            </td>
            <td></td>
        </tr>
      </table>  

      <table width="640" border="0" class="zonaactiva">
        <tr>
            <td height="15px"></td>
        </tr>
        <tr> 
          <td class="subtitulo" colspan="11">&nbsp;I. Actividades económicas</td>
        </tr>
        <tr>
            <td width="15%"></td>
            <td width="20%"></td>
            <td width="5%"></td>
            <td width="20%"></td>
            <td width="5%"></td>
            <td width="20%"></td>
            <td width="15%"></td>
        </tr>
        
        <tr>
            <td></td>
            <td>
                <label>Ingresos</label>
            </td>
            <td></td>
            <td>
                <label>Gastos</label>
            </td>
            <td></td>
            <td>
                <label>Rendimiento Neto</label>
            </td>
            <td></td>
        </tr>
        
        <tr>
            <td>
                <label><div align="right">01</div></label>
            </td>
            <td>    
                <input class="textbox1" type="text" style="text-align:right;"
                       name="casilla01" value="<?php echo $datosPresentar['01'];?>" readonly />
            </td>
            <td>
                <label><div align="right">02</div></label>
            </td>
            <td>    
                <input class="textbox1" type="text" style="text-align:right;"
                       name="casilla02" value="<?php echo $datosPresentar['02'];?>" readonly />
            </td>
            <td>
                <label><div align="right">03</div></label>
            </td>
            <td>
                <input class="textbox1" type="text" style="text-align:right;"
                       name="casilla03" value="<?php echo $datosPresentar['03'];?>" readonly />
            </td>
            <td>
                <label><div align="right"></div></label>
            </td>
            <td>
            </td>
            <td></td>
        </tr>

        <tr>
            <td></td>
            <td>
                <label>Cuota</label>
            </td>
            <td></td>
            <td>
                <label>Cuotas Anteriores</label>
            </td>
            <td></td>
            <td>
<!--                <label>Liquidación</label>-->
            </td>
            <td></td>
        </tr>
        
        <tr>
            <td>
                <label><div align="right">04</div></label>
            </td>
            <td>    
                <input class="textbox1" type="text" style="text-align:right;"
                       name="casilla04" value="<?php echo $datosPresentar['04'];?>" readonly />
            </td>
            <td>
                <label><div align="right">05</div></label>
            </td>
            <td>    
                <input class="textbox1" type="text" style="text-align:right;"
                       name="casilla05" value="<?php echo $datosPresentar['05'];?>" readonly />
            </td>
            <td>
<!--                <label><div align="right">06</div></label>-->
            </td>
            <td>
<!--                <input class="textbox1" type="text" style="text-align:right;font-weight:bold;"
                       name="casilla06" value="<?php //echo $datosPresentar['Liquidacion']; ?>" readonly />-->
                <input type="hidden" name="casilla06" value="<?php echo $datosPresentar['06']; ?>" />
            </td>
            <td>
                <label><div align="right"></div></label>
            </td>
            <td>
            </td>
            <td></td>
        </tr>

        <tr>
            <td height="15px"></td>
        </tr>
      </table>
        
      <table width="640" border="0" class="zonaactiva">
        <tr>
            <td height="15px"></td>
        </tr>
        <tr> 
          <td class="subtitulo" colspan="11">&nbsp;Total Liquidación</td>
        </tr>
        <tr>
            <td width="30%"></td>
            <td width="15%"></td>
            <td width="5%"></td>
            <td width="10%"></td>
            <td width="5%"></td>
            <td width="20%"></td>
            <td width="15%"></td>
        </tr>
        
        <tr>
            <td></td>
            <td>
            </td>
            <td></td>
            <td>
            </td>
            <td></td>
            <td>
                <label>Resultado de la declaración</label>
            </td>
            <td></td>
        </tr>
        
        <tr>
            <td>
                <label><div align="right"></div></label>
            </td>
            <td>    
            </td>
            <td>
                <label><div align="right"></div></label>
            </td>
            <td>    
            </td>
            <td>
                <label><div align="right">19</div></label>
            </td>
            <td>
                <input class="textbox1" type="text" style="text-align:right;" readonly
                       name="casilla19" value="<?php echo $datosPresentar['19']; ?>" />
            </td>
            <td>
                <label><div align="right"></div></label>
            </td>
            <td>
            </td>
            <td></td>
        </tr>

        <tr>
            <td height="15px"></td>
        </tr>
      </table>
        
        
      <table width="640" border="0" class="zonaactiva">
        <tr> 
          <td class="subtitulo">&nbsp;Firma</td>
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
        
      <table width="640" border="0" class="zonaactiva">
          <tr>
              <td>
                  <div align="center">
<!--                      <a href="../vista/consultar_autonomo130.php">-->
                          <input type="button" class="buttonAzul" value="Volver" onClick="volver();"/>
<!--                      </a>-->
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