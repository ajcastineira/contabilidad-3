<?php
session_start();
//carga la conexion
require_once '../../general/'.$_SESSION['mapeo'];

$db = new Db();


$IdTarjeta = $_GET['IdTarjeta'];
$cuentaTarjeta = $_GET['cuentaTarjeta'];


//guardo los datos en la tabla "tbventas_tarjetas"
//1º veo si el dato "IdTarjeta" no viene vacio
//SI viene vacio no hago nada
//SI NO viene vacio, viene con numero, ese es el IdTarjeta fila que hay que editar
if($IdBanco !== ''){
    //es actualizar
    
    //consulta SQL
    $strSQL="
            UPDATE tbventas_tarjetas T
            SET T.CuentaTarjeta = $cuentaTarjeta
            WHERE T.IdTarjeta = $IdTarjeta
            ";

    $db->conectar($_SESSION['mapeo']);
    $result=$db->ejecutar($strSQL);
    $db->desconectar();

    echo 'editado';
}