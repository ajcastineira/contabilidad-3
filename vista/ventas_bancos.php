<?php
//VER ERRORES
//error_reporting(E_ALL); 

session_start ();
require_once '../CN/clsCNDatosVentas.php';
require_once '../general/funcionesGenerales.php';


////Control de Sesion
//ControlaLoginTimeOut();
//
////Control de Permisos. Hay que incluirlo en todas las páginas
///**************************************************************/
//$strPagina=dameURL();
//$strCargo = trim($_SESSION['cargo']);   //Esto es el puesto al que le hacemos un trim
//
//$lngPermiso = AccesoUsuarioPagina ($strPagina, $strCargo);  // Le pasamos la página y el cargo. 
//
//if ($lngPermiso==-1)
//{//Se ha producido un error de base. TENDREMOS QUE PASAR A LA FUNCION ERROR
//    ControlErrorPermiso();
//    die;
//}
//if ($lngPermiso==0)
//{//El usuario no tiene permisos por tanto mostramos error
//    ControlAvisoPermiso();
//    die;
//}

//Si devuelve 1 entonces que siga el flujo 
/**************************************************************/

$clsCNDatosVentas = new clsCNDatosVentas();
$clsCNDatosVentas->setStrBD($_SESSION['dbContabilidad']);
$clsCNDatosVentas->setStrBDCliente($_SESSION['mapeo']);


logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
       " ||||entrada Datos de Ventas");


$listadoCuentasBancos = $clsCNDatosVentas->ListadoCuentasBancos($_GET['cuentaBanco']);
$listadoBancosJS = $clsCNDatosVentas->ListadoBancosJS();        

//ESTO AHORA NO VA A VALER 27/1/2016  BORRAR
//if(isset($_POST['calcular']) && $_POST['calcular'] === 'SI'){
//
//    $_POST['calcular'] = 'NO';
//    
//    //preparo el array de datos de la tabla
//    $tabla = '';
//    foreach ($_POST as $key => $value) {
//        //vamos cojiendo segun su identificacion
//        if(substr($key,0,7) === 'IdBanco'){
//            $ii = substr($key,7);
//            $tabla[$ii]['IdBanco'] = $value; 
//        }
//        if(substr($key,0,9) === 'fechaFila'){
//            $ii = substr($key,9);
//            $tabla[$ii]['fechaFila'] = $value; 
//        }
//        if(substr($key,0,8) === 'Cantidad' && !(substr($key,0,19) === 'Cantidad_distribuir') && !(substr($key,0,15) === 'CantidadInicial')){
//            $ii = substr($key,8);
//            if($value === ''){
//                $tabla[$ii]['Cantidad'] = ''; 
//            }else{
//                $tabla[$ii]['Cantidad'] = desFormateaNumeroContabilidad($value); 
//            }
//            $tabla[$ii]['Cantidad_distribuir'] = '';
//        }
//        if(substr($key,0,10) === 'Distribuir'){
//            $ii = substr($key,10);
//            $tabla[$ii]['Distribuir'] = $value; 
//        }
//    }
//    
//    //ahora recorro el array y hago lo siguiente:
//    //1 veo si tiene la vble=Distribuir y el valor=1
//    //1.1 si es asi hago el calculo de la distribucion hacia arriba empezando por el dia anterior
//    //1.2 Si no es asi, es que no se distribuye, lo unico que hago es copiar el valor en el campo CD
//    for ($i = 0; $i < count($tabla); $i++) {
//        if(isset($tabla[$i]['Distribuir']) && $tabla[$i]['Distribuir'] === '1'){
//            //1.1
//            $dia = explode('-',$tabla[$i]['fechaFila']);
//            $restoFecha = $dia[0].'-'.$dia[1].'-';
//            $dia = (int)$dia[2];
//            
//            //ahora preparo el array de distribucion
//            $distribucion = "";
//            for ($ii = 1; $ii <= 5; $ii++) {
//                $dia = $dia - 1;
//                if($dia >= 1){
//                    //veo si el numero tiene una longitud de 2, sino le añado un 0 delante
//                    if(strlen($dia) < 2){
//                        $dia = '0'.$dia;
//                    }
//                    //añado este dia al array
//                    $distribucion[$ii]['fecha'] = $restoFecha.$dia;
//                }else{
//                    //veo sino existe todavia datos en el array
//                    //si no lo es añado el dia de hoy y salgo del for
//                    if(!is_array($distribucion)){
//                        $distribucion[$ii]['fecha'] = $tabla[$i]['fechaFila'];
//                    }
//                }
//            }
//            
//            //ahora calculo las cantidades distribuidas entre los dias del array
//            $numArray = count($distribucion);
//            $cantDistribuir = round($tabla[$i]['Cantidad'] / $numArray,2);
//            $cantidadRestante = (float)$tabla[$i]['Cantidad'];
//            
//            //ahora recorro el array de distribucion (menos la ultima posicion)
//            // y voy actualizando el campo CD segun la fecha
//            for ($ii = 1; $ii <= $numArray-1; $ii++) {
//                //busco la fila de la tabla por la fecha
//                for ($iii = 0; $iii < count($tabla); $iii++) {
//                    if($tabla[$iii]['fechaFila'] === $distribucion[$ii]['fecha']){
//                        $tabla[$iii]['Cantidad_distribuir'] = $tabla[$iii]['Cantidad_distribuir'] + $cantDistribuir;
//                        break;
//                    }
//                }
//                //resto la cantidaRestante para la ultima distribucion
//                $cantidadRestante = (float)$cantidadRestante - $cantDistribuir;
//            }
//            //ahora la ultima posicion del array pongo la cantidadRestante
//            for ($iii = 0; $iii < count($tabla); $iii++) {
//                if($tabla[$iii]['fechaFila'] === $distribucion[$numArray]['fecha']){
//                    $tabla[$iii]['Cantidad_distribuir'] = $tabla[$iii]['Cantidad_distribuir'] + $cantidadRestante;
//                    break;
//                }
//            }
//        }else{
//            //1.2
//            $tabla[$i]['Cantidad_distribuir'] = $tabla[$i]['Cantidad'];
//        }
//    }
//    
//    var_dump($tabla);die;
//    //ahora guardamos estos datos (campo CD) de la tabla en la BBDD
//    for ($i = 0; $i < count($tabla); $i++) {
//        //veo si existe IdBanco (si existe es una fila que exite y actualizamos los datos)
//        if($tabla[$i]['IdBanco'] !== ''){
//            $OK = $clsCNDatosVentas->actualizarBancoFilaCampoCD($tabla[$i]);
//        }else{
//            $OK = $clsCNDatosVentas->nuevaBancoFilaCampoCD($tabla[$i],$_POST['cuentaBanco']);
//        }
//        
//    }
//    
//    
//}





?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="../images/q.ico">
        <title>Ventas - Bancos</title>
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
            //var editor; 
            
            $(document).ready(function(){
//                //formatear y traducir los datos de la tabla
//                $('#datatablesMod').dataTable({
//                    "bProcessing": true,
//                    "sPaginationType":"full_numbers",
//                    "oLanguage": {
//                        "sLengthMenu": "Ver _MENU_ registros por pagina",
//                        "sZeroRecords": "No se han encontrado registros",
//                        "sInfo": "Ver _START_ al _END_ de _TOTAL_ Registros",
//                        "sInfoEmpty": "Ver 0 al 0 de 0 registros",
//                        "sInfoFiltered": "(filtrados _MAX_ total registros)",
//                        "sSearch": "Busqueda:"
//                    },
//                    "bSort":true,
//                    "aaSorting": [[ 0, "asc" ]],
//                    "aoColumns": [
//			{ "sType": 'string' },
//			{ "sType": 'string' },
//			{ "sType": 'string' },
//			{ "sType": 'string' },
//			{ "sType": 'string' },
//			null,
//			{ "sType": 'string' },
//			{ "sType": 'string' },
//			{ "sType": 'string' },
//			{ "sType": 'string' },
//			{ "sType": 'string' },
//			{ "sType": 'string' },
//			{ "sType": 'string' }
//                    ],                    
//                    "bJQueryUI":true,
//                    "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]]
//                });
                
                
                
                
            });
        </script>
<style type="text/css">
/* para que no salga el rectangulo inferior */        
/*.ui-widget-content {
    border: 0px solid #AAAAAA;
}*/
</style>      

<script LANGUAGE="JavaScript"> 
//formatear valores numericos con puntos de miles y comas para decimales
function formateaNumContabilidad(objeto) {
    var numero = objeto.value;
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

    //actualizo el valor del objeto que se para por referencia
    objeto.value = numero;
    return true;
}

function desFormateaNumContabilidad(objeto) {
    var numero = objeto.value;
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
    
    //actualizo el valor del objeto que se para por referencia
    objeto.value = numero;
    return true;
}
    </script>
<?php
//Funciones generales - carga las funciones auxiliares de eventos de los input text
    eventosInputText();
?>
    </head>
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
    
    <body>
    <?php require_once '../vista/cabecera2Asesor.php'; ?>
        
<table align="center">
    <tr>
        <td>
            <div align="center"><h3>Entrada Datos de Bancos</h3></div>

    <form name="form1" action="../vista/ventas_bancos.php" method="get">
    <table align="center" border="0" width="">
        <tr></tr>
        <tr><td>
<!--    <label class="filtroTexto" align="center" onclick="onOff_filtro(document.getElementById('filtros'));">Filtros</label> -->
    <div id="filtros" style="display: block;">
    <table class="filtro" align="center" border="0" width="725">
    <tr>
        <td width="150"></td>
        <td width="200"></td>
        <td width="100"></td>
        <td width="100"></td>
        <td width="200"></td>
        <td width=""></td>
    </tr>    
    <tr> 
      <td class="nombreCampo"><div align="right">Mes:</div></td>
      <td>
          <div align="left">
            <select name="mes" class="textbox1" tabindex="5">
                <option value=""></option>
                <option value="01" <?php if((isset($_GET['mes']) && $_GET['mes']==='01')){echo 'selected';}?>>Enero</option>
                <option value="02" <?php if((isset($_GET['mes']) && $_GET['mes']==='02')){echo 'selected';}?>>Febrero</option>
                <option value="03" <?php if((isset($_GET['mes']) && $_GET['mes']==='03')){echo 'selected';}?>>Marzo</option>
                <option value="04" <?php if((isset($_GET['mes']) && $_GET['mes']==='04')){echo 'selected';}?>>Abril</option>
                <option value="05" <?php if((isset($_GET['mes']) && $_GET['mes']==='05')){echo 'selected';}?>>Mayo</option>
                <option value="06" <?php if((isset($_GET['mes']) && $_GET['mes']==='06')){echo 'selected';}?>>Junio</option>
                <option value="07" <?php if((isset($_GET['mes']) && $_GET['mes']==='07')){echo 'selected';}?>>Julio</option>
                <option value="08" <?php if((isset($_GET['mes']) && $_GET['mes']==='08')){echo 'selected';}?>>Agosto</option>
                <option value="09" <?php if((isset($_GET['mes']) && $_GET['mes']==='09')){echo 'selected';}?>>Septiembre</option>
                <option value="10" <?php if((isset($_GET['mes']) && $_GET['mes']==='10')){echo 'selected';}?>>Octubre</option>
                <option value="11" <?php if((isset($_GET['mes']) && $_GET['mes']==='11')){echo 'selected';}?>>Noviembre</option>
                <option value="12" <?php if((isset($_GET['mes']) && $_GET['mes']==='12')){echo 'selected';}?>>Diciembre</option>
            </select>
          </div>
      </td>
      <td></td>
      <td class="nombreCampo"><div align="right">Ejercicio:</div></td>
      <td>
          <div align="left">
            <select name="ejercicio" class="textbox1" tabindex="5">
                <?php
                $selec2015 = '';
                $selec2016 = '';
                $selec2017 = '';
                $selec2018 = '';
                if(isset($_GET['ejercicio'])){
                    if($_GET['ejercicio']==='2015'){
                        $selec2015 = 'selected';
                    }else
                    if($_GET['ejercicio']==='2016'){
                        $selec2016 = 'selected';
                    }else
                    if($_GET['ejercicio']==='2017'){
                        $selec2017 = 'selected';
                    }else
                    if($_GET['ejercicio']==='2018'){
                        $selec2018 = 'selected';
                    }
                }else{
                    if(date('Y') === '2015'){
                        $selec2015 = 'selected';
                    }else
                    if(date('Y') === '2016'){
                        $selec2016 = 'selected';
                    }else
                    if(date('Y') === '2017'){
                        $selec2017 = 'selected';
                    }else
                    if(date('Y') === '2018'){
                        $selec2018 = 'selected';
                    }
                }
                ?>
                <option value="2015" <?php echo $selec2015; ?>>2015</option>
                <option value="2016" <?php echo $selec2016; ?>>2016</option>
                <option value="2017" <?php echo $selec2017; ?>>2017</option>
                <option value="2018" <?php echo $selec2018; ?>>2018</option>
            </select>
          </div>
      </td>
      <td class="nombreCampo" rowspan="2" colspan="2" nowrap>
      </td>
    </tr>
    <tr>
      <td class="nombreCampo"><div align="right">Cuenta de Banco:</div></td>
      <td>
          <div align="left">
            <?php echo $listadoCuentasBancos;?>
          </div>
      </td>
      <td></td>
      <td class="nombreCampo"><div align="right"></div></td>
      <td>
      </td>
      <td class="nombreCampo" rowspan="2" colspan="2" nowrap>
      </td>
    </tr>
    
    <tr> 
      <td colspan="8"><hr align="left"></td>
    </tr>
     <tr align="center">
         <td colspan="8">
<!--             <input type="Reset" class="button" value="Vaciar Datos" name="cmdReset"/>-->
             <input type="submit" class="button" value="Consultar" name="cmdConsultar"  />
             <input name="cmdListar" type="hidden" value="OK"/>
         </td>
     </tr>
     </table>
    </div>
    </td></tr>
    <tr></tr>
    </table>   
    </form>
    
            <?php
                $arResult = $clsCNDatosVentas->ListadoVentasBancos($_GET);
                //$arResult = $clsCNDatosVentas->ListadoVentas($_GET);
                //var_dump($arResult);die;
            ?>

            <br/>
            <style>
                .inputDatos{
                    background-color: transparent;
                    border: 0px solid;
                    width: 110px;
                    text-align:right;
                }
                .inputDatosTarjeta{
                    background-color: transparent;
                    border: 0px solid;
                    width: 150px;
                }
                .labelDatos{
                    font-size: 14px;
                }
                
                /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
                 * DataTables display
                 */
                table.tablaExcel {
                    margin: 0 auto;
                    clear: both;
                    border-collapse: collapse;
                    font-size: 12px;
                }

                table.tablaExcel thead th {
                    padding: 2px 2px 2px 5px;
                    font-weight: bold;
                    font-size: 13px;
                }

                table.tablaExcel tr.heading2 td {
/*                        border-bottom: 1px solid #aaa;*/
                }

                table.tablaExcel td {
                    padding: 2px 5px;
                }

                table.tablaExcel td.center {
                        /*text-align: center;*/
                }
            </style>
            
            <script type="text/javascript">

            //actualizo este campo segun llego (focus)
            function datoInicial(valor,id){
                document.getElementById(id).value = valor;
            }    
                
            //hago las funciones que van a actualizar por AJAX los datos en la tabla "tbventas_bancos"
            function acCD(iTabla,cantidad_distribuir,IdBanco,cuentaBanco,CD_Inicial,fecha){
                //compruebo si "cantidad_distribuir" y "CD_Inicial" son iguales o no
                //si son iguales es que no a cambiado por lo que no se hace nada, si son distintas
                //se ejecuta a accion
                
                if(isNaN(cantidad_distribuir)){
                    alert('Este valor no es numérico');
                    $('#Cantidad_distribuir'+iTabla).val('');
                }else{
                
                    //redondeamos cantidad_distribuir
                    if(cantidad_distribuir !== ''){
                        cantidad_distribuir = redondeo2dec(cantidad_distribuir);
                    }

                    if(cantidad_distribuir !== parseFloat(CD_Inicial)){
                        //1º actualizo el dato de cantidad en la tabla
                        $.ajax({
                            data:{"cantidad_distribuir":cantidad_distribuir,"IdBanco":IdBanco,"cuentaBanco":cuentaBanco,"fecha":fecha},
                            url: '../vista/ajax/ventas_actCD.php',
                            type:"get",
                            success: function(data) {
                                //si devuelve la palabra 'editado', es que ha editado correctamente
                                //si devuelve un numero, es la insercion de una nueva linea
                                var datos = JSON.parse(data);
                                //cargar el IdBanco*
                                $('#IdBanco'+iTabla).val(datos.IdBanco);

                                //recalcula sumas
                                //guardo todos los datos de la tabla (fecha, cantidad y si se distribuye o no)
                                var Cantidad = [];
                                var Asiento = [];
                                var Cantidad_distribuir = [];

                                $('#formBancos').find(":input").each(function(){
                                    var elemento = this;
                                    //comprobamos el nombre del elemento y lo guardamos en ua array segun sea cantidad, precio, importe y concepto
                                    var nombreElemento = elemento.name;
                                    if(nombreElemento.substring(0,19) === 'Cantidad_distribuir'){//es un elemento Cantidad_distribuir
                                        Cantidad_distribuir[nombreElemento.substr(19,3)] = desFormateaNumeroContabilidad(elemento.value);
                                    }else
                                    if(nombreElemento.substring(0,8) === 'Cantidad' && !(nombreElemento.substring(0,19) === 'Cantidad_distribuir') && !(nombreElemento.substring(0,15) === 'CantidadInicial')){//es un elemento Cantidad
                                        Cantidad[nombreElemento.substr(8,3)] = desFormateaNumeroContabilidad(elemento.value);
                                    }else
                                    if(nombreElemento.substring(0,12) === 'AsientoBanco'){//es un elemento Asiento
                                        Asiento[nombreElemento.substr(12,3)] = elemento.value;
                                    }
                                });

                                var arraysCampos = [];
                                for(i in Cantidad){
                                    var objeto ={"Cantidad":Cantidad[i],"Asiento":Asiento[i],"Cantidad_distribuir":Cantidad_distribuir[i]};
                                    arraysCampos.push(objeto);
                                }

                                //ahora hago las sumas
                                var sumaCantidad = 0;
                                var sumaCD = 0;

                                for(i=0;i<arraysCampos.length;i++){
                                    //compruebo que el asiento no sea numerico (esta contabilizado) y no se incluye en este calculo
                                    if(isNaN(parseInt(arraysCampos[i].Asiento))){
                                        sumaCantidad = redondeo2dec(sumaCantidad + parseFloat(arraysCampos[i].Cantidad));
                                        sumaCD = redondeo2dec(sumaCD + parseFloat(arraysCampos[i].Cantidad_distribuir));
                                    }
                                }

                                var diferencia = redondeo2dec(sumaCD - sumaCantidad);

                                $('#sumaCD').html(formateaNumeroContabilidad(sumaCD.toString()));
                                $('#sumaCantidad').html(formateaNumeroContabilidad(sumaCantidad.toString()));
                                $('#diferencia').html(formateaNumeroContabilidad(diferencia.toString()));
                            }
                        });
                    }
                
                }
            }
                
            function actCantidad(iTabla,cantidad,IdBanco,cuentaBanco,CantidadInicial,fecha){
                //compruebo si "cantidad" y "CantidadInicial" son iguales o no
                //si son iguales es que no a cambiado por lo que no se hace nada, si son distintas
                //se ejecuta a accion
                
                
                if(isNaN(cantidad)){
                    alert('Este valor no es numérico');
                    $('#Cantidad'+iTabla).val('');
                }else{

                    //redondeamos cantidad
                    if(cantidad !== ''){
                        cantidad = redondeo2dec(cantidad);
                    }

                    if(CantidadInicial !== cantidad){
                        //1º actualizo el dato de cantidad en la tabla
                        $.ajax({
                            data:{"cantidad":cantidad,"IdBanco":IdBanco,"cuentaBanco":cuentaBanco,"fecha":fecha},
                            url: '../vista/ajax/ventas_actCantidad.php',
                            type:"get",
                            success: function(data) {
                                //si devuelve la palabra 'editado', es que ha editado correctamente
                                //si devuelve un numero, es la insercion de una nueva linea
                                var datos = JSON.parse(data);
                                //cargar el IdBanco*
                                $('#IdBanco'+iTabla).val(datos.IdBanco);
                                //cargar numero de cuenta de banco
                                if(datos.cuentaBanco !== 'null'){
                                    var htmlCuenta = "<select id='Cuenta"+iTabla+"' name='Cuenta"+iTabla+"' tabindex='"+iTabla+"0006' onchange='actCuenta(this.value,"+iTabla+");'>";
                                    htmlCuenta = htmlCuenta + "<option value='570000000' selected>0 - Caja</option>";//caja
                                    <?php
                                    for ($i = 0; $i < count($listadoBancosJS); $i++) {
                                        $cuenta = (int) substr($listadoBancosJS[$i]['NumCuenta'],4);
                                        ?>
                                        if(parseInt(cuentaBanco) === <?php echo $listadoBancosJS[$i]['NumCuenta'];?>){
                                            htmlCuenta = htmlCuenta + "<option value='<?php echo $listadoBancosJS[$i]['NumCuenta'];?>' selected><?php echo $cuenta . ' - ' . $listadoBancosJS[$i]['Nombre'];?></option>";
                                        }else{
                                            htmlCuenta = htmlCuenta + "<option value='<?php echo $listadoBancosJS[$i]['NumCuenta'];?>'><?php echo $cuenta . ' - ' . $listadoBancosJS[$i]['Nombre'];?></option>";
                                        }
                                        <?php
                                    }
                                    ?>
                                    $('#CuentaDiv'+iTabla).html(htmlCuenta);
                                }else{
                                    $('#CuentaDiv'+iTabla).html('');
                                }

                                //genero el DOM del select de esta fila
                                if(datos.cantidad !== 'null'){
                                    var htmlAsiento = "<select name='AsientoBanco"+iTabla+"' tabindex='"+iTabla+"0006'>";
                                    htmlAsiento = htmlAsiento + "<option value='P' selected>P</option>";
                                    htmlAsiento = htmlAsiento + "<option value='X'>X</option>";
                                    htmlAsiento = htmlAsiento + "</select>";
                                    $('#Distribuir'+iTabla).prop("checked", true);
                                }else{
                                    var htmlAsiento = "";
                                    $('#Distribuir'+iTabla).prop("checked", false);
                                    $('#Distribuir'+iTabla).prop("disabled", true);
                                }
                                $('#AsientoBancoDiv'+iTabla).html(htmlAsiento);

                                //hago la distribucion de todos los campos de esta tabla (este mes)
                                calculoDistribucion();
                            }
                        });
                    }
                
                }
            }
            
            function calculoDistribucion(){
                //guardo todos los datos de la tabla (fecha, cantidad y si se distribuye o no)
                var IdBanco = [];
                var fechaFila = [];
                var Cantidad = [];
                var Distribuir = [];
                var Asiento = [];
                var CuentaBanco = [];
                
                $('#formBancos').find(":input").each(function(){
                    var elemento = this;
                    //comprobamos el nombre del elemento y lo guardamos en ua array segun sea cantidad, precio, importe y concepto
                    var nombreElemento = elemento.name;
                    if(nombreElemento.substring(0,7) === 'IdBanco'){//es un elemento IdBanco
                        IdBanco[nombreElemento.substr(7,3)] = elemento.value;
                    }else 
                    if(nombreElemento.substring(0,9) === 'fechaFila'){//es un elemento fechaFila
                        fechaFila[nombreElemento.substr(9,3)] = elemento.value;
                    }else
                    if(nombreElemento.substring(0,8) === 'Cantidad' && !(nombreElemento.substring(0,19) === 'Cantidad_distribuir') && !(nombreElemento.substring(0,15) === 'CantidadInicial')){//es un elemento Cantidad
                        Cantidad[nombreElemento.substr(8,3)] = desFormateaNumeroContabilidad(elemento.value);
                    }else
                    if(nombreElemento.substring(0,6) === 'Cuenta'){//es un elemento Cuenta
                        CuentaBanco[nombreElemento.substr(6,3)] = elemento.value;
                    }else
                    if(nombreElemento.substring(0,12) === 'AsientoBanco'){//es un elemento Asiento
                        Asiento[nombreElemento.substr(12,3)] = elemento.value;
                    }else            
                    if(nombreElemento.substring(0,10) === 'Distribuir'){//es un elemento Distribuir
                        Distribuir[nombreElemento.substr(10,3)] = elemento.checked;
                    }
                });
                
                var distribucion = [];
                for(i in IdBanco){
                    var objeto ={"iTabla": i,"IdBanco":IdBanco[i],"fechaFila":fechaFila[i],"Cantidad":Cantidad[i],"Distribuir":Distribuir[i],"CuentaBanco":CuentaBanco[i],"Asiento":Asiento[i],"Cantidad_distribuir":0,"fila_Valida":"SI"};
                    distribucion.push(objeto);
                }
            
                //ahora recorro el array y hago lo siguiente:
                //1 veo si tiene la vble=Distribuir y el valor=1
                //1.1 si es asi hago el calculo de la distribucion hacia arriba empezando por el dia anterior
                //1.2 Si no es asi, es que no se distribuye, lo unico que hago es copiar el valor en el campo CD
                
                var submitir = false;
                
                for(fila=0;fila<distribucion.length;fila++){
                    //if(typeof(distribucion[fila].Distribuir) !== "undefined" && distribucion[fila].Distribuir === '1'){
                    if(distribucion[fila].Distribuir === true){
                        //1.1
                        //busco el dia de la fecha
                        var fechas = distribucion[fila].fechaFila.split("-");
                        var dia = fechas[2];

                        //preparo el array de los dias a distribuir (5 dias hacia atras empezando por el dia anterior)
                        var distCantidad = [];

                        //calculo los dias donde guardar la distribucion
                        for(i=1;i<=5;i++){
                            //var dia = dia - 1;
                            //compruebo que no sea menor que 1
                            var pos = '';
                            if(dia > 1){
                                //si lo entuentra, este dia no vale para distribucion, nos desplazamos al dia anterior
                                do{
                                    //resto un dia
                                    var encontrado = 'NO';
                                    var dia = dia - 1;
                                    //compruebo si length es 1 o menos
                                    if(dia.toString().length < 2){
                                        dia = '0' + dia.toString();
                                    }
                                    //escribo el dia
                                    var diaNuevo = fechas[0]+'-'+fechas[1]+'-'+dia;
                                    //compruebo si este dia tiene un dato ya contabilizado (campo Asiento = numerico
                                    for(ii=0;ii<distribucion.length;ii++){
                                        if(diaNuevo === distribucion[ii].fechaFila && isNaN(parseInt(distribucion[ii].Asiento))){
                                            encontrado = 'SI';
                                            pos = ii;
                                            break;
                                        }
                                    }
                                    
                                }while(encontrado === 'NO');
                                
                                //escribo el dia
                                var diaNuevo = fechas[0]+'-'+fechas[1]+'-'+dia;
                                //por ultimo guardamos en nuestro arrays 'distCantidad' este dia
                                distCantidad.push({"fecha":diaNuevo,"cantidad":0,"pos":pos});
                            }
                        }

                        //compruebo que el array "distCantidad", si es asi es que no se a echo la 
                        //distribucion (porque estamos en el dia 1)
                        //por lo que hay que añadir solo el dia 1 del mes en curso)
                        if(distCantidad.length <= 0){
                            diaNuevo = '01'+'-'+fechas[1]+'-'+dia;
                            distCantidad.push({"fecha":diaNuevo,"cantidad":0,"pos":0});
                        }
                        
                        

                        //ahora relleno de las cantidades
                        var dist = distCantidad.length;
                        var cantidadRestante = distribucion[fila].Cantidad;
                        var cantDist = redondeo2dec(distribucion[fila].Cantidad / dist);
                        //recorro todo el array menos la ultima posicion
                        for(i=0;i<dist-1;i++){
                            //busco en en el array "distribucion" por pos(iTabla) y lo sumo al dato que tenga
                            distribucion[distCantidad[i].pos].Cantidad_distribuir = redondeo2dec(distribucion[distCantidad[i].pos].Cantidad_distribuir + cantDist);
                            //resto cantidad distribuida
                            cantidadRestante = cantidadRestante - cantDist;
                        }
                        
                        //ahora la ultima posicion del array
                        distribucion[distCantidad[dist-1].pos].Cantidad_distribuir = redondeo2dec(distribucion[distCantidad[dist-1].pos].Cantidad_distribuir + parseFloat(cantidadRestante));
                        
                    }else{
                        //1.2
                        distribucion[fila].Cantidad_distribuir = redondeo2dec(parseFloat(distribucion[fila].Cantidad_distribuir) + parseFloat(distribucion[fila].Cantidad));
                    }
                }
                
                //ahora cambio el estado de cada fila a calculando
                //y indico en cada campo de CD, Distribuir su valor
                for(i=0;i<distribucion.length;i++){
                    //compruebo que Asiento es distinto de Numerico
                    //si no es numerico hago la distribucion
                    if(isNaN(parseInt(distribucion[i].Asiento))){
                        $('#estado'+distribucion[i].iTabla).html('<img src="../images/cargar.gif" width="10" height="10" border="0"/>');
                        
                        //vacio el campo
                        $('#Cantidad_distribuir'+distribucion[i].iTabla).val('');

                        //compruebo que la Cantidad_distribuir !== 0
                        if(distribucion[i].Cantidad_distribuir.toString() !== '0'){
                            $('#Cantidad_distribuir'+distribucion[i].iTabla).val(formateaNumeroContabilidad(distribucion[i].Cantidad_distribuir.toString()));
                            $('#Distribuir'+distribucion[i].iTabla).prop("checked", distribucion[i].Distribuir);
                        }
                        if(distribucion[i].Cantidad.toString() !== '0'){
                            $('#Distribuir'+distribucion[i].iTabla).prop("disabled", false);
                        }
                    }
                }
                
                //hago las sumas de los campos CD y Cantidad y su diferencia
                var sumaCD = 0;
                var sumaCantidad = 0;
                sumaCD = sCD(distribucion);
                sumaCantidad = sCantidad(distribucion);
                var diferencia = redondeo2dec(sumaCD - sumaCantidad);

                $('#sumaCD').html(formateaNumeroContabilidad(sumaCD.toString()));
                $('#sumaCantidad').html(formateaNumeroContabilidad(sumaCantidad.toString()));
                $('#diferencia').html(formateaNumeroContabilidad(diferencia.toString()));
                
                
                //hago una revision por si hay filas con los datos vacios en Cantidad y Cantidad_distribuir
                //si hay alguna fila asi , se marca el campo 'fila_Valida' a NO (se ha generado por error)
                for(i=1;i<distribucion.length;i++){
                    //compruebo que esten 'Cantidad' y 'Cantidad_distribuir' vacias
                    if(distribucion[i].Cantidad.toString() === '0' && distribucion[i].Cantidad_distribuir.toString() === '0'){
                        //ahora compruebo si existe una fecha igual en los campos anteriores
                        //si es asi borro esta fila
                        if(distribucion[i].fechaFila.toString() === distribucion[i-1].fechaFila.toString()){
                            distribucion[i].fila_Valida = 'NO';
                        }
                    }
                }
                
                
                //ahora tengo que actualizar el campo 'Cantidad_distribuir' de todas estas fechas indicadas en el array
                $.ajax({
                    data:{"datos":distribucion,"fechaInicioB":$('#fechaInicioB').val(),"fechaFinB":$('#fechaFinB').val(),"cuentaBanco":$('#cuentaBanco').val()},
                    url: '../vista/ajax/ventas_actCDistribuirArray.php',
                    type:"post",
                    success: function(data){
                        var datos = JSON.parse(data);
                        for(i=0;i<datos.length;i++){
                            if(datos[i].estado === 'error'){
                                $('#estado'+datos[i].iTabla).html('<img src="../images/error.png" width="10" height="10" border="0"/>');
                            }else{
                                //actualizo la posicion de la linea de la BBDD con la de la tabla del formulario
                                $('#IdBanco'+datos[i].iTabla).val(datos[i].IdBanco);
                                $('#estado'+datos[i].iTabla).html('');
                            }
                        }
                    }
                });
                
                //ahora compruebo si hay que submitir el formulario (porque se haya creado alguna linea nueva
                if(submitir === true){
                    $('#formBancos').submit();
                }

                return true;
            }
            
            function sCD(distribucion){
                var sumaCD = 0;
                
                for(i=0;i<distribucion.length;i++){
                    //compruebo que el asiento no sea numerico (esta contabilizado) y no se incluye en este calculo
                    //if(isNaN(parseInt(distribucion[i].Asiento))){
                        sumaCD = redondeo2dec(sumaCD + distribucion[i].Cantidad_distribuir);
                    //}
                }
                
                return sumaCD;
            }
            
            function sCantidad(distribucion){
                var sumaCantidad = 0;
                
                for(i=0;i<distribucion.length;i++){
                    //compruebo que el asiento no sea numerico (esta contabilizado) y no se incluye en este calculo
                    //if(isNaN(parseInt(distribucion[i].Asiento))){
                        sumaCantidad = redondeo2dec(sumaCantidad + parseFloat(distribucion[i].Cantidad));
                    //}
                }
                
                return sumaCantidad;
            }
            
            function actCuenta(cuentaBanco,IdBanco){
                var IdBancoCompleta = document.getElementById('IdBanco'+IdBanco).value;
                //por AJAX actualizo el dato en la tabla
                $.ajax({
                  data:{"cuentaBanco":cuentaBanco,"IdBanco":IdBancoCompleta},
                  url: '../vista/ajax/ventas_actCuenta.php',
                  type:"get",
                  success: function(data) {
                  }
                });
            }
            
            function actAsiento(IdBanco,valor){
                //por AJAX actualizo el dato en la tabla
                $.ajax({
                  data:{"Asiento":valor,"IdBanco":IdBanco},
                  url: '../vista/ajax/ventas_actAsiento.php',
                  type:"get",
                  success: function(data) {
                  }
                });
            }

            //crea una fila nueva en la tabla
            function crearFila(nuevo_iTabla,iTabla,Cantidad_distribuir){
                //clono la fila indicada con iTabla
                fila = $("#iTabla"+iTabla).clone(true);
                //pongo nueva numeracion nuevo_iTabla
                fila.attr("id","iTabla"+nuevo_iTabla);
                //actualizo ids y sus eventos
                fila.find('#iconoCrear'+iTabla).attr("id","iconoCrear"+nuevo_iTabla);
                fila.find('#crear'+iTabla).attr("id","crear"+nuevo_iTabla);
                fila.find('#crear'+nuevo_iTabla).attr("onclick","crearFila("+(nuevo_iTabla+1)+","+nuevo_iTabla+",0);");
                //IdBanco
                fila.find('#IdBanco'+iTabla).attr("id","IdBanco"+nuevo_iTabla);
                fila.find('#IdBanco'+nuevo_iTabla).attr("name","IdBanco"+nuevo_iTabla);
                fila.find('#IdBanco'+nuevo_iTabla).attr("value","");
                //fechaFila
                fila.find('#fechaFila'+iTabla).attr("id","fechaFila"+nuevo_iTabla);
                fila.find('#fechaFila'+nuevo_iTabla).attr("name","fechaFila"+nuevo_iTabla);
                //Cantidad_distribuir
                fila.find('#Cantidad_distribuir'+iTabla).attr("id","Cantidad_distribuir"+nuevo_iTabla);
                fila.find('#Cantidad_distribuir'+nuevo_iTabla).attr("name","Cantidad_distribuir"+nuevo_iTabla);
                fila.find('#Cantidad_distribuir'+nuevo_iTabla).attr("tabindex",nuevo_iTabla+"002");
                fila.find('#Cantidad_distribuir'+nuevo_iTabla).attr("disabled",false);
                fila.find('#Cantidad_distribuir'+nuevo_iTabla).attr("onfocus","desFormateaNumContabilidad(this);datoInicial(this.value,'CD_Inicial"+nuevo_iTabla+"');this.select();");
                fila.find('#Cantidad_distribuir'+nuevo_iTabla).attr("onblur","acCD("+nuevo_iTabla+",this.value,'',document.getElementById('cuentaBanco').value,document.getElementById('CD_Inicial"+nuevo_iTabla+"').value,document.getElementById('fechaFila"+nuevo_iTabla+"').value);formateaNumContabilidad(this);");
                if(Cantidad_distribuir === 0){
                    fila.find('#Cantidad_distribuir'+nuevo_iTabla).attr("value","");
                }else{
                    fila.find('#Cantidad_distribuir'+nuevo_iTabla).attr("value",Cantidad_distribuir);
                }
                //CD_Inicial
                fila.find('#CD_Inicial'+iTabla).attr("id","CD_Inicial"+nuevo_iTabla);
                fila.find('#CD_Inicial'+nuevo_iTabla).attr("name","CD_Inicial"+nuevo_iTabla);
                fila.find('#CD_Inicial'+nuevo_iTabla).attr("value",Cantidad_distribuir);
                //Distribuir
                fila.find('#Distribuir'+iTabla).attr("id","Distribuir"+nuevo_iTabla);
                fila.find('#Distribuir'+nuevo_iTabla).attr("name","Distribuir"+nuevo_iTabla);
                fila.find('#Distribuir'+nuevo_iTabla).attr("tabindex",nuevo_iTabla+"003");
                fila.find('#Distribuir'+nuevo_iTabla).attr("checked",false);
                fila.find('#Distribuir'+nuevo_iTabla).attr("disabled",true);
                //Cantidad
                fila.find('#Cantidad'+iTabla).attr("id","Cantidad"+nuevo_iTabla);
                fila.find('#Cantidad'+nuevo_iTabla).attr("name","Cantidad"+nuevo_iTabla);
                fila.find('#Cantidad'+nuevo_iTabla).attr("tabindex",nuevo_iTabla+"004");
                fila.find('#Cantidad'+nuevo_iTabla).attr("disabled",false);
                fila.find('#Cantidad'+nuevo_iTabla).attr("onfocus","desFormateaNumContabilidad(this);datoInicial(this.value,'CantidadInicial"+nuevo_iTabla+"');this.select();");
                fila.find('#Cantidad'+nuevo_iTabla).attr("onblur","actCantidad("+nuevo_iTabla+",this.value,document.getElementById('IdBanco"+nuevo_iTabla+"').value,document.getElementById('cuentaBanco').value,document.getElementById('CantidadInicial"+nuevo_iTabla+"').value,document.getElementById('fechaFila"+nuevo_iTabla+"').value);formateaNumContabilidad(this);");
                fila.find('#Cantidad'+nuevo_iTabla).attr("value","");
                //CantidadInicial
                fila.find('#CantidadInicial'+iTabla).attr("id","CantidadInicial"+nuevo_iTabla);
                fila.find('#CantidadInicial'+nuevo_iTabla).attr("name","CantidadInicial"+nuevo_iTabla);
                fila.find('#CantidadInicial'+nuevo_iTabla).attr("value","");
                //Cuenta
                fila.find('#CuentaDiv'+iTabla).attr("id","CuentaDiv"+nuevo_iTabla);
                fila.find('#CuentaDiv'+nuevo_iTabla).html("");
                //CuentaInicial
                fila.find('#CuentaInicial'+iTabla).attr("id","CuentaInicial"+nuevo_iTabla);
                fila.find('#CuentaInicial'+nuevo_iTabla).attr("name","CuentaInicial"+nuevo_iTabla);
                fila.find('#CuentaInicial'+nuevo_iTabla).attr("value","");
                //AsientoBancoDiv
                fila.find('#AsientoBancoDiv'+iTabla).attr("id","AsientoBancoDiv"+nuevo_iTabla);
                fila.find('#AsientoBancoDiv'+nuevo_iTabla).html("");
                
                
                //quito la imagen del + de la fila seleccionada
                $('#iconoCrear'+iTabla).html('');
                
                
                //Inserto nueva fila en la tabla
                $("#iTabla"+iTabla).after(fila);
                
                
                
                //POR ULTIMO INSERTO ESTA FILA EN LA BBDD (NO se hace, esta linea esta vacia ahora mismo)
                //************************************
            }
            
            </script>
            <form id="formBancos" name="form2" method="post" action="../vista/ventas_bancos.php">
<!--            <input type="hidden" id="calcular" name="calcular" value="NO" />-->
            <?php
            //voy a recorrer todos los dias del mes y ejercicio
            //$mes = date('m');
            if(isset($_GET['mes'])){
                $mes = $_GET['mes'];
            }
            $mesTxt = '';
            switch ($mes) {
                case '01':
                    $mesTxt = 'Enero';
                    break;
                case '02':
                    $mesTxt = 'Febrero';
                    break;
                case '03':
                    $mesTxt = 'Marzo';
                    break;
                case '04':
                    $mesTxt = 'Abril';
                    break;
                case '05':
                    $mesTxt = 'Mayo';
                    break;
                case '06':
                    $mesTxt = 'Junio';
                    break;
                case '07':
                    $mesTxt = 'Julio';
                    break;
                case '08':
                    $mesTxt = 'Agosto';
                    break;
                case '09':
                    $mesTxt = 'Septiembre';
                    break;
                case '10':
                    $mesTxt = 'Octubre';
                    break;
                case '11':
                    $mesTxt = 'Noviembre';
                    break;
                case '12':
                    $mesTxt = 'Diciembre';
                    break;
            }
            
            $ejercicio = date('Y');
            if(isset($_GET['ejercicio'])){
                $ejercicio = $_GET['ejercicio'];
            }
            ?>
            <?php if(isset($mes) && $mes !== ''){  ?>
            <h4 align="center"><?php echo $mesTxt . ' - ' . $ejercicio; ?></h4>
            <table id="datatablesMod" class="tablaExcel" border="1">
                <thead>
                    <tr>
                        <th width="2%"></th>
                        <th width="5%">Fecha</th>
                        <th width="10%">C.Distribuir</th>
                        <th width="4%">Distribuir</th>
                        <th width="10%">Cantidad</th>
                        <th width="20%">Banco</th>
                        <th width="4%">Asiento</th>
                        <th width="80px"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //compruebo si hay datos
                    if(is_array($arResult)){
                        //indico el recorrido por los dias del mes 
                        $fechaInicio = 1;
                        $month = $ejercicio.'-'.$mes;
                        $aux = date('Y-m-d', strtotime("{$month} + 1 month"));
                        $fechaFin = date('d', strtotime("{$aux} - 1 day"));
                        
                        
                        
                        //fechas para enviar al AJAX para borrar los datos del mes
                        $fechaInicioB = strtotime("01-".$mes."-".$ejercicio);
                        $month = $ejercicio.'-'.$mes;
                        $aux = date('Y-m-d', strtotime("{$month} + 1 month"));
                        $last_day = date('Y-m-d', strtotime("{$aux} - 1 day"));
                        $fechaFinB = strtotime($last_day);
                        
                        
                        $sumaDistribuir = 0.00;
                        $sumaCantidades = 0.00;
                        
                        for($i = $fechaInicio; $i <= $fechaFin; $i++){
                            $dia = $i.'/'.$mes.'/'.$ejercicio;
                            if(strlen($dia)<10){
                                $dia = '0' . $dia;
                            }
                            
                            for ($ii = 0; $ii < count($arResult); $ii++) {
                                if($dia === $arResult[$ii]['Fecha']){
                                    $fecha = explode('/',$dia);
                                    $fechaN = $fecha[2].$fecha[1].$fecha[0];
                                    $fechaDate = $fecha[2].'-'.$fecha[1].'-'.$fecha[0];
                                    
                                    //si el asiento esta OK (esta contabilizado), solo se presentan los datos
                                    $disabled = '';
                                    if(is_numeric($arResult[$ii]['AsientoBanco'])){
                                        $disabled = 'disabled';
                                    }

                                    $disabledDistribuir = '';
                                    if(is_numeric($arResult[$ii]['AsientoBanco'])){
                                        $disabledDistribuir = 'disabled';
                                    }else
                                    if(!isset($arResult[$ii]['Cantidad']) || $arResult[$ii]['Cantidad'] === ''){
                                        $disabledDistribuir = 'disabled';
                                    }

                                    //suma parcial
                                    $sumaDistribuir = (float)$sumaDistribuir + (float)$arResult[$ii]['Cantidad_distribuir'];
                                    $sumaCantidades = (float)$sumaCantidades + (float)$arResult[$ii]['Cantidad'];
                        
                                    $diferencia = $sumaDistribuir - $sumaCantidades;
                                    ?>
                                    <tr id="iTabla<?php echo $ii;?>">
                                        <td>
                                            <span id="iconoCrear<?php echo $ii;?>">
                                                <a id="crear<?php echo $ii;?>" onclick="crearFila(<?php echo count($arResult); ?>,<?php echo $ii;?>,0);"><img src="../images/add.jpg" style="width: 12px; height: 12px;"  tabindex="<?php echo $ii;?>0001"></a>
                                            </span>
                                        </td>
                                        <td><!-- <?php echo $fechaN; ?> -->
                                            <label class="labelDatos"><?php echo $dia; ?></label>
                                            <input type="hidden" id="IdBanco<?php echo $ii;?>" name="IdBanco<?php echo $ii;?>" value="<?php echo $arResult[$ii]['IdBanco']; ?>" />
                                            <input type="hidden" id="fechaFila<?php echo $ii;?>" name="fechaFila<?php echo $ii;?>" value="<?php echo $fechaDate; ?>" />
                                        </td>
                                        <td align="right">
                                            <input type="text" class="inputDatos" id="Cantidad_distribuir<?php echo $ii;?>" name="Cantidad_distribuir<?php echo $ii;?>" value="<?php echo formateaNumeroContabilidad($arResult[$ii]['Cantidad_distribuir']); ?>" tabindex="<?php echo $ii;?>0002" 
                                                   onfocus="desFormateaNumContabilidad(this);datoInicial(this.value,'CD_Inicial<?php echo $ii;?>');this.select();"
                                                   onblur="acCD(<?php echo $ii;?>,this.value,document.getElementById('IdBanco<?php echo $ii;?>').value,document.getElementById('cuentaBanco').value,document.getElementById('CD_Inicial<?php echo $ii;?>').value,document.getElementById('fechaFila<?php echo $ii;?>').value);formateaNumContabilidad(this);"
                                                   onkeypress="return solonumerosNeg(event);" />
                                            <input type="hidden" id="CD_Inicial<?php echo $ii;?>" name="CD_Inicial<?php echo $ii;?>" />
                                        </td>
                                        <td>
                                            <div align="center">
                                                <input type="checkbox" id="Distribuir<?php echo $ii;?>" name="Distribuir<?php echo $ii;?>" value="<?php echo $arResult[$ii]['Distribuir']; ?>" <?php if($arResult[$ii]['Distribuir'] === '1'){echo 'checked';}?> tabindex="<?php echo $ii;?>0003" <?php echo $disabledDistribuir;?> onchange="calculoDistribucion();" />
                                            </div>
                                        </td>
                                        <td align="right" style="background-color: #f7f7f7;">
                                            <input type="text" class="inputDatos" id="Cantidad<?php echo $ii;?>" name="Cantidad<?php echo $ii;?>" value="<?php echo formateaNumeroContabilidad($arResult[$ii]['Cantidad']); ?>" tabindex="<?php echo $ii;?>0004" 
                                                   onfocus="desFormateaNumContabilidad(this);datoInicial(this.value,'CantidadInicial<?php echo $ii;?>');this.select();"
                                                   onblur="actCantidad(<?php echo $ii;?>,this.value,document.getElementById('IdBanco<?php echo $ii;?>').value,document.getElementById('cuentaBanco').value,document.getElementById('CantidadInicial<?php echo $ii;?>').value,document.getElementById('fechaFila<?php echo $ii;?>').value);formateaNumContabilidad(this);"
                                                   onkeypress="return solonumerosNeg(event);" <?php echo $disabled;?> />
                                            <input type="hidden" id="CantidadInicial<?php echo $ii;?>" name="CantidadInicial<?php echo $ii;?>" value="<?php echo $arResult[$ii]['Cantidad']; ?>" />
                                        </td>
                                        <td>
                                            <div align="center" id="CuentaDiv<?php echo $ii;?>">
                                            <?php
                                            //segun venga asiento indicamos o un listado o OK
                                            if($arResult[$ii]['Cuenta'] !== ''){
                                                if($arResult[$ii]['AsientoBanco'] === 'P' || $arResult[$ii]['AsientoBanco'] === 'X'){
                                                    echo presentarCuentas('Cuenta',$ii,$arResult[$ii]['Cuenta'],$arResult[$ii]['IdBanco'],'0005');
                                                }else{
                                                    echo '<label class="labelDatos">' . $arResult[$ii]['Cuenta'] . '</label>';
                                                    echo '<input type="hidden" id="Cuenta'.$ii.'" name="Cuenta'.$ii.'" value="'.$arResult[$ii]['Cuenta'].'"/>';
                                                }
                                            }
                                            ?>    
                                            </div>
                                        </td>
                                        <td>
                                            <div align="center" id="AsientoBancoDiv<?php echo $ii;?>">
                                            <?php
                                            //segun venga asiento indicamos o un listado o el numero de asiento
                                            if($arResult[$ii]['AsientoBanco'] === 'P' || $arResult[$ii]['AsientoBanco'] === 'X'){
                                                echo presentarAsiento($ii, $arResult[$ii]['AsientoBanco'],$arResult[$ii]['IdBanco'],'0006');
                                            }else{
                                                echo '<label class="labelDatos">' . $arResult[$ii]['AsientoBanco'] . '</label>';
                                                echo '<input type="hidden" name="AsientoBanco'.$ii.'" value="'.$arResult[$ii]['AsientoBanco'].'"/>';
                                            }
                                            ?>    
                                            </div>
                                        </td>
                                        <td onClick="<?php echo $link; ?>">
                                            <span id="estado<?php echo $ii;?>"></span>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            
                        }
                    }
                    ?>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td align="right">
                                            <span id="sumaCD" class="labelDatos"><?php echo formateaNumeroContabilidad($sumaDistribuir); ?></span>
                                        </td>
                                        <td align="right">
                                            <span id="diferencia" class="labelDatos"><?php echo formateaNumeroContabilidad($diferencia); ?></span>
                                        </td>
                                        <td align="right">
                                            <span id="sumaCantidad" class="labelDatos"><?php echo formateaNumeroContabilidad($sumaCantidades); ?></span>
                                            <input type="hidden" id="fechaInicioB" name="fechaInicioB" value="<?php echo $fechaInicioB; ?>" />
                                            <input type="hidden" id="fechaFinB" name="fechaFinB" value="<?php echo $fechaFinB; ?>" />
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                </tbody>
            </table>
            <br/><br/><br/>
            <a onclick="refrescar();"><input type="button" class="button" value="Refrescar Tabla"></a>
            <?php } ?>
            </form>
            
            <script type="text/javascript">
//                function borrarTabla(){
//                    if(confirm('¿Borramos los datos de la tabla?')){
//                        $.ajax({
//                          url: '../vista/ajax/ventas_borrarTabla_bancos.php',
//                          type:"get",
//                          success: function(data) {
//                              document.form1.submit();
//                          }
//                        });
//                    }
//                }
                
                function refrescar(){
                    document.form1.submit();
                }
            </script>
            
            <br/><br/><br/>
            <?php include '../vista/IndicacionIncidencia.php'; ?>
<!--        </td>
        </tr>
        </table>-->
    </body>
</html>
