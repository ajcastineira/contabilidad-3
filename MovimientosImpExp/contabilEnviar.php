<?php
session_start ();
require_once '../CN/clsCNContabilidad.php';
require_once '../general/funcionesGenerales.php';
require '../general/phpmailer/PHPMailerAutoload.php';

$clsCNContabilidad=new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['dbContabilidad']);
$clsCNContabilidad->setStrBDCliente($_SESSION['mapeo']);

//genero el zip
$clsCNContabilidad->archivoZIP();

logger('traza',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['srtBD'].', SesionID: '.  session_id().
       " Comienza Envio Correo.");

$content  = nl2br($_POST['msg']);
//$datosPresupuesto=$clsCNContabilidad->datosPresupuesto($_POST['IdPresupuesto']);

$to = $_POST['email'];
$Cc=$_POST['emailCC'];
$from=$clsCNContabilidad->ParametrosGenerales_email();
$subject = "Fichero Contabil.zip ";

//$ejercicio=substr($datosPresupuesto['NumPresupuestoBBDD'],0,4);
//$numero=substr($datosPresupuesto['NumPresupuestoBBDD'],4,4);
$file="../MovimientosImpExp/contabil.zip";

$mail = new PHPMailer();
//Correo desde donde se envía (from)
$mail->setFrom($from, '');
//Correo de envío (to)
$mail->addAddress($to, '');
if($Cc<>''){
    $mail->addAddress($Cc, '');
}
$mail->CharSet = "UTF-8";
$mail->Subject = $subject;

$html='<!DOCTYPE html>
        <html>
            <head>
                <title>Presupuesto</title>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width">
            </head>
            <body>
                <div>Este correo contiene el fichero adjunto contabil.zip</div>
                <IMG SRC="http://www.qualidad.es/contabilidad/images/logo-'.$_SESSION['base']. '.jpg" width="132" height="67" BORDER="0">
            </body>
        </html>';

//Lee un HTML message body desde un fichero externo,
//convierte HTML un plain-text básico 
$mail->msgHTML($html);
//Reemplaza al texto plano del body
$mail->AltBody = 'Contabil.Mdb';
//incluye el fichero adjunto
$mail->addAttachment($file);

if (!$mail->send()) {
    logger('traza',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['srtBD'].', SesionID: '.  session_id().
           " Correo NO Enviado.");
} else {
    logger('traza',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['srtBD'].', SesionID: '.  session_id().
           " Correo Enviado CORRECTAMENTE.");
}


echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/default2.php">';die;

?>