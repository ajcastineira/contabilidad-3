<?php
session_start();
require_once '../general/funcionesGenerales.php';
class clsCADLogin{
    
    function asignacionVblesSesion($dbempresas,$nombre_empresa,$usuario){
        //asignamos la navegacion, si es vista, movil o tablet
        //$_SESSION['navegacion']=$this->navegacion();
        
        require_once '../general/conexion.php';

        $db = new DbC();
        $db->conectar($dbempresas);
        $query='SELECT * FROM tbempresas WHERE strNombre="'.$nombre_empresa.'"';
        $result=$db->ejecutar($query);
        $row=  mysql_fetch_array($result);
        date_default_timezone_set('Europe/Madrid');
        $datHoy=date('Y-m-d h:m:s');
        if($row['fechaVencimiento']<$datHoy){
            return false;
        }
        
        $_SESSION["ultimoAcceso"]= date("Y-n-j H:i:s");   //Esta es para controlar el tiempo en el que se loguea
        $_SESSION["autentificado"] = "SI";     //Esta es una vez que el usuario ha metido el login y el psw y es correcto.
        
        //guardo la sesion (Nombre de la empresa)
        $_SESSION['sesion']=$row['strSesion'];
        //guardo la BBDD
        $_SESSION['strBD']=$row['strBD'];
        //el nombre del mapeo de la empresa (nombre de la base de datos)
        $_SESSION['mapeo']=$row['strMapeo'];
        //la version de la aplicacion de la empresa
        $_SESSION['version']=$row['Version'];
        //la variable del usuario
        $_SESSION['strUsuario']=$usuario;
        //el nombre base
        $_SESSION['base']=$row['strBD'];
        //el nombre de la empresa
        $_SESSION['strSesion']=$row['strSesion'];
        //ID empresa
        $_SESSION['idEmp']=$row['IdEmpresa'];
        //y el cargo del usuario
//        $db->conectar($row['strMapeo']);
        $query='SELECT * FROM tbusuarios WHERE strUsuario="'.$usuario.'"';
        $result=$db->ejecutar($query);
        $row=  mysql_fetch_array($result);
        
        //Establecemos el IdUsuario que sera el Identificador de la session
        $_SESSION['usuario']=$row['lngIdEmpleado'];        
        //$db->conectar($row['strMapeo']);
        $query="
                SELECT U.strPuesto
                FROM tbusuarios U,tbempleados E
                WHERE U.lngIdEmpleado=E.lngIdEmpleado
                AND U.lngIdEmpleado =" .$row['lngIdEmpleado']
                ;
        $result=$db->ejecutar($query);
        $row=  mysql_fetch_array($result);
        //Asignamos el cargo que realmente es el puesto que ocupa en la empresa
        $_SESSION['cargo']=$row['strPuesto'];
//        //De la misma forma añadimos el perfil 
//        $_SESSION['idPerfil']=$row['idPerfil'];    
        
		//CONTROL DE LOG
		
	$query="select status from tbcontrollinglog where strTipo = 'Info'";
        $result=$db->ejecutar($query);
        $row=  mysql_fetch_array($result);
        $_SESSION['InfoLog']=$row['status'];
				
	$query="select status from tbcontrollinglog where strTipo = 'Warning'";
        $result=$db->ejecutar($query);
        $row=  mysql_fetch_array($result);        
        $_SESSION['WarningLog']=$row['status'];
		
	$query="select status from tbcontrollinglog where strTipo = 'ERROR'";
        $result=$db->ejecutar($query);
        $row=  mysql_fetch_array($result);
        $_SESSION['ErrorLog']=$row['status'];
		
	$query="select status from tbcontrollinglog where strTipo = 'TRAZADEVELOPER'";
        $result=$db->ejecutar($query);
        $db->desconectar();
        $row=  mysql_fetch_array($result);
        $_SESSION['Traza']=$row['status'];

        //guardo en variables de sesion el logo y si se imprime o no en documentos
        //1º Logo en Aplicacion, si es SI leo el logo y lo guardo en la vble, si es NO guardo el de qualidad
        $logoEnAplicacion=$this->Parametro_general('Logo en Aplicacion',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));
        logger('info','clsCADLogin.php-' , "logo en Aplicacion? ".$logoEnAplicacion);
        if($logoEnAplicacion==='on'){
            $_SESSION['logo']=$this->Parametro_general('Logo',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));
        }else{
            $_SESSION['logo']='logo-Qualidad.JPG';
        }
        
        //2º Leo si se imprime el logo en documentos
        $_SESSION['imprimeDoc']=$this->Parametro_general('Logo en Documentos',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));
        
//        //3º Leo la carpeta de usuarios a guardar
//        $_SESSION['carpetaUsuario']=$this->Parametro_general('carpeta Usuario',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));
//        
        logger('info','clsCADLogin.php-' , "Se ha logueado el usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.session_id());
        
        return true;
    }
    
    function MantenimientoDb_tbconsulta_pregunta($bbdd){
        require_once '../general/conexion.php';
        $db = new DbC();

        //comprobamos las preguntas que tengan la ultima respuesta hace 10 dias o mas y
        // que esten en estado 'Respondida', se pasa el campo strEstado a 'Cerrada'
        $strSQL="UPDATE tbconsulta_pregunta SET tbconsulta_pregunta.strEstado='Cerrada'
                 WHERE DATE_ADD(tbconsulta_pregunta.datFechaStatus, INTERVAL 10 DAY)<NOW()
                 AND tbconsulta_pregunta.strEstado='Respondida'";
        $db->conectar($bbdd);
        $stmt = $db->ejecutar ( $strSQL );
        $db->desconectar();
        
        if($stmt){
            logger('traza','clsCADLogin.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADConsultas->MantenimientoDb_tbconsulta_pregunta($bbdd)|| 10 Dias a Cerrada Actualizado ");
        }else{
            logger('traza','clsCADLogin.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADConsultas->MantenimientoDb_tbconsulta_pregunta($bbdd)|| NO-10 Dias a Cerrada Actualizado ");
        }
        
        return true;
    }
    
    function MantenimientoDb_tbmisfacturas($bbdd){
        require_once '../general/'.$bbdd;
        $db = new Db();
        
        //compruebo que la tabla 'tbmisfacturas' el campo 'Situacion' tiene varios valores, entre ellos 'En plazo' y 'Vencida'.
        //'En plazo' significa que la factura no ha superado la fecha del campo 'FechaVtoFactura', cuando la supere este campo debe
        //pasar a ?Vencida'. Como es un capo que depende del tiempo se comprueba cada vez que nos logeamos
        $strSQL="
                UPDATE tbmisfacturas
                SET Situacion='Vencida'
                WHERE FechaVtoFactura<NOW()
                AND Situacion='En plazo'
                ";
        $db->conectar($bbdd);
        $stmt = $db->ejecutar ( $strSQL );
        $db->desconectar();
        
        if($stmt){
            logger('traza','clsCADLogin.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADConsultas->MantenimientoDb_tbmisfacturas($bbdd)|| Actualizado el campo 'Situacion'en tabla 'tbmisfacturas'. ");
        }else{
            logger('traza','clsCADLogin.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADConsultas->MantenimientoDb_tbmisfacturas($bbdd)|| NO-Actualizado el campo 'Situacion'en tabla 'tbmisfacturas'.  ");
        }
        
        return true;
    }
    
    function nombreEmpresaPorUsuario($usuario,$bbdd){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($bbdd);

        $strSQL="SELECT EP.strNombre
                 FROM tbusuarios U, tbempleados EM, tbempresas EP
                 WHERE U.lngIdEmpleado=EM.lngIdEmpleado
                 AND EM.IdEmpresa=EP.IdEmpresa
                 AND U.strUsuario='$usuario'";
        $stmt = $db->ejecutar ( $strSQL );
        $db->desconectar();
        
        if($stmt){
            $row=  mysql_fetch_array($stmt);
            return $row['strNombre'];
        }else{
            return false;
        }
    }

    //esta copiado de clsCNContabilidad 30/1/2014
    function Parametro_general($parametroBuscar,$fechaInicio,$fechaFin){
        require_once '../general/'.$_SESSION['mapeo'];
        $db = new Db();
        
        //extraigo el parametro a buscar de la tabla  'tbparametros_generales'
        $strSQL="
                SELECT valor,ValidoDesde,ValidoHasta
                FROM tbparametros_generales
                WHERE nombre ='$parametroBuscar'
                ";
        logger('traza','clsCADContabilidad.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADContabilidad->Parametro_general()|| SQL : ".$strSQL);
        
        $db->conectar($_SESSION['mapeo']);
        $stmt = $db->ejecutar ( $strSQL );
        $db->desconectar();
        
        $resultado='';
        if($stmt){
            while($row=  mysql_fetch_array($stmt)){
                $reg='';
                foreach($row as $propiedad=>$valor){
                    if(!is_numeric($propiedad)){
                        $reg[$propiedad]=$valor;
                    }
                }
                $resultado[]=$reg;
            }
        }
        
        //paso a DATETIME
//        $fechaInicio=fecha_to_DATETIME($fechaInicio);
//        $fechaFin=fecha_to_DATETIME($fechaFin);
        
        //ahora busco en este array por fechas que este valido este parametro
        if(is_array($resultado)){
            for($i=0;$i<count($resultado);$i++){
                //si ValidoHasta = null , solo hay que combrobar que $fechaInicio>=ValidoDesde
                if($resultado[$i]['ValidoHasta']==null){
                    if($fechaInicio >= $resultado[$i]['ValidoDesde']){
                        $valorParametro=$resultado[$i]['valor'];
                    }
                }else{
                //si ValidoHasta tiene valor 
                    //hay que ver que $fechaInicio>=ValidoDesde y $fechaFin<=ValidoHasta
                    if(($fechaInicio >= $resultado[$i]['ValidoDesde']) && ($fechaFin <= $resultado[$i]['ValidoHasta'])){
                        $valorParametro=$resultado[$i]['valor'];
                    }
                }
            }
        }
        //sino no hay array es que no se a encntrado nada, por defecto se pone 0
        else{
            $valorParametro=0;
        }
        logger('traza','clsCADContabilidad.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADContabilidad->Parametro_general()|| valorParametro : ".$valorParametro);
        return $valorParametro;
    }
    
    function navegacion(){
        require_once '../general/Mobile_Detect.php';
        $detect=new Mobile_Detect();

        if($detect->isMobile()==true){
//            $navegacion='vista';
            $navegacion='movil';
        }else if($detect->isTablet()==true){
            $navegacion='vista';
        }else{
            $navegacion='vista';
        }
        
        return $navegacion;
    }
    
    function listFicheros($dir){
        //listo los ficheros que hay en la carpeta $dir*

        $directorio = opendir($dir); 
        //guardo los ficheros que hay
        $ficheros=array();
        $i=0;
        while ($archivo = readdir($directorio))
        {
            if (!is_dir($archivo))//verificamos si es o no un directorio
            {
                $ficheros[$i]=$archivo;
                $i++;
            }
        }
        //devolvemos el array final
        return $ficheros;
    }
}
?>
