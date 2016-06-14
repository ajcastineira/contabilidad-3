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


//primero controlo que vengo de facturar_presupuesto.php
//sino es asi vuelvo a default2.php
if(isset($_SESSION['FP'])){
    //es uno de estos dos ficheros que continue el flujo
}else{
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/default2.php">';die;
}


//venimos del menu principal alta o Modificacion/Duplicar/Borrar
if(isset($_GET['IdPresupuesto'])){
    logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['srtBD'].', SesionID: '.  session_id().
           " ||||Mis Presupuestos->Facturar Presupuesto||");

    $datosPresupuesto=$clsCNContabilidad->datosPresupuesto($_GET['IdPresupuesto']);
    //extraemos los datos de nuestra empresa
    $datosNuestraEmpresa=$clsCNContabilidad->datosNuestraEmpresaPresupuesto();
    
    
    
}else{
    logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
           " ||||Vuelvo al principal");
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/default2.php">';die;
}


//extraigo el listado de contactos y clientes
$listadoContactos=$clsCNContabilidad->listadoContactos();

//ahora preparo la consulta select (las opciones)
$htmlSelect='';
if(is_array($listadoContactos)){
    foreach($listadoContactos as $contacto){
        if(isset($contacto['IdContacto'])){
            $value=$contacto['IdContacto'];
            $tipo='CO';
        }else if(isset($contacto['NumCuenta'])){
            $value=$contacto['NumCuenta'];
            $tipo='CL';
        }
        $texto=$contacto['NombreEmpresa'];
        //comprobamos si venimos de editar (existe la vble $datosPresupuesto[Contacto_Cliente]
        $contactoCliente=$tipo.'.'.$value;

        if($contactoCliente==$datosPresupuesto['Contacto_Cliente'] || $contactoCliente==('CO.'.$_GET['IdContacto'])){
            $htmlSelect=$htmlSelect.'<input type="text" class="textbox1" name="Contacto" value="'.$texto.'" readonly />';
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
<TITLE>Facturar Presupuesto - Elegir los conceptos</TITLE>

<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>

</head> 
    <body>
        
    <div data-role="page" id="factura-presup_parcial">
<?php
eventosInputText();
?>
<script language="JavaScript">

//REVISAR TODO
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
            $('#Contacto').val(cliente.NombreEmpresa);
            $('#CIF').val(cliente.CIF);
            $('#direccion').val(cliente.direccion);
            $('#poblacion').val(cliente.poblacion);
            $('#provincia').val(cliente.provincia);
            $('#email').val(cliente.Correo);
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
            //comprobamos que el check este checked, sino no suma
            if(nombreElemento.substring(0,7)==='importe'){//es un elemento importe
                var nombreCheck='check'+nombreElemento.substring(7);
                if(document.getElementById(nombreCheck).checked){//comprobación del check
                    importeTotal=parseFloat(importeTotal)+parseFloat(desFormateaNumeroContabilidad(elemento.value));
                }    
            }            
            if(nombreElemento.substring(0,5)==='cuota'){//es un elemento cuota
                var nombreCheck='check'+nombreElemento.substring(5);
                if(document.getElementById(nombreCheck).checked){//comprobación del check
                    cuotaTotal=parseFloat(cuotaTotal)+parseFloat(desFormateaNumeroContabilidad(elemento.value));
                }
            }
        });
    });
    
    importeTotal=truncar2dec(importeTotal);
    cuotaTotal=truncar2dec(cuotaTotal);
    
    total=parseFloat(importeTotal)+parseFloat(cuotaTotal);
    total=truncar2dec(total);

    //irpf
    //facturaCalculoIRPF(document.form1.totalImporte,document.form1.total,document.form1.irpf,document.form1.IRPFcuota,document.form1.totalFinal);
    var IRPFcuota = 0;
    var totalFinal = 0;
    IRPFcuota=parseFloat(importeTotal)*parseFloat(document.form1.irpf.value)/100;
    IRPFcuota=truncar2dec(IRPFcuota);

    totalFinal=total-IRPFcuota;
    
    importeTotal=formateaNumeroContabilidad(importeTotal.toString());
    document.getElementById('totalImporte').innerHTML=importeTotal;
        
    cuotaTotal=formateaNumeroContabilidad(cuotaTotal.toString());
    document.getElementById('totalCuota').innerHTML=cuotaTotal;
        
    total=formateaNumeroContabilidad(total.toString());
    document.getElementById('total').innerHTML=total;
    
    IRPFcuota=formateaNumeroContabilidad(IRPFcuota.toString());
    document.getElementById('IRPFcuota').innerHTML=IRPFcuota;
    
    totalFinal=formateaNumeroContabilidad(totalFinal.toString());
    document.getElementById('totalFinal').innerHTML=totalFinal;
}

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

function generarFactura(){
    //cuento todos los check que hay
    var checkTotal=0;
    $("input[type='checkbox']").each(function(){
        checkTotal++;
    });
    
    //y ahora cuento todos los check marcados (:checked)
    var checkON=0;
    $("input[type='checkbox']:checked").each(function(){
        checkON++;
    });
    
    if(checkON===0){
        //error
        alert('No hay seleccionado ningún concepto.');
    }else{
        // si las cantidades coinciden es que estan todos los check seleccionados
        //por lo que es una factura total, se lo notificamos como tal, sino le indicamos que es parcial
        if(checkTotal==checkON){
            //total
            alert('Se va a facturar totalmente el presupuesto');
        }else{
            //parcial
            alert('Se va a facturar parcialmente el presupuesto');
        }
        
        //por último se submite el formulario
        document.getElementById("generar").value = "Generando...";
        document.getElementById("generar").disabled = true;
        document.form1.submit();
    }
}

function quitarCheck(){
    $("input[type='checkbox']").each(function(){
        this.remove();
    });
}

//function salir(){
//    window.location='../vista/default2.php';
//}

function volver(){
    javascript:history.back();
}

</script>
<script>
$(document).ready(function() {
    <?php
    $contacto='';
    if(isset($datosPresupuesto['Contacto_Cliente'])){
        $contacto=$datosPresupuesto['Contacto_Cliente'];
    }else
    if(isset($datosPresupuesto['Contacto'])){
        $contacto=$datosPresupuesto['Contacto'];
    }
    
    if($contacto<>''){
    //quitamos los check si es contacto o no es Aceptado
    $datosContacto=explode('.',$datosPresupuesto['Contacto_Cliente']);
    if(($datosContacto==='CO') || ($datosPresupuesto['Estado']<>'Aceptado')){
        echo 'quitarCheck();';
    }
    ?>
            
    rellenarDatos("<?php echo $contacto; ?>","Editar");    
    <?php
    }
    ?>
});
</script>


    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>

    <div data-role="content" data-theme="a">
        <form name="form1" id="form1" method="post" action="../vista/factura_presup_parcial.php" data-ajax="false">
        <?php
        if(isset($datosPresupuesto['numPresupuesto'])){
            $num=$datosPresupuesto['numPresupuesto'];
        }else
        if(isset($datosPresupuesto['NumPresupuesto'])){
            $num=$datosPresupuesto['NumPresupuesto'];
        }
        ?>
        <h3 align="center"><font size="3px">Presupuesto <?php echo $num; ?></font></h3>
        <br/>
        
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
                        <label><b>Datos del Cliente</b></label>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>Att de D./Dña (Lectura)</label>
                        <input type="text" name="Cliente" id="Cliente" readonly />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>Cliente (Lectura)</label>
                        <input type="text" name="Contacto" id="Contacto" readonly />
                        <input type="hidden" id="ContactoHidden" name="ContactoHidden" value="<?php if(isset($datosPresupuesto)){echo $datosPresupuesto['Contacto_Cliente'];} ?>" />
                        <input type="hidden" name="NumPresupuesto" value="<?php if(isset($datosPresupuesto)){echo $datosPresupuesto['NumPresupuesto'];} ?>" />
                        <input type="hidden" name="NumPresupuestoBBDD" value="<?php if(isset($datosPresupuesto)){echo $datosPresupuesto['NumPresupuestoBBDD'];} ?>" />
                        <input type="hidden" name="fechaPresup" value="<?php if(isset($datosPresupuesto)){echo $datosPresupuesto['FechaPresupuesto'];} ?>" />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>CIF (Lectura)</label>
                        <input type="text" name="CIF" id="CIF" readonly />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>Dirección (Lectura)</label>
                        <input type="text" name="direccion" id="direccion" readonly />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>Población (Lectura)</label>
                        <input type="text" name="poblacion" id="poblacion" readonly />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>Provincia (Lectura)</label>
                        <input type="text" name="provincia" id="provincia" readonly />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>Forma de Pago</label>
                        <?php
                        if(isset($datosPresupuesto['FormaPago'])){
                            $FormaPago=$datosPresupuesto['FormaPago'];
                        }else
                        if(isset($datosPresupuesto['FormaPagoHabitual'])){
                            $FormaPago=$datosPresupuesto['FormaPagoHabitual'];
                        }
                        ?>
                        <input type="text" name="FormaPagoHabitual" id="FormaPagoHabitual" value="<?php echo $FormaPago; ?>" readonly />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label>Proforma</label>
                        <input type="text" name="Proforma" id="Proforma" value="<?php if($datosPresupuesto['Proforma']==='0'){echo 'No';}else{echo 'Si';}?>" readonly />
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <label>Validez Presupuesto (Dias)</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <?php
                        if(isset($datosPresupuesto['Validez'])){
                            $validez=$datosPresupuesto['Validez'];
                        }else
                        if(isset($datosPresupuesto['validez'])){
                            $validez=$datosPresupuesto['validez'];
                        }
                        
                        $presentarValidez='';
                        if(isset($datosPresupuesto)){
                            $presentarValidez=$validez;
                            if((int)$presentarValidez==0){
                                $presentarValidez='';
                            }
                        }else{
                            $presentarValidez='15';
                        }
                        
                        ?>
                        <input type="text" name="validez" id="validez"
                               value="<?php echo $presentarValidez; ?>" readonly />
                    </td>
                </tr>
                <tr>
                    <td height="30px"></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label><b>Detalle de los Conceptos</b></label>
                    </td>
                </tr>
                <tr>
                    <td height="15px"></td>
                </tr>
            </tbody>
        </table>        
        
        <ul data-role="listview" data-dividertheme="a">
        <?php 
        if(is_array($datosPresupuesto['DetallePresupuesto'])){ 
            //y voy sumando el importe y la cuota
            $totalImportePres=0;
            $totalCuotaPres=0;
            ?>
            <?php for($i=0;$i<count($datosPresupuesto['DetallePresupuesto']);$i++){
                $link=""; 

                $IdPresupLineaPres=  $datosPresupuesto['DetallePresupuesto'][$i]['IdPresupLineas'];
                $NumLineaPresupPres=  $datosPresupuesto['DetallePresupuesto'][$i]['NumLineaPresup'];
                $IdArticuloPres=  $datosPresupuesto['DetallePresupuesto'][$i]['IdArticulo'];
                $estaFacturadoPres=  $datosPresupuesto['DetallePresupuesto'][$i]['estaFacturado'];
                $cantidadPres=  formateaNumeroContabilidad($datosPresupuesto['DetallePresupuesto'][$i]['cantidad']);
                $conceptoPres=  $datosPresupuesto['DetallePresupuesto'][$i]['concepto'];
                $precioPres=  formateaNumeroContabilidad($datosPresupuesto['DetallePresupuesto'][$i]['precio']);
                $importePres=  formateaNumeroContabilidad($datosPresupuesto['DetallePresupuesto'][$i]['importe']);
                $ivaPres=  formateaNumeroContabilidad($datosPresupuesto['DetallePresupuesto'][$i]['iva']);
                $cuotaPres=  formateaNumeroContabilidad($datosPresupuesto['DetallePresupuesto'][$i]['cuota']);
                $totalPres=  formateaNumeroContabilidad($datosPresupuesto['DetallePresupuesto'][$i]['importe']+$datosPresupuesto['DetallePresupuesto'][$i]['cuota']);
                $totalImportePres=$totalImportePres+$datosPresupuesto['DetallePresupuesto'][$i]['importe'];
                $totalCuotaPres=$totalCuotaPres+$datosPresupuesto['DetallePresupuesto'][$i]['cuota'];

                ?>
                <li onClick="<?php echo $link; ?>">
                    <script>
                    function OnOff(i){
                        if(document.getElementById('check'+i).checked===true){
                            document.getElementById('check'+i).checked=false;
                        }else{
                            document.getElementById('check'+i).checked=true;
                        }
                    }
                    </script>
                    <a href="#" data-ajax="false" onClick="OnOff(<?php echo ($i+1);?>);sumas();">
                        <table border="0" style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td style="width: 10%;"></td>
                                    <td style="width: 30%;"></td>
                                    <td style="width: 50%;"></td>
                                    <td style="width: 20%;"></td>
                                </tr>
                                <tr>
                                    <td>
                                    </td>
                                    <td>
                                        <?php echo '<font style="font-style: initial !important;" color="30a53b">&nbsp;&nbsp;Importe: </font>'; ?>
                                    </td>
                                    <td>
                                        <div align="right" style="font-style: initial;"> 
                                        <?php echo $importePres; ?>
                                        <input type="hidden" name="importe<?php echo ($i+1);?>" id="importe<?php echo ($i+1);?>" value="<?php echo $importePres; ?>" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left">
                                        <input type="checkbox" id="check<?php echo ($i+1);?>" name="check<?php echo ($i+1);?>" checked onclick="sumas();" />
                                    </td>
                                    <td>
                                        <?php echo '<font color="30a53b">&nbsp;&nbsp;Cuota: </font>'; ?>
                                    </td>
                                    <td>
                                        <div align="right"> 
                                        <?php echo $cuotaPres; ?>
                                        <input type="hidden" name="cuota<?php echo ($i+1);?>" id="cuota<?php echo ($i+1);?>" value="<?php echo $cuotaPres; ?>" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <?php echo '<font color="30a53b">&nbsp;&nbsp;Total: </font>'; ?>
                                    </td>
                                    <td>
                                        <div align="right"> 
                                        <?php echo $totalPres; ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="hidden" name="idPresupLinea<?php echo ($i+1);?>" value="<?php echo $IdPresupLineaPres; ?>" />
                        <input type="hidden" name="numLineaPresup<?php echo ($i+1);?>" value="<?php echo $NumLineaPresupPres; ?>" />
                        <input type="hidden" name="IdArticulo<?php echo ($i+1);?>" value="<?php echo $IdArticuloPres; ?>" />
                        <input type="hidden" name="cantidad<?php echo ($i+1);?>" value="<?php echo $cantidadPres; ?>" />
                        <input type="hidden" name="concepto<?php echo ($i+1);?>" value="<?php echo $conceptoPres; ?>" />
                        <input type="hidden" name="precio<?php echo ($i+1);?>" value="<?php echo $precioPres; ?>" />
                        <input type="hidden" name="iva<?php echo ($i+1);?>" value="<?php echo $ivaPres; ?>" />
                        <input type="hidden" name="total<?php echo ($i+1);?>" value="<?php echo $totalPres; ?>" />
                        <input type="hidden" name="linea" value="<?php echo count($datosPresupuesto['DetallePresupuesto']); ?>" />
                        <input type="hidden" name="esValido" value="SI" />
                        
                        <?php echo '<font color="30a53b">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Concepto: </font>'.$conceptoPres; ?>
                    </a>
                </li>
            <?php } ?>
        <?php } ?>
        </ul>        
        
        <!-- Subtotales y Totales-->
        <a href="#" data-ajax="false">
            <table border="0" style="width: 100%;">
                <tbody>
                    <tr>
                        <td height="15px"></td>
                    </tr>
                    <tr>
                        <td style="width: 15%;"></td>
                        <td style="width: 30%;"></td>
                        <td style="width: 40%;"></td>
                        <td style="width: 15%;"></td>
                    </tr>
<!--                    <input type="hidden" name='conceptoOpcion' />-->
                    <tr>
                        <td height="15px"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <?php echo '<font color="30a53b">Subtotal: </font>'; ?>
                        </td>
                        <td>
                            <div align="right"> 
                            <?php echo '<span id="totalImporte">'.formateaNumeroContabilidad($totalImportePres).'</span>'; ?>
<!--                            <input type="hidden" name="totalImporte" id="totalImporte" />-->
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <?php echo '<font color="30a53b">Cuota: </font>'; ?>
                        </td>
                        <td>
                            <div align="right"> 
                            <?php echo '<span id="totalCuota">'.formateaNumeroContabilidad($totalCuotaPres).'</span>'; ?>
<!--                            <input type="hidden" name="totalCuota" id="totalCuota" />-->
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <?php echo '<font color="30a53b">Total: </font>'; ?>
                        </td>
                        <td>
                            <div align="right"> 
                            <?php echo '<span id="total">'.formateaNumeroContabilidad($totalImportePres+$totalCuotaPres).'</span>'; ?>
                            </div>
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
                    $tipoIRPF=$clsCNContabilidad->Parametro_general('Tipo IRPF',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));
                    if($numIRPF==='0'){
                        if((int)$tipoIRPF===0){
                            $IRPF_SI='NO';
                        }
                    }

                    ?>
                    <?php if($IRPF_SI==='SI'){ ?>
                    <tr>
                        <td></td>
                        <td>
                            <?php echo '<font color="30a53b">IRPF: </font>'; ?>
                        </td>
                        <td>
                            <div align="right"> 
                                <?php echo $numIRPF; ?>
                                <input type="hidden" name="irpf" value="<?php echo $numIRPF; ?>" />    
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <?php echo '<font color="30a53b">Retención: </font>'; ?>
                        </td>
                        <td>
                            <div align="right"> 
                                <span id="IRPFcuota">
                                    <?php echo formateaNumeroContabilidad($totalImportePres*$datosPresupuesto['Retencion']/100); ?>
                                </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <?php echo '<font color="30a53b">TOTAL: </font>'; ?>
                        </td>
                        <td>
                            <div align="right"> 
                                <span id="totalFinal">
                                    <?php echo formateaNumeroContabilidad(($totalImportePres+$totalCuotaPres)- ($totalImportePres*$datosPresupuesto['Retencion']/100)); ?>
                                </span>
                            </div>
                        </td>
                    </tr>
                    <?php }else{ ?>
                    <div style="display: none;">
                        <span id="IRPFcuota">
                            <?php echo formateaNumeroContabilidad($totalImportePres*$datosPresupuesto['Retencion']/100); ?>
                        </span>
                        <span id="totalFinal">
                            <?php echo formateaNumeroContabilidad(($totalImportePres+$totalCuotaPres)- ($totalImportePres*$datosPresupuesto['Retencion']/100)); ?>
                        </span>
                        <input type="hidden" name="irpf" value="<?php echo $numIRPF; ?>" />
                    </div>
                
                
<!--                    <input type="hidden" name="IRPFcuota" />-->
                    <?php } ?>
<!--                    <input type="hidden" name="totalFinal" />-->
                    
                    <tr>
                        <td height="15px"></td>
                    </tr>
                </tbody>
            </table>
        </a>
        <br/>
        
        <!--botones-->
        <!--<div data-role="footer" data-theme="c" data-position="fixed">-->
        <table border="0" style="width: 100%;">
            <tbody>
                <tr>
                    <td style="width: 22%;"></td>
                    <td style="width: 23%;"></td>
                    <td style="width: 23%;"></td>
                    <td style="width: 22%;"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2">
                        <input type="button" data-icon="back" data-theme="a" data-mini="true" id='cmdAnterior'
                               value = "Volver" onclick="javascript:history.back();" /> 
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2">
                        <?php
                        if($datosContacto[0]==='CL'){
                            if($datosPresupuesto['Estado']==='Aceptado'){
                            ?>
                                <input type="button" id="generar" name="generar" value = "Generar Factura" 
                                       data-icon="star" data-iconpos="right" data-theme="a" data-mini="true"
                                       class="button" onClick="generarFactura();" />
                            <?php
                            }
                        }else{
                        ?>
                            <input type="button" value = "Pasar este Contacto a Cliente" 
                                   data-icon="star" data-iconpos="right" data-theme="a" data-mini="true"
                                   onClick="javascript:document.location.href='../movil/altacontacto.php?IdContacto=<?php echo $datosContacto[1]; ?>';" />
                        <?php
                        }
                        ?>
                        <input type="hidden" name="IdPresupuesto" value="<?php echo $_GET['IdPresupuesto'];?>"/>     
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
    </div>

    </div>  
        
    </body>
</html>



