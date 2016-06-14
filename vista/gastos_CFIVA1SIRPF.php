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



//print_r($_SESSION);
$clsCNContabilidad=new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['mapeo']);
$clsCNUsu=new clsCNUsu();
$clsCNUsu->setStrBD($_SESSION['dbContabilidad']);


//codigo principal
//comprobamos si se ha submitido el formulario y que que valor viene en 'cmdAlta'
//aqui viene los tres valores indicados en la anterior pantalla
//las distintas convinaciones son:
//  ConFactura+IVA1+SinRetencionIRPF       
//
//
//Caso 3 (ConFactura+IVA1+SinRetencionIRPF)
if(isset($_POST['cmdAlta']) && $_POST['cmdAlta']=='Alta'){
    logger('info','gastos.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
           " ||||Operaciones->Mis Gastos|| Ha pulsado 'Aceptar'(ConFactura+IVA1+SinRetencionIRPF)");
    //print_r($_POST);die;
    //guardo el gasto el la tabla tbmovimientos, tbacumulados y tbmovimientos_iva
    $varRes = $clsCNContabilidad->AltaGastosMovimientos(0,$_SESSION["idEmp"],$_POST['strCuenta'], $_POST["lngIngreso"],
                                            $_POST['strCuentaCli'], $_POST["lngCantidad"],$_POST["lngIva"],$_POST["lngPorcientoSin"], $_POST["datFecha"],$_POST['optTipo'],
                                            $_POST['strCuentaBancos'],$_POST["lngPeriodo"], $_POST["lngEjercicio"], addslashes($_POST["strConcepto"]), $_POST['esAbono'], $_SESSION["strUsuario"]);   

    logger('warning','' ,
           ' $clsCNContabilidad->AltaGastosMovimientos(0,'.$_SESSION["idEmp"].",'".$_POST['strCuenta']."','". $_POST["lngIngreso"]."','".
                                            $_POST['strCuentaCli']."','". $_POST["lngCantidad"]."','".$_POST["lngIva"]."','".$_POST["lngPorcientoSin"]."','". $_POST["datFecha"]."','".$_POST['optTipo']."','".
                                            $_POST['strCuentaBancos']."',".$_POST["lngPeriodo"].",". $_POST["lngEjercicio"].",'". addslashes($_POST["strConcepto"])."','". $_POST['esAbono']."','". $_SESSION["strUsuario"]."');");
    
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
//            "lngPorcientoSin"=>$_POST["lngPorcientoSin"],
//            "lngIva"=>$_POST["lngIva"],
//            "lngIvaContabilidad"=>$_POST["lngIvaContabilidad"],
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
//        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/gastos_exito.php?op=CFIVA1SIRPF&datos='.$compactada.'&esAbono='.$_POST["esAbono"].'">';
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/gastos_exito.php?op=CFIVA1SIRPF&tipo='.$_POST['tipo'].'">';
    }
    
}
//se viene del listado de editar asientos (listado_asientos2.php)
else if(isset($_GET['editar']) && $_GET['editar']==='SI'){
    logger('info','gastos_CFIVA1SIRPF.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
           " ||||Operaciones->Modificar Asiento||");

    $datosUsuario=$clsCNUsu->DatosUsuario($_SESSION['usuario']);
    
    //se buscan los datos de este asiento para cargarlos en el formulario
    $datos=$clsCNContabilidad->DatosAsientoCFIVA1SIRPF($_GET['Asiento'],$_GET['esAbono']);
    
    //vemos si el asiento esta en un perido editable para el iva
    $editarAsiento=$clsCNContabilidad->AsientoEditable($datos['lngEjercicio'],$datos['lngPeriodo']);

    //si $datos[Borrado]='0' este asiento esta borrado por lo que redirecciono a 'default2.php'
    if(isset($datos['Borrado']) && $datos['Borrado']==='1'){
        //presento el formulario con los datos
        
        //aqui dirijo a la presentacion en PC o Movil (APP)
        if($_SESSION['navegacion']==='movil'){
            html_paginaMovil($datosUsuario,$datos,$editarAsiento,'edicion');
        }else{
            html_pagina($datosUsuario,$datos,$editarAsiento,'edicion');
        }
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
        $OK2 = $clsCNContabilidad->AltaGastosMovimientos($_POST['Asiento'],$_SESSION["idEmp"],$_POST['strCuenta'], $_POST["lngIngreso"],
                                            $_POST['strCuentaCli'], $_POST["lngCantidad"],$_POST["lngIva"],$_POST["lngPorcientoSin"], $_POST["datFecha"],$_POST['optTipo'],
                                            $_POST['strCuentaBancos'],$_POST["lngPeriodo"], $_POST["lngEjercicio"], addslashes($_POST["strConcepto"]), $_POST['esAbono'], $_SESSION["strUsuario"]);   

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
    logger('info','gastos.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
           " ||||Operaciones->Mis Gastos||");
    
    $datosUsuario=$clsCNUsu->DatosUsuario($_SESSION['usuario']);
    
    //recojemos los datos si venimos de pulsar 'VOLVER' en 'gastos_exito.php'
    if(isset($_GET['datos'])){
        $datos=stripslashes ($_GET['datos']);
        $datos=unserialize ($datos);
    }else
    //si venimos de alta nueva, de la pagina gastos_entrada2.php    
    if(isset($_GET['tipo'])){
        $datos['datFecha']=$_GET['datFecha'];
        $datos['tipo']=$_GET['tipo'];
        $datos['strCuenta']=$_GET['strCuenta'];
        $datos['strCuentaCli']=$_GET['strCuentaCli'];
    }else{
        $datos=null;
    }
    
    //aqui dirijo a la presentacion en PC o Movil (APP)
    if($_SESSION['navegacion']==='movil'){
        html_paginaMovil($datosUsuario,$datos,'SI','nuevo');
    }else{
        html_pagina($datosUsuario,$datos,'SI','nuevo');
    }
}

function html_pagina($datosUsuario,$datos,$editarAsiento,$NoE){
    
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
<TITLE>Alta de Gastos - Movimientos</TITLE>

<script language="JavaScript">

function validar()
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
  //comprobacion del campo 'strConcepto'
  if (document.form1.strConcepto.value === ''){ 
    textoError=textoError+"Es necesario introducir el concepto.\n";
    document.form1.strConcepto.style.borderColor='#FF0000';
    document.form1.strConcepto.title ='Se debe introducir el concepto';
    esValido=false;
  }
  //comprobacion del campo 'strCuentaBancos',
  // si tiene el checked del campo 'optTipo[1]' esta a true, se comprueba que tenga datos
  if(document.form1.optTipo[1].checked===true){
      if(document.form1.strCuentaBancos.value===''){
        textoError=textoError+"Por favor seleccione un banco/caja.\n";
        document.form1.strCuentaBancos.style.borderColor='#FF0000';
        document.form1.strCuentaBancos.title ='Se debe seleccionar un banco/caja';
        esValido=false;
      }
  }
  
    if (document.form1.lngIngresoContabilidad.value === '0,00'){ 
      textoError=textoError+"El valor de la factura debe ser superior a 0.\n";
      document.form1.lngIngresoContabilidad.style.borderColor='#FF0000';
      document.form1.lngIngresoContabilidad.title ='El valor de la factura debe ser superior a 0';
      esValido=false;
    }
    
  //comprobar que los input hideen okStrCuenta.. esten con value=SI
  if(document.getElementById('okStrCuenta').value === 'NO'){
    textoError=textoError+"La cuenta de gasto no existe en la BBDD.\n";
    document.form1.strCuenta.style.borderColor='#FF0000';
    document.form1.strCuenta.title ='La cuenta de gasto no existe en la BBDD.';
    esValido=false;
  }

  if(document.getElementById('okStrCuentaCli').value === 'NO'){
    textoError=textoError+"La cuenta Proveedor-Acreedor no existe en la BBDD.\n";
    document.form1.strCuentaCli.style.borderColor='#FF0000';
    document.form1.strCuentaCli.title ='La cuenta Proveedor-Acreedor no existe en la BBDD.';
    esValido=false;
  }

  // si tiene el checked del campo 'optTipo[1]' esta a true, se comprueba que tenga datos
  if(document.form1.optTipo[1].checked===true){
    if(document.getElementById('okStrCuentaBancos').value === 'NO'){
      textoError=textoError+"La cuenta de banco/caja no existe en la BBDD.\n";
      document.form1.strCuentaBancos.style.borderColor='#FF0000';
      document.form1.strCuentaBancos.title ='La cuenta de banco/caja no existe en la BBDD.';
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

function ActivaSelecBanco(objeto){
    if(objeto.value==1){
        document.form1.strCuentaBancos.disabled=false;
    }else{
        document.form1.strCuentaBancos.disabled=true;
        onMouseOverInputText(document.form1.strCuentaBancos);
    }
}

//formateo de numeros
function formateaCantidad(objeto){
    objeto.value=formateaNumeroContabilidad(objeto.value);
}    

//poner en color rojo los campos siguientes
function formateoColoresCampo(esAbono){
    if(esAbono==='SI'){
        formateoCampoColor(document.form1.lngCantidadContabilidad,'<?php echo $_GET['esAbono'];?>','#FF0000');
        formateoCampoColor(document.form1.lngIvaContabilidad,'<?php echo $_GET['esAbono'];?>','#FF0000');
        formateoCampoColor(document.form1.lngIngresoContabilidad,'<?php echo $_GET['esAbono'];?>','#FF0000');
    }else{
        formateoCampoColor(document.form1.lngCantidadContabilidad,'<?php echo $_GET['esAbono'];?>','#666666');
        formateoCampoColor(document.form1.lngIvaContabilidad,'<?php echo $_GET['esAbono'];?>','#666666');
        formateoCampoColor(document.form1.lngIngresoContabilidad,'<?php echo $_GET['esAbono'];?>','#666666');
    }    
}

//borrar Asiento
function borrarAsiento(id){
    if (confirm("¿Desea borrar el Asiento de la base de datos?"))
    {
        window.location='../vista/asientoBorrar.php?id='+id;
    }
}

function asientoCerrado(){
    alert('Este asiento esta en un periodo cerrado. No se puede editar ni borrar.');
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
<BODY bgColor=#ffffff leftMargin=0 topMargin=0 rightMargin=0 bottomMargin=0 marginwidth="0" marginheight="0"  background="<?php echo FONDO; ?>" 
      onLoad="rotulo_status();
              fechaMes(document.getElementById('datFecha'));
              formateoColoresCampo('<?php echo $_GET['esAbono'];?>');
              <?php
                if($editarAsiento==='SI'){
                    if(!isset($_GET['editar']) && !isset($_GET['datFecha'])){
                        echo 'focusFecha();';
                    }
                    if(isset($_GET['borrar'])&& $_GET['borrar']=='si'){
                        echo 'borrarAsiento('. $_GET['Asiento'].');';
                    }
                }else{
                    echo 'asientoCerrado();';
                }
              ?>">
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
$cabeceraNumero='020302';
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
    <form name="form1" method="post" action="../vista/gastos_CFIVA1SIRPF.php">
        
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
              <input class="textbox1" type="text" name="strEmpresa" maxlength="50" value="<?php echo $_SESSION['sesion'];?>" readonly />
              </div>
          </td>
          <td></td>
          <td colspan="2">
              <div align="left">
              <label class="nombreCampo">Periodo</label>
              <input class="textbox1" type="text" id="strPeriodo" name="strPeriodo" readonly value="<?php echo $datos['strPeriodo']; ?>" />
              <input type="hidden" id="lngPeriodo" name="lngPeriodo" value="0" value="<?php echo $datos['lngPeriodo']; ?>" />
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
            if($editarAsiento==='SI') {
                datepicker_español('datFecha');
            }
            
            //funcion general
            activarPlaceHolder();
            ?>
            <style type="text/css">
            /* para que no salga el rectangulo inferior */        
            .ui-widget-content {
                border: 0px solid #AAAAAA;
            }
            </style>
            <input class="textbox1" type="text" id="datFecha" name="datFecha" maxlength="38"
                   value="<?php if(isset($datos['datFecha'])){echo $datos['datFecha'];}else {echo $fechaForm;}?>"
                   <?php if($editarAsiento==='SI') {?>
                   placeholder="<?php if(isset($datos['datFecha'])){echo $datos['datFecha'];}else {echo $fechaForm;}?>" 
                   onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" tabindex="1"
                   onKeyUp="this.value=formateafechaEntrada(this.value);" 
                   onfocus="onFocusInputText(this);<?php if(!isset($datos['datFecha'])){echo 'limpiaCampoFecha(this);';}?>"
                   onblur="onBlurInputText(this);comprobarFechaEsCerrada(this);comprobarVacioFecha(this,'<?php echo $fechaForm;?>');fechaMes(this);"
                   onchange="fechaMes(this);comprobarFechaEsCerrada(this);"
                   <?php }else{?>
                   readonly
                   <?php }?>
                   />
             </div>
          </td>
        </tr>
        
        <tr> 
          <td colspan="6"> 
              <div align="left">
              <label class="nombreCampo">Compra o Gasto</label>
              <?php
              //funcion general
              if($editarAsiento==='SI') {
                  autocomplete_cuentas_SubGrupo2y6('strCuenta');
              }
              ?>
              <input class="textbox1" type="text" id="strCuenta" name="strCuenta" tabindex="2" 
                    value="<?php echo htmlentities($datos['strCuenta'],ENT_QUOTES,'UTF-8');?>"
                   <?php if($editarAsiento==='SI') {?>
                    onKeyUp="comprobarCuenta(this,document.getElementById('okStrCuenta'));"  
                    onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                    onfocus="onFocusInputText(this);desactivaCampoComprobacionCuenta(document.getElementById('okStrCuenta'));"
                    onblur="onBlurInputText(this);comprobarCuentaBlur(this,document.getElementById('okStrCuenta'));"
                   <?php }else{?>
                   readonly
                   <?php }?>
                   />
              <input type="hidden" id="okStrCuenta" name="okStrCuenta" value="SI" />
              </div>
          </td>
          <td></td>
          <td colspan="4">
              <div align="left">
              <?php
                //funcion general
                if($_GET['tipo']==='Proveedor'){
                    $filtro='40';
                    $provAcre='Proveedor';
                    if($editarAsiento==='SI') {
                        autocomplete_cuentas_SubGrupo4('strCuentaCli',$filtro);
                    }
                }else if($_GET['tipo']==='Acreedor'){
                    $filtro='41';
                    $provAcre='Proveedor';
                    if($editarAsiento==='SI') {
                        autocomplete_cuentas_SubGrupo4('strCuentaCli',$filtro);
                    }
                }else{
                    $filtro='4';
                    $provAcre='Proveedor o Acreedor';
                    if($editarAsiento==='SI') {
                        autocomplete_cuentas_SubGrupo40y41('strCuentaCli');
                    }
                }
              ?>
              <label class="nombreCampo"><?php echo $provAcre; ?><font color="#F0F8FF">...............</font></label>
              <input class="textbox1" type="text" id="strCuentaCli" name="strCuentaCli" tabindex="3" 
                   value="<?php echo htmlentities($datos['strCuentaCli'],ENT_QUOTES,'UTF-8');?>"
                   <?php if($editarAsiento==='SI') {?>
                   onKeyUp="comprobarCuenta(this,document.getElementById('okStrCuentaCli'));"  
                   onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                   onfocus="onFocusInputText(this);desactivaCampoComprobacionCuenta(document.getElementById('okStrCuentaCli'));"
                   onblur="onBlurInputText(this);comprobarCuentaBlur(this,document.getElementById('okStrCuentaCli'));" 
                   <?php }else{?>
                   readonly
                   <?php }?>
                   />
              <input type="hidden" id="okStrCuentaCli" name="okStrCuentaCli" value="SI" />
              </div>
          </td>
        </tr>

        <tr>
          <td colspan="10">
              <div align="left">
              <label class="nombreCampo">Concepto</label>
              <input class="textbox1" type="text" name="strConcepto" maxlength="122" tabindex="4"
                     value="<?php echo htmlentities($datos['strConcepto'],ENT_QUOTES,'UTF-8'); ?>"
                   <?php if($editarAsiento==='SI') {?>
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"
                   <?php }else{?>
                   readonly
                   <?php }?>
                      />
              </div>
          </td>
        </tr>
        
        <tr>
          <td colspan="2">
              <div align="left">
              <label class="nombreCampo">Base Imponible</label>
              <input class="textbox1" type="text" name="lngCantidadContabilidad" maxlength="10" style="text-align:right;font-weight:bold;"
                     tabindex="" value="<?php if(isset($datos['lngCantidadContabilidad'])){echo $datos['lngCantidadContabilidad'];}else{echo '0,00';} ?>"
                     <?php if($editarAsiento==='SI') {?>
                     onkeypress="return solonumeros(event);" 
                     onkeyUp="CalculaIvaMas(this.value,document.form1.lngPorcientoSin.value);"
                     onblur="onBlurInputText(this);CalculaIvaMas(this.value,document.form1.lngPorcientoSin.value);formateaCantidad(this);
                             formateaNegativoContabilidad(this,'<?php echo $_GET['esAbono'];?>');
                             formateaNegativoContabilidad(document.form1.lngIvaContabilidad,'<?php echo $_GET['esAbono'];?>');
                             formateaNegativoContabilidad(document.form1.lngIngresoContabilidad,'<?php echo $_GET['esAbono'];?>');"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);entradaCantidad(this,document.form1.lngCantidad);selecciona_value(this);"
                     <?php }else{?>
                     readonly
                     <?php }?>
                     />
              <input type="hidden" name="lngCantidad" value="<?php echo $datos['lngCantidad']; ?>"/>
              </div>
          </td>
          <td colspan="3">
              <div align="right">
              <label class="nombreCampo">% IVA Aplicable</label>
              <select name="lngPorcientoSin"
                      class="textbox1" style="text-align:right;font-weight:bold;width:50%;" tabindex="6"
                   <?php if($editarAsiento==='SI') {?>
                      onchange="CalculaIva(document.form1.lngIngreso.value,document.form1.lngPorcientoSin.value);
                                formateaNegativoContabilidad(document.form1.lngCantidadContabilidad,'<?php echo $_GET['esAbono'];?>');
                                formateaNegativoContabilidad(document.form1.lngIvaContabilidad,'<?php echo $_GET['esAbono'];?>');
                                formateaNegativoContabilidad(document.form1.lngIngresoContabilidad,'<?php echo $_GET['esAbono'];?>');"
                      onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                   <?php }else{?>
                      disabled="true"
                   <?php }?>
                   >
                  <?php
                  //preparo el listado del select
                  $selected0='';
                  $selected4='';
                  $selected10='';
                  $selected21='';
                  if(isset($datos['lngPorcientoSin'])){ //existe IVA
                      if($datos['lngPorcientoSin']==0){
                          $selected0='selected';
                      }else if($datos['lngPorcientoSin']==4){
                          $selected4='selected';
                      }else if($datos['lngPorcientoSin']==10){
                          $selected10='selected';
                      }else if($datos['lngPorcientoSin']==21){
                          $selected21='selected';
                      }
                  }else //no existe IVA, por defecto 21%
                  {
                      $selected21='selected';
                  }
                  echo "<option value = '0' $selected0> 0</option>";
                  echo "<option value = '4' $selected4> 4</option>";
                  echo "<option value = '10' $selected10>10</option>";
                  echo "<option value = '21' $selected21>21</option>";
                  ?>
              </select>
              </div>
          </td>
          <td></td>
          <td colspan="2">
              <div align="left">
              <label class="nombreCampo">IVA Soportado</label>
              <input class="textbox1" type="text" name="lngIvaContabilidad" maxlength="4" readonly
                     style="text-align:right;font-weight:bold;" value="<?php if(isset($datos['lngIvaContabilidad'])){echo $datos['lngIvaContabilidad'];}else{echo '0,00';} ?>" />
              <input type="hidden" name="lngIva" value="<?php echo $datos['lngIva'];?>"/>
              </div>
          </td>
          <td></td>
          <td colspan="2">
              <div align="left">
              <label class="nombreCampo">Total Factura</label>
              <input class="textbox1" type="text" name="lngIngresoContabilidad" maxlength="10" style="text-align:right;font-weight:bold;"
                     tabindex="5" value="<?php if(isset($datos['lngIngresoContabilidad'])){echo $datos['lngIngresoContabilidad'];}else{echo '0,00';} ?>"
                     <?php if($editarAsiento==='SI') {?>
                     onkeypress="return solonumeros(event);" 
                     onkeyUp="CalculaIva(this.value,document.form1.lngPorcientoSin.value);"
                     onblur="onBlurInputText(this);CalculaIva(this.value,document.form1.lngPorcientoSin.value);formateaCantidad(this);
                             formateaNegativoContabilidad(this,'<?php echo $_GET['esAbono'];?>');
                             formateaNegativoContabilidad(document.form1.lngIvaContabilidad,'<?php echo $_GET['esAbono'];?>');
                             formateaNegativoContabilidad(document.form1.lngCantidadContabilidad,'<?php echo $_GET['esAbono'];?>');"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);entradaCantidad(this,document.form1.lngIngreso);selecciona_value(this);"
                     <?php }else{?>
                     readonly
                     <?php }?>
                     />
              <input type="hidden" name="lngIngreso" value="<?php if(isset($datos['lngIngreso'])){echo $datos['lngIngreso'];}else{echo '0.00';} ?>"/>
              </div>
          </td>
        </tr>
        
        <tr>
            <td colspan="2"></td>
            <td colspan="2">
                <div align="left">
                <label class="nombreCampo">Dejar Pendiente</label>
                </div>
            </td>
            <td>
                <div align="left">
                <input class="txtgeneral" type="radio" name="optTipo" value="0"
                     <?php if(!(isset($datos['optTipo'])) || $datos['optTipo']=='0'){echo 'checked';} ?> onClick="ActivaSelecBanco(this);" tabindex="7"
                     <?php if($editarAsiento<>'SI') {?>
                     disabled="true"
                     <?php }?>
                     />
                </div>
            </td>
        </tr>
        
        <tr>
            <td colspan="2"></td>
            <td colspan="2">
                <div align="left">
                <label class="nombreCampo">Realizar Pago</label>
                </div>
            </td>
            <td>
                <div align="left">
                <input class="txtgeneral" type="radio" name="optTipo" value="1"
                     <?php if($datos['optTipo']=='1'){echo 'checked';} ?> onClick="ActivaSelecBanco(this);" tabindex="8"
                     <?php if($editarAsiento<>'SI') {?>
                     disabled="true"
                     <?php }?>
                     />
                </div>
            </td>
            <td colspan="2">
                <div align="left">
                <label class="nombreCampo">Cuenta Banco/Caja</label>
                </div>
            </td>
            <td colspan="6"> 
                <div align="left">
                <?php
                //funcion general
                if($editarAsiento==='SI') {
                    autocomplete_cuentas_SubGrupo4('strCuentaBancos',57);
                }
                ?>
                <input class="textbox1" type="text" id="strCuentaBancos" name="strCuentaBancos" 
                   <?php if(!(isset($datos['optTipo'])) || $datos['optTipo']=='0'){echo 'disabled';} ?>
                   value="<?php echo htmlentities($datos['strCuentaBancos'],ENT_QUOTES,'UTF-8');?>" tabindex="8"    
                   <?php if($editarAsiento==='SI') {?>
                   onKeyUp="comprobarCuenta(this,document.getElementById('okStrCuentaBancos'));" 
                   onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" 
                   onfocus="onFocusInputText(this);desactivaCampoComprobacionCuenta(document.getElementById('okStrCuentaBancos'));"
                   onblur="onBlurInputText(this);comprobarCuentaBlur(this,document.getElementById('okStrCuentaBancos'));"
                   <?php }else{?>
                   readonly
                   <?php }?>
                   />
                <input type="hidden" id="okStrCuentaBancos" name="okStrCuentaBancos" value="<?php if($NoE==='nuevo'){echo 'NO';}else if($NoE==='edicion'){echo 'SI';} ?>" />
                </div>
            </td>
        </tr>
        
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
                javascript:history.back();
            }
            function verAsiento(id){
                javascript:window.location = '../vista/ingresos_gastos_ver.php?Asiento='+id+'&borrar=';
            }
        </script>
        <input type="button" class="button" name="cmdAlta" id="cmdAlta" value = "Grabar" onclick="javascript:validar();" tabindex="10" /> 
        <input class="buttonAzul" type="button" value="Volver" onclick="volver();" />
        <?php if($editarAsiento==='SI') {?>
        <?php if(isset($_GET['editar']) && $_GET['editar']==='SI'){echo '<input type="button" class="buttonAzul" value="Eliminar" name="cmdBorrar" onclick="javascript:borrarAsiento('.$_GET['Asiento'].');" />';} ?>  
        <input type="Reset" class="button" value="<?php if(isset($_GET['editar']) && $_GET['editar']==='SI'){echo 'Datos Iniciales';}else{echo 'Vaciar Datos';} ?>" name="cmdReset" tabindex="10" />
        <?php if(isset($_GET['editar']) && $_GET['editar']==='SI'){echo '<input type="button" class="buttonAzul"  value="Ver Est. Asiento" name="cmdVerAsiento" onclick="javascript:verAsiento('.$_GET['Asiento'].');" />';} ?>  
        <input type="hidden"  name="cmdAlta" <?php if(isset($_GET['editar']) && $_GET['editar']==='SI'){echo 'value="Editar"';}else{echo 'value="Alta"';} ?>  />
        <input type="hidden"  name="tipo" value="<?php if(isset($datos['tipo'])){echo $datos['tipo'];} ?>" />
        <input type="hidden"  name="esAbono" value="<?php if(isset($_GET['esAbono'])){echo $_GET['esAbono'];}else{echo 'NO';} ?>" />
        <?php if(isset($_GET['editar']) && $_GET['editar']==='SI'){echo '<input type="hidden"  name="Asiento" value="'.$_GET['Asiento'].'" />';} ?>  
        <?php } ?>
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
}//fin de html_pagina


function html_paginaMovil($datosUsuario,$datos,$editarAsiento,$NoE){
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
<BODY onLoad="fechaMes_MovilAsiento(document.getElementById('datFecha'));
              formateoColoresCampo('<?php echo $_GET['esAbono'];?>');
              <?php
                if($editarAsiento==='SI'){
                    echo "ActivaSelecBanco(document.getElementById('optTipo1'));";
                    if(!isset($_GET['editar']) && !isset($_GET['datFecha'])){
                        echo 'focusFecha();';
                    }
                    if(isset($_GET['borrar'])&& $_GET['borrar']=='si'){
                        echo 'borrarAsiento('. $_GET['Asiento'].');';
                    }
                }else{
                    echo 'asientoCerrado();';
                }
              ?>"
      class="api jquery-mobile archive category category-widgets category-2 listing single-author"> 

<div data-role="page" id="ingresos_CFIVA1SIRPF">
<?php
eventosInputText();
?>
<script language="JavaScript">

function validar()
{
  esValido=true;
  textoError='';
  
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
  //comprobacion del campo 'strConcepto'
  if (document.form1.strConcepto.value === ''){ 
    textoError=textoError+"Es necesario introducir el concepto.\n";
    document.form1.strConcepto.style.borderColor='#FF0000';
    esValido=false;
  }
  //comprobacion del campo 'strCuentaBancos',
  // si tiene el checked del campo 'optTipo[1]' esta a true, se comprueba que tenga datos
  if(document.form1.optTipo[1].checked===true){
      if(document.form1.strCuentaBancos.value===''){
        textoError=textoError+"Por favor seleccione un banco/caja.\n";
        document.form1.strCuentaBancos.style.borderColor='#FF0000';
        esValido=false;
      }
  }
  
  if (document.form1.lngIngresoContabilidad.value === '0,00'){ 
      textoError=textoError+"El valor de la factura debe ser superior a 0.\n";
      document.form1.lngIngresoContabilidad.style.borderColor='#FF0000';
      esValido=false;
  }

  //comprobar que los input hideen okStrCuenta.. esten con value=SI
  if(document.getElementById('okStrCuenta').value === 'NO'){
    textoError=textoError+"La cuenta de gasto no existe en la BBDD.\n";
    document.form1.strCuenta.style.borderColor='#FF0000';
    esValido=false;
  }

  if(document.getElementById('okStrCuentaCli').value === 'NO'){
    textoError=textoError+"La cuenta Proveedor-Acreedor no existe en la BBDD.\n";
    document.form1.strCuentaCli.style.borderColor='#FF0000';
    esValido=false;
  }

  // si tiene el checked del campo 'optTipo[1]' esta a true, se comprueba que tenga datos
  if(document.form1.optTipo[1].checked===true){
    if(document.getElementById('okStrCuentaBancos').value === 'NO'){
      textoError=textoError+"La cuenta de banco/caja no existe en la BBDD.\n";
      document.form1.strCuentaBancos.style.borderColor='#FF0000';
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

function ActivaSelecBanco(objeto){
    if(objeto.value === "0"){
        $('#pantalla').slideUp(1000);
    }else{
        $('#pantalla').slideDown(1000);
    }
}

//formateo de numeros
function formateaCantidad(objeto){
    objeto.value=formateaNumeroContabilidad(objeto.value);
}    

//poner en color rojo los campos siguientes
function formateoColoresCampo(esAbono){
    if(esAbono==='SI'){
        formateoCampoColor(document.form1.lngCantidadContabilidad,'<?php echo $_GET['esAbono'];?>','#FF0000');
        formateoCampoColor(document.form1.lngIvaContabilidad,'<?php echo $_GET['esAbono'];?>','#FF0000');
        formateoCampoColor(document.form1.lngIngresoContabilidad,'<?php echo $_GET['esAbono'];?>','#FF0000');
    }else{
        formateoCampoColor(document.form1.lngCantidadContabilidad,'<?php echo $_GET['esAbono'];?>','#666666');
        formateoCampoColor(document.form1.lngIvaContabilidad,'<?php echo $_GET['esAbono'];?>','#666666');
        formateoCampoColor(document.form1.lngIngresoContabilidad,'<?php echo $_GET['esAbono'];?>','#666666');
    }    
}

//borrar Asiento
function borrarAsiento(id){
    if (confirm("¿Desea borrar el Asiento de la base de datos?"))
    {
        window.location='../vista/asientoBorrar.php?id='+id;
    }
}

function asientoCerrado(){
    alert('Este asiento esta en un periodo cerrado. No se puede editar ni borrar.');
}    
</script>
    

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>

    <div data-role="content" data-theme="a">
        <form action="../vista/gastos_CFIVA1SIRPF.php" name="form1" method="POST" data-ajax="false">
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
                            <article id="post-2" class="hentry">
                            <div class="entry-summary">
                                <table border="0" style="width: 100%;">
                                    <tr>
                                        <td style="width: 50%;"></td>
                                        <td style="width: 50%;"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Empresa:</label>
                                        </td>
                                        <td>
                                            <label><font color="2e9b46"><b><?php echo $_SESSION['sesion'];?></b></font></label>
                                            <input type="hidden" name="strEmpresa" value="<?php echo $_SESSION['sesion'];?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Periodo:</label>
                                        </td>
                                        <td>
                                            <label><font color="2e9b46"><b><span id="strPeriodo"></span></b></font></label>
                                            <input type="hidden"  name="strPeriodo" value="<?php echo $datos['strPeriodo']; ?>" />
                                            <input type="hidden" id="lngPeriodo" name="lngPeriodo" value="<?php echo $datos['lngPeriodo']; ?>"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Ejercicio:</label>
                                        </td>
                                        <td>
                                            <label><font color="2e9b46"><b><span id="lngEjercicio"></span></b></font></label>
                                            <input type="hidden" id="lngEjercicioH" name="lngEjercicio" value="" />
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            </article>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label>Fecha</label>
                            <?php
                            date_default_timezone_set('Europe/Madrid');
                            $fechaForm=date('d/m/Y');
                            
                            if($editarAsiento==='SI') {
                                datepicker_español('datFecha');
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                                <input type="text" id="datFecha" name="datFecha" maxlength="38"
                                       value="<?php if(isset($datos['datFecha'])){echo $datos['datFecha'];}else {echo $fechaForm;}?>"
                                       <?php if($editarAsiento==='SI') {?>
                                       placeholder="<?php if(isset($datos['datFecha'])){echo $datos['datFecha'];}else {echo $fechaForm;}?>" 
                                       onfocus="onFocusInputTextM(this);<?php if(!isset($datos['datFecha'])){echo 'limpiaCampoFecha(this);';}?>"
                                       onblur="comprobarFechaEsCerrada(this);comprobarVacioFecha(this,'<?php echo $fechaForm;?>');fechaMes_MovilAsiento(this);"
                                       onchange="fechaMes_MovilAsiento(this);comprobarFechaEsCerrada(this);"
                                       <?php }else{?>
                                       readonly
                                       <?php }?>
                                       />
                        </td>
                    </tr>
                    <tr> 
                      <td colspan="4"> 
                          <div align="left">
                          <label class="nombreCampo">Compra o Gasto</label>
                          <?php
                          //funcion general
                          autocomplete_cuentas_SubGrupo2y6('strCuenta');
                          ?>
                            <input type="text" id="strCuenta" name="strCuenta" tabindex="2" 
                                  value="<?php echo htmlentities($datos['strCuenta'],ENT_QUOTES,'UTF-8');?>"
                                 <?php if($editarAsiento==='SI') {?>
                                  onKeyUp="comprobarCuenta(this,document.getElementById('okStrCuenta'));"  
                                  onfocus="onFocusInputTextM(this);desactivaCampoComprobacionCuenta(document.getElementById('okStrCuenta'));"
                                  onblur="comprobarCuentaBlur(this,document.getElementById('okStrCuenta'));"
                                 <?php }else{?>
                                 readonly
                                 <?php }?>
                                 />
                            <input type="hidden" id="okStrCuenta" name="okStrCuenta" value="SI" />
                          </div>
                      </td>
                    </tr>
                    <tr> 
                      <td colspan="4">
                          <div align="left">
                            <?php
                            //funcion general
                            if($_GET['tipo']==='Proveedor'){
                                $filtro='40';
                                $provAcre='Proveedor';
                                if($editarAsiento==='SI') {
                                    autocomplete_cuentas_SubGrupo4('strCuentaCli',$filtro);
                                }
                            }else if($_GET['tipo']==='Acreedor'){
                                $filtro='41';
                                $provAcre='Proveedor';
                                if($editarAsiento==='SI') {
                                    autocomplete_cuentas_SubGrupo4('strCuentaCli',$filtro);
                                }
                            }else{
                                $filtro='4';
                                $provAcre='Proveedor o Acreedor';
                                if($editarAsiento==='SI') {
                                    autocomplete_cuentas_SubGrupo40y41('strCuentaCli');
                                }
                            }
                            ?>
                            <label class="nombreCampo"><?php echo $provAcre; ?></label>
                            <input type="text" id="strCuentaCli" name="strCuentaCli" tabindex="3" 
                                 value="<?php echo htmlentities($datos['strCuentaCli'],ENT_QUOTES,'UTF-8');?>"
                                 <?php if($editarAsiento==='SI') {?>
                                 onKeyUp="comprobarCuenta(this,document.getElementById('okStrCuentaCli'));"  
                                 onfocus="onFocusInputTextM(this);desactivaCampoComprobacionCuenta(document.getElementById('okStrCuentaCli'));"
                                 onblur="comprobarCuentaBlur(this,document.getElementById('okStrCuentaCli'));" 
                                 <?php }else{?>
                                 readonly
                                 <?php }?>
                                 />
                            <input type="hidden" id="okStrCuentaCli" name="okStrCuentaCli" value="SI" />
                          </div>
                      </td>
                    </tr>
                    <tr> 
                        <td colspan="4">
                            <div align="left">
                            <label class="nombreCampo">Concepto</label>
                            <textarea name="strConcepto" rows=4 cols="20"
                                          onfocus="onFocusInputTextM(this);"
                                        <?php if($editarAsiento==='SI') {?>
                                        <?php }else{?>
                                        readonly
                                        <?php }?>
                                      ><?php echo htmlentities($datos['strConcepto'],ENT_QUOTES,'UTF-8'); ?></textarea> 
                            </div>
                        </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                          <div align="left">
                            <label>Base Imponible</label>
                            <input type="text" name="lngCantidadContabilidad" maxlength="10" style="text-align:right;font-weight:bold;"
                                   tabindex="" value="<?php if(isset($datos['lngCantidadContabilidad'])){echo $datos['lngCantidadContabilidad'];}else{echo '0,00';} ?>"
                                   style="text-align:right;font-weight:bold;"
                                   <?php if($editarAsiento==='SI') {?>
                                   onkeyUp="CalculaIvaMas(this.value,document.form1.lngPorcientoSin.value);"
                                   onblur="solonumerosM(this);CalculaIvaMas(this.value,document.form1.lngPorcientoSin.value);formateaCantidad(this);
                                           formateaNegativoContabilidad(this,'<?php echo $_GET['esAbono'];?>');
                                           formateaNegativoContabilidad(document.form1.lngIvaContabilidad,'<?php echo $_GET['esAbono'];?>');
                                           formateaNegativoContabilidad(document.form1.lngIngresoContabilidad,'<?php echo $_GET['esAbono'];?>');"
                                   onfocus="onFocusInputTextM(this);entradaCantidad(this,document.form1.lngCantidad);selecciona_value(this);"
                                   <?php }else{?>
                                   readonly
                                   <?php }?>
                                   />
                            <input type="hidden" name="lngCantidad" value="<?php echo $datos['lngCantidad']; ?>"/>
                          </div>
                      </td>
                      <td colspan="2">
                          <div align="left">
                            <label>% IVA Aplicable</label>
                                <select name="lngPorcientoSin" id="lngPorcientoSin" 
                                        onchange="CalculaIva(document.form1.lngIngreso.value,document.form1.lngPorcientoSin.value);"
                                        data-native-menu="false" data-theme='a'>
                                    <?php
                                    //preparo el listado del select
                                    $selected0='';
                                    $selected4='';
                                    $selected10='';
                                    $selected21='';
                                    if(isset($datos['lngPorcientoSin'])){ //existe IVA
                                        if($datos['lngPorcientoSin']==0){
                                            $selected0='selected';
                                        }else if($datos['lngPorcientoSin']==4){
                                            $selected4='selected';
                                        }else if($datos['lngPorcientoSin']==10){
                                            $selected10='selected';
                                        }else if($datos['lngPorcientoSin']==21){
                                            $selected21='selected';
                                        }
                                    }else //no existe IVA, por defecto 21%
                                    {
                                        $selected21='selected';
                                    }
                                    echo "<option value = '0' $selected0> 0</option>";
                                    echo "<option value = '4' $selected4> 4</option>";
                                    echo "<option value = '10' $selected10>10</option>";
                                    echo "<option value = '21' $selected21>21</option>";
                                    ?>
                                </select>
                          </div>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                          <div align="left">
                            <label>IVA Soportado</label>
                            <input type="text" name="lngIvaContabilidad" maxlength="4" readonly
                                   style="text-align:right;font-weight:bold;" value="<?php if(isset($datos['lngIvaContabilidad'])){echo $datos['lngIvaContabilidad'];}else{echo '0,00';} ?>" />
                            <input type="hidden" name="lngIva" value="<?php echo $datos['lngIva'];?>"/>
                          </div>
                      </td>
                      <td colspan="2">
                          <div align="left">
                            <label>Total Factura</label>
                            <input type="text" name="lngIngresoContabilidad" maxlength="10" style="text-align:right;font-weight:bold;"
                                   tabindex="5" value="<?php if(isset($datos['lngIngresoContabilidad'])){echo $datos['lngIngresoContabilidad'];}else{echo '0,00';} ?>"
                                   <?php if($editarAsiento==='SI') {?>
                                   onkeyUp="CalculaIva(this.value,document.form1.lngPorcientoSin.value);"
                                   onblur="solonumerosM(this);CalculaIva(this.value,document.form1.lngPorcientoSin.value);formateaCantidad(this);
                                           formateaNegativoContabilidad(this,'<?php echo $_GET['esAbono'];?>');
                                           formateaNegativoContabilidad(document.form1.lngIvaContabilidad,'<?php echo $_GET['esAbono'];?>');
                                           formateaNegativoContabilidad(document.form1.lngCantidadContabilidad,'<?php echo $_GET['esAbono'];?>');"
                                   onfocus="onFocusInputTextM(this);entradaCantidad(this,document.form1.lngIngreso);selecciona_value(this);"
                                   <?php }else{?>
                                   readonly
                                   <?php }?>
                                   />
                            <input type="hidden" name="lngIngreso" value="<?php if(isset($datos['lngIngreso'])){echo $datos['lngIngreso'];}else{echo '0.00';} ?>"/>
                          </div>
                      </td>
                    </tr>
                    <tr>
                        <td height="15px;"></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                        <div class="ui-field-contain">
                            <fieldset data-role="controlgroup" data-mini="true">
                                <input type="radio" name="optTipo" value="0" id="optTipo0" class="custom" <?php if(!(isset($datos['optTipo'])) || $datos['optTipo']=='0'){echo 'checked';} ?>
                                       data-theme="a" data-iconpos="right" onClick="ActivaSelecBanco(this);">
                                <label for="optTipo0">Dejar Pendiente</label>
                                <input type="radio" name="optTipo" id="optTipo1" class="custom" value="1" <?php if($datos['optTipo']=='1'){echo 'checked';} ?>
                                       data-theme="a" data-iconpos="right" onClick="ActivaSelecBanco(this);">
                                <label for="optTipo1">Realizar Pago</label>
                            </fieldset>
                        </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                          <div align="left" id="pantalla" style="display: none;">
                                <?php
                                //funcion general
                                autocomplete_cuentas_SubGrupo4('strCuentaBancos',57);
                                ?>
                                <label>Cuenta Banco/Caja</label>
                                <input type="text" id="strCuentaBancos" name="strCuentaBancos" <?php if(!(isset($datos['optTipo'])) || $datos['optTipo']=='0'){echo '';} ?>
                                   onKeyUp="comprobarCuenta(this,document.getElementById('okStrCuentaBancos'));" value="<?php echo htmlentities($datos['strCuentaBancos'],ENT_QUOTES,'UTF-8');?>" 
                                   onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" tabindex="8"
                                   onfocus="onFocusInputText(this);desactivaCampoComprobacionCuenta(document.getElementById('okStrCuentaBancos'));"
                                   onblur="onBlurInputText(this);comprobarCuentaBlur(this,document.getElementById('okStrCuentaBancos'));" />
                                <input type="hidden" id="okStrCuentaBancos" name="okStrCuentaBancos" value="<?php if($NoE==='nuevo'){echo 'NO';}else if($NoE==='edicion'){echo 'SI';} ?>" />
                          </div>
                        </td>
                    </tr>
            
                    
                    
                    <tr>
                        <td colspan="2">
                        <div align="center">
                            <input type="button" data-theme="a" data-icon="back" data-iconpos="right" value = "Volver" onClick="javascript:volver();" /> 
                        </div>
                        </td>
                        <td colspan="2">
                            <script languaje="JavaScript"> 
                                function volver(){
                                    javascript:history.back();
                                }
                            </script>
                            <input type="button" id="cmdAlta" name="cmdAlta" data-theme="a" data-icon="forward" data-iconpos="right" value="Grabar" onClick="javascript:validar();" /> 
                            <?php if($editarAsiento==='SI') {?>
                            <?php if(isset($_GET['editar']) && $_GET['editar']==='SI'){echo '<input type="button" data-theme="a" value="Eliminar" name="cmdBorrar" onclick="javascript:borrarAsiento('.$_GET['Asiento'].');" />';} ?>  
                            <input type="hidden"  name="cmdAlta" <?php if(isset($_GET['editar']) && $_GET['editar']==='SI'){echo 'value="Editar"';}else{echo 'value="Alta"';} ?>  />
                            <input type="hidden"  name="tipo" value="<?php if(isset($datos['tipo'])){echo $datos['tipo'];} ?>" />
                            <input type="hidden"  name="esAbono" value="<?php if(isset($_GET['esAbono'])){echo $_GET['esAbono'];}else{echo 'NO';} ?>" />
                            <?php if(isset($_GET['editar']) && $_GET['editar']==='SI'){echo '<input type="hidden"  name="Asiento" value="'.$_GET['Asiento'].'" />';} ?>  
                            <?php } ?>
                        </td>
                    </tr>                    
                </tbody>
            </table>
        </form>
    </div>    
</div>
</body>    
<?php    
}//fin del html_paginaMovil
?>