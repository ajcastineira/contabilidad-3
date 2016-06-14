<?php
class clsCNDep{

    private $strDB='';
    
    function setStrBD($str){
        $this->strDB=$str;
    }
    
    function getStrBD(){
        return $this->strDB;
    }

    function ObtieneIdDep($strDepartamento){
        logger('traza','clsCNDep.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               "  clsCNDep->ObtieneIdDep($strDepartamento)");
        require_once '../CAD/clsCADDep.php';
        $clsCADDep=new clsCADDep();
        $clsCADDep->setStrBD($this->getStrBD());
        
        return $clsCADDep->ObtieneIdDep($strDepartamento);
    }
}
?>
