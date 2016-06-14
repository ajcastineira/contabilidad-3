<?php
session_start();

$ext=explode('.',$_FILES['archivo']['name']);
$ext=$ext[1];

require_once '../../general/'.$_SESSION['mapeo'];
$db = new Db();
$db->conectar($_SESSION['mapeo']);

//numero Id
$strSQL="
        SELECT IF(ISNULL(MAX(IdAdjunto)),1,MAX(IdAdjunto)+1) AS Id FROM tbempleados_incidencias_adj
        ";

$stmt = $db->ejecutar ( $strSQL );

if($stmt){
    $row=  mysql_fetch_array($stmt);
    $IdNuevo=$row['Id'];

    //genero el nombre del fichero 
    date_default_timezone_set('Europe/Madrid');
    $nombre='Inc-'.$_POST['IdIncidencia'].$IdNuevo.date('YmdHms').'.'.$ext;
    $destino = "../../doc/doc-" . $_SESSION['base'] . "/".$nombre;
    
    //sino existe este directorio lo crea
    if(!file_exists("../doc/doc-" . $_SESSION['base'])){
        mkdir("../doc/doc-" . $_SESSION['base']);
    }

    if(move_uploaded_file($_FILES['archivo']['tmp_name'], $destino)){
        //inserto los datos
        $strSQL="
                INSERT INTO tbempleados_incidencias_adj (IdAdjunto,IdIncidencia,fichero,descripcion,Borrado,fecha) VALUES ($IdNuevo,".$_POST['IdIncidencia'].",'$nombre','".$_POST['descripcion']."',1,now())
                ";

        $stmt = $db->ejecutar ( $strSQL );
        $db->desconectar ();

        if($stmt){
            echo 'OK';
        }else{
            echo '';
        }
    }else{
        $db->desconectar ();
        echo '';
    }
}else{
    $db->desconectar ();
    echo '';
}
?>
