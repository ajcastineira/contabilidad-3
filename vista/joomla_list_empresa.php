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

<h3 align="center" color="#FFCC66"><font size="3px">Listado</font></h3> 
    
            <?php
                //extraigo la consulta de esta tabla
                require_once '../CN/clsCNJoomla.php';
                $clsCNJoomla=new clsCNJoomla;
                $clsCNJoomla->setStrBD($_SESSION['dbContabilidad']);
                $arResult=$clsCNJoomla->listadoForm_Suscripcion();
                //compruebo que se tengan BBDD libres para asignar, sino no se deja entrar en el formulario
                $BBDD_libre=$clsCNJoomla->BBDD_libre();
            ?>

            <br/>
            <table id="datatablesMod" class="display">
                <thead>
                    <tr>
                        <th width="15%">Empresa</th>
                        <th width="15%">Tipo</th>
                        <th width="30%">Contacto</th>
                        <th width="15%">Teléfono</th>
                        <th width="15%">E-mail</th>
                        <th width="10%">Fecha Registro</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(is_array($arResult)){
                        for ($i = 0; $i < count($arResult); $i++) {
                            //si $BBDD_libre=TRUE (es que hay BBDD libres) ponemos e link
                            if($BBDD_libre==true){
                                $link="javascript:document.location.href='../vista/joomla_alta_empresa.php?id_joomla=".$arResult[$i]['id_joomla']."';";
                            }else{
                                $link="javascript:alert('No se puede dar de alta, no hay BBDD libres. Debe de dar de alta una BBDD en ARSYS');";
                            }
                            
                            //preparo el texto que va delante de la fecha para que se ordene correctamente
                            $fecha=explode('/',$arResult[$i]['fecha']);
                            $textoFecha='<!-- '.$fecha[2].$fecha[1].$fecha[0].'-->';
                            $fechaAlta=$textoFecha.$arResult[$i]['fecha'];
                            ?>
                            <tr>
                                <td onClick="<?php echo $link; ?>"><b><?php echo $arResult[$i]['nombre_empresa']; ?></b></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['tipo_empresa']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['contacto']['nombre'].' '.$arResult[$i]['contacto']['apellido1'].' '.$arResult[$i]['contacto']['apellido2']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['telefono']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['email']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $fechaAlta; ?></td>
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
