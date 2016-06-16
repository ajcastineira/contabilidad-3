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


//NUMERO DE MOVIMIENTOS QUE PODEMOS INSERTAR (APARECE EN PANTALLA)
$numMovimientos=5;
////POR DEFECTO EL NUMERO DE ASIENTO ES 0 (QUE ES ASIENTO NUEVO POR LO QUE SE INSERTA)
//$Asiento=0;

//codigo principal
//comprobamos si se ha submitido el formulario y que el cliente existe
if(isset($_POST['cmdAlta']) && $_POST['cmdAlta']=='Aceptar'){
    //guardamos la informacion en la BBDD
    
    //guardo en un array los movimientos de este asiento
    $movimientosAsiento='';
    for($i=1;$i<=$numMovimientos;$i++){
        //comprobamos que no este vacio el movimiento (por el campo strCuentaDEBE o HABER
        if($_POST['strCuentaDEBE'.$i]<>''){
            //DEBE
            $movimientosAsiento[]=array("IdMovimiento"=>$_POST['idMovDEBE'.$i],
                                        "Cuenta"=>$_POST['strCuentaDEBE'.$i],
                                        "Concepto"=>$_POST['strConceptoDEBE'.$i],
                                        "Cantidad"=>$_POST['lngCuentaDEBE'.$i],
                                        "DoH"=>'D'
            );
        }    
        if($_POST['strCuentaHABER'.$i]<>''){
            //HABER
            $movimientosAsiento[]=array("IdMovimiento"=>$_POST['idMovHABER'.$i],
                                        "Cuenta"=>$_POST['strCuentaHABER'.$i],
                                        "Concepto"=>$_POST['strConceptoHABER'.$i],
                                        "Cantidad"=>$_POST['lngCuentaHABER'.$i],
                                        "DoH"=>'H'
            );
        }
    }
    
    if(isset($_POST['asiento'])&& $_POST['asiento']==0){
        //asiento nuevo
        //insercion en la tabla 'tbmovimientos'
        logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " ||||Operaciones->Mis Movimientos|| Ha pulsado 'Aceptar'");


        $varRes = $clsCNContabilidad->AltaIngresosGastos($_SESSION["idEmp"],$movimientosAsiento,$_POST["datFecha"],$_POST["lngPeriodo"], $_POST["lngEjercicio"], $_SESSION["strUsuario"]);   

    }else{
        //edicion de asiento
        //edicion en la tabla 'tbmovimientos'
        logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " ||||Operaciones->Modificar Asiento|| Ha pulsado 'Aceptar'");
        
        //extraemos los datos de este asiento original
        $datosDebeAsiento=$clsCNContabilidad->leeAsiento($_POST['asiento'],'D');
        $datosHaberAsiento=$clsCNContabilidad->leeAsiento($_POST['asiento'],'H');
        
        $datosAsientoOriginal='';
        for($i=1;$i<=count($datosDebeAsiento);$i++){
            $datosAsientoOriginal[]=array(
                                        "IdMovimiento"=>$datosDebeAsiento[$i]["IdMovimiento"],
                                        "asiento"=>$datosDebeAsiento[$i]["asiento"],
                                        "cuenta"=>$datosDebeAsiento[$i]["cuenta"],
                                        "periodo"=>$datosDebeAsiento[$i]["periodo"],
                                        "ejercicio"=>$datosDebeAsiento[$i]["ejercicio"],
                                        "orden"=>$datosDebeAsiento[$i]["orden"],
                                        "concepto"=>$datosDebeAsiento[$i]["concepto"],
                                        "cantidad"=>$datosDebeAsiento[$i]["cantidad"],
                                        "DoH"=>"D"
                                        );
        }
        for($i=1;$i<=count($datosHaberAsiento);$i++){
            $datosAsientoOriginal[]=array(
                                        "IdMovimiento"=>$datosHaberAsiento[$i]["IdMovimiento"],
                                        "asiento"=>$datosDebeAsiento[$i]["asiento"],
                                        "cuenta"=>$datosHaberAsiento[$i]["cuenta"],
                                        "periodo"=>$datosHaberAsiento[$i]["periodo"],
                                        "ejercicio"=>$datosHaberAsiento[$i]["ejercicio"],
                                        "orden"=>$datosHaberAsiento[$i]["orden"],
                                        "concepto"=>$datosHaberAsiento[$i]["concepto"],
                                        "cantidad"=>$datosHaberAsiento[$i]["cantidad"],
                                        "DoH"=>"H"
                                        );
        }
        
        
        $varRes = $clsCNContabilidad->EditarIngresosGastos($_POST['asiento'],$datosAsientoOriginal, $_SESSION["idEmp"],$movimientosAsiento,$_POST["datFecha"],$_POST["lngPeriodo"], $_POST["lngEjercicio"], $_SESSION["strUsuario"]);   
        
    }

    //salida final
    if($varRes<>1){
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/error.php?id='.$varRes.'">';
    }else{
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/gastos_exito.php?op=2">';
    }
    
}else{//comienzo del else principal
               
    $datosUsuario=$clsCNUsu->DatosUsuario($_SESSION['usuario']);
               
    //numero de asiento a editar 
    if(isset($_GET['Asiento'])){
        logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " ||||Operaciones->Modificar Asiento||");
        $Asiento=$_GET['Asiento'];
    }else{
        logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " ||||Operaciones->Mis Movimientos||");
        $Asiento=0;
    }
    //compruebo si se puede o no editar (comprobacion de la pagina anterior)   
    
    //extraemos los datos de este asiento
    $datosDebeAsiento=$clsCNContabilidad->leeAsiento($Asiento,'D');
    $datosHaberAsiento=$clsCNContabilidad->leeAsiento($Asiento,'H');
    $datosFechaAsiento=$clsCNContabilidad->leeAsientoFecha($Asiento);
//    echo $Asiento.'<br/>';
//    print_r($datosDebeAsiento);die;
    
    //calculo las sumas del debe y haber
    $sumaDEBE=0;
    for($i=1;$i <= count($datosDebeAsiento);$i++){
        $sumaDEBE=$sumaDEBE+$datosDebeAsiento[$i]['cantidad'];
    }
    $sumaHABER=0;
    for($i=1;$i <= count($datosHaberAsiento);$i++){
        $sumaHABER=$sumaHABER+$datosHaberAsiento[$i]['cantidad'];
    }
    
    //comprobamos si se puede editar o no este asiento (buscamos 
    $editar='SI'; //por defecto si
    //buscamos si hay cuenta 4770 o 4720 (IVA), si es asi comprobamos que el campo Activo este a 1
    //sino no dejamos editar
    //elresto de cuentas solo NO edita si Activo=3
    //primero a $datosDebeAsiento
    for($i=1;$i <= count($datosDebeAsiento);$i++){
        $cuenta=substr($datosDebeAsiento[$i]['cuenta'],0,4);
        if($cuenta=='4720' || $cuenta=='4770'){
            if($datosDebeAsiento[$i]['Activo']==2 || $datosDebeAsiento[$i]['Activo']==3){
                $editar='NO';
            }
        }else{
            if($datosDebeAsiento[$i]['Activo']==3){
                $editar='NO';
            }
        }
    }
    
    //despues a $datosHaberAsiento
    for($i=1;$i <= count($datosHaberAsiento);$i++){
        $cuenta=substr($datosHaberAsiento[$i]['cuenta'],0,4);
        if($cuenta=='4720' || $cuenta=='4770'){
            if($datosHaberAsiento[$i]['Activo']==2 || $datosHaberAsiento[$i]['Activo']==3){
                $editar='NO';
            }
        }else{
            if($datosHaberAsiento[$i]['Activo']==3){
                $editar='NO';
            }
        }
    }
    
    
    //aqui dirijo a la presentacion en PC o Movil (APP)
    if($_SESSION['navegacion']==='movil'){
        html_paginaMovil($datosUsuario,$datosFechaAsiento,$datosDebeAsiento,$datosHaberAsiento,$editar,$numMovimientos,$sumaDEBE,$sumaHABER,$Asiento);
    }else{
        html_pagina($datosUsuario,$datosFechaAsiento,$datosDebeAsiento,$datosHaberAsiento,$editar,$numMovimientos,$sumaDEBE,$sumaHABER,$Asiento);
    }
}


function scripts($numMovimientos){
?>
<script language="JavaScript">

function validar2()
{
  esValido=true;
  textoError='';
  
  //comprobacion del campo 'strEmpresa'
  if (document.form1.strEmpresa.value == ''){ 
    textoError=textoError+"Es necesario introducir el nombre de la empresa.\n";
    document.form1.strEmpresa.style.borderColor='#FF0000';
    document.form1.strEmpresa.title ='Se debe introducir el nombre de la empresa';
    esValido=false;
  }
  //comprobacion del campo 'strPeriodo'
  if (document.form1.strPeriodo.value == ''){ 
    textoError=textoError+"Es necesario introducir el periodo.\n";
    document.form1.strPeriodo.style.borderColor='#FF0000';
    document.form1.strPeriodo.title ='Se debe introducir el periodo';
    esValido=false;
  }
  //comprobacion del campo 'lngEjercicio'
  if (document.form1.lngEjercicio.value == ''){ 
    textoError=textoError+"Es necesario introducir el ejercicio.\n";
    document.form1.lngEjercicio.style.borderColor='#FF0000';
    document.form1.lngEjercicio.title ='Se deben introducir el ejercicio';
    esValido=false;
  }
  //comprobacion del campo 'datFecha'
  if (document.form1.datFecha.value == ''){ 
    textoError=textoError+"Es necesario introducir la fecha del apunte.\n";
    document.form1.datFecha.style.borderColor='#FF0000';
    document.form1.datFecha.title ='Se debe introducir la fecha del apunte';
    esValido=false;
  }
  //comprobacion que en los campos debe si hay valores en lngCuentaDEBE distinto de 0
  //comprobar que haya datos numericos y comprobar que en el campo strCuentaDEBE haya asignada una cuenta
  //y al campo strConceptoDEBE tenga texto escrito
  for(i=1;i<=<?php echo $numMovimientos; ?>;i++){
      var objeto=document.getElementById('lngCuentaDEBE['+i+']');
      if(objeto.value != ''){//vemos que no esta vacio
          //ahora compruebo que sea numerico
          if(objeto.value==''){
            textoError=textoError+"Es necesario introducir una cantidad al movimiento DEBE "+i+".\n";
            objeto.style.borderColor='#FF0000';
            objeto.title ='Se debe introducir una cantidad al movimiento '+i;
            esValido=false;
          }
          //compruebo que en el campo de cuenta contenga datos
          if(document.getElementById('strCuentaDEBE'+i).value==''){
            textoError=textoError+"Es necesario introducir una cuenta al movimiento DEBE "+i+".\n";
            document.getElementById('strCuentaDEBE'+i).style.borderColor='#FF0000';
            document.getElementById('strCuentaDEBE'+i).title ='Se debe introducir una cuenta al movimiento '+i;
            esValido=false;
          }
          //compruebo que en el campo de concepto contenga datos
          if(document.getElementById('strConceptoDEBE'+i).value==''){
            textoError=textoError+"Es necesario introducir un concepto al movimiento DEBE "+i+".\n";
            document.getElementById('strConceptoDEBE'+i).style.borderColor='#FF0000';
            document.getElementById('strConceptoDEBE'+i).title ='Se debe introducir un concepto al movimiento '+i;
            esValido=false;
          }
      }
  }
  //la misma comprobacion que el anterior en las cuentas de HABER
  for(i=1;i<=<?php echo $numMovimientos; ?>;i++){
      var objeto=document.getElementById('lngCuentaHABER['+i+']');
      if(objeto.value != ''){//vemos que no esta vacio
          //ahora compruebo que sea numerico
          if(objeto.value==''){
            textoError=textoError+"Es necesario introducir una cantidad al movimiento HABER "+i+".\n";
            objeto.style.borderColor='#FF0000';
            objeto.title ='Se debe introducir una cantidad al movimiento '+i;
            esValido=false;
          }
          //y por ultimo compruebo que en el campo de cuenta contenga datos
          if(document.getElementById('strCuentaHABER'+i).value==''){
            textoError=textoError+"Es necesario introducir una cuenta al movimiento HABER "+i+".\n";
            document.getElementById('strCuentaHABER'+i).style.borderColor='#FF0000';
            document.getElementById('strCuentaHABER'+i).title ='Se debe introducir una cuenta al movimiento '+i;
            esValido=false;
          }
          //compruebo que en el campo de concepto contenga datos
          if(document.getElementById('strConceptoHABER'+i).value==''){
            textoError=textoError+"Es necesario introducir un concepto al movimiento HABER "+i+".\n";
            document.getElementById('strConceptoHABER'+i).style.borderColor='#FF0000';
            document.getElementById('strConceptoHABER'+i).title ='Se debe introducir un concepto al movimiento '+i;
            esValido=false;
          }
      }
  }
  //comprobacion de que la cuenta del DEBE es correcta (existe)
  //esto se verifica por la variable oculta okStrCuentaDEBE
  for(i=1;i<=<?php echo $numMovimientos; ?>;i++){
      if(document.getElementById('okStrCuentaDEBE'+i).value=='NO'){
            textoError=textoError+"La cuenta del DEBE "+i+" no existe en la BBDD.\n";
            document.getElementById('strCuentaDEBE'+i).style.borderColor='#FF0000';
            document.getElementById('strCuentaDEBE'+i).title ='La cuenta del DEBE '+i+' no existe en la BBDD.';
            esValido=false;
      }
  }
  //lo mismo para las cuentas del HABER
  //esto se verifica por la variable oculta okStrCuentaHABER
  for(i=1;i<=<?php echo $numMovimientos; ?>;i++){
      if(document.getElementById('okStrCuentaHABER'+i).value=='NO'){
            textoError=textoError+"La cuenta del HABER "+i+" no existe en la BBDD.\n";
            document.getElementById('strCuentaHABER'+i).style.borderColor='#FF0000';
            document.getElementById('strCuentaHABER'+i).title ='La cuenta del HABER '+i+' no existe en la BBDD.';
            esValido=false;
      }
  }
  //comprobar que si hay una anotacion de cuenta y concepto la cantidad no sea 0 o vacio (seria incongruente)
  //primero lo hago con las de DEBE
  for(i=1;i<=<?php echo $numMovimientos; ?>;i++){
      if(document.getElementById('lngCuentaDEBE['+i+']').value=='0,00' || document.getElementById('lngCuentaDEBE['+i+']').value=='' && document.getElementById('strCuentaDEBE'+i).value!=''){
            textoError=textoError+"La cantidad de la cuenta del DEBE "+i+" debe ser distinta de CERO.\n";
            document.getElementById('lngCuentaDEBE['+i+']').style.borderColor='#FF0000';
            document.getElementById('lngCuentaDEBE['+i+']').title ="La cantidad de la cuenta del DEBE "+i+" debe ser distinta de CERO";
            esValido=false;
      }
  }
  //ahora con las de HABER
  for(i=1;i<=<?php echo $numMovimientos; ?>;i++){
      if(document.getElementById('lngCuentaHABER['+i+']').value=='0,00' || document.getElementById('lngCuentaHABER['+i+']').value=='' && document.getElementById('strCuentaHABER'+i).value!=''){
            textoError=textoError+"La cantidad de la cuenta del HABER "+i+" debe ser distinta de CERO.\n";
            document.getElementById('lngCuentaHABER['+i+']').style.borderColor='#FF0000';
            document.getElementById('lngCuentaHABER['+i+']').title ="La cantidad de la cuenta del HABER "+i+" debe ser distinta de CERO";
            esValido=false;
      }
  }
  //comprobar que el total del debe y haber deben coincidir
  var totalDEBE=document.getElementById('lngTotalDebe').value;
  var totalHABER=document.getElementById('lngTotalHaber').value;
  if(totalDEBE != totalHABER){
    textoError=textoError+"El asiento está descuadrado.\n";
    document.getElementById('lngTotalDebe').style.borderColor='#FF0000';
    document.getElementById('lngTotalHaber').style.borderColor='#FF0000';
    esValido=false;
  }
  //comprobacion por si se pulsa 'Aceptar' sin haber anotado ningun movimiento
  vacio=true;
  for(i=1;i<=<?php echo $numMovimientos; ?>;i++){
    if(document.getElementById('strCuentaDEBE'+i).value!=''){
        vacio=false;
    }
    if(document.getElementById('strCuentaHABER'+i).value!=''){
        vacio=false;
    }
  }
  if(vacio==true){
    //si vacio es true indico el error
    textoError=textoError+"Debe existir alguna anotacion.\n";
    esValido=false;
  }

  //sino a habido ningun error de validacion, guardamos en las variables hidden los datos numericos que 
  //despues se guardan en BBDD
  for(i=1;i<=<?php echo $numMovimientos; ?>;i++){
      document.getElementById('lngCuentaDEBE'+i).value=desFormateaNumeroContabilidad(document.getElementById('lngCuentaDEBE['+i+']').value);
      document.getElementById('lngCuentaHABER'+i).value=desFormateaNumeroContabilidad(document.getElementById('lngCuentaHABER['+i+']').value);
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

function CalculaDEBE() {
    var numMov=<?php echo $numMovimientos; ?>;
    var suma=0;
    for (i=1; i<=numMov; i++){
        var numero=document.getElementById('lngCuentaDEBE['+i+']').value;
        var numeroSinFormateo=desFormateaNumeroContabilidad(numero);
        suma=parseFloat(suma)+parseFloat(numeroSinFormateo);
        suma=Math.round(suma*100)/100;
    }
    if(isNaN(suma)){
        document.getElementById('lngTotalDebe').value='';
    }else{
        document.getElementById('lngTotalDebe').value=suma;
        document.getElementById('lngTotalDebe').value=formateaNumeroContabilidad(document.getElementById('lngTotalDebe').value);
    }
}

function CalculaHABER() {
    var numMov=<?php echo $numMovimientos; ?>;
    var suma=0;
    for (i=1; i<=numMov; i++){
        var numero=document.getElementById('lngCuentaHABER['+i+']').value;
        var numeroSinFormateo=desFormateaNumeroContabilidad(numero);
        suma=parseFloat(suma)+parseFloat(numeroSinFormateo);
        suma=Math.round(suma*100)/100;
    }
    if(isNaN(suma)){
        document.getElementById('lngTotalHaber').value='';
    }else{
        document.getElementById('lngTotalHaber').value=suma;
        document.getElementById('lngTotalHaber').value=formateaNumeroContabilidad(document.getElementById('lngTotalHaber').value);
    }
}

//formateo de numeros
function formateaCantidad(objeto){
    objeto.value=formateaNumeroContabilidad(objeto.value);
}    

//borrar Asiento
function borrarAsiento(id){
    if (confirm("¿Desea borrar el Asiento de la base de datos?"))
    {
        window.location='../vista/asientoBorrar.php?id='+id;
    }
}

//funcion que copia el texto del conceptojusto encima
function rellenaConceptoDebe(i){
    //compruebo que no sea la primera linea
    if(i>1){
        //compruebo que este vacio el campo
        if(document.getElementById('strConceptoDEBE'+i).value===''){
            document.getElementById('strConceptoDEBE'+i).value = document.getElementById('strConceptoDEBE'+(i-1)).value;
        }
    }
}

//funcion que copia el texto del conceptojusto encima
function rellenaConceptoHaber(i){
    //compruebo que este vacio el campo
    if(document.getElementById('strConceptoHABER'+i).value===''){
        document.getElementById('strConceptoHABER'+i).value = document.getElementById('strConceptoDEBE'+i).value;
    }
}

</script>
<?php
}

    
function html_pagina($datosUsuario,$datosFechaAsiento,$datosDebeAsiento,$datosHaberAsiento,$editar,$numMovimientos,$sumaDEBE,$sumaHABER,$Asiento){
    
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
<TITLE>Alta de Movimientos - Movimientos</TITLE>

<?php
scripts($numMovimientos);
?>

<script languaje="JavaScript"  type="text/JavaScript">
function Modificar(menu)
{

		document.form1.strTipReclamacion.value = menu.options[menu.selectedIndex].text
}
</script>
<!--<SCRIPT LANGUAGE="JavaScript" SRC="../js/valida.js">

	alert('Error en el fichero valida.js');
// 
</SCRIPT>-->
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
<!--<SCRIPT language="JavaScript" SRC="../js/car_valido.js">

</SCRIPT>-->
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
      onLoad="fechaMes(document.getElementById('datFecha'));
              <?php
                if(!isset($_GET['Asiento'])){
                    echo 'focusFecha();';
                }else{
                    if(isset($_GET['borrar']) && $_GET['borrar']==='si'){
                        echo 'borrarAsiento('. $_GET['Asiento'].');';
                    }
                }
              ?>"
              >
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<!-- Cabecera-->
  <tr>
   <td width="40%" height="100%" border="0"></td>
   <td  width="1300" height="35" border="0" alt="" bgcolor="#FFFFFF"  class="Text2">
   <table border="<?php echo MARCO_BORDER; ?>" cellpadding="0" cellspacing="0" width="1200">

   <tr>
   <!-- contenido pagina -->
   <td width="1200" height="854" border="0" alt="" valign="top">
   <br><p></p>

<center>
    
<?php
$tituloForm='MOVIMIENTOS<br/>ALTA DE ASIENTO';
if(isset($_GET['Asiento'])){
    $cabeceraNumero='0204e';
}else{
    $cabeceraNumero='0204n';
}
$paginaForm='';
//require_once 'CodFormat.php';
//$codFormat=new CodFormat();
//$codFormat->setStrBD($_SESSION['dbContabilidad']);
//$formatoForm=$codFormat->SelectFormato(60);
$formatoForm='';
$numeroForm='';
$disabledForm='disabled';
date_default_timezone_set('Europe/Madrid');
$fechaForm=date('d/m/Y');
$fechaYear=date('Y');
require_once 'cabeceraForm.php';
?>
  <div class="apaisado"> 
    <hr color = "#FF9900">
    <br/>
    <form name="form1" method="post" action="../vista/ingresos_gastos.php">
	
        
      <table width="1200" border="0" class="zonaactiva">
        <tr> 
          <td class="subtitulo" colspan="11">&nbsp;Datos de la Empresa</td>
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
              <input class="textbox1" type="text" name="strEmpresa" maxlength="50" value="<?php echo $_SESSION['sesion'];?>" readonly
                   <?php if($editar=='NO'){?>
                       disabled
                   <?php }?>
                     />
              </div>
          </td>
          <td></td>
          <td colspan="2">
             <div align="left">
             <label class="nombreCampo" width="70">Fecha</label>
            <?php
            datepicker_español('datFecha');
            ?>
            <style type="text/css">
            /* para que no salga el rectangulo inferior */        
            .ui-widget-content {
                border: 0px solid #AAAAAA;
            }
            </style>
            
                <input class="textbox1" type="text" id="datFecha" name="datFecha" maxlength="38" value="<?php if(isset($datosFechaAsiento[1])){echo date("d/m/Y",strtotime($datosFechaAsiento[1]['fecha']));}else{echo $fechaForm;}?>"
                   <?php if($editar=='NO'){?>
                       disabled
                   <?php }else{?>
                   placeholder="<?php if(isset($datosFechaAsiento[1])){echo date("d/m/Y",strtotime($datosFechaAsiento[1]['fecha']));}else{echo $fechaForm;}?>" 
                   onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                   onKeyUp="this.value=formateafechaEntrada(this.value);" 
                   onfocus="onFocusInputText(this);<?php if(!isset($datosFechaAsiento[1])){echo 'limpiaCampoFecha(this)';}?>"
                   onblur="onBlurInputText(this);comprobarFechaEsCerrada(this);comprobarVacioFecha(this,'<?php echo $fechaForm;?>');fechaMes(this);"
                   onchange="fechaMes(this);comprobarFechaEsCerrada(this);" 
                   <?php }?>
                />
             </div>
          </td>
          <td></td>
          <td colspan="2">
              <div align="left">
              <label class="nombreCampo">Ejercicio</label>
              <input class="textbox1" type="text" id="lngEjercicio" name="lngEjercicio" maxlength="4" readonly 
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOverInputText(this);"
                     value="<?php if(isset($datosFechaAsiento[1])){echo $datosFechaAsiento[1]['ejercicio'];}?>"
                   <?php if($editar=='NO'){?>
                       disabled
                   <?php }else{?>
                     onkeypress="fechaMes(document.getElementById('datFecha'));" 
                   <?php }?>
              />       
              </div>
          </td>
          <td></td>
          <td colspan="2">
              <div align="left">
              <label class="nombreCampo">Periodo</label>
              <input class="textbox1" type="text" id="strPeriodo" name="strPeriodo" readonly
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOverInputText(this);"
                     value="<?php if(isset($datosFechaAsiento[1])){echo $datosFechaAsiento[1]['periodo'];}?>"
                   <?php if($editar=='NO'){?>
                       readonly
                   <?php }?>
              />         
              <input type="hidden" id="lngPeriodo" name="lngPeriodo" value="0" />
              </div>
          </td>
        </tr>
        
        <tr>
            <td height="15px"></td>
        </tr>
      </table>
        
      <table width="1200" border="0" class="zonaactiva">
        <tr> 
          <td class="subtitulo">&nbsp;Alta de Movimientos</td>
        </tr>
        
        <tr>
            <td>
                <table width="1200" border="0" class="zonaactiva">
                    <tr>
                        <td colspan="4">
                          <div align="center">
                            <strong>&nbsp;CUENTA DEBE</strong>
                          </div>
                        </td>
                        <td></td>
                        <td colspan="4">
                          <div align="center">
                            <strong>&nbsp;CUENTA HABER</strong>
                          </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="2%"><strong>&nbsp;</strong></td>
                        <td width="19%"><strong>&nbsp;Cuenta</strong></td>
                        <td width="18%"><strong>&nbsp;Concepto</strong></td>
                        <td width="9%"><strong>&nbsp;Cantidad</strong></td>
                        <td width="4%">&nbsp;</td>
                        <td width="2%"><strong>&nbsp;</strong></td>
                        <td width="19%"><strong>&nbsp;Cuenta</strong></td>
                        <td width="18%"><strong>&nbsp;Concepto</strong></td>
                        <td width="9%"><strong>&nbsp;Cantidad</strong></td>
                    </tr>
                    <?php
                    //se repite un numero de veces esta fila (row)
                    for($i=1;$i<=$numMovimientos;$i++){
                    ?>
                    <tr>
                        <td>
                            <?php echo $i?>
                            <input type="hidden" id="idMovDEBE<?php echo $i;?>" name="idMovDEBE<?php echo $i;?>" value="<?php if(!is_array($datosDebeAsiento)){echo $datosDebeAsiento[$i]['IdMovimiento'];}?>"/>
                        </td>
                        <td>
                          <div align="left">
                            <?php
                            //funcion general
                            autocomplete_cuentas('strCuentaDEBE'.$i);
                            ?>
                              <input class="textbox1" size="40" type="text" id="strCuentaDEBE<?php echo $i;?>" name="strCuentaDEBE<?php echo $i;?>" onKeyUp="comprobarCuenta(this,document.getElementById('okStrCuentaDEBE<?php echo $i;?>'));"
                                   onMouseOver="onMouseOverInputText(this);onMouseOverInputText(document.getElementById('strConceptoDEBE<?php echo $i;?>'));onMouseOverInputText(document.getElementById('lngCuentaDEBE[<?php echo $i;?>]'));"
                                   onMouseOut="onMouseOutInputText(this);onMouseOutInputText(document.getElementById('strConceptoDEBE<?php echo $i;?>'));onMouseOutInputText(document.getElementById('lngCuentaDEBE[<?php echo $i;?>]'));"
                                   onfocus="onFocusInputText(this);onFocusInputText(document.getElementById('strConceptoDEBE<?php echo $i;?>'));onFocusInputText(document.getElementById('lngCuentaDEBE[<?php echo $i;?>]'));comprobarCuentaBlur(this,document.getElementById('okStrCuentaDEBE<?php echo $i;?>'));"
                                   onblur="rellenaConceptoDebe('<?php echo $i;?>');onBlurInputText(this);onBlurInputText(document.getElementById('strConceptoDEBE<?php echo $i;?>'));onBlurInputText(document.getElementById('lngCuentaDEBE[<?php echo $i;?>]'));comprobarCuentaBlur(this,document.getElementById('okStrCuentaDEBE<?php echo $i;?>'));"
                                   value="<?php if(isset($datosDebeAsiento[$i])){echo $datosDebeAsiento[$i]['cuenta'];}?>" <?php if($editar=='NO'){echo 'disabled';} ?> />
                            <input type="hidden" id="okStrCuentaDEBE<?php echo $i;?>" name="okStrCuentaDEBE<?php echo $i;?>" value="SI"/>
                          </div>
                        </td>
                        <td>
                          <div align="left">
                            <input class="textbox1" size="50" type="text" id="strConceptoDEBE<?php echo $i;?>" name="strConceptoDEBE<?php echo $i;?>" 
                                   onMouseOver="onMouseOverInputText(this);onMouseOverInputText(document.getElementById('strCuentaDEBE<?php echo $i;?>'));onMouseOverInputText(document.getElementById('lngCuentaDEBE[<?php echo $i;?>]'));"
                                   onMouseOut="onMouseOutInputText(this);onMouseOutInputText(document.getElementById('strCuentaDEBE<?php echo $i;?>'));onMouseOutInputText(document.getElementById('lngCuentaDEBE[<?php echo $i;?>]'));"
                                   onfocus="onFocusInputText(this);onFocusInputText(document.getElementById('strCuentaDEBE<?php echo $i;?>'));onFocusInputText(document.getElementById('lngCuentaDEBE[<?php echo $i;?>]'));"
                                   onblur="onBlurInputText(this);onBlurInputText(document.getElementById('strCuentaDEBE<?php echo $i;?>'));onBlurInputText(document.getElementById('lngCuentaDEBE[<?php echo $i;?>]'));"
                                   value="<?php if(isset($datosDebeAsiento[$i])){echo $datosDebeAsiento[$i]['concepto'];}?>" <?php if($editar=='NO'){echo 'disabled';} ?> />
                          </div>
                        </td>
                        <td>
                          <div align="left">
                            <input class="textbox1" type="text" id="lngCuentaDEBE[<?php echo $i;?>]" name="lngCuentaDEBEContabilidad<?php echo $i;?>" maxlength="10"
                                   style="text-align:right;font-weight:bold;" value="<?php if(isset($datosDebeAsiento[$i])){if($datosDebeAsiento[$i]['cantidad']==''){echo '0,00';}else{echo number_format($datosDebeAsiento[$i]['cantidad'], 2, ",", ".");}}?>"
                                   <?php
                                   if($editar=='NO'){?>
                                      disabled
                                   <?php
                                   }else{
                                   ?>
                                      onkeypress="javascript:return solonumeros(event);"
                                      onMouseOver="onMouseOverInputText(this);onMouseOverInputText(document.getElementById('strCuentaDEBE<?php echo $i;?>'));onMouseOverInputText(document.getElementById('strConceptoDEBE<?php echo $i;?>'));"
                                      onMouseOut="onMouseOutInputText(this);onMouseOutInputText(document.getElementById('strCuentaDEBE<?php echo $i;?>'));onMouseOutInputText(document.getElementById('strConceptoDEBE<?php echo $i;?>'));"
                                      onfocus="CalculaDEBE();onFocusInputText(this);onFocusInputText(document.getElementById('strCuentaDEBE<?php echo $i;?>'));onFocusInputText(document.getElementById('strConceptoDEBE<?php echo $i;?>'));entradaCantidad(this,document.form1.lngCuentaDEBE<?php echo $i;?>);selecciona_value(this);"
                                      onblur="onBlurInputText(this);onBlurInputText(document.getElementById('strCuentaDEBE<?php echo $i;?>'));onBlurInputText(document.getElementById('strConceptoDEBE<?php echo $i;?>'));formateaCantidad(this);vaciarSiEs0(this);CalculaDEBE();actualizaCampoHidden(this,document.form1.lngCuentaDEBE<?php echo $i;?>);"
                                   <?php   
                                   } 
                                   ?>
                            />
                            <input type="hidden" id="lngCuentaDEBE<?php echo $i;?>" name="lngCuentaDEBE<?php echo $i;?>" value="<?php if(isset($datosDebeAsiento[$i])){if($datosDebeAsiento[$i]['cantidad']==''){echo '0,00';}else{echo $datosDebeAsiento[$i]['cantidad'];}}?>" />
                          </div>
                        </td>
                        <td></td>
                        <td>
                            <?php echo $i?>
                            <input type="hidden" id="idMovHABER<?php echo $i;?>" name="idMovHABER<?php echo $i;?>" value="<?php if(!is_array($datosHaberAsiento)){echo $datosHaberAsiento[$i]['IdMovimiento'];}?>"/>
                        </td>
                        <td>
                          <div align="left">
                            <?php
                            //funcion general
                            autocomplete_cuentas('strCuentaHABER'.$i);
                            ?>
                            <input class="textbox1" size="40" type="text" id="strCuentaHABER<?php echo $i;?>" name="strCuentaHABER<?php echo $i;?>" onKeyUp="comprobarCuenta(this,document.getElementById('okStrCuentaHABER<?php echo $i;?>'));" 
                                   onMouseOver="onMouseOverInputText(this);onMouseOverInputText(document.getElementById('strConceptoHABER<?php echo $i;?>'));onMouseOverInputText(document.getElementById('lngCuentaHABER[<?php echo $i;?>]'));"
                                   onMouseOut="onMouseOutInputText(this);onMouseOutInputText(document.getElementById('strConceptoHABER<?php echo $i;?>'));onMouseOutInputText(document.getElementById('lngCuentaHABER[<?php echo $i;?>]'));"
                                   onfocus="onFocusInputText(this);onFocusInputText(document.getElementById('strConceptoHABER<?php echo $i;?>'));onFocusInputText(document.getElementById('lngCuentaHABER[<?php echo $i;?>]'));comprobarCuentaBlur(this,document.getElementById('okStrCuentaHABER<?php echo $i;?>'));"
                                   onblur="rellenaConceptoHaber('<?php echo $i;?>');;onBlurInputText(this);onBlurInputText(document.getElementById('strConceptoHABER<?php echo $i;?>'));onBlurInputText(document.getElementById('lngCuentaHABER[<?php echo $i;?>]'));comprobarCuentaBlur(this,document.getElementById('okStrCuentaHABER<?php echo $i;?>'));"
                                   value="<?php if(isset($datosHaberAsiento[$i])){echo $datosHaberAsiento[$i]['cuenta'];}?>" <?php if($editar=='NO'){echo 'disabled';} ?> />
                            <input type="hidden" id="okStrCuentaHABER<?php echo $i;?>" name="okStrCuentaHABER<?php echo $i;?>" value="SI"/>
                          </div>
                        </td>
                        <td>
                          <div align="left">
                            <input class="textbox1" size="50" type="text" id="strConceptoHABER<?php echo $i;?>" name="strConceptoHABER<?php echo $i;?>" 
                                   onMouseOver="onMouseOverInputText(this);onMouseOverInputText(document.getElementById('strCuentaHABER<?php echo $i;?>'));onMouseOverInputText(document.getElementById('lngCuentaHABER[<?php echo $i;?>]'));"
                                   onMouseOut="onMouseOutInputText(this);onMouseOutInputText(document.getElementById('strCuentaHABER<?php echo $i;?>'));onMouseOutInputText(document.getElementById('lngCuentaHABER[<?php echo $i;?>]'));"
                                   onfocus="onFocusInputText(this);onFocusInputText(document.getElementById('strCuentaHABER<?php echo $i;?>'));onFocusInputText(document.getElementById('lngCuentaHABER[<?php echo $i;?>]'));"
                                   onblur="onBlurInputText(this);onBlurInputText(document.getElementById('strCuentaHABER<?php echo $i;?>'));onBlurInputText(document.getElementById('lngCuentaHABER[<?php echo $i;?>]'));"
                                   value="<?php if(isset($datosHaberAsiento[$i])){echo $datosHaberAsiento[$i]['concepto'];}?>" <?php if($editar=='NO'){echo 'disabled';} ?> />
                          </div>
                        </td>
                        <td>
                          <div align="left">
                            <input class="textbox1" type="text" id="lngCuentaHABER[<?php echo $i;?>]" name="lngCuentaHABERContabilidad<?php echo $i;?>" maxlength="10"
                                   style="text-align:right;font-weight:bold;" value="<?php if(isset($datosHaberAsiento[$i])){if($datosHaberAsiento[$i]['cantidad']==''){echo '0,00';}else{echo number_format($datosHaberAsiento[$i]['cantidad'], 2, ",", ".");}}?>"
                                   <?php
                                   if($editar=='NO'){?>
                                      disabled
                                   <?php
                                   }else{
                                   ?>
                                      onkeypress="javascript:return solonumeros(event);"
                                      onMouseOver="onMouseOverInputText(this);onMouseOverInputText(document.getElementById('strCuentaHABER<?php echo $i;?>'));onMouseOverInputText(document.getElementById('strConceptoHABER<?php echo $i;?>'));"
                                      onMouseOut="onMouseOutInputText(this);onMouseOutInputText(document.getElementById('strCuentaHABER<?php echo $i;?>'));onMouseOutInputText(document.getElementById('strConceptoHABER<?php echo $i;?>'));"
                                      onfocus="CalculaHABER();onFocusInputText(this);onFocusInputText(document.getElementById('strCuentaHABER<?php echo $i;?>'));onFocusInputText(document.getElementById('strConceptoHABER<?php echo $i;?>'));entradaCantidad(this,document.form1.lngCuentaHABER<?php echo $i;?>);selecciona_value(this);"
                                      onblur="onBlurInputText(this);onBlurInputText(document.getElementById('strCuentaHABER<?php echo $i;?>'));onBlurInputText(document.getElementById('strConceptoHABER<?php echo $i;?>'));formateaCantidad(this);vaciarSiEs0(this);CalculaHABER();actualizaCampoHidden(this,document.form1.lngCuentaHABER<?php echo $i;?>);"
                                   <?php   
                                   } 
                                   ?>
                            />
                            <input type="hidden" id="lngCuentaHABER<?php echo $i;?>" name="lngCuentaHABER<?php echo $i;?>" value="<?php if(isset($datosHaberAsiento[$i])){if($datosHaberAsiento[$i]['cantidad']==''){echo '0,00';}else{echo $datosHaberAsiento[$i]['cantidad'];}}?>" />
                          </div>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                          <div align="right">
                            <label class="nombreCampo"><strong>TOTAL DEBE</strong></label>
                          </div>
                        </td>
                        <td>
                          <div align="left">
                              <input class="textbox1" type="text" id="lngTotalDebe" name="lngTotalDebe" style="text-align:right;font-weight:bold;" value="<?php echo number_format($sumaDEBE, 2, ",", ".");?>" readonly
                                <?php if($editar=='NO'){?>
                                    disabled
                                <?php }else{?>
                                   onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"
                                <?php }?>
                              />     
                          </div>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                          <div align="right">
                            <label class="nombreCampo"><strong>TOTAL HABER</strong></label>
                          </div>
                        </td>
                        <td>
                          <div align="left">
                            <input class="textbox1" type="text" id="lngTotalHaber" name="lngTotalHaber" style="text-align:right;font-weight:bold;" value="<?php echo number_format($sumaHABER, 2, ",", ".");?>" readonly
                                <?php if($editar=='NO'){?>
                                    disabled
                                <?php }else{?>
                                   onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"
                                <?php }?>
                              />     
                          </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>        
        
        <tr>
            <td height="15px"></td>
        </tr>
      </table>
        
        
      <table width="1200" border="0" class="zonaactiva">
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
        <input type="button" class="button" name="cmdAlta" id="cmdAlta" value = "Grabar" onclick="javascript:validar2();" />
        <?php if(isset($_GET['Asiento'])){?>
        <script languaje="JavaScript"> 
            function volver(){
                javascript:history.back();
            }
        </script>
        <input class="buttonAzul" type="button" value="Volver" onclick="volver();" />
        <?php if(isset($_GET['Asiento'])){?>
            <input type="button" class="buttonAzul"  value="Eliminar" name="cmdBorrar" onclick="javascript:borrarAsiento('<?php echo $Asiento;?>');" />
        <?php }?>
        <?php }?>
        <script languaje="JavaScript"> 
            function botonReset(){
                document.form1.reset();
                fechaMes(document.getElementById('datFecha'));
            }
        </script>
        <input type="button" name="cmdReset" onclick="botonReset();"
        <?php if(isset($_GET['Asiento'])){?>
            value="Datos Iniciales"
        <?php }else{?>
            value="Vaciar Datos"
        <?php }?>
        <?php if($editar=='NO'){?>
            class="buttonDesactivado" disabled="true"
        <?php }else{?>
            class="button"
        <?php }?>
        <?php if($editar=='NO'){?>
            disabled="true"
            class="buttonDesactivado" disabled="true"
        <?php }else{?>
            class="button"
        <?php }?>
        /> 
        <input type="hidden"  name="cmdAlta" value="Aceptar" />
<!--        con esta variable hidden sabemos el numero de asiento  asi sabemos si hay que crear o editar asiento-->
        <input type="hidden"  name="asiento" value="<?php echo $Asiento;?>" />
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
<!--indico si se puede editar o no este Asiento    -->
<?php if(isset($editar) && $editar=='NO'){ ?>
<script language="JavaScript">
    alert('Este Asiento esta CERRADO. NO se puede EDITAR.');
</script>
<?php } ?>
    
</body>
</html>
<?php
}//fin del html_pagina


function html_paginaMovil($datosUsuario,$datosFechaAsiento,$datosDebeAsiento,$datosHaberAsiento,$editar,$numMovimientos,$sumaDEBE,$sumaHABER,$Asiento){
require_once '../general/funcionesGenerales.php';
?>
<!DOCTYPE html>
<html>
<head>
<TITLE>Alta de Ingresos - Movimientos  XXXXXXXXXXXX</TITLE>

<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>
<link rel="stylesheet" href="../css/estiloMovil.css" />
<?php
scripts($numMovimientos);
?>
        
</head>
<BODY 
      onLoad="fechaMes_MovilAsientoMovimientos(document.getElementById('datFecha'));
              <?php
                if(!isset($_GET['Asiento'])){
                    echo 'focusFecha();';
                }else{
                    if(isset($_GET['borrar']) && $_GET['borrar']==='si'){
                        echo 'borrarAsiento('. $_GET['Asiento'].');';
                    }
                }
              ?>"
      class="api jquery-mobile archive category category-widgets category-2 listing single-author"> 

<div data-role="page" id="ingresos_gastos">
<?php
eventosInputText();
?>
<script language="JavaScript">
</script>
    

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>

    <div data-role="content" data-theme="a">
        <form action="../vista/ingresos_gastos.php" name="form1" method="POST" data-ajax="false">
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
                                            <label><font color="2e9b46"><b><span id="strPeriodoMov"><?php if(isset($datosFechaAsiento[1])){echo $datosFechaAsiento[1]['periodo'];}?></span></b></font></label>
                                            <input type="hidden" id="strPeriodo" name="strPeriodo" value="<?php if(isset($datosFechaAsiento[1])){echo $datosFechaAsiento[1]['periodo'];}?>" />
                                            <input type="hidden" id="lngPeriodo" name="lngPeriodo" value="0"/>
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
                            <?php
                            datepicker_español('datFecha');
                            ?>
                            <input type="text" id="datFecha" name="datFecha" maxlength="38"
                                   value="<?php if(isset($datosFechaAsiento[1])){echo date("d/m/Y",strtotime($datosFechaAsiento[1]['fecha']));}else{echo $fechaForm;}?>"
                                    <?php if($editar=='NO'){?>
                                        disabled
                                    <?php }else{?>

                                   placeholder="<?php if(isset($datosFechaAsiento[1])){echo date("d/m/Y",strtotime($datosFechaAsiento[1]['fecha']));}else{echo $fechaForm;}?>" 
                                   onfocus="onFocusInputTextM(this);<?php if(!isset($datosFechaAsiento[1])){echo 'limpiaCampoFecha(this)';}?>"
                                   onblur="comprobarFechaEsCerrada(this);comprobarVacioFecha(this,'<?php echo $fechaForm;?>');fechaMes_MovilAsiento(this);"
                                   onchange="fechaMes_MovilAsientoMovimientos(this);comprobarFechaEsCerrada(this);"
                                   <?php }?>
                                   />
                        </td>
                    </tr>
                    <tr>
                        <td style="height:20px;"></td>
                    </tr>
                    
                    <tr>
                        <td colspan="4">
                            <label>CUENTA DEBE</label>
                            <hr/>
                        </td>
                    </tr>
                    
                    <?php
                    //se repite un numero de veces esta fila (row)
                    for($i=1;$i<=$numMovimientos;$i++){
                    ?>
                    <tr> 
                      <td colspan="4"> 
                        <article id="post-2" class="hentry">
                        <div class="entry-summary">
                            <table border="0" style="width: 100%;">
                                <tr>
                                    <td style="width: 22%;"></td>
                                    <td style="width: 23%;"></td>
                                    <td style="width: 23%;"></td>
                                    <td style="width: 22%;"></td>
                                </tr>
                                <tr>
                                  <td colspan="4"> 
                                    <div align="left">
                                    <label class="nombreCampo">Cuenta</label>
                                    <?php
                                    //funcion general
                                      autocomplete_cuentas('strCuentaDEBE'.$i);
                                    ?>
                                      <input type="text" id="strCuentaDEBE<?php echo $i;?>" name="strCuentaDEBE<?php echo $i;?>" tabindex="2" 
                                            value="<?php if(isset($datosDebeAsiento[$i])){echo $datosDebeAsiento[$i]['cuenta'];}?>" <?php if($editar=='NO'){echo 'readonly';} ?>
                                            onKeyUp="comprobarCuenta(this,document.getElementById('okStrCuentaDEBE<?php echo $i;?>'));"  
                                            onfocus="onFocusInputTextM(this);onFocusInputTextM(document.getElementById('strConceptoDEBE<?php echo $i;?>'));onFocusInputTextM(document.getElementById('lngCuentaDEBE[<?php echo $i;?>]'));comprobarCuentaBlur(this,document.getElementById('okStrCuentaDEBE<?php echo $i;?>'));"
                                            onblur="rellenaConceptoDebe('<?php echo $i;?>');onBlurInputText(this);onBlurInputText(document.getElementById('strConceptoDEBE<?php echo $i;?>'));onBlurInputText(document.getElementById('lngCuentaDEBE[<?php echo $i;?>]'));comprobarCuentaBlur(this,document.getElementById('okStrCuentaDEBE<?php echo $i;?>'));"
                                           />
                                      <input type="hidden" id="idMovDEBE<?php echo $i;?>" name="idMovDEBE<?php echo $i;?>" value="<?php if(!is_array($datosDebeAsiento)){echo $datosDebeAsiento[$i]['IdMovimiento'];}?>"/>
                                      <input type="hidden" id="okStrCuentaDEBE<?php echo $i;?>" name="okStrCuentaDEBE<?php echo $i;?>" value="SI"/>
                                    </div>
                                </td>
                              </tr>
                              <tr> 
                                  <td colspan="4">
                                      <div align="left">
                                      <label class="nombreCampo">Concepto</label>
                                      <textarea id="strConceptoDEBE<?php echo $i;?>" name="strConceptoDEBE<?php echo $i;?>" rows=4 cols="20" <?php if($editar=='NO'){echo 'readonly';} ?> 
                                                    onfocus="javascript:this.style.borderColor='#aaa666';onFocusInputTextM(document.getElementById('strCuentaDEBE<?php echo $i;?>'));onFocusInputTextM(document.getElementById('lngCuentaDEBE[<?php echo $i;?>]'));"
                                                ><?php if(isset($datosDebeAsiento[$i])){echo htmlentities($datosDebeAsiento[$i]['concepto'],ENT_QUOTES,'UTF-8');}?></textarea> 
                                      </div>
                                  </td>
                              </tr>
                              <tr>
                                <td colspan="2">
                                    <div align="left">
                                      <label>Cantidad</label>
                                      <input type="text" id="lngCuentaDEBE[<?php echo $i;?>]" name="lngCuentaDEBEContabilidad<?php echo $i;?>" maxlength="10"
                                             style="text-align:right;font-weight:bold;"
                                             value="<?php if(isset($datosDebeAsiento[$i])){if($datosDebeAsiento[$i]['cantidad']==''){echo '0,00';}else{echo number_format($datosDebeAsiento[$i]['cantidad'], 2, ",", ".");}}?>" tabindex="5"
                                             <?php
                                             if($editar=='NO'){?>
                                                readonly
                                             <?php
                                             }else{
                                             ?>
                                                onfocus="CalculaDEBE();onFocusInputTextM(this);onFocusInputTextM(document.getElementById('strCuentaDEBE<?php echo $i;?>'));onFocusInputTextM(document.getElementById('strConceptoDEBE<?php echo $i;?>'));entradaCantidad(this,document.form1.lngCuentaDEBE<?php echo $i;?>);selecciona_value(this);"
                                                onblur="onBlurInputText(this);onBlurInputText(document.getElementById('strCuentaDEBE<?php echo $i;?>'));onBlurInputText(document.getElementById('strConceptoDEBE<?php echo $i;?>'));formateaCantidad(this);vaciarSiEs0(this);CalculaDEBE();actualizaCampoHidden(this,document.form1.lngCuentaDEBE<?php echo $i;?>);"
                                             <?php   
                                             } 
                                             ?>
                                              />
                                      <input type="hidden" id="lngCuentaDEBE<?php echo $i;?>" name="lngCuentaDEBE<?php echo $i;?>" value="<?php if(isset($datosDebeAsiento[$i])){if($datosDebeAsiento[$i]['cantidad']==''){echo '0,00';}else{echo $datosDebeAsiento[$i]['cantidad'];}}?>" />
                                    </div>
                                </td>
                              </tr>
                            </table>
                        </div>
                        </article>
                    <?php
                    }
                    ?>
                    </tr>
                    <tr>
                        <td style="height:30px;"></td>
                    </tr>
                    
                    <tr>
                        <td colspan="4">
                            <label>CUENTA HABER</label>
                            <hr/>
                        </td>
                    </tr>
                    
                    <?php
                    //se repite un numero de veces esta fila (row)
                    for($j=1;$j<=$numMovimientos;$j++){
                    ?>
                    <tr> 
                      <td colspan="4"> 
                        <article id="post-2" class="hentry">
                        <div class="entry-summary">
                            <table border="0" style="width: 100%;">
                                <tr>
                                    <td style="width: 22%;"></td>
                                    <td style="width: 23%;"></td>
                                    <td style="width: 23%;"></td>
                                    <td style="width: 22%;"></td>
                                </tr>
                                <tr>
                                  <td colspan="4"> 
                                    <div align="left">
                                    <label class="nombreCampo">Cuenta</label>
                                    <?php
                                    //funcion general
                                    autocomplete_cuentas('strCuentaHABER'.$j);
                                    ?>
                                      <input type="text" id="strCuentaHABER<?php echo $j;?>" name="strCuentaHABER<?php echo $j;?>" tabindex="2" 
                                            value="<?php if(isset($datosHaberAsiento[$j])){echo $datosHaberAsiento[$j]['cuenta'];}?>" <?php if($editar=='NO'){echo 'readonly';} ?>
                                            onKeyUp="comprobarCuenta(this,document.getElementById('okStrCuentaHABER<?php echo $j;?>'));"  
                                            onfocus="onFocusInputTextM(this);onFocusInputTextM(document.getElementById('strConceptoHABER<?php echo $j;?>'));onFocusInputTextM(document.getElementById('lngCuentaHABER[<?php echo $j;?>]'));comprobarCuentaBlur(this,document.getElementById('okStrCuentaHABER<?php echo $j;?>'));"
                                            onblur="rellenaConceptoDebe('<?php echo $j;?>');onBlurInputText(this);onBlurInputText(document.getElementById('strConceptoHABER<?php echo $j;?>'));onBlurInputText(document.getElementById('lngCuentaHABER[<?php echo $j;?>]'));comprobarCuentaBlur(this,document.getElementById('okStrCuentaHABER<?php echo $j;?>'));"
                                           />
                                      <input type="hidden" id="idMovHABER<?php echo $j;?>" name="idMovHABER<?php echo $j;?>" value="<?php if(!is_array($datosHaberAsiento)){echo $datosHaberAsiento[$j]['IdMovimiento'];}?>"/>
                                      <input type="hidden" id="okStrCuentaHABER<?php echo $j;?>" name="okStrCuentaHABER<?php echo $j;?>" value="SI"/>
                                    </div>
                                </td>
                              </tr>
                              <tr> 
                                  <td colspan="4">
                                      <div align="left">
                                      <label class="nombreCampo">Concepto</label>
                                      <textarea id="strConceptoHABER<?php echo $j;?>" name="strConceptoHABER<?php echo $j;?>" rows=4 cols="20" <?php if($editar=='NO'){echo 'readonly';} ?>
                                                    onfocus="javascript:this.style.borderColor='#aaa666';onFocusInputTextM(document.getElementById('strCuentaHABER<?php echo $j;?>'));onFocusInputTextM(document.getElementById('lngCuentaHABER[<?php echo $j;?>]'));"
                                                ><?php if(isset($datosHaberAsiento[$j])){echo htmlentities($datosHaberAsiento[$j]['concepto'],ENT_QUOTES,'UTF-8');}?></textarea> 
                                      </div>
                                  </td>
                              </tr>
                              <tr>
                                <td colspan="2">
                                    <div align="left">
                                      <label>Cantidad</label>
                                      <input type="text" id="lngCuentaHABER[<?php echo $j;?>]" name="lngCuentaHABERContabilidad<?php echo $j;?>" maxlength="10"
                                             style="text-align:right;font-weight:bold;"
                                             value="<?php if(isset($datosHaberAsiento[$j])){if($datosHaberAsiento[$j]['cantidad']==''){echo '0,00';}else{echo number_format($datosHaberAsiento[$j]['cantidad'], 2, ",", ".");}}?>" tabindex="5"
                                             <?php
                                             if($editar=='NO'){?>
                                                readonly
                                             <?php
                                             }else{
                                             ?>
                                                onfocus="CalculaHABER();onFocusInputTextM(this);onFocusInputTextM(document.getElementById('strCuentaHABER<?php echo $j;?>'));onFocusInputTextM(document.getElementById('strConceptoHABER<?php echo $j;?>'));entradaCantidad(this,document.form1.lngCuentaHABER<?php echo $j;?>);selecciona_value(this);"
                                                onblur="onBlurInputText(this);onBlurInputText(document.getElementById('strCuentaHABER<?php echo $j;?>'));onBlurInputText(document.getElementById('strConceptoHABER<?php echo $j;?>'));formateaCantidad(this);vaciarSiEs0(this);CalculaHABER();actualizaCampoHidden(this,document.form1.lngCuentaHABER<?php echo $j;?>);"
                                             <?php   
                                             } 
                                             ?>
                                              />
                                      <input type="hidden" id="lngCuentaHABER<?php echo $j;?>" name="lngCuentaHABER<?php echo $j;?>" value="<?php if(isset($datosHaberAsiento[$j])){if($datosHaberAsiento[$j]['cantidad']==''){echo '0,00';}else{echo $datosHaberAsiento[$j]['cantidad'];}}?>" />
                                    </div>
                                </td>
                              </tr>
                            </table>
                        </div>
                        </article>
                    <?php
                    }
                    ?>
                    </tr>
                    
                    
                    
                    <tr>
                      <td colspan="2"> 
                        <label>TOTAL DEBE</label>
                        <input style="text-align:right;font-weight:bold;" type="text" id="lngTotalDebe" name="lngTotalDebe" style="text-align:right;font-weight:bold;" value="<?php echo number_format($sumaDEBE, 2, ",", ".");?>" readonly
                          <?php if($editar=='NO'){?>
                              readonly
                          <?php }else{?>
                             onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"
                          <?php }?>
                        />     
                      </td>
                      <td colspan="2"> 
                        <label>TOTAL HABER</label>
                        <input style="text-align:right;font-weight:bold;" type="text" id="lngTotalHaber" name="lngTotalHaber" style="text-align:right;font-weight:bold;" value="<?php echo number_format($sumaHABER, 2, ",", ".");?>" readonly
                          <?php if($editar=='NO'){?>
                              readonly
                          <?php }else{?>
                             onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"
                          <?php }?>
                        />     
                      </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="button" id="cmdAlta" name="cmdAlta" data-theme="a" data-icon="forward" data-iconpos="right" value="Grabar" onClick="javascript:validar2();" /> 
                        </td>
                        <td colspan="2">
                        <?php if(isset($_GET['Asiento'])){?>
                            <input type="button" class="buttonAzul"  value="Eliminar" name="cmdBorrar" onclick="javascript:borrarAsiento('<?php echo $Asiento;?>');" />
                        <?php }?>
                            <input type="hidden"  name="cmdAlta" value="Aceptar" />
                    <!--        con esta variable hidden sabemos el numero de asiento  asi sabemos si hay que crear o editar asiento-->
                            <input type="hidden"  name="asiento" value="<?php echo $Asiento;?>" />
                        </td>
                    </tr>                    
                </tbody>
            </table>
        </form>
    </div>    
    <!--indico si se puede editar o no este Asiento    -->
    <?php if(isset($editar) && $editar=='NO'){ ?>
    <script language="JavaScript">
        alert('Este Asiento esta CERRADO. NO se puede EDITAR.');
    </script>
    <?php } ?>
</body>    
</html>
<?php    
}//fin del html_paginaMovil
?>
