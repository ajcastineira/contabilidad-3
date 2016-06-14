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


//funcion de los javascripts comunes
function javascriptPagina(){
?>    

<script language="JavaScript">
//para los asientos de nóminas
//calcula este algoritmo:
//bruto = liquido + IRPF + SStrab
function Calcula(opcion,objeto){
    //guardo el dato en el campo hidden
    //var dato = desFormateaNumeroContabilidad(objeto.value);
    
    if(isNaN(objeto.value)){
        alert("No es numérico el valor introducido");
    }else{
        if(objeto.value !== ''){
            document.getElementById(opcion).value = objeto.value;

            //recoje los datos de:
            //bruto, IRPF, SSTrab y Liquido
            //y hago el calculo

            var bruto = parseFloat($('#lngBruto').val()).toFixed(2);
            var irpf = parseFloat($('#lngIRPF').val()).toFixed(2);
            var SSTrab = parseFloat($('#lngSSTrab').val()).toFixed(2);
            var liquido = parseFloat($('#lngLiquido').val()).toFixed(2);

            switch(opcion) {
                case 'lngBruto':
                    var calculo = parseFloat(bruto - irpf - SSTrab).toFixed(2);
                    $('#lngLiquido').val(calculo);
                    var dato = formateaNumeroContabilidad(calculo.toString());
                    $('#lngLiquidoContabilidad').val(dato);
                    break;
                case 'lngIRPF':
                    var calculo = parseFloat(bruto - irpf - SSTrab).toFixed(2);
                    $('#lngLiquido').val(calculo);
                    var dato = formateaNumeroContabilidad(calculo.toString());
                    $('#lngLiquidoContabilidad').val(dato);
                    break;
                case 'lngSSTrab':
                    var calculo = parseFloat(bruto - irpf - SSTrab).toFixed(2);
                    $('#lngLiquido').val(calculo);
                    var dato = formateaNumeroContabilidad(calculo.toString());
                    $('#lngLiquidoContabilidad').val(dato);
                    break;
                case 'lngLiquido':
                    var calculo = parseFloat(irpf) + parseFloat(SSTrab) + parseFloat(liquido);
                    $('#lngBruto').val(calculo.toFixed(2));
                    var dato = formateaNumeroContabilidad(calculo.toFixed(2));
                    $('#lngBrutoContabilidad').val(dato);
                    break;
            } 
        }else{
            alert("Debe rellenar el campo");
        }
    }
}

function recojeOculto(opcion,objeto){
    objeto.value = $('#'+opcion).val();
    return false;
}

function textoDefectoConcepto(){
    document.getElementById('strConcepto').value = 'Nómina del mes de '+document.getElementById('strPeriodo').value+' de '+document.getElementById('lngEjercicio').value;
}

</script>
<?php    
}



//codigo principal
//comprobamos si se ha submitido el formulario y que que valor viene en 'cmdAlta'
if(isset($_POST['opcion'])){
    //var_dump($_POST);die;
    if($_POST['opcion'] === 'Alta'){
        logger('info','gastos_nomina.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
               " ||||Contabilidad->Compras y Gastos||Ha pulsado 'Grabar' (Alta)");


        //guardo el gasto el la tabla tbmovimientos, tbacumulados y tbmovimientos_iva (tipo 3)
        $varRes = $clsCNContabilidad->AltaNomina($_POST, $_SESSION["strUsuario"],$_SESSION["idEmp"]);

        if($varRes === false){
            echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/error.php?id='.$varRes.'">';
        }else{
            //voy a la pagina de 'gastos_exito.php'
            echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/gastos_exito.php?op=3">';
        }
    }
    else
    if($_POST['opcion'] === 'Editar'){
        logger('info','gastos_nomina.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
               " ||||Contabilidad->Compras y Gastos||Ha pulsado 'Grabar' (Editar)");

        //primero doy de baja el asiento actual
        $OK = $clsCNContabilidad->DarBajaAsiento($_POST['Asiento']);
        
//        var_dump($_POST);die;
        
        //si falla, vamos a la pantalla de error
        if($OK <> 1){
            echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/error.php?id=No se a editado el asiento">';
        }else{
            //doy de alta el asiento actualizo (tipo 3)
            $varRes = $clsCNContabilidad->AltaNomina($_POST, $_SESSION["strUsuario"],$_SESSION["idEmp"]);

            if($varRes === false){
                //como ha fallado vuelvo a dar de alta el asiento actual
                $OK = $clsCNContabilidad->DarAltaAsiento($_POST['Asiento']);
                
                echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/error.php?id=No se a editado el asiento">';
            }else{
                //voy a la pagina de 'exito.php'
                echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/exito.php">';
            }
        }
    }
}

//se viene de submitir el form
else{//comienzo del else principal
    logger('info','gastos_nomina.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
           " ||||Contabilidad->Compras y Gastos||");
    
    $datosUsuario = $clsCNUsu->DatosUsuario($_SESSION['usuario']);
    
    //vemos si es editar o nuevo
    if(isset($_GET['Asiento']) && $_GET['Asiento'] !== ''){
        //se buscan los datos de este asiento para cargarlos en el formulario
        $datos = $clsCNContabilidad->DatosAsientoNomina($_GET['Asiento'],$_GET['esAbono']);
        
        //si no encuentra el asiento (viene false), redireccionamos a default2.php
        if($datos === false){
            echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/default2.php">';die;
        }
        //vemos si el asiento esta en un perido editable para el iva (PREGUNTAR HACER UN BLOQUEO PARA IRPF JM 25/5/2016)
        //$editarAsiento=$clsCNContabilidad->AsientoEditable($datos['lngEjercicio'],$datos['lngPeriodo']);
        
    }else{
        $datos = '';
    }
    
    //sino viene la variable $_GET['esAbono'], la indicamos y con valor 'NO'
    if(!isset($_GET['esAbono'])){
        $_GET['esAbono'] = 'NO';
    }
    
    //aqui dirijo a la presentacion en PC o Movil (APP)
    if($_SESSION['navegacion'] === 'movil'){
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
javascriptPagina();
?>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../images/q.ico">
<TITLE>Nóminas</TITLE>

<script language="JavaScript">

function validarForm()
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
  //comprobacion del campo 'strConcepto'
  if (document.form1.strConcepto.value === ''){ 
    textoError=textoError+"Es necesario introducir el concepto.\n";
    document.form1.strConcepto.style.borderColor='#FF0000';
    document.form1.strConcepto.title ='Se debe introducir el concepto';
    esValido=false;
  }
  
  //comprobacion del campo 'lngBrutoContabilidad'
  if(document.form1.lngBrutoContabilidad.value === '' || document.form1.lngBrutoContabilidad.value === '0,00'){
    textoError=textoError+"Es necesario introducir el importe bruto y que sea mayor que 0.00\n";
    document.form1.lngBrutoContabilidad.style.borderColor='#FF0000';
    document.form1.lngBrutoContabilidad.title ='Es necesario introducir el importe bruto.';
    esValido=false;
  }

  //comprobacion del campo 'lngSSTrabContabilidad'
  if(document.form1.lngSSTrabContabilidad.value === ''){
    textoError=textoError+"Es necesario introducir los Seg. Sociales a c/ trabajador.\n";
    document.form1.lngSSTrabContabilidad.style.borderColor='#FF0000';
    document.form1.lngSSTrabContabilidad.title ='Es necesario introducir los Seg. Sociales a c/ trabajador.';
    esValido=false;
  }
  
  //comprobacion del campo 'lngIRPFContabilidad'
  if(document.form1.lngIRPFContabilidad.value === ''){
    textoError=textoError+"Es necesario introducir el IRPF.\n";
    document.form1.lngIRPFContabilidad.style.borderColor='#FF0000';
    document.form1.lngIRPFContabilidad.title ='Es necesario introducir el IRPF.';
    esValido=false;
  }
  
  //comprobacion del campo 'lngLiquidoContabilidad'
  if(document.form1.lngLiquidoContabilidad.value === ''){
    textoError=textoError+"La cantidad de importe líquido debe existir y ser mayor 0.00.\n";
    document.form1.lngLiquidoContabilidad.style.borderColor='#FF0000';
    document.form1.lngLiquidoContabilidad.title ='La cantidad de importe líquido debe existir y ser mayor 0.00.';
    esValido=false;
  }

  //comprobacion del campo 'lngSSEmpContabilidad'
  if(document.form1.lngSSEmpContabilidad.value === ''){
    textoError=textoError+"Es necesario introducir los Seg. Sociales a c/ empresa.\n";
    document.form1.lngSSEmpContabilidad.style.borderColor='#FF0000';
    document.form1.lngSSEmpContabilidad.title ='Es necesario introducir los Seg. Sociales a c/ empresa.';
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
              fechaMes(document.getElementById('datFecha'));
              <?php
              if(!isset($_GET['Asiento'])){
                  echo "textoDefectoConcepto();";
              }
              ?>
              formateoColoresCampo('<?php echo $_GET['esAbono'];?>');
              focusFecha();
              <?php
                if($editarAsiento==='SI'){
//                    if(!isset($_GET['editar']) && !isset($_GET['datFecha'])){
//                        echo 'focusFecha();';
//                    }
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
$cabeceraNumero='020302n';
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
    <form name="form1" method="post" action="../vista/gastos_nomina.php">
        
      <table width="640" border="0" class="zonaactiva">
        <tr> 
          <td class="subtitulo" colspan="11">&nbsp;Nómina</td>
        </tr>
        <tr>
            <td width="8%"></td>
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
              <input type="hidden" id="lngPeriodo" name="lngPeriodo" value="<?php echo $datos['lngPeriodo']; ?>" />
              <input type="hidden" id="esAbono" name="esAbono" value="<?php echo $datos['esAbono']; ?>" />
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
                   onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
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
            <td height="15px"></td>
        </tr>
        <tr>
            <td height="15px" colspan="11"><hr/></td>
        </tr>
      </table>
        
      <table width="640" border="0" class="zonaactiva">
        <tr>
            <td width="5%"></td>
            <td width="16%"></td>
            <td width="5%"></td>
            <td width="48%"></td>
            <td width="5%"></td>
            <td width="16%"></td>
            <td width="5%"></td>
        </tr>
        <tr>
          <td></td>
          <td colspan="6">
              <div align="left">
              <label class="nombreCampo">Concepto</label>
              <input class="textbox1" type="text" id="strConcepto" name="strConcepto" maxlength="122" tabindex="1"
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
            <td height="15px"></td>
        </tr>
        
        <tr>
          <td></td>
          <td>
              <div align="left">
              <input class="textbox1" type="text" id="lngBrutoContabilidad" name="lngBrutoContabilidad" style="text-align:right;font-weight:bold;"
                     tabindex="2" value="<?php if(isset($datos['lngBruto'])){echo formateaNumeroContabilidad($datos['lngBruto']);}else{echo '0,00';} ?>"
                     <?php if($editarAsiento === 'SI') {?>
                     onkeypress="return solonumeros(event);" 
                     onblur="onBlurInputText(this);Calcula('lngBruto',this);formateaCantidad(this);
                             formateaNegativoContabilidad(this,'<?php echo $_GET['esAbono'];?>');"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);recojeOculto('lngBruto',this);selecciona_value(this);"
                     <?php }else{?>
                     readonly
                     <?php }?>
                     />
              <input type="hidden" id="lngBruto" name="lngBruto" value="<?php echo $datos['lngBruto']; ?>"/>
              </div>
          </td>
          <td><font size="-3">6400</font></td>
          <td>
              <div align="center">
                <label class="nombreCampo">Importe Bruto / Total Devengos</label>
              </div>
          </td>
        </tr>
        
        <tr>
          <td colspan="3"></td>
          <td>
              <div align="center">
                <label class="nombreCampo">Retención IRPF</label>
              </div>
          </td>
          <td><font size="-3"><div align="right">4751</div></font></td>
          <td>
              <div align="left">
              <input class="textbox1" type="text" id="lngIRPFContabilidad" name="lngIRPFContabilidad" style="text-align:right;font-weight:bold;"
                     tabindex="3" value="<?php if(isset($datos['lngIRPF'])){echo formateaNumeroContabilidad($datos['lngIRPF']);}else{echo '0,00';} ?>"
                     <?php if($editarAsiento==='SI') {?>
                     onkeypress="return solonumeros(event);" 
                     onblur="onBlurInputText(this);Calcula('lngIRPF',this);formateaCantidad(this);
                             formateaNegativoContabilidad(this,'<?php echo $_GET['esAbono'];?>');"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);recojeOculto('lngIRPF',this);selecciona_value(this);"
                     <?php }else{?>
                     readonly
                     <?php }?>
                     />
              <input type="hidden" id="lngIRPF" name="lngIRPF" value="<?php if(isset($datos['lngIRPF'])){echo $datos['lngIRPF'];}else{echo '0.00';} ?>"/>
              </div>
          </td>
        </tr>
        
        <tr>
          <td colspan="3"></td>
          <td>
              <div align="center">
                <label class="nombreCampo">Retención Seguros Sociales</label>
              </div>
          </td>
          <td><font size="-3"><div align="right">6420</div></font></td>
          <td>
              <div align="left">
              <input class="textbox1" type="text" id="lngSSTrabContabilidad" name="lngSSTrabContabilidad" maxlength="10" style="text-align:right;font-weight:bold;"
                     tabindex="4" value="<?php if(isset($datos['lngSSTrab'])){echo formateaNumeroContabilidad($datos['lngSSTrab']);}else{echo '0,00';} ?>"
                     <?php if($editarAsiento==='SI') {?>
                     onkeypress="return solonumeros(event);" 
                     onblur="onBlurInputText(this);Calcula('lngSSTrab',this);formateaCantidad(this);
                             formateaNegativoContabilidad(this,'<?php echo $_GET['esAbono'];?>');"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);recojeOculto('lngSSTrab',this);selecciona_value(this);"
                     <?php }else{?>
                     readonly
                     <?php }?>
                     />
              <input type="hidden" id="lngSSTrab" name="lngSSTrab" value="<?php if(isset($datos['lngSSTrab'])){echo $datos['lngSSTrab'];}else{echo '0.00';} ?>"/>
              </div>
          </td>
        </tr>
        
        <tr>
          <td colspan="3"></td>
          <td>
              <div align="center">
                <label class="nombreCampo">Importe Líquido</label>
              </div>
          </td>
          <td><font size="-3"><div align="right">4650</div></font></td>
          <td>
              <div align="left">
              <input class="textbox1" type="text" id="lngLiquidoContabilidad" name="lngLiquidoContabilidad" style="text-align:right;font-weight:bold;"
                     tabindex="5" value="<?php if(isset($datos['lngLiquido'])){echo formateaNumeroContabilidad($datos['lngLiquido']);}else{echo '0,00';} ?>"
                     <?php if($editarAsiento==='SI') {?>
                     onkeypress="return solonumeros(event);" 
                     onblur="onBlurInputText(this);Calcula('lngLiquido',this);formateaCantidad(this);
                             formateaNegativoContabilidad(this,'<?php echo $_GET['esAbono'];?>');"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);recojeOculto('lngLiquido',this);selecciona_value(this);"
                     <?php }else{?>
                     readonly
                     <?php }?>
                     />
              <input type="hidden" id="lngLiquido" name="lngLiquido" value="<?php if(isset($datos['lngLiquido'])){echo $datos['lngLiquido'];}else{echo '0.00';} ?>"/>
              </div>
          </td>
        </tr>
        
        <tr>
          <td></td>
          <td>
              <div align="left">
              <input class="textbox1" type="text" id="lngSSEmpContabilidad" name="lngSSEmpContabilidad" style="text-align:right;font-weight:bold;"
                     tabindex="6" value="<?php if(isset($datos['lngSSEmp'])){echo formateaNumeroContabilidad($datos['lngSSEmp']);}else{echo '0,00';} ?>"
                     <?php if($editarAsiento==='SI') {?>
                     onkeypress="return solonumeros(event);" 
                     onblur="onBlurInputText(this);Calcula('lngSSEmp',this);formateaCantidad(this);
                             formateaNegativoContabilidad(this,'<?php echo $_GET['esAbono'];?>');"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);recojeOculto('lngSSEmp',this);selecciona_value(this);"
                     <?php }else{?>
                     readonly
                     <?php }?>
                     />
              <input type="hidden" id="lngSSEmp" name="lngSSEmp" value="<?php if(isset($datos['lngSSEmp'])){echo $datos['lngSSEmp'];}else{echo '0.00';} ?>"/>
              </div>
          </td>
          <td><font size="-3">4760</font></td>
          <td>
              <div align="center">
                <label class="nombreCampo">Total Seg. Sociales (Cuota a c/empresa y trabajador)</label>
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
                //javascript:window.location = '../vista/ingresos_gastos_ver.php?Asiento='+id+'&borrar=';
            }
        </script>
        <input type="button" class="button" name="cmdAlta" id="cmdAlta" value = "Grabar" onclick="javascript:validarForm();" tabindex="7" /> 
        <input class="buttonAzul" type="button" value="Volver" onclick="volver();" />
        <?php if($editarAsiento==='SI') {?>
        <?php if(isset($_GET['Asiento']) && $_GET['Asiento'] !== ''){echo '<input type="button" class="buttonAzul" value="Eliminar" name="cmdBorrar" onclick="javascript:borrarAsiento('.$_GET['Asiento'].');" />';} ?>  
        <input type="Reset" class="button" value="<?php if(isset($_GET['editar']) && $_GET['editar']==='SI'){echo 'Datos Iniciales';}else{echo 'Vaciar Datos';} ?>" name="cmdReset" tabindex="10" />
        <input type="hidden" name="opcion" <?php if(isset($_GET['Asiento']) && $_GET['Asiento'] !== ''){echo 'value="Editar"';}else{echo 'value="Alta"';} ?>  />
        <input type="hidden" name="esAbono" value="<?php if(isset($_GET['esAbono'])){echo $_GET['esAbono'];}else{echo 'NO';} ?>" />
        <?php if(isset($_GET['Asiento']) && $_GET['Asiento'] !== ''){echo '<input type="hidden"  name="Asiento" value="'.$_GET['Asiento'].'" />';} ?>  
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
<TITLE>Nóminas</TITLE>

<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>
<link rel="stylesheet" href="../css/estiloMovil.css" />
        
</head>
<BODY onLoad="fechaMes_MovilAsiento(document.getElementById('datFecha'));
              <?php
              if(!isset($_GET['Asiento'])){
                  echo "textoDefectoConcepto();";
              }
              ?>
              <?php
                if($editarAsiento==='SI'){
                    if(!isset($_GET['editar']) && !isset($_GET['datFecha'])){
                        //echo 'focusFecha();';
                    }
                    if(isset($_GET['borrar'])&& $_GET['borrar']=='si'){
                        echo 'borrarAsiento('. $_GET['Asiento'].');';
                    }
                }else{
                    echo 'asientoCerrado();';
                }
              ?>"
      class="api jquery-mobile archive category category-widgets category-2 listing single-author"> 

<div data-role="page" id="gastos_nomina">
<?php
eventosInputText();
javascriptPagina();
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
  //comprobacion del campo 'strConcepto'
  if (document.form1.strConcepto.value === ''){ 
    textoError=textoError+"Es necesario introducir el concepto.\n";
    document.form1.strConcepto.style.borderColor='#FF0000';
    esValido=false;
  }
 
  if (document.form1.lngBrutoContabilidad.value === '' || document.form1.lngBrutoContabilidad.value === '0,00'){ 
      textoError=textoError+"Es necesario introducir el importe bruto y que sea mayor que 0.00\n";
      $('#lngBrutoContabilidad').parent().css('border-color','red');
      esValido=false;
  }

  //comprobacion del campo 'lngSSTrabContabilidad'
  if(document.form1.lngSSTrabContabilidad.value === ''){
    textoError=textoError+"Es necesario introducir los Seg. Sociales a c/ trabajador.\n";
    $('#lngSSTrabContabilidad').parent().css('border-color','red');
    esValido=false;
  }
  
  //comprobacion del campo 'lngIRPFContabilidad'
  if(document.form1.lngIRPFContabilidad.value === ''){
    textoError=textoError+"Es necesario introducir el IRPF.\n";
    $('#lngIRPFContabilidad').parent().css('border-color','red');
    esValido=false;
  }
  
  //comprobacion del campo 'lngLiquidoContabilidad'
  if(document.form1.lngLiquidoContabilidad.value === ''){
    textoError=textoError+"La cantidad de importe líquido debe existir y ser mayor 0.00.\n";
    $('#lngLiquidoContabilidad').parent().css('border-color','red');
    esValido=false;
  }

  //comprobacion del campo 'lngSSEmpContabilidad'
  if(document.form1.lngSSEmpContabilidad.value === ''){
    textoError=textoError+"Es necesario introducir los Seg. Sociales a c/ empresa.\n";
    $('#lngSSEmpContabilidad').parent().css('border-color','red');
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

//function ActivaSelecBanco(objeto){
//    if(objeto.value==0){
//        $('#pantalla').slideUp(1000);
//    }else{
//        $('#pantalla').slideDown(1000);
//    }
//}


//formatear valores numericos con puntos de miles y comas para decimales
function formateaNumeroContabilidad2(numero) {
    decimales=2;
    separador_decimal=',';
    separador_miles='.';
    numero=parseFloat(numero);
    if(isNaN(numero)){
        return "";
    }

    if(decimales!==undefined){
        // Redondeamos
        numero=numero.toFixed(decimales);
    }

    // Convertimos el punto en separador_decimal
    numero=numero.toString().replace(".", separador_decimal!==undefined ? separador_decimal : ",");

    if(separador_miles){
        // Añadimos los separadores de miles
        var miles=new RegExp("(-?[0-9]+)([0-9]{3})");
        while(miles.test(numero)) {
            numero=numero.replace(miles, "$1" + separador_miles + "$2");
        }
    }

    return numero;

}

function desFormateaNumeroContabilidad2(numero) {
    //contar los puntos que hay
    var punto=".";
    var cont=0;
    for(i=0;i<numero.length;i++){
        var let=numero.substring(i,(i+1));
        if(punto===let){
            cont=cont + 1;
        }
    }
    //quitar los puntos de miles
    for (j=0;j<cont;j++){
        numero=numero.replace(".", "");
    }
    //cambiar la coma de decimales por punto
    numero=numero.replace(",", ".");
    
    return numero;
}

//formateo de numeros
function formateaCantidad(objeto){
    objeto.value=formateaNumeroContabilidad2(objeto.value);
}    

function desFormateaCantidad(objeto){
    objeto.value=desFormateaNumeroContabilidad2(objeto.value);
}    

////poner en color rojo los campos siguientes
//function formateoColoresCampo(esAbono){
//    if(esAbono==='SI'){
//        formateoCampoColor(document.form1.lngCantidadContabilidad,'<?php //echo $_GET['esAbono'];?>','#FF0000');
//        formateoCampoColor(document.form1.lngIvaContabilidad,'<?php //echo $_GET['esAbono'];?>','#FF0000');
//        formateoCampoColor(document.form1.lngIngresoContabilidad,'<?php //echo $_GET['esAbono'];?>','#FF0000');
//    }else{
//        formateoCampoColor(document.form1.lngCantidadContabilidad,'<?php //echo $_GET['esAbono'];?>','#666666');
//        formateoCampoColor(document.form1.lngIvaContabilidad,'<?php //echo $_GET['esAbono'];?>','#666666');
//        formateoCampoColor(document.form1.lngIngresoContabilidad,'<?php //echo $_GET['esAbono'];?>','#666666');
//    }    
//}

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
        <form action="../vista/gastos_nomina.php" name="form1" method="POST" data-ajax="false">
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
                                            <input type="hidden"  id="strPeriodo" name="strPeriodo" value="<?php echo $datos['strPeriodo']; ?>" />
                                            <input type="hidden" id="lngPeriodo" name="lngPeriodo" value="<?php echo $datos['lngPeriodo']; ?>"/>
                                            <input type="hidden" id="esAbono" name="esAbono" value="<?php echo $datos['esAbono']; ?>" />
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
                            <hr/>
                        </td>
                    </tr>
                    <tr> 
                        <td colspan="4">
                            <div align="left">
                            <label class="nombreCampo">Concepto</label>
                            <textarea id="strConcepto" name="strConcepto" rows=4 cols="20" tabindex="1"
                                          onfocus="javascript:document.form1.strConcepto.style.borderColor='#aaa666';"
                                        <?php if($editarAsiento==='SI') {?>
                                        <?php }else{?>
                                        readonly
                                        <?php }?>
                                      ><?php echo htmlentities($datos['strConcepto'],ENT_QUOTES,'UTF-8'); ?></textarea> 
                            </div>
                        </td>
                    </tr>
                    <tr> 
                      <td colspan="3"> 
                          <div align="left">
                          <label class="nombreCampo">Importe Bruto / Total Devengos</label>
                            <input type="text" id="lngBrutoContabilidad" name="lngBrutoContabilidad" tabindex="2" 
                                  value="<?php if(isset($datos['lngBruto'])){echo formateaNumeroContabilidad($datos['lngBruto']);}else{echo '0,00';} ?>"
                                 <?php if($editarAsiento==='SI') {?>
                                  onKeyUp=""  
                                  onfocus="onFocusInputTextM(this);desFormateaCantidad(this);selecciona_value(this);"
                                  onblur="Calcula('lngBruto',this);formateaCantidad(this);"
                                 <?php }else{?>
                                 readonly
                                 <?php }?>
                                 />
                            <input type="hidden" id="lngBruto" name="lngBruto" value="<?php echo $datos['lngBruto']; ?>"/>
                          </div>
                      </td>
                      <td>
                          <label class="nombreCampo">(6400)</label>
                      </td>
                    </tr>
                    <tr> 
                      <td colspan="3"> 
                          <div align="left">
                          <label class="nombreCampo">Retención IRPF</label>
                            <input type="text" id="lngIRPFContabilidad" name="lngIRPFContabilidad" tabindex="3" 
                                  value="<?php if(isset($datos['lngIRPF'])){echo formateaNumeroContabilidad($datos['lngIRPF']);}else{echo '0,00';} ?>"
                                 <?php if($editarAsiento==='SI') {?>
                                  onKeyUp=""  
                                  onfocus="onFocusInputTextM(this);desFormateaCantidad(this);selecciona_value(this);"
                                  onblur="Calcula('lngIRPF',this);formateaCantidad(this);"
                                 <?php }else{?>
                                 readonly
                                 <?php }?>
                                 />
                            <input type="hidden" id="lngIRPF" name="lngIRPF" value="<?php if(isset($datos['lngIRPF'])){echo $datos['lngIRPF'];}else{echo '0.00';} ?>"/>
                          </div>
                      </td>
                      <td>
                          <label class="nombreCampo">(4751)</label>
                      </td>
                    </tr>
                    <tr> 
                      <td colspan="3"> 
                          <div align="left">
                          <label class="nombreCampo">Retención Seguros Sociales</label>
                            <input type="text" id="lngSSTrabContabilidad" name="lngSSTrabContabilidad" tabindex="4" 
                                  value="<?php if(isset($datos['lngSSTrab'])){echo formateaNumeroContabilidad($datos['lngSSTrab']);}else{echo '0,00';} ?>"
                                 <?php if($editarAsiento==='SI') {?>
                                  onKeyUp=""  
                                  onfocus="onFocusInputTextM(this);desFormateaCantidad(this);selecciona_value(this);"
                                  onblur="Calcula('lngSSTrab',this);formateaCantidad(this);"
                                 <?php }else{?>
                                 readonly
                                 <?php }?>
                                 />
                            <input type="hidden" id="lngSSTrab" name="lngSSTrab" value="<?php if(isset($datos['lngSSTrab'])){echo $datos['lngSSTrab'];}else{echo '0.00';} ?>"/>
                          </div>
                      </td>
                      <td>
                          <label class="nombreCampo">(4650)</label>
                      </td>
                    </tr>
                    <tr> 
                      <td colspan="3"> 
                          <div align="left">
                          <label class="nombreCampo">Importe Líquido</label>
                            <input type="text" id="lngLiquidoContabilidad" name="lngLiquidoContabilidad" tabindex="4" 
                                  value="<?php if(isset($datos['lngLiquido'])){echo formateaNumeroContabilidad($datos['lngLiquido']);}else{echo '0,00';} ?>"
                                 <?php if($editarAsiento==='SI') {?>
                                  onKeyUp=""  
                                  onfocus="onFocusInputTextM(this);desFormateaCantidad(this);selecciona_value(this);"
                                  onblur="Calcula('lngLiquido',this);formateaCantidad(this);"
                                 <?php }else{?>
                                 readonly
                                 <?php }?>
                                 />
                            <input type="hidden" id="lngLiquido" name="lngLiquido" value="<?php if(isset($datos['lngLiquido'])){echo $datos['lngLiquido'];}else{echo '0.00';} ?>"/>
                          </div>
                      </td>
                      <td>
                          <label class="nombreCampo">(4650)</label>
                      </td>
                    </tr>
                    <tr> 
                      <td colspan="4"> 
                          <div align="left">
                              <label class="nombreCampo">Total Seg. Sociales (Cuota a c/empresa y trabajador)</label>
                          </div>
                      </td>
                    </tr>
                    <tr> 
                      <td colspan="3"> 
                          <div align="left">
                            <input type="text" id="lngSSEmpContabilidad" name="lngSSEmpContabilidad" tabindex="4" 
                                  value="<?php if(isset($datos['lngSSEmp'])){echo formateaNumeroContabilidad($datos['lngSSEmp']);}else{echo '0,00';} ?>"
                                 <?php if($editarAsiento==='SI') {?>
                                  onKeyUp=""  
                                  onfocus="onFocusInputTextM(this);desFormateaCantidad(this);selecciona_value(this);"
                                  onblur="Calcula('lngSSEmp',this);formateaCantidad(this);"
                                 <?php }else{?>
                                 readonly
                                 <?php }?>
                                 />
                            <input type="hidden" id="lngSSEmp" name="lngSSEmp" value="<?php if(isset($datos['lngSSEmp'])){echo $datos['lngSSEmp'];}else{echo '0.00';} ?>"/>
                          </div>
                      </td>
                      <td>
                          <label class="nombreCampo">(4760)</label>
                      </td>
                    </tr>
                    
                    <tr>
                        <td height="15px;"></td>
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
                            <input type="hidden" name="opcion" <?php if(isset($_GET['Asiento']) && $_GET['Asiento'] !== ''){echo 'value="Editar"';}else{echo 'value="Alta"';} ?>  />
                            <input type="hidden" name="esAbono" value="<?php if(isset($_GET['esAbono'])){echo $_GET['esAbono'];}else{echo 'NO';} ?>" />
                            <?php if(isset($_GET['Asiento']) && $_GET['Asiento'] !== ''){echo '<input type="hidden"  name="Asiento" value="'.$_GET['Asiento'].'" />';} ?>  
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