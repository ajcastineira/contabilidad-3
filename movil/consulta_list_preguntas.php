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
       " ||||Comunicaciones->Consultas al Asesor||");

date_default_timezone_set('Europe/Madrid');
$fechaForm=date('d/m/Y');


require_once '../CN/clsCNConsultas.php';
$clsCNConsultas=new clsCNConsultas();
$clsCNConsultas->setStrBD($_SESSION['dbContabilidad']);
$arResult=$clsCNConsultas->ListadoConsultas('','','','');

?>

<!DOCTYPE html>
<html>
<head>
<TITLE>Listado de Consultas</TITLE>

<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>
</head> 
    <body>
    <div data-role="page" id="consultalistpreguntas">
<?php
eventosInputText();
?>
<script LANGUAGE="JavaScript"> 



</script>

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>
        
    <div data-role="content" data-theme="a">
        <h3 align="center" color="#FFCC66"><font size="3px">Listado de Consultas</font></h3>
        <script>
            function irNueva(){
                window.location.href='../vista/consulta_del_asesor.php';
            }
        </script>
        <table>
            <tr>
                <td style="width: 22%;"></td>
                <td style="width: 46%;">
                    <input data-mini="true" data-theme="a" type="button" value="Nueva Pregunta" onclick="irNueva();" />
                </td>
                <td style="width: 22%;"></td>
            </tr>
        </table>
        <br/>
        <ul data-role="listview" data-dividertheme="a" data-filter="true" data-filter-placeHolder="Buscar">
            <?php
            if(is_array($arResult)){
                for ($i = 0; $i < count($arResult); $i++) {

                    $link="javascript:document.location.href='../vista/consulta_asesor.php?IdPregunta=".$arResult[$i]['IdPregunta']."';";

                    //preparo el texto que va delante de la fecha para que se ordene correctamente
                    $fecha=explode('/',$arResult[$i]['Fecha']);
                    $textoFecha='<!-- '.$fecha[2].$fecha[1].$fecha[0].'-->';
                    $fechaPregunta=$arResult[$i]['Fecha'];

                    //comprobar la la fecha de la ultima respuesta y si esta leido o no
                    $UltimaRespuesta=$clsCNConsultas->fechaUltimaRespuesta($arResult[$i]['IdPregunta']);

                    $fechaUltimaRespuesta='';
                    if($arResult[$i]['Leido'] == 1){
                        $fechaUltimaRespuesta=$UltimaRespuesta['FechaResp'];
                        //comprobar que existan respuestas
                        if($UltimaRespuesta['FechaResp']<>null){
                            //marcamos SIN LEER las que no estan leidas, que no sean del mismo usuario y que el usuario no sea Asesor
                            if($UltimaRespuesta['leido']==0 && $UltimaRespuesta['lngIdUsuario']<>$_SESSION['usuario']){
                                $fechaUltimaRespuesta=$fechaUltimaRespuesta.' <font color="red"><b>SIN LEER</b></font>';
                            }
                        }
                    }else{
                        //comprobamos que no sea pregunta de asesor estas no se indican SIN LEER (Leido=9)
                        if($arResult[$i]['Leido']<>9){
                            $fechaPregunta=$fechaPregunta.' <font color="red"><b>SIN LEER</b></font>';
                        }
                        $fechaUltimaRespuesta=$UltimaRespuesta['FechaResp'];
                        //se indica la fecha de la ultima respuesta ysi esta leido
                        if($UltimaRespuesta['FechaResp']<>null){
                            //marcamos SIN LEER las que no estan leidas, que no sean del mismo usuario y que el usuario no sea Asesor
                            if($UltimaRespuesta['leido']==0 && $UltimaRespuesta['lngIdUsuario']<>$_SESSION['usuario']){
                                $fechaUltimaRespuesta=$fechaUltimaRespuesta.' <font color="red"><b>SIN LEER</b></font>';
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
                    <li onClick="<?php echo $link; ?>">
                        <a href="#" data-ajax="false">
                        <?php echo $textoFecha.'<font color="30a53b">Empresa: </font>'.$empresa.'</font><br/>'; ?>
                        <?php echo '<font color="30a53b">Cliente: </font>'.$arResult[$i]['Cliente'].'<br/>'; ?>
                        <?php echo '<font color="30a53b">Clasificación: </font>'.$arResult[$i]['Clasificacion'].'<br/>'; ?>
                        <?php echo '<font color="30a53b">Estado: </font>'.$arResult[$i]['Estado'].'<br/>'; ?>
                        <?php echo '<font color="30a53b">Fecha Consulta: </font><br/>'; ?>
                        <?php echo '&nbsp;&nbsp;&nbsp;<font color="3ba5ba">'.$fechaPregunta.'</font><br/>'; ?>
                        <?php echo '<font color="30a53b">Fecha Ultima Resp.: </font><br/>'; ?>
                        <?php echo '&nbsp;&nbsp;&nbsp;<font color="3ba5ba">'.$fechaUltimaRespuesta.'</font><br/>'; ?>
                        </a>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
    </div>            
            
    </div>    
    <script type="text/javascript" charset="utf-8">
    </script>
    </body>
</html>
