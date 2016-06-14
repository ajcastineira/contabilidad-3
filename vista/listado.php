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



logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
       " ||||Consultas->Listados||");

date_default_timezone_set('Europe/Madrid');
$fechaForm=date('d/m/Y');

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="../images/q.ico">
        <title>Listados</title>
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
<!--        <SCRIPT language="JavaScript" SRC="/include/frames.js"> 
        </SCRIPT>-->
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

<h3 align="center" color="#FFCC66"><font size="3px">Consulta de Cuentas</font></h3> 
<form name="form1" action="../vista/listado.php" method="get">
    <table align="center" border="0" width="954">
        <tr></tr>
        <tr><td>
    <label class="filtroTexto" align="center" onclick="onOff_filtro(document.getElementById('filtros'));">Filtros</label> 
    <div id="filtros" style="display: none;">
    <table class="filtro" align="center" border="0" width="945">
    <tr> 
      <td class="nombreCampo"><div align="right">Cuenta:</div></td>
      <td colspan="2" width="250">
          <div align="right">
              <input class="textbox1" style="width:100%" type="text" name="strCuenta" maxlength="50" value="<?php if(isset($_GET['strCuenta'])){echo $_GET['strCuenta'];}?>"
                                    onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"  onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
          </div>
      </td>
      <td class="nombreCampo" rowspan="2" width="150"><div align="right"><I>Fecha:</I></div></td>
      <td class="nombreCampo" width="80"><div align="right">Desde:</div></td>
      <?php
      datepicker_español('datFechaInicio');
      datepicker_español('datFechaFin');
      ?>
      <td width="90">
          <input class="textbox1" type="text" name="datFechaInicio" id="datFechaInicio" size="12" maxlength="38" value="<?php if(isset($_GET['datFechaInicio'])){echo $_GET['datFechaInicio'];}?>"
               onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
               onKeyUp="this.value=formateafechaEntrada(this.value);" 
               onfocus="onFocusInputText(this);"
               onblur="onBlurInputText(this);comprobarVacioFecha(this,'<?php echo $fechaForm;?>');"
               />
      </td>
      <td class="nombreCampo" rowspan="2" colspan="2" width="81" nowrap>
          <font color="#FF0000">(dd/mm/yyyy)</font>
      </td>
    </tr>
    <tr> 
      <td class="nombreCampo"> <div align="right">Periodo:</div></td>
      <td colspan="2">
          <div align="right">
              <select name="lngPeriodo" class="textbox1"
                      onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);">
                    <option value= "" <?php if(isset($_GET['lngPeriodo']) && $_GET['lngPeriodo']===''){echo 'selected';}?>></option>  
                    <option VALUE = "0" <?php if(isset($_GET['lngPeriodo']) && $_GET['lngPeriodo']=='0'){echo 'selected';} ?>>APERTURA</option>
                    <option VALUE = "1" <?php if(isset($_GET['lngPeriodo']) && $_GET['lngPeriodo']==1){echo 'selected';} ?>>ENERO</option>
                    <option VALUE = "2" <?php if(isset($_GET['lngPeriodo']) && $_GET['lngPeriodo']==2){echo 'selected';} ?>>FEBRERO</option>
                    <option VALUE = "3" <?php if(isset($_GET['lngPeriodo']) && $_GET['lngPeriodo']==3){echo 'selected';} ?>>MARZO</option>
                    <option VALUE = "4" <?php if(isset($_GET['lngPeriodo']) && $_GET['lngPeriodo']==4){echo 'selected';} ?>>ABRIL</option>
                    <option VALUE = "5" <?php if(isset($_GET['lngPeriodo']) && $_GET['lngPeriodo']==5){echo 'selected';} ?>>MAYO</option>
                    <option VALUE = "6" <?php if(isset($_GET['lngPeriodo']) && $_GET['lngPeriodo']==6){echo 'selected';} ?>>JUNIO</option>
                    <option VALUE = "7" <?php if(isset($_GET['lngPeriodo']) && $_GET['lngPeriodo']==7){echo 'selected';} ?>>JULIO</option>
                    <option VALUE = "8" <?php if(isset($_GET['lngPeriodo']) && $_GET['lngPeriodo']==8){echo 'selected';} ?>>AGOSTO</option>
                    <option VALUE = "9" <?php if(isset($_GET['lngPeriodo']) && $_GET['lngPeriodo']==9){echo 'selected';} ?>>SEPTIEMBRE</option>
                    <option VALUE = "10" <?php if(isset($_GET['lngPeriodo']) && $_GET['lngPeriodo']==10){echo 'selected';} ?>>OCTUBRE</option>
                    <option VALUE = "11" <?php if(isset($_GET['lngPeriodo']) && $_GET['lngPeriodo']==11){echo 'selected';} ?>>NOVIEMBRE</option>
                    <option VALUE = "12" <?php if(isset($_GET['lngPeriodo']) && $_GET['lngPeriodo']==12){echo 'selected';} ?>>DICIEMBRE</option>
                    <option VALUE = "98" <?php if(isset($_GET['lngPeriodo']) && $_GET['lngPeriodo']==98){echo 'selected';} ?>>CIERRE EJERCICIO</option>
                    <option VALUE = "99" <?php if(isset($_GET['lngPeriodo']) && $_GET['lngPeriodo']==99){echo 'selected';} ?>>CIERRE CONTABLE</option>
              </select>
          </div>
      </td>
      <td class="nombreCampo"> <div align="right">Hasta:</div></td>
      <td>
          <input class="textbox1" type="text" name="datFechaFin" id="datFechaFin" size="12" maxlength="38" value="<?php if(isset($_GET['datFechaFin'])){echo $_GET['datFechaFin'];}else{echo date('d/m/Y');}?>"
                 onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                 onKeyUp="this.value=formateafechaEntrada(this.value);" 
                 onfocus="onFocusInputText(this);"
                 onblur="onBlurInputText(this);comprobarVacioFecha(this,'<?php echo $fechaForm;?>');"
                 />
      </td>
    </tr>
    <tr> 
      <td class="nombreCampo"> <div align="right">Ejercicio:</div></td>
      <td>
          <div align="right">
              <input class="textbox1" type="text" name="lngEjercicio" maxlength="4"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onkeypress="return solonumeros(event);" value="<?php if(isset($_GET['lngEjercicio'])){echo $_GET['lngEjercicio'];}else{echo date('Y');}?>"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
          </div>
      </td>
      <td width="150"></td>
      <td class="nombreCampo"><div align="right"><I>Cantidad:</I></div></td>
      <td class="nombreCampo">
          <div align="left">Opción:</div>
          <div align="right">
              <select name="strOpcion" class="textbox1"
                    onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);">
                  <option value= "" <?php if(isset($_GET['strOpcion']) && $_GET['strOpcion']==''){echo 'selected';}?>></option>  
                  <option value = ">" <?php if(isset($_GET['strOpcion']) && $_GET['strOpcion']=='>'){echo 'selected';}?>>Mayor</option>
                  <option value = "<"<?php if(isset($_GET['strOpcion']) && $_GET['strOpcion']=='<'){echo 'selected';}?>>Menor</option>
                  <option value = "="<?php if(isset($_GET['strOpcion']) && $_GET['strOpcion']=='='){echo 'selected';}?>>Igual</option>
              </select>
          </div>
      </td>
      <td class="nombreCampo">
          <div align="left">Cantidad:</div>
          <div align="right">
              <input class="textbox1" type="text" name="lngCantidad" maxlength="9" value="<?php if(isset($_GET['lngCantidad'])){echo $_GET['lngCantidad'];}?>"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                     onkeypress="return solonumeros(event);"
                     onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
          </div>
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
//            if(isset($_GET['cmdListar'])&&$_GET['cmdListar']=='OK'){
                //extraigo la consulta de esta tabla
                require_once '../CN/clsCNContabilidad.php';
                $clsCNContabilidad=new clsCNContabilidad();
                $clsCNContabilidad->setStrBD($_SESSION['mapeo']);
                $arResult=$clsCNContabilidad->ListadoModAsientos($_GET['strCuenta'],$_GET['lngPeriodo'],
                                                                 $_GET['lngEjercicio'],$_GET['datFechaInicio'],
                                                                 $_GET['datFechaFin'],$_GET['strOpcion'],
                                                                 $_GET['lngCantidad']);
                //print_r($arResult);
                //guardo los parametros de busqueda para utilizarlos mas adelante
                $parametrosBusqueda=array("Periodo"=>$_GET['lngPeriodo'],
                                          "Ejercicio"=>$_GET['lngEjercicio'],
                                          "FechaInicio"=>$_GET['datFechaInicio'],
                                          "FechaFin"=>$_GET['datFechaFin'],
                                          "Opcion"=>$_GET['strOpcion'],
                                          "Cantidad"=>$_GET['lngCantidad']
                                          );
                //preparo el array para enviar por url
                $parametrosBusqueda=  serialize($parametrosBusqueda);
                $parametrosBusqueda = urlencode($parametrosBusqueda); 
            ?>
<!--            <h3 align="center" color="#FFCC66"><font size="3px">Listado de Cuentas</font></h3>-->
            
            <br/>
            <table id="datatablesMod" class="display">
                <thead>
                    <tr>
                        <th>Cuenta</th>
                        <th>Nombre</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(is_array($arResult)){
                        for ($i = 0; $i < count($arResult); $i++) {
                            //preparo el array de $arResult[$i] para enviar por url
                            $cuenta=  serialize($arResult[$i]);
                            $cuenta = urlencode($cuenta); 
                            $link="javascript:document.location.href='../vista/listado_cuenta.php?cuenta=".$cuenta."&parametros=".$parametrosBusqueda."';";
                            ?>
                            <tr>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['Cuenta']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['Nombre']; ?></td>
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
