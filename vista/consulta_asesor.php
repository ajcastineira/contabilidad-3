<?php
session_start ();

require_once '../CN/clsCNContabilidad.php';
require_once '../CN/clsCNConsultas.php';
require_once '../CN/clsCNUsu.php';
require_once '../general/funcionesGenerales.php';
require_once '../vista/consulta_asesor_html_funciones.php';

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



$clsCNConsultas=new clsCNConsultas();
$clsCNConsultas->setStrBD($_SESSION['dbContabilidad']);
$clsCNUsu=new clsCNUsu();
$clsCNUsu->setStrBD($_SESSION['dbContabilidad']);

$datosUsuarioActivo=$clsCNUsu->DatosUsuario($_SESSION['usuario']);

//CORREO DE LOS USUARIOS QUE RECIBEN LOS ASESORES (1 correo)
//CORREO DE CONFIRMACIÓN A LOS USUARIOS QUE ENVÍAN CONSULTAS (1 correo)
function EnviaCorreoAlAsesor($Usuario,$Asesor,$estadoPregunta,$strMail,$MailUsuario,$strConsulta){
    require '../general/phpmailer/PHPMailerAutoload.php';
    
    //CORREO DE LOS USUARIOS QUE RECIBEN LOS ASESORES (1 correo)
    $from="asesor@qualidad.es";
    $to=$strMail;

    $mail = new PHPMailer();
    //Correo desde donde se envía (from)
    $mail->setFrom($from, '');
    //Correo de envío (to)
    $mail->addAddress($to, '');
    $mail->CharSet = "UTF-8";
    $mail->Subject = "Consulta plataforma gestión online";

    $html='<!DOCTYPE html>
            <html>
                <head>
                    <title>Q-Conta</title>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width">
                </head>
                <body>
                    <div>Pregunta enviada por: '.$Usuario.' de '.$_SESSION['sesion'].'</div>
                    <div>Estado: '.$estadoPregunta.' </div><br/>
                    <div>Consulta: '.$strConsulta.'</div><br/>
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
    
    //CORREO DE CONFIRMACIÓN A LOS USUARIOS QUE ENVÍAN CONSULTAS (1 correo)
    $from="asesor@qualidad.es";
    $to=$MailUsuario;

    $mail = new PHPMailer();
    //Correo desde donde se envía (from)
    $mail->setFrom($from, '');
    //Correo de envío (to)
    $mail->addAddress($to, '');
    $mail->CharSet = "UTF-8";
    $mail->Subject = "Consulta plataforma gestión online";

    $html='<!DOCTYPE html>
            <html>
                <head>
                    <title>Q-Conta</title>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width">
                </head>
                <body>
                    <div>Realizada por: '.$Usuario.' de '.$_SESSION['sesion'].'</div>
                    <div>Consulta: '.$strConsulta.'</div><br/><br/><br/>
                    <div>
                        <p>Su mensaje se ha enviado correctamente. En breve recibirá la respuesta de su asesor.</p>
                        <p>Gracias por utilizar la plataforma de gestión online.</p>
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

//CORREO DE LOS ASESORES QUE RECIBEN LOS USUARIOS (1 correo)
function EnviaCorreoAlCliente($Usuario,$Asesor,$strMail,$strRespuesta){
    require '../general/phpmailer/PHPMailerAutoload.php';
    
    $from="asesor@qualidad.es";
    $to=$strMail;

    $mail = new PHPMailer();
    //Correo desde donde se envía (from)
    $mail->setFrom($from, '');
    //Correo de envío (to)
    $mail->addAddress($to, '');
    $mail->CharSet = "UTF-8";
    $mail->Subject = "Respuesta plataforma gestión online";

    $html='<!DOCTYPE html>
            <html>
                <head>
                    <title>Q-Conta</title>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width">
                </head>
                <body>
                    <div>Respuesta enviada por: '.$Asesor.'</div>
                    <div>Respuesta: '.$strRespuesta.'</div><br/><br/><br/>
                    <div>
                        <p>Esperamos haber resuelto sus dudas. Estamos a su disposición para ampliar cualquier información al respecto.</p>
                        <p>Gracias por utilizar la plataforma de gestión online</p>
                        <p>Qualidad Consulting de Sistemas, S.L.</p>
                    </div><br/>
                </body>
            </html>';

    //Lee un HTML message body desde un fichero externo,
    //convierte HTML un plain-text básico 
    $mail->msgHTML($html);
//    //Reemplaza al texto plano del body
//    $mail->AltBody = 'Presupuesto';

    if (!$mail->send()) {
        logger('traza',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['srtBD'].', SesionID: '.  session_id().
               " Correo NO Enviado.");
    } else {
        logger('traza',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['srtBD'].', SesionID: '.  session_id().
               " Correo Enviado CORRECTAMENTE.");
    }
}


//BORRAR

////comprobamos el navegador, si es IE8 o IE9 ponemos colores simples para los sombreados 

//////class="respBgColorAsesor" y class="respBgColorCliente"
//                  
//$ie8=strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 8.0');
//$ie9=strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 9.0');
//if($ie8 || $ie9){
//    //rescritura de las clases que afectan a los sombreados del listado
//    $htmlCSS='<style>';
//    
//    $htmlCSS=$htmlCSS.'.tablaComentarios tbody tr.impares{';
//    $htmlCSS=$htmlCSS.'background-color: #E1E9EF;}';
//    $htmlCSS=$htmlCSS.'.tablaComentarios tbody tr.pares{';
//    $htmlCSS=$htmlCSS.'background-color: #C9E0F2;}';
//    $htmlCSS=$htmlCSS.'.tablaComentarios tbody td.respBgColorCliente{';
//    $htmlCSS=$htmlCSS.'background-color: #E1E9EF;}';
//    $htmlCSS=$htmlCSS.'.tablaComentarios tbody td.respBgColorAsesor{';
//    $htmlCSS=$htmlCSS.'background-color: #C9E0F2;}';
//    
//    $htmlCSS=$htmlCSS.'</style>';
//}




//codigo principal
//comprobar si venimos de submitir alguna opcion
//si hemos submitido una consulta nueva venimos por $_POST['cmdAltaConsulta']=='Aceptar'
//esta opción solo la utiliza el cliente, al asesor le sale desactivado este formulario
if(isset($_POST['cmdAltaConsulta']) && $_POST['cmdAltaConsulta']=='Aceptar'){
    logger('info','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id(). 
           " ||||Comunicaciones->Consulta al Asesor|| Ha pulsado 'Guardar' una consulta");
    logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
           " Alta Consulta");
    //compiamos al servidor el fichero adjuntado, si hay
    $OK=null;
    //compruebo que no haya habido error
    if($_FILES['doc']['error']==1){
        logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " Ha habido error en la subida.");
        $errorFile='Error al subir el fichero. ';
        if($_SESSION['navegacion']==='movil'){
            html_paginaMobil('','',$datosUsuarioActivo);
        }else{
            html_pagina('','',$datosUsuarioActivo);
        }
    }else{
        if($_FILES['doc']['error'] !== 4 && $_FILES['doc']['name'] !== '' && $_FILES['doc']['type'] === 'application/pdf'){
            logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " Tiene fichero adjunto: ".$_FILES['doc']['name']);
            //le damos un nombre al fichero
            //este nombre consta del lngIdUsuario+fecha(año+mes+dia+hora+min+seg)
            date_default_timezone_set('Europe/Madrid');
            $nombre=$_SESSION['usuario'].date('YmdHis');
            $url="../doc/doc-".$_SESSION['base'].'/'.$nombre.'.pdf';
            //sino existe este directorio lo crea
            if(!file_exists("../doc/doc-".$_SESSION['base'])){
                mkdir("../doc/doc-".$_SESSION['base']);
            }
            //compruebo que no sea superior a 1 MB (1048576)
            if($_FILES['doc']['size']<1048576){
                logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " El fichero es menor de 1 MB: ".$_FILES['doc']['size']);
                //subo a la carpeta de doc-EMPRESA el fichero seleccionado
                if(move_uploaded_file($_FILES['doc']['tmp_name'], $url)){
                    logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                           " El fichero ".$_FILES['doc']['name'].' a sido subido correctamente al servidor');
                    //damos de alta la consulta del cliente
                    logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                           " Damos de alta en la BBDD la respuesta: clsCNConsultas->AltaPregunta(".$_SESSION['usuario'].",".$_POST['strConsulta'].",$url)>");
                    $OK = true;
                }else{
                    logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                           " El fichero ".$_FILES['doc']['name'].' NO a sido subido al servidor. Error en COPY');
                    $OK = false;
                    $IdPregunta=false;
                    $errorFile='Error al subir el fichero: '.$_FILES['doc']['name'];
                    if($_SESSION['navegacion']==='movil'){
                        html_paginaMobil($errorFile,'',$datosUsuarioActivo);
                    }else{
                        html_pagina($errorFile,'',$datosUsuarioActivo);
                    }
                }
            }else{
                logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " El fichero es mayor de 1 MB: ".$_FILES['doc']['size']);
                $errorFile=$_FILES['doc']['name'].': Este fichero supera 1MB de tamaño.';
                if($_SESSION['navegacion']==='movil'){
                    html_paginaMobil($errorFile,'',$datosUsuarioActivo);
                }else{
                    html_pagina($errorFile,'',$datosUsuarioActivo);
                }
            }
        }else
        //revisar si hay fichero "Foto" a adjuntar (foto)
        if($_FILES['foto']['error'] !== 4 && $_FILES['foto']['name'] !== '' && $_FILES['foto']['type'] === 'image/jpeg'){
            logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['base'].', SesionID: '.  session_id().
                   " Tiene fichero (foto) adjunto: ".$_FILES['foto']['name']);

            //genero el nombre del fichero 
            date_default_timezone_set('Europe/Madrid');
            $nombre=$_SESSION['usuario'].$_POST['cmdAltaRespuesta'].date('YmdHis');
            $url="../doc/doc-".$_SESSION['base'].'/'.$nombre.'.jpg';

            //sino existe este directorio lo crea
            if(!file_exists("../doc/doc-" . $_SESSION['base'])){
                mkdir("../doc/doc-" . $_SESSION['base']);
            }

            //subo a la carpeta de reclamacion el fichero seleccionado
            if(move_uploaded_file($_FILES['foto']['tmp_name'], $url)){
                logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['base'].', SesionID: '.  session_id().
                   " El fichero ".$_FILES['foto']['name'].' a sido subido correctamente al servidor');
                $OK = true;
            }else{
                logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['base'].', SesionID: '.  session_id().
                       " El fichero ".$_FILES['foto']['name'].' NO a sido subido al servidor. Error en move_uploaded_file');
                $OK = false;
                $errorFile='Error al subir el fichero: '.$_FILES['foto']['name'];
            }
        }else{//si no hay, insertamos
            logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " NO tiene fichero adjunto. ");
            logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " Damos de alta en la BBDD la respuesta: clsCNConsultas->AltaPregunta(".$_SESSION['usuario'].",".$_POST['strConsulta'].",'')>");
            $IdPregunta=$clsCNConsultas->AltaPregunta($_SESSION['usuario'],$_POST['strConsulta'],'');
        }
        
        if($OK === true){
            $IdPregunta=$clsCNConsultas->AltaPregunta($_SESSION['usuario'],$_POST['strConsulta'],$url);
        }
    }
    //si el alta de la pregunta ha sido correcta se envia un correo al asesor
    //extraigo los datos del asesor
    $Asesor=$clsCNUsu->DatosAsesor($_SESSION['idEmp']);
    $estadoPregunta=$clsCNConsultas->PreguntaEstado($IdPregunta);
    //envio el correo al asesor
    logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
           " Se envia correo al cliente: ".($datosUsuarioActivo['strNombre'].' '.$datosUsuarioActivo['strApellidos']));
    EnviaCorreoAlAsesor(($datosUsuarioActivo['strNombre'].' '.$datosUsuarioActivo['strApellidos']), $Asesor['Asesor'],$estadoPregunta, $Asesor['strCorreo'],$datosUsuarioActivo['strCorreo'], $_POST['strConsulta']);
    logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
           " Todo a sido correcto, nos redireccionamos a 'exito.php' ");
    if($IdPregunta<>false){
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/exito.php?Id=La consulta se ha guardado">';
    }
}else

//si hemos submitido una consulta nueva venimos por $_POST['cmdAltaRespuesta']
//esta opcion la pueden utilizar tanto el cliente como el asesor
//esto lo sabemos por la variable de control que ponemos en los formularios de respuestas POST[esAsesor]
if(isset($_POST['cmdAltaRespuesta'])){
    logger('info','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id(). 
           " ||||Comunicaciones->Consulta al Asesor|| Ha pulsado 'Guardar' una respuesta de una consulta");
    logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
           " Alta Respuesta");
    if($_POST['esAsesor']=='NO'){
        logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " Respuesta de Cliente");
        $OK=null;
        //compruebo que no haya habido error
        if($_FILES['docResp']['error']==1){
            logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " Ha habido error en la subida.");
            $errorFile='Error al subir el fichero. ';
            if($_SESSION['navegacion']==='movil'){
                html_paginaMobil($errorFile,'',$datosUsuarioActivo);
            }else{
                html_pagina($errorFile,'',$datosUsuarioActivo);
            }
        }else{
            if(!$_FILES['docResp']['error']==4 && $_FILES['docResp']['name'] !== '' && $_FILES['docResp']['type'] === 'application/pdf'){
                logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " Tiene fichero adjunto: ".$_FILES['docResp']['name']);
                //le damos un nombre al fichero
                //este nombre consta del lngIdUsuario+idPregunta+fecha(año+mes+dia+hora+min+seg)
                date_default_timezone_set('Europe/Madrid');
                $nombre=$_SESSION['usuario'].$_POST['cmdAltaRespuesta'].date('YmdHis');
                $url="../doc/doc-".$_SESSION['base'].'/'.$nombre.'.pdf';
                //sino existe este directorio lo crea
                if(!file_exists("../doc/doc-".$_SESSION['base'])){
                    mkdir("../doc/doc-".$_SESSION['base']);
                }
                //compruebo que no sea superior a 1 MB (1048576)
                if($_FILES['docResp']['size']<1048576){
                    logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                           " El fichero es menor de 1 MB: ".$_FILES['docResp']['size']);
                    //subo a la carpeta de doc-EMPRESA el fichero seleccionado
                    if(move_uploaded_file($_FILES['docResp']['tmp_name'], $url)){
                        logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                               " El fichero ".$_FILES['docResp']['name'].' a sido subido correctamente al servidor');
                        //damos de alta la consulta del cliente
                        logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                               " Damos de alta en la BBDD la respuesta: clsCNConsultas->AltaRespuestaAPregunta(".$_SESSION['usuario'].",".$_POST['strRespuesta'].",".$_POST['cmdAltaRespuesta'].",$url)>");
                        $OK = true;
                    }else{
                        logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                               " El fichero ".$_FILES['docResp']['name'].' NO a sido subido al servidor. Error en COPY');
                        $OK = false;
                        $IdRespuesta=false;
                        $errorFile='Error al subir el fichero: '.$_FILES['docResp']['name'];
                        if($_SESSION['navegacion']==='movil'){
                            html_paginaMobil($errorFile,'',$datosUsuarioActivo);
                        }else{
                            html_pagina($errorFile,'',$datosUsuarioActivo);
                        }
                    }
                }else{
                    logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                           " El fichero es mayor de 1 MB: ".$_FILES['docResp']['size']);
                    $errorFile=$_FILES['docResp']['name'].': Este fichero supera 1MB de tamaño.';
                    if($_SESSION['navegacion']==='movil'){
                        html_paginaMobil($errorFile,'',$datosUsuarioActivo);
                    }else{
                        html_pagina($errorFile,'',$datosUsuarioActivo);
                    }
                }
            }else
            //revisar si hay fichero "Foto" a adjuntar (foto)
            if(!$_FILES['docRespFoto']['error'] == 4 && $_FILES['docRespFoto']['name'] !== '' && $_FILES['docRespFoto']['type'] === 'image/jpeg'){
                logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['base'].', SesionID: '.  session_id().
                       " Tiene fichero (foto) adjunto: ".$_FILES['docRespFoto']['name']);

                //genero el nombre del fichero 
                date_default_timezone_set('Europe/Madrid');
                $nombre=$_SESSION['usuario'].$_POST['cmdAltaRespuesta'].date('YmdHis');
                $url="../doc/doc-".$_SESSION['base'].'/'.$nombre.'.jpg';

                //sino existe este directorio lo crea
                if(!file_exists("../doc/doc-" . $_SESSION['base'])){
                    mkdir("../doc/doc-" . $_SESSION['base']);
                }

                //subo a la carpeta de reclamacion el fichero seleccionado
                if(move_uploaded_file($_FILES['docRespFoto']['tmp_name'], $url)){
                    logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['base'].', SesionID: '.  session_id().
                       " El fichero ".$_FILES['docRespFoto']['name'].' a sido subido correctamente al servidor');
                    $OK = true;
                }else{
                    logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['base'].', SesionID: '.  session_id().
                           " El fichero ".$_FILES['docRespFoto']['name'].' NO a sido subido al servidor. Error en move_uploaded_file');
                    $OK = false;
                    $errorFile='Error al subir el fichero: '.$_FILES['docRespFoto']['name'];
                }
            }else{//si no hay, insertamos
                logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " NO tiene fichero adjunto: ".$_FILES['docResp']['name']);
                logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " Damos de alta en la BBDD la respuesta: clsCNConsultas->AltaRespuestaAPregunta(".$_SESSION['usuario'].",".$_POST['strRespuesta'].",".$_POST['cmdAltaRespuesta'].",'')>");
                $IdRespuesta=$clsCNConsultas->AltaRespuestaAPregunta($_SESSION['usuario'],$_POST['strRespuesta'],$_POST['cmdAltaRespuesta'],'');
            }
            
            if($OK === true){
                $IdRespuesta=$clsCNConsultas->AltaRespuestaAPregunta($_SESSION['usuario'],$_POST['strRespuesta'],$_POST['cmdAltaRespuesta'],$url);
            }
        }
        //si ha sido corredto el copiado (si procede) y guardado en BBDD de la respuesta se envia un correo 
        //si el alta de la respuesta ha sido correcta se envia un correo al asesor
        if($IdRespuesta<>false){
            //extraigo los datos del asesor
            $Asesor=$clsCNUsu->DatosAsesor($_SESSION['idEmp']);
            $estadoRespuesta=$clsCNConsultas->RespuestaEstado($IdRespuesta);
            //envio el correo al asesor
            logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " Se envia correo al cliente: ".($datosUsuarioActivo['strNombre'].' '.$datosUsuarioActivo['strApellidos']));
            EnviaCorreoAlAsesor(($datosUsuarioActivo['strNombre'].' '.$datosUsuarioActivo['strApellidos']), $Asesor['Asesor'],$estadoRespuesta, $Asesor['strCorreo'],$datosUsuarioActivo['strCorreo'], $_POST['strRespuesta']);
            //cambiamos el estado de la pregunta a EnCurso
            $clsCNConsultas->RespuestaEstadoEnCurso($_POST['cmdAltaRespuesta']);
            logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " Todo a sido correcto, nos redireccionamos a 'exito.php' ");
            echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/exito.php?Id=La respuesta se ha guardado">';
        }
    }else if($_POST['esAsesor']=='SI'){
        logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " Respuesta del Asesor");
        $OK=null;
        if(isset($_POST['fileResp']) && $_POST['fileResp']<>''){
            logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " Tiene fichero adjunto: ".$_POST['fileResp']);
            //veo si es una url relativa (fichero) o directa (link)
            if(substr($_POST['fileResp'],0,4)==='http'){
                $url=$_POST['fileResp'];
            }else{
                $url="../doc/generales/".$_POST['fileResp'];
            }
            //damos de alta la consulta del cliente
            logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " Damos de alta en la BBDD la respuesta: clsCNConsultas->AltaRespuestaAPregunta(".$_SESSION['usuario'].",".$_POST['strRespuesta'].",".$_POST['cmdAltaRespuesta'].",$url)>");
            $OK=$clsCNConsultas->AltaRespuestaAPregunta($_SESSION['usuario'],$_POST['strRespuesta'],$_POST['cmdAltaRespuesta'],$url);
        }else{//si no hay, insertamos
            logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " NO tiene fichero adjunto: ");
            logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " Damos de alta en la BBDD la respuesta: clsCNConsultas->AltaRespuestaAPregunta(".$_SESSION['usuario'].",".$_POST['strRespuesta'].",".$_POST['cmdAltaRespuesta'].",'')>");
            $OK=$clsCNConsultas->AltaRespuestaAPregunta($_SESSION['usuario'],$_POST['strRespuesta'],$_POST['cmdAltaRespuesta'],'');
        }
        //envio el correo al asesor
        logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " Se envia correo al cliente: ".($datosUsuarioActivo['strNombre'].' '.$datosUsuarioActivo['strApellidos']));
        EnviaCorreoAlCliente($_POST['Usuario'], ($datosUsuarioActivo['strNombre'].' '.$datosUsuarioActivo['strApellidos']), $datosUsuarioActivo['strCorreo'], $_POST['strRespuesta']);
        //cambiamos el estado de la pregunta a respondida
        $clsCNConsultas->RespuestaEstadoRespondida($_POST['cmdAltaRespuesta']);
        logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " Todo a sido correcto, nos redireccionamos a 'exito.php' ");
        if($OK){
            echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/exito.php?Id=La consulta se ha guardado">';
        }
    }
}else

//esta opcion es de actualizar la clasificacion y estado de la pregunta, lo hace un ASESOR
if(isset($_GET['cmdActualizar'])){
    logger('info','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id(). 
           " ||||Comunicaciones->Consulta al Asesor|| Ha pulsado 'Actualizar' la clasificación y Estado de la consulta");
    //actualizamos los datos en la tabla pregunatas y volvemos a presentar la pregunta y sus respuestas
    logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
           " Actualizar la clasificacion y Estado de la pregunta: clsCNConsultas->ActualizarPregunta(".$_GET['IdPregunta'].",".$_GET['strClasificacion'].",".$_GET['strEstado'].")>");
    $OK=$clsCNConsultas->ActualizarPregunta($_GET['IdPregunta'],$_GET['strClasificacion'],$_GET['strEstado']);
    if($OK){
        logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " Actualizado la clasificacion y Estado de la pregunta: ".$_GET['IdPregunta']);
        $txtActualizado='Clasificación y Estado Actualizados';
        if($_SESSION['navegacion']==='movil'){
            html_paginaMobil('',$txtActualizado,$datosUsuarioActivo);
        }else{
            html_pagina('',$txtActualizado,$datosUsuarioActivo);
        }
    }else{
        logger('traza','consulta_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " NO actualizado la clasificacion y Estado de la pregunta: ".$_GET['IdPregunta']);
        
        if($_SESSION['navegacion']==='movil'){
            html_paginaMobil('',$txtActualizado,$datosUsuarioActivo);
        }else{
            html_pagina('',$txtActualizado,$datosUsuarioActivo);
        }
    }
}else{
    if($_SESSION['navegacion']==='movil'){
        html_paginaMobil('','',$datosUsuarioActivo);
    }else{
        html_pagina('','',$datosUsuarioActivo);
    }
}

?>