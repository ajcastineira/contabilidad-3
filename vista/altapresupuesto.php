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

//si viene la vble $_SESSION['presupuestoActivo'] la borro (formulario de movil)
if(isset($_SESSION['presupuestoActivo'])){
    unset($_SESSION['presupuestoActivo']);
}

//esta opcion de autocomplete de articulos del concepto, esta habilitada si esta en
//parametros generales la variable 'articulos' en 'on'
$tieneArticulos = $clsCNContabilidad->Parametro_general('articulo', date('Y-m-d H:i:s'), date('Y-m-d H:i:s'));

//Iva Generico
$IvaGenerico = $clsCNContabilidad->Parametro_general('IvaGenerico',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));


//funcion del combo del IVA-IRPF
function listadoIVA($irpf){
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

//extraemos los datos de nuestra empresa
$datosNuestraEmpresa=$clsCNContabilidad->datosNuestraEmpresaPresupuesto();

//borro este dato de session $_SESSION['lineasArticulosSinGuardar']
unset($_SESSION['lineasArticulosSinGuardar']);



//codigo principal
if(isset($_POST['IdPresupuesto'])){
    //var_dump($_POST);die;
    //a pulsado aceptar, si viene POST[IdPresupuesto] = 'Nuevo' es nuevo si llega numero es editar
    if($_POST['IdPresupuesto'] === 'Nuevo' && !isset($varRes)){
        logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " ||||Mis Presupuestos->Alta|| Ha pulsado 'Aceptar'");
        
        $varRes=$clsCNContabilidad->AltaPresupuesto($_SESSION['usuario'],$_POST,'Alta');
    }else{
        logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " ||||Mis Presupuestos->Actualizar|| Ha pulsado 'Actualizar'");
        $varRes=$clsCNContabilidad->EditarPresupuesto($_SESSION['usuario'],$_POST);
    }

    //voy a una pagina intermedia que me volvera a enviar aqui, asi no podran recargar la pagina
    if($varRes === false || $varRes === 'false'){
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/error.php?id='.$varRes.'">';die;
    }else{
        if($tieneArticulos === 'on'){
            //ahora compruebo si hay algun articulo que no este guardado(campo IdArticulo=NULL)
            //cuando IdArticulo=numero es un articulo y si IdArticulo=0 no es articulo
            //extraigo un array con los datos
            $datosPresupuesto = $clsCNContabilidad->datosPresupuesto($varRes);

            $lineasArticulosSinGuardar = '';
            if(is_array($datosPresupuesto)){
                //tiene IdArticulo=NULL o IdArticulo=vacio
                //cargamos la pagina donde sale un listado con las lineas de los conceptos
                for ($i = 0; $i < count($datosPresupuesto['DetallePresupuesto']); $i++) {
                    if(!isset($datosPresupuesto['DetallePresupuesto'][$i]['IdArticulo']) || $datosPresupuesto['DetallePresupuesto'][$i]['IdArticulo'] === ''){
                        $lineasArticulosSinGuardar[] = $datosPresupuesto['DetallePresupuesto'][$i];
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
                        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/articulosSinGuardar.php?pid='.$varRes.'">';die;
                }else if($_POST['guardarArticulosNuevos'] === 'NO'){
                    //Si es NO se ponen todos estos IdArticulo a 0 en el presupuesto
                    $clsCNContabilidad->PonerIdArticuloACeroPresupuesto($varRes);
                    //y continua el flujo
                }
            }
        }
    
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/exitoInsertado.php?id='.$varRes.'&pant='.$_POST['pant'].'">';die;
    }
}
    
//venimos del menu principal alta o Modificacion/Duplicar/Borrar
if(isset($_GET['IdPresupuesto'])){
    logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
           " ||||Mis Presupuestos->Modificacion/Duplicar/Baja||");

    $datosPresupuesto=$clsCNContabilidad->datosPresupuesto($_GET['IdPresupuesto']);
//    print_r($datosPresupuesto);die;
    
    if($datosPresupuesto['Borrado']==='0'){
        //este presupuesto esta borrado por lo que volvemos al menu
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/default2.php">';die;
    }
    
    //compruebo si vengo de duplicar
    if(isset($_GET['duplicar']) && $_GET['duplicar']==='si'){
        //generamos en la BBDD un presupuesto copiando los datos de este
        $numeroNuevoPresupuesto=$clsCNContabilidad->NumeroNuevoPresupuesto();
        $tipoContador=$clsCNContabilidad->Parametro_general('Tipo Contador',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));
        
        //preparo el numero de la forma '20140005' para guardar
        $numPresupuesto = numeroFormateado($numeroNuevoPresupuesto,$tipoContador);
//        switch ($tipoContador) {
//            case 'simple':
//                $numPresupuesto= $numeroNuevoPresupuesto;
//                break;
//            case 'compuesto1':
//                $numeroNuevoPresupuesto=explode('/',$numeroNuevoPresupuesto);
//                while(strlen($numeroNuevoPresupuesto[0])<4){
//                    $numeroNuevoPresupuesto[0]='0'.$numeroNuevoPresupuesto[0];
//                }
//                $numPresupuesto=$numeroNuevoPresupuesto[1].$numeroNuevoPresupuesto[0];
//                break;
//            case 'compuesto2':
//                $numeroNuevoPresupuesto=explode('/',$numeroNuevoPresupuesto);
//                $numPresupuesto=$numeroNuevoPresupuesto[0].$numeroNuevoPresupuesto[1];
//                break;
//            default://ningun contador
//                $numPresupuesto= $numeroNuevoPresupuesto;
//                break;
//        }
        
        $PresupuestoDuplicado=$clsCNContabilidad->datosDuplicarPresupuesto($_GET['IdPresupuesto'],$numPresupuesto);
        if($PresupuestoDuplicado === 'false'){
            echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/error.php?id=No se a podido duplicar el presupuesto">';die;
        }else{
            echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/altapresupuesto.php?IdPresupuesto='.$PresupuestoDuplicado.'">';die;
        }
    }
    
//}else if(isset($_GET['IdContacto'])){
    
}else{
    logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
           " ||||Mis Presupuestos->Alta||");
    $numeroNuevoPresupuesto=$clsCNContabilidad->NumeroNuevoPresupuesto();
    //$tipoContador=$clsCNContabilidad->Parametro_general('Tipo Contador',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));
}

$tipoContador=$clsCNContabilidad->Parametro_general('Tipo Contador',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));
$numPresupuestoBBDD = numeroFormateado($numeroNuevoPresupuesto,$tipoContador);

//extraigo el listado de contactos y clientes
$listadoContactos=$clsCNContabilidad->listadoContactos();

//ahora preparo la consulta select (las opciones)
$htmlSelect='';
$htmlSelect=$htmlSelect.'<option value=""></option>';
$htmlSelect=$htmlSelect.'<option value="Nuevo">Nuevo...</option>';
$listadoSinOrdenar= '';
if(is_array($listadoContactos)){
    foreach($listadoContactos as $contacto){
        $dato = '';
        if(isset($contacto['IdContacto'])){
            $value=$contacto['IdContacto'];
            //$tipo='CO';
            $dato['tipo'] = 'CO';
        }else if(isset($contacto['NumCuenta'])){
            $value=$contacto['NumCuenta'];
            //$tipo='CL';
            $dato['tipo'] = 'CL';
        }
        //$texto=$contacto['NombreEmpresa'];
        $dato['texto'] = $contacto['NombreEmpresa'];
        //si el NombreEmpresa esta vacio indicamos en NombreContacto+ApellidosContacto
        if($contacto['NombreEmpresa']===''){
            //$texto=$contacto['NombreContacto'].' '.$contacto['ApellidosContacto'];
            $dato['texto'] = $contacto['NombreContacto'].' '.$contacto['ApellidosContacto'];
        }
        //comprobamos si venimos de editar (existe la vble $datosPresupuesto[Contacto_Cliente]
        //$contactoCliente=$tipo.'.'.$value;
        $dato['contactoCliente'] = $dato['tipo'].'.'.$value;

        //if($contactoCliente==$datosPresupuesto['Contacto_Cliente'] || $contactoCliente==('CO.'.$_GET['IdContacto'])){
        if($dato['contactoCliente'] === $datosPresupuesto['Contacto_Cliente'] || $dato['contactoCliente'] === ('CO.'.$_GET['IdContacto'])){
            $dato['select'] = 'SI';
            $listadoSinOrdenar[] = $dato;
            
            //$htmlSelect=$htmlSelect."<option value='$contactoCliente' selected>$texto</option>";
        }else{
            $dato['select'] = 'NO';
            $listadoSinOrdenar[] = $dato;
            
            //$htmlSelect=$htmlSelect."<option value='$contactoCliente'>$texto</option>";
        }
    }
    
    //ahora ordeno este array
    $aux = '';
    foreach ($listadoSinOrdenar as $key => $row) {
        $aux[$key] = $row['texto'];
    }
    array_multisort($aux, SORT_ASC, $listadoSinOrdenar);
    
    //ahora preparo el html del select
    foreach ($listadoSinOrdenar as $key => $row) {
        if($row['select'] === 'SI'){
            $htmlSelect=$htmlSelect."<option value='".$row['contactoCliente']."' selected>".$row['texto']."</option>";
        }else{
            $htmlSelect=$htmlSelect."<option value='".$row['contactoCliente']."'>".$row['texto']."</option>";
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
<TITLE><?php if(isset($_GET['IdPresupuesto'])){echo 'Presupuesto - EDITAR';}else{echo 'Presupuesto - ALTA';}?></TITLE>

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
    textoError=textoError+"Es necesario introducir un número de presupuesto.\n";
    document.form1.numPresupuesto.style.borderColor='#FF0000';
    document.form1.numPresupuesto.title ='Se debe introducir un número de presupuesto';
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
        location.href="../vista/altacontacto.php";
    }else{
        var dividirTexto=objeto.split(".");
        var tipo=dividirTexto[0];
        var numero=dividirTexto[1];

        $.ajax({
          data:{"q":tipo,"numero":numero},  
          url: '../vista/ajax/datosContacto.php',
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
function borrarPresupuesto(id){
    if (confirm("¿Desea borrar el Presupuesto de la base de datos?"))
    {
        window.location='../vista/presupuestoBorrar.php?id='+id;
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
        
        window.open("../vista/presupuestoImprimir.php?"+datos, '', 'scrollbars=yes,menubar=no,height=600,width=800,resizable=yes,toolbar=no,status=no,location=no');
    }else{
        alert('No se puede ver el PDF sin haber guardado el presupuesto');
    }
}

function Enviar(i){
    if(document.form1.SePuedeImprimir.value==='SI'){    
        var datos=preparaURL(i,'enviar');
        
        //aparece el formulario emergente
        $(".modalbox").fancybox();

        $.ajax({
          url: '../vista/presupuestoImprimir.php?'+datos,
          type:"get"
        });
    }else{
        alert('No se puede enviar el PDF sin haber guardado el presupuesto');
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
        var datos='IdPresupuesto=<?php echo $_GET['IdPresupuesto']; ?>';
        datos=datos+'&opcion='+opcion;
        
        datos=encodeURI(datos);
        return datos;
}

function DesactivaImprimir(){
    document.form1.SePuedeImprimir.value='NO';
}

function ComprobarPresupuesto(objeto){
    var IdPresupuesto='<?php if(isset($_GET['IdPresupuesto'])){echo $_GET['IdPresupuesto'];}else{echo 'NO';}?>';
    $.ajax({
      data:{"numP":objeto.value,"IdPresupuesto":IdPresupuesto},  
      url: '../vista/ajax/ComprobarNumeroPresupuesto.php',
      type:"get",
      success: function(data) {
        if(data==='SI'){
            alert('Este número de presupuesto EXISTE.');
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

function SiEsArticuloRellenar(concepto,IdArticulo,cantidad,precio,precioHidden,importe,iva,cuota,total,esValido){
if(IdArticulo.value === 'null'){
<?php
    if($tieneArticulos === 'on'){
    ?>

    //busco si existe este articulo y me traigo sus datos
    $.ajax({
        data:{"articulo":concepto.value,"cuenta":""},  
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
function lineaFactura(linea,IdPresupLinea,estaFacturado,estaPedido,cantidad,concepto,precio,importe,iva,cuota,total,IdArticulo){

var precioHidden = desFormateaNumeroContabilidad(precio);
var cantidadHidden = desFormateaNumeroContabilidad(cantidad);

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

var opcionBorrar='';
if(estaFacturado==='NO' && estaPedido==='NO'){
    opcionBorrar='<a class="delete" href="javascript:;" title="Borrar Concepto"><font color="#FF0000">X</font></a>';
}else{
    opcionBorrar='';
}

var txtLinea='<tr id="linea'+linea+'" class="item-row">'+ 
            '<td valign="top">'+opcionBorrar+'</td>'+
            "<td valign='top'>"+
                '<div class="divFormato">'+
                '<input type="hidden" name="IdPresupLinea'+linea+'" id="IdPresupLinea'+linea+'" value="'+IdPresupLinea+'" />'+
                '<input class="textbox2" type="text" name="cantidad'+linea+'" id="cantidad'+linea+'" maxlength="12" tabindex="'+linea+'1" '+
                       'onkeypress="return solonumeros(event);" style="text-align:right;" value="'+cantidad+'" '+
                       'onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" '+
                       'onkeypress="DesactivaImprimir();" onkeyup="DesactivaImprimir();" '+
                       'onfocus="desFormateaCantidad(this);this.select();"'+
                       'onClick="this.select();"'+
                       'onblur="copiaHidden(this,cantidadHidden'+linea+');formateaCantidad(this);'+
                               'facturaCalculoCantidad(this,document.form1.precioHidden'+linea+',document.form1.importe'+linea+','+
                               'document.form1.iva'+linea+',document.form1.cuota'+linea+',document.form1.total'+linea+');sumas();"/>'+
                '<input type="hidden" id="cantidadHidden'+linea+'" name="cantidadHidden'+linea+'" value="'+cantidadHidden+'">'+
                "</div>"+
            "</td>"+
            "<td valign='top'>"+
                '<div align="left">'+
                  '<textarea class="textbox1area" name="concepto'+linea+'" id="concepto'+linea+'" tabindex="'+linea+'2" '+
                        'cols="20" rows="0" onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" '+
                        'onkeypress="DesactivaImprimir();return facturasCaracteresDescartados(event);" onkeyup="DesactivaImprimir();" '+
                        'onfocus="" onblur="SiEsArticuloRellenar(this,IdArticulo'+linea+',cantidadHidden'+linea+',precio'+linea+',precioHidden'+linea+',importe'+linea+',iva'+linea+',cuota'+linea+',total'+linea+',document.form1.esValido);">'+concepto+'</textarea>'+ 
                '<input type="hidden" id="IdArticulo'+linea+'" name="IdArticulo'+linea+'" value="'+IdArticulo+'">'+
                "</div>"+
            "</td>"+
            "<td valign='top'>"+
                '<div class="divFormato" align="left">'+
                '<input class="textbox2" type="text" name="precio'+linea+'" id="precio'+linea+'" maxlength="12" tabindex="'+linea+'3" '+
                       'onkeypress="return solonumeros(event);" style="text-align:right;" value="'+precio+'" '+
                       'onkeypress="DesactivaImprimir();" onkeyup="DesactivaImprimir();" '+
                       'onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" '+
                       'onfocus="desFormateaCantidadHidden(this,precioHidden'+linea+');this.select();"'+
                       'onClick="this.select();"'+
                       'onblur="copiaHidden(this,precioHidden'+linea+');'+
                               'facturaCalculoPrecio(document.form1.cantidadHidden'+linea+',this,document.form1.precioHidden'+linea+',document.form1.importe'+linea+
                               ',document.form1.iva'+linea+',document.form1.cuota'+linea+',document.form1.total'+linea+',document.form1.esValido);formateaCantidad(this);sumas();"/>'+
                '<input type="hidden" id="precioHidden'+linea+'" name="precioHidden'+linea+'" value="'+precioHidden+'">'+
                "</div>"+
            "</td>"+
            "<td valign='top'>"+
                '<div class="divFormato" align="left">'+
                '<input class="textbox2" type="text" name="importe'+linea+'" id="importe'+linea+'" maxlength="12" tabindex="'+linea+'4" '+
                       'onkeypress="return solonumeros(event);" style="text-align:right;" value="'+importe+'" '+
                       'onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" '+
                       'onkeypress="DesactivaImprimir();" onkeyup="DesactivaImprimir();" '+
                       'onfocus="desFormateaCantidad(this);this.select();"'+
                       'onClick="this.select();"'+
                       'onblur="formateaCantidad(this);'+
                               'facturaCalculoImporte(document.form1.cantidad'+linea+',document.form1.precio'+linea+',this,'+
                               'document.form1.iva'+linea+',document.form1.cuota'+linea+',document.form1.total'+linea+',document.form1.esValido);sumas();"/>'+
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
    for($i=0;$i<count($datosPresupuesto['DetallePresupuesto']);$i++){
        $IdPresupLineaPres = $datosPresupuesto['DetallePresupuesto'][$i]['IdPresupLineas'];
        $estaFacturadoPres = $datosPresupuesto['DetallePresupuesto'][$i]['estaFacturado'];
        $estaPedidoPres = $datosPresupuesto['DetallePresupuesto'][$i]['estaPedido'];
        $cantidadPres = formateaNumeroContabilidad($datosPresupuesto['DetallePresupuesto'][$i]['cantidad']);
        $conceptoPres = $datosPresupuesto['DetallePresupuesto'][$i]['concepto'];
        $precioPres = formateaNumeroContabilidad($datosPresupuesto['DetallePresupuesto'][$i]['precio']);
        $importePres = formateaNumeroContabilidad($datosPresupuesto['DetallePresupuesto'][$i]['importe']);
        $ivaPres = formateaNumeroContabilidad($datosPresupuesto['DetallePresupuesto'][$i]['iva']);
        $cuotaPres = formateaNumeroContabilidad($datosPresupuesto['DetallePresupuesto'][$i]['cuota']);
        $totalPres = formateaNumeroContabilidad($datosPresupuesto['DetallePresupuesto'][$i]['importe']+$datosPresupuesto['DetallePresupuesto'][$i]['cuota']);
        $totalImportePres = $totalImportePres+$datosPresupuesto['DetallePresupuesto'][$i]['importe'];
        $totalCuotaPres = $totalCuotaPres+$datosPresupuesto['DetallePresupuesto'][$i]['cuota'];
        if(isset($datosPresupuesto['DetallePresupuesto'][$i]['IdArticulo'])){
            $IdArticulo = $datosPresupuesto['DetallePresupuesto'][$i]['IdArticulo'];
        }else{
            $IdArticulo = '';
        }
?>
    $("#linea<?php echo $i;?>:last").after(
            lineaFactura(<?php echo $i+1;?>,'<?php echo $IdPresupLineaPres; ?>','<?php echo $estaFacturadoPres; ?>','<?php echo $estaPedidoPres; ?>','<?php echo $cantidadPres; ?>','<?php echo str_replace(array("\r\n","\r","\n"),'\n',$conceptoPres); ?>','<?php echo $precioPres; ?>','<?php echo $importePres; ?>',
                         '<?php echo $ivaPres; ?>','<?php echo $cuotaPres; ?>','<?php echo $totalPres; ?>','<?php echo $IdArticulo; ?>')
    );
    //ESTA COMENTADO A VER SI FALLA
//    if ($(".delete").length > 0) $(".delete").show();
    
<?php
//if($tieneArticulos === 'on'){
?>

//    $("#concepto<?php //echo $i+1;?>").autocomplete({
//        source: "../vista/ajax/buscar_articulos.php?bd='<?php //echo $_SESSION['mapeo']; ?>'",
//        autoFill: true,
//        selectFirst: true
//        }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
//            var txt=item.value.split('-');
//            var inner_html = "<a><small><font color='Grey'>"+txt[0]+"</font></small> - <b><font color='Teal'>"+txt[1]+"</font></b></a>";
//            return $( "<li></li>" )
//                .data( "item.autocomplete", item )
//                .append(inner_html)
//                .appendTo( ul );
//        };
<?php
//}
?>

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
    rellenarDatos("<?php echo $datosPresupuesto['Contacto_Cliente']; ?>","Editar");
    <?php
    echo "document.form1.linea.value='$i'";
}

?>  
        
  $("#addrow").click(function(){
    var id=$("#lineasFactura tr:last").attr("id");
    $("#"+id+":last").after(
        lineaFactura((parseInt(document.form1.linea.value)+1),'','NO','NO','','','','','<?php echo $IvaGenerico; ?>','','',null)
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
                    echo 'borrarPresupuesto('. $_GET['IdPresupuesto'].');';
                }
                if(isset($_GET['IdContacto'])){
                    echo "rellenarDatos('CO.".$_GET['IdContacto']."','Editar');";
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
if(isset($_GET['IdPresupuesto']) || isset($varRes)){
    $tituloForm='';
    $fechaForm=$datosPresupuesto['FechaPresupuesto'];
}else{
    $tituloForm='';
    date_default_timezone_set('Europe/Madrid');
    $fechaForm=date('d/m/Y');
}
$formatoForm='';
$disabledForm = 'disabled';
$anchoCabecera = 800;

//preparo la fecha en forma 20 de diciembre de 2013
$fechaPartes=explode('/',$fechaForm);
//escribir mes en texto
switch ($fechaPartes[1]) {
    case '01':
        $mes='Enero';
        break;
    case '02':
        $mes='Febrero';
        break;
    case '03':
        $mes='Marzo';
        break;
    case '04':
        $mes='Abril';
        break;
    case '05':
        $mes='Mayo';
        break;
    case '06':
        $mes='Junio';
        break;
    case '07':
        $mes='Julio';
        break;
    case '08':
        $mes='Agosto';
        break;
    case '09':
        $mes='Septiembre';
        break;
    case '10':
        $mes='Octubre';
        break;
    case '11':
        $mes='Noviembre';
        break;
    case '12':
        $mes='Diciembre';
        break;
}
//unas veces vendra la fecha con formato Y/m/d (2013/12/22) y otras con d/m/Y (22/12/2013)
//para saber el año se comprueba que [0] o [2] tenga 4 digitos
if(strlen($fechaPartes[0])==4){
    $year=$fechaPartes[0];
    $day=$fechaPartes[2];
}else{
    $year=$fechaPartes[2];
    $day=$fechaPartes[0];
}

$fechaTexto=$day.' de '.$mes.' de '.$year;
?>

<form id="form1" name="form1" method="post" action="../vista/altapresupuesto.php" onSubmit="desactivaBoton();">
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
                    <td height="25" align="right">Presupuesto Nº:</td>
                    <td>
                        <input type="text" class="textbox1" name="numPresupuesto" size="12" tabindex="1" <?php if($tipoContador<>''){echo ' readonly';}?>
                               value="<?php if(isset($datosPresupuesto['NumPresupuesto'])){echo $datosPresupuesto['NumPresupuesto'];}else{echo $numeroNuevoPresupuesto;}?>"
                               onkeypress="DesactivaImprimir();" onkeyup="DesactivaImprimir();"
                               onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                               onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);ComprobarPresupuesto(this);" />
                        <input type="hidden" name="numPresupuestoBBDD" value="<?php if(isset($datosPresupuesto['NumPresupuestoBBDD']) && $datosPresupuesto['NumPresupuestoBBDD'] !== ''){echo $datosPresupuesto['NumPresupuestoBBDD'];}else{echo $numPresupuestoBBDD;} ?>" />
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
            <h2>PRESUPUESTO</h2>
            <br/><br/>
            <label><?php echo $datosNuestraEmpresa['municipio'].', ',$fechaTexto;?></label>
            <input type="hidden" name="fechaPresup" value="<?php echo $fechaTexto;?>"/>
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
          <td colspan="5">
              <div align="left">
                  <a id="addrow" href="javascript:;" title="Añadir Concepto">Añadir Concepto</a>
              </div>
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
        if(!isset($_GET['IdPresupuesto'])){
            $numIRPF=$tipoIRPF;
        }
        ?>
        <?php if($IRPF_SI==='SI'){ ?>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2" align="right">
                <label class="nombreCampo">Retención</label>
            </td>
            <td align="left">
                <select name="irpf" class="selectFactura" style="text-align:right;font-weight:bold;width:100%;" tabindex="100"
                            onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" 
                            onChange="facturaCalculoIRPF(document.form1.totalImporte,document.form1.total,this,document.form1.IRPFcuota,document.form1.totalFinal);DesactivaImprimir();">
                      <?php
                      listadoIVA($numIRPF);
                      ?>          
                </select>
            </td>
            <td align="left">
                <input type="text" class="textbox1readonly" name="IRPFcuota" style="text-align:right;" readonly />
            </td>
        </tr>
        <?php }else{ ?>
        <input type="hidden" name="irpf" value="<?php echo $numIRPF; ?>" />
        <input type="hidden" name="IRPFcuota" />
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
                  <select name="FormaPagoHabitual" id="FormaPagoHabitual" class="textbox1" tabindex="101" style="width: 100%;" onchange="SiEsContado(this);DesactivaImprimir();">
                      <?php if(isset($varRes)){?>
                      <option value="" <?php if($datosPresupuesto['FormaPago']===''){echo 'selected';}?>></option>
                      <option value="Contado" <?php if($datosPresupuesto['FormaPago']==='Contado'){echo 'selected';}?>>Contado</option>
                      <option value="Pagare" <?php if($datosPresupuesto['FormaPago']==='Pagare'){echo 'selected';}?>>Pagaré</option>
                      <option value="Recibo" <?php if($datosPresupuesto['FormaPago']==='Recibo'){echo 'selected';}?>>Recibo</option>
                      <option value="Talon" <?php if($datosPresupuesto['FormaPago']==='Talon'){echo 'selected';}?>>Talón</option>
                      <option value="Transferencia" <?php if($datosPresupuesto['FormaPago']==='Transferencia'){echo 'selected';}?>>Transferencia</option>
                      <?php }else if($_GET['IdPresupuesto']){?>
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
                  </select>
                </div>
            </td>
            <td align="right"><label class="nombreCampo">Validez del presupuesto</label></td>
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
                       onkeyup="DesactivaImprimir();" onblur="onBlurInputText(this);"/>
                </div>
            </td>
            <td align="left"><label class="nombreCampo">Dias</label></td>
          </tr>
          <tr>
            <td class="nombreCampo"><div align="right">Factura Proforma:</div></td>
            <td>
                <div align="left">
                  <select name="Proforma" id="Proforma" class="textbox1" tabindex="102" style="width: 100%;" onchange="DesactivaImprimir();">
                      <option value="0" <?php if($datosPresupuesto['Proforma']==='0'){echo 'selected';}?>>No</option>
                      <option value="1" <?php if($datosPresupuesto['Proforma']==='1'){echo 'selected';}?>>Si</option>
                  </select>
                </div>
            </td>
          </tr>
      </table>
    
    <input type="hidden" name="linea" value="0"/>     
    <input type="hidden" name="esValido" value="false"/>     
    
        
      <P>
        <input type="hidden" name="guardarArticulosNuevos" value="NO"/>     
        <input type="button" id="cmdAlta" name="cmdAlta" class="button" value = "<?php if(isset($_GET['IdPresupuesto'])){echo 'Grabar';}else{echo 'Grabar';} ?>" onclick="javascript:validar2(document.form1.esValido,document.form1.guardarArticulosNuevos);" />
        <input type="button" class="buttonAzul" value="Volver" onclick="javascript:history.back();" />
        <?php
        if(isset($_GET['IdPresupuesto'])){
            echo '<input type="hidden"  name="IdPresupuesto" value="'.$_GET['IdPresupuesto'].'" />';
        }else if(isset($varRes)){
            echo '<input type="hidden"  name="IdPresupuesto" value="'.$varRes.'" />';
        }else{
            echo '<input type="hidden"  name="IdPresupuesto" value="Nuevo" />';
        }
        ?>
        <?php if(isset($_GET['IdPresupuesto'])){echo '<input type="button" class="buttonAzul"  value="Eliminar" name="cmdBorrar" onclick="javascript:borrarPresupuesto('.$_GET['IdPresupuesto'].');" />';} ?>  
        <?php if(isset($varRes)){echo '<input type="button" class="buttonAzul"  value="Eliminar" name="cmdBorrar" onclick="javascript:borrarPresupuesto('.$varRes.');" />';} ?>  
        <input type="button" class="buttonAzul" value = "Salir" onclick="javascript:salir();" />
        <input type="button" name="imprimir" value = "Imprimir" 
               onclick="javascript:Imprimir(document.form1.linea.value);" class="button" />
        <a class="modalbox" href="#inline">
            <input type="button" name="enviar" value = "Enviar" 
                   onclick="javascript:Enviar(document.form1.linea.value);" class="button" />
        </a>
        <?php if(!isset($_GET['IdPresupuesto']) && !isset($varRes)){echo '<input type="hidden" name="SePuedeImprimir" value="NO" />';}else{echo '<input type="hidden" name="SePuedeImprimir" value="SI" />';}?>
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
    <td  width="40%" height="100%" border="0" alt=""  ></td>
  </tr>
<!-- presentacion-->   
</table>
<!--formulario emergente envio PDF    -->
<div id="inline">
	<h2>Envio PDF</h2>

        <form id="contact" name="contact" action="../vista/presupuestoEnviar.php" method="post">
		<label class="nombreCampo" for="email">Para</label><br/>
		<input type="email" id="email" name="email" class="textbox1" /><br/>
		<label class="nombreCampo" for="emailCC">C.C.</label><br/>
		<input type="email" id="emailCC" name="emailCC" class="textbox1" /><br/>
		<br>
		<label class="nombreCampo" for="msg">Mensaje</label>
                <textarea id="msg" name="msg" class="textbox1area" rows="5"></textarea>
		
		<input type="button" id="send" class="button" onclick="EnviarForm();" value="Envio" />
                <input type="hidden" name="IdPresupuesto" value="<?php echo $_GET['IdPresupuesto'];?>"/>     
	</form>
</div>
</body>
</html>
