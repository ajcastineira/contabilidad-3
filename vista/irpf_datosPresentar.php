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


//NO FUNCIONA 26/2/2014
//funcion de envio de correo al cliente con el envio del impuesto
function enviarCorreoNO($to,$file){
    $from = "soporte@qualidad.com";
    $subject = 'Tramitación del impuesto I.R.P.F.';

    $semi_rand = md5(time());
    $mime_boundary = "==TecniBoundary_x{$semi_rand}x";

    $headers = "From: $from";
    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";

    $message = "Este correo contiene el fichero adjunto para la tramitación del impuesto del IRPF 111 a la Agencia Tributaria";
    $message =$message. "\n";
    $message =$message. "\nDepartamento de Calidad\n";
    $message =$message. '<IMG SRC="https://www.qualidad.es/contabilidad/images/logo-'.$_SESSION['base']. '.jpg" BORDER="0">';
    $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"utf-8\"\r\n" .
    "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n";

    $fp = fopen($file, "rb");
    $data = fread($fp, filesize($file));
    fclose($fp);
    $data = chunk_split(base64_encode($data));
    
    $message .= "--{$mime_boundary}\r\n";
    $message .= "Content-Type: application/octet-stream; name=\"" . basename($file). "\"\r\n" . "Content-Transfer-Encoding: base64\r\n" . $data . "\r\n" . "Content-Disposition: attachment\r\n";

    $message .= "--{$mime_boundary}--";
    if(mail($to, $subject, $message, $headers)){
        logger('traza','irpf_datosPresentar.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
               " enviarCorreo()<TRUE: Enviado correcto. Volvemos a presentar_irpf.php");
        return true;
    }else{
        logger('traza','irpf_datosPresentar.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
               " enviarCorreo()<FALSE: NO Enviado correcto. Volvemos a presentar_irpf.php");
        return false;
    }
}    

//funcion de envio de correo al cliente con el envio del impuesto
function enviarCorreo($to,$file){
    require '../general/phpmailer/PHPMailerAutoload.php';

    $mail = new PHPMailer();
    //Correo desde donde se envía (from)
    $mail->setFrom('soporte@qualidad.com', 'Qualidad');
    //Correo de envío (to)
    $mail->addAddress($to, '');
    $mail->CharSet = "UTF-8";
    $mail->Subject = 'Tramitación del impuesto I.R.P.F.';
    
    $html='<!DOCTYPE html>
            <html>
                <head>
                    <title>Tramitación del impuesto I.R.P.F.</title>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width">
                </head>
                <body>
                    <div>Este correo contiene el fichero adjunto para la tramitación del impuesto del IRPF 111 a la Agencia Tributaria</div>
                    <IMG SRC="https://www.qualidad.es/contabilidad/images/logo-'.$_SESSION['base']. '.jpg" width="132" alt="67" BORDER="0">
                </body>
            </html>';
    
    //Lee un HTML message body desde un fichero externo,
    //convierte HTML un plain-text básico 
    $mail->msgHTML($html);
    //Reemplaza al texto plano del body
    $mail->AltBody = 'Fichero tramitación IRPF';
    //incluye el fichero adjunto
    $mail->addAttachment($file);

    if (!$mail->send()) {
        logger('traza','irpf_datosPresentar.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
               " enviarCorreo()<FALSE: NO Enviado correcto. Volvemos a presentar_iva.php");
        return false;
    } else {
        logger('traza','irpf_datosPresentar.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
               " enviarCorreo()<TRUE: Enviado correcto. Volvemos a presentar_iva.php");
        return true;
    }
}



//codigo principal

//calculo los datos para presentar en pantalla el IRPF
//si vienen por GET cojo los datos del GET
if(isset($_GET['lngEjercicio'])){
    if(isset($_GET['datosIRPF'])){
        $datosIRPF = stripslashes($_GET['datosIRPF']); 
        $datosIRPF = urldecode($datosIRPF); 
        $datosIRPF = unserialize($datosIRPF);
    }
    $lngEjercicio=$_GET['lngEjercicio'];
    
    //calculamos los datos a presentar
    if($_GET['cmdCierre']=='Cierre 1T' || $_GET['cmdCierre']=='1T'){
        $Periodo='1T';
    }else if($_GET['cmdCierre']=='Cierre 2T' || $_GET['cmdCierre']=='2T'){
        $Periodo='2T';
    }else if($_GET['cmdCierre']=='Cierre 3T' || $_GET['cmdCierre']=='3T'){
        $Periodo='3T';
    }else if($_GET['cmdCierre']=='Cierre 4T' || $_GET['cmdCierre']=='4T'){
        $Periodo='4T';
    }
}else if(isset($_POST['Ejercicio'])){
    if(isset($_POST['datosIRPF'])){
        $datosIRPF = stripslashes($_POST['datosIRPF']); 
        $datosIRPF = urldecode($datosIRPF); 
        $datosIRPF = unserialize($datosIRPF);
        $lngEjercicio=$_POST['Ejercicio'];
    }
}

//print_r($datosPresentar);die;

//a pulsado en 'Aceptar'
if(isset($_POST['cmdAlta']) && $_POST['cmdAlta']=='Aceptar'){
    logger('info','irpf_datosPresentar.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
           " ||||Consultas->I.R.P.F.|| Calculados (Aceptar)");

    //print_r($_POST);die;
    //guardamos estos datos en la tabla tbiva
    logger('traza','irpf_datosPresentar.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
           " clsCNContabilidad->guardarTrimestreIRPF(".$_POST['Ejercicio'].",".$_POST['Trimestre'].",".$_POST['casilla02'].",
                                         ".$_POST['casilla03'].",".$_POST['casilla08'].",".$_POST['casilla09'].")>");
    $varRes=$clsCNContabilidad->guardarTrimestreIRPF($_POST['Ejercicio'],$_POST['Trimestre'],$_POST['casilla02'],
                                         $_POST['casilla03'],$_POST['casilla08'],$_POST['casilla09']);

    if($varRes<>1){
        logger('traza','irpf_datosPresentar.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
               " clsCNContabilidad->guardarTrimestreIRPF()<FALSE: No se ha guardado el trimestre");
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/error.php?id='.$varRes.'">';
    }else{
        logger('traza','irpf_datosPresentar.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
               " clsCNContabilidad->guardarTrimestreIRPF()<TRUE: Se ha guardado el trimestre");
        //guardo los datos del banco (los que vengan)
//        $datosBancarios=array(
//            'SeDomicilia'=>$_POST['SeDomicilia'],
//            'SinActividad'=>$_POST['SinActividad'],
//            'cuentaBanco_Entidad'=>$_POST['cuentaBanco_Entidad'],
//            'cuentaBanco_Oficina'=>$_POST['cuentaBanco_Oficina'],
//            'cuentaBanco_DC'=>$_POST['cuentaBanco_DC'],
//            'cuentaBanco_NCuenta'=>$_POST['cuentaBanco_NCuenta'],
//        );
        //guardo en un fichero de texto extension .111 el impuesto para presentar
        logger('traza','irpf_datosPresentar.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
               ' clsCNContabilidad->generarFicheroIRPF($_POST)>');
        // a la administracion en la carpeta ..impuestos/
        $datos=$clsCNContabilidad->generarFicheroIRPF($_POST);
        //Si viene sin $datos, redirecciono a la pagina de exito, no hay que enviar fichero a su correo
//        print_r($datos);die;
        if($datos==''){
            logger('traza','irpf_datosPresentar.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
                   ' $datos esta vacia: no hay que enviar fichero por correo. Se va a exito');
            echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/exito.php">';
        }else{
            logger('traza','irpf_datosPresentar.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
                   ' $datos NO esta vacia: HAY que enviar fichero por correo.');
            
            //envio por correo el fichero
            logger('traza','irpf_datosPresentar.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
                   " enviarCorreo(".$datos['url'].")>");

            //extraigo los datos del usuario para saber el correo al que enviar
            $datosUsuario=$clsCNUsu->DatosUsuario($_SESSION['usuario']);

            $enviado=enviarCorreo($datosUsuario['strCorreo'],$datos['url']);

            if($enviado==true){
                echo "<META HTTP-EQUIV=Refresh CONTENT='0; URL=../vista/exito.php'>";
            }else{
                echo "<META HTTP-EQUIV=Refresh CONTENT='0; URL=../vista/error.php?id=No se envio el correo al usuario'>";
            }
        }
    }
}
else{//comienzo del else principal
    logger('info','irpf_datosPresentar.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
           " ||||Consultas->I.R.P.F.|| Calculados");
    $datosUsuario=$clsCNUsu->DatosUsuario($_SESSION['usuario']);
    
    //ahora calculo los datos de los profesionales (clave G en la tabla 'tbretenciones_irpf')
    $PerceptoresIRPF_G=$clsCNContabilidad->PerceptoresIRPF($lngEjercicio,$Periodo,'G');

    //ahora calculo los datos de las nominas (clave A en la tabla 'tbretenciones_irpf')
    $PerceptoresIRPF_A=$clsCNContabilidad->PerceptoresIRPF($lngEjercicio,$Periodo,'A');

    //por ultimo preparo el array de presentacion de resultados
    $datosPresentar=array(
        'IRPF_ClaveA'=>array(
                        'Base'=>$datosIRPF['BaseA'],
                        'Retenciones'=>$datosIRPF['RetencionesA'],
                        'Perceptores'=>$PerceptoresIRPF_A,
                        ),
        'IRPF_ClaveG'=>array(
                        'Base'=>$datosIRPF['BaseG'],
                        'Retenciones'=>$datosIRPF['RetencionesG'],
                        'Perceptores'=>$PerceptoresIRPF_G,
                        )
    );

    //print_r($datosPresentar);die;
    
    html_pagina($lngEjercicio,$Periodo,$datosPresentar,$datosUsuario);
}

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
<TITLE>Autoliquidación. Impuesto Retención Personas Físicas</TITLE>

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
    if (confirm("¿Va a cerrar este periodo?. Esto implica que no pueda modificar ni dar de alta ningún asiento que incluya cuenta "+
                "de IRPF con fecha que este comprendida en este periodo"))
    {
        objeto.submit();
    }
}

function entradaCantidad(objeto){
    objeto.value='';
}

function actualizaCasilla30(casilla03,casilla09){
    var numCasilla03=desFormateaNumeroContabilidad(casilla03);
    var suma=parseFloat(numCasilla03)+parseFloat(casilla09);
    suma=Math.round(suma*100)/100;
    document.form1.casilla30.value=suma;
    document.form1.casilla30.value=formateaNumeroContabilidad(document.form1.casilla30.value);
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
//    eventosInputText();
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
$tituloForm='AUTOLIQUIDACIÓN<br/>IMPUESTO RETENCIÓN PERSONAS FÍSICAS';
$cabeceraNumero='030201';
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
    <form name="form1" method="post" action="../vista/irpf_datosPresentar.php">

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
          <td class="subtitulo" colspan="11">&nbsp;I. Rendimientos del trabajo</td>
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
                <label>Nº Perceptores</label>
            </td>
            <td></td>
            <td>
                <label>Base</label>
            </td>
            <td></td>
            <td>
                <label>Retenciones</label>
            </td>
            <td></td>
        </tr>
        
        <tr>
            <td>
                <label><div align="right">01</div></label>
            </td>
            <td>    
                <input class="textbox1" type="text" style="text-align:right;"
                       name="casilla01" value="<?php echo $datosPresentar['IRPF_ClaveA']['Perceptores'];?>" 
                       onkeypress="return solonumeros(event);"
                       onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                       onfocus="onFocusInputText(this);entradaCantidad(this);" onblur="onBlurInputText(this);" />
            </td>
            <td>
                <label><div align="right">02</div></label>
            </td>
            <td>    
                <input class="textbox1" type="text"
                       name="casilla02" value="<?php echo $datosPresentar['IRPF_ClaveA']['Base'];?>" 
                       onkeypress="return solonumeros(event);" style="text-align:right;"
                       onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                       onfocus="onFocusInputText(this);entradaCantidad(this);" onblur="onBlurInputText(this);formateaCantidad(this);" />
            </td>
            <td>
                <label><div align="right">03</div></label>
            </td>
            <td>
                <?php
                $casilla03=desFormateaNumeroContabilidad($datosPresentar['IRPF_ClaveA']['Retenciones']);
                $casilla09=desFormateaNumeroContabilidad($datosPresentar['IRPF_ClaveG']['Retenciones']);
                $casilla30=$casilla03+$casilla09;
                ?>
                <input class="textbox1" type="text"
                       name="casilla03" value="<?php echo $datosPresentar['IRPF_ClaveA']['Retenciones'];?>" 
                       onchange="actualizaCasilla30(this.value,<?php echo $casilla09;?>);"
                       onkeypress="return solonumeros(event);" style="text-align:right;"
                       onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                       onfocus="onFocusInputText(this);entradaCantidad(this);"
                       onblur="onBlurInputText(this);
                               formateaCantidad(this);
                               actualizaCasilla30(this.value,<?php echo $casilla09;?>);" />
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
          <td class="subtitulo" colspan="11">&nbsp;II. Rendimientos de Actividades Económicas</td>
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
                <label>Nº Perceptores</label>
            </td>
            <td></td>
            <td>
                <label>Base</label>
            </td>
            <td></td>
            <td>
                <label>Retenciones</label>
            </td>
            <td></td>
        </tr>
        
        <tr>
            <td>
                <label><div align="right">07</div></label>
            </td>
            <td>    
                <input class="textbox1" type="text" style="text-align:right;"
                       name="casilla07" value="<?php echo $datosPresentar['IRPF_ClaveG']['Perceptores'];?>" readonly />
            </td>
            <td>
                <label><div align="right">08</div></label>
            </td>
            <td>    
                <input class="textbox1" type="text" style="text-align:right;"
                       name="casilla08" value="<?php echo $datosPresentar['IRPF_ClaveG']['Base'];?>" readonly />
            </td>
            <td>
                <label><div align="right">09</div></label>
            </td>
            <td>
                <input class="textbox1" type="text" style="text-align:right;"
                       name="casilla09" value="<?php echo $datosPresentar['IRPF_ClaveG']['Retenciones'];?>" readonly />
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
            <td width="15%"></td>
            <td width="20%"></td>
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
                <label>Resultado a Ingresar</label>
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
                <label><div align="right">30</div></label>
            </td>
            <td>
                <input class="textbox1" type="text" style="text-align:right;" readonly
                       name="casilla30" value="<?php echo formateaNumeroContabilidad($casilla30); ?>" />
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
          <td class="subtitulo" colspan="11">&nbsp;</td>
        </tr>
        <tr>
            <td height="15px"></td>
        </tr>
        <tr>
            <td width="5%"></td>
            <td width="50%"></td>
            <td width="10%">Entidad</td>
            <td width="10%">Oficina</td>
            <td width="5%">DC</td>
            <td width="20%">Número de Cuenta</td>
        </tr>
        
        <tr>
            <td>
                <input type="checkbox" onclick="activaCampoCBanco(this);"/>
                <input type="hidden" name="SeDomicilia" value="NO" />
            </td>
            <td>
                <label class="nombreCampo">Domiciliación Pago en Banco</label>
            </td>
            <td>
                <input class="textbox1" name="cuentaBanco_Entidad" type="text" maxlength="4" 
                       onkeypress="return solonumeros(event);" style="text-align:right;" disabled />
            </td>
            <td>
                <input class="textbox1" name="cuentaBanco_Oficina" type="text" maxlength="4" 
                       onkeypress="return solonumeros(event);" style="text-align:right;" disabled />
            </td>
            <td>
                <input class="textbox1" name="cuentaBanco_DC" type="text" maxlength="2" 
                       onkeypress="return solonumeros(event);" style="text-align:right;" disabled />
            </td>
            <td>
                <input class="textbox1" name="cuentaBanco_NCuenta" type="text" maxlength="10" 
                       onkeypress="return solonumeros(event);" style="text-align:right;" disabled />
            </td>
        </tr>
        <tr>
            <td>
                <?php
                //si los datos de estos campos estan a 0, se activa esta casilla
                if($datosPresentar['IRPF_ClaveG']['Base']==='0,00' && $datosPresentar['IRPF_ClaveG']['Retenciones']==='0,00'){
                ?>
                <input type="checkbox" onclick="Actividad(this);" />
                <?php
                }else{
                ?>
                <input type="checkbox" disabled/>
                <?php
                }
                ?>
                <input type="hidden" name="SinActividad" value="NO" />
            </td>
            <td>
                <label class="nombreCampo">Sin Actividad</label>
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
        
      <table width="640" border="0" class="zonaactiva">
          <tr>
            <td width="30%"></td>
            <td width="15%"></td>
            <td width="5%"></td>
            <td width="15%"></td>
            <td width="30%"></td>
          </tr>
          
          <tr>
              <td colspan="5">
                  <div align="center">
                    <input type="checkbox" name="chkTransmitir" onclick="Transmitir(this);" />
                    <label class="nombreCampo">Desea Transmitir la liquidación de I.R.P.F.</label>
                  </div>
              </td>
          </tr>

          <tr>
              <td></td>
              <td>
                  <input type="button" class="button" id="cmdAlta" value = "Aceptar" tabindex="11" onclick="submitir(document.form1);" /> 
                  <input type="hidden" name="Ejercicio" value="<?php echo $lngEjercicio; ?>" />
                  <input type="hidden" name="Trimestre" value="<?php echo $Periodo; ?>" />
                  <input type="hidden" name="cmdAlta" value="Aceptar" />
                  <input type="hidden" name="TransmitoImp" value="NO" />
              </td>
              <td></td>
              <td>
                  <a href="../vista/presentar_irpf.php"><input type="button" class="buttonAzul" value="Volver" /></a>
              </td>
              <td></td>
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