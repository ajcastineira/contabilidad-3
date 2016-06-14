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



logger('info','empleados_list.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
       " ||||Laboral->Incidencias Nominas||");

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="../images/q.ico">
        <title>Incidencias de los EMPLEADOS</title>
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
                    "aaSorting": [[ 1, "asc" ]],
                    "aoColumns": [
			{ "sType": 'string' },
			{ "sType": 'string' },
			{ "sType": 'string' },
			{ "sType": 'string' },
			{ "sType": 'string' },
			{ "sType": 'string' },
			{ "sType": 'string' },
			{ "sType": 'string' },
			{ "sType": 'string' }
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

function seleccionar(objeto){
    if(objeto.checked){
        //esta seleccionado, lo deselecciono
        $(document).ready(function(){
            $('#datatablesMod').find(":checkbox").each(function(){
                var elemento=this;
                elemento.checked=true;
            });
        });
    }else{
        //esta deseleccionado, lo selecciono
        $(document).ready(function(){
            $('#datatablesMod').find(":checkbox").each(function(){
                var elemento=this;
                elemento.checked=false;
            });
        });
    }
}

function copiarFin(objetoACopiar,objetoDondeCopia){
    objetoDondeCopia.value=objetoACopiar.value;
}

function cerrarIncidencias(){
    //comprobamos que este un empleado seleccionado
    var hayEmpleado='false';
    
    $('#datatablesMod').find(":checkbox").each(function(){
        var elemento=this;
        if(elemento.checked===true){
            hayEmpleado='true';
        }
    });
    
    if(hayEmpleado==='true'){
        document.form2.opcionBoton.value='cerrar';
        document.getElementById("cmdCerrarInc").value = "Procensando...";
        document.getElementById("cmdCerrarInc").disabled = true;
        document.form2.submit();
    }else{
        alert('No ha seleccionado ningun empleado.');
    }
}

function nuevaIncidencia(){
    //comprobamos que este un empleado seleccionado
    var hayEmpleado='false';
    
    $('#datatablesMod').find(":checkbox").each(function(){
        var elemento=this;
        if(elemento.checked===true){
            hayEmpleado='true';
        }
    });
    
    if(hayEmpleado==='true'){
        document.form2.opcionBoton.value='nueva';
        document.getElementById("cmdNuevaInc").value = "Procensando...";
        document.getElementById("cmdNuevaInc").disabled = true;
        document.form2.submit();
    }else{
        alert('No ha seleccionado ningun empleado.');
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
    <?php require_once '../vista/cabecera2.php'; ?>

<table align="center">
    <tr>
        <td>
    <h3 align="center" color="#FFCC66">
        <font size="3px">Incidencias de Empleados</font>
    </h3> 
            
<form name="form1" action="../vista/incNomina.php" method="get">
    <table align="center" border="0" width="954">
        <tr></tr>
        <tr><td>
    <label class="filtroTexto" align="center" onclick="onOff_filtro(document.getElementById('filtros'));">Filtros</label> 
    <div id="filtros" style="display: none;">
    <table class="filtro" align="center" border="0" width="350">
    <tr> 
      <td class="nombreCampo"><div align="right">Tipo Contrato:</div></td>
      <td width="200">
          <div align="right">
            <select name="tipoContrato" class="textbox1" tabindex="1"
                    onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);">
                <option value = "" <?php if($_GET['tipoContrato'] === ''){echo '';} ?>></option>
                <option value = "Indefinido" <?php if($_GET['tipoContrato'] === 'Indefinido'){echo 'selected';} ?>>Indefinido</option>
                <option value = "Temporal" <?php if($_GET['tipoContrato'] === 'Temporal'){echo 'selected';} ?>>Temporal</option>
                <option value = "Practicas" <?php if($_GET['tipoContrato'] === 'Practicas'){echo 'selected';} ?>>Prácticas</option>
                <option value = "Formacion" <?php if($_GET['tipoContrato'] === 'Formacion'){echo 'selected';} ?>>Formación</option>
            </select>
          </div>
      </td>
    </tr>
    <tr> 
      <td class="nombreCampo"><div align="right">Categoría:</div></td>
      <td>
          <div align="right">
              <input class="textbox1" type="text" name="categoria" maxlength="50" tabindex="2"
                     value="<?php if(isset($_GET['categoria'])){echo $_GET['categoria'];} ?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
          </div>
      </td>
    </tr>
    <tr> 
      <td colspan="5"></td>
    </tr>
     <tr align="center">
         <td colspan="5">
             <input type="Reset" class="button" value="Vaciar Datos" name="cmdReset"/>
             <input type="submit" class="button" value="Consultar" name="cmdConsultar" tabindex="3" />
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
                require_once '../CN/clsCNContabilidad.php';
                $clsCNContabilidad=new clsCNContabilidad();
                $clsCNContabilidad->setStrBD($_SESSION['mapeo']);
                
                $arResult=$clsCNContabilidad->ListadoEmpleados($_GET);
            ?>

            <br/>
            <form name="form2" action="../vista/incNomina_nueva.php" method="post">
            <table id="datatablesMod" class="display">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nombre y Apellidos</th>
                        <th>Tipo y Nº Doc</th>
                        <th>Nº Afiliación S.S.</th>
                        <th>Tipo Contrato</th>
                        <th>Categoría</th>
                        <th>Fecha Alta</th>
                        <th>Fecha Baja</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(is_array($arResult)){
                        for ($i = 0; $i < count($arResult); $i++) {
                            $link="javascript:document.location.href='../vista/incNominaEmpleado.php?IdEmpleado=".$arResult[$i]['IdEmpleado']."';";
                            $fechaAlta='';
                            if(isset($arResult[$i]['fechaAlta']) && $arResult[$i]['fechaAlta']<>'0000-00-00 00:00:00'){
                                $time = strtotime($arResult[$i]['fechaAlta']);
                                $fechaAlta = date("d/m/Y", $time);                            
                            }
                            
                            $fechaBaja='';
                            if(isset($arResult[$i]['fechaBaja']) && $arResult[$i]['fechaBaja']<>'0000-00-00 00:00:00'){
                                $time = strtotime($arResult[$i]['fechaBaja']);
                                $fechaBaja = date("d/m/Y", $time);                            
                            }
                            
                            $num = $arResult[$i]['NumEmpleado'];
                            while(strlen($num) < 3){
                                $num = '0' . $num;
                            }
                            
                            
                            ?>
                            <tr>
                                <td onClick=""><input type="checkbox" id="check<?php echo $arResult[$i]['IdEmpleado']; ?>" name="id<?php echo $arResult[$i]['IdEmpleado']; ?>" class="nombreCampo" /></td>
                                <td onClick="<?php echo $link; ?>"><?php echo "<!-- $num  -->  ".$arResult[$i]['NumEmpleado'].' - '.$arResult[$i]['nombre'].' '.$arResult[$i]['apellido1'].' '.$arResult[$i]['apellido2']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['tipoDocumento'].'-'.$arResult[$i]['numDocumento']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['numAfiliacion']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['tipoContrato']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['Categoria']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $fechaAlta; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $fechaBaja; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo '<font class="circulo"><b>&nbsp;'.$arResult[$i]['Numero'].'&nbsp;</b></font>'; ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
                
            <table align="center" border="0" width="100%">
                <tbody>
                    <tr>
                        <td width="30px" align="center">
                            <input type="checkbox" id="chkTodos" name="chkTodos" class="nombreCampo" onclick="seleccionar(this);" />
                        </td>
                        <td class="nombreCampo">Seleccionar/Quitar Todo</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td align="center">
                            <input class="button" type="button" id="cmdNuevaInc" value="Nueva Incidencia" onclick="nuevaIncidencia();" />
                            <?php 
                            if(substr($_SESSION['cargo'],0,6) === 'Asesor'){
                            ?>
                                <input class="button" type="button" id="cmdCerrarInc" value="Cerrar Incidencias" onclick="cerrarIncidencias();" />
                            <?php 
                            }
                            ?>
                            <input type="hidden" name="opcionBoton" />
                        </td>
                    </tr>
                <tbody>
            </table>
            </form>
            <?php
//            }//fin de la condicion if
            ?>
            <?php include '../vista/IndicacionIncidencia.php'; ?>
        </td>
        </tr>
        </table>
    </body>
</html>
