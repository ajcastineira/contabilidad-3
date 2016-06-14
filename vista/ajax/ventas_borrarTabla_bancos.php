<?php

session_start();
//carga la conexion
require_once '../../general/'.$_SESSION['mapeo'];

$db = new Db();


//consulta SQL
$strSQL="
        TRUNCATE tbventas_bancos
        ";

$db->conectar($_SESSION['mapeo']);
$result=$db->ejecutar($strSQL);
$db->desconectar();

echo 'OK';
