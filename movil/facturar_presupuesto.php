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



//logica de control para las paginas 'factura_presup_parcial.php' y 'factura_presup_diferencia.php'
//creo una variable se SESSION que verificaran estas paginas para saber que vienen de esta
$_SESSION['FP']='FP';


logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
       " ||||Mis Presupuestos->Facturar Presupuesto||");

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
<TITLE>Facturar Presupuestos</TITLE>

<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>
</head> 
    <body>
    <div data-role="page" id="facturar_presupuesto">
<?php
eventosInputText();
?>
<script LANGUAGE="JavaScript"> 
//comntrolar que solo se introduce datos numericos en el campo
// function Solo_Numerico(variable){
//    Numer=parseInt(variable);
//    if (isNaN(Numer)){
//        return "";
//    }
//    return Numer;
//}
//function ValNumero(Control){
//    Control.value=Solo_Numerico(Control.value);
//}

//function actualizarEstadoPresupuesto(IdPresupuesto,contacto_cliente,opcion){
//    //actualizamos la BBDD por ajax
//    $.ajax({
//      url: '../vista/ajax/actualizarEstadoPresupuesto.php?IdPresupuesto='+IdPresupuesto+'&opcion='+opcion,
//      type:"get"
//    });
//    //ahora aparecen los iconos de Total y Parcial si Estado=Aceptado y es cliente, en el resto de opciones los iconos no aparecen
//    if((opcion==='Aceptado') &&(contacto_cliente==='CL')){
//        var parcial='<a id="parcial'+IdPresupuesto+'" href="../vista/factura_presup_parcial.php?IdPresupuesto='+IdPresupuesto+'"><img src="../images/editcut.png" width="12" height="11" border="0"/></a>';
//        $('#tdparcial'+IdPresupuesto).append(parcial);
//        var total='<a id="total'+IdPresupuesto+'" href="../vista/factura_presup_total.php?IdPresupuesto='+IdPresupuesto+'"><img src="../images/folder_green.png" width="10" height="10" border="0"/></a>'; 
//        $('#tdtotal'+IdPresupuesto).append(total);
//    }else{
//        $('#parcial'+IdPresupuesto).remove();
//        $('#total'+IdPresupuesto).remove();
//    }
//}

function esContacto(IdPresupuesto){
    //visualizamos el presupuesto
    alert('Va a visualizar el presupuesto en modo consulta. Para poder facturarlo debe convertir el contacto en cliente.');
    document.location.href='../movil/factura_presup_parcial.php?IdPresupuesto='+IdPresupuesto;
}

function soloVer(IdPresupuesto){
    //visualizamos el presupuesto
    var opcion=confirm('El presupuesto no está Aceptado.\n Va a visualizar el presupuesto en modo consulta.\n\n¿Desea aceptarlo? (Aceptar=SI, Cancelar=NO)');
    
    if(opcion==true){
        $.ajax({
            url: '../vista/ajax/actualizarEstadoPresupuesto.php?IdPresupuesto='+IdPresupuesto+'&opcion=Aceptado',
            type:"get"
        });
        document.location.href='../movil/factura_presup_parcial.php?IdPresupuesto='+IdPresupuesto;
    }else{
        document.location.href='../movil/factura_presup_parcial.php?IdPresupuesto='+IdPresupuesto;
    }

    //NO FUNCIONA dialog    
//    $(function() {
//        $( "#dialog-confirm" ).dialog({
//            resizable: false,
//            height:160,
//            modal: true,
//            buttons: {
//            "Si": function() {
//                },
//            "No": function() {
//                }
//            }
//        });
//    });    
}

function irDiferencia(IdPresupuesto){
    //vamos a la factura diferencia
    alert('Este presupuesto tiene emitidas facturas. Se presentará la factura restante sobre el presupuesto.');
    document.location.href='../movil/factura_presup_diferencia.php?IdPresupuesto='+IdPresupuesto;
}

</script>

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>
        
    <div data-role="content" data-theme="a">
        <h3 align="center" color="#FFCC66"><font size="3px">Facturar Presupuestos</font></h3>
        <br/>
        <ul data-role="listview" data-dividertheme="a" data-filter="true" data-filter-placeHolder="Buscar">
            <?php
            $tipoContador=$clsCNContabilidad->Parametro_general('Tipo Contador',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));
            
            if(is_array($arResult)){
                for ($i = 0; $i < count($arResult); $i++) {
                    //presento los presupuestos no facturados o facturados parcialmente (GenFacPed=NO o Parcial)
                    //if($arResult[$i]['GenFacPed']==='NO' || $arResult[$i]['GenFacPed']==='Parcial'){
                    if($arResult[$i]['TotalFacturadaPedido']==='NO'){
                        $ejercicio=substr($arResult[$i]['NumPresupuesto'],0,4);
                        $numero=substr($arResult[$i]['NumPresupuesto'],4,4);

                        $numero4cifras=$numero;
                        while(substr($numero,0,1)==='0'){
                            $numero=substr($numero,1);
                        }

                        //ahora segun el tipo de contador presento el numero del presupuesto
                        $numeroPresupuesto = numeroDesformateado($arResult[$i]['NumPresupuesto'],$tipoContador);
//                        switch ($tipoContador) {
//                            case 'simple':
//                                $numeroPresupuesto=$numero;
//                                break;
//                            case 'compuesto1':
//                                $numeroPresupuesto=$numero.'/'.$ejercicio;
//                                break;
//                            case 'compuesto2':
//                                $numeroPresupuesto=$ejercicio.'/'.$numero;
//                                break;
//                            default://ningun contador
//                                $numeroPresupuesto=$numero;
//                                break;
//                        }

                        //preparo el importe en texto y sin decimales, y una cifra de 20 digitos, asi puedo ordenarlo bien por importe
                        $importeTxt=$arResult[$i]['totalImporte']*100;
                        while(strlen($importeTxt)<20){
                            $importeTxt='0'.$importeTxt;
                        }

                        //preparo el array de $arResult[$i] para enviar por url  
                        $contacto=explode('.',$arResult[$i]['Contacto_Cliente']);

                        //comprobamos que NO sea contacto o Estado=Aceptado (con una de estas dos condiciones desaparece el icono)
                        if($contacto[0]<>'CO'){
                            if($arResult[$i]['Estado']==='Aceptado'){
                                if($arResult[$i]['GenFacPed']==='NO'){
                                    //genera una factura de 0
                                    $link="javascript:document.location.href='../movil/facturar_presupuesto_detalle.php?IdPresupuesto=".$arResult[$i]['IdPresupuesto']."';";
                                }else{
                                    //existe ya facturas parciales emitidas anteriormente, generamos una factura diferenciade las anteriores
                                    $link="irDiferencia(".$arResult[$i]['IdPresupuesto'].");";
                                }
                            }else{
                                $link="soloVer(".$arResult[$i]['IdPresupuesto'].");";
                            }
                        }else{
                            $link="esContacto(".$arResult[$i]['IdPresupuesto'].");";
                        }
                        
                        
                        //$link="javascript:document.location.href='../movil/facturar_presupuesto_detalle.php?IdPresupuesto=".$arResult[$i]['IdPresupuesto']."';";
                    ?>
                    <li onClick="<?php echo $link; ?>">
                        <a href="#" data-ajax="false">
                        <?php echo '<font color="30a53b">Número: </font>'."<!-- ".$arResult[$i]['NumPresupuesto']." -->".$numeroPresupuesto. '   <font color="3ba5ba">'.$arResult[$i]['FechaPresupuesto'].'</font><br/>'; ?>
                        <?php echo '<font color="30a53b">Cliente/Contacto: </font><br/>'; ?>
                        <?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$arResult[$i]['nombreContacto'].'<br/>'; ?>
                        <?php echo '<font color="30a53b">Importe: </font>'."<!-- $importeTxt -->".formateaNumeroContabilidad($arResult[$i]['totalImporte']).'<br/>'; ?>
                        </a>
                    </li>
                    <?php
                    }
                }
            }
            ?>
        </ul>
    </div>            
            
    </div>

    <div data-role="page" id="dialogo">
        <div data-role="header" ><h1>dialogo de ejemplo</h1></div>
        <div data-role="content">
        Este es un cuadro de dialogo sencillo que esta dentro del mismo HTML del enlace
        <a href="#" data-role="button" data-rel="back">Aceptar</a>
        </div>
    </div>
        
        
    <script type="text/javascript" charset="utf-8">
    </script>
    </body>
</html>
