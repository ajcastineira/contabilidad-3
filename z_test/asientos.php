<?php

/* 
 * Probar como se guardan los tipos de asientos
 */

/* se escribe en consola: php asientos.php  */


/*  Indice   */

//0 Gastos
//TIPOASIENTO |    TIPO    |  FACTURA  |  IVA  |  IRPF  |  CUENTAS
//-------------------------------------------------------------------
//    00N     |  Gasto     |    No     |    No    |   No   |    1
//    01N     |  Gasto     |    Si     |     1    |   No   |    1
//    02N     |  Gasto     |    Si     |     1    |   Si   |    1
//    03N     |  Gasto     |    Si     |  Varios  |   No   |    1
//    04N     |  Gasto     |    Si     |  Varios  |   Si   |    1
//    05N     |  Gasto     |    Si     |     1    |   No   |  Varias
//    06N     |  Gasto     |    Si     |     1    |   Si   |  Varias
//    07N     |  Gasto     |    Si     |  Varios  |   No   |  Varias
//    08N     |  Gasto     |    Si     |  Varios  |   Si   |  Varias
//-------------------------------------------------------------------


//1 Ingresos
//
//    10N     |  Ingreso   |    No     |    No    |   No   |    1
//    11N     |  Ingreso   |    Si     |     1    |   No   |    1
//    12N     |  Ingreso   |    Si     |     1    |   Si   |    1
//    13N     |  Ingreso   |    Si     |  Varios  |   No   |    1
//    14N     |  Ingreso   |    Si     |  Varios  |   Si   |    1
//    15N     |  Ingreso   |    Si     |     1    |   No   |  Varias
//    16N     |  Ingreso   |    Si     |     1    |   Si   |  Varias
//    17N     |  Ingreso   |    Si     |  Varios  |   No   |  Varias
//    18N     |  Ingreso   |    Si     |  Varios  |   Si   |  Varias


//2 Mis Movimientos


//3 Nominas



/* Desarrollo  */
//variables de SESSION
$_SESSION['mapeo'] = 'conexion3.php';
$_SESSION['strUsuario'] = 'amartin';
$_SESSION['usuario'] = '17';
$_SESSION['strBD'] = 'qq';
$_SESSION['dbContabilidad'] = 'c-dbContabilidad';
$_SESSION['idEmp'] = '1';


function borrar_tablas(){
    require_once '../general/'.$_SESSION['mapeo'];
    $db = new Db();
    $db->conectar('');
        
//    require_once '../CN/clsCNContabilidad.php';
//    $clsCNContabilidad=new clsCNContabilidad();
//    $clsCNContabilidad->setStrBD($_SESSION['mapeo']);


    $strSQL="TRUNCATE tbacumulados";
    $stmt = $db->ejecutar ( $strSQL );

    $strSQL="TRUNCATE tbmisfacturas";
    $stmt = $db->ejecutar ( $strSQL );
    
    $strSQL="TRUNCATE tbmisfacturaslineas";
    $stmt = $db->ejecutar ( $strSQL );
    
    $strSQL="TRUNCATE tbmovimientos";
    $stmt = $db->ejecutar ( $strSQL );
    
    $strSQL="TRUNCATE tbmovimientos_iva";
    $stmt = $db->ejecutar ( $strSQL );
    
    $strSQL="TRUNCATE tbretenciones_irpf";
    $stmt = $db->ejecutar ( $strSQL );
    
    
    $db->desconectar ();
}


function gastos_00(){
    echo "Gastos: Asiento Tipo 00:\n========================\n";
    
    require_once '../CN/clsCNContabilidad.php';
    $clsCNContabilidad=new clsCNContabilidad();
    $clsCNContabilidad->setStrBD($_SESSION['mapeo']);
    
    //datos
    $_POST['strCuenta'] = "623000000 - Asesorías";
    $_POST['lngIngreso'] = "4789.51";
    $_POST['strCuentaCli'] = "400000002 - BCTS Spain, S.L.";
    $_POST['lngCantidad'] = "4789.51";
    $_POST['datFecha'] = "26/06/2016";
    $_POST['optTipo'] = "0";
    $_POST['strCuentaBancos'] = null;
    $_POST['lngPeriodo'] = "6";
    $_POST['lngEjercicio'] = "2016";
    $_POST['strConcepto'] = "concepto";
    $_POST['esAbono'] = "NO";
    
    
    $varRes = $clsCNContabilidad->AltaGastosMovimientosSinIVA(0,$_SESSION["idEmp"], $_POST['strCuenta'], $_POST["lngIngreso"],
                                     $_POST['strCuentaCli'], $_POST["lngCantidad"], $_POST["datFecha"],$_POST['optTipo'], $_POST['strCuentaBancos'],
                                     $_POST["lngPeriodo"], $_POST["lngEjercicio"], addslashes($_POST["strConcepto"]),$_POST['esAbono'], $_SESSION["strUsuario"]);   
    
    
    //ahora se comprueba los datos insertados si son los correctos
    $datos = $clsCNContabilidad->DatosAsientoSF($varRes,$_POST['esAbono']);
    
    //comparamos
    $datosCorrectos = '';


    if($datos['strCuenta'] !== $_POST['strCuenta']){
        $datosCorrectos['strCuenta'] = 'NO';
    }else{
        $datosCorrectos['strCuenta'] = 'SI';
    }
    echo "-Cuenta: Entrada - " . $_POST['strCuenta'] . " , Salida - " . $datos['strCuenta'] . " ::Correcto?: " . $datosCorrectos['strCuenta'] . "\n";
    
    if($datos['lngIngreso'] !== $_POST['lngIngreso']){
        $datosCorrectos['lngIngreso'] = 'NO';
    }else{
        $datosCorrectos['lngIngreso'] = 'SI';
    }
    echo "-Ingreso: Entrada - " . $_POST['lngIngreso'] . " , Salida - " . $datos['lngIngreso'] . " ::Correcto?: " . $datosCorrectos['lngIngreso'] . "\n";
    
    if($datos['strCuentaCli'] !== $_POST['strCuentaCli']){
        $datosCorrectos['strCuentaCli'] = 'NO';
    }else{
        $datosCorrectos['strCuentaCli'] = 'SI';
    }
    echo "-Cuenta Cliente: Entrada - " . $_POST['strCuentaCli'] . " , Salida - " . $datos['strCuentaCli'] . " ::Correcto?: " . $datosCorrectos['strCuentaCli'] . "\n";
    
    if($datos['lngCantidad'] !== $_POST['lngCantidad']){
        $datosCorrectos['lngCantidad'] = 'NO';
    }else{
        $datosCorrectos['lngCantidad'] = 'SI';
    }
    echo "-Cantidad: Entrada - " . $_POST['lngCantidad'] . " , Salida - " . $datos['lngCantidad'] . " ::Correcto?: " . $datosCorrectos['lngCantidad'] . "\n";
    
    if($datos['datFecha'] !== $_POST['datFecha']){
        $datosCorrectos['datFecha'] = 'NO';
    }else{
        $datosCorrectos['datFecha'] = 'SI';
    }
    echo "-Fecha: Entrada - " . $_POST['datFecha'] . " , Salida - " . $datos['datFecha'] . " ::Correcto?: " . $datosCorrectos['datFecha'] . "\n";
    
    if($datos['lngPeriodo'] !== $_POST['lngPeriodo']){
        $datosCorrectos['lngPeriodo'] = 'NO';
    }else{
        $datosCorrectos['lngPeriodo'] = 'SI';
    }
    echo "-Periodo: Entrada - " . $_POST['lngPeriodo'] . " , Salida - " . $datos['lngPeriodo'] . " ::Correcto?: " . $datosCorrectos['lngPeriodo'] . "\n";
    
    if($datos['lngEjercicio'] !== $_POST['lngEjercicio']){
        $datosCorrectos['lngEjercicio'] = 'NO';
    }else{
        $datosCorrectos['lngEjercicio'] = 'SI';
    }
    echo "-Ejercicio: Entrada - " . $_POST['lngEjercicio'] . " , Salida - " . $datos['lngEjercicio'] . " ::Correcto?: " . $datosCorrectos['lngEjercicio'] . "\n";

    if($datos['strConcepto'] !== $_POST['strConcepto']){
        $datosCorrectos['strConcepto'] = 'NO';
    }else{
        $datosCorrectos['strConcepto'] = 'SI';
    }
    echo "-Concepto: Entrada - " . $_POST['strConcepto'] . " , Salida - " . $datos['strConcepto'] . " ::Correcto?: " . $datosCorrectos['strConcepto'] . "\n";
    
    
    $correcto = 'SI';
    foreach ($datosCorrectos as $value) {
        if($value === 'NO'){
            $correcto = 'NO';
            break;
        }
    }
    
    
    echo "--------------------------------------------\nAsiento Tipo 00: Insertado correctamente?:" . $correcto . "\n--------------------------------------------\n\n";

}



function gastos_01(){
    echo "Gastos: Asiento Tipo 01:\n========================\n";
    
    require_once '../CN/clsCNContabilidad.php';
    $clsCNContabilidad=new clsCNContabilidad();
    $clsCNContabilidad->setStrBD($_SESSION['mapeo']);
    
    //datos
    $_POST['strCuenta'] = "624100000 - Locomoción";
    $_POST['lngIngreso'] = "6336.09";
    $_POST['strCuentaCli'] = "400000003 - Davanti Limpieza en Seco, S.L.";
    $_POST['lngCantidad'] = "5236.44";
    $_POST['lngIva'] = "1099.65";
    $_POST['lngPorcientoSin'] = "21";
    $_POST['datFecha'] = "26/06/2016";
    $_POST['optTipo'] = "0";
    $_POST['strCuentaBancos'] = null;
    $_POST['lngPeriodo'] = "6";
    $_POST['lngEjercicio'] = "2016";
    $_POST['strConcepto'] = "concepto";
    $_POST['esAbono'] = "NO";
    
    
    
    $varRes = $clsCNContabilidad->AltaGastosMovimientos(0,$_SESSION["idEmp"],$_POST['strCuenta'], $_POST["lngIngreso"],
                                        $_POST['strCuentaCli'], $_POST["lngCantidad"],$_POST["lngIva"],$_POST["lngPorcientoSin"], $_POST["datFecha"],$_POST['optTipo'],
                                        $_POST['strCuentaBancos'],$_POST["lngPeriodo"], $_POST["lngEjercicio"], addslashes($_POST["strConcepto"]), $_POST['esAbono'], $_SESSION["strUsuario"]);   
    
    
    //ahora se comprueba los datos insertados si son los correctos
    $datos = $clsCNContabilidad->DatosAsientoCFIVA1SIRPF($varRes,$_POST['esAbono']);
    
    //comparamos
    $datosCorrectos = '';
    
    if($datos['strCuenta'] !== $_POST['strCuenta']){
        $datosCorrectos['strCuenta'] = 'NO';
    }else{
        $datosCorrectos['strCuenta'] = 'SI';
    }
    echo "-Cuenta: Entrada - " . $_POST['strCuenta'] . " , Salida - " . $datos['strCuenta'] . " ::Correcto?: " . $datosCorrectos['strCuenta'] . "\n";
    
    if($datos['lngIngreso'] !== $_POST['lngIngreso']){
        $datosCorrectos['lngIngreso'] = 'NO';
    }else{
        $datosCorrectos['lngIngreso'] = 'SI';
    }
    echo "-Ingreso: Entrada - " . $_POST['lngIngreso'] . " , Salida - " . $datos['lngIngreso'] . " ::Correcto?: " . $datosCorrectos['lngIngreso'] . "\n";
    
    if($datos['strCuentaCli'] !== $_POST['strCuentaCli']){
        $datosCorrectos['strCuentaCli'] = 'NO';
    }else{
        $datosCorrectos['strCuentaCli'] = 'SI';
    }
    echo "-Cuenta Cliente: Entrada - " . $_POST['strCuentaCli'] . " , Salida - " . $datos['strCuentaCli'] . " ::Correcto?: " . $datosCorrectos['strCuentaCli'] . "\n";
    
    if($datos['lngCantidad'] !== $_POST['lngCantidad']){
        $datosCorrectos['lngCantidad'] = 'NO';
    }else{
        $datosCorrectos['lngCantidad'] = 'SI';
    }
    echo "-Cantidad: Entrada - " . $_POST['lngCantidad'] . " , Salida - " . $datos['lngCantidad'] . " ::Correcto?: " . $datosCorrectos['lngCantidad'] . "\n";
    
    if((String)$datos['lngIva'] !== $_POST['lngIva']){
        $datosCorrectos['lngIva'] = 'NO';
    }else{
        $datosCorrectos['lngIva'] = 'SI';
    }
    echo "-Cuota IVA: Entrada - " . $_POST['lngIva'] . " , Salida - " . $datos['lngIva'] . " ::Correcto?: " . $datosCorrectos['lngIva'] . "\n";
    
    if($datos['lngPorcientoSin'] !== $_POST['lngPorcientoSin']){
        $datosCorrectos['lngPorcientoSin'] = 'NO';
    }else{
        $datosCorrectos['lngPorcientoSin'] = 'SI';
    }
    echo "-% Porciento: Entrada - " . $_POST['lngPorcientoSin'] . " , Salida - " . $datos['lngPorcientoSin'] . " ::Correcto?: " . $datosCorrectos['lngPorcientoSin'] . "\n";
    
    if($datos['datFecha'] !== $_POST['datFecha']){
        $datosCorrectos['datFecha'] = 'NO';
    }else{
        $datosCorrectos['datFecha'] = 'SI';
    }
    echo "-Fecha: Entrada - " . $_POST['datFecha'] . " , Salida - " . $datos['datFecha'] . " ::Correcto?: " . $datosCorrectos['datFecha'] . "\n";
    
    if($datos['lngPeriodo'] !== $_POST['lngPeriodo']){
        $datosCorrectos['lngPeriodo'] = 'NO';
    }else{
        $datosCorrectos['lngPeriodo'] = 'SI';
    }
    echo "-Periodo: Entrada - " . $_POST['lngPeriodo'] . " , Salida - " . $datos['lngPeriodo'] . " ::Correcto?: " . $datosCorrectos['lngPeriodo'] . "\n";
    
    if($datos['lngEjercicio'] !== $_POST['lngEjercicio']){
        $datosCorrectos['lngEjercicio'] = 'NO';
    }else{
        $datosCorrectos['lngEjercicio'] = 'SI';
    }
    echo "-Ejercicio: Entrada - " . $_POST['lngEjercicio'] . " , Salida - " . $datos['lngEjercicio'] . " ::Correcto?: " . $datosCorrectos['lngEjercicio'] . "\n";

    if($datos['strConcepto'] !== $_POST['strConcepto']){
        $datosCorrectos['strConcepto'] = 'NO';
    }else{
        $datosCorrectos['strConcepto'] = 'SI';
    }
    echo "-Concepto: Entrada - " . $_POST['strConcepto'] . " , Salida - " . $datos['strConcepto'] . " ::Correcto?: " . $datosCorrectos['strConcepto'] . "\n";
    
    
    $correcto = 'SI';
    foreach ($datosCorrectos as $value) {
        if($value === 'NO'){
            $correcto = 'NO';
            break;
        }
    }
    
    
    echo "--------------------------------------------\nAsiento Tipo 01: Insertado correctamente?:" . $correcto . "\n--------------------------------------------\n\n";


    
    //var_dump($datos);die;
}


function gastos_03(){
    echo "Gastos: Asiento Tipo 03:\n========================\n";
    
    require_once '../CN/clsCNContabilidad.php';
    $clsCNContabilidad=new clsCNContabilidad();
    $clsCNContabilidad->setStrBD($_SESSION['mapeo']);
    
    //datos
    $_POST['strCuenta'] = "624000000 - Transportes";
    $_POST["Total"] = "4625.59";
    $_POST['strCuentaCli'] = "400000005 - Orizonia Destination Management S.L.";
    $_POST["lngCantidadTotal"] = "4178.46";
    $_POST["lngIvaTotal"] = "447.13";
    $_POST["datFecha"] = "05/07/2016";
    $_POST['optTipo'] = "0";
    $_POST['strCuentaBancos'] = null;
    $_POST["lngPeriodo"] = "7";
    $_POST["lngEjercicio"] = "2016";
    $_POST["strConcepto"] = "concepto";
    $_POST['lngCantidad1'] = "1523.44";
    $_POST['lngIva1'] = "319.92";
    $_POST['lngPorciento1'] = "21";
    $_POST['lngCantidad2'] = "956.44";
    $_POST['lngIva2'] = "95.64";
    $_POST['lngPorciento2'] = "10";
    $_POST['lngCantidad3'] = "789.14";
    $_POST['lngIva3'] = "31.57";
    $_POST['lngPorciento3'] = "4";
    $_POST['lngCantidad4'] = "909.44";
    $_POST['lngIva4'] = "0";
    $_POST['lngPorciento4'] = "0";
    $_POST['esAbono'] = "NO";
    
    
    $varRes = $clsCNContabilidad->AltaGastosMovimientosIVA_Varios(0,$_SESSION["idEmp"],$_POST['strCuenta'], $_POST["Total"],
                                            $_POST['strCuentaCli'], $_POST["lngCantidadTotal"],$_POST["lngIvaTotal"], $_POST["datFecha"],$_POST['optTipo'],
                                            $_POST['strCuentaBancos'],$_POST["lngPeriodo"], $_POST["lngEjercicio"], addslashes($_POST["strConcepto"]), $_SESSION["strUsuario"],
                                            $_POST['lngCantidad1'],$_POST['lngIva1'],$_POST['lngPorciento1'],
                                            $_POST['lngCantidad2'],$_POST['lngIva2'],$_POST['lngPorciento2'],
                                            $_POST['lngCantidad3'],$_POST['lngIva3'],$_POST['lngPorciento3'],
                                            $_POST['lngCantidad4'],$_POST['lngIva4'],$_POST['lngPorciento4'], $_POST['esAbono']);   
    
    
    
    //ahora se comprueba los datos insertados si son los correctos
    $datos = $clsCNContabilidad->DatosAsientoCFIVAV($varRes,$_POST['esAbono']);
    
    //comparamos
    $datosCorrectos = '';
    
    
    if($datos['strCuenta'] !== $_POST['strCuenta']){
        $datosCorrectos['strCuenta'] = 'NO';
    }else{
        $datosCorrectos['strCuenta'] = 'SI';
    }
    echo "-Cuenta: Entrada - " . $_POST['strCuenta'] . " , Salida - " . $datos['strCuenta'] . " ::Correcto?: " . $datosCorrectos['strCuenta'] . "\n";
    
    if($datos['Total'] !== $_POST['Total']){
        $datosCorrectos['Total'] = 'NO';
    }else{
        $datosCorrectos['Total'] = 'SI';
    }
    echo "-Total: Entrada - " . $_POST['Total'] . " , Salida - " . $datos['Total'] . " ::Correcto?: " . $datosCorrectos['Total'] . "\n";
    
    if($datos['strCuentaCli'] !== $_POST['strCuentaCli']){
        $datosCorrectos['strCuentaCli'] = 'NO';
    }else{
        $datosCorrectos['strCuentaCli'] = 'SI';
    }
    echo "-Cuenta Cliente: Entrada - " . $_POST['strCuentaCli'] . " , Salida - " . $datos['strCuentaCli'] . " ::Correcto?: " . $datosCorrectos['strCuentaCli'] . "\n";

    if($datos['lngCantidadTotal'] !== $_POST['lngCantidadTotal']){
        $datosCorrectos['lngCantidadTotal'] = 'NO';
    }else{
        $datosCorrectos['lngCantidadTotal'] = 'SI';
    }
    echo "-Cantidad total: Entrada - " . $_POST['lngCantidadTotal'] . " , Salida - " . $datos['lngCantidadTotal'] . " ::Correcto?: " . $datosCorrectos['lngCantidadTotal'] . "\n";

    if($datos['lngIvaTotal'] !== $_POST['lngIvaTotal']){
        $datosCorrectos['lngIvaTotal'] = 'NO';
    }else{
        $datosCorrectos['lngIvaTotal'] = 'SI';
    }
    echo "-Cuota IVA total: Entrada - " . $_POST['lngIvaTotal'] . " , Salida - " . $datos['lngIvaTotal'] . " ::Correcto?: " . $datosCorrectos['lngIvaTotal'] . "\n";
    
    if($datos['datFecha'] !== $_POST['datFecha']){
        $datosCorrectos['datFecha'] = 'NO';
    }else{
        $datosCorrectos['datFecha'] = 'SI';
    }
    echo "-Fecha: Entrada - " . $_POST['datFecha'] . " , Salida - " . $datos['datFecha'] . " ::Correcto?: " . $datosCorrectos['datFecha'] . "\n";
    
    if($datos['lngPeriodo'] !== $_POST['lngPeriodo']){
        $datosCorrectos['lngPeriodo'] = 'NO';
    }else{
        $datosCorrectos['lngPeriodo'] = 'SI';
    }
    echo "-Periodo: Entrada - " . $_POST['lngPeriodo'] . " , Salida - " . $datos['lngPeriodo'] . " ::Correcto?: " . $datosCorrectos['lngPeriodo'] . "\n";
    
    if($datos['lngEjercicio'] !== $_POST['lngEjercicio']){
        $datosCorrectos['lngEjercicio'] = 'NO';
    }else{
        $datosCorrectos['lngEjercicio'] = 'SI';
    }
    echo "-Ejercicio: Entrada - " . $_POST['lngEjercicio'] . " , Salida - " . $datos['lngEjercicio'] . " ::Correcto?: " . $datosCorrectos['lngEjercicio'] . "\n";

    if($datos['strConcepto'] !== $_POST['strConcepto']){
        $datosCorrectos['strConcepto'] = 'NO';
    }else{
        $datosCorrectos['strConcepto'] = 'SI';
    }
    echo "-Concepto: Entrada - " . $_POST['strConcepto'] . " , Salida - " . $datos['strConcepto'] . " ::Correcto?: " . $datosCorrectos['strConcepto'] . "\n";

    if($datos['lngCantidad1'] !== $_POST['lngCantidad1']){
        $datosCorrectos['lngCantidad1'] = 'NO';
    }else{
        $datosCorrectos['lngCantidad1'] = 'SI';
    }
    echo "-Cantidad1: Entrada - " . $_POST['lngCantidad1'] . " , Salida - " . $datos['lngCantidad1'] . " ::Correcto?: " . $datosCorrectos['lngCantidad1'] . "\n";

    if($datos['lngIva1'] !== $_POST['lngIva1']){
        $datosCorrectos['lngIva1'] = 'NO';
    }else{
        $datosCorrectos['lngIva1'] = 'SI';
    }
    echo "-Cuota IVA1: Entrada - " . $_POST['lngIva1'] . " , Salida - " . $datos['lngIva1'] . " ::Correcto?: " . $datosCorrectos['lngIva1'] . "\n";

    if($datos['lngPorciento1'] !== $_POST['lngPorciento1']){
        $datosCorrectos['lngPorciento1'] = 'NO';
    }else{
        $datosCorrectos['lngPorciento1'] = 'SI';
    }
    echo "-% IVA1: Entrada - " . $_POST['lngPorciento1'] . " , Salida - " . $datos['lngPorciento1'] . " ::Correcto?: " . $datosCorrectos['lngPorciento1'] . "\n";
    
    if($datos['lngCantidad2'] !== $_POST['lngCantidad2']){
        $datosCorrectos['lngCantidad2'] = 'NO';
    }else{
        $datosCorrectos['lngCantidad2'] = 'SI';
    }
    echo "-Cantidad2: Entrada - " . $_POST['lngCantidad2'] . " , Salida - " . $datos['lngCantidad2'] . " ::Correcto?: " . $datosCorrectos['lngCantidad2'] . "\n";

    if($datos['lngIva2'] !== $_POST['lngIva2']){
        $datosCorrectos['lngIva2'] = 'NO';
    }else{
        $datosCorrectos['lngIva2'] = 'SI';
    }
    echo "-Cuota IVA2: Entrada - " . $_POST['lngIva2'] . " , Salida - " . $datos['lngIva2'] . " ::Correcto?: " . $datosCorrectos['lngIva2'] . "\n";

    if($datos['lngPorciento2'] !== $_POST['lngPorciento2']){
        $datosCorrectos['lngPorciento2'] = 'NO';
    }else{
        $datosCorrectos['lngPorciento2'] = 'SI';
    }
    echo "-% IVA2: Entrada - " . $_POST['lngPorciento2'] . " , Salida - " . $datos['lngPorciento2'] . " ::Correcto?: " . $datosCorrectos['lngPorciento2'] . "\n";
    
    if($datos['lngCantidad3'] !== $_POST['lngCantidad3']){
        $datosCorrectos['lngCantidad3'] = 'NO';
    }else{
        $datosCorrectos['lngCantidad3'] = 'SI';
    }
    echo "-Cantidad3: Entrada - " . $_POST['lngCantidad3'] . " , Salida - " . $datos['lngCantidad3'] . " ::Correcto?: " . $datosCorrectos['lngCantidad3'] . "\n";

    if($datos['lngIva3'] !== $_POST['lngIva3']){
        $datosCorrectos['lngIva3'] = 'NO';
    }else{
        $datosCorrectos['lngIva3'] = 'SI';
    }
    echo "-Cuota IVA3: Entrada - " . $_POST['lngIva3'] . " , Salida - " . $datos['lngIva3'] . " ::Correcto?: " . $datosCorrectos['lngIva3'] . "\n";

    if($datos['lngPorciento3'] !== $_POST['lngPorciento3']){
        $datosCorrectos['lngPorciento3'] = 'NO';
    }else{
        $datosCorrectos['lngPorciento3'] = 'SI';
    }
    echo "-% IVA3: Entrada - " . $_POST['lngPorciento3'] . " , Salida - " . $datos['lngPorciento3'] . " ::Correcto?: " . $datosCorrectos['lngPorciento3'] . "\n";
    
    if($datos['lngCantidad4'] !== $_POST['lngCantidad4']){
        $datosCorrectos['lngCantidad4'] = 'NO';
    }else{
        $datosCorrectos['lngCantidad4'] = 'SI';
    }
    echo "-Cantidad4: Entrada - " . $_POST['lngCantidad4'] . " , Salida - " . $datos['lngCantidad4'] . " ::Correcto?: " . $datosCorrectos['lngCantidad4'] . "\n";

    if($datos['lngIva4'] !== $_POST['lngIva4']){
        $datosCorrectos['lngIva4'] = 'NO';
    }else{
        $datosCorrectos['lngIva4'] = 'SI';
    }
    echo "-Cuota IVA4: Entrada - " . $_POST['lngIva4'] . " , Salida - " . $datos['lngIva4'] . " ::Correcto?: " . $datosCorrectos['lngIva4'] . "\n";

    if($datos['lngPorciento4'] !== $_POST['lngPorciento4']){
        $datosCorrectos['lngPorciento4'] = 'NO';
    }else{
        $datosCorrectos['lngPorciento4'] = 'SI';
    }
    echo "-% IVA4: Entrada - " . $_POST['lngPorciento4'] . " , Salida - " . $datos['lngPorciento4'] . " ::Correcto?: " . $datosCorrectos['lngPorciento4'] . "\n";
    
    
    
    $correcto = 'SI';
    foreach ($datosCorrectos as $value) {
        if($value === 'NO'){
            $correcto = 'NO';
            break;
        }
    }
    
    
    echo "--------------------------------------------\nAsiento Tipo 03: Insertado correctamente?:" . $correcto . "\n--------------------------------------------\n\n";


    
    //var_dump($datos);die;
}




borrar_tablas();
gastos_00();
gastos_01();
gastos_03();

