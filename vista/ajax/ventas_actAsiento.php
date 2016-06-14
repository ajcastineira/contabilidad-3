<?php
session_start();
//carga la conexion
require_once '../../general/'.$_SESSION['mapeo'];

$db = new Db();


$IdBanco = $_GET['IdBanco'];
$asiento = $_GET['Asiento'];


//guardo los datos en la tabla "tbventas_bancos"
//1º veo si el dato "IdBanco" no viene vacio
//SI viene vacio no hago nada
//SI NO viene vacio, viene con numero, ese es el IdBanco fila que hay que editar
if($IdBanco !== ''){
    //es actualizar
    
    //consulta SQL
    $strSQL="
            UPDATE tbventas_bancos B
            SET B.Asiento = '$asiento'
            WHERE B.IdBanco = $IdBanco
            ";

    $db->conectar($_SESSION['mapeo']);
    $result=$db->ejecutar($strSQL);
    $db->desconectar();

    echo 'editado';
}