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

var_dump($_SESSION['ingresos_CFIVA1SIRPFVC']);die;

//compruebo si venimos con la variable de sesion $_SESSION['presupuestoActivo']
//sino viniesemos nos redireccionamos a default2.php (main)
if(!isset($_GET['IdLinea']) && $_GET['IdLinea'] !== ''){
    //este presupuesto esta borrado por lo que volvemos al menu
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../movil/default2.php">';die;
}


$clsCNContabilidad=new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['dbContabilidad']);
$clsCNContabilidad->setStrBDCliente($_SESSION['mapeo']);



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


if(isset($_POST['opcion']) && $_POST['opcion']==='Grabar'){
    $_SESSION['presupuestoActivo']['SePuedeImprimir']=$_POST['SePuedeImprimir'];
    $_SESSION['presupuestoActivo']['irpf']=$_POST['irpf'];
    //paso a un fichero 'altafacturaFinal.php' donde preparo fun formulario 
    //con todos los datos para que le lleguen igual que por 'vista'
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../movil/altafacturaFinal.php?pant=2">';die;
}

if(isset($_POST['opcion']) && $_POST['opcion']==='anterior'){
    $_SESSION['presupuestoActivo']['SePuedeImprimir']=$_POST['SePuedeImprimir'];
    $_SESSION['presupuestoActivo']['irpf']=$_POST['irpf'];

    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../movil/altafactura.php?IdFactura='.$_SESSION['presupuestoActivo']['IdFactura'].'">';die;
}

if(isset($_POST['opcion']) && $_POST['opcion']==='concepto'){
    $_SESSION['presupuestoActivo']['SePuedeImprimir']=$_POST['SePuedeImprimir'];
    $_SESSION['presupuestoActivo']['irpf']=$_POST['irpf'];

    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../movil/altafacturaLineaEditar.php?IdLinea='.$_POST['conceptoOpcion'].'">';die;
}

//venimos del menu principal alta o Modificacion/Duplicar/Borrar
if(isset($_GET['IdLinea']) && $_GET['IdLinea'] !== ''){
    logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['srtBD'].', SesionID: '.  session_id().
           " ||||Contabilidad->Modificar Asiento (Linea)||");

//    $datosLinea = '';
//    if($_GET['IdLinea'] !== 'Nuevo'){
//        $datosLinea = $clsCNContabilidad->DatosLineaMovimientos($_GET['IdLinea']);
//    }
    
//    var_dump($datosLinea);die;
    
//    if($datosPresupuesto['Borrado']==='0'){
//        //este presupuesto esta borrado por lo que volvemos al menu
//        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../movil/default2.php">';die;
//    }
    
//}else{
//    logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
//           " ||||Mis Facturas->Alta||");
//    $numeroNuevoPresupuesto=$clsCNContabilidad->NumeroNuevoPresupuesto();
//    $tipoContador=$clsCNContabilidad->Parametro_general('Tipo Contador',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));
}

//$tipoContador=$clsCNContabilidad->Parametro_general('Tipo Contador',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));

?>
<!DOCTYPE html>
<html>
<head>
<TITLE>Asiento - Editar</TITLE>

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
    
function validar()
{
  esValido=true;
  textoError='';
  
  
  if(esValido===true){
    document.form1.opcion.value='Grabar';
    $('#cmdGrabar').button('disable'); 
    document.form1.submit();
  }else{
      if(textoError===''){textoError='Revise los datos. NO estan correctos';}
      alert(textoError);
      return false;
  }  
}

function anterior(){
    document.form1.opcion.value='anterior';
    $('#cmdAnterior').button('disable'); 
    document.form1.submit();
}

function Concepto(opcion){
    document.form1.opcion.value='concepto';
    document.form1.conceptoOpcion.value=opcion;
    document.form1.submit();
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


function DesactivaImprimir(){
    document.form1.SePuedeImprimir.value='NO';
    $('#Envio').button('disable'); 
}

//function Enviar(i){
//    //primero grabamos por ajax el presupuesto
//    
//    
////    if(document.form1.SePuedeImprimir.value==='SI'){    
//        var datos=preparaURL(i,'enviar');
//        
//        //aparece el formulario emergente
//        //$(".modalbox").fancybox();
//
//        $.ajax({
//          url: '../vista/facturaImprimir<?php //echo $tipoFactura; ?>.php?'+datos,
//          type:"get"
//        });
////    }else{
////        alert('No se puede enviar el PDF sin haber guardado el presupuesto');
////    }
//}

</script>
<script>
$(document).ready(function() {
    <?php
//    $contacto='';
//    if(isset($datosPresupuesto['Contacto_Cliente'])){
//        $contacto=$datosPresupuesto['Contacto_Cliente'];
//    }else
//    if(isset($datosPresupuesto['Contacto'])){
//        $contacto=$datosPresupuesto['Contacto'];
//    }
//    
//    if($contacto<>''){
//    ?>
        //rellenarDatos("//<?php //echo $contacto; ?>","Editar");    
    //<?php
//    }
    ?>
});
</script>


    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>

    <div data-role="content" data-theme="a">
    <form name="form1" method="get" action="../vista/ingresos_CFIVA1SIRPFVC.php" data-ajax="false">
        <?php
//        if(isset($datosPresupuesto['numFactura'])){
//            $num=$datosPresupuesto['numFactura'];
//        }else
//        if(isset($datosPresupuesto['NumFactura'])){
//            $num=$datosPresupuesto['NumFactura'];
//        }
        ?>
        <h3 align="center" color="#FFCC66"><font size="3px">Editar</font></h3>
        <?php
        //if($datosPresupuesto['Estado']==='Contabilizada'){
        ?>
            <!--<h3><center><font color="FF0000">Factura contabilizada. Sólo se editan los conceptos</font></center></h3>-->
        <?php
        //}
        ?>
        <br/>
        <ul data-role="listview" data-dividertheme="a">
        <?php 
        if(is_array($_SESSION['ingresos_CFIVA1SIRPFVC']['datos']['cuentas'])){ 
            //y voy sumando el importe y la cuota
            $totalImportePres=0;
            $totalCuotaPres=0;
            ?>
            <?php for($i=0;$i<count($datosPresupuesto['DetallePresupuesto']);$i++){
                //$link="javascript:document.location.href='../movil/altapresupuestoLineaEditar.php?IdLinea=".$i."';"; 
                $link="javascript:Concepto(".$i.");"; 

                $IdPresupLineaPres=  $datosPresupuesto['DetallePresupuesto'][$i]['IdPresupLineas'];
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
                    <a href="#" data-ajax="false">
                        <table border="0" style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td style="width: 5%;"></td>
                                    <td style="width: 30%;"></td>
                                    <td style="width: 55%;"></td>
                                    <td style="width: 20%;"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <?php echo '<font style="font-style: initial !important;" color="30a53b">Importe: </font>'; ?>
                                    </td>
                                    <td>
                                        <div align="right" style="font-style: initial;"> 
                                        <?php echo $importePres; ?>
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
                                        <?php echo $cuotaPres; ?>
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
                                        <?php echo $totalPres; ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <?php echo '<font color="30a53b">&nbsp;&nbsp;&nbsp;&nbsp;Concepto: </font>'.$conceptoPres; ?>
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
                    <?php
                    if($datosPresupuesto['Estado']<>'Contabilizada'){
                    ?>
                    <tr>
                        <td></td>
                        <td colspan="2">
                            <input type="button" data-icon="plus" name="cmdNuevoC" id="cmdNuevoC" data-theme="a" data-mini="true"
                                   value = "Nueva Linea" onclick="javascript:Concepto('Nuevo');" /> 
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                    <input type="hidden" name='conceptoOpcion' />
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
                            <?php echo formateaNumeroContabilidad($totalImportePres); ?>
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
                            <?php echo formateaNumeroContabilidad($totalCuotaPres); ?>
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
                            <?php echo formateaNumeroContabilidad($totalImportePres+$totalCuotaPres); ?>
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
                    if(isset($datosPresupuesto['irpf'])){
                        $numIRPF=$datosPresupuesto['irpf'];
                    }

                    //si $numIRPF=0, comprobamos si $tipoIRPF=0
                    $IRPF_SI='SI';
                    $tipoIRPF=$clsCNContabilidad->Parametro_general('Tipo IRPF',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));
                    if($numIRPF==='0'){
                        if((int)$tipoIRPF===0){
                            $IRPF_SI='NO';
                        }
                    }

                    //por ultimo veo si $tipoIRPF <> 0 , si es asi la casilla de Retencion (IRPF) se presenta
                    //y si es un presupuesto nuevo (no viene $_GET[IdPresupuesto]) la vble $numIRPF=$tipoIRPF
                    if(!isset($_SESSION['presupuestoActivo']['IdPresupuesto'])){
                        $numIRPF=$tipoIRPF;
                    }
                    ?>
                    <?php if($IRPF_SI==='SI'){ ?>
                    <tr>
                        <td></td>
                        <td>
                            <?php echo '<font color="30a53b">IRPF: </font>'; ?>
                        </td>
                        <td>
                            <select name="irpf" data-native-menu="false" data-theme='a' name="iprf" data-mini="true"
                                    onChange="facturaCalculoIRPF_M('<?php echo formateaNumeroContabilidad($totalImportePres); ?>','<?php echo formateaNumeroContabilidad($totalCuotaPres); ?>',this.value,document.getElementById('retencion'),document.getElementById('total'));
                                              DesactivaImprimir();">
                                <?php
                                listadoIVA($numIRPF,$datosPresupuesto['Estado']);
                                ?>          
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <?php echo '<font color="30a53b">Retención: </font>'; ?>
                        </td>
                        <td>
                            <div align="right"> 
                                <span id="retencion">
                                    <?php echo formateaNumeroContabilidad($totalImportePres*$datosPresupuesto['irpf']/100); ?>
                                </span>
                                <input type="hidden" name="cuotaIRPF" value="<?php echo $totalImportePres*$datosPresupuesto['irpf']/100; ?>" />    
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
                                <span id="total">
                                    <?php echo formateaNumeroContabilidad(($totalImportePres+$totalCuotaPres)- ($totalImportePres*$datosPresupuesto['irpf']/100)); ?>
                                </span>
                            </div>
                        </td>
                    </tr>
                    <?php }else{ ?>
                    <input type="hidden" name="irpf" value="<?php echo $numIRPF; ?>" />
                    <input type="hidden" name="IRPFcuota" />
                    <?php } ?>
                    
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
                    <td colspan="2">
                        <input type="button" data-icon="back" data-theme="a" data-mini="true" id='cmdAnterior'
                               value = "Anterior" onclick="javascript:anterior();" /> 
                    </td>
                    <td colspan="2">
                        <input type="button" data-icon="star" data-iconpos="right" id='cmdGrabar'
                               name="cmdAlta" id="cmdAlta" data-theme="a" data-mini="true" 
                               value = "Grabar" onclick="javascript:validar();"
                                <?php
                                if(isset($datosPresupuesto['DetallePresupuesto'])){ 
                                    if(count($datosPresupuesto['DetallePresupuesto'])>0){
                                    }else{
                                        echo 'disabled="true"';
                                    }
                                }else{
                                    echo 'disabled="true"';
                                }
                                ?>
                               /> 
                        <input type="hidden" name="opcion" value="" />
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2">
                        <a href="#altafacturaLineasEnvio" data-rel="dialog" style="text-decoration: none;">
                            <input type="button" name="enviar" value="Envio" data-icon="arrow-r" data-iconpos="right" data-theme="a" data-mini="true" id="Envio"
                                   onclick="javascript:Enviar(<?php echo $_SESSION['presupuestoActivo']['IdFactura']; ?>);" 
                                   <?php
                                    if($datosPresupuesto['SePuedeImprimir']==='NO'){
                                        echo 'disabled="true" ';
                                    }                                   
                                    if(isset($datosPresupuesto['DetallePresupuesto'])){ 
                                        if(count($datosPresupuesto['DetallePresupuesto'])>0){
                                        }else{
                                            echo 'disabled="true" ';
                                        }
                                    }else{
                                        echo 'disabled="true" ';
                                    }
                                   ?>
                                   />
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php
        if(isset($_SESSION['presupuestoActivo']['SePuedeImprimir'])){
            $SePuedeImp = $_SESSION['presupuestoActivo']['SePuedeImprimir'];
        }else{
            $SePuedeImp = 'SI';
        }
        ?>
        <input type="hidden" id="SePuedeImprimir" name="SePuedeImprimir" value="<?php echo $SePuedeImp;?>" />
        <input type="hidden" name="ContactoHidden" value="<?php echo $datosPresupuesto['ContactoHidden'];?>" />
    </form>
    </div>

    </div>  
        
    <div data-role="page" id="altafacturaLineasEnvio">
<?php
eventosInputText();
?>
<script language="JavaScript">
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
//            $('#Cliente').val(cliente.Cliente);
//            $('#CIF').val(cliente.CIF);
//            $('#direccion').val(cliente.direccion);
//            $('#poblacion').val(cliente.poblacion);
//            $('#provincia').val(cliente.provincia);
            $('#email').val(cliente.Correo);
//            if(opcion==='Nuevo'){
//                $('#FormaPagoHabitual').val(cliente.FormaPagoHabitual);
//            }
          }
        });
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
        $('#send').button('disable'); 
        document.contact.submit();
    }else{
        if(textoError===''){textoError='Revise los datos. NO estan correctos';}
        alert(textoError);
        return false;
    }  
}

function preparaURL(i,opcion){
        var datos='IdFactura='+i;
        datos=datos+'&opcion='+opcion;
        
        datos=encodeURI(datos);
        return datos;
}

//function DesactivaImprimir(){
//    document.form1.SePuedeImprimir.value='NO';
//}

</script>
    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>

    <div data-role="content" data-theme="a">
	<h2>Envio PDF</h2>

        <form id="contact" name="contact" action="../vista/facturaEnviar.php" method="post">
		<label for="email">Para</label>
		<input type="email" id="email" name="email"><br/>
		<label for="emailCC">C.C.</label>
		<input type="email" id="emailCC" name="emailCC"><br/>
		<br>
		<label for="msg">Mensaje</label>
                <textarea id="msg" name="msg" rows="5"></textarea>
		
		<input type="button" id="send" onclick="EnviarForm(<?php echo $_SESSION['presupuestoActivo']['IdFactura']; ?>);" value="Envio" />
                <input type="hidden" name="IdFactura" value="<?php echo $_SESSION['presupuestoActivo']['IdFactura'];?>"/>     
	</form>
    </div>

    </div>
        
    </body>
</html>



