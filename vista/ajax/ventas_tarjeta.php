<?php
session_start();
//carga la conexion
require_once '../../general/'.$_SESSION['mapeo'];

$db = new Db();


$IdTarjeta = $_GET['IdTarjeta'];
$fecha = $_GET['fecha'];
$TipoTarjeta = $_GET['TipoTarjeta'];
$bruto = $_GET['bruto'];
$comision = $_GET['comision'];
$liquido = $_GET['liquido'];
$cuentaTarjeta = $_GET['cuentaTarjeta'];


//guardo los datos en la tabla "tbventas_bancos"
//1º veo si el dato "IdBanco" no viene vacio
//SI viene vacio no hago nada
//SI NO viene vacio, viene con numero, ese es el IdBanco fila que hay que editar
$respuesta['iTabla'] = $_GET['iTabla'];
if($IdTarjeta !== ''){
    //es actualizar
    
    //consulta SQL
    $strSQL="
            UPDATE tbventas_tarjetas T
            SET T.Bruto = $bruto,
            T.Comision = $comision,
            T.Liquido = $liquido
            WHERE T.IdTarjeta = $IdTarjeta
            ";

    $db->conectar($_SESSION['mapeo']);
    $result=$db->ejecutar($strSQL);
    $db->desconectar();

    $respuesta['IdTarjeta'] = $IdTarjeta;
    $respuesta['tipo'] = "Edicion";
    
}else{
    //es nuevo, inserto en la tabla 
    //consulta SQL
    $strSQL = "
                SELECT IF(ISNULL(MAX(IdTarjeta)),1,MAX(IdTarjeta)+1) AS IdTarjeta FROM tbventas_tarjetas
               ";
    $db->conectar($_SESSION['mapeo']);
    $stmt = $db->ejecutar($strSQL);
    $db->desconectar();
    $row = mysql_fetch_array($stmt);
    $IdTarjeta = $row['IdTarjeta'];

    //control de los datos que son numericos
    if($bruto == ''){
        $bruto = NULL;
    }
    if($comision == ''){
        $comision = NULL;
    }
    if($liquido == ''){
        $liquido = NULL;
    }
    
    $strSQL = "
                INSERT INTO tbventas_tarjetas 
                (IdTarjeta,Fecha,TipoTarjeta,Bruto,Comision,Liquido,CuentaTarjeta,Asiento,Borrado)
                VALUES
                ($IdTarjeta,'$fecha','$TipoTarjeta',$bruto,$comision,$liquido,$cuentaTarjeta,'P',1)
              ";

    $db->conectar($_SESSION['mapeo']);
    $result=$db->ejecutar($strSQL);
    $db->desconectar();

    
    $respuesta['IdTarjeta'] = $IdTarjeta;
    $respuesta['tipo'] = "Nuevo";
}
if($result){
    $respuesta['guardado'] = 'SI';
}else{
    $respuesta['guardado'] = 'NO';
}

echo json_encode($respuesta);
