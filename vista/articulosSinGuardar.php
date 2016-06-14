<?php
session_start();
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

$clsCNContabilidad = new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['dbContabilidad']);
$clsCNContabilidad->setStrBDCliente($_SESSION['mapeo']);


logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
       " ||||Mis Presupuestos->Guardar Articulos||");

date_default_timezone_set('Europe/Madrid');
$fechaForm=date('d/m/Y');

$txtError = '';

//guardar un articulo
if(isset($_POST['cmdAlta']) && $_POST['cmdAlta'] === 'Aceptar'){
    //var_dump($_POST);die;
    //nuevo Articulo
    logger('info','articuloSinGuardar.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
           " ||||Presupuestos y Facturas->Articulo Nuevo||");

    $IdArticulo = $clsCNContabilidad->AltaArticulo($_POST);
    
    if($IdArticulo == false){
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/error.php?id=Se ha producido un error en el guardado del articulo">';
    }else{
        //se guarda el IdArticulo en la linea de $_POST[IdPresupLineas] (actualizar tbmispresupuestoslineas)
        if(isset($_POST['p'])){
            $varRes = $clsCNContabilidad->ActualizarLineaPresupuesto($_POST,$IdArticulo);
        }else if(isset($_POST['f'])){
            $varRes = $clsCNContabilidad->ActualizarLineaFactura($_POST,$IdArticulo);
        }else if(isset($_POST['pe'])){
            $varRes = $clsCNContabilidad->ActualizarLineaPedido($_POST,$IdArticulo);
        }
        
        //si falla la actualizacion anterior deshago el alta de articulo
        if($varRes == false){
            $clsCNContabilidad->BorrarArticulo($IdArticulo);
            $txtError = 'No se ha dado de alta el artículo en la base de datos';
        }else{
        
            //ahora a la vble. $_SESSION['lineasArticulosSinGuardar'] le quito la linea que ya
            //hemos guardado y volvemos a cargar la pagina
            //recorremos el array
            if(isset($_POST['p'])){
                $IdLinea = $_POST['IdPresupLineas'];
                $keyLinea = 'IdPresupLineas';
            }else if(isset($_POST['f'])){
                $IdLinea = $_POST['IdFacturaLineas'];
                $keyLinea = 'IdFacturaLineas';
            }
            
            for ($i = 0; $i < count($_SESSION['lineasArticulosSinGuardar']); $i++) {
                if($_SESSION['lineasArticulosSinGuardar'][$i][$keyLinea] === $IdLinea){
                    unset($_SESSION['lineasArticulosSinGuardar'][$i]);
                }
            }
            $_SESSION['lineasArticulosSinGuardar'] = array_values($_SESSION['lineasArticulosSinGuardar']);
            $txtError = 'Se ha dado de alta el artículo en la base de datos';
        }
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="../images/q.ico">
        <title>Guardar Artículos en la Base de Datos</title>
        <script language="JavaScript">
            <!-- //
            var txt="-    Sistema de Gestión de la Calidad    ";
            var espera=120;
            var refresco=null;
 
            function rotulo_status() {
                window.status=txt;
                txt=txt.substring(1,txt.length)+txt.charAt(0);        
                refresco=setTimeout("rotulo_status()",espera);
            }
 
            // --></script>
        <link href="../css/Estilos_Qualidad.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="../css/calidad2.css" type="text/css">
        
        <!--            HE INCLUIDO AQUI ESTAS LIBRERIAS DE jQuery PACO-->
        <?php
        librerias_jQuery_listado();
        ?>
        <!--       FIN     HE INCLUIDO AQUI ESTAS LIBRERIAS DE jQuery PACO-->

        <style>
            *{
                /*font-family: arial;*/
            }
        </style>
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function(){
                //formatear y traducir los datos de la tabla
                $('#datatablesMod').dataTable({
                    "bProcessing": true,
                    "sPaginationType":"full_numbers",
                    "oLanguage": {
                        "sLengthMenu": "Ver _MENU_ registros por pagina",
                        "sZeroRecords": "No se han encontrado registros",
                        "sInfo": "Ver _START_ al _END_ de _TOTAL_ Registros",
                        "sInfoEmpty": "Ver 0 al 0 de 0 registros",
                        "sInfoFiltered": "(filtrados _MAX_ total registros)",
                        "sSearch": "Busqueda:"
                    },
                    "bSort":true,
                    "aaSorting": [[ 0, "asc" ]],
                    "aoColumns": [
			{ "sType": 'string' },
			null
                    ],                    
                    "bJQueryUI":true,
                    "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]]
                });
            });
        </script>
<style type="text/css">
/* para que no salga el rectangulo inferior */        
.ui-widget-content {
    border: 0px solid #AAAAAA;
}
</style>      

<script LANGUAGE="JavaScript"> 

//comntrolar que solo se introduce datos numericos en el campo
 function Solo_Numerico(variable){
    Numer=parseInt(variable);
    if (isNaN(Numer)){
        return "";
    }
    return Numer;
}
function ValNumero(Control){
    Control.value=Solo_Numerico(Control.value);
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
<?php
//Funciones generales - carga las funciones auxiliares de eventos de los input text
    eventosInputText();
?>
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
               // clock.innerHTML = movingtime;
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
    
    </head>
    
    <body>
    <?php require_once '../vista/cabecera2.php'; ?>
        <style>
            #error{
                background-color: #6ce26c;
            }
        </style>
        <script>
        $(document).ready(function(){                  
           setTimeout("$('#error').hide(1000);", 3000);
        });
        </script>
<table align="center">
    <tr>
        <td>
            <div id="error">
                <?php echo $txtError; ?>
            </div>            
            <br/>
    
            <?php
            //extraigo la consulta de esta tabla
            //require_once '../CN/clsCNContabilidad.php';
            $arResult = $_SESSION['lineasArticulosSinGuardar'];

            if(isset($_GET['pid'])){
                $id = $_GET['pid'];
                $opcion = 'p';
            }else if($_POST['p']){
                $id = $_POST['p'];
                $opcion = 'p';
            }else if($_GET['fid']){
                $id = $_GET['fid'];
                $opcion = 'f';
            }else if($_POST['f']){
                $id = $_POST['f'];
                $opcion = 'f';
            }else if($_GET['peid']){
                $id = $_GET['peid'];
                $opcion = 'pe';
            }else if($_POST['pe']){
                $id = $_POST['pe'];
                $opcion = 'pe';
            }
            
            if(is_array($arResult) && count($arResult)>0){
            ?>
            <h3 align="center" color="#FFCC66"><font size="3px">Artículos a añadir a la Base de Datos</font></h3> 

            <br/>
            <script>
            function formOnOff(i){
                //cierro todos los div
                <?php
                for ($jj = 0; $jj < count($arResult); $jj++) {
                    echo "$('#inline$jj').hide();";
                }
                ?>
                //y abro el que toca
                $('#inline'+i).show(1000);
            }
            
            //indicar linea IdArticulos a 0 en tbpresupuestoslineas
            function ArticuloIdACeroP(id,idPresupLinea){
                if (confirm("¿Desea omitir el articulo de la base de datos?"))
                {
                    window.location='../vista/altaArticuloNOGuardar.php?Id='+id+'&IdPresupLinea='+idPresupLinea+'&tipo=p';
                }
            }
            
            //indicar linea IdArticulos a 0 en tbfacturaslineas y si tiene en presupuestos (tbpresupuestoslineas)
            function ArticuloIdACeroF(id,idFacturaLinea,idPresupLineas){
                if (confirm("¿Desea omitir el articulo de la base de datos?"))
                {
                    window.location='../vista/altaArticuloNOGuardar.php?Id='+id+'&IdFacturaLinea='+idFacturaLinea+'&idPresupLineas='+idPresupLineas+'&tipo=f';
                }
            }
            
            //indicar linea IdArticulos a 0 en tbfacturaslineas y si tiene en presupuestos (tbpresupuestoslineas)
            function ArticuloIdACeroPE(id,idPedidoLinea,idPresupLineas){
                if (confirm("¿Desea omitir el articulo de la base de datos?"))
                {
                    window.location='../vista/altaArticuloNOGuardar.php?Id='+id+'&IdPedidoLinea='+idPedidoLinea+'&idPresupLineas='+idPresupLineas+'&tipo=f';
                }
            }
            
            </script>
            
            <?php
            //}
            
            ?>
            
            <table id="datatablesMod" class="display" style="width: 650px;">
                <thead>
                    <tr>
                        <th width="75%">Concepto</th>
                        <th width="25%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //if(is_array($arResult)){
                        for ($i = 0; $i < count($arResult); $i++) {
                            $href = "";
                            if(isset($_GET['pid']) || isset($_POST['p'])){
                                $href = '<a href="javascript:ArticuloIdACeroP(' . $id . ',' . $arResult[$i]['IdPresupLineas'] . ');"><input type="button" class="button" name="No" value="No" /></a>';
                            }else if(isset($_GET['fid']) || isset($_POST['f'])){
                                $href = '<a href="javascript:ArticuloIdACeroF(' . $id . ',' . $arResult[$i]['IdFacturaLineas'] . ',' . $arResult[$i]['IdPresupLineas'] . ');"><input type="button" class="button" name="No" value="No" /></a>';
                            }else if(isset($_GET['peid']) || isset($_POST['pe'])){
                                $href = '<a href="javascript:ArticuloIdACeroPE(' . $id . ',' . $arResult[$i]['IdPedidoLineas'] . ',' . $arResult[$i]['IdPresupLineas'] . ');"><input type="button" class="button" name="No" value="No" /></a>';
                            }
                            
                            ?>
                            <tr>
                                <td onClick=""><?php echo $arResult[$i]['concepto']; ?></td>
                                <td align="center">
                                    <?php echo '<input type="button" class="button" name="Si" value="Si" onClick="formOnOff('.$i.');" />'; ?>
                                    <?php echo $href; ?>
                                </td>
                            </tr>
                            <?php
                        }
                    //}
                    ?>
                </tbody>
            </table>
            <?php
            }else{
                echo "No hay mas artículos de este presupuesto para guardar<br/><br/>";
            }
            
            if(isset($_GET['pid']) || isset($_POST['p'])){
            ?>
                <a href="../vista/altapresupuesto.php?IdPresupuesto=<?php echo $id; ?>"><input type="button" class="button" name="Volver" value="Volver a Presupuesto" /></a>
            <?php
            }else if(isset($_GET['fid']) || isset($_POST['f'])){
            ?>
                <a href="../vista/altafactura.php?IdFactura=<?php echo $id; ?>"><input type="button" class="button" name="Volver" value="Volver a Factura" /></a>
            <?php
            }else if(isset($_GET['peid']) || isset($_POST['pe'])){
            ?>
                <a href="../vista/altapedido.php?IdPedido=<?php echo $id; ?>"><input type="button" class="button" name="Volver" value="Volver a Pedido" /></a>
            <?php
            }
            ?>
            <br/><br/><br/>

        <!--formularios emergentes Guardar articulo    -->
        <?php
        
        
        
        if(is_array($arResult)){
            for ($fi = 0; $fi < count($arResult); $fi++) {
                ?>
                <script>
                    function validar<?php echo $fi;?>(){
                        
                        esValido=true;
                        textoError='';
                        
                        //compruebo que la referencia no exista en la tabla 'tbarticulos'
                        $.ajax({
                          data:{"opcion":"Referencia","dato":document.articulo<?php echo $fi;?>.Referencia.value},  
                          url: '../vista/ajax/articuloComprobarExiste.php',
                          type:"get",
                          success: function(data) {
                            if(data === 'SI'){
                                textoError=textoError+"La Referencia de artículo introducida ya existe en la base de datos.\n";
                                document.articulo<?php echo $fi;?>.Referencia.style.borderColor='#FF0000';
                                document.articulo<?php echo $fi;?>.Referencia.title ='La Referencia del artículo introducida ya existe en la base de datos';
                                esValido=false;
                            }
                            
                            //ahora compruebo que la descripcion no exista en la tabla 'tbarticulos'
                            //lo hago asi anidado para que siga este flujo
                            $.ajax({
                              data:{"opcion":"Descripcion","dato":document.articulo<?php echo $fi;?>.Descripcion.value},  
                              url: '../vista/ajax/articuloComprobarExiste.php',
                              type:"get",
                              success: function(data) {
                                if(data === 'SI'){
                                    textoError=textoError+"La Descripcion del artículo introducida ya existe en la base de datos.\n";
                                    document.articulo<?php echo $fi;?>.Descripcion.style.borderColor='#FF0000';
                                    document.articulo<?php echo $fi;?>.Descripcion.title ='La Descripcion del artículo introducida ya existe en la base de datos';
                                    esValido=false;
                                }
                                
                                //ahora sigo con las demas comprobaciones
                                //comprobacion del campo 'Referencia'
                                if (document.articulo<?php echo $fi;?>.Referencia.value == ''){ 
                                  textoError=textoError+"Es necesario introducir la Referencia.\n";
                                  document.articulo<?php echo $fi;?>.Referencia.style.borderColor='#FF0000';
                                  document.articulo<?php echo $fi;?>.Referencia.title ='Se debe introducir la Referencia';
                                  esValido=false;
                                }
                                //comprobacion del campo 'Descripcion'
                                if (document.articulo<?php echo $fi;?>.Descripcion.value == ''){ 
                                  textoError=textoError+"Es necesario introducir la descripción.\n";
                                  document.articulo<?php echo $fi;?>.Descripcion.style.borderColor='#FF0000';
                                  document.articulo<?php echo $fi;?>.Descripcion.title ='Se debe introducir la descripción';
                                  esValido=false;
                                }
//                                //comprobacion del campo 'Precio'
//                                if (document.articulo<?php //echo $fi;?>.Precio.value == ''){ 
//                                  textoError=textoError+"Es necesario introducir El precio.\n";
//                                  document.articulo<?php //echo $fi;?>.Precio.style.borderColor='#FF0000';
//                                  document.articulo<?php //echo $fi;?>.Precio.title ='Se deben introducir El precio';
//                                  esValido=false;
//                                }
                                //comprobacion del campo 'cantidadAlmacen'
                                if (document.articulo<?php echo $fi;?>.cantidadAlmacen.value == ''){ 
                                  textoError=textoError+"Es necesario introducir la cantidad del almacén.\n";
                                  document.articulo<?php echo $fi;?>.cantidadAlmacen.style.borderColor='#FF0000';
                                  document.articulo<?php echo $fi;?>.cantidadAlmacen.title ='Se debe introducir la cantidad del almacén';
                                  esValido=false;
                                }
                                
                                
                                //indicar el mensaje de error si es 'esValido' false
                                if (!esValido){
                                        alert(textoError);
                                }

                                if(esValido==true){
                                    document.getElementById("cmdAlta<?php echo $fi;?>").value = "Enviando...";
                                    document.getElementById("cmdAlta<?php echo $fi;?>").disabled = true;
                                    document.articulo<?php echo $fi;?>.submit();
                                }else{
                                    return false;
                                }  
                              }
                            });
                          }
                        });
                    }
                </script>
                
                <div class="doc" id="inline<?php echo $fi;?>" style="display: none;">
                        <form id="articulo<?php echo $fi;?>" name="articulo<?php echo $fi;?>" action="../vista/articulosSinGuardar.php" method="post">
                            <table width="650" border="0" class="zonaactiva" align="center">
                              <tr> 
                                <td class="subtitulo" colspan="9">&nbsp;Datos del Artículo</td>
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
                                    <label class="nombreCampo">Referencia</label>
                                    <input class="textbox1" type="text" name="Referencia" id="Referencia" maxlength="25"
                                           value=""
                                           onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" 
                                           onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
                                    </div>
                                </td>
                                <td></td>
                                <td>
                                    <div align="left">
                                    <label class="nombreCampo">Descripción</label>
                                    <input class="textbox1" type="text" name="Descripcion" id="descripcion" maxlength="255"
                                           value="<?php if(isset($arResult[$fi]['concepto'])){echo $arResult[$fi]['concepto'];}?>"
                                           onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" 
                                           onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
                                    </div>
                                </td>
                                <td colspan="1"></td>
                              </tr>
                              
<!--                              <tr> 
                                <td></td>
                                <td>
                                    <div align="left">
                                    <label class="nombreCampo">Precio</label>
                                    <input class="textbox1" type="text" name="Precio" id="Precio" maxlength="15"
                                           value="<?php //if(isset($arResult[$fi]['precio'])){echo formateaNumeroContabilidad($arResult[$fi]['precio']);}?>"
                                           onkeypress="return solonumeros(event);"
                                           onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" 
                                           onfocus="desFormateaCantidad(this);this.select();onFocusInputText(this);" onblur="onBlurInputText(this);formateaCantidad(this);"/>
                                    </div>
                                </td>
                                <td></td>
                                <td>
                                    <div align="left" style="width: 30%;">
                                    <label class="nombreCampo">Tipo IVA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <select name="tipoIVA"
                                            class="textbox1" style="text-align:right;font-weight:bold;width:50%;"
                                            onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);">
                                        <?php
                                        //preparo el listado del select
//                                        $selected0='';
//                                        $selected4='';
//                                        $selected10='';
//                                        $selected21='';
//                                        if(isset($arResult[$fi]['iva'])){ //existe IVA
//                                            if($arResult[$fi]['iva']==0){
//                                                $selected0='selected';
//                                            }else if($arResult[$fi]['iva']==4){
//                                                $selected4='selected';
//                                            }else if($arResult[$fi]['iva']==10){
//                                                $selected10='selected';
//                                            }else if($arResult[$fi]['iva']==21){
//                                                $selected21='selected';
//                                            }
//                                        }else //no existe IVA, por defecto 21%
//                                        {
//                                            $selected21='selected';
//                                        }
//                                        //preparo el listado del select
//                                        echo "<option value = '0' $selected0> 0</option>";
//                                        echo "<option value = '4' $selected4> 4</option>";
//                                        echo "<option value = '10' $selected10>10</option>";
//                                        echo "<option value = '21' $selected21>21</option>";
                                        ?>
                                    </select>
                                    </div>
                                </td>
                                <td colspan="1"></td>
                              </tr>-->
                              <input type="hidden"  name="Precio" value="<?php if(isset($arResult[$fi]['precio'])){echo formateaNumeroContabilidad($arResult[$fi]['precio']);}?>" />
                              <input type="hidden"  name="tipoIVA" value="<?php if(isset($arResult[$fi]['iva'])){echo $arResult[$fi]['iva'];}?>" />
                              <input type="hidden"  name="idPresupLineas" value="<?php if(isset($arResult[$fi]['IdPresupLineas'])){echo $arResult[$fi]['IdPresupLineas'];}?>" />
                              
                              
                              <tr> 
                                <td></td>
                                <td>
                                    <div align="left">
                                    <label class="nombreCampo">Cantidad Almacén</label>
                                    <input class="textbox1" type="text" name="cantidadAlmacen" id="cantidadAlmacen" maxlength="10"
                                           value=""
                                           onkeypress="return solonumeros(event);"
                                           onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" 
                                           onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
                                    </div>
                                </td>
                                <td></td>
                                <td>
                                    <div align="left">
                                      <label class="nombreCampo">Cuenta Contable</label>
                                      <select class="textbox1" name="cuentaContable">
                                      <?php
                                      $listadoCuentasContables = $clsCNContabilidad->listarCuentasArticulos();
                                      //preparo el listado
                                      echo "<option value=''></option>";
                                      for ($i = 0; $i < count($listadoCuentasContables); $i++) {
                                          echo "<option value='".$listadoCuentasContables[$i]['NumCuenta']."'>".$listadoCuentasContables[$i]['cuenta']."</option>";
                                      }
                                      ?>
                                      </select>
                                    </div>
                                </td>
                                <td colspan="1"></td>
                              </tr>
                              <tr>
                                <td></td>
                                <td></td>
                                <td colspan="2">
                                    <div align="left">
                                      <label class="nombreCampo">Grupo</label>
                                      <select class="textbox1" name="IdGrupo">
                                      <?php
                                      $ListadoGruposArticulos=$clsCNContabilidad->ListadoGruposArticulos();
                                      //preparo el listado
                                      for ($i = 0; $i < count($ListadoGruposArticulos); $i++) {
                                          echo"<option value='".$ListadoGruposArticulos[$i]['IdGrupo']."'>".$ListadoGruposArticulos[$i]['Grupo']."</option>";
                                      }
                                      ?>
                                      </select>
                                    </div>
                                </td>
                              </tr>
                              <tr>
                                  <td height="15px"></td>
                              </tr>
                            </table>

                            <input type="button" class="button" id="cmdAlta<?php echo $fi;?>" onclick="validar<?php echo $fi;?>();" value="Guardar" />
                            <input type="hidden" name="cmdAlta" value="Aceptar" />
                            <input type="hidden" name="<?php echo $opcion; ?>" value="<?php echo $id; ?>" />
                            <?php
                            $valorId = '0';
                            $nameId = 'IdPresupLineas';
                            
                            if(isset($arResult[$fi]['IdPresupLineas']) && $arResult[$fi]['IdPresupLineas'] !== ''){
                                if(isset($arResult[$fi]['IdFacturaLineas']) && $arResult[$fi]['IdFacturaLineas'] !== ''){
                                    $valorId = $arResult[$fi]['IdFacturaLineas'];
                                    $nameId = 'IdFacturaLineas';
                                }else
                                if(isset($arResult[$fi]['IdPedidoLineas']) && $arResult[$fi]['IdPedidoLineas'] !== ''){
                                    $valorId = $arResult[$fi]['IdPedidoLineas'];
                                    $nameId = 'IdPedidoLineas';
                                }else{
                                    $valorId = $arResult[$fi]['IdPresupLineas'];
                                    $nameId = 'IdPresupLineas';
                                }
                            }
                            ?>
                            <input type="hidden" name="<?php echo $nameId; ?>" value="<?php echo $valorId; ?>" />
                        </form>
                </div>
                <?php
            }
        }
        ?>
            
            
            
            <br/>
            <?php include '../vista/IndicacionIncidencia.php'; ?>
        </td>
        </tr>
        </table>
        
        
    </body>
</html>
