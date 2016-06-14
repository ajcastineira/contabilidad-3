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

//borro de la sssion la factura activa que tuviese de antes
unset($_SESSION['presupuestoActivo']);


logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
       " ||||Mis Facturas->Modificación/Duplicar/Baja||");

date_default_timezone_set('Europe/Madrid');
$fechaForm=date('d/m/Y');


require_once '../CN/clsCNContabilidad.php';
$clsCNContabilidad=new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['dbContabilidad']);
$clsCNContabilidad->setStrBDCliente($_SESSION['mapeo']);
$arResult = $clsCNContabilidad->ListadoFacturas('','',$_GET['ejercicio']);

$ejercicios=$clsCNContabilidad->verEjerciciosFacturas();

function listadoEjercicios($ejercicios,$ejercicio){
    if($ejercicio === null){
        $ejercicio = date('Y');
    }
?>
<select id="ejercicio" name="ejercicio" data-native-menu="false" data-theme='a'>
    <?php
    for ($i = 0; $i < count($ejercicios); $i++) {
    ?>
        <option value="<?php echo $ejercicios[$i];?>" <?php if($ejercicios[$i] === $ejercicio){echo 'selected';}?>><?php echo $ejercicios[$i];?></option>
    <?php
    }
    ?>
</select>
<?php
}



?>

<!DOCTYPE html>
<html>
<head>
<TITLE>Listado de Facturas</TITLE>

<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>
</head> 
    <body>
    <div data-role="page" id="facturalist">
<?php
eventosInputText();
?>
<script LANGUAGE="JavaScript"> 

</script>

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>
        
    <div data-role="content" data-theme="a">
        <h3 align="center" color="#FFCC66"><font size="3px">Control de Facturas</font></h3>
        <br/>
        
        <form name="form1" action="../movil/facturalist.php" method="get">
        <table border="0" style="width: 100%;">
            <tbody>
                <tr>
                    <td style="width: 22%;"></td>
                    <td style="width: 23%;"></td>
                    <td style="width: 23%;"></td>
                    <td style="width: 22%;"></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>Ejercicio</label>
                        <?php
                        echo listadoEjercicios($ejercicios,$_GET['ejercicio']);
                        ?>
                        <input type="hidden" id="ContactoHidden" name="ContactoHidden" value="<?php if(isset($datosPresupuesto)){echo $datosPresupuesto['NombreEmpresa'];} ?>" />
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2">
                        <input type="submit" data-theme="a" data-mini="true" data-iconpos="right" name="cmdConsultar" id="cmdConsultar" 
                               value = "Consultar" /> 
                        <input name="cmdListar" type="hidden" value="OK"/>
                    </td>
                </tr>
            </tbody>
        </table>
        </form>
        <br/><br/><br/>
        <ul data-role="listview" data-dividertheme="a" data-filter="true" data-filter-placeHolder="Buscar">
            <?php
            if(is_array($arResult)){
                for ($i = 0; $i < count($arResult); $i++) {
                    $tipoContador=$clsCNContabilidad->Parametro_general('Tipo Contador',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));

                    $ejercicio=substr($arResult[$i]['NumFactura'],0,4);
                    $numero=substr($arResult[$i]['NumFactura'],4,4);

                    $numero4cifras=$numero;
                    while(substr($numero,0,1)==='0'){
                        $numero=substr($numero,1);
                    }


                    //ahora segun el tipo de contador presento el numero del presupuesto
                    $numeroFactura = numeroDesformateado($arResult[$i]['NumFactura'],$tipoContador);

                    //preparo el importe en texto y sin decimales, y una cifra de 20 digitos, asi puedo ordenarlo bien por importe
                    $importeTxt=$arResult[$i]['totalImporte']*100;
                    while(strlen($importeTxt)<20){
                        $importeTxt='0'.$importeTxt;
                    }

                    if($arResult[$i]['NumPresupuesto']<>'0'){
                        $ejercicio=substr($arResult[$i]['NumPresupuesto'],0,4);
                        $numero=substr($arResult[$i]['NumPresupuesto'],4,4);

                        $numero4cifras=$numero;
                        while(substr($numero,0,1)==='0'){
                            $numero=substr($numero,1);
                        }

                        //ahora segun el tipo de contador presento el numero del presupuesto
                        $numeroPresupuesto = numeroDesformateado($arResult[$i]['NumPresupuesto'],$tipoContador);
                    }else{
                        $numeroPresupuesto='';
                    }

                    //preparo el array de $arResult[$i] para enviar por url
                    $link="javascript:document.location.href='../movil/altafactura.php?IdFactura=".$arResult[$i]['IdFactura']."';";
                    
                    ?>
                    <li onClick="<?php echo $link; ?>">
                        <a href="#" data-ajax="false">
                        <?php echo '<font color="30a53b">Número: </font>'."<!-- ".$arResult[$i]['NumFactura']." -->".$numeroFactura. '   <font color="3ba5ba">'.$arResult[$i]['FechaFactura'].'</font><br/>'; ?>
                        <?php echo '<font color="30a53b">Cliente: </font><br/>'; ?>
                        <?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$arResult[$i]['nombreContacto'].'<br/>'; ?>
                        <?php echo '<font color="30a53b">Importe: </font>'."<!-- $importeTxt -->".formateaNumeroContabilidad($arResult[$i]['totalImporte']).'<br/>'; ?>
                        <?php echo '<font color="30a53b">Estado: </font>'.$arResult[$i]['Estado'].'<br/>';?>
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
