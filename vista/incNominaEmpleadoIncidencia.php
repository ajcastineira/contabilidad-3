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
if(isset($_POST['existeIncidencia']) && $_POST['existeIncidencia']=='SI'){
    //se editan los datos de la incidencia
    logger('info','incNominaEmpleadoIncidencia.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
           " ||||Laboral->Incidencias->Editar(submitimos datos)");

    //listado de empleados de esta incidencia
    $listIdEmpleados=$clsCNContabilidad->ListadoEmpleadosIncidencia($_POST['IdIncidencia']);
    
    $varRes=$clsCNContabilidad->EditarIncidencia($_POST,$listIdEmpleados,$_SESSION['usuario']);

    if($varRes<>1){
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/error.php?id='.$varRes.'">';
    }else{
        //redirecciono a la pagina de exito
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/exito.php">';
    }
}else if(isset($_POST['existeIncidencia']) && $_POST['existeIncidencia']=='NO'){
    //esta opcion no se usa
    
//    logger('info','incNominaEmpleadoIncidencia.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
//           " ||||Laboral->Incidencias->Alta|| Ha pulsado 'Proceder al Alta'(Incidencia Nueva)");
//    
//    $varRes=$clsCNContabilidad->AltaEmpleado($_POST,$_SESSION['usuario']);
//    
//    if($varRes<>1){
//        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/error.php?id='.$varRes.'">';
//    }else{
//        //redirecciono a la pagina de exito
//        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/exito.php">';
//    }
    
}else{//comienzo del else principal
    logger('info','incNominaEmpleadoIncidencia.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
           " ||||Laboral->Incidencias->Editar||");
    
    //listado de empleados de esta incidencia
    $listIdEmpleados=$clsCNContabilidad->ListadoEmpleadosIncidencia($_GET['IdIncidencia']);
    
    
    //miro si traigo datos por GET (es que es para editar los datos del empleado)
    if(isset($_GET['IdIncidencia'])){
        //extraigo los datos del empleado de la BBDD
        $datosIncidencia=$clsCNContabilidad->datosIncidencia($_GET['IdIncidencia']);
    }
    $usuario=$clsCNUsu->DatosUsuario($_SESSION['usuario']);
    
    $disabled = '';
    if($datosIncidencia['cerrada'] == '1' && substr($_SESSION['cargo'],0,7)==='Usuario'){
        $disabled = 'disabled';
    }

    
    //aqui dirijo a la presentacion en PC o Movil (APP)
    if($_SESSION['navegacion']==='movil'){
        html_paginaLaboralEmpleadoIncidenciaMovil($listIdEmpleados,$usuario,$clsCNContabilidad,$datosIncidencia,$disabled);
    }else{
        html_paginaLaboralEmpleadoIncidencia($listIdEmpleados,$usuario,$clsCNContabilidad,$datosIncidencia,$disabled);
    }
}

function html_paginaLaboralEmpleadoIncidencia($listIdEmpleados,$usuario,$clsCNContabilidad,$datosIncidencia,$disabled){
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
      onLoad="rotulo_status();
              presentarTablaFicheros(<?php echo $_GET['IdIncidencia'];?>);">
    
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
$tituloForm='EMPLEADO';

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
    <form id="form1" name="form1" method="post" enctype="multipart/form-data" action="../vista/incNominaEmpleadoIncidencia.php" onSubmit="desactivaBoton();">

      <table width="640" border="0" class="zonaactiva">
        <tr> 
          <td class="subtitulo" colspan="9">&nbsp;Empleados de la Incidencia</td>
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
            $datosEmpleado=$clsCNContabilidad->datosEmpleado($listIdEmpleados[$j]['IdEmpleado']);
            
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
                         value="<?php if(isset($datosIncidencia)){echo $datosIncidencia['fechaInicio'];}?>"
                         onKeyUp="this.value=formateafechaEntrada(this.value);" 
                         onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                         onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"
                         <?php echo $disabled; ?> />
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
                         value="<?php if(isset($datosIncidencia)){echo $datosIncidencia['fechaFin'];}?>"
                         onKeyUp="this.value=formateafechaEntrada(this.value);" 
                         onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                         onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"
                         <?php echo $disabled; ?> />
              </div>
            </td>
            <td></td>
            <td>
              <div align="left">
                    <label class="nombreCampo">Tipo</label>
                    <?php
                    $selecEnfermedad='';
                    $selecAccidente='';
                    $selecAusencia='';
                    $selecMaternidad='';
                    if(isset($datosIncidencia['tipo'])){
                        if($datosIncidencia['tipo']==='enfermedad'){
                            $selecEnfermedad='selected';
                        }else
                        if($datosIncidencia['tipo']==='accidente'){
                            $selecAccidente='selected';
                        }else
                        if($datosIncidencia['tipo']==='ausencia'){
                            $selecAusencia='selected';
                        }else
                        if($datosIncidencia['tipo']==='maternidad'){
                            $selecMaternidad='selected';
                        }
                    }
                    ?>
                    <select name="tipo" class="textbox1" tabindex="3" <?php echo $disabled; ?>
                            onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);">
                        <option value = "enfermedad" <?php echo $selecEnfermedad; ?>>Enfermedad</option>
                        <option value = "accidente" <?php echo $selecAccidente; ?>>Accidente</option>
                        <option value = "ausencia" <?php echo $selecAusencia; ?>>Ausencia</option>
                        <option value = "maternidad" <?php echo $selecMaternidad; ?>>Maternidad</option>
                    </select>
              </div>
            </td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="5">
                <label class="nombreCampo">Observaciones</label>
                <textarea class="textbox1area" name="observaciones" rows=4 <?php echo $disabled; ?>
                          cols="20" onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                          onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"
                          ><?php if(isset($datosIncidencia)){echo $datosIncidencia['observaciones'];}?></textarea> 
            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2">
                <div align="right">
                    <p>¿Cerrar Incidencia?</p>
                </div>
            </td>
            <td>
                <?php
                $checked = '';
                if($datosIncidencia['cerrada'] == '1'){
                    $checked = 'checked';
                }
                $disabledCerrada = '';
                if(substr($_SESSION['cargo'],0,7)==='Usuario'){
                    $disabledCerrada = 'disabled';
                }
                ?>
                <input type="checkbox" name="cerrada" <?php echo $checked.' '.$disabledCerrada; ?> />
            </td>
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

        //presentar una tabla con los ficheros de la tabla tbrecl_nc_pm_fichero
        function presentarTablaFicheros(id){
            $.ajax({
              data:{"id":id}, 
              url: '../vista/ajax/listadoFicheros_incidencias_adjuntos.php',
              type:"get",
              success: function(data) {
                  document.getElementById('tablaFicheros').innerHTML=data;
              }
            });

            //ahora limpio los campos de descripcion, el fichero y el de las indicaciones (txt_file)
            document.form1.strDescFichero.value='';
            document.form1.doc.value='';
            document.getElementById('txt_file').innerHTML='El documento debe ser PDF';
            document.form1.docCorrecto.value='NO';
        }

        //valida y sube el fichero a la carpteta ../qualidad/doc-Cliente/recl_nc_pm/ y da de alta en la tabla tbrecl_nc_pm_fichero
        function validarFichero(descripcion,IdIncidencia){
            esValido=true;
            textoError='';


            //comprobacion del campo 'strDescFichero'
            if (document.form1.strDescFichero.value == ''){ 
              textoError=textoError+"Es necesario introducir la descripción del fichero.\n";
              document.form1.strDescFichero.style.borderColor='#FF0000';
              document.form1.strDescFichero.title ='Se debe introducir la descripción del fichero';
              esValido=false;
            }

            if (document.form1.docCorrecto.value === 'NO'){
                textoError=textoError+"O debe seleccionar un documento o este no es PDF e inferior a 1MB.\n";
                esValido=false;
            }

            //indicar el mensaje de error si es 'esValido' false
            if(esValido==false){
                alert(textoError);
                return false;
            }

            document.form1.btnConsulta.disabled=true;
            document.form1.btnConsulta.value='Subiendo Documento ...';
            //ahora subimos el fichero y damos de alta en la tabla tbrecl_nc_pm_fichero esta reclamacion
            var inputFileImage = document.getElementById("doc");

            if((navigator.appVersion.indexOf("MSIE 8.")!=-1) || (navigator.appVersion.indexOf("MSIE 7.")!=-1) || 
                (navigator.appVersion.indexOf("MSIE 6.")!=-1) || (navigator.appVersion.indexOf("MSIE 9.")!=-1)){
                //submito el form y doy de alta el documento
                document.form1.btnConsulta.value='Subiendo Documento ...';
                document.form1.AltaDoc.value='SI';
                document.form1.submit();
            }else{
                //doy de alta el doc y la foto por AJAX
                var file = inputFileImage.files[0];
                var data = new FormData();
                data.append('archivo',file);
                data.append('descripcion',descripcion);
                data.append('IdIncidencia',IdIncidencia);
                
                //AJAX actualizas datos en la tabla
                $.ajax({
                    url: '../vista/ajax/insertar_incidencias_adjuntos.php',
                    type:"POST",
                    contentType:false,
                    data:data,
                    processData:false,
                    cache:false,
                    success: function(data) {
                        if(data==='OK'){
                            alert('Se ha registrado correctamente el documento anexo. Sino aparece en el listado pulse en "Actualizar Listado"');
                            document.form1.btnConsulta.disabled=false;
                            document.form1.btnConsulta.value='Anexar Documento';
                        }else{
                            alert('NO se ha registrado correctamente el documento anexo.');
                            document.form1.btnConsulta.disabled=false;
                            document.form1.btnConsulta.value='Anexar Documento';
                        }
                    }
                });
            }

            //por último actualizo el listado de ficheros
            setTimeout("presentarTablaFicheros(<?php echo $_GET['IdIncidencia'];?>)",0);
        }
        
        //borra fichero de la tabla tbrecl_nc_pm_fichero
        function borrarFichero(Id){
            if(confirm("¿Desea borrar el documento anexado? Pinche en el botón 'Actualizar Listado' para ver el listado actualizado")){
                //AJAX actualizas datos en la tabla
                $.ajax({
                    data:{"Id":Id},
                    url: '../vista/ajax/borrarFicheros_incidencias_adjuntos.php',
                    type:"POST"
                });


                //por último actualizo el listado de ficheros
                setTimeout("presentarTablaFicheros(<?php echo $_GET['IdIncidencia'];?>)",0);
            }
        }

        </script>
        
        <table width="640" border="0" class="zonaactiva">
              <tr>
                  <td height="15px"></td>
              </tr>
              <tr>
                  <td width="320" class="subtitulo">&nbsp;Documento(s) anexo(s) </td>
              </tr>
              <tr>
                  <td align="center">
                      <span id="tablaFicheros"><img src="../images/cargar.gif" height="20" widt="20" /></span><br/>
                  </td>
              </tr>
              <tr>
                  <td height="15px"></td>
              </tr>
              <tr>
                  <td align="center">
                      <?php 
                      if($disabled === 'disabled'){
                          $display = 'none';
                      }else{
                          $display = 'block';
                      }
                      ?>
                      <div style="display: <?php echo $display;?>;">
                        <span class="nombreCampo">Descripción Fichero:</span>
                        <input class="textbox1" style="width: 140px;" type="text" name="strDescFichero" onchange="onMouseOverInputText(this);" maxlength="30" 
                               onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
                               <br/><br/>
                        <input type="file" class="file" id="doc" name="doc" onchange="check_fileAnexo();" /><br/>
                        <span class="nombreCampo" id="txt_file">El documento debe ser PDF</span><br/>
                        <input type="hidden" name="docCorrecto" id="docCorrecto" value="NO" />
                        <input type="hidden" name="AltaDoc" value="NO" />
                        <input type="button" name="btnConsulta" class="button" value = "Anexar Documento" 
                               onclick="validarFichero(document.form1.strDescFichero.value,'<?php echo $_GET['IdIncidencia']; ?>');"/>
                        <input type="button" name="btnListar" class="button" value = "Actualizar Listado" 
                               onclick="presentarTablaFicheros('<?php echo $_GET['IdIncidencia']; ?>');"/>
                        </div>
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

function html_paginaLaboralEmpleadoIncidenciaMovil($listIdEmpleados,$usuario,$clsCNContabilidad,$datosIncidencia,$disabled){
?>
<!DOCTYPE html>
<html>
<head>
<TITLE></TITLE>

<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>
<link rel="stylesheet" href="../css/estiloMovil.css" />
        
</head>
<body onLoad="presentarTablaFicheros(<?php echo $_GET['IdIncidencia'];?>);"
      class="api jquery-mobile archive category category-widgets category-2 listing single-author"> 

<div data-role="page" id="incNominaEmpleadoIncidencias">
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
    <form id="form1" name="form1" method="post" enctype="multipart/form-data" action="../vista/incNominaEmpleadoIncidencia.php">
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
                        <label><b>Empleados de la Incidencia</b></label>
                    </td>
                </tr>
                <?php
                //preparamos el listado de ls empleados a guardar una incidencia
                for($j=0;$j<count($listIdEmpleados);$j++){
                    //extraemos los datos del empleado
                    $datosEmpleado=$clsCNContabilidad->datosEmpleado($listIdEmpleados[$j]['IdEmpleado']);

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
                               onKeyUp="this.value=formateafechaEntrada(this.value);" value="<?php if(isset($datosIncidencia['fechaInicio'])){echo $datosIncidencia['fechaInicio'];}?>"
                               onfocus="<?php if(!isset($datosEmpleado['fechaInicio'])){echo 'limpiaCampoFecha(this)';}?>"
                               onblur=""
                               <?php echo $disabled; ?>
                               onchange="" />
                    </td>
                    <td colspan="2">
                        <label>Fecha Fin</label>
                        <?php
                        datepicker_español('fechaFin');
                        ?>
                        <input type="text" id="fechaFin" name="fechaFin" maxlength="38" 
                               onKeyUp="this.value=formateafechaEntrada(this.value);" value="<?php if(isset($datosIncidencia['fechaFin'])){echo $datosIncidencia['fechaFin'];}?>"
                               onfocus="<?php if(!isset($datosEmpleado['fechaFin'])){echo 'limpiaCampoFecha(this)';}?>"
                               onblur=""
                               <?php echo $disabled; ?>
                               onchange="" />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>Tipo</label>
                        <select name="tipo" tabindex="3" data-native-menu="false" data-theme='a' data-mini="true" <?php echo $disabled; ?>>
                            <option value = "enfermedad" <?php if($datosIncidencia['tipo'] === 'enfermedad'){echo 'selected';} ?>>Enfermedad</option>
                            <option value = "accidente" <?php if($datosIncidencia['tipo'] === 'accidente'){echo 'selected';} ?>>Accidente</option>
                            <option value = "ausencia" <?php if($datosIncidencia['tipo'] === 'ausencia'){echo 'selected';} ?>>Ausencia</option>
                            <option value = "maternidad" <?php if($datosIncidencia['tipo'] === 'maternidad'){echo 'selected';} ?>>Maternidad</option>
                        </select>
                    </td>
                </tr>        
                <tr> 
                    <td colspan="4">
                        <label>Observaciones</label>
                        <textarea name="observaciones" rows=4 cols="20" <?php echo $disabled; ?>
                                onfocus="onFocusInputTextM(this);"
                                ><?php if(isset($datosIncidencia)){echo $datosIncidencia['observaciones'];}?></textarea> 
                    </td>
                </tr>
                <tr> 
                    <?php
                    if(substr($_SESSION['cargo'],0,7)!=='Usuario'){
                    ?>
                    <td colspan="3">
                        <div align="right">
                            <p>¿Cerrar Incidencia?</p>
                        </div>
                    </td>
                    <td>
                        <?php
                        $checked = '';
                        if($datosIncidencia['cerrada'] == '1'){
                            $checked = 'checked';
                        }
                        ?>
                        <input type="checkbox" name="cerrada" <?php echo $checked; ?> />
                    </td>
                    <?php
                    }else{
                    ?>
                    <tr>
                        <td colspan="4" height="20px"></td>
                    </tr>
                    <?php
                    }
                    ?>
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

        function check_fotoAnexo(){
            var inputFileImage = document.getElementById("foto");
            
            if(navigator.appVersion.indexOf("MSIE 6.")!=-1 || navigator.appVersion.indexOf("MSIE 7.")!=-1
               || navigator.appVersion.indexOf("MSIE 8.")!=-1 || navigator.appVersion.indexOf("MSIE 9.")!=-1){
                var url=inputFileImage.value;
                var ficheroI=url.split("\\");
                var fichero=ficheroI[ficheroI.length-1];
                var ficheroDiv=fichero.split(".");
                var ext=ficheroDiv[ficheroDiv.length-1];
                ext=ext.toUpperCase();

                if(ext != 'JPG'){
                    $('#txt_foto').html("<b class='fileError'>&nbsp;&nbsp;&nbsp;El documento no es JPG</b>");
                    document.getElementById('docCorrecto').value='NO';
                }else{
                    $('#txt_foto').html("<b>&nbsp;&nbsp;&nbsp;El documento es correcto</b>");
                    $.ajax({
                      data:{"name":fichero,"size":"10","type":"image/jpeg"}, 
                      url: '../vista/ajax/buscar_fotoCorrecto.php',
                      type:"POST",
                      success: function(data) {
                        if(data==='SI'){
                            $('#txt_foto').html("<b>&nbsp;&nbsp;&nbsp;El documento es correcto</b>");
                        }else{
                            $('#txt_foto').html("<b class='fileError'>&nbsp;&nbsp;&nbsp;El documento no es JPG</b>");
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
                  url: '../vista/ajax/buscar_fotoCorrecto.php',
                  type:"POST",
                  success: function(data) {
                    if(data==='SI'){
                        $('#txt_foto').html("<b>&nbsp;&nbsp;&nbsp;El documento es correcto</b>");
                    }else{
                        $('#txt_foto').html("<b class='fileError'>&nbsp;&nbsp;&nbsp;El documento no es JPG</b>");
                    }
                    document.getElementById('docCorrecto').value=data;
                  }
                });
            }
        }


        //presentar una tabla con los ficheros de la tabla tbrecl_nc_pm_fichero
        function presentarTablaFicheros(id){
            $.ajax({
              data:{"id":id}, 
              url: '../vista/ajax/listadoFicheros_incidencias_adjuntos.php',
              type:"get",
              success: function(data) {
                  document.getElementById('tablaFicheros').innerHTML=data;
              }
            });

            //ahora limpio los campos de descripcion, el fichero y el de las indicaciones (txt_file)
            document.form1.strDescFichero.value='';
            document.form1.doc.value='';
            document.getElementById('txt_file').innerHTML='El documento debe ser PDF';
            document.form1.docCorrecto.value='NO';
        }

        //valida y sube el fichero a la carpteta ../qualidad/doc-Cliente/recl_nc_pm/ y da de alta en la tabla tbrecl_nc_pm_fichero
        function validarFichero(descripcion,IdIncidencia){
            esValido=true;
            textoError='';


            //comprobacion del campo 'strDescFichero'
            if (document.form1.strDescFichero.value == ''){ 
              textoError=textoError+"Es necesario introducir la descripción del fichero.\n";
              document.form1.strDescFichero.style.borderColor='#FF0000';
              document.form1.strDescFichero.title ='Se debe introducir la descripción del fichero';
              esValido=false;
            }

            if (document.form1.docCorrecto.value === 'NO'){
                textoError=textoError+"O debe seleccionar un documento o este no es PDF e inferior a 1MB.\n";
                esValido=false;
            }

            //indicar el mensaje de error si es 'esValido' false
            if(esValido==false){
                alert(textoError);
                return false;
            }

            document.form1.btnConsulta.disabled=true;
            document.form1.btnConsulta.value='Subiendo Documento ...';
            //ahora subimos el fichero y damos de alta en la tabla tbrecl_nc_pm_fichero esta reclamacion
            var inputFileImage = document.getElementById("doc");

            if((navigator.appVersion.indexOf("MSIE 8.")!=-1) || (navigator.appVersion.indexOf("MSIE 7.")!=-1) || 
                (navigator.appVersion.indexOf("MSIE 6.")!=-1) || (navigator.appVersion.indexOf("MSIE 9.")!=-1)){
                //submito el form y doy de alta el documento
                document.form1.btnConsulta.value='Subiendo Documento ...';
                document.form1.AltaDoc.value='SI';
                document.form1.submit();
            }else{
                //doy de alta el doc por AJAX
                var file = inputFileImage.files[0];
                var data = new FormData();
                data.append('archivo',file);
                data.append('descripcion',descripcion);
                data.append('IdIncidencia',IdIncidencia);

                //AJAX actualizas datos en la tabla
                $.ajax({
                    url: '../vista/ajax/insertar_incidencias_adjuntos.php',
                    type:"POST",
                    contentType:false,
                    data:data,
                    processData:false,
                    cache:false,
                    success: function(data) {
                        if(data==='OK'){
                            alert('Se ha registrado correctamente el documento anexo. Sino aparece en el listado pulse en "Actualizar Listado"');
                            document.form1.btnConsulta.disabled=false;
                            document.form1.btnConsulta.value='Anexar Documento';
                        }else{
                            alert('NO se ha registrado correctamente el documento anexo.');
                            document.form1.btnConsulta.disabled=false;
                            document.form1.btnConsulta.value='Anexar Documento';
                        }
                    }
                });
            }

            //por último actualizo el listado de ficheros
            setTimeout("presentarTablaFicheros(<?php echo $_GET['IdIncidencia'];?>)",0);
        }

        //valida y sube el fichero 
        function validarFicheroFoto(descripcion,IdIncidencia){
            esValido=true;
            textoError='';


            //comprobacion del campo 'strDescFichero'
            if (document.form1.strDescFichero.value == ''){ 
              textoError=textoError+"Es necesario introducir la descripción del fichero.\n";
              document.form1.strDescFichero.style.borderColor='#FF0000';
              document.form1.strDescFichero.title ='Se debe introducir la descripción del fichero';
              esValido=false;
            }

//            if (document.form1.docCorrecto.value === 'NO'){
//                textoError=textoError+"O debe seleccionar un documento o este no es PDF e inferior a 1MB.\n";
//                esValido=false;
//            }

            //indicar el mensaje de error si es 'esValido' false
            if(esValido==false){
                alert(textoError);
                return false;
            }

            document.form1.btnConsulta.disabled=true;
            document.form1.btnConsulta.value='Subiendo Documento ...';
            //ahora subimos el fichero y damos de alta en la tabla tbrecl_nc_pm_fichero esta reclamacion
            var inputFileImage = document.getElementById("foto");

            if((navigator.appVersion.indexOf("MSIE 8.")!=-1) || (navigator.appVersion.indexOf("MSIE 7.")!=-1) || 
                (navigator.appVersion.indexOf("MSIE 6.")!=-1) || (navigator.appVersion.indexOf("MSIE 9.")!=-1)){
                //submito el form y doy de alta el documento
                document.form1.btnConsulta.value='Subiendo Documento ...';
                document.form1.AltaDoc.value='SI';
                document.form1.submit();
            }else{
                //doy de alta el doc y la foto por AJAX
                var file = inputFileImage.files[0];
                var data = new FormData();
                data.append('archivo',file);
                data.append('descripcion',descripcion);
                data.append('IdIncidencia',IdIncidencia);
                
                //AJAX actualizas datos en la tabla
                $.ajax({
                    url: '../vista/ajax/insertar_incidencias_adjuntos.php',
                    type:"POST",
                    contentType:false,
                    data:data,
                    processData:false,
                    cache:false,
                    success: function(data) {
                        if(data==='OK'){
                            alert('Se ha registrado correctamente el documento anexo. Sino aparece en el listado pulse en "Actualizar Listado"');
                            document.form1.btnConsulta.disabled=false;
                            document.form1.btnConsulta.value='Anexar Documento';
                        }else{
                            alert('NO se ha registrado correctamente el documento anexo.');
                            document.form1.btnConsulta.disabled=false;
                            document.form1.btnConsulta.value='Anexar Documento';
                        }
                    }
                });
            }

            //por último actualizo el listado de ficheros
            setTimeout("presentarTablaFicheros(<?php echo $_GET['IdIncidencia'];?>)",0);
        }



        //borra fichero de la tabla tbrecl_nc_pm_fichero
        function borrarFichero(Id){
            if(confirm("¿Desea borrar el documento anexado? Pinche en el botón 'Actualizar Listado' para ver el listado actualizado")){
                //AJAX actualizas datos en la tabla
                $.ajax({
                    data:{"Id":Id},
                    url: '../vista/ajax/borrarFicheros_incidencias_adjuntos.php',
                    type:"POST"
                });


                //por último actualizo el listado de ficheros
                setTimeout("presentarTablaFicheros(<?php echo $_GET['IdIncidencia'];?>)",0);
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
                        <label><b>Documento(s) anexo(s)</b></label>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <span id="tablaFicheros"><img src="../images/cargar.gif" height="20" widt="20" /></span><br/>
                    </td>
                </tr>
                <tr>
                    <td height="15px"></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <?php 
                        if($disabled === 'disabled'){
                            $display = 'none';
                        }else{
                            $display = 'block';
                        }
                        ?>
                        <div style="display: <?php echo $display;?>;">
                            <style>
                                .txtListadoFicheros{
                                    
                                }
                            </style>
                            <span class="nombreCampo">Descripción Fichero:</span>
                            <input data-mini="true" type="text" name="strDescFichero" maxlength="30" />
                                   <br/><br/>
                            <input type="file" id="doc" name="doc" onchange="check_fileAnexo();" /><br/>
                            <span class="nombreCampo" id="txt_file">El documento debe ser PDF</span><br/>
                            <input type="hidden" name="docCorrecto" id="docCorrecto" value="NO" />
                            <input type="hidden" name="AltaDoc" value="NO" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td height="15px"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style="display: <?php echo $display;?>;">
                            <input type="button" name="btnConsulta" data-mini="true" value = "Anexar Documento" 
                                   onclick="validarFichero(document.form1.strDescFichero.value,'<?php echo $_GET['IdIncidencia']; ?>');"/>
                        </div>
                    </td>
                    <td colspan="2">
                        <div style="display: <?php echo $display;?>;">
                            <input type="button" name="btnListar" data-mini="true" value = "Actualizar Listado" 
                                   onclick="presentarTablaFicheros('<?php echo $_GET['IdIncidencia']; ?>');"/>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" height="20px"><hr/></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>Subir Foto:</label>
                        <input type="file" id="foto" name="foto" accept="image/*" capture="camera" onchange="check_fotoAnexo();" /><br/>
                        <span class="nombreCampo" id="txt_foto"></span><br/>
                    </td>
                </tr>                
                <tr>
                    <td colspan="2">
                        <div style="display: <?php echo $display;?>;">
                            <input type="button" name="btnConsulta" data-mini="true" value = "Anexar Foto" 
                                   onclick="validarFicheroFoto(document.form1.strDescFichero.value,'<?php echo $_GET['IdIncidencia']; ?>');"/>
                        </div>
                    </td>
                    <td colspan="2">
                        <div style="display: <?php echo $display;?>;">
                            <input type="button" name="btnListar" data-mini="true" value = "Actualizar Listado" 
                                   onclick="presentarTablaFicheros('<?php echo $_GET['IdIncidencia']; ?>');"/>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" height="20px"><hr/></td>
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
