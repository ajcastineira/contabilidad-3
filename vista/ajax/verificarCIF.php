<?phpsession_start();//carga la conexionrequire_once '../../general/conexion.php';$db = new DbC();$db->conectar($_SESSION['dbContabilidad']);//cojemos el parametro 'q' de la URL$q=$_GET["q"];$tipo=$_GET["tipo"];if($tipo==='4000'){    $cliProv=1;}else{    $cliProv=0;}//buscamos si hay nombre de usuario en la BD$query='SELECT IdCliProv,Nombre,CIF,direccion,municipio,provincia,CP,Telefono1,Telefono2,Fax,Correo,Actividad,CNAE,NumSS        FROM tbcliprov  WHERE "' . $q . '" = CIF  AND Borrado = 0';$result=$db->ejecutar($query);if($result){    $count= mysql_num_rows($result);    if($count>0){        $row= mysql_fetch_array($result);        $datos=array(            "IdCliProv"=>$row['IdCliProv'],            "Nombre"=>$row['Nombre'],            "CIF"=>$row['CIF'],            "direccion"=>$row['direccion'],            "municipio"=>$row['municipio'],            "provincia"=>$row['provincia'],            "CP"=>$row['CP'],            "Telefono1"=>$row['Telefono1'],            "Telefono2"=>$row['Telefono2'],            "Fax"=>$row['Fax'],            "Correo"=>$row['Correo'],            "Actividad"=>$row['Actividad'],            "CNAE"=>$row['CNAE'],            "NumSS"=>$row['NumSS'],            "strCCRecibos"=>'',            "ExisteCuenta"=>'',        );        //ahora busco si esta cuenta ya esta dada de alta        $query='                SELECT *                FROM tbrelacioncliprov                WHERE IdCliProv=' . $row['IdCliProv'] . '                 AND Borrado = 0 AND idEmpresa='.$_SESSION['idEmp'].'                AND CliProv='.$cliProv                ;        $result=$db->ejecutar($query);        if($result){            $count= mysql_num_rows($result);            if($count>0){                $datos['ExisteCuenta']='SI';                while($row = mysql_fetch_array($result)){                    $datos['strCCRecibos']=$row['CC_Recibos'];                }            }else{                $response='vacio';            }        }else{            $response='vacio';        }                        $response=$datos;    }else{        $response='vacio';    }}else{    $response='vacio';}////cerrar la conexion$db->desconectar();//devuelvo la respuesta al sendecho json_encode($response);?>