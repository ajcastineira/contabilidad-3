<?phpsession_start();//carga la conexionrequire_once '../../general/conexion.php';require_once '../../general/myLogger.php';$db = new DbC();$db->conectar($_SESSION['dbContabilidad']);//cojemos los parametros que vienen por GET$nombreDoc=$_GET["nombreDoc"];$edicion=$_GET["edicion"];//buscamos si existe este documento en la BD$query='SELECT * FROM tbdocumentos WHERE strDocumento="'.$nombreDoc.'" AND IdVersion='.$edicion;$result=$db->ejecutar($query);if($result){    $count=  mysql_num_rows($result);    if($count>0){        $response="<img src='../images/error.png' width='15' height='15' />";//    }else if(strlen($q)==0){//        $response="";    }else{        $response="<img src='../images/ok.png' width='15' height='15' />";    }}else{    $response="<img src='../images/ok.png' width='15' height='15' />";}////cerrar la conexion$db->desconectar();//devuelvo la respuesta al send que lo envióecho $response;?>