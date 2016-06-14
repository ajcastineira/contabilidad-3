<?php
class clsCADUsu{
    
    private $strDB='';
    private $strDBCliente='';

    function setStrBD($str){
        $this->strDB=$str;
    }

    function getStrBD(){
        return $this->strDB;
    }

    function setStrBDCliente($str){
        $this->strDBCliente=$str;
    }

    function getStrBDCliente(){
        return $this->strDBCliente;
    }

    function IdUsuarioNuevo(){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());
                  
        $strSQL = 'SELECT lngIdEmpleado FROM tbempleados ORDER BY lngIdEmpleado DESC LIMIT 0,1';
        logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->IdUsuarioNuevo()|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        $db->desconectar ();
        $num=  mysql_num_rows($stmt);
        if($num>0){
            $row=  mysql_fetch_assoc($stmt);
            $numero=$row['lngIdEmpleado']+1;
        }else{
            $numero=1;
        }
        logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id(). " clsCADUsu->IdUsuarioNuevo():Numero: ".$numero);
        return $numero;
    }
    
    function IdCliProv(){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());
                  
        $strSQL = 'SELECT IdCliProv FROM tbcliprov ORDER BY IdCliProv DESC LIMIT 0,1';
        logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->IdCliProv()|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        $db->desconectar ();
        $num=  mysql_num_rows($stmt);
        if($num>0){
            $row=  mysql_fetch_assoc($stmt);
            $numero=$row['IdCliProv']+1;
        }else{
            $numero=1;
        }
        logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id(). " clsCADUsu->IdCliProv():Numero: ".$numero);
        return $numero;
    }
    
    function DatosCuenta($IdCuenta){
        require_once '../general/'.$_SESSION['mapeo'];
        $db = new Db();
        $db->conectar($this->getStrBD());
                  
        $strSQL = 'SELECT IdCuenta,NumCuenta,Grupo,SubGrupo2,SubGrupo4,Nombre FROM tbcuenta WHERE IdCuenta='.$IdCuenta;
        logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->DatosCuenta($IdCuenta)|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        $db->desconectar ();

        //aqui guardo los datos de la consulta
        $arDoc='';
        if($stmt){
            //tengo datos, los guardo en un array
            $row=  mysql_fetch_array($stmt,MYSQL_ASSOC);
            $arDoc=array("IdCuenta"=>$row['IdCuenta'],
                         "NumCuenta"=>$row['NumCuenta'],
                         "Grupo"=>$row['Grupo'],
                         "SubGrupo2"=>$row['SubGrupo2'],
                         "SubGrupo4"=>$row['SubGrupo4'],
                         "Nombre"=>$row['Nombre']
            );
            return $arDoc;
        }else{
            //no hay datos
            return '';
        }
    }
    
    function ListadoASP_Borra($strNombre,$strApellidos){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());
        
//        //extraigo los datos de los usuarios de las tablas 'tbusuarios', 'tbempleados', 'tbdepartamentos' y 'tbcargos'
//        $strSQL = "SELECT E.lngIdEmpleado, E.strNombre, E.strApellidos, D.strDescripcion, C.strCargo " .
//                  "FROM tbempleados E, tbdepartamentos D, tbusuarios U, tbcargos C " .
//                  " WHERE E.lngIdDepartamento = D.lngId AND E.lngIdEmpleado = U.lngIdEmpleado AND U.lngPermiso = C.lngId " .
//                  " AND E.lngIdEmpleado <> 0 AND U.strPassword <> '9999' AND E.IdEmpresa=".$_SESSION['idEmp'].
//                  " AND E.lngStatus<>0";
        
        //extraigo los datos de los usuarios de las tablas 'tbusuarios', 'tbempleados'
        $strSQL = "
                    SELECT E.lngIdEmpleado,E.strNombre,E.strApellidos,E.lngTelefono,E.lngMovil,E.strCorreo,U.strUsuario,U.strPassword,U.strPuesto
                    FROM tbempleados E,tbusuarios U
                    WHERE E.IdEmpresa=".$_SESSION['idEmp']."
                    AND E.lngIdEmpleado=U.lngIdEmpleado
                    AND U.lngStatus<>0
                    ";

        //incluyo los filtros
        if($strNombre<>''){
            $strSQL=$strSQL." AND E.strNombre='".$strNombre."'";
        }
        if($strApellidos<>''){
            $strSQL=$strSQL." AND E.strApellidos='".$strApellidos."'";
        }
//        if($strDepartamento<>''){
//            $strSQL=$strSQL." AND D.strDescripcion='".$strDepartamento."'";
//        }
        
        logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].
               ', SesionID: '.  session_id(). " clsCADUsu->ListadoASP_Borra($strNombre,$strApellidos,$strDepartamento)|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        $db->desconectar ();

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
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->ListadoASP_Borra(): SI hay datos");
            return $resultado;
        }else{
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->ListadoASP_Borra(): NO hay datos");
            return '';
        }
        
        
//        //aqui guardo los datos de la consulta
//        $arDoc='';
//        if($stmt){
//            //tengo datos
//            while($row=  mysql_fetch_array($stmt,MYSQL_ASSOC)){
//                $arDoc[]=array("Id"=>$row['lngIdEmpleado'],
//                               "strNombre"=>$row['strNombre'],
//                               "strApellidos"=>$row['strApellidos'],
//                               "strDepartamento"=>$row['strDescripcion'],
//                               "strPermiso"=>$row['strCargo']
//                );
//            }
//            return $arDoc;
//        }else{
//            //no hay datos
//            return '';
//        }
    }
    
    function ObtieneListaAprob_CliProv($strNombre,$strCIF,$tipo){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());
        
        // $tipo puede ser 'cliente' (cuenta 4300) o 'proveedor' (cuentas 4000 y 4100)
        //primero buscamos los que haya en las tablas tbcliprov, tbrelacioncliprov (dbcontabilidad) y tbcuenta (BBDD cliente)
        if($tipo==='cliente'){//4300
            $condicion="R.codigo LIKE '4300%'";
        }else//$tipo=1 => Proveedor=1 y Acreedor=2
        if($tipo==='proveedor'){//4000 y 4100
            $condicion="(R.codigo LIKE '4000%' OR R.codigo LIKE '4100%')";
        }

        //NO VALE
//        //extraigo los datos de los usuarios de las tablas 'tbusuarios', 'tbempleados', 'tbdepartamentos' y 'tbcargos'
//        $strSQL = "
//                  SELECT R.CliProv,R.codigo,R.IdRelacionCliProv ,CP.nombre,CIF FROM tbcliprov CP,tbrelacioncliprov R 
//                  WHERE CP.IdCliProv=R.IdCliProv 
//                  AND R.IdEmpresa=".$_SESSION['idEmp']." 
//                  AND $condicion 
//                  AND R.borrado = 0
//                  ";

        //extraigo los datos de los usuarios de las tablas 'tbusuarios', 'tbempleados', 'tbdepartamentos' y 'tbcargos'
        $strSQL = "
                  SELECT R.CliProv,R.codigo,R.IdRelacionCliProv ,CP.nombre,CIF 
                  FROM tbcliprov CP,tbrelacioncliprov R 
                  WHERE CP.IdCliProv=R.IdCliProv 
                  AND R.IdEmpresa=".$_SESSION['idEmp']." 
                  AND $condicion 
                  AND R.borrado = 0
                  ";

        //incluyo los filtros
        if($strNombre<>''){
            $strSQL=$strSQL." AND CP.nombre LIKE '%".$strNombre."%'";
        }
        if($strCIF<>''){
            $strSQL=$strSQL." AND CP.CIF like'%".$strCIF."%'";
        }
        logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].
               ', SesionID: '.  session_id(). " clsCADUsu->ObtieneListaAprob_CliProv($strNombre,$strCIF,$tipo)|| SQL : ".$strSQL);
        
        $stmt = $db->ejecutar ( $strSQL );
        $db->desconectar ();

        //aqui guardo los datos de la consulta
        $arDoc='';
        if($stmt){
            //tengo datos
            while($row=  mysql_fetch_array($stmt,MYSQL_ASSOC)){
//                //indico el tipo de cuenta que es (0=4300, 1=4000 y 2=4100)
//                if($row['CliProv']==='0'){
//                    $tipoCuenta='4300';
//                }else
//                if($row['CliProv']==='1'){
//                    $tipoCuenta='4000';
//                }else
//                if($row['CliProv']==='2'){
//                    $tipoCuenta='4100';
//                }
                $arDoc[]=array("IdRelacionCliProv"=>'CliProv-'.$row['IdRelacionCliProv'],
                               "Codigo"=>$row['codigo'],
                               "nombre"=>$row['nombre'],
                               "CIF"=>$row['CIF']
                );
            }
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->ObtieneListaAprob_CliProv($strNombre,$strCIF,$tipo): SI hay datos");
            
//        }else{
//            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
//                   " clsCADUsu->ObtieneListaAprob_CliProv($strNombre,$strCIF,$tipo): NO hay datos");
//            //no hay datos
//            return '';
        }
        
        //ahora busco los que hay en las tablas 'tbcuenta' y 'tbcontactos'
        // en este listado habra cuentas ya encontradas antes, estas se descartan lógicamente
        $strSQL = "
                    SELECT CU.IdCuenta,CO.IdCliProv,CU.NumCuenta,CU.Nombre,CO.CIF
                    FROM tbcuenta CU, tbmiscontactos CO
                    WHERE CU.IdCuenta=CO.idCuenta
                  ";
        
        //le indicamos el filtro de tipo
        if($tipo==='cliente'){//4300
            $strSQL = $strSQL ." AND CU.NumCuenta LIKE '4300%'";
        }else
        if($tipo==='proveedor'){//4000 y 4100
            $strSQL = $strSQL ." AND (CU.NumCuenta LIKE '4000%' OR CU.NumCuenta LIKE '4100%')";
        }

        require_once '../general/'.$_SESSION['mapeo'];
        $dbC = new Db();
        $dbC->conectar($this->getStrBDCliente());
        $stmt = $dbC->ejecutar ( $strSQL );
        $dbC->desconectar ();
        
        if($stmt){
            //tengo datos
            while($row=  mysql_fetch_array($stmt,MYSQL_ASSOC)){
                //primero reviso que esta cuenta no este ya en el array $arDoc
                //si el campo 'IdCliProv no es null es que está en el array
                if($row['IdCliProv']===NULL){
                    $arDoc[]=array("IdRelacionCliProv"=>'CuenCont-'.$row['IdCuenta'],
                                    "Codigo"=>$tipoCuenta.$row['NumCuenta'],
                                    "nombre"=>$row['Nombre'],
                                    "CIF"=>$row['CIF']
                            );
                }
            }
        }
        
        

        return $arDoc;
        
        
    }
    
    function ObtieneListaAprob_Cuentas($strNombre,$lngNumCuenta){
        require_once '../general/'.$_SESSION['mapeo'];
        $db = new Db();
        $db->conectar($this->getStrBD());
        //extraigo los datos de los usuarios de las tablas 'tbusuarios', 'tbempleados', 'tbdepartamentos' y 'tbcargos'
        $strSQL = "SELECT IdCuenta,Nombre,NumCuenta FROM tbcuenta WHERE borrado = 0";

        //incluyo los filtros
        if($strNombre<>''){
            $strSQL=$strSQL." AND Nombre like '%".$strNombre."%'";
        }
        if($lngNumCuenta<>''){
            $strSQL=$strSQL." AND NumCuenta like'%".$lngNumCuenta."%'";
        }
        logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].
               ', SesionID: '.  session_id(). " clsCADUsu->ObtieneListaAprob_Cuentas($strNombre,$lngNumCuenta)|| SQL : ".$strSQL);
        
        $stmt = $db->ejecutar ( $strSQL );
        $db->desconectar ();

        //aqui guardo los datos de la consulta
        $arDoc='';
        if($stmt){
            //tengo datos
            while($row=  mysql_fetch_array($stmt,MYSQL_ASSOC)){
                $arDoc[]=array("IdCuenta"=>$row['IdCuenta'],
                               "Nombre"=>$row['Nombre'],
                               "NumCuenta"=>$row['NumCuenta']
                );
            }
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->ObtieneListaAprob_Cuentas($strNombre,$lngNumCuenta): SI hay datos");
            return $arDoc;
        }else{
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->ObtieneListaAprob_Cuentas($strNombre,$lngNumCuenta): NO hay datos");
            //no hay datos
            return '';
        }
        
    }
    
    function ObtieneDepartamentoUsuario($usuario){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());
        
        $strSQL = "SELECT D.strDescripcion AS strDepartamento,D.lngId AS lngDepartamento
                    FROM tbempleados E, tbdepartamentos D
                    WHERE E.lngIdEmpleado=$usuario
                    AND E.lngIdDepartamento=D.lngId";
        logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id(). " clsCADUsu->ObtieneDepartamentoUsuario($usuario)|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        $db->desconectar ();
        if($stmt){
            //tengo datos
            while($row=  mysql_fetch_array($stmt,MYSQL_ASSOC)){
                $arcDoc=array("strDepartamento"=>$row['strDepartamento'],
                              "lngDepartamento"=>$row['lngDepartamento']
                );
            }
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id(). " clsCADUsu->ObtieneDepartamentoUsuario($usuario): Si hay datos");
            return $arcDoc;
        }else{
            //no hay datos
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id(). " clsCADUsu->ObtieneDepartamentoUsuario($usuario): No hay datos");
            return '';
        }
    }

    function Alta($num,$idEmp,$strNombre,$strApellidos,$lngTelefono,$lngMovil,$strCorreos,
                  $strUsuario,$strPassword){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());
        
        //como voy a realizar dos inserciones en las tablas 'tbempleados' y 'tbusuarios'
        //lo hare utilizando las transacciones en MySQL
        
        //controlo los datos de las variables $lngTelefono, $lngMovil
        if($lngTelefono===''){
            $lngTelefono=0;
        }
        if($lngMovil===''){
            $lngMovil=0;
        }
        
        //inserto datos del usuario en la tabla 'tbempleados'
        $db->ejecutar ("START TRANSACTION");
        logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADUsu->Alta()|| SQL : START TRANSACTION");
        
        $strSQL = "INSERT INTO tbempleados (lngIdEmpleado, IdEmpresa, strNombre, strApellidos, lngIdResponsable,lngIdDepartamento,strCorreo," .
                  "lngTelefono, lngMovil,lngStatus,datFechaStatus,lngIdEmpleadoStatus) " .
                  "values ( " . $num . " ," . $idEmp . " , '" .
                  $strNombre . "','" . $strApellidos . "', 0,0,'" . $strCorreos . "'," .
                  $lngTelefono . "," . $lngMovil .",1,now(),".$_SESSION['usuario'] .")";
        logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADUsu->Alta()|| SQL : ".$strSQL);
        $stmt1 = $db->ejecutar ( $strSQL );

        //ahora inserto datos en la tabla tbusuario
        $strSQL = "INSERT INTO tbusuarios (strUsuario, strPassword, lngIdEmpleado, lngPermiso, strPuesto,
                  lngStatus,datFechaStatus,lngIdEmpleadoStatus) " .
                  "values ( '" . $strUsuario . "','" . $strPassword . "'," . $num .
                  ",20,'Usuario',1,now(),".$_SESSION['usuario'] .")";
        logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADUsu->Alta()|| SQL : ".$strSQL);
        $stmt2 = $db->ejecutar ( $strSQL );

//        //y por último inserto datos en la tabla tbperfilempleado
//        //provisionalmente inserto como lngIdPerfil=4 (Usuario1)
//        $strSQL = "
//            SELECT IF(ISNULL(MAX(lngId)),1,MAX(lngId)+1) AS lngId FROM tbperfilempleado
//        ";
//        logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
//                " clsCADUsu->Alta()|| SQL : ".$strSQL);
//        $stmt = $db->ejecutar ( $strSQL );
//        if($stmt){
//            $row=  mysql_fetch_assoc($stmt);
//            $lngId=$row['lngId'];
//        }else{
//            return false;
//        }
        
        
//        $strSQL = "INSERT INTO tbperfilempleado (lngId, lngIdEmpleado, lngIdPerfil, datFecha) " .
//                  "values ($lngId,$num,4,now())";
//        logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
//                " clsCADUsu->Alta($num,$idEmp,$strNombre,$strApellidos,$lngTelefono,$lngExtension,$strCorreos,
//                  $lngDepartamento,$strUsuario,$strPassword)|| SQL : ".$strSQL);
//        $stmt3 = $db->ejecutar ( $strSQL );

        //ahora compruebo que las dos inserciones estan correctas, sino de deshace dicha transaccion
        if($stmt1==1 && $stmt2==1){
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADUsu->Alta()|| SQL : COMMIT");
            $db->ejecutar ("COMMIT");
            $db->desconectar ();
            return true;
        }else{
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADUsu->Alta()|| SQL : ROLLBACK");
            $db->ejecutar ("ROLLBACK");
            $db->desconectar ();
            return false;
        }
    }

    function AltaEmpresa($strEmpresa,$strCIF,$strPassword){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());
        
        //averiguo el valor idEmpresa mas alto que haya
        $strSQL = 'SELECT IdEmpresa FROM tbempresas ORDER BY IdEmpresa DESC LIMIT 0,1';
        logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADUsu->AltaEmpresa($strEmpresa,$strCIF,$strPassword)|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        $num=  mysql_num_rows($stmt);
        $numero=0;
        if($num>0){
            $row=  mysql_fetch_assoc($stmt);
            $numero=$row['IdEmpresa']+1;
        }else{
            $numero=1;
        }
        
        //inserto datos de la empresa en la tabla 'tbempresas'
        $strSQL = "INSERT INTO tbempresas(IdEmpresa,strPassword,strNombre,strSesion,strBD,strCIF,fechaAlta,fechaVencimiento,version,borrado)
                   values ( " . $numero . ",'" . $strPassword . "','" . $strEmpresa . "','contabilidad','contabilidad','" .
                   $strCIF . "',now(),now()+INTERVAL 15 DAY,1,0)";
        logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADUsu->AltaEmpresa($strEmpresa,$strCIF,$strPassword)|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        $db->desconectar ();

        //guardo los datos en un array
        $datos='';
        if($stmt){
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADUsu->AltaEmpresa($strEmpresa,$strCIF,$strPassword) : true");
            $datos=array(
                            "correcto"=>1,
                            "idEmpresa"=>$numero        
                        );
        }else{
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADUsu->AltaEmpresa($strEmpresa,$strCIF,$strPassword) : true");
            $datos=array(
                            "correcto"=>0,
                            "idEmpresa"=>""        
                        );
        }
        return $datos;
    }

    function Modificacion($num,$idEmp,$strNombre,$strApellidos,$lngTelefono,$lngMovil,$strCorreos,
                  $lngDepartamento,$strUsuario,$strPassword){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());
        
        //No se pueden cambiar los permisos de un responsable final
        // de departamento, asigne antes otro responsable para ese departamento
//        $idUsu=trim($num); //usuario actual
//        $idRespAux=$this->ObtieneRespDepartamento($idUsu);
//
//        if($idUsu==$idRespAux){
//            echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/error.php?id=No se pueden cambiar los permisos de un responsable final de departamento, asigne antes otro responsable para ese departamento">';
//        }
        
        //como voy a realizar dos actualizaciones en las tablas 'tbempleados' y 'tbusuarios'
        //lo hare utilizando las transacciones en MySQL
        
        //actualizo los datos del usuario en la tabla 'tbempleados'
        $db->ejecutar ("START TRANSACTION");
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->Modificacion($num,$idEmp,$strNombre,$strApellidos,$lngTelefono,$lngMovil,$strCorreos,
                  $lngDepartamento,$strUsuario,$strPassword)|| SQL : START TRANSACTION");
        
        $strSQL="UPDATE tbempleados
                 SET strNombre='".$strNombre."'
                     ,strApellidos='".$strApellidos."'
                     ,lngTelefono=".$lngTelefono."
                     ,lngMovil=".$lngMovil."
                     ,strCorreo='".$strCorreos."'
                     ,datFechaStatus=now()"."
                     ,lngIdEmpleadoStatus=".$_SESSION['usuario'].
                 " WHERE lngIdEmpleado=".$num;
        $stmt1 = $db->ejecutar ( $strSQL );
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->Modificacion()|| SQL : ".$strSQL);

        //y por último actualizo los datos en la tabla tbusuario
        $strSQL = "UPDATE tbusuarios 
                   SET strUsuario='".$strUsuario."'
                       ,strPassword='".$strPassword."'
                       ,datFechaStatus=now()
                       ,lngIdEmpleadoStatus= ".$_SESSION['usuario'].
                  " WHERE lngIdEmpleado=".$num;
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->Modificacion()|| SQL : ".$strSQL);
        $stmt2 = $db->ejecutar ( $strSQL );

        //ahora compruebo que las dos inserciones estan correctas, sino de deshace dicha transaccion
        if($stmt1==1 && $stmt2==1){
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->Modificacion()|| SQL : COMMIT");
            $db->ejecutar ("COMMIT");
            $db->desconectar ();
            return true;
        }else{
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->Modificacion()|| SQL : ROLLBACK");
            $db->ejecutar ("ROLLBACK");
            $db->desconectar ();
            return false;
        }
    }

    function DatosUsuario($id){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());

        //consulta recuperacion de los datos de la reclamacion
        $strSQL = 'SELECT E.strNombre,E.strApellidos,E.lngTelefono,E.lngMovil,E.strCorreo,E.lngIdDepartamento,
                   U.strUsuario,U.strPassword,U.lngPermiso FROM tbusuarios U, tbempleados E
                   WHERE E.lngIdEmpleado='.$id.' AND U.lngIdEmpleado=E.lngIdEmpleado';
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->DatosUsuario($id)|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        
        //aqui guardo los datos de la consulta
        $arDoc='';
        if($stmt){
            //tengo datos, los guardo en un array
            $row=  mysql_fetch_array($stmt,MYSQL_ASSOC);
            $arDoc=array("strNombre"=>$row['strNombre'],
                         "strApellidos"=>$row['strApellidos'],
                         "lngTelefono"=>$row['lngTelefono'],
                         "lngMovil"=>$row['lngMovil'],
                         "strCorreo"=>$row['strCorreo'],
                         "strDepartamento"=>$row['lngIdDepartamento'],
                         "strUsuario"=>$row['strUsuario'],
                         "strPassword"=>$row['strPassword'],
                         "Permiso"=>$row['lngPermiso']
            );
            //tengo el numero del dpto, busco su nombre
            $strSQL = 'SELECT strDescripcion FROM tbdepartamentos WHERE lngId='.$arDoc['strDepartamento'];
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->DatosUsuario($id)|| SQL : ".$strSQL);
            $stmt = $db->ejecutar ( $strSQL );
            $row=  mysql_fetch_array($stmt,MYSQL_ASSOC);
            $arDoc['strDepartamento']=$row['strDescripcion'];
            $db->desconectar ();
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->DatosUsuario($id): SI hay datos");
            return $arDoc;
        }else{
            $db->desconectar ();
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->DatosUsuario($id): No hay datos");
            //no hay datos
            return '';
        }
    }

    function DatosCliProv($IdRelacionCliProv){
        require_once '../general/conexion.php';
        $dbG = new DbC();
        $dbG->conectar($this->getStrBD());

        //averiguo si es de la tabla tbCliProv o de tbContacto
        $dato=explode('-',$IdRelacionCliProv);
        //si es 'CliProv' buscamos los datos en la tabla tbCliProv' de dbContabilidad
        if($dato[0]==='CliProv'){
            //consulta 
            $strSQL = "SELECT CP.IdCliProv,CP.nombre,CP.CIF,CP.direccion,CP.municipio,CP.provincia,
                       CP.CP,CP.Telefono1,CP.Telefono2,CP.Fax,CP.Correo,CP.Correo2,
                       CP.actividad,CP.CNAE,CP.NumSS
                       FROM tbcliprov CP,tbrelacioncliprov R
                       WHERE CP.IdCliProv=R.IdCliProv
                       AND R.IdRelacionCliProv=".$dato[1]." AND CP.Borrado = 0";
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->DatosCliProv($IdRelacionCliProv)|| SQL : ".$strSQL);

            $stmt = $dbG->ejecutar ( $strSQL );

            //aqui guardo los datos de la consulta
            $arDoc='';
            if($stmt){
                //tengo datos, los guardo en un array
                $row=  mysql_fetch_array($stmt,MYSQL_ASSOC);
                $arDoc=array("IdCliProv"=>$row['IdCliProv'],
                             "nombre"=>$row['nombre'],
                             "CIF"=>$row['CIF'],
                             "actividad"=>$row['actividad'],
                             "CP"=>$row['CP'],
                             "direccion"=>$row['direccion'],
                             "municipio"=>$row['municipio'],
                             "provincia"=>$row['provincia'],
                             "Correo"=>$row['Correo'],
                             "Correo2"=>$row['Correo2'],
                             "Telefono1"=>$row['Telefono1'],
                             "Telefono2"=>$row['Telefono2'],
                             "Fax"=>$row['Fax'],
                             "CNAE"=>$row['CNAE'],
                             "NumSS"=>$row['NumSS'],
                             "strCCRecibos"=>'',
                             "TieneAsientos"=>'NO',
                             "TienePresupuestos"=>'NO',
                             "TieneFacturas"=>'NO',
                );
                //ahora compruebo si tienes o no asientos
                //primero extraigo la cuenta y tambien la CC Recibos
                $strSQL = "
                            SELECT CliProv,Codigo,CC_Recibos
                            FROM tbrelacioncliprov
                            WHERE IdRelacionCliProv=".$dato[1]." AND Borrado = 0
                          ";

                $stmt = $dbG->ejecutar ( $strSQL );
                $row=  mysql_fetch_array($stmt);
                $dbG->desconectar ();

                $numCuenta=$row['Codigo'];
                $arDoc['strCCRecibos']=$row['CC_Recibos'];

                //ahora extraigo si hay asientos en la tabla 'tbmovimientos'
                require_once '../general/'.$_SESSION['mapeo'];
                $dbC = new Db();
                $dbC->conectar($this->getStrBD());

                $strSQL = "
                            SELECT IdMovimiento
                            FROM tbmovimientos
                            WHERE idCuenta=$numCuenta AND Borrado = 1
                          ";

                $stmt = $dbC->ejecutar ( $strSQL );

                logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " clsCADUsu->DatosCliProv($IdRelacionCliProv)|| SQL : ".$strSQL);

                $num=  mysql_num_rows($stmt);
                if($num>0){
                    $arDoc['TieneAsientos']='SI';
                }else{
                    $arDoc['TieneAsientos']='NO';
                }
                
                //ahora compruebo si hay presupuestos asociados a esta cuenta
                $strSQL = "
                            SELECT IdPresupuesto
                            FROM tbmispresupuestos
                            WHERE Contacto_Cliente='CL.$numCuenta' AND Borrado = 1
                          ";

                $stmt = $dbC->ejecutar ( $strSQL );

                logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " clsCADUsu->DatosCliProv($IdRelacionCliProv)|| SQL : ".$strSQL);

                $num=  mysql_num_rows($stmt);
                if($num>0){
                    $arDoc['TienePresupuestos']='SI';
                }else{
                    $arDoc['TienePresupuestos']='NO';
                }
                
                //y por ultimo compruebo si tiene facturas
                $strSQL = "
                            SELECT IdFactura
                            FROM tbmisfacturas
                            WHERE Cliente='$numCuenta' AND Borrado = 1
                          ";

                $stmt = $dbC->ejecutar ( $strSQL );
                $dbC->desconectar ();

                logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " clsCADUsu->DatosCliProv($IdRelacionCliProv)|| SQL : ".$strSQL);

                $num=  mysql_num_rows($stmt);
                if($num>0){
                    $arDoc['TieneFacturas']='SI';
                }else{
                    $arDoc['TieneFacturas']='NO';
                }

                logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " clsCADUsu->DatosCliProv($IdRelacionCliProv): SI hay datos");
            }else{
                logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " clsCADUsu->DatosCliProv($IdRelacionCliProv): No hay datos");
                //no hay datos
                return '';
            }
        }else
        //si es 'CuenCont' buscamos los datos en la tabla 'tbmiscontactos'
        if($dato[0]==='CuenCont'){
            require_once '../general/'.$_SESSION['mapeo'];
            $dbC = new Db();
            $dbC->conectar($this->getStrBD());
            
            $strSQL = "
                        SELECT C.IdCliProv,C.NombreEmpresa,C.CIF,C.CodPostal,C.Direccion,C.Ciudad,C.Provincia,C.Correo,C.Telefono
                        FROM tbmiscontactos C
                        WHERE idCuenta=".$dato[1]."
                        AND C.Borrado=1
            ";

            $stmt = $dbC->ejecutar ( $strSQL );

            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->DatosCliProv($IdRelacionCliProv)|| SQL : ".$strSQL);
            
            //aqui guardo los datos de la consulta
            $arDoc='';
            if($stmt){
                //tengo datos, los guardo en un array
                $row=  mysql_fetch_array($stmt,MYSQL_ASSOC);
                $arDoc=array("IdCliProv"=>$row['IdCliProv'],
                             "nombre"=>$row['NombreEmpresa'],
                             "CIF"=>$row['CIF'],
                             "actividad"=>'',
                             "CP"=>$row['CodPostal'],
                             "direccion"=>$row['Direccion'],
                             "municipio"=>$row['Ciudad'],
                             "provincia"=>$row['Provincia'],
                             "Correo"=>$row['Correo'],
                             "Correo2"=>$row['Correo2'],
                             "Telefono1"=>$row['Telefono'],
                             "Telefono2"=>'',
                             "Fax"=>'',
                             "CNAE"=>'',
                             "NumSS"=>'',
                             "strCCRecibos"=>'',
                             "TieneAsientos"=>'NO',
                             "TienePresupuestos"=>'NO',
                             "TieneFacturas"=>'NO',
                );
                //ahora compruebo si tienes o no asientos
                //extraigo si hay asientos en la tabla 'tbmovimientos'
                $strSQL = "
                            SELECT CU.NumCuenta
                            FROM tbmiscontactos CO, tbcuenta CU
                            WHERE CU.IdCuenta=CO.idCuenta
                            AND CU.IdCuenta=".$dato[1]."
                          ";

                $stmt = $dbC->ejecutar ( $strSQL );
                $row=  mysql_fetch_array($stmt,MYSQL_ASSOC);
                
                $strSQL = "
                             SELECT M.IdMovimiento
                             FROM tbmovimientos M
                             WHERE M.idCuenta='".$row['NumCuenta']."'
                             AND M.Borrado=1
                          ";
                
                $stmt = $dbC->ejecutar ( $strSQL );

                logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " clsCADUsu->DatosCliProv($IdRelacionCliProv)|| SQL : ".$strSQL);

                $num=  mysql_num_rows($stmt);
                if($num>0){
                    $arDoc['TieneAsientos']='SI';
                }else{
                    $arDoc['TieneAsientos']='NO';
                }
                
                // y por ultimo compruebo si hay presupuestos asociados a esta cuenta
                // (un contacto no hace facturas)
                $strSQL = "
                            SELECT IdPresupuesto
                            FROM tbmispresupuestos
                            WHERE Contacto_Cliente='CO.$numCuenta' AND Borrado = 1
                          ";

                $stmt = $dbC->ejecutar ( $strSQL );
                $dbC->desconectar ();

                logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " clsCADUsu->DatosCliProv($IdRelacionCliProv)|| SQL : ".$strSQL);

                $num=  mysql_num_rows($stmt);
                if($num>0){
                    $arDoc['TienePresupuestos']='SI';
                }else{
                    $arDoc['TienePresupuestos']='NO';
                }

                logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " clsCADUsu->DatosCliProv($IdRelacionCliProv): SI hay datos");
            }else{
                logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " clsCADUsu->DatosCliProv($IdRelacionCliProv): No hay datos");
                //no hay datos
                return '';
            }
        }
        
        return $arDoc;
        
    }

    function usuarioBorrar($id){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());

        //consulta borrar los datos del usuario de las tablas 'tbusuarios' y 'tbempleados'
        //se hace por transaccion
        $db->ejecutar ("START TRANSACTION");
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->usuarioBorrar($id)|| SQL : START TRANSACTION");
        
        $strSQL = 'UPDATE tbusuarios SET lngStatus=0, datFechaStatus=now(), lngIdEmpleadoStatus='.$_SESSION['usuario'].' WHERE lngIdEmpleado='.$id;
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->usuarioBorrar($id)|| SQL : ".$strSQL);
        $stmt1 = $db->ejecutar ( $strSQL );

        $strSQL = 'UPDATE tbempleados SET lngStatus=0, datFechaStatus=now(), lngIdEmpleadoStatus='.$_SESSION['usuario'].' WHERE lngIdEmpleado='.$id;
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->usuarioBorrar($id)|| SQL : ".$strSQL);
        $stmt2 = $db->ejecutar ( $strSQL );

        //comprobacion de las actualizaciones se han llevado a cabo
        if($stmt1==1 && $stmt2==1){
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->usuarioBorrar($id)|| SQL : COMMIT");
            $db->ejecutar ("COMMIT");
            $db->desconectar ();
            return true;
        }else{
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->usuarioBorrar($id)|| SQL : ROLLBACK");
            $db->ejecutar ("ROLLBACK");
            $db->desconectar ();
            return false;
        }
    }
    
    function cliprovBorrar($id){
        require_once '../general/conexion.php';
        $dbG = new DbC();
        $dbG->conectar($this->getStrBD());

        //primero extraigo el numero de cuenta
        $strSQL = "SELECT CliProv,Codigo " .
                  "FROM tbrelacioncliprov" .
                  " WHERE IdRelacionCliProv =" . $id;
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->cliprovBorrar($id)|| SQL : ".$strSQL);
        $stmt = $dbG->ejecutar ( $strSQL );
        if($stmt){
            $row=  mysql_fetch_array($stmt);
            if($row['CliProv']==='1'){
                $NumCuenta='4000';
            }else{
                $NumCuenta='4300';
            }
            $NumCuenta=$row['Codigo'];
        }else{
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->cliprovBorrar($id)|| Fallo al borrar");
            $dbG->desconectar();
            return false;
        }
        
        //primero borro de la BBDD de Contabilidad de la tabla tbrelacioncliprov
        $strSQL = "UPDATE tbrelacioncliprov " .
                  " SET borrado = '1'" .
                  " WHERE IdRelacionCliProv =" . $id;
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->cliprovBorrar($id)|| SQL : ".$strSQL);
        $stmt = $dbG->ejecutar ( $strSQL );
        if(!$stmt){
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->cliprovBorrar($id)|| Fallo al borrar");
            return false;
        }
        
        //preparo la consulta a ejecutar (desaher el borrado anterior) por si falla la siguiente consulta
        $strSQL_Recuperar = "UPDATE tbrelacioncliprov " .
                  " SET borrado = '0'" .
                  " WHERE IdRelacionCliProv =" . $id;
        
        //ahora borramos en la BBDD cliente la tabla 'tbcuenta'
        require_once '../general/'.$_SESSION['mapeo'];
        $dbC = new Db();
        $dbC->conectar($this->getStrBD());

        $strSQL = "UPDATE tbcuenta " .
                  " SET borrado = '1'" .
                  " WHERE NumCuenta =" . $NumCuenta;
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->cliprovBorrar($id)|| SQL : ".$strSQL);
        $stmt = $dbC->ejecutar ( $strSQL );
        $dbC->desconectar();
        
        if(!$stmt){
            //ha dado error al borrar por lo que tengo que dehacer el anterior borrado
            $dbG->ejecutar($strSQL_Recuperar);
            return false;
        }
        
        //si todas las operaciones estan correctas devolvemos true
        return true;
    }
    
    function cuentaBorrar($id){
        require_once '../general/'.$_SESSION['mapeo'];
        $db = new Db();
        $db->conectar($this->getStrBD());

        $strSQL = "UPDATE tbcuenta " .
                  " SET Borrado = '1'" .
                  " WHERE IdCuenta =" . $id;
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->cuentaBorrar($id)|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        $db->desconectar ();
        if($stmt==1){
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->cuentaBorrar($id)|| Borrado");
            return true;
        }else{
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->cuentaBorrar($id)|| Fallo al borrar");
            return false;
        }
    }
    
    function ObtieneRespDepartamento($lngDepartamento){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());
        $strSQL='SELECT * FROM tbdepresp WHERE lngIdDepartamento='.$lngDepartamento;
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->ObtieneRespDepartamento($lngDepartamento)|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        $db->desconectar ();
        if($stmt){
            $row=  mysql_fetch_array($stmt);
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->ObtieneRespDepartamento($lngDepartamento)|| lngDepartamento= : ".$row['lngIdResponsable']);
            return $row['lngIdResponsable'];
        }else{
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->ObtieneRespDepartamento($lngDepartamento)|| lngDepartamento= : -1");
            return -1;
        }
    }
    
    function AltaCliente($num,$strNombre,$strCIF,$strActividad,$lngCP,$strDireccion,$strMunicipio,$strProvincia,
                         $strEmail,$strEmail2,$lngTelefono1,$lngTelefono2,$lngFax,$lngCodigo,$numCuenta,$numEmpresa,$cliProv,$strCCRecibos){
        //conexion BBDD contabilidad
        require_once '../general/conexion.php';
        $dbG = new DbC();
        $dbG->conectar($this->getStrBD());
        
        //como se realizan varias operaciones contra la BBDD lo hacemos por transaccion
        $dbG->ejecutar ("START TRANSACTION");
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->AltaCliente()|| SQL : START TRANSACTION BBDD contabilidad");

        //primero guardo la informacion que hay actualmente (por si hay que deshacer mas adelante)
        $strSQL="SELECT * FROM tbcliprov WHERE IdCliProv=$num";
        $stmt=$dbG->ejecutar($strSQL);
        
        if($stmt){
            $row= mysql_fetch_array($stmt);
            //dejo preparada la consulta para restaurar los valores actuales si fallase en la BBDD cliente
            $strSQL_tbcliprov='UPDATE tbcliprov SET
                     nombre="'.$row['nombre'].'",
                     CIF="'.$row['CIF'].'",
                     Actividad="'.$row['Actividad'].'",
                     CP="'.$row['CP'].'",
                     direccion="'.$row['direccion'].'",
                     municipio="'.$row['municipio'].'",
                     provincia="'.$row['provincia'].'",
                     correo="'.$row['Correo'].'",
                     correo2="'.$row['Correo2'].'",
                     Telefono1="'.$row['Telefono1'].'",
                     Telefono2="'.$row['Telefono2'].'",
                     Fax="'.$row['Fax'].'"
                     WHERE IdCliProv='.$num;
        }else{
            //si ha fallado la consulta hacemos ROLLBACK Y DEVOLVEMOS false
            $dbG->ejecutar ("ROLLBACK");
            $dbG->desconectar ();
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->AltaCliente()<ROLLBACK");
            return false;
        }
        
        //ahora actualizamos la tabla 'tbcliprov' los datos del cliente/proveedor
        $strSQL='UPDATE tbcliprov SET
                 nombre="'.$strNombre.'",
                 CIF="'.$strCIF.'",
                 Actividad="'.$strActividad.'",
                 CP="'.$lngCP.'",
                 direccion="'.$strDireccion.'",
                 municipio="'.$strMunicipio.'",
                 provincia="'.$strProvincia.'",
                 correo="'.$strEmail.'",
                 correo2="'.$strEmail2.'",
                 Telefono1="'.$lngTelefono1.'",
                 Telefono2="'.$lngTelefono2.'",
                 Fax="'.$lngFax.'"
                 WHERE IdCliProv='.$num;
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->AltaCliente()|| SQL : ".$strSQL);
        $stmt1 = $dbG->ejecutar ( $strSQL );
        
        if(!$stmt1){
            //si ha fallado la consulta hacemos ROLLBACK Y DEVOLVEMOS false
            $dbG->ejecutar ("ROLLBACK");
            $dbG->desconectar ();
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->AltaCliente()<ROLLBACK");
            return false;
        }
        
        //ahora insertamos en la tabla 'tbrelacioncliprov'
        //primero buscamos el numero mas alto de 'IdRelacionCliProv'
        $strSQL='SELECT IdRelacionCliProv FROM tbrelacioncliprov ORDER BY IdRelacionCliProv DESC LIMIT 0,1';
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->AltaCliente()|| SQL : ".$strSQL);
        $stmt2 = $dbG->ejecutar ( $strSQL );
        
        if($stmt2){
            $num1=  mysql_num_rows($stmt2);
            $IdRelacionCliProv=0;
            if($num1>0){
                $row=  mysql_fetch_assoc($stmt2);
                $IdRelacionCliProv=$row['IdRelacionCliProv']+1;
            }else{
                $IdRelacionCliProv=1;
            }
        }else{
            //si ha fallado la consulta hacemos ROLLBACK Y DEVOLVEMOS false
            $dbG->ejecutar ("ROLLBACK");
            $dbG->desconectar ();
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->AltaCliente()<ROLLBACK");
            return false;
        }

        // Y ahora hacemos la insercion
        $strSQL="INSERT INTO tbrelacioncliprov (IdRelacionCliProv, IdEmpresa, Codigo, IdCliProv,Borrado,CliProv,CC_Recibos)
                 VALUES ( " . $IdRelacionCliProv . " , " . $numEmpresa . ",'" . $numCuenta . "'," . $num . ", '0' , " . $cliProv . ",'$strCCRecibos')";
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->AltaCliente()|| SQL : ".$strSQL);
        $stmt3 = $dbG->ejecutar ( $strSQL );
        
        if($stmt3){
            //preparo la consulta para borrar esta insercion en esta tbal por si fallase en la BBDD cliente las operaciones
            $strSQL_tbrelacioncliprov="DELETE FROM tbrelacioncliprov WHERE IdRelacionCliProv=$IdRelacionCliProv";
        }else{
            //si ha fallado la consulta hacemos ROLLBACK Y DEVOLVEMOS false
            $dbG->ejecutar ("ROLLBACK");
            $dbG->desconectar ();
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->AltaCliente()<ROLLBACK");
            return false;
        }
        
        //-------------------------------------------------------------
        //si todas las operaciones contra la BBDD contabilidad han sido correctas, se hace COMMIT
        $dbG->ejecutar ("COMMIT");
        $dbG->desconectar ();
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->AltaCliente()<COMMIT contabilidad");
        
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->AltaCliente()>COMIENZA LAS OPERACIONES CONTRA BBDD CLIENTE");
        
        
        //Por último hacemos la inserción en la tabla 'tbcuentas' de la BBDD de cliente
        //conexion BBDD cliente
        require_once '../general/'.$_SESSION['mapeo'];
        $dbC = new Db();
        $dbC->conectar($this->getStrBDCliente());
        
        //Por último hacemos la inserción en la tabla 'tbcuentas'
        //primero buscamos el numero mas alto de 'IdCuenta'
        $strSQL='SELECT IdCuenta FROM tbcuenta ORDER BY IdCuenta DESC LIMIT 0,1';
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->AltaCliente()|| SQL : ".$strSQL);
        $stmt4 = $dbC->ejecutar ( $strSQL );
        if($stmt4){
            $num2=  mysql_num_rows($stmt4);
            $numeroCuenta=0;
            if($num2>0){
                $row=  mysql_fetch_assoc($stmt4);
                $numeroCuenta=$row['IdCuenta']+1;
            }else{
                $numeroCuenta=1;
            }
        }else{
            //si ha fallado la consulta borramos la insercion en la BBDD contabilidad en la tabla 
            //'tbrelacioncliprov' segun el campo IdRelacionCliProv y actualizamos a los datos anteriores
            //de la tabla 'tbcliprov' segun el campo IdCliProv y DEVOLVEMOS false
            $dbC->desconectar ();
            //vuelvo a conectarme a la BBDD contabilidad
            $dbG->conectar($this->getStrBD());
            //actualizamos los datos de la tabla 'tbcliprov' (los antiguos)
            $stmtB1=$dbG->ejecutar($strSQL_tbcliprov);
            //borramos los datos de la tabla 'tbrelacioncliprov'
            $stmtB2=$dbG->ejecutar($strSQL_tbrelacioncliprov);
            $dbG->desconectar();
            if($stmtB1==true && $stmtB2==true){
                logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " clsCADUsu->AltaCliente()<ERROR (se desacen la actualizacion de la tabla 'tbcliprov'
                         por el campo IdCliProv=$num y de la insercion de la tabla 'tbrelacioncliprov' por el campo IdRelacionCLiProv=$IdRelacionCliProv");
            }else{
                logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " clsCADUsu->AltaCliente()<ERROR: NO SE HA ACTUALIZADO LOS DATOS ORIGINALES DE LA TABLA 'tbcliprov'
                         por el campo IdCliProv=$num : LA INSTRUCCION SQL QUE HA FALLADO ES=$strSQL_tbcliprov
                         Y DE LA TABLA 'tbrelacioncliprov' por el campo IdRelacionCLiProv=$IdRelacionCliProv");
            }
            return false;
        }
        
        // Y ahora hacemos la insercion
        $strSQL="INSERT INTO tbcuenta (IdCuenta, NumCuenta, Grupo, SubGrupo2, SubGrupo4, Nombre, Borrado)
                 VALUES (" . $numeroCuenta . " , '" . $numCuenta . "'," . substr($numCuenta,0,1) . "," . substr($numCuenta,0,2) .
                 "," . substr($numCuenta,0,4) . ",'$strNombre',0)";
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->AltaCliente()|| SQL : ".$strSQL);
        $stmt5 = $dbC->ejecutar ( $strSQL );
  
        if(!$stmt5){
            //si ha fallado la consulta borramos la insercion en la BBDD contabilidad en la tabla 
            //'tbrelacioncliprov' segun el campo IdRelacionCliProv y actualizamos a los datos anteriores
            //de la tabla 'tbcliprov' segun el campo IdCliProv y DEVOLVEMOS false
            $dbC->desconectar ();
            //vuelvo a conectarme a la BBDD contabilidad
            $dbG->conectar($this->getStrBD());
            //actualizamos los datos de la tabla 'tbcliprov' (los antiguos)
            $stmtB1=$dbG->ejecutar($strSQL_tbcliprov);
            //borramos los datos de la tabla 'tbrelacioncliprov'
            $stmtB2=$dbG->ejecutar($strSQL_tbrelacioncliprov);
            $dbG->desconectar();
            if($stmtB1==true && $stmtB2==true){
                logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " clsCADUsu->AltaCliente()<ERROR (se desacen la actualizacion de la tabla 'tbcliprov'
                         por el campo IdCliProv=$num y de la insercion de la tabla 'tbrelacioncliprov' por el campo IdRelacionCLiProv=$IdRelacionCliProv");
            }else{
                logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " clsCADUsu->AltaCliente()<ERROR: NO SE HA ACTUALIZADO LOS DATOS ORIGINALES DE LA TABLA 'tbcliprov'
                         por el campo IdCliProv=$num : LA INSTRUCCION SQL QUE HA FALLADO ES=$strSQL_tbcliprov
                         Y DE LA TABLA 'tbrelacioncliprov' por el campo IdRelacionCLiProv=$IdRelacionCliProv");
            }
            return false;
        }
        
        //-------------------------------------------------------------
        //si todas las operaciones contra la BBDD se han efectuado correctamente se hace COMMIT y devolvemos true
        $dbC->ejecutar ("COMMIT");
        $dbC->desconectar ();
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->AltaCliente()<COMMIT");
        return true;
    }
    
    function PasarContactoAClienteNuevo($num,$strNombre,$strCIF,$strActividad,$lngCP,$strDireccion,$strMunicipio,$strProvincia,
                         $strEmail,$lngTelefono1,$lngTelefono2,$lngFax,$lngCodigo,$numCuenta,$numEmpresa,$cliProv){
        //conexion BBDD contabilidad
        require_once '../general/conexion.php';
        $dbG = new DbC();
        $dbG->conectar($this->getStrBD());
        
        //como se realizan varias operaciones contra la BBDD lo hacemos por transaccion
        $dbG->ejecutar ("START TRANSACTION");
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->AltaClienteNuevo()|| SQL : START TRANSACTION BBDD contabilidad");
        
        //primero inserto en la tabla 'tbcliprov' los datos del cliente/proveedor nuevo
        $strSQL="INSERT INTO tbcliprov (IdCliProv, nombre, CIF, direccion,municipio,provincia," .
        "CP,Telefono1,Telefono2,Fax,Correo,Actividad,Borrado) " .
        "VALUES ( " . $num . " , '" . $strNombre . "','" . $strCIF . "','" . $strDireccion . "','"
        . $strMunicipio . "','" . $strProvincia . "', '" . $lngCP . "','" . $lngTelefono1 . "', '" . $lngTelefono2 . "', '"
        . $lngFax . "','" . $strEmail . "', '" . $strActividad . "',0)";
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->AltaClienteNuevo()|| SQL : ".$strSQL);
        $stmt2 = $dbG->ejecutar ( $strSQL );

        if(!$stmt2){
            //si ha fallado la consulta hacemos ROLLBACK Y DEVOLVEMOS false
            $dbG->ejecutar ("ROLLBACK");
            $dbG->desconectar ();
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->AltaClienteNuevo()<ROLLBACK");
            return false;
        }
        
        //para controlar en las operaciones contra la BBDD cliente si hubiese error deshacer estas inserciones realizadas en contabilidad
        $IdCliProv=$num;
        
        //ahora insertamos en la tabla 'tbrelacioncliprov'
        //primero buscamos el numero mas alto de 'IdRelacionCliProv'
        $strSQL='SELECT IdRelacionCliProv FROM tbrelacioncliprov ORDER BY IdRelacionCliProv DESC LIMIT 0,1';
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->AltaClienteNuevo()|| SQL : ".$strSQL);
        $stmt3 = $dbG->ejecutar ( $strSQL );
        if($stmt3){
            $num1=  mysql_num_rows($stmt3);
            $IdRelacionCliProv=0;
            if($num1>0){
                $row=  mysql_fetch_assoc($stmt3);
                $IdRelacionCliProv=$row['IdRelacionCliProv']+1;
            }else{
                $IdRelacionCliProv=1;
            }
        }else{
            //si ha fallado la consulta hacemos ROLLBACK Y DEVOLVEMOS false
            $dbG->ejecutar ("ROLLBACK");
            $dbG->desconectar ();
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->AltaClienteNuevo()<ROLLBACK");
            return false;
        }
        
        // Y ahora hacemos la insercion
        $strSQL="INSERT INTO tbrelacioncliprov (IdRelacionCliProv, IdEmpresa, Codigo, IdCliProv,Borrado)
                 VALUES ( " . $IdRelacionCliProv . " , " . $numEmpresa . ",'" . $numCuenta . "'," . $num . ", '0')";
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->AltaClienteNuevo()|| SQL : ".$strSQL);
        $stmt4 = $dbG->ejecutar ( $strSQL );

        if(!$stmt4){
            //si ha fallado la consulta hacemos ROLLBACK Y DEVOLVEMOS false
            $dbG->ejecutar ("ROLLBACK");
            $dbG->desconectar ();
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->AltaClienteNuevo()<ROLLBACK");
            return false;
        }
        
        //-------------------------------------------------------------
        //si todas las operaciones contra la BBDD contabilidad han sido correctas, se hace COMMIT
        $dbG->ejecutar ("COMMIT");
        $dbG->desconectar ();
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->AltaClienteNuevo()<COMMIT contabilidad y devolvemos TRUE");
        
        return true;
    }
    
    function AltaClienteNuevo($num,$strNombre,$strCIF,$strActividad,$lngCP,$strDireccion,$strMunicipio,$strProvincia,
                         $strEmail,$strEmail2,$lngTelefono1,$lngTelefono2,$lngFax,$lngCodigo,$numCuenta,$numEmpresa,$cliProv,$strCCRecibos){
        //conexion BBDD contabilidad
        require_once '../general/conexion.php';
        $dbG = new DbC();
        $dbG->conectar($this->getStrBD());
        
        //como se realizan varias operaciones contra la BBDD lo hacemos por transaccion
        $dbG->ejecutar ("START TRANSACTION");
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->AltaClienteNuevo()|| SQL : START TRANSACTION BBDD contabilidad");
        
        //primero inserto en la tabla 'tbcliprov' los datos del cliente/proveedor nuevo
        $strSQL="INSERT INTO tbcliprov (IdCliProv, nombre, CIF, direccion,municipio,provincia," .
        "CP,Telefono1,Telefono2,Fax,Correo,Correo2,Actividad,Borrado) " .
        "VALUES ( " . $num . " , '" . $strNombre . "','" . $strCIF . "','" . $strDireccion . "','"
        . $strMunicipio . "','" . $strProvincia . "', '" . $lngCP . "','" . $lngTelefono1 . "', '" . $lngTelefono2 . "', '"
        . $lngFax . "','" . $strEmail . "','" . $strEmail2 . "', '" . $strActividad . "',0)";
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->AltaClienteNuevo()|| SQL : ".$strSQL);
        $stmt2 = $dbG->ejecutar ( $strSQL );

        if(!$stmt2){
            //si ha fallado la consulta hacemos ROLLBACK Y DEVOLVEMOS false
            $dbG->ejecutar ("ROLLBACK");
            $dbG->desconectar ();
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->AltaClienteNuevo()<ROLLBACK");
            return false;
        }
        
        //para controlar en las operaciones contra la BBDD cliente si hubiese error deshacer estas inserciones realizadas en contabilidad
        $IdCliProv=$num;
        
        //ahora insertamos en la tabla 'tbrelacioncliprov'
        //primero buscamos el numero mas alto de 'IdRelacionCliProv'
        $strSQL="SELECT IdRelacionCliProv FROM tbrelacioncliprov ORDER BY IdRelacionCliProv DESC LIMIT 0,1";
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->AltaClienteNuevo()|| SQL : ".$strSQL);
        $stmt3 = $dbG->ejecutar ( $strSQL );
        if($stmt3){
            $num1=  mysql_num_rows($stmt3);
            $IdRelacionCliProv=0;
            if($num1>0){
                $row=  mysql_fetch_assoc($stmt3);
                $IdRelacionCliProv=$row['IdRelacionCliProv']+1;
            }else{
                $IdRelacionCliProv=1;
            }
        }else{
            //si ha fallado la consulta hacemos ROLLBACK Y DEVOLVEMOS false
            $dbG->ejecutar ("ROLLBACK");
            $dbG->desconectar ();
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->AltaClienteNuevo()<ROLLBACK");
            return false;
        }
        
        // Y ahora hacemos la insercion
        $strSQL="INSERT INTO tbrelacioncliprov (IdRelacionCliProv, IdEmpresa, Codigo, IdCliProv,Borrado,CC_Recibos)
                 VALUES ( " . $IdRelacionCliProv . " , " . $_SESSION['idEmp'] . ",'" . $numCuenta . "'," . $num . ", '0','".$strCCRecibos."')";
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->AltaClienteNuevo()|| SQL : ".$strSQL);
        $stmt4 = $dbG->ejecutar ( $strSQL );

        if(!$stmt4){
            //si ha fallado la consulta hacemos ROLLBACK Y DEVOLVEMOS false
            $dbG->ejecutar ("ROLLBACK");
            $dbG->desconectar ();
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->AltaClienteNuevo()<ROLLBACK");
            return false;
        }
        
        //-------------------------------------------------------------
        //si todas las operaciones contra la BBDD contabilidad han sido correctas, se hace COMMIT
        $dbG->ejecutar ("COMMIT");
        $dbG->desconectar ();
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->AltaClienteNuevo()<COMMIT contabilidad");
        
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->AltaClienteNuevo()>COMIENZA LAS OPERACIONES CONTRA BBDD CLIENTE");
        
        //Por último hacemos la inserción en la tabla 'tbcuentas' de la BBDD de cliente
        //conexion BBDD cliente
        require_once '../general/'.$_SESSION['mapeo'];
        $dbC = new Db();
        $dbC->conectar($this->getStrBDCliente());
        
        //primero buscamos el numero mas alto de 'IdCuenta'
        $strSQL='SELECT IdCuenta FROM tbcuenta ORDER BY IdCuenta DESC LIMIT 0,1';
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->AltaClienteNuevo()|| SQL : ".$strSQL);
        $stmt5= $dbC->ejecutar ( $strSQL );
        
        if($stmt5){
            $num2=  mysql_num_rows($stmt5);
            $numeroCuenta=0;
            if($num2>0){
                $row=  mysql_fetch_assoc($stmt5);
                $numeroCuenta=$row['IdCuenta']+1;
            }else{
                $numeroCuenta=1;
            }
        }else{
            //si ha fallado la consulta borramos las inserciones en la BBDD contabilidad en las tablas 
            //'tbcliprov' segun el campo IdCliProv y 'tbrelacioncliprov' segun el campo IdRelacionCliProv y DEVOLVEMOS false
            $dbC->desconectar ();
            //vuelvo a conectarme a la BBDD contabilidad
            $dbG->conectar($this->getStrBD());
            
            $strSQL="DELETE FROM tbcliprov WHERE IdCliProv=".$IdCliProv;
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->AltaClienteNuevo()|| SQL : ".$strSQL);
            $stmtB1= $dbG->ejecutar ( $strSQL );
            $strSQL="DELETE FROM tbrelacioncliprov WHERE IdRelacionCliProv=".$IdRelacionCliProv;
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->AltaClienteNuevo()|| SQL : ".$strSQL);
            $stmtB2= $dbG->ejecutar ( $strSQL );
            $dbG->desconectar();
            if($stmtB1==true && $stmtB2==true){
                logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " clsCADUsu->AltaClienteNuevo()<ERROR (se desacen la inserción de la tabla 'tbcliprov'
                         por el campo IdCliProv=$IdCliProv y de la tabla 'tbrelacioncliprov' por el campo IdRelacionCLiProv=$IdRelacionCliProv");
            }else{
                logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " clsCADUsu->AltaClienteNuevo()<ERROR: NO SE HAN BORRADO LAS INSERCIONES DE LAS TABLAS POR LOS CAMPOS SIGIUIENTES: (la tabla 'tbcliprov'
                         por el campo IdCliProv=$IdCliProv y de la tabla 'tbrelacioncliprov' por el campo IdRelacionCLiProv=$IdRelacionCliProv");
            }
            return false;
        }
        
        // Y ahora hacemos la insercion
        $strSQL="INSERT INTO tbcuenta (IdCuenta, NumCuenta, Grupo, SubGrupo2, SubGrupo4, Nombre, Borrado)
                 VALUES (" . $numeroCuenta . " , '" . $numCuenta . "'," . substr($numCuenta,0,1) . "," . substr($numCuenta,0,2) .
                 "," . substr($numCuenta,0,4) . ",'$strNombre',0)";
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->AltaClienteNuevo()|| SQL : ".$strSQL);
        $stmt6 = $dbC->ejecutar ( $strSQL );

        if(!$stmt6){
            //si ha fallado la consulta borramos las inserciones en la BBDD contabilidad en las tablas 
            //'tbcliprov' segun el campo IdCliProv y 'tbrelacioncliprov' segun el campo IdRelacionCliProv y DEVOLVEMOS false
            $dbC->desconectar ();
            //vuelvo a conectarme a la BBDD contabilidad
            $dbG->conectar($this->getStrBD());
            
            $strSQL="DELETE FROM tbcliprov WHERE IdCliProv=".$IdCliProv;
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->AltaClienteNuevo()|| SQL : ".$strSQL);
            $stmtB1= $dbG->ejecutar ( $strSQL );
            $strSQL="DELETE FROM tbrelacioncliprov WHERE IdRelacionCliProv=".$IdRelacionCliProv;
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->AltaClienteNuevo()|| SQL : ".$strSQL);
            $stmtB2= $dbG->ejecutar ( $strSQL );
            $dbG->desconectar();
            if($stmtB1==true && $stmtB2==true){
                logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " clsCADUsu->AltaClienteNuevo()<ERROR (se desacen la inserción de la tabla 'tbcliprov'
                         por el campo IdCliProv=$IdCliProv y de la tabla 'tbrelacioncliprov' por el campo IdRelacionCLiProv=$IdRelacionCliProv");
            }else{
                logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " clsCADUsu->AltaClienteNuevo()<ERROR: NO SE HAN BORRADO LAS INSERCIONES DE LAS TABLAS POR LOS CAMPOS SIGIUIENTES: (la tabla 'tbcliprov'
                         por el campo IdCliProv=$IdCliProv y de la tabla 'tbrelacioncliprov' por el campo IdRelacionCLiProv=$IdRelacionCliProv");
            }
            return false;
        }
        
        //-------------------------------------------------------------
        //si todas las operaciones contra la BBDD se han efectuado correctamente se hace COMMIT y devolvemos true
        $dbC->desconectar ();
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->AltaClienteNuevo()<FIN OPERACIONES CONTRA BBDD CLIENTE: TODO A SIDO CORRECTO. DEVOLVEMOS TRUE");
        return true;
    }
    
    function ModificarCli($IdRelacionCliProv,$strNombre, $strCIF,$strActividad, $lngCP, $strDireccion,
                          $strMunicipio, $strProvincia,$strEmail,$strEmail2,$lngTelefono1,$lngTelefono2,
                          $lngFax,$lngCNAE,$lngNumSS,$strCCRecibos){
        //conexion contabilidad
        require_once '../general/conexion.php';
        $dbG = new DbC();
        $dbG->conectar($this->getStrBD());

        $IdRelacionCliProvExplode=explode('-',$IdRelacionCliProv);

        //averiguamos si la cuenta está guardada en BBDD dbcontabilidad o la BBDD del cliente
        //si es CliProv = esta guardada en dbcontabilidad.tbcliprov
        if($IdRelacionCliProvExplode[0]==='CliProv'){
            //como se realizan varias operaciones contra la BBDD Contabilidad lo hacemos por transaccion
            $dbG->ejecutar ("START TRANSACTION");
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->ModificarCli()|| SQL : START TRANSACTION BBDD contabilidad");

            //primero guardo la informacion que hay actualmente (por si hay que deshacer mas adelante)
            $strSQL="SELECT CP.IdCliProv,CP.nombre,CP.CIF,CP.Actividad,CP.direccion,CP.municipio,CP.provincia,CP.CP,
                     CP.Correo,CP.Correo2,CP.Telefono1,CP.Telefono2,CP.CNAE,CP.NumSS,CP.Fax FROM tbcliprov CP,tbrelacioncliprov R 
                     WHERE R.IdRelacionCliProv=".$IdRelacionCliProvExplode[1]." AND CP.IdCliProv=R.IdCliProv
                     AND R.Borrado='0'";
            $stmt=$dbG->ejecutar($strSQL);

            if($stmt){
                $row= mysql_fetch_array($stmt);
                //dejo preparada la consulta para restaurar los valores actuales si fallase en la BBDD cliente
                $strSQL_tbcliprov="UPDATE tbcliprov " .
                    ' SET nombre = "' . $row['nombre'] . '", CIF= "' . $row['CIF'] . '", Actividad = "' . $row['Actividad'] .
                    '",direccion= "' . $row['direccion'] . '", municipio= "' . $row['municipio'] .
                    '", provincia= "' . $row['provincia'] . '", CP = ' . $row['CP'] . ', Correo = "' . $row['Correo'] . '", Correo2 = "' . $row['Correo2'] . '",' .
                    ' Telefono1 = "' . $row['Telefono1'] . '", Telefono2 = "' . $row['Telefono2'] . '",CNAE = "' . $row['CNAE'] .
                    '", NumSS = "' . $row['NumSS'] . '", Fax = "' . $row['Fax'] . '" WHERE IdCliProv = ' . $row['IdCliProv'];
            }else{
                //si ha fallado la consulta hacemos ROLLBACK Y DEVOLVEMOS false
                $dbG->ejecutar ("ROLLBACK");
                $dbG->desconectar ();
                logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " clsCADUsu->AltaCliente()<ROLLBACK");
                return false;
            }

            //hacemos la actualización en la BBDD
            $strSQL="UPDATE tbcliprov " .
                    ' SET nombre = "' . $strNombre . '", CIF= "' . $strCIF . '", Actividad = "' . $strActividad .
                    '",direccion= "' . $strDireccion . '", municipio= "' . $strMunicipio .
                    '", provincia= "' . $strProvincia . '", CP = ' . $lngCP . ', Correo = "' . $strEmail . '", Correo2 = "' . $strEmail2 . '",' .
                    ' Telefono1 = "' . $lngTelefono1 . '", Telefono2 = "' . $lngTelefono2 . '",CNAE = "' . $lngCNAE .
                    '", NumSS = "' . $lngNumSS . '", Fax = "' . $lngFax . '" WHERE IdCliProv = ' . $row['IdCliProv'];
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->ModificarCli()|| SQL : ".$strSQL);
            $stmt = $dbG->ejecutar ( $strSQL );

            if(!$stmt){
                //si ha fallado la consulta hacemos ROLLBACK Y DEVOLVEMOS false
                $dbG->ejecutar ("ROLLBACK");
                $dbG->desconectar ();
                logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " clsCADUsu->ModificarCli()<ROLLBACK");
                return false;
            }

            //ahora actualizo la CC_Recibos en la tabla 'tbrelacioncliprov'
            $strSQL="UPDATE tbrelacioncliprov " .
                    " SET CC_Recibos = '" . $strCCRecibos . "' WHERE IdRelacionCliProv = " . $IdRelacionCliProvExplode[1];
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->ModificarCli()|| SQL : ".$strSQL);
            $stmt = $dbG->ejecutar ( $strSQL );

            if(!$stmt){
                //si ha fallado la consulta hacemos ROLLBACK Y DEVOLVEMOS false
                $dbG->ejecutar ("ROLLBACK");
                $dbG->desconectar ();
                logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " clsCADUsu->ModificarCli()<ROLLBACK");
                return false;
            }
            
            
            
            
            //ahora cojo la cuenta+nombre para poder actualizar en las tablas de la BBDD cliente
            $strSQL="SELECT RCP.codigo AS NumCuenta
                     FROM tbrelacioncliprov RCP
                     WHERE RCP.IdCliProv=". $row['IdCliProv']."
                     AND RCP.IdEmpresa=".$_SESSION['idEmp']
                    ;
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->ModificarCli()|| SQL : ".$strSQL);
            $stmt = $dbG->ejecutar ( $strSQL );

            $cuentasIdCliProv='';
            $idx=0;
            if($stmt){
                while($row=  mysql_fetch_array($stmt)){
                    //guardo en un array el resultado
                    $cuentasIdCliProv[$idx]=$row['NumCuenta'];
                    $idx++;
                }
            }else{
                //si ha fallado la consulta hacemos ROLLBACK Y DEVOLVEMOS false
                $dbG->ejecutar ("ROLLBACK");
                $dbG->desconectar ();
                logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " clsCADUsu->ModificarCli()<ROLLBACK");
                return false;
            }

            //-------------------------------------------------------------
            //si todas las operaciones contra la BBDD contabilidad han sido correctas, se hace COMMIT
            $dbG->ejecutar ("COMMIT");
            $dbG->desconectar ();
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->AltaCliente()<COMMIT contabilidad");

            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->AltaCliente()>COMIENZA LAS OPERACIONES CONTRA BBDD CLIENTE");

            //ahora cambiamos las cuentas de este IdCliProv en la tabla 'tbcuenta' de la BBDD cliente
            //conexion BBDD cliente
            require_once '../general/'.$_SESSION['mapeo'];
            $dbC = new Db();
            $dbC->conectar($this->getStrBDCliente());

            //como se realizan varias operaciones contra la BBDD cliente lo hacemos por transaccion
            $dbC->ejecutar ("START TRANSACTION");
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->ModificarCli()|| SQL : START TRANSACTION BBDD cliente");
            
            //recorremos todo el array $cuentasIdCliProv
            for($i=0;$i<count($cuentasIdCliProv);$i++){
                //ahora actualizo 
                $strSQL='UPDATE tbcuenta SET Nombre="'.$strNombre.'" WHERE NumCuenta="'.$cuentasIdCliProv[$i].'"'; 
                logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " clsCADUsu->ModificarCli()|| SQL : ".$strSQL);
                $stmt = $dbC->ejecutar ( $strSQL );
                if(!$stmt){
                    //si ha fallado la consulta hacemos ROLLBACK, deshacemos la actualizacion de la BBDD contabilidad Y DEVOLVEMOS false
                    $dbC->ejecutar ("ROLLBACK");
                    $dbC->desconectar ();

                    $dbG->conectar($this->getStrBD());
                    //deshago la actualizacion de la tabla 'tbcliprov'
                    $stmtB=$dbG->ejecutar($strSQL_tbcliprov);
                    $dbG->desconectar();
                    if($stmtB==true){
                        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                               " clsCADUsu->ModificarCli()<ERROR (se desacen la actualizacion de la tabla 'tbcliprov'
                                 por el campo IdCliProv=$IdCliProv");
                    }else{
                        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                               " clsCADUsu->ModificarCli()<ERROR: NO SE HA ACTUALIZADO LOS DATOS ORIGINALES DE LA TABLA 'tbcliprov'
                                 por el campo IdCliProv=$IdCliProv : LA INSTRUCCION SQL QUE HA FALLADO ES=$strSQL_tbcliprov");
                    }
                    return false;
                }
            }
                
            //-------------------------------------------------------------
            //si todas las operaciones contra la BBDD se han efectuado correctamente se hace COMMIT y devolvemos true
            $dbC->ejecutar ("COMMIT");
            $dbC->desconectar ();
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->ModificarCli()<COMMIT cliente");

            return true;
            
        }else
        //si es CuentCont = esta guardada en cliente.tbmiscontactos.IdCuenta
        if($IdRelacionCliProvExplode[0]==='CuenCont'){
            require_once '../general/'.$_SESSION['mapeo'];
            $dbC = new Db();
            $dbC->conectar($this->getStrBDCliente());
            
            //como se realizan varias operaciones contra la BBDD cliente lo hacemos por transaccion
            $dbC->ejecutar ("START TRANSACTION");
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->ModificarCli()|| SQL : START TRANSACTION BBDD cliente");
            
            //hacemos la actualización en la tabla tbmiscontactos
            $strSQL="UPDATE tbmiscontactos 
                     SET NombreEmpresa = '$strNombre', CIF= '$strCIF',Direccion= '$strDireccion', Ciudad= '$strMunicipio',
                     Provincia= '$strProvincia', CodPostal =$lngCP, Correo = '$strEmail',
                     Telefono = '$lngTelefono1' 
                     WHERE IdCuenta = " . $IdRelacionCliProvExplode[1];
            
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->ModificarCli()|| SQL : ".$strSQL);
            $stmt = $dbC->ejecutar ( $strSQL );

            if(!$stmt){
                //si ha fallado la consulta hacemos ROLLBACK Y DEVOLVEMOS false
                $dbC->ejecutar ("ROLLBACK");
                $dbC->desconectar ();
                logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " clsCADUsu->ModificarCli()<ROLLBACK");
                return false;
            }
            
            //hacemos la actualización en la tabla tbmiscontactos
            $strSQL="UPDATE tbcuenta 
                     SET Nombre = '$strNombre' 
                     WHERE IdCuenta = " . $IdRelacionCliProvExplode[1];
            
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->ModificarCli()|| SQL : ".$strSQL);
            $stmt = $dbC->ejecutar ( $strSQL );

            if(!$stmt){
                //si ha fallado la consulta hacemos ROLLBACK Y DEVOLVEMOS false
                $dbC->ejecutar ("ROLLBACK");
                $dbC->desconectar ();
                logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " clsCADUsu->ModificarCli()<ROLLBACK");
                return false;
            }
            
            //-------------------------------------------------------------
            //si todas las operaciones contra la BBDD se han efectuado correctamente se hace COMMIT y devolvemos true
            $dbC->ejecutar ("COMMIT");
            $dbC->desconectar ();
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->ModificarCli()<COMMIT cliente");

            return true;
        }
    }
    
    function ModificarCuentas($IdCuenta,$strNombre){
        require_once '../general/'.$_SESSION['mapeo'];
        $dbC = new Db();
        $dbC->conectar($this->getStrBD());

        //como se realizan varias operaciones contra la BBDD cliente lo hacemos por transaccion
        $dbC->ejecutar ("START TRANSACTION");
            
        //hacemos la actualización en la tabla tbcuenta
        $strSQL="UPDATE tbcuenta " .
                " SET Nombre = '" . $strNombre . "' WHERE IdCuenta = " . $IdCuenta;
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->ModificarCuentas()|| SQL : ".$strSQL);

        $stmt = $dbC->ejecutar ( $strSQL );
        
        if(!$stmt){
            //si ha fallado la consulta hacemos ROLLBACK Y DEVOLVEMOS false
            $dbC->ejecutar ("ROLLBACK");
            $dbC->desconectar ();
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->ModificarCuentas()<ROLLBACK");
            return false;
        }

        //y ahora buscamos en la tabla tbmiscontactos segun el idCuenta, si existe registro, actualizamos el tbmiscontactos.NombreEmpresa    
        $strSQL="
                UPDATE tbmiscontactos 
                SET NombreEmpresa = '" . $strNombre . "'
                WHERE IdCuenta = " . $IdCuenta
                ;
        
        $stmt = $dbC->ejecutar ( $strSQL );
        
        if(!$stmt){
            //si ha fallado la consulta hacemos ROLLBACK Y DEVOLVEMOS false
            $dbC->ejecutar ("ROLLBACK");
            $dbC->desconectar ();
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->ModificarCuentas()<ROLLBACK");
            return false;
        }

        
        //-------------------------------------------------------------
        //si todas las operaciones contra la BBDD se han efectuado correctamente se hace COMMIT y devolvemos true
        $dbC->ejecutar ("COMMIT");
        $dbC->desconectar ();
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->ModificarCuentas()<COMMIT");

        return true;
    }
    
    function AltaCuenta($numCuenta,$grupo,$subGrupo2,$subGrupo4,$strNombre){
        require_once '../general/'.$_SESSION['mapeo'];
        $db = new Db();
        $db->conectar($this->getStrBD());

        logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               $this->getStrBD());
        //calculo el numero IdCuenta para la sgte insercion
        $strSQL = 'SELECT IdCuenta FROM tbcuenta ORDER BY IdCuenta DESC LIMIT 0,1';
        logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->AltaCuenta($numCuenta,$grupo,$subGrupo2,$subGrupo4,$strNombre)|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        $num=  mysql_num_rows($stmt);
        if($num>0){
            $row=  mysql_fetch_assoc($stmt);
            $numero=$row['IdCuenta']+1;
        }else{
            $numero=1;
        }
        logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->AltaCuenta($numCuenta,$grupo,$subGrupo2,$subGrupo4,$strNombre)|| Numero IdCuenta : ".$numero);

        //y ahora hago la insercion en la tabla 'tbcuenta'
        $strSQL = "INSERT INTO tbcuenta (IdCuenta,NumCuenta,Grupo,SubGrupo2,SubGrupo4,Nombre,Borrado)
                   VALUES (".$numero.",'".$numCuenta."',".$grupo.",".$subGrupo2.",".$subGrupo4.",'".$strNombre."',0)";
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->AltaCuenta($numCuenta,$grupo,$subGrupo2,$subGrupo4,$strNombre)|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        $db->desconectar ();
        
        if($stmt){
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->AltaCuenta($numCuenta,$grupo,$subGrupo2,$subGrupo4,$strNombre)<TRUE");
            return true;
        }else{
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->AltaCuenta($numCuenta,$grupo,$subGrupo2,$subGrupo4,$strNombre)<FALSE");
            return false;
        }
    }
    
    function DatosEmpleado($lngId,$strUsuario){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());
//        if($lngId<>0 || $strUsuario<>''){
            if($lngId==0){
                $strSQL='SELECT E.lngIdEmpleado as lngIdEmpleado, E.lngIdResponsable as lngIdResponsable, '.
                        'E.strNombre as strNombre, E.strApellidos as strApellidos, '.
                        'D.strDescripcion  as strDepartamento, U.lngPermiso '.
                        'FROM tbempleados E, tbusuarios U, tbdepartamentos D '.
                        'WHERE E.lngIdEmpleado = U.lngIdEmpleado '.
                        'AND E.lngIdDepartamento = D.lngId '.
                        'AND U.strUsuario = "'.$strUsuario.'"';
            }else{
                $strSQL='SELECT E.lngIdEmpleado as lngIdEmpleado, E.lngIdResponsable as lngIdResponsable, '.
                        'E.strNombre as strNombre, E.strApellidos as strApellidos, '.
                        'D.strDescripcion  as strDepartamento, U.lngPermiso '.
                        'FROM tbempleados E, tbusuarios U, tbdepartamentos D '.
                        'WHERE E.lngIdEmpleado = U.lngIdEmpleado '.
                        'AND E.lngIdDepartamento = D.lngId '.
                        'AND E.lngIdEmpleado = '.$lngId;
            }
//        }
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->DatosEmpleado($lngId,$strUsuario)|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        $db->desconectar ();
        if($stmt){
            $row=  mysql_fetch_array($stmt);
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->DatosEmpleado($lngId,$strUsuario)|| Si hay Datos");
            return $row;
        }else{
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->DatosEmpleado($lngId,$strUsuario)|| No hay Datos");
            return '';
        }
    }
    
    function DatosAsesor($idEmp){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());

        $strSQL="SELECT CONCAT(strNombre,' ',strApellidos) AS Asesor,strCorreo
                 FROM tbempleados
                 WHERE lngIdEmpleado
                 IN 
                 (SELECT E.lngAsesor 
                 FROM tbempresas E
                 WHERE E.IdEmpresa=$idEmp)";
        logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADUsu->DatosAsesor($idEmp)|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        $db->desconectar ();
        if($stmt){
            $row=  mysql_fetch_array($stmt);
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->DatosAsesor($idEmp)|| Si hay Datos");
            return $row;
        }else{
            logger('traza','clsCADsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADUsu->DatosAsesor($idEmp)|| No hay Datos");
            return '';
        }
    }
    
    function ExisteNIF_CIF($idEmp){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());
        
        $strSQL = "SELECT strCIF FROM tbempresas WHERE tbempresas.IdEmpresa=$idEmp";
        logger('traza','clsCADContabilidad.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
                " clsCADUsu->ExisteNIF_CIF($idEmp)|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        
        $result=false;
        if($stmt){
            $count=  mysql_num_rows($stmt);
            if($count>0){
                $row=  mysql_fetch_assoc($stmt);
                $result=$row['strCIF'];
            }
        }
        return $result;
    }
    
    function AltaCuentaContactos($CodigoCuenta,$nombre){
        require_once '../general/'.$_SESSION['mapeo'];
        $db = new Db();
        $db->conectar($this->getStrBD());

        //es transaccion
        $db->ejecutar ("START TRANSACTION");
        logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADUsu->AltaCuentaContactos() || START TRANSACTION");
        
        //primero inserto en la tabla 'tbcuenta'
        $strSQL = "
                    SELECT IF(ISNULL(MAX(idCuenta)),1,MAX(idCuenta)+1) AS idCuenta FROM tbcuenta
                  ";
        logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADUsu->AltaCuentaContactos()|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        if(!$stmt){
            //si ha fallado la consulta hacemos ROLLBACK Y DEVOLVEMOS false
            $db->ejecutar ("ROLLBACK");
            $db->desconectar ();
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADUsu->AltaCuentaContactos()<ROLLBACK");
            return false;
        }
        
        $row=  mysql_fetch_array($stmt);
        $idCuenta=$row['idCuenta'];
        
        $strSQL = "
                    INSERT INTO tbcuenta (idCuenta,NumCuenta,Grupo,SubGrupo2,SubGrupo4,Nombre,Borrado) 
                    VALUES ($idCuenta,'$CodigoCuenta',".substr($CodigoCuenta,0,1).",".substr($CodigoCuenta,0,2).",".substr($CodigoCuenta,0,4).",
                            '$nombre',0)
                  ";
        logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADUsu->AltaCuentaContactos()|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );

        if(!$stmt){
            //si ha fallado la consulta hacemos ROLLBACK Y DEVOLVEMOS false
            $db->ejecutar ("ROLLBACK");
            $db->desconectar ();
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADUsu->AltaCuentaContactos()<ROLLBACK");
            return false;
        }
        
        //por último inserto en la tabla 'tbcontactos'
        $strSQL = "
                    SELECT IF(ISNULL(MAX(IdContacto)),1,MAX(IdContacto)+1) AS IdContacto FROM tbmiscontactos
                  ";
        logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADUsu->AltaCuentaContactos()|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        if(!$stmt){
            //si ha fallado la consulta hacemos ROLLBACK Y DEVOLVEMOS false
            $db->ejecutar ("ROLLBACK");
            $db->desconectar ();
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADUsu->AltaCuentaContactos()<ROLLBACK");
            return false;
        }
        
        $row=  mysql_fetch_array($stmt);
        $IdContacto=$row['IdContacto'];
        
        $strSQL = "
                    INSERT INTO tbmiscontactos (IdContacto,idCuenta,NombreEmpresa) 
                    VALUES ($IdContacto,$idCuenta,'$nombre')
                  ";
        logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADUsu->AltaCuentaContactos()|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );

        if(!$stmt){
            //si ha fallado la consulta hacemos ROLLBACK Y DEVOLVEMOS false
            $db->ejecutar ("ROLLBACK");
            $db->desconectar ();
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADUsu->AltaCuentaContactos()<ROLLBACK");
            return false;
        }
        
        //si todas las operaciones contra la BBDD se han efectuado correctamente se hace COMMIT y devolvemos true
        $db->ejecutar ("COMMIT");
        logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADUsu->AltaCuentaContactos()<COMMIT");
        
        $db->desconectar ();

        return true;
    }
    
    function listadoAsesores(){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());

        $strSQL = "
                    SELECT E.lngIdEmpleado,CONCAT(E.strNombre,' ',E.strApellidos) AS Asesor
                    FROM tbusuarios U, tbempleados E
                    WHERE U.lngIdEmpleado=E.lngIdEmpleado
                    AND U.strPuesto LIKE 'Asesor%'
                  ";
        logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADUsu->listadoAsesores()|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );


        if($stmt){
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADUsu->listadoAsesores()|| true ");
            $resultado='';
            while ($row=  mysql_fetch_array($stmt)){
                $reg='';
                foreach($row as $propiedad=>$valor){
                    if(!is_numeric($propiedad)){
                        $reg[$propiedad]=$valor;
                    }
                }
                $resultado[]=$reg;
            }
            
            return $resultado;
        }else{
            //si ha fallado la insercion hacemos ROLLBACK Y DEVOLVEMOS false
            $db->desconectar ();
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADUsu->listadoAsesores()|| false ");
            return false;
        }
    }
    
    function listadoBBDDLibres(){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());

        $strSQL = "
                    SELECT id,fichero
                    FROM tbasignacion_bbdd
                    WHERE libre_ocupado='Libre'
                    ";
        logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADUsu->listadoBBDDLibres()|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );


        if($stmt){
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADUsu->listadoBBDDLibres()|| true ");
            $resultado='';
            while ($row=  mysql_fetch_array($stmt)){
                $reg='';
                foreach($row as $propiedad=>$valor){
                    if(!is_numeric($propiedad)){
                        $reg[$propiedad]=$valor;
                    }
                }
                $resultado[]=$reg;
            }
            
            return $resultado;
        }else{
            //si ha fallado la insercion hacemos ROLLBACK Y DEVOLVEMOS false
            $db->desconectar ();
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADUsu->listadoBBDDLibres()|| false ");
            return false;
        }
    }

//    function AltaEmpresaNueva($strNombre,$strCIF,$strPassword,$strDireccion,$strProvincia,$strSesion,$strMunicipio,$strCP,$strTelefono,$email1,$email2,$version,$numApuntes
//                                    ,$IdAsesor,$strMapeo,$claseEmpresa){
    function AltaEmpresaNueva($strNombre,$strCIF,$strPassword,$strDireccion,$strSesion,$strMunicipio,$strCP,$strTelefono,$email1,$email2,$version,$numApuntes
                                    ,$IdAsesor,$strMapeo,$claseEmpresa){
        
        
        
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());
        
        //es transaccion
        $db->ejecutar ("START TRANSACTION");
        logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADUsu->AltaCuentaContactos() || START TRANSACTION");

        //averiguo el valor idEmpresa mas alto que haya
        $strSQL = 'SELECT IdEmpresa FROM tbempresas ORDER BY IdEmpresa DESC LIMIT 0,1';
        logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADUsu->AltaEmpresaNueva()|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        $num=  mysql_num_rows($stmt);
        $numero=0;
        if($num>0){
            $row=  mysql_fetch_assoc($stmt);
            $numero=$row['IdEmpresa']+1;
        }else{
            $numero=1;
        }
        
        //inserto datos de la empresa en la tabla 'tbempresas'
        $strSQL = "INSERT INTO tbempresas(IdEmpresa,strPassword,strNombre,strSesion,strBD,strCIF,fechaAlta,fechaVencimiento,direccion,municipio,provincia,
                                          CP,telefono,email1,email2,Version,numApuntes,borrado,strMapeo,lngAsesor,claseEmpresa)
                   VALUES ($numero,'$strPassword','$strNombre','$strSesion','$strNombre','$strCIF',now(),now()+INTERVAL 15 DAY,'$strDireccion',
                '$strMunicipio','$strProvincia',$strCP,$strTelefono,'$email1','$email2',$version,$numApuntes,0,'$strMapeo',$IdAsesor,'$claseEmpresa')";
        logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADUsu->AltaEmpresaNueva()|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        
        if(!$stmt){
            //si ha fallado la consulta hacemos ROLLBACK Y DEVOLVEMOS false
            $db->ejecutar ("ROLLBACK");
            $db->desconectar ();
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADUsu->AltaEmpresaNueva()<ROLLBACK");
            return false;
        }
        
        
        //ahora actualizamos la tabla tbasignacion_bbdd
        $strSQL = "
                    UPDATE tbasignacion_bbdd
                    SET libre_ocupado='Ocupado',
                        IdEmpresa=$numero,
                        fecha_asignacion=now()    
                    WHERE fichero='$strMapeo' 
                    ";
        logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADUsu->AltaEmpresaNueva()|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        
        if(!$stmt){
            //si ha fallado la consulta hacemos ROLLBACK Y DEVOLVEMOS false
            $db->ejecutar ("ROLLBACK");
            $db->desconectar ();
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADUsu->AltaEmpresaNueva()<ROLLBACK");
            return false;
        }
        
        
        //si todas las operaciones contra la BBDD se han efectuado correctamente se hace COMMIT y devolvemos true
        $db->ejecutar ("COMMIT");
        logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADUsu->AltaEmpresaNueva()<COMMIT");
        
        $db->desconectar ();

        return true;
    }
    
    function AltaEmpresaNuevaDesdeJoomla($post){
        //se da de alta una empresa con los datos de joomla
        //se guardan los datos de la empresa y del usuario (tablas tbempresas, tbempleados,
        //tbusuarios y tbasignacion_bbdd)
        //
        //utilizare la funcion *AltaEmpresaNueva()-> guarda los datos de la empresa y la asignacion 
        //de la BBDD (tablas tbempresas y tbasignacion_bbdd)
        //
        //despues utilizare la funcion *Alta()-> guarda
        
        $id_joomla=$post['id_joomla'];
        
        //primero preparo los datos para la funcion **AltaEmpresaNueva()
        $strNombre=$post['strNombre'];
        $strCIF=$post['strCIF'];
        $strPassword=$post['strPassword'];
        $strDireccion=$post['strDireccion'];
        $strSesion=$post['strSesion'];
        $strMunicipio=$post['strMunicipio'];
        $strProvincia=$post['provincia'];
        $strCP=$post['strCP'];
        $strTelefono=$post['strTelefono'];
        $email1=$post['email1'];
        $version=$post['version'];
        $numApuntes=$post['numApuntes'];
        $IdAsesor=$post['IdAsesor'];
        $strMapeo=$post['strMapeo'];
        $claseEmpresa=$post['claseEmpresa'];
        
        logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADUsu->AltaEmpresaNuevaDesdeJoomla()|| Entro AltaEmpresaNueva()> ");
        $OK=$this->AltaEmpresaNueva($strNombre, $strCIF, $strPassword, $strDireccion, $strProvincia, $strSesion,
                                $strMunicipio, $strCP, $strTelefono, $email1, '', $version,
                                $numApuntes, $IdAsesor, $strMapeo, $claseEmpresa);
        logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADUsu->AltaEmpresaNuevaDesdeJoomla()|| Salgo AltaEmpresaNueva(): ".$OK);
        
        if($OK<>1){
            return false;
        }

        //extraigo el $idEmpresa que acabamos de insertar
        $strSQL = "
                    SELECT E.IdEmpresa
                    FROM tbempresas E
                    WHERE E.strNombre='$strNombre'
                    AND E.borrado=0
                    ";
        logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADUsu->AltaEmpresaNuevaDesdeJoomla()|| SQL : ".$strSQL);
        
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());
        $stmt = $db->ejecutar ( $strSQL );
        $db->desconectar ();

        $row=  mysql_fetch_array($stmt);
        $idEmpresa=$row['IdEmpresa'];
        
        //despues preparo los datos para la funcion **Alta()
        $num=$this->IdUsuarioNuevo();
        
        $strNombreUsuario=$post['strNombreUsuario'];
        $strApellidos=$post['strApellidos'];
        $lngTelefono=$post['lngTelefono'];
        $lngMovil=$post['lngMovil'];
        $strCorreos=$post['strCorreos'];
        $strUsuario=$post['strUsuario'];
        $strPasswordUsuario=$post['strPasswordUsuario'];
        
        $varRes=$this->Alta($num, $idEmpresa, $strNombreUsuario, $strApellidos, $lngTelefono, $lngMovil, 
                            $strCorreos, $strUsuario, $strPasswordUsuario);
        
        if($varRes<>1){
            //como a dado error borro la insersion realizada en la tabla 'tbempresas' y dejo la BBDDlibre
            //(esto se indica en la tabla 'tbasignacion_bbdd')
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADUsu->AltaEmpresaNuevaDesdeJoomla()|| Deshaciendo inserciones por error ");
            
            //ahora actualizamos la tabla 'tbasignacion_bbdd'
            $strSQL = "
                        UPDATE tbasignacion_bbdd
                        SET libre_ocupado='Libre',
                            fecha_asignacion=null    
                        WHERE IdEmpresa=$idEmpresa 
                        ";
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADUsu->AltaEmpresaNuevaDesdeJoomla()|| SQL : ".$strSQL);
            $db->conectar($this->getStrBD());
            $stmt = $db->ejecutar ( $strSQL );
            
            //borro el registro insertado tabla 'tbempresas'
            $strSQL = "
                        DELETE FROM tbempresas
                        WHERE IdEmpresa = $idEmpresa
                        ";
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADUsu->AltaEmpresaNuevaDesdeJoomla()|| SQL : ".$strSQL);
            $stmt = $db->ejecutar ( $strSQL );
            $db->desconectar ();
            
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADUsu->AltaEmpresaNuevaDesdeJoomla()|| FALSE ");
            return false;
        }
        
        //ahora por ultimo registro en la tabla de control 'tbempresas_joomla_control'
        
        //busco el campo Importado mas reciente borrada
        $strSQL = "
            SELECT IF(ISNULL(MAX(id)),1,MAX(id)+1) AS id FROM tbempresas_joomla_control
        ";
        logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADUsu->AltaEmpresaNuevaDesdeJoomla()|| SQL : ".$strSQL);
        
        $db->conectar($this->getStrBD());
        $stmt = $db->ejecutar ( $strSQL );
        
        if($stmt){
            $row=  mysql_fetch_assoc($stmt);
            $id=$row['id'];
        }else{
            //como a dado error borro la insersion realizada en la tabla 'tbempresas' y dejo la BBDDlibre
            //(esto se indica en la tabla 'tbasignacion_bbdd')
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADUsu->AltaEmpresaNuevaDesdeJoomla()|| Deshaciendo inserciones por error ");
            
            //ahora actualizamos la tabla 'tbasignacion_bbdd'
            $strSQL = "
                        UPDATE tbasignacion_bbdd
                        SET libre_ocupado='Libre',
                            fecha_asignacion=null    
                        WHERE IdEmpresa=$idEmpresa 
                        ";
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADUsu->AltaEmpresaNuevaDesdeJoomla()|| SQL : ".$strSQL);
            $db->conectar($this->getStrBD());
            $stmt = $db->ejecutar ( $strSQL );
            
            //borro el registro insertado tabla 'tbempresas'
            $strSQL = "
                        DELETE FROM tbempresas
                        WHERE IdEmpresa = $idEmpresa
                        ";
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADUsu->AltaEmpresaNuevaDesdeJoomla()|| SQL : ".$strSQL);
            $stmt = $db->ejecutar ( $strSQL );

            //ahora borro los datos insertados en la tabla 'tbempleados'
            $strSQL = "
                        DELETE FROM tbempleados
                        WHERE lngIdEmpleado=$num
                        ";
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADUsu->AltaEmpresaNuevaDesdeJoomla()|| SQL : ".$strSQL);
            $stmt = $db->ejecutar ( $strSQL );
            
            //ahora borro los datos insertados en la tabla 'tbusuarios'
            $strSQL = "
                        DELETE FROM tbusuarios
                        WHERE lngIdEmpleado=$num
                        ";
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADUsu->AltaEmpresaNuevaDesdeJoomla()|| SQL : ".$strSQL);
            $stmt = $db->ejecutar ( $strSQL );
            $db->desconectar ();
            
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADUsu->AltaEmpresaNuevaDesdeJoomla()|| FALSE ");
            return false;
        }
        
        //hago la insercion de los datos
        $strSQL = "
                    INSERT INTO tbempresas_joomla_control (id,id_joomla,fecha_alta)
                    VALUES ($id,$id_joomla,now())
                    ";
        logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADUsu->AltaEmpresaNuevaDesdeJoomla()|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        $db->desconectar ();
        
        if(!$stmt){
            //como a dado error borro la insersion realizada en la tabla 'tbempresas' y dejo la BBDDlibre
            //(esto se indica en la tabla 'tbasignacion_bbdd')
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADUsu->AltaEmpresaNuevaDesdeJoomla()|| Deshaciendo inserciones por error ");
            
            //ahora actualizamos la tabla 'tbasignacion_bbdd'
            $strSQL = "
                        UPDATE tbasignacion_bbdd
                        SET libre_ocupado='Libre',
                            fecha_asignacion=null    
                        WHERE IdEmpresa=$idEmpresa 
                        ";
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADUsu->AltaEmpresaNuevaDesdeJoomla()|| SQL : ".$strSQL);
            $db->conectar($this->getStrBD());
            $stmt = $db->ejecutar ( $strSQL );
            
            //borro el registro insertado tabla 'tbempresas'
            $strSQL = "
                        DELETE FROM tbempresas
                        WHERE IdEmpresa = $idEmpresa
                        ";
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADUsu->AltaEmpresaNuevaDesdeJoomla()|| SQL : ".$strSQL);
            $stmt = $db->ejecutar ( $strSQL );

            //ahora borro los datos insertados en la tabla 'tbempleados'
            $strSQL = "
                        DELETE FROM tbempleados
                        WHERE lngIdEmpleado=$num
                        ";
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADUsu->AltaEmpresaNuevaDesdeJoomla()|| SQL : ".$strSQL);
            $stmt = $db->ejecutar ( $strSQL );
            
            //ahora borro los datos insertados en la tabla 'tbusuarios'
            $strSQL = "
                        DELETE FROM tbusuarios
                        WHERE lngIdEmpleado=$num
                        ";
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADUsu->AltaEmpresaNuevaDesdeJoomla()|| SQL : ".$strSQL);
            $stmt = $db->ejecutar ( $strSQL );
            $db->desconectar ();
            
            logger('traza','clsCADUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADUsu->AltaEmpresaNuevaDesdeJoomla()|| FALSE ");
            return false;
        }
        
        //como todas las operaciones contra la BBDD han salido correctas damos true
        return true;
    }
}
?>
