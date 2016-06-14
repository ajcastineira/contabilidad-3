<?php
session_start();
require_once '../CN/clsCNContabilidad.php';
require_once '../CN/clsCNUsu.php';

$clsCNContabilidad=new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['mapeo']);
$clsCNUsu=new clsCNUsu();
$clsCNUsu->setStrBD($_SESSION['dbContabilidad']);


//funcion de envio de correo al asesor al borrar un empleado
function CorreoBorrarEmpleado($Usuario,$strMail,$datos){

        $strHTML = '<style type="text/css">'; 
        $strHTML = $strHTML . '.txtgeneral{'; 
        $strHTML = $strHTML . 'COLOR: #003366;'; 
        $strHTML = $strHTML . 'background-color: aliceblue;'; 
        $strHTML = $strHTML . 'text-align: center;'; 
        $strHTML = $strHTML . 'font-size: -2;}'; 
        $strHTML = $strHTML . '</style>'; 
        $strHTML = $strHTML . '<table width="750"  border="0" height="22" class="txtgeneral">'; 
        $strHTML = $strHTML . "<tr><td align='right'>El usuario:</td><td align='left'><b>$Usuario</b></td></tr>";
        $strHTML = $strHTML . "<tr><td></td></tr>";
        $strHTML = $strHTML . "<tr><td>Ha borrado un empleado de la BBDD</td><td align='left'>el día :".date("d-m-Y")."</td></tr>";
        $strHTML = $strHTML . "<tr><td colspan='2'><hr/></td></tr>";
        $strHTML = $strHTML . "<tr><td></td></tr>";
        $strHTML = $strHTML . "<tr><td align='right' width='25%'>DNI/NIE:</td><td align='left'><i>".$datos['DNINIE']."</i></td></tr>";
        $strHTML = $strHTML . "<tr style='background-color:#D9EBFC;'><td align='right'>Nº Seg. Social:</td><td align='left'><i>".$datos['NumeroSS']."</i></td></tr>";
        $strHTML = $strHTML . "<tr><td align='right'>Nombre y Apellidos:</td><td align='left'><i>".$datos['NombreApellidos']."</i></td></tr>";
        $strHTML = $strHTML . "<tr style='background-color:#D9EBFC;'><td align='right'>Fecha Nacimiento:</td><td align='left'><i>".$datos['FechaNac']."</i></td></tr>";
        $strHTML = $strHTML . "<tr><td align='right'>Tipo de Contrato:</td><td align='left'><i>".$datos['TipoContrato']."</i></td></tr>";
        $strHTML = $strHTML . "<tr style='background-color:#D9EBFC;'><td align='right'>Duración de Contrato:</td><td align='left'><i>".$datos['DuracionContrato']."</i></td></tr>";
        $strHTML = $strHTML . "<tr><td align='right'>Jornada:</td><td align='left'><i>".$datos['Jornada']."</i></td></tr>";
        $strHTML = $strHTML . "<tr style='background-color:#D9EBFC;'><td align='right'>Categoría Profesional:</td><td align='left'><i>".$datos['CategProfesional']."</i></td></tr>";
        $strHTML = $strHTML . "<tr><td align='right' valign='top'>Observaciones:</td><td align='left'><i>".$datos['Observaciones']."</i></td></tr>";
        $strHTML = $strHTML . "<tr><td></td></tr>";
        $strHTML = $strHTML . "<tr><td></td></tr>";
        $strHTML = $strHTML . "<tr><td colspan='2'><hr/></td></tr>";
        $strHTML = $strHTML . '<tr><td colspan="2">Departamento de Calidad</td></tr>';
        $strHTML = $strHTML . '<tr><td colspan="2"><center><IMG SRC="http://www.qualidad.info/contabilidad/images/logo-'.$_SESSION['base']. '.jpg" BORDER="0"></center>';				
        $strHTML = $strHTML . '</td></tr>';
        $strHTML = $strHTML . '</table>';
        
        $strHTML ='<HTML><head><meta http-equiv="Content-type" content="text/html; charset=utf-8" /></head><BODY><font face=""Verdana, Arial, Helvetica, sans-serif"" size=""-1"">'.$strHTML.'</font></BODY></HTML>';
        $cabeceras = "Content-type: text/html\r\n";

        //echo $strHTML;die;
        mail("$strMail", "Sistema de Calidad", "$strHTML","$cabeceras");
}



//borramos este empleado (cambiamos el campo lngAltaBaja a 0)
$id=$_GET['id'];
logger('traza','empleadoBorrar.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
       " Comienzo clsCNContabilidad->empleadoBorrar($id)>");

if($clsCNContabilidad->empleadoBorrar($id)){
        //guardo en un array los datos del alta
        $datosEmpleado=$clsCNContabilidad->datosEmpleado($id);
        //extraigo los datos del asesor
        $Asesor=$clsCNUsu->DatosAsesor($_SESSION['idEmp']);
        //extraigo los datos del usuario actual
        $datosUsuarioActivo=$clsCNUsu->DatosUsuario($_SESSION['usuario']);
        //envio un correo al asesor del alta del empleado
        CorreoBorrarEmpleado(($datosUsuarioActivo['strNombre'].' '.$datosUsuarioActivo['strApellidos']), $Asesor['strCorreo'], $datosEmpleado);
        
        //redirecciono a la pagina de exito
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/exito.php?Id=Se ha borrado el empleado de la base de datos">';
}else{
    //si no se ha borrado
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/error.php?id=NO se ha borrado el empleado de la base de datos">';
}
?>
