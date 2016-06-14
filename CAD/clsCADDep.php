<?php
class clsCADDep{
    
    private $strDB='';

    function setStrBD($str){
        $this->strDB=$str;
    }

    function getStrBD(){
        return $this->strDB;
    }
    
    function existeDpto($strDepartamento){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());
                  
        $strSQL = 'SELECT strDescripcion FROM tbdepartamentos WHERE strDescripcion="'.$strDepartamento.'"';
        logger('traza','clsCADDep.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id(). " clsCADDep->existeDpto($strDepartamento)|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        $db->desconectar ();
        $num=  mysql_num_rows($stmt);
        if($num>0){
            logger('traza','clsCADDep.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id(). " clsCADDep->existeDpto($strDepartamento)|| SQL : ".$strSQL);
            return 'SI';
        }else{
            logger('traza','clsCADDep.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id(). " clsCADDep->existeDpto($strDepartamento)|| SQL : ".$strSQL);
            return 'NO';
        }
    }

    function ObtieneIdDep($strDepartamento){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());

        //preparo la consulta general de todos los dicumentos
        $strSQL="SELECT * FROM tbdepartamentos WHERE strDescripcion='$strDepartamento'";
        logger('traza','clsCADDep.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id(). " clsCADDep->existeDpto($strDepartamento)|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        $db->desconectar ();
        //aqui guardo los datos de la consulta
        if($stmt){
            //tengo datos
            $row=  mysql_fetch_array($stmt,MYSQL_ASSOC);
            logger('traza','clsCADDep.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id(). " clsCADDep->existeDpto($strDepartamento)|| SQL : ".$strSQL);
            return $row['lngId'];
        }else{
            logger('traza','clsCADDep.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id(). " clsCADDep->existeDpto($strDepartamento)|| SQL : ".$strSQL);
            return '';
        }
    }
    
}
?>
