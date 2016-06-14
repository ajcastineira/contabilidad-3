<?php
require_once '../general/funcionesGenerales.php';

class clsCNDatosVentas {
    
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
    
    function ListadoVentas($get){
        logger('traza', 'clsCNDatosVentas.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCADDatosVentas->ListadoVentas()>");
        require_once '../CAD/clsCADDatosVentas.php';
        $clsCADDatosVentas = new clsCADDatosVentas();
        $clsCADDatosVentas->setStrBDCliente($this->getStrBD());

        return $clsCADDatosVentas->ListadoVentas($get);
    }
    
    function ListadoVentasBancos($get){
        logger('traza', 'clsCNDatosVentas.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCADDatosVentas->ListadoVentasBancos()>");
        require_once '../CAD/clsCADDatosVentas.php';
        $clsCADDatosVentas = new clsCADDatosVentas();
        $clsCADDatosVentas->setStrBDCliente($this->getStrBD());

        return $clsCADDatosVentas->ListadoVentasBancos($get);
    }
    
    function ListadoVentasTarjetas($get){
        logger('traza', 'clsCNDatosVentas.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCADDatosVentas->ListadoVentasTarjetas()>");
        require_once '../CAD/clsCADDatosVentas.php';
        $clsCADDatosVentas = new clsCADDatosVentas();
        $clsCADDatosVentas->setStrBDCliente($this->getStrBD());

        return $clsCADDatosVentas->ListadoVentasTarjetas($get);
    }
    
    //NO VALE 22/1/2016
    function ListadoBancos($get){
        logger('traza', 'clsCNDatosVentas.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCADDatosVentas->ListadoBancos()>");
        require_once '../CAD/clsCADDatosVentas.php';
        $clsCADDatosVentas = new clsCADDatosVentas();
        $clsCADDatosVentas->setStrBDCliente($this->getStrBD());

        return $clsCADDatosVentas->ListadoBancos($get);
    }
    
    function ListadoCuentasBancos($cuentaDefecto){
        logger('traza', 'clsCNDatosVentas.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCADDatosVentas->ListadoCuentasBancos()>");
        require_once '../CAD/clsCADDatosVentas.php';
        $clsCADDatosVentas = new clsCADDatosVentas();
        $clsCADDatosVentas->setStrBDCliente($this->getStrBD());

        
        $listado = $clsCADDatosVentas->ListadoCuentasBancos();
        
        
        //preparo el select de los bancos
        $html = '<select class="textbox1" name="cuentaBanco" id="cuentaBanco">';
        $html = $html . '<option value="570000000">0 - Caja</option>';
        
        for ($i = 0; $i < count($listado); $i++) {
            $cuenta = (int) substr($listado[$i]['NumCuenta'],4);
            if($listado[$i]['NumCuenta'] !== 570000000){
                if($cuentaDefecto === $listado[$i]['NumCuenta']){
                    $html = $html . '<option value="'.$listado[$i]['NumCuenta'].'" selected>'.$cuenta.' - '.$listado[$i]['Nombre'].'</option>';
                }else{
                    $html = $html . '<option value="'.$listado[$i]['NumCuenta'].'">'.$cuenta.' - '.$listado[$i]['Nombre'].'</option>';
                }
            }
        }
    
        $html = $html . '</select>';

        return $html;
    }
    
    //CREO QUE NO SE USA, BORRAR 7/3/2016
    function ListadoCuentasBancosTarjetas($cuentaDefecto){
        logger('traza', 'clsCNDatosVentas.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCADDatosVentas->ListadoCuentasBancosTarjetas()>");
        require_once '../CAD/clsCADDatosVentas.php';
        $clsCADDatosVentas = new clsCADDatosVentas();
        $clsCADDatosVentas->setStrBDCliente($this->getStrBD());

        
        $listado = $clsCADDatosVentas->ListadoCuentasBancos();
        
        
        //preparo el select de los bancos
        $html = '<select class="textbox1" name="cuentaBanco" id="cuentaBanco">';
        
        for ($i = 0; $i < count($listado); $i++) {
            $cuenta = (int) substr($listado[$i]['NumCuenta'],4);
            if($cuenta !== 0){
                if((int)$cuentaDefecto === $cuenta){
                    $html = $html . '<option value="'.$cuenta.'" selected>'.$cuenta.' - '.$listado[$i]['Nombre'].'</option>';
                }else{
                    $html = $html . '<option value="'.$cuenta.'">'.$cuenta.' - '.$listado[$i]['Nombre'].'</option>';
                }
            }
        }
    
        $html = $html . '</select>';

        return $html;
    }
    
    function actualizarBancoFilaCampoCD($datos){
        logger('traza', 'clsCNDatosVentas.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCADDatosVentas->actualizarBancoFilaCampoCD()>");
        require_once '../CAD/clsCADDatosVentas.php';
        $clsCADDatosVentas = new clsCADDatosVentas();
        $clsCADDatosVentas->setStrBDCliente($this->getStrBD());

        return $clsCADDatosVentas->actualizarBancoFilaCampoCD($datos);
    }
    
    function nuevaBancoFilaCampoCD($datos,$cuentaBanco){
        logger('traza', 'clsCNDatosVentas.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCADDatosVentas->nuevaBancoFilaCampoCD()>");
        require_once '../CAD/clsCADDatosVentas.php';
        $clsCADDatosVentas = new clsCADDatosVentas();
        $clsCADDatosVentas->setStrBDCliente($this->getStrBD());

        return $clsCADDatosVentas->nuevaBancoFilaCampoCD($datos,$cuentaBanco);
    }
    
    function ListadoBancosCuenta(){
        logger('traza', 'clsCNDatosVentas.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCADDatosVentas->ListadoBancosCuenta()>");
        require_once '../CAD/clsCADDatosVentas.php';
        $clsCADDatosVentas = new clsCADDatosVentas();
        $clsCADDatosVentas->setStrBDCliente($this->getStrBD());

        return $clsCADDatosVentas->ListadoCuentasBancos();
    }
    
    function ListadoBancosJS(){
        logger('traza', 'clsCNDatosVentas.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCADDatosVentas->ListadoBancosJS()>");
        require_once '../CAD/clsCADDatosVentas.php';
        $clsCADDatosVentas = new clsCADDatosVentas();
        $clsCADDatosVentas->setStrBDCliente($this->getStrBD());

        return $clsCADDatosVentas->ListadoBancosJS();
    }
    
    function ListadoTarjetas(){
        logger('traza', 'clsCNDatosVentas.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCADDatosVentas->ListadoTarjetas()>");
        require_once '../CAD/clsCADDatosVentas.php';
        $clsCADDatosVentas = new clsCADDatosVentas();
        $clsCADDatosVentas->setStrBDCliente($this->getStrBD());
        
        //este listado se hace a partir de listar las tarjetas (uenta 5750) y despues los cheques (cuenta 4100)
        $listadoOrigen = $clsCADDatosVentas->ListadoTarjetas('5750');
        $listado = '';
        for ($i = 0; $i < count($listadoOrigen); $i++) {
            $Num = (int)substr($listadoOrigen[$i]['NumCuenta'],4);
            if($Num !== 0){
                $nodo['Num'] = $Num;
                $nodo['NumCuenta'] = $listadoOrigen[$i]['NumCuenta'];
                $nodo['Nombre'] = $listadoOrigen[$i]['Nombre'];
                $listado[] = $nodo;
            }
        }

        $listadoOrigen = $clsCADDatosVentas->ListadoTarjetas('4100');
        for ($i = 0; $i < count($listadoOrigen); $i++) {
            $Num = (int)substr($listadoOrigen[$i]['NumCuenta'],4);
            if($Num !== 0){
                $nodo['Num'] = $Num;
                $nodo['NumCuenta'] = $listadoOrigen[$i]['NumCuenta'];
                $nodo['Nombre'] = $listadoOrigen[$i]['Nombre'];
                $listado[] = $nodo;
            }
        }

        return $listado;
    }
    
    function nombreTarjeta($TipoTarjeta){
        logger('traza', 'clsCNDatosVentas.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCADDatosVentas->nombreTarjeta()>");
        require_once '../CAD/clsCADDatosVentas.php';
        $clsCADDatosVentas = new clsCADDatosVentas();
        $clsCADDatosVentas->setStrBDCliente($this->getStrBD());

        return $clsCADDatosVentas->nombreTarjeta($TipoTarjeta);
    }
    
    function nombreCuenta($cuenta){
        logger('traza', 'clsCNDatosVentas.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCADDatosVentas->nombreCuenta()>");
        require_once '../CAD/clsCADDatosVentas.php';
        $clsCADDatosVentas = new clsCADDatosVentas();
        $clsCADDatosVentas->setStrBDCliente($this->getStrBD());

        return $clsCADDatosVentas->nombreCuenta($cuenta);
    }
}
