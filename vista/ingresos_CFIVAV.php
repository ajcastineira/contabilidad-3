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
//  ConFactura+IVA_Varios+SinRetencionIRPF  = Caso 4
//
//
if(isset($_POST['cmdAlta']) && $_POST['cmdAlta']=='Alta'){ 
    logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
           " ||||Operaciones->Mis Ingresos|| Ha pulsado 'Aceptar'(ConFactura+IVA_Varios+SinRetencionIRPF)");
    
    //primero comprobar que exista DNI/CIF
    //si existe, traigo los datos, si no doy error y no hago nada
    $NIFCIF=$clsCNUsu->ExisteNIF_CIF($_SESSION["idEmp"]);
    //print_r($_POST);die;
    if($NIFCIF==false){
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/error.php?id=No existe NIF/CIF de esta empresa.<br/> No se han grabado los datos">';
    }else{
        //hay datos de la empresa
        //grabamos en las tablas tbmovimientos, tbacumulados y tbmovimientos_iva
        $varRes = $clsCNContabilidad->AltaIngresosMovimientosIVA_Varios(0,$_SESSION["idEmp"],$_POST['strCuenta'], $_POST["Total"],
                                                $_POST['strCuentaCli'], $_POST["lngCantidadTotal"],$_POST["lngIvaTotal"], $_POST["datFecha"],$_POST['optTipo'],
                                                $_POST['strCuentaBancos'],$_POST["lngPeriodo"], $_POST["lngEjercicio"], addslashes($_POST["strConcepto"]), $_SESSION["strUsuario"],
                                                $_POST['lngCantidad1'],$_POST['lngIva1'],$_POST['lngPorciento1'],
                                                $_POST['lngCantidad2'],$_POST['lngIva2'],$_POST['lngPorciento2'],
                                                $_POST['lngCantidad3'],$_POST['lngIva3'],$_POST['lngPorciento3'],
                                                $_POST['lngCantidad4'],$_POST['lngIva4'],$_POST['lngPorciento4'], $_POST['esAbono']);   

    logger('warning','' ,
           ' $clsCNContabilidad->AltaIngresosMovimientosIVA_Varios(0,'.$_SESSION["idEmp"].",'".$_POST['strCuenta']."','". $_POST["Total"]."','".
                                                $_POST['strCuentaCli']."','". $_POST["lngCantidadTotal"]."','".$_POST["lngIvaTotal"]."','". $_POST["datFecha"]."','".$_POST['optTipo']."','".
                                                $_POST['strCuentaBancos']."','".$_POST["lngPeriodo"]."','". $_POST["lngEjercicio"]."','". addslashes($_POST["strConcepto"])."','". $_SESSION["strUsuario"]."','".
                                                $_POST['lngCantidad1']."','".$_POST['lngIva1']."','".$_POST['lngPorciento1']."','".
                                                $_POST['lngCantidad2']."','".$_POST['lngIva2']."','".$_POST['lngPorciento2']."','".
                                                $_POST['lngCantidad3']."','".$_POST['lngIva3']."','".$_POST['lngPorciento3']."','".
                                                $_POST['lngCantidad4']."','".$_POST['lngIva4']."','".$_POST['lngPorciento4']."','". $_POST['esAbono']."');");
											
    if($varRes==FALSE){
            echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/error.php?id='.$varRes.'">';
        }else{
//        //paso por array los datos del formulario, por si se tuviesen que utilizar mas tarde (son los del POST)
//        $strPeriodo=$clsCNContabilidad->periodo($_POST["lngPeriodo"]);
//        
//        $datosForm=array(
//            "strCuenta"=>$_POST['strCuenta'],
//            "Total"=>$_POST["Total"],
//            "ContabilidadTotal"=>$_POST["ContabilidadTotal"],
//            "strCuentaCli"=>$_POST['strCuentaCli'],
//            "lngCantidadTotal"=>$_POST["lngCantidadTotal"],
//            "lngCantidadContabilidadTotal"=>$_POST["lngCantidadContabilidadTotal"],
//            "lngIvaTotal"=>$_POST["lngIvaTotal"],
//            "lngIvaContabilidadTotal"=>$_POST["lngIvaContabilidadTotal"],
//            "datFecha"=>$_POST["datFecha"],
//            "optTipo"=>$_POST['optTipo'],
//            "strCuentaBancos"=>$_POST['strCuentaBancos'],
//            "lngPeriodo"=>$_POST["lngPeriodo"],
//            "strPeriodo"=>$strPeriodo,
//            "lngEjercicio"=>$_POST["lngEjercicio"],
//            "strConcepto"=>$_POST["strConcepto"],
//            "lngCantidad1"=>$_POST["lngCantidad1"],
//            "lngCantidadContabilidad1"=>$_POST["lngCantidadContabilidad1"],
//            "lngIva1"=>$_POST["lngIva1"],
//            "lngIvaContabilidad1"=>$_POST["lngIvaContabilidad1"],
//            "lngPorciento1"=>$_POST["lngPorciento1"],
//            "lngCantidad2"=>$_POST["lngCantidad2"],
//            "lngCantidadContabilidad2"=>$_POST["lngCantidadContabilidad2"],
//            "lngIva2"=>$_POST["lngIva2"],
//            "lngIvaContabilidad2"=>$_POST["lngIvaContabilidad2"],
//            "lngPorciento2"=>$_POST["lngPorciento2"],
//            "lngCantidad3"=>$_POST["lngCantidad3"],
//            "lngCantidadContabilidad3"=>$_POST["lngCantidadContabilidad3"],
//            "lngIva3"=>$_POST["lngIva3"],
//            "lngIvaContabilidad3"=>$_POST["lngIvaContabilidad3"],
//            "lngPorciento3"=>$_POST["lngPorciento3"],
//            "lngCantidad4"=>$_POST["lngCantidad4"],
//            "lngCantidadContabilidad4"=>$_POST["lngCantidadContabilidad4"],
//            "lngIva4"=>$_POST["lngIva4"],
//            "lngIvaContabilidad4"=>$_POST["lngIvaContabilidad4"],
//            "lngPorciento4"=>$_POST["lngPorciento4"]
//        );
//        $compactada=serialize($datosForm);
//        $compactada=urlencode($compactada);

        
        
        //voy a la pagina de 'ingresos_exito.php'
//        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/ingresos_exito.php?op=CFIVAV&datos='.$compactada.'&esAbono='.$_POST["esAbono"].'">';
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/gastos_exito.php?op=CFIVAV">';
        }
    }
    
}
//se viene del listado de editar asientos (listado_asientos2.php)
else if(isset($_GET['editar']) && $_GET['editar']==='SI'){
    logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
           " ||||Operaciones->Modificar Asiento||");

    $datosUsuario=$clsCNUsu->DatosUsuario($_SESSION['usuario']);
    
    //se buscan los datos de este asiento para cargarlos en el formulario
    $datos=$clsCNContabilidad->DatosAsientoCFIVAV($_GET['Asiento'],$_GET['esAbono']);
    
    //vemos si el asiento esta en un perido editable para el iva
    $editarAsiento=$clsCNContabilidad->AsientoEditable($datos['lngEjercicio'],$datos['lngPeriodo']);
    
    //si $datos[Borrado]='0' este asiento esta borrado por lo que redirecciono a 'default2.php'
    if(isset($datos['Borrado']) && $datos['Borrado']==='1'){
        //presento el formulario con los datos
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
        
        $OK2 = $clsCNContabilidad->AltaIngresosMovimientosIVA_Varios($_POST['Asiento'],$_SESSION["idEmp"],$_POST['strCuenta'], $_POST["Total"],
                                                $_POST['strCuentaCli'], $_POST["lngCantidadTotal"],$_POST["lngIvaTotal"], $_POST["datFecha"],$_POST['optTipo'],
                                                $_POST['strCuentaBancos'],$_POST["lngPeriodo"], $_POST["lngEjercicio"], addslashes($_POST["strConcepto"]), $_SESSION["strUsuario"],
                                                $_POST['lngCantidad1'],$_POST['lngIva1'],$_POST['lngPorciento1'],
                                                $_POST['lngCantidad2'],$_POST['lngIva2'],$_POST['lngPorciento2'],
                                                $_POST['lngCantidad3'],$_POST['lngIva3'],$_POST['lngPorciento3'],
                                                $_POST['lngCantidad4'],$_POST['lngIva4'],$_POST['lngPorciento4'], $_POST['esAbono']);   
        
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
    logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
           " ||||Operaciones->Mis Ingresos||");
    
    $datosUsuario=$clsCNUsu->DatosUsuario($_SESSION['usuario']);
    
    //recojemos los datos si venimos de pulsar 'VOLVER' en 'gastos_exito.php'
    if(isset($_GET['datos'])){
        $datos=stripslashes ($_GET['datos']);
        $datos=unserialize ($datos);
        //print_r($datos);
    }else{
        $datos=null;
    }
    
    
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
<TITLE>Alta de Ingresos - Movimientos</TITLE>

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
  
    //comprobacion de que haya algun valor superior a 0 en algun campo
    //si no hay valores o estan todos a 0 damos error
    var cantidad1=document.form1.lngCantidadContabilidad1.value;
    var cantidad2=document.form1.lngCantidadContabilidad2.value;
    var cantidad3=document.form1.lngCantidadContabilidad3.value;
    var cantidad4=document.form1.lngCantidadContabilidad4.value;

    if ((cantidad1 === '' || cantidad1==='0,00') &&
        (cantidad2 === '' || cantidad2==='0,00') &&
        (cantidad3 === '' || cantidad3==='0,00') &&
        (cantidad4 === '' || cantidad4==='0,00')){

        textoError=textoError+"Debe haber algun valor positivo en las entradas de la base imponible.\n";
        document.form1.lngCantidadContabilidad1.style.borderColor='#FF0000';
        document.form1.lngCantidadContabilidad2.style.borderColor='#FF0000';
        document.form1.lngCantidadContabilidad3.style.borderColor='#FF0000';
        document.form1.lngCantidadContabilidad4.style.borderColor='#FF0000';
        document.form1.lngCantidadContabilidad1.title ='Debe haber algun valor positivo';
        document.form1.lngCantidadContabilidad2.title ='Debe haber algun valor positivo';
        document.form1.lngCantidadContabilidad3.title ='Debe haber algun valor positivo';
        document.form1.lngCantidadContabilidad4.title ='Debe haber algun valor positivo';
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
      //como todos los datos son correctos, hago un calculo de los campos calculados
      SumasFactura();
      
      //y por último envio el formulario
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
        formateoCampoColor(document.form1.lngCantidadContabilidad1,'<?php echo $_GET['esAbono'];?>','#FF0000');
        formateoCampoColor(document.form1.lngCantidadContabilidad2,'<?php echo $_GET['esAbono'];?>','#FF0000');
        formateoCampoColor(document.form1.lngCantidadContabilidad3,'<?php echo $_GET['esAbono'];?>','#FF0000');
        formateoCampoColor(document.form1.lngCantidadContabilidad4,'<?php echo $_GET['esAbono'];?>','#FF0000');
        formateoCampoColor(document.form1.lngIvaContabilidad1,'<?php echo $_GET['esAbono'];?>','#FF0000');
        formateoCampoColor(document.form1.lngIvaContabilidad2,'<?php echo $_GET['esAbono'];?>','#FF0000');
        formateoCampoColor(document.form1.lngIvaContabilidad3,'<?php echo $_GET['esAbono'];?>','#FF0000');
        formateoCampoColor(document.form1.lngIvaContabilidad4,'<?php echo $_GET['esAbono'];?>','#FF0000');
        formateoCampoColor(document.form1.lngCantidadContabilidadTotal,'<?php echo $_GET['esAbono'];?>','#FF0000');
        formateoCampoColor(document.form1.lngIvaContabilidadTotal,'<?php echo $_GET['esAbono'];?>','#FF0000');
        formateoCampoColor(document.form1.ContabilidadTotal,'<?php echo $_GET['esAbono'];?>','#FF0000');
    }else{
        formateoCampoColor(document.form1.lngCantidadContabilidad1,'<?php echo $_GET['esAbono'];?>','#666666');
        formateoCampoColor(document.form1.lngCantidadContabilidad2,'<?php echo $_GET['esAbono'];?>','#666666');
        formateoCampoColor(document.form1.lngCantidadContabilidad3,'<?php echo $_GET['esAbono'];?>','#666666');
        formateoCampoColor(document.form1.lngCantidadContabilidad4,'<?php echo $_GET['esAbono'];?>','#666666');
        formateoCampoColor(document.form1.lngIvaContabilidad1,'<?php echo $_GET['esAbono'];?>','#666666');
        formateoCampoColor(document.form1.lngIvaContabilidad2,'<?php echo $_GET['esAbono'];?>','#666666');
        formateoCampoColor(document.form1.lngIvaContabilidad3,'<?php echo $_GET['esAbono'];?>','#666666');
        formateoCampoColor(document.form1.lngIvaContabilidad4,'<?php echo $_GET['esAbono'];?>','#666666');
        formateoCampoColor(document.form1.lngCantidadContabilidadTotal,'<?php echo $_GET['esAbono'];?>','#666666');
        formateoCampoColor(document.form1.lngIvaContabilidadTotal,'<?php echo $_GET['esAbono'];?>','#666666');
        formateoCampoColor(document.form1.ContabilidadTotal,'<?php echo $_GET['esAbono'];?>','#666666');
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
                  if(!isset($_GET['editar'])){
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
$tituloForm='MOVIMIENTOS<br/>ALTA DE INGRESOS';
$cabeceraNumero='020203';
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
    <form name="form1" method="post" action="../vista/ingresos_CFIVAV.php">
        
      <table width="640" border="0" class="zonaactiva">
        <tr> 
          <td class="subtitulo" colspan="11">&nbsp;Alta Movimientos - Ingresos</td>
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
              <input type="hidden" id="lngPeriodo" name="lngPeriodo" value="<?php echo $datos['lngPeriodo']; ?>"/>
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
                   value="<?php if(isset($datos)){echo $datos['datFecha'];}else {echo $fechaForm;}?>"
                   <?php if($editarAsiento==='SI') {?>
                   placeholder="<?php if(isset($datos)){echo $datos['datFecha'];}else {echo $fechaForm;}?>" 
                   onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" tabindex="1"
                   onKeyUp="this.value=formateafechaEntrada(this.value);" 
                   onfocus="onFocusInputText(this);<?php if(!isset($datos)){echo 'limpiaCampoFecha(this)';}?>"
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
              <label class="nombreCampo">Cliente</label>
              <?php
              //funcion general
              if($editarAsiento==='SI') {
                  autocomplete_cuentas_SubGrupo4('strCuentaCli',43);
              }
              ?>
              <input class="textbox1" type="text" id="strCuentaCli" name="strCuentaCli" tabindex="2" 
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
              <input type="hidden" id="okStrCuentaCli" name="okStrCuentaCli" value="<?php if($NoE==='nuevo'){echo 'NO';}else if($NoE==='edicion'){echo 'SI';} ?>" />
              </div>
          </td>
          <td></td>
          <td colspan="4">
              <div align="left">
              <label class="nombreCampo">Cuenta de Ingresos<font color="#F0F8FF">...............</font></label>
              <?php
              //funcion general
              if($editarAsiento==='SI') {
                  autocomplete_cuentas_SubGrupo4('strCuenta',7);
              }
              ?>
              <input class="textbox1" type="text" id="strCuenta" name="strCuenta" tabindex="3" 
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
              <input type="hidden" id="okStrCuenta" name="okStrCuenta" value="<?php if($NoE==='nuevo'){echo 'NO';}else if($NoE==='edicion'){echo 'SI';} ?>" />
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
        
        <tr><!-- Titulos -->
          <td colspan="2">
              <div align="left">
              <label class="nombreCampo">Base Imponible</label>
              </div>
          </td>
          <td colspan="3">
              <div align="right">
              <label class="nombreCampo">% IVA Aplicable</label>
              </div>
          </td>
          <td></td>
          <td colspan="2">
              <div align="left">
              <label class="nombreCampo">Realizar Cobro</label>
              </div>
          </td>
          <td></td>
          <td colspan="2">
              <div align="left">
              <label class="nombreCampo">Total Factura</label>
              </div>
          </td>
        </tr>
        
        <tr><!-- Esta fila se repite 4 veces: 1 -->
          <td colspan="2">
              <div align="left">
              <input class="textbox1" type="text" name="lngCantidadContabilidad1" maxlength="10" tabindex="5"
                     value="<?php if(isset($datos)){echo $datos['lngCantidadContabilidad1'];}else{echo '0,00';} ?>" 
                     style="text-align:right;font-weight:bold;" 
                     <?php if($editarAsiento==='SI') {?>
                     onkeypress="return solonumeros(event);"
                     onkeyUp="CalculaIva1(this.value,document.form1.lngPorciento1.value);SumasFactura();"
                     onblur="onBlurInputText(this);CalculaIva1(this.value,document.form1.lngPorciento1.value);formateaCantidad(this);SumasFactura();
                             formateaNegativoContabilidad(this,'<?php echo $_GET['esAbono'];?>');
                             formateaNegativoContabilidad(document.form1.lngIvaContabilidad1,'<?php echo $_GET['esAbono'];?>');
                             formateaNegativoContabilidad(document.form1.lngCantidadContabilidadTotal,'<?php echo $_GET['esAbono'];?>');
                             formateaNegativoContabilidad(document.form1.lngIvaContabilidadTotal,'<?php echo $_GET['esAbono'];?>');
                             formateaNegativoContabilidad(document.form1.ContabilidadTotal,'<?php echo $_GET['esAbono'];?>');"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);entradaCantidad(this,document.form1.lngCantidad1);selecciona_value(this);"
                     <?php }else{?>
                     readonly
                     <?php }?>
                      />
              <input type="hidden" name="lngCantidad1" value="<?php if(isset($datos)){echo $datos['lngCantidad1'];}else{echo '0.00';} ?>"/>
              </div>
          </td>
          <td colspan="3">
              <div align="right">
              <select name="lngPorciento1"
                      class="textbox1" style="text-align:right;font-weight:bold;width:50%;" tabindex="6"
                   <?php if($editarAsiento==='SI') {?>
                      onchange="CalculaIva1(document.form1.lngCantidad1.value,this.value);SumasFactura();
                                formateaNegativoContabilidad(document.form1.lngIvaContabilidad1,'<?php echo $_GET['esAbono'];?>');
                                formateaNegativoContabilidad(document.form1.lngCantidadContabilidadTotal,'<?php echo $_GET['esAbono'];?>');
                                formateaNegativoContabilidad(document.form1.lngIvaContabilidadTotal,'<?php echo $_GET['esAbono'];?>');
                                formateaNegativoContabilidad(document.form1.ContabilidadTotal,'<?php echo $_GET['esAbono'];?>');"
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
                  if(isset($datos)){ //existe IVA
                      if($datos['lngPorciento1']==0){
                          $selected0='selected';
                      }else if($datos['lngPorciento1']==4){
                          $selected4='selected';
                      }else if($datos['lngPorciento1']==10){
                          $selected10='selected';
                      }else if($datos['lngPorciento1']==21){
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
              <input class="textbox1" type="text" name="lngIvaContabilidad1" maxlength="4" readonly
                     style="text-align:right;font-weight:bold;"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"
                     value="<?php if(isset($datos)){echo $datos['lngIvaContabilidad1'];}else{echo '0,00';} ?>" />
              <input type="hidden" name="lngIva1" value="<?php echo $datos['lngIva1'];?>"/>
              </div>
          </td>
          <td></td>
          <td colspan="2"></td>
        </tr>
        
        <tr><!-- 2 -->
          <td colspan="2">
              <div align="left">
              <input class="textbox1" type="text" name="lngCantidadContabilidad2" maxlength="10" tabindex="7"
                     value="<?php if(isset($datos)){echo $datos['lngCantidadContabilidad2'];}else{echo '0,00';} ?>"
                     style="text-align:right;font-weight:bold;" 
                     <?php if($editarAsiento==='SI') {?>
                     onkeypress="return solonumeros(event);" 
                     onkeyUp="CalculaIva2(this.value,document.form1.lngPorciento2.value);SumasFactura();"
                     onblur="onBlurInputText(this);CalculaIva2(this.value,document.form1.lngPorciento2.value);formateaCantidad(this);SumasFactura();
                             formateaNegativoContabilidad(this,'<?php echo $_GET['esAbono'];?>');
                             formateaNegativoContabilidad(document.form1.lngIvaContabilidad2,'<?php echo $_GET['esAbono'];?>');
                             formateaNegativoContabilidad(document.form1.lngCantidadContabilidadTotal,'<?php echo $_GET['esAbono'];?>');
                             formateaNegativoContabilidad(document.form1.lngIvaContabilidadTotal,'<?php echo $_GET['esAbono'];?>');
                             formateaNegativoContabilidad(document.form1.ContabilidadTotal,'<?php echo $_GET['esAbono'];?>');"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);entradaCantidad(this,document.form1.lngCantidad2);selecciona_value(this);"
                     <?php }else{?>
                     readonly
                     <?php }?>
                      />
              <input type="hidden" name="lngCantidad2" value="<?php if(isset($datos)){echo $datos['lngCantidad2'];}else{echo '0.00';} ?>"/>
              </div>
          </td>
          <td colspan="3">
              <div align="right">
              <select name="lngPorciento2"
                      class="textbox1" style="text-align:right;font-weight:bold;width:50%;" tabindex="8"
                   <?php if($editarAsiento==='SI') {?>
                      onchange="CalculaIva2(document.form1.lngCantidad2.value,this.value);SumasFactura();
                                formateaNegativoContabilidad(document.form1.lngIvaContabilidad2,'<?php echo $_GET['esAbono'];?>');
                                formateaNegativoContabilidad(document.form1.lngCantidadContabilidadTotal,'<?php echo $_GET['esAbono'];?>');
                                formateaNegativoContabilidad(document.form1.lngIvaContabilidadTotal,'<?php echo $_GET['esAbono'];?>');
                                formateaNegativoContabilidad(document.form1.ContabilidadTotal,'<?php echo $_GET['esAbono'];?>');"
                      onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" 
                   <?php }else{?>
                      disabled="true"
                   <?php }?>
                   >
                  <?php
                  $selected0='';
                  $selected4='';
                  $selected10='';
                  $selected21='';
                  if(isset($datos)){ //existe IVA
                      if($datos['lngPorciento2']==0){
                          $selected0='selected';
                      }else if($datos['lngPorciento2']==4){
                          $selected4='selected';
                      }else if($datos['lngPorciento2']==10){
                          $selected10='selected';
                      }else if($datos['lngPorciento2']==21){
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
              <input class="textbox1" type="text" name="lngIvaContabilidad2" maxlength="4" readonly
                     style="text-align:right;font-weight:bold;"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"
                     value="<?php if(isset($datos)){echo $datos['lngIvaContabilidad2'];}else{echo '0,00';} ?>" />
              <input type="hidden" name="lngIva2" value="<?php echo $datos['lngIva2'];?>"/>
              </div>
          </td>
          <td></td>
          <td colspan="2"></td>
        </tr>
        
        <tr><!-- 3 -->
          <td colspan="2">
              <div align="left">
              <input class="textbox1" type="text" name="lngCantidadContabilidad3" maxlength="10" tabindex="9"
                     value="<?php if(isset($datos)){echo $datos['lngCantidadContabilidad3'];}else{echo '0,00';} ?>"
                     style="text-align:right;font-weight:bold;"
                     <?php if($editarAsiento==='SI') {?>
                     onkeypress="return solonumeros(event);"  
                     onkeyUp="CalculaIva3(this.value,document.form1.lngPorciento3.value);SumasFactura();"
                     onblur="onBlurInputText(this);CalculaIva3(this.value,document.form1.lngPorciento3.value);formateaCantidad(this);SumasFactura();
                             formateaNegativoContabilidad(this,'<?php echo $_GET['esAbono'];?>');
                             formateaNegativoContabilidad(document.form1.lngIvaContabilidad3,'<?php echo $_GET['esAbono'];?>');
                             formateaNegativoContabilidad(document.form1.lngCantidadContabilidadTotal,'<?php echo $_GET['esAbono'];?>');
                             formateaNegativoContabilidad(document.form1.lngIvaContabilidadTotal,'<?php echo $_GET['esAbono'];?>');
                             formateaNegativoContabilidad(document.form1.ContabilidadTotal,'<?php echo $_GET['esAbono'];?>');"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);entradaCantidad(this,document.form1.lngCantidad3);selecciona_value(this);"
                     <?php }else{?>
                     readonly
                     <?php }?>
                      />
              <input type="hidden" name="lngCantidad3" value="<?php if(isset($datos)){echo $datos['lngCantidad3'];}else{echo '0.00';} ?>"/>
              </div>
          </td>
          <td colspan="3">
              <div align="right">
              <select name="lngPorciento3"
                      class="textbox1" style="text-align:right;font-weight:bold;width:50%;" tabindex="10"
                   <?php if($editarAsiento==='SI') {?>
                      onchange="CalculaIva3(document.form1.lngCantidad3.value,this.value);SumasFactura();
                                formateaNegativoContabilidad(document.form1.lngIvaContabilidad3,'<?php echo $_GET['esAbono'];?>');
                                formateaNegativoContabilidad(document.form1.lngCantidadContabilidadTotal,'<?php echo $_GET['esAbono'];?>');
                                formateaNegativoContabilidad(document.form1.lngIvaContabilidadTotal,'<?php echo $_GET['esAbono'];?>');
                                formateaNegativoContabilidad(document.form1.ContabilidadTotal,'<?php echo $_GET['esAbono'];?>');"
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
                  if(isset($datos)){ //existe IVA
                      if($datos['lngPorciento3']==0){
                          $selected0='selected';
                      }else if($datos['lngPorciento3']==4){
                          $selected4='selected';
                      }else if($datos['lngPorciento3']==10){
                          $selected10='selected';
                      }else if($datos['lngPorciento3']==21){
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
              <input class="textbox1" type="text" name="lngIvaContabilidad3" maxlength="4" readonly
                     style="text-align:right;font-weight:bold;"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"
                     value="<?php if(isset($datos)){echo $datos['lngIvaContabilidad3'];}else{echo '0,00';} ?>" />
              <input type="hidden" name="lngIva3" value="<?php echo $datos['lngIva3'];?>"/>
              </div>
          </td>
          <td></td>
          <td colspan="2"></td>
        </tr>
        
        <tr><!-- 4 -->
          <td colspan="2">
              <div align="left">
              <input class="textbox1" type="text" name="lngCantidadContabilidad4" maxlength="10" tabindex="11"
                     value="<?php if(isset($datos)){echo $datos['lngCantidadContabilidad4'];}else{echo '0,00';} ?>"
                     style="text-align:right;font-weight:bold;"
                     <?php if($editarAsiento==='SI') {?>
                     onkeypress="return solonumeros(event);" 
                     onkeyUp="CalculaIva4(this.value,document.form1.lngPorciento4.value);SumasFactura();"
                     onblur="onBlurInputText(this);CalculaIva4(this.value,document.form1.lngPorciento4.value);formateaCantidad(this);SumasFactura();
                             formateaNegativoContabilidad(this,'<?php echo $_GET['esAbono'];?>');
                             formateaNegativoContabilidad(document.form1.lngIvaContabilidad4,'<?php echo $_GET['esAbono'];?>');
                             formateaNegativoContabilidad(document.form1.lngCantidadContabilidadTotal,'<?php echo $_GET['esAbono'];?>');
                             formateaNegativoContabilidad(document.form1.lngIvaContabilidadTotal,'<?php echo $_GET['esAbono'];?>');
                             formateaNegativoContabilidad(document.form1.ContabilidadTotal,'<?php echo $_GET['esAbono'];?>');"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);entradaCantidad(this,document.form1.lngCantidad4);selecciona_value(this);"
                     <?php }else{?>
                     readonly
                     <?php }?>
                      />
              <input type="hidden" name="lngCantidad4" value="<?php if(isset($datos)){echo $datos['lngCantidad4'];}else{echo '0.00';} ?>"/>
              </div>
          </td>
          <td colspan="3">
              <div align="right">
              <select name="lngPorciento4"
                      class="textbox1" style="text-align:right;font-weight:bold;width:50%;" tabindex="12"
                   <?php if($editarAsiento==='SI') {?>
                      onchange="CalculaIva4(document.form1.lngCantidad4.value,this.value);SumasFactura();
                                formateaNegativoContabilidad(document.form1.lngIvaContabilidad4,'<?php echo $_GET['esAbono'];?>');
                                formateaNegativoContabilidad(document.form1.lngCantidadContabilidadTotal,'<?php echo $_GET['esAbono'];?>');
                                formateaNegativoContabilidad(document.form1.lngIvaContabilidadTotal,'<?php echo $_GET['esAbono'];?>');
                                formateaNegativoContabilidad(document.form1.ContabilidadTotal,'<?php echo $_GET['esAbono'];?>');"
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
                  if(isset($datos)){ //existe IVA
                      if($datos['lngPorciento4']==0){
                          $selected0='selected';
                      }else if($datos['lngPorciento4']==4){
                          $selected4='selected';
                      }else if($datos['lngPorciento4']==10){
                          $selected10='selected';
                      }else if($datos['lngPorciento4']==21){
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
              <input class="textbox1" type="text" name="lngIvaContabilidad4" maxlength="4" readonly
                     style="text-align:right;font-weight:bold;"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"
                     value="<?php if(isset($datos)){echo $datos['lngIvaContabilidad4'];}else{echo '0,00';} ?>" />
              <input type="hidden" name="lngIva4" value="<?php echo $datos['lngIva4'];?>"/>
              </div>
          </td>
          <td></td>
          <td colspan="2"></td>
        </tr>
        
        
        <tr><!-- Linea de suma -->
          <td colspan="11"><hr/></td>
        </tr>

        <tr><!-- Sumas -->
          <td colspan="2">
              <div align="left">
              <input class="textbox1" type="text" name="lngCantidadContabilidadTotal" maxlength="10"
                     style="text-align:right;font-weight:bold;" readonly 
                     value="<?php if(isset($datos)){echo $datos['lngCantidadContabilidadTotal'];}else{echo '0,00';} ?>" />
              <input type="hidden" name="lngCantidadTotal" value="<?php echo $datos['lngCantidadTotal'];?>"/>
              </div>
          </td>
          <td colspan="3"></td>
          <td></td>
          <td colspan="2">
              <div align="left">
              <input class="textbox1" type="text" name="lngIvaContabilidadTotal" maxlength="4" readonly
                     style="text-align:right;font-weight:bold;"
                     value="<?php if(isset($datos)){echo $datos['lngIvaContabilidadTotal'];}else{echo '0,00';} ?>" />
              <input type="hidden" name="lngIvaTotal" value="<?php echo $datos['lngIvaTotal'];?>"/>
              </div>
          </td>
          <td></td>
          <td colspan="2">
              <div align="left">
              <input class="textbox1" type="text" name="ContabilidadTotal" maxlength="10"
                      style="text-align:right;font-weight:bold;" readonly 
                      value="<?php if(isset($datos)){echo $datos['ContabilidadTotal'];}else{echo '0,00';} ?>" />
              <input type="hidden" name="Total" value="<?php echo $datos['Total'];?>"/>
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
                     <?php if(!(isset($datos['optTipo'])) || $datos['optTipo']=='0'){echo 'checked';} ?> onClick="ActivaSelecBanco(this);" tabindex="13"
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
                <label class="nombreCampo">Cobrar Ingreso</label>
                </div>
            </td>
            <td>
                <div align="left">
                <input class="txtgeneral" type="radio" name="optTipo" value="1" 
                     <?php if($datos['optTipo']=='1'){echo 'checked';} ?> onClick="ActivaSelecBanco(this);" tabindex="14"
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
                <input class="textbox1" type="text" id="strCuentaBancos" name="strCuentaBancos" tabindex="15" 
                   <?php if(!(isset($datos['optTipo'])) || $datos['optTipo']=='0'){echo 'disabled';} ?>
                   value="<?php echo htmlentities($datos['strCuentaBancos'],ENT_QUOTES,'UTF-8');?>"     
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
        <input type="button" class="button" name="cmdAlta" id="cmdAlta" value = "Grabar" onclick="javascript:validar();" tabindex="16" /> 
        <input class="buttonAzul" type="button" value="Volver" onclick="volver();" />
        <?php if($editarAsiento==='SI') {?>
        <?php if(isset($_GET['editar']) && $_GET['editar']==='SI'){echo '<input type="button" class="buttonAzul" value="Eliminar" name="cmdBorrar" onclick="javascript:borrarAsiento('.$_GET['Asiento'].');" />';} ?>  
        <input type="Reset" class="button" value="<?php if(isset($_GET['editar']) && $_GET['editar']==='SI'){echo 'Restaurar Original';}else{echo 'Vaciar Datos';} ?>" name="cmdReset" tabindex="10" />
        <?php if(isset($_GET['editar']) && $_GET['editar']==='SI'){echo '<input type="button" class="buttonAzul"  value="Ver Est. Asiento" name="cmdVerAsiento" onclick="javascript:verAsiento('.$_GET['Asiento'].');" />';} ?>  
        <input type="hidden"  name="cmdAlta" <?php if(isset($_GET['editar']) && $_GET['editar']==='SI'){echo 'value="Editar"';}else{echo 'value="Alta"';} ?>  />
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
}//fin del html_pagina

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
                if($datos['optTipo'] === 1){
                    echo "ActivaSelecBanco(document.getElementById('pantalla'));";
                }
                
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
              ?>"
      class="api jquery-mobile archive category category-widgets category-2 listing single-author"> 

<div data-role="page" id="ingresos_CFIVAV">
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
  
    //comprobacion de que haya algun valor superior a 0 en algun campo
    //si no hay valores o estan todos a 0 damos error
    var cantidad1=document.form1.lngCantidadContabilidad1.value;
    var cantidad2=document.form1.lngCantidadContabilidad2.value;
    var cantidad3=document.form1.lngCantidadContabilidad3.value;
    var cantidad4=document.form1.lngCantidadContabilidad4.value;

    if ((cantidad1 === '' || cantidad1==='0,00') &&
        (cantidad2 === '' || cantidad2==='0,00') &&
        (cantidad3 === '' || cantidad3==='0,00') &&
        (cantidad4 === '' || cantidad4==='0,00')){

        textoError=textoError+"Debe haber algun valor positivo en las entradas de la base imponible.\n";
        document.form1.lngCantidadContabilidad1.style.borderColor='#FF0000';
        document.form1.lngCantidadContabilidad2.style.borderColor='#FF0000';
        document.form1.lngCantidadContabilidad3.style.borderColor='#FF0000';
        document.form1.lngCantidadContabilidad4.style.borderColor='#FF0000';
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
      //como todos los datos son correctos, hago un calculo de los campos calculados
      SumasFactura();
      
      //y por último envio el formulario
      document.getElementById("cmdAlta").value = "Enviando...";
      document.getElementById("cmdAlta").disabled = true;
      document.form1.submit();
  }else{
      return false;
  }  
}

function ActivaSelecBanco(objeto){
    if(objeto.value==0){
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
        formateoCampoColor(document.form1.lngCantidadContabilidad1,'<?php echo $_GET['esAbono'];?>','#FF0000');
        formateoCampoColor(document.form1.lngCantidadContabilidad2,'<?php echo $_GET['esAbono'];?>','#FF0000');
        formateoCampoColor(document.form1.lngCantidadContabilidad3,'<?php echo $_GET['esAbono'];?>','#FF0000');
        formateoCampoColor(document.form1.lngCantidadContabilidad4,'<?php echo $_GET['esAbono'];?>','#FF0000');
        formateoCampoColor(document.form1.lngIvaContabilidad1,'<?php echo $_GET['esAbono'];?>','#FF0000');
        formateoCampoColor(document.form1.lngIvaContabilidad2,'<?php echo $_GET['esAbono'];?>','#FF0000');
        formateoCampoColor(document.form1.lngIvaContabilidad3,'<?php echo $_GET['esAbono'];?>','#FF0000');
        formateoCampoColor(document.form1.lngIvaContabilidad4,'<?php echo $_GET['esAbono'];?>','#FF0000');
        formateoCampoColor(document.form1.lngCantidadContabilidadTotal,'<?php echo $_GET['esAbono'];?>','#FF0000');
        formateoCampoColor(document.form1.lngIvaContabilidadTotal,'<?php echo $_GET['esAbono'];?>','#FF0000');
        formateoCampoColor(document.form1.ContabilidadTotal,'<?php echo $_GET['esAbono'];?>','#FF0000');
    }else{
        formateoCampoColor(document.form1.lngCantidadContabilidad1,'<?php echo $_GET['esAbono'];?>','#666666');
        formateoCampoColor(document.form1.lngCantidadContabilidad2,'<?php echo $_GET['esAbono'];?>','#666666');
        formateoCampoColor(document.form1.lngCantidadContabilidad3,'<?php echo $_GET['esAbono'];?>','#666666');
        formateoCampoColor(document.form1.lngCantidadContabilidad4,'<?php echo $_GET['esAbono'];?>','#666666');
        formateoCampoColor(document.form1.lngIvaContabilidad1,'<?php echo $_GET['esAbono'];?>','#666666');
        formateoCampoColor(document.form1.lngIvaContabilidad2,'<?php echo $_GET['esAbono'];?>','#666666');
        formateoCampoColor(document.form1.lngIvaContabilidad3,'<?php echo $_GET['esAbono'];?>','#666666');
        formateoCampoColor(document.form1.lngIvaContabilidad4,'<?php echo $_GET['esAbono'];?>','#666666');
        formateoCampoColor(document.form1.lngCantidadContabilidadTotal,'<?php echo $_GET['esAbono'];?>','#666666');
        formateoCampoColor(document.form1.lngIvaContabilidadTotal,'<?php echo $_GET['esAbono'];?>','#666666');
        formateoCampoColor(document.form1.ContabilidadTotal,'<?php echo $_GET['esAbono'];?>','#666666');
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
        <form action="../vista/ingresos_CFIVAV.php" name="form1" method="POST" data-ajax="false">
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
                          <label class="nombreCampo">Cliente</label>
                          <?php
                            //funcion general
                            if($editarAsiento==='SI') {
                                autocomplete_cuentas_SubGrupo4('strCuentaCli',43);
                            }
                          ?>
                            <input type="text" id="strCuentaCli" name="strCuentaCli" tabindex="2" 
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
                            <?php
                            //funcion general
                            if($editarAsiento==='SI') {
                                autocomplete_cuentas_SubGrupo4('strCuenta',7);
                            }
                            ?>
                            <label class="nombreCampo">Cuenta de Ingresos</label>
                            <input type="text" id="strCuenta" name="strCuenta" tabindex="3" 
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
                </tbody>
            </table>
            <table border="0" style="width: 100%;">
                <tbody>
                    <tr><!-- Titulos -->
                        <td style="width: 35%;"><label>Base Imponible</label></td>
                        <td style="width: 30%;"><label>% IVA</label></td>
                        <td style="width: 35%;"><label>IVA Repercutido</label></td>
                    </tr>
                    <tr><!-- Esta fila se repite 4 veces: 1 -->
                      <td>
                          <div align="left">
                            <input type="text" name="lngCantidadContabilidad1" maxlength="10" tabindex="5"
                                   value="<?php if(isset($datos['lngCantidadContabilidad1'])){echo $datos['lngCantidadContabilidad1'];}else{echo '0,00';} ?>" 
                                   style="text-align:right;font-weight:bold;" 
                                   <?php if($editarAsiento==='SI') {?>
                                   onkeyUp="CalculaIva1(this.value,document.form1.lngPorciento1.value);SumasFactura();"
                                   onblur="solonumerosM(this);CalculaIva1(this.value,document.form1.lngPorciento1.value);formateaCantidad(this);SumasFactura();
                                           formateaNegativoContabilidad(this,'<?php echo $_GET['esAbono'];?>');
                                           formateaNegativoContabilidad(document.form1.lngIvaContabilidad1,'<?php echo $_GET['esAbono'];?>');
                                           formateaNegativoContabilidad(document.form1.lngCantidadContabilidadTotal,'<?php echo $_GET['esAbono'];?>');
                                           formateaNegativoContabilidad(document.form1.lngIvaContabilidadTotal,'<?php echo $_GET['esAbono'];?>');
                                           formateaNegativoContabilidad(document.form1.ContabilidadTotal,'<?php echo $_GET['esAbono'];?>');"
                                   onfocus="onFocusInputTextM(this);entradaCantidad(this,document.form1.lngCantidad1);selecciona_value(this);"
                                   <?php }else{?>
                                   readonly
                                   <?php }?>
                                    />
                            <input type="hidden" name="lngCantidad1" value="<?php if(isset($datos['lngCantidad1'])){echo $datos['lngCantidad1'];}else{echo '0.00';} ?>"/>
                          </div>
                      </td>
                      <td>
                          <div align="left">
                            <select name="lngPorciento1" style="text-align:right;font-weight:bold;width:50%;" tabindex="6"
                                 <?php if($editarAsiento==='SI') {?>
                                    onchange="CalculaIva1(document.form1.lngCantidad1.value,this.value);SumasFactura();
                                              formateaNegativoContabilidad(document.form1.lngIvaContabilidad1,'<?php echo $_GET['esAbono'];?>');
                                              formateaNegativoContabilidad(document.form1.lngCantidadContabilidadTotal,'<?php echo $_GET['esAbono'];?>');
                                              formateaNegativoContabilidad(document.form1.lngIvaContabilidadTotal,'<?php echo $_GET['esAbono'];?>');
                                              formateaNegativoContabilidad(document.form1.ContabilidadTotal,'<?php echo $_GET['esAbono'];?>');"
                                 <?php }else{?>
                                    disabled="true"
                                 <?php }?>
                                    data-native-menu="false" data-theme='a'>
                                <?php
                                //preparo el listado del select
                                $selected0='';
                                $selected4='';
                                $selected10='';
                                $selected21='';
                                if(isset($datos['lngPorciento1'])){ //existe IVA
                                    if($datos['lngPorciento1']==0){
                                        $selected0='selected';
                                    }else if($datos['lngPorciento1']==4){
                                        $selected4='selected';
                                    }else if($datos['lngPorciento1']==10){
                                        $selected10='selected';
                                    }else if($datos['lngPorciento1']==21){
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
                      <td>
                          <div align="left">
                            <input type="text" name="lngIvaContabilidad1" maxlength="4" readonly
                                   style="text-align:right;font-weight:bold;"
                                   value="<?php if(isset($datos['lngIvaContabilidad1'])){echo $datos['lngIvaContabilidad1'];}else{echo '0,00';} ?>" />
                            <input type="hidden" name="lngIva1" value="<?php echo $datos['lngIva1'];?>"/>
                          </div>
                      </td>
                    </tr>
                    <tr><!-- Fila 2 -->
                      <td>
                          <div align="left">
                            <input type="text" name="lngCantidadContabilidad2" maxlength="10" tabindex="5"
                                   value="<?php if(isset($datos['lngCantidadContabilidad2'])){echo $datos['lngCantidadContabilidad2'];}else{echo '0,00';} ?>" 
                                   style="text-align:right;font-weight:bold;" 
                                   <?php if($editarAsiento==='SI') {?>
                                   onkeyUp="CalculaIva2(this.value,document.form1.lngPorciento2.value);SumasFactura();"
                                   onblur="solonumerosM(this);CalculaIva2(this.value,document.form1.lngPorciento2.value);formateaCantidad(this);SumasFactura();
                                           formateaNegativoContabilidad(this,'<?php echo $_GET['esAbono'];?>');
                                           formateaNegativoContabilidad(document.form1.lngIvaContabilidad2,'<?php echo $_GET['esAbono'];?>');
                                           formateaNegativoContabilidad(document.form1.lngCantidadContabilidadTotal,'<?php echo $_GET['esAbono'];?>');
                                           formateaNegativoContabilidad(document.form1.lngIvaContabilidadTotal,'<?php echo $_GET['esAbono'];?>');
                                           formateaNegativoContabilidad(document.form1.ContabilidadTotal,'<?php echo $_GET['esAbono'];?>');"
                                   onfocus="onFocusInputTextM(this);entradaCantidad(this,document.form1.lngCantidad2);selecciona_value(this);"
                                   <?php }else{?>
                                   readonly
                                   <?php }?>
                                    />
                            <input type="hidden" name="lngCantidad2" value="<?php if(isset($datos['lngCantidad2'])){echo $datos['lngCantidad2'];}else{echo '0.00';} ?>"/>
                          </div>
                      </td>
                      <td>
                          <div align="left">
                            <select name="lngPorciento2" style="text-align:right;font-weight:bold;width:50%;" tabindex="6"
                                 <?php if($editarAsiento==='SI') {?>
                                    onchange="CalculaIva2(document.form1.lngCantidad2.value,this.value);SumasFactura();
                                              formateaNegativoContabilidad(document.form1.lngIvaContabilidad2,'<?php echo $_GET['esAbono'];?>');
                                              formateaNegativoContabilidad(document.form1.lngCantidadContabilidadTotal,'<?php echo $_GET['esAbono'];?>');
                                              formateaNegativoContabilidad(document.form1.lngIvaContabilidadTotal,'<?php echo $_GET['esAbono'];?>');
                                              formateaNegativoContabilidad(document.form1.ContabilidadTotal,'<?php echo $_GET['esAbono'];?>');"
                                 <?php }else{?>
                                    disabled="true"
                                 <?php }?>
                                    data-native-menu="false" data-theme='a'>
                                <?php
                                //preparo el listado del select
                                $selected0='';
                                $selected4='';
                                $selected10='';
                                $selected21='';
                                if(isset($datos['lngPorciento2'])){ //existe IVA
                                    if($datos['lngPorciento2']==0){
                                        $selected0='selected';
                                    }else if($datos['lngPorciento2']==4){
                                        $selected4='selected';
                                    }else if($datos['lngPorciento2']==10){
                                        $selected10='selected';
                                    }else if($datos['lngPorciento2']==21){
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
                      <td>
                          <div align="left">
                            <input type="text" name="lngIvaContabilidad2" maxlength="4" readonly
                                   style="text-align:right;font-weight:bold;"
                                   value="<?php if(isset($datos['lngIvaContabilidad2'])){echo $datos['lngIvaContabilidad2'];}else{echo '0,00';} ?>" />
                            <input type="hidden" name="lngIva2" value="<?php echo $datos['lngIva2'];?>"/>
                          </div>
                      </td>
                    </tr>
                    <tr><!-- Fila 3 -->
                      <td>
                          <div align="left">
                            <input type="text" name="lngCantidadContabilidad3" maxlength="10" tabindex="5"
                                   value="<?php if(isset($datos['lngCantidadContabilidad3'])){echo $datos['lngCantidadContabilidad3'];}else{echo '0,00';} ?>" 
                                   style="text-align:right;font-weight:bold;" 
                                   <?php if($editarAsiento==='SI') {?>
                                   onkeyUp="CalculaIva3(this.value,document.form1.lngPorciento3.value);SumasFactura();"
                                   onblur="solonumerosM(this);CalculaIva3(this.value,document.form1.lngPorciento3.value);formateaCantidad(this);SumasFactura();
                                           formateaNegativoContabilidad(this,'<?php echo $_GET['esAbono'];?>');
                                           formateaNegativoContabilidad(document.form1.lngIvaContabilidad3,'<?php echo $_GET['esAbono'];?>');
                                           formateaNegativoContabilidad(document.form1.lngCantidadContabilidadTotal,'<?php echo $_GET['esAbono'];?>');
                                           formateaNegativoContabilidad(document.form1.lngIvaContabilidadTotal,'<?php echo $_GET['esAbono'];?>');
                                           formateaNegativoContabilidad(document.form1.ContabilidadTotal,'<?php echo $_GET['esAbono'];?>');"
                                   onfocus="onFocusInputTextM(this);entradaCantidad(this,document.form1.lngCantidad3);selecciona_value(this);"
                                   <?php }else{?>
                                   readonly
                                   <?php }?>
                                    />
                            <input type="hidden" name="lngCantidad3" value="<?php if(isset($datos['lngCantidad3'])){echo $datos['lngCantidad3'];}else{echo '0.00';} ?>"/>
                          </div>
                      </td>
                      <td>
                          <div align="left">
                            <select name="lngPorciento3" style="text-align:right;font-weight:bold;width:50%;" tabindex="6"
                                 <?php if($editarAsiento==='SI') {?>
                                    onchange="CalculaIva3(document.form1.lngCantidad3.value,this.value);SumasFactura();
                                              formateaNegativoContabilidad(document.form1.lngIvaContabilidad3,'<?php echo $_GET['esAbono'];?>');
                                              formateaNegativoContabilidad(document.form1.lngCantidadContabilidadTotal,'<?php echo $_GET['esAbono'];?>');
                                              formateaNegativoContabilidad(document.form1.lngIvaContabilidadTotal,'<?php echo $_GET['esAbono'];?>');
                                              formateaNegativoContabilidad(document.form1.ContabilidadTotal,'<?php echo $_GET['esAbono'];?>');"
                                 <?php }else{?>
                                    disabled="true"
                                 <?php }?>
                                    data-native-menu="false" data-theme='a'>
                                <?php
                                //preparo el listado del select
                                $selected0='';
                                $selected4='';
                                $selected10='';
                                $selected21='';
                                if(isset($datos['lngPorciento3'])){ //existe IVA
                                    if($datos['lngPorciento3']==0){
                                        $selected0='selected';
                                    }else if($datos['lngPorciento3']==4){
                                        $selected4='selected';
                                    }else if($datos['lngPorciento3']==10){
                                        $selected10='selected';
                                    }else if($datos['lngPorciento3']==21){
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
                      <td>
                          <div align="left">
                            <input type="text" name="lngIvaContabilidad3" maxlength="4" readonly
                                   style="text-align:right;font-weight:bold;"
                                   value="<?php if(isset($datos['lngIvaContabilidad3'])){echo $datos['lngIvaContabilidad3'];}else{echo '0,00';} ?>" />
                            <input type="hidden" name="lngIva3" value="<?php echo $datos['lngIva3'];?>"/>
                          </div>
                      </td>
                    </tr>
                    <tr><!-- Fila 4 -->
                      <td>
                          <div align="left">
                            <input type="text" name="lngCantidadContabilidad4" maxlength="10" tabindex="5"
                                   value="<?php if(isset($datos['lngCantidadContabilidad4'])){echo $datos['lngCantidadContabilidad4'];}else{echo '0,00';} ?>" 
                                   style="text-align:right;font-weight:bold;" 
                                   <?php if($editarAsiento==='SI') {?>
                                   onkeyUp="CalculaIva4(this.value,document.form1.lngPorciento4.value);SumasFactura();"
                                   onblur="solonumerosM(this);CalculaIva4(this.value,document.form1.lngPorciento4.value);formateaCantidad(this);SumasFactura();
                                           formateaNegativoContabilidad(this,'<?php echo $_GET['esAbono'];?>');
                                           formateaNegativoContabilidad(document.form1.lngIvaContabilidad4,'<?php echo $_GET['esAbono'];?>');
                                           formateaNegativoContabilidad(document.form1.lngCantidadContabilidadTotal,'<?php echo $_GET['esAbono'];?>');
                                           formateaNegativoContabilidad(document.form1.lngIvaContabilidadTotal,'<?php echo $_GET['esAbono'];?>');
                                           formateaNegativoContabilidad(document.form1.ContabilidadTotal,'<?php echo $_GET['esAbono'];?>');"
                                   onfocus="onFocusInputTextM(this);entradaCantidad(this,document.form1.lngCantidad4);selecciona_value(this);"
                                   <?php }else{?>
                                   readonly
                                   <?php }?>
                                    />
                            <input type="hidden" name="lngCantidad4" value="<?php if(isset($datos['lngCantidad4'])){echo $datos['lngCantidad4'];}else{echo '0.00';} ?>"/>
                          </div>
                      </td>
                      <td>
                          <div align="left">
                            <select name="lngPorciento4" style="text-align:right;font-weight:bold;width:50%;" tabindex="6"
                                 <?php if($editarAsiento==='SI') {?>
                                    onchange="CalculaIva4(document.form1.lngCantidad4.value,this.value);SumasFactura();
                                              formateaNegativoContabilidad(document.form1.lngIvaContabilidad4,'<?php echo $_GET['esAbono'];?>');
                                              formateaNegativoContabilidad(document.form1.lngCantidadContabilidadTotal,'<?php echo $_GET['esAbono'];?>');
                                              formateaNegativoContabilidad(document.form1.lngIvaContabilidadTotal,'<?php echo $_GET['esAbono'];?>');
                                              formateaNegativoContabilidad(document.form1.ContabilidadTotal,'<?php echo $_GET['esAbono'];?>');"
                                 <?php }else{?>
                                    disabled="true"
                                 <?php }?>
                                    data-native-menu="false" data-theme='a'>
                                <?php
                                //preparo el listado del select
                                $selected0='';
                                $selected4='';
                                $selected10='';
                                $selected21='';
                                if(isset($datos['lngPorciento4'])){ //existe IVA
                                    if($datos['lngPorciento4']==0){
                                        $selected0='selected';
                                    }else if($datos['lngPorciento4']==4){
                                        $selected4='selected';
                                    }else if($datos['lngPorciento4']==10){
                                        $selected10='selected';
                                    }else if($datos['lngPorciento4']==21){
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
                      <td>
                          <div align="left">
                            <input type="text" name="lngIvaContabilidad4" maxlength="4" readonly
                                   style="text-align:right;font-weight:bold;"
                                   value="<?php if(isset($datos['lngIvaContabilidad4'])){echo $datos['lngIvaContabilidad4'];}else{echo '0,00';} ?>" />
                            <input type="hidden" name="lngIva4" value="<?php echo $datos['lngIva4'];?>"/>
                          </div>
                      </td>
                    </tr>
                    <tr>
                        <td colspan="3"><hr/></td>
                    </tr>
                    <tr><!-- Sumas  -->
                        <td>
                            <div align="left">
                            <input type="text" name="lngCantidadContabilidadTotal" maxlength="10"
                                   style="text-align:right;font-weight:bold;" readonly 
                                   value="<?php if(isset($datos['lngCantidadContabilidadTotal'])){echo $datos['lngCantidadContabilidadTotal'];}else{echo '0,00';} ?>" />
                            <input type="hidden" name="lngCantidadTotal" value="<?php echo $datos['lngCantidadTotal'];?>"/>
                            </div>
                        </td>
                        <td></td>
                        <td>
                            <div align="left">
                            <input type="text" name="lngIvaContabilidadTotal" maxlength="4" readonly
                                   style="text-align:right;font-weight:bold;"
                                   value="<?php if(isset($datos['lngIvaContabilidadTotal'])){echo $datos['lngIvaContabilidadTotal'];}else{echo '0,00';} ?>" />
                            <input type="hidden" name="lngIvaTotal" value="<?php echo $datos['lngIvaTotal'];?>"/>
                            </div>
                        </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                          <div align="left">
                            <label>Total Factura</label>
                            <input type="text" name="ContabilidadTotal" maxlength="10"
                                    style="text-align:right;font-weight:bold;" readonly 
                                    value="<?php if(isset($datos['ContabilidadTotal'])){echo $datos['ContabilidadTotal'];}else{echo '0,00';} ?>" />
                            <input type="hidden" name="Total" value="<?php echo $datos['Total'];?>"/>
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
                </tbody>
            </table>
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
    
</body>  
</html>
<?php    
}//fin del html_paginaMovil
?>