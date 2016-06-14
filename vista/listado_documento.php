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



logger('info','listado_documento.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['base'].', SesionID: '.  session_id(). 
        " ||||Documentacion->Listado Documentos|| ");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="../images/q.ico">
        <title>Documentos - CONSULTA</title>
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
                font-family: arial;
            }
        </style>
        <script type="text/javascript" charset="utf-8">

            $(document).ready(function(){

                //formatear y traducir los datos de la tabla
                $('#datatables').dataTable({
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
			null,
			null,
			null
                    ],                    
                    "bJQueryUI":true,
                    "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]]
                });

            });
            
        </script>
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
                clock.innerHTML = movingtime;
            }
            setTimeout("funClock()", 1000)
        }
        window.onload = funClock;
        //  Fin -->
    </script>
<?php
eventosInputText();
?>

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
        <div>
            <?php require_once '../vista/cabecera2Asesor.php'; ?>
            <table align="center">
                <tr>
                    <td>

            <form name="criterios" action="../vista/listado_documento.php" method="get">
            <table align="center" border="0" width="954">
                <tr></tr>
                <tr><td>
                <label class="filtroTexto" align="center" onclick="onOff_filtro(document.getElementById('filtros'));">Filtros</label> 
                <div id="filtros" style="display: none;">
                <table class="filtro" align="center" border="0" width="945">
                <tr>
                    <td>
                        <table align="center">
                            <tbody>
                                <tr align="center">
                                    <td><font size="-2">TOTAL</font></td>
                                    <td><font size="-2">Interno</font></td>
                                    <td><font size="-2">Externo</font></td>
                                </tr>
                                <tr align="center">
                                    <td>
                                        <input class="txtgeneral" type="radio" name="criterio" value="Total"
                                        <?php
                                        if(isset($_GET['criterio'])){
                                            if($_GET['criterio']=='Total'){
                                                echo 'checked';
                                            }
                                        }else{
                                            echo 'checked';
                                        }
                                        ?>
                                        />
                                    </td>
                                    <td>
                                        <input class="txtgeneral" type="radio" name="criterio" value="Interno"
                                        <?php
                                        if(isset($_GET['criterio'])){
                                            if($_GET['criterio']=='Interno'){
                                                echo 'checked';
                                            }
                                        }
                                        ?>
                                        />
                                    </td>
                                    <td>
                                        <input class="txtgeneral" type="radio" name="criterio" value="Externo"
                                        <?php
                                        if(isset($_GET['criterio'])){
                                            if($_GET['criterio']=='Externo'){
                                                echo 'checked';
                                            }
                                        }
                                        ?>
                                        />
                                    </td>
                                </tr>
                                </thead>
                        </table>
                    </td>
                </tr>
                <tr align="center">
                    <td colspan="2">
                        <input class="button" type="submit" id="cmdBuscar" name="cmdBuscar" value="Buscar"/>
                        <input name="cmdListar" type="hidden" value="OK"/>
                    </td>
                </tr>
            </table>
            </div>
            </td></tr>
            </table>   
        </form>
            <br/>
            <?php
//            if(isset($_GET['cmdListar'])&&$_GET['cmdListar']=='OK'){
                logger('info','listado_documento.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['base'].', SesionID: '.  session_id().
                        " ||||Documentación->Listado Documentación|| Ha pulsado Buscar: ".$_GET['criterio']);
                //la pagina se carga despues de haber pulsado el boton 'Buscar'
                
                //tenemos que hacer la busqueda y guardar los datos en la variable $arcDoc
                require_once '../CN/clsCNConsultas.php';
                //traigo los datos de la consulta
                $clsCNConsultas = new clsCNConsultas();
                $clsCNConsultas->setStrBD($_SESSION['dbContabilidad']);
                
                $arDoc = $clsCNConsultas->ListadoDocumentos($_GET['criterio']);
                logger('info','listado_documento.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['base'].', SesionID: '.  session_id().
                        " ||||Documentación->Listado Documentación|| Presenta listado");
                
                switch($_GET['criterio']){
                    case 'Total':
                        echo '<h3 align="center" color="#FFCC66"><font size="3px">Todos</font></h3>';
                        break;
                    case 'Interno':
                        echo '<h3 align="center" color="#FFCC66"><font size="3px">Internos</font></h3>';
                        break;
                    case 'Externo':
                        echo '<h3 align="center" color="#FFCC66"><font size="3px">Externos</font></h3>';
                        break;
                    default:
                        echo '<h3 align="center" color="#FFCC66"><font size="3px">Todos</font></h3>';
                        break;
                }
            ?>
            
            <br/>
            <table id="datatables" class="display">
                <thead>
                    <tr>
                        <th width="15%">Codigo</th>
                        <th width="5%">Edición</th>
                        <th width="10%">Fecha</th>
                        <th width="70%">Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(is_array($arDoc)){
                        for ($i = 0; $i < count($arDoc); $i++) {
                            //print_r($arDoc);
                            
                            //sino hay documento en la consuta se va a docverext.php
                            if($arDoc[$i]["strNombre"]==""){
                                $link="";
                            }else{
                                $link = "javascript:window.open('../doc/generales/" . $arDoc[$i]['strNombre'] . "');";
                            }
                            ?>
                            <tr>
                                <td onClick="<?php echo $link; ?>"><?php echo '&nbsp;&nbsp;&nbsp;<!-- '.$arDoc[$i]['lngOrden'].' -->'.$arDoc[$i]['strDocumento']; ?></td>
                                <td align="center" onClick="<?php echo $link; ?>"><?php echo $arDoc[$i]['IdVersion']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arDoc[$i]['datFecha']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arDoc[$i]['Descripcion']; ?></td>
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
<!--        </div>-->
        <br/><br/><br/>
        <?php include '../vista/IndicacionIncidencia.php'; ?>
        </td>
        </tr>
    </table>
    </body>
</html>
