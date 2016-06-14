<?php

class clsCNJoomla{
    
    private $strDB = '';

    function setStrBD($str) {
        $this->strDB = $str;
    }

    function getStrBD() {
        return $this->strDB;
    }
    
    function listadoForm_Suscripcion(){
        logger('traza', 'clsCNJoomla.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNJoomla->listadoForm_Suscripcion()>");

        require_once '../CAD/clsCADJoomla.php';
        $clsCADJoomla = new clsCADJoomla();
        $clsCADJoomla->setStrBD($this->getStrBD());

        return $clsCADJoomla->listadoForm_Suscripcion();
    }
    
    function datosForm_Suscripcion($id_joomla){
        logger('traza', 'clsCNJoomla.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNJoomla->datosForm_Suscripcion()>");

        require_once '../CAD/clsCADJoomla.php';
        $clsCADJoomla = new clsCADJoomla();
        $clsCADJoomla->setStrBD($this->getStrBD());

        return $clsCADJoomla->datosForm_Suscripcion($id_joomla);
    }
    
    function BBDD_libre(){
        logger('traza', 'clsCNJoomla.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNJoomla->BBDD_libre()>");

        require_once '../CAD/clsCADJoomla.php';
        $clsCADJoomla = new clsCADJoomla();
        $clsCADJoomla->setStrBD($this->getStrBD());

        return $clsCADJoomla->BBDD_libre();
    }
}

?>