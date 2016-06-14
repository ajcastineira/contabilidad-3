<?php
session_start();

require_once '../CN/clsCNContabilidad.php';
require_once '../CN/clsCNConsultas.php';
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


$clsCNConsultas=new clsCNConsultas();
$clsCNConsultas->setStrBD($_SESSION['dbContabilidad']);
$clsCNUsu=new clsCNUsu();
$clsCNUsu->setStrBD($_SESSION['dbContabilidad']);

$datosUsuarioActivo=$clsCNUsu->DatosUsuario($_SESSION['usuario']);




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
    <div data-role="page" id="altapresupuestoLineaEditar">
<?php
eventosInputText();
?>
<script language="JavaScript">
    
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
    var cantidadNumero=parseFloat(desFormateaNumeroContabilidad(document.form1.cantidad.value));
    var precioNumero=parseFloat(desFormateaNumeroContabilidad(document.form1.precio.value));
    if(!(cantidadNumero===0 && precioNumero===0)){
        var importeComp=cantidadNumero*precioNumero;
        importeComp=truncar2dec(importeComp);
        var importeNumero=parseFloat(desFormateaNumeroContabilidad(document.form1.importe.value));
        if(importeComp!==importeNumero){
            textoError=textoError+"Los datos introducidos no son correctos, hay una incongruencia en cantidad, precio o importe.\n";
            $('#importe').parent().css('border-color','red');
            $('#cantidad').parent().css('border-color','red');
            $('#precio').parent().css('border-color','red');
            esValido=false;
        }
    }

    //compruebo que el concepto no esté vacio
    if(document.form1.concepto.value == ''){
        textoError=textoError+"Debe haber algún dato en el concepto.\n";
        document.form1.concepto.style.borderColor='red';
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

function DesactivaImprimir(){
    document.form1.SePuedeImprimir.value='NO';
}

function borrar(){
    if (confirm("¿Desea borrar este concepto del presupuesto?"))
    {
        document.form1.opcion.value='Borrar';  
        document.getElementById("cmdAlta").value = "Enviando...";
        document.getElementById("cmdAlta").disabled = true;
        document.form1.submit();
    }
}

</script>

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>

    <div data-role="content" data-theme="a">
        <form name="form1" method="post" action="../movil/altapresupuestoLineaEditar.php"  data-ajax="false">
        
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
                    <td colspan="2">
                        <label>Cantidad</label>
                        <input type="text" name="cantidad" maxlength="12" id="cantidad"
                               onfocus="onFocusInputTextM(this);desFormateaCantidad(this);" 
                               onkeypress="DesactivaImprimir();" onkeyup="DesactivaImprimir();"
                               onblur="solonumerosM(this);formateaCantidad(this);
                                       facturaCalculoCantidad(this,document.form1.precio,document.form1.importe,document.form1.iva,document.form1.cuota,document.form1.total);"
                               value="<?php if(isset($_SESSION['presupuestoActivo'])){echo formateaNumeroContabilidad($_SESSION['presupuestoActivo']['DetallePresupuesto'][$linea]['cantidad']);} ?>" />
                    </td>
                    <td colspan="2">
                        <label>Precio</label>
                        <input type="text" name="precio" maxlength="12" id="precio"
                               onfocus="onFocusInputTextM(this);desFormateaCantidad(this);" 
                               onkeypress="DesactivaImprimir();" onkeyup="DesactivaImprimir();"
                               onblur="solonumerosM(this);formateaCantidad(this);
                                       facturaCalculoPrecio(document.form1.cantidad,this,document.form1.importe,document.form1.iva,document.form1.cuota,document.form1.total,document.form1.esValido);"
                               value="<?php if(isset($_SESSION['presupuestoActivo'])){echo formateaNumeroContabilidad($_SESSION['presupuestoActivo']['DetallePresupuesto'][$linea]['precio']);} ?>" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label>Importe</label>
                        <input type="text" name="importe" id="importe"
                               onfocus="onFocusInputTextM(this);desFormateaCantidad(this);" 
                               onkeypress="DesactivaImprimir();" onkeyup="DesactivaImprimir();"
                               onblur="solonumerosM(this);formateaCantidad(this);
                                       facturaCalculoImporte(document.form1.cantidad,document.form1.precio,this,document.form1.iva,document.form1.cuota,document.form1.total,document.form1.esValido);"
                               value="<?php if(isset($_SESSION['presupuestoActivo'])){echo formateaNumeroContabilidad($_SESSION['presupuestoActivo']['DetallePresupuesto'][$linea]['importe']);} ?>" />
                    </td>
                    <td colspan="2">
                        <label>IVA</label>
                        <?php
                        $iva=formateaNumeroContabilidad($_SESSION['presupuestoActivo']['DetallePresupuesto'][$linea]['iva']);
                        if($iva==='0,00'){
                        $textoiva='<option value="0" selected>0</option>'.
                                  '<option value="4">4</option>'.
                                  '<option value="10">10</option>'.
                                  '<option value="21">21</option>';
                        }else if($iva==='4,00'){
                        $textoiva='<option value="0">0</option>'.
                                  '<option value="4" selected>4</option>'.
                                  '<option value="10">10</option>'.
                                  '<option value="21">21</option>';
                        }else if($iva==='10,00'){
                        $textoiva='<option value="0">0</option>'.
                                  '<option value="4">4</option>'.
                                  '<option value="10" selected>10</option>'.
                                  '<option value="21">21</option>';
                        }else if($iva==='21,00'){
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
                        <select name="iva" id="iva" onChange="facturaCalculoIVA(document.form1.importe,this,document.form1.cuota,document.form1.total);DesactivaImprimir();" data-native-menu="false" data-theme='a'>
                            <?php echo $textoiva;?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label>Cuota IVA</label>
                        <input type="text" name="cuota" id="cuota" readonly
                               value="<?php if(isset($_SESSION['presupuestoActivo'])){echo formateaNumeroContabilidad($_SESSION['presupuestoActivo']['DetallePresupuesto'][$linea]['cuota']);} ?>" />
                    </td>
                    <td colspan="2">
                        <label>TOTAL</label>
                        <input type="text" name="total" id="total" readonly
                               value="<?php if(isset($_SESSION['presupuestoActivo'])){echo formateaNumeroContabilidad($_SESSION['presupuestoActivo']['DetallePresupuesto'][$linea]['total']);} ?>" />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>Concepto</label>
                        <textarea name="concepto" rows=4 cols="20" onfocus="javascript:document.form1.concepto.style.borderColor='#aaa666';
"
                                  onkeypress="DesactivaImprimir();" onkeyup="DesactivaImprimir();"
                                  ><?php if(isset($_SESSION['presupuestoActivo'])){echo $_SESSION['presupuestoActivo']['DetallePresupuesto'][$linea]['concepto'];} ?></textarea>
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
                        <input type="button" data-icon="delete" value = "Borrar" 
                               onclick="javascript:borrar();" data-theme="a" data-mini="true"
                               <?php if($_GET['IdLinea']==='Nuevo'){echo ' disabled';} ?> 
                               <?php if($_SESSION['presupuestoActivo']['DetallePresupuesto'][$linea]['estaFacturado']==='SI'){echo ' disabled';} ?> />
                        
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2">
                        <input type="button" data-icon="back" value = "Volver" data-mini="true"
                               onclick="javascript:history.back();" data-theme="a" />
                    </td>
                </tr>
            </tbody>
        </table>    
        <input type="hidden" name="opcion" value = "" />
        <input type="hidden" name="esValido" value = "true" />
        <input type="hidden" name="IdLinea" value = "<?php echo $linea; ?>" />
        
        <input type="hidden" name="SePuedeImprimir" 
               value = "<?php if(isset($_SESSION['presupuestoActivo'])){echo $_SESSION['presupuestoActivo']['SePuedeImprimir'];} ?>" />

        
        
    </form>
    </div>

    </div>    
    </body>
</html>
