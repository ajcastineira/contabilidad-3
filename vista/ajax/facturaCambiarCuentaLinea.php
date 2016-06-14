<?php
session_start();
//carga la conexion
require_once '../../general/'.$_SESSION['mapeo'];

$db = new Db();
$db->conectar($_SESSION['mapeo']);

$cuenta = $_GET['cuenta'];
$IdFacturaLineas = $_GET['IdFacturaLineas'];

//buscamos los IdPresupLineas de esta IdFacturaLineas (esta factura puede tener mas facturas relaccionadas por 
//el mismo presupuesto
$query="
        SELECT IdPresupLineas
        FROM tbmisfacturaslineas
        WHERE IdFacturaLineas = $IdFacturaLineas
        ";

$result = $db->ejecutar($query);

if(!$result){
    echo 'NO';die;
}

while($row = mysql_fetch_array($result)){
    //añado la condicion si $IdPresupLineas=0 para que solo actualice su linea
    $condicion = '';
    if($row['IdPresupLineas'] === '0'){
        $condicion =" AND IdFacturaLineas = ".$IdFacturaLineas;
    }
    
    //ahora actualizo las lineas que tengan como IdPresupLineas los que vengan en el $row
    $query="
            UPDATE tbmisfacturaslineas
            SET cuentaArticulo = '$cuenta'
            WHERE IdPresupLineas = ".$row['IdPresupLineas']."
            $condicion
            ";
    
    $result = $db->ejecutar($query);

    if(!$result){
        echo 'NO';die;
    }
}
$db->desconectar();

//si todo a ido correctamente devolvemos SI
echo 'SI';