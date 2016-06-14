<?php
session_start ();
require_once '../CN/clsCNUsu.php';
require_once '../general/funcionesGenerales.php';

$clsCNUsu=new clsCNUsu();
$clsCNUsu->setStrBD($_SESSION['dbContabilidad']);
$clsCNUsu->setStrBDCliente($_SESSION['mapeo']);

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
if(isset($_POST['existeCliProv']) && $_POST['existeCliProv']=='SI'){
    logger('info','altaCliprov.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
           " ||||Configuracion->Mis Clientes->Alta|| Ha pulsado 'Proceder al Alta'(Cliente Existente)");
    $num=$_POST['num2'];
    $numCuenta=$_POST['lngTipo'].formatearCodigo($_POST['lngCodigo']);
    $numEmpresa=$_SESSION["idEmp"];
    //0-cliente (4300) 1-Proveedor (4000). Existe otro mas de proveedor (4100)
    if($_GET['tipo']=='cliente'){
        $cliProv=0;
    }else{
        $cliProv=1;
    }
    
    $varRes=$clsCNUsu->AltaCliente($num,$_POST['strNombre'],$_POST['strCIF'],$_POST['strActividad'],$_POST['lngCP'],$_POST['strDireccion'],
                                   $_POST['strMunicipio'],$_POST['strProvincia'],$_POST['strEmail'],$_POST['strEmail2'],$_POST['lngTelefono1'],
                                   $_POST['lngTelefono2'],$_POST['lngFax'],formatearCodigo($_POST['lngCodigo']),$numCuenta,$numEmpresa,$cliProv,$_POST['strCCRecibos']);

    if($varRes<>1){
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/error.php?id='.$varRes.'">';
    }else{
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/cliprov_exito.php?tipo='.$_GET['tipo'].'">';
    }
    
}else if(isset($_POST['existeCliProv']) && $_POST['existeCliProv']=='NO'){
    if($_GET['tipo']=='cliente'){
        logger('info','altaClientes.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
               " ||||Configuracion->Mis Clientes->Alta|| Ha pulsado 'Proceder al Alta'(Cliente Nuevo)");
    }else{
        logger('info','altaClientes.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
               " ||||Configuracion->Mis Proveedores->Alta|| Ha pulsado 'Proceder al Alta'(Proveedor Nuevo)");
    }
    $num=$clsCNUsu->IdCliProv();
    $numCuenta=$_POST['lngTipo'].formatearCodigo($_POST['lngCodigo']);
    $numEmpresa=$_SESSION["idEmp"];
    //0-cliente 1-Proveedor
    if($_GET['tipo']==='cliente'){
        $cliProv=0;
    }else{
        $cliProv=1;
    }
    
    $varRes=$clsCNUsu->AltaClienteNuevo($num,$_POST['strNombre'],$_POST['strCIF'],$_POST['strActividad'],$_POST['lngCP'],$_POST['strDireccion'],
                                   $_POST['strMunicipio'],$_POST['strProvincia'],$_POST['strEmail'],$_POST['strEmail2'],$_POST['lngTelefono1'],
                                   $_POST['lngTelefono2'],$_POST['lngFax'],formatearCodigo($_POST['lngCodigo']),$numCuenta,$numEmpresa,$cliProv,$_POST['strCCRecibos']);

    if($varRes<>1){
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/error.php?id='.$varRes.'">';
    }else{
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/cliprov_exito.php?tipo='.$_GET['tipo'].'">';
    }
    
}else{//comienzo del else principal
    if($_GET['tipo']=='cliente'){
        logger('info','altaClientes.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
               " ||||Configuracion->Mis Clientes->Alta||");
    }else{
        logger('info','altaClientes.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
               " ||||Configuracion->Mis Proveedores->Alta||");
    }
    
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
<TITLE><?php if($_GET['tipo']=='cliente'){echo 'Cliente - ALTA';}else{echo 'Proveedor - ALTA';}?></TITLE>

<script language="JavaScript">

function validar2()
{
  esValido=true;
  textoError='';
  //comprobacion del campo 'strCIF'
  if (document.form1.strCIF.value == ''){ 
    textoError=textoError+"Es necesario introducir el CIF.\n";
    document.form1.strCIF.style.borderColor='#FF0000';
    document.form1.strCIF.title ='Se debe introducir el CIF';
    esValido=false;
  }
  //comprobacion del campo 'strNombre'
  if (document.form1.strNombre.value == ''){ 
    textoError=textoError+"Es necesario introducir el nombre.\n";
    document.form1.strNombre.style.borderColor='#FF0000';
    document.form1.strNombre.title ='Se debe introducir el nombre';
    esValido=false;
  }
//  //comprobacion del campo 'strActividad'
//  if (document.form1.strActividad.value == ''){ 
//    textoError=textoError+"Es necesario introducir la actividad.\n";
//    document.form1.strActividad.style.borderColor='#FF0000';
//    document.form1.strActividad.title ='Se deben introducir la actividad';
//    esValido=false;
//  }
  //comprobacion del campo 'strEmail'
  if (document.form1.strEmail.value === ''){ 
//    textoError=textoError+"Es necesario introducir un E-mail.\n";
//    document.form1.strEmail.style.borderColor='#FF0000';
//    document.form1.strEmail.title ='Se debe introducir un E-mail';
//    esValido=false;
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
  //comprobacion del campo 'lngCodigo'
  if (document.form1.lngCodigo.value == ''){ 
    textoError=textoError+"Es necesario introducir un codigo de la cuenta.\n";
    document.form1.lngCodigo.style.borderColor='#FF0000';
    document.form1.lngCodigo.title ='Se debe introducir un codigo de la cuenta';
    esValido=false;
  }
  //comprobacion qeu no exista cuenta en la BBDD (en el txt_cuenta)
  texto=document.getElementById("txt_cuenta").innerHTML;
  if (texto.indexOf('error') != -1){
    textoError=textoError+"El numero de cuenta ya existe.\n";
    document.form1.lngCodigo.style.borderColor='#FF0000';
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

//AJAX jQuery verifica si existe el cliente
function verificar_CIF(str,tipo){
    document.getElementById('txt_validar').innerHTML='';
    $.ajax({
      data:{"q":str.value,"tipo":tipo},  
      url: '../vista/ajax/verificarCIF.php',
      type:"get",
      success: function(data) {
        var cliente = JSON.parse(data);
        $('#strNombre').val(cliente.Nombre);
        $('#strActividad').val(cliente.Actividad);
        $('#strDireccion').val(cliente.direccion);
        $('#strMunicipio').val(cliente.municipio);
        $('#strProvincia').val(cliente.provincia);
        $('#strEmail').val(cliente.Correo);
        $('#lngTelefono1').val(cliente.Telefono1);
        $('#lngTelefono2').val(cliente.Telefono2);
        $('#lngFax').val(cliente.Fax);
        $('#lngCP').val(cliente.CP);
        $('#strCCRecibos').val(cliente.strCCRecibos);
        //indicar si el cliente no existe
        if(cliente.IdCliProv != null){
            //el cliente existe
            document.form1.existeCliProv.value='SI';
            document.form1.num2.value=cliente.IdCliProv;
        }else{
            if(document.form1.strCIF.value==''){
                document.getElementById('txt_validar').innerHTML='El campo está vacio.';
                //document.form1.strCIF.focus();
            }else{
                //el cliente NO existe
                document.form1.existeCliProv.value='NO';
                document.getElementById('txt_validar').innerHTML=document.getElementById('txt_validar').innerHTML+'No existe cliente correspodientes a ese NIF/CIF.Debe darlo de alta rellenando todos los campos\n';
            }
        }
        if(cliente.ExisteCuenta==='SI'){
            alert('Este cliente/proveedor existe. No se puede dar de alta');
            document.getElementById("cmdAlta").disabled = true;
        }else{
            document.getElementById("cmdAlta").disabled = false;
        }
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
if($_GET['tipo']=='cliente'){
    $cabeceraNumero='010201';
    $tituloForm='ALTA DE CLIENTES';
}else{
    $cabeceraNumero='010301';
    $tituloForm='ALTA DE PROVEEDORES';
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
    <form name="form1" method="post" action="../vista/altacliprov.php?tipo=<?php echo $_GET['tipo'];?>" onSubmit="desactivaBoton();">
	
      <table width="640" border="0" class="zonaactiva">
        <tr> 
          <td class="subtitulo" colspan="10">&nbsp;Validación de CIF/NIF</td>
        </tr>
        <tr>
            <td width="20%"></td>
            <td width="40%"></td>
            <td width="30%"></td>
            <td width="10%"></td>
        </tr>
        <tr>
            <td></td>
            <td>
              <div align="left">
              <label class="nombreCampo">CIF</label>
              <input class="textbox1" type="text" name="strCIF" maxlength="50"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);"
                     onblur="onBlurInputText(this);verificar_CIF(this,<?php if($_GET['tipo']=='cliente'){echo '4300';}else{echo '4000';}?>);validarNIFCIF(this);"/>
              </div>
          </td>
          <td rowspan="2"><span class="validar" id="txt_validar"></span></td>
        </tr>
        <tr>
            <td height="15px"><span class="validar" id="txt_usuario"></span></td>
        </tr>
      </table>

        
      <table width="640" border="0" class="zonaactiva">
        <tr> 
          <td class="subtitulo" colspan="9">&nbsp;Datos del <?php echo $_GET['tipo'];?></td>
        </tr>
        <tr>
            <td width="7%"></td>
            <td width="15%"></td>
            <td width="8%"></td>
            <td width="15%"></td>
            <td width="8%"></td>
            <td width="15%"></td>
            <td width="8%"></td>
            <td width="15%"></td>
            <td width="8%"></td>
<!--            <td width="15%"></td>-->
        </tr>
        <tr> 
          <td></td>
          <td colspan="3">
              <div align="left">
              <label class="nombreCampo">Nombre</label>
              <input class="textbox1" type="text" name="strNombre" id="strNombre" maxlength="50"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
          </td>
          <td></td>
          <td colspan="3">
              <div align="left">
              <label class="nombreCampo">Actividad</label>
              <input class="textbox1" type="text" name="strActividad" id="strActividad" maxlength="50"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
          <td colspan="1"></td>
        </tr>
        <tr> 
          <td></td>
          <td colspan="3">
              <div align="left">
              <label class="nombreCampo">Dirección</label>
              <input class="textbox1" type="text" name="strDireccion" id="strDireccion" maxlength="50"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
          <td></td>
          <td colspan="3"> 
              <div align="left">
              <label class="nombreCampo">Municipio</label>
              <input class="textbox1" type="text" name="strMunicipio" id="strMunicipio" maxlength="50"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
          <td colspan="1"></td>
        </tr>
        <tr> 
          <td></td>
          <td colspan="3">
              <div align="left">
              <label class="nombreCampo">Provincia</label>
              <input class="textbox1" type="text" name="strProvincia" id="strProvincia" maxlength="50"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
          <td></td>
          <td colspan="3"> 
              <div align="left">
              <label class="nombreCampo">E-mail</label>
              <input class="textbox1" type="text" name="strEmail" id="strEmail" maxlength="50"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
          <td colspan="1"></td>
        </tr>
        <tr> 
          <td></td>
          <td colspan="3">
              <div align="left">
              </div>
          </td>
          <td></td>
          <td colspan="3"> 
              <div align="left">
              <label class="nombreCampo">E-mail 2</label>
              <input class="textbox1" type="text" name="strEmail2" id="strEmail2" maxlength="50"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
          <td colspan="1"></td>
        </tr>
        <tr> 
          <td></td>
          <td> 
              <div align="left">
              <label class="nombreCampo">Telefono 1</label>
              <input class="textbox1" type="text" name="lngTelefono1" id="lngTelefono1" maxlength="11" onkeypress="javascript:return solonumeros(event);" 
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
          <td></td>
          <td colspan="">
              <div align="left"> 
              <label class="nombreCampo">Telefono 2</label>
              <input class="textbox1" type="text" name="lngTelefono2" id="lngTelefono2" maxlength="11" onkeypress="javascript:return solonumeros(event);"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
          <td></td>
          <td>
              <div align="left">
              <label class="nombreCampo">Fax</label>
              <input class="textbox1" type="text" name="lngFax" id="lngFax" maxlength="11" style="width: 97%" onkeypress="javascript:return solonumeros(event);"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
          <td></td>
          <td>
              <div align="left">
              <label class="nombreCampo">C.P.</label>
              <input class="textbox1" type="text" name="lngCP" id="lngCP" maxlength="5" style="width: 97%" onkeypress="javascript:return solonumeros(event);"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
        </tr>
        <tr> 
          <td></td>
          <td colspan="3">
              <div align="left">
              <label class="nombreCampo">CC. Recibos</label>
              <input class="textbox1" type="text" name="strCCRecibos" id="strCCRecibos" maxlength="30"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
          <td></td>
          <td colspan="3"> 
              <div align="left">
              </div>
          </td>
          <td colspan="1"></td>
        </tr>
        <tr> 
          <td></td>
          <td colspan="2">
              <div align="left">
              <label class="nombreCampo">Nº Cuenta</label>
              <?php
                if($_GET['tipo']=='cliente'){
              ?>
              <input class="textbox1" type="text" name="lngTipo" id="lngTipo" maxlength="4"
                     value="4300" readonly />
              </div>
              <?php
                }else{
              ?>
              <select class="textbox1" name="lngTipo" id="lngTipo">
                  <option value="4000">4000 - Proveedores</option>
                  <option value="4100">4100 - Acreedores</option>
              </select>
              <?php
                }
              ?>
              
          </td>
          <td></td>
          <td colspan="2"> 
              <div align="left">
              <label class="nombreCampo"><font color="#F0F8FF">Codigo</font></label>
              <input class="textbox1" type="text" name="lngCodigo" id="lngCodigo" maxlength="5" onkeypress="javascript:return solonumeros(event);" onKeyUp="check_cuenta(this.value,document.form1.lngTipo.value);"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
          <td>
              <table border="0">
                  <tr>
                      <td height="5">&nbsp;</td>
                  </tr>
                  <tr>
                      <td height="20">
                         <span valign="top" id="txt_cuenta"><img src='../images/error.png' width='15' height='15' /></span>
                      </td>
                  </tr>
                  <tr>
                      <td></td>
                  </tr>
                  <tr>
                      <td></td>
                  </tr>
              </table>
          </td>
        </tr>
        <tr>
            <td height="15px"></td>
        </tr>
      </table>
        
      <P>
        <input type="Reset" class="buttonAzul" value="Vaciar Datos" name="cmdReset"/>
        <input type="button" class="button" name="cmdAlta" id="cmdAlta" value = "Proceder al Alta" onclick="javascript:validar2();" /> 
        <input type="hidden"  name="cmdAlta" value="Aceptar" />
        <input type="hidden"  name="existeCliProv" value="NO" />
        <input type="hidden"  name="num2" value="" />
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