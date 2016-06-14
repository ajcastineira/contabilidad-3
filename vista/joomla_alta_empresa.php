<?php
session_start ();
require_once '../CN/clsCNUsu.php';
require_once '../general/funcionesGenerales.php';
require_once '../CN/clsCNJoomla.php';
$clsCNJoomla=new clsCNJoomla;
$clsCNJoomla->setStrBD($_SESSION['dbContabilidad']);

$clsCNUsu=new clsCNUsu();
$clsCNUsu->setStrBD($_SESSION['dbContabilidad']);

//Control de Sesion
//ControlaLoginTimeOut();

//Control de Permisos. Hay que incluirlo en todas las páginas
/**************************************************************/
$strPagina=dameURL();
$strCargo = trim($_SESSION['cargo']);   //Esto es el puesto al que le hacemos un trim

//$lngPermiso = AccesoUsuarioPagina ($strPagina, $strCargo);  // Le pasamos la página y el cargo. 
$lngPermiso = 1;  // Le pasamos la página y el cargo. 

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

function listadoAsesores(){
    require_once '../CN/clsCNUsu.php';
    $clsCNUsu=new clsCNUsu();
    $clsCNUsu->setStrBD($_SESSION['dbContabilidad']);
    $listadoAsesores=$clsCNUsu->listadoAsesores();
    $strHTML='';
    for ($i=0;$i<count($listadoAsesores);$i++){
        $strHTML =$strHTML."<OPTION value='".$listadoAsesores[$i]['lngIdEmpleado']."'>".$listadoAsesores[$i]['Asesor']."</OPTION>";
    }
    return $strHTML;
}


function listadoBBDDLibres(){
    require_once '../CN/clsCNUsu.php';
    $clsCNUsu=new clsCNUsu();
    $clsCNUsu->setStrBD($_SESSION['dbContabilidad']);
    $listadoBBDDLibres=$clsCNUsu->listadoBBDDLibres();
    $strHTML='';
    
    if($listadoBBDDLibres===''){
        return 'vacio';
    }
    for ($i=0;$i<count($listadoBBDDLibres);$i++){
        $strHTML =$strHTML."<OPTION value='".$listadoBBDDLibres[$i]['fichero']."'>".$listadoBBDDLibres[$i]['fichero']."</OPTION>";
    }
    return $strHTML;
}

//genero el listado de bases de datos vacias
$listadoBBDDLibres=listadoBBDDLibres();

////si no hay bases de datos libres lo avisamos y lo mandamos a la pagina de error
//if($listadoBBDDLibres==='vacio'){
//        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/errorAsesor.php?id=No existen Bases de Datos libres, se deben de crear nuevas bases de datos antes de dar de alta una nueva empresa.">';die;
//}

//CORREO DE LOS ASESORES QUE RECIBEN LOS USUARIOS (1 correo)
function EnviaCorreoAlCliente($Usuario,$strMail,$strNombre,$strPassword){
    require '../general/phpmailer/PHPMailerAutoload.php';
    
    $from="asesor@qualidad.es";
    $to=$strMail;

    $mail = new PHPMailer();
    //Correo desde donde se envía (from)
    $mail->setFrom($from, '');
    //Correo de envío (to)
    $mail->addAddress($to, '');
    $mail->CharSet = "UTF-8";
    $mail->Subject = "Qualidad. Plataforma gestión online";

    $html='<!DOCTYPE html>
            <html>
                <head>
                    <title>Q-Conta</title>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width">
                </head>
                <body>
                    <div>Respuesta enviada por: QUALIDAD S.L.</div>
                    <div>Al cliente: '.$Usuario.'</div><br/><br/><br/>
                    <div>
                        <p>Ha sido dado de alta en la plataforma de gestión online.</p>
                        <p>Sus claves de acceso son:</p>
                        <p></p>
                        <p>Usuario: '.$strNombre.'</p>
                        <p>Contraseña: '.$strPassword.'</p>
                        <p></p>
                        <p>Esperamos haber resuelto sus dudas. Estamos a su disposición para ampliar cualquier información al respecto.</p>
                        <p>Gracias por utilizar la plataforma de gestión online</p>
                        <p>Qualidad Consulting de Sistemas, S.L.</p>
                    </div><br/>
                </body>
            </html>';

    //Lee un HTML message body desde un fichero externo,
    //convierte HTML un plain-text básico 
    $mail->msgHTML($html);

    if (!$mail->send()) {
        logger('traza',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['srtBD'].', SesionID: '.  session_id().
               " Correo NO Enviado.");
    } else {
        logger('traza',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['srtBD'].', SesionID: '.  session_id().
               " Correo Enviado CORRECTAMENTE.");
    }
}



//codigo principal
//comprobamos si se ha submitido el formulario
if(isset($_POST['cmdAlta']) && $_POST['cmdAlta']=='Aceptar'){
    logger('info','joomla_alta_empresa.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id(). " ||||www.qualidad.es->Alta Empresa|| Ha pulsado 'Proceder a Alta'");

    //doy de alta la empresa y el usuario con los datos recogidos de joomla
    $OK=$clsCNUsu->AltaEmpresaNuevaDesdeJoomla($_POST);
    
    if($OK===true){
        //envio un correo al cliente indicandole que esta dado de alta y las claves de acceso
        EnviaCorreoAlCliente(($_POST['strNombreUsuario'].' '.$_POST['strApellidos']),$_POST['strCorreos'],$_POST['strUsuario'],$_POST['strPasswordUsuario']);
        
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/exitoAsesor.php">';
    }else{
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/errorAsesor.php">';
    }
    
}else{//comienzo del else principal
    logger('info','joomla_alta_empresa.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id(). " ||||www.qualidad.es->Alta Empresa|| ");
    $datos=$clsCNJoomla->datosForm_Suscripcion($_GET['id_joomla']);
    
    
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
<TITLE>Empresa - ALTA desde www.qualidad.es</TITLE>

<script language="JavaScript">

function validarP1()
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
  
  //comprobacion del campo 'strDireccion'
  if (document.form1.strDireccion.value == ''){ 
    textoError=textoError+"Es necesario introducir la dirección.\n";
    document.form1.strDireccion.style.borderColor='#FF0000';
    document.form1.strDireccion.title ='Es necesario introducir la dirección';
    esValido=false;
  }

  //comprobacion del campo 'strSesion'
  if (document.form1.strSesion.value == ''){ 
    textoError=textoError+"Es necesario introducir el nombre de la Empresa.\n";
    document.form1.strSesion.style.borderColor='#FF0000';
    document.form1.strSesion.title ='Es necesario introducir el nombre de la Empresa';
    esValido=false;
  }

  //comprobacion del campo 'strMunicipio'
  if (document.form1.strMunicipio.value == ''){ 
    textoError=textoError+"Es necesario introducir el municipio.\n";
    document.form1.strMunicipio.style.borderColor='#FF0000';
    document.form1.strMunicipio.title ='Es necesario introducir el municipio';
    esValido=false;
  }
  //comprobacion del campo 'provincia'
  if (document.form1.provincia.value == ''){ 
    textoError=textoError+"Es necesario introducir la provincia de la empresa.\n";
    document.form1.provincia.style.borderColor='#FF0000';
    document.form1.provincia.title ='Es necesario introducir la provincia de la empresa';
    esValido=false;
  }

  //comprobacion del campo 'strCP'
  if (document.form1.strCP.value == '' || isNaN(document.form1.strCP.value)){ 
    textoError=textoError+"Es necesario introducir el código postal.\n";
    document.form1.strCP.style.borderColor='#FF0000';
    document.form1.strCP.title ='Es necesario introducir el código postal';
    esValido=false;
  }

  //comprobacion del campo 'strTelefono'
  if (document.form1.strTelefono.value == ''){ 
    textoError=textoError+"Es necesario introducir el telefono.\n";
    document.form1.strTelefono.style.borderColor='#FF0000';
    document.form1.strTelefono.title ='Es necesario introducir el telefono';
    esValido=false;
  }

  //comprobacion del campo 'email1'
  if (document.form1.email1.value === ''){ 
    textoError=textoError+"Es necesario introducir el e-mail.\n";
    document.form1.email1.style.borderColor='#FF0000';
    document.form1.email1.title ='Es necesario introducir el e-mail';
    esValido=false;
  }else{
    //compruebo que el e-mail tenga un formato correcto 'admin@admin.com'  
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(document.form1.email1.value) ){
        textoError=textoError+"El E-mail 1 " + document.form1.email1.value + " es incorrecto.\n";
        document.form1.email1.style.borderColor='#FF0000';
        document.form1.email1.title ='El E-mail 1 es incorrecto';
        esValido=false;
    }
  }

  //comprobacion del campo 'email2'
  if (document.form1.email2.value === ''){ 
  }else{
    //compruebo que el e-mail tenga un formato correcto 'admin@admin.com'  
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(document.form1.email2.value) ){
        textoError=textoError+"El E-mail 2 " + document.form1.email2.value + " es incorrecto.\n";
        document.form1.email2.style.borderColor='#FF0000';
        document.form1.email2.title ='El E-mail 2 es incorrecto';
        esValido=false;
    }
  }

  //comprobacion del campo 'version'
  if (document.form1.version.value == ''){ 
    textoError=textoError+"Es necesario introducir la versión de la aplicación.\n";
    document.form1.version.style.borderColor='#FF0000';
    document.form1.version.title ='Es necesario introducir la versión de la aplicación';
    esValido=false;
  }

  //comprobacion del campo 'numApuntes'
  if (document.form1.numApuntes.value == ''){ 
    textoError=textoError+"Es necesario introducir el número de apuntes.\n";
    document.form1.numApuntes.style.borderColor='#FF0000';
    document.form1.numApuntes.title ='Es necesario introducir el número de apuntes';
    esValido=false;
  }
  

  //indicar el mensaje de error si es 'esValido' false
  if (!esValido){
          alert(textoError);
  }



  if(esValido==true){
      $('#pantallaSuperior').empty();
      $('#pantallaSuperior').html('<img id="imgSuperior" src="../images/joomla02.png" width="300" height="50" />');
      $('#pantalla1').slideUp(1000);
      $('#pantalla2').slideDown(1000);
  }else{
      return false;
  }  

}

function validar(){
    esValido=true;
    textoError='';

    //comprobacion del campo 'strNombreUsuario'
    if (document.form1.strNombreUsuario.value == ''){ 
      textoError=textoError+"Es necesario introducir el nombre del usuario.\n";
      document.form1.strNombreUsuario.style.borderColor='#FF0000';
      document.form1.strNombreUsuario.title ='Se debe introducir el nombre del usuario';
      esValido=false;
    }
    //comprobacion del campo 'strApellidos'
    if (document.form1.strApellidos.value == ''){ 
      textoError=textoError+"Es necesario introducir los apellidos del usuario.\n";
      document.form1.strApellidos.style.borderColor='#FF0000';
      document.form1.strApellidos.title ='Se deben introducir los apellidos del usuario';
      esValido=false;
    }
    //comprobacion del campo 'strCorreos'
    if (document.form1.strCorreos.value == ''){ 
      textoError=textoError+"Es necesario introducir un E-mail del usuario.\n";
      document.form1.strCorreos.style.borderColor='#FF0000';
      document.form1.strCorreos.title ='Se debe introducir un E-mail del usuario';
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
      textoError=textoError+"Es necesario introducir el nombre de usuario.\n";
      document.form1.strUsuario.style.borderColor='#FF0000';
      document.form1.strUsuario.title ='Se debe introducir el nombre de usuario';
      esValido=false;
    }
    //comprobacion del campo 'strPasswordUsuario'
    if (document.form1.strPasswordUsuario.value == ''){ 
      textoError=textoError+"Es necesario introducir la contraseña.\n";
      document.form1.strPasswordUsuario.style.borderColor='#FF0000';
      document.form1.strPasswordUsuario.title ='Se debe introducir la contraseña';
      esValido=false;
    }
    //comprobacion del campo 'strPasswordUsuario2'
    if (document.form1.strPasswordUsuario2.value == ''){ 
      textoError=textoError+"Es necesario introducir la repetición de la contraseña.\n";
      document.form1.strPasswordUsuario2.style.borderColor='#FF0000';
      document.form1.strPasswordUsuario2.title ='Se debe introducir repetición de la contraseña';
      esValido=false;
    }
    //comprobacion del campo 'strPasswordUsuario' y 'strPasswordUsuario2' son iguales
    if ((document.form1.strPasswordUsuario.value != '')&&(document.form1.strPasswordUsuario2.value != '') &&
         (document.form1.strPasswordUsuario.value != document.form1.strPasswordUsuario2.value) ){ 
      textoError=textoError+"La contraseña debe coincidir en los campos contraseña y repetir contraseña.\n";
      document.form1.strPasswordUsuario.style.borderColor='#FF0000';
      document.form1.strPasswordUsuario2.style.borderColor='#FF0000';
      document.form1.strPasswordUsuario.title ='Esta contraseña debe coincidir con la del campo repetir';
      document.form1.strPasswordUsuario2.title ='Esta repetición de contraseña debe coincidor con la del campo contraseña';
      esValido=false;
    }

    //comprobacion de que el nombre de usuario no esta repetido y que no sea el que tiene actualmente
    texto=document.getElementById("txt_usuario2").innerHTML;
    if (texto.indexOf('error') != -1 && document.form1.strUsuarioUsuario.value != '<?php echo $datosUsuario['strUsuario'];?>'){
      textoError=textoError+"El nombre de usuario ya existe.\n";
      document.form1.strUsuarioUsuario.style.borderColor='#FF0000';
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
function check_empresa(str){
    $.ajax({
      data:{"q":str},  
      url: '../vista/ajax/buscar_empresa.php',
      type:"get",
      success: function(data) {
        $('#txt_usuario').html(data);
      }
    });
}

//AJAX jQuery chequea usuario exista en la BD
function check_usuario(str){
    $.ajax({
      data:{"q":str},  
      url: '../vista/ajax/buscar_usuario.php',
      type:"get",
      success: function(data) {
        $('#txt_usuario2').html(data);
      }
    });
}

function limpiarTextoValidacion(){
    document.getElementById('txt_validar').innerHTML='';
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
$tituloForm="ALTA DE EMPRESA";
if(isset($_GET['id_joomla'])){
    $cabeceraNumero='a0101b';
}else{
    $cabeceraNumero='a0101a';
}
$paginaForm='';
$formatoForm='';
$numeroForm='';
$disabledForm='disabled';
date_default_timezone_set('Europe/Madrid');
$fechaForm=date('d/m/Y');
require_once './cabeceraFormAsesor.php';
?>
    
    <div class="doc"> 
    <hr color = "#FF9900">
    <br/>
    <form name="form1" method="post" action="../vista/joomla_alta_empresa.php" onSubmit="desactivaBoton()">
      <div>
          <span id="pantallaSuperior">
              <img id="imgSuperior" src="../images/joomla01.png" width="300" height="50" />
          </span>
      </div>
	
      <div id="pantalla1">
      <table width="640" border="0" class="zonaactiva">
        <tr> 
          <td class="subtitulo" colspan="10">&nbsp;Datos de la Empresa</td>
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
              <label class="nombreCampo">CIF</label>
              <input class="textbox1" type="text" name="strCIF" maxlength="50" value="<?php if(is_array($datos)){echo $datos['Cif'];} ?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="limpiarTextoValidacion();onFocusInputText(this);"
                     onblur="onBlurInputText(this);validarNIFCIF(this);"/>
              </div>
          </td>
          <td rowspan="2"><span class="validar" id="txt_validar"></span></td>
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
          <td class="subtitulo" colspan="10">&nbsp;Datos de inicio de Sesión</td>
        </tr>
        <tr>
          <td></td>
          <td>
              <div align="left">
              <label class="nombreCampo">Nombre</label>
              <input class="textbox1" type="text" name="strNombre" maxlength="30" onKeyUp="check_empresa(this.value);"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);" onblur="check_empresa(this.value);onBlurInputText(this);"/>
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
                  <label class="nombreCampo" style="font-size:11px;">NOTA: El nombre y la contraseña serán de 10 caracteres como máximo </label>
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

      <table width="640" border="0" class="zonaactiva">
          <tr>
              <td height="5" width="10%"></td>
              <td width="30%"></td>
              <td width="20%"></td>
              <td width="30%"></td>
              <td width="10%"></td>
          </tr>  
        <tr> 
          <td class="subtitulo" colspan="10">&nbsp;Datos Generales</td>
        </tr>
        <tr>
          <td></td>
          <td colspan="3">
              <div align="left">
              <label class="nombreCampo">Nombre de la Empresa</label>
              <input class="textbox1" type="text" name="strSesion" maxlength="50"
                     value="<?php if(is_array($datos)){echo $datos['Nombre_empresa'];} ?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
          </td>
          <td>
          </td>
        </tr>
        <tr>
          <td></td>
          <td>
              <div align="left">
              <label class="nombreCampo">Dirección</label>
              <input class="textbox1" type="text" name="strDireccion" maxlength="50"
                     value="<?php if(is_array($datos)){echo $datos['Direccion'];} ?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
          </td>
          <td>
          </td>
          <td>
              <div align="left">
              <label class="nombreCampo">Municipio</label>
              <input class="textbox1" type="text" name="strMunicipio" maxlength="50"
                     value="<?php if(is_array($datos)){echo $datos['Poblacion'];} ?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
          </td>
          <td>
          </td>
        </tr>
        <tr>
          <td></td>
          <td>
              <div align="left">
              <label class="nombreCampo">Provincia</label>
              <input class="textbox1" type="text" name="provincia" maxlength="50"
                     value="<?php if(isset($datos)){echo $datos['Provincia'];} ?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
          </td>
          <td>
          </td>
          <td>
          </td>
          <td>
          </td>
        </tr>
        <tr>
          <td></td>
          <td>
              <div align="left">
              <label class="nombreCampo">C.P.</label>
              <input class="textbox1" type="text" name="strCP" maxlength="5" onkeypress="javascript:return solonumeros(event);"
                     value="<?php if(is_array($datos)){echo $datos['CP'];} ?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
          </td>
          <td></td>
          <td>
              <div align="left">
              <label class="nombreCampo">Telefono</label>
              <input class="textbox1" type="text" name="strTelefono" maxlength="11" onkeypress="javascript:return solonumeros(event);"
                     value="<?php if(is_array($datos)){echo $datos['Telefono'];} ?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
          </td>
          <td></td>
        </tr>
        <tr>
          <td></td>
          <td>
              <div align="left">
              <label class="nombreCampo">E-mail 1</label>
              <input class="textbox1" type="text" name="email1" maxlength="50"
                     value="<?php if(is_array($datos)){echo $datos['email'];} ?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
          </td>
          <td></td>
          <td>
              <div align="left">
              <label class="nombreCampo">E-mail 2</label>
              <input class="textbox1" type="text" name="email2" maxlength="50"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
          </td>
          <td></td>
        </tr>
        <tr>
          <td></td>
          <td>
              <div align="left">
              <label class="nombreCampo">Version</label>
              <input class="textbox1" type="text" name="version" maxlength="11" onkeypress="javascript:return solonumeros(event);"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" value="1"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
          </td>
          <td></td>
          <td>
              <div align="left">
              <label class="nombreCampo">Número Apuntes</label>
              <input class="textbox1" type="text" name="numApuntes" maxlength="11" onkeypress="javascript:return solonumeros(event);"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" value="100"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
          </td>
          <td></td>
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
          <td class="subtitulo" colspan="10">&nbsp;Datos Aplicación</td>
        </tr>
        <tr>
            <td height="15px"></td>
        </tr>
        <tr>
          <td></td>
          <td colspan="1">
              <div align="left">
              <label class="nombreCampo">Asesor</label>
              <select class="textbox1" name="IdAsesor" onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);">
                  <?php
                  //funcion general
                  echo listadoAsesores();
                  ?>
              </select>
              </div>
          </td>
          <td>
          </td>
        </tr>
        <tr>
          <td></td>
          <td>
              <div align="left">
              <label class="nombreCampo">Base Datos Libres</label>
              <select class="textbox1" name="strMapeo" onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);">
                  <?php
                  //funcion general
                  echo $listadoBBDDLibres;
                  ?>
              </select>
              </div>
          </td>
          <td>
          </td>
          <td>
              <div align="left">
              <label class="nombreCampo">Clase de Empresa</label>
              <select class="textbox1" name="claseEmpresa" onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);">
                  <option value="Autonomo">Autonomo</option>
                  <option value="Sociedades">sociedades (PYMES)</option>
                  <option value="AsocSAL">Asociaciones (Sin Animo de Lucro)</option>
              </select>
              </div>
          </td>
          <td>
          </td>
        </tr>
        
        
        <tr>
            <td height="15px"></td>
        </tr>
      </table>
      <input type="button" id="cmdAlta1" class="button" value = "Continuar" onclick="javascript:validarP1();" />
      </div>

        
      <div id="pantalla2" style="display:none;">
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
              <input class="textbox1" type="text" name="strNombreUsuario" maxlength="30" value="<?php if(is_array($datos)){echo $datos['Nombre'];} ?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
          </td>
        </tr>
        <tr>
          <td colspan="7">
              <div align="left">
              <label class="nombreCampo">Apellidos</label>
              <input class="textbox1" type="text" name="strApellidos" maxlength="30" value="<?php if(is_array($datos)){echo $datos['Primer_apellido'].' '.$datos['Segundo_apellido'];} ?>"
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
              <label class="nombreCampo">Móvil</label>
              <input class="textbox1" type="text" name="lngMovil" maxlength="20" value="<?php if(is_array($datos)){echo $datos['Telef_movil'];} ?>" onkeypress="javascript:return solonumeros(event);"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
          <td></td>
          <td colspan="3">
              <div align="left">
              <label class="nombreCampo">E-mail</label>
              <input class="textbox1" type="text" name="strCorreos" maxlength="50" value="<?php if(is_array($datos)){echo $datos['email_responsable'];} ?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
          <td width="5%"></td>
        </tr>
        <tr>
          <td colspan="2"></td>
          <td colspan="3">
          </td>
          <td></td>
        </tr>
        <tr>
          <td colspan="2"></td>
          <td colspan="3">
          </td>
          <td></td>
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
                     value="<?php echo $datosUsuario['strUsuario'];?>"
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
                         <span valign="top" id="txt_usuario2"></span>
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
              <input class="textbox1" type="password" name="strPasswordUsuario" maxlength="10" value="<?php echo $datosUsuario['strPassword'];?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
          <td></td>
          <td>
              <div align="left">
              <label class="nombreCampo">Repetir Contraseña</label>
              <input class="textbox1" type="password" name="strPasswordUsuario2" maxlength="10" value="<?php echo $datosUsuario['strPassword'];?>"
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
        <input type="button" class="button" name="cmdAlta" id="cmdAlta" value = "Proceder al Alta" onclick="javascript:validar();" /> 
        <input type="hidden"  name="cmdAlta" value="Aceptar" />
        <input type="hidden"  name="id_joomla" value="<?php echo $_GET['id_joomla']; ?>" />
      </P>
      </div>
        
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