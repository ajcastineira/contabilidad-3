<?php
session_start ();
require_once '../CN/clsCNContabilidad.php';
require_once '../CN/clsCNUsu.php';
require_once '../general/funcionesGenerales.php';
require_once '../CN/clsCNConsultas.php';
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



$clsCNContabilidad=new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['mapeo']);
$clsCNConsultas=new clsCNConsultas();
$clsCNConsultas->setStrBD($_SESSION['dbContabilidad']);
$clsCNUsu=new clsCNUsu();
$clsCNUsu->setStrBD($_SESSION['dbContabilidad']);

$datosUsuarioActivo=$clsCNUsu->DatosUsuario($_SESSION['usuario']);

$editarEmpleado = 'NO';
if(isset($_GET['IdEmpleado']) && $_GET['IdEmpleado'] <> ''){
    $editarEmpleado = 'SI';
}


//codigo principal
//comprobamos si se ha submitido el formulario 
if(isset($_POST['existeEmpleado']) && $_POST['existeEmpleado']=='SI'){
    //comprobamos si se tiene que borrar o no
    logger('info','empleados.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
           " ||||Laboral->Empleados->Alta|| Ha pulsado 'Proceder al Alta'(Empleado Existente)");

    //extraigo el numeroPregunta y como esta el check (chatAutomatico) guardado en la tabla tbempleados
    $datosEmpleado = $clsCNContabilidad->EmpleadoNumPregunta($_POST['IdEmpleado']);

    //guardo la edicion del empleado
    $varRes=$clsCNContabilidad->EditarEmpleado($_POST,$_SESSION['usuario']);

    if($varRes<>1){
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/error.php?id='.$varRes.'">';
    }else{
        //ahora compruebo el check (chatAutomatico) y esta vble guardada en la BBDD
        //chatAutomatico puede venir en on o null (!isset) y en la BBDD esta guardado como 0 o 1
        //existe estan combinaciones
        //chatActualizado    BBDD    = Hacer
        //---------------------------------------
        //1    null            0         0 (nada)
        //2    null            1         0 (cambiar a 0 y enviar respuesta a la pregunta, es un cambio)
        //3    on              0         1 (cambiar a 1 y enviar respuesta a la pregunta, terminada a tramitacion del asesor)
        //4    on              1         1 (nada)
        
        //1 y 4
        $guardarEnviar = 'NO';
        if(isset($_POST['chatActualizado'])){//chatActualizado = on
            if($datosEmpleado['chatActualizado'] === '0'){//3
                $guardarEnviar = 'SI';
                $txtRespuestaAutomatica= 'Se a tramitado correctamente';
            }
        }else{//chatActualizado = null
            if($datosEmpleado['chatActualizado'] === '1'){//2
                $guardarEnviar = 'SI';
                $txtRespuestaAutomatica= 'Se va a tramitar este cambio';
            }
        }
        
        $OK = '';
        if($guardarEnviar === 'SI'){
            $OK=$clsCNConsultas->AltaRespuestaAPregunta($_SESSION['usuario'],$txtRespuestaAutomatica,$datosEmpleado['numPregunta'],'');
        }
        
        if($OK !== false){
            //redirecciono a la pagina de exito
            echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/exito.php">';
        }else{
            echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/error.php">';
        }
    }
}else if(isset($_POST['existeEmpleado']) && $_POST['existeEmpleado']=='NO'){
    logger('info','empleados.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
           " ||||Laboral->Empleados->Alta|| Ha pulsado 'Proceder al Alta'(Empleado Nuevo)");
    
    $varRes=$clsCNContabilidad->AltaEmpleado($_POST,$_SESSION['usuario']);
    
    if($varRes<>1){
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/error.php?id='.$varRes.'">';
    }else{
        //redirecciono a la pagina de exito
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/exito.php">';
    }
}else{//comienzo del else principal
    logger('info','empleados.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
           " ||||Laboral->Empleados->Alta||");
    
    //miro si traigo datos por GET (es que es para editar los datos del empleado)
    if(isset($_GET['IdEmpleado'])){
        //extraigo los datos del empleado de la BBDD
        $datosEmpleado=$clsCNContabilidad->datosEmpleado($_GET['IdEmpleado']);
    }
    $usuario=$clsCNUsu->DatosUsuario($_SESSION['usuario']);
    
    //aqui dirijo a la presentacion en PC o Movil (APP)
    if($_SESSION['navegacion']==='movil'){
        html_paginaLaboralEmpleadosMovil($datosEmpleado,$usuario,$clsCNContabilidad,$editarEmpleado);
    }else{
        html_paginaLaboralEmpleados($datosEmpleado,$usuario,$clsCNContabilidad,$editarEmpleado);
    }
}

function html_paginaLaboralEmpleados($datosEmpleado,$usuario,$clsCNContabilidad,$editarEmpleado){
?>
<!DOCTYPE html>
<HTML>
<HEAD>
    
<!--            HE INCLUIDO AQUI ESTAS LIBRERIAS DE jQuery PACO-->
<script src="https://code.jquery.com/jquery-1.8.3.js"></script>
<script src="../js/jQuery/js/jquery.dataTables.qualidad.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />

<link rel="stylesheet" href="../js/jQuery/css/jquery-ui.qualidad.css" />
<script src="https://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
<script src="../js/jQuery/ui/jquery.blockUI.js"></script>

<style type="text/css">
    @import "../js/jQuery/css/demo_table_jui.css";
    @import "../js/jQuery/themes/smoothness/jquery-ui-1.8.4.custom.css";
    @import "../js/jQuery/css/table_qualidad.css";
</style>
<!--       FIN     HE INCLUIDO AQUI ESTAS LIBRERIAS DE jQuery PACO-->

<link href="../js/jQuery/input-file/jquery.file.css" rel="stylesheet" type="text/css" />
<script src="../js/jQuery/input-file/jquery.file.js" type="text/javascript"></script>
    
<?php
//estas funciones son generales
//librerias_jQuery();
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
  
  
  //comprobacion del campo 'nombre'
  if (document.form1.nombre.value == ''){ 
    textoError=textoError+"Hay que indicar el nombre.\n";
    document.form1.nombre.style.borderColor='#FF0000';
    document.form1.nombre.title ='Hay que indicar el nombre.';
    esValido=false;
  }
  
  //comprobacion del campo 'apellido1'
  if (document.form1.apellido1.value == ''){ 
    textoError=textoError+"Hay que indicar el primer apellido.\n";
    document.form1.apellido1.style.borderColor='#FF0000';
    document.form1.apellido1.title ='Hay que indicar el primer apellido.';
    esValido=false;
  }
  
  //comprobacion del campo 'Horas' si tipoJornada=Parcial
  if (document.form1.tipoJornada.value == 'Parcial'){ 
    if (document.form1.HorasN.value == ''){ 
      textoError=textoError+"Hay que indicar las horas.\n";
      document.form1.HorasN.style.borderColor='#FF0000';
      document.form1.HorasN.title ='Hay que indicar las horas.';
      esValido=false;
    }
  }
  
  //comprobar las fechas de nacimiento
  if (document.form1.Hijos.value == '1'){
    //recorro todos los name que empiecen por fechaN+numero
    var fechasN=new Array();
    $(document).ready(function(){
        $('#form1').find(":input").each(function(){
            var elemento=this;
            //comprobamos el nombre del elemento y lo guardamos en ua array segun sea cantidad, precio, importe y concepto
            var nombreElemento=elemento.name;
            if(nombreElemento.substring(0,6)==='fechaN'){//es un elemento fechaN
                fechasN[nombreElemento.substr(6,3)]=elemento.value;
            }            
        });
    });
    //compruebo que los arrays lleven datos (lentgh)
    //si fuese 0 es que no se a introducido ninguna fecha de nacimiento y eso es incongruente
    if(fechasN.length===0){
        textoError=textoError+"Debe introducidir los años de nacimiento de el/los hijo/s.\n";
        esValido=false;
    }
    
    //recorro el arrayy si hay algun campo vacio lo indico
    for(i=0;i<fechasN.length;i++){
        if(fechasN[i]===''){
            textoError=textoError+"Hay que indicar el año de nacimiento "+(i+1)+".\n";
            document.getElementById('fechaN'+i).style.borderColor='#FF0000';
            document.getElementById('fechaN'+i).title ='Hay que indicar el año de nacimiento '+i+'.';
            esValido=false;
        }
    }
  } 
  
  //compruebo que no haya error en el span AJAX (de la carga del fichero)
  //primero compruebo que haya texto en la observacion, sino no se guarda nada
  if(document.form1.strObservaciones.value!==''){
    if ((document.getElementById("txt_file").innerHTML.indexOf('Nombre de fichero existe ya')!=-1) ||
        (document.getElementById("txt_file").innerHTML.indexOf('Este fichero NO es PDF')!=-1)){
      textoError=textoError+"El fichero a adjuntar no es correcto.\n";
      esValido=false;
    }
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

//borrar empleado
function borrarEmpleado(id){
    if (confirm("¿Desea borrar el registro del empleado de la base de datos?"))
    {
        window.location='../vista/empleadoBorrar.php?id='+id;
    }
}

function cambiaJornada(objeto){
    if(objeto.value==='Parcial'){
        document.getElementById('HorasN').style.display='block';
        document.getElementById('HorasT').style.display='block';
    }else{
        document.getElementById('HorasN').style.display='none';
        document.getElementById('HorasT').style.display='none';
    }
}

function cambiaHijos(objeto){
    if(objeto.value==='1'){
        $('#hijosNacimiento').slideDown(1000);
    }else{
        $('#hijosNacimiento').slideUp(1000);
    }
}

$(document).ready(function() {
    cambiaJornada(document.form1.tipoJornada);
    cambiaHijos(document.form1.Hijos);
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
      onLoad="rotulo_status();
              <?php if(isset($_GET['borrar'])&& $_GET['borrar']=='si'){
                                       echo 'borrarEmpleado('. $_GET['IdEmpleado'].');';
                                       }?>">
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
if(isset($_GET['IdEmpleado'])){
    $cabeceraNumero='080102';
}else{
    $cabeceraNumero='080101';
}
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
    <form id="form1" name="form1" method="post" enctype="multipart/form-data" action="../vista/empleados.php" onSubmit="desactivaBoton();">
        
      <table width="640" border="0" class="zonaactiva">
        <tr> 
          <td class="subtitulo" colspan="9">&nbsp;Datos del Empleado</td>
        </tr>
        <tr>
            <td width="7%"></td>
            <td width="25%"></td>
            <td width="6%"></td>
            <td width="25%"></td>
            <td width="6%"></td>
            <td width="25%"></td>
            <td width="6%"></td>
        </tr>
        <tr>
            <td></td>
            <td>
              <div align="left">
              <label class="nombreCampo">Número Empleado</label>
              <input class="textbox1" type="text" name="NumEmpleado" maxlength="10" tabindex="1"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     value="<?php if(isset($datosEmpleado['NumEmpleado'])){echo $datosEmpleado['NumEmpleado'];}?>"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
            </td>
        </tr>
        <tr>
            <td style="height: 15px;"></td>
        </tr>
        <tr>
            <td></td>
            <td>
              <div align="left">
              <label class="nombreCampo">Nombre</label>
              <input class="textbox1" type="text" name="nombre" maxlength="50" tabindex="2"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     value="<?php if(isset($datosEmpleado['nombre'])){echo $datosEmpleado['nombre'];}?>"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
            </td>
            <td></td>
            <td>
              <div align="left">
              <label class="nombreCampo">Primer Apellido</label>
              <input class="textbox1" type="text" name="apellido1" maxlength="50" tabindex="3"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     value="<?php if(isset($datosEmpleado['apellido1'])){echo $datosEmpleado['apellido1'];}?>"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
            </td>
            <td></td>
            <td>
              <div align="left">
              <label class="nombreCampo">Segundo Apellido</label>
              <input class="textbox1" type="text" name="apellido2" maxlength="50" tabindex="4"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     value="<?php if(isset($datosEmpleado['apellido2'])){echo $datosEmpleado['apellido2'];}?>"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
            </td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <div align="left">
                    <label class="nombreCampo">Tipo Documento</label>
                    <?php
                    $selecDNI='';
                    $selecNIE='';
                    $selecPas='';
                    if(isset($datosEmpleado['tipoDocumento'])){
                        if($datosEmpleado['tipoDocumento']==='DNI'){
                            $selecDNI='selected';
                        }else
                        if($datosEmpleado['tipoDocumento']==='NIE'){
                            $selecNIE='selected';
                        }else
                        if($datosEmpleado['tipoDocumento']==='Pasaporte'){
                            $selecPas='selected';
                        }
                    }
                    ?>
                    <select name="tipoDocumento" class="textbox1" tabindex="5"
                            onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);">
                        <option value = "DNI" <?php echo $selecDNI; ?>>DNI</option>
                        <option value = "NIE" <?php echo $selecNIE; ?>>NIE</option>
                        <option value = "Pasaporte" <?php echo $selecPas; ?>>Pasaporte</option>
                    </select>
                </div>
            </td>
            <td></td>
            <td>
              <div align="left">
              <label class="nombreCampo">Número Documento</label>
              <input class="textbox1" type="text" name="numDocumento" maxlength="40" tabindex="6"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     value="<?php if(isset($datosEmpleado['numDocumento'])){echo $datosEmpleado['numDocumento'];}?>"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);vaciarCampo('txt_validar');validarNIFCIF(this);"/>
              </div>
            </td>
            <td></td>
            <td>
              <div align="left">
              <label class="nombreCampo">Nº Afiliación S.S.</label>
              <input class="textbox1" type="text" name="numAfiliacion" maxlength="30" tabindex="7"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     value="<?php if(isset($datosEmpleado['numAfiliacion'])){echo $datosEmpleado['numAfiliacion'];}?>"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="3" height="25px"></td>
            <td><span class="validar" id="txt_validar"></span></td>
        </tr>
        <tr>
            <td style="height: 15px;"></td>
        </tr>
        <tr>
            <td colspan="7" style="height: 15px;"><hr class="lineaSeparacion" /></td>
        </tr>
      </table>
        
      <table width="640" border="0" class="zonaactiva">
        <tr>
            <td width="7%"></td>
            <td width="30%"></td>
            <td width="6%"></td>
            <td width="13%"></td>
            <td width="6%"></td>
            <td width="13%"></td>
            <td width="6%"></td>
            <td width="13%"></td>
            <td width="6%"></td>
        </tr>
        <tr>
            <td></td>
            <td>
              <div align="left">
              <label class="nombreCampo">Dirección</label>
              <input class="textbox1" type="text" name="calle" maxlength="70" tabindex="8"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     value="<?php if(isset($datosEmpleado['calle'])){echo $datosEmpleado['calle'];}?>"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
            </td>
            <td></td>
            <td>
              <div align="left">
              <label class="nombreCampo">Número</label>
              <input class="textbox1" type="text" name="numero" maxlength="10" tabindex="9"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     value="<?php if(isset($datosEmpleado['numero'])){echo $datosEmpleado['numero'];}?>"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
            </td>
            <td></td>
            <td>
              <div align="left">
              <label class="nombreCampo">Piso</label>
              <input class="textbox1" type="text" name="piso" maxlength="10" tabindex="10"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     value="<?php if(isset($datosEmpleado['piso'])){echo $datosEmpleado['piso'];}?>"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
            </td>
            <td></td>
            <td>
              <div align="left">
              <label class="nombreCampo">Letra</label>
              <input class="textbox1" type="text" name="letra" maxlength="5" tabindex="11"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     value="<?php if(isset($datosEmpleado['letra'])){echo $datosEmpleado['letra'];}?>"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
            </td>
            <td></td>
        </tr>
      </table>        
      <table width="640" border="0" class="zonaactiva">
        <tr>
            <td width="7%"></td>
            <td width="25%"></td>
            <td width="6%"></td>
            <td width="25%"></td>
            <td width="6%"></td>
            <td width="25%"></td>
            <td width="6%"></td>
        </tr>
        <tr>
            <td></td>
            <td>
              <div align="left">
              <label class="nombreCampo">Código Postal</label>
              <input class="textbox1" type="text" name="codPostal" maxlength="5" tabindex="12"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     value="<?php if(isset($datosEmpleado['codPostal'])){echo $datosEmpleado['codPostal'];}?>"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
            </td>
            <td></td>
            <td>
              <div align="left">
              <label class="nombreCampo">Población</label>
              <input class="textbox1" type="text" name="poblacion" maxlength="70" tabindex="13"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     value="<?php if(isset($datosEmpleado['poblacion'])){echo $datosEmpleado['poblacion'];}?>"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
            </td>
            <td></td>
            <td>
              <div align="left">
              <label class="nombreCampo">Provincia</label>
              <input class="textbox1" type="text" name="provincia" maxlength="25" tabindex="14"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     value="<?php if(isset($datosEmpleado['provincia'])){echo $datosEmpleado['provincia'];}?>"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
            </td>
            <td></td>
        </tr>
        <tr>
            <td style="height: 15px;"></td>
        </tr>
        <tr>
            <td colspan="7" style="height: 15px;"><hr class="lineaSeparacion" /></td>
        </tr>
    </table>
    <table width="640" border="0" class="zonaactiva">
        <tr>
            <td width="7%"></td>
            <td width="16%"></td>
            <td width="5%"></td>
            <td width="16%"></td>
            <td width="5%"></td>
            <td width="17%"></td>
            <td width="5%"></td>
            <td width="23%"></td>
            <td width="6%"></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <div align="left">
                <label class="nombreCampo">Fecha Alta</label>
                  <?php
                  datepicker_español('fechaAlta');
                  date_default_timezone_set('Europe/Madrid');
                  ?>
                  <style type="text/css">
                  /* para que no salga el rectangulo inferior */        
                  .ui-widget-content {
                      border: 0px solid #AAAAAA;
                  }
                  </style>
                  <input class="textbox1" type="text" id="fechaAlta" name="fechaAlta" maxlength="38" tabindex="15"
                         value="<?php if(isset($datosEmpleado['fechaAlta'])){echo $datosEmpleado['fechaAlta'];}?>"
                         onKeyUp="this.value=formateafechaEntrada(this.value);" 
                         onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                         onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
                </div>
            </td>
            <td></td>
            <td>
                <?php if($editarEmpleado==='SI'){ ?>
                <div align="left">
                <label class="nombreCampo">Fecha Baja</label>
                  <?php
                  datepicker_español('fechaBaja');
                  date_default_timezone_set('Europe/Madrid');
                  ?>
                  <style type="text/css">
                  /* para que no salga el rectangulo inferior */        
                  .ui-widget-content {
                      border: 0px solid #AAAAAA;
                  }
                  </style>
                  <input class="textbox1" type="text" id="fechaAlta" name="fechaBaja" maxlength="38" tabindex="16"
                         value="<?php if(isset($datosEmpleado['fechaBaja'])){echo $datosEmpleado['fechaBaja'];}?>"
                         onKeyUp="this.value=formateafechaEntrada(this.value);" 
                         onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                         onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
                </div>
                <?php } ?>
            </td>
            <td></td>
            <td>
                <div align="left">
                <label class="nombreCampo">Vto. Contrato</label>
                  <?php
                  datepicker_español('fechaVtoContrato');
                  date_default_timezone_set('Europe/Madrid');
                  ?>
                  <style type="text/css">
                  /* para que no salga el rectangulo inferior */        
                  .ui-widget-content {
                      border: 0px solid #AAAAAA;
                  }
                  </style>
                  <input class="textbox1" type="text" id="fechaVtoContrato" name="fechaVtoContrato" maxlength="38" tabindex="17"
                         value="<?php if(isset($datosEmpleado['fechaVtoContrato'])){echo $datosEmpleado['fechaVtoContrato'];}?>"
                         onKeyUp="this.value=formateafechaEntrada(this.value);" 
                         onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                         onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
                </div>
            </td>
            <td></td>
            <td>
              <div align="left">
              <label class="nombreCampo">Categoría</label>
              <input class="textbox1" type="text" name="Categoria" maxlength="50" tabindex="18"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     value="<?php if(isset($datosEmpleado['Categoria'])){echo $datosEmpleado['Categoria'];}?>"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
            </td>
            <td></td>
        </tr>
      </table>
        
      <table width="640" border="0" class="zonaactiva">
        <tr>
            <td width="7%"></td>
            <td width="25%"></td>
            <td width="6%"></td>
            <td width="25%"></td>
            <td width="6%"></td>
            <td width="10%"></td>
            <td width="15%"></td>
            <td width="6%"></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <div align="left">
                    <label class="nombreCampo">Tipo Contrato</label>
                    <?php
                    $selecIndef='';
                    $selecTemp='';
                    $selecPrac='';
                    $selecForm='';
                    if(isset($datosEmpleado['tipoContrato'])){
                        if($datosEmpleado['tipoContrato']==='Indefinido'){
                            $selecIndef='selected';
                        }else
                        if($datosEmpleado['tipoContrato']==='Temporal'){
                            $selecTemp='selected';
                        }else
                        if($datosEmpleado['tipoContrato']==='Practicas'){
                            $selecPrac='selected';
                        }else
                        if($datosEmpleado['tipoContrato']==='Formacion'){
                            $selecForm='selected';
                        }
                    }
                    ?>
                    <select name="tipoContrato" class="textbox1" tabindex="19"
                            onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);">
                        <option value = "Indefinido" <?php echo $selecIndef; ?>>Indefinido</option>
                        <option value = "Temporal" <?php echo $selecTemp; ?>>Temporal</option>
                        <option value = "Practicas" <?php echo $selecPrac; ?>>Prácticas</option>
                        <option value = "Formacion" <?php echo $selecForm; ?>>Formación</option>
                    </select>
                </div>
            </td>
            <td></td>
            <td>
                <div align="left">
                    <label class="nombreCampo">Tipo Jornada</label>
                    <?php
                    $selecComp='';
                    $selecParc='';
                    if(isset($datosEmpleado['tipoJornada'])){
                        if($datosEmpleado['tipoJornada']==='Completa'){
                            $selecComp='selected';
                        }else
                        if($datosEmpleado['tipoJornada']==='Parcial'){
                            $selecParc='selected';
                        }
                    }
                    ?>
                    <select name="tipoJornada" class="textbox1" tabindex="20" onchange="cambiaJornada(this);"
                            onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);">
                        <option value = "Completa" <?php echo $selecComp; ?>>Completa</option>
                        <option value = "Parcial" <?php echo $selecParc; ?>>Parcial</option>
                    </select>
                </div>
            </td>
            <td></td>
            <td>
              <div align="left" id="HorasN" style="display: none;">
              <label class="nombreCampo">Horas</label>
              <input class="textbox1" type="text" name="HorasN" maxlength="10" tabindex="21"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     value="<?php if(isset($datosEmpleado['HorasN'])){echo $datosEmpleado['HorasN'];}?>"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
            </td>
            <td>
                <div align="left" id="HorasT" style="display: none;">
                    <label class="nombreCampo">Tipo Jornada</label>
                    <?php
                    $selecSem='';
                    $selecDia='';
                    if(isset($datosEmpleado['HorasT'])){
                        if($datosEmpleado['HorasT']==='semanal'){
                            $selecSem='selected';
                        }else
                        if($datosEmpleado['HorasT']==='diaria'){
                            $selecDia='selected';
                        }
                    }
                    ?>
                    <select name="HorasT" class="textbox1" tabindex="22"
                            onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);">
                        <option value = "semanal" <?php echo $selecSem; ?>>Semanal</option>
                        <option value = "diaria" <?php echo $selecDia; ?>>Diaria</option>
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td style="height: 15px;"></td>
        </tr>
      </table>
        
    <?php
    $displayForm='none';
    if($editarEmpleado==='SI'){
        $displayForm='block';
    }
    ?>
    <div style="display: <?php echo $displayForm;?>;">    
      <table width="340px" border="0" class="zonaactiva">
        <tr>
            <td width="7%"></td>
            <td width="30%"></td>
            <td width="6%"></td>
            <td width="15%"></td>
            <td width="42%"></td>
        </tr>
        <tr>
            <td colspan="5" style="height: 15px;"><hr class="lineaSeparacion" /></td>
        </tr>
        <tr> 
          <td></td>
          <td>
              <div align="left">
                <label class="nombreCampo">Situación</label>
                <?php
                $selecSolt='';
                $selecCasado='';
                $selecSep='';
                if(isset($datosEmpleado['SituacionFamiliar'])){
                    if($datosEmpleado['SituacionFamiliar']==='soltero'){
                        $selecSolt='selected';
                    }else
                    if($datosEmpleado['SituacionFamiliar']==='casado'){
                        $selecCasado='selected';
                    }else
                    if($datosEmpleado['SituacionFamiliar']==='separado'){
                        $selecSep='selected';
                    }else
                    if($datosEmpleado['SituacionFamiliar']==='viudo'){
                        $selecSep='selected';
                    }
                }
                ?>
                <select name="SituacionFamiliar" class="textbox1" tabindex="23"
                        onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);">
                    <option value = "soltero" <?php echo $selecSolt; ?>>Soltero</option>
                    <option value = "casado" <?php echo $selecCasado; ?>>Casado</option>
                    <option value = "separado" <?php echo $selecSep; ?>>Separado/Divorciado</option>
                    <option value = "viudo" <?php echo $selecSep; ?>>Viudo</option>
                </select>
              </div>
          </td>
          <td></td>
          <td>
              <div align="left">
                <label class="nombreCampo">Hijos</label>
                <?php
                $selecNO='';
                $selecSI='';
                if(isset($datosEmpleado['Hijos'])){
                    if($datosEmpleado['Hijos']==='0'){
                        $selecNO='selected';
                    }else
                    if($datosEmpleado['Hijos']==='1'){
                        $selecSI='selected';
                    }
                }
                ?>
                <select name="Hijos" class="textbox1" tabindex="24" onchange="cambiaHijos(this);"
                        onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);">
                    <option value = "0" <?php echo $selecNO; ?>>NO</option>
                    <option value = "1" <?php echo $selecSI; ?>>SI</option>
                </select>
              </div>
          </td>
          <td></td>
        </tr>
        <tr>
            <td height="15px"></td>
        </tr>
      </table>
    </div>
          
    <div align="left" id="hijosNacimiento" style="display: none;">
      <table width="280" border="0" class="zonaactiva">
        <tr>
            <td width="20%"></td>
            <td width="20%"></td>
            <td width="60%"></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <script>
                function lineaHijo(linea,fecha){
                    var txtLinea='<tr id="linea'+linea+'" class="item-row">'+ 
                                '<td valign="top">'+
                                '<a class="delete" href="javascript:;" title="Borrar Linea"><font color="#FF0000">X</font></a>'+
                                '</td>'+
                                '<td>'+
                                '<input class="textbox1" type="text" name="fechaN'+linea+'" id="fechaN'+linea+'" name="fechaN'+linea+'" maxlength="4" '+
                                       'value="'+fecha+'"'+
                                       'onkeypress="return solonumeros(event);"'+ 
                                       'onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"'+
                                       'onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />'+
                                '</td>'+
                                '</tr>';
                    return txtLinea;
                }
                
                $(document).ready(function() {
                  //cargo los datos de la tabla tbempleados_hijos
                  <?php
                  $cont=1;
                  for($i=0;$i<count($datosEmpleado['fechaNacimiento']);$i++){
                  ?>
                    var id=$("#lineasFactura tr:last").attr("id");
                    $("#"+id+":last").after(
                        lineaHijo('<?php echo $cont;?>','<?php echo $datosEmpleado['fechaNacimiento'][$i];?>')
                    );
                    if ($(".delete").length > 0) $(".delete").show();
                  <?php        
                    $cont++;
                  }
                  ?>

                  $("#addrow").click(function(){
                    var id=$("#lineasFactura tr:last").attr("id");  
                    $("#"+id+":last").after(
                            lineaHijo(document.form1.linea.value,'')
                            );
                    //para cargar el datepicker a este campo
//                    $(function() {
//                        $("#fechaN"+document.form1.linea.value).datepicker();
//                    });
                    
                    document.form1.linea.value=parseInt(document.form1.linea.value)+1;
                    if ($(".delete").length > 0) $(".delete").show();
                  });


                  $(".delete").live('click',function(){
                    $(this).parents('.item-row').remove();
                    if ($(".delete").length < 1) $(".delete").hide();
                  });
                });
                </script>
                <table class="zonaactivafactura" id="lineasFactura">
                    <tr id="hiderow">
                        <input type="hidden" name="linea" value="0" />
                        <div align="left">
                            <a id="addrow" href="javascript:;" title="Añadir Fecha Nacimiento">Añadir fecha Nacimiento</a><br/><br/>
                        </div>
                    </tr>
                </table>
            </td>
            <td></td>
        </tr>
        <tr>
            <td height="15px"></td>
        </tr>
      </table>
      </div>
        
      <table width="640" border="0" class="zonaactiva">
        <tr>
            <td width="30%"></td>
            <td width="10%"></td>
            <td width="60%"></td>
        </tr>
        <tr>
            <td colspan="5" style="height: 15px;"><hr class="lineaSeparacion" /></td>
        </tr>
        <tr>
            <td>
                <div align="right">
                    <?php
                    //averiguo si es dar el alta o es otro cambiosolicitado
                    //para eso veo si la pregunta tiene respuestas, sin las tiene es un alta
                    $tieneRespuestas = $clsCNContabilidad->tieneRespuestasLaPreguntaDelEmpleado($_GET['IdEmpleado']);
                    
                    if($tieneRespuestas === 'NO'){
                        ?>
                        <p>¿Tramitado el alta?</p>
                        <?php
                    }else{
                        ?>
                        <p>¿Tramitado el cambio solicitado?</p>
                        <?php
                    }
                    ?>
                </div>
            </td>
            <td>
                <?php
                $checked = '';
                if($datosEmpleado['chatActualizado'] == '1'){
                    $checked = 'checked';
                }
                $disabled = '';
                if(substr($_SESSION['cargo'],0,7)==='Usuario'){
                    $disabled = 'disabled';
                }
                ?>
                <input type="checkbox" name="chatActualizado" <?php echo $checked.' '.$disabled; ?> />
            </td>
        </tr>
      </table>  
        
    <?php
    $displayForm='none';
    if($editarEmpleado==='NO'){
        $displayForm='block';
    }
    ?>
    <div style="display: <?php echo $displayForm;?>;">    
    <table border="0" class="zonaactiva">
      <tr> 
        <td colspan="4" class="subtitulo">Observaciones</td>
      </tr>
      <tr> 
        <td colspan="4">
            <textarea class="textbox1area" name="strObservaciones" rows=4 
                      cols="20" onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                      onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"><?php //if(isset($_POST['strConsulta'])){echo $_POST['strConsulta'];}?></textarea> 
        </td>
      </tr>
      <tr>
          <td width="200" class="nombreCampo">Usuario:<br/> <?php echo $usuario['strNombre'].' '.$usuario['strApellidos'] ; ?></td>
          <td width="50" class="nombreCampo">
            <?php date_default_timezone_set('Europe/Madrid'); ?>
            Fecha:<br/> <?php print date("d/m/y"); ?>
          </td>
          <td width="20"></td>
          <td align="left">
              <script>
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
              <input type="file" class="file" id="doc" name="doc" onchange="check_fileConsulta(this.value);" /><br/>
              <span class="nombreCampo" id="txt_file">El documento debe ser PDF y no superior a 1 MB</span><br/>
              <input type="hidden" name="cmdAltaConsulta" />
          </td>
      </tr>
        <tr>
            <td height="15x"></td>
        </tr>
    </table>
    </div>
        
      <P>
        <input type="button" class="button" name="cmdAlta" id="cmdAlta"
               value = "<?php if(isset($_GET['IdEmpleado'])){echo 'Grabar';}else{echo 'Solicitar al Alta';}?>"
               onclick="javascript:validar2();" /> 
        <input type="button" class="buttonAzul" value="Volver" onclick="javascript:history.back();" />
        <input type="Reset" class="button"
               value="<?php if(isset($_GET['IdEmpleado'])){echo 'Datos iniciales';}else{echo 'Vaciar Datos';} ?>"
               name="cmdReset"/>
        <input type="hidden"  name="cmdAlta" value="Aceptar" />
        <input type="hidden"  name="existeEmpleado" value="<?php if(isset($_GET['IdEmpleado'])){echo 'SI';}else{echo 'NO';}?>" />
        <input type="hidden"  name="IdEmpleado" value="<?php if(isset($_GET['IdEmpleado'])){echo $_GET['IdEmpleado'];}?>" />
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
    <td colspan="2"></td>
    <td bgcolor="#FFFFFF">
    <?php
    //compruebo que estamos editando
    $displayChat='none';
    if($editarEmpleado==='SI'){
        $displayChat='block';
    }
    if($datosEmpleado['Observaciones']==='0'){
        $displayChat='none';
    }
    ?>
    <div style="display: <?php echo $displayChat;?>;">  
        <?php
            if($_SESSION['navegacion']==='movil'){
                html_paginaEmpleadosMobil('','',$datosUsuarioActivo,$datosEmpleado['Observaciones']);
            }else{
                html_paginaEmpleados('','',$datosUsuarioActivo,$datosEmpleado['Observaciones']);
            }
        ?>
    </div>  
    </td>
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
}//fin html_pagina() 

function html_paginaLaboralEmpleadosMovil($datosEmpleado,$usuario,$clsCNContabilidad,$editarEmpleado){
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
<body onLoad="<?php if(isset($_GET['borrar'])&& $_GET['borrar']=='si'){
                                       echo 'borrarEmpleado('. $_GET['IdEmpleado'].');';
                                       }?>"
      class="api jquery-mobile archive category category-widgets category-2 listing single-author"> 

<div data-role="page" id="empleados">
<?php
eventosInputText();
?>
<script language="JavaScript">
function validarP1(){
  esValido=true;
  textoError='';
  
  //comprobacion del campo 'nombre'
  if (document.form1.nombre.value == ''){ 
    textoError=textoError+"Hay que indicar el nombre.\n";
    $('#nombre').parent().css('border-color','red');
    esValido=false;
  }
  
  //comprobacion del campo 'apellido1'
  if (document.form1.apellido1.value == ''){ 
    textoError=textoError+"Hay que indicar el primer apellido.\n";
    $('#apellido1').parent().css('border-color','red');
    esValido=false;
  }


  //indicar el mensaje de error si es 'esValido' false
  if (!esValido){
          alert(textoError);
  }

  if(esValido==true){
      $('#pantalla1').slideUp(1000);
      $('#pantalla2').slideDown(1000);
  }else{
      return false;
  }  
}

function validarP2(){
    $('#pantalla2').slideUp(1000);
    $('#pantalla3').slideDown(1000);
}

function validarP3(){
    $('#pantalla3').slideUp(1000);
    $('#pantalla4').slideDown(1000);
    $('#pantalla5').slideDown(1000);
}

function validarP4(){
    document.getElementById("cmdAlta").value = "Enviando...";
    document.getElementById("cmdAlta").disabled = true;
    document.form1.submit();
}


//borrar empleado
function borrarEmpleado(id){
    if (confirm("¿Desea borrar el registro del empleado de la base de datos?"))
    {
        window.location='../vista/empleadoBorrar.php?id='+id;
    }
}


function cambiaJornada(objeto){
    if(objeto.value==='Parcial'){
        $('#HorasN').slideDown(1000);
        $('#HorasT').slideDown(1000);
    }else{
        $('#HorasN').slideUp(1000);
        $('#HorasT').slideUp(1000);
    }
}

function cambiaHijos(objeto){
    if(objeto.value==='1'){
        $('#hijosNacimiento').slideDown(1000);
    }else{
        $('#hijosNacimiento').slideUp(1000);
    }
}

$(document).ready(function() {
    cambiaJornada(document.form1.tipoJornada);
    cambiaHijos(document.form1.Hijos);
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


function lineaHijo(linea,fecha){
    var txtLinea='<tr id="linea'+linea+'" class="item-row">'+ 
                '<td>'+
                '<a class="delete" data-ajax="false" href="javascript:;" title="Borrar Linea"><font color="#FF0000">X</font></a>'+
                '</td>'+
                '<td>'+
                '<input type="text" name="fechaN'+linea+'" id="fechaN'+linea+'" maxlength="4" '+
                       'value="'+fecha+'"'+
                       'onblur="" />'+
                '</td>'+
                '</tr>';
    return txtLinea;
}

$(document).ready(function() {
  //cargo los datos de la tabla tbempleados_hijos
  <?php
  $cont=1;
  for($i=0;$i<count($datosEmpleado['fechaNacimiento']);$i++){
  ?>
    var id=$("#lineasFactura tr:last").attr("id");
    $("#"+id+":last").after(
        lineaHijo('<?php echo $cont;?>','<?php echo $datosEmpleado['fechaNacimiento'][$i];?>')
    );
    if ($(".delete").length > 0) $(".delete").show();
  <?php        
    $cont++;
  }
  ?>

  $("#addrow").click(function(){
    var id=$("#lineasFactura tr:last").attr("id");  
    $("#"+id+":last").after(
            lineaHijo(document.form1.linea.value,'')
            );

    document.form1.linea.value=parseInt(document.form1.linea.value)+1;
    if ($(".delete").length > 0) $(".delete").show();
  });


  $(".delete").on('click',function(){
    $(this).parents('.item-row').remove();
    if ($(".delete").length < 1) $(".delete").hide();
  });
});



</script>

<?php
include_once '../movil/cabeceraMovil.php';
?>

<div data-role="content" data-theme="a">
    <form id="form1" name="form1" method="post" enctype="multipart/form-data" action="../vista/empleados.php" data-ajax="false">
        <div id="pantalla1">
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
                            <label><b>Datos del Empleado</b></label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label>Número Empleado</label>
                            <input type="text" name="NumEmpleado" id="NumEmpleado" maxlength="10" onfocus="onFocusInputTextM(this);"
                                   value="<?php if(isset($datosEmpleado['NumEmpleado'])){echo $datosEmpleado['NumEmpleado'];}?>"
                                   onblur="" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <label>Nombre</label>
                            <input type="text" name="nombre" id="nombre" maxlength="50" onfocus="onFocusInputTextM(this);"
                                   value="<?php if(isset($datosEmpleado['nombre'])){echo $datosEmpleado['nombre'];}?>"
                                   onblur="" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <label>Primer Apellido</label>
                            <input type="text" name="apellido1" id="apellido1" maxlength="50" onfocus="onFocusInputTextM(this);"
                                   value="<?php if(isset($datosEmpleado['apellido1'])){echo $datosEmpleado['apellido1'];}?>"
                                   onblur="" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <label>Segundo Apellido</label>
                            <input type="text" name="apellido2" id="apellido2" maxlength="50" onfocus="onFocusInputTextM(this);"
                                   value="<?php if(isset($datosEmpleado['apellido2'])){echo $datosEmpleado['apellido2'];}?>"
                                   onblur="" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label>Documento: Tipo</label>
                            <select name="tipoDocumento" tabindex="5" data-native-menu="false" data-theme='a' data-mini="true">
                                <option value = "DNI" <?php if($datosEmpleado['tipoDocumento'] === 'DNI'){echo 'selected';} ?>>DNI</option>
                                <option value = "NIE" <?php if($datosEmpleado['tipoDocumento'] === 'NIE'){echo 'selected';} ?>>NIE</option>
                                <option value = "Pasaporte" <?php if($datosEmpleado['tipoDocumento'] === 'Pasaporte'){echo 'selected';} ?>>Pasaporte</option>
                            </select>
                        </td>
                        <td colspan="2">
                            <label>Número</label>
                            <input type="text" name="numDocumento" id="numDocumento" maxlength="40" onfocus="onFocusInputTextM(this);"
                                   value="<?php if(isset($datosEmpleado['numDocumento'])){echo $datosEmpleado['numDocumento'];}?>"
                                   onblur="" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <label>Nº Afiliación S.S.</label>
                            <input type="text" name="numAfiliacion" id="numAfiliacion" maxlength="30" onfocus="onFocusInputTextM(this);"
                                   value="<?php if(isset($datosEmpleado['numAfiliacion'])){echo $datosEmpleado['numAfiliacion'];}?>"
                                   onblur="" />
                        </td>
                    </tr>
                </tbody>
            </table>
            <input type="button" id="cmdAlta1" value = "Continuar" data-mini="true" onclick="javascript:validarP1();" />
        </div>
        
        <div id="pantalla2" style="display:none;">
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
                            <label><b>Datos del Empleado (2)</b></label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <label>Dirección</label>
                            <input type="text" name="calle" id="calle" maxlength="70" onfocus="onFocusInputTextM(this);"
                                   value="<?php if(isset($datosEmpleado['calle'])){echo $datosEmpleado['calle'];}?>"
                                   onblur="" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label>Número</label>
                            <input type="text" name="numero" id="numero" maxlength="10" onfocus="onFocusInputTextM(this);"
                                   value="<?php if(isset($datosEmpleado['numero'])){echo $datosEmpleado['numero'];}?>"
                                   onblur="" />
                        </td>
                        <td colspan="2">
                            <label>Piso</label>
                            <input type="text" name="piso" id="piso" maxlength="10" onfocus="onFocusInputTextM(this);"
                                   value="<?php if(isset($datosEmpleado['piso'])){echo $datosEmpleado['piso'];}?>"
                                   onblur="" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label>Letra</label>
                            <input type="text" name="letra" id="letra" maxlength="5" onfocus="onFocusInputTextM(this);"
                                   value="<?php if(isset($datosEmpleado['letra'])){echo $datosEmpleado['letra'];}?>"
                                   onblur="" />
                        </td>
                        <td colspan="2">
                            <label>Cod. Postal</label>
                            <input type="text" name="codPostal" id="codPostal" maxlength="5" onfocus="onFocusInputTextM(this);"
                                   value="<?php if(isset($datosEmpleado['codPostal'])){echo $datosEmpleado['codPostal'];}?>"
                                   onblur="" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <label>Población</label>
                            <input type="text" name="poblacion" id="poblacion" maxlength="70" onfocus="onFocusInputTextM(this);"
                                   value="<?php if(isset($datosEmpleado['poblacion'])){echo $datosEmpleado['poblacion'];}?>"
                                   onblur="" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <label>Provincia</label>
                            <input type="text" name="provincia" id="provincia" maxlength="25" onfocus="onFocusInputTextM(this);"
                                   value="<?php if(isset($datosEmpleado['provincia'])){echo $datosEmpleado['provincia'];}?>"
                                   onblur="" />
                        </td>
                    </tr>
                </tbody>
            </table>
            <input type="button" id="cmdAlta1" value = "Continuar" data-mini="true" onclick="javascript:validarP2();" />
        </div> 
        
        <div id="pantalla3" style="display:none;">
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
                            <label><b>Datos del Empleado (3)</b></label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label>Fecha Alta</label>
                            <?php
                            date_default_timezone_set('Europe/Madrid');
                            $fechaForm=date('d/m/Y');
                            datepicker_español('fechaAlta');
                            ?>
                            <input type="text" id="fechaAlta" name="fechaAlta" maxlength="38" 
                                   onKeyUp="this.value=formateafechaEntrada(this.value);" value="<?php if(isset($datosEmpleado['fechaAlta'])){echo $datosEmpleado['fechaAlta'];} ?>"
                                   onfocus="<?php if(!isset($datosEmpleado['fechaAlta'])){echo 'limpiaCampoFecha(this)';}?>"
                                   onblur=""
                                   onchange="" />
                        </td>
                        <td colspan="2">
                        <?php if($editarEmpleado==='SI'){ ?>
                            <label>Fecha Baja</label>
                            <?php
                            datepicker_español('fechaBaja');
                            ?>
                            <input type="text" id="fechaBaja" name="fechaBaja" maxlength="38" 
                                   onKeyUp="this.value=formateafechaEntrada(this.value);" value="<?php if(isset($datosEmpleado['fechaBaja'])){echo $datosEmpleado['fechaBaja'];} ?>"
                                   onfocus="<?php if(!isset($datosEmpleado['fechaBaja'])){echo 'limpiaCampoFecha(this)';}?>"
                                   onblur=""
                                   onchange="" />
                        <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label>Vto. Contrato</label>
                            <?php
                            datepicker_español('fechaVtoContrato');
                            ?>
                            <input type="text" id="fechaVtoContrato" name="fechaVtoContrato" maxlength="38" 
                                   onKeyUp="this.value=formateafechaEntrada(this.value);" value="<?php if(isset($datosEmpleado['fechaVtoContrato'])){echo $datosEmpleado['fechaVtoContrato'];} ?>"
                                   onfocus="<?php if(!isset($datosEmpleado['fechaVtoContrato'])){echo 'limpiaCampoFecha(this)';}?>"
                                   onblur=""
                                   onchange="" />
                        </td>
                        <td colspan="2">
                            <label>Categoría</label>
                            <input type="text" name="Categoria" id="Categoria" maxlength="50" onfocus="onFocusInputTextM(this);"
                                   value="<?php if(isset($datosEmpleado['Categoria'])){echo $datosEmpleado['Categoria'];}?>"
                                   onblur="" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label>Tipo Contrato</label>
                            <select name="tipoContrato" tabindex="19" data-native-menu="false" data-theme='a' data-mini="true">
                                <option value = "Indefinido" <?php if($datosEmpleado['tipoContrato'] === 'Indefinido'){echo 'selected';} ?>>Indefinido</option>
                                <option value = "Temporal" <?php if($datosEmpleado['tipoContrato'] === 'Temporal'){echo 'selected';} ?>>Temporal</option>
                                <option value = "Practicas" <?php if($datosEmpleado['tipoContrato'] === 'Practicas'){echo 'selected';} ?>>Prácticas</option>
                                <option value = "Formacion" <?php if($datosEmpleado['tipoContrato'] === 'Formacion'){echo 'selected';} ?>>Formación</option>
                            </select>
                        </td>
                        <td colspan="2">
                            <label>Tipo Jornada</label>
                            <select name="tipoJornada" tabindex="19" data-native-menu="false" data-theme='a' onchange="cambiaJornada(this);" data-mini="true">
                                <option value = "Completa" <?php if($datosEmpleado['tipoJornada'] === 'Completa'){echo 'selected';} ?>>Completa</option>
                                <option value = "Parcial" <?php if($datosEmpleado['tipoJornada'] === 'Parcial'){echo 'selected';} ?>>Parcial</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                          <div align="left" id="HorasN" style="display: none;">
                            <label>Horas</label>
                            <input type="text" name="HorasN" id="HorasN" maxlength="10" onfocus="onFocusInputTextM(this);"
                                   value="<?php if(isset($datosEmpleado['HorasN'])){echo $datosEmpleado['HorasN'];}?>"
                                   onblur="solonumerosM(this);" />
                          </div>
                        </td>
                        <td colspan="2">
                          <div align="left" id="HorasT" style="display: none;">
                            <label>Tipo Jornada</label>
                            <select name="HorasT" tabindex="22" data-native-menu="false" data-theme='a' data-mini="true">
                                <option value = "semanal" <?php if($datosEmpleado['HorasT'] === 'semanal'){echo 'selected';} ?>>Semanal</option>
                                <option value = "diaria" <?php if($datosEmpleado['HorasT'] === 'diaria'){echo 'selected';} ?>>Diaria</option>
                            </select>
                          </div>
                        </td>
                    </tr>
                </tbody>
            </table>            
            <input type="button" id="cmdAlta1" value = "Continuar" data-mini="true" onclick="javascript:validarP3();" />
        </div>
        
        <div id="pantalla4" style="display:none;">
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
                            <label><b>Datos del Empleado (4)</b></label>
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php
            $displayForm='none';
            if($editarEmpleado==='SI'){
                $displayForm='block';
            }
            ?>
            <div style="display: <?php echo $displayForm;?>;">    
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
                            <label>Situación</label>
                            <select name="SituacionFamiliar" tabindex="23" data-native-menu="false" data-theme='a' data-mini="true">
                                <option value = "soltero" <?php if($datosEmpleado['SituacionFamiliar'] === 'soltero'){echo 'selected';} ?>>Soltero</option>
                                <option value = "casado" <?php if($datosEmpleado['SituacionFamiliar'] === 'casado'){echo 'selected';} ?>>Casado</option>
                                <option value = "separado" <?php if($datosEmpleado['SituacionFamiliar'] === 'separado'){echo 'selected';} ?>>Separado/Divorciado</option>
                                <option value = "viudo" <?php if($datosEmpleado['SituacionFamiliar'] === 'viudo'){echo 'selected';} ?>>Viudo</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label>Hijos</label>
                            <select name="Hijos" tabindex="24" onchange="cambiaHijos(this);" data-native-menu="false" data-theme='a' data-mini="true">
                                <option value = "0" <?php if($datosEmpleado['Hijos'] === '0'){echo 'selected';} ?>>NO</option>
                                <option value = "1" <?php if($datosEmpleado['Hijos'] === '1'){echo 'selected';} ?>>SI</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>                
            </div>
            
            <div align="left" id="hijosNacimiento" style="display: none;">
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
                            <table id="lineasFactura">
                                <tbody>
                                    <tr id="hiderow">
                                        <input type="hidden" name="linea" value="0" />
                                        <a id="addrow" href="javascript:;" data-ajax="false" title="Añadir Fecha Nacimiento">Añadir fecha Nacimiento</a><br/><br/>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
            
            <table border="0" style="width: 100%;">
                <tbody>
                    <tr>
                        <td style="width: 22%;"></td>
                        <td style="width: 23%;"></td>
                        <td style="width: 23%;"></td>
                        <td style="width: 22%;"></td>
                    </tr>
                    <tr>
                        <hr/>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div align="right">
                                <?php
                                //averiguo si es dar el alta o es otro cambiosolicitado
                                //para eso veo si la pregunta tiene respuestas, sin las tiene es un alta
                                $tieneRespuestas = $clsCNContabilidad->tieneRespuestasLaPreguntaDelEmpleado($_GET['IdEmpleado']);

                                if($tieneRespuestas === 'NO'){
                                    ?>
                                    <p>¿Tramitado el alta?</p>
                                    <?php
                                }else{
                                    ?>
                                    <p>¿Tramitado el cambio solicitado?</p>
                                    <?php
                                }
                                ?>
                            </div>
                        </td>
                        <td>
                            <?php
                            $checked = '';
                            if($datosEmpleado['chatActualizado'] == '1'){
                                $checked = 'checked';
                            }
                            $disabled = '';
                            if(substr($_SESSION['cargo'],0,7)==='Usuario'){
                                $disabled = 'disabled';
                            }
                            ?>
                            <input type="checkbox" name="chatActualizado" <?php echo $checked.' '.$disabled; ?> />
                        </td>
                    </tr>
                </tbody>
            </table>  
            
            <?php
            $displayForm='none';
            if($editarEmpleado==='NO'){
                $displayForm='block';
            }
            ?>
            <div style="display: <?php echo $displayForm;?>;">    
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
                          <textarea name="strObservaciones" rows=4 cols="20"
                                    onfocus="onFocusInputTextM(this);"><?php //if(isset($_POST['strConsulta'])){echo $_POST['strConsulta'];}?></textarea> 
                      </td>
                    </tr>
                    <tr>
                        <td colspan="4">Usuario: <?php echo $usuario['strNombre'].' '.$usuario['strApellidos'] ; ?></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                          <?php date_default_timezone_set('Europe/Madrid'); ?>
                          Fecha: <?php print date("d/m/y"); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <input type="file" data-mini="true" id="doc" name="doc" onchange="check_fileConsulta(this.value);" /><br/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <span class="nombreCampo" id="txt_file">El documento debe ser PDF y no superior a 1 MB</span><br/>
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
                </tbody>
            </table>
            </div>            
            
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
                            <input type="button" name="cmdAlta" id="cmdAlta" data-theme="a" data-icon="forward" data-iconpos="right"
                                   value = "<?php if(isset($_GET['IdEmpleado'])){echo 'Grabar';}else{echo 'Alta';}?>"
                                   onclick="javascript:validarP4();" /> 
                        </td>
                        <td colspan="2">
                            <input type="Reset" data-theme="a"
                                   value="<?php if(isset($_GET['IdEmpleado'])){echo 'Datos Inic.';}else{echo 'Vaciar';} ?>"
                                   name="cmdReset"/>
                            <input type="hidden"  name="cmdAlta" value="Aceptar" />
                            <input type="hidden"  name="existeEmpleado" value="<?php if(isset($_GET['IdEmpleado'])){echo 'SI';}else{echo 'NO';}?>" />
                            <input type="hidden"  name="IdEmpleado" value="<?php if(isset($_GET['IdEmpleado'])){echo $_GET['IdEmpleado'];}?>" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </form>    
    
    <div id="pantalla5" style="display:none;">
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
                    <?php
                    //compruebo que estamos editando
                    $displayChat='none';
                    if($editarEmpleado==='SI'){
                        $displayChat='block';
                    }
                    if($datosEmpleado['Observaciones']==='0'){
                        $displayChat='none';
                    }
                    ?>
                    <div style="display: <?php echo $displayChat;?>;">  
                        <?php
                            if($_SESSION['navegacion']==='movil'){
                                html_paginaEmpleadosMobil('','',$datosUsuarioActivo,$datosEmpleado['Observaciones']);
                            }else{
                                html_paginaEmpleados('','',$datosUsuarioActivo,$datosEmpleado['Observaciones']);
                            }
                        ?>
                    </div>  
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
</div>
</div>
</body>    
</html>    
<?php    
}//fin html_paginaMovil()

?>




