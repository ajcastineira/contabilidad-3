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



//codigo principal
if($_GET['tipo']=='cliente'){
    logger('info','cliprovlist.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
           " ||||Configuraciones->Mis Clientes->Consulta/Modificacion||");
}else{
    logger('info','cliprovlist.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
           " ||||Configuraciones->Mis Proveedores->Consulta/Modificacion||");
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="../images/q.ico">
        <title>Consulta de <?php echo $_GET['tipo'];?></title>
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
    <h3 align="center" color="#FFCC66">
        <font size="3px">
        <?php
        if($_GET['tipo']=='cliente'){
            echo 'Consulta de Cliente';
        }else{
            echo 'Consulta de Proveedor';
        }
        ?>
        </font>
    </h3> 
<form name="form1" action="../vista/cliprovlist.php" method="get">
    <table align="center" border="0" width="954">
        <tr></tr>
        <tr><td>
    <label class="filtroTexto" align="center" onclick="onOff_filtro(document.getElementById('filtros'));">Filtros</label> 
    <div id="filtros" style="display: none;">
    <table class="filtro" align="center" border="0" width="945">
    <tr>
        <td height="10px"></td>
    </tr>    
    <tr> 
      <td width="100" class="nombreCampo"><div align="right">Nombre:</div></td>
      <td width="70">
          <div align="right">
              <input class="textbox1" type="text" name="strNombre" maxlength="50"
                                    onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"  onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
          </div>
      </td>
      <td width="100"></td>
    </tr>
    <tr> 
      <td class="nombreCampo"> <div align="right">NIF/CIF:</div></td>
      <td>
          <div align="right">
              <input class="textbox1" type="text" name="strCIF" maxlength="50"
                             onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"  onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"/>
          </div>
      </td>
    </tr>
    <tr> 
      <td colspan="5"></td>
    </tr>
     <tr align="center">
         <td colspan="5">
             <input type="Reset" class="button" value="Vaciar Datos" name="cmdReset"/>
             <input type="submit" class="button" value="Consultar" name="cmdConsultar"  />
             <input name="cmdListar" type="hidden" value="OK"/>
             <input name="tipo" type="hidden" value="<?php echo $_GET['tipo'];?>"/>
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
                require_once '../CN/clsCNUsu.php';
                $clsCNUsu=new clsCNUsu();
                $clsCNUsu->setStrBD($_SESSION['dbContabilidad']);
                $clsCNUsu->setStrBDCliente($_SESSION['mapeo']);
                $arResult=$clsCNUsu->ListadoCliProv($_GET['tipo'],$_GET['strNombre'],$_GET['strCIF']);
                //print_r($arResult);die;
            ?>
<!--            <h3 align="center" color="#FFCC66">
                <font size="3px">
                <?php
//                if($_GET['tipo']=='cliente'){
//                    echo 'Listado de Clientes';
//                }else{
//                    echo 'Listado de Proveedores';
//                }
                ?>
                </font>
            </h3> -->
            <br/>
            <table id="datatablesMod" class="display">
                <thead>
                    <tr>
                        <th>Num</th>
                        <th>Nombre</th>
                        <th>CIF</th>
                        <th>Baja</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(is_array($arResult)){
                        for ($i = 0; $i < count($arResult); $i++) {
                            //print_r($arDoc);
                            $link="javascript:document.location.href='../vista/consultacliprov.php?IdRelacionCliProv=".$arResult[$i]['IdRelacionCliProv']."&tipo=".$_GET['tipo']."';";
                            ?>
                            <tr>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['Codigo']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['nombre']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['CIF']; ?></td>
                                <td align="center"><?php echo '<a href="../vista/consultacliprov.php?IdRelacionCliProv=' . $arResult[$i]['IdRelacionCliProv'] . '&tipo='.$_GET['tipo'].'&borrar=si"><img src="../images/error.png" width="10" height="10" border="0"/></a>'; ?></td>
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
            <?php include '../vista/IndicacionIncidencia.php'; ?>
        </td>
        </tr>
        </table>
    </body>
</html>
