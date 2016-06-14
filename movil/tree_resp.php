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



//tenemos que hacer la busqueda y guardar los datos en la variable $arcDoc
require_once '../CN/clsCNConsultas.php';
//traigo los datos de la consulta
$clsCNConsultas = new clsCNConsultas();
$clsCNConsultas->setStrBD($_SESSION['dbContabilidad']);

$arResult = $clsCNConsultas->ListadoDocumentos('Total');


?>

<!DOCTYPE html>
<html>
<head>
<TITLE>Selección de Documento</TITLE>

<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>
</head> 
    <body>
    <div data-role="page" id="treeresp">
<?php
eventosInputText();
?>
<script LANGUAGE="JavaScript"> 


</script>

    <?php
//    include_once '../movil/cabeceraMovil.php';
    ?>
        
    <div data-role="content" data-theme="a">
        <h3 align="center" color="#FFCC66"><font size="3px">Listado de Documentos Generales</font></h3>
        <br/>
        <ul data-role="listview" data-dividertheme="a" data-filter="true" data-filter-placeHolder="Buscar">
            <?php
            if(is_array($arResult)){
                for ($i = 0; $i < count($arResult); $i++) {
                    if($arResult[$i]['lngTipo']==='0'){
                        $link="javascript:onMouseClickFila('".$arResult[$i]['strNombre']."');";
                    }else{
                        $link="javascript:onMouseClickFila('".$arResult[$i]['link']."');";
                    }
                    
                    ?>
                    <script type="text/javascript">
                        function onMouseClickFila(row_id){
                            window.opener.nombreDocumento(row_id);
                            window.close();
                        };
                    </script>
                    <li onClick="<?php echo $link; ?>">
                        <a href="#" data-ajax="false">
                        <?php echo '<font color="30a53b">Código: </font>'."<!-- ".$arResult[$i]['lngOrden']." -->".$arResult[$i]['strDocumento'].'<br/>'; ?>
                        <?php echo '<font color="30a53b">Edición: </font>'.$arResult[$i]['IdVersion'].'<br/>';?>
                        <?php echo '<font color="30a53b">Fecha: </font><font color="3ba5ba">'.$arResult[$i]['Fecha'].'</font><br/>';?>
                        <?php echo '<font color="30a53b">Descripción: </font><br/>'; ?>
                        <?php echo $arResult[$i]['Descripcion'].'<br/>';?>
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
