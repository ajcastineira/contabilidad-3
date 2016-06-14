<?php
require_once '../general/funcionesGenerales.php';

class clsCNControl {

    private $strDB = '';
    private $strDBCliente='';

    function setStrBD($str) {
        $this->strDB = $str;
    }

    function getStrBD() {
        return $this->strDB;
    }

    function setStrBDCliente($str){
        $this->strDBCliente=$str;
    }

    function getStrBDCliente(){
        return $this->strDBCliente;
    }

    
    function ListadoEmpresas(){
        require_once './clsCADControl.php';
        $clsCADControl = new clsCADControl();
        $clsCADControl->setStrBD($this->getStrBD());

        return $clsCADControl->ListadoEmpresas();
    }
    
    function listadoClientes($id,$mapeo){
        require_once './clsCADControl.php';
        $clsCADControl = new clsCADControl();
        $clsCADControl->setStrBD($this->getStrBD());

        return $clsCADControl->listadoClientes($id,$mapeo);
    }
    
    function Igualar($idEmp,$mapeo,$cuenta){
        require_once './clsCADControl.php';
        $clsCADControl = new clsCADControl();
        $clsCADControl->setStrBD($this->getStrBD());

        return $clsCADControl->Igualar($idEmp,$mapeo,$cuenta);
    }
}
?>
