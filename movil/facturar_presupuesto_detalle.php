<?php
session_start();
require_once '../CN/clsCNContabilidad.php';
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


function listadoEstados($opcion,$IdPresupuesto,$contacto_cliente){
?>
<select name="estadoNuevo" data-native-menu="false" data-theme='a' data-mini="true" 
        onchange="actualizarEstadoPresupuesto(<?php echo $IdPresupuesto; ?>,'<?php echo $contacto_cliente; ?>',this.value);">
    <option value="Pendiente" <?php if($opcion==='Pendiente'){echo 'selected';}?>>Pendiente</option>
    <option value="Aceptado" <?php if($opcion==='Aceptado'){echo 'selected';}?>>Aceptado</option>
    <option value="Rechazado" <?php if($opcion==='Rechazado'){echo 'selected';}?>>Rechazado</option>
    <option value="Cancelado" <?php if($opcion==='Cancelado'){echo 'selected';}?>>Cancelado</option>
</select>
<?php
}


//compruebo si viene de submitirse este formulario y es editar
if(isset($_POST['opcion']) && $_POST['opcion']==='Nuevo'){

    
    
    //ahora volvemos a la pagina de altapresupuestoLineas
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../movil/altapresupuestoLineas.php">';die;
}else

//compruebo si viene de submitirse este formulario y es editar
if(isset($_POST['opcion']) && $_POST['opcion']==='Editar'){

    
    
    //ahora volvemos a la pagina de altapresupuestoLineas
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../movil/altapresupuestoLineas.php">';die;
}else
    
//compruebo si viene de submitirse este formulario y es borrar
if(isset($_POST['opcion']) && $_POST['opcion']==='Borrar'){
    //borro de la vble de session esta linea (concepto) (borro y reordeno el array)
    array_splice($_SESSION['presupuestoActivo']['DetallePresupuesto'],$_POST['IdLinea'],1);
    $_SESSION['presupuestoActivo']['SePuedeImprimir']='NO';
    
    //ahora volvemos a la pagina de altapresupuestoLineas
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../movil/altapresupuestoLineas.php">';die;
}else{
    //vengo de facturar presupuesto
    //primero listo todos los presupuesto(ya tengo la funcion hecha
    require_once '../CN/clsCNContabilidad.php';
    $clsCNContabilidad=new clsCNContabilidad();
    $clsCNContabilidad->setStrBD($_SESSION['dbContabilidad']);
    $clsCNContabilidad->setStrBDCliente($_SESSION['mapeo']);
    $arResult=$clsCNContabilidad->ListadoPresupuestos('','');
    
    //ahora busco el IdPresupuesto y guardolos datos
    $datosPresupuesto='';
    if(is_array($arResult)){
        for ($j = 0; $j < count($arResult); $j++) {
            if($arResult[$j]['IdPresupuesto']===$_GET['IdPresupuesto']){
                $i=$j;
                break;
            }
        }
    }
    
    //compruebo si no esta borrado el presupuesto
    if($arResult[$i]['Borrado']==='0'){
        //este presupuesto está borrado, redireccionamos al main
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../movil/default2.php">';die;
    }
    
}

$tipoContador=$clsCNContabilidad->Parametro_general('Tipo Contador',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));

$ejercicio=substr($arResult[$i]['NumPresupuesto'],0,4);
$numero=substr($arResult[$i]['NumPresupuesto'],4,4);

$numero4cifras=$numero;
while(substr($numero,0,1)==='0'){
    $numero=substr($numero,1);
}

//ahora segun el tipo de contador presento el numero del presupuesto
$numeroPresupuesto='';
switch ($tipoContador) {
    case 'simple':
        $numeroPresupuesto=$numero;
        break;
    case 'compuesto1':
        $numeroPresupuesto=$numero.'/'.$ejercicio;
        break;
    case 'compuesto2':
        $numeroPresupuesto=$ejercicio.'/'.$numero;
        break;
    default://ningun contador
        $numeroPresupuesto=$numero;
        break;
}

//preparo el array de $arResult[$i] para enviar por url  
$contacto=explode('.',$arResult[$i]['Contacto_Cliente']);




?>
<!DOCTYPE html>
<html>
<head>
<TITLE>Facturar Presupuesto <?php echo $numeroPresupuesto;?></TITLE>

<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>

</head> 
    <body>
    <div data-role="page" id="facturar_presupuesto_detalle">
<?php
eventosInputText();
?>
<script language="JavaScript">
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

function actualizarEstadoPresupuesto(IdPresupuesto,contacto_cliente,opcion){
    //actualizamos la BBDD por ajax
    $.ajax({
      url: '../vista/ajax/actualizarEstadoPresupuesto.php?IdPresupuesto='+IdPresupuesto+'&opcion='+opcion,
      type:"get"
    });
    //ahora aparecen los iconos de Total y Parcial si Estado=Aceptado y es cliente, en el resto de opciones los iconos no aparecen
    if((opcion==='Aceptado') &&(contacto_cliente==='CL')){
        var parcial='<label>Parcial</label><br/><a id="parcial'+IdPresupuesto+'" href="../movil/factura_presup_parcial.php?IdPresupuesto='+IdPresupuesto+'"><img src="../images/editcut.png" width="40" height="40" border="0"/></a>';
        $('#tdparcial'+IdPresupuesto).append(parcial);
        var total='<label>Total</label><br/><a id="total'+IdPresupuesto+'" href="../movil/factura_presup_total.php?IdPresupuesto='+IdPresupuesto+'"><img src="../images/folder_green.png" width="40" height="40" border="0"/></a>'; 
        $('#tdtotal'+IdPresupuesto).append(total);
    }else{
        $('#tdparcial'+IdPresupuesto).text('');
        $('#tdtotal'+IdPresupuesto).text('');
    }
}

function esContacto(IdPresupuesto){
    //visualizamos el presupuesto
    alert('Va a visualizar el presupuesto en modo consulta. Para poder facturarlo debe convertir el contacto en cliente.');
    document.location.href='../vista/factura_presup_parcial.php?IdPresupuesto='+IdPresupuesto;
}

function soloVer(IdPresupuesto){
    //visualizamos el presupuesto
//    var opcion=confirm('El presupuesto no está Aceptado.\n Va a visualizar el presupuesto en modo consulta.\n\n¿Desea aceptarlo?');
    
    $(function() {
        $( "#dialog-confirm" ).dialog({
            resizable: false,
            height:160,
            modal: true,
            buttons: {
            "Si": function() {
//                actualizarEstadoPresupuesto(IdPresupuesto,contacto_cliente,'Aceptado');
                $.ajax({
                  url: '../vista/ajax/actualizarEstadoPresupuesto.php?IdPresupuesto='+IdPresupuesto+'&opcion=Aceptado',
                  type:"get"
                });
                document.location.href='../vista/factura_presup_parcial.php?IdPresupuesto='+IdPresupuesto;
                },
            "No": function() {
                document.location.href='../vista/factura_presup_parcial.php?IdPresupuesto='+IdPresupuesto;
                }
            }
        });
    });    
}

function irDiferencia(IdPresupuesto){
    //vamos a la factura diferencia
    alert('Este presupuesto tiene emitidas facturas. Se presentará la factura restante sobre el presupuesto.');
    document.location.href='../vista/factura_presup_diferencia.php?IdPresupuesto='+IdPresupuesto;
}

</script>

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>

    <div data-role="content" data-theme="a">
        <form name="form1" method="post" action="../movil/facturar_presupuesto_detalle.php"  data-ajax="false">
        
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
                        <label><b>Facturar Presupuesto <?php echo $numeroPresupuesto;?></b></label>
                    </td>
                </tr>
                <tr>
                    <td height="15px"></td>
                </tr>                
                <tr>
                    <td colspan="2">
                        <div align="center"><label>Estado</label></div>
                    </td>
                    <td colspan="2">
                        <?php 
                        if($contacto[0]==='CO'){
                            echo '<div align="center"><label>Pasar a Cliente</label></div>';
                        }
                        ?>    
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <?php
                        if($arResult[$i]['GenFacPed']==='NO'){
                            listadoEstados($arResult[$i]['Estado'],$arResult[$i]['IdPresupuesto'],$contacto[0]);
                        }else{
                            echo $arResult[$i]['Estado'];
                        }
                        ?>
                    </td>
                    <td colspan="2">
                        <?php
                        if($contacto[0]==='CO'){
                            echo '<div align="center"><a href="../movil/altacontacto.php?IdContacto='.$contacto[1] . '" title="Pasar a Cliente" data-ajax="false"><img src="../images/kdmconfig.png" width="40" height="40" border="0"/></a></div>';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td height="15px"></td>
                </tr>                
                <tr>
                    <td colspan="2" id="tdparcial<?php echo $arResult[$i]['IdPresupuesto']; ?>" align="center">
                        <?php
                        //comprobamos que NO sea contacto o Estado=Aceptado (con una de estas dos condiciones desaparece el icono)
                        if(($contacto[0]<>'CO') && ($arResult[$i]['Estado']==='Aceptado')){
                            echo '<label>Parcial</label><br/>';
                            echo '<a id="parcial'.$arResult[$i]['IdPresupuesto'].'" href="../movil/factura_presup_parcial.php?IdPresupuesto='.$arResult[$i]['IdPresupuesto'] . '" data-ajax="false"><img src="../images/editcut.png" width="40" height="40" border="0"/></a>';
                        }
                        ?>
                    </td>
                    <td colspan="2" id="tdtotal<?php echo $arResult[$i]['IdPresupuesto']; ?>" align="center">
                        <?php 
                        if(($contacto[0]<>'CO') && ($arResult[$i]['Estado']==='Aceptado')){
                            echo '<label>Total</label><br/>';
                            echo '<a id="total'.$arResult[$i]['IdPresupuesto'].'" href="../vista/factura_presup_total.php?IdPresupuesto='.$arResult[$i]['IdPresupuesto'] . '" data-ajax="false"><img src="../images/folder_green.png" width="40" height="40" border="0"/></a>'; 
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td height="30px"></td>
                </tr>                
                <tr>
                    <td></td>
                    <td colspan="2">
                        <input type="button" data-icon="back" value = "Volver" data-mini="true"
                               onclick="javascript:history.back();" data-theme="a" />
                    </td>
                </tr>
            </tbody>
        </table>    
        <input type="hidden" name="opcion" value = "" />
        <input type="hidden" name="esValido" value = "true" />
        <input type="hidden" name="IdLinea" value = "<?php echo $linea; ?>" />
        
        <input type="hidden" name="SePuedeImprimir" 
               value = "<?php if(isset($_SESSION['presupuestoActivo'])){echo $_SESSION['presupuestoActivo']['SePuedeImprimir'];} ?>" />

        
        
    </form>
    </div>

    </div>    
    </body>
</html>
