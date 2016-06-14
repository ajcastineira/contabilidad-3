<?php
session_start();
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


logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
       " ||||Mis Presupuestos->Modificación/Baja||");

date_default_timezone_set('Europe/Madrid');
$fechaForm=date('d/m/Y');

function listadoEstados($opcion,$IdPresupuesto){
?>
<select name="estadoNuevo" class="textbox1" onchange="actualizarEstadoPresupuesto(<?php echo $IdPresupuesto; ?>,this.value);">
    <option value="Pendiente" <?php if($opcion==='Pendiente'){echo 'selected';}?>>Pendiente</option>
    <option value="Aceptado" <?php if($opcion==='Aceptado'){echo 'selected';}?>>Aceptado</option>
    <option value="Rechazado" <?php if($opcion==='Rechazado'){echo 'selected';}?>>Rechazado</option>
    <option value="Cancelado" <?php if($opcion==='Cancelado'){echo 'selected';}?>>Cancelado</option>
</select>
<?php
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="../images/q.ico">
        <title>Listar/Modificar Presupuestos</title>
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
        <SCRIPT language="JavaScript" src="../js/car_valido.js"> 
        </SCRIPT>
        <SCRIPT languaje="JavaScript" src="../js/valida.js"> 
            <!--
            alert('Error en el fichero valida.js');
            // -->
        </SCRIPT>
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
                    "bStateSave": true,
                    "iCookieDuration": 60, //1 minuto
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
			null,
			null,
			null,
			{ "sType": 'string' },
			null,
			null,
			null,
			null,
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

function actualizarEstadoPresupuesto(IdPresupuesto,opcion){
    $.ajax({
      url: '../vista/ajax/actualizarEstadoPresupuesto.php?IdPresupuesto='+IdPresupuesto+'&opcion='+opcion,
      type:"get"
    });
}

function soloVer(IdPresupuesto){
    //visualizamos el presupuesto
    alert('Este presupuesto tiene facturas emitidas.');
    document.location.href='../vista/altapresupuesto.php?IdPresupuesto='+IdPresupuesto;
}

function soloVerPedido(IdPresupuesto){
    //visualizamos el presupuesto
    alert('Este presupuesto tiene pedidos emitidos.');
    document.location.href='../vista/altapresupuesto.php?IdPresupuesto='+IdPresupuesto;
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
    <?php require_once '../vista/cabecera2.php'; ?>
<table align="center">
    <tr>
        <td>

<h3 align="center" color="#FFCC66"><font size="3px">Control de Presupuestos</font></h3> 
<form name="form1" action="../vista/presupuestolist.php" method="get">
    <table align="center" border="0" width="954">
        <tr></tr>
        <tr><td>
    <label class="filtroTexto" align="center" onclick="onOff_filtro(document.getElementById('filtros'));">Filtros</label> 
    <div id="filtros" style="display: none;">
    <table class="filtro" align="center" border="0" width="945">
    <tr>
        <td width="100"></td>
        <td width="200"></td>
        <td width="125"></td>
        <td width="100"></td>
        <td width="200"></td>
        <td width=""></td>
    </tr>    
    <tr> 
      <td class="nombreCampo"><div align="right">Cliente:</div></td>
      <td>
          <div align="right">
              <input class="textbox1" style="width:100%" type="text" name="strNomContacto" maxlength="150" value="<?php if(isset($_GET['strNomContacto'])){echo $_GET['strNomContacto'];}?>"
                                    onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"  onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
          </div>
      </td>
      <td></td>
      <td class="nombreCampo"><div align="right">Estado:</div></td>
      <td>
          <div align="left">
            <select name="estado" class="textbox1" tabindex="5">
                <option value=""></option>
                <option value="Pendiente" <?php if($_GET['estado']==='Pendiente'){echo 'selected';}?>>Pendiente</option>
                <option value="Aceptado" <?php if($_GET['estado']==='Aceptado'){echo 'selected';}?>>Aceptado</option>
                <option value="Rechazado" <?php if($_GET['estado']==='Rechazado'){echo 'selected';}?>>Rechazado</option>
                <option value="Cancelado" <?php if($_GET['estado']==='Cancelado'){echo 'selected';}?>>Cancelado</option>
            </select>
          </div>
      </td>
      <td class="nombreCampo" rowspan="2" colspan="2" nowrap>
      </td>
    </tr>
    
    <tr> 
      <td colspan="8"><hr align="left"></td>
    </tr>
     <tr align="center">
         <td colspan="8">
             <input type="Reset" class="button" value="Vaciar Datos" name="cmdReset"/>
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
//            if(isset($_GET['cmdListar']) && $_GET['cmdListar']=='OK'){
                //extraigo la consulta de esta tabla
                require_once '../CN/clsCNContabilidad.php';
                $clsCNContabilidad=new clsCNContabilidad();
                $clsCNContabilidad->setStrBD($_SESSION['dbContabilidad']);
                $clsCNContabilidad->setStrBDCliente($_SESSION['mapeo']);
                $arResult=$clsCNContabilidad->ListadoPresupuestos($_GET['strNomContacto'],$_GET['estado']);
                //var_dump($arResult);die;
            ?>
<!--            <h3 align="center" color="#FFCC66"><font size="3px">Control de Presupuestos</font></h3>-->

            <br/>
            <table id="datatablesMod" class="display">
                <thead>
                    <tr>
                        <th width="7%">Numero Presupuesto</th>
                        <th width="25%">Cliente/Contacto</th>
                        <th width="10%">Fecha</th>
                        <th width="10%">Validez Hasta</th>
                        <th width="6%">Importe</th>
                        <th width="10%">Estado</th>
                        <th width="10%">PDF Enviado</th>
                        <th width="10%">Fecha Envio</th>
                        <th width="6%">Duplicar</th>
                        <th width="6%">Baja</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $tipoContador=$clsCNContabilidad->Parametro_general('Tipo Contador',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));

                    if(is_array($arResult)){
                        for ($i = 0; $i < count($arResult); $i++) {
                            
                            //ahora segun el tipo de contador presento el numero del presupuesto
                            $numeroPresupuesto = numeroDesformateado($arResult[$i]['NumPresupuesto'],$tipoContador);
//                            switch ($tipoContador) {
//                                case 'simple':
//                                    $numeroPresupuesto=$arResult[$i]['NumPresupuesto'];
//                                    break;
//                                case 'compuesto1':
//                                    $ejercicio=substr($arResult[$i]['NumPresupuesto'],0,4);
//                                    $numero=substr($arResult[$i]['NumPresupuesto'],4,4);
//
//                                    $numero4cifras=$numero;
//                                    while(substr($numero,0,1)==='0'){
//                                        $numero=substr($numero,1);
//                                    }
//                                    $numeroPresupuesto=$numero.'/'.$ejercicio;
//                                    break;
//                                case 'compuesto2':
//                                    $ejercicio=substr($arResult[$i]['NumPresupuesto'],0,4);
//                                    $numero=substr($arResult[$i]['NumPresupuesto'],4,4);
//
//                                    $numero4cifras=$numero;
//                                    while(substr($numero,0,1)==='0'){
//                                        $numero=substr($numero,1);
//                                    }
//                                    $numeroPresupuesto=$ejercicio.'/'.$numero;
//                                    break;
//                                default://ningun contador
//                                    $numeroPresupuesto=$arResult[$i]['NumPresupuesto'];
//                                    break;
//                            }
                            
                            //preparo el importe en texto y sin decimales, y una cifra de 20 digitos, asi puedo ordenarlo bien por importe
                            $importeTxt=$arResult[$i]['totalImporte']*100;
                            while(strlen($importeTxt)<20){
                                $importeTxt='0'.$importeTxt;
                            }
                            
                            //preparo el array de $arResult[$i] para enviar por url
                            if($arResult[$i]['GenFacPed']==='NO' && $arResult[$i]['GenPedPre']==='NO'){
                                $link="javascript:document.location.href='../vista/altapresupuesto.php?IdPresupuesto=".$arResult[$i]['IdPresupuesto']."';";
                            }else
                            if($arResult[$i]['GenFacPed']==='SI' || $arResult[$i]['GenFacPed']==='Parcial'){
                                $link="soloVer(".$arResult[$i]['IdPresupuesto'].");";
                            }else
                            if($arResult[$i]['GenPedPre']==='SI' || $arResult[$i]['GenPedPre']==='Parcial'){
                                $link="soloVerPedido(".$arResult[$i]['IdPresupuesto'].");";
                            }
                            if($arResult[$i]['existePDF']<>'NO'){
                                //$linkPDF="javascript:window.open('../presupuestosEnviados/Presupuesto_".$_SESSION['idEmp'].'-'.$ejercicio.'-'.$numero4cifras.".pdf')";
                                $linkPDF="javascript:window.open('../presupuestosEnviados/Presupuesto_".$_SESSION['idEmp'].'-'.$arResult[$i]['NumPresupuesto'].".pdf')";
                                $imagenPDF='<img src="../images/pdf.png" width="10" height="10" border="0"/>';
                                $fechaPDF=$arResult[$i]['existePDF'];
                            }else{
                                $linkPDF='';
                                $imagenPDF='';
                                $fechaPDF='';
                            }
                            ?>
                            <tr>
                                <td onClick="<?php echo $link; ?>"><?php echo "<!-- ".$arResult[$i]['NumPresupuesto']." -->".$numeroPresupuesto; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['nombreContacto']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['FechaPresupuesto']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['FechaVtoPresupuesto']; ?></td>
                                <td align="right" onClick="<?php echo $link; ?>"><?php echo "<!-- $importeTxt -->".formateaNumeroContabilidad($arResult[$i]['totalImporte']); ?></td>
                                <td>
                                    <?php
                                    if($arResult[$i]['GenFacPed']==='NO' && $arResult[$i]['GenPedPre']==='NO'){
                                        listadoEstados($arResult[$i]['Estado'],$arResult[$i]['IdPresupuesto']);
                                    }else{
                                        echo $arResult[$i]['Estado'];
                                    }
                                    ?>
                                </td>
                                <td align="center" onClick="<?php echo $linkPDF; ?>"><?php echo $imagenPDF; ?></td>
                                <td align="center" onClick="<?php echo $link; ?>"><?php echo $fechaPDF; ?></td>
                                <td align="center"><?php echo '<a href="../vista/altapresupuesto.php?IdPresupuesto='.$arResult[$i]['IdPresupuesto'] . '&duplicar=si"><img src="../images/copy.png" width="12" height="11" border="0"/></a>'; ?></td>
                                <td align="center">
                                    <?php
                                    if($arResult[$i]['GenFacPed']==='NO' && $arResult[$i]['GenPedPre']==='NO'){
                                        echo '<a href="../vista/altapresupuesto.php?IdPresupuesto='.$arResult[$i]['IdPresupuesto'] . '&borrar=si"><img src="../images/error.png" width="10" height="10" border="0"/></a>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
            <?php
//            }//fin de la condicion if
            ?>
            <br/><br/><br/>
            <?php include '../vista/IndicacionIncidencia.php'; ?>
        </td>
        </tr>
        </table>
    </body>
</html>
