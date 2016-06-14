<?php
session_start ();
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

$clsCNContabilidad=new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['dbContabilidad']);
$clsCNContabilidad->setStrBDCliente($_SESSION['mapeo']);

//veo si puedo o no imprimir logo en documento PDF
//$logo=$clsCNContabilidad->Parametro_general('Logo en Documentos',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));



//codigo principal
if(isset($_GET['IdPresupuesto'])){
    logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
       " ||||Mis Presupuestos->Convertir a Pedido (Total)||");

    //extraigo los datos del presupuesto
    $datos=$clsCNContabilidad->datosPresupuesto($_GET['IdPresupuesto']);
    
    //ahora formateo estos datos para que los entienda la funcion 'generarPedidoDePresupuesto'
    //(esta función recoje los datos de un POST de un formulario)
    
    $datosFormateados=array(
        "NumPresupuesto"=>$datos['NumPresupuesto'],
        "NumPresupuestoBBDD"=>$datos['NumPresupuestoBBDD'],
        "ContactoHidden"=>$datos['Contacto_Cliente'],
        "irpf"=>$datos['Retencion'],
        "FormaPagoHabitual"=>$datos['FormaPago'],
        "FechaPedido"=>date('d/m/Y'),
        "FechaVtoPedido"=>'',
        "FechaFinalizacion"=>'',
        "TipoFactura"=>'Periodica',
        "DiaPeriodica"=>date('d'),
        "FrecuenciaPeriodica"=>'Mensual',
        "FechaProximaFacturaPeriodica"=>date('d/m/Y'),
        "CC_Recibos"=>'',
        "CIF"=>$datos['CIFEmpresa'],
        "direccion"=>$datos['DireccionEmpresa'],
        "poblacion"=>$datos['PoblacionEmpresa'],
        "provincia"=>$datos['ProvinciaEmpresa'],
        "validez"=>$datos['Validez'],
    );

    //sumas de importe y cuota
    $sumaImporte=0;
    $sumaCuota=0;
    
    //ahora añado las lineas del presupuesto y voy haciendo las sumas de importe y cuotaIva
    foreach($datos['DetallePresupuesto'] as $propiedad=>$valor){
        $numero=$propiedad+1;
        $datosFormateados['check'.$numero]='on';
        $datosFormateados['idPresupLinea'.$numero]=$valor['IdPresupLineas'];
        $datosFormateados['IdArticulo'.$numero]=$valor['IdArticulo'];
        $datosFormateados['cantidad'.$numero]=  formateaNumeroContabilidad($valor['cantidad']);
        $datosFormateados['concepto'.$numero]=$valor['concepto'];
        $datosFormateados['precio'.$numero]=formateaNumeroContabilidad($valor['precio']);
        $datosFormateados['importe'.$numero]=formateaNumeroContabilidad($valor['importe']);
        $datosFormateados['iva'.$numero]=$valor['iva'];
        $datosFormateados['cuota'.$numero]=formateaNumeroContabilidad($valor['cuota']);
        $datosFormateados['total'.$numero]=formateaNumeroContabilidad($valor['total']);
        
        $sumaImporte=$sumaImporte+$valor['importe'];
        $sumaCuota=$sumaCuota+$valor['cuota'];
    }
    
    //los totales
    $total=$sumaImporte+$sumaCuota;
    $IRPFCuota=round(($sumaImporte+$sumaCuota)*$datos['Retencion']/100,2);
    $datosFormateados['totalImporte']=formateaNumeroContabilidad($sumaImporte);
    $datosFormateados['totalCuota']=formateaNumeroContabilidad($sumaCuota);
    $datosFormateados['total']=formateaNumeroContabilidad($total);
    $datosFormateados['IRPFcuota']=formateaNumeroContabilidad($IRPFCuota);
    $datosFormateados['totalFinal']=formateaNumeroContabilidad($total-$IRPFCuota);
    $datosFormateados['IdPresupuesto']=$_GET['IdPresupuesto'];    
    
    //por último ejecuto la función 'generarPedidoDePresupuesto' con los datos formateados
    $IdPedido=$clsCNContabilidad->generarPedidoDePresupuesto($_SESSION['usuario'],$datosFormateados);
    
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/altapedido.php?IdPedido='.$IdPedido.'">';die;
}
?>
