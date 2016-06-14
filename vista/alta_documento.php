<?php
session_start ();
require_once '../CN/clsCNUsu.php';
require_once '../CN/clsCNConsultas.php';
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


$clsCNUsu=new clsCNUsu();
$clsCNUsu->setStrBD($_SESSION['dbContabilidad']);
$clsCNConsultas=new clsCNConsultas();
$clsCNConsultas->setStrBD($_SESSION['dbContabilidad']);

//codigo principal
//comprobamos si se ha submitido el formulario
if(isset($_POST['cmdAlta']) && $_POST['cmdAlta']=='Aceptar'){
//    print_r($_FILES);die;
    logger('info','alta_documento.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id(). 
           " ASESOR:||||Documentacion->Alta Documento|| Ha pulsado 'Alta Documento'");
    
    //compiamos al servidor el fichero adjuntado, si hay
    $OK=false;
    //compruebo que no haya habido error
    if($_FILES['doc']['error']==1){
        logger('traza','alta_documento.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
               " Ha habido error en la subida del documento.");
        $OK=false;
    }else{
        if(!$_FILES['doc']['error']==4 && $_FILES['doc']['name']<>''){
            logger('traza','alta_documento.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
                   " Tiene fichero adjunto: ".$_FILES['doc']['name']);
            //le damos un nombre al fichero
            //este nombre consta del nombre del fichero+fecha(año+mes+dia+hora+min+seg)
            date_default_timezone_set('Europe/Madrid');
            $nombre=explode('.',$_FILES['doc']['name']);
            $nombre=$nombre[0];
            $nombre=$nombre.'-'.date('YmdHis').'.pdf';
            $url="../doc/generales/".$nombre;
            
            if($_FILES['doc']['size']<1048576){
                logger('traza','alta_documento.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
                       " El fichero es menor de 1 MB: ".$_FILES['doc']['size']);
                //subo a la carpeta de generales el fichero seleccionado
                if(move_uploaded_file($_FILES['doc']['tmp_name'], $url)){
                    logger('traza','alta_documento.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
                           " El fichero ".$_FILES['doc']['name'].' a sido subido correctamente al servidor');

                    //damos de alta el documento
                    logger('traza','alta_documento.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
                           " Damos de alta en la BBDD la respuesta: clsCNConsultas->AltaDocumento()>");
                    $OK=$clsCNConsultas->AltaDocumento($_POST['versionDoc'],$_POST['optTipo'],$_POST['optTipo2'],$_POST['nombreDoc'],$nombre,
                                                       $_POST['optCategoria'],$_POST['strUrl'],$_POST['strDescripcion'],$_POST['lngIdEmpleado']);
                }else{
                    logger('traza','alta_documento.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
                           " El fichero ".$_FILES['doc']['name'].' NO a sido subido al servidor. Error en COPY');
                    $OK=false;
                }
            }else{
                logger('traza','alta_documento.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
                       " El fichero es mayor de 1 MB: ".$_FILES['doc']['size']);
                $OK=false;
            }
        }else{//si no hay, insertamos
            //damos de alta el documento
            logger('traza','alta_documento.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
                   " Damos de alta en la BBDD la respuesta: clsCNConsultas->AltaDocumento()>");
            $OK=$clsCNConsultas->AltaDocumento($_POST['versionDoc'],$_POST['optTipo'],$_POST['optTipo2'],$_POST['nombreDoc'],'',
                                               $_POST['optCategoria'],$_POST['strUrl'],$_POST['strDescripcion'],$_POST['lngIdEmpleado']);
        }
    }
    
    if($OK){
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/exitoAsesor.php?Id=El documento se ha guardado">';
    }else{
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/errorAsesor.php?id=Ha habido un error al guardar el documento">';
    }
}else{//comienzo del else principal
    logger('info','alta_documento.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
           " ASESOR:||||Documentacion->Alta Documento|| ");

    $datosUsuario=$clsCNUsu->DatosUsuario($_SESSION['usuario']);
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
<TITLE>Documentación - ALTA</TITLE>

<script src="https://code.jquery.com/jquery-1.8.3.js"></script>
<script src="https://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
<link href="../js/jQuery/input-file/jquery.file.css" rel="stylesheet" type="text/css" />
<script src="../js/jQuery/input-file/jquery.file.js" type="text/javascript"></script>

<script language="JavaScript">

function validar()
{
  esValido=true;
  textoError='';
  //comprobacion del campo 'nombreDoc'
  if (document.form1.nombreDoc.value == ''){ 
    textoError=textoError+"Es necesario introducir el código del documento.\n";
    document.form1.nombreDoc.style.borderColor='#FF0000';
    document.form1.nombreDoc.title ='Se debe introducir el código del documento';
    esValido=false;
  }
  //comprobacion del campo 'versionDoc'
  if (document.form1.versionDoc.value == ''){ 
    textoError=textoError+"Es necesario introducir el número de edición.\n";
    document.form1.versionDoc.style.borderColor='#FF0000';
    document.form1.versionDoc.title ='Se deben introducir el número de edición';
    esValido=false;
  }
  //comprobacion del campo 'strDescripcion'
  if (document.form1.strDescripcion.value == ''){ 
    textoError=textoError+"Es necesario introducir una descripción.\n";
    document.form1.strDescripcion.style.borderColor='#FF0000';
    document.form1.strDescripcion.title ='Se deben introducir una descripción';
    esValido=false;
  }
  
  //comprobacion que no exista cuenta en la BBDD (en el txt_edicion)
  texto=document.getElementById("txt_edicion").innerHTML;
  if (texto.indexOf('error') != -1){
    textoError=textoError+"Este documento con esta edición ya existe.\n";
    document.form1.versionDoc.style.borderColor='#FF0000';
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

function comprobarConDocumento(){
    document.getElementById('div_subir').style.display='block';
    document.getElementById('div_url').style.display='none';
}

function comprobarSinDocumento(){
    document.getElementById('div_subir').style.display='none';
    document.getElementById('div_url').style.display='block';
}

//AJAX jQuery chequea si existe nombre y edicion del cocumento en la BBDD
function check_DocEdicion(nombre,edicion){
    $.ajax({
      data:{"nombreDoc":nombre,"edicion":edicion},  
      url: '../vista/ajax/buscar_DocEdicion.php',
      type:"get",
      success: function(data) {
        $('#txt_edicion').html(data);
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
$tituloForm="ALTA DE DOCUMENTO";
$cabeceraNumero='a0201';
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
    <form name="form1" enctype="multipart/form-data" method="post" action="../vista/alta_documento.php" onSubmit="desactivaBoton()">
	
      <table width="640" border="0" class="zonaactiva">
        <tr> 
          <td class="subtitulo" colspan="5">&nbsp;Persona que Realiza el Alta</td>
        </tr>
        <tr>
            <td width="10%"></td>
            <td width="35%"></td>
            <td width="10%"></td>
            <td width="35%"></td>
            <td width="10%"></td>
        </tr>
        <tr>
          <td></td>
          <td>
              <div align="left">
              <label class="nombreCampo">Cód. Empleado:</label>
              <input class="textbox1" type="text" name="lngIdEmpleado" maxlength="5" value="<?php echo $_SESSION['usuario'];?>" readonly />
              </div>
          </td>
          <td></td>
          <td>
              <div align="left">
              <label class="nombreCampo">Nombre:</label>
              <input class="textbox1" type="text" name="strNombre" maxlength="30" value="<?php echo $datosUsuario['strNombre'];?>" readonly />
              </div>
          </td>
        </tr>
        <tr>
            <td></td>  
          <td>
              <div align="left">
              <label class="nombreCampo">Departamento:</label>
              <input class="textbox1" type="text" name="strNombre" maxlength="30" value="" readonly />
              </div>
          </td>
          <td></td>
          <td>
              <div align="left">
              <label class="nombreCampo">Apellidos:</label>
              <input class="textbox1" type="text" name="strApellidos" maxlength="30" value="<?php echo $datosUsuario['strApellidos'];?>" readonly />
              </div>
          </td>
        </tr>
        <tr>
            <td height="15px"></td>
        </tr>
      </table>

      <table width="640" border="0" class="zonaactiva">
        <tr> 
          <td class="subtitulo" colspan="15">&nbsp;Datos del Documento</td>
        </tr>
        <tr>
            <td width="2%"></td>
            <td width="16%"></td>
            <td width="15%"></td>
            <td width="5%"></td>
            <td width="15%"></td>
            <td width="5%"></td>
            <td width="15%"></td>
            <td width="5%"></td>
            <td width="15%"></td>
            <td width="5%"></td>
            <td width="2%"></td>
        </tr>
        <tr>
          <td></td><!-- 1 -->
          <td><!-- 2 -->
              <div align="left">
              <label class="nombreCampo">Tipo Documento</label>
              </div>
          </td>
          <td><!-- 4 -->
              <div align="right">
              <label class="nombreCampo">Interno</label>
              </div>
          </td>
          <td class="txtgeneral"><input name="optTipo" type="radio" value="0" checked /></td><!-- 5 -->
          <td><!-- 7 -->
              <div align="right">
              <label class="nombreCampo">Con Doc. Anexo</label>
              </div>
          </td>
          <td class="txtgeneral"><input name="optDoc" type="radio" value="0" checked onchange="comprobarConDocumento()"/></td><!-- 8 -->
          <td><!-- 10 -->
              <div align="right">
              <label class="nombreCampo">Pública</label>
              </div>
          </td>
          <td class="txtgeneral"><input name="optTipo2" type="radio" value="Publica" checked /></td><!-- 11 -->
          <td><!-- 13 -->
              <div align="right">
              <label class="nombreCampo">Calidad</label>
              </div>
          </td>
          <td class="txtgeneral"><input name="optCategoria" type="radio" value="Calidad" checked /></td><!-- 14 -->
          <td></td>
        </tr>
        <tr>
          <td></td><!-- 1 -->
          <td></td>
          <td><!-- 4 -->
              <div align="right">
              <label class="nombreCampo">Externo</label>
              </div>
          </td>
          <td class="txtgeneral"><input name="optTipo" type="radio" value="1" /></td><!-- 5 -->
          <td><!-- 7 -->
              <div align="right">
              <label class="nombreCampo">Sin Doc. Anexo</label>
              </div>
          </td>
          <td class="txtgeneral"><input name="optDoc" type="radio" value="1" onchange="comprobarSinDocumento();" /></td><!-- 8 -->
          <td><!-- 10 -->
              <div align="right">
              <label class="nombreCampo">División</label>
              </div>
          </td>
          <td class="txtgeneral"><input name="optTipo2" type="radio" value="Division" disabled /></td><!-- 11 -->
          <td><!-- 13 -->
              <div align="right">
              <label class="nombreCampo">Ambiental</label>
              </div>
          </td>
          <td class="txtgeneral"><input name="optCategoria" type="radio" value="Ambiental" /></td><!-- 14 -->
          <td></td>
        </tr>
        <tr>
          <td></td><!-- 1 -->
          <td></td>
          <td></td>
          <td></td><!-- 5 -->
          <td></td>
          <td ></td><!-- 8 -->
          <td><!-- 10 -->
              <div align="right">
              <label class="nombreCampo">Departamento</label>
              </div>
          </td>
          <td class="txtgeneral"><input name="optTipo2" type="radio" value="Departamento" /></td><!-- 11 -->
          <td><!-- 13 -->
              <div align="right">
              <label class="nombreCampo">Contabilidad</label>
              </div>
          </td>
          <td class="txtgeneral"><input name="optCategoria" type="radio" value="Contabilidad" /></td><!-- 14 -->
          <td></td>
        </tr>
        <tr>
          <td></td><!-- 1 -->
          <td></td>
          <td></td>
          <td></td><!-- 5 -->
          <td></td>
          <td ></td><!-- 8 -->
          <td><!-- 10 -->
              <div align="right">
              <label class="nombreCampo">Sección</label>
              </div>
          </td>
          <td class="txtgeneral"><input name="optTipo2" type="radio" value="Seccion" disabled /></td><!-- 11 -->
          <td></td>
          <td></td><!-- 14 -->
          <td></td>
        </tr>
        <tr>
            <td height="15px"></td>
        </tr>
      </table>

      <table width="640" border="0" class="zonaactiva">
        <tr>
            <td width="5%"></td>
            <td width="20%"></td>
            <td width="20%"></td>
            <td width="5%"></td>
            <td width="20%"></td>
            <td width="20%"></td>
            <td width="10%"></td>
        </tr>
        <tr>
          <td></td>
          <td>
              <div align="right">
              <label class="nombreCampo">Código Documento</label><br/>
              <label class="nombreCampo"><font style="font-size:x-small; color:#FF0000;">Máx. 15 caracteres</font></label>
              </div>
          </td>
          <td>
              <div align="left">
              <input class="textbox1" type="text" name="nombreDoc" maxlength="15"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);"
                     onblur="onBlurInputText(this);"/>
              </div>
          </td>
          <td></td>
          <td>
              <div align="right">
              <label class="nombreCampo">Número de Edición</label><br/>
              </div>
          </td>
          <td>
              <div align="left">
              <input class="textbox1" type="text" name="versionDoc" maxlength="10"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);"
                      onKeyUp="check_DocEdicion(document.form1.nombreDoc.value,this.value);"
                     onblur="check_DocEdicion(document.form1.nombreDoc.value,this.value);onBlurInputText(this);" onkeypress="javascript:return solonumeros(event);" />
              </div>
          </td>
          <td>
              <table border="0">
                  <tr>
                      <td height="5">&nbsp;</td>
                  </tr>
                  <tr>
                      <td height="20">
                         <span valign="top" id="txt_edicion"></span>
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
        
      <table width="640" border="0" class="zonaactiva">
        <tr> 
          <td class="subtitulo" colspan="15">&nbsp;Descripción del Documento</td>
        </tr>
        <tr>
            <td>
            <textarea class="textbox1area" name=strDescripcion rows="5" cols="20" onKeyDown="LimitaTexto(this, 800);" onKeyUp="LimitaTexto(this, 800);"
                      onchange="onMouseOverInputText(this);" onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"></textarea>
            </td>
        </tr>
      </table>
        
      <table width="640" border="0" class="zonaactiva">
        <tr> 
          <td class="subtitulo" colspan="15">&nbsp;Fichero Externo que desea Subir</td>
        </tr>
        <tr>
            <td>
                <div id='div_subir' style='display:block;'>
                    <label>
                        <input type="file" id="doc" name="doc" />
                    </label><br/>
                    <span class="nombreCampo" id="txt_file">&nbsp;&nbsp;&nbsp;&nbsp;El documento debe ser PDF y no superior a 1 MB</span><br/>
                </div>
                <div id='div_url' style='display:none;'>
                    <label class='nombreCampo'>Indique la url donde se aloja este Documento</label>
                    <input class="textbox1" type="text" name="strUrl" maxlength="255"
                           onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);"
                           onblur="onBlurInputText(this);"/>
                </div>
            </td>
        </tr>
        <tr>
            <td height="15px"></td>
        </tr>
      </table>
        
      <table width="640" border="0" class="zonaactiva">
        <tr> 
          <td class="subtitulo">&nbsp;Firma</td>
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
        
      <P>
        <input type="Reset" class="button" value="Vaciar Datos" name="cmdReset"/>
<!--        <input type="submit" class="button" name="cmdAlta" id="cmdAlta" value = "Proceder al Alta" /> -->
        <input type="button" class="button" name="cmdAlta" id="cmdAlta" value = "Proceder al Alta" onclick="javascript:validar();" /> 
        <input type="hidden"  name="cmdAlta" value="Aceptar" />
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