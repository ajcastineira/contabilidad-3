<?php
session_start ();
require_once '../CN/clsCNContabilidad.php';
require_once '../general/funcionesGenerales.php';
require '../general/phpmailer/PHPMailerAutoload.php';

$clsCNContabilidad=new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['dbContabilidad']);
$clsCNContabilidad->setStrBDCliente($_SESSION['mapeo']);

logger('traza',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
       " Comienza Envio Correo.");

$content  = nl2br($_POST['msg']);
$datosPresupuesto=$clsCNContabilidad->datosPresupuesto($_POST['IdPresupuesto']);

$to = $_POST['email'];
$Cc=$_POST['emailCC'];
$from=$clsCNContabilidad->ParametrosGenerales_email();
$subject = 'Presupuesto '.$datosPresupuesto['NumPresupuesto'].' ['.$datosPresupuesto['NombreEmpresa'].']';

$ejercicio=substr($datosPresupuesto['NumPresupuestoBBDD'],0,4);
$numero=substr($datosPresupuesto['NumPresupuestoBBDD'],4,4);
//$file="../presupuestosEnviados/Presupuesto_".$_SESSION['idEmp'].'-'.$ejercicio.'-'.$numero.".pdf";
$file="../presupuestosEnviados/Presupuesto_".$_SESSION['idEmp'].'-'.$datosPresupuesto['NumPresupuestoBBDD'].".pdf";

$mail = new PHPMailer();
//Correo desde donde se envía (from)
$mail->setFrom($from, '');
//Correo de envío (to)
$mail->addAddress($to, '');
$mail->addBCC($from);
        
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
                <div>Estimado Cliente: <br/>
                        Adjuntamos nuestro presupuesto indicado en el encabezamiento, esperando sea de su conformidad.
                        Para cualquier aclaración, puede contactar con nosotros, por los medios habituales.<br/>
                        Saludos
                </div><br/><br/>
                <i>'.$content.'</i><br/><br/>
                <b>'.$_SESSION['strSesion'].'</b><br/>    
                <IMG SRC="https://www.qualidad.es/contabilidad/images/logo-'.$_SESSION['base']. '.JPG" width="140" height="70" BORDER="0">
            </body>
        </html>';

//Lee un HTML message body desde un fichero externo,
//convierte HTML un plain-text básico 
$mail->msgHTML($html);
//Reemplaza al texto plano del body
$mail->AltBody = 'Presupuesto';
//incluye el fichero adjunto
$mail->addAttachment($file);

if (!$mail->send()) {
    logger('traza',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['srtBD'].', SesionID: '.  session_id().
           " Correo NO Enviado.");
} else {
    logger('traza',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['srtBD'].', SesionID: '.  session_id().
           " Correo Enviado CORRECTAMENTE.");
}

if(isset($_SESSION['presupuestoActivo']['IdPresupuesto'])){
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/altapresupuesto.php?IdPresupuesto='.$_SESSION['presupuestoActivo']['IdPresupuesto'].'">';die;
}else{
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/altapresupuesto.php?IdPresupuesto='.$_POST['IdPresupuesto'].'">';die;
}
?>