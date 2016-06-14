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


?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="../images/q.ico">
        <title>Modificar datos del USUARIO</title>
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
                    "aaSorting": [[ 2, "asc" ]],
                    "bJQueryUI":true,
                    "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]]
                });
            });
        </script>
        <?php
        //estas funciones son generales para los datepicker
        datepicker_español('datAltaDesde');
        datepicker_español('datAltaHasta');
        ?>
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

<h3 align="center" color="#FFCC66"><font size="3px">Consulta de Usuarios</font></h3> 
<form name="form1" action="../vista/usulist.php" method="get">
    <div>
    <table class="filtro" align="center" border="0" width="954">
        <tr></tr>
        <tr><td>
    <table class="filtro" align="center" border="0" width="350">
    <tr> 
      <td rowspan="2" width="154"><div align="left"><b><I>Usuario:</I></b></div></td>
      <td class="nombreCampo"><div align="right">Nombre:</div></td>
      <td width="90">
          <div align="right"><input class="textbox1" style="width:100%" type="text" name="strNombre" maxlength="15"
                                    onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"  onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
          </div>
      </td>
    </tr>
    <tr> 
      <td class="nombreCampo"> <div align="right">Apellidos:</div></td>
      <td width="90">
          <div align="right"><input class="textbox1" type="text" name="strApellidos" maxlength="30"
                             onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"  onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
          </div>
      </td>
    </tr>
    <tr> 
      <td colspan="5"><hr align="left"></td>
    </tr>
    <tr> 
      <td colspan="5"></td>
    </tr>
    <tr>
         <td><div align="left"><b><I>Departamento:</I></b></div></td>
         <td align="left" colspan = "4">
            <div align="left">
            <?php
            //funcion general
            autocomplete_departamentos('strDepartamento');
            ?>
            <input class="textbox1" type="text" id="strDepartamento" name="strDepartamento" 
                   onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
            </div>
         </td>
     </tr>
     <tr align="center">
         <td colspan="5">
             <input type="Reset" class="button" value="Vaciar Datos" name="cmdReset"/>
             <input type="submit" class="button" value="Consultar" name="cmdConsultar"  />
             <input name="cmdListar" type="hidden" value="OK"/>
         </td>
     </tr>
     </table>
    </td></tr>
    <tr></tr>
    </table>   
     </form>
    
            <?php
            if(isset($_GET['cmdListar'])&&$_GET['cmdListar']=='OK'){
                //extraigo la consulta de esta tabla
                require_once '../CN/clsCNUsu.php';
                $clsCNUsu=new clsCNUsu();
                $clsCNUsu->setStrBD($_SESSION['dbContabilidad']);
                $arResult=$clsCNUsu->ListadoASPModifFilter($_SESSION['dbContabilidad'],$_GET['strNombre']
                                                      ,$_GET['strApellidos'],$_GET['strDepartamento']);
            ?>
            <h3 align="center" color="#FFCC66"><font size="3px">Listado de Usuarios</font></h3>
            
            
            
            
            <table id="datatablesMod" class="display">
                <thead>
                    <tr>
                        <th>Num</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Departamento</th>
                        <th>Permisos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(is_array($arResult)){
                        for ($i = 0; $i < count($arResult); $i++) {
                            //print_r($arDoc);
                            $link="javascript:document.location.href='../vista/usumodif.php?id=".$arResult[$i]['Id']."';";
                            ?>
                            <tr>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['Id']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['strNombre']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['strApellidos']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['strDepartamento']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['strPermiso']; ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
            <?php
            }//fin de la condicion if
            ?>
        </div>
    </body>
</html>
