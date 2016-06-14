<?php
session_start();
class cuentas{

    public function buscarCuenta($buscar,$bd){
        require_once '../../general/'.$_SESSION['mapeo'];
        $db = new Db();
        $db->conectar($bd);
        $datos=array();

        $strSQL="
                SELECT CONCAT(A.Referencia,' - ',A.Descripcion) AS Descripcion
                FROM tbarticulos A
                WHERE A.Descripcion LIKE '%".$buscar."%'
                AND A.Borrado=1
                ORDER BY Descripcion
                ";

        $stmt = $db->ejecutar ( $strSQL );
        $db->desconectar ();

        while($row=  mysql_fetch_array($stmt,MYSQL_ASSOC)){
            $datos[]=array("value"=>$row["Descripcion"]);
        }
        return $datos;
    }
}

$cuentas=new cuentas();

$datos = json_encode($cuentas->buscarCuenta($_GET['term'],$_GET['bd']));

echo $datos;
?>

