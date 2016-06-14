<?php
session_start();
//carga la conexion
require_once '../../general/'.$_SESSION['mapeo'];

$db = new Db();


$fecha = $_GET['fecha'];
$Cantidad_distribuir = $_GET['Cantidad_distribuir'];
$iTabla = $_GET['iTabla'];
$IdBanco = $_GET['IdBanco'];


//$datos['estado'] = 'OK';
//$datos['iTabla'] = $iTabla;
//
//echo json_encode($datos);die;




//guardo los datos en la tabla "tbventas_bancos"
//1 veo si el dato "IdBanco" no viene vacio
//1.1 SI viene vacio, compruebo si viene CD=0 Y Cantidad=0
//1.1 SI viene vacio hay que insertar una nueva fila en la tabla
//1.2 SI NO viene vacio, viene con numero, ese es el IdBanco fila que hay que editar
if($Cantidad_distribuir !== '0'){
    if($IdBanco === '' || !isset($IdBanco)){
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
                    (IdBanco,Fecha,Cantidad_distribuir,Borrado)
                    VALUES ($IdBanco,'$fecha',$Cantidad_distribuir,1)
                  ";

        $db->conectar($_SESSION['mapeo']);
        $stmt = $db->ejecutar($strSQL);
        $db->desconectar();

        $datos['iTabla'] = $iTabla;
        if($stmt){
            $datos['IdBanco'] = $IdBanco;
            $datos['Cantidad_distribuir'] = $Cantidad_distribuir;
            $datos['estado'] = 'OK';
        }else{
            $datos['IdBanco'] = '';
            $datos['Cantidad_distribuir'] = '';
            $datos['estado'] = 'error';
        }
    }else{
        //es actualizar

        //consulta SQL
        $strSQL="
                UPDATE tbventas_bancos B
                SET B.Cantidad_distribuir = $Cantidad_distribuir
                WHERE B.IdBanco = $IdBanco
                ";

        $db->conectar($_SESSION['mapeo']);
        $stmt = $db->ejecutar($strSQL);
        $db->desconectar();

        $datos['iTabla'] = $iTabla;
        if($stmt){
            $datos['IdBanco'] = $IdBanco;
            $datos['Cantidad_distribuir'] = $Cantidad_distribuir;
            $datos['estado'] = 'OK';
        }else{
            $datos['IdBanco'] = '';
            $datos['Cantidad_distribuir'] = '';
            $datos['estado'] = 'error';
        }
    }
}else{
    //sino existiese linea no hara nada y si existe la actualiza colocando los valores a null
    if($IdBanco !== ''){
        //consulta SQL
        $strSQL="
                UPDATE tbventas_bancos B
                SET B.Cantidad_distribuir = null
                WHERE B.IdBanco = $IdBanco
                ";

        $db->conectar($_SESSION['mapeo']);
        $stmt = $db->ejecutar($strSQL);
        $db->desconectar();
    }
    
    
    $datos['iTabla'] = $iTabla;
    $datos['IdBanco'] = '';
    $datos['Cantidad_distribuir'] = '';
    $datos['estado'] = '';
}

echo json_encode($datos);
