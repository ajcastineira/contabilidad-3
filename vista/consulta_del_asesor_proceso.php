<?php
session_start();
require_once '../general/funcionesGenerales.php';
require_once '../CN/clsCNContabilidad.php';
require_once '../CN/clsCNConsultas.php';
require_once '../CN/clsCNUsu.php';


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
$clsCNContabilidad->setStrBDCliente($_SESSION['mapeo']);
$clsCNConsultas=new clsCNConsultas();
$clsCNConsultas->setStrBD($_SESSION['dbContabilidad']);
$clsCNUsu=new clsCNUsu();
$clsCNUsu->setStrBD($_SESSION['dbContabilidad']);

                
logger('info','consulta_del-asesor_proceso.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
       " ||||Comunicaciones->Consulta al Asesor (Pregunta Nueva)||");



////extraigo los id de los check (son los IdUsuarios) del POST
//$listado = stripslashes($_GET['listado']); 
//$listado = urldecode($listado); 
//$listado = unserialize($listado);



//BORRAR

//CORREO DE LOS USUARIOS QUE RECIBEN LOS ASESORES (1 correo)
function EnviaCorreoAlAsesor($Usuario,$estadoPregunta,$strMail,$strConsulta){
    require '../general/phpmailer/PHPMailerAutoload.php';
    $clsCNUsu=new clsCNUsu();
    $clsCNUsu->setStrBD($_SESSION['dbContabilidad']);
    
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

    
//    //CORREO DE CONFIRMACIÓN A LOS USUARIOS QUE ENVÍAN CONSULTAS (1 correo por usuario)
//    //lo primero que tengo que hacer es extraer el listado de usuarios
//    //extraigo los id de los check (son las IdFactura a contabilizar) del POST
//    $listaUsuarios='';
//    foreach($MailUsuarios as $prop=>$valor){
//        if(substr($prop,0,2)==='id'){
//            $IdUsuario=substr($prop,2,3);
//            $listaUsuarios[]=$IdUsuario;
//        }
//    }
        
//    //preparo el array para enviar por url
//    $listaUsuarios=  serialize($listaUsuarios);
//    $listaUsuarios = urlencode($listaUsuarios); 
//                
//    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/consulta_del_asesor_proceso.php?listado='.$listaUsuarios.'&consulta='.$strConsulta.'">';die;
}


//comprobar si venimos de submitir alguna opcion
//si hemos submitido una consulta nueva venimos por $_POST['cmdAltaConsulta']=='Aceptar'
//esta opción solo la utiliza el cliente, al asesor le sale desactivado este formulario
//if(isset($_POST['cmdAltaConsulta']) && $_POST['cmdAltaConsulta']=='Aceptar'){
    logger('info','consulta_del_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id(). 
           " ||||Comunicaciones->Consulta del Asesor|| Ha pulsado 'Guardar' una consulta");
    logger('traza','consulta_del_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
           " Alta Consulta");
    //compiamos al servidor el fichero adjuntado, si hay
    $OK=null;
    //compruebo que no haya habido error
    if($_FILES['doc']['error']==1){
        logger('traza','consulta_del_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " Ha habido error en la subida.");
        $errorFile='Error al subir el fichero. ';
        html_pagina('','',$datosUsuarioActivo);
    }else{
        if($_FILES['doc']['error'] !== 4 && $_FILES['doc']['name'] !== '' && $_FILES['doc']['type'] === 'application/pdf'){
            logger('traza','consulta_del_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
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
                logger('traza','consulta_del_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " El fichero es menor de 1 MB: ".$_FILES['doc']['size']);
                //subo a la carpeta de doc-EMPRESA el fichero seleccionado
                if(move_uploaded_file($_FILES['doc']['tmp_name'], $url)){
                    logger('traza','consulta_del_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                           " El fichero ".$_FILES['doc']['name'].' a sido subido correctamente al servidor');
                    //damos de alta la consulta del cliente
                    logger('traza','consulta_del_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                           " Damos de alta en la BBDD la respuesta: clsCNConsultas->AltaPregunta(".$_SESSION['usuario'].",".$_POST['strConsulta'].",$url)>");
                    $OK = true;
                }else{
                    logger('traza','consulta_del_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                           " El fichero ".$_FILES['doc']['name'].' NO a sido subido al servidor. Error en COPY');
                    $IdPregunta=false;
                    $OK = false;
                    $errorFile='Error al subir el fichero: '.$_FILES['doc']['name'];
                    html_pagina($errorFile,'',$datosUsuarioActivo);
                }
            }else{
                logger('traza','consulta_del_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " El fichero es mayor de 1 MB: ".$_FILES['doc']['size']);
                $errorFile=$_FILES['doc']['name'].': Este fichero supera 1MB de tamaño.';
                html_pagina($errorFile,'',$datosUsuarioActivo);
            }
        }else
        //revisar si hay fichero "Foto" a adjuntar (foto)
        if($_FILES['foto']['error'] !== 4 && $_FILES['foto']['name'] !== '' && $_FILES['foto']['type'] === 'image/jpeg'){
            logger('traza','consulta_del_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['base'].', SesionID: '.  session_id().
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
                logger('traza','consulta_del_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['base'].', SesionID: '.  session_id().
                   " El fichero ".$_FILES['foto']['name'].' a sido subido correctamente al servidor');
                $OK = true;
            }else{
                logger('traza','consulta_del_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['base'].', SesionID: '.  session_id().
                       " El fichero ".$_FILES['foto']['name'].' NO a sido subido al servidor. Error en move_uploaded_file');
                $OK = false;
                $errorFile='Error al subir el fichero: '.$_FILES['foto']['name'];
            }
        }else{//si no hay, insertamos
            logger('traza','consulta_del_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " NO tiene fichero adjunto. ");
            logger('traza','consulta_del_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " Damos de alta en la BBDD la respuesta: clsCNConsultas->AltaPregunta(".$_SESSION['usuario'].",".$_POST['strConsulta'].",'')>");
            $IdPregunta=$clsCNConsultas->AltaPreguntaAsesor($_SESSION['usuario'],$_POST,'');
        }
        
        if($OK === true){
            $IdPregunta=$clsCNConsultas->AltaPreguntaAsesor($_SESSION['usuario'],$_POST,$url);
        }
    }
    //si el alta de la pregunta ha sido correcta se envia un correo al asesor
    //extraigo los datos del asesor
    $Asesor=$clsCNUsu->DatosAsesor($_SESSION['idEmp']);
    $estadoPregunta=$clsCNConsultas->PreguntaEstado($IdPregunta);
    //envio el correo al asesor
    logger('traza','consulta_del_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
           " Se envia correo al cliente: ".($datosUsuarioActivo['strNombre'].' '.$datosUsuarioActivo['strApellidos']));
    EnviaCorreoAlAsesor($Asesor['Asesor'], $estadoPregunta, $Asesor['strCorreo'], $_POST['strConsulta']);
    
    //CORREO DE CONFIRMACIÓN A LOS USUARIOS QUE ENVÍAN CONSULTAS (1 correo por usuario)
    //lo primero que tengo que hacer es extraer el listado de usuarios
    //extraigo los id de los check (son las IdFactura a contabilizar) del POST
    $listaUsuarios='';
    foreach($_POST as $prop=>$valor){
        if(substr($prop,0,2)==='id'){
            $IdUsuario=substr($prop,2,3);
            $listaUsuarios[]=$IdUsuario;
        }
    }
    
    logger('traza','consulta_del_asesor.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
           " Todo a sido correcto, nos redireccionamos a 'exito.php' ");
//    if($IdPregunta<>false){
//        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/exito.php?Id=La consulta se ha guardado">';
//    }
//}

if($_SESSION['navegacion']==='movil'){
    html_paginaMobil($listaUsuarios,$Asesor);
}else{
    html_pagina($listaUsuarios,$Asesor);
}


function html_pagina($listaUsuarios,$Asesor){
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="../images/q.ico">
        <title>Envio de e-mail - Proceso</title>
        <script language="JavaScript">
            var txt="-    Sistema de Gestión de la Calidad    ";
            var espera=120;
            var refresco=null;
 
            function rotulo_status() {
                window.status=txt;
                txt=txt.substring(1,txt.length)+txt.charAt(0);        
                refresco=setTimeout("rotulo_status()",espera);
            }
        </script>
        <link href="../css/Estilos_Qualidad.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="../css/calidad2.css" type="text/css">

        <!--            HE INCLUIDO AQUI ESTAS LIBRERIAS DE jQuery PACO-->
        <?php
        librerias_jQuery_listado();
        ?>
        <!--       FIN     HE INCLUIDO AQUI ESTAS LIBRERIAS DE jQuery PACO-->

<script LANGUAGE="JavaScript"> 

//comntrolar que solo se introduce datos numericos en el campo
 function Solo_Numerico(variable){
    Numer=parseInt(variable);
    if (isNaN(Numer)){
        return "";
    }
    return Numer;
}

function ValNumero(Control){
    Control.value=Solo_Numerico(Control.value);
}

</script>
<script languaje="JavaScript"> 

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
           // clock.innerHTML = movingtime;
        }
        setTimeout("funClock()", 1000)
    }
    window.onload = funClock;
    //  Fin -->
</script>


<script languaje="JavaScript"> 
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
<script type="text/javascript">
function envio(idUsuario,consulta,asesor){
    $.ajax({
      data:{"idUsuario":idUsuario,"consulta":consulta,"asesor":asesor},  
      url: '../vista/consulta_del_asesor_proceso_ajax.php',
      type:"get",
      success: function(data) {
        //recuperamos el valor del texto
        var val = document.getElementById("numValue");
        //actualizamos el indicador visual con el texto
        val.innerHTML = data+val.innerHTML;
      }
    });
}

var idUsuarios=new Array();
<?php
for($i=0;$i<count($listaUsuarios);$i++){
    ?>
    idUsuarios[<?php echo $i;?>]=<?php echo $listaUsuarios[$i];?>;
    <?php
}
?>

//progreso actual
var currProgress = 0;
//esta la tarea completa
var done = false;
//cantidad total de progreso
var total = <?php echo count($listaUsuarios);?>;

function startProgress() {
    //ejecuto la funcion que llama por AJAX la los procedimientos para guardar la factura    
    envio(idUsuarios[currProgress],'<?php echo $_POST['strConsulta']; ?>','<?php echo $Asesor['Asesor'];?>');

    ////incrementamos el valor del progreso cada vez que la funciÃ³n se ejecuta
    currProgress++;
    //comprobamos si hemos terminado
    if(currProgress>(idUsuarios.length-1)){
        done=true;
    }
    // sino hemos terminado, volvemos a llamar a la funciÃ³n despuÃ©s de un tiempo
    if(!done)
    {
        document.getElementById("startBtn").disabled = true;
        setTimeout("startProgress()",0);
    }  
    //tarea terminada, habilitar el botón
    else{   
        document.getElementById("startBtn").disabled = false;
    }
}

function inicio(){
    window.location='../vista/consulta_list_preguntas.php';
}

</script>

</head>
<body onload="startProgress();">
<?php require_once '../vista/cabecera2.php'; ?>
<table align="center" border="0"  width="954">
    <tr>
        <td>
            <h3 align="center" color="#FFCC66"><span id="txtIndicacion">E-mail pendientes. Proceso...</span></h3> 
            <table id="indicacion" align="center" border="0" width="500">
                <tr>
                    <td align="center">
                        <div id="numValue"></div>
                    </td>
                </tr>
            </table>   
            <div align="center">
                <input class="button" id="startBtn" type="button" name="eleccion" value="Volver" onclick="inicio();" disabled />
            </div>

            <br/><br/><br/>
            <?php include '../vista/IndicacionIncidencia.php'; ?>
        </td>
        </tr>
        </table>
    </body>
</html>
<?php
}


function html_paginaMobil($listaUsuarios,$Asesor){
?>
<!DOCTYPE html>
<html>
<head>
<TITLE>Envio de e-mail - Proceso</TITLE>

<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>

        
</head>
<body onload="startProgress();">
           
<div data-role="page" id="consultadelAsesorProceso">
<?php
eventosInputText();
?>
<script type="text/javascript">
function envio(idUsuario,consulta,asesor){
    $.ajax({
      data:{"idUsuario":idUsuario,"consulta":consulta,"asesor":asesor},  
      url: '../vista/consulta_del_asesor_proceso_ajax.php',
      type:"get",
      success: function(data) {
        //recuperamos el valor del texto
        var val = document.getElementById("numValue");
        //actualizamos el indicador visual con el texto
        val.innerHTML = data+val.innerHTML;
      }
    });
}

var idUsuarios=new Array();
<?php
for($i=0;$i<count($listaUsuarios);$i++){
    ?>
    idUsuarios[<?php echo $i;?>]=<?php echo $listaUsuarios[$i];?>;
    <?php
}
?>

//progreso actual
var currProgress = 0;
//esta la tarea completa
var done = false;
//cantidad total de progreso
var total = <?php echo count($listaUsuarios);?>;

function startProgress() {
    //ejecuto la funcion que llama por AJAX la los procedimientos para guardar la factura    
    envio(idUsuarios[currProgress],'<?php echo $_POST['strConsulta']; ?>','<?php echo $Asesor['Asesor'];?>');

    ////incrementamos el valor del progreso cada vez que la funciÃ³n se ejecuta
    currProgress++;
    //comprobamos si hemos terminado
    if(currProgress>(idUsuarios.length-1)){
        done=true;
    }
    // sino hemos terminado, volvemos a llamar a la funciÃ³n despuÃ©s de un tiempo
    if(!done)
    {
        $("#startBtn").button('disable');
        //document.getElementById("startBtn").disabled = true;
        setTimeout("startProgress()",0);
    }  
    //tarea terminada, habilitar el botón
    else{   
        $("#startBtn").button('enable');
        //document.getElementById("startBtn").disabled = false;
    }
}

function inicio(){
    window.location='../movil/consulta_list_preguntas.php';
}

</script>

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>

    <div data-role="content" data-theme="a">
        <p><span id="txtIndicacion">E-mail pendientes. Proceso...</span></p>
        <table border="0" style="width: 100%;">
                <tbody>
                    <tr>
                        <td style="width: 22%;"></td>
                        <td style="width: 23%;"></td>
                        <td style="width: 23%;"></td>
                        <td style="width: 22%;"></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div id="numValue" style=""></div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="2">
                            <input data-mini="true" id="startBtn" type="button" name="eleccion" value="Volver" onclick="inicio();" />
                        </td>
                    </tr>
                </tbody>            
        </table>
        
        
        
    </div>
</div>
</body>
</html>






<?php
}


?>