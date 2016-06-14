<?php
session_start();


$id=$_GET['id'];

//hago la consulta en la tabla tbrecl_nc_pm_fichero
//carga la conexion
require_once '../../general/'.$_SESSION['mapeo'];
$db = new Db();
$db->conectar($_SESSION['mapeo']);


$strSQL="
    SELECT A.IdAdjunto,A.fichero,A.descripcion,DATE_FORMAT(A.fecha,'%d/%m/%Y') AS fecha
    FROM tbempleados_incidencias_adj A
    WHERE A.IdIncidencia=$id
    AND A.Borrado=1
";

$stmt = $db->ejecutar ( $strSQL );
$db->desconectar ();


$arResult='';
if($stmt){
    while($row=  mysql_fetch_array($stmt)){
        $reg='';
        foreach($row as $propiedad=>$valor){
            if(!is_numeric($propiedad)){
                $reg[$propiedad]=$valor;
            }
        }
        $arResult[]=$reg;
    }

    if($_SESSION['navegacion']==='movil'){
        //version APP movil
        $html='<table id="datatablesMod1" style="width: 100%;">
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Fecha</th>
                    <th>Baja</th>
                </tr>
            </thead>
            <tbody>';

        if(is_array($arResult)){
            for ($i = 0; $i < count($arResult); $i++) {
                $link = "javascript:window.open('../doc/doc-" . $_SESSION['base'] . "/".$arResult[$i]['fichero']."');";
                $fecha=explode('/',$arResult[$i]['fecha']);
                $html=$html.'<tr style="background-color: #C9E0F2;" style="cursor: pointer;">';
                $html=$html.'<td onClick="'.$link.'">'.$arResult[$i]['descripcion'].'</td>';
                $html=$html.'<td onClick="'.$link.'"><!-- '.$fecha[2].$fecha[1].$fecha[0].' -->'.$arResult[$i]['fecha'].'</td>';
                $html=$html.'<td align="center" onclick="borrarFichero('.$arResult[$i]['IdAdjunto'].');"><img src="../images/error.png" width="10" height="10" border="0"/></td>';
                $html=$html.'</tr>';
            }
        }
        $html=$html.'</tbody></table>';
    }else{
        //version PC (en tabla)
        $html='<table id="datatablesMod1" style="width:300px;" class="ficheros" border="0">
            <thead>
                <tr class="txtListadoFicherosC">
                    <th>Descripción</th>
                    <th>Fecha</th>
                    <th>Baja</th>
                </tr>
            </thead>
            <tbody>';

        if(is_array($arResult)){
            for ($i = 0; $i < count($arResult); $i++) {
                $link = "javascript:window.open('../doc/doc-" . $_SESSION['base'] . "/".$arResult[$i]['fichero']."');";
                $fecha=explode('/',$arResult[$i]['fecha']);
                $html=$html.'<tr class="txtListadoFicheros" style="cursor: pointer;">';
                $html=$html.'<td onClick="'.$link.'">'.$arResult[$i]['descripcion'].'</td>';
                $html=$html.'<td onClick="'.$link.'"><!-- '.$fecha[2].$fecha[1].$fecha[0].' -->'.$arResult[$i]['fecha'].'</td>';
                $html=$html.'<td align="center" onclick="borrarFichero('.$arResult[$i]['IdAdjunto'].');"><img src="../images/error.png" width="10" height="10" border="0"/></td>';
                $html=$html.'</tr>';
            }
        }
        $html=$html.'</tbody></table>';
    }
    
    echo $html;
}else{
    echo '';
}
?>
