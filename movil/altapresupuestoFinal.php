<?php
session_start ();
require_once '../general/funcionesGenerales.php';

//esta pagina es de transicion para ir a altapresupuesto.php con los datos por post

//compruebo si venimos con la variable de sesion $_SESSION['presupuestoActivo']
//sino viniesemos nos redireccionamos a default2.php (main)
if(!isset($_SESSION['presupuestoActivo'])){
    //este presupuesto esta borrado por lo que volvemos al menu
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../movil/default2.php">';die;
}

$vble=$_SESSION['presupuestoActivo'];

//ahora hacemos un formulario virtual para poder pasar las vbles por post


?>
<!DOCTYPE html>
<html>
<head>
<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>
    <script language="JavaScript">
        function Enviar(){
            //actualizo el estado (para hacerlo igual que en version PC)
            $.ajax({
              url: '../vista/ajax/actualizarEstadoPresupuesto.php?IdPresupuesto=<?php echo $vble['IdPresupuesto'];?>&opcion=<?php echo $vble['Estado'];?>',
              type:"get"
            });
            
            document.form1.submit();
        }
    </script>    
</head>
<body onload="Enviar();">
    <form name="form1" method="post" action="../vista/altapresupuesto.php">
        <input type="hidden" name="numPresupuesto" value="<?php echo $vble['NumPresupuesto'];?>" />
        <input type="hidden" name="numPresupuestoBBDD" value="<?php echo $vble['NumPresupuestoBBDD'];?>" />
        <input type="hidden" name="fechaPresup" value="<?php echo $vble['FechaPresupuesto'];?>" />
        <input type="hidden" name="Cliente" value="<?php echo $vble['Cliente'];?>" />
        <input type="hidden" name="Contacto" value="<?php echo $vble['Contacto'];?>" />
        <input type="hidden" name="ContactoHidden" value="<?php echo $vble['ContactoHidden'];?>" />
        <input type="hidden" name="CIF" value="<?php echo $vble['CIF'];?>" />
        <input type="hidden" name="direccion" value="<?php echo $vble['direccion'];?>" />
        <input type="hidden" name="poblacion" value="<?php echo $vble['poblacion'];?>" />
        <input type="hidden" name="provincia" value="<?php echo $vble['provincia'];?>" />
        <?php
        $totalImporte=0;
        $totalCuota=0;
        //recorro todas las lineas del presupuesto
        for($i=0;$i<count($vble['DetallePresupuesto']);$i++){
            echo '<input type="hidden" name="IdPresupLinea'.($i+1).'" value="'.$vble['DetallePresupuesto'][$i]['IdPresupLineas'].'" />';
            echo '<input type="hidden" name="IdArticulo'.($i+1).'" value="'.$vble['DetallePresupuesto'][$i]['IdArticulo'].'" />';
            echo '<input type="hidden" name="cantidadHidden'.($i+1).'" value="'.$vble['DetallePresupuesto'][$i]['cantidad'].'" />';
            echo '<input type="hidden" name="cantidad'.($i+1).'" value="'.formateaNumeroContabilidad($vble['DetallePresupuesto'][$i]['cantidad']).'" />';
            echo '<input type="hidden" name="concepto'.($i+1).'" value="'.$vble['DetallePresupuesto'][$i]['concepto'].'" />';
            echo '<input type="hidden" name="precio'.($i+1).'" value="'.formateaNumeroContabilidad($vble['DetallePresupuesto'][$i]['precio']).'" />';
            echo '<input type="hidden" name="importe'.($i+1).'" value="'.formateaNumeroContabilidad($vble['DetallePresupuesto'][$i]['importe']).'" />';
            echo '<input type="hidden" name="iva'.($i+1).'" value="'.$vble['DetallePresupuesto'][$i]['iva'].'" />';
            echo '<input type="hidden" name="cuota'.($i+1).'" value="'.formateaNumeroContabilidad($vble['DetallePresupuesto'][$i]['cuota']).'" />';
            echo '<input type="hidden" name="total'.($i+1).'" value="'.formateaNumeroContabilidad($vble['DetallePresupuesto'][$i]['total']).'" />';
            $totalImporte=$totalImporte+$vble['DetallePresupuesto'][$i]['importe'];
            $totalCuota=$totalImporte+$vble['DetallePresupuesto'][$i]['cuota'];
        }
        ?>
        <input type="hidden" name="totalImporte" value="<?php echo formateaNumeroContabilidad($totalImporte);?>" />
        <input type="hidden" name="totalCuota" value="<?php echo formateaNumeroContabilidad($totalCuota);?>" />
        <input type="hidden" name="total" value="<?php echo formateaNumeroContabilidad($totalImporte+$totalCuota);?>" />
        <?php 
        $IRPFcuota = round(($totalImporte*$vble['irpf']/100),2);
        ?>
        <input type="hidden" name="IRPFcuota" value="<?php echo formateaNumeroContabilidad($IRPFcuota);?>" />
        <input type="hidden" name="FormaPagoHabitual" value="<?php echo $vble['FormaPagoHabitual'];?>" />
        <input type="hidden" name="validez" value="<?php echo $vble['validez'];?>" />
        <input type="hidden" name="Proforma" value="<?php echo $vble['Proforma'];?>" />
        <input type="hidden" name="linea" value="<?php echo count($vble['DetallePresupuesto']);?>" />
        <input type="hidden" name="esValido" value="SI" /><!-- REVISAR  -->
        <?php if($vble['IdPresupuesto']===''){
            echo '<input type="hidden" name="IdPresupuesto" value="Nuevo" />';
        }else{
            echo '<input type="hidden" name="IdPresupuesto" value="'.$vble['IdPresupuesto'].'" />';
        }
        ?>
        <input type="hidden" name="SePuedeImprimir" value="SI" />
        <input type="hidden" name="irpf" value="<?php echo $vble['irpf'];?>" />
        <input type="hidden" name="pant" value="<?php echo $_GET['pant'];?>" />
        
        
        
        
    </form>
</body>
</html>
