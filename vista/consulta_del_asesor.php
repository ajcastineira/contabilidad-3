<?php
session_start ();

require_once '../CN/clsCNContabilidad.php';
require_once '../CN/clsCNConsultas.php';
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



$clsCNConsultas=new clsCNConsultas();
$clsCNConsultas->setStrBD($_SESSION['dbContabilidad']);
$clsCNUsu=new clsCNUsu();
$clsCNUsu->setStrBD($_SESSION['dbContabilidad']);

if($_SESSION['navegacion']==='movil'){
    html_paginaMobil('','',$datosUsuarioActivo);
}else{
    html_pagina('','',$datosUsuarioActivo);
}

function html_pagina($errorFile,$txtActualizado,$datosUsuarioActivo){
$clsCNConsultas=new clsCNConsultas();
$clsCNConsultas->setStrBD($_SESSION['dbContabilidad']);
$clsCNUsu=new clsCNUsu();
$clsCNUsu->setStrBD($_SESSION['dbContabilidad']);
?>
<!DOCTYPE html>
<HTML>
<HEAD>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../images/q.ico">
<TITLE>Comentario - SOLUCIÓN</TITLE>

<!--            HE INCLUIDO AQUI ESTAS LIBRERIAS DE jQuery PACO-->
<?php
librerias_jQuery_listado();
?>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function(){
        //formatear y traducir los datos de la tabla
        $('#datatablesMod').dataTable({
            "bProcessing": true,
            "sPaginationType":"full_numbers",
            "bPaginate": false,
            "oLanguage": {
                "sLengthMenu": "Ver _MENU_ registros por pagina",
                "sZeroRecords": "No se han encontrado registros",
                "sInfo": "_TOTAL_ Registros",
                "sInfoEmpty": "Ver 0 al 0 de 0 registros",
                "sInfoFiltered": "(filtrados _MAX_ total registros)",
                "sSearch": "Busqueda:"
            },
            "bSort":true,
            bFilter: false,
            "aaSorting": [[ 0, "desc" ]],
            "aoColumns": [
                { "sType": 'string' },
                { "sType": 'string' },
                { "sType": 'string' },
                null
            ],                    
            "bJQueryUI":true,
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]]
        });
    });
</script>


<link href="../js/jQuery/input-file/jquery.file.css" rel="stylesheet" type="text/css" />
<script src="../js/jQuery/input-file/jquery.file.js" type="text/javascript"></script>

<script language="JavaScript">

//variable general de usuarios seleccionados
var seleccionado=0;
var maxSeleccionado=0;

$(document).ready(function(){
    $('#datatablesMod').find(":checkbox").each(function(){
        maxSeleccionado=maxSeleccionado+1;
    });
});

    
function listarUsuariosDeEmpresa(idEmpresa){
    //marco en la lista de los usuarios todos los de esta empresa
    //saco por AJAX ellistado de emplados (idEmpleado) de esta empresa
    $.ajax({
      data:{"idEmpresa":idEmpresa},  
      url: '../vista/ajax/listar_idEmpleado_por_idEmpresa.php',
      type:"get",
      success: function(data) {
          var listado = JSON.parse(data);
          if(document.getElementById('emp'+idEmpresa).checked){
              for(i=0;i<listado.length;i++){
                  document.getElementById('usu'+listado[i]).checked=true;
                  seleccionado=seleccionado+1;
                  compruebaSeleccionado();
              }
          }else{
              for(i=0;i<listado.length;i++){
                  document.getElementById('usu'+listado[i]).checked=false;
                  seleccionado=seleccionado-1;
                  compruebaSeleccionado();
              }
          }
      }
    });
}

function listarUsuariosClaseDeEmpresa(clase,id){
    //marco en la lista de los usuarios todos los de esta empresa
    //saco por AJAX ellistado de emplados (idEmpleado) de esta empresa
    $.ajax({
      data:{"clase":clase},  
      url: '../vista/ajax/listar_idEmpleado_por_claseEmpresa.php',
      type:"get",
      success: function(data) {
          var listado = JSON.parse(data);
          if(document.getElementById('clase'+id).checked){
              for(i=0;i<listado.length;i++){
                  document.getElementById('usu'+listado[i]).checked=true;
                  seleccionado=seleccionado+1;
                  compruebaSeleccionado();
              }
          }else{
              for(i=0;i<listado.length;i++){
                  document.getElementById('usu'+listado[i]).checked=false;
                  seleccionado=seleccionado-1;
                  compruebaSeleccionado();
              }
          }
      }
    });
}

function listarTodosUsuarios(){
    if(document.getElementById('checkTodo').checked){
        //esta deseleccionado, lo selecciono
        $('#datatablesMod').find(":checkbox").each(function(){
            var elemento=this;
            elemento.checked=true;
            seleccionado=seleccionado+1;
            compruebaSeleccionado();
        });
    }else{
        //esta seleccionado, lo deselecciono
        $('#datatablesMod').find(":checkbox").each(function(){
            var elemento=this;
            elemento.checked=false;
            seleccionado=seleccionado-1;
            compruebaSeleccionado();
        });
    }
}

function compruebaSeleccionado(){
    if(seleccionado < 0){
        seleccionado=0;
    }
    if(seleccionado > maxSeleccionado){
        seleccionado=maxSeleccionado;
    }
    
    //si seleccionado=0 es que antes era 1 y esta el boton de submitir enabled y hay que ponerlo disabled
    if(seleccionado===0){
        document.formConsulta.btnConsulta.className='buttonDesactivado';
        document.formConsulta.btnConsulta.disabled=true;
    }else{
        document.formConsulta.btnConsulta.className='button';
        document.formConsulta.btnConsulta.disabled=false;
    }
}

function onOffUsuario(id){
    if(document.getElementById('usu'+id).checked){
        seleccionado=seleccionado+1;
        compruebaSeleccionado(seleccionado);
        document.getElementById('usu'+id).checked=true;
    }else{
        seleccionado=seleccionado-1;
        compruebaSeleccionado(seleccionado);
        document.getElementById('usu'+id).checked=false;
    }
}

function validarConsulta(){
  
  esValido=true;
  textoError='';

  //compruebo que no haya error en el span AJAX (de la carga del fichero)
  if ((document.getElementById("txt_file").innerHTML.indexOf('Nombre de fichero existe ya')!=-1) ||
      (document.getElementById("txt_file").innerHTML.indexOf('Este fichero NO es PDF')!=-1)){
    textoError=textoError+"El fichero a adjuntar no es correcto.\n";
    esValido=false;
  }
     
  //comprobacion del campo 'strConsulta'
  if (document.formConsulta.strConsulta.value == ''){ 
    textoError=textoError+"Hay que rellenar la consulta.\n";
    document.formConsulta.strConsulta.style.borderColor='#FF0000';
    document.formConsulta.strConsulta.title ='Hay que rellenar la consulta.';
    esValido=false;
  }
  
  //indicar el mensaje de error si es 'esValido' false
  if (!esValido){
          alert(textoError);
  }

  if(esValido==true){
      //bloqueo la pantalla
      $.blockUI(
        {message:'Por favor. Espere...',
        css: { 
            border: 'none', 
            padding: '10px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        }}
      ); 
      
      //para que salga el gif de subir en las respuestas  
      if(document.getElementById('doc').value.length>0){
          document.getElementById('loading').style.display='inline';
      }
      
      document.formConsulta.cmdAltaConsulta.value='Aceptar';
      document.formConsulta.btnConsulta.value="Enviando...";
      document.formConsulta.btnConsulta.disabled=true;
      document.formConsulta.submit();
  }else{
      return false;
  }  
}

$(document).ready(function() {
        $("input.file").file();
});

//AJAX jQuery chequea cuenta exista en la BD
function check_fileConsulta(file){
    $.ajax({
      data:{"file":file},  
      url: '../vista/ajax/buscar_file.php',
      type:"get",
      success: function(data) {
        $('#txt_file').html(data);
      }
    });
}

</script>
<script language="JavaScript">
<!-- //
var txt="-    Sistema de Gestión de la Calidad    ";
var espera=120;
var refresco=null;

function rotulo_status() {
        window.status=txt;
        txt=txt.substring(1,txt.length)+txt.charAt(0);        
        refresco=setTimeout("rotulo_status()",espera);
        }

// --></script>
<!--<SCRIPT language="JavaScript" SRC="/include/frames.js"></SCRIPT>-->
<script languaje="JavaScript"  type="text/JavaScript">
<!--
function Modificar(menu)
{

		document.form1.strTipReclamacion.value = menu.options[menu.selectedIndex].text
}
//-->
</script>
<link href="../css/Estilos_Qualidad.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../css/calidad2.css" type="text/css">
<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
    eventosInputText();
?>
</HEAD>
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
<!--    <div class="blocker" style="display:none;"></div>-->
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
$tituloForm="CONSULTAS DEL ASESOR";
$cabeceraNumero='0402b';
$paginaForm='';
$disabledForm='disabled';
date_default_timezone_set('Europe/Madrid');
$fechaForm=date('d/m/Y');
require_once 'cabeceraForm.php';
?>
  <div class="doc"> 
    <hr color = "#FF9900">
      
    <br/><br/>

    <b class="fileError">
        <?php
        if(isset($errorFile) && $errorFile<>''){
        ?>
        <script languaje="JavaScript">
        $.blockUI(
          {message:'<?php echo $errorFile;?>',
          css: { 
              border: 'none', 
              padding: '10px', 
              backgroundColor: '#000', 
              '-webkit-border-radius': '10px', 
              '-moz-border-radius': '10px', 
              opacity: .5, 
              color: '#fff' 
          }}
        );
        setTimeout($.unblockUI, 2000);    
        </script>
        <?php
        }
        ?>
    </b><br/>
        
    <table class="filtro" align="center" border="0" width="300">
    <tr> 
      <td class="nombreCampo"><div align="right">Clasificación:</div></td>
      <td colspan="2" width="250">
          <div align="right">
              <select name="strClasificacion" class="textbox1"
                      onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);">
                    <option value = ""></option>
                    <option value = "Contable">Contable</option>
                    <option value = "Fiscal">Fiscal</option>
                    <option value = "Laboral">Laboral</option>
                    <option value = "Mercantil">Mercantil</option>
                    <option value = "Técnico">Técnico</option>
              </select>
          </div>
      </td>
    </tr>
    <tr> 
      <td class="nombreCampo"> <div align="right">Estado:</div></td>
      <td colspan="2">
          <div align="right">
              <select name="strEstado" class="textbox1"
                      onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);">
                    <option value = ""></option>
                    <option value = "Abierto">Abierto</option>
                    <option value = "En Curso">En Curso</option>
                    <option value = "Respondida">Respondida</option>
                    <option value = "Cerrada">Cerrada</option>
              </select>
          </div>
      </td>
    </tr>
    <tr> 
      <td colspan="8"><hr align="left"></td>
    </tr>
    </table>
    <br/>
    
    <form name="formConsulta" enctype="multipart/form-data" method="post" action="../vista/consulta_del_asesor_proceso.php">
    <table width="640" border="0" class="zonaactiva">
        <tr> 
          <td colspan="4" class="subtitulo">Nueva Consulta</td>
        </tr>
        <tr> 
          <td colspan="4">
              <textarea class="textbox1area" name="strConsulta" rows=4 
                        cols="20" onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                        onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"><?php if(isset($_POST['strConsulta'])){echo $_POST['strConsulta'];}?></textarea> 
          </td>
        </tr>
        <tr>
            <td width="200" class="nombreCampo">Usuario:<br/> <?php echo $datosUsuarioActivo['strNombre'].' '.$datosUsuarioActivo['strApellidos'] ; ?></td>
            <td width="50" class="nombreCampo">
              <?php date_default_timezone_set('Europe/Madrid'); ?>
              Fecha:<br/> <?php print date("d/m/y"); ?>
            </td>
            <td width="20"></td>
            <td align="left">
                <input type="file" class="file" id="doc" name="doc" onchange="check_fileConsulta(this.value);" /><br/>
                <span class="nombreCampo" id="txt_file">El documento debe ser PDF y no superior a 1 MB</span><br/>
                <img id="loading" src="../images/cargar.gif" width="25" height="25" style="display:none" />
            </td>
        </tr>
        <tr>
            <td height="15x"></td>
        </tr>
    </table>
        
    <?php
    //extraigo las empresas
    $arResult=$clsCNConsultas->ListadoEmpresas();
    ?>
    <table border="0" class="zonaactiva">
    <tr> 
       <td colspan="4" class="subtitulo">Seleccione Usuarios</td>
    </tr>
    <tr>
    <td valign="top">
    <!--presentamos el listado de las empresas-->
    <table class="tablaEmpresa">
        <thead>
            <tr>
                <th colspan="2">Empresa</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(is_array($arResult)){
                for ($i = 0; $i < count($arResult); $i++) {
                    if($i%2==0){
                        $classRow='parListado';
                    }else{
                        $classRow='imparListado';
                    }
                    $link="javascript:listarUsuariosDeEmpresa(".$arResult[$i]['IdEmpresa'].");";
                    ?>
                    <tr class="<?php echo $classRow;?>">
                        <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['strSesion']; ?></td>
                        <td onClick="<?php echo $link; ?>"><center><input type="checkbox" id="emp<?php echo $arResult[$i]['IdEmpresa'];?>" /></center></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
    </td>
    <?php
    //extraigo las empresas
    $arResult=$clsCNConsultas->ListadoClaseEmpresas();
    ?>
    
    <td valign="top">
    <!--presentamos el listado de clases de empresa-->
    <table class="tablaEmpresa">
        <thead>
            <tr>
                <th colspan="2">Clase Empresa</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(is_array($arResult)){
                for ($i = 0; $i < count($arResult); $i++) {
                    if($i%2==0){
                        $classRow='parListado';
                    }else{
                        $classRow='imparListado';
                    }
                    $link="javascript:listarUsuariosClaseDeEmpresa('".$arResult[$i]['claseEmpresa']."',".$i.");";
                    $nombre='';
                    if($arResult[$i]['claseEmpresa']==='Autonomo'){
                        $nombre='Autonomo';
                    }else if($arResult[$i]['claseEmpresa']==='Sociedades'){
                        $nombre='Sociedades (PYMES)';
                    }else if($arResult[$i]['claseEmpresa']==='AsocSAL'){
                        $nombre='Asociaciones (Sin ánimo de lucro)';
                    }
                    ?>
                    <tr class="<?php echo $classRow;?>">
                        <td onClick="<?php echo $link; ?>"><?php echo $nombre; ?></td>
                        <td onClick="<?php echo $link; ?>"><center><input type="checkbox" id="clase<?php echo $i;?>" /></center></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
    </td>
    </tr>
    <tr>
    <td colspan="2" align="center" valign="top">
    <!--Seleccionar TODOS los usuarios-->
    <table style="width: 150px;background-color: #fceda7;">
        <tbody>
            <tr>
                <td>TODO</td>
                <td onClick="javascript:listarTodosUsuarios();"><center><input type="checkbox" id="checkTodo" /></center></td>
            </tr>
        </tbody>
    </table>
    </td>
    </tr>
    <tr>
        <td colspan="2">
            <div align="center">
            <input type="button" name="btnConsulta" class="buttonDesactivado" value = "Enviar" onclick="validarConsulta();" disabled="true" />
            <input type="hidden" name="cmdAltaConsulta" />
            </div>
        </td>
    </tr>
    </table>
    
    <?php
    //extraigo todos los usuarios
    $arResult=$clsCNConsultas->ListadoUsuarios();
    ?>
    <table id="datatablesMod" class="display">
        <thead>
            <tr>
                <th width="20%">Empresa</th>
                <th width="40%">Usuario</th>
                <th width="30%">Clase Empresa</th>
                <th width="10%"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(is_array($arResult)){
                for ($i = 0; $i < count($arResult); $i++) {
                    $link="javascript:onOffUsuario(".$arResult[$i]['lngIdEmpleado'].");";
                    ?>
                    <tr>
                        <td onClick=""><?php echo $arResult[$i]['strSesion']; ?></td>
                        <td onClick=""><?php echo $arResult[$i]['usuario']; ?></td>
                        <td onClick=""><?php echo $arResult[$i]['claseEmpresa']; ?></td>
                        <td onClick=""><center><input type="checkbox" id="usu<?php echo $arResult[$i]['lngIdEmpleado'];?>" name="id<?php echo $arResult[$i]['lngIdEmpleado'];?>" onClick="<?php echo $link; ?>" /></center></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
    
    
    
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
}//fin html_pagina


function html_paginaMobil($errorFile,$txtActualizado,$datosUsuarioActivo){
$clsCNConsultas=new clsCNConsultas();
$clsCNConsultas->setStrBD($_SESSION['dbContabilidad']);
$clsCNUsu=new clsCNUsu();
$clsCNUsu->setStrBD($_SESSION['dbContabilidad']);
?>
<!DOCTYPE html>
<html>
<head>
<TITLE>Comentario - SOLUCIÓN</TITLE>
<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>
<!--<link rel="stylesheet" href="../css/estiloMovil.css" />-->

</head> 
    <body>
    <div data-role="page" id="consultadelAsesor">
<?php
eventosInputText();
?>
<script language="JavaScript">

//variable general de usuarios seleccionados
var seleccionado=0;
var maxSeleccionado=0;

$(document).ready(function(){
    $('#datatablesMod').find(":checkbox").each(function(){
        maxSeleccionado=maxSeleccionado+1;
    });
    //desactivar boton de envio
    $('#btnConsulta').button('disable');
});

    
function listarUsuariosDeEmpresa(idEmpresa){
    //marco en la lista de los usuarios todos los de esta empresa
    //saco por AJAX ellistado de emplados (idEmpleado) de esta empresa
    $.ajax({
      data:{"idEmpresa":idEmpresa},  
      url: '../vista/ajax/listar_idEmpleado_por_idEmpresa.php',
      type:"get",
      success: function(data) {
          var listado = JSON.parse(data);
          if(document.getElementById('emp'+idEmpresa).checked){
              for(i=0;i<listado.length;i++){
                  $("#usu"+listado[i]).attr("checked",true).checkboxradio("refresh");
                  //document.getElementById('usu'+listado[i]).checked=true;
                  seleccionado=seleccionado+1;
                  compruebaSeleccionado();
              }
          }else{
              for(i=0;i<listado.length;i++){
                  $("#usu"+listado[i]).attr("checked",false).checkboxradio("refresh");
                  //document.getElementById('usu'+listado[i]).checked=false;
                  seleccionado=seleccionado-1;
                  compruebaSeleccionado();
              }
          }
      }
    });
}

function listarUsuariosClaseDeEmpresa(clase,id){
    //marco en la lista de los usuarios todos los de esta empresa
    //saco por AJAX ellistado de emplados (idEmpleado) de esta empresa
    $.ajax({
      data:{"clase":clase},  
      url: '../vista/ajax/listar_idEmpleado_por_claseEmpresa.php',
      type:"get",
      success: function(data) {
          var listado = JSON.parse(data);
          if(document.getElementById('clase'+id).checked){
              for(i=0;i<listado.length;i++){
                  $("#usu"+listado[i]).attr("checked",true).checkboxradio("refresh");
                  //document.getElementById('usu'+listado[i]).checked=true;
                  seleccionado=seleccionado+1;
                  compruebaSeleccionado();
              }
          }else{
              for(i=0;i<listado.length;i++){
                  $("#usu"+listado[i]).attr("checked",false).checkboxradio("refresh");
                  //document.getElementById('usu'+listado[i]).checked=false;
                  seleccionado=seleccionado-1;
                  compruebaSeleccionado();
              }
          }
      }
    });
}

function listarTodosUsuarios(){
    if(document.getElementById('checkTodo').checked){
        //esta deseleccionado, lo selecciono
        $('#datatablesMod').find("input[type=checkbox]").each(function(){
            //var elemento=this.name;
            $(this).attr("checked",true).checkboxradio("refresh");
            //elemento.checked=true;
            seleccionado=seleccionado+1;
            compruebaSeleccionado();
        });
    }else{
        //esta seleccionado, lo deselecciono
        $('#datatablesMod').find("input[type=checkbox]").each(function(){
            //var elemento=this.name;
            $(this).attr("checked",false).checkboxradio("refresh");
            //elemento.checked=false;
            seleccionado=seleccionado-1;
            compruebaSeleccionado();
        });
    }
}

function compruebaSeleccionado(){
    if(seleccionado < 0){
        seleccionado=0;
    }
    if(seleccionado > maxSeleccionado){
        seleccionado=maxSeleccionado;
    }
    
    //si seleccionado=0 es que antes era 1 y esta el boton de submitir enabled y hay que ponerlo disabled
    if(seleccionado===0){
//        document.formConsulta.btnConsulta.className='buttonDesactivado';
        $('#btnConsulta').button('disable');
//        document.formConsulta.btnConsulta.disabled=true;
    }else{
//        document.formConsulta.btnConsulta.className='button';
        $('#btnConsulta').button('enable');
//        document.formConsulta.btnConsulta.disabled=false;
    }
}

function onOffUsuario(id){
    if(document.getElementById('usu'+id).checked){
        seleccionado=seleccionado+1;
        compruebaSeleccionado(seleccionado);
        document.getElementById('usu'+id).checked=true;
    }else{
        seleccionado=seleccionado-1;
        compruebaSeleccionado(seleccionado);
        document.getElementById('usu'+id).checked=false;
    }
}

function validarConsultaM(){
  
  esValido=true;
  textoError='';

  //compruebo que no haya error en el span AJAX (de la carga del fichero)
  if ((document.getElementById("txt_file").innerHTML.indexOf('Nombre de fichero existe ya')!=-1) ||
      (document.getElementById("txt_file").innerHTML.indexOf('Este fichero NO es PDF')!=-1)){
    textoError=textoError+"El fichero a adjuntar no es correcto.\n";
    esValido=false;
  }
     
  //comprobacion del campo 'strConsulta'
  if (document.formConsulta.strConsulta.value == ''){ 
    textoError=textoError+"Hay que rellenar la consulta.\n";
    document.formConsulta.strConsulta.style.borderColor='#FF0000';
    document.formConsulta.strConsulta.title ='Hay que rellenar la consulta.';
    esValido=false;
  }
  
  //indicar el mensaje de error si es 'esValido' false
  if (!esValido){
          alert(textoError);
  }

  if(esValido==true){
      //bloqueo la pantalla
//      $.blockUI(
//        {message:'Por favor. Espere...',
//        css: { 
//            border: 'none', 
//            padding: '10px', 
//            backgroundColor: '#000', 
//            '-webkit-border-radius': '10px', 
//            '-moz-border-radius': '10px', 
//            opacity: .5, 
//            color: '#fff' 
//        }}
//      ); 
      
      //para que salga el gif de subir en las respuestas  
      if(document.getElementById('doc').value.length>0){
          document.getElementById('loading').style.display='inline';
      }
      
      document.formConsulta.cmdAltaConsulta.value='Aceptar';
      document.formConsulta.btnConsulta.value="Enviando...";
      document.formConsulta.btnConsulta.disabled=true;
      document.formConsulta.submit();
  }else{
      return false;
  }  
}

//$(document).ready(function() {
//        $("input.file").file();
//});

//AJAX jQuery chequea cuenta exista en la BD
function check_fileConsulta(file){
    $.ajax({
      data:{"file":file},  
      url: '../vista/ajax/buscar_file.php',
      type:"get",
      success: function(data) {
        $('#txt_file').html(data);
      }
    });
}
    
</script>

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>

    <div data-role="content" data-theme="a">

        <table border="0" style="width: 100%;">
            <tbody>
                <tr>
                    <td style="width: 22%;"></td>
                    <td style="width: 23%;"></td>
                    <td style="width: 23%;"></td>
                    <td style="width: 22%;"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label>Clasificación</label>
                    </td>
                    <td colspan="2">
                        <div align="right">
                            <select name="strClasificacion" data-native-menu="false" data-theme='a' data-mini="true">
                                  <option value = ""></option>
                                  <option value = "Contable">Contable</option>
                                  <option value = "Fiscal">Fiscal</option>
                                  <option value = "Laboral">Laboral</option>
                                  <option value = "Mercantil">Mercantil</option>
                                  <option value = "Técnico">Técnico</option>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label>Estado</label>
                    </td>
                    <td colspan="2">
                        <div align="right">
                            <select name="strEstado" data-native-menu="false" data-theme='a' data-mini="true">
                                <option value = ""></option>
                                <option value = "Abierto">Abierto</option>
                                <option value = "En Curso">En Curso</option>
                                <option value = "Respondida">Respondida</option>
                                <option value = "Cerrada">Cerrada</option>
                            </select>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>   
        <br/>
        <?php
        
        //este formulario para añadir preguntas 
        ?>
        <form name="formConsulta" enctype="multipart/form-data" method="post" action="../vista/consulta_del_asesor_proceso.php" data-ajax="false">
        <table border="0" style="width: 100%;">
            <tbody>
                <tr>
                    <td style="width: 22%;"></td>
                    <td style="width: 23%;"></td>
                    <td style="width: 23%;"></td>
                    <td style="width: 22%;"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label>Nueva Consulta</label>
                    </td>
                </tr>
                <tr> 
                  <td colspan="4">
                      <textarea name="strConsulta" rows=4 cols="20"
                                onfocus="onFocusInputTextM(this);"><?php if(isset($_POST['strConsulta'])){echo $_POST['strConsulta'];}?></textarea> 
                  </td>
                </tr>
                <tr>
                    <td colspan="4">Usuario: <?php echo $datosUsuarioActivo['strNombre'].' '.$datosUsuarioActivo['strApellidos'] ; ?></td>
                </tr>
                <tr>
                    <td colspan="4">
                      <?php date_default_timezone_set('Europe/Madrid'); ?>
                      Fecha: <?php print date("d/m/y"); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <input type="file" data-mini="true" class="file" id="doc" name="doc" onchange="check_fileConsulta(this.value);" /><br/>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <font style="font-size: small;"><span class="nombreCampo" id="txt_file">El documento debe ser PDF y no superior a 1 MB</span></font>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">Foto</td>
                </tr>
                <tr>
                    <td colspan="4">
                        <input type="file" data-mini="true" class="file" id="foto" name="foto" accept="image/*" capture="camera" />
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2">
                        <input type="button" data-mini="true" id="btnConsulta" name="btnConsulta" value = "Enviar" onclick="validarConsultaM(<?php if(isset($respApregunta)) {echo count($respApregunta);}else{echo '0';}?>);" />
                        <input type="hidden" name="cmdAltaConsulta" />
                        <img id="loading" src="../images/cargar.gif" width="25" height="25" style="display:none" />
                    </td>
                </tr>
                <tr>
                    <td style="height: 15px;"></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label><b>Seleccione Usuarios</b></label>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        
                    <div class="ui-field-contain">
                    <fieldset data-role="controlgroup" data-mini="true">
                        <input type="checkbox" name="checkTodo" id="checkTodo" class="custom" 
                               data-theme="a" data-iconpos="right" onClick="javascript:listarTodosUsuarios();">
                        <label for="checkTodo">TODO</label>
                    </fieldset>
                    </div>
                    
                    <?php
                    //extraigo las empresas
                    $arResult=$clsCNConsultas->ListadoEmpresas();
                    ?>
                    <label>Empresa</label>
                    <div class="ui-field-contain">
                      <fieldset data-role="controlgroup" data-mini="true">
                            <?php
                            if(is_array($arResult)){
                                for ($i = 0; $i < count($arResult); $i++) {
                                    $link="javascript:listarUsuariosDeEmpresa(".$arResult[$i]['IdEmpresa'].");";
                                    ?>
                                    <input type="checkbox" name="emp<?php echo $arResult[$i]['IdEmpresa'];?>" id="emp<?php echo $arResult[$i]['IdEmpresa'];?>" class="custom" 
                                           data-theme="a" data-iconpos="right" onClick="<?php echo $link; ?>">
                                    <label for="emp<?php echo $arResult[$i]['IdEmpresa'];?>"><?php echo $arResult[$i]['strSesion']; ?></label>
                        
                                    <?php
                                    
                                }
                            }
                            ?>
                        </fieldset>
                    </div>
                    <?php
                    //extraigo las empresas
                    $arResult=$clsCNConsultas->ListadoClaseEmpresas();
                    ?>
                    <label>Clase Empresa</label>
                    <div class="ui-field-contain">
                      <fieldset data-role="controlgroup" data-mini="true">
                            <?php
                            if(is_array($arResult)){
                                for ($i = 0; $i < count($arResult); $i++) {
                                    $link="javascript:listarUsuariosClaseDeEmpresa('".$arResult[$i]['claseEmpresa']."',".$i.");";
                                    $nombre='';
                                    if($arResult[$i]['claseEmpresa']==='Autonomo'){
                                        $nombre='Autonomo';
                                    }else if($arResult[$i]['claseEmpresa']==='Sociedades'){
                                        $nombre='Sociedades (PYMES)';
                                    }else if($arResult[$i]['claseEmpresa']==='AsocSAL'){
                                        $nombre='Asociaciones (Sin ánimo de lucro)';
                                    }
                                    ?>
                                    <input type="checkbox" name="clase<?php $i;?>" id="clase<?php echo $i;?>" class="custom" 
                                           data-theme="a" data-iconpos="right" onClick="<?php echo $link; ?>">
                                    <label for="clase<?php echo $i;?>"><?php echo $nombre; ?></label>
                        
                                    <?php
                                    
                                }
                            }
                            ?>
                        </fieldset>
                    </div>
                    <?php
                    //extraigo todos los usuarios
                    $arResult=$clsCNConsultas->ListadoUsuarios();
                    ?>
                    <label>Usuarios</label>
                    <div class="ui-field-contain" id="datatablesMod">
                      <fieldset data-role="controlgroup" data-mini="true">
                            <?php
                            if(is_array($arResult)){
                                for ($i = 0; $i < count($arResult); $i++) {
                                    $link="javascript:onOffUsuario(".$arResult[$i]['lngIdEmpleado'].");";
                                    ?>
                                    <input type="checkbox" name="id<?php echo $arResult[$i]['lngIdEmpleado'];?>" id="usu<?php echo $arResult[$i]['lngIdEmpleado'];?>" class="custom" 
                                           data-theme="a" data-iconpos="right" onClick="<?php echo $link; ?>">
                                    <label for="usu<?php echo $arResult[$i]['lngIdEmpleado'];?>"><?php echo $arResult[$i]['usuario']; ?></label>
                        
                                    <?php
                                    
                                }
                            }
                            ?>
                        </fieldset>
                    </div>
                        
                        
                        
                        
                    </td>
                </tr>
                
            </tbody>
        </table>
        </form>
        <br/>
            
        
        
        
        
    </div>

    </div>    
    </body>
</html>
<?php
    
}
?>