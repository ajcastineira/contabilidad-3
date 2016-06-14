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
       " ||||Configuracion->Mis Articulos->Consulta/Modificación||");

date_default_timezone_set('Europe/Madrid');
$fechaForm=date('d/m/Y');


$IdGrupoListar = '0';
if(isset($_GET['IdGrupo'])){
    $IdGrupoListar = $_GET['IdGrupo'];
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="../images/q.ico">
        <title>Listar/Modificar Mis Artículos</title>
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
                //formatear y traducir los datos de la tabla grupos
                $('#grupo').dataTable({
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
			{ "sType": 'string' },
			{ "sType": 'string' },
			{ "sType": 'string' }
                    ],                    
                    "bJQueryUI":true,
                    "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]]
                });
                
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
<table align="center" width="954" border="0">
    <tr>
        <td>
<h3 align="center" color="#FFCC66"><font size="3px">Listado de Grupos</font></h3> 
            <?php
                //extraigo la consulta de esta tabla
                require_once '../CN/clsCNContabilidad.php';
                $clsCNContabilidad=new clsCNContabilidad();
                $clsCNContabilidad->setStrBD($_SESSION['dbContabilidad']);
                $clsCNContabilidad->setStrBDCliente($_SESSION['mapeo']);
                $arResult=$clsCNContabilidad->ListadoGruposArticulos();
            ?>
            <br/>
            <table id="grupo" class="display">
                <thead>
                    <tr>
                        <th>Nombre Grupo</th>
                        <th>Identificador</th>
                        <th>Cuenta</th>
                        <th>Editar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(is_array($arResult)){
                        for ($i = 0; $i < count($arResult); $i++) {
                            //preparo el array de $arResult[$i] para enviar por url
                            $link="javascript:document.location.href='../vista/misArticulos.php?IdGrupo=".$arResult[$i]['IdGrupo']."';";
                            ?>
                            <tr>
                                <td onClick="<?php echo $link; ?>"><?php echo "<!-- ".$arResult[$i]['IdGrupo']."-->".$arResult[$i]['Grupo']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['Identificador']; ?></td>
                                <td onClick="<?php echo $link; ?>">
                                    <div align="right">
                                        <?php echo $arResult[$i]['Cuenta']; ?>
                                    </div>
                                </td>
                                <td align="center"><?php echo '<a href="../vista/altaGrupoArticulo.php?Id=' . $arResult[$i]['IdGrupo'] . '"><img src="../images/edit.png" width="12" height="12" border="0"/></a>'; ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
            
            <form name="form2" method="post" action="../vista/altaGrupoArticulo.php">
                <input type="submit" id="cmdAlta" class="button" value = "Añadir Grupo" />
            </form>
            
            <?php
            //listado de articulos por grupo
            $arResultArt = $clsCNContabilidad->ListadoArticulosDeGrupo($IdGrupoListar);
            $nombreGrupo = $clsCNContabilidad->nombreGrupoArticulo($IdGrupoListar);
            ?>
            
            <h3 align="center" color="#FFCC66"><font size="3px">Listado de Articulos del Grupo <?php echo $nombreGrupo[0]['Grupo'];?></font></h3> 
    
            <br/>
            <table id="datatablesMod" class="display">
                <thead>
                    <tr>
                        <th width="10%">Referencia</th>
                        <th width="40%">Descripción</th>
                        <th width="10%">Precio</th>
                        <th width="5%">Tipo IVA</th>
                        <th width="10%">Cantidad Almacén</th>
                        <th width="15%">Cuenta Contable</th>
                        <th width="10%">Borrar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(is_array($arResultArt)){
                        for ($i = 0; $i < count($arResultArt); $i++) {
                            //preparo el array de $arResult[$i] para enviar por url
                            $link="javascript:document.location.href='../vista/altaArticulo.php?Id=".$arResultArt[$i]['Id']."';";
                            ?>
                            <tr>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResultArt[$i]['Referencia']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResultArt[$i]['Descripcion']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo formateaNumeroContabilidad($arResultArt[$i]['Precio']); ?></td>
                                <td onClick="<?php echo $link; ?>">
                                    <div align="right">
                                        <?php echo $arResultArt[$i]['tipoIVA']; ?>
                                    </div>
                                </td>
                                <td onClick="<?php echo $link; ?>">
                                    <div align="right">
                                        <?php echo $arResultArt[$i]['CantidadAlmacen']; ?>
                                    </div>
                                </td>
                                <td onClick="<?php echo $link; ?>">
                                    <div align="right">
                                        <?php echo $arResultArt[$i]['CuentaContable']; ?>
                                    </div>
                                </td>
                                <td align="center"><?php echo '<a href="../vista/altaArticulo.php?Id=' . $arResultArt[$i]['Id'] . '&borrar=si"><img src="../images/error.png" width="10" height="10" border="0"/></a>'; ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
            
            <form name="form1" method="post" action="../vista/altaArticulo.php">
                <input type="submit" id="cmdAlta" class="button" value = "Añadir Artículo" />
                <input type="hidden" name="grupo" value = "<?php echo $IdGrupoListar; ?>" />
            </form>

            <br/><br/><br/>
            <?php include '../vista/IndicacionIncidencia.php'; ?>
        </td>
        </tr>
        </table>
    </body>
</html>
