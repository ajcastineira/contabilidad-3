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
//(ConFactura+IVA1+SinRetencionIRPF)
if(isset($_POST['cmdAlta']) && $_POST['cmdAlta']=='Alta'){
    //************************************************************************
    logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
           " ||||Operaciones->Mis Gastos|| Ha pulsado 'Aceptar'(ConFactura+IVA1+SinRetencionIRPF+Varias Cuentas)");
    
    //CREO QUE ESTA OPCION, QUE ES DAR DE ALTA UN NUEVO ASIENTO 15N NO HAY QUE HACERLA 21-4-2015
    //var_dump($_POST);die;
    //SIN HACER 17/4/2015
    
    //guardo el gasto el la tabla tbmovimientos, tbacumulados y tbmovimientos_iva
    $varRes = $clsCNContabilidad->AltaIngresosMovimientos(0,$_SESSION["idEmp"],$_POST['strCuenta'], $_POST["lngIngreso"],
                                            $_POST['strCuentaCli'], $_POST["lngCantidad"],$_POST["lngIva"],$_POST["lngPorcientoSin"], $_POST["datFecha"],$_POST['optTipo'],
                                            $_POST['strCuentaBancos'],$_POST["lngPeriodo"], $_POST["lngEjercicio"], addslashes($_POST["strConcepto"]), $_POST['esAbono'], $_SESSION["strUsuario"]);   

    logger('warning','' ,
           ' $clsCNContabilidad->AltaIngresosMovimientos(0,'.$_SESSION["idEmp"].",'".$_POST['strCuenta']."','". $_POST["lngIngreso"]."','".
                                            $_POST['strCuentaCli']."','". $_POST["lngCantidad"]."','".$_POST["lngIva"]."','".$_POST["lngPorcientoSin"]."','". $_POST["datFecha"]."','".$_POST['optTipo']."','".
                                            $_POST['strCuentaBancos']."',".$_POST["lngPeriodo"].",". $_POST["lngEjercicio"].",'". addslashes($_POST["strConcepto"])."','". $_POST['esAbono']."','". $_SESSION["strUsuario"]."');");
    
    if($varRes==FALSE){
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/error.php?id='.$varRes.'">';
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
//        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/ingresos_exito.php?op=CFIVA1SIRPF&datos='.$compactada.'&esAbono='.$_POST["esAbono"].'">';
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/ingresos_exito.php?op=CFIVA1SIRPF">';
    }
    //************************************************************************
}
//se viene del listado de editar asientos (listado_asientos2.php)
else if(isset($_GET['editar']) && $_GET['editar']==='SI'){
    logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
           " ||||Operaciones->Modificar Asiento||");

    $datosUsuario=$clsCNUsu->DatosUsuario($_SESSION['usuario']);
    
    //se buscan los datos de este asiento para cargarlos en el formulario
    $datos=$clsCNContabilidad->DatosAsientoCFIVA1SIRPFVC($_GET['Asiento'],$_GET['esAbono']);
    
    //vemos si el asiento esta en un perido editable para el iva
    $editarAsiento=$clsCNContabilidad->AsientoEditable($datos['lngEjercicio'],$datos['lngPeriodo']);

    //si $datos[Borrado]='0' este asiento esta borrado por lo que redirecciono a 'default2.php'
    if(isset($datos['Borrado']) && $datos['Borrado']==='1'){
        //presento el formulario con los datos
        html_pagina($datosUsuario,$datos,$editarAsiento,'edicion');
    }else{
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/default2.php">';
    }    
}
//se viende de dar a aceptar a editar un asiento
else if(isset($_POST['cmdAlta']) && $_POST['cmdAlta']=='Editar'){

    //var_dump($_POST);die;
    //SIN REVISAR
    
    //primero doy de baja el asiento actual
    $OK=$clsCNContabilidad->DarBajaAsiento($_POST['Asiento']);

    //si $OK<> informamos del error 
    if($OK<>1){
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/error.php?id=No se a cambiado el asiento">';
    }else{
        $OK2 = $clsCNContabilidad->AltaAsientoMovimientos_SinIRPF($_POST,$_SESSION["idEmp"], $_SESSION["strUsuario"]);   

        //me traigo la fecha de importacion y exportacion
        if($OK2==TRUE){
            $clsCNContabilidad->ActualizarAsientoImportado_tbmovimientos($_POST['Asiento']);
        }

        if($OK2==FALSE){
            //como ha fallado la insercion de los nuevos datos volvemos a dar de alta el asiento que habias dado de baja antes
            $clsCNContabilidad->DarAltaAsiento($_POST['Asiento']);
            ////indicamos el error
            echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/error.php?id=No se a editado el asiento">';
        }else{
            //voy a la pagina de 'exito.php'
            echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/exito.php?Id=Asiento editado correctamente">';
        }
    }    
}
//se viene de 'gastos_entrada.php'
else{//comienzo del else principal
    logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
           " ||||Operaciones->Mis Gastos||");
    
    $datosUsuario=$clsCNUsu->DatosUsuario($_SESSION['usuario']);
    
    //recojemos los datos si venimos de pulsar 'VOLVER' en 'gastos_exito.php'
    if(isset($_GET['datos'])){
        $datos=stripslashes ($_GET['datos']);
        $datos=unserialize ($datos);
        //print_r($datos);
    }else{
        $datos=null;
    }
    
    
    html_pagina($datosUsuario,$datos,'SI','nuevo');
}

function html_pagina($datosUsuario,$datos,$editarAsiento,$NoE){
    
    $clsCNContabilidad=new clsCNContabilidad();
    $clsCNContabilidad->setStrBD($_SESSION['mapeo']);
    
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
  
    //compruebo que las sumas de las cuentas y las del asiento (Base Imponible, cuota y total) sean las mismas
    if(document.form1.totalImporte.value !== document.form1.lngCantidadContabilidad.value){
        textoError=textoError+"La base imponible no suma "+document.form1.lngCantidadContabilidad.value+". Debe corregir esta desviación.\n";
//        document.form1.totalImporte.style.borderColor='#FF0000';
//        document.form1.lngCantidadContabilidad.style.borderColor='#FF0000';
        esValido=false;
    }
    if(document.form1.totalCuota.value !== document.form1.lngIvaContabilidad.value){
        textoError=textoError+"El IVA Soportado no suma "+document.form1.lngIvaContabilidad.value+". Debe corregir esta desviación.\n";
//        document.form1.totalCuota.style.borderColor='#FF0000';
//        document.form1.lngIvaContabilidad.style.borderColor='#FF0000';
        esValido=false;
    }
//    if(document.form1.totalTotal.value !== document.form1.lngIngresoContabilidad.value){
//        textoError=textoError+"El IVA Soportado no suma "+document.form1.lngIngresoContabilidad.value+". Debe corregir esta desviación.\n";
//        document.form1.totalTotal.style.borderColor='#FF0000';
//        document.form1.lngIngresoContabilidad.style.borderColor='#FF0000';
//        esValido=false;
//    }
  
  
  
  
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
    document.form1.strPeriodo.title ='Se debe introducir la fecha del apunte';
    esValido=false;
  }
  //comprobacion del campo 'lngEjercicio'
  if (document.form1.lngEjercicio.value === ''){ 
    textoError=textoError+"Es necesario introducir la fecha del apunte (EJERCICIO).\n";
    document.form1.lngEjercicio.title ='Se debe introducir la fecha del apunte';
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
  
    //revisamos toda la tabla de lineas de cuentas, hay que revisar el importe
    var importes = new Array();
    var nombreCuenta = new Array();
    var ivas = new Array();
    $(document).ready(function(){
        $('#form1').find(":input").each(function(){
            var elemento=this;
            //comprobamos el nombre del elemento y lo guardamos en ua array segun sea importe
            var nombreElemento=elemento.name;
            if(nombreElemento.substring(0,7)==='importe'){//es un elemento importe
                importes[nombreElemento.substr(7,3)]=elemento.value;
            }
            if(nombreElemento.substring(0,12)==='nombreCuenta'){//es un elemento importe
                nombreCuenta[nombreElemento.substr(12,3)]=elemento.value;
            }
            if(nombreElemento.substring(0,3)==='iva'){//es un elemento iva
                ivas[nombreElemento.substr(3,3)]=elemento.value;
            }
        });
    });
    //compruebo que no haya cuentas+ivas repetidas
    //recorro el array con dos punteros
    //punteros del array
    var punt1 = 0;
    var punt2 = 0;
    for(i=0;i<nombreCuenta.length-1;i++){
        for(j=i+1;j<nombreCuenta.length;j++){
            if(nombreCuenta[i] ===  nombreCuenta[j] && ivas[i] ===  ivas[j]){
                punt1 = i;
                punt2 = j;
            }
        }
    }    
    //si punt1 y punt2 son distintos de 0 es que hay cuentas repetidas, por lo que se indican
    if(punt1 !== 0 && punt2 !== 0){
        textoError=textoError+"la cuenta "+nombreCuenta[punt1]+" con iva "+ivas[punt1]+" esta repetida.\n";
        var txtNombreCuenta1 = "nombreCuenta"+punt1;
        var txtNombreCuenta2 = "nombreCuenta"+punt2;
        var txtIva1 = "iva"+punt1;
        var txtIva2 = "iva"+punt2;
        document.getElementById(txtNombreCuenta1).style.borderColor='#FF0000';
        document.getElementById(txtIva1).style.borderColor='#FF0000';
        document.getElementById(txtNombreCuenta2).style.borderColor='#FF0000';
        document.getElementById(txtIva2).style.borderColor='#FF0000';
        esValido=false;
    }
    
    //compruebo que los arrays lleven datos (lentgh)
    //si fuese 0 es que no se a introducido ninguna linea de factura y eso es incongruente
    if(importes.length===0){
        textoError=textoError+"Debe introducidir alguna linea en el presupuesto.\n";
        esValido=false;
    }
    
    
    var falloComp='NO';
    var falloImporte0='NO';
    var falloConceptoVacio='NO';
    
    for(i=0;i<importes.length;i++){
        //comprobamos que este control existe
        if(typeof importes[i] !== 'undefined' && importes[i]!=='null'){
            if(isNaN(parseFloat(desFormateaNumeroContabilidad(importes[i])))){
            }else{
                //importe no sea 0
                var importeNumero=parseFloat(desFormateaNumeroContabilidad(importes[i]));
                if(importeNumero===0){
                    var importe='importe'+i;
                    document.getElementById(importe).style.borderColor='#FF0000';
                    esValido=false;
                    falloImporte0='SI';
                }
            }
        }
    }
    
    //compruebo si esValido viene en false, si es asi indico el error
    if(esValido===false){
        if(falloComp==='SI'){
            textoError=textoError+"Los datos introducidos no son correctos, hay una incongruencia en cantidad, precio o importe.\n";
        }
        if(falloImporte0==='SI'){
            textoError=textoError+"El importe debe ser un valor positivo.\n";
        }
        if(falloConceptoVacio==='SI'){
            textoError=textoError+"Debe haber algún dato en el concepto.\n";
        }
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
    
//  //comprobar que los input hideen okStrCuenta.. esten con value=SI
//  if(document.getElementById('okStrCuenta').value === 'NO'){
//    textoError=textoError+"La cuenta de gasto no existe en la BBDD.\n";
//    document.form1.strCuenta.style.borderColor='#FF0000';
//    document.form1.strCuenta.title ='La cuenta de gasto no existe en la BBDD.';
//    esValido=false;
//  }

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
      //compruebo si el asiento es 15N o 15N2
      //si es 15N el asiento esta hecho con los datos de origen de la factura
      //si es 15N2 ya no esta ligada a la factura origen
      var tipoAsiento = document.form1.TipoAsiento.value;
      if(tipoAsiento === '15N' || tipoAsiento === '16N' || tipoAsiento === '17N' || tipoAsiento === '18N'){
          alert('Está modificando únicamente el asiento contable. No se realizará ningún cambio en la factura origen.');
      }
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

<script type="text/javascript" Language="JavaScript"> 
//formateo de numeros
function formateaCantidad(objeto){
    objeto.value=formateaNumeroContabilidad2(objeto.value);
}    

function desFormateaCantidad(objeto){
    objeto.value=desFormateaNumeroContabilidad2(objeto.value);
}    

//function copiaHidden(precio,precioHidden){
//    //guardo el valor del hidden
//    precioHidden.value=precio.value;
//}

function copiarCuentaHidden(cuenta,cuentaHidden){
    cuentaHidden.value = cuenta.value;
}

//function desFormateaCantidadHidden(precio,precioHidden){
//    //cojo el valor del hidden
//    precio.value=precioHidden.value;
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

function sumas(){
    var importeTotal=0;
    var cuotaTotal=0;
    var total=0;
    $(document).ready(function(){
        $('#form1').find(":input").each(function(){
            var elemento=this;
            //comprobamos el nombre del elemento y lo guardamos en ua array segun sea cantidad, precio, importe y concepto
            var nombreElemento=elemento.name;
            if(nombreElemento.substring(0,7)==='importe'){//es un elemento importe
                importeTotal=parseFloat(importeTotal)+parseFloat(desFormateaNumeroContabilidad2(elemento.value));
            }            
            if(nombreElemento.substring(0,5)==='cuota'){//es un elemento cuota
                cuotaTotal=parseFloat(cuotaTotal)+parseFloat(desFormateaNumeroContabilidad2(elemento.value));
            }            
        });
    });
    
    importeTotal=truncar2dec(importeTotal);
    cuotaTotal=truncar2dec(cuotaTotal);
    
    total=parseFloat(importeTotal)+parseFloat(cuotaTotal);
    total=truncar2dec(total);
        
    importeTotal=formateaNumeroContabilidad2(importeTotal.toString());
    document.form1.totalImporte.value=importeTotal;
        
    cuotaTotal=formateaNumeroContabilidad2(cuotaTotal.toString());
    document.form1.totalCuota.value=cuotaTotal;
        
    total=formateaNumeroContabilidad2(total.toString());
    document.form1.totalTotal.value=total;
}

function asientoCalculoImporte(ObjImporte,ObjIva,ObjCuota,ObjTotal){

    var importe = desFormateaNumeroContabilidad(ObjImporte.value);
    var iva = desFormateaNumeroContabilidad(ObjIva.value);
    
    var cuota = parseFloat(importe) * parseFloat(iva) / 100;
    var total = parseFloat(importe) + parseFloat(cuota);
    
    cuota = truncar2dec(cuota);
    cuota = formateaNumeroContabilidad(cuota.toString());
    ObjCuota.value = cuota;
    
    total = truncar2dec(total);
    total = formateaNumeroContabilidad(total.toString());
    ObjTotal.value = total;
}

//function que renderiza la linea de la factura    
function lineaFactura(linea,idCuenta,cantidad,cuota,total){

var textoiva='<option value="0">0</option>'+
             '<option value="4">4</option>'+
             '<option value="10">10</option>'+
             '<option value="21">21</option>';

<?php
$listadoCuentasContables = $clsCNContabilidad->listarCuentasArticulos();

$txtListado = "";
for ($i = 0; $i < count($listadoCuentasContables); $i++) {
    $txtListado = $txtListado . "<option value='".$listadoCuentasContables[$i]['NumCuenta']."'>".$listadoCuentasContables[$i]['cuenta']."</option>";
}

?>
var listadoCuentas = "<?php echo $txtListado; ?>";
    
var txtLinea='<tr id="linea'+linea+'" class="item-row">'+ 
            '<td valign="top">'+
            '<a class="delete" href="javascript:;" title="Borrar Cuenta"><font color="#FF0000">X</font></a>'+
            '</td>'+
            "<td valign='top'>"+
                '<div class="divFormato">'+
                '<input type="hidden" name="cuenta'+linea+'" value="'+idCuenta+'" />'+
                '<select id="nombreCuenta'+linea+'" name="nombreCuenta'+linea+'" class="textbox1" style="text-align:left;width:100%;" tabindex="'+linea+'1"'+
                        'onChange="copiarCuentaHidden(this,document.form1.cuenta'+linea+')">'+listadoCuentas+
                '</select>'+
                "</div>"+
            "</td>"+
            "<td valign='top'>"+
                '<div class="divFormato" align="left">'+
                '<input class="textbox2" type="text" name="importe'+linea+'" id="importe'+linea+'" maxlength="18" tabindex="'+linea+'2" '+
                       'onkeypress="return solonumerosNeg(event);" style="text-align:right;" value="'+cantidad+'" '+
                       'onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" '+
                       'onfocus="desFormateaCantidad(this);this.select();"'+
                       'onClick="this.select();"'+
                       'onblur="formateaCantidad(this);'+
                               'asientoCalculoImporte(this,document.form1.iva'+linea+',document.form1.cuota'+linea+',document.form1.total'+linea+');sumas();" '+
                       ' />'+
                "</div>"+
            "</td>"+
            "<td valign='top'>"+
                '<div class="divFormato" align="center">'+
                    '<select id="iva'+linea+'" name="iva'+linea+'" class="textbox1" style="text-align:center;font-weight:bold;width:100%;" tabindex="'+linea+'5"'+
                            'onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"'+
                            'onChange="facturaCalculoIVA(document.form1.importe'+linea+',this,document.form1.cuota'+linea+
                               ',document.form1.total'+linea+');sumas();">'+textoiva+
                    '</select>'+
                "</div>"+
            "</td>"+
            "<td valign='top'>"+
                '<div class="divFormato" align="left">'+
                '<input class="textbox2" type="text" name="cuota'+linea+'" id="cuota'+linea+'" maxlength="12" value="'+cuota+'"'+
                       'style="text-align:right;" readonly />'+
                "</div>"+
            "</td>"+
            "<td valign='top'>"+
                '<div class="divFormato" align="left">'+
                '<input class="textbox2" type="text" name="total'+linea+'" id="total'+linea+'" maxlength="12" value="'+total+'"'+
                       'style="text-align:right;" readonly />'+
                "</div>"+
            "</td>"+
        "</tr>";
return txtLinea;
}    

$(document).ready(function() {
<?php
////si venimos de editar tenemos datos en $datosPresupuesto
if(isset($datos['cuentas'])){
    //ejecuto la funcion de javascript 'lineaFactura()' por cada linea
    //y voy sumando el importe y la cuota
    $totalImportePres=0;
    $totalCuotaPres=0;
    for($i=0;$i<count($datos['cuentas']);$i++){
        $idCuenta = $datos['cuentas'][$i]['idCuenta'];
        $nombreCuenta = $datos['cuentas'][$i]['idCuenta'];
        $cantidad = $datos['cuentas'][$i]['lngCantidadContabilidad'];
        $cuota = $datos['cuentas'][$i]['lngIvaContabilidad'];
        $iva = round((float)$datos['cuentas'][$i]['cuota'] / (float)$datos['cuentas'][$i]['cantidad'] * 100,0);
        $total = round((float)$datos['cuentas'][$i]['cantidad'] + (float)$datos['cuentas'][$i]['cuota'],2);
        $IG = $datos['TipoAsiento'];
        if($IG==='15N' || $IG==='15N2' || $IG==='16N' || $IG==='16N2'
           || $IG==='17N' || $IG==='17N2' || $IG==='18N' || $IG==='18N2'){
            $total = formateaNumeroContabilidad($total);
        }else 
        if($IG==='15A' || $IG==='15A2' || $IG==='16A' || $IG==='16A2'
           || $IG==='17A' || $IG==='17A2' || $IG==='18A' || $IG==='18A2'){
            $total = formateaNumeroContabilidad(-$total);
        }
        
        
        
?>
    $("#linea<?php echo $i;?>:last").after(
            lineaFactura(<?php echo $i+1;?>,'<?php echo $idCuenta; ?>','<?php echo $cantidad; ?>','<?php echo $cuota; ?>','<?php echo $total; ?>')
            );
    
    //selected por defecto del nombre de la cuenta y del iva
    $("#nombreCuenta<?php echo $i+1;?>").val('<?php echo $nombreCuenta; ?>');
    $("#iva<?php echo $i+1;?>").val('<?php echo $iva; ?>');
    
<?php
    }
?>
    <?php
    echo "document.form1.linea.value='$i'";
}

?>  
        
  $("#addrow").click(function(){
    var id=$("#lineasFactura tr:last").attr("id");
    $("#"+id+":last").after(
        lineaFactura((parseInt(document.form1.linea.value)+1),'','','','')
    );
    
    
    document.form1.linea.value=parseInt(document.form1.linea.value)+1;
    if ($(".delete").length > 0) $(".delete").show();
    //para que se redimensione los textarea
    $('#concepto'+document.form1.linea.value).autoResize();
  });
  
  
  $(".delete").live('click',function(){
    $(this).parents('.item-row').remove();
    if ($(".delete").length < 1) $(".delete").hide();
    sumas();
  });
  
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
//              formateoColoresCampo('<?php //echo $_GET['esAbono'];?>');
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
    <form id="form1" name="form1" method="post" action="../vista/ingresos_CFIVA1SIRPFVC.php">
        
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
                   value="<?php if(isset($datos)){echo $datos['datFecha'];}else {echo $fechaForm;}?>"
                   <?php if($editarAsiento==='SI') {?>
                   placeholder="<?php if(isset($datos)){echo $datos['datFecha'];}else {echo $fechaForm;}?>" 
                   onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" tabindex="1"
                   onKeyUp="this.value=formateafechaEntrada(this.value);" 
                   onfocus="onFocusInputText(this);<?php if(!isset($datos)){echo 'limpiaCampoFecha(this);';}?>"
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
              <label class="nombreCampo">Cliente<font color="#F0F8FF">...............</font></label>
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
          </td>
        </tr>
        
        <tr>
            <td style="height: 15px;"></td>
        </tr>
    </table>
    <table width="640" border="0" class="zonaactivafactura" id="lineasFactura">
        <tr>
            <td width="2%" class="subtitulo" style="text-align: right;"></td>
            <td width="50%" class="subtitulo">Cuenta(s) de Ingreso</td>
            <td width="19%" class="subtitulo" style="text-align: right;">B. Imponible</td>
            <td width="7%" class="subtitulo" style="text-align: right;">IVA</td>
            <td width="11%" class="subtitulo" style="text-align: right;">Cuota</td>
            <td width="11%" class="subtitulo" style="text-align: right;">Total</td>
        </tr>
        <tr id="linea0"> </tr>
    </table>
    <table width="640" border="0" class="zonaactivafactura" id="lineasFactura">
      <tr id="hiderow">
        <td colspan="5">
            <div align="left">
                <a id="addrow" href="javascript:;" title="Añadir Concepto">Añadir Concepto</a>
            </div>
        </td>
      </tr>
    </table>        
    <table width="640" border="0">
        <tr>
            <td width="2%"></td>
            <td width="50%"></td>
            <td width="19%">
                <input class="textbox1" type="text" name="totalImporte" readonly style="text-align: right;"
                       value="<?php if(isset($datos)){echo $datos['lngCantidadContabilidad'];}else{echo '0,00';} ?>" />
            </td>
            <td width="7%"></td>
            <td width="11%">
                <input class="textbox1" type="text" name="totalCuota" readonly style="text-align: right;" 
                       value="<?php if(isset($datos)){echo $datos['lngIvaContabilidad'];}else{echo '0,00';} ?>" />
            </td>
            <td width="11%">
                <?php
                $totalTotal = $datos['lngCantidad'] + $datos['lngIva'];
                if($datos['TipoAsiento']){
                    //$totalTotal = - $totalTotal;
                    $totalTotal = abs($totalTotal);
                }
                ?>
                <input class="textbox1" type="text" name="totalTotal" readonly  style="text-align: right;"
                       value="<?php if(isset($datos)){echo formateaNumeroContabilidad($totalTotal);}else{echo '0,00';} ?>" />
            </td>
        </tr>
        <tr id="linea0"> </tr>
    </table>
        

        
        
      <table width="640" border="0" class="zonaactiva">
        <tr> 
          <!--<td class="subtitulo" colspan="11">&nbsp;Alta Movimientos - Ingresos</td>-->
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
                     tabindex="" value="<?php if(isset($datos)){echo $datos['lngCantidadContabilidad'];}else{echo '0,00';} ?>"
                     readonly />
              </div>
          </td>
          <td colspan="3">
          </td>
          <td></td>
          <td colspan="2">
              <div align="left">
              <label class="nombreCampo">Realizar Cobro</label>
              <input class="textbox1" type="text" name="lngIvaContabilidad" maxlength="4" readonly
                     style="text-align:right;font-weight:bold;" value="<?php if(isset($datos)){echo $datos['lngIvaContabilidad'];}else{echo '0,00';} ?>" 
                     readonly />
              </div>
          </td>
          <td></td>
          <td colspan="2">
              <div align="left">
                <?php
                if((int)$datos['lngPorcientoIRPF'] === 0){
                ?>
              <label class="nombreCampo">Total Factura</label>
              <input class="textbox1" type="text" name="lngIngresoContabilidad" maxlength="10" style="text-align:right;font-weight:bold;"
                     tabindex="5" value="<?php if(isset($datos)){echo $datos['lngIngresoContabilidad'];}else{echo '0,00';} ?>"
                     readonly />
                <?php
                }
                ?>
              </div>
          </td>
        </tr>
        
<!--        control de presentar IRPF-->

        <?php
        if((int)$datos['lngPorcientoIRPF'] !== 0){
        ?>
        <tr>
          <td colspan="2">
              <div align="left">
              </div>
          </td>
          <td colspan="3">
              <div align="right">
              <label class="nombreCampo">% IRPF<font color="#FFFFFF">...............</font> </label>
              <select name="lngPorcientoIRPF"
                      class="textbox1" style="text-align:right;font-weight:bold;width:50%;" tabindex="13"
                      disabled="true">
                  <?php
                  //preparo el listado del select
                  if(isset($datos)){ //existe IRPF
                    for($i=0;$i<=25;$i++){ //0% al 25%
                        if((int)$datos['lngPorcientoIRPF']==$i){
                            echo "<option value = '$i' selected> $i</option>";
                        }else{
                            echo "<option value = '$i'> $i</option>";
                        }
                    }
                  }else //no existe IRPF, por defecto 21%
                  {
                    for($i=0;$i<=25;$i++){ //0% al 25%
                        if($i===21){
                            echo "<option value = '$i' selected> $i</option>";
                        }else{
                            echo "<option value = '$i'> $i</option>";
                        }
                    }
                  }
                  ?>
              </select>
              </div>
          </td>
          <td></td>
          <td colspan="2">
              <div align="left">
              <label class="nombreCampo">Retención IRPF</label>
              <input class="textbox1" type="text" name="lngIRPFContabilidad" maxlength="4"
                     readonly value="<?php if(isset($datos)){echo $datos['lngIRPFContabilidad'];}else{echo '0,00';} ?>"
                     style="text-align:right;font-weight:bold;" />
              </div>
          </td>
          <td></td>
          <td colspan="2">
              <div align="left">
              <label class="nombreCampo">Total Factura</label>
              <input class="textbox1" type="text" name="lngIngresoContabilidad" maxlength="10" style="text-align:right;font-weight:bold;"
                     tabindex="5" value="<?php if(isset($datos)){echo $datos['lngIngresoContabilidad'];}else{echo '0,00';} ?>"
                     readonly />
              </div>
          </td>
        </tr>
        <?php
        }
        ?>
        
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
                <label class="nombreCampo">Cobrar Ingreso</label>
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
        </script>
        <input type="button" class="button" name="cmdAlta" id="cmdAlta" value = "Grabar" onclick="javascript:validar();" tabindex="9" /> 
        <input class="buttonAzul" type="button" value="Volver" onclick="volver();" />
        <?php if($editarAsiento==='SI') {?>
        <?php if(isset($_GET['editar']) && $_GET['editar']==='SI'){echo '<input type="button" class="buttonAzul"  value="Eliminar" name="cmdBorrar" onclick="javascript:borrarAsiento('.$_GET['Asiento'].');" />';} ?>  
<!--        <input type="Reset" class="button" value="<?php //if(isset($_GET['editar']) && $_GET['editar']==='SI'){echo 'Datos Iniciales';}else{echo 'Vaciar Datos';} ?>" name="cmdReset" tabindex="10" />-->
        <input type="hidden"  name="cmdAlta" <?php if(isset($_GET['editar']) && $_GET['editar']==='SI'){echo 'value="Editar"';}else{echo 'value="Alta"';} ?>  />
        <input type="hidden"  name="esAbono" value="<?php if(isset($_GET['esAbono'])){echo $_GET['esAbono'];}else{echo 'NO';} ?>" />
        <?php if(isset($_GET['editar']) && $_GET['editar']==='SI'){echo '<input type="hidden"  name="Asiento" value="'.$_GET['Asiento'].'" />';} ?>  
        <?php } ?>
      </P>
      <input type="hidden" name="linea" value="0" />     
      <input type="hidden" name="TipoAsiento" value="<?php echo $datos['TipoAsiento']; ?>" />     
      <input type="hidden" name="porcientoIRPF" value="<?php echo $datos['lngPorcientoIRPF']; ?>" />     
        
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