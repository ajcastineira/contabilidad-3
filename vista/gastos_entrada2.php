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



//print_r($_GET);
$clsCNContabilidad=new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['mapeo']);
$clsCNUsu=new clsCNUsu();
$clsCNUsu->setStrBD($_SESSION['dbContabilidad']);


//codigo principal
//comprobamos si se ha submitido el formulario y que que valor viene en 'cmdAlta'
if(isset($_POST['cmdAlta']) && $_POST['cmdAlta']=='Alta'){
    logger('info','gastos.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
           " ||||Operaciones->Mis Gastos|| Ha pulsado 'Aceptar'(SinFactura)");

    $varRes = $clsCNContabilidad->AltaGastosMovimientosSinIVA(0,$_SESSION["idEmp"], $_POST['strCuenta'], $_POST["lngIngreso"],
                                     $_POST['strCuentaCli'], $_POST["lngCantidad"], $_POST["datFecha"],$_POST['optTipo'], $_POST['strCuentaBancos'],
                                     $_POST["lngPeriodo"], $_POST["lngEjercicio"], addslashes($_POST["strConcepto"]),$_POST['esAbono'], $_SESSION["strUsuario"]);   
    logger('warning','' ,
           ' $clsCNContabilidad->AltaGastosMovimientosSinIVA(0,' .$_SESSION["idEmp"].",'". $_POST['strCuenta']."','". $_POST["lngIngreso"]."','".
                                     $_POST['strCuentaCli']."','". $_POST["lngCantidad"]."','". $_POST["datFecha"]."','".$_POST['optTipo']."','". $_POST['strCuentaBancos']."',".
                                     $_POST["lngPeriodo"].",". $_POST["lngEjercicio"].",'". addslashes($_POST["strConcepto"])."','".$_POST['esAbono']."','". $_SESSION["strUsuario"]."');");
    
    
    if($varRes==FALSE){
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/error.php?id='.$varRes.'">';
    }else{
//        //paso por array los datos del formulario, por si se tuviesen que utilizar mas tarde (son los del POST)
//        $strPeriodo=$clsCNContabilidad->periodo($_POST["lngPeriodo"]);
//        
//        $datosForm=array(
//            "strCuenta"=>$_POST['strCuenta'],
//            "lngIngreso"=>$_POST["lngIngreso"],
//            "lngIngresoContabilidad"=>$_POST["lngIngresoContabilidad"],
//            "strCuentaCli"=>$_POST['strCuentaCli'],
//            "lngCantidad"=>$_POST["lngCantidad"],
//            "lngCantidadContabilidad"=>$_POST["lngCantidadContabilidad"],
//            "datFecha"=>$_POST["datFecha"],
//            "optTipo"=>$_POST['optTipo'],
//            "strCuentaBancos"=>$_POST['strCuentaBancos'],
//            "lngPeriodo"=>$_POST["lngPeriodo"],
//            "strPeriodo"=>$strPeriodo,
//            "lngEjercicio"=>$_POST["lngEjercicio"],
//            "strConcepto"=>$_POST["strConcepto"]
//        );
//        $compactada=serialize($datosForm);
//        $compactada=urlencode($compactada);
        
        //voy a la pagina de 'gastos_exito.php'
//        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/gastos_exito.php?op=SF&datos='.$compactada.'&esAbono='.$_POST["esAbono"].'">';
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/gastos_exito.php?op=SF">';
    }
}
//se viene del listado de editar asientos (listado_asientos2.php)
else if(isset($_GET['editar']) && $_GET['editar']==='SI'){
    logger('info','gastos_SF.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
           " ||||Operaciones->Modificar Asiento||");

    $datosUsuario=$clsCNUsu->DatosUsuario($_SESSION['usuario']);
    
    //se buscan los datos de este asiento para cargarlos en el formulario
    $datos=$clsCNContabilidad->DatosAsientoSF($_GET['Asiento'],$_GET['esAbono']);
    
    //si $datos[Borrado]='0' este asiento esta borrado por lo que redirecciono a 'default2.php'
    if(isset($datos['Borrado']) && $datos['Borrado']==='1'){
        //presento el formulario con los datos
        html_pagina($datosUsuario,$datos,'edicion');
    }else{
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/default2.php">';
    }
}
//se viende de dar a aceptar a editar un asiento
else if(isset($_POST['cmdAlta']) && $_POST['cmdAlta']=='Editar'){

    //primero doy de baja el asiento actual
    $OK=$clsCNContabilidad->DarBajaAsiento($_POST['Asiento']);
    
    //si $OK<> informamos del error 
    if($OK<>1){
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/error.php?id=No se a cambiado el asiento">';
    }else{
        $OK2 = $clsCNContabilidad->AltaGastosMovimientosSinIVA($_POST['Asiento'],$_SESSION["idEmp"],  $_POST['strCuenta'], $_POST["lngIngreso"],
                                         $_POST['strCuentaCli'], $_POST["lngCantidad"], $_POST["datFecha"],$_POST['optTipo'],$_POST['strCuentaBancos'],
                                         $_POST["lngPeriodo"], $_POST["lngEjercicio"], addslashes($_POST["strConcepto"]),$_POST['esAbono'], $_SESSION["strUsuario"]);   

        //me traigo la fecha de importacion y exportacion
        if($OK2==TRUE){
            $clsCNContabilidad->ActualizarAsientoImportado_tbmovimientos($_POST['Asiento']);
        }

        if($OK2==FALSE){
            //como ha fallado la insercion de los nuevos datos volvemos a dar de alta el asiento que habias dado de baja antes
            $clsCNContabilidad->DarAltaAsiento($_POST['Asiento']);
            ////indicamos el error
            echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/error.php?id=No se a editado el asiento">';
        }else{
            //voy a la pagina de 'exito.php'
            echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/exito.php?Id=Asiento editado correctamente">';
        }
    }    
}
//se viene de 'gastos_entrada.php'
else{//comienzo del else principal
    logger('info','gastos_SF.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
           " ||||Operaciones->Mis Gastos||");
    
    $datosUsuario=$clsCNUsu->DatosUsuario($_SESSION['usuario']);
    
    //recojemos los datos si venimos de pulsar 'VOLVER' en 'gastos_exito.php'
    if(isset($_GET['datos'])){
        $datos=stripslashes ($_GET['datos']);
        $datos=unserialize ($datos);
        //print_r($datos);die;
    }else{
        $datos=null;
    }

    
    if($_SESSION['navegacion']==='movil'){
        html_paginaMovil($datosUsuario,$datos,'nuevo');
    }else{
        html_pagina($datosUsuario,$datos,'nuevo');
    }
    
    
}

function html_pagina($datosUsuario,$datos,$NoE){
?>
<!DOCTYPE html>
<HTML>
<HEAD>
<?php
//estas funciones son generales
librerias_jQuery();
eventosInputText();
?>
<script src="../js/jQuery/jquery.balloon.js"></script>
    
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../images/q.ico">
<TITLE>Alta de Gastos - Movimientos</TITLE>

<script language="JavaScript">

function continuar()
{
  esValido=true;
  textoError='';
  
  
  //comprobacion del campo 'strEmpresa'
  if (document.form1.strEmpresa.value === ''){ 
    textoError=textoError+"Es necesario introducir el nombre de la empresa.\n";
    document.form1.strEmpresa.style.borderColor='#FF0000';
    document.form1.strEmpresa.title ='Se debe introducir el nombre de la empresa';
    esValido=false;
  }
  //comprobacion del campo 'strPeriodo'
  if (document.form1.strPeriodo.value === ''){ 
    textoError=textoError+"Es necesario introducir la fecha del apunte (PERIODO).\n";
    document.form1.strPeriodo.style.borderColor='#FF0000';
    esValido=false;
  }
  //comprobacion del campo 'lngEjercicio'
  if (document.form1.lngEjercicio.value === ''){ 
    textoError=textoError+"Es necesario introducir la fecha del apunte (EJERCICIO).\n";
    document.form1.lngEjercicio.style.borderColor='#FF0000';
    esValido=false;
  }
  //comprobacion del campo 'datFecha'
  if (document.form1.datFecha.value === ''){ 
    textoError=textoError+"Es necesario introducir la fecha del apunte.\n";
    document.form1.datFecha.style.borderColor='#FF0000';
    document.form1.datFecha.title ='Se debe introducir la fecha del apunte';
    esValido=false;
  }
  //comprobacion del campo 'strCuentaCli'
  if (document.form1.strCuentaCli.value === ''){ 
    textoError=textoError+"Es necesario introducir la cuenta del cliente.\n";
    document.form1.strCuentaCli.style.borderColor='#FF0000';
    document.form1.strCuentaCli.title ='Se debe introducir la cuenta del cliente';
    esValido=false;
  }
  //comprobacion del campo 'strCuenta'
  if (document.form1.strCuenta.value === ''){ 
    textoError=textoError+"Es necesario introducir la cuenta de origen.\n";
    document.form1.strCuenta.style.borderColor='#FF0000';
    document.form1.strCuenta.title ='Se debe introducir la cuenta de origen';
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
              acProveedor();
              fechaMes(document.getElementById('datFecha'));
              <?php if(isset($_GET['borrar'])&& $_GET['borrar']=='si'){echo 'borrarAsiento('. $_GET['Asiento'].');';}?>
              <?php if(!isset($_GET['editar'])){echo 'focusFecha();';} ?>">
    
<script>
    $('#observaciones').balloon();        
</script>  
    
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
$tituloForm='MOVIMIENTOS<br/>ALTA DE GASTOS';
$cabeceraNumero='020301';
if($_GET['esAbono']==='SI'){
    $tituloForm=$tituloForm.'<br/><font color="FF0000">ABONO</font>';
}
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
    <form name="form1" method="get" action="../vista/<?php echo $_GET['pag'];?>.php">
        
      <table width="640" border="0" class="zonaactiva">
        <tr> 
          <td class="subtitulo" colspan="11">&nbsp;Alta Movimientos - Gastos</td>
        </tr>
        <tr>
            <td width="15%"></td>
            <td width="8%"></td>
            <td width="8%"></td>
            <td width="8%"></td>
            <td width="8%"></td>
            <td width="8%"></td>
            <td width="8%"></td>
            <td width="8%"></td>
            <td width="8%"></td>
            <td width="8%"></td>
            <td width="8%"></td>
        </tr>
        <tr> 
          <td colspan="2">
              <div align="left">
              <label class="nombreCampo">Empresa</label>
              <input class="textbox1" type="text" maxlength="50" name="strEmpresa" value="<?php echo $_SESSION['sesion'];?>" readonly />
              </div>
          </td>
          <td></td>
          <td colspan="2">
              <div align="left">
              <label class="nombreCampo">Periodo</label>
              <input class="textbox1" type="text" id="strPeriodo" name="strPeriodo" readonly value="<?php echo $datos['strPeriodo']; ?>" />
              <input type="hidden" id="lngPeriodo" value="<?php echo $datos['lngPeriodo']; ?>"/>
              </div>
          </td>
          <td></td>
          <td colspan="2">
              <div align="left">
              <label class="nombreCampo">Ejercicio</label>
              <input class="textbox1" type="text" id="lngEjercicio" name="lngEjercicio" maxlength="4"
                     onkeypress="fechaMes(document.getElementById('datFecha'));" readonly
                     value="<?php echo $datos['lngEjercicio']; ?>" />
              </div>
          </td>
          <td></td>
          
          <td colspan="2">
             <div align="left">
             <label class="nombreCampo" width="70">Fecha</label>
            <?php
            datepicker_español('datFecha');
            
            //funcion general
            activarPlaceHolder();
            ?>
            <style type="text/css">
            /* para que no salga el rectangulo inferior */        
            .ui-widget-content {
                border: 0px solid #AAAAAA;
            }
            </style>
            
            <input class="textbox1" type="text" id="datFecha" name="datFecha" maxlength="38" placeholder="<?php if(isset($datos)){echo $datos['datFecha'];}else {echo $fechaForm;}?>" 
                   onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" tabindex="1"
                   onKeyUp="this.value=formateafechaEntrada(this.value);" value="<?php if(isset($datos)){echo $datos['datFecha'];}else {echo $fechaForm;}?>"
                   onfocus="onFocusInputText(this);<?php if(!isset($datos)){echo 'limpiaCampoFecha(this)';}?>"
                   onblur="onBlurInputText(this);comprobarFechaEsCerrada(this);comprobarVacioFecha(this,'<?php echo $fechaForm;?>');fechaMes(this);"
                   onchange="fechaMes(this);comprobarFechaEsCerrada(this);" />
             </div>
          </td>
        </tr>
        
        <tr>
            <td height="15px"></td>
        </tr>
        
        <tr>
            <td colspan="2"></td>
            <td onClick="acProveedor();">
                <div align="right">
                    <input type="radio" name="tipo" value="Proveedor" checked tabindex="2" />
                </div>
            </td>
            <td colspan="2" onClick="acProveedor();"><font style="font-size: 15px;">Proveedor</font></td>
            <td onClick="acAcreedor();">
                <div align="right">
                    <input type="radio" name="tipo" value="Acreedor" tabindex="2" />
                </div>
            </td>
            <td colspan="2" onClick="acAcreedor();">
                <font style="font-size: 15px;">Acreedor</font>&nbsp;&nbsp;&nbsp;
                <?php
                $txtTexto = "
Proveedores: suministran mercancías para su venta o elementos (generalmente materias primas) para incorporar a nuestro proceso productivo.

Acreedores: suministran productos o servicios que no se incorporan de forma directa al proceso productivo. Ej.: luz, teléfono, alquileres, seguros, transportes, etc.

Ejemplo práctico: La compra de un ordenador.
Si nuestra actividad es la venta de material informático, estamos comprando un ordenador para su venta. El suministrador tendría la consideración de Proveedor (Grupo 400).
Si nuestra actividad es la venta de fruta, estamos comprando un ordenador para utilizarlo en nuestra empresa. El suministrador tendría la consideración de Acreedor (Grupo 410).
                            ";
                ?>
                <a id="observaciones" title="<?php echo $txtTexto; ?>">
                    <img src="../images/info.png" width="15" height="15" />
                </a>
            </td>
            <script>
            function acProveedor(){
                var tipo = document.getElementsByName('tipo');
                tipo[0].checked=true;
                tipo[1].checked=false;
                Listado('400');
                document.form1.strCuentaCli.value='';
                document.getElementById('txtProAcre').innerHTML='Proveedor';
            }
            function acAcreedor(){
                var tipo = document.getElementsByName('tipo');
                tipo[1].checked=true;
                tipo[0].checked=false;
                Listado('410');
                document.form1.strCuentaCli.value='';
                document.getElementById('txtProAcre').innerHTML='Acreedor';
            }
            </script>
        </tr>
        
        <tr> 
          <td colspan="6"> 
              <div align="left">
              <label class="nombreCampo">Compra o Gasto</label>
              <?php
              //funcion general
              autocomplete_cuentas_SubGrupo2y6('strCuenta');
              ?>
              <input class="textbox1" type="text" id="strCuenta" name="strCuenta" tabindex="3" value="<?php echo htmlentities($datos['strCuenta'],ENT_QUOTES,'UTF-8');?>"
                    onKeyUp="comprobarCuenta(this,document.getElementById('okStrCuenta'));"  
                    onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                    onfocus="onFocusInputText(this);desactivaCampoComprobacionCuenta(document.getElementById('okStrCuenta'));"
                    onblur="onBlurInputText(this);comprobarCuentaBlur(this,document.getElementById('okStrCuenta'));" />
              <input type="hidden" id="okStrCuenta" name="okStrCuenta" value="<?php if($NoE==='nuevo'){echo 'NO';}else if($NoE==='edicion'){echo 'SI';} ?>" />
              </div>
          </td>
          <td></td>
          <td colspan="4">
              <div align="left">
            <script language="JavaScript">
            function Listado(filtro){
            $("#strCuentaCli").autocomplete({
                source: "../vista/ajax/ingresos_gastos_cuentas_filtros.php?bd=<?php echo $_SESSION['mapeo']; ?>&filtro="+filtro,
                autoFill: true,
                selectFirst: true
            //    select : function(event,ui){
            //        $("#<?php //echo $id;?>").html(ui.item.value);
            //    }
            //    });
                }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
                    var txt=item.value.split('-');
                    var inner_html = "<a><small><font color='Grey'>"+txt[0]+"</font></small> - <b><font color='Teal'>"+txt[1]+"</font></b></a>";
                    return $( "<li></li>" )
                        .data( "item.autocomplete", item )
                        .append(inner_html)
                        .appendTo( ul );
                };
            }
            </script>
            <label class="nombreCampo"><span id="txtProAcre"></span><font color="#F0F8FF">...............</font></label>
              <input class="textbox1" type="text" id="strCuentaCli" name="strCuentaCli" tabindex="4" value="<?php echo htmlentities($datos['strCuentaCli'],ENT_QUOTES,'UTF-8');?>"
                   onKeyUp="comprobarCuenta(this,document.getElementById('okStrCuentaCli'));"  
                   onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                   onfocus="onFocusInputText(this);desactivaCampoComprobacionCuenta(document.getElementById('okStrCuentaCli'));"
                   onblur="onBlurInputText(this);comprobarCuentaBlur(this,document.getElementById('okStrCuentaCli'));" />
              <input type="hidden" id="okStrCuentaCli" name="okStrCuentaCli" value="<?php if($NoE==='nuevo'){echo 'NO';}else if($NoE==='edicion'){echo 'SI';} ?>" />
              </div>
          </td>
        </tr>
        <tr>
            <td height="25px"></td>
        </tr>
<!--        <tr>
            <td></td>
            <td colspan="9">
                <div class="txtComentario">
                    <p>Proveedores: suministran mercancías para su venta o elementos (generalmente materias primas) para incorporar a nuestro proceso productivo.</p>
                    <p>Acreedores: suministran productos o servicios que no se incorporan de forma directa al proceso productivo. Ej.: luz, teléfono, alquileres, seguros, transportes, etc.</p>

                    <p>Ejemplo práctico: La compra de un ordenador.</p>
                    <p>Si nuestra actividad es la venta de material informático, estamos comprando un ordenador para su venta. El suministrador tendría la consideración de Proveedor (Grupo 400).</p>
                    <p>Si nuestra actividad es la venta de fruta, estamos comprando un ordenador para utilizarlo en nuestra empresa. El suministrador tendría la consideración de Acreedor (Grupo 410).</p>
                </div>
            </td>
            <td></td>
        </tr>        -->
        
        
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
        
      <P>
        <script languaje="JavaScript"> 
            function volver(){
                javascript:window.location.href="../vista/gastos_entrada.php";
            }
        </script>
        <input class="buttonAzul" type="button" value="Volver" onclick="volver();" />
        <input type="button" class="button" name="cmdAlta" id="cmdAlta" value = "Continuar" onclick="javascript:continuar();" tabindex="5" /> 
        <input type="hidden"  name="esAbono" value="<?php if(isset($_GET['esAbono'])){echo $_GET['esAbono'];}else{echo 'NO';} ?>" />
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
}//fin del html_pagina



function html_paginaMovil($datosUsuario,$datos,$NoE){
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
<body onLoad="fechaMes(document.getElementById('datFecha'));
              acProveedor();
              formateoColoresCampo('<?php echo $_GET['esAbono'];?>');
              <?php if(isset($_GET['borrar'])&& $_GET['borrar']=='si'){echo 'borrarAsiento('. $_GET['Asiento'].');';}?>
              <?php if(!isset($_GET['editar'])){echo 'focusFecha();';} ?>"
      class="api jquery-mobile archive category category-widgets category-2 listing single-author">
           
<div data-role="page" id="gastos_entrada2">
<?php
eventosInputText();
?>
<script language="JavaScript">
function continuarM()
{
  esValido=true;
  textoError='';
  
  
  //comprobacion del campo 'strEmpresa'
  if (document.form1.strEmpresa.value === ''){ 
    textoError=textoError+"Es necesario introducir el nombre de la empresa.\n";
    document.form1.strEmpresa.style.borderColor='#FF0000';
    document.form1.strEmpresa.title ='Se debe introducir el nombre de la empresa';
    esValido=false;
  }
  //comprobacion del campo 'strPeriodo'
  if (document.form1.strPeriodo.value === ''){ 
    textoError=textoError+"Es necesario introducir la fecha del apunte (PERIODO).\n";
    document.form1.strPeriodo.style.borderColor='#FF0000';
    esValido=false;
  }
  //comprobacion del campo 'lngEjercicio'
  if (document.form1.lngEjercicio.value === ''){ 
    textoError=textoError+"Es necesario introducir la fecha del apunte (EJERCICIO).\n";
    document.form1.lngEjercicio.style.borderColor='#FF0000';
    esValido=false;
  }
  //comprobacion del campo 'datFecha'
  if (document.form1.datFecha.value === ''){ 
    textoError=textoError+"Es necesario introducir la fecha del apunte.\n";
    document.form1.datFecha.style.borderColor='#FF0000';
    esValido=false;
  }
  //comprobacion del campo 'strCuentaCli'
  if (document.form1.strCuentaCli.value === ''){ 
    textoError=textoError+"Es necesario introducir la cuenta del cliente.\n";
    document.form1.strCuentaCli.style.borderColor='#FF0000';
    esValido=false;
  }
  //comprobacion del campo 'strCuenta'
  if (document.form1.strCuenta.value === ''){ 
    textoError=textoError+"Es necesario introducir la cuenta de origen.\n";
    document.form1.strCuenta.style.borderColor='#FF0000';
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

//poner en color rojo los campos siguientes
function formateoColoresCampo(esAbono){
/*    if(esAbono==='SI'){
        formateoCampoColor(document.form1.lngCantidadContabilidad,'<?php //echo $_GET['esAbono'];?>','#FF0000');
        formateoCampoColor(document.form1.lngIngresoContabilidad,'<?php //echo $_GET['esAbono'];?>','#FF0000');
    }else{
        formateoCampoColor(document.form1.lngCantidadContabilidad,'<?php //echo $_GET['esAbono'];?>','#666666');
        formateoCampoColor(document.form1.lngIngresoContabilidad,'<?php //echo $_GET['esAbono'];?>','#666666');
    } */   
}

//volver a pag gastos_entrada
function volverM(){
    javascript:window.location.href="../movil/gastos_entrada.php";
}

</script>        

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>

    <div data-role="content" data-theme="a">
        
        <form action="../vista/<?php echo $_GET['pag'];?>.php" name="form1" method="get" data-ajax="false">
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
                            <label>Empresa</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <input type="text" name="strEmpresa" maxlength="50" value="<?php echo $_SESSION['sesion'];?>" readonly />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label>Periodo</label>
                        </td>
                        <td colspan="2">
                            <label>Ejercicio</label>
                        </td>            
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="text" id="strPeriodo" name="strPeriodo" readonly value="<?php echo $datos['strPeriodo']; ?>" />
                            <input type="hidden" id="lngPeriodo" name="lngPeriodo" value="<?php echo $datos['lngPeriodo']; ?>"/>
                        </td>
                        <td colspan="2">
                            <input type="text" id="lngEjercicio" name="lngEjercicio" 
                                   onkeypress="fechaMes(document.getElementById('datFecha'));" readonly
                                   value="<?php echo $datos['lngEjercicio']; ?>" />
                        </td>            
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label>Fecha</label>
                            <?php
                            date_default_timezone_set('Europe/Madrid');
                            $fechaForm=date('d/m/Y');
                            datepicker_español('datFecha');
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="text" id="datFecha" name="datFecha" maxlength="38" placeholder="<?php if(isset($datos)){echo $datos['datFecha'];}else {echo $fechaForm;}?>" 
                                   onKeyUp="this.value=formateafechaEntrada(this.value);" value="<?php if(isset($datos)){echo $datos['datFecha'];}else {echo $fechaForm;}?>"
                                   onfocus="<?php if(!isset($datos)){echo 'limpiaCampoFecha(this)';}?>"
                                   onblur="comprobarFechaEsCerrada(this);comprobarVacioFecha(this,'<?php echo $fechaForm;?>');fechaMes(this);"
                                   onchange="fechaMes(this);comprobarFechaEsCerrada(this);" />
                        </td>
                    </tr>
<!--                    <tr>-->
                    <tr>
                        <td colspan="4">
                        <script>
                        function acProveedor(){
                            var tipo = document.getElementsByName('tipo');
                            tipo[0].checked=true;
                            tipo[1].checked=false;
                            Listado('400');
                            document.form1.strCuentaCli.value='';
                            document.getElementById('txtProAcre').innerHTML='Proveedor';
                        }
                        function acAcreedor(){
                            var tipo = document.getElementsByName('tipo');
                            tipo[1].checked=true;
                            tipo[0].checked=false;
                            Listado('410');
                            document.form1.strCuentaCli.value='';
                            document.getElementById('txtProAcre').innerHTML='Acreedor';
                        }
                        </script>
                        <div class="ui-field-contain">
                            <fieldset data-role="controlgroup" data-mini="true">
                                <input type="radio" name="tipo" value="Proveedor" id="Proveedor" class="custom" checked="checked"
                                       data-theme="a" data-iconpos="right" onClick="acProveedor();">
                                <label for="Proveedor">Proveedor</label>
                                <input type="radio" name="tipo" id="Acreedor" class="custom" value="Acreedor"
                                       data-theme="a" data-iconpos="right" onClick="acAcreedor();">
                                <label for="Acreedor">Acreedor</label>
                            </fieldset>
                        </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <label>Compra o Gasto</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div class="ui-widget">
                                
                                <?php
                                //funcion filtro
                                autocomplete_cuentas_SubGrupo2y6('strCuenta');
                                ?>
                                <input type="text" id="strCuenta" name="strCuenta" tabindex="3" value="<?php echo htmlentities($datos['strCuenta'],ENT_QUOTES,'UTF-8');?>"
                                      onKeyUp="comprobarCuenta(this,document.getElementById('okStrCuenta'));"  
                                      onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                                      onfocus="onFocusInputText(this);desactivaCampoComprobacionCuenta(document.getElementById('okStrCuenta'));"
                                      onblur="onBlurInputText(this);comprobarCuentaBlur(this,document.getElementById('okStrCuenta'));" />
                                <input type="hidden" id="okStrCuenta" name="okStrCuenta" value="<?php if($NoE==='nuevo'){echo 'NO';}else if($NoE==='edicion'){echo 'SI';} ?>" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <label><span id="txtProAcre"></span></label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <script language="JavaScript">
                            function Listado(filtro){
                            $("#strCuentaCli").autocomplete({
                                source: "../vista/ajax/ingresos_gastos_cuentas_filtros.php?bd=<?php echo $_SESSION['mapeo']; ?>&filtro="+filtro,
                                autoFill: true,
                                selectFirst: true
                            //    select : function(event,ui){
                            //        $("#<?php //echo $id;?>").html(ui.item.value);
                            //    }
                            //    });
                                }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
                                    var txt=item.value.split('-');
                                    var inner_html = "<a><small><font color='Grey'>"+txt[0]+"</font></small> - <b><font color='Teal'>"+txt[1]+"</font></b></a>";
                                    return $( "<li></li>" )
                                        .data( "item.autocomplete", item )
                                        .append(inner_html)
                                        .appendTo( ul );
                                };
                            }
                            </script>
                            <input type="text" id="strCuentaCli" name="strCuentaCli" tabindex="4" value="<?php echo htmlentities($datos['strCuentaCli'],ENT_QUOTES,'UTF-8');?>"
                                 onKeyUp="comprobarCuenta(this,document.getElementById('okStrCuentaCli'));"  
                                 onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                                 onfocus="onFocusInputText(this);desactivaCampoComprobacionCuenta(document.getElementById('okStrCuentaCli'));"
                                 onblur="onBlurInputText(this);comprobarCuentaBlur(this,document.getElementById('okStrCuentaCli'));" />
                            <input type="hidden" id="okStrCuentaCli" name="okStrCuentaCli" value="<?php if($NoE==='nuevo'){echo 'NO';}else if($NoE==='edicion'){echo 'SI';} ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td height='15px'></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <article id="post-2" class="hentry">
                            <div class="entry-summary">
                                <p>Proveedores: suministran mercancías para su venta o elementos (generalmente materias primas) para incorporar a nuestro proceso productivo.</p>
                                <p>Acreedores: suministran productos o servicios que no se incorporan de forma directa al proceso productivo. Ej.: luz, teléfono, alquileres, seguros, transportes, etc.</p>

                                <p>Ejemplo práctico: La compra de un ordenador.</p>
                                <p>Si nuestra actividad es la venta de material informático, estamos comprando un ordenador para su venta. El suministrador tendría la consideración de Proveedor (Grupo 400).</p>
                                <p>Si nuestra actividad es la venta de fruta, estamos comprando un ordenador para utilizarlo en nuestra empresa. El suministrador tendría la consideración de Acreedor (Grupo 410).</p>
                            </div>
                            </article>
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="2">
                        <div align="center">
                            <input type="button" data-theme="a" data-icon="back" data-iconpos="right" value = "Volver" onClick="javascript:volverM();" /> 
                        </div>
                        </td>
                        <td colspan="2">
                        <div align="center">
                            <input type="button" id="cmdAlta" data-theme="a" data-icon="forward" data-iconpos="right" value = "Continuar" onClick="javascript:continuarM();" /> 
                            <input type="hidden"  name="esAbono" value="<?php if(isset($_GET['esAbono'])){echo $_GET['esAbono'];}else{echo 'NO';} ?>" />
                        </div>
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
}//fin del html_paginaMovil
?>