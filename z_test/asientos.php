<?php

/* 
 * Probar como se guardan los tipos de asientos
 */

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



function gastos_01(){
    echo "Asiento Tipo 01:<br/>";
    
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
    
    if($datos['lngCantidad'] !== $_POST['lngCantidad']){
        $datosCorrectos['lngCantidad'] = 'NO';
    }else{
        $datosCorrectos['lngCantidad'] = 'SI';
    }
    echo "Cantidad: Entrada - " . $_POST['lngCantidad'] . " , Salida - " . $datos['lngCantidad'] . " ::Correcto?: " . $datosCorrectos['lngCantidad'] . "<br/>";
    if($datos['lngEjercicio'] !== $_POST['lngEjercicio']){
        $datosCorrectos['lngEjercicio'] = 'NO';
    }else{
        $datosCorrectos['lngEjercicio'] = 'SI';
    }
    echo "Ejercicio: Entrada - " . $_POST['lngEjercicio'] . " , Salida - " . $datos['lngEjercicio'] . " ::Correcto?: " . $datosCorrectos['lngEjercicio'] . "<br/>";
    if($datos['lngPeriodo'] !== $_POST['lngPeriodo']){
        $datosCorrectos['lngPeriodo'] = 'NO';
    }else{
        $datosCorrectos['lngPeriodo'] = 'SI';
    }
    echo "Periodo: Entrada - " . $_POST['lngPeriodo'] . " , Salida - " . $datos['lngPeriodo'] . " ::Correcto?: " . $datosCorrectos['lngPeriodo'] . "<br/>";


    $correcto = 'SI';
    foreach ($datosCorrectos as $value) {
        if($value === 'NO'){
            $correcto = 'NO';
            break;
        }
    }
    
    
    echo "Tipo Asiento 01 insertado correctamente?:" . $correcto . "<br/><br/>";
    
    //var_dump($datos);die;
}


borrar_tablas();
gastos_01();

