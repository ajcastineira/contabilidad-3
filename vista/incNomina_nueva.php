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



$clsCNContabilidad=new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['mapeo']);
$clsCNUsu=new clsCNUsu();
$clsCNUsu->setStrBD($_SESSION['dbContabilidad']);



//codigo principal
//comprobamos si se ha submitido el formulario 
if(isset($_POST['existeIncidencia']) && $_POST['existeIncidencia']=='NO'){
    logger('info','incNomina_nueva.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
           " ||||Laboral->Incidencias->Alta|| Ha pulsado 'Proceder al Alta'(Incidencia Nueva)");
    
    $IdIncidencia=$clsCNContabilidad->AltaIncidencia($_POST,$_SESSION['usuario']);
    
    if($IdIncidencia===false){
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/error.php?id=>NO se ha dado de alta la incidencia">';
    }else{
        //revisar si hay fichero PDF a adjuntar (doc)
        if($_FILES['doc']['error'] !== 4 && $_FILES['doc']['name'] !== '' && $_FILES['doc']['type'] === 'application/pdf'){
            logger('traza','incNomina_nueva.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['base'].', SesionID: '.  session_id().
                   " Tiene fichero adjunto: ".$_FILES['doc']['name']);

            //le damos un nombre al fichero
            $IdAdjunto=$clsCNContabilidad->Incidencia_adjunto_nuevo_id();

            //genero el nombre del fichero 
            date_default_timezone_set('Europe/Madrid');
            $nombre='Inc-'.$IdIncidencia.$IdAdjunto.date('YmdHms').'.pdf';
            $destino = "../doc/doc-" . $_SESSION['base'] . "/".$nombre;

            //sino existe este directorio lo crea
            if(!file_exists("../doc/doc-" . $_SESSION['base'])){
                mkdir("../doc/doc-" . $_SESSION['base']);
            }

            //compruebo que no sea superior a 1 MB (1048576)
            if($_FILES['doc']['size']<1048576){
                logger('traza','incNomina_nueva.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['base'].', SesionID: '.  session_id().
                       " El fichero PDF es menor de 1 MB: ".$_FILES['doc']['size']);
                //subo a la carpeta de reclamacion el fichero seleccionado
                if(move_uploaded_file($_FILES['doc']['tmp_name'], $destino)){
                    logger('traza','incNomina_nueva.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['base'].', SesionID: '.  session_id().
                       " El fichero PDF ".$_FILES['doc']['name'].' a sido subido correctamente al servidor');
                    $OK = true;
                }else{
                    logger('traza','incNomina_nueva.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['base'].', SesionID: '.  session_id().
                           " El fichero PDF ".$_FILES['doc']['name'].' NO a sido subido al servidor. Error en move_uploaded_file');
                    $OK = false;
                    $errorFile='Error al subir el fichero PDF: '.$_FILES['doc']['name'];
                }
            }else{
                logger('traza','incNomina_nueva.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['base'].', SesionID: '.  session_id().
                       " El fichero PDF es mayor de 1 MB: ".$_FILES['doc']['size']);
                $errorFile=$_FILES['doc']['name'].': Este fichero supera 1MB de tamaño.';
            }
        }else{//no hay fichero adjunto
            logger('traza','incNomina_nueva.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['base'].', SesionID: '.  session_id().
                   " NO tiene fichero PDF adjunto. ");
        }

        //revisar si hay fichero "Foto" a adjuntar (foto)
        if($_FILES['foto']['error'] !== 4 && $_FILES['foto']['name'] !== '' && $_FILES['foto']['type'] === 'image/jpeg'){
            logger('traza','incNomina_nueva.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['base'].', SesionID: '.  session_id().
                   " Tiene fichero (foto) adjunto: ".$_FILES['doc']['name']);

            //le damos un nombre al fichero
            $IdAdjunto=$clsCNContabilidad->Incidencia_adjunto_nuevo_id();

            //genero el nombre del fichero 
            date_default_timezone_set('Europe/Madrid');
            $nombre='Inc-'.$IdIncidencia.$IdAdjunto.date('YmdHms').'.jpg';
            $destino = "../doc/doc-" . $_SESSION['base'] . "/".$nombre;

            //sino existe este directorio lo crea
            if(!file_exists("../doc/doc-" . $_SESSION['base'])){
                mkdir("../doc/doc-" . $_SESSION['base']);
            }

            //compruebo que no sea superior a 1 MB (1048576)
//            if($_FILES['doc']['size']<1048576){
//                logger('traza','incNomina_nueva.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['base'].', SesionID: '.  session_id().
//                       " El fichero (foto) es menor de 1 MB: ".$_FILES['doc']['size']);
                //subo a la carpeta de reclamacion el fichero seleccionado
                if(move_uploaded_file($_FILES['foto']['tmp_name'], $destino)){
                    logger('traza','incNomina_nueva.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['base'].', SesionID: '.  session_id().
                       " El fichero ".$_FILES['foto']['name'].' a sido subido correctamente al servidor');
                    $OK = true;
                }else{
                    logger('traza','incNomina_nueva.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['base'].', SesionID: '.  session_id().
                           " El fichero ".$_FILES['foto']['name'].' NO a sido subido al servidor. Error en move_uploaded_file');
                    $OK = false;
                    $errorFile='Error al subir el fichero: '.$_FILES['foto']['name'];
                }
            }else{
                logger('traza','incNomina_nueva.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['base'].', SesionID: '.  session_id().
                       " NO tiene fichero adjunto. ");
            }
//        }else{//no hay fichero adjunto
//            logger('traza','incNomina_nueva.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['base'].', SesionID: '.  session_id().
//                   " NO tiene fichero adjunto. ");
//        }

        //guardamos los datos de el fichero subido de la reclamacion en la tabla tbrecl_nc_pm_fichero
        logger('traza','incNomina_nueva.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['base'].', SesionID: '.  session_id().
               " Damos de alta en la BBDD el fichero: tabla tbempleados_incidencias_adj");
        
        //si se han subido bien los ficheros (PDF o Foto)
        if($OK === true){
            $OK = $clsCNContabilidad->AltaEmpleado_incidencia_adj($IdIncidencia,$IdAdjunto,$nombre,$_POST['strDescFichero']);
        }
        
        
        if($OK===false){
            echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/error.php?id='.$varRes.'">';
        }else{
            //redirecciono a la pagina de exito
            echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/exito.php">';
        }
    
    }
}else{//comienzo del else principal
    logger('info','incNominaEmpleadoIncidencia.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
           " ||||Laboral->Incidencias->Alta||");
    
    //miro el listado de empleados a guardar la incidencia
    $listIdEmpleados='';
    foreach ($_POST as $key => $value) {
        //compruebo que el key es id+numero
        if(substr($key,0,2)==='id'){
            $listIdEmpleados[]=substr($key,2);
        }
    }
    
    //miro la vble opcionBoton, si es cerrar , ejecuto esta parte de codigo
    if($_POST['opcionBoton'] === 'cerrar'){
        $OK = $clsCNContabilidad->IncidenciasCerrarPorListadoEmpleados($listIdEmpleados);
        
        if($OK === false){
            //redirecciono a la pagina de error
            echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/error.php">';die;
        }else{
            //redirecciono a la pagina de exito
            echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/exito.php">';die;
        }
    }else 
    if ($_POST['opcionBoton'] === 'cerrarIncidencias') {
        $OK = $clsCNContabilidad->IncidenciasCerrarPorListadoIncidencias($listIdEmpleados);
        
        if($OK === false){
            //redirecciono a la pagina de error
            echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/error.php">';die;
        }else{
            //redirecciono a la pagina de exito
            echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/exito.php">';die;
        }
    }
    //sino que siga el flujo
    
    //datos del usuario
    $usuario=$clsCNUsu->DatosUsuario($_SESSION['usuario']);
    
    //aqui dirijo a la presentacion en PC o Movil (APP)
    if($_SESSION['navegacion']==='movil'){
        html_paginaLaboralIncNominaMovil($listIdEmpleados,$usuario,$clsCNContabilidad);
    }else{
        html_paginaLaboralIncNomina($listIdEmpleados,$usuario,$clsCNContabilidad);
    }
}

function html_paginaLaboralIncNomina($listIdEmpleados,$usuario,$clsCNContabilidad){
    
?>
<!DOCTYPE html>
<HTML>
<HEAD>
    
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../images/q.ico">
<?php
//estas funciones son generales
librerias_jQuery();
eventosInputText();
?>
<TITLE>Empleado</TITLE>

<script language="JavaScript">

function validar2()
{
  esValido=true;
  textoError='';
  
  
  //comprobacion del campo 'fechaInicio'
  if (document.form1.fechaInicio.value == ''){ 
    textoError=textoError+"Hay que indicar la fecha de inicio.\n";
    document.form1.fechaInicio.style.borderColor='#FF0000';
    document.form1.fechaInicio.title ='Hay que indicar la fecha de inicio.';
    esValido=false;
  }
  
  //comprobacion del campo 'observaciones'
  if (document.form1.observaciones.value == ''){ 
    textoError=textoError+"Hay que indicar las observaciones.\n";
    document.form1.observaciones.style.borderColor='#FF0000';
    document.form1.observaciones.title ='Hay que indicar las observaciones.';
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
<BODY bgColor=#ffffff leftMargin=0 topMargin=0 rightMargin=0 bottomMargin=0 marginwidth="0" marginheight="0"  background="<?php echo FONDO; ?>"
      onLoad="rotulo_status();">
    
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<!-- Cabecera-->
  <tr>
   <td colspan="2" width="40%"></td>
   <td  width="780" bgcolor="#FFFFFF" class="Text2">
   <table border="<?php echo MARCO_BORDER; ?>" cellpadding="0" cellspacing="0" width="780">

   <tr>
   <!-- contenido pagina -->
   <td width="768" border="0" alt="" valign="top">
   <br><p></p>

<center>
    
<?php
$tituloForm='INCIDENCIAS';

$cabeceraNumero='0802a';

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
    <form id="form1" name="form1" method="post" enctype="multipart/form-data" action="../vista/incNomina_nueva.php" onSubmit="desactivaBoton();">

      <table width="640" border="0" class="zonaactiva">
        <tr> 
          <td class="subtitulo" colspan="9">&nbsp;Empleados a guardar la incidencia</td>
        </tr>
        <tr>
            <td width="7%"></td>
            <td width="86%"></td>
            <td width="7%"></td>
        </tr>
        <?php
        //preparamos el listado de ls empleados a guardar una incidencia
        for($j=0;$j<count($listIdEmpleados);$j++){
            //extraemos los datos del empleado
            $datosEmpleado=$clsCNContabilidad->datosEmpleado($listIdEmpleados[$j]);
            
            //preparamos la linea de datos de este empleado
            echo "<tr>";
            echo "<td></td>";
            echo "<td>".$datosEmpleado['nombre'].' '.$datosEmpleado['apellido1'].' '.$datosEmpleado['apellido2'].'</td>';
            echo "</tr>";
        }
        ?>
        <tr>
            <td height="15px"></td>
        </tr>
      </table>        
        
        
      <table width="640" border="0" class="zonaactiva">
        <tr> 
          <td class="subtitulo" colspan="9">&nbsp;Datos de la Incidencia</td>
        </tr>
        <tr>
            <td width="7%"></td>
            <td width="20%"></td>
            <td width="6%"></td>
            <td width="20%"></td>
            <td width="6%"></td>
            <td width="35%"></td>
            <td width="6%"></td>
        </tr>
        <tr>
            <td></td>
            <td>
              <div align="left">
                <label class="nombreCampo">Fecha Inicio</label>
                  <?php
                  datepicker_español('fechaInicio');
                  date_default_timezone_set('Europe/Madrid');
                  ?>
                  <style type="text/css">
                  /* para que no salga el rectangulo inferior */        
                  .ui-widget-content {
                      border: 0px solid #AAAAAA;
                  }
                  </style>
                  <input class="textbox1" type="text" id="fechaInicio" name="fechaInicio" maxlength="38" tabindex="1"
                         value=""
                         onKeyUp="this.value=formateafechaEntrada(this.value);" 
                         onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                         onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
            </td>
            <td></td>
            <td>
              <div align="left">
                <label class="nombreCampo">Fecha Fin</label>
                  <?php
                  datepicker_español('fechaFin');
                  date_default_timezone_set('Europe/Madrid');
                  ?>
                  <style type="text/css">
                  /* para que no salga el rectangulo inferior */        
                  .ui-widget-content {
                      border: 0px solid #AAAAAA;
                  }
                  </style>
                  <input class="textbox1" type="text" id="fechaFin" name="fechaFin" maxlength="38" tabindex="2"
                         value=""
                         onKeyUp="this.value=formateafechaEntrada(this.value);" 
                         onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                         onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
            </td>
            <td></td>
            <td>
              <div align="left">
                    <label class="nombreCampo">Tipo</label>
                    <select name="tipo" class="textbox1" tabindex="3"
                            onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);">
                        <option value = "enfermedad" selected>Enfermedad</option>
                        <option value = "accidente">Accidente</option>
                        <option value = "ausencia">Ausencia</option>
                        <option value = "maternidad">Maternidad</option>
                    </select>
              </div>
            </td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="5">
                <label class="nombreCampo">Observaciones</label>
                <textarea class="textbox1area" name="observaciones" rows=4 
                          cols="20" onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                          onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"
                          ></textarea> 
            </td>
            <td></td>
        </tr>
        <tr>
            <td height="15px"></td>
        </tr>
    </table>
        
    <!--PARA FICHEROS NUEVOS-->   
    
    
    
        <script>
        //AJAX jQuery chequea que el fichero sea PDF
        function check_fileAnexo(){
            var inputFileImage = document.getElementById("doc");

            if(navigator.appVersion.indexOf("MSIE 6.")!=-1 || navigator.appVersion.indexOf("MSIE 7.")!=-1
               || navigator.appVersion.indexOf("MSIE 8.")!=-1 || navigator.appVersion.indexOf("MSIE 9.")!=-1){
                var url=inputFileImage.value;
                var ficheroI=url.split("\\");
                var fichero=ficheroI[ficheroI.length-1];
                var ficheroDiv=fichero.split(".");
                var ext=ficheroDiv[ficheroDiv.length-1];
                ext=ext.toUpperCase();

                if(ext != 'PDF'){
                    $('#txt_file').html("<b class='fileError'>&nbsp;&nbsp;&nbsp;El documento no es PDF o supera el tamaño maximo (1MB)</b>");
                    document.getElementById('docCorrecto').value='NO';
                }else{
                    $('#txt_file').html("<b>&nbsp;&nbsp;&nbsp;El documento es correcto</b>");
                    $.ajax({
                      data:{"name":fichero,"size":"10","type":"application/pdf"}, 
                      url: '../vista/ajax/buscar_fileCorrecto.php',
                      type:"POST",
                      success: function(data) {
                        if(data==='SI'){
                            $('#txt_file').html("<b>&nbsp;&nbsp;&nbsp;El documento es correcto</b>");
                        }else{
                            $('#txt_file').html("<b class='fileError'>&nbsp;&nbsp;&nbsp;El documento no es PDF o supera el tamaño maximo (1MB)</b>");
                        }
                        document.getElementById('docCorrecto').value=data;
                      }
                    });
                }
            }else{
                //para el resto de navegadores
                var file = inputFileImage.files[0];
                $.ajax({
                  data:{"name":file.name,"size":file.size,"type":file.type}, 
                  url: '../vista/ajax/buscar_fileCorrecto.php',
                  type:"POST",
                  success: function(data) {
                    if(data==='SI'){
                        $('#txt_file').html("<b>&nbsp;&nbsp;&nbsp;El documento es correcto</b>");
                    }else{
                        $('#txt_file').html("<b class='fileError'>&nbsp;&nbsp;&nbsp;El documento no es PDF o supera el tamaño maximo (1MB)</b>");
                    }
                    document.getElementById('docCorrecto').value=data;
                  }
                });
            }
        }

        </script>
        
        <table width="640" border="0" class="zonaactiva">
            <tr>
                <td class="subtitulo">&nbsp;Documento anexo </td>
            </tr>
            <tr>
                <td height="15px"></td>
            </tr>
            <tr>
                <td align="center">
                    <span class="nombreCampo">Descripción Fichero:</span>
                    <input class="textbox1" style="width: 140px;" type="text" name="strDescFichero" onchange="onMouseOverInputText(this);" size="30"
                           onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
                           <br/><br/>
                    <input type="file" class="file" id="doc" name="doc" onchange="check_fileAnexo();" /><br/>
                    <span class="nombreCampo" id="txt_file">El documento debe ser PDF</span><br/>
                    <input type="hidden" name="docCorrecto" id="docCorrecto" value="NO" />
                </td>
            </tr>
            <tr>
                <td height="15px"></td>
            </tr>
        </table>
        
        
        
        
      <P>
        <input type="button" class="button" name="cmdAlta" id="cmdAlta"
               value = "<?php if(isset($_GET['IdIncidencia'])){echo 'Grabar';}else{echo 'Proceder al Alta';}?>"
               onclick="javascript:validar2();" tabindex="10" /> 
        <input type="button" class="buttonAzul" value="Volver" onclick="javascript:history.back();" />
        <input type="Reset" class="button"
               value="<?php if(isset($_GET['IdIncidencia'])){echo 'Datos iniciales';}else{echo 'Vaciar Datos';} ?>"
               name="cmdReset"/>
        <input type="hidden"  name="cmdAlta" value="Aceptar" />
        <input type="hidden"  name="existeIncidencia" value="<?php if(isset($_GET['IdIncidencia'])){echo 'SI';}else{echo 'NO';}?>" />
        <input type="hidden"  name="IdIncidencia" value="<?php if(isset($_GET['IdIncidencia'])){echo $_GET['IdIncidencia'];}?>" />
        <?php
        $listIdEmpleados = serialize($listIdEmpleados);
        $listIdEmpleados = urlencode($listIdEmpleados); 
        ?>
        <input type="hidden"  name="listEmp" value="<?php if(isset($listIdEmpleados)){echo $listIdEmpleados;}?>" />
      </P>
    </form>
  </div>
</center>

   </td>
  </tr>
  </table>
  </td>
  <td colspan="2" width="40%"></td>
  </tr>
  <tr>
    <td colspan="2" width="40%"></td>
    <td bgcolor="#FFFFFF">
        <table border="0" width="780">
            <tr>
                <td></td>
                <!-- contenido pagina -->
                <td width="620" border="0" alt="" valign="top">
                    <br><p></p>
                    <center>
                        <?php include '../vista/IndicacionIncidencia.php'; ?>
                    </center>
                </td>
                <td></td>
            </tr>
        </table>        
    </td>
    <td colspan="2" width="40%"></td>
  </tr>
<!-- presentacion-->   
</table>
</body>
</html>
<?php
}//fin 


function html_paginaLaboralIncNominaMovil($listIdEmpleados,$usuario,$clsCNContabilidad){
?>
<!DOCTYPE html>
<html>
<head>
<TITLE>Alta de Ingresos - Movimientos</TITLE>

<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>
<link rel="stylesheet" href="../css/estiloMovil.css" />
        
</head>
<body onLoad=""
      class="api jquery-mobile archive category category-widgets category-2 listing single-author"> 

<div data-role="page" id="incNominas_nueva">
<?php
eventosInputText();
?>
<script language="JavaScript">
    
function validar2()
{
  esValido=true;
  textoError='';
  
  
  //comprobacion del campo 'fechaInicio'
  if (document.form1.fechaInicio.value == ''){ 
    textoError=textoError+"Hay que indicar la fecha de inicio.\n";
    document.form1.fechaInicio.style.borderColor='#FF0000';
    document.form1.fechaInicio.title ='Hay que indicar la fecha de inicio.';
    esValido=false;
  }
  
  //comprobacion del campo 'observaciones'
  if (document.form1.observaciones.value == ''){ 
    textoError=textoError+"Hay que indicar las observaciones.\n";
    document.form1.observaciones.style.borderColor='#FF0000';
    document.form1.observaciones.title ='Hay que indicar las observaciones.';
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
    
</script>

<?php
include_once '../movil/cabeceraMovil.php';
?>

<div data-role="content" data-theme="a">
    <form id="form1" name="form1" method="post" enctype="multipart/form-data" action="../vista/incNomina_nueva.php" onSubmit="desactivaBoton();">
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
                        <label><b>Empleados a guardar la incidencia</b></label>
                    </td>
                </tr>
                <?php
                //preparamos el listado de ls empleados a guardar una incidencia
                for($j=0;$j<count($listIdEmpleados);$j++){
                    //extraemos los datos del empleado
                    $datosEmpleado=$clsCNContabilidad->datosEmpleado($listIdEmpleados[$j]);

                    //preparamos la linea de datos de este empleado
                    echo "<tr>";
                    echo "<td colspan='4'>".$datosEmpleado['nombre'].' '.$datosEmpleado['apellido1'].' '.$datosEmpleado['apellido2'].'</td>';
                    echo "</tr>";
                }
                ?>
                <tr>
                    <td colspan="4" height="20px"><hr/></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label><b>Datos de la Incidencia</b></label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label>Fecha Inicio</label>
                        <?php
                        date_default_timezone_set('Europe/Madrid');
                        $fechaForm=date('d/m/Y');
                        datepicker_español('fechaInicio');
                        ?>
                        <input type="text" id="fechaInicio" name="fechaInicio" maxlength="38" 
                               onKeyUp="this.value=formateafechaEntrada(this.value);" value=""
                               onfocus="<?php if(!isset($datosEmpleado['fechaInicio'])){echo 'limpiaCampoFecha(this)';}?>"
                               onblur=""
                               onchange="" />
                    </td>
                    <td colspan="2">
                        <label>Fecha Fin</label>
                        <?php
                        datepicker_español('fechaFin');
                        ?>
                        <input type="text" id="fechaFin" name="fechaFin" maxlength="38" 
                               onKeyUp="this.value=formateafechaEntrada(this.value);" value=""
                               onfocus="<?php if(!isset($datosEmpleado['fechaFin'])){echo 'limpiaCampoFecha(this)';}?>"
                               onblur=""
                               onchange="" />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>Tipo</label>
                        <select name="tipo" tabindex="3" data-native-menu="false" data-theme='a' data-mini="true">
                            <option value = "enfermedad" selected>Enfermedad</option>
                            <option value = "accidente">Accidente</option>
                            <option value = "ausencia">Ausencia</option>
                            <option value = "maternidad">Maternidad</option>
                        </select>
                    </td>
                </tr>        
                <tr> 
                    <td colspan="4">
                        <label>Observaciones</label>
                        <textarea name="observaciones" rows=4 cols="20"
                                onfocus="onFocusInputTextM(this);"></textarea> 
                    </td>
                </tr>
            </tbody>
        </table>
        
        <script>
        //AJAX jQuery chequea que el fichero sea PDF
        function check_fileAnexo(){
            var inputFileImage = document.getElementById("doc");

            if(navigator.appVersion.indexOf("MSIE 6.")!=-1 || navigator.appVersion.indexOf("MSIE 7.")!=-1
               || navigator.appVersion.indexOf("MSIE 8.")!=-1 || navigator.appVersion.indexOf("MSIE 9.")!=-1){
                var url=inputFileImage.value;
                var ficheroI=url.split("\\");
                var fichero=ficheroI[ficheroI.length-1];
                var ficheroDiv=fichero.split(".");
                var ext=ficheroDiv[ficheroDiv.length-1];
                ext=ext.toUpperCase();

                if(ext != 'PDF'){
                    $('#txt_file').html("<b class='fileError'>&nbsp;&nbsp;&nbsp;El documento no es PDF o supera el tamaño maximo (1MB)</b>");
                    document.getElementById('docCorrecto').value='NO';
                }else{
                    $('#txt_file').html("<b>&nbsp;&nbsp;&nbsp;El documento es correcto</b>");
                    $.ajax({
                      data:{"name":fichero,"size":"10","type":"application/pdf"}, 
                      url: '../vista/ajax/buscar_fileCorrecto.php',
                      type:"POST",
                      success: function(data) {
                        if(data==='SI'){
                            $('#txt_file').html("<b>&nbsp;&nbsp;&nbsp;El documento es correcto</b>");
                        }else{
                            $('#txt_file').html("<b class='fileError'>&nbsp;&nbsp;&nbsp;El documento no es PDF o supera el tamaño maximo (1MB)</b>");
                        }
                        document.getElementById('docCorrecto').value=data;
                      }
                    });
                }
            }else{
                //para el resto de navegadores
                var file = inputFileImage.files[0];
                $.ajax({
                  data:{"name":file.name,"size":file.size,"type":file.type}, 
                  url: '../vista/ajax/buscar_fileCorrecto.php',
                  type:"POST",
                  success: function(data) {
                    if(data==='SI'){
                        $('#txt_file').html("<b>&nbsp;&nbsp;&nbsp;El documento es correcto</b>");
                    }else{
                        $('#txt_file').html("<b class='fileError'>&nbsp;&nbsp;&nbsp;El documento no es PDF o supera el tamaño maximo (1MB)</b>");
                    }
                    document.getElementById('docCorrecto').value=data;
                  }
                });
            }
        }

        </script>
        
        <table border="0" style="width: 100%;">
            <tbody>
                <tr>
                    <td style="width: 22%;"></td>
                    <td style="width: 23%;"></td>
                    <td style="width: 23%;"></td>
                    <td style="width: 22%;"></td>
                </tr>
                <tr>
                    <td colspan="4" height="20px"><hr/></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label><b>Documento anexo</b></label>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>Descripción Fichero:</label>
                        <input type="text" name="strDescFichero" id="strDescFichero" maxlength="30" onfocus="onFocusInputTextM(this);"
                               value=""
                               onblur="" />
                    </td>
                </tr>                
                <tr>
                    <td colspan="4">
                        <input type="file" data-mini="true" id="doc" name="doc" accept="application/pdf" onchange="check_fileAnexo();" /><br/>
                    </td>
                </tr>                
                <tr>
                    <td colspan="4">
                        <span class="nombreCampo" id="txt_file">El documento debe ser PDF</span><br/>
                        <input type="hidden" name="docCorrecto" id="docCorrecto" value="NO" />
                    </td>
                </tr>                
                <tr>
                    <td colspan="4" height="20px"><hr/></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>Subir Foto:</label>
                        <input type="file" data-mini="true" id="foto" name="foto" accept="image/*" capture="camera" /><br/>
                    </td>
                </tr>                
                <tr>
                    <td colspan="2">
                        <input type="button" name="cmdAlta" id="cmdAlta"
                               value = "<?php if(isset($_GET['IdIncidencia'])){echo 'Grabar';}else{echo 'Alta';}?>"
                               onclick="javascript:validar2();" /> 
                    </td>
                    <td colspan="2">
                        <input type="Reset"
                               value="<?php if(isset($_GET['IdIncidencia'])){echo 'Datos Inic.';}else{echo 'Vaciar';} ?>"
                               name="cmdReset"/>
                        <input type="hidden"  name="cmdAlta" value="Aceptar" />
                        <input type="hidden"  name="existeIncidencia" value="<?php if(isset($_GET['IdIncidencia'])){echo 'SI';}else{echo 'NO';}?>" />
                        <input type="hidden"  name="IdIncidencia" value="<?php if(isset($_GET['IdIncidencia'])){echo $_GET['IdIncidencia'];}?>" />
                        <?php
                        $listIdEmpleados = serialize($listIdEmpleados);
                        $listIdEmpleados = urlencode($listIdEmpleados); 
                        ?>
                        <input type="hidden"  name="listEmp" value="<?php if(isset($listIdEmpleados)){echo $listIdEmpleados;}?>" />
                    </td>
                </tr>
            </tbody>
        </table>
    </form>    
</div>
</div>
</body>    
</html>    
<?php
}
?>