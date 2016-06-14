<?php
session_start();
//carga la conexion
require_once '../../general/'.$_SESSION['mapeo'];

$db = new Db();

$IdBanco = $_GET['IdBanco'];
$cantidad = $_GET['cantidad'];
$cuentaBanco = $_GET['cuentaBanco'];
$fecha = $_GET['fecha'];
$Asiento = "P";

//si $cantidad es vacia pongo a null este campo, cuentaBanco y Asiento
if($cantidad === ''){
    $cantidad = 'null';
    $cuentaBanco = 'null';
    $Asiento = "";
}

//guardo los datos en la tabla "tbventas_bancos"
//1º veo si el dato "IdBanco" no viene vacio
//SI viene vacio hay que insertar una nueva fila en la tabla
//SI NO viene vacio, viene con numero, ese es el IdBanco fila que hay que editar
if($IdBanco === ''){
    //hay que insertar
    //consulta SQL
    $strSQL = "
                SELECT IF(ISNULL(MAX(IdBanco)),1,MAX(IdBanco)+1) AS IdBanco FROM tbventas_bancos
               ";
    $db->conectar($_SESSION['mapeo']);
    $stmt = $db->ejecutar($strSQL);
    $db->desconectar();
    $row = mysql_fetch_array($stmt);
    $IdBanco = $row['IdBanco'];

    
    $strSQL = "
                INSERT INTO tbventas_bancos 
                (IdBanco,Fecha,Distribuir,Cantidad,Cuenta,Asiento,Borrado)
                VALUES ($IdBanco,'$fecha',1,$cantidad,$cuentaBanco,'P',1)
              ";

    $db->conectar($_SESSION['mapeo']);
    $result=$db->ejecutar($strSQL);
    $db->desconectar();

}else{
    //es actualizar
    
    //consulta SQL
    $strSQL="
            UPDATE tbventas_bancos B
            SET B.Cantidad = $cantidad,
            Distribuir = 1,
            Cuenta = $cuentaBanco,
            Asiento = '$Asiento',
            Borrado = 1
            WHERE B.IdBanco = $IdBanco
            ";

    $db->conectar($_SESSION['mapeo']);
    $result=$db->ejecutar($strSQL);
    $db->desconectar();

}

//datos a devolver
$datos['IdBanco'] = $IdBanco;
$datos['cuentaBanco'] = $cuentaBanco;
$datos['cantidad'] = $cantidad;
$datos['fecha'] = $fecha;
   
   
echo json_encode($datos);
