<?phpsession_start();//carga la conexionrequire_once '../../general/'.$_SESSION['mapeo'];$db = new Db();//cojemos el parametro 'q' de la URL$IdPresupuesto=$_GET["IdPresupuesto"];$opcion=$_GET["opcion"];//consulta SQL$strSQL="            UPDATE tbmispresupuestos            SET Estado='$opcion'            WHERE IdPresupuesto=".$IdPresupuesto."        ";$db->conectar($_SESSION['mapeo']);$result=$db->ejecutar($strSQL);$db->desconectar();echo true;?>