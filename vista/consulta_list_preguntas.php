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



logger('info','consulta_list_preguntas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
       " ||||Comunicaciones->Consultas al Asesor||");

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="../images/q.ico">
        <title>Modificar Consultas del Cliente - Listado</title>
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
                    "aaSorting": [[ 5, "desc" ]],
                    "aoColumns": [
			{ "sType": 'string' },
			{ "sType": 'string' },
			{ "sType": 'string' },
			{ "sType": 'string' },
			{ "sType": 'string' },
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

<h3 align="center" color="#FFCC66"><font size="3px">Listado de Consultas</font></h3> 
<form name="form1" action="../vista/consulta_list_preguntas.php" method="get">
    <table align="center" border="0" width="954">
        <tr></tr>
        <tr><td>
    <label class="filtroTexto" align="center" onclick="onOff_filtro(document.getElementById('filtros'));">Filtros</label> 
    <div id="filtros" style="display: none;">
    <table class="filtro" align="center" border="0" width="945">
    <tr> 
      <td class="nombreCampo"><div align="right">Clasificación:</div></td>
      <td colspan="2" width="250">
          <div align="right">
              <select name="strClasificacion" class="textbox1"
                      onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);">
                    <option value = "" <?php if(!isset($_GET['strClasificacion'])){echo 'selected';}?>></option>
                    <option value = "Contable"
                            <?php
                            if(isset($_GET['strClasificacion'])){
                                if($_GET['strClasificacion']=='Contable'){
                                    echo ' selected';
                                }
                            }
                            ?>
                            >Contable</option>
                    <option value = "Fiscal"
                            <?php
                            if(isset($_GET['strClasificacion'])){
                                if($_GET['strClasificacion']=='Fiscal'){
                                    echo ' selected';
                                }
                            }
                            ?>
                            >Fiscal</option>
                    <option value = "Laboral"
                            <?php
                            if(isset($_GET['strClasificacion'])){
                                if($_GET['strClasificacion']=='Laboral'){
                                    echo ' selected';
                                }
                            }
                            ?>
                            >Laboral</option>
                    <option value = "Mercantil"
                            <?php
                            if(isset($_GET['strClasificacion'])){
                                if($_GET['strClasificacion']=='Mercantil'){
                                    echo ' selected';
                                }
                            }
                            ?>
                            >Mercantil</option>
                    <option value = "Técnico"
                            <?php
                            if(isset($_GET['strClasificacion'])){
                                if($_GET['strClasificacion']=='Técnico'){
                                    echo ' selected';
                                }
                            }
                            ?>
                            >Técnico</option>
              </select>
          </div>
      </td>
      <td class="nombreCampo" rowspan="2" width="150"><div align="right"><I>Fecha:</I></div></td>
      <td class="nombreCampo" width="80"><div align="right">Desde:</div></td>
      <?php
      datepicker_español('datFechaInicio');
      datepicker_español('datFechaFin');
      ?>
      <td width="90">
        <input class="textbox1" type="text" name="datFechaInicio" id="datFechaInicio" size="12" maxlength="38"
               value="<?php if(isset($_GET['datFechaInicio'])){echo $_GET['datFechaInicio'];}?>"
               onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
               onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"
               onKeyUp="this.value=formateafechaEntrada(this.value);" />
      </td>
      <td class="nombreCampo" rowspan="2" colspan="2" width="81" nowrap>
          <font color="#FF0000">(dd/mm/yyyy)</font>
      </td>
    </tr>
    <tr> 
      <td class="nombreCampo"> <div align="right">Estado:</div></td>
      <td colspan="2">
          <div align="right">
              <select name="strEstado" class="textbox1"
                      onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);">
                    <option value = "" <?php if(!isset($_GET['strClasificacion'])){echo 'selected';}?>></option>
                    <option value = "Abierto"
                            <?php
                            if(isset($_GET['strEstado'])){
                                if($_GET['strEstado']=='Abierto'){
                                    echo ' selected';
                                }
                            }
                            ?>
                            >Abierto</option>
                    <option value = "En Curso"
                            <?php
                            if(isset($_GET['strEstado'])){
                                if($_GET['strEstado']=='En Curso'){
                                    echo ' selected';
                                }
                            }
                            ?>
                            >En Curso</option>
                    <option value = "Respondida"
                            <?php
                            if(isset($_GET['strEstado'])){
                                if($_GET['strEstado']=='Respondida'){
                                    echo ' selected';
                                }
                            }
                            ?>
                            >Respondida</option>
                    <option value = "Cerrada"
                            <?php
                            if(isset($_GET['strEstado'])){
                                if($_GET['strEstado']=='Cerrada'){
                                    echo ' selected';
                                }
                            }
                            ?>
                            >Cerrada</option>
              </select>
          </div>
      </td>
      <td class="nombreCampo"> <div align="right">Hasta:</div></td>
      <td>
          <input class="textbox1" type="text" name="datFechaFin" id="datFechaFin" size="12" maxlength="38"
               value="<?php if(isset($_GET['datFechaFin'])){echo $_GET['datFechaFin'];}else{echo date('d/m/Y');}?>"
                 onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                 onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"
                 onKeyUp="this.value=formateafechaEntrada(this.value);" />
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
                //extraigo la consulta de esta tabla
                require_once '../CN/clsCNConsultas.php';
                $clsCNConsultas=new clsCNConsultas();
                $clsCNConsultas->setStrBD($_SESSION['dbContabilidad']);
                $arResult=$clsCNConsultas->ListadoConsultas($_GET['strClasificacion'],$_GET['strEstado'],
                                    $_GET['datFechaInicio'],$_GET['datFechaFin']);
            ?>
            <div align="center">
            <input class="button" type="button" value="Nueva Pregunta" onclick="irNueva();" />
            </div>

            <br/>
            <table id="datatablesMod" class="display">
                <thead>
                    <tr>
                        <th width="15%">Empresa</th>
                        <th width="15%">Cliente</th>
                        <th width="30%">Consulta</th>
                        <th width="10%">Clasificación</th>
                        <th width="10%">Estado</th>
                        <th width="10%">Fecha Pregunta</th>
                        <th width="10%">Fecha Ultima Respuesta</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(is_array($arResult)){
                        for ($i = 0; $i < count($arResult); $i++) {
                            $link="javascript:document.location.href='../vista/consulta_asesor.php?IdPregunta=".$arResult[$i]['IdPregunta']."';";
                            
                            //preparo el texto que va delante de la fecha para que se ordene correctamente
                            $fecha=explode('/',$arResult[$i]['Fecha']);
                            $textoFecha='<!-- '.$fecha[2].$fecha[1].$fecha[0].'-->';
                            $fechaPregunta=$textoFecha.$arResult[$i]['Fecha'];
                            
                            //comprobar la la fecha de la ultima respuesta y si esta leido o no
                            $UltimaRespuesta=$clsCNConsultas->fechaUltimaRespuesta($arResult[$i]['IdPregunta']);
                            
                            $fechaUltimaRespuesta='';
                            if($arResult[$i]['Leido'] == 1){
                                $fechaUltimaRespuesta=$UltimaRespuesta['FechaResp'];
                                //comprobar que existan respuestas
                                if($UltimaRespuesta['FechaResp']<>null){
                                    //marcamos SIN LEER las que no estan leidas, que no sean del mismo usuario y que el usuario no sea Asesor
                                    if($UltimaRespuesta['leido']==0 && $UltimaRespuesta['lngIdUsuario']<>$_SESSION['usuario']){
                                        $fechaUltimaRespuesta=$fechaUltimaRespuesta.' <br/><font color="red"><b>SIN LEER</b></font>';
                                    }
                                }
                            }else{
                                //comprobamos que no sea pregunta de asesor estas no se indican SIN LEER (Leido=9)
                                if($arResult[$i]['Leido']<>9){
                                    $fechaPregunta=$fechaPregunta.' <br/><font color="red"><b>SIN LEER</b></font>';
                                }
                                $fechaUltimaRespuesta=$UltimaRespuesta['FechaResp'];
                                //se indica la fecha de la ultima respuesta ysi esta leido
                                if($UltimaRespuesta['FechaResp']<>null){
                                    //marcamos SIN LEER las que no estan leidas, que no sean del mismo usuario y que el usuario no sea Asesor
                                    if($UltimaRespuesta['leido']==0 && $UltimaRespuesta['lngIdUsuario']<>$_SESSION['usuario']){
                                        $fechaUltimaRespuesta=$fechaUltimaRespuesta.' <br/><font color="red"><b>SIN LEER</b></font>';
                                    }
                                }
                            }
                            
                            //el campo de la tabla Empresa no presento valores si la pregunta es de un asesor
                            $empresa=$arResult[$i]['Empresa'];
                            if(substr($arResult[$i]['Perfil'],0,6)==='Asesor'){
                                $empresa='';
                            }
                            
                            //presentar el texto de consulta, sies mayor de 100 letras lo corto y 
                            //pongo puntos suspensivos
                            $txtConsulta=$arResult[$i]['Consulta'];
                            if(strlen($txtConsulta)>100){
                                $txtConsulta=substr($txtConsulta,0,100).' ...';
                            }
                            ?>
                            <tr>
                                <td onClick="<?php echo $link; ?>"><?php echo $empresa; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['Cliente']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $txtConsulta; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['Clasificacion']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['Estado']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $fechaPregunta; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $fechaUltimaRespuesta; ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
            <script>
                function irNueva(){
                    window.location.href='../vista/consulta_del_asesor.php';
                }
            </script>
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
