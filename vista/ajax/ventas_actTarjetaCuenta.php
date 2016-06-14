<?php
session_start();
//carga la conexion
require_once '../../general/'.$_SESSION['mapeo'];

$db = new Db();


$IdTarjeta = $_GET['IdTarjeta'];
$cuenta = $_GET['cuenta'];


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
            SET T.CuentaTarjeta = $cuenta
            WHERE T.IdTarjeta = $IdTarjeta
            ";

    $db->conectar($_SESSION['mapeo']);
    $result=$db->ejecutar($strSQL);
    $db->desconectar();

    $respuesta['IdTarjeta'] = $IdTarjeta;
    $respuesta['tipo'] = "Edicion";
    
}
if($result){
    $respuesta['guardado'] = 'SI';
}else{
    $respuesta['guardado'] = 'NO';
}

echo json_encode($respuesta);
