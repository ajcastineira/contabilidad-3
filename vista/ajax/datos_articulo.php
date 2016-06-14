<?php
session_start();
class cuentas{

    public function buscarCuenta($buscar,$cuenta){
        require_once '../../general/'.$_SESSION['mapeo'];
        $db = new Db();
        $db->conectar($_SESSION['mapeo']);
        
        $datos="";
        

        //busco el parametro de cuenta de ventas por defecto
        $datos["CuentaContable"] = $cuenta;
        
        
        //busco la cuenta del grupo del articulo
        $strSQL="
                SELECT G.Cuenta
                FROM tbgrupoarticulos G, tbarticulos A
                WHERE A.IdGrupo=G.IdGrupo
                AND A.Borrado=1
                AND CONCAT(A.Referencia,' - ',A.Descripcion) = '".$buscar."'
                ";
        
        $stmt = $db->ejecutar ( $strSQL );
        
        while($row = mysql_fetch_array($stmt,MYSQL_ASSOC)){
            //compruebo que no venga vacio
            if($row["Cuenta"] !== ''){
                $datos["CuentaContable"] = $row["Cuenta"];
            }
        }
        
        
        //busco la cuenta del articulo
        $strSQL="
                SELECT A.Id,A.Precio,A.tipoIVA,A.CuentaContable
                FROM tbarticulos A
                WHERE CONCAT(A.Referencia,' - ',A.Descripcion) = '".$buscar."'
                AND A.Borrado=1
                ";

        $stmt = $db->ejecutar ( $strSQL );
        $db->desconectar ();

        while($row=  mysql_fetch_array($stmt,MYSQL_ASSOC)){
            $datos["Id"]=$row["Id"];
            $datos["precio"]=$row["Precio"];
            $datos["tipoIVA"]=$row["tipoIVA"];
            //compruebo que no venga vacio
            if($row["CuentaContable"] !== ''){
                $datos["CuentaContable"] = $row["CuentaContable"];
            }
        }
        
        return $datos;
    }
}

$cuentas=new cuentas();

$datos = json_encode($cuentas->buscarCuenta($_GET['articulo'],$_GET['cuenta']));

echo $datos;
?>

