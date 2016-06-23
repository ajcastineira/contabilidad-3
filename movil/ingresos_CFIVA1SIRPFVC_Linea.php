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

//var_dump($_SESSION['ingresos_CFIVA1SIRPFVC']['datos']['cuentas']);die;


//var_dump($_GET['IdLinea']);die;

$clsCNContabilidad=new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['dbContabilidad']);
$clsCNContabilidad->setStrBDCliente($_SESSION['mapeo']);

//esta opcion de autocomplete de articulos del concepto, esta habilitada si esta en
//parametros generales la variable 'articulos' en 'on'
$tieneArticulos = $clsCNContabilidad->Parametro_general('articulo', date('Y-m-d H:i:s'), date('Y-m-d H:i:s'));
$cuentaContable = $clsCNContabilidad->Parametro_general('cuentaContable', date('Y-m-d H:i:s'), date('Y-m-d H:i:s'));


//compruebo si viene de submitirse este formulario y es editar
if(isset($_POST['opcion']) && $_POST['opcion']==='Nuevo'){
    echo "Nueva linea OK";die;
    
//    //doy de alta una linea mas del concepto nuevo
//    $count=count($_SESSION['presupuestoActivo']['DetallePresupuesto']);
//    
//    $_SESSION['presupuestoActivo']['DetallePresupuesto'][$count]['IdArticulo']= $_POST['IdArticulo'];
//    $_SESSION['presupuestoActivo']['DetallePresupuesto'][$count]['cuenta']= $_POST['cuenta'];
//    $_SESSION['presupuestoActivo']['DetallePresupuesto'][$count]['cantidad']= desFormateaNumeroContabilidad($_POST['cantidad']);
//    $_SESSION['presupuestoActivo']['DetallePresupuesto'][$count]['precio']=desFormateaNumeroContabilidad($_POST['precio']);
//    $_SESSION['presupuestoActivo']['DetallePresupuesto'][$count]['importe']=desFormateaNumeroContabilidad($_POST['importe']);
//    $_SESSION['presupuestoActivo']['DetallePresupuesto'][$count]['iva']=desFormateaNumeroContabilidad($_POST['iva']);
//    $_SESSION['presupuestoActivo']['DetallePresupuesto'][$count]['cuota']=desFormateaNumeroContabilidad($_POST['cuota']);
//    $_SESSION['presupuestoActivo']['DetallePresupuesto'][$count]['total']=desFormateaNumeroContabilidad($_POST['total']);
//    $_SESSION['presupuestoActivo']['DetallePresupuesto'][$count]['concepto']=$_POST['concepto'];
//    $_SESSION['presupuestoActivo']['SePuedeImprimir']=$_POST['SePuedeImprimir'];
    
    //ahora volvemos a la pagina de altafacturaLineas
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/ingresos_CFIVA1SIRPFVC.php">';die;
}else

//compruebo si viene de submitirse este formulario y es editar
if(isset($_POST['opcion']) && $_POST['opcion']==='Editar'){
    echo "Editar linea OK -  no guarda en SESSION los datos o no los presenta bien en la pagina principal";
//    var_dump($_SESSION['ingresos_CFIVA1SIRPFVC']['datos']['cuentas']);die;
    
    //guardamos estos datos en la vble $_SESSION['ingresos_CFIVA1SIRPFVC']['datos']['cuentas'][$_POST['IdLinea']]
    $_SESSION['ingresos_CFIVA1SIRPFVC']['datos']['cuentas'][$_POST['IdLinea']]['idCuenta'] = $_POST['cuenta'];
    $_SESSION['ingresos_CFIVA1SIRPFVC']['datos']['cuentas'][$_POST['IdLinea']]['strCuenta'] = $_POST['nombreCuenta'];
    $_SESSION['ingresos_CFIVA1SIRPFVC']['datos']['cuentas'][$_POST['IdLinea']]['cantidad'] = $_POST['importe'];
    $_SESSION['ingresos_CFIVA1SIRPFVC']['datos']['cuentas'][$_POST['IdLinea']]['cuota'] = $_POST['cuota'];
    
    //ahora volvemos a la pagina de altafacturaLineas
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/ingresos_CFIVA1SIRPFVC.php">';die;
}else
    
//compruebo si viene de submitirse este formulario y es borrar
if(isset($_POST['opcion']) && $_POST['opcion']==='Borrar'){
    echo "Borrar linea OK";die;
    
//    //borro de la vble de session esta linea (concepto) (borro y reordeno el array)
//    array_splice($_SESSION['presupuestoActivo']['DetallePresupuesto'],$_POST['IdLinea'],1);
//    $_SESSION['presupuestoActivo']['SePuedeImprimir']='NO';
    
    //ahora volvemos a la pagina de altafacturaLineas
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../movil/altafacturaLineas.php">';die;
}
//controlo que traigo $_GET[IdLinea], sino vuelvo a default2.php
if(!isset($_GET['IdLinea']) && $_GET['IdLinea'] !== ''){
    //este presupuesto esta borrado por lo que volvemos al menu
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../movil/default2.php">';die;
}

$linea=$_GET['IdLinea'];

?>
<!DOCTYPE html>
<html>
<head>
<TITLE>Editar Concepto</TITLE>

<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>

</head> 
    <body>
    <div data-role="page" id="ingresos_CFIVA1SIRPFVC_Linea">
<?php
eventosInputText();
?>
<script language="JavaScript">
<?php
//esta opcion de autocomplete de articulos del concepto, esta habilitada si esta en
//parametros generales la variable 'articulos' en 'on'
if($tieneArticulos === 'on'){
?>
//$(function() {
//$(document).ready(function(){
//    $("#concepto").autocomplete({
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
//    };
//});
    
<?php
}
?>
    
function validar2(){
  esValido=true;
  textoError='';

    //compruebo que el importe no sea 0 o vacio
    if(document.form1.importe.value == '' || document.form1.importe.value == '0' ||
            document.form1.importe.value == '0,00'){
        textoError=textoError+"El importe debe ser un valor positivo.\n";
        $('#importe').parent().css('border-color','red');
        esValido=false;
    }

    //compruebo que importe= cantidad x precio
    //quitando que cantidad y precio=0 entonces la cantidad en importe vale
//    var cantidadNumero=parseFloat(desFormateaNumeroContabilidad(document.form1.cantidad.value));
//    var precioNumero=parseFloat(desFormateaNumeroContabilidad(document.form1.precio.value));
//    if(!(cantidadNumero===0 && precioNumero===0)){
//        var importeComp=cantidadNumero*precioNumero;
//        importeComp=truncar2dec(importeComp);
//        var importeNumero=parseFloat(desFormateaNumeroContabilidad(document.form1.importe.value));
//        if(importeComp!==importeNumero){
//            textoError=textoError+"Los datos introducidos no son correctos, hay una incongruencia en cantidad, precio o importe.\n";
//            $('#importe').parent().css('border-color','red');
//            $('#cantidad').parent().css('border-color','red');
//            $('#precio').parent().css('border-color','red');
//            esValido=false;
//        }
//    }

    //compruebo que el cuenta no esté vacio
    if(document.form1.cuenta.value == ''){
        textoError=textoError+"Debe haber algún dato en la cuenta de ingreso.\n";
        document.form1.cuenta.style.borderColor='red';
        esValido=false;
    }


    //indicar el mensaje de error si es 'esValido' false
    if (!esValido){
        alert(textoError);
    }

    if(esValido==true){
        <?php
        if($_GET['IdLinea']==='Nuevo'){
            echo "document.form1.opcion.value='Nuevo';";
        }else{
            echo "document.form1.opcion.value='Editar';";
        }
        ?>
                    
        document.getElementById("cmdAlta").value = "Enviando...";
        document.getElementById("cmdAlta").disabled = true;
        document.form1.submit();
    }else{
        return false;
    }  
}

//function validar2(){
//    document.getElementById("cmdAlta2").value = "Enviando...";
//    document.getElementById("cmdAlta2").disabled = true;
//    document.form1.submit();
//}

//formateo de numeros
function formateaCantidad(objeto){
    objeto.value=formateaNumeroContabilidad2(objeto.value);
}    

function desFormateaCantidad(objeto){
    objeto.value=desFormateaNumeroContabilidad2(objeto.value);
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


function DesactivaImprimir(){
    document.form1.SePuedeImprimir.value='NO';
}

function borrar(){
    if (confirm("¿Desea borrar este concepto del asiento?"))
    {
        document.form1.opcion.value='Borrar';  
        document.getElementById("cmdAlta").value = "Enviando...";
        document.getElementById("cmdAlta").disabled = true;
        document.form1.submit();
    }
}

function copiaHidden(precio,precioHidden){
    //guardo el valor del hidden
    precioHidden.value=precio.value;
}

//function SiEsArticuloRellenar(concepto,IdArticulo,cuenta,cantidad,precio,precioHidden,importe,iva,cuota,total,esValido){
//if(IdArticulo.value === 'null'){
//<?php
//    if($tieneArticulos === 'on'){
//        $cuenta = $clsCNContabilidad->Parametro_general('cuentaContable',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));
    ?>//
//
//    //busco si existe este articulo y me traigo sus datos
//    $.ajax({
//        data:{"articulo":concepto.value,"cuenta":<?php //echo $cuenta; ?>},  
//        url: '../vista/ajax/datos_articulo.php',
//        type:"get",
//        success: function(data) {
//            var datos = JSON.parse(data);
//            //si hay datos actualizamos en todos los campos de esta linea con los datos que viene de AJAX
//            if(datos.precio !== undefined){
//                $(precioHidden).val(datos.precio);
//                $(precio).val(formateaNumeroContabilidad2(datos.precio));
//                $(iva).val(datos.tipoIVA);
//                $(iva).selectmenu('refresh', true);
//                $(IdArticulo).val(datos.Id);
//                $(cuenta).val(datos.CuentaContable);
//                facturaCalculoPrecioM(cantidad,precio,precioHidden,importe,iva,cuota,total,esValido);
//            //sino 
//            }else{
////                $(precioHidden).val(desFormateaNumeroContabilidad(precio.value));
////                $(precio).val(formateaNumeroContabilidad2(datos.precio));
//            }
//        }
//    });
//
//    <?php
//    }else{
    ?>//
//    //solo indicamos que el IdArticulo es 0
//    $(IdArticulo).val('0');
//    <?php
//    }
?>//
//}
//}


function copiarCuentaHidden(cuenta,cuentaHidden){
    cuentaHidden.value = cuenta.value;
}

</script>

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>

    <div data-role="content" data-theme="a">
        <form id="form1" name="form1" method="post" action="../movil/ingresos_CFIVA1SIRPFVC_Linea.php"  data-ajax="false">
        
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
                        <label><b>Datos del concepto</b></label>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <?php
                        //funcion general
                        autocomplete_cuentas_SubGrupo4('nombreCuenta',7);
                        ?>
                        <label>Cuenta de Ingreso</label>
                        <input type="hidden" id="cuenta" name="cuenta" value="<?php if(isset($_SESSION['ingresos_CFIVA1SIRPFVC']['datos']['cuentas'][$_GET['IdLinea']]['idCuenta'])){echo $_SESSION['ingresos_CFIVA1SIRPFVC']['datos']['cuentas'][$_GET['IdLinea']]['idCuenta'];} ?>">
                        <textarea id="nombreCuenta" name="nombreCuenta" rows=4 cols="20" onfocus="javascript:document.form1.concepto.style.borderColor='#aaa666';"
                                  onkeypress="" onkeyup="" onChange="copiarCuentaHidden(this,document.form1.cuenta)"
                                  ><?php echo htmlentities($_SESSION['ingresos_CFIVA1SIRPFVC']['datos']['cuentas'][$_GET['IdLinea']]['strCuenta'],ENT_QUOTES,'UTF-8');?></textarea>
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2">
                        <label>Base Imponible</label>
                        <input type="text" name="importe" id="importe"
                               onfocus="onFocusInputTextM(this);desFormateaCantidad(this);" 
                               onblur="solonumerosM(this);formateaCantidad(this);
                                       asientoCalculoImporte(this,document.form1.iva,document.form1.cuota,document.form1.total);sumas();"
                               value="<?php if(isset($_SESSION['ingresos_CFIVA1SIRPFVC']['datos']['cuentas'][$_GET['IdLinea']]['cantidad'])){echo formateaNumeroContabilidad($_SESSION['ingresos_CFIVA1SIRPFVC']['datos']['cuentas'][$_GET['IdLinea']]['cantidad']);} ?>" />
                    </td>
                    <td colspan="2">
                        <label>IVA</label>
                        <?php
                        $cuota = $_SESSION['ingresos_CFIVA1SIRPFVC']['datos']['cuentas'][$_GET['IdLinea']]['cuota'];
                        $cantidad = $_SESSION['ingresos_CFIVA1SIRPFVC']['datos']['cuentas'][$_GET['IdLinea']]['cantidad'];
                        $total = $cuota + $cantidad;
                        $iva = (int)($cuota / $cantidad * 100);
                        //$iva=formateaNumeroContabilidad($_SESSION['presupuestoActivo']['DetallePresupuesto'][$linea]['iva']);
                        if($iva===0){
                        $textoiva='<option value="0" selected>0</option>'.
                                  '<option value="4">4</option>'.
                                  '<option value="10">10</option>'.
                                  '<option value="21">21</option>';
                        }else if($iva===4){
                        $textoiva='<option value="0">0</option>'.
                                  '<option value="4" selected>4</option>'.
                                  '<option value="10">10</option>'.
                                  '<option value="21">21</option>';
                        }else if($iva===10){
                        $textoiva='<option value="0">0</option>'.
                                  '<option value="4">4</option>'.
                                  '<option value="10" selected>10</option>'.
                                  '<option value="21">21</option>';
                        }else if($iva===21){
                        $textoiva='<option value="0">0</option>'.
                                  '<option value="4">4</option>'.
                                  '<option value="10">10</option>'.
                                  '<option value="21" selected>21</option>';
                        }else{
                        $textoiva='<option value="0">0</option>'.
                                  '<option value="4">4</option>'.
                                  '<option value="10">10</option>'.
                                  '<option value="21" selected>21</option>';
                        }
                        ?>
                        <select name="iva" id="iva" 
                                onChange="facturaCalculoIVA(document.form1.importe,this,document.form1.cuota,document.form1.total);" 
                                data-native-menu="false" data-theme='a'>
                            <?php echo $textoiva;?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label>Cuota IVA</label>
                        <input type="text" name="cuota" id="cuota" readonly
                               value="<?php if(isset($_SESSION['ingresos_CFIVA1SIRPFVC']['datos']['cuentas'][$_GET['IdLinea']]['cantidad'])){echo formateaNumeroContabilidad($_SESSION['ingresos_CFIVA1SIRPFVC']['datos']['cuentas'][$_GET['IdLinea']]['cuota']);} ?>" />
                    </td>
                    <td colspan="2">
                        <label>TOTAL</label>
                        <input type="text" name="total" id="total" readonly
                               value="<?php if(isset($_SESSION['ingresos_CFIVA1SIRPFVC']['datos']['cuentas'])){echo formateaNumeroContabilidad($total);} ?>" />
                    </td>
                </tr>
                <tr>
                    <td height="15px"></td>
                </tr>                
                <tr>
                    <td colspan="2">
                        <input type="button" data-icon="check" id="cmdAlta" value = "Grabar Linea" data-mini="true"
                               onclick="javascript:validar2();" data-theme="a" />
                    </td>
                    <td colspan="2">
                        <input type="button" data-icon="delete" value = "Borrar" data-mini="true"
                               onclick="javascript:borrar();" data-theme="a"
                               <?php if($_GET['IdLinea']==='Nuevo'){echo ' disabled';} ?> 
                               />
                        
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2">
                        <input type="button" data-icon="back" value = "Volver" data-mini="true"
                               onclick="javascript:window.location='../vista/ingresos_CFIVA1SIRPFVC.php';" data-theme="a" />
                    </td>
                </tr>
            </tbody>
        </table>    
        <input type="hidden" name="opcion" value = "" />
        <input type="hidden" name="esValido" value = "true" />
        <input type="hidden" name="IdLinea" value = "<?php echo $_GET['IdLinea'] ;?>" />
        
<!--        <input type="hidden" name="SePuedeImprimir" 
               value = "<?php //if(isset($_SESSION['presupuestoActivo'])){echo $_SESSION['presupuestoActivo']['SePuedeImprimir'];} ?>" />-->

        
        
    </form>
    </div>

    </div>    
    </body>
</html>
