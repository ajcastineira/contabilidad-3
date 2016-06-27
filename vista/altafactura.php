<?php
session_start ();
require_once '../CN/clsCNContabilidad.php';
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
$clsCNContabilidad->setStrBD($_SESSION['dbContabilidad']);
$clsCNContabilidad->setStrBDCliente($_SESSION['mapeo']);

//veo el tipo de factura (dato guardado en "tbparametros_generales")
$tipoFactura = $clsCNContabilidad->Parametro_general('Factura Tipo',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));

//esta opcion de autocomplete de articulos del concepto, esta habilitada si esta en
//parametros generales la variable 'articulos' en 'on'
$tieneArticulos = $clsCNContabilidad->Parametro_general('articulo', date('Y-m-d H:i:s'), date('Y-m-d H:i:s'));

$cuentaContable = $clsCNContabilidad->Parametro_general('cuentaContable', date('Y-m-d H:i:s'), date('Y-m-d H:i:s'));

//Iva Generico
$IvaGenerico = $clsCNContabilidad->Parametro_general('IvaGenerico',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));

//funcion del combo del IVA-IRPF
function listadoIVA($irpf,$estado){
    //comprobamos si esta o no contabilizada la factura
    if($estado==='Contabilizada'){
        echo "<option value = '$irpf' selected> $irpf</option>";
    }else{
        //preparo el listado del select
        $irfs=[0,9,14,21];
        $irpfExisteListado='NO';
        for($i=0;$i<count($irfs);$i++){
            if($irpf==$irfs[$i]){
                $irpfExisteListado='SI';
                echo "<option value = '$irfs[$i]' selected> $irfs[$i]</option>";
            }else{
                echo "<option value = '$irfs[$i]'> $irfs[$i]</option>";
            }
        }

        //si $irpfExisteListado='NO' entonces incluimos este IRPF (esun IRPF antiguo)
        if($irpfExisteListado==='NO'){
            echo "<option value = '$irpf' selected> $irpf</option>";
        }
    }
}

//extraemos los datos de nuestra empresa
$datosNuestraEmpresa=$clsCNContabilidad->datosNuestraEmpresaPresupuesto();

//codigo principal
if(isset($_POST['IdFactura'])){
    
    //var_dump($_POST);die;
    
    //a pulsado aceptar, si viene POST[IdPresupuesto] = 'Nuevo' es nuevo si llega numero es editar
    if($_POST['IdFactura'] === 'Nuevo' && !isset($varRes)){
        logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " ||||Mis Facturas->Alta|| Ha pulsado 'Aceptar'");
        
        $varRes=$clsCNContabilidad->AltaFactura($_SESSION['usuario'],$_POST);
        
    }else{
        logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " ||||Mis Facturas->Actualizar|| Ha pulsado 'Actualizar'");
        
        $varRes=$clsCNContabilidad->EditarFactura($_SESSION['usuario'],$_POST);
    }
    
    //voy a una pagina intermedia que me volvera a enviar aqui, asi no podran recargar la pagina
    if($varRes === false || $varRes === 'false'){
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/error.php?id='.$varRes.'">';die;
    }else{
        if($tieneArticulos === 'on'){
            //ahora compruebo si hay algun articulo que no este guardado(campo IdArticulo=NULL)
            //cuando IdArticulo=numero es un articulo y si IdArticulo=0 no es articulo
            //extraigo un array con los datos
            $datosPresupuesto = $clsCNContabilidad->datosFactura($varRes);

            $lineasArticulosSinGuardar = '';
            if(is_array($datosPresupuesto)){
                //tiene IdArticulo=NULL o IdArticulo=vacio
                //cargamos la pagina donde sale un listado con las lineas de los conceptos
                for ($i = 0; $i < count($datosPresupuesto['DetalleFactura']); $i++) {
                    if(!isset($datosPresupuesto['DetalleFactura'][$i]['IdArticulo']) || $datosPresupuesto['DetalleFactura'][$i]['IdArticulo'] === ''){
                        $lineasArticulosSinGuardar[] = $datosPresupuesto['DetalleFactura'][$i];
                    }
                }
            }

            if(is_array($lineasArticulosSinGuardar)){
                //controlamos si la respuesta es aceptar=SI o cancelar=NO
                //Si es SI se va a la pagina 'articulosSinGuardar.php'
                if($_POST['guardarArticulosNuevos'] === 'SI'){
                    //compruebo si este array ($lineasArticulosSinGuardar) tiene datos (es array)
                        //entonces hay articulos sin guardar,
                        //por lo que redireccionamos a la pagina 'articulosSinGuardar.php'
                        //llevando este array por session
                        $_SESSION['lineasArticulosSinGuardar'] = $lineasArticulosSinGuardar;
                        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/articulosSinGuardar.php?fid='.$varRes.'">';die;
                }else if($_POST['guardarArticulosNuevos'] === 'NO'){
                    //Si es NO se ponen todos estos IdArticulo a 0 en la factura
                    $clsCNContabilidad->PonerIdArticuloACeroFactura($varRes);
                    //y continua el flujo
                }
            }
        }
        
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/exitoInsertado_factura.php?id='.$varRes.'&pant='.$_POST['pant'].'">';die;
    }
    
}
    
//venimos del menu principal alta o Modificacion/Duplicar/Borrar o de Facturar Presupuesto
if(isset($_GET['IdFactura'])){
    logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
           " ||||Mis Facturas->Modificacion/Duplicar/Baja||");

    $datosPresupuesto=$clsCNContabilidad->datosFactura($_GET['IdFactura']);
    
    if($datosPresupuesto['Borrado']==='0'){
        //esta factura esta borrada por lo que volvemos al menu
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/default2.php">';die;
    }
    
    //compruebo si vengo de duplicar
    if(isset($_GET['duplicar']) && $_GET['duplicar']==='si'){
        //generamos en la BBDD una factura copiando los datos de este
        $numeroNuevaFactura = $clsCNContabilidad->NumeroNuevaFactura();
        $tipoContador=$clsCNContabilidad->Parametro_general('Tipo Contador',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));
        
        //preparo el numero de la forma '20140005' para guardar
        $numFactura = numeroFormateado($numeroNuevaFactura,$tipoContador);
        
        $FacturaDuplicada = $clsCNContabilidad->datosDuplicarFactura($_GET['IdFactura'],$numFactura);
        if($FacturaDuplicada === 'false'){
            echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/error.php?id=No se a podido duplicar la factura">';die;
        }else{
            echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/altafactura.php?IdFactura='.$FacturaDuplicada.'">';die;
        }
    }
    
//}else if(isset($_GET['IdContacto'])){
    
}else{
    logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
           " ||||Mis Facturas->Alta||");
    $numeroNuevaFactura = $clsCNContabilidad->NumeroNuevaFactura();
    //$tipoContador=$clsCNContabilidad->Parametro_general('Tipo Contador',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));
}
$tipoContador=$clsCNContabilidad->Parametro_general('Tipo Contador',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));
$numFacturaBBDD = numeroFormateado($numeroNuevaFactura,$tipoContador);

//extraigo el listado de clientes
$listadoClientes = $clsCNContabilidad->listadoClientes();

//ordeno esta lista
$aux = '';
foreach ($listadoClientes as $key => $row) {
    $aux[$key] = $row['NombreEmpresa'];
}
array_multisort($aux, SORT_ASC, $listadoClientes);


//ahora preparo la consulta select (las opciones)
//si la factura esta contabilizadad solo aparece el cliente actual (no se puede cambiar)
if($datosPresupuesto['Estado']==='Contabilizada'){
    $htmlSelect='';
    if(is_array($listadoClientes)){
        foreach($listadoClientes as $contacto){
            $value=$contacto['NumCuenta'];
            $texto=$contacto['NombreEmpresa'];
            //comprobamos si venimos de editar (existe la vble $datosFactura[Cliente]
            $contactoCliente=$value;
            if($contactoCliente==$datosPresupuesto['Cliente']){
                $htmlSelect=$htmlSelect."<option value='$contactoCliente' selected>$texto</option>";
            }
        }
    }
}else{
    $htmlSelect='';
    $htmlSelect=$htmlSelect.'<option value=""></option>';
    $htmlSelect=$htmlSelect.'<option value="Nuevo">Nuevo...</option>';
    if(is_array($listadoClientes)){
        foreach($listadoClientes as $contacto){
            $value=$contacto['NumCuenta'];
            $texto=$contacto['NombreEmpresa'];
            //comprobamos si venimos de editar (existe la vble $datosFactura[Cliente]
            $contactoCliente=$value;

            if($contactoCliente==$datosPresupuesto['Cliente']){
                $htmlSelect=$htmlSelect."<option value='$contactoCliente' selected>$texto</option>";
            }else{
                $htmlSelect=$htmlSelect."<option value='$contactoCliente'>$texto</option>";
            }
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
<?php
//estas funciones son generales
librerias_jQuery();
eventosInputText();
?>
<link rel="stylesheet" type="text/css" media="all" href="../js/jQuery/fancybox/style.css">
<link rel="stylesheet" type="text/css" media="all" href="../js/jQuery/fancybox/jquery.fancybox.css">
<script type="text/javascript" src="../js/jQuery/fancybox/jquery.fancybox.js?v=2.0.6"></script>
<script type="text/javascript" src="../js/jQuery/autoresize/textareaAutoResize.js"></script>

<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../images/q.ico">
<TITLE><?php if(isset($_GET['IdFactura'])){echo 'Factura - EDITAR';}else{echo 'Factura - ALTA';}?></TITLE>

<SCRIPT type="text/javascript" Language="JavaScript"> 

function validar2(esValido,guardarArticulosNuevos)
{
  esValido.value=true;
  textoError='';
  
    //revisamos toda la tabla de lineas de factura, hay que revisar cantidad, precio,
    // importe que se cumpla importe = cantidad x precio
    var cantidades=new Array();
    var precios=new Array();
    var importes=new Array();
    var conceptos=new Array();
    $(document).ready(function(){
        $('#form1').find(":input").each(function(){
            var elemento=this;
            //comprobamos el nombre del elemento y lo guardamos en ua array segun sea cantidad, precio, importe y concepto
            var nombreElemento=elemento.name;
            if(nombreElemento.substring(0,8)==='cantidad'){//es un elemento cantidad
                cantidades[nombreElemento.substr(8,3)]=elemento.value;
            }else 
            if(nombreElemento.substring(0,6)==='precio'){//es un elemento precio
                precios[nombreElemento.substr(6,3)]=elemento.value;
            }else
            if(nombreElemento.substring(0,7)==='importe'){//es un elemento importe
                importes[nombreElemento.substr(7,3)]=elemento.value;
            }else            
            if(nombreElemento.substring(0,8)==='concepto'){//es un elemento concepto
                conceptos[nombreElemento.substr(8,3)]=elemento.value;
            }else
            //compruebo si IdArticulo esta NULL o vacio
            if(nombreElemento.substring(0,10)==='IdArticulo'){//es un elemento IdArticulo
                if(elemento.value === '' || elemento.value === 'null'){
                    //es una vble. hidden del formulario
                    guardarArticulosNuevos.value = 'SI';
                }
            }
        });
    });
    //compruebo que los arrays lleven datos (lentgh)
    //si fuese 0 es que no se a introducido ninguna linea de factura y eso es incongruente
    if(cantidades.length===0){
        textoError=textoError+"Debe introducidir alguna linea en el presupuesto.\n";
        esValido.value='false';
    }
    
    
    var falloComp='NO';
    var falloImporte0='NO';
    var falloConceptoVacio='NO';
    
    for(i=0;i<cantidades.length;i++){
        //comprobamos que este control existe
        if(typeof cantidades[i] !== 'undefined' && cantidades[i]!=='null'){
            if(isNaN(parseFloat(desFormateaNumeroContabilidad(precios[i]))) || isNaN(parseFloat(desFormateaNumeroContabilidad(cantidades[i])))){
            }else{
                //importe no sea 0
                var importeNumero=parseFloat(desFormateaNumeroContabilidad(importes[i]));
                if(importeNumero===0){
                    var importe='importe'+i;
                    document.getElementById(importe).style.borderColor='#FF0000';
                    esValido.value='false';
                    falloImporte0='SI';
                }
                
                //importe no este vacio
                if(conceptos[i]===''){
                    var concepto='concepto'+i;
                    document.getElementById(concepto).style.borderColor='#FF0000';
                    esValido.value='false';
                    falloConceptoVacio='SI';
                }
                
                //compruebo que importe= cantidad x precio en esta linea
                if(cantidades[i]===0 || precios[i]===0 || cantidades[i]==='0,00' || precios[i]==='0,00' ||
                   cantidades[i]==='' || precios[i]===''){
                    //nada
                }else{
                    var importeComp=parseFloat(desFormateaNumeroContabilidad(cantidades[i]))*parseFloat(desFormateaNumeroContabilidad(precios[i]));
                    importeComp=truncar2dec(importeComp);
                    if(importeComp!==importeNumero){
                        var cantidad='cantidad'+i;
                        document.getElementById(cantidad).style.borderColor='#FF0000';
                        var precio='precio'+i;
                        document.getElementById(precio).style.borderColor='#FF0000';
                        var importe='importe'+i;
                        document.getElementById(importe).style.borderColor='#FF0000';
                        esValido.value='false';
                        falloComp='SI';
                    }
                }
            }
        }
    }
    
    //compruebo si esValido.value viene en false, si es asi indico el error
    if(esValido.value==='false'){
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
    
  //comprobacion del campo 'Contacto'
  if (document.form1.Contacto.value === ''){ 
    textoError=textoError+"Es necesario introducir un cliente.\n";
//    document.form1.Contacto.style.borderColor='#FF0000';
    document.form1.Contacto.title ='Se debe introducir un cliente';
    esValido.value=false;
  }
  //comprobacion del campo 'numPresupuesto'
  if (document.form1.numPresupuesto.value === ''){ 
    textoError=textoError+"Es necesario introducir un número de factura.\n";
    document.form1.numPresupuesto.style.borderColor='#FF0000';
    document.form1.numPresupuesto.title ='Se debe introducir un número de factura';
    esValido.value=false;
  }
  
  
  //indicar el mensaje de error si es 'esValido.value'='false'
  if (esValido.value==='false'){
      if(textoError===''){textoError='Revise los datos. NO estan correctos';}
      alert(textoError);
  }

  if(esValido.value==='true'){
      if(guardarArticulosNuevos.value === 'SI'){
        if (confirm("Ha incluido usted articulos nuevos, ¿desea añadirlos a la base de datos? (Aceptar = SI, Cancelar = NO)"))
        {
            document.form1.guardarArticulosNuevos.value='SI';
        }
        else
        {
            document.form1.guardarArticulosNuevos.value='NO';
        }
      }
      document.getElementById("cmdAlta").value = "Enviando...";
      document.getElementById("cmdAlta").disabled = true;
      document.form1.submit();
  }else{
      return false;
  }  
}

function rellenarDatos(objeto,opcion){
    if(objeto==='Nuevo'){
        location.href="../vista/altacliprov.php?tipo=cliente";
    }else{
        var dividirTexto=objeto.split(".");
        var tipo=dividirTexto[0];
        var numero=dividirTexto[1];

        $.ajax({
          data:{"q":tipo,"numero":numero},  
          url: '../vista/ajax/datosCliente.php',
          type:"get",
          success: function(data) {
            var cliente = JSON.parse(data);
            $('#Cliente').val(cliente.Cliente);
            $('#CIF').val(cliente.CIF);
            $('#direccion').val(cliente.direccion);
            $('#poblacion').val(cliente.poblacion);
            $('#provincia').val(cliente.provincia);
            $('#email').val(cliente.Correo);
            $('#emailCC').val(cliente.Correo2);
            if(opcion==='Nuevo'){
                $('#FormaPagoHabitual').val(cliente.FormaPagoHabitual);
            }
          }
        });
    }
}

//sumas de los importes, cuotas y totales
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
                importeTotal=parseFloat(importeTotal)+parseFloat(desFormateaNumeroContabilidad(elemento.value));
            }            
            if(nombreElemento.substring(0,5)==='cuota'){//es un elemento cuota
                cuotaTotal=parseFloat(cuotaTotal)+parseFloat(desFormateaNumeroContabilidad(elemento.value));
            }            
        });
    });
    
    importeTotal=truncar2dec(importeTotal);
    cuotaTotal=truncar2dec(cuotaTotal);
    
    total=parseFloat(importeTotal)+parseFloat(cuotaTotal);
    total=truncar2dec(total);
        
    importeTotal=formateaNumeroContabilidad(importeTotal.toString());
    document.form1.totalImporte.value=importeTotal;
        
    cuotaTotal=formateaNumeroContabilidad(cuotaTotal.toString());
    document.form1.totalCuota.value=cuotaTotal;
        
    total=formateaNumeroContabilidad(total.toString());
    document.form1.total.value=total;
    
    //irpf
    facturaCalculoIRPF(document.form1.totalImporte,document.form1.total,document.form1.irpf,document.form1.IRPFcuota,document.form1.totalFinal);
}

//borrar Asiento
function borrarFactura(id){
    if (confirm("¿Desea borrar la Factura de la base de datos?"))
    {
        window.location='../vista/facturaBorrar.php?id='+id;
    }
}

//formateo de numeros
function formateaCantidad(objeto){
    objeto.value=formateaNumeroContabilidad2(objeto.value);
}    

function desFormateaCantidad(objeto){
    objeto.value=desFormateaNumeroContabilidad2(objeto.value);
}    

function copiaHidden(precio,precioHidden){
    //guardo el valor del hidden
    precioHidden.value=precio.value;
}

function desFormateaCantidadHidden(precio,precioHidden){
    //cojo el valor del hidden
    precio.value=precioHidden.value;
}

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

function salir(){
    window.location='../vista/default2.php';
}


function Imprimir(i){
    if(document.form1.SePuedeImprimir.value==='SI'){    
        var datos=preparaURL(i,'imprimir');
        
        window.open("../vista/facturaImprimir<?php echo $tipoFactura; ?>.php?"+datos, '', 'scrollbars=yes,menubar=no,height=600,width=800,resizable=yes,toolbar=no,status=no,location=no');
    }else{
        alert('No se puede ver el PDF sin haber guardado la factura');
    }
}

function Enviar(i){
    if(document.form1.SePuedeImprimir.value==='SI'){    
        var datos=preparaURL(i,'enviar');
        
        //aparece el formulario emergente
        $(".modalbox").fancybox();

        $.ajax({
          url: '../vista/facturaImprimir<?php echo $tipoFactura; ?>.php?'+datos,
          type:"get"
        });
    }else{
        alert('No se puede enviar el PDF sin haber guardado la factura');
    }
}

function EnviarForm(){
  esValido=true;
  textoError='';
    
    //comprobacion del campo 'email'
    if (document.contact.email.value === ''){
          textoError=textoError+"Debe introducir datos en el campo Para.\n";
          document.contact.email.style.borderColor='#FF0000';
          document.contact.email.title ='Debe introducir datos en el campo Para';
          esValido=false;
    }else{
      //compruebo que el e-mail tenga un formato correcto 'admin@admin.com'  
      expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      if ( !expr.test(document.contact.email.value) ){
          textoError=textoError+"El E-mail del campo '" + document.contact.email.value + "' es incorrecto.\n";
          document.contact.email.style.borderColor='#FF0000';
          document.contact.email.title ='El E-mail del campo Para es incorrecto';
          esValido=false;
      }
    }
    
    //comprobacion del campo 'emailCC'
    if (document.contact.emailCC.value === ''){
    }else{
      //compruebo que el e-mail tenga un formato correcto 'admin@admin.com'  
      expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      if ( !expr.test(document.contact.emailCC.value) ){
          textoError=textoError+"El E-mail del campo C.C. '" + document.contact.emailCC.value + "' es incorrecto.\n";
          document.contact.emailCC.style.borderColor='#FF0000';
          document.contact.emailCC.title ='El E-mail del campo C.C. es incorrecto';
          esValido=false;
      }
    }
    
    
    if(esValido===true){
        document.contact.submit();
    }else{
        if(textoError===''){textoError='Revise los datos. NO estan correctos';}
        alert(textoError);
        return false;
    }  
}

function preparaURL(i,opcion){
        var datos='IdFactura=<?php echo $_GET['IdFactura']; ?>';
        datos=datos+'&opcion='+opcion;
        
        datos=encodeURI(datos);
        return datos;
}

function DesactivaImprimir(){
    document.form1.SePuedeImprimir.value='NO';
}

function ComprobarPresupuesto(objeto){
    var IdFactura='<?php if(isset($_GET['IdFactura'])){echo $_GET['IdFactura'];}else{echo 'NO';}?>';
    $.ajax({
      data:{"numP":objeto.value,"IdFactura":IdFactura},  
      url: '../vista/ajax/ComprobarNumeroFactura.php',
      type:"get",
      success: function(data) {
        if(data==='SI'){
            alert('Este número de factura EXISTE.');
            objeto.focus();
        }
      }
    });
}

function SiEsContado(objeto){
    if(objeto.value==='Contado'){
        document.form1.validez.value='';
        document.form1.validez.setAttribute("readonly" , "readonly" , false);
    }else{
        document.form1.validez.removeAttribute("readonly"  , false);
    }
}


function SiEsArticuloRellenar(concepto,IdArticulo,cuenta,cantidad,precio,precioHidden,importe,iva,cuota,total,esValido){
if(IdArticulo.value === 'null'){
<?php
    if($tieneArticulos === 'on'){
        $cuenta = $clsCNContabilidad->Parametro_general('cuentaContable',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));
        ?>

        //busco si existe este articulo y me traigo sus datos
        $.ajax({
            data:{"articulo":concepto.value,"cuenta":<?php echo $cuenta; ?>},  
            url: '../vista/ajax/datos_articulo.php',
            type:"get",
            success: function(data) {
                var datos = JSON.parse(data);
                //si hay datos actualizamos en todos los campos de esta linea con los datos que viene de AJAX
                if(!$.isEmptyObject(datos)){
                    //compruebo qsi existe esta propiedad del objeto, si es asi actualizo ese campo
                    if(datos.precio){
                        $(precioHidden).val(datos.precio);
                    }
                    if(datos.tipoIVA){
                        $(iva).val(datos.tipoIVA);
                    }
                    if(datos.Id){
                        $(IdArticulo).val(datos.Id);
                    }
                    if(datos.CuentaContable){
                        $(cuenta).val(datos.CuentaContable);
                    }
                    
                    facturaCalculoPrecio(cantidad,precio,precioHidden,importe,iva,cuota,total,esValido);
                    sumas();
                //sino 
                }else{
                    $(precioHidden).val(desFormateaNumeroContabilidad(precio.value));
                }
            
                //ir a precio (focus)
                $(precio).focus();
            }
        });
        <?php
    }else{
    ?>
    //solo indicamos que el IdArticulo es 0
    $(IdArticulo).val('0');
    <?php
    }
?>
}
}

</script>

<script type="text/javascript" Language="JavaScript"> 
//function que renderiza la linea de la factura    
function lineaFactura(linea,idPresupLinea,numLineaPresup,idPedidoLinea,numLineaPedido,cantidad,concepto,precio,importe,iva,cuota,total,IdArticulo,cuenta){

var precioHidden = desFormateaNumeroContabilidad(precio);
var cantidadHidden = desFormateaNumeroContabilidad(cantidad);

<?php
if($datosPresupuesto['Estado']==='Contabilizada'){
?>
    if(iva==='0,00'){
        var textoiva='<option value="0" selected>0</option>';
    }else if(iva==='4,00'){
        var textoiva='<option value="4" selected>4</option>>';
    }else if(iva==='10,00'){
        var textoiva='<option value="10" selected>10</option>';
    }else if(iva==='16,00'){
        var textoiva='<option value="16" selected>16</option>';
    }else if(iva==='18,00'){
        var textoiva='<option value="18" selected>18</option>';
    }else if(iva==='21,00'){
        var textoiva='<option value="21" selected>21</option>';
    }else{
        var textoiva='<option value="21" selected>21</option>';
    }
<?php
}else{ 
?>
if(iva==='0,00' || iva==='0'){
var textoiva='<option value="0" selected>0</option>'+
             '<option value="4">4</option>'+
             '<option value="10">10</option>'+
             '<option value="16">16</option>'+
             '<option value="18">18</option>'+
             '<option value="21">21</option>'
}else if(iva==='4,00' || iva==='4'){
var textoiva='<option value="0">0</option>'+
             '<option value="4" selected>4</option>'+
             '<option value="10">10</option>'+
             '<option value="16">16</option>'+
             '<option value="18">18</option>'+
             '<option value="21">21</option>'
}else if(iva==='10,00' || iva==='10'){
var textoiva='<option value="0">0</option>'+
             '<option value="4">4</option>'+
             '<option value="10" selected>10</option>'+
             '<option value="16">16</option>'+
             '<option value="18">18</option>'+
             '<option value="21">21</option>'
}else if(iva==='16,00' || iva==='16'){
var textoiva='<option value="0">0</option>'+
             '<option value="4">4</option>'+
             '<option value="10">10</option>'+
             '<option value="16" selected>16</option>'+
             '<option value="18">18</option>'+
             '<option value="21">21</option>'
}else if(iva==='18,00' || iva==='18'){
var textoiva='<option value="0">0</option>'+
             '<option value="4">4</option>'+
             '<option value="10">10</option>'+
             '<option value="16">16</option>'+
             '<option value="18" selected>18</option>'+
             '<option value="21">21</option>'
}else if(iva==='21,00' || iva==='21'){
var textoiva='<option value="0">0</option>'+
             '<option value="4">4</option>'+
             '<option value="10">10</option>'+
             '<option value="16">16</option>'+
             '<option value="18">18</option>'+
             '<option value="21" selected>21</option>'
}else{
var textoiva='<option value="0">0</option>'+
             '<option value="4">4</option>'+
             '<option value="10">10</option>'+
             '<option value="16">16</option>'+
             '<option value="18">18</option>'+
             '<option value="21" selected>21</option>'
}
<?php
} 
?>
    
    
var txtLinea='<tr id="linea'+linea+'" class="item-row">'+ 
            '<td valign="top">'+
            <?php
            if($datosPresupuesto['Estado']<>'Contabilizada'){
            ?>
            '<a class="delete" href="javascript:;" title="Borrar Linea"><font color="#FF0000">X</font></a>'+
            <?php
            }
            ?>
            '</td>'+
            "<td valign='top'>"+
                '<div class="divFormato">'+
                '<input type="hidden" name="idPresupLinea'+linea+'" value="'+idPresupLinea+'" />'+
                '<input type="hidden" name="numLineaPresup'+linea+'" value="'+numLineaPresup+'" />'+
                '<input type="hidden" name="idPedidoLinea'+linea+'" value="'+idPedidoLinea+'" />'+
                '<input type="hidden" name="numLineaPedido'+linea+'" value="'+numLineaPedido+'" />'+
                '<input class="textbox2" type="text" name="cantidad'+linea+'" id="cantidad'+linea+'" maxlength="12" tabindex="'+linea+'1" '+
                       'onkeypress="return solonumeros(event);" style="text-align:right;" value="'+cantidad+'" '+
                       'onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" '+
                       'onkeypress="DesactivaImprimir();" onkeyup="DesactivaImprimir();" '+
                       'onfocus="desFormateaCantidad(this);this.select();"'+
                       'onClick="this.select();" '+
                       'onblur="copiaHidden(this,cantidadHidden'+linea+');formateaCantidad(this);'+
                               'facturaCalculoCantidad(this,document.form1.precioHidden'+linea+',document.form1.importe'+linea+','+
                               'document.form1.iva'+linea+',document.form1.cuota'+linea+',document.form1.total'+linea+');sumas();"'+
                       '<?php if($datosPresupuesto['Estado']==='Contabilizada'){echo 'readonly';} ?> />'+
                '<input type="hidden" id="cantidadHidden'+linea+'" name="cantidadHidden'+linea+'" value="'+cantidadHidden+'">'+
                "</div>"+
            "</td>"+
            "<td valign='top'>"+
                '<div align="left">'+
                  '<textarea class="textbox1area" name="concepto'+linea+'" id="concepto'+linea+'" tabindex="'+linea+'2" '+
                        'cols="20" rows="0" onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" '+
                        'onkeypress="DesactivaImprimir();return facturasCaracteresDescartados(event);" onkeyup="DesactivaImprimir();" '+
                        'onfocus="" onblur="SiEsArticuloRellenar(this,IdArticulo'+linea+',cuenta'+linea+',cantidadHidden'+linea+',precio'+linea+',precioHidden'+linea+',importe'+linea+',iva'+linea+',cuota'+linea+',total'+linea+',document.form1.esValido);">'+concepto+'</textarea>'+ 
                '<input type="hidden" id="IdArticulo'+linea+'" name="IdArticulo'+linea+'" value="'+IdArticulo+'">'+
                '<input type="hidden" id="cuenta'+linea+'" name="cuenta'+linea+'" value="'+cuenta+'">'+
                "</div>"+
            "</td>"+
            "<td valign='top'>"+
                '<div class="divFormato" align="left">'+
                '<input class="textbox2" type="text" name="precio'+linea+'" id="precio'+linea+'" maxlength="12" tabindex="'+linea+'3" '+
                       'onkeypress="return solonumerosNeg(event);" style="text-align:right;" value="'+precio+'" '+
                       'onkeypress="DesactivaImprimir();" onkeyup="DesactivaImprimir();" '+
                       'onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" '+
                       'onfocus="desFormateaCantidadHidden(this,precioHidden'+linea+');this.select();"'+
                       'onClick="this.select();"'+
                       'onblur="copiaHidden(this,precioHidden'+linea+');'+
                               'facturaCalculoPrecio(document.form1.cantidadHidden'+linea+',this,document.form1.precioHidden'+linea+',document.form1.importe'+linea+
                               ',document.form1.iva'+linea+',document.form1.cuota'+linea+',document.form1.total'+linea+',document.form1.esValido);formateaCantidad(this);sumas();" '+
                       '<?php if($datosPresupuesto['Estado']==='Contabilizada'){echo 'readonly';} ?> />'+
                '<input type="hidden" id="precioHidden'+linea+'" name="precioHidden'+linea+'" value="'+precioHidden+'">'+
                "</div>"+
            "</td>"+
            "<td valign='top'>"+
                '<div class="divFormato" align="left">'+
                '<input class="textbox2" type="text" name="importe'+linea+'" id="importe'+linea+'" maxlength="12" tabindex="'+linea+'4" '+
                       'onkeypress="return solonumerosNeg(event);" style="text-align:right;" value="'+importe+'" '+
                       'onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" '+
                       'onkeypress="DesactivaImprimir();" onkeyup="DesactivaImprimir();" '+
                       'onfocus="desFormateaCantidad(this);this.select();"'+
                       'onClick="this.select();"'+
                       'onblur="formateaCantidad(this);'+
                               'facturaCalculoImporte(document.form1.cantidad'+linea+',document.form1.precio'+linea+',this,'+
                               'document.form1.iva'+linea+',document.form1.cuota'+linea+',document.form1.total'+linea+',document.form1.esValido);sumas();" '+
                       '<?php if($datosPresupuesto['Estado']==='Contabilizada'){echo 'readonly';} ?> />'+
                "</div>"+
            "</td>"+
            "<td valign='top'>"+
                '<div class="divFormato" align="center">'+
                    '<select id="iva'+linea+'" name="iva'+linea+'" class="selectFactura" style="text-align:center;font-weight:bold;width:100%;" tabindex="'+linea+'5"'+
                            'onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"'+
                            'onChange="facturaCalculoIVA(document.form1.importe'+linea+',this,document.form1.cuota'+linea+
                               ',document.form1.total'+linea+');sumas();DesactivaImprimir();">'+textoiva+
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
if(isset($datosPresupuesto)){
    //ejecuto la funcion de javascript 'lineaFactura()' por cada linea
    //y voy sumando el importe y la cuota
    $totalImportePres=0;
    $totalCuotaPres=0;
    for($i=0;$i<count($datosPresupuesto['DetalleFactura']);$i++){
        $idPresupLinea = $datosPresupuesto['DetalleFactura'][$i]['IdPresupLineas'];
        $numLineaPresup = $datosPresupuesto['DetalleFactura'][$i]['NumLineaPresup'];
        $idPedidoLinea = $datosPresupuesto['DetalleFactura'][$i]['IdPedidoLineas'];
        $numLineaPedido = $datosPresupuesto['DetalleFactura'][$i]['NumLineaPedido'];
        $cantidadPres = formateaNumeroContabilidad($datosPresupuesto['DetalleFactura'][$i]['cantidad']);
        $conceptoPres = $datosPresupuesto['DetalleFactura'][$i]['concepto'];
        $precioPres = formateaNumeroContabilidad($datosPresupuesto['DetalleFactura'][$i]['precio']);
        $importePres = formateaNumeroContabilidad($datosPresupuesto['DetalleFactura'][$i]['importe']);
        $ivaPres = formateaNumeroContabilidad($datosPresupuesto['DetalleFactura'][$i]['iva']);
        $cuotaPres = formateaNumeroContabilidad($datosPresupuesto['DetalleFactura'][$i]['cuota']);
        $totalPres = formateaNumeroContabilidad($datosPresupuesto['DetalleFactura'][$i]['importe']+$datosPresupuesto['DetalleFactura'][$i]['cuota']);
        $totalImportePres = $totalImportePres+$datosPresupuesto['DetalleFactura'][$i]['importe'];
        $totalCuotaPres = $totalCuotaPres+$datosPresupuesto['DetalleFactura'][$i]['cuota'];
        if(isset($datosPresupuesto['DetalleFactura'][$i]['IdArticulo'])){
            $IdArticulo = $datosPresupuesto['DetalleFactura'][$i]['IdArticulo'];
        }else{
            $IdArticulo = '';
        }
        if(isset($datosPresupuesto['DetalleFactura'][$i]['cuentaArticulo'])){
            $cuenta = $datosPresupuesto['DetalleFactura'][$i]['cuentaArticulo'];
        }else{
            $cuenta = $cuentaContable;
        }
?>
    $("#linea<?php echo $i;?>:last").after(
            lineaFactura(<?php echo $i+1;?>,<?php echo $idPresupLinea; ?>,<?php echo $numLineaPresup; ?>,<?php echo $idPedidoLinea; ?>,<?php echo $numLineaPedido; ?>,'<?php echo $cantidadPres; ?>','<?php echo str_replace(array("\r\n","\r","\n"),'\n',$conceptoPres); ?>','<?php echo $precioPres; ?>','<?php echo $importePres; ?>',
                         '<?php echo $ivaPres; ?>','<?php echo $cuotaPres; ?>','<?php echo $totalPres; ?>','<?php echo $IdArticulo; ?>','<?php echo $cuenta; ?>')
    );

    //para que se redimensione los textarea
    $('#concepto<?php echo $i+1;?>').autoResize();
<?php
    }
    ?>
    //actualizo las sumas del subtotal
    document.form1.totalImporte.value='<?php echo formateaNumeroContabilidad($totalImportePres);?>';
    document.form1.totalCuota.value='<?php echo formateaNumeroContabilidad($totalCuotaPres);?>';
    document.form1.total.value='<?php echo formateaNumeroContabilidad($totalImportePres+$totalCuotaPres);?>';
    document.form1.IRPFcuota.value=parseFloat(<?php echo $totalImportePres;?>)*document.form1.irpf.value/100;
    document.form1.IRPFcuota.value=truncar2dec(document.form1.IRPFcuota.value);
    document.form1.totalFinal.value=parseFloat(<?php echo $totalImportePres+$totalCuotaPres;?>)-parseFloat(document.form1.IRPFcuota.value);
    document.form1.totalFinal.value=truncar2dec(document.form1.totalFinal.value);
    document.form1.IRPFcuota.value=formateaNumeroContabilidad(document.form1.IRPFcuota.value.toString());
    document.form1.totalFinal.value=formateaNumeroContabilidad(document.form1.totalFinal.value.toString());
    rellenarDatos("<?php echo $datosPresupuesto['Cliente']; ?>","Editar");
    <?php
    echo "document.form1.linea.value='$i'";
}

?>  
        
  $("#addrow").click(function(){
    var id=$("#lineasFactura tr:last").attr("id");
    $("#"+id+":last").after(
        lineaFactura((parseInt(document.form1.linea.value)+1),'','','','','','','','','<?php echo $IvaGenerico; ?>','','',null,'<?php echo $cuenta; ?>')
    );
    var numero = parseInt(document.form1.linea.value)+1;
    $('#cantidad'+numero).focus();
    
<?php
//esta opcion de autocomplete de articulos del concepto, esta habilitada si esta en
//parametros generales la variable 'articulos' en 'on'
if($tieneArticulos === 'on'){
?>
            
    $("#concepto"+(parseInt(document.form1.linea.value)+1)).autocomplete({
        source: "../vista/ajax/buscar_articulos.php?bd='<?php echo $_SESSION['mapeo']; ?>'",
        autoFill: true,
        selectFirst: true
        }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
            var txt=item.value.split('-');
            var inner_html = "<a><small><font color='Grey'>"+txt[0]+"</font></small> - <b><font color='Teal'>"+txt[1]+"</font></b></a>";
            return $( "<li></li>" )
                .data( "item.autocomplete", item )
                .append(inner_html)
                .appendTo( ul );
    };
<?php
}
?>
    
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

$("input[type=text]").focus(function(){	   
  this.select();
});

</script>        
<script type="text/javascript" Language="JavaScript"> 
    function volver(){
        javascript:history.back();
    }
</script>

<script type="text/javascript" Language="JavaScript">     
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
<script ype="text/javascript" languaje="JavaScript"  type="text/JavaScript">
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
<script type="text/javascript" Language="JavaScript">     
function desactivaBoton() {
	if (this.form1.cmdAlta.value == "Anular") {
	  alert("Está intentando dar de alta dos veces");
  this.form1.strDescripcion.name="";
	}else{
		this.form1.cmdAlta.value = "Anular";
	}
}
</script> 
<script type="text/javascript" Language="JavaScript">     

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


<script type="text/javascript" Language="JavaScript">     
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
<script type="text/javascript" Language="JavaScript">     
function focus(){
    document.form1.numPresupuesto.focus();
}
</script>
</head>
<body bgColor=#ffffff leftMargin=0 topMargin=0 rightMargin=0 bottomMargin=0 marginwidth="0" marginheight="0"  background="<?php echo FONDO; ?>" 
      onLoad="rotulo_status();
              focus();
              SiEsContado(document.form1.FormaPagoHabitual);
              <?php
                if(isset($_GET['borrar'])&& $_GET['borrar']=='si'){
                    echo 'borrarFactura('. $_GET['IdFactura'].');';
                }
                if(isset($datosPresupuesto)){
                    echo "rellenarDatos('".$datosPresupuesto['Cliente']."','Editar');";
                }
                ?>
      ">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<!-- Cabecera-->
  <tr>
   <td width="40%" height="100%" border="0"></td>
   <td  width="780" height="35" border="0" alt="" bgcolor="#FFFFFF"  class="Text2">
   <table border="<?php echo MARCO_BORDER; ?>" cellpadding="0" cellspacing="0" width="880">

   <tr>
   <!-- contenido pagina -->
   <td width="768" height="854" alt="" valign="top">
   <br><p></p>

<center>
<!--    cabecera-->
<?php
$formatoForm='';
$disabledForm = 'disabled';
$anchoCabecera = 800;

//preparo la fecha de la cabecera
if(isset($_GET['IdFactura']) || isset($varRes)){
    $fechaForm=$datosPresupuesto['FechaFactura'];
}else{
    date_default_timezone_set('Europe/Madrid');
    $fechaForm=date('d/m/Y');
}

$fechaTexto = fechaCabecera($fechaForm);
$fechaUltimaFactura = $clsCNContabilidad->fechaUltimaFactura();
$fecha = explode('/',$fechaForm);
$fecha = $fecha[2] .'/' .$fecha[1] .'/' .$fecha[0];
        
if($datosPresupuesto['Estado']==='Contabilizada'){
    $tituloForm='<h3><center><font color="FF0000">Factura contabilizada. Sólo se editan los conceptos</font></center></h3>';
}else{
    $tituloForm='';
}


?>

<form id="form1" name="form1" method="post" action="../vista/altafactura.php" onSubmit="desactivaBoton();">
<table border="0" class="cabecera" height="82" width="<?php echo $anchoCabecera; ?>">
    <tr> 
        <td width="177" align="middle" valign="center"><div align="center"><a href="../<?php echo $_SESSION['navegacion'];?>/default2.php"><IMG height=67 alt="Ir al menú" src="../images/<?php echo $_SESSION['logo']; ?>" width=132 border="0"></a></div></td>
        <td width="200"><div align="center"><?php echo $tituloForm; ?></div></td>
        <td>
            <div align="right">
            <table border="0" class="cabecera">
                <tr>
                    <td width="50" height="25" align="middle">
                    </td>			
                    <td width="90" align="left"></td>
                    <td></td>
                </tr>

                <tr align="right">
                    <td></td>
                    <td height="25" align="right">Factura Nº:</td>
                    <td>
                        <input type="text" class="textbox1" name="numPresupuesto" size="12" tabindex="1" <?php if($tipoContador<>''){echo ' readonly';}?>
                               value="<?php if(isset($datosPresupuesto['NumFactura'])){echo $datosPresupuesto['NumFactura'];}else{echo $numeroNuevaFactura;}?>"
                               onkeypress="DesactivaImprimir();" onkeyup="DesactivaImprimir();"
                               onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                               onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);ComprobarPresupuesto(this);" />
                        <input type="hidden" name="numPresupuestoBBDD" value="<?php if(isset($datosPresupuesto['NumFacturaBBDD']) && $datosPresupuesto['NumFacturaBBDD'] !== ''){echo $datosPresupuesto['NumFacturaBBDD'];}else{echo $numFacturaBBDD;} ?>" />
                        <input type="hidden" name="IdPresupuesto" value="<?php echo $datosPresupuesto['IdPresupuesto'];?>" />
                        <input type="hidden" name="IdPedido" value="<?php echo $datosPresupuesto['IdPedido'];?>" />
                    </td>
                </tr>

                <tr align="right">
                    <td></td>
                    <td height="22" align="left"></td>
                    <td>
                    </td>
                </tr>
            </table>
            </div>
        </td>
    </tr>
</table>
<table border="0" width="<?php echo $anchoCabecera; ?>">
    <tr>
        <td width="50%" height="75" align="left" valign="bottom">
            <?php
            //si es abono (factura Rectificativa), aparece este texto
            if(isset($datosPresupuesto['esAbono']) && $datosPresupuesto['esAbono'] !== ''){
                $tipoContador=$clsCNContabilidad->Parametro_general('Tipo Contador',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));
                $numero = numeroDesformateado($datosPresupuesto['esAbono'],$tipoContador);
                $txtTitulo = " RECTIFICATIVA";
                $html = '<label class="nombreCampo">Rectificación Factura Nº '.$numero.'</label><br/><br/>';
            }
            ?>
            <input type="hidden" name="esAbono" value="<?php echo $datosPresupuesto['esAbono']; ?>" />
            <h2>FACTURA <?php echo $txtTitulo; ?></h2>
            <br/>
            <label class="nombreCampo">Referencia:</label>
            <input type="text" class="textbox1" name="Referencia" id="Referencia" style="width:50%;"
                   value="<?php if(isset($datosPresupuesto)){echo $datosPresupuesto['Referencia'];} ?>" />
            <br/><br/>
            <?php echo $html; ?>
            
            <label><?php echo $datosNuestraEmpresa['municipio'].', '; ?><span id="fechaCambiada"><?php echo $fechaTexto.'&nbsp;&nbsp;';?></span></label>
            <input type="hidden" id="fechaPresup" name="fechaPresup" value="<?php echo $fechaForm;?>" onchange="cambiarFecha(this.value);comprobarFechaPorFactura(this.value,'<?php echo $datosPresupuesto['NumFacturaBBDD']; ?>');" />
            <?php
            if($datosPresupuesto['Estado']<>'Contabilizada'){
            ?>
            <script>
            $("#fechaPresup").datepicker({ 
                buttonImage: '../images/calendar.png', 
                buttonImageOnly: true, 
                changeMonth: true, 
                changeYear: true, 
                showOn: 'button',
                defaultDate: "<?php echo $fecha;?>",
                autoSize: true
            });
            
            function comprobarFechaPorFactura(fecha,NumFacturaBBDD){
                //comprobamos si viene o no factura (sino viene es nueva)
                if(NumFacturaBBDD === ''){
                    comprobarFechaFactura(fecha,'<?php echo $fechaUltimaFactura; ?>');
                }else{
                    //busco la fecha y factura anterior y posterior a esta
                    var fechaSplit = fecha.split('/');
                    var fechaForm = fechaSplit[2]+'-'+fechaSplit[1]+'-'+fechaSplit[0];
                    $.ajax({
                        data:{"NumFacturaBBDD":NumFacturaBBDD},  
                        url: '../vista/ajax/comprobar_fechas_factura.php',
                        type:"get",
                        success: function(data) {
                            var errorTxt = '';
                            var datos = JSON.parse(data);
                            //si hay datos hago la comprobacion de fechas con la fecha introducida
                            if(!$.isEmptyObject(datos)){
                                if(datos.fechaAnterior === ''){
                                    //fecha del ejercicio anterior
                                    var fecha = new Date();
                                    fechaPresentarAnt = '01/01/'+fecha.getFullYear();
                                }else{
                                    var fechaPresentarAnt = datos.fechaAnterior.split('-');
                                    fechaPresentarAnt = fechaPresentarAnt[2]+'/'+fechaPresentarAnt[1]+'/'+fechaPresentarAnt[0];
                                }
                                if(datos.fechaPosterior === ''){
                                    fechaPresentarPos = '31/12/9999';
                                }else{
                                    var fechaPresentarPos = datos.fechaPosterior.split('-');
                                    fechaPresentarPos = fechaPresentarPos[2]+'/'+fechaPresentarPos[1]+'/'+fechaPresentarPos[0];
                                }
                                
                                //primero compruebo si la fecha es menor que la de la factura anterior
                                if(Date.parse(fechaForm) < Date.parse(datos.fechaAnterior)){
                                    errorTxt = errorTxt + "La fecha es menor que la de la factura anterior (Fecha: "+fechaPresentarAnt+')';
                                }
                                //ahora compruebo si la fecha es mayor que la de la factura posterior
                                if(Date.parse(fechaForm) > Date.parse(datos.fechaPosterior)){
                                    errorTxt = errorTxt + "La fecha es mayor que la de la factura posterior (Fecha: "+fechaPresentarPos+')';
                                }
                                
                                if(errorTxt !== ''){
                                    alert(errorTxt);
                                }
                            }
                        }
                    });
                }
            }
            
            function cambiarFecha(fechaForm){
                //preparo la fecha en forma 20 de diciembre de 2013
                var fechaPartes=fechaForm.split('/');
                //escribir mes en texto
                var mes;
                switch (fechaPartes[1]) {
                    case '01':
                        mes='Enero';
                        break;
                    case '02':
                        mes='Febrero';
                        break;
                    case '03':
                        mes='Marzo';
                        break;
                    case '04':
                        mes='Abril';
                        break;
                    case '05':
                        mes='Mayo';
                        break;
                    case '06':
                        mes='Junio';
                        break;
                    case '07':
                        mes='Julio';
                        break;
                    case '08':
                        mes='Agosto';
                        break;
                    case '09':
                        mes='Septiembre';
                        break;
                    case '10':
                        mes='Octubre';
                        break;
                    case '11':
                        mes='Noviembre';
                        break;
                    case '12':
                        mes='Diciembre';
                        break;
                }
                //unas veces vendra la fecha con formato Y/m/d (2013/12/22) y otras con d/m/Y (22/12/2013)
                //para saber el año se comprueba que [0] o [2] tenga 4 digitos
                var day,year;
                
                if(fechaPartes[0].length == 4){
                    year=fechaPartes[0];
                    day=fechaPartes[2];
                }else{
                    year=fechaPartes[2];
                    day=fechaPartes[0];
                }

                //reescribo el span donde va la fecha
                $('#fechaCambiada').html(day+' de '+mes+' de '+year);
            }
            </script>
            <?php
                datepicker_español('fechaPresup');
            }
            ?>
        </td>
        <td width="50%" style="background-color: #eeeeee;">
            <table border="0" width="<?php echo $anchoCabecera/2; ?>">
                <tr>
                    <td width="30%"></td>
                    <td width="70%"></td>
                </tr>
                <tr>
                    <td align="right">
                        <label class="nombreCampo">Att de D./Dña:</label>
                    </td>
                    <td align="left">
                        <input type="text" class="textbox1readonly" name="Cliente" id="Cliente" readonly />
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <label class="nombreCampo">Cliente:</label>
                    </td>
                    <td align="left">
                        <select class="textbox1" name="Contacto" id="Contacto" style="width: 100%;" tabindex="2" onchange="rellenarDatos(this.value,'Nuevo');DesactivaImprimir();">
                            <?php echo $htmlSelect; ?>
                        </select>
                        <input type="hidden" id="ContactoHidden" name="ContactoHidden" value="<?php if(isset($datosPresupuesto)){echo $datosPresupuesto['NombreEmpresa'];} ?>"/>
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <label class="nombreCampo">CIF:</label>
                    </td>
                    <td align="left">
                        <input type="text" class="textbox1readonly" name="CIF" id="CIF" readonly />
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <label class="nombreCampo">Dirección:</label>
                    </td>
                    <td align="left">
                        <input type="text" class="textbox1readonly" name="direccion" id="direccion" readonly />
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <label class="nombreCampo">Población:</label>
                    </td>
                    <td align="left">
                        <input type="text" class="textbox1readonly" name="poblacion" id="poblacion" readonly />
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <label class="nombreCampo">Provincia:</label>
                    </td>
                    <td align="left">
                        <input type="text" class="textbox1readonly" name="provincia" id="provincia" readonly />
                    </td>
                </tr>
                
            </table>
        </td>
    </tr>
</table>
<!--    fin cabecera-->
    
  <div class="docPresup"> 
<!--    <hr style="border-width: 1px;border-style: solid;" color = "#FF9900">-->
    <table border="0" width="100%">
        <tr>
            <td class="lineaRoja"></td>
        </tr>
    </table>
    <br/>
        
      <table width="<?php echo $anchoCabecera; ?>" border="0" class="zonaactivafactura" id="lineasFactura">
        <tr>
            <td width="2%" class="subtitulo" style="text-align: right;"></td>
            <td width="8%" class="subtitulo" style="text-align: right;">Cantidad</td>
            <td width="42%" class="subtitulo">Concepto</td>
            <td width="8%" class="subtitulo" style="text-align: right;">Precio</td>
            <td width="11%" class="subtitulo" style="text-align: right;">Importe</td>
            <td width="7%" class="subtitulo" style="text-align: right;">IVA</td>
            <td width="11%" class="subtitulo" style="text-align: right;">Cuota</td>
            <td width="11%" class="subtitulo" style="text-align: right;">Total</td>
        </tr>
        <tr id="linea0"> </tr>
      </table>
      <table width="<?php echo $anchoCabecera; ?>" border="0" class="zonaactivafactura" id="lineasFactura">
        <tr id="hiderow">
            <?php
            if($datosPresupuesto['Estado']<>'Contabilizada'){
            ?>
          <td colspan="5">
              <div align="left">
                  <a id="addrow" href="javascript:;" title="Añadir Concepto">Añadir Concepto</a>
              </div>
          </td>
            <?php
            }
            ?>
        </tr>
        
        
      </table>
      <table border="0" width="100%">
          <tr>
              <td class="lineaAzul"></td>
          </tr>
      </table>

      <table width="<?php echo $anchoCabecera; ?>" border="0">
        <tr>
            <td width="2%"></td>
            <td width="8%"></td>
            <td width="42%"></td>
            <td width="8%"></td>
            <td width="11%"></td>
            <td width="7%"></td>
            <td width="11%"></td>
            <td width="11%"></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td align="right"><label class="nombreCampo">SubTotal</label></td>
            <td align="left">
                <input type="text" class="textbox1readonly" name="totalImporte" id="totalImporte" style="text-align:right;" readonly />
            </td>
            <td></td>
            <td align="left">
                <input type="text" class="textbox1readonly" name="totalCuota" id="totalCuota" style="text-align:right;" readonly />
            </td>
            <td align="left">
                <input type="text" class="textbox1readonly" name="total" id="total" style="text-align:right;" readonly />
            </td>
        </tr>
        
        <!--Si del parametro genera 'Tipo IRPF'=0 no se presenta esta columna-->
        <!--a no ser que ya este guardado un IRPF>0-->
        <?php 
        $numIRPF='0';
        if(isset($datosPresupuesto['Retencion'])){
            $numIRPF=$datosPresupuesto['Retencion'];
        }

        //si $numIRPF=0, comprobamos si $tipoIRPF=0
        $IRPF_SI='SI';
        if($numIRPF==='0'){
            $tipoIRPF=$clsCNContabilidad->Parametro_general('Tipo IRPF',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));
            if((int)$tipoIRPF===0){
                $IRPF_SI='NO';
            }
        }
        
        //por ultimo veo si $tipoIRPF <> 0 , si es asi la casilla de Retencion (IRPF) se presenta
        //y si es un presupuesto nuevo (no viene $_GET[IdPresupuesto]) la vble $numIRPF=$tipoIRPF
        if(!isset($_GET['IdFactura'])){
            $numIRPF=$tipoIRPF;
        }
        ?>
        <?php if($IRPF_SI==='SI'){ ?>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2" align="right"><label class="nombreCampo">Retención</label></td>
            <td align="left">
                <select name="irpf" class="selectFactura" style="text-align:right;font-weight:bold;width:100%;" tabindex="100" name="iprf"
                            onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" 
                            onChange="facturaCalculoIRPF(document.form1.totalImporte,document.form1.total,this,document.form1.IRPFcuota,document.form1.totalFinal);DesactivaImprimir();">
                      <?php
//                      $numIRPF=0;
//                      if(isset($datosPresupuesto['Retencion'])){
//                          $numIRPF=$datosPresupuesto['Retencion'];
//                      }
                      listadoIVA($numIRPF,$datosPresupuesto['Estado']);
                      ?>          
                </select>
            </td>
            <td align="left">
                <input type="text" class="textbox1readonly" name="IRPFcuota" style="text-align:right;" readonly />
            </td>
        </tr>
        <?php }else{ ?>
        <tr>
            <td>
                <input type="hidden" name="irpf" value="<?php echo $numIRPF; ?>" />
                <input type="hidden" name="IRPFcuota" />
            </td>
        </tr>
        <?php } ?>
        
        <tr>
            <td height="15px"></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td align="right"><label class="nombreCampo">Total</label></td>
            <td align="left">
                <input type="text" class="textbox1readonly" name="totalFinal" style="text-align:right;" readonly />
            </td>
        </tr>
      </table>
      <table border="0" width="100%">
          <tr>
              <td class="lineaAzul"></td>
          </tr>
      </table>
      <table width="<?php echo $anchoCabecera; ?>" border="0">
          <tr>
            <td class="nombreCampo"><div align="right">Forma de Pago:</div></td>
            <td>
                <div align="left">
                    <script>
                    function SiEsTransferencia(objeto){
                        if(objeto.value === 'Transferencia'){
                            $('.cc').show('500');
                        }else{
                            $('.cc').hide('500');
                        }
                    }
                    </script>
                    
                  <select name="FormaPagoHabitual" id="FormaPagoHabitual" class="textbox1" tabindex="101" style="width: 100%;" onchange="SiEsContado(this);DesactivaImprimir();SiEsTransferencia(this);">
                      <?php if($datosPresupuesto['Estado']==='Contabilizada'){ ?>
                        <option value="<?php echo $datosPresupuesto['FormaPago']; ?>" selected><?php echo $datosPresupuesto['FormaPago']; ?></option>
                      <?php }else{?>
                        <?php if(isset($varRes)){?>
                        <option value="" <?php if($datosPresupuesto['FormaPago']===''){echo 'selected';}?>></option>
                        <option value="Contado" <?php if($datosPresupuesto['FormaPago']==='Contado'){echo 'selected';}?>>Contado</option>
                        <option value="Pagare" <?php if($datosPresupuesto['FormaPago']==='Pagare'){echo 'selected';}?>>Pagaré</option>
                        <option value="Recibo" <?php if($datosPresupuesto['FormaPago']==='Recibo'){echo 'selected';}?>>Recibo</option>
                        <option value="Talon" <?php if($datosPresupuesto['FormaPago']==='Talon'){echo 'selected';}?>>Talón</option>
                        <option value="Transferencia" <?php if($datosPresupuesto['FormaPago']==='Transferencia'){echo 'selected';}?>>Transferencia</option>
                        <?php }else if($_GET['IdFactura']){?>
                        <option value="" <?php if($datosPresupuesto['FormaPago']===''){echo 'selected';}?>></option>
                        <option value="Contado" <?php if($datosPresupuesto['FormaPago']==='Contado'){echo 'selected';}?>>Contado</option>
                        <option value="Pagare" <?php if($datosPresupuesto['FormaPago']==='Pagare'){echo 'selected';}?>>Pagaré</option>
                        <option value="Recibo" <?php if($datosPresupuesto['FormaPago']==='Recibo'){echo 'selected';}?>>Recibo</option>
                        <option value="Talon" <?php if($datosPresupuesto['FormaPago']==='Talon'){echo 'selected';}?>>Talón</option>
                        <option value="Transferencia" <?php if($datosPresupuesto['FormaPago']==='Transferencia'){echo 'selected';}?>>Transferencia</option>
                        <?php }else{?>
                        <option value=""></option>
                        <option value="Contado" <?php if($_GET['FormaPagoHabitual']==='Contado'){echo 'selected';}?>>Contado</option>
                        <option value="Pagare" <?php if($_GET['FormaPagoHabitual']==='Pagare'){echo 'selected';}?>>Pagaré</option>
                        <option value="Recibo" <?php if($_GET['FormaPagoHabitual']==='Recibo'){echo 'selected';}?>>Recibo</option>
                        <option value="Talon" <?php if($_GET['FormaPagoHabitual']==='Talon'){echo 'selected';}?>>Talón</option>
                        <option value="Transferencia" <?php if($_GET['FormaPagoHabitual']==='Transferencia'){echo 'selected';}?>>Transferencia</option>
                        <?php }?>
                      <?php }?>
                  </select>
                </div>
            </td>
            <td align="right"><label class="nombreCampo">Vencimiento</label></td>
            <td width="50px">
                <div align="left">
                <?php
                $presentarValidez='';
                if(isset($datosPresupuesto)){
                    $presentarValidez=$datosPresupuesto['Validez'];
                    if((int)$presentarValidez==0){
                        $presentarValidez='';
                    }
                }else{
                    $presentarValidez='15';
                }
                ?>
                <input class="textbox1" type="text" name="validez" maxlength="12" tabindex="102" value="<?php echo $presentarValidez; ?>"
                       onkeypress="DesactivaImprimir();return solonumeros(event);" style="text-align:right;"
                       onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                       onfocus="onFocusInputText(this);selecciona_value(this);"
                       <?php if($datosPresupuesto['Estado']==='Contabilizada'){echo 'disabled';}?>
                       onkeyup="DesactivaImprimir();" onblur="onBlurInputText(this);"/>
                </div>
            </td>
            <td align="left"><label class="nombreCampo">Dias</label></td>
          </tr>
          <tr>
              <td>
                  <?php
                  $display_CC_Trans = 'none;';
                  if($datosPresupuesto['FormaPago']==='Transferencia'){
                      $display_CC_Trans = 'block;';
                  }
                  
                  ?>
                <div class="cc" style="text-align:right; display: <?php echo $display_CC_Trans; ?>">
                <label>CC Transferencia</label>
                </div>
              </td>
              <td>
                <div class="cc" style="display: <?php echo $display_CC_Trans; ?>">
                <input class="textbox1" type="text" name="CC_Trans" maxlength="30" tabindex="103" value="<?php echo $datosPresupuesto['CC_Trans']; ?>"
                       onkeypress="DesactivaImprimir();" style="text-align:left;"
                       onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                       onfocus="onFocusInputText(this);selecciona_value(this);"
                       <?php if($datosPresupuesto['Estado']==='Contabilizada'){echo 'disabled';}?>
                       onkeyup="DesactivaImprimir();" onblur="onBlurInputText(this);"/>
                </div>
              </td>
          </tr>
      </table>
    
    <input type="hidden" name="linea" value="0"/>     
    <input type="hidden" name="esValido" value="false"/>     
    
        
      <P>
        <input type="hidden" name="guardarArticulosNuevos" value="NO"/>     
        <input type="button" id="cmdAlta" name="cmdAlta" class="button" value = "<?php if(isset($_GET['IdFactura'])){echo 'Grabar';}else{echo 'Grabar';} ?>" onclick="javascript:validar2(document.form1.esValido,document.form1.guardarArticulosNuevos);" />
        <input type="button" class="buttonAzul" value="Volver" onclick='javascript:window.location = "../vista/facturalist.php";' />
        <?php
        if(isset($_GET['IdFactura'])){
            echo '<input type="hidden"  name="IdFactura" value="'.$_GET['IdFactura'].'" />';
        }else if(isset($varRes)){
            echo '<input type="hidden"  name="IdFactura" value="'.$varRes.'" />';
        }else{
            echo '<input type="hidden"  name="IdFactura" value="Nuevo" />';
        }
        
        if($datosPresupuesto['Estado']<>'Contabilizada'){
            if(isset($_GET['IdFactura'])){
                echo '<input type="button" class="buttonAzul" value="Eliminar" name="cmdBorrar" onclick="javascript:borrarFactura('.$_GET['IdFactura'].');" />';
            } 
            if(isset($varRes)){
                echo '<input type="button" class="buttonAzul" value="Eliminar" name="cmdBorrar" onclick="javascript:borrarFactura('.$varRes.');" />';
            } 
        }
        ?>  
        <input type="button" class="buttonAzul" value = "Salir" onclick="javascript:salir();" />
        <input type="button" name="imprimir" value = "Imprimir" 
               onclick="javascript:Imprimir(document.form1.linea.value);" class="button" />
        <a class="modalbox" href="#inline"><input type="button" name="enviar" value = "Enviar" 
                                                  onclick="javascript:Enviar(document.form1.linea.value);" class="button" /></a>
        <?php if(!isset($_GET['IdFactura']) && !isset($varRes)){echo '<input type="hidden" name="SePuedeImprimir" value="NO" />';}else{echo '<input type="hidden" name="SePuedeImprimir" value="SI" />';}?>
      </P>
        
      <?php include '../vista/IndicacionIncidencia.php'; ?>
  </div>
</form>
</center>

   </td>
   <!-- contenido pagina -->
  </tr>
  </table>
</td>
<td width="40%" height="100%" valign="top" align="center">
<!-- ayuda-->
<a onClick="javascript:window.open('../Videos/verVideo.php','nueva','resizable=yes, scrollbars=yes, width=800,height=650');">
    <img src="../images/ayuda_juan.gif" alt="Ayuda en Línea" width="35" height="35" border="0">
</a>
</td>
</tr>
<!-- presentacion-->   
</table>

    
<!--formulario emergente envio PDF    -->
<div id="inline">
	<h2>Envio PDF</h2>

        <form id="contact" name="contact" action="../vista/facturaEnviar.php" method="post">
		<label class="nombreCampo" for="email">Para</label><br/>
		<input type="email" id="email" name="email" class="textbox1"><br/>
		<label class="nombreCampo" for="email">C.C.</label><br/>
		<input type="email" id="emailCC" name="emailCC" class="textbox1"><br/>
		<br>
		<label class="nombreCampo" for="msg">Mensaje</label>
                <textarea id="msg" name="msg" class="textbox1area" rows="5"></textarea>
		
		<input type="button" id="send" class="button" onclick="EnviarForm();" value="Envio" />
                <input type="hidden" name="IdFactura" value="<?php echo $_GET['IdFactura'];?>"/>     
	</form>
</div>
</body>
</html>
