<?php
session_start();
//carga la conexion
require_once '../../general/'.$_SESSION['mapeo'];

$db = new Db();


$tabla = $_POST['datos'];
$fechaInicio = $_POST['fechaInicioB'];
$fechaFin = $_POST['fechaFinB'];
$cuentaBancoInsertar = $_POST['cuentaBanco'];


//primero borro 'tbventas_bancos'
//consulta SQL
//$strSQL="
//        DELETE FROM tbventas_bancos 
//        WHERE UNIX_TIMESTAMP(Fecha) >= '$fechaInicio' AND UNIX_TIMESTAMP(Fecha) <= '$fechaFin'
//        AND Borrado = 1 AND (Asiento = 'P' OR Asiento = 'X' OR Asiento = '') 
//        ";

$strSQL="
        DELETE FROM tbventas_bancos 
        WHERE UNIX_TIMESTAMP(Fecha) >= '$fechaInicio' AND UNIX_TIMESTAMP(Fecha) <= '$fechaFin'
        AND Borrado = 1 AND (Asiento = 'P' OR Asiento = 'X' OR Asiento = '' OR ISNULL(Asiento)) 
        ";

$db->conectar($_SESSION['mapeo']);
$stmt = $db->ejecutar($strSQL);
$db->desconectar();

$respuesta = "";
//ahora inserto los datos
for ($i = 0; $i < count($tabla); $i++) {
    //compruebo si se puede insertar ese valor (campo fila_Valida)
    if($tabla[$i]['fila_Valida'] === 'SI'){
        //compruebo que el asiento no sea un numero (seria el numero del asiento, estaria contabilizado, por lo que no habria que hacer nada)
        if(!is_numeric($tabla[$i]['Asiento'])){
            //ahora ompruebo que tenga valores los campos "Cantidad_distribuir" o "Cantidad"
            //si tiene valor > 0 alguno de los dos se inserta, si tienen los dos valor 0, no se inserta
            if(!(($tabla[$i]['Cantidad_distribuir'] === '0') && ($tabla[$i]['Cantidad'] === '0'))){
                //se inserta
                
                //consulta SQL
                $strSQL = "
                            SELECT IF(ISNULL(MAX(IdBanco)),1,MAX(IdBanco)+1) AS IdBanco FROM tbventas_bancos
                           ";
                $db->conectar($_SESSION['mapeo']);
                $stmt = $db->ejecutar($strSQL);
                $row = mysql_fetch_array($stmt);
                $IdBanco = $row['IdBanco'];

                $distribuir = 'false';
                if($tabla[$i]['Distribuir'] === 'true'){
                    $distribuir = 'true';
                }

                $cantidad_distribuir = $tabla[$i]['Cantidad_distribuir'];
                if($tabla[$i]['Cantidad_distribuir'] === '0'){
                    $cantidad_distribuir = 'null';
                }

                $cantidad = $tabla[$i]['Cantidad'];
                if($tabla[$i]['Cantidad'] === '0'){
                    $cantidad = 'null';
                }

                $cuentaBanco = $tabla[$i]['CuentaBanco'];
                if($cantidad !== 'null'){
                    if($tabla[$i]['CuentaBanco'] === ''){
                        $cuentaBanco = $cuentaBancoInsertar;
                    }
                }else{
                    $cuentaBanco = 'null';
                }


                $strSQL = "
                            INSERT INTO tbventas_bancos 
                            (IdBanco,Fecha,Cantidad_distribuir,Distribuir,Cantidad,Cuenta,Asiento,Borrado)
                            VALUES ($IdBanco,'".$tabla[$i]['fechaFila']."',$cantidad_distribuir,$distribuir,".$cantidad.",$cuentaBanco,'".$tabla[$i]['Asiento']."',1)
                          ";

                $stmt = $db->ejecutar($strSQL);
                $db->desconectar();

                $respuesta['IdBanco'] = $IdBanco;
                $respuesta['iTabla'] = $tabla[$i]['iTabla'];
                if($stmt){
                    $respuesta['estado'] = "OK";
                }else{
                    $respuesta['estado'] = "error";
                }
            }else{
                $respuesta['IdBanco'] = '';
                $respuesta['iTabla'] = $tabla[$i]['iTabla'];
                $respuesta['estado'] = "OK";
            }
            $respuestas[] = $respuesta;
        }
    }
}

echo json_encode($respuestas);die;

