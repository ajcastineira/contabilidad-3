<?php
session_start();
//carga la conexion
require_once '../../general/'.$_SESSION['mapeo'];

$db = new Db();


$respuesta['iTabla'] = $_GET['iTabla'];
$respuesta['IdTarjeta'] = $_GET['IdTarjeta'];

//compruebo que no venga vacio este numero
if($_GET['IdTarjeta'] !== ''){
    $strSQL="
            DELETE FROM tbventas_tarjetas 
            WHERE IdTarjeta = ".$_GET['IdTarjeta']."
            ";

    $db->conectar($_SESSION['mapeo']);
    $result=$db->ejecutar($strSQL);
    $db->desconectar();
    
    if($result){
        $respuesta['guardado'] = 'SI';
    }else{
        $respuesta['guardado'] = 'NO';
    }
}else{
    $respuesta['guardado'] = 'SI';
}



echo json_encode($respuesta);
