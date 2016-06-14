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
//comprobamos si se ha submitido el formulario y que el cliente existe
if(isset($_POST['cmdAlta']) && $_POST['cmdAlta']=='Aceptar'){
    if($_GET['tipo']=='cliente'){
        logger('info','consultacliprov.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
               " ||||Configuracion->Mis Clientes->Consulta/Modificacion|| Ha pulsado 'Modificar'");
    }else{
        logger('info','consultacliprov.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
               " ||||Configuracion->Mis Proveedores->Consulta/Modificacion|| Ha pulsado 'Modificar'");
    }
    //modifico los datos
    $varRes=$clsCNUsu->ModificarCli($_POST["IdRelacionCliProv"],$_POST["strNombre"], $_POST["strCIF"],
                                    $_POST["strActividad"], $_POST["lngCP"], $_POST["strDireccion"],
                                    $_POST["strMunicipio"], $_POST["strProvincia"], $_POST["strEmail"], $_POST["strEmail2"],
                                    $_POST["lngTelefono1"],$_POST["lngTelefono2"], $_POST["lngFax"],
                                    $_POST["lngCNAE"],$_POST["lngNumSS"],$_POST["strCCRecibos"]);
    
    if($varRes<>1){
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/error.php?id='.$varRes.'">';
    }else{
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/exito.php">';
    }
    
}else{//comienzo del else principal
    if($_GET['tipo']=='cliente'){
        logger('info','consultacliprov.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
               " ||||Configuracion->Mis Clientes->Consulta/Modificacion||");
    }else{
        logger('info','consultacliprov.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
               " ||||Configuracion->Mis Proveedores->Consulta/Modificacion||");
    }
    //cargar los datos del cliente/proveedor
    $datosCliProv=$clsCNUsu->DatosCliProv($_GET['IdRelacionCliProv']);
    
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
<TITLE><?php if($_GET['tipo']=='cliente'){echo 'Consulta Cliente';}else{echo 'Consulta Proveedor';}?></TITLE>

<script language="JavaScript">

function validar2()
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
  //comprobacion del campo 'strEmail'
  if (document.form1.strEmail.value === ''){ 
  }else{
    //compruebo que el e-mail tenga un formato correcto 'admin@admin.com'  
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(document.form1.strEmail.value) ){
        textoError=textoError+"El E-mail " + document.form1.strEmail.value + " es incorrecto.\n";
        document.form1.strEmail.style.borderColor='#FF0000';
        document.form1.strEmail.title ='El E-mail es incorrecto';
        esValido=false;
    }
  }
  //comprobacion del campo 'strDireccion'
  if (document.form1.strDireccion.value == ''){ 
    textoError=textoError+"Es necesario introducir la direccion.\n";
    document.form1.strDireccion.style.borderColor='#FF0000';
    document.form1.strDireccion.title ='Se debe introducir la direccion';
    esValido=false;
  }
  //comprobacion del campo 'strMunicipio'
  if (document.form1.strMunicipio.value == ''){ 
    textoError=textoError+"Es necesario introducir el nombre del municipio.\n";
    document.form1.strMunicipio.style.borderColor='#FF0000';
    document.form1.strMunicipio.title ='Se debe introducir el nombre de municipio';
    esValido=false;
  }
  //comprobacion del campo 'strProvincia'
  if (document.form1.strProvincia.value == ''){ 
    textoError=textoError+"Es necesario introducir la provincia.\n";
    document.form1.strProvincia.style.borderColor='#FF0000';
    document.form1.strProvincia.title ='Se debe introducir la provincia';
    esValido=false;
  }
  //comprobacion del campo 'lngCP'
  if (document.form1.lngCP.value == ''){ 
    textoError=textoError+"Es necesario introducir el código postal.\n";
    document.form1.lngCP.style.borderColor='#FF0000';
    document.form1.lngCP.title ='Se debe introducir el código postal';
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
function borrarCliProv(id){
    if (confirm("¿Desea borrar el registro del usuario de la base de datos?"))
    {
        window.location='../vista/cliprovBorrar.php?id='+id;
    }
}

function avisoCliProv(){
    alert('Esta cuenta tiene datos asociados en la Base de Datos. NO se puede borrar.');
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
</HEAD>

<?php $id=explode('-',$_GET['IdRelacionCliProv']); ?>
<BODY bgColor=#ffffff leftMargin=0 topMargin=0 rightMargin=0 bottomMargin=0 marginwidth="0" marginheight="0"  background="<?php echo FONDO; ?>"
      onLoad="rotulo_status();<?php if(isset($_GET['borrar'])&& $_GET['borrar']=='si'){
                                        if($datosCliProv['TieneAsientos']==='NO' && $datosCliProv['TienePresupuestos']==='NO' && $datosCliProv['TieneFacturas']==='NO'){
                                           echo 'borrarCliProv('. $id[1].');';
                                        }else{
                                           echo 'avisoCliProv();';
                                        }
                                       }?>">
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
if($_GET['tipo']=='cliente'){
    $cabeceraNumero='010202';
    $tituloForm='CONSULTA DE CLIENTES';
}else{
    $cabeceraNumero='010302';
    $tituloForm='CONSULTA DE PROVEEDORES';
}
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
    <form name="form1" method="post" action="../vista/consultacliprov.php" onSubmit="desactivaBoton();">
        
      <table width="640" border="0" class="zonaactiva">
        <tr> 
          <td class="subtitulo" colspan="7">&nbsp;Datos del <?php echo $_GET['tipo'];?></td>
        </tr>
        <tr>
            <td width="25%"></td>
            <td width="10%"></td>
            <td width="5%"></td>
            <td width="15%"></td>
            <td width="5%"></td>
            <td width="10%"></td>
            <td width="25%"></td>
        </tr>
        <tr> 
            <td colspan="3">
              <div align="left">
              <label class="nombreCampo">Nombre</label>
              <input class="textbox1" type="text" name="strNombre" id="strNombre" maxlength="50" value="<?php echo $datosCliProv['nombre'];?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
          </td>
          <td></td>
          <td colspan="3">
              <div align="left">
              <label class="nombreCampo">CIF</label>
              <?php
              $tipoCliente=explode('-',$_GET['IdRelacionCliProv']);
              ?>
              <input class="textbox1" type="text" name="strCIF" id="strCIF" maxlength="50" value="<?php echo $datosCliProv['CIF'];?>" <?php if($tipoCliente[0]==='CliProv'){echo 'readonly';} ?> />
              </div>
          </td>
        </tr>
        <tr> 
            <td colspan="3">
              <div align="left">
              <label class="nombreCampo">Actividad</label>
              <input class="textbox1" type="text" name="strActividad" id="strActividad" maxlength="50" value="<?php echo $datosCliProv['actividad'];?>" <?php if($tipoCliente[0]==='CuenCont'){echo 'readonly';} ?>
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
          <td></td>
          <td colspan="3"> 
              <div align="left">
              <label class="nombreCampo">CP</label>
              <input class="textbox1" type="text" name="lngCP" id="lngCP" maxlength="5" onkeypress="javascript:return solonumeros(event);" value="<?php echo $datosCliProv['CP'];?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
        </tr>
        <tr> 
            <td colspan="3">
              <div align="left">
              <label class="nombreCampo">Dirección</label>
              <input class="textbox1" type="text" name="strDireccion" id="strDireccion" maxlength="50" value="<?php echo $datosCliProv['direccion'];?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
          <td></td>
          <td colspan="3"> 
              <div align="left">
              <label class="nombreCampo">Municipio</label>
              <input class="textbox1" type="text" name="strMunicipio" id="strMunicipio" maxlength="50" value="<?php echo $datosCliProv['municipio'];?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
        </tr>
        <tr> 
            <td colspan="3">
              <div align="left">
              <label class="nombreCampo">Provincia</label>
              <input class="textbox1" type="text" name="strProvincia" id="strProvincia" maxlength="50" value="<?php echo $datosCliProv['provincia'];?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
          <td></td>
          <td colspan="3"> 
              <div align="left">
              <label class="nombreCampo">E-mail</label>
              <input class="textbox1" type="text" name="strEmail" id="strEmail" maxlength="50" value="<?php echo $datosCliProv['Correo'];?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
        </tr>
        <tr> 
            <td colspan="3">
              <div align="left">
              </div>
          </td>
          <td></td>
          <td colspan="3"> 
              <div align="left">
              <label class="nombreCampo">E-mail 2</label>
              <input class="textbox1" type="text" name="strEmail2" id="strEmail2" maxlength="50" value="<?php echo $datosCliProv['Correo2'];?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
        </tr>
        <tr> 
            <td colspan="3">
              <div align="left">
              <label class="nombreCampo">Telefono 1</label>
              <input class="textbox1" type="text" name="lngTelefono1" id="lngTelefono1" maxlength="11" onkeypress="javascript:return solonumeros(event);" value="<?php echo $datosCliProv['Telefono1'];?>" 
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
          <td></td>
          <td colspan="3"> 
              <div align="left"> 
              <label class="nombreCampo">Telefono 2</label>
              <input class="textbox1" type="text" name="lngTelefono2" id="lngTelefono2" maxlength="11" onkeypress="javascript:return solonumeros(event);" value="<?php echo $datosCliProv['Telefono2'];?>" <?php if($tipoCliente[0]==='CuenCont'){echo 'readonly';} ?>
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
        </tr>
        <tr> 
          <td colspan="3">
              <div align="left">
              <label class="nombreCampo">Fax</label>
              <input class="textbox1" type="text" name="lngFax" id="lngFax" maxlength="11" style="width: 97%" onkeypress="javascript:return solonumeros(event);" value="<?php echo $datosCliProv['Fax'];?>" <?php if($tipoCliente[0]==='CuenCont'){echo 'readonly';} ?>
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
          <td></td>
          <td colspan="3"> 
              <div align="left">
              <label class="nombreCampo">CC. Recibos</label>
              <input class="textbox1" type="text" name="strCCRecibos" id="strCCRecibos" maxlength="30" style="width: 97%" onkeypress="" value="<?php echo $datosCliProv['strCCRecibos'];?>" <?php if($tipoCliente[0]==='CuenCont'){echo 'readonly';} ?>
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
        </tr>
        
        
        <tr> 
          <td> 
          </td>
          <td></td>
          <td colspan="3">
          </td>
          <td></td>
          <td>
          </td>
        </tr>
<!--        <tr> 
          <td>
              <div align="left">
              <label class="nombreCampo">CNAE</label>
              <input class="textbox1" type="text" name="lngCNAE" id="lngCNAE" maxlength="11" onkeypress="javascript:return solonumeros(event);" value="<?php //echo $datosCliProv['CNAE'];?>" <?php //if($tipoCliente[0]==='CuenCont'){echo 'readonly';} ?>
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
          <td></td>
          <td colspan="3"> 
              <div align="left">
              <label class="nombreCampo">Num SS</label>
              <input class="textbox1" type="text" name="lngNumSS" id="lngNumSS" maxlength="11" onkeypress="javascript:return solonumeros(event);" value="<?php //echo $datosCliProv['NumSS'];?>" <?php //if($tipoCliente[0]==='CuenCont'){echo 'readonly';} ?>
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
        </tr>-->
        <tr>
            <td height="15px"></td>
        </tr>
      </table>
        
      <P>
        <input type="button" class="button" name="cmdAlta" id="cmdAlta" value = "Grabar" onclick="javascript:validar2();" /> 
        <input class="buttonAzul" type="button" value="Volver" onclick="javascript:history.back();" />
        <?php if($datosCliProv['TieneAsientos']==='NO' && $datosCliProv['TienePresupuestos']==='NO' && $datosCliProv['TieneFacturas']==='NO'){?>
        <input type="button" class="buttonAzul"  value="Eliminar" name="cmdBorrar" onclick="javascript:borrarCliProv(<?php echo $id[1]; ?>);" />
        <?php }else{?>
        <input type="button" class="buttonAzul"  value="Eliminar" name="cmdBorrar" onclick="javascript:avisoCliProv();" />
        <?php }?>
        <input type="Reset" class="button" value="Datos Iniciales" name="cmdReset"/>
        <input type="hidden"  name="cmdAlta" value="Aceptar" />
        <input name="tipo" type="hidden" value="<?php echo $_GET['tipo'];?>"/>
        <input name="IdRelacionCliProv" type="hidden" value="<?php echo $_GET['IdRelacionCliProv'];?>"/>
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