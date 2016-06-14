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
       " ||||Mis Presupuestos->Modificación/Baja||");

date_default_timezone_set('Europe/Madrid');
$fechaForm=date('d/m/Y');


require_once '../CN/clsCNContabilidad.php';
$clsCNContabilidad=new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['dbContabilidad']);
$clsCNContabilidad->setStrBDCliente($_SESSION['mapeo']);
$arResult=$clsCNContabilidad->ListadoPresupuestos('','');


?>

<!DOCTYPE html>
<html>
<head>
<TITLE>Listado de Presupuestos</TITLE>

<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>
</head> 
    <body>
    <div data-role="page" id="presupuestolist">
<?php
eventosInputText();
?>
<script LANGUAGE="JavaScript"> 

function soloVer(IdPresupuesto){
    //visualizamos el presupuesto
    alert('Este presupuesto tiene facturas emitidas.');
    document.location.href='../movil/altapresupuesto.php?IdPresupuesto='+IdPresupuesto;
}

</script>

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>
        
    <div data-role="content" data-theme="a">
        <h3 align="center" color="#FFCC66"><font size="3px">Control de Presupuestos</font></h3>
        <br/>
        <ul data-role="listview" data-dividertheme="a" data-filter="true" data-filter-placeHolder="Buscar">
            <?php
            if(is_array($arResult)){
                for ($i = 0; $i < count($arResult); $i++) {
                    $tipoContador=$clsCNContabilidad->Parametro_general('Tipo Contador',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));

                    $ejercicio=substr($arResult[$i]['NumPresupuesto'],0,4);
                    $numero=substr($arResult[$i]['NumPresupuesto'],4,4);

                    $numero4cifras=$numero;
                    while(substr($numero,0,1)==='0'){
                        $numero=substr($numero,1);
                    }

                    //ahora segun el tipo de contador presento el numero del presupuesto
                    $numeroPresupuesto = numeroDesformateado($arResult[$i]['NumPresupuesto'],$tipoContador);
//                    switch ($tipoContador) {
//                        case 'simple':
//                            $numeroPresupuesto=$numero;
//                            break;
//                        case 'compuesto1':
//                            $numeroPresupuesto=$numero.'/'.$ejercicio;
//                            break;
//                        case 'compuesto2':
//                            $numeroPresupuesto=$ejercicio.'/'.$numero;
//                            break;
//                        default://ningun contador
//                            $numeroPresupuesto=$numero;
//                            break;
//                    }

                    //preparo el importe en texto y sin decimales, y una cifra de 20 digitos, asi puedo ordenarlo bien por importe
                    $importeTxt=$arResult[$i]['totalImporte']*100;
                    while(strlen($importeTxt)<20){
                        $importeTxt='0'.$importeTxt;
                    }

                    //preparo el array de $arResult[$i] para enviar por url
                    if($arResult[$i]['GenFacPed']==='NO'){
                        $link="javascript:document.location.href='../movil/altapresupuesto.php?IdPresupuesto=".$arResult[$i]['IdPresupuesto']."';";
                    }else{
                        $link="soloVer(".$arResult[$i]['IdPresupuesto'].");";
                    }
                    ?>
                    <li onClick="<?php echo $link; ?>">
                        <a href="#" data-ajax="false">
                        <?php echo '<font color="30a53b">Número: </font>'."<!-- ".$arResult[$i]['NumPresupuesto']." -->".$numeroPresupuesto. '   <font color="3ba5ba">'.$arResult[$i]['FechaPresupuesto'].'</font><br/>'; ?>
                        <?php echo '<font color="30a53b">Cliente/Contacto: </font><br/>'; ?>
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
