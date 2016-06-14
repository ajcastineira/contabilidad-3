<?php
session_start();
require_once '../../general/'.$_SESSION['mapeo'];
require_once '../../general/myLogger.php';

$Id = $_POST['Id']; 

$db = new Db();
$db->conectar($_SESSION['mapeo']);


//borro el registro de la tabla (cambio el campo Borrado=0) 
$strSQL="
        UPDATE tbempleados_incidencias_adj 
        SET Borrado=0
        WHERE IdAdjunto=$Id
        ";
$stmt = $db->ejecutar ( $strSQL );
$db->desconectar ();

if($stmt){
    echo 'OK';
}else{
    echo '';
}
?>
