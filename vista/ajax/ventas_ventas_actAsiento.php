<?php
session_start();
//carga la conexion
require_once '../../general/'.$_SESSION['mapeo'];

$db = new Db();


$IdVenta = $_GET['IdVenta'];
$asiento = $_GET['Asiento'];
$fecha = $_GET['fecha'];


//guardo los datos en la tabla "tbventas"
//1º veo si el dato "IdVenta" no viene vacio
//SI viene vacio inserto en dato en la tabla
//SI NO viene vacio, viene con numero, ese es el IdVenta fila que hay que editar
$datos['iTabla'] = $_GET['iTabla'];
if($IdVenta !== ''){
    //es actualizar
    
    //consulta SQL
    $strSQL="
            UPDATE tbventas B
            SET B.Asiento = '$asiento'
            WHERE B.IdVenta = $IdVenta
            ";

    $db->conectar($_SESSION['mapeo']);
    $stmt = $db->ejecutar($strSQL);
    $db->desconectar();

}else{
    //hay que insertar
    //consulta SQL
    $strSQL = "
                SELECT IF(ISNULL(MAX(IdVenta)),1,MAX(IdVenta)+1) AS IdVenta FROM tbventas
               ";
    $db->conectar($_SESSION['mapeo']);
    $stmt = $db->ejecutar($strSQL);
    $db->desconectar();
    $row = mysql_fetch_array($stmt);
    $IdVenta = $row['IdVenta'];
    
    //formateo fecha
    $fecha = explode('/',$fecha);
    $fecha = $fecha[2].'-'.$fecha[1].'-'.$fecha[0];

    $strSQL = "
                INSERT INTO tbventas 
                (IdVenta,Fecha,Asiento,Borrado)
                VALUES ($IdVenta,'$fecha','$asiento',1)
              ";

    $db->conectar($_SESSION['mapeo']);
    $stmt = $db->ejecutar($strSQL);
    $db->desconectar();

}

if($stmt){
    $datos['IdVenta'] = $IdVenta;
    $datos['estado'] = 'OK';
}else{
    $datos['IdVenta'] = '';
    $datos['estado'] = 'error';
}


echo json_encode($datos) ;
