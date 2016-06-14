<?php
session_start ();
require_once '../CN/clsCNContabilidad.php';
require_once '../CN/clsCNUsu.php';
require_once '../general/funcionesGenerales.php';

$clsCNUsu=new clsCNUsu();
$clsCNUsu->setStrBD($_SESSION['dbContabilidad']);
$clsCNUsu->setStrBDCliente($_SESSION['mapeo']);
$clsCNContabilidad=new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['dbContabilidad']);

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



//codigo principal
//comprobamos si se ha submitido el formulario
if(isset($_POST['Id'])){
    //var_dump($_POST);die;
    if($_POST['Id'] === ''){
        //nuevo Articulo
        logger('info','altaArticulo.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
               " ||||Configuracion->Mis Articulos->Alta|| Ha pulsado 'Proceder al Alta'(Articulo Nuevo)");

        $varRes=$clsCNContabilidad->AltaGrupoArticulo($_POST);

        if($varRes<>1){
            echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/error.php?id=Se ha producido un error en el guardado del articulo">';
        }else{
            echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/exito.php?Id=Se ha guardado correctamente el articulo en la base de datos">';
        }
    }else if($_POST['Id'] !== ''){
        //editar Articulo
        logger('info','altaArticulo.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
               " ||||Configuracion->Mis Articulos->Consulta/Modificacion|| Ha pulsado 'OK'(Editar Articulo)");

        $varRes=$clsCNContabilidad->EditarGrupoArticulo($_POST);

        if($varRes<>1){
            echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/error.php?id=Se ha producido un error al editar el articulo">';
        }else{
            echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/exito.php?Id=Se ha editado correctamente el articulo en la base de datos">';
        }
    }
}else{
    //compruebo si vengo por GET con un Id (es editar el articulo)
    if(isset($_GET['Id']) && $_GET['Id'] !== ""){
        $datos = $clsCNContabilidad->LeeGrupo($_GET['Id']);
    }
    
    //aqui dirijo a la presentacion en PC o Movil (APP)
    if($_SESSION['navegacion']==='movil'){
        html_paginaGrupoArticuloMovil($datos,$clsCNContabilidad);
    }else{
        html_paginaGrupoArticulo($datos,$clsCNContabilidad);
    }
    
}

function html_paginaGrupoArticulo($datos,$clsCNContabilidad){
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
<TITLE><?php if(isset($_GET['Id'])){echo 'Grupo Artículo - EDITAR';}else{echo 'Grupo Artículo - ALTA';}?></TITLE>

<script language="JavaScript">

function validar2()
{
  esValido=true;
  textoError='';
  //comprobacion del campo 'Identificador'
  if (document.form1.Identificador.value == ''){ 
    textoError=textoError+"Es necesario introducir un Identificador del Grupo.\n";
    document.form1.Identificador.style.borderColor='#FF0000';
    document.form1.Identificador.title ='Se debe introducir un Identificador del Grupo';
    esValido=false;
  }
  //comprobacion del campo 'Grupo'
  if (document.form1.Grupo.value == ''){ 
    textoError=textoError+"Es necesario introducir el Grupo.\n";
    document.form1.Grupo.style.borderColor='#FF0000';
    document.form1.Grupo.title ='Se debe introducir el Grupo';
    esValido=false;
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
      onLoad="rotulo_status();">
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
//??
if(isset($_GET['Id'])){
    $cabeceraNumero='010702';
    $tituloForm='EDITAR GRUPO ARTÍCULO';
}else{
    $cabeceraNumero='010701';
    $tituloForm='ALTA GRUPO DE ARTÍCULO';
}
//?? FIN

$paginaForm='';
$formatoForm='';
$numeroForm='';
$disabledForm='disabled';
date_default_timezone_set('Europe/Madrid');
$fechaForm=date('d/m/Y');
require_once 'cabeceraForm.php';
?>
  <div class="doc"> 
    <hr color = "#FF9900">
    <br/>
    <form name="form1" method="post" action="../vista/altaGrupoArticulo.php" onSubmit="desactivaBoton();">
	
      <table width="640" border="0" class="zonaactiva">
        <tr> 
          <td class="subtitulo" colspan="9">&nbsp;Datos del Grupo del Artículo</td>
        </tr>
        <tr>
            <td width="8%"></td>
            <td width="20%"></td>
            <td width="8%"></td>
            <td width="56%"></td>
            <td width="8%"></td>
        </tr>
        <tr> 
          <td></td>
          <td>
              <div align="left">
              <label class="nombreCampo">Identificacdor</label>
              <input class="textbox1" type="text" name="Identificador" id="Identificador" maxlength="5"
                     value="<?php if(isset($datos[0]['Identificador'])){echo $datos[0]['Identificador'];}?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" 
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
              </div>
          </td>
          <td></td>
          <td>
              <div align="left">
              <label class="nombreCampo">Grupo</label>
              <input class="textbox1" type="text" name="Grupo" id="Grupo" maxlength="100"
                     value="<?php if(isset($datos[0]['Grupo'])){echo $datos[0]['Grupo'];}?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" 
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
              </div>
          </td>
          <td colspan="1"></td>
        </tr>
        <tr> 
          <td></td>
          <td></td>
          <td></td>
          <td>
              <div align="left">
                <label class="nombreCampo">Cuenta Contable</label>
                <select class="textbox1" name="cuentaContable">
                <?php
                $listadoCuentasContables = $clsCNContabilidad->listarCuentasArticulos();
                //preparo el listado
                echo"<option value=''></option>";
                for ($i = 0; $i < count($listadoCuentasContables); $i++) {
                    $selected='';
                    if($datos[0]['Cuenta']===$listadoCuentasContables[$i]['NumCuenta']){
                        $selected='selected';
                    }
                    echo"<option value='".$listadoCuentasContables[$i]['NumCuenta']."' ".$selected.">".$listadoCuentasContables[$i]['cuenta']."</option>";
                }
                ?>
                </select>
              </div>
          </td>
          <td colspan="1"></td>
        </tr>
        <tr>
            <td height="15px"></td>
        </tr>
      </table>
        
      <P>
        <input type="Reset" class="buttonAzul" value="Vaciar Datos" name="cmdReset"/>
        <input type="button" class="button" name="cmdAlta" id="cmdAlta" value = "<?php if(isset($datos[0]['IdGrupo'])){echo 'OK';}else{echo 'Proceder al Alta';}?>" onclick="javascript:validar2();" /> 
        <input type="hidden"  name="cmdAlta" value="Aceptar" />
        <input type="hidden"  name="Id" value="<?php if(isset($datos[0]['IdGrupo'])){echo $datos[0]['IdGrupo'];}?>" />
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
}//fin del html PC

function html_paginaGrupoArticuloMovil($datos,$clsCNContabilidad){
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
<body onLoad=""
      class="api jquery-mobile archive category category-widgets category-2 listing single-author"> 

<div data-role="page" id="empleados">
<?php
eventosInputText();
?>
<script language="JavaScript">
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
    
function validar2()
{
    esValido=true;
    textoError='';
  
    //comprobacion del campo 'Referencia'
    if (document.form1.Referencia.value === ''){ 
        textoError=textoError+"Es necesario introducir la referencia.\n";
        $('#Referencia').parent().css('border-color','red');
        esValido=false;
    }

    //comprobacion del campo 'Descripcion'
    if (document.form1.Descripcion.value === ''){ 
        textoError=textoError+"Es necesario introducir la descripción.\n";
        $('#Descripcion').parent().css('border-color','red');
        esValido=false;
    }

    //comprobacion del campo 'Precio'
    if (document.form1.Precio.value === ''){ 
        textoError=textoError+"Es necesario introducir el precio.\n";
        $('#Precio').parent().css('border-color','red');
        esValido=false;
    }

    //comprobacion del campo 'cantidadAlmacen'
    if (document.form1.cantidadAlmacen.value === ''){ 
        textoError=textoError+"Es necesario introducir la cantidad en el almacén.\n";
        $('#cantidadAlmacen').parent().css('border-color','red');
        esValido=false;
    }

    //comprobacion del campo 'cuentaContable'
    if (document.form1.cuentaContable.value === ''){ 
        textoError=textoError+"Es necesario introducir la cuenta contable.\n";
        $('#cuentaContable').parent().css('border-color','red');
        esValido=false;
    }

    
    //indicar el mensaje de error si es 'esValido' false
    if (!esValido){
        alert(textoError);
    }

    if(esValido===true){
        document.form1.submit();
    }else{
        return false;
    }  
}

//borrar contacto/cliente cde tbmiscontactos
function borrarArticulo(id){
    if (confirm("¿Desea borrar el articulo de la base de datos?"))
    {
        window.location='../vista/articuloBorrar.php?id='+id;
    }
}
</script>

<?php
include_once '../movil/cabeceraMovil.php';
?>

<div data-role="content" data-theme="a">
    <form id="form1" name="form1" method="post" action="../vista/altaArticulo.php" data-ajax="false">
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
                        <label>Referencia</label>
                        <input type="text" name="Referencia" id="Referencia" maxlength="25" onfocus="onFocusInputTextM(this);"
                               value="<?php if(isset($datos[0]['Referencia'])){echo $datos[0]['Referencia'];}?>"
                               onblur="" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label>Descripción</label>
                    </td>
                </tr>
                <tr> 
                    <td colspan="4">
                        <textarea name="Descripcion" rows=4 cols="20"
                                onfocus="onFocusInputTextM(this);"
                        ><?php if(isset($datos[0]['Descripcion'])){echo $datos[0]['Descripcion'];}?></textarea> 
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label>Precio</label>
                        <input type="text" name="Precio" id="Precio" maxlength="15"  style="text-align:right;font-weight:bold;"
                               onfocus="onFocusInputTextM(this);desFormateaCantidad(this);"
                               value="<?php if(isset($datos[0]['Precio'])){echo formateaNumeroContabilidad($datos[0]['Precio']);}?>"
                               onblur="solonumerosM(this);formateaCantidad(this);" />
                    </td>
                    <td colspan="2">
                        <label>IVA</label>
                            <select name="tipoIVA" data-native-menu="false" data-theme='a' data-mini="true">
                                <option value = "0" <?php if($datos[0]['tipoIVA'] === '0'){echo 'selected';} ?>>0</option>
                                <option value = "4" <?php if($datos[0]['tipoIVA'] === '4'){echo 'selected';} ?>>4</option>
                                <option value = "10" <?php if($datos[0]['tipoIVA'] === '10'){echo 'selected';} ?>>10</option>
                                <option value = "21" <?php if($datos[0]['tipoIVA'] === '21'){echo 'selected';} ?>>21</option>
                            </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label>Cantidad Almacén</label>
                        <input type="text" name="cantidadAlmacen" id="cantidadAlmacen" maxlength="10" 
                               onfocus="onFocusInputTextM(this);" style="text-align:right;font-weight:bold;"
                               value="<?php if(isset($datos[0]['CantidadAlmacen'])){echo $datos[0]['CantidadAlmacen'];}?>"
                               onblur="solonumerosM(this);" />
                    </td>
                </tr>                
                <tr>
                    <td colspan="4">
                            <?php
                            //funcion filtro
                            autocomplete_cuentas_SubGrupo4('cuentaContable',7);
                            ?>
                            <label>Cuenta Contable</label>
                            <input type="text" id="cuentaContable" name="cuentaContable" tabindex="3" 
                                   value="<?php if(isset($datos[0]['CuentaContable'])){echo $datos[0]['CuentaContable'];}?>"
                                   onKeyUp="comprobarCuenta(this,document.getElementById('okCuentaContable'));"  
                                   onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                                   onfocus="onFocusInputText(this);desactivaCampoComprobacionCuenta(document.getElementById('okCuentaContable'));"
                                   onblur="onBlurInputText(this);comprobarCuentaBlur(this,document.getElementById('okCuentaContable'));" />
                            <input type="hidden" id="okCuentaContable" name="okCuentaContable" value="<?php if(isset($_GET['Id']) && $_GET['Id'] !== ""){echo 'SI';}else{echo 'NO';} ?>" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="button" id="cmdAlta" data-theme="a" data-icon="check" value = "<?php if(isset($datos[0]['Id'])){echo 'Grabar';}else{echo 'Alta';}?>" onclick="javascript:validar2();" />
                        <input type="hidden"  name="cmdAlta" value="Aceptar" />
                        <input type="hidden"  name="Id" value="<?php if(isset($datos[0]['Id'])){echo $datos[0]['Id'];}?>" />
                    </td>
                    <?php
                    if(isset($datos[0]['Id'])){
                    ?>
                    <td colspan="2">
                        <input type="button" data-theme="a" data-icon="delete" value="Eliminar" name="cmdBorrar" onclick="javascript:borrarArticulo(<?php echo $datos[0]['Id']; ?>);" />
                    </td>
                    <?php
                    }
                    ?>
                </tr>
            </tbody>
        </table>
    </form>    
</div>
</div>
</body>    
</html>    
<?php
}//fin del html Movil
?>

