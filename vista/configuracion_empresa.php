<?php
session_start ();
require_once '../CN/clsCNContabilidad.php';
require_once '../general/funcionesGenerales.php';


//Control de Sesion
//ControlaLoginTimeOut();

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

function listadoAsesores($lngAsesor){
    require_once '../CN/clsCNUsu.php';
    $clsCNUsu=new clsCNUsu();
    $clsCNUsu->setStrBD($_SESSION['dbContabilidad']);
    $listadoAsesores=$clsCNUsu->listadoAsesores();
    $strHTML='';
    for ($i=0;$i<count($listadoAsesores);$i++){
        if($lngAsesor==$i){
            $strHTML =$strHTML."<OPTION value='".$listadoAsesores[$i]['lngIdEmpleado']."' selected>".$listadoAsesores[$i]['Asesor']."</OPTION>";
        }else{
            $strHTML =$strHTML."<OPTION value='".$listadoAsesores[$i]['lngIdEmpleado']."'>".$listadoAsesores[$i]['Asesor']."</OPTION>";
        }
    }
    return $strHTML;
}

//generar el codigo HTML para el select del tipo de factura
//lee de la tabla tbContabilidad.tbtipofactura
function listadoTiposFactura($IdTipo){
    require_once '../CN/clsCNContabilidad.php';
    $clsCNContabilidad=new clsCNContabilidad();
    $clsCNContabilidad->setStrBD($_SESSION['dbContabilidad']);

    $listado = $clsCNContabilidad->listadoTiposFactura();
    $strHTML='';
    for ($i=0;$i<count($listado);$i++){
        if($listado[$i]['IdTipo'] === $IdTipo){
            $strHTML =$strHTML."<OPTION value='".$listado[$i]['IdTipo']."' selected>".$listado[$i]['Nombre']."</OPTION>";
        }else{
            $strHTML =$strHTML."<OPTION value='".$listado[$i]['IdTipo']."'>".$listado[$i]['Nombre']."</OPTION>";
        }
    }
    return $strHTML;
}





//codigo principal
//pulso el boton cmdAlta
if(isset($_POST['opcion']) && $_POST['opcion']==='true'){
    logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
           " ||||Configuracion->Mi Empresa(Guardando)||");
    //compruebo el files[doc]
    //compruebo que no haya habido error de subida
    if($_FILES['doc']['error']==1){
        logger('traza',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " Ha habido error en la subida.");
        $errorFile='Error al subir el fichero. ';
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/error.php?id=No se ha actualizado los datos en la BBDD correctamente<br/>'.$errorFile.'">';die;
    }else{
        if(!$_FILES['doc']['error']==4 && $_FILES['doc']['name']<>''){
            logger('traza',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " Tiene fichero adjunto: ".$_FILES['doc']['name']);
            //le damos un nombre al fichero
            //este nombre consta del 'logo-' y $_SESSION[strBD]
            $ext=explode('.',$_FILES['doc']['name']);
            $nombre='logo-'.$_SESSION['strBD'].'.'.$ext[1];
            $url="../images/".$nombre;
            //compruebo que no sea superior a 100 kB (102400)
            if($_FILES['doc']['size']<102400){
                logger('traza',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " El fichero es menor de 100 kB: ".$_FILES['doc']['size']);
                //subo a la carpeta de doc-EMPRESA el fichero seleccionado
                if(move_uploaded_file($_FILES['doc']['tmp_name'], $url)){
                    logger('traza',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                           " El fichero ".$_FILES['doc']['name'].' a sido subido correctamente al servidor');
                    //ahora actualizo el registro de Logo en 'tbparametros_generales'
                    $OK=$clsCNContabilidad->Actualizar_Logo_tbparametros_generales($nombre);
                }else{
                    logger('traza',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                           " El fichero ".$_FILES['doc']['name'].' NO a sido subido al servidor. Error en COPY');
//                    $OK=false;
                    $errorFile='Error al subir el fichero: '.$_FILES['doc']['name'];
                echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/error.php?id=No se ha actualizado los datos en la BBDD correctamente<br/>'.$errorFile.'">';die;
                }
            }else{
                logger('traza',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " El fichero es mayor de 100 kB: ".$_FILES['doc']['size']);
                $errorFile=$_FILES['doc']['name'].': Este fichero supera 100 kB de tamaño.';
                echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/error.php?id=No se ha actualizado los datos en la BBDD correctamente<br/>'.$errorFile.'">';die;
            }
        }else{//si no hay, insertamos
            logger('traza',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " NO tiene fichero adjunto. ");
        }
    }    
    
    //compruebo si las operaciones anteriores vienen correctas $OK
    if($OK==='false'){
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/error.php?id=No se ha actualizado los datos en la BBDD correctamente<br/>'.$errorFile.'">';die;
    }else{
        //guardo los datos en la tabla 'tbparametros_generales'
        $varRes=$clsCNContabilidad->guardarParametros_generales($_POST);
        
        //redireccionamos a exito o error, segun la variable $varRes
        if($varRes<>1){
            echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/error.php?id=No se ha actualizado correctamente los datos en la BBDD">';die;
        }else{
            //guardo los datos de la tabla 'tbempresas' (actualizo)
            $OK=$clsCNContabilidad->Actualizar_tbempresas($_POST);
            if($OK<>1){
                echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/error.php?id=No se ha actualizado correctamente los datos en la BBDD">';
            }else{
                echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/exito.php">';
            }
        }
    }
}
//comienzo del else principal
else{
    logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
           " ||||Configuracion->Mi Empresa||");

    //datos de la empresa guardados en la tabla tbparametros_generales
    $datosEmpresa=$clsCNContabilidad->DatosEmpresa();
    
    //datos de la empresa guardados en la tabla tbempresas
    $datosEmpresa_tbempresas=$clsCNContabilidad->DatosEmpresa_tbempresas($_SESSION['idEmp']);
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

<script src="https://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
<script type="text/javascript" src="../js/jQuery/js/jquery.corner.js"></script>
<link rel="stylesheet" href="../js/jQuery/css/jquery-ui.qualidad.css" />

<link href="../js/jQuery/input-file/jquery.file.css" rel="stylesheet" type="text/css" />
<script src="../js/jQuery/input-file/jquery.file.js" type="text/javascript"></script>

<TITLE>Configuración Mi Empresa</TITLE>

<script language="JavaScript">

function validar2()
{
  esValido=true;
  textoError='';
  
  //comprobacion del campo 'PorcAutonomos'
  if (document.form1.PorcAutonomo.value == ''){ 
    textoError=textoError+"Es necesario introducir la cantidad de retención de porcentaje de autonomos.\n";
    document.form1.PorcAutonomo.style.borderColor='#FF0000';
    document.form1.PorcAutonomo.title ='Es necesario introducir la cantidad de retención de porcentaje de autonomos';
    esValido=false;
  }
  //comprobacion del campo 'PagosCuentas'
  if (document.form1.PagosCuentas.value == ''){ 
    textoError=textoError+"Es necesario introducir la cantidad de retención de pago a cuenta.\n";
    document.form1.PagosCuentas.style.borderColor='#FF0000';
    document.form1.PagosCuentas.title ='Es necesario introducir la cantidad de retención de pago a cuenta';
    esValido=false;
  }
  //comprobacion del campo 'email'
  if (document.form1.email.value === ''){ 
  }else{
    //compruebo que el e-mail tenga un formato correcto 'admin@admin.com'  
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(document.form1.email.value) ){
        textoError=textoError+"El E-mail " + document.form1.email.value + " es incorrecto.\n";
        document.form1.email.style.borderColor='#FF0000';
        document.form1.email.title ='El E-mail es incorrecto';
        esValido=false;
    }
  }
  
  //comprobacion que no haya frases con error en el txt_file
  texto=document.getElementById("txt_file").innerHTML;
  if (texto.indexOf('NO es JPG o PNG') != -1){
    textoError=textoError+"El fichero NO es JPG o PNG.\n";
    esValido=false;
  }
  if (texto.indexOf('Este fichero EXISTE') != -1){
    textoError=textoError+"Este fichero EXISTE.\n";
    esValido=false;
  }
  
  //indicar el mensaje de error si es 'esValido' false
  if (!esValido){
          alert(textoError);
  }

  if(esValido==true){
      document.getElementById("cmdAlta").value = "Enviando...";
      document.getElementById("cmdAlta").disabled = true;
      document.form1.opcion.value='true';
      document.form1.submit();
  }else{
      return false;
  }  
}

//AJAX jQuery chequea usuario exista en la BD
function check_usuario(str){
    $.ajax({
      data:{"q":str},  
      url: '../vista/ajax/buscar_empresa.php',
      type:"get",
      success: function(data) {
          $('#txt_usuario').html(data);
      }
    });
}

function validarP1(){
  esValido=true;
  textoError='';
  
  //comprobacion del campo 'strSesion'
  if (document.form1.strSesion.value == ''){ 
    textoError=textoError+"Es necesario introducir el nombre de la empresa.\n";
    document.form1.strSesion.style.borderColor='#FF0000';
    document.form1.strSesion.title ='Es necesario introducir el nombre de la empresa';
    esValido=false;
  }
  //comprobacion del campo 'strDireccion'
  if (document.form1.strDireccion.value == ''){ 
    textoError=textoError+"Es necesario introducir la dirección de la empresa.\n";
    document.form1.strDireccion.style.borderColor='#FF0000';
    document.form1.strDireccion.title ='Es necesario introducir la dirección de la empresa';
    esValido=false;
  }
  //comprobacion del campo 'strMunicipio'
  if (document.form1.strMunicipio.value == ''){ 
    textoError=textoError+"Es necesario introducir el municipio de la empresa.\n";
    document.form1.strMunicipio.style.borderColor='#FF0000';
    document.form1.strMunicipio.title ='Es necesario introducir el municipio de la empresa';
    esValido=false;
  }
  //comprobacion del campo 'provincia'
  if (document.form1.provincia.value == ''){ 
    textoError=textoError+"Es necesario introducir la provincia de la empresa.\n";
    document.form1.provincia.style.borderColor='#FF0000';
    document.form1.provincia.title ='Es necesario introducir la provincia de la empresa';
    esValido=false;
  }
  //comprobacion del campo 'lngCP'
  if (document.form1.lngCP.value == ''){ 
    textoError=textoError+"Es necesario introducir el código postal de la empresa.\n";
    document.form1.lngCP.style.borderColor='#FF0000';
    document.form1.lngCP.title ='Es necesario introducir el código postal de la empresa';
    esValido=false;
  }
  //comprobacion del campo 'lngTelefono'
  if (document.form1.lngTelefono.value == ''){ 
    textoError=textoError+"Es necesario introducir el teléfono de la empresa.\n";
    document.form1.lngTelefono.style.borderColor='#FF0000';
    document.form1.lngTelefono.title ='Es necesario introducir el teléfono de la empresa';
    esValido=false;
  }
  //comprobacion del campo 'strEmail1'
  if (document.form1.strEmail1.value == ''){ 
    textoError=textoError+"Es necesario introducir el e-mail 1 de la empresa.\n";
    document.form1.strEmail1.style.borderColor='#FF0000';
    document.form1.strEmail1.title ='Es necesario introducir el e-mail 1 de la empresa';
    esValido=false;
  }else{
    //compruebo que el e-mail tenga un formato correcto 'admin@admin.com'  
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(document.form1.strEmail1.value) ){
        textoError=textoError+"El E-mail " + document.form1.strEmail1.value + " es incorrecto.\n";
        document.form1.strEmail1.style.borderColor='#FF0000';
        document.form1.strEmail1.title ='El E-mail es incorrecto';
        esValido=false;
    }
  }
  //comprobacion del campo 'strEmail2'
  if (document.form1.strEmail2.value == ''){ 
  }else{
    //compruebo que el e-mail tenga un formato correcto 'admin@admin.com'  
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(document.form1.strEmail2.value) ){
        textoError=textoError+"El E-mail " + document.form1.strEmail2.value + " es incorrecto.\n";
        document.form1.strEmail2.style.borderColor='#FF0000';
        document.form1.strEmail2.title ='El E-mail es incorrecto';
        esValido=false;
    }
  }
  //comprobacion del campo 'fechaAlta'
  if (document.form1.fechaAlta.value == ''){ 
    textoError=textoError+"Es necesario introducir la fecha de alta de la empresa.\n";
    document.form1.fechaAlta.style.borderColor='#FF0000';
    document.form1.fechaAlta.title ='Es necesario introducir la fecha de alta de la empresa';
    esValido=false;
  }
  //comprobacion del campo 'fechaVencimiento'
  if (document.form1.fechaVencimiento.value == ''){ 
    textoError=textoError+"Es necesario introducir la fecha de vencimiento de la empresa.\n";
    document.form1.fechaVencimiento.style.borderColor='#FF0000';
    document.form1.fechaVencimiento.title ='Es necesario introducir la fecha de vencimiento de la empresa';
    esValido=false;
  }
    
    
  //indicar el mensaje de error si es 'esValido' false
  if (!esValido){
          alert(textoError);
  }

  if(esValido==true){
      $('#pantallaSuperior').empty();
      $('#pantallaSuperior').html('<img id="imgSuperior" src="../images/paso02.png" width="300" height="50" />');
      $('#pantalla1').slideUp(1000);
      $('#pantalla2').slideDown(1000);
  }else{
      return false;
  }  
}

function validarP2(){
  esValido=true;
  textoError='';
  
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
    
    
  //indicar el mensaje de error si es 'esValido' false
  if (!esValido){
          alert(textoError);
  }

  if(esValido==true){
      $('#pantallaSuperior').empty();
      $('#pantallaSuperior').html('<img id="imgSuperior" src="../images/paso03.png" width="300" height="50" />');
      $('#pantalla2').slideUp(1000);
      $('#pantalla3').slideDown(1000);
  }else{
      return false;
  }  
}

function validarP3(){
    //aqui no hay que validar nada, esta todo en select
      $('#pantallaSuperior').empty();
      $('#pantallaSuperior').html('<img id="imgSuperior" src="../images/paso04.png" width="300" height="50" />');
      $('#pantalla3').slideUp(1000);
      $('#pantalla4').slideDown(1000);
}

//aparece o esconde los comentarios
function comentario(objeto,opcion){
    if(opcion==='Ver'){
        objeto.style.display='block';
    }else{
        objeto.style.display='none';
    }
}

//AJAX jQuery chequea cuenta exista en la BD
function check_fileConsulta(file){
    var respuesta=true;
    $.ajax({
        data:{"file":file.value},  
        url: '../vista/ajax/buscar_fileLogo.php',
        type:"get",
        success: function(data) {
          $('#txt_file').html(data);
          if(data!=''){
              respuesta=false;
          }
        }
    });
}

function actualizaHiddenEstado(check,hidden){
    if(check.checked===true){
        hidden.value='on';
    }else{
        hidden.value='off';
    }
}

$(document).ready(function() {
    $('#Autonomos').corner("round 5px");
    $('#PagosCuenta').corner("round 5px");
    $('#emailEnvio').corner("round 5px");
    $('#tipoCont').corner("round 5px");
    $('#aliasEmp').corner("round 5px");
    $('#logoImg').corner("round 5px");
    $('#carpetaUsuarioCuadro').corner("round 5px");
});

$(document).ready(function() {
    $("input.file").file();
});

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
<BODY bgColor=#ffffff leftMargin=0 topMargin=0 rightMargin=0 bottomMargin=0 marginwidth="0" marginheight="0"  background="<?php echo FONDO; ?>"
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
$tituloForm='CONFIGURACIÓN MI EMPRESA';
$cabeceraNumero='0106';
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
    <form name="form1" method="post" action="../vista/configuracion_empresa.php" onSubmit="desactivaBoton();" enctype="multipart/form-data">
      <div>
          <span id="pantallaSuperior">
              <img id="imgSuperior" src="../images/paso01.png" width="300" height="50" />
          </span>
      </div>
        
      <div id="pantalla1">
      <table width="640" border="0" class="zonaactiva">
        <tr> 
          <td class="subtitulo" colspan="10">&nbsp;Datos Generales</td>
        </tr>
          <tr>
              <td width="10%"></td>
              <td width="30%"></td>
              <td width="20%"></td>
              <td width="30%"></td>
              <td width="10%"></td>
          </tr>  
        <tr>
          <td></td>
          <td colspan="3">
              <div align="left">
              <label class="nombreCampo">Nombre de la Empresa</label>
              <input class="textbox1" type="text" name="strSesion" maxlength="50" value="<?php if(isset($datosEmpresa_tbempresas)){echo $datosEmpresa_tbempresas['strSesion'];} ?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
          </td>
          <td>
          </td>
        </tr>
        <tr>
          <td></td>
          <td colspan="3">
              <div align="left">
              <label class="nombreCampo">CIF (Lectura)</label>
              <input class="textbox1" type="text" readonly
                     value="<?php if(isset($datosEmpresa_tbempresas)){echo $datosEmpresa_tbempresas['strCIF'];} ?>" />
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
                     value="<?php if(isset($datosEmpresa_tbempresas)){echo $datosEmpresa_tbempresas['direccion'];} ?>"
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
                     value="<?php if(isset($datosEmpresa_tbempresas)){echo $datosEmpresa_tbempresas['municipio'];} ?>"
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
                     value="<?php if(isset($datosEmpresa_tbempresas)){echo $datosEmpresa_tbempresas['provincia'];} ?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
          </td>
          <td></td>
          <td>
              <div align="left">
              <label class="nombreCampo">CC Transferencias</label>
              <input class="textbox1" type="text" name="CCTrans" maxlength="30"
                     value="<?php if(isset($datosEmpresa)){echo $datosEmpresa['CCTrans'];} ?>"
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
              <label class="nombreCampo">C.P.</label>
              <input class="textbox1" type="text" name="lngCP" maxlength="5" onkeypress="javascript:return solonumeros(event);"
                     value="<?php if(isset($datosEmpresa_tbempresas)){echo $datosEmpresa_tbempresas['CP'];} ?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
          </td>
          <td></td>
          <td>
              <div align="left">
              <label class="nombreCampo">Telefono</label>
              <input class="textbox1" type="text" name="lngTelefono" maxlength="11" onkeypress="javascript:return solonumeros(event);"
                     value="<?php if(isset($datosEmpresa_tbempresas)){echo $datosEmpresa_tbempresas['telefono'];} ?>"
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
              <input class="textbox1" type="text" name="strEmail1" maxlength="50"
                     value="<?php if(isset($datosEmpresa_tbempresas)){echo $datosEmpresa_tbempresas['email1'];} ?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
          </td>
          <td></td>
          <td>
              <div align="left">
              <label class="nombreCampo">E-mail 2</label>
              <input class="textbox1" type="text" name="strEmail2" maxlength="50"
                     value="<?php if(isset($datosEmpresa_tbempresas)){echo $datosEmpresa_tbempresas['email2'];} ?>"
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
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" 
                     value="<?php if(isset($datosEmpresa_tbempresas)){echo $datosEmpresa_tbempresas['Version'];} ?>"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
          </td>
          <td></td>
          <td>
              <div align="left">
              <label class="nombreCampo">Número Apuntes</label>
              <input class="textbox1" type="text" name="numApuntes" maxlength="11" onkeypress="javascript:return solonumeros(event);"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     value="<?php if(isset($datosEmpresa_tbempresas)){echo $datosEmpresa_tbempresas['numApuntes'];} ?>"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
          </td>
          <td></td>
        </tr>
        <tr>
          <td></td>
          <td>
              <?php
              datepicker_español('fechaAlta');
              datepicker_español('fechaVencimiento');
              ?>
              <div align="left">
              <label class="nombreCampo">Fecha Alta</label>
              <input class="textbox1" type="text" name="fechaAlta" maxlength="38"
                     onKeyUp="this.value=formateafechaEntrada(this.value);" id="fechaAlta"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" 
                     value="<?php if(isset($datosEmpresa_tbempresas)){echo $datosEmpresa_tbempresas['fechaAlta'];} ?>"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
          </td>
          <td></td>
          <td>
              <div align="left">
              <label class="nombreCampo">Fecha Vencimiento</label>
              <input class="textbox1" type="text" name="fechaVencimiento" maxlength="38"
                     onKeyUp="this.value=formateafechaEntrada(this.value);" id="fechaVencimiento"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" 
                     value="<?php if(isset($datosEmpresa_tbempresas)){echo $datosEmpresa_tbempresas['fechaVencimiento'];} ?>"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
          </td>
          <td></td>
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
          <td class="subtitulo" colspan="10">&nbsp;Datos de Inicio de Sesión</td>
        </tr>
          <tr>
              <td height="5"></td>
              <td width="30%"></td>
              <td width="20%"></td>
              <td width="30%"></td>
              <td width="10%"></td>
          </tr>  
        <tr>
          <td></td>
          <td>
              <div align="left">
              <label class="nombreCampo">Nombre</label>
              <input class="textbox1" type="text" name="strNombre" maxlength="30" onKeyUp="check_usuario(this.value);"
                     value="<?php if(isset($datosEmpresa_tbempresas)){echo $datosEmpresa_tbempresas['strNombre'];} ?>"
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
                     value="<?php if(isset($datosEmpresa_tbempresas)){echo $datosEmpresa_tbempresas['strPassword'];} ?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
          <td></td>
          <td>
              <div align="left">
              <label class="nombreCampo">Repetir Contraseña</label>
              <input class="textbox1" type="password" name="strPassword2" maxlength="10"
                     value="<?php if(isset($datosEmpresa_tbempresas)){echo $datosEmpresa_tbempresas['strPassword'];} ?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
          <td></td>
        </tr>
        <tr>
            <td height="15px"></td>
        </tr>
      </table>
      <input type="button" id="cmdAlta2" class="button" value = "Continuar" onclick="javascript:validarP2();" />
      </div>
        
      <div id="pantalla3" style="display:none;">
      <table width="640" border="0" class="zonaactiva">
        <tr> 
            <td class="subtitulo" colspan="10">&nbsp;Datos Configuración Aplicación</td>
        </tr>
        <tr>
            <td height="5" width="10%"></td>
            <td width="30%"></td>
            <td width="20%"></td>
            <td width="30%"></td>
            <td width="10%"></td>
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
                  echo listadoAsesores($datosEmpresa_tbempresas['lngAsesor']);
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
              <label class="nombreCampo">Base Datos (Lectura)</label>
              <input class="textbox1" type="text" readonly
                     value="<?php if(isset($datosEmpresa_tbempresas)){echo $datosEmpresa_tbempresas['strMapeo'];} ?>" />
              </div>
          </td>
          <td>
          </td>
          <td>
              <div align="left">
              <label class="nombreCampo">Clase de Empresa</label>
              <select class="textbox1" name="claseEmpresa" onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);">
                  <?php
                  $selectedVacio='';
                  $selectedAutonomo='';
                  $selectedSociedades='';
                  $selectedAsocSAL='';
                  if($datosEmpresa_tbempresas['claseEmpresa']===''){
                      $selectedVacio='selected';
                  }else
                  if($datosEmpresa_tbempresas['claseEmpresa']==='Autonomo'){
                      $selectedAutonomo='selected';
                  }else
                  if($datosEmpresa_tbempresas['claseEmpresa']==='Sociedades'){
                      $selectedSociedades='selected';
                  }else
                  if($datosEmpresa_tbempresas['claseEmpresa']==='AsocSAL'){
                      $selectedAsocSAL='selected';
                  }
                  ?>
                  <option value="" <?php echo $selectedVacio;?>></option>
                  <option value="Autonomo" <?php echo $selectedAutonomo;?>>Autonomo</option>
                  <option value="Sociedades" <?php echo $selectedSociedades;?>>Sociedades (PYMES)</option>
                  <option value="AsocSAL" <?php echo $selectedAsocSAL;?>>Asociaciones (Sin Animo de Lucro)</option>
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
        <input type="button" id="cmdAlta3" class="button" value = "Continuar" onclick="javascript:validarP3();" />
      </div>
        
      <div id="pantalla4" style="display:none;">
      <table width="640" border="0" class="zonaactiva">
        <tr> 
          <td class="subtitulo" colspan="9">&nbsp;Datos Configuración Aplicación (Continuación)</td>
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
            <td colspan="1">
              <div align="left">
              <label class="nombreCampo">Autonomos (%)</label>
              <input class="textbox1" type="text" name="PorcAutonomo" maxlength="5" value="<?php if(isset($datosEmpresa)){echo $datosEmpresa['Porcentaje Autonomo'];}else{echo '20';} ?>"
                     onkeypress="return solonumeros(event);"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);comentario(document.getElementById('Autonomos'),'Ver');" onblur="onBlurInputText(this);comentario(document.getElementById('Autonomos'),'Ocultar');"/>
              </div>
              <br/>
          </td>
          <td colspan="2">
              <div id="Autonomos" class="cuadrosConfiguracion" style="display:none;">
                  <label class="nombreCampo">Cuota de retención (%) para los autónomos</label>
              </div>
          </td>
        </tr>
        <tr>
          <td></td>
          <td colspan="1">
              <div align="left">
              <label class="nombreCampo">Pagos Cuenta (%)</label>
              <input class="textbox1" type="text" name="PagosCuentas" maxlength="5" value="<?php if(isset($datosEmpresa)){echo $datosEmpresa['Pagos Cuenta'];}else{echo '20';} ?>"
                     onkeypress="return solonumeros(event);"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);comentario(document.getElementById('PagosCuenta'),'Ver');" onblur="onBlurInputText(this);comentario(document.getElementById('PagosCuenta'),'Ocultar');"/>
              </div>
              <br/>
          </td>
          <td colspan="2">
              <div id="PagosCuenta" class="cuadrosConfiguracion" style="display:none;">
                  <label class="nombreCampo">Pagos a Cuenta (%)</label>
              </div>
          </td>
        </tr>
        <tr>
          <td></td>
          <td colspan="1">
              <div align="left">
              <label class="nombreCampo">Iva Genérico (%)</label>
              <input class="textbox1" type="text" name="IvaGenerico" maxlength="5" value="<?php if(isset($datosEmpresa)){echo $datosEmpresa['IvaGenerico'];}else{echo '21';} ?>"
                     onkeypress="return solonumeros(event);"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);comentario(document.getElementById('txtIvaGenerico'),'Ver');" onblur="onBlurInputText(this);comentario(document.getElementById('txtIvaGenerico'),'Ocultar');"/>
              </div>
              <br/>
          </td>
          <td colspan="3">
              <div id="txtIvaGenerico" class="cuadrosConfiguracion" style="display:none;">
                  <label class="nombreCampo">IVA aplicable de forma general, salvo que se especifique un porcentaje diferente en los artículos</label>
              </div>
          </td>
        </tr>
        <tr> 
          <td></td>
          <td colspan="3"> 
              <div align="left">
              <label class="nombreCampo">Email Envios</label>
              <input class="textbox1" type="text" name="email" maxlength="40" value="<?php if(isset($datosEmpresa)){echo $datosEmpresa['Email Envios'];} ?>" 
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);comentario(document.getElementById('emailEnvio'),'Ver');" onblur="onBlurInputText(this);comentario(document.getElementById('emailEnvio'),'Ocultar');" />
              </div>
              <br/>
          </td>
          <td colspan="2">
              <div id="emailEnvio" class="cuadrosConfiguracion" style="display:none;">
                  <label class="nombreCampo">Email a donde irán los envíos que realice la aplicación</label>
              </div>
          </td>
        </tr>
        <tr>
          <td></td>
          <td colspan="5">
              <div align="left"> 
                  <label class="nombreCampo">¿Desea que aparezca el Logotipo en los documentos que se generen?</label>
                  <input type="checkbox" name="checkLogoDocumento" onclick="actualizaHiddenEstado(this,document.form1.logoDocumento);" <?php if(isset($datosEmpresa)){if($datosEmpresa['Logo en Documentos']==='on'){echo 'checked';}} ?> />
                  <input type="hidden" name="logoDocumento" value="<?php if(isset($datosEmpresa)){echo $datosEmpresa['Logo en Documentos'];} ?>" />
              </div>
          </td>
        </tr>
        <tr>
          <td></td>
          <td colspan="5">
              <div align="left"> 
                  <label class="nombreCampo">¿Desea que aparezca el Logotipo en la aplicación?</label>
                  <input type="checkbox" name="checkLogoAplicacion" onclick="actualizaHiddenEstado(this,document.form1.logoAplicacion);" <?php if(isset($datosEmpresa)){if($datosEmpresa['Logo en Aplicacion']==='on'){echo 'checked';}} ?> />
                  <input type="hidden" name="logoAplicacion" value="<?php if(isset($datosEmpresa)){echo $datosEmpresa['Logo en Aplicacion'];} ?>" />
              </div>
          </td>
          <td></td>
        </tr>
        <tr>
          <td></td>
          <td colspan="2">
              <div align="left"> 
                <br/>
                <label class="nombreCampo">Tipo de Contador</label>
                <select name="tipoContador"
                        onfocus="comentario(document.getElementById('tipoCont'),'Ver');" 
                        onblur="comentario(document.getElementById('tipoCont'),'Ocultar');">
<!--                    <option value="" <?php //if($datosEmpresa['Tipo Contador']===''){echo 'selected';}?>>Ninguno</option>-->
                    <option value="simple" <?php if($datosEmpresa['Tipo Contador']==='simple'){echo 'selected';}?>>Simple</option>
                    <option value="compuesto1" <?php if($datosEmpresa['Tipo Contador']==='compuesto1'){echo 'selected';}?>>Compuesto Número/Año</option>
<!--                    <option value="compuesto2" <?php //if($datosEmpresa['Tipo Contador']==='compuesto2'){echo 'selected';}?>>Compuesto Año/Número</option>-->
                </select>
              <br/>
              </div>
          </td>
          <td colspan="4">
              <div id="tipoCont" class="cuadrosConfiguracion" style="display:none;">
                  <label class="nombreCampo">Tipo de contador para la numeración de los presupuestos y facturas</label>
              </div>
          </td>
        </tr>
        <tr>
            <td height="15px"></td>
        </tr>
        <tr>
          <td></td>
          <td colspan="2">
              <div align="left"> 
                <label class="nombreCampo">Alias de la Empresa</label>
                <input class="textbox1" type="text" name="alias" maxlength="25" value="<?php if(isset($datosEmpresa)){echo $datosEmpresa['Alias'];} ?>"
                       onfocus="comentario(document.getElementById('aliasEmp'),'Ver');" onblur="comentario(document.getElementById('aliasEmp'),'Ocultar');" />
              <br/>
              </div>
          </td>
          <td colspan="2">
              <div id="aliasEmp" class="cuadrosConfiguracion" style="display:none;">
                  <label class="nombreCampo">Nombre corto de la Empresa</label>
              </div>
          </td>
        </tr>
        <tr>
            <td height="15px"></td>
        </tr>
        <tr>
          <td></td>
          <td colspan="2">
              <div align="left"> 
                <label class="nombreCampo">Prefijo en las facturas Rectificativas</label>
                <input class="textbox1" type="text" name="PrefijoFacturaAbono" maxlength="25" value="<?php if(isset($datosEmpresa)){echo $datosEmpresa['PrefijoFacturaAbono'];} ?>"
                       onfocus="comentario(document.getElementById('prefAbono'),'Ver');" onblur="comentario(document.getElementById('prefAbono'),'Ocultar');" />
              <br/>
              </div>
          </td>
          <td colspan="2">
              <div id="prefAbono" class="cuadrosConfiguracion" style="display:none;">
                  <label class="nombreCampo">Prefijo en las facturas Rectificativas</label>
              </div>
          </td>
        </tr>
        <tr>
            <td height="15px"></td>
        </tr>
        <tr>
          <td></td>
          <td colspan="2">
              <div align="left"> 
                <label class="nombreCampo">Logo de la Empresa</label>
                <input type="file" class="file" id="doc" name="doc" onchange="check_fileConsulta(this);" 
                       onfocus="comentario(document.getElementById('logoImg'),'Ver');"
                       onblur="comentario(document.getElementById('logoImg'),'Ocultar');" /><br/>
                <span class="nombreCampo" id="txt_file">El documento debe ser JPG, PNG y no superior a 100 kB</span><br/>
              <br/>
              </div>
          </td>
          <td colspan="2">
              <div id="logoEmp">
                  <span id="img_file">
                      <?php if(isset($datosEmpresa)){echo '<img id="imagen" height="70" width="140" src="../images/'.$datosEmpresa['Logo'].'" />';} ?>
                  </span><br/>
              </div>
          </td>
          <td colspan="2">
              <div id="logoImg" class="cuadrosConfiguracion" style="display:none;">
                  <label class="nombreCampo">Logo de la empresa (El tamaño debe ser de 140x70 pixeles o proporcional a este formato 2 H : 1 V)</label>
              </div>
          </td>
        </tr>
        <tr>
            <td height="15px"></td>
        </tr>
        <tr>
          <td></td>
          <td colspan="2">
              <div align="left"> 
                <br/>
                <label class="nombreCampo">Titulo del Presupuesto</label>
                <select name="tituloPrep"
                        onfocus="comentario(document.getElementById('tituloPrepTxt'),'Ver');" 
                        onblur="comentario(document.getElementById('tituloPrepTxt'),'Ocultar');">
                    <option value="presupuesto" <?php if($datosEmpresa['Titulo Presupuesto']==='presupuesto'){echo 'selected';}?>>Presupuesto</option>
                    <option value="oferta" <?php if($datosEmpresa['Titulo Presupuesto']==='oferta'){echo 'selected';}?>>Oferta</option>
                </select>
              <br/>
              </div>
          </td>
          <td colspan="4">
              <div id="tituloPrepTxt" class="cuadrosConfiguracion" style="display:none;">
                  <label class="nombreCampo">Nombre para el titulo del presupuesto</label>
              </div>
          </td>
        </tr>
        <tr> 
          <td></td>
          <td colspan="5"> 
              <div align="left">
              <label class="nombreCampo">Texto a pie de página</label>

              <textarea class="textbox1area" name="txtPie" rows=4 
                      cols="20" onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                      onfocus="onFocusInputText(this);comentario(document.getElementById('txtPieCom'),'Ver');"
                      onblur="onBlurInputText(this);comentario(document.getElementById('txtPieCom'),'Ocultar');"
                      ><?php if(isset($datosEmpresa)){echo $datosEmpresa['Texto Pie'];} ?></textarea> 
              </div>
              <br/>
          </td>
          <td colspan="3">
              <div id="txtPieCom" class="cuadrosConfiguracion" style="display:none;">
                  <label class="nombreCampo">Texto que saldrá en el pié de la página del presupuesto y factura</label>
              </div>
          </td>
        </tr>
        <tr>
          <td></td>
          <td colspan="6">
              <div align="left"> 
                <br/>
                <label class="nombreCampo">Si emite facturas con retención IRPF, escoja el tipo</label>
                <select name="tipoIRPF">
                    <option value="0" <?php if($datosEmpresa['Tipo IRPF']==='0'){echo 'selected';}?>>NO</option>
                    <option value="9" <?php if($datosEmpresa['Tipo IRPF']==='9'){echo 'selected';}?>>9</option>
                    <option value="14" <?php if($datosEmpresa['Tipo IRPF']==='14'){echo 'selected';}?>>14</option>
                    <option value="19" <?php if($datosEmpresa['Tipo IRPF']==='19'){echo 'selected';}?>>19</option>
                    <option value="19.5" <?php if($datosEmpresa['Tipo IRPF']==='19.5'){echo 'selected';}?>>19.5</option>
                    <option value="20" <?php if($datosEmpresa['Tipo IRPF']==='20'){echo 'selected';}?>>20</option>
                    <option value="21" <?php if($datosEmpresa['Tipo IRPF']==='21'){echo 'selected';}?>>21</option>
                </select>
              <br/>
              </div>
          </td>
        </tr>
        <tr>
            <td height="15px"></td>
        </tr>
        <tr>
            <td></td>
            <td>
              <div align="left">
                <script>
                function verImgFactura(fichero){
                    window.open ("../images/"+fichero,"nueva","resizable=yes, scrollbars=yes, width=650,height=450");
                }
                
                function cambiarImg(objeto){
                    $.ajax({
                      data:{"IdTipo":objeto.value},  
                      url: '../vista/buscarFicheroTipoFactura.php',
                      type:"get",
                      success: function(data) {
                        //actualizamos el fichero a ver del select
                        document.form1.imgTextFicheroHidden.value = data;
                      }
                    });
                }
                </script>  
              <label class="nombreCampo">Tipo Factura</label>
              <select class="textbox1" name="FacturaTipo" onMouseOver="onMouseOverInputText(this);" 
                      onMouseOut="onMouseOutInputText(this);" onchange="cambiarImg(this);">
                  <?php
                  echo listadoTiposFactura($datosEmpresa['Factura Tipo']);
                  ?>
              </select>
              </div>
            </td>
            <td></td>
            <td colspan="2">
                <?php
                //buscar imagen
                $nombreFichero = $clsCNContabilidad->nombreFacturaFichero($datosEmpresa['Factura Tipo']);
                ?>
                <img id="imgTipoFichero" height="30" width="30" src="../images/kview.png" 
                     onclick="verImgFactura(document.form1.imgTextFicheroHidden.value);" />
                <input type="hidden" name="imgTextFicheroHidden" value="<?php echo $nombreFichero; ?>" />
            </td>
        </tr>
        <tr>
            <td height="15px"></td>
        </tr>
        <tr>
          <td></td>
          <td colspan="5">
              <div align="left"> 
                  <label class="nombreCampo">Utilizar la Base de Datos de Artículos</label>
                  <input type="checkbox" name="checkArticulo" onclick="actualizaHiddenEstado(this,document.form1.articulo);" <?php if(isset($datosEmpresa['articulo'])){if($datosEmpresa['articulo']==='on'){echo 'checked';}} ?> />
                  <input type="hidden" name="articulo" value="<?php if(isset($datosEmpresa['articulo'])){echo $datosEmpresa['articulo'];} ?>" />
              </div>
          </td>
        </tr>
        <tr>
            <td height="15px"></td>
        </tr>
        <tr>
          <td></td>
          <td colspan="3">
              <div align="left"> 
                  <script>
                  function cambioCuentaContable(objeto,objHidden){
                      objHidden.value=objeto.value;
                  }    
                  </script>  
                <label class="nombreCampo">Cuenta Contable de Ventas</label>
                <select class="textbox1" name="" onchange="cambioCuentaContable(this,document.form1.cuentaContable);">
                <?php
                $listadoCuentasContables = $clsCNContabilidad->listarCuentasArticulos();
                //preparo el listado
                for ($i = 0; $i < count($listadoCuentasContables); $i++) {
                    $selected='';
                    if($datosEmpresa['cuentaContable']===$listadoCuentasContables[$i]['NumCuenta']){
                        $selected='selected';
                    }
                    echo"<option value='".$listadoCuentasContables[$i]['NumCuenta']."' ".$selected.">".$listadoCuentasContables[$i]['cuenta']."</option>";
                }
                ?>
                </select>
                <input type="hidden" name="cuentaContable" value="<?php echo $datosEmpresa['cuentaContable']; ?>" />
<!--                <input class="textbox1" type="text" name="cuentaContable" id="cuentaContable"
                       onKeyUp="comprobarCuenta(this,document.getElementById('okCuentaContable'));"  
                       value="<?php //if(isset($datosEmpresa['cuentaContable'])){echo $datosEmpresa['cuentaContable'];} ?>"
                       onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" 
                       onfocus="onFocusInputText(this);desactivaCampoComprobacionCuenta(document.getElementById('okCuentaContable'));" 
                       onblur="onBlurInputText(this);comprobarCuentaBlur(this,document.getElementById('okCuentaContable'));" />-->
              <br/>
              </div>
          </td>
          <td colspan="2">
              <div id="cuadroCuentaContable" class="cuadrosConfiguracion" style="display:none;">
                  <label class="nombreCampo">Cuenta Contable por defecto para los artículos</label>
              </div>
          </td>
        </tr>
        <tr>
            <td height="15px"></td>
        </tr>
        <tr>
          <td></td>
          <td colspan="2">
              <div align="left"> 
                <label class="nombreCampo">Código de Empresa</label>
                <input class="textbox1" type="text" name="codigoEmpresa" maxlength="5" value="<?php if(isset($datosEmpresa)){echo $datosEmpresa['codigoEmpresa'];} ?>"
                       onfocus="comentario(document.getElementById('codigoEmpresa'),'Ver');" onblur="comentario(document.getElementById('codigoEmpresa'),'Ocultar');" />
              <br/>
              </div>
          </td>
          <td colspan="2">
              <div id="codigoEmpresa" class="cuadrosConfiguracion" style="display:none;">
                  <label class="nombreCampo">Código de Empresa para el fichero 'Contabil.Mdb'</label>
              </div>
          </td>
        </tr>
        
        
        <tr>
            <td height="15px"></td>
        </tr>
        <tr>
        <script>
        function autorizacion(objeto){
            if(objeto.checked===true){
                document.form1.cmdAlta.setAttribute("class", "button");
                document.form1.cmdAlta.disabled=false;
            }else{
                document.form1.cmdAlta.setAttribute("class", "buttonDesactivado");
                document.form1.cmdAlta.disabled=true;
            }
        }
        </script>
            <td>
                <input type="checkbox" name="chkAutorizacion" onclick="autorizacion(this);" />
            </td>
          <td colspan="6">
              <div align="left"> 
                <br/>
                <label class="nombreCampo" onclick="autorizacion(this);">Declaro que todos los datos son ciertos bajo mi responsabilidad, y estoy autorizado a utilizar las direcciones de e-mail para el envío de correos.</label>
              </div>
          </td>
        </tr>
        
        
        <tr>
            <td height="15px"></td>
        </tr>
      </table>
        
        
      <P>
        <input type="button" name="cmdAlta" id="cmdAlta" class="buttonDesactivado" value = "Guardar" onclick="javascript:validar2();" disabled="true" />
        <input type="hidden" name="opcion" value="false" />
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

<!--    
    Este addEventListener es para el input de fichero id=doc
    asi puede uno cargar la imagen en donde esta el logo
-->
<script language="JavaScript">
  function handleFileSelect(evt) {
    var files = evt.target.files; // FileList object

    // Loop through the FileList and render image files as thumbnails.
    for (var i = 0, f; f = files[i]; i++) {

      // Only process image files.
      if (!f.type.match('image.*')) {
        continue;
      }

      var reader = new FileReader();

      // Closure to capture the file information.
      reader.onload = (function(theFile) {
        return function(e) {
          // Render thumbnail.
          var span = document.getElementById('img_file');
          span.innerHTML = ['<img width="140" height="70" src="', e.target.result,
                            '" title="', escape(theFile.name), '"/>'].join('');
        };
      })(f);

      // Read in the image file as a data URL.
      reader.readAsDataURL(f);
    }
  }

  document.getElementById('doc').addEventListener('change', handleFileSelect, false);

</script>

</body>
</html>
<?php
}//fin del else principal
?>