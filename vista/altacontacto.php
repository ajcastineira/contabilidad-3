<?php
session_start ();
require_once '../CN/clsCNContabilidad.php';
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

$clsCNContabilidad=new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['dbContabilidad']);



//codigo principal
//pulso el boton cmdAlta
if(isset($_POST['opcion'])){
    //comprobamos si se ha submitido el formulario $_POST[opcion]=editarContacto
    if($_POST['opcion'] === 'editarContacto'){
        logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " ||||Configuraciones->Mis Contactos->Editar|| Ha pulsado 'Actualizar'(Contacto Existente)");
        //print_r($_POST);die;
        $varRes=$clsCNContabilidad->EditarContacto($_SESSION['usuario'],$_POST['IdContacto'],$_POST['strNomEmpresa'],$_POST['strCIF'],$_POST['strDireccion'],$_POST['strMunicipio'],$_POST['lngCP'],
                                       $_POST['strProvincia'],$_POST['strNombre'],$_POST['strApellidos'],$_POST['strTelefono'],
                                       $_POST['strMovil'],$_POST['strEmail'],$_POST['strNotas'],$_POST['strFormaPago']);
    }
    //comprobamos si se ha submitido el formulario $_POST[opcion]=altaContacto
    else if($_POST['opcion'] === 'altaContacto')
    {
        logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " ||||Configuraciones->Mis Contactos->Alta|| Ha pulsado 'Proceder al Alta'(Contacto Nuevo)");
        
        $varRes=$clsCNContabilidad->AltaContacto($_SESSION['usuario'],$_POST['strNomEmpresa'],$_POST['strCIF'],$_POST['strDireccion'],$_POST['strMunicipio'],$_POST['lngCP'],
                                       $_POST['strProvincia'],$_POST['strNombre'],$_POST['strApellidos'],$_POST['strTelefono'],
                                       $_POST['strMovil'],$_POST['strEmail'],$_POST['strNotas'],$_POST['strFormaPago']);
    }
    //comprobamos si se ha submitido el formulario $_POST[opcion]=altaClienteDeContacto
    else if($_POST['opcion'] === 'altaClienteDeContacto')
    {
        logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " ||||Configuraciones->Mis Contactos->Alta|| Ha pulsado 'Proceder al Alta'(Cliente Nuevo de Contacto)");
        
        //primero actualizamos los datos en la tabla 'tbmiscontactos'
        $varRes=$clsCNContabilidad->EditarContacto($_SESSION['usuario'],$_POST['IdContacto'],$_POST['strNomEmpresa'],$_POST['strCIF'],$_POST['strDireccion'],$_POST['strMunicipio'],$_POST['lngCP'],
                                       $_POST['strProvincia'],$_POST['strNombre'],$_POST['strApellidos'],$_POST['strTelefono'],
                                       $_POST['strMovil'],$_POST['strEmail'],$_POST['strNotas'],$_POST['strFormaPago']);
        
        //y si a sido correcta, damos de alta en cliente
        if($varRes==true){
            $varRes=$clsCNContabilidad->AltaClienteDeContacto($_SESSION['usuario'],$_POST['IdContacto'],$_POST['strNomEmpresa'],$_POST['strCIF'],$_POST['strDireccion'],$_POST['strMunicipio'],$_POST['lngCP'],
                                       $_POST['strProvincia'],$_POST['strNombre'],$_POST['strApellidos'],$_POST['strTelefono'],
                                       $_POST['strMovil'],$_POST['strEmail'],$_POST['strNotas'],$_POST['strFormaPago'],$_POST['lngTipo'],$_POST['lngCodigo']);
            
            //si a sido correcto
            //actualizamos en la tabla 'tbmispresupuestos' el campo 'Contacto_Cliente'
            //si el contacto tiene el formato 'CO.14' se pasara al cliente 'CL.430000018'
            if($varRes==true){
                //se coje las variables 'lngTipo=4300 y lngCodigo=18 y se forma la cuenta y se le añade al principio CL.
                $numCuenta='CL.'.$_POST['lngTipo'].formatearCodigo($_POST['lngCodigo']);
                
                //contacto
                $contacto='CO.'.$_POST['IdContacto'];
                
                //y ahora actualizo los Contacto_Cliente de tbmispresupuestos
                $varRes=$clsCNContabilidad->Actualizar_tbmispresupuestos_Contacto_Cliente($contacto,$numCuenta);
            }
        }
    }
    
    //redireccionamos a exito o error, segun la variable $varRes
    if($varRes==false){
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/error.php?id='.$varRes.'">';
    }else{
        //veo si $_POST['url_inicial'] es de nuevo de presupuesto o del principal (default2)
        if($_POST['url_inicial']==='PresupuestoNuevo'){
            echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/altapresupuesto.php?IdContacto='.$varRes.'">';
        }else{
            echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/exito.php?opcion='.$_POST['url_inicial'].'">';
        }
    }
}
//comienzo del else principal
else{
    if(isset($_GET['IdContacto'])){
        logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
               " ||||Configuracion->Mis Contactos->Editar||");
        
        $datosContacto=$clsCNContabilidad->DatosContacto($_GET['IdContacto']);
        //print_r($datosContacto);die;
    }else{
        logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
               " ||||Configuracion->Mis Contactos->Alta||");
    }
    
?>
<!DOCTYPE html>
<HTML>
<HEAD>
<?php
//estas funciones son generales
librerias_jQuery();
eventosInputText();

//averiguamos si el contacto es igual al nombre de empresa(contactoNombre+contactoApellidos = nombreEmpresa
$nombreEmpresa=$datosContacto['NombreEmpresa'];
$contacto=$datosContacto['NombreContacto'].' '.$datosContacto['ApellidosContacto'];
        
$contactoSiEmpresa='No';
if($nombreEmpresa==$contacto){        
    $contactoSiEmpresa='Si';
}

?>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../images/q.ico">
<TITLE><?php if(isset($_GET['IdContacto'])){echo 'Contacto - EDITAR';}else{echo 'Contacto - ALTA';}?></TITLE>

<script language="JavaScript">

function validar2()
{
  esValido=true;
  textoError='';
  
  //comprobacion del campo 'strNombre'
  if (document.form1.strNombre.value == ''){ 
    textoError=textoError+"Es necesario introducir el nombre del contacto.\n";
    document.form1.strNombre.style.borderColor='#FF0000';
    document.form1.strNombre.title ='Se debe introducir el nombre del contacto';
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

function pasarACliente(){
    document.form1.opcion.value='altaClienteDeContacto';
    document.getElementById("cmdAlta").className='buttonDesactivado';
    document.getElementById("cmdAlta").disabled = true;
    $('#cuenta').show(1000);
}

function pasarAClienteContactoOK(){
  esValido=true;
  textoError='';

  //comprobacion del campo 'strNombreEmpresa'
  if (document.form1.strNomEmpresa.value == ''){ 
    textoError=textoError+"Es necesario introducir el nombre de la Empresa.\n";
    document.form1.strNomEmpresa.style.borderColor='#FF0000';
    document.form1.strNomEmpresa.title ='Se debe introducir el nombre de la Empresa';
    esValido=false;
  }
  //comprobacion del campo 'strCIF'
  if (document.form1.strCIF.value == ''){ 
    textoError=textoError+"Es necesario introducir el CIF.\n";
    document.form1.strCIF.style.borderColor='#FF0000';
    document.form1.strCIF.title ='Se debe introducir el CIF';
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

  //indicar el mensaje de error si es 'esValido' false
  if (!esValido){
          alert(textoError);
  }

  if(esValido==true){
//      document.form1.opcion.value='altaClienteDeContactoImportado';
      document.getElementById("cmdPasarClienteOK").value = "Enviando...";
      document.getElementById("cmdPasarClienteOK").disabled = true;
      document.form1.submit();
  }else{
      return false;
  }  
}

function pasarAClienteOK(){
  esValido=true;
  textoError='';
  
  //comprobacion del campo 'strNombreEmpresa'
  if (document.form1.strNomEmpresa.value == ''){ 
    textoError=textoError+"Es necesario introducir el nombre de la Empresa.\n";
    document.form1.strNomEmpresa.style.borderColor='#FF0000';
    document.form1.strNomEmpresa.title ='Se debe introducir el nombre de la Empresa';
    esValido=false;
  }
  //comprobacion del campo 'strCIF'
  if (document.form1.strCIF.value == ''){ 
    textoError=textoError+"Es necesario introducir el CIF.\n";
    document.form1.strCIF.style.borderColor='#FF0000';
    document.form1.strCIF.title ='Se debe introducir el CIF';
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
//      document.form1.opcion.value='altaClienteDeContacto';
      document.getElementById("cmdPasarClienteOK").value = "Enviando...";
      document.getElementById("cmdPasarClienteOK").disabled = true;
      document.form1.submit();
  }else{
      return false;
  }  
}

//borrar contacto/cliente cde tbmiscontactos
function borrarContacto(id){
    if (confirm("¿Desea borrar el registro del contacto de la base de datos?"))
    {
        window.location='../vista/contactoBorrar.php?id='+id;
    }
}

function avisoContacto(){
    alert('Este contacto no se puede borrar. Tiene datos asociados en la Base de Datos');
}

//limpia el texto de verificacion de NIF/CIF
function limpiarTxtValidar(){
    document.getElementById('txt_validar').innerHTML='';
}

//si el select tiene elvalor de 'Si' rellenamos el campo 'strNomEmpresa' con los datos 
//de 'strNombre' + 'strApellidos'
function comprobarContactoSiEmpresa(){
    if(document.form1.contactoSiEmpresa.value==='Si'){
        document.form1.strNomEmpresa.value=document.form1.strNombre.value + ' ' + document.form1.strApellidos.value;
    }
}

function leer(){
    //extraig la url de la que venimos
    var url=document.referrer;
    //parto este texto por el simbolo '/'
    var partes=url.split("/");
    //guardo el ultimo valor (esla pagina mas si tiene parametros)
    var ultimo=partes[partes.length-1];
    var response='';
    if(ultimo.indexOf('?') != -1){
        //dividimos el texto por ste simbolo ?
        var partesUltimo=ultimo.split("?");
        if(partesUltimo[0]==='altapresupuesto.php'){
            response='PresupuestoEditado?'+partesUltimo[1];
        }else if(partesUltimo[0]==='default2.php'){
            response='Principal';
        }
    }else{
        if(ultimo==='altapresupuesto.php'){
            response='PresupuestoNuevo';
        }else if(ultimo==='default2.php'){
            response='Principal';
        }
    }

    //ahora vemos que fichero es y le asignamos un valor a 'document.form1.url_inicial.value'
    document.form1.url_inicial.value=response;
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
      onLoad="leer();rotulo_status();<?php if(isset($_GET['borrar'])&& $_GET['borrar']=='si'){
                                            if($datosContacto['TienePresupuestos']==='NO'){
                                               echo 'borrarContacto('. $_GET['IdContacto'].');';
                                            }else{
                                               echo 'avisoContacto();';
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
if(isset($_GET['IdContacto'])){
    $cabeceraNumero='010502';
    $tituloForm='EDITAR CONTACTO';
}else{
    $cabeceraNumero='010501';
    $tituloForm='ALTA DE CONTACTO';
}
$paginaForm='';
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
    <form name="form1" method="post" action="../vista/altacontacto.php" onSubmit="desactivaBoton();">
        
      <table width="640" border="0" class="zonaactiva">
        <tr> 
          <td class="subtitulo" colspan="9">&nbsp;Contacto</td>
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
            <td colspan="3">
              <div align="left">
              <label class="nombreCampo">Nombre</label>
              <input class="textbox1" type="text" name="strNombre" id="strNombre" maxlength="30" value="<?php echo $datosContacto['NombreContacto']; ?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
          </td>
          <td></td>
          <td colspan="3">
              <div align="left">
              <label class="nombreCampo">Apellidos</label>
              <input class="textbox1" type="text" name="strApellidos" id="strApellidos" maxlength="50" value="<?php echo $datosContacto['ApellidosContacto']; ?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
          <td colspan="2"></td>
        </tr>
        <tr> 
            <td></td>
          <td> 
              <div align="left">
              <label class="nombreCampo">Teléfono</label>
              <input class="textbox1" type="text" name="strTelefono" id="strTelefono" maxlength="15" onkeypress="javascript:return solonumeros(event);" 
                     value="<?php echo $datosContacto['Telefono']; ?>" 
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
          <td></td>
          <td colspan="">
              <div align="left"> 
              <label class="nombreCampo">Teléfono Móvil</label>
              <input class="textbox1" type="text" name="strMovil" id="strMovil" maxlength="15" onkeypress="javascript:return solonumeros(event);" 
                     value="<?php echo $datosContacto['TelefonoMovil']; ?>" 
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
          <td></td>
          <td colspan="3">
              <div align="left">
                <label class="nombreCampo">Correo Electrónico</label>
                <input class="textbox1" type="text" name="strEmail" id="strEmail" maxlength="100" value="<?php echo $datosContacto['Correo']; ?>" 
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
          <td></td>
        </tr>
        <tr>
          <td></td>
          <td colspan="7">
              <div align="left">
                <label class="nombreCampo">Notas</label>
                <textarea class="textbox1area" name="strNotas" rows=4 
                      onKeyDown="LimitaTexto(this,254);" onKeyUp="LimitaTexto(this, 254);" cols="20" onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                      onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"><?php if(isset($datosContacto['Notas'])){echo $datosContacto['Notas'];}?></textarea> 
              </div>
          </td>
        </tr>
        <tr>
           <td></td>
           <td colspan="7">
               <label class="nombreCampo">¿Nombre de empresa igual a contacto?</label>
               <select class="textbox1" name="contactoSiEmpresa" style="width: 10%;" onChange="comprobarContactoSiEmpresa();">
                   <option value="No" <?php if($contactoSiEmpresa==='No'){echo 'selected';}?>>No</option>
                   <option value="Si" <?php if($contactoSiEmpresa==='Si'){echo 'selected';}?>>Si</option>
               </select>
           </td>
        </tr>
        <tr>
            <td height="15px"></td>
        </tr>
      </table>
        
      <table width="640" border="0" class="zonaactiva">
        <tr> 
          <td class="subtitulo" colspan="10">&nbsp;Empresa</td>
        </tr>
        <tr>
            <td width="3%"></td>
            <td width="15%"></td>
            <td width="8%"></td>
            <td width="15%"></td>
            <td width="8%"></td>
            <td width="15%"></td>
            <td width="8%"></td>
            <td width="15%"></td>
            <td width="13%"></td>
        </tr>
        <tr> 
            <td></td>
            <td colspan="3">
              <div align="left">
              <label class="nombreCampo">Nombre</label>
              <input class="textbox1" type="text" name="strNomEmpresa" id="strNomEmpresa" maxlength="150" value="<?php echo $datosContacto['NombreEmpresa']; ?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
          </td>
          <td></td>
          <td colspan="3">
              <div align="left">
              <label class="nombreCampo">CIF</label>
              <input class="textbox1" type="text" name="strCIF" id="strCIF" maxlength="20" value="<?php echo $datosContacto['CIF']; ?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);limpiarTxtValidar();" onblur="onBlurInputText(this);validarNIFCIF(this);" />
              </div>
          </td>
          <td>
              <span class="validar" id="txt_validar"></span>
          </td>
          <td></td>
        </tr>
        <tr> 
            <td></td>
            <td colspan="3">
              <div align="left">
              <label class="nombreCampo">Dirección</label>
              <input class="textbox1" type="text" name="strDireccion" id="strDireccion" maxlength="255" value="<?php echo $datosContacto['Direccion']; ?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
          <td></td>
          <td colspan="3"> 
              <div align="left">
              <label class="nombreCampo">Municipio</label>
              <input class="textbox1" type="text" name="strMunicipio" id="strMunicipio" maxlength="50" value="<?php echo $datosContacto['Ciudad']; ?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
          <td colspan="2"></td>
        </tr>
        <tr> 
          <td></td>
          <td> 
              <div align="left">
              <label class="nombreCampo">Código Postal</label>
              <input class="textbox1" type="text" name="lngCP" id="lngCP" maxlength="5" onkeypress="javascript:return solonumeros(event);"
                     value="<?php echo $datosContacto['CodPostal']; ?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
          <td></td>
          <td>
              <div align="left"> 
              <label class="nombreCampo">Provincia</label>
              <input class="textbox1" type="text" name="strProvincia" id="strProvincia" maxlength="50" value="<?php echo $datosContacto['Provincia']; ?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
          <td></td>
          <td colspan="2">
              <div align="left"> 
              <label class="nombreCampo">Forma Pago Habitual</label>
              <select class="textbox1" name="strFormaPago" style="width: 90%;">
                  <option value=""></option>
                  <option value="Contado" <?php if($datosContacto['FormaPagoHabitual']==='Contado'){echo 'selected';}?>>Contado</option>
                  <option value="Pagare" <?php if($datosContacto['FormaPagoHabitual']==='Pagare'){echo 'selected';}?>>Pagaré</option>
                  <option value="Recibo" <?php if($datosContacto['FormaPagoHabitual']==='Recibo'){echo 'selected';}?>>Recibo</option>
                  <option value="Talon" <?php if($datosContacto['FormaPagoHabitual']==='Talon'){echo 'selected';}?>>Talón</option>
                  <option value="Transferencia" <?php if($datosContacto['FormaPagoHabitual']==='Transferencia'){echo 'selected';}?>>Transferencia</option>
              </select>
              </div>
          </td>
          <td>
            <?php
            //si es contacto nuevo no aparece este boton de pasar a Cliente, si se edita si aparece
            if(isset($_GET['IdContacto'])){
            ?>
              <div align="left">
                <label class="nombreCampo">¿Es Cliente?</label>
                <input class="textbox1" type="text" 
                <?php
                //compruebo como viene $datosContacto['IdCliProv']
                if(isset($datosContacto['IdCliProv']) && $datosContacto['IdCliProv']<>'0'){
                    echo 'value="SI"';
                }else{
                    echo 'value="NO"';
                }
                ?>       
                readonly />
              </div>
            <?php
            }
            ?>
          </td>
          <td></td>
        </tr>
        <tr>
            <td height="15px"></td>
        </tr>
      </table>

        
      <P>
        <input type="button" id="cmdAlta" class="button" value = "<?php if(isset($_GET['IdContacto'])){echo 'Grabar';}else{echo 'Proceder al Alta';} ?>" onclick="javascript:validar2();" />
        <?php if(isset($_GET['IdContacto'])){?>
        <input class="buttonAzul" type="button" value="Volver" onclick="javascript:history.back();" />
        <?php }?>
        <?php
        //si es contacto nuevo no aparece este boton de pasar a Cliente, si se edita si aparece
        if(isset($_GET['IdContacto'])){
            if($datosContacto['TienePresupuesto']==='NO'){
            ?>
            <input type="button" class="buttonAzul"  value="Eliminar" name="cmdBorrar" onclick="javascript:borrarContacto(<?php echo $_GET['IdContacto']; ?>);" />
            <?php }else{?>
            <input type="button" class="buttonAzul"  value="Eliminar" name="cmdBorrar" onclick="javascript:avisoContacto();" />
            <?php }?>
        <?php }?>
        <input type="Reset" class="buttonAzul" value="<?php if(isset($_GET['IdContacto'])){echo 'Datos Iniciales';}else{echo 'Vaciar Datos';} ?>" name="cmdReset"/>
        <?php
        //si es cliente no aparece el boton
        if(!isset($datosContacto['IdCliProv']) || $datosContacto['IdCliProv']==='0'){
            //si es contacto nuevo no aparece este boton de pasar a Cliente, si se edita si aparece
            if(isset($_GET['IdContacto'])){
        ?>
        <input type="button" class="button" name="cmdPasarCliente" id="cmdPasarCliente" value = "Generar Cliente" 
               onclick="javascript:pasarACliente();" />
        
        <div id="cuenta" style="display: none;">
            <?php if(!isset($datosContacto['NumCuenta']) || $datosContacto['NumCuenta']===''){?>
            <table border="0" width="400">
                <tr> 
                  <td width="75">
                      <div align="left">
                      <label class="nombreCampo">Nº Cuenta</label>
                      <input class="textbox1" type="text" name="lngTipo" id="lngTipo" maxlength="4"
                             value="4300" readonly />
                      </div>
                  </td>
                  <td></td>
                  <td colspan="2" width="150"> 
                      <div align="left">
                      <label class="nombreCampo"><font color="#F0F8FF">Codigo</font></label>
                      <input class="textbox1" type="text" name="lngCodigo" id="lngCodigo" maxlength="5" onkeypress="javascript:return solonumeros(event);" onKeyUp="check_cuenta(this.value,document.form1.lngTipo.value);"
                             onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
                      </div>
                  </td>
                  <td width="50">
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
                  <td>
                    <div align="left">  
                    <label class="nombreCampo"><font color="#F0F8FF">Codigo.........</font></label>
                    <input type="button" class="button" name="cmdPasarClienteOK" id="cmdPasarClienteOK" value = "OK" 
                           onclick="javascript:pasarAClienteOK();" />
                    </div>
                  </td>
                </tr>
            </table>
            <?php }else{ ?>
            <table border="0" width="400">
                <tr> 
                  <td width="75">
                      <div align="left">
                      <label class="nombreCampo">Nº Cuenta</label>
                      <input class="textbox1" type="text" name="lngTipo" id="lngTipo" maxlength="4"
                             value="<?php echo $datosContacto['NumCuenta']; ?>" readonly />
                      </div>
                  </td>
                  <td></td>
                  <td>
                    <div align="left">  
                    <label class="nombreCampo"><font color="#F0F8FF">Codigo.........</font></label>
                    <input type="button" class="button" name="cmdPasarClienteOK" id="cmdPasarClienteOK" value = "OK" 
                           onclick="javascript:pasarAClienteContactoOK();" />
                    </div>
                  </td>
                </tr>
            </table>
            <?php } ?>
        </div>
        <?php
            }
        }
        ?>
        <input type="hidden"  name="opcion" value="<?php if(isset($_GET['IdContacto'])){echo 'editarContacto';}else{echo 'altaContacto';} ?>" />
        <input type="hidden"  name="IdContacto" value="<?php if(isset($_GET['IdContacto'])){echo $_GET['IdContacto'];} ?>" />

        <input type="hidden" name="url_inicial" onload="leer();" />
        
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