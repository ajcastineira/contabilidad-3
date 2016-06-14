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

//veo si puedo o no imprimir logo en documento PDF
//$logo=$clsCNContabilidad->Parametro_general('Logo en Documentos',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));


//venimos de inchar el boton 'siguiente'
if(isset($_POST['IdPresupuesto'])){
    //paso a SESSION los datos del presupuesto y los datos qe vienen por post
    $datosPresupuesto=$clsCNContabilidad->datosPresupuesto($_POST['IdPresupuesto']);
    
    //creo la variable de sesion 'presupuestoActivo' y guardo ahi toda la informacion
    
    //estas variables hay que ver si existe la vble. $_SESSION['presupuestoActivo']
    //si no existe esta vble de sesion se crea y se guardan los datos 
    if(!isset($_SESSION['presupuestoActivo'])){
        $_SESSION['presupuestoActivo']['irpf']=$datosPresupuesto['Retencion'];
        $_SESSION['presupuestoActivo']['DetallePresupuesto']=$datosPresupuesto['DetallePresupuesto'];
    }
    
    //en las siguiente pagina todos los cambios que haga iran reflejados en esta variable de sesion
    //hasta que pinchemos en el boton de 'Grabar'
    $_SESSION['presupuestoActivo']['IdPresupuesto']=$_POST['IdPresupuesto'];
    $_SESSION['presupuestoActivo']['NumPresupuesto']=$_POST['numPresupuesto'];
    $_SESSION['presupuestoActivo']['NumPresupuestoBBDD']=$_POST['numPresupuestoBBDD'];
    $_SESSION['presupuestoActivo']['FechaPresupuesto']=$datosPresupuesto['FechaPresupuesto'];
    $_SESSION['presupuestoActivo']['Cliente']=$_POST['Cliente'];
    $_SESSION['presupuestoActivo']['Contacto']=$_POST['Contacto'];
    $_SESSION['presupuestoActivo']['ContactoHidden']=$_POST['ContactoHidden'];
    $_SESSION['presupuestoActivo']['CIF']=$_POST['CIF'];
    $_SESSION['presupuestoActivo']['direccion']=$_POST['direccion'];
    $_SESSION['presupuestoActivo']['poblacion']=$_POST['poblacion'];
    $_SESSION['presupuestoActivo']['provincia']=$_POST['provincia'];
    $_SESSION['presupuestoActivo']['FormaPagoHabitual']=$_POST['FormaPagoHabitual'];
    $_SESSION['presupuestoActivo']['validez']=$_POST['validez'];
    $_SESSION['presupuestoActivo']['Proforma']=$_POST['Proforma'];
    $_SESSION['presupuestoActivo']['Borrado']=$datosPresupuesto['Borrado'];
    $_SESSION['presupuestoActivo']['Estado']=$_POST['estadoNuevo'];
    $_SESSION['presupuestoActivo']['SePuedeImprimir']=$_POST['SePuedeImprimir'];
    
    
    if($_POST['opcion']==='Grabar'){
        //paso a un fichero 'altapresupuestoFinal.php' donde preparo fun formulario 
        //con todos los datos para que le lleguen igual que por 'vista'
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../movil/altapresupuestoFinal.php?pant=1">';die;
    }else{
        //y ahora a la pag 'altapresupuestoLineas' donde se representan las lineas de los conceptos
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../movil/altapresupuestoLineas.php">';die;
    }
}

//venimos del menu principal alta o Modificacion/Duplicar/Borrar
if(isset($_GET['IdPresupuesto'])){
    logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['srtBD'].', SesionID: '.  session_id().
           " ||||Mis Presupuestos->Modificacion/Duplicar/Baja||");

    //si existe vble de sesion $_SESSION['presupuestoActivo'] es que vengo de altapresupuestoLineas.php
    //por lo que conservo los datos, sino busco los datos en la BBDD
    if(isset($_SESSION['presupuestoActivo'])){
        $datosPresupuesto=$_SESSION['presupuestoActivo'];
    }else{
        $datosPresupuesto=$clsCNContabilidad->datosPresupuesto($_GET['IdPresupuesto']);
        
        //creo la variable de sesion 'presupuestoActivo' y guardo ahi toda la informacion

        //estas variables hay que ver si existe la vble. $_SESSION['presupuestoActivo']
        //si no existe esta vble de sesion se crea y se guardan los datos 
        if(!isset($_SESSION['presupuestoActivo'])){
            $_SESSION['presupuestoActivo']['irpf']=$datosPresupuesto['Retencion'];
            $_SESSION['presupuestoActivo']['DetallePresupuesto']=$datosPresupuesto['DetallePresupuesto'];
        }

        //en las siguiente pagina todos los cambios que haga iran reflejados en esta variable de sesion
        //hasta que pinchemos en el boton de 'Grabar'
        $_SESSION['presupuestoActivo']['IdPresupuesto']=$_GET['IdPresupuesto'];
        $_SESSION['presupuestoActivo']['NumPresupuesto']=$datosPresupuesto['NumPresupuesto'];
        $_SESSION['presupuestoActivo']['NumPresupuestoBBDD']=$datosPresupuesto['NumPresupuestoBBDD'];
        $_SESSION['presupuestoActivo']['FechaPresupuesto']=$datosPresupuesto['FechaPresupuesto'];
        $_SESSION['presupuestoActivo']['Cliente']='';//??
        $_SESSION['presupuestoActivo']['Contacto']=$datosPresupuesto['Contacto_Cliente'];
        $_SESSION['presupuestoActivo']['ContactoHidden']='';//NO HAY
        $_SESSION['presupuestoActivo']['CIF']=$datosPresupuesto['CIFEmpresa'];
        $_SESSION['presupuestoActivo']['direccion']=$datosPresupuesto['DireccionEmpresa'];
        $_SESSION['presupuestoActivo']['poblacion']=$datosPresupuesto['PoblacionEmpresa'];
        $_SESSION['presupuestoActivo']['provincia']=$datosPresupuesto['ProvinciaEmpresa'];
        $_SESSION['presupuestoActivo']['FormaPagoHabitual']=$datosPresupuesto['FormaPago'];
        $_SESSION['presupuestoActivo']['validez']=$datosPresupuesto['Validez'];
        $_SESSION['presupuestoActivo']['Proforma']=$datosPresupuesto['Proforma'];
        $_SESSION['presupuestoActivo']['Borrado']=$datosPresupuesto['Borrado'];
        $_SESSION['presupuestoActivo']['Estado']=$datosPresupuesto['Estado'];
        $_SESSION['presupuestoActivo']['SePuedeImprimir']='SI';
    }
    
    
    if($datosPresupuesto['Borrado']==='0'){
        //este presupuesto esta borrado por lo que volvemos al menu
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../movil/default2.php">';die;
    }

    //si viene $_GET[pant]=2 lo redirecciono a 'altapresupuestoLineas.php'
    if(isset($_GET['pant']) && $_GET['pant']==='2'){
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../movil/altapresupuestoLineas.php">';die;
    }
    
}else{
    logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
           " ||||Mis Presupuestos->Alta||");
    $numeroNuevoPresupuesto=$clsCNContabilidad->NumeroNuevoPresupuesto();
    $tipoContador=$clsCNContabilidad->Parametro_general('Tipo Contador',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));
}

$tipoContador=$clsCNContabilidad->Parametro_general('Tipo Contador',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));

//extraigo el listado de contactos y clientes
$listadoContactos=$clsCNContabilidad->listadoContactos();


//ahora preparo la consulta select (las opciones)
$htmlSelect='';
//$htmlSelect=$htmlSelect.'<option value=""></option>';
$htmlSelect=$htmlSelect."<option value='CL.430000000'>Clientes </option>";
//$htmlSelect=$htmlSelect.'<option value="Nuevo">Nuevo...</option>';
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
        //si el NombreEmpresa esta vacio indicamos en NombreContacto+ApellidosContacto
        if($contacto['NombreEmpresa']===''){
            $texto=$contacto['NombreContacto'].' '.$contacto['ApellidosContacto'];
        }
        //comprobamos si venimos de editar (existe la vble $datosPresupuesto[Contacto_Cliente]
        $contactoCliente=$tipo.'.'.$value;

        if($contactoCliente==$datosPresupuesto['Contacto_Cliente'] || $contactoCliente==$datosPresupuesto['Contacto']){
            $htmlSelect=$htmlSelect."<option value='$contactoCliente' selected>$texto</option>";
        }else{
            $htmlSelect=$htmlSelect."<option value='$contactoCliente'>$texto</option>";
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
<TITLE>Presupuesto</TITLE>

<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>

</head>

    <body>
        
    <div data-role="page" id="altapresupuesto">
<?php
eventosInputText();
?>
<script language="JavaScript">
function validar()
{
  esValido=true;
  textoError='';
  

  //comprobacion del campo 'Contacto'
  if (document.form1.Contacto.value === ''){ 
//  if (!document.getElementById('Contacto')){ 
    textoError=textoError+"Es necesario introducir un cliente.\n";
    esValido=false;
  }
  //comprobacion del campo 'numPresupuesto'
  if (document.form1.numPresupuesto.value === ''){ 
    textoError=textoError+"Es necesario introducir un número de presupuesto.\n";
    esValido=false;
  }


  if(esValido===true){
      document.getElementById("cmdAlta").value = "Enviando...";
      $('#cmdAlta').button('disable'); 
      document.form1.submit();
  }else{
      if(textoError===''){textoError='Revise los datos. NO estan correctos';}
      alert(textoError);
      return false;
  }  
}

function rellenarDatos(objeto,opcion){
    if(objeto==='Nuevo'){
        location.href="../movil/altacontacto.php";
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
            if(opcion==='Nuevo'){
                $('#FormaPagoHabitual').val(cliente.FormaPagoHabitual);
            }
          }
        });
    }
}

//borrar Presupuesto
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

function grabar(){
    document.form1.opcion.value='Grabar';
    $('#cmdGrabar').button('disable'); 
    document.form1.submit();
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

//borrar Asiento
function borrarPresupuesto(id){
    if (confirm("¿Desea borrar el Presupuesto de la base de datos?"))
    {
        window.location='../vista/presupuestoBorrar.php?id='+id;
    }
}

function DesactivaImprimir(){
    document.form1.SePuedeImprimir.value='NO';
    //document.getElementById('Envio').disabled='disabled';
    $('#Envio').button('disable'); 
}

function SiEsContado(objeto){
    if(objeto.value==='Contado'){
        document.form1.validez.value='';
        document.form1.validez.setAttribute("readonly" , "readonly" , false);
    }else{
        document.form1.validez.removeAttribute("readonly"  , false);
    }
}

</script>
<script>
$(document).ready(function() {
    <?php
    if(isset($datosPresupuesto['Contacto'])){
        $cc=$datosPresupuesto['Contacto'];
    }else
    if(isset($datosPresupuesto['Contacto_Cliente'])){
        $cc=$datosPresupuesto['Contacto_Cliente'];
    }
    if(isset($cc)){
    ?>
        rellenarDatos("<?php echo $cc; ?>","Editar");
    <?php } ?>
    //para controlar segun el tipo de pago la casilla de validez    
    SiEsContado(document.form1.FormaPagoHabitual);    
});
</script>


    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>

    <div data-role="content" data-theme="a">
    <form id="form1" name="form1" method="post" action="../movil/altapresupuesto.php" data-ajax="false">
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
                        <label>Presupuesto Nº</label>
                        <?php
                        $NumPresupuesto='';
                        if(isset($datosPresupuesto['NumPresupuesto'])){
                            $NumPresupuesto=$datosPresupuesto['NumPresupuesto'];
//                        }else
//                        if(isset($_SESSION['presupuestoActivo'])){
//                            $NumPresupuesto=$_SESSION['presupuestoActivo']['NumPresupuesto'];
                        }else{
                            $NumPresupuesto=$numeroNuevoPresupuesto;
                        }
                        ?>
                        <input type="text" name="numPresupuesto" <?php if($tipoContador<>''){echo ' readonly';}?> 
                               value="<?php echo $NumPresupuesto;?>" 
                               onblur="ComprobarPresupuesto(this);" />
                        <input type="hidden" name="numPresupuestoBBDD" value="<?php echo $datosPresupuesto['NumPresupuestoBBDD'];?>" />
                        <input type="hidden" name="IdPresupuesto" value="<?php echo $_GET['IdPresupuesto'];?>" />
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
                        <select id="Contacto" name="Contacto" data-native-menu="false" data-theme='a'
                                onchange="rellenarDatos(this.value,'Nuevo');DesactivaImprimir();">
                            <?php echo $htmlSelect; ?>
                        </select>
                        <input type="hidden" id="ContactoHidden" name="ContactoHidden" value="<?php if(isset($datosPresupuesto)){echo $datosPresupuesto['NombreEmpresa'];} ?>" />
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
                        <select id="FormaPagoHabitual" name="FormaPagoHabitual" data-native-menu="false" data-theme='a' data-mini="true" 
                                onchange="SiEsContado(this);DesactivaImprimir();">
                            <?php
                            if(isset($datosPresupuesto['FormaPago'])){
                                $FormaPago=$datosPresupuesto['FormaPago'];
                            }else
                            if(isset($datosPresupuesto['FormaPagoHabitual'])){
                                $FormaPago=$datosPresupuesto['FormaPagoHabitual'];
                            }
                            ?>
                            <option value="" <?php if($FormaPago===''){echo 'selected';}?>></option>
                            <option value="Contado" <?php if($FormaPago==='Contado'){echo 'selected';}?>>Contado</option>
                            <option value="Pagare" <?php if($FormaPago==='Pagare'){echo 'selected';}?>>Pagaré</option>
                            <option value="Recibo" <?php if($FormaPago==='Recibo'){echo 'selected';}?>>Recibo</option>
                            <option value="Talon" <?php if($FormaPago==='Talon'){echo 'selected';}?>>Talón</option>
                            <option value="Transferencia" <?php if($FormaPago==='Transferencia'){echo 'selected';}?>>Transferencia</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label>Proforma</label>
                        <select id="Proforma" name="Proforma" data-native-menu="false" data-theme='a' data-mini="true" 
                                onchange="DesactivaImprimir();">
                            <option value="0" <?php if($datosPresupuesto['Proforma']==='0'){echo 'selected';}?>>No</option>
                            <option value="1" <?php if($datosPresupuesto['Proforma']==='1'){echo 'selected';}?>>Si</option>
                        </select>
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
                        <input type="text" name="validez" maxlength="12" id="validez"
                               value="<?php echo $presentarValidez; ?>" onchange="DesactivaImprimir();"
                               onblur="solonumerosM(this);" onfocus="onFocusInputTextM(this);" />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>Estado</label>
                        <?php $opcion=$datosPresupuesto['Estado']; ?>
                        <?php 
                        if(!isset($_GET['IdPresupuesto']) || $_GET['IdPresupuesto']===''){ ?>
                        <select name="estadoNuevo" data-native-menu="false" data-theme='a' data-mini="true" onchange="DesactivaImprimir();">
                            <option value="Pendiente" selected>Pendiente</option>
                        </select>
                        <?php 
                        }else{
                        ?>
                        <select name="estadoNuevo" data-native-menu="false" data-theme='a' data-mini="true" onchange="DesactivaImprimir();">
                            <option value="Pendiente" <?php if($opcion==='Pendiente'){echo 'selected';}?>>Pendiente</option>
                            <option value="Aceptado" <?php if($opcion==='Aceptado'){echo 'selected';}?>>Aceptado</option>
                            <option value="Rechazado" <?php if($opcion==='Rechazado'){echo 'selected';}?>>Rechazado</option>
                            <option value="Cancelado" <?php if($opcion==='Cancelado'){echo 'selected';}?>>Cancelado</option>
                        </select>
                        <?php 
                        }
                        ?>
                    </td>
                </tr>
                
                <tr>
                    <td height="15px"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <?php 
                        $disabled = '';
                        if(!isset($_GET['IdPresupuesto']) || $_GET['IdPresupuesto']===''){
                            $disabled = ' disabled';
                        } 
                        ?>  
                        <input type="button" data-icon="delete" data-theme="a" data-mini="true" value="Eliminar" name="cmdBorrar" 
                               onclick="javascript:borrarPresupuesto('<?php echo $_GET['IdPresupuesto'];?>');" 
                               <?php echo $disabled;?> />
                    </td>
                    <td colspan="2">
                        <input type="button" data-icon="forward" data-theme="a" data-mini="true" data-iconpos="right" name="cmdAlta" id="cmdAlta" 
                               value = "Siguiente" onclick="javascript:validar();" /> 
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2">
                        <input type="button" data-icon="star" data-theme="a" data-mini="true" data-iconpos="right" 
                            value = "Grabar" onclick="javascript:grabar();"
                            <?php
                            if(!isset($_GET['IdPresupuesto']) || $_GET['IdPresupuesto']===''){
                                echo ' disabled';
                            }else{
                                if(!isset($datosPresupuesto) && count($datosPresupuesto['DetallePresupuesto'])===0){
                                    echo ' disabled';
                                }
                            } 
                            ?>
                            /> 
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
        <input type="hidden" name="opcion" value="" />
    </form>
    </div>

    </div>    
    </body>

</html>
