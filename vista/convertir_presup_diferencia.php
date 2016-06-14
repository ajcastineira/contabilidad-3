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


//primero controlo que vengo de presupuestoConvertirList.php
//sino es asi vuelvo a default2.php
if(isset($_SESSION['CP'])){
    //es uno de estos dos ficheros que continue el flujo
}else{
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/default2.php">';die;
}



//codigo principal
if(isset($_POST['IdPresupuesto'])){
    
    //var_dump($_POST);die;
    //ESTA PARTE CREO QUE NO SE USA 13/5/2015
    logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
       " ||||Mis Presupuestos->Convertir a Pedido|| A pulsado 'Generar Pedido'");

    $IdPedido=$clsCNContabilidad->generarPedidoDePresupuesto($_SESSION['usuario'],$_POST);
    
    if($IdPedido === 'false'){
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/error.php?id=No se a dado de alta el pedido">';die;
    }else{
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/altapedido.php?IdPedido='.$IdPedido.'">';die;
    }
}
    
//venimos del menu principal alta o Modificacion/Duplicar/Borrar
if(isset($_GET['IdPresupuesto'])){
    logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['srtBD'].', SesionID: '.  session_id().
           " ||||Mis Presupuestos->Convertir a Pedido||");

    $datosPresupuesto=$clsCNContabilidad->datosPresupuestoDiferencia($_GET['IdPresupuesto']);
    //extraemos los datos de nuestra empresa
    $datosNuestraEmpresa=$clsCNContabilidad->datosNuestraEmpresaPresupuesto();
    //extraigo el listado de facturas emitidas de este presupuesto
    $facturasEmitidas=$clsCNContabilidad->listadoFacturasEmitidas($_GET['IdPresupuesto']);
    $pedidosEmitidos=$clsCNContabilidad->listadoPedidosEmitidos($_GET['IdPresupuesto']);
    
    
}else{//extraigo el listado de contactos y clientes
//$listadoContactos=$clsCNContabilidad->listadoContactos();

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
<?php
//estas funciones son generales
librerias_jQuery();
eventosInputText();
?>
<link rel="stylesheet" type="text/css" media="all" href="../js/jQuery/fancybox/style.css">
<link rel="stylesheet" type="text/css" media="all" href="../js/jQuery/fancybox/jquery.fancybox.css">
<!--<script type="text/javascript" src="../js/jQuery/fancybox/jquery.fancybox.js?v=2.0.6"></script>-->
<script type="text/javascript" src="../js/jQuery/autoresize/textareaAutoResize.js"></script>

<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../images/q.ico">
<TITLE>Facturar Presupuesto - Elegir los conceptos</TITLE>

<SCRIPT type="text/javascript" Language="JavaScript"> 

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
        
    importeTotal=formateaNumeroContabilidad(importeTotal.toString());
    document.form1.totalImporte.value=importeTotal;
        
    cuotaTotal=formateaNumeroContabilidad(cuotaTotal.toString());
    document.form1.totalCuota.value=cuotaTotal;
        
    total=formateaNumeroContabilidad(total.toString());
    document.form1.total.value=total;
    
    //irpf
    facturaCalculoIRPF(document.form1.totalImporte,document.form1.total,document.form1.irpf,document.form1.IRPFcuota,document.form1.totalFinal);
}

////borrar Asiento
//function borrarPresupuesto(id){
//    if (confirm("¿Desea borrar el Presupuesto de la base de datos?"))
//    {
//        window.location='../vista/presupuestoBorrar.php?id='+id;
//    }
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

function generarFactura(){
//    //cuento todos los check que hay
//    var checkTotal=0;
//    $("input[type='checkbox']").each(function(){
//        checkTotal++;
//    });
//    
    //cuento todos los check marcados (:checked)
    var checkON=0;
    $("input[type='checkbox']:checked").each(function(){
        checkON++;
    });
    
    // si checkON=0 es que no hay seleccionado ninguno por lo que lo indico y no submito
    if(checkON===0){
        //error
        alert('No hay seleccionado ningún concepto.');
    }else{
        //submite el formulario
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

function salir(){
    window.location='../vista/default2.php';
}

function volver(){
    javascript:history.back();
}
</script>

<script type="text/javascript" Language="JavaScript"> 
//function que renderiza la linea de la factura    
function lineaFactura(linea,idPresupLinea,numLineaPresup,IdArticulo,cantidad,concepto,precio,importe,iva,cuota,total){

var txtLinea='<tr id="linea'+linea+'" class="item-row">'+
            '<td valign="top"><input type="checkbox" id="check'+linea+'" name="check'+linea+'" class="textbox1" checked  tabindex="'+linea+'" onclick="sumas();" /></td>'+
            "<td valign='top'>"+
                '<div class="divFormato">'+
                '<input type="hidden" name="idPresupLinea'+linea+'" value="'+idPresupLinea+'" />'+
                '<input type="hidden" name="numLineaPresup'+linea+'" value="'+numLineaPresup+'" />'+
                '<input type="hidden" name="IdArticulo'+linea+'" value="'+IdArticulo+'" />'+
                '<input class="textbox2" type="text" name="cantidad'+linea+'" id="cantidad'+linea+'" maxlength="12"'+
                       'style="text-align:right;" value="'+cantidad+'" readonly />'+
                "</div>"+
            "</td>"+
            "<td valign='top'>"+
                '<div align="left">'+
                  '<textarea class="textbox1area" name="concepto'+linea+'" id="concepto'+linea+'" '+
                        'cols="20" rows="0" '+
                        'readonly >'+concepto+'</textarea>'+ 
                "</div>"+
            "</td>"+
            "<td valign='top'>"+
                '<div class="divFormato" align="left">'+
                '<input class="textbox2" type="text" name="precio'+linea+'" id="precio'+linea+'" maxlength="12" '+
                       'style="text-align:right;" value="'+precio+'" readonly />'+
                "</div>"+
            "</td>"+
            "<td valign='top'>"+
                '<div class="divFormato" align="left">'+
                '<input class="textbox2" type="text" name="importe'+linea+'" id="importe'+linea+'" maxlength="12" '+
                       'style="text-align:right;" value="'+importe+'" readonly />'+
                "</div>"+
            "</td>"+
            "<td valign='top'>"+
                '<div class="divFormato" align="center">'+
                '<input class="textbox2" type="text" name="iva'+linea+'" id="iva'+linea+'" maxlength="12" '+
                       'style="text-align:right;" value="'+iva+'" readonly />'+
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
        $idPresupLinea=$datosPresupuesto['DetallePresupuesto'][$i]['IdPresupLineas'];
        $numLineaPresup=  $datosPresupuesto['DetallePresupuesto'][$i]['NumLineaPresup'];
        $IdArticulo=  $datosPresupuesto['DetallePresupuesto'][$i]['IdArticulo'];
        if($IdArticulo === null){
            $IdArticulo = 'null';
        }
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
    $("#linea<?php echo $i;?>:last").after(
            lineaFactura(<?php echo $i+1;?>,<?php echo $idPresupLinea; ?>,<?php echo $numLineaPresup; ?>,<?php echo $IdArticulo; ?>,'<?php echo $cantidadPres; ?>','<?php echo str_replace(array("\r\n","\r","\n"),'\n',$conceptoPres); ?>','<?php echo $precioPres; ?>','<?php echo $importePres; ?>',
                         '<?php echo $ivaPres; ?>','<?php echo $cuotaPres; ?>','<?php echo $totalPres; ?>')
            );
    if ($(".delete").length > 0) $(".delete").show();
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
    $("#linea"+document.form1.linea.value+":last").after(
            lineaFactura((parseInt(document.form1.linea.value)+1),'','','','','','','','','')
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
              <?php
                if(isset($_GET['IdContacto'])){
                    echo "rellenarDatos('CO.".$_GET['IdContacto']."','Editar');";
                }
                //quitamos los check si es contacto o no es Aceptado
                $datosContacto=explode('.',$datosPresupuesto['Contacto_Cliente']);
                if(($datosContacto==='CO') || ($datosPresupuesto['Estado']<>'Aceptado')){
                    echo 'quitarCheck();';
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
//}else{
//    $tituloForm='';
//    date_default_timezone_set('Europe/Madrid');
//    $fechaForm=date('d/m/Y');
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

<form id="form1" name="form1" method="post" action="../vista/convertir_presup_parcial.php" onSubmit="desactivaBoton();">
<table border="0" class="cabecera" height="82" width="<?php echo $anchoCabecera; ?>">
    <tr> 
        <td width="177" align="middle" valign="center"><div align="center"><a href="../<?php echo $_SESSION['navegacion'];?>/default2.php"><IMG height=67 alt="Ir al menú" src="../images/<?php echo $_SESSION['logo']; ?>" width=132 border="0"></a></div></td>
        <td width="200"><div align="center"><?php echo $tituloForm; ?></div></td>
        <td>
            <div align="right">
            <table border="0" class="cabecera">
                <tr>
                    <td width="90" height="25" align="middle">
                    <td width="50" height="25" align="middle">
                    </td>			
                    <td width="90" align="left"></td>
                    <td></td>
                </tr>

                <tr align="right">
                    <td height="25" align="right">Presupuesto Nº:</td>
                    <td>
                        <input type="text" class="textbox1" name="numPresupuesto" size="12" tabindex="1" readonly
                               value="<?php if(isset($datosPresupuesto['NumPresupuesto'])){echo $datosPresupuesto['NumPresupuesto'];}else{echo $numeroNuevoPresupuesto;}?>" />
                        <input type="hidden" name="numPresupuestoBBDD" value="<?php echo $datosPresupuesto['NumPresupuestoBBDD'];?>" />
                    </td>
                    <td></td>
                    <td></td>
                </tr>

                <tr align="right">
                    <td>Pedidos y/o facturas emitidas:</td>
                    <td colspan="3" height="22" align="left">
                        <input type="text" class="textbox1" name="listaFactAnt" size="12" readonly
                               value="<?php
                                        $textoFactAnt='';
                                        if(is_array($pedidosEmitidos)){
                                            for($i=0;$i<count($pedidosEmitidos);$i++){
                                                $textoFactAnt=$textoFactAnt.'  '.'Pedido:'.$pedidosEmitidos[$i];
                                            }
                                        }
                                        if(is_array($facturasEmitidas)){
                                            for($i=0;$i<count($facturasEmitidas);$i++){
                                                $textoFactAnt=$textoFactAnt.'  '.'Factura:'.$facturasEmitidas[$i];
                                            }
                                        }
                                        echo $textoFactAnt;
                                        ?>"
                        />
                    </td>
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
                            <?php echo $htmlSelect; ?>
                        <input type="hidden" id="ContactoHidden" name="ContactoHidden" 
                               value="<?php
                                        if(isset($datosPresupuesto)){
                                            echo $datosPresupuesto['Contacto_Cliente'];
                                        }
                                      ?>"
                        />
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
        
    <table border="0" width="100%">
        <tr>
            <td width="40%"></td>
            <td width="10%"></td>
            <td width="40%"></td>
        </tr>
        <tr>
            <td>
                <table border="0" width="100%" style="background-color: #eeeeee;">
                    <tr>
                        <td height="15px" width="50%"></td>
                        <td width="45%"></td>
                        <td width="5%"></td>
                    </tr>
                    <tr>
                        <td style="text-align: right;">
                            <label>Fecha Pedido</label>
                        </td>
                        <td>
                            <?php
                            datepicker_español('FechaPedido');
                            ?>
                            <input type="text" class="textbox1" name="FechaPedido" id="FechaPedido" 
                                   onKeyUp="this.value=formateafechaEntrada(this.value);" 
                                   value="<?php if(isset($datosPresupuesto['FechaPedido'])){echo $datosPresupuesto['FechaPedido'];}else{echo date('d/m/Y');}?>" />
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right;">
                            <label>Fecha Vencimiento</label>
                        </td>
                        <td>
                            <?php
                            datepicker_español('FechaVtoPedido');
                            ?>
                            <input type="text" class="textbox1" name="FechaVtoPedido" id="FechaVtoPedido" 
                                   onKeyUp="this.value=formateafechaEntrada(this.value);" 
                                   value="<?php echo $datosPresupuesto['FechaVtoPedido'];?>" />
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right;">
                            <label>Fecha Finalización</label>
                        </td>
                        <td>
                            <?php
                            datepicker_español('FechaFinalizacion');
                            ?>
                            <input type="text" class="textbox1" name="FechaFinalizacion" id="FechaFinalizacion" 
                                   value="<?php echo $datosPresupuesto['FechaFinalizacion'];?>" />
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right;">
                            <label>Forma de Pago</label>
                        </td>
                        <td>
                            <script>
                            function SiEsTransferencia(objeto){
                                if(objeto.value === 'Transferencia'){
                                    $('.cc').show('500');
                                }else{
                                    $('.cc').hide('500');
                                }
                            }
                            </script>
                            <select name="FormaPagoHabitual" id="FormaPagoHabitual" class="textbox1" tabindex="101" style="width: 100%;" onchange="SiEsTransferencia(this);">
                                  <?php if(isset($varRes)){?>
                                  <option value="" <?php if($datosPresupuesto['FormaPago']===''){echo 'selected';}?>></option>
                                  <option value="Contado" <?php if($datosPresupuesto['FormaPago']==='Contado'){echo 'selected';}?>>Contado</option>
                                  <option value="Pagare" <?php if($datosPresupuesto['FormaPago']==='Pagare'){echo 'selected';}?>>Pagaré</option>
                                  <option value="Recibo" <?php if($datosPresupuesto['FormaPago']==='Recibo'){echo 'selected';}?>>Recibo</option>
                                  <option value="Talon" <?php if($datosPresupuesto['FormaPago']==='Talon'){echo 'selected';}?>>Talón</option>
                                  <option value="Transferencia" <?php if($datosPresupuesto['FormaPago']==='Transferencia'){echo 'selected';}?>>Transferencia</option>
                                  <?php }else if($_GET['IdPedido']){?>
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
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right;">
                            <div class="cc" style="display: none;">
                            <label>CC Transferencia</label>
                            </div>
                        </td>
                        <td>
                            <div class="cc" style="display: none;">
                            <input type="text" class="textbox1" name="CC_Recibos" id="CC_Recibos" 
                                   value="<?php echo $datosPresupuesto['CC_Trans'];?>" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td height="15px"></td>
                    </tr>
                </table>
            </td>
            <td></td>
            <td>
                <table border="0" width="100%" style="background-color: #eeeeee;">
                    <tr>
                        <td height="15px" width="5%"></td>
                        <td width="40%"></td>
                        <td width="10%"></td>
                        <td width="40%"></td>
                        <td width="5%"></td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: center;">
                            <label>Tipo Factura</label>
                        </td>
                    </tr>           
                    <tr>
                        <td></td>
                        <td>
                            <script>
                            function tipoChecked(){
                                //si encuentro algun valor cheked (seleccionado) paso 'esValido' a true
                                if(document.form1.tipoFactura[0].checked){
                                    document.form1.DiaPeriodica.disabled = false;
                                    document.form1.FrecuenciaPeriodica.disabled = false;
                                }else{
                                    //deshabilito los campos DiaPeriodica y FrecuenciaPeriodica
                                    document.form1.DiaPeriodica.disabled = true;
                                    document.form1.FrecuenciaPeriodica.disabled = true;
                                }
                            }
                            </script>
                            <input type="radio" name="tipoFactura" value="Periodica" onchange="tipoChecked();"
                                <?php if($datosPresupuesto['TipoFactura'] === 'Periodica'){echo 'checked';}else if(!isset($datosPresupuesto['TipoFactura'])){echo 'checked';}?> />
                            <label>Periódica</label>
                        </td>
                        <td></td>
                        <td>
                            <input type="radio" name="tipoFactura" value="Puntual" onchange="tipoChecked();" 
                                <?php if($datosPresupuesto['TipoFactura'] === 'Puntual'){echo 'checked';}?> />
                            <label>Puntual</label>
                        </td>
                    </tr>
                    <tr>
                        <td style="height: 15px;"></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: right;">
                            <label>Día</label>
                        </td>
                        <td colspan="2">
                            <input type="text" class="textbox1" name="DiaPeriodica" id="DiaPeriodica" 
                                   onkeypress="return solonumeros(event);"
                                   onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);tipoChecked();"
                                   onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" 
                                   value="<?php if(isset($datosPresupuesto['DiaPeriodica'])){echo $datosPresupuesto['DiaPeriodica'];}else{echo date('d');} ?>" style="text-align: right;" />
                        </td>
                    </tr>                    
                    <tr>
                        <td colspan="2" style="text-align: right;">
                            <label>Frecuencia</label>
                        </td>
                        <td colspan="2">
                            <select name="FrecuenciaPeriodica" style="width: 100%;" class="textbox1" onchange="tipoChecked();">
                                <option value="Mensual" <?php if($datosPresupuesto['FrecuenciaPeriodica'] === 'Mensual'){echo 'selected';}?>>Mensual</option>
                                <option value="Trimestral" <?php if($datosPresupuesto['FrecuenciaPeriodica'] === 'Trimestral'){echo 'selected';}?>>Trimestral</option>
                                <option value="Semestral" <?php if($datosPresupuesto['FrecuenciaPeriodica'] === 'Semestral'){echo 'selected';}?>>Semestral</option>
                                <option value="Anual" <?php if($datosPresupuesto['FrecuenciaPeriodica'] === 'Anual'){echo 'selected';}?>>Anual</option>
                            </select>
                        </td>
                    </tr>                    
                    <tr>
                        <td colspan="2" style="text-align: right;">
                            <label>Fecha Próxima Factura</label>
                        </td>
                        <td colspan="2">
                            <?php
                            datepicker_español('FechaProximaFacturaPeriodica');
                            ?>
                            <input type="text" class="textbox1" name="FechaProximaFacturaPeriodica" id="FechaProximaFacturaPeriodica" 
                                   value="<?php if(isset($datosPresupuesto['FechaProximaFacturaPeriodica'])){echo $datosPresupuesto['FechaProximaFacturaPeriodica'];}else{echo date('d/m/Y');} ?>" style="text-align: right;" />
                        </td>
                    </tr>                    
                    <tr>
                        <td height="15px"></td>
                    </tr>
                </table>                
            </td>
        </tr>
    </table>
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
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2" align="right"><label class="nombreCampo">Retención</label></td>
            <td align="left">
                <input type="text" class="textbox1readonly" name="irpf" id="irpf" value="<?php echo $datosPresupuesto['Retencion'];?>" style="text-align:right;" readonly />
<!--                <select name="irpf" class="selectFactura" style="text-align:right;font-weight:bold;width:100%;" tabindex="100" name="iprf"
                            onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" 
                            onChange="facturaCalculoIRPF(document.form1.totalImporte,document.form1.total,this,document.form1.IRPFcuota,document.form1.totalFinal);DesactivaImprimir();">
                      <?php
//                      $numIRPF=0;
//                      if(isset($datosPresupuesto['Retencion'])){
//                          $numIRPF=$datosPresupuesto['Retencion'];
//                      }
                      //listadoIVA($numIRPF);
                      ?>          
                </select>-->
            </td>
            <td align="left">
                <input type="text" class="textbox1readonly" name="IRPFcuota" style="text-align:right;" readonly />
            </td>
        </tr>
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
                    <input type="text" class="textbox1readonly" name="FormaPagoHabitual"
                           value="<?php echo $datosPresupuesto['FormaPago'];?>" style="width:100px;" readonly />
                </div>
            </td>
            <td align="right"><label class="nombreCampo">Validez del presupuesto</label></td>
            <td width="50px">
                <div align="left">
                <input class="textbox1" type="text" name="validez" maxlength="12" tabindex="102" value="<?php if(isset($datosPresupuesto)){echo $datosPresupuesto['Validez'];}else{echo '15';} ?>"
                       style="text-align:right;" readonly />
                </div>
            </td>
            <td align="left"><label class="nombreCampo">Dias</label></td>
          </tr>
      </table>
    
    <input type="hidden" name="linea" value="0"/>     
    <input type="hidden" name="esValido" value="false"/>     
    
        
      <P>
        <?php
        if(isset($_GET['IdPresupuesto'])){
            echo '<input type="hidden"  name="IdPresupuesto" value="'.$_GET['IdPresupuesto'].'" />';
        }else if(isset($varRes)){
            echo '<input type="hidden"  name="IdPresupuesto" value="'.$varRes.'" />';
        }else{
            echo '<input type="hidden"  name="IdPresupuesto" value="Nuevo" />';
        }
        ?>
        <input type="button" class="button" value = "Salir" onclick="javascript:salir();" />
        <?php
        if($datosContacto[0]==='CL'){
            if($datosPresupuesto['Estado']==='Aceptado'){
            ?>
                <input type="button" id="generar" name="generar" value = "Generar Pedido" class="button" onClick="generarFactura();" />
            <?php
            }else{
            ?>
                <input class="button" type="button" value="Volver" onclick="volver();" />
            <?php
            }
        }else{
        ?>
            <input type="button" value = "Pasar este Contacto a Cliente" class="button" 
                   onClick="javascript:document.location.href='../vista/altacontacto.php?IdContacto=<?php echo $datosContacto[1]; ?>';" />
        <?php
        }
        ?>
        <input type="hidden" name="IdPresupuesto" value="<?php echo $_GET['IdPresupuesto'];?>"/>     
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
</body>
</html>
