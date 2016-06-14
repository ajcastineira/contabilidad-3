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


//$listadoCuentasBancos = $clsCNDatosVentas->ListadoCuentasBancosTarjetas($_GET['cuentaBanco']);
$listadoCuentasBancos = $clsCNDatosVentas->ListadoCuentasBancos($_GET['cuentaBanco']);
$listadoBancosJS = $clsCNDatosVentas->ListadoBancosJS();        


//listado de tarjetas y cheques
//$listadoTarjetas[] = 'American Express';
//$listadoTarjetas[] = 'Visa';
//$listadoTarjetas[] = 'Diners';
//$listadoTarjetas[] = 'Cheque Gourmet';

$listadoTarjetas = $clsCNDatosVentas->ListadoTarjetas();

function presentarTarjeta($nombre,$dato,$i,$listadoTarjetas){
    $html = '<div align="center">';
    $html = $html . '<select id="'.$nombre.'" name="'.$nombre.'" tabindex="'.$i.'0001" onchange="actTarjeta(this.value,'.$i.');">';

    for ($i = 0; $i < count($listadoTarjetas); $i++) {
        if($dato === $listadoTarjetas[$i]['NumCuenta']){
            $html = $html . '<option value="'.$listadoTarjetas[$i]['NumCuenta'].'" selected>'.$listadoTarjetas[$i]['Num'].' - '.$listadoTarjetas[$i]['Nombre'].'</option>';
        }else{
            $html = $html . '<option value="'.$listadoTarjetas[$i]['NumCuenta'].'">'.$listadoTarjetas[$i]['Num'].' - '.$listadoTarjetas[$i]['Nombre'].'</option>';
        }
    }
    
    $html = $html . '</select>';
    $html = $html . '</div>';
    
    return $html;
}


function presentarCuentasTarjeta($nombre,$ii,$cuentaSelecc,$IdTarjeta,$tab){
    $clsCNDatosVentas = new clsCNDatosVentas();
    $clsCNDatosVentas->setStrBD($_SESSION['dbContabilidad']);
    $clsCNDatosVentas->setStrBDCliente($_SESSION['mapeo']);
    
    if($cuentaSelecc !== null){
        $listado = $clsCNDatosVentas->ListadoBancosCuenta();

        $html = "<select id='".$nombre.$ii."' name='".$nombre.$ii."' tabindex='".$ii.$tab."' onchange='actTarjetaCuenta(this.value,".$ii.");'>";
        $html = $html . '<option value="570000000">0 - Caja</option>';

        for ($i = 0; $i < count($listado); $i++) {
            $cuenta = (int) substr($listado[$i]['NumCuenta'],4);
            //if($cuenta !== 0){
                if((int)$cuentaSelecc === (int)$listado[$i]['NumCuenta']){
                    $html = $html . '<option value="'.$listado[$i]['NumCuenta'].'" selected>'.$cuenta.' - '.$listado[$i]['Nombre'].'</option>';
                }else{
                    $html = $html . '<option value="'.$listado[$i]['NumCuenta'].'">'.$cuenta.' - '.$listado[$i]['Nombre']. '</option>';
                }
            //}
        }
        $html = $html . '</select>';
    }else{
        $html = '';
    }
    
    return $html;
}

function presentarAsientoTarjeta($nombre,$dato,$i,$tab){
    $html = "<select id='AsientoBanco".$nombre."' name='AsientoBanco".$nombre."' tabindex='".$nombre.$tab."' onchange='actAsiento(".$nombre.",this.value);'>";
    $seleP = '';
    $seleX = '';
    if($dato === 'P'){
        $seleP = 'selected';
    }else{
        $seleX = 'selected';
    }
    $html = $html . '<option value="P" '.$seleP.'>P</option>';
    $html = $html . '<option value="X" '.$seleX.'>X</option>';
    $html = $html . '</select>';
    
    return $html;
}


?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="../images/q.ico">
        <title>Ventas - Tarjetas</title>
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

function siEsTodas(valor){
    if(valor === 'Todas'){
        document.form1.tarjeta.value = "Todas";
        document.form1.submit();
    }
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
            <div align="center"><h3>Entrada Datos de Tarjetas/Cheques</h3></div>

    <form name="form1" action="../vista/ventas_tarjetas.php" method="get">
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
            <select name="mes" class="textbox1">
                <option value="" ></option>
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
            <select name="ejercicio" class="textbox1">
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
      <td class="nombreCampo"><div align="right">Tarjeta/Cheque:</div></td>
      <td>
          <div align="left">
            <?php 
            //genero el listado de las tarjetas
            $html = '<select class="textbox1" name="tarjeta" id="tarjeta" onchange="siEsTodas(this.value);">';

            for ($i = 0; $i < count($listadoTarjetas); $i++) {
                if($_GET['tarjeta'] === $listadoTarjetas[$i]['NumCuenta']){
                    $html = $html . '<option value="'.$listadoTarjetas[$i]['NumCuenta'].'" selected>'.$listadoTarjetas[$i]['Num'].' - '.$listadoTarjetas[$i]['Nombre'].'</option>';
                }else{
                    $html = $html . '<option value="'.$listadoTarjetas[$i]['NumCuenta'].'">'.$listadoTarjetas[$i]['Num'].' - '.$listadoTarjetas[$i]['Nombre'].'</option>';
                }
            }
            $html = $html . '<option value="Todas">(Todas)</option>';
            $html = $html . '</select>';
            
            echo $html;
            ?>
          </div>
      </td>
      <td></td>
      <td class="nombreCampo"><div align="right">Cuenta de Banco:</div></td>
      <td>
          <div align="left">
            <?php echo $listadoCuentasBancos; ?>
          </div>
      </td>
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
                $arResult = $clsCNDatosVentas->ListadoVentasTarjetas($_GET);
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
            
            //crea una fila nueva en la tabla
            function crearFila(nuevo_iTabla,iTabla,Cantidad_distribuir){
                //clono la fila indicada con iTabla
                var fila = $("#iTabla"+iTabla).clone(true);
                //pongo nueva numeracion nuevo_iTabla
                fila.attr("id","iTabla"+nuevo_iTabla);
                //actualizo ids y sus eventos
                fila.find('#iconoCrear'+iTabla).attr("id","iconoCrear"+nuevo_iTabla);
                fila.find('#crear'+iTabla).attr("id","crear"+nuevo_iTabla);
                fila.find('#crear'+nuevo_iTabla).attr("onclick","crearFila("+(nuevo_iTabla+1)+","+nuevo_iTabla+",0);");
                //IdTarjeta
                fila.find('#IdTarjeta'+iTabla).attr("id","IdTarjeta"+nuevo_iTabla);
                fila.find('#IdTarjeta'+nuevo_iTabla).attr("name","IdTarjeta"+nuevo_iTabla);
                fila.find('#IdTarjeta'+nuevo_iTabla).attr("value","");
                //fechaFila
                fila.find('#fechaFila'+iTabla).attr("id","fechaFila"+nuevo_iTabla);
                fila.find('#fechaFila'+nuevo_iTabla).attr("name","fechaFila"+nuevo_iTabla);
                //TarjetaDiv
                fila.find('#TarjetaDiv'+iTabla).attr("id","TarjetaDiv"+nuevo_iTabla);
                fila.find('#TarjetaDiv'+nuevo_iTabla).html("<label class='labelDatos'></label><input type='hidden' id='AsientoTarjeta"+nuevo_iTabla+"' name='AsientoTarjeta"+nuevo_iTabla+"' value=''>");
                //Bruto
                fila.find('#Bruto'+iTabla).attr("id","Bruto"+nuevo_iTabla);
                fila.find('#Bruto'+nuevo_iTabla).attr("name","Bruto"+nuevo_iTabla);
                fila.find('#Bruto'+nuevo_iTabla).attr("value","");
                fila.find('#Bruto'+nuevo_iTabla).attr("tabindex",nuevo_iTabla+"0003");
                fila.find('#Bruto'+nuevo_iTabla).attr("onfocus","desFormateaNumContabilidad(this);datoInicial(this.value,'Bruto_Inicial"+nuevo_iTabla+"');this.select();");
                fila.find('#Bruto'+nuevo_iTabla).attr("onblur","formateaNumContabilidad(this); escriboBruto("+nuevo_iTabla+",document.getElementById('tarjeta').value,document.getElementById('cuentaBanco').value);");
                //Bruto_inicial
                fila.find('#Bruto_Inicial'+iTabla).attr("id","Bruto_Inicial"+nuevo_iTabla);
                fila.find('#Bruto_Inicial'+nuevo_iTabla).attr("name","Bruto_Inicial"+nuevo_iTabla);
                fila.find('#Bruto_Inicial'+nuevo_iTabla).attr("value","");
                //Comision
                fila.find('#Comision'+iTabla).attr("id","Comision"+nuevo_iTabla);
                fila.find('#Comision'+nuevo_iTabla).attr("name","Comision"+nuevo_iTabla);
                fila.find('#Comision'+nuevo_iTabla).attr("value","");
                fila.find('#Comision'+nuevo_iTabla).attr("tabindex",nuevo_iTabla+"0004");
                fila.find('#Comision'+nuevo_iTabla).attr("onfocus","desFormateaNumContabilidad(this);datoInicial(this.value,'Comision_inicial"+nuevo_iTabla+"');this.select();");
                fila.find('#Comision'+nuevo_iTabla).attr("onblur","formateaNumContabilidad(this); escriboComision("+nuevo_iTabla+",document.getElementById('tarjeta').value,document.getElementById('cuentaBanco').value);");
                //Bruto_inicial
                fila.find('#Comision_inicial'+iTabla).attr("id","Comision_inicial"+nuevo_iTabla);
                fila.find('#Comision_inicial'+nuevo_iTabla).attr("name","Comision_inicial"+nuevo_iTabla);
                fila.find('#Comision_inicial'+nuevo_iTabla).attr("value","");
                //Liquido
                fila.find('#Liquido'+iTabla).attr("id","Liquido"+nuevo_iTabla);
                fila.find('#Liquido'+nuevo_iTabla).attr("name","Liquido"+nuevo_iTabla);
                fila.find('#Liquido'+nuevo_iTabla).attr("value","");
                fila.find('#Liquido'+nuevo_iTabla).attr("tabindex",nuevo_iTabla+"0005");
                fila.find('#Liquido'+nuevo_iTabla).attr("onfocus","desFormateaNumContabilidad(this);datoInicial(this.value,'Liquido_inicial"+nuevo_iTabla+"');this.select();");
                fila.find('#Liquido'+nuevo_iTabla).attr("onblur","formateaNumContabilidad(this); escriboLiquido("+nuevo_iTabla+",document.getElementById('tarjeta').value,document.getElementById('cuentaBanco').value);");
                //Liquido_inicial
                fila.find('#Liquido_inicial'+iTabla).attr("id","Liquido_inicial"+nuevo_iTabla);
                fila.find('#Liquido_inicial'+nuevo_iTabla).attr("name","Liquido_inicial"+nuevo_iTabla);
                fila.find('#Liquido_inicial'+nuevo_iTabla).attr("value","");
                //estado
                fila.find('#estado'+iTabla).attr("id","estado"+nuevo_iTabla);
                
                
                
                
                //CuentaDiv
                fila.find('#CuentaDiv'+iTabla).attr("id","CuentaDiv"+nuevo_iTabla);
                fila.find('#CuentaDiv'+nuevo_iTabla).html("");
                //AsientoTarjetaDiv
                fila.find('#AsientoTarjetaDiv'+iTabla).attr("id","AsientoTarjetaDiv"+nuevo_iTabla);
                fila.find('#AsientoTarjetaDiv'+nuevo_iTabla).html("");
                
                //quito la imagen del + de la fila seleccionada
                $('#iconoCrear'+iTabla).html('');
                
                
                //Inserto nueva fila en la tabla
                $("#iTabla"+iTabla).after(fila);
                
                
                
                //POR ULTIMO INSERTO ESTA FILA EN LA BBDD (NO se hace, esta linea esta vacia ahora mismo)
                //************************************
            }
            
            
            function actCuenta(cuentaTarjeta,IdTarjeta){
                //por AJAX actualizo el dato en la tabla
                $.ajax({
                  data:{"cuentaTarjeta":cuentaTarjeta,"IdTarjeta":IdTarjeta},
                  url: '../vista/ajax/ventas_actCuentaTarjeta.php',
                  type:"get",
                  success: function(data) {
                  }
                });
            }
            
            //funcion para crear el select de TipoTarjeta
            function createSelecTarjeta(iTabla,tarjetaDefecto){
                //se crea el select de TipoAsiento y por defecto se pone el seleccionado en los filtros
                var html = '<div align="center">';
                var html = html + '<select id="AsientoTarjeta'+iTabla+'" name="AsientoTarjeta'+iTabla+'" tabindex="'+iTabla+'0001" onchange="actTarjeta(this.value,'+iTabla+');">';
                <?php 
                for ($i = 0; $i < count($listadoTarjetas); $i++) {
                ?>
                    if(tarjetaDefecto === '<?php echo $listadoTarjetas[$i]['NumCuenta']; ?>'){
                        html = html + '<option value="<?php echo $listadoTarjetas[$i]['NumCuenta']; ?>" selected><?php echo $listadoTarjetas[$i]['Num'].' - '.$listadoTarjetas[$i]['Nombre']; ?></option>';
                    }else{
                        html = html + '<option value="<?php echo $listadoTarjetas[$i]['NumCuenta']; ?>"><?php echo $listadoTarjetas[$i]['Num'].' - '.$listadoTarjetas[$i]['Nombre']; ?></option>';
                    }
                <?php 
                }
                ?>
                html = html + '</select>';
                
                return html;
            }
            
            //funcion para crear el select de la cuentaTarjeta
            function createSelectCuentaTarjeta(iTabla,CuentaTarjetaDefecto){
                var htmlCuenta = "<select id='CuentaTarjeta"+iTabla+"' name='CuentaTarjeta"+iTabla+"' tabindex='"+iTabla+"0006'  onchange='actTarjetaCuenta(this.value,"+iTabla+");'>";
                htmlCuenta = htmlCuenta + "<option value='570000000' selected>0 - Caja</option>";//caja
                <?php
                for ($i = 0; $i < count($listadoBancosJS); $i++) {
                    $cuenta = (int) substr($listadoBancosJS[$i]['NumCuenta'],4);
                    //if($cuenta !== 0){
                    ?>
                        if(parseInt(CuentaTarjetaDefecto) === <?php echo $listadoBancosJS[$i]['NumCuenta'];?>){
                            htmlCuenta = htmlCuenta + "<option value='<?php echo $listadoBancosJS[$i]['NumCuenta'];?>' selected><?php echo $cuenta . ' - ' . $listadoBancosJS[$i]['Nombre'];?></option>";
                        }else{
                            htmlCuenta = htmlCuenta + "<option value='<?php echo $listadoBancosJS[$i]['NumCuenta'];?>'><?php echo $cuenta . ' - ' . $listadoBancosJS[$i]['Nombre'];?></option>";
                        }
                    <?php
                    //}
                }
                ?>
                
                return htmlCuenta;
            }
            
            //funcionpara crear select del Asiento (P, X, o si esta contabilizado)
            function createSelectAsiento(iTabla){
                //select del Tpo Asiento (P, X  numero si esta contabilizada)
                var htmlAsiento = "<select id='AsientoBanco"+iTabla+"' name='AsientoBanco"+iTabla+"' tabindex='"+iTabla+"0007' onchange='actAsiento("+iTabla+",this.value);'>";
                htmlAsiento = htmlAsiento + "<option value='P' selected>P</option>";
                htmlAsiento = htmlAsiento + "<option value='X'>X</option>";
                htmlAsiento = htmlAsiento + "</select>";
                
                return htmlAsiento;
            }
            
            function escriboBruto(iTabla,tarjetaDefecto,CuentaTarjetaDefecto){
                //recojo los objetos
                var bruto = document.getElementById('Bruto'+iTabla);
                var brutoInicial = document.getElementById('Bruto_Inicial'+iTabla);
                var valorBruto = desFormateaNumeroContabilidad(bruto.value);
                
                //compruebo que son distintos, si lo es ejecuto el resto de la funcion, sino, termino aqui
                if(valorBruto !== brutoInicial.value){
                    //recojo el resto de objetos de datos de sta linea
                    var IdTarjeta = document.getElementById('IdTarjeta'+iTabla);
                    var fechaFila = document.getElementById('fechaFila'+iTabla);
                    var TarjetaDiv = document.getElementById('TarjetaDiv'+iTabla);

                    var comision = document.getElementById('Comision'+iTabla);
                    var liquido = document.getElementById('Liquido'+iTabla);

                    var CuentaDiv = document.getElementById('CuentaDiv'+iTabla);
                    var AsientoTarjetaDiv = document.getElementById('AsientoTarjetaDiv'+iTabla);
                    //hago la comprobacion de que esta cuenta es 5750, de tajetas, para poder hacer
                    //el calculo bruto - comision = liquido
                    var numTarjeta4 = document.getElementById('AsientoTarjeta'+iTabla).value.substr(0,4);
                    
                    //compruebo que bruto.value != ''
                    if(bruto.value !== ''){
                        //hago los calculos de bruto,comision y liquido
                        //formateo los numeros de bruto, comision y liquido
                        //var valorBruto = bruto.value;
                        if(valorBruto === ""){
                            valorBruto = 0;
                        }
                        var valorComision = comision.value;
                        if(valorComision === ""){
                            valorComision = 0;
                        }else{
                            valorComision = desFormateaNumeroContabilidad(valorComision);
                        }
                        var valorLiquido = liquido.value;

                        //liquido = bruto - comision (solo si es cuentas 5750)
                        if(numTarjeta4 === '5750'){
                            valorLiquido = parseFloat(valorBruto) - parseFloat(valorComision);
                            valorLiquido = Math.round(valorLiquido * 100) / 100;
                        }else{
                            valorLiquido = desFormateaNumeroContabilidad(valorLiquido);
                        }
                        if(isNaN(valorLiquido)){
                            alert('Este valor no es numérico');
                            bruto.value = "";
                        }else{
                            liquido.value = formateaNumeroContabilidad(valorLiquido.toString());
                            comision.value = formateaNumeroContabilidad(valorComision.toString());

                            //ahora actualizo esta linea en la tabla

                            //si la linea no esta guarda en la BBDD el IdTarjeta = ""
                            //creo los campos select de tipoTareja, cuenta tarjeta y Asiento
                            //datos de tipoTarjeta y cuentaTarjeta
                            var tipoTarjeta = tarjetaDefecto;
                            var cuentaTarjeta = CuentaTarjetaDefecto;
                            if(IdTarjeta.value === ""){
                                //se crea el select de TipoAsiento y por defecto se pone el seleccionado en los filtros
                                TarjetaDiv.innerHTML = createSelecTarjeta(iTabla,tarjetaDefecto);

                                //select banco tarjeta
                                CuentaDiv.innerHTML = createSelectCuentaTarjeta(iTabla,CuentaTarjetaDefecto);
                                
                                //select del Tipo Asiento (P, X  numero si esta contabilizada)
                                AsientoTarjetaDiv.innerHTML = createSelectAsiento(iTabla);

                                //ahora ponemos el estado en esperando
                                $('#estado'+iTabla).html('<img src="../images/cargar.gif" width="10" height="10" border="0"/>');
                                //datos de tipoTarjeta y cuentaTarjeta
                                var tipoTarjeta = tarjetaDefecto;
                                var cuentaTarjeta = CuentaTarjetaDefecto;
                            }else{
                                //datos de tipoTarjeta y cuentaTarjeta
                                var tipoTarjeta = $('#AsientoTarjeta'+iTabla).val();
                                var cuentaTarjeta = $('#Cuenta'+iTabla).val();
                            }

                            //ahora guardo los datos en la BBDD
                            $.ajax({
                                data:{"iTabla":iTabla,"IdTarjeta":IdTarjeta.value,"fecha":fechaFila.value,"TipoTarjeta":tipoTarjeta,"bruto":valorBruto,
                                    "comision":valorComision,"liquido":valorLiquido,"cuentaTarjeta":cuentaTarjeta},
                                url: '../vista/ajax/ventas_tarjeta.php',
                                type:"get",
                                success: function(data) {
                                    var datos = JSON.parse(data);
                                    //compruebo si se ha guardado
                                    if(datos.guardado === 'SI'){
                                        $('#estado'+datos.iTabla).html('');
                                        //actualizo los campos de sumas
                                        //ahora compruebo si s nuevo o editado
                                        if(datos.tipo === 'Nuevo'){
                                            //actualizo el valor de este Id
                                            $('#IdTarjeta'+datos.iTabla).val(datos.IdTarjeta);
                                        }else{
                                            //nada
                                        }
                                        //sumas();
                                    }else{
                                        $('#estado'+datos.iTabla).html('<img src="../images/error.png" width="10" height="10" border="0"/>');
                                    }
                                }
                            });
                        }
                    }else{
                        //si es vacio el campo, borro toda la linea tanto en el form como en la BBDD
                        //1º borro esta linea de los datos en la BBDD
                        $.ajax({
                            data:{"iTabla":iTabla,"IdTarjeta":IdTarjeta.value},
                            url: '../vista/ajax/ventas_tarjeta_borrar.php',
                            type:"get",
                            success: function(data) {
                                var datos = JSON.parse(data);
                                //compruebo si se ha guardado
                                //2º limpio los campos de Tarjetas, cuentas y asiento
                                if(datos.guardado === 'SI'){
                                    $('#estado'+datos.iTabla).html('');
                                    $('#TarjetaDiv'+datos.iTabla).html('');
                                    $('#Comision'+datos.iTabla).val('');
                                    $('#Liquido'+datos.iTabla).val('');
                                    $('#CuentaDiv'+datos.iTabla).html('');
                                    $('#AsientoTarjetaDiv'+datos.iTabla).html('');
                                    //ahora compruebo si s nuevo o editado
                                    $('#IdTarjeta'+datos.iTabla).val('');
                                    //actualizo los campos de sumas
                                    //sumas();
                                }else{
                                    $('#estado'+datos.iTabla).html('<img src="../images/error.png" width="10" height="10" border="0"/>');
                                }
                            }
                        });
                        
                        
                    }
                }
            }
            
            function escriboComision(iTabla,tarjetaDefecto,CuentaTarjetaDefecto){
                //recojo los objetos
                var comision = document.getElementById('Comision'+iTabla);
                var comisionInicial = document.getElementById('Comision_inicial'+iTabla);
                var valorComision = desFormateaNumeroContabilidad(comision.value);
                
                //compruebo que son distintos, si lo es ejecuto el resto de la funcion, sino, termino aqui
                if(valorComision !== comisionInicial.value){
                    //recojo el resto de objetos de datos de sta linea
                    var IdTarjeta = document.getElementById('IdTarjeta'+iTabla);
                    var fechaFila = document.getElementById('fechaFila'+iTabla);
                    var TarjetaDiv = document.getElementById('TarjetaDiv'+iTabla);

                    var bruto = document.getElementById('Bruto'+iTabla);
                    var liquido = document.getElementById('Liquido'+iTabla);

                    var CuentaDiv = document.getElementById('CuentaDiv'+iTabla);
                    var AsientoTarjetaDiv = document.getElementById('AsientoTarjetaDiv'+iTabla);
                    //hago la comprobacion de que esta cuenta es 5750, de tajetas, para poder hacer
                    //el calculo bruto - comision = liquido
                    var numTarjeta4 = document.getElementById('AsientoTarjeta'+iTabla).value.substr(0,4);
                    
                    //hago los calculos de bruto,comision y liquido
                    //formateo los numeros de bruto, comision y liquido
                    var valorBruto = bruto.value;
                    if(valorBruto === ""){
                        valorBruto = 0;
                    }else{
                        valorBruto = desFormateaNumeroContabilidad(valorBruto);
                    }
                    //var valorComision = comision.value;
                    if(valorComision === ""){
                        valorComision = 0;
                    }
                    var valorLiquido = liquido.value;
                    if(valorLiquido === ""){
                        valorLiquido = 0;
                    }else{
                        valorLiquido = desFormateaNumeroContabilidad(valorLiquido);
                    }
                        
                    //liquido = bruto - comision
                    //valorLiquido = parseFloat(valorBruto) - parseFloat(valorComision);
                    if(isNaN(valorComision)){
                        alert('Este valor no es numérico');
                        comision.value = "";
                    }else{
                        //ahora existe varios posibles casos de calculo
                        //1º (Bruto != 0 y Liquido != 0) o (Bruto != 0 y Liquido = 0) : calculo liquido
                        if((valorBruto !== 0 && valorLiquido !== 0) 
                                || (valorBruto !== 0 && valorLiquido === 0)){
                            //calculo liquido
                            if(numTarjeta4 === '5750'){
                                valorLiquido = parseFloat(valorBruto) - parseFloat(valorComision);
                                valorLiquido = Math.round(valorLiquido * 100) / 100;
                            }else{
                                valorLiquido = desFormateaNumeroContabilidad(valorLiquido);
                            }
                            if(isNaN(valorLiquido)){
                                liquido.value = "";
                            }else{
                                liquido.value = formateaNumeroContabilidad(valorLiquido.toString());
                            }
                        }else
                        //2º (Bruto = 0 y Liquido != 0) : calculo bruto
                        if(valorBruto === 0 && valorLiquido !== 0){
                            //calculo bruto
                            if(numTarjeta4 === '5750'){
                                valorBruto = parseFloat(valorLiquido) + parseFloat(valorComision);
                            }else{
                                valorBruto = desFormateaNumeroContabilidad(valorBruto);
                            }
                            if(isNaN(valorBruto)){
                                bruto.value = "";
                            }else{
                                bruto.value = formateaNumeroContabilidad(valorBruto.toString());
                            }
                        }
                    
                        //ahora actualizo esta linea en la tabla

                        //ahora ponemos el estado en esperando
                        $('#estado'+iTabla).html('<img src="../images/cargar.gif" width="10" height="10" border="0"/>');
                                
                        //si la linea no esta guarda en la BBDD el IdTarjeta = ""
                        //creo los campos select de tipoTareja, cuenta tarjeta y Asiento
                        //datos de tipoTarjeta y cuentaTarjeta
                        var tipoTarjeta = tarjetaDefecto;
                        var cuentaTarjeta = CuentaTarjetaDefecto;
                        if(IdTarjeta.value !== ""){
                            //datos de tipoTarjeta y cuentaTarjeta
                            var tipoTarjeta = $('#AsientoTarjeta'+iTabla).val();
                            var cuentaTarjeta = $('#CuentaTarjeta'+iTabla).val();
                        }else{
                            //no hago nada, en este campo si no hay nada en los demas no hago nada, 
                            //ni guardo ni nada
                        }
                        
                        //ahora guardo los datos en la BBDD
                        $.ajax({
                            data:{"iTabla":iTabla,"IdTarjeta":IdTarjeta.value,"fecha":fechaFila.value,"TipoTarjeta":tipoTarjeta,"bruto":valorBruto,
                                "comision":valorComision,"liquido":valorLiquido,"cuentaTarjeta":cuentaTarjeta},
                            url: '../vista/ajax/ventas_tarjeta.php',
                            type:"get",
                            success: function(data) {
                                var datos = JSON.parse(data);
                                //compruebo si se ha guardado
                                if(datos.guardado === 'SI'){
                                    $('#estado'+datos.iTabla).html('');
                                    //actualizo los campos de sumas
                                    //ahora compruebo si s nuevo o editado
                                    if(datos.tipo === 'Nuevo'){
                                        //actualizo el valor de este Id
                                        $('#IdTarjeta'+datos.iTabla).val(datos.IdTarjeta);
                                    }else{
                                        //nada
                                    }
                                    //sumas();
                                }else{
                                    $('#estado'+datos.iTabla).html('<img src="../images/error.png" width="10" height="10" border="0"/>');
                                }
                            }
                        });
                    }
                }
            }
            
            function escriboLiquido(iTabla,tarjetaDefecto,CuentaTarjetaDefecto){
                //recojo los objetos
                var liquido = document.getElementById('Liquido'+iTabla);
                var liquidoInicial = document.getElementById('Liquido_inicial'+iTabla);
                var valorLiquido = desFormateaNumeroContabilidad(liquido.value);

                //compruebo que son distintos, si lo es ejecuto el resto de la funcion, sino, termino aqui
                if(valorLiquido !== liquidoInicial.value){
                    //recojo el resto de objetos de datos de sta linea
                    var IdTarjeta = document.getElementById('IdTarjeta'+iTabla);
                    var fechaFila = document.getElementById('fechaFila'+iTabla);
                    var TarjetaDiv = document.getElementById('TarjetaDiv'+iTabla);

                    var comision = document.getElementById('Comision'+iTabla);
                    var bruto = document.getElementById('Bruto'+iTabla);

                    var CuentaDiv = document.getElementById('CuentaDiv'+iTabla);
                    var AsientoTarjetaDiv = document.getElementById('AsientoTarjetaDiv'+iTabla);
                    //hago la comprobacion de que esta cuenta es 5750, de tajetas, para poder hacer
                    //el calculo bruto - comision = liquido
                    var numTarjeta4 = document.getElementById('AsientoTarjeta'+iTabla).value.substr(0,4);
                        
                    //compruebo que bruto.value != ''
                    if(liquido.value !== ''){
                        //hago los calculos de bruto,comision y liquido
                        //formateo los numeros de bruto, comision y liquido
                        //var valorLiquido = liquido.value;
                        if(valorLiquido === ""){
                            valorLiquido = 0;
                        }
                        var valorComision = comision.value;
                        if(valorComision === ""){
                            valorComision = 0;
                        }else{
                            valorComision = desFormateaNumeroContabilidad(valorComision);
                        }
                        var valorBruto = bruto.value;

                        //bruto = liquido + comision
                        if(numTarjeta4 === '5750'){
                            valorBruto = parseFloat(valorLiquido) + parseFloat(valorComision);
                            valorBruto = Math.round(valorBruto * 100) / 100;
                        }else{
                            valorBruto = desFormateaNumeroContabilidad(valorBruto);
                        }
                        if(isNaN(valorBruto)){
                            alert('Este valor no es numérico');
                            liquido.value = "";
                        }else{
                            bruto.value = formateaNumeroContabilidad(valorBruto.toString());
                            comision.value = formateaNumeroContabilidad(valorComision.toString());

                            //ahora actualizo esta linea en la tabla

                            //si la linea no esta guarda en la BBDD el IdTarjeta = ""
                            //creo los campos select de tipoTareja, cuenta tarjeta y Asiento
                            //datos de tipoTarjeta y cuentaTarjeta
                            var tipoTarjeta = tarjetaDefecto;
                            var cuentaTarjeta = CuentaTarjetaDefecto;
                            if(IdTarjeta.value === ""){
                                //se crea el select de TipoAsiento y por defecto se pone el seleccionado en los filtros
                                TarjetaDiv.innerHTML = createSelecTarjeta(iTabla,tarjetaDefecto);

                                //select banco tarjeta
                                CuentaDiv.innerHTML = createSelectCuentaTarjeta(iTabla,CuentaTarjetaDefecto);
                                
                                //select del Tpo Asiento (P, X  numero si esta contabilizada)
                                AsientoTarjetaDiv.innerHTML = createSelectAsiento(iTabla);

                                //ahora ponemos el estado en esperando
                                $('#estado'+iTabla).html('<img src="../images/cargar.gif" width="10" height="10" border="0"/>');
                                //datos de tipoTarjeta y cuentaTarjeta
                                var tipoTarjeta = tarjetaDefecto;
                                var cuentaTarjeta = CuentaTarjetaDefecto;
                            }else{
                                //datos de tipoTarjeta y cuentaTarjeta
                                var tipoTarjeta = $('#AsientoTarjeta'+iTabla).val();
                                var cuentaTarjeta = $('#Cuenta'+iTabla).val();
                            }

                            //ahora guardo los datos en la BBDD
                            $.ajax({
                                data:{"iTabla":iTabla,"IdTarjeta":IdTarjeta.value,"fecha":fechaFila.value,"TipoTarjeta":tipoTarjeta,"bruto":valorBruto,
                                    "comision":valorComision,"liquido":valorLiquido,"cuentaTarjeta":cuentaTarjeta},
                                url: '../vista/ajax/ventas_tarjeta.php',
                                type:"get",
                                success: function(data) {
                                    var datos = JSON.parse(data);
                                    //compruebo si se ha guardado
                                    if(datos.guardado === 'SI'){
                                        $('#estado'+datos.iTabla).html('');
                                        //actualizo los campos de sumas
                                        //ahora compruebo si s nuevo o editado
                                        if(datos.tipo === 'Nuevo'){
                                            //actualizo el valor de este Id
                                            $('#IdTarjeta'+datos.iTabla).val(datos.IdTarjeta);
                                        }else{
                                            //nada
                                        }
                                        //sumas();
                                    }else{
                                        $('#estado'+datos.iTabla).html('<img src="../images/error.png" width="10" height="10" border="0"/>');
                                    }
                                }
                            });
                        }

                    }else{
                        //si es vacio el campo, borro toda la linea tanto en el form como en la BBDD
                        //1º borro esta linea de los datos en la BBDD
                        $.ajax({
                            data:{"iTabla":iTabla,"IdTarjeta":IdTarjeta.value},
                            url: '../vista/ajax/ventas_tarjeta_borrar.php',
                            type:"get",
                            success: function(data) {
                                var datos = JSON.parse(data);
                                //compruebo si se ha guardado
                                //2º limpio los campos de Tarjetas, cuentas y asiento
                                if(datos.guardado === 'SI'){
                                    $('#estado'+datos.iTabla).html('');
                                    $('#TarjetaDiv'+datos.iTabla).html('');
                                    $('#Comision'+datos.iTabla).val('');
                                    $('#Bruto'+datos.iTabla).val('');
                                    $('#CuentaDiv'+datos.iTabla).html('');
                                    $('#AsientoTarjetaDiv'+datos.iTabla).html('');
                                    //ahora compruebo si s nuevo o editado
                                    $('#IdTarjeta'+datos.iTabla).val('');
                                    //actualizo los campos de sumas
                                    //sumas();
                                }else{
                                    $('#estado'+datos.iTabla).html('<img src="../images/error.png" width="10" height="10" border="0"/>');
                                }
                            }
                        });
                    }
                }
            }
            
            function actTarjeta(tarjeta,iTabla){
                var IdTarjeta = document.getElementById('IdTarjeta'+iTabla).value;
                
                //ahora actualizo este dato el la fila de la tabla indicada por IdTarjeta
                
                //ahora ponemos el estado en esperando
                $('#estado'+iTabla).html('<img src="../images/cargar.gif" width="10" height="10" border="0"/>');
                                
                //ahora guardo los datos en la BBDD
                $.ajax({
                    data:{"iTabla":iTabla,"IdTarjeta":IdTarjeta,"TipoTarjeta":tarjeta},
                    url: '../vista/ajax/ventas_actTarjeta.php',
                    type:"get",
                    success: function(data) {
                        var datos = JSON.parse(data);
                        //compruebo si se ha guardado
                        if(datos.guardado === 'SI'){
                            $('#estado'+datos.iTabla).html('');
                        }else{
                            $('#estado'+datos.iTabla).html('<img src="../images/error.png" width="10" height="10" border="0"/>');
                        }
                    }
                });
                
            }
            
            function actTarjetaCuenta(cuenta,iTabla){
                var IdTarjeta = document.getElementById('IdTarjeta'+iTabla).value;
                
                //ahora actualizo este dato el la fila de la tabla indicada por IdTarjeta
                
                //ahora ponemos el estado en esperando
                $('#estado'+iTabla).html('<img src="../images/cargar.gif" width="10" height="10" border="0"/>');
                                
                //ahora guardo los datos en la BBDD
                $.ajax({
                    data:{"iTabla":iTabla,"IdTarjeta":IdTarjeta,"cuenta":cuenta},
                    url: '../vista/ajax/ventas_actTarjetaCuenta.php',
                    type:"get",
                    success: function(data) {
                        var datos = JSON.parse(data);
                        //compruebo si se ha guardado
                        if(datos.guardado === 'SI'){
                            $('#estado'+datos.iTabla).html('');
                        }else{
                            $('#estado'+datos.iTabla).html('<img src="../images/error.png" width="10" height="10" border="0"/>');
                        }
                    }
                });
            
            }
            
            function actAsiento(iTabla,value){
                var IdTarjeta = document.getElementById('IdTarjeta'+iTabla).value;
                
                //ahora actualizo este dato el la fila de la tabla indicada por IdTarjeta
                
                //ahora ponemos el estado en esperando
                $('#estado'+iTabla).html('<img src="../images/cargar.gif" width="10" height="10" border="0"/>');
                                
                //ahora guardo los datos en la BBDD
                $.ajax({
                    data:{"iTabla":iTabla,"IdTarjeta":IdTarjeta,"asiento":value},
                    url: '../vista/ajax/ventas_actTarjetaAsiento.php',
                    type:"get",
                    success: function(data) {
                        var datos = JSON.parse(data);
                        //compruebo si se ha guardado
                        if(datos.guardado === 'SI'){
                            $('#estado'+datos.iTabla).html('');
                        }else{
                            $('#estado'+datos.iTabla).html('<img src="../images/error.png" width="10" height="10" border="0"/>');
                        }
                    }
                });
            
            }
            
            function sumas(){
                var frm = document.form2;
                
                var sumaBruto = 0;
                var sumaComision = 0;
                var sumaLiquido = 0;
            
                for(i=0;i<frm.elements.length;i++){
                    //bruto
                    if(frm.elements[i].name.substring(0,5) === 'Bruto' && !(frm.elements[i].name.substring(0,13) === 'Bruto_Inicial')){
                        var pos = frm.elements[i].name.substr(5,3);
                        //1º compruebo si esta fila tiene datos (campo IdTarjeta != '') y 
                        var IdTarjeta = document.getElementById('IdTarjeta'+pos).value;
                        if(IdTarjeta !== ''){
                            //2º compruebo que no este contabilizado (el campo "AsientoBancoX" no sea numerico
                            //if(isNaN(parseInt(document.getElementById('AsientoBanco'+pos).value))){
                                sumaBruto = Math.round((sumaBruto + parseFloat(desFormateaNumeroContabilidad(frm.elements[i].value))) * 100) / 100;
                            //}
                        }
                    }
                    //comision
                    if(frm.elements[i].name.substring(0,8) === 'Comision' && !(frm.elements[i].name.substring(0,16) === 'Comision_inicial')){
                        var pos = frm.elements[i].name.substr(8,3);
                        //1º compruebo si esta fila tiene datos (campo IdTarjeta != '')
                        var IdTarjeta = document.getElementById('IdTarjeta'+pos).value;
                        if(IdTarjeta !== ''){
                            //2º compruebo que no este contabilizado (el campo "AsientoBancoX" no sea numerico
                            //if(isNaN(parseInt(document.getElementById('AsientoBanco'+pos).value))){
                                sumaComision = Math.round((sumaComision + parseFloat(desFormateaNumeroContabilidad(frm.elements[i].value))) * 100) / 100;
                            //}
                        }
                    }
                    //liquido
                    if(frm.elements[i].name.substring(0,7) === 'Liquido' && !(frm.elements[i].name.substring(0,15) === 'Liquido_inicial')){
                        var pos = frm.elements[i].name.substr(7,3);
                        //1º compruebo si esta fila tiene datos (campo IdTarjeta != '')
                        var IdTarjeta = document.getElementById('IdTarjeta'+pos).value;
                        if(IdTarjeta !== ''){
                            //2º compruebo que no este contabilizado (el campo "AsientoBancoX" no sea numerico
                            //if(isNaN(parseInt(document.getElementById('AsientoBanco'+pos).value))){
                                sumaLiquido = Math.round((sumaLiquido + parseFloat(desFormateaNumeroContabilidad(frm.elements[i].value))) * 100) / 100;
                            //}
                        }
                    }
                }

                //actualizo los campos
                $('#sumaBruto').html(formateaNumeroContabilidad(sumaBruto.toString()));
                $('#sumaComision').html(formateaNumeroContabilidad(sumaComision.toString()));
                $('#sumaLiquido').html(formateaNumeroContabilidad(sumaLiquido.toString()));
            }
            
            </script>
            <form id="formBancos" name="form2" method="post" action="../vista/ventas_tarjetas.php">
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
            <?php 
            if(isset($mes) && $mes !== ''){  
            ?>
            <h4 align="center"><?php echo $mesTxt . ' - ' . $ejercicio; ?></h4>
            <table id="datatablesMod" class="tablaExcel" border="1">
                <thead>
                    <tr>
                        <th width="2%"></th>
                        <th width="5%">Fecha</th>
                        <th width="10%">Tarjeta/Cheque</th>
                        <th width="10%">+ Bruto</th>
                        <th width="10%">- Comisión</th>
                        <th width="10%">= Liquido</th>
                        <th width="20%">Banco</th>
                        <th width="5%">Asiento</th>
                        <th width="28%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
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
                        
                        
                        $sumaBruto = 0.00;
                        $sumaComision = 0.00;
                        $sumaLiquido = 0.00;
                        
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
                                    if(is_numeric($arResult[$ii]['AsientoTarjeta'])){
                                        $disabled = 'disabled';
                                    }

//                                    $disabledDistribuir = '';
//                                    if(is_numeric($arResult[$ii]['AsientoBanco'])){
//                                        $disabledDistribuir = 'disabled';
//                                    }else
//                                    if(!isset($arResult[$ii]['Cantidad']) || $arResult[$ii]['Cantidad'] === ''){
//                                        $disabledDistribuir = 'disabled';
//                                    }
//
                                    //suma parcial
                                    $sumaBruto = (float)$sumaBruto + (float)$arResult[$ii]['Bruto'];
                                    $sumaComision = (float)$sumaComision + (float)$arResult[$ii]['Comision'];
                                    $sumaLiquido = (float)$sumaLiquido + (float)$arResult[$ii]['Liquido'];
                                    ?>
                                    <tr id="iTabla<?php echo $ii;?>">
                                        <td>
                                            <span id="iconoCrear<?php echo $ii;?>">
                                                <a id="crear<?php echo $ii;?>" onclick="crearFila(<?php echo '1'.$ii.'00'; ?>,<?php echo $ii;?>,0);"><img src="../images/add.jpg" style="width: 12px; height: 12px;"></a>
                                            </span>
                                        </td>
                                        <td>
                                            <label class="labelDatos"><?php echo $dia; ?></label>
                                            <input type="hidden" id="IdTarjeta<?php echo $ii;?>" name="IdTarjeta<?php echo $ii;?>" value="<?php echo $arResult[$ii]['IdTarjeta']; ?>" />
                                            <input type="hidden" id="fechaFila<?php echo $ii;?>" name="fechaFila<?php echo $ii;?>" value="<?php echo $fechaDate; ?>" />
                                        </td>
                                        <td>
                                            <div align="center" id="TarjetaDiv<?php echo $ii;?>">
                                            <?php
                                            //segun venga asiento indicamos o un listado si es P o X
                                            if($arResult[$ii]['AsientoTarjeta'] === 'P' || $arResult[$ii]['AsientoTarjeta'] === 'X'){
                                                //echo listadoTarjetas($arResult[$ii]['TipoTarjeta']);
                                                echo presentarTarjeta('AsientoTarjeta'.$ii,$arResult[$ii]['TipoTarjeta'],$ii,$listadoTarjetas);
                                            }else{
                                                //indico el nombre si es un numero (esta contabilizada)
                                                echo '<label class="labelDatos">' . $clsCNDatosVentas->nombreTarjeta($arResult[$ii]['TipoTarjeta']) . '</label>';
                                                echo '<input type="hidden" id="AsientoTarjeta'.$ii.'" name="AsientoTarjeta'.$ii.'" value="'.$arResult[$ii]['TipoTarjeta'].'"/>';
                                            }
                                            ?>    
                                            </div>
                                        </td>
                                        <td align="right" style="background-color: #f7f7f7;">
                                            <input type="text" class="inputDatos" id="Bruto<?php echo $ii;?>" name="Bruto<?php echo $ii;?>" value="<?php echo formateaNumeroContabilidad($arResult[$ii]['Bruto']); ?>" tabindex="<?php echo $ii;?>0003" 
                                                   onfocus="desFormateaNumContabilidad(this);datoInicial(this.value,'Bruto_Inicial<?php echo $ii;?>');this.select();"
                                                   onblur="formateaNumContabilidad(this); escriboBruto(<?php echo $ii;?>,document.getElementById('tarjeta').value,document.getElementById('cuentaBanco').value); sumas();"
                                                   onkeypress="return solonumerosNeg(event);" <?php echo $disabled;?> />
                                            <input type="hidden" id="Bruto_Inicial<?php echo $ii;?>" name="Bruto_Inicial<?php echo $ii;?>"  value="<?php echo $arResult[$ii]['Bruto']; ?>" />
                                        </td>
                                        <td align="right" style="background-color: #f7f7f7;">
                                            <input type="text" class="inputDatos" id="Comision<?php echo $ii;?>" name="Comision<?php echo $ii;?>" value="<?php echo formateaNumeroContabilidad($arResult[$ii]['Comision']); ?>" tabindex="<?php echo $ii;?>0004" 
                                                   onfocus="desFormateaNumContabilidad(this);datoInicial(this.value,'Comision_inicial<?php echo $ii;?>');this.select();"
                                                   onblur="formateaNumContabilidad(this); escriboComision(<?php echo $ii;?>,document.getElementById('tarjeta').value,document.getElementById('cuentaBanco').value); sumas();"
                                                   onkeypress="return solonumerosNeg(event);" <?php echo $disabled;?> />
                                            <input type="hidden" id="Comision_inicial<?php echo $ii;?>" name="Comision_inicial<?php echo $ii;?>" value="<?php echo $arResult[$ii]['Comision']; ?>" />
                                        </td>
                                        <td align="right" style="background-color: #f7f7f7;">
                                            <input type="text" class="inputDatos" id="Liquido<?php echo $ii;?>" name="Liquido<?php echo $ii;?>" value="<?php echo formateaNumeroContabilidad($arResult[$ii]['Liquido']); ?>" tabindex="<?php echo $ii;?>0005" 
                                                   onfocus="desFormateaNumContabilidad(this);datoInicial(this.value,'Liquido_inicial<?php echo $ii;?>');this.select();"
                                                   onblur="formateaNumContabilidad(this); escriboLiquido(<?php echo $ii;?>,document.getElementById('tarjeta').value,document.getElementById('cuentaBanco').value); sumas();"
                                                   onkeypress="return solonumerosNeg(event);" <?php echo $disabled;?> />
                                            <input type="hidden" id="Liquido_inicial<?php echo $ii;?>" name="Liquido_inicial<?php echo $ii;?>" value="<?php echo $arResult[$ii]['Liquido']; ?>" />
                                        </td>
                                        <td>
                                            <div align="center" id="CuentaDiv<?php echo $ii;?>">
                                            <?php
                                            //segun venga asiento indicamos o un listado o OK
                                            if($arResult[$ii]['CuentaTarjeta'] !== ''){
                                                if($arResult[$ii]['AsientoTarjeta'] === 'P' || $arResult[$ii]['AsientoTarjeta'] === 'X'){
                                                    echo presentarCuentasTarjeta('CuentaTarjeta',$ii,$arResult[$ii]['CuentaTarjeta'],$arResult[$ii]['IdTarjeta'],'0005');
                                                }else{
                                                    echo '<label class="labelDatos">' . $arResult[$ii]['CuentaTarjeta'] . '</label>';
                                                    echo '<input type="hidden" id="CuentaTarjeta'.$ii.'" name="CuentaTarjeta'.$ii.'" value="'.$arResult[$ii]['CuentaTarjeta'].'"/>';
                                                }
                                            }
                                            ?>    
                                            </div>
                                        </td>
                                        <td>
                                            <div align="center" id="AsientoTarjetaDiv<?php echo $ii;?>">
                                            <?php
                                            //segun venga asiento indicamos o un listado o OK
                                            if($arResult[$ii]['AsientoTarjeta'] === 'P' || $arResult[$ii]['AsientoTarjeta'] === 'X'){
                                                echo presentarAsientoTarjeta($ii, $arResult[$ii]['AsientoTarjeta'],$arResult[$ii]['IdTarjeta'],'0007');
                                            }else{
                                                echo '<label class="labelDatos">' . $arResult[$ii]['AsientoTarjeta'] . '</label>';
                                                echo '<input type="hidden" id="AsientoBanco'.$ii.'" name="AsientoBanco'.$ii.'" value="'.$arResult[$ii]['AsientoTarjeta'].'"/>';
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
                                        <td></td>
                                        <td align="right">
                                            <span id="sumaBruto" class="labelDatos"><?php echo formateaNumeroContabilidad($sumaBruto); ?></span>
                                        </td>
                                        <td align="right">
                                            <span id="sumaComision" class="labelDatos"><?php echo formateaNumeroContabilidad($sumaComision); ?></span>
                                        </td>
                                        <td align="right">
                                            <span id="sumaLiquido" class="labelDatos"><?php echo formateaNumeroContabilidad($sumaLiquido); ?></span>
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
//                          url: '../vista/ajax/ventas_borrarTabla_tarjetas.php',
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
