<?php

require_once '../general/funcionesGenerales.php';

class clsCNContabilidad {

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
    
    function AltaMovimientos($idEmp, $strCuenta, $lngIngreso, $strCuentaCli, $lngCantidad, $lngIva, $datFecha, $lngPeriodo, $lngEjercicio, $strConcepto, $usuario) {
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->AltaMovimientos($idEmp,$strCuenta, $lngIngreso,$strCuentaCli,$lngCantidad,$lngIva,
                             $datFecha,$lngPeriodo,$lngEjercicio,$strConcepto,$usuario)>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->AltaMovimientos($idEmp, $strCuenta, $lngIngreso, $strCuentaCli, $lngCantidad, $lngIva, $datFecha, $lngPeriodo, $lngEjercicio, $strConcepto, $usuario);
    }

    function SelectCuentas($GRoSUBGR, $valor) {
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->SelectCuentas($GRoSUBGR,$valor)>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->SelectCuentas($GRoSUBGR, $valor);
    }

    function AltaGastosMovimientos($numAsiento,$idEmp, $strCuenta, $lngIngreso, $strCuentaCli, $lngCantidad, $lngIva,$lngPorciento, $datFecha, $optTipo, $strCuentaBancos, $strPeriodo, $lngEjercicio, $strConcepto, $esAbono,$strUsuario) {
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->AltaGastosMovimientos($numAsiento,$idEmp,$strCuenta, $lngIngreso,$strCuentaCli, $lngCantidad,$lngIva,$lngPorciento,$datFecha,
               $optTipo,$strCuentaBancos,$strPeriodo, $lngEjercicio,$strConcepto, $esAbono, $strUsuario)>");
        
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        //guardo solo el codigo de la cuenta
        $strCuenta=explode('-',$strCuenta);
        $strCuenta=$strCuenta[0];
        $strCuentaCli=explode('-',$strCuentaCli);
        $strCuentaCli=$strCuentaCli[0];
        $strCuentaBancos=explode('-',$strCuentaBancos);
        $strCuentaBancos=$strCuentaBancos[0];
        
        //indico el tipo de asiento
        //los tipos de asientos son:
        ////------------------------
        //00N Gasto Sin Factura                         ***  00A Gasto Sin Factura ABONO
        //01N Gasto Con Factura 1 IVA Sin IRPF          ***  01A Gasto Con Factura 1 IVA Sin IRPF ABONO
        //02N Gasto Con Factura 1 IVA Con IRPF          ***  02A Gasto Con Factura 1 IVA Con IRPF ABONO
        //03N Gasto Con Factura Varios IVAs             ***  03A Gasto Con Factura Varios IVAs ABONO
        
        if($esAbono==='NO'){
            $tipoAsiento='01N';
        }else{
            $tipoAsiento='01A';
        }
        
        return $clsCADContabilidad->AltaGastosMovimientos($numAsiento,$idEmp, $strCuenta, $lngIngreso, $strCuentaCli, $lngCantidad, $lngIva,$lngPorciento, $datFecha,
                                            $optTipo, $strCuentaBancos, $strPeriodo, $lngEjercicio, $strConcepto, $esAbono, $strUsuario,$tipoAsiento);
    }
    
    function AltaIngresosMovimientos($numAsiento,$idEmp, $strCuenta, $lngIngreso, $strCuentaCli, $lngCantidad, $lngIva,$lngPorciento, $datFecha, $optTipo, $strCuentaBancos, $strPeriodo, $lngEjercicio, $strConcepto, $esAbono,$strUsuario) {
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->AltaIngresosMovimientos()>");
        
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        //guardo solo el codigo de la cuenta
        $strCuenta=explode('-',$strCuenta);
        $strCuenta=$strCuenta[0];
        $strCuentaCli=explode('-',$strCuentaCli);
        $strCuentaCli=$strCuentaCli[0];
        $strCuentaBancos=explode('-',$strCuentaBancos);
        $strCuentaBancos=$strCuentaBancos[0];
        
        //indico el tipo de asiento
        //los tipos de asientos son:
        ////------------------------
        //10N Ingreso Sin Factura                       ***  10A Ingreso Sin Factura ABONO
        //11N Ingreso Con Factura 1 IVA Sin IRPF        ***  11A Ingreso Con Factura 1 IVA Sin IRPF ABONO
        //12N Ingreso Con Factura 1 IVA Con IRPF        ***  12A Ingreso Con Factura 1 IVA Con IRPF ABONO
        //13N Ingreso Con Factura Varios IVAs           ***  13A Ingreso Con Factura Varios IVAs ABONO
        
        if($esAbono==='NO'){
            $tipoAsiento='11N';
        }else{
            $tipoAsiento='11A';
        }
        
        return $clsCADContabilidad->AltaIngresosMovimientos($numAsiento,$idEmp, $strCuenta, $lngIngreso, $strCuentaCli, $lngCantidad, $lngIva,$lngPorciento, $datFecha,
                                            $optTipo, $strCuentaBancos, $strPeriodo, $lngEjercicio, $strConcepto, $esAbono, $strUsuario,$tipoAsiento);
    }
    
    function AltaIngresosMovimientos_VariasCuentas($numAsiento,$idEmp, $cuentaVentas, $lngIngreso, $strCuentaCli, $lngCantidad, $lngIva,$lngPorciento, $datFecha, $optTipo, $strCuentaBancos, $strPeriodo, $lngEjercicio, $strConcepto, $esAbono,$strUsuario) {
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->AltaIngresosMovimientos_VariasCuentas()>");
        
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        //guardo solo el codigo de la cuenta
//        $strCuenta=explode('-',$strCuenta);
//        $strCuenta=$strCuenta[0];
        $strCuentaCli=explode('-',$strCuentaCli);
        $strCuentaCli=$strCuentaCli[0];
        $strCuentaBancos=explode('-',$strCuentaBancos);
        $strCuentaBancos=$strCuentaBancos[0];
        
        //indico el tipo de asiento
        
        if($esAbono==='NO'){
            $tipoAsiento='15N';
        }else{
            $tipoAsiento='15A';
        }
        
        return $clsCADContabilidad->AltaIngresosMovimientos_VariasCuentas($numAsiento,$idEmp, $cuentaVentas, $lngIngreso, $strCuentaCli, $lngCantidad, $lngIva,$lngPorciento, $datFecha,
                                            $optTipo, $strCuentaBancos, $strPeriodo, $lngEjercicio, $strConcepto, $esAbono, $strUsuario,$tipoAsiento);
    }
    
    function AltaGastosMovimientosIRPF($numAsiento,$idEmp,$strCuenta,$strCuentaCli,
                                            $lngCantidad,$lngIva,$lngPorciento,
                                            $lngIRPF,$lngPorcientoIRPF,$datFecha,
                                            $optTipo,$strCuentaBancos,$lngPeriodo,$strPeriodo,
                                            $lngEjercicio, $strConcepto, $esAbono, $strUsuario)
    {
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->AltaGastosMovimientosIRPF($numAsiento,$idEmp,$strCuenta,$strCuentaCli,
                                            $lngCantidad,$lngIva,$lngPorciento,
                                            $lngIRPF,$lngPorcientoIRPF,$datFecha,
                                            $optTipo,$strCuentaBancos,$lngPeriodo,$strPeriodo,
                                            $lngEjercicio, $strConcepto, $esAbono, $strUsuario)>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        //guardo solo el codigo de la cuenta
        $strCuenta=explode('-',$strCuenta);
        $strCuenta=$strCuenta[0];
        $strCuentaCli=explode('-',$strCuentaCli);
        $strCuentaCli=$strCuentaCli[0];
        $strCuentaBancos=explode('-',$strCuentaBancos);
        $strCuentaBancos=$strCuentaBancos[0];
        
        //indico el tipo de asiento
        //los tipos de asientos son:
        ////------------------------
        //00N Gasto Sin Factura                         ***  00A Gasto Sin Factura ABONO
        //01N Gasto Con Factura 1 IVA Sin IRPF          ***  01A Gasto Con Factura 1 IVA Sin IRPF ABONO
        //02N Gasto Con Factura 1 IVA Con IRPF          ***  02A Gasto Con Factura 1 IVA Con IRPF ABONO
        //03N Gasto Con Factura Varios IVAs             ***  03A Gasto Con Factura Varios IVAs ABONO
        
        if($esAbono==='NO'){
            $tipoAsiento='02N';
        }else{
            $tipoAsiento='02A';
        }
        
        return $clsCADContabilidad->AltaGastosMovimientosIRPF($numAsiento,$idEmp,$strCuenta,$strCuentaCli,
                                            $lngCantidad,$lngIva,$lngPorciento,
                                            $lngIRPF,$lngPorcientoIRPF,$datFecha,
                                            $optTipo,$strCuentaBancos,$lngPeriodo,$strPeriodo,
                                            $lngEjercicio, $strConcepto, $esAbono, $strUsuario,$tipoAsiento);
    }
                
    function AltaIngresosMovimientosIRPF($numAsiento,$idEmp,$strCuenta,$strCuentaCli,
                                            $lngCantidad,$lngIva,$lngPorciento,
                                            $lngIRPF,$lngPorcientoIRPF,$datFecha,
                                            $optTipo,$strCuentaBancos,$lngPeriodo,$strPeriodo,
                                            $lngEjercicio, $strConcepto, $esAbono, $strUsuario)
    {
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->AltaIngresosMovimientosIRPF()>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        //guardo solo el codigo de la cuenta
        $strCuenta=explode('-',$strCuenta);
        $strCuenta=$strCuenta[0];
        $strCuentaCli=explode('-',$strCuentaCli);
        $strCuentaCli=$strCuentaCli[0];
        $strCuentaBancos=explode('-',$strCuentaBancos);
        $strCuentaBancos=$strCuentaBancos[0];
        
        //indico el tipo de asiento
        //los tipos de asientos son:
        ////------------------------
        //10N Ingreso Sin Factura                       ***  10A Ingreso Sin Factura ABONO
        //11N Ingreso Con Factura 1 IVA Sin IRPF        ***  11A Ingreso Con Factura 1 IVA Sin IRPF ABONO
        //12N Ingreso Con Factura 1 IVA Con IRPF        ***  12A Ingreso Con Factura 1 IVA Con IRPF ABONO
        //13N Ingreso Con Factura Varios IVAs           ***  13A Ingreso Con Factura Varios IVAs ABONO
        
        if($esAbono==='NO'){
            $tipoAsiento='12N';
        }else{
            $tipoAsiento='12A';
        }
        
        return $clsCADContabilidad->AltaIngresosMovimientosIRPF($numAsiento,$idEmp,$strCuenta,$strCuentaCli,
                                            $lngCantidad,$lngIva,$lngPorciento,
                                            $lngIRPF,$lngPorcientoIRPF,$datFecha,
                                            $optTipo,$strCuentaBancos,$lngPeriodo,$strPeriodo,
                                            $lngEjercicio, $strConcepto, $esAbono, $strUsuario,$tipoAsiento);
    }
                
    function AltaIngresosMovimientosIRPF_VariasCuentas($numAsiento,$idEmp,$cuentaVentas,$strCuentaCli,
                                            $lngCantidad,$lngIva,$lngPorciento,
                                            $lngIRPF,$lngPorcientoIRPF,$datFecha,
                                            $optTipo,$strCuentaBancos,$lngPeriodo,$strPeriodo,
                                            $lngEjercicio, $strConcepto, $esAbono, $strUsuario)
    {
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->AltaIngresosMovimientosIRPF_VariasCuentas()>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        //guardo solo el codigo de la cuenta
//        $strCuenta=explode('-',$strCuenta);
//        $strCuenta=$strCuenta[0];
        $strCuentaCli=explode('-',$strCuentaCli);
        $strCuentaCli=$strCuentaCli[0];
        $strCuentaBancos=explode('-',$strCuentaBancos);
        $strCuentaBancos=$strCuentaBancos[0];
        
        //indico el tipo de asiento
        
        if($esAbono==='NO'){
            $tipoAsiento='16N';
        }else{
            $tipoAsiento='16A';
        }
        
        return $clsCADContabilidad->AltaIngresosMovimientosIRPF_VariasCuentas($numAsiento,$idEmp,$cuentaVentas,$strCuentaCli,
                                            $lngCantidad,$lngIva,$lngPorciento,
                                            $lngIRPF,$lngPorcientoIRPF,$datFecha,
                                            $optTipo,$strCuentaBancos,$lngPeriodo,$strPeriodo,
                                            $lngEjercicio, $strConcepto, $esAbono, $strUsuario,$tipoAsiento);
    }
                
    function AltaGastosMovimientosIVA_Varios($numAsiento,$idEmp, $strCuenta, $lngIngreso, $strCuentaCli, $lngCantidad,
                                      $lngIva, $datFecha, $optTipo, $strCuentaBancos, $strPeriodo,
                                      $lngEjercicio,$strConcepto, $strUsuario,
                                      $lngCantidad1,$lngIva1,$lngPorciento1,
                                      $lngCantidad2,$lngIva2,$lngPorciento2,
                                      $lngCantidad3,$lngIva3,$lngPorciento3,
                                      $lngCantidad4,$lngIva4,$lngPorciento4,$esAbono)
    {
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->AltaGastosMovimientosIVA_Varios()>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        //guardo solo el codigo de la cuenta
        $strCuenta=explode('-',$strCuenta);
        $strCuenta=$strCuenta[0];
        $strCuentaCli=explode('-',$strCuentaCli);
        $strCuentaCli=$strCuentaCli[0];
        $strCuentaBancos=explode('-',$strCuentaBancos);
        $strCuentaBancos=$strCuentaBancos[0];
        
        //indico el tipo de asiento
        //los tipos de asientos son:
        ////------------------------
        //00N Gasto Sin Factura                         ***  00A Gasto Sin Factura ABONO
        //01N Gasto Con Factura 1 IVA Sin IRPF          ***  01A Gasto Con Factura 1 IVA Sin IRPF ABONO
        //02N Gasto Con Factura 1 IVA Con IRPF          ***  02A Gasto Con Factura 1 IVA Con IRPF ABONO
        //03N Gasto Con Factura Varios IVAs             ***  03A Gasto Con Factura Varios IVAs ABONO
        
        if($esAbono==='NO'){
            $tipoAsiento='03N';
        }else{
            $tipoAsiento='03A';
        }
        
        return $clsCADContabilidad->AltaGastosMovimientosIVA_Varios($numAsiento,$idEmp, $strCuenta, $lngIngreso, $strCuentaCli, $lngCantidad,
                                                                    $lngIva, $datFecha, $optTipo, $strCuentaBancos, $strPeriodo,
                                                                    $lngEjercicio,$strConcepto, $strUsuario,
                                                                    $lngCantidad1,$lngIva1,$lngPorciento1,
                                                                    $lngCantidad2,$lngIva2,$lngPorciento2,
                                                                    $lngCantidad3,$lngIva3,$lngPorciento3,
                                                                    $lngCantidad4,$lngIva4,$lngPorciento4,$esAbono,$tipoAsiento);
    }
    
    function AltaGastosMovimientosIVA_VariosIRPF($numAsiento,$idEmp, $strCuenta, $lngIngreso, $strCuentaCli, $lngCantidad,
                                      $lngIva, $datFecha, $optTipo, $strCuentaBancos, $strPeriodo,
                                      $lngEjercicio,$strConcepto, $strUsuario,
                                      $lngCantidad1,$lngIva1,$lngPorciento1,
                                      $lngCantidad2,$lngIva2,$lngPorciento2,
                                      $lngCantidad3,$lngIva3,$lngPorciento3,
                                      $lngCantidad4,$lngIva4,$lngPorciento4,$esAbono,
                                      $lngPorcientoIRPF,$lngIRPF)   
    {
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->AltaGastosMovimientosIVA_Varios($numAsiento,$idEmp, $strCuenta, $lngIngreso, $strCuentaCli, $lngCantidad,
                                      $lngIva, $datFecha, $optTipo, $strCuentaBancos, $strPeriodo,
                                      $lngEjercicio,$strConcepto, $strUsuario,
                                      $lngCantidad1,$lngIva1,$lngPorciento1,
                                      $lngCantidad2,$lngIva2,$lngPorciento2,
                                      $lngCantidad3,$lngIva3,$lngPorciento3,
                                      $lngCantidad4,$lngIva4,$lngPorciento4,$esAbono)>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        //guardo solo el codigo de la cuenta
        $strCuenta=explode('-',$strCuenta);
        $strCuenta=$strCuenta[0];
        $strCuentaCli=explode('-',$strCuentaCli);
        $strCuentaCli=$strCuentaCli[0];
        $strCuentaBancos=explode('-',$strCuentaBancos);
        $strCuentaBancos=$strCuentaBancos[0];
        
        //indico el tipo de asiento
        //los tipos de asientos son:
        ////------------------------
        //00N Gasto Sin Factura                         ***  00A Gasto Sin Factura ABONO
        //01N Gasto Con Factura 1 IVA Sin IRPF          ***  01A Gasto Con Factura 1 IVA Sin IRPF ABONO
        //02N Gasto Con Factura 1 IVA Con IRPF          ***  02A Gasto Con Factura 1 IVA Con IRPF ABONO
        //03N Gasto Con Factura Varios IVAs             ***  03A Gasto Con Factura Varios IVAs ABONO
        //04N Gasto Con Factura Varios IVAs Con IRPF    ***  04A Gasto Con Factura Varios IVAs Con IRPF ABONO
        
        if($esAbono==='NO'){
            $tipoAsiento='04N';
        }else{
            $tipoAsiento='04A';
        }
        
        return $clsCADContabilidad->AltaGastosMovimientosIVA_VariosIRPF($numAsiento,$idEmp, $strCuenta, $lngIngreso, $strCuentaCli, $lngCantidad,
                                                                    $lngIva, $datFecha, $optTipo, $strCuentaBancos, $strPeriodo,
                                                                    $lngEjercicio,$strConcepto, $strUsuario,
                                                                    $lngCantidad1,$lngIva1,$lngPorciento1,
                                                                    $lngCantidad2,$lngIva2,$lngPorciento2,
                                                                    $lngCantidad3,$lngIva3,$lngPorciento3,
                                                                    $lngCantidad4,$lngIva4,$lngPorciento4,$esAbono,$tipoAsiento,
                                                                    $lngPorcientoIRPF,$lngIRPF);   
    }
    
    function AltaIngresosMovimientosIVA_Varios($numAsiento,$idEmp, $strCuenta, $lngIngreso, $strCuentaCli, $lngCantidad,
                                      $lngIva, $datFecha, $optTipo, $strCuentaBancos, $strPeriodo,
                                      $lngEjercicio,$strConcepto, $strUsuario,
                                      $lngCantidad1,$lngIva1,$lngPorciento1,
                                      $lngCantidad2,$lngIva2,$lngPorciento2,
                                      $lngCantidad3,$lngIva3,$lngPorciento3,
                                      $lngCantidad4,$lngIva4,$lngPorciento4,$esAbono)
    {
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->AltaIngresosMovimientosIVA_Varios($numAsiento,$idEmp, $strCuenta, $lngIngreso, $strCuentaCli, $lngCantidad,
                                      $lngIva, $datFecha, $optTipo, $strCuentaBancos, $strPeriodo,
                                      $lngEjercicio,$strConcepto, $strUsuario,
                                      $lngCantidad1,$lngIva1,$lngPorciento1,
                                      $lngCantidad2,$lngIva2,$lngPorciento2,
                                      $lngCantidad3,$lngIva3,$lngPorciento3,
                                      $lngCantidad4,$lngIva4,$lngPorciento4,$esAbono)>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        //guardo solo el codigo de la cuenta
        $strCuenta=explode('-',$strCuenta);
        $strCuenta=$strCuenta[0];
        $strCuentaCli=explode('-',$strCuentaCli);
        $strCuentaCli=$strCuentaCli[0];
        $strCuentaBancos=explode('-',$strCuentaBancos);
        $strCuentaBancos=$strCuentaBancos[0];
        
        //indico el tipo de asiento
        //los tipos de asientos son:
        ////------------------------
        //10N Ingreso Sin Factura                       ***  10A Ingreso Sin Factura ABONO
        //11N Ingreso Con Factura 1 IVA Sin IRPF        ***  11A Ingreso Con Factura 1 IVA Sin IRPF ABONO
        //12N Ingreso Con Factura 1 IVA Con IRPF        ***  12A Ingreso Con Factura 1 IVA Con IRPF ABONO
        //13N Ingreso Con Factura Varios IVAs           ***  13A Ingreso Con Factura Varios IVAs ABONO
        
        if($esAbono==='NO'){
            $tipoAsiento='13N';
        }else{
            $tipoAsiento='13A';
        }
        
        return $clsCADContabilidad->AltaIngresosMovimientosIVA_Varios($numAsiento,$idEmp, $strCuenta, $lngIngreso, $strCuentaCli, $lngCantidad,
                                                                    $lngIva, $datFecha, $optTipo, $strCuentaBancos, $strPeriodo,
                                                                    $lngEjercicio,$strConcepto, $strUsuario,
                                                                    $lngCantidad1,$lngIva1,$lngPorciento1,
                                                                    $lngCantidad2,$lngIva2,$lngPorciento2,
                                                                    $lngCantidad3,$lngIva3,$lngPorciento3,
                                                                    $lngCantidad4,$lngIva4,$lngPorciento4,$esAbono,$tipoAsiento);
    }
    
    function AltaIngresosMovimientosIVA_Varios_VariasCuentas($numAsiento,$idEmp, $cuentaVentas, $lngIngreso, $strCuentaCli, $lngCantidad,
                                      $lngIva, $datFecha, $optTipo, $strCuentaBancos, $strPeriodo,
                                      $lngEjercicio,$strConcepto, $strUsuario,
                                      $lngCantidad1,$lngIva1,$lngPorciento1,
                                      $lngCantidad2,$lngIva2,$lngPorciento2,
                                      $lngCantidad3,$lngIva3,$lngPorciento3,
                                      $lngCantidad4,$lngIva4,$lngPorciento4,$esAbono)
    {
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->AltaIngresosMovimientosIVA_Varios_VariasCuentas()>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        //guardo solo el codigo de la cuenta
//        $strCuenta=explode('-',$strCuenta);
//        $strCuenta=$strCuenta[0];
        $strCuentaCli=explode('-',$strCuentaCli);
        $strCuentaCli=$strCuentaCli[0];
        $strCuentaBancos=explode('-',$strCuentaBancos);
        $strCuentaBancos=$strCuentaBancos[0];
        
        //indico el tipo de asiento
        
        if($esAbono==='NO'){
            $tipoAsiento='17N';
        }else{
            $tipoAsiento='17A';
        }
        
        return $clsCADContabilidad->AltaIngresosMovimientosIVA_Varios_VariasCuentas($numAsiento,$idEmp, $cuentaVentas, $lngIngreso, $strCuentaCli, $lngCantidad,
                                                                    $lngIva, $datFecha, $optTipo, $strCuentaBancos, $strPeriodo,
                                                                    $lngEjercicio,$strConcepto, $strUsuario,
                                                                    $lngCantidad1,$lngIva1,$lngPorciento1,
                                                                    $lngCantidad2,$lngIva2,$lngPorciento2,
                                                                    $lngCantidad3,$lngIva3,$lngPorciento3,
                                                                    $lngCantidad4,$lngIva4,$lngPorciento4,$esAbono,$tipoAsiento);
    }
    
    function AltaIngresosMovimientosIVA_VariosIRPF($numAsiento,$idEmp, $strCuenta, $lngIngreso, $strCuentaCli, $lngCantidad,
                                      $lngIva, $datFecha, $optTipo, $strCuentaBancos, $strPeriodo,
                                      $lngEjercicio,$strConcepto, $strUsuario,
                                      $lngCantidad1,$lngIva1,$lngPorciento1,
                                      $lngCantidad2,$lngIva2,$lngPorciento2,
                                      $lngCantidad3,$lngIva3,$lngPorciento3,
                                      $lngCantidad4,$lngIva4,$lngPorciento4,
                                      $esAbono,$lngPorcientoIRPF,$lngIRPF)
    {
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->AltaIngresosMovimientosIVA_VariosIRPF()>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        //guardo solo el codigo de la cuenta
        $strCuenta=explode('-',$strCuenta);
        $strCuenta=$strCuenta[0];
        $strCuentaCli=explode('-',$strCuentaCli);
        $strCuentaCli=$strCuentaCli[0];
        $strCuentaBancos=explode('-',$strCuentaBancos);
        $strCuentaBancos=$strCuentaBancos[0];
        
        //indico el tipo de asiento
        //los tipos de asientos son:
        ////------------------------
        //10N Ingreso Sin Factura                       ***  10A Ingreso Sin Factura ABONO
        //11N Ingreso Con Factura 1 IVA Sin IRPF        ***  11A Ingreso Con Factura 1 IVA Sin IRPF ABONO
        //12N Ingreso Con Factura 1 IVA Con IRPF        ***  12A Ingreso Con Factura 1 IVA Con IRPF ABONO
        //13N Ingreso Con Factura Varios IVAs sin IRPF  ***  13A Ingreso Con Factura Varios IVAs sin IRPF ABONO
        //14N Ingreso Con Factura Varios IVAs con IRPF  ***  14A Ingreso Con Factura Varios IVAs con IRPF ABONO
        
        if($esAbono==='NO'){
            $tipoAsiento='14N';
        }else{
            $tipoAsiento='14A';
        }
        
        return $clsCADContabilidad->AltaIngresosMovimientosIVA_VariosIRPF($numAsiento,$idEmp, $strCuenta, $lngIngreso, $strCuentaCli, $lngCantidad,
                                                                    $lngIva, $datFecha, $optTipo, $strCuentaBancos, $strPeriodo,
                                                                    $lngEjercicio,$strConcepto, $strUsuario,
                                                                    $lngCantidad1,$lngIva1,$lngPorciento1,
                                                                    $lngCantidad2,$lngIva2,$lngPorciento2,
                                                                    $lngCantidad3,$lngIva3,$lngPorciento3,
                                                                    $lngCantidad4,$lngIva4,$lngPorciento4,
                                                                    $esAbono,$lngPorcientoIRPF,$lngIRPF,$tipoAsiento);
    }
    
    function AltaIngresosMovimientosIVA_VariosIRPF_VariasCuentas($numAsiento,$idEmp, $cuentaVentas, $lngIngreso, $strCuentaCli, $lngCantidad,
                                      $lngIva, $datFecha, $optTipo, $strCuentaBancos, $strPeriodo,
                                      $lngEjercicio,$strConcepto, $strUsuario,
                                      $lngCantidad1,$lngIva1,$lngPorciento1,
                                      $lngCantidad2,$lngIva2,$lngPorciento2,
                                      $lngCantidad3,$lngIva3,$lngPorciento3,
                                      $lngCantidad4,$lngIva4,$lngPorciento4,
                                      $esAbono,$lngPorcientoIRPF,$lngIRPF)
    {
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->AltaIngresosMovimientosIVA_VariosIRPF()>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        //guardo solo el codigo de la cuenta
//        $strCuenta=explode('-',$strCuenta);
//        $strCuenta=$strCuenta[0];
        $strCuentaCli=explode('-',$strCuentaCli);
        $strCuentaCli=$strCuentaCli[0];
        $strCuentaBancos=explode('-',$strCuentaBancos);
        $strCuentaBancos=$strCuentaBancos[0];
        
        //indico el tipo de asiento
        
        if($esAbono==='NO'){
            $tipoAsiento='18N';
        }else{
            $tipoAsiento='18A';
        }
        
        return $clsCADContabilidad->AltaIngresosMovimientosIVA_VariosIRPF_VariasCuentas($numAsiento,$idEmp, $cuentaVentas, $lngIngreso, $strCuentaCli, $lngCantidad,
                                                                    $lngIva, $datFecha, $optTipo, $strCuentaBancos, $strPeriodo,
                                                                    $lngEjercicio,$strConcepto, $strUsuario,
                                                                    $lngCantidad1,$lngIva1,$lngPorciento1,
                                                                    $lngCantidad2,$lngIva2,$lngPorciento2,
                                                                    $lngCantidad3,$lngIva3,$lngPorciento3,
                                                                    $lngCantidad4,$lngIva4,$lngPorciento4,
                                                                    $esAbono,$lngPorcientoIRPF,$lngIRPF,$tipoAsiento);
    }
    
    function AltaGastosMovimientosSinIVA($numAsiento,$idEmp,$strCuenta, $lngIngreso,
                                            $strCuentaCli, $lngCantidad, $datFecha,$optTipo,
                                            $strCuentaBancos,$strPeriodo, $lngEjercicio, $strConcepto,$esAbono, $strUsuario)
    {
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->AltaGastosMovimientosSinIVA($numAsiento,$idEmp,$strCuenta, $lngIngreso,
                                            $strCuentaCli, $lngCantidad, $datFecha,$optTipo,
                                            $strCuentaBancos,$strPeriodo, $lngEjercicio, $strConcepto,$esAbono, $strUsuario)>");
        
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        //guardo solo el codigo de la cuenta
        $strCuenta=explode('-',$strCuenta);
        $strCuenta=$strCuenta[0];
        $strCuentaCli=explode('-',$strCuentaCli);
        $strCuentaCli=$strCuentaCli[0];
        $strCuentaBancos=explode('-',$strCuentaBancos);
        $strCuentaBancos=$strCuentaBancos[0];
        
        //indico el tipo de asiento
        //los tipos de asientos son:
        ////------------------------
        //00N Gasto Sin Factura                         ***  00A Gasto Sin Factura ABONO
        //01N Gasto Con Factura 1 IVA Sin IRPF          ***  01A Gasto Con Factura 1 IVA Sin IRPF ABONO
        //02N Gasto Con Factura 1 IVA Con IRPF          ***  02A Gasto Con Factura 1 IVA Con IRPF ABONO
        //03N Gasto Con Factura Varios IVAs             ***  03A Gasto Con Factura Varios IVAs ABONO
        
        if($esAbono==='NO'){
            $tipoAsiento='00N';
        }else{
            $tipoAsiento='00A';
        }
        
        return $clsCADContabilidad->AltaGastosMovimientosSinIVA($numAsiento,$idEmp,$strCuenta, $lngIngreso,
                                            $strCuentaCli, $lngCantidad, $datFecha,$optTipo,
                                            $strCuentaBancos,$strPeriodo, $lngEjercicio, $strConcepto, $esAbono, $strUsuario,$tipoAsiento);
    }
    
    function AltaIngresosMovimientosSinIVA($numAsiento,$idEmp,$strCuenta, $lngIngreso,
                                            $strCuentaCli, $lngCantidad, $datFecha,$optTipo,
                                            $strCuentaBancos,$strPeriodo, $lngEjercicio, $strConcepto,$esAbono, $strUsuario)
    {
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->AltaIngresosMovimientosSinIVA($numAsiento,$idEmp,$strCuenta, $lngIngreso,
                                            $strCuentaCli, $lngCantidad, $datFecha,$optTipo,
                                            $strCuentaBancos,$strPeriodo, $lngEjercicio, $strConcepto,$esAbono, $strUsuario)>");
        
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        //guardo solo el codigo de la cuenta
        $strCuenta=explode('-',$strCuenta);
        $strCuenta=$strCuenta[0];
        $strCuentaCli=explode('-',$strCuentaCli);
        $strCuentaCli=$strCuentaCli[0];
        $strCuentaBancos=explode('-',$strCuentaBancos);
        $strCuentaBancos=$strCuentaBancos[0];
        
        //indico el tipo de asiento
        //los tipos de asientos son:
        ////------------------------
        //10N Ingreso Sin Factura                       ***  10A Ingreso Sin Factura ABONO
        //11N Ingreso Con Factura 1 IVA Sin IRPF        ***  11A Ingreso Con Factura 1 IVA Sin IRPF ABONO
        //12N Ingreso Con Factura 1 IVA Con IRPF        ***  12A Ingreso Con Factura 1 IVA Con IRPF ABONO
        //13N Ingreso Con Factura Varios IVAs           ***  13A Ingreso Con Factura Varios IVAs ABONO
        
        if($esAbono==='NO'){
            $tipoAsiento='10N';
        }else{
            $tipoAsiento='10A';
        }
        
        return $clsCADContabilidad->AltaIngresosMovimientosSinIVA($numAsiento,$idEmp,$strCuenta, $lngIngreso,
                                            $strCuentaCli, $lngCantidad, $datFecha,$optTipo,
                                            $strCuentaBancos,$strPeriodo, $lngEjercicio, $strConcepto, $esAbono, $strUsuario,$tipoAsiento);
    }
    
    function AltaIngresosGastos($idEmp, $movimientosAsiento, $datFecha, $lngPeriodo, $lngEjercicio, $strUsuario) {
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->AltaIngresosGastos($idEmp,$movimientosAsiento,
                                                       $datFecha,$lngPeriodo, $lngEjercicio, $strUsuario)>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->AltaIngresosGastos($idEmp, $movimientosAsiento, $datFecha, $lngPeriodo, $lngEjercicio, $strUsuario);
    }

    function EditarIngresosGastos($Asiento, $datosAsientoOriginal, $idEmp, $movimientosAsiento, $datFecha, $lngPeriodo, $lngEjercicio, $strUsuario) {
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->EditarIngresosGastos($Asiento,$datosAsientoOriginal,$idEmp,$movimientosAsiento,
                                                       $datFecha,$lngPeriodo, $lngEjercicio, $strUsuario)>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->EditarIngresosGastos($Asiento, $datosAsientoOriginal, $idEmp, $movimientosAsiento, $datFecha, $lngPeriodo, $lngEjercicio, $strUsuario);
    }

    function ListadoModAsientos($strCuenta,$lngPeriodo,$lngEjercicio,$datFechaInicio,$datFechaFin,$strOpcion,$lngCantidad) {
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->ListadoModAsientos($strCuenta,$lngPeriodo,$lngEjercicio,$datFechaInicio,$datFechaFin,$strOpcion,$lngCantidad)>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->ObtieneListaModAsiento($strCuenta,$lngPeriodo,$lngEjercicio,$datFechaInicio,$datFechaFin,$strOpcion,$lngCantidad);
    }

    function ListadoAsientosCuenta($cuenta, $parametros) {
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->ListadoAsientosCuenta($cuenta,parametros)>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->ListadoAsientosCuenta($cuenta, $parametros);
    }

    function leeAsiento($Asiento, $DoH) {
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->leeAsiento($Asiento,$DoH)>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->leeAsiento($Asiento, $DoH);
    }

    function leeAsientoFecha($Asiento) {
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->leeAsientoFecha($Asiento)>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->leeAsientoFecha($Asiento);
    }

    function consultaCerradoIVA() {
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->consultaCerradoIVA()>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->consultaCerradoIVA();
    }

    function consultaAbiertoIVA() {
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->consultaAbiertoIVA()>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->consultaAbiertoIVA();
    }

    function calculoDatosIVA($lngEjercicio) {
        //primero leo la tabla 'tbiva'
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->consultaCerradoIVA()>");
        $datosCerradoIVA = $this->consultaCerradoIVA();
        
        //ahora leo los datos de la tabla 'tbmovimientos' y 'tbmovimientos_iva' del año $lngEjercicio y 
        //las cuentas que comiencen por 4720 y 4770
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->consultaAbiertoIVA()>");
        $datosAbiertoIVA = $this->consultaAbiertoIVA();

        //a continuación comienzo a preparar los datos que saldran en la consulta
        //voy a recojer los datos que presentaré en un array
        //el tamaño del array es 4 (trimestres) 
        //hago un primer recorrido rellenando los datos que vienen del $datosCerradoIVA
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                ' clsCNContabilidad->calculoDatosIVA(): Introduzco en $datos todos los IVAs por trimestre');
        $datos = '';
        $trimestreCerrado = 0;
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->calculoDatosIVA(): Primero los que vienen de la tabla 'tbiva' que son periodos cerrados");
        for ($i = 1; $i <= count($datosCerradoIVA); $i++) {
            if($i>1){$dato_A_Compensar=$datosCerradoIVA[$i - 1]["A_Compensar"];}else{$dato_A_Compensar=0;}
            $datos[] = array(
                "Saldo_Anterior" => $dato_A_Compensar,
                "Ejercicio" => $datosCerradoIVA[$i]["Ejercicio"],
                "Trimestre" => $datosCerradoIVA[$i]["Trimestre"],
                "IVA_Repercutido" => $datosCerradoIVA[$i]["IVA_Repercutido"],
                "IVA_Soportado" => $datosCerradoIVA[$i]["IVA_Soportado"],
                "A_Compensar" => $datosCerradoIVA[$i]["A_Compensar"],
                "Esta_Cerrado" => "SI"
            );
            logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                    ' $datos['.$trimestreCerrado.']: Saldo_Anterior=>'.$datos[$trimestreCerrado]["Saldo_Anterior"].' - Ejercicio=>'.$datos[$trimestreCerrado]["Ejercicio"].' - Trimestre=>'.$datos[$trimestreCerrado]["Trimestre"].' - IVA_Repercutido=>'.$datos[$trimestreCerrado]["IVA_Repercutido"].' - IVA_Soportado=>'.$datos[$trimestreCerrado]["IVA_Soportado"].' - A_Compensar=>'.$datos[$trimestreCerrado]["A_Compensar"].' - Esta_Cerrado=>'.$datos[$trimestreCerrado]["Esta_Cerrado"]);
            $trimestreCerrado++;
        }
        if(is_null($datosCerradoIVA[1])){
            //no hay datos de IVAs cerrados, creo esta variable con el año en curso y periodo 0 
            $ultimoTrimestreCerrado=array(
                "Ejercicio"=>$lngEjercicio,
                "Trimestre"=>0,  //asi al sumar mas adelante no hay incongruencias
                "A_Compensar"=>0,  //asi al sumar mas adelante no hay incongruencias
            );
        }else{
            //existen datos de IVAs cerrados, los coje
            $ultimoTrimestreCerrado = $datosCerradoIVA[count($datosCerradoIVA)];
        }
        
        $trimestreActual = $ultimoTrimestreCerrado['Trimestre'] + 1;
        $ejercicioActual=$ultimoTrimestreCerrado['Ejercicio'];
        if($trimestreActual>4){//si el trimestre es 4 el sigueinte trimestre es 1 del año siguiente
            $trimestreActual=1;
            $ejercicioActual=$ejercicioActual+1;
        }
        $A_CompensarActual = $ultimoTrimestreCerrado['A_Compensar'];
        
        //recorro los $datosAbiertoIVA y los introduzco en el array $datos
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->calculoDatosIVA(): Segundo los que vienen de la tabla 'tbamovimientos' que son periodos abiertos");

        $ultimoEjercicioCerrado=$ejercicioActual;
        $ultimoTrimestreCerrado=$trimestreActual-1;//es el trimestre anterior
        //calculo el primer periodo sin cerrar
        $primerEjercicioSinCerrar=$ultimoEjercicioCerrado;
        $primerTrimestreSinCerrar=$ultimoTrimestreCerrado+1;
        if($primerTrimestreSinCerrar>=5){
            $primerEjercicioSinCerrar++;
            $primerTrimestreSinCerrar=1;
        }
        
        //calculo en numero de trimestres a recorrer
        $difEjercicios=$lngEjercicio-$primerEjercicioSinCerrar;
        
        $ejercicioActual=$primerEjercicioSinCerrar;
        $trimestreActual=$primerTrimestreSinCerrar;
        
        //voy recorriendo los trimestres que quedan por recorrer
        for ($j = $primerTrimestreSinCerrar; $j <= 44; $j++) { //4 trimestres como máximo
            //calculo los datos a introducir en al array
            $IVA_Repercutido=0;
            $IVA_Soportado=0;
            
            //$IVA_Repercutido
            for ($i = 1; $i <= count($datosAbiertoIVA); $i++) {

                //compruebo si ejercicio y trimestre son los buscados y lo guardo en Repercutido
                if($datosAbiertoIVA[$i]['Tipo']==='Repercutido' &&
                   $datosAbiertoIVA[$i]['Ejercicio']==$ejercicioActual &&
                   $datosAbiertoIVA[$i]['Trimestre']==$trimestreActual){
                    $IVA_Repercutido=$datosAbiertoIVA[$i]['Cuota'];
                }

                //compruebo si ejercicio y trimestre son los buscados y lo guardo en Soportado
                if($datosAbiertoIVA[$i]['Tipo']==='Soportado' &&
                   $datosAbiertoIVA[$i]['Ejercicio']==$ejercicioActual &&
                   $datosAbiertoIVA[$i]['Trimestre']==$trimestreActual){
                    $IVA_Soportado=$datosAbiertoIVA[$i]['Cuota'];
                }
            }
            
            //paso los datos al array $datos
            $datos[] = array(
                "Saldo_Anterior" => $A_CompensarActual,
                "Ejercicio" => $ejercicioActual,
                "Trimestre" => $trimestreActual,
                "IVA_Repercutido" => $IVA_Repercutido,
                "IVA_Soportado" => $IVA_Soportado,
                "A_Compensar" => $IVA_Repercutido - $IVA_Soportado + $A_CompensarActual,
                "Esta_Cerrado" => "NO"
            );

            $trimestreActual++;
            //si $trimestreActual pasa de 4 (5) es que es el 1 trimestre del ejercicio siguiente
            if($trimestreActual>=5){
                $trimestreActual=1;
                $ejercicioActual++;
            }
            //actualizo en A compensar del siguiente ciclo
            $A_CompensarActual = $IVA_Repercutido - $IVA_Soportado + $A_CompensarActual;
            //si es superior a 0 es a ingresar por lo que el Saldo Anterior siguiente es 0
            if($A_CompensarActual>=0){
                $A_CompensarActual = 0;
            }
            
        }
        
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->calculoDatosIVA(): Por ultimo introduzco los datos que se van a presentar en pantalla en un array");
        //ahora introduzco los datos a presentar en un array
        $trimestreDatos = array(
            "Saldo_Anterior" => '0,00',
            "IVA_Repercutido" => '0,00',
            "IVA_Soportado" => '0,00',
            "Resultado" => "",
            "Esta_Cerrado" => ""
        );
        $datosPresentar = array(
            "0T" => $trimestreDatos,
            "1T" => $trimestreDatos,
            "2T" => $trimestreDatos,
            "3T" => $trimestreDatos,
            "4T" => $trimestreDatos,
            "Total" => $trimestreDatos
        );
        //comienzo a introducir los datos
        //los totales se inician a 0
        $datosPresentar['Total']['IVA_Repercutido'] = 0;
        $datosPresentar['Total']['IVA_Soportado'] = 0;
        
        foreach ($datos as $valor) {
            //primero introduzco el cuarto trimestre del año anterior (me valdrá para calculos de totales y algunas comprobaciones)
            if ($valor['Ejercicio'] == ($lngEjercicio-1)) {
                if ($valor['Trimestre'] == 4) {
                    logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                            " clsCNContabilidad->calculaDatosTrimestre(valor,datosPresentar,'0T')>");
                    $this->calculaDatosTrimestre($valor,$datosPresentar,'0T');
                }
            }
            
            //ahora introduzco los del año seleccionado
            if ($valor['Ejercicio'] == $lngEjercicio) {
                if ($valor['Trimestre'] == 1) {
                    logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                            " clsCNContabilidad->calculaDatosTrimestre(valor,datosPresentar,'1T')>");
                    $this->calculaDatosTrimestre($valor,$datosPresentar,'1T');
                } else if ($valor['Trimestre'] == 2) {
                    logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                            " clsCNContabilidad->calculaDatosTrimestre(valor,datosPresentar,'2T')>");
                    $this->calculaDatosTrimestre($valor,$datosPresentar,'2T');
                } else if ($valor['Trimestre'] == 3) {
                    logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                            " clsCNContabilidad->calculaDatosTrimestre(valor,datosPresentar,'3T')>");
                    $this->calculaDatosTrimestre($valor,$datosPresentar,'3T');
                } else if ($valor['Trimestre'] == 4) {
                    logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                            " clsCNContabilidad->calculaDatosTrimestre(valor,datosPresentar,'4T')>");
                    $this->calculaDatosTrimestre($valor,$datosPresentar,'4T');
                }
            }
        }
        //calculo el resultado anual natural (1/enero al 31-diciembre)
        $datosPresentar['Total']['Resultado']=$datosPresentar['Total']['IVA_Repercutido']-$datosPresentar['Total']['IVA_Soportado']-desFormateaNumeroContabilidad($datosPresentar['1T']['Saldo_Anterior']);
        $datosPresentar['Total']['IVA_Repercutido']=formateaNumeroContabilidad($datosPresentar['Total']['IVA_Repercutido']);
        $datosPresentar['Total']['IVA_Soportado']=formateaNumeroContabilidad($datosPresentar['Total']['IVA_Soportado']);

        //ahora comprobamos si este resultado es negativo (A_Compensar) o positivo
        if($datosPresentar['Total']['Resultado']<0){
            $datosPresentar['Total']['Resultado'] = '<font color="#FF0000">' . formateaNumeroContabilidad($datosPresentar['Total']['Resultado']) . '<br/>A Compensar</font>';
        }else{//si es positivo es a ingresar
            $datosPresentar['Total']['Resultado'] = formateaNumeroContabilidad($datosPresentar['Total']['Resultado']) . '<br/>Ingresar';
        }
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                ' clsCNContabilidad->calculoDatosIVA()<TERMINA y DEVUELVE $datosPresentar');
        
        return $datosPresentar;
    }
    
    function consultaCerradoIRPF() {
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->consultaCerradoIRPF()>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->consultaCerradoIRPF();
    }

    function consultaAbiertoIRPF($clave) {
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->consultaAbiertoIRPF($clave)>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->consultaAbiertoIRPF($clave);
    }

    function calculoDatosIRPF($lngEjercicio){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->consultaCerradoIRPF()>");
        $datosCerradoIRPF = $this->consultaCerradoIRPF();
        //print_r($datosCerradoIRPF);die;
        //ahora leo los datos de la tabla 'tbmovimientos' y 'tbretencion_irpf' del año $lngEjercicio y 
        //las cuentas que comiencen por 4751
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->consultaAbiertoIRPF()>");
        $datosAbiertoIRPF_G = $this->consultaAbiertoIRPF('G');
        $datosAbiertoIRPF_A = $this->consultaAbiertoIRPF('A');
        
        //a continuación comienzo a preparar los datos que saldran en la consulta
        //voy a recojer los datos que presentaré en un array
        //el tamaño del array es 4 (trimestres) 
        //hago un primer recorrido rellenando los datos que vienen del $datosCerradoIRPF
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                ' clsCNContabilidad->calculoDatosIRPF(): Introduzco en $datos todos los IRPFs por trimestres');
        $datos = '';
        $trimestreCerrado = 0;
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->calculoDatosIRPF(): Primero los que vienen de la tabla 'tbirpf' que son periodos cerrados");
        if(is_array($datosCerradoIRPF)){
            for ($i = 0; $i < count($datosCerradoIRPF); $i++) {
                $datos[] = array(
                    "Ejercicio" => $datosCerradoIRPF[$i]['Ejercicio'],
                    "Trimestre" => $datosCerradoIRPF[$i]['Trimestre'],
                    "BaseA" => $datosCerradoIRPF[$i]['BaseImponibleA'],
                    "RetencionesA" => $datosCerradoIRPF[$i]['RetencionA'],
                    "BaseG" => $datosCerradoIRPF[$i]['BaseImponibleG'],
                    "RetencionesG" => $datosCerradoIRPF[$i]['RetencionG'],
                    "Esta_Cerrado" => "SI"
                );
                logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                        ' $datos['.$i.']: Ejercicio=>'.$datos[$i]["Ejercicio"].' - Trimestre=>'.$datos[$i]["Trimestre"].
                        ' - BaseA=>'.$datos[$i]["BaseA"].' - RetencionesA=>'.$datos[$i]["RetencionesA"].
                        ' - BaseG=>'.$datos[$i]["BaseG"].' - RetencionesG=>'.$datos[$i]["RetencionesG"].
                        ' - Esta_Cerrado=>'.$datos[$i]["Esta_Cerrado"]);
                $trimestreCerrado=$datosCerradoIRPF[$i]['Trimestre'];
            }
        }
        if(!is_array($datosCerradoIRPF)){
            //no hay datos de IRPFs cerrados, creo esta variable con el año en curso
            $ultimoTrimestreCerrado=array(
                "Ejercicio"=>$lngEjercicio,
                "Trimestre"=>0,  //asi al sumar mas adelante no hay incongruencias
            );
        }else{
            //existen datos de IRPFs cerrados, los coje
            $ultimoTrimestreCerrado = $datosCerradoIRPF[count($datosCerradoIRPF)-1];
        }
        
        $trimestreActual = $ultimoTrimestreCerrado['Trimestre'] + 1;
        $ejercicioActual=$ultimoTrimestreCerrado['Ejercicio'];
        if($trimestreActual>4){//si el trimestre es 4 el siguiente trimestre es 1 del año siguiente
            $trimestreActual=1;
            $ejercicioActual=$ejercicioActual+1;
        }
        
        //recorro los $datosAbiertoIRPF y los introduzco en el array $datos
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->calculoDatosIRPF(): Segundo los que vienen de la tabla 'tbretenciones_irpf' que son periodos abiertos");

        $ultimoEjercicioCerrado=$ejercicioActual;
        $ultimoTrimestreCerrado=$trimestreActual-1;//es el trimestre anterior
        if($ultimoTrimestreCerrado<=0){//si es trimestre 0 es el 4 del año anterior
            $ultimoTrimestreCerrado=4;
            $ultimoEjercicioCerrado=$ultimoEjercicioCerrado-1;
        }
        //calculo el primer periodo sin cerrar
        $primerEjercicioSinCerrar=$ultimoEjercicioCerrado;
        $primerTrimestreSinCerrar=$ultimoTrimestreCerrado+1;
        if($primerTrimestreSinCerrar>=5){
            $primerEjercicioSinCerrar++;
            $primerTrimestreSinCerrar=1;
        }
        
        //recorrer el array $datosAbiertoIRPF_A
        $k=0;
        if($primerEjercicioSinCerrar==$lngEjercicio){
            foreach ($datosAbiertoIRPF_G as $trimestreG) { //4 trimestres como máximo
                //introduzco los datos en al array
                //veo si el ejercicio y trimestre coinciden, entonces cojo los datos de A
                if(isset($datosAbiertoIRPF_A)){
                    for($k=0;$k<count($datosAbiertoIRPF_A);$k++){
                        $encontrado='NO';
                        if($trimestreG['ejercicio']===$datosAbiertoIRPF_A[$k]['ejercicio'] && 
                           $trimestreG['Trimestre']===$datosAbiertoIRPF_A[$k]['Trimestre']){
                            $baseA=$datosAbiertoIRPF_A[$k]['Base'];
                            $retencionesA=$datosAbiertoIRPF_A[$k]['Cuota'];
                            $encontrado='SI';
                            break;
                        }
                        if($encontrado==='NO'){
                            $baseA=0;
                            $retencionesA=0;
                        }
                    }
                }
                if(!isset($baseA)){
                    $baseA=0;
                }
                if(!isset($retencionesA)){
                    $retencionesA=0;
                }
                
                //miro si este Ejercicio y trimestre estan en $datos (significa que esta cerrado),
                //si es asi no lo introduzco
                $cerrado='NO';
                foreach($datos as $datoCerrado){
                    if(($trimestreG['ejercicio']===$datoCerrado['Ejercicio'] &&
                       $trimestreG['Trimestre']===$datoCerrado['Trimestre'])){
                        $cerrado='SI';
                    }
                }

                if($cerrado==='NO'){
                    //paso los datos al array $datos
                    $datos[] = array(
                        "Ejercicio" => $trimestreG['ejercicio'],//resto a j 1 porque el array comienza en 0
                        "Trimestre" => $trimestreG['Trimestre'],
                        "BaseG" => $trimestreG['Base'],
                        "RetencionesG" => $trimestreG['Cuota'],
                        "BaseA" => $baseA,
                        "RetencionesA" => $retencionesA,
                        "Esta_Cerrado" => "NO"
                    );
                }
            }
        }

        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->calculoDatosIRPF(): Por ultimo introduzco los datos que se van a presentar en pantalla en un array");
        //ahora introduzco los datos a presentar en un array
        $trimestreDatos = array(
            "BaseA" => '0,00',
            "RetencionesA" => '0,00',
            "BaseG" => '0,00',
            "RetencionesG" => '0,00',
            "Esta_Cerrado" => "NO"
        );
        $trimestreTotal = array(
            "1T" => '0,00',
            "2T" => '0,00',
            "3T" => '0,00',
            "4T" => '0,00',
            "Total" => '0,00'
        );
        $datosPresentar = array(
            "0T" => $trimestreDatos,
            "1T" => $trimestreDatos,
            "2T" => $trimestreDatos,
            "3T" => $trimestreDatos,
            "4T" => $trimestreDatos,
            "Total" => $trimestreDatos,
            "TrimestresTotal" => $trimestreTotal
        );
        
        //comienzo a introducir los datos
        //los totales se inician a 0
        $datosPresentar['Total']['BaseA'] = 0;
        $datosPresentar['Total']['RetencionesA'] = 0;
        $datosPresentar['Total']['BaseG'] = 0;
        $datosPresentar['Total']['RetencionesG'] = 0;
        
        foreach ($datos as $valor) {
            //introduzco los datos
            
            //primero los del 4 trimestre del ejercico anterior
            if ($valor['Ejercicio'] == ($lngEjercicio-1) && $valor['Trimestre']==='4') {
                $datosPresentar['0T']['Esta_Cerrado']=$valor['Esta_Cerrado'];
            }
            
            if ($valor['Ejercicio'] == $lngEjercicio) {
                $datosPresentar['Total']['BaseA']=$datosPresentar['Total']['BaseA']+$valor['BaseA'];
                $datosPresentar['Total']['RetencionesA']=$datosPresentar['Total']['RetencionesA']+$valor['RetencionesA'];
                $datosPresentar['Total']['BaseG']=$datosPresentar['Total']['BaseG']+$valor['BaseG'];
                $datosPresentar['Total']['RetencionesG']=$datosPresentar['Total']['RetencionesG']+$valor['RetencionesG'];
                if ($valor['Trimestre'] == 1) {
                    $datosPresentar['1T']['BaseA']= formateaNumeroContabilidad($valor['BaseA']);
                    $datosPresentar['1T']['RetencionesA']= formateaNumeroContabilidad($valor['RetencionesA']);
                    $datosPresentar['1T']['BaseG']= formateaNumeroContabilidad($valor['BaseG']);
                    $datosPresentar['1T']['RetencionesG']= formateaNumeroContabilidad($valor['RetencionesG']);
                    $datosPresentar['1T']['Esta_Cerrado']=$valor['Esta_Cerrado'];
                    $datosPresentar['TrimestresTotal']['1T']=formateaNumeroContabilidad($valor['RetencionesA']+$valor['RetencionesG']);
                    $datosPresentar['TrimestresTotal']['Total']=$datosPresentar['TrimestresTotal']['Total']+$valor['RetencionesA']+$valor['RetencionesG'];
                } else if ($valor['Trimestre'] == 2) {
                    $datosPresentar['2T']['BaseA']= formateaNumeroContabilidad($valor['BaseA']);
                    $datosPresentar['2T']['RetencionesA']= formateaNumeroContabilidad($valor['RetencionesA']);
                    $datosPresentar['2T']['BaseG']= formateaNumeroContabilidad($valor['BaseG']);
                    $datosPresentar['2T']['RetencionesG']= formateaNumeroContabilidad($valor['RetencionesG']);
                    $datosPresentar['2T']['Esta_Cerrado']=$valor['Esta_Cerrado'];
                    $datosPresentar['TrimestresTotal']['2T']=formateaNumeroContabilidad($valor['RetencionesA']+$valor['RetencionesG']);
                    $datosPresentar['TrimestresTotal']['Total']=$datosPresentar['TrimestresTotal']['Total']+$valor['RetencionesA']+$valor['RetencionesG'];
                } else if ($valor['Trimestre'] == 3) {
                    $datosPresentar['3T']['BaseA']= formateaNumeroContabilidad($valor['BaseA']);
                    $datosPresentar['3T']['RetencionesA']= formateaNumeroContabilidad($valor['RetencionesA']);
                    $datosPresentar['3T']['BaseG']= formateaNumeroContabilidad($valor['BaseG']);
                    $datosPresentar['3T']['RetencionesG']= formateaNumeroContabilidad($valor['RetencionesG']);
                    $datosPresentar['3T']['Esta_Cerrado']=$valor['Esta_Cerrado'];
                    $datosPresentar['TrimestresTotal']['3T']=formateaNumeroContabilidad($valor['RetencionesA']+$valor['RetencionesG']);
                    $datosPresentar['TrimestresTotal']['Total']=$datosPresentar['TrimestresTotal']['Total']+$valor['RetencionesA']+$valor['RetencionesG'];
                } else if ($valor['Trimestre'] == 4) {
                    $datosPresentar['4T']['BaseA']= formateaNumeroContabilidad($valor['BaseA']);
                    $datosPresentar['4T']['RetencionesA']= formateaNumeroContabilidad($valor['RetencionesA']);
                    $datosPresentar['4T']['BaseG']= formateaNumeroContabilidad($valor['BaseG']);
                    $datosPresentar['4T']['RetencionesG']= formateaNumeroContabilidad($valor['RetencionesG']);
                    $datosPresentar['4T']['Esta_Cerrado']=$valor['Esta_Cerrado'];
                    $datosPresentar['TrimestresTotal']['4T']=formateaNumeroContabilidad($valor['RetencionesA']+$valor['RetencionesG']);
                    $datosPresentar['TrimestresTotal']['Total']=$datosPresentar['TrimestresTotal']['Total']+$valor['RetencionesA']+$valor['RetencionesG'];
                }
            }
        }
        $datosPresentar['Total']['BaseA']=  formateaNumeroContabilidad($datosPresentar['Total']['BaseA']);
        $datosPresentar['Total']['RetencionesA']=  formateaNumeroContabilidad($datosPresentar['Total']['RetencionesA']);
        $datosPresentar['Total']['BaseG']=  formateaNumeroContabilidad($datosPresentar['Total']['BaseG']);
        $datosPresentar['Total']['RetencionesG']=  formateaNumeroContabilidad($datosPresentar['Total']['RetencionesG']);
        $datosPresentar['TrimestresTotal']['Total']=formateaNumeroContabilidad($datosPresentar['TrimestresTotal']['Total']);
        
        
        
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                ' clsCNContabilidad->calculoDatosIRPF()()<TERMINA y DEVUELVE $datosPresentar');
        return $datosPresentar;
    }

    //HABRA QUE BORRAR (COMFIRMAR)
    function calculoDatosIRPF_A($lngEjercicio,$Periodo){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->calculoDatosIRPF_A($lngEjercicio,$Periodo)>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->calculoDatosIRPF_A($lngEjercicio,$Periodo);
    }
    
    
    //HABRA QUE BORRAR (COMFIRMAR)
    private function calculaDatosAbierto($periodoMin, $periodoMax, $datos,$lngEjercicio) {
        //calculo el IVA Repercutido y Soportado segun el ejercicio y periodos min y max
        $IVA_RepercutidoDEBE = 0; //4770
        $IVA_RepercutidoHABER = 0; //4770
        $IVA_SoportadoDEBE = 0; //4720
        $IVA_SoportadoHABER = 0; //4720
        //recorro los datos
        for ($i = 1; $i <= count($datos); $i++) {
            //compruebo si son del ejercicio + periodoMin y peridoMax
            //si lo son sumo los IVA's
            if ($datos[$i]['Periodo'] >= $periodoMin && $datos[$i]['Periodo'] <= $periodoMax && $datos[$i]['Ejercicio']==$lngEjercicio) {
                if ($datos[$i]['SubGrupo4'] == '4770') {
                    $IVA_RepercutidoDEBE = $IVA_RepercutidoDEBE + $datos[$i]['Debe'];
                    $IVA_RepercutidoHABER = $IVA_RepercutidoHABER + $datos[$i]['Haber'];
                }
                if ($datos[$i]['SubGrupo4'] == '4720') {
                    $IVA_SoportadoDEBE = $IVA_SoportadoDEBE + $datos[$i]['Debe'];
                    $IVA_SoportadoHABER = $IVA_SoportadoHABER + $datos[$i]['Haber'];
                }
            }
        }
        return array("IVA_RepercutidoDEBE" => $IVA_RepercutidoDEBE,
            "IVA_RepercutidoHABER" => $IVA_RepercutidoHABER,
            "IVA_SoportadoDEBE" => $IVA_SoportadoDEBE,
            "IVA_SoportadoHABER" => $IVA_SoportadoHABER
        );
    }

    private function calculaDatosTrimestre($valor,&$datosPresentar,$trimestre){
        if ($valor['A_Compensar'] < 0) {
            //hay camtidad superior a 0, significa que es a compensar, se presenta de color rojo
            $resultadoTxt = '<font color="#FF0000">' . formateaNumeroContabilidad($valor['A_Compensar']) . '<br/>A Compensar</font>';
        } else {
            //0 o positivo, se presenta de color normal
            //comprobamos si esta cerrado o no
            //si esta cerrado cojemos el dato directamente $valor['A_Compensar']
            //sino debemos calcularlo
            if($valor['Esta_Cerrado']=='NO'){
                $resultadoTxt = formateaNumeroContabilidad($valor['A_Compensar']) . '<br/>Ingresar';
            }else{
                $resultadoTxt = formateaNumeroContabilidad($valor['IVA_Repercutido']-$valor['IVA_Soportado']+$valor['Saldo_Anterior']) . '<br/>Ingresar';
            }
        }
        $datosPresentar[$trimestre]['Saldo_Anterior'] = formateaNumeroContabilidad(abs($valor['Saldo_Anterior']));
        $datosPresentar[$trimestre]['IVA_Repercutido'] = formateaNumeroContabilidad($valor['IVA_Repercutido']);
        $datosPresentar[$trimestre]['IVA_Soportado'] = formateaNumeroContabilidad($valor['IVA_Soportado']);
        $datosPresentar[$trimestre]['Resultado'] = $resultadoTxt;
        $datosPresentar[$trimestre]['Esta_Cerrado'] = $valor['Esta_Cerrado'];
        //sumo en los totales
        //compruebo que no se incluya en la suma el T0 (es el ultimo trimestre del año anterior)
        if($trimestre<>'0T'){
            $datosPresentar['Total']['IVA_Repercutido'] = $datosPresentar['Total']['IVA_Repercutido'] + $valor['IVA_Repercutido'];
            $datosPresentar['Total']['IVA_Soportado'] = $datosPresentar['Total']['IVA_Soportado'] + $valor['IVA_Soportado'];
        }
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->calculaDatosTrimestre()<TERMINA");
    }
    
    function guardarTrimestre($ejercicio,$trimestre,$IVA_Rep,$IVA_Sop,$Saldo_Anterior){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->guardarTrimestre($ejercicio,$trimestre,$IVA_Rep,$IVA_Sop,$Saldo_Anterior)>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        //veo el dato del trimestre y los paso en numero (1,2,3 o 4)
        if($trimestre==='1T'){
            $trimestreNum=1;
        }else if($trimestre==='2T'){
            $trimestreNum=2;
        }else if($trimestre==='3T'){
            $trimestreNum=3;
        }else if($trimestre==='4T'){
            $trimestreNum=4;
        }
        
        //ahora pasamos los valores de IVAs y Saldo a numerico normal (con punto para decimales)
        $IVA_Rep=desFormateaNumeroContabilidad($IVA_Rep);
        $IVA_Sop=desFormateaNumeroContabilidad($IVA_Sop);
        $Saldo_Anterior=desFormateaNumeroContabilidad($Saldo_Anterior);

        return $clsCADContabilidad->guardarTrimestre($ejercicio,$trimestreNum,$IVA_Rep,$IVA_Sop,$Saldo_Anterior);
    }
   
    function guardarTrimestreIRPF($ejercicio,$trimestre,$baseA,$retA,$baseG,$retG){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->guardarTrimestreIRPF($ejercicio,$trimestre,$baseA,$retA,$baseG,$retG)>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        //veo el dato del trimestre y los paso en numero (1,2,3 o 4)
        if($trimestre==='1T'){
            $trimestreNum=1;
        }else if($trimestre==='2T'){
            $trimestreNum=2;
        }else if($trimestre==='3T'){
            $trimestreNum=3;
        }else if($trimestre==='4T'){
            $trimestreNum=4;
        }
        
        //ahora pasamos los valores de IVAs y Saldo a numerico normal (con punto para decimales)
        $baseA=desFormateaNumeroContabilidad($baseA);
        $retA=desFormateaNumeroContabilidad($retA);
        $baseG=desFormateaNumeroContabilidad($baseG);
        $retG=desFormateaNumeroContabilidad($retG);

        return $clsCADContabilidad->guardarTrimestreIRPF($ejercicio,$trimestreNum,$baseA,$retA,$baseG,$retG);
    }
   
    function trimestreEnFecha($trimestre,$ejercicio){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->trimestreEnFecha($trimestre,$ejercicio)>");
        
        //indico los rango s a mirar
        if($trimestre=='1T'){
            $inicio=$ejercicio.'-01-01';
            $fin=$ejercicio.'-03-31';
        }else if($trimestre=='2T'){
            $inicio=$ejercicio.'-04-01';
            $fin=$ejercicio.'-06-30';
        }else if($trimestre=='3T'){
            $inicio=$ejercicio.'-07-01';
            $fin=$ejercicio.'-09-30';
        }else if($trimestre=='4T'){
            $inicio=$ejercicio.'-10-01';
            $fin=$ejercicio.'-12-31';
        }
        
        date_default_timezone_set('Europe/Madrid');
        $diaDeHoy=date('Y-m-d');
        
        //los datos a devolver son:
        //ACTUAL- Está dentro del trimestre
        //ANTERIOR- O es superior al trimestre (trimestres anteriores sin cerrar)
        //POSTERIOR- O es un trimestre superior
        $resultado='';
        if(($inicio<=$diaDeHoy) && ($fin>=$diaDeHoy)){
            $resultado='ACTUAL'; //trimestre actual
        }
        if($fin<=$diaDeHoy){
            $resultado='ANTERIOR';//trimestre anterior
        }
        if($inicio>=$diaDeHoy){
            $resultado='POSTERIOR';//trimestre superior
        }
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->trimestreEnFecha() : ".$resultado);
        return $resultado;
    }
    
    function AltaEmpleado($post,$usuario)
    {
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->AltaEmpleado()>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->AltaEmpleado($post,$usuario);
    }
    
    function EditarEmpleado($post,$usuario)
    {
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->EditarEmpleado()>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->EditarEmpleado($post,$usuario);
    }
    
    function ListadoEmpleados($get)
    {
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->ListadoEmpleados()>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->ListadoEmpleados($get);
    }        
    
    function ListadoIncidenciasEmpleado($IdEmpleado)
    {
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->ListadoIncidenciasEmpleado()>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->ListadoIncidenciasEmpleado($IdEmpleado);
    }        
    
    function datosEmpleado($IdEmpleado){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->datosEmpleado($IdEmpleado)>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->datosEmpleado($IdEmpleado);
    }
    
    function empleadoBorrar($id){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->empleadoBorrar($id)>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->empleadoBorrar($id);
    }
    
    function ImpuestoIVA303($lngEjercicio,$cmdCierre){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->ImpuestoIVA303($lngEjercicio,$cmdCierre)>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->ImpuestoIVA303($lngEjercicio,$cmdCierre);
    }

    //ESTA ES LA NUEVA
    function generarFicheroIVA303($resultado,$lngEjercicio,$trimestre,$datosBancarios,$TransmitoImp){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->generarFicheroIVA303()>");

        $Periodo=$trimestre;

        $nombre=$_SESSION['idEmp'].'-303-'.$lngEjercicio.'-'.$Periodo.'.303';
        $dirNombre='../impuestos/'.$nombre;
        $ddf = fopen($dirNombre,'w');
        
        require_once '../CN/clsCNConsultas.php';
        //extraigo datos de la empresa
        $clsCNConsultas=new clsCNConsultas();
        $clsCNConsultas->setStrBD($_SESSION['dbContabilidad']);
        $datosEmpresa=$clsCNConsultas->datosEmpresa($_SESSION['idEmp']);
        
        
        //generar el texto del fichero
        //este fichero consta de 4 partes DP30300, DP30301, DP30302 y DP30303
        //DP30300
        $texto="<T3030".$lngEjercicio.$trimestre."0000><AUX>";

        //<AUX> </AUX>
        //Posicion 23 a 323
        $blancos='';
        while(strlen($blancos)<300){
            $blancos=' '.$blancos;
        }
        $texto=$texto.$blancos;
        $texto=$texto."</AUX>";
        //DP30300 - Fin

        //DP30301
        $texto=$texto."<T30301>";
        
        //Posicion 9-Tipo de Declaración (1)
        //C = Solicitud de compensación, D = Devolucion, G = Cuenta corriente Tributaria-ingreso, I = Ingreso,
        //N = Sin actividad/resultado cero, V = cuenta corriente tributaria-devolucion, U = domiciliacion del ingreso en CCC
        if($resultado['71']>0){
            $texto=$texto.'I';
        }else if($resultado['48']==0){
            $texto=$texto.'N';
        }else if($resultado['48']<0){
            $texto=$texto.'D';
        }
        
        //Posicion 10-Identificacion NIF (9)
        //controlo para que el texto tenga espacios en blanco si no tiene el tamaño requerido
        $NIF=$datosEmpresa['strCIF'];
        while(strlen($NIF)<9){
            $NIF=$NIF.' ';
        }
        $texto=$texto.$NIF;

        //Posicion 19-Identificacion Apellidos o Razon Social (30)
        //controlo para que el texto tenga espacios en blanco si no tiene el tamaño requerido
        $nomEmpresa=$datosEmpresa['strSesion'];
        while(strlen($nomEmpresa)<30){
            $nomEmpresa=$nomEmpresa.' ';
        }
        //si el tamaño es superior lo recorto
        if(strlen($nomEmpresa)>30){
            $nomEmpresa=substr($nomEmpresa,0,30);
        }
        $texto=$texto.$nomEmpresa;

        //Posicion 49-Identificacion Nombre (15)
        //Este campo no le estamos guardando por el momento
        //se incluyen directamente 15 espacios en blanco
        $nombre='';
        while(strlen($nombre)<15){
            $nombre=$nombre.' ';
        }
        $texto=$texto.$nombre;

        //Posicion 64-inscrito en el registro de devolucion mensual (1)
        //Este campo siempre asignamos 2
        $texto=$texto.'2';

        //Posicion 65-Tributa exclusivamente en Regimen Simplificado (1)
        $texto=$texto.'2';

        //Posicion 66-Autoliquidacion conjunta (1)
        $texto=$texto.'2';
        
        //Posicion 67-Declarado en concurso.. (1)
        $texto=$texto.'2';

        //Posicion 68-Fecha en el que se dicto.. (8) blanco
        $texto=$texto.'        ';
        
        //Posicion 76-Auto de declaracion.. (1)
        $texto=$texto.' ';
        
        //Posicion 77-Opcion por el regimen especial.. (1)
        $texto=$texto.'2';
        
        //Posicion 78-Destinatario e las operaciones.. (1)
        $texto=$texto.'2';
        
        //Posicion 79-Opcion por la aplicacion de la.. (1)
        $texto=$texto.'2';
        
        //Posicion 80-Revocacion de la opcion por.. (1)
        $texto=$texto.'2';
        
        //Posicion 81-Devengo - Ejercicio (4)       
        $texto=$texto.$resultado['Ejercicio'];
        
        //Posicion 85-Devengo - Periodo (2)       
        $texto=$texto.$resultado['Trimestre'];

        //Posicion 87-Liquidacion - IVA Devengado [01] (17= 15 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $numero01=desFormateaNumeroContabilidad($resultado['01']);
        $numero01=$numero01*100;
        //ahora añado ceros a la izda sino llega al tamaño requerido
        while(strlen($numero01)<17){
            $numero01='0'.$numero01;
        }
        $texto=$texto.$numero01;
        
        //Posicion 104-Liquidacion - IVA Devengado [02] (5= 3 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $numero02=desFormateaNumeroContabilidad($resultado['02']);
        $numero02=$numero02*100;
        //ahora añado ceros a la izda sino llega al tamaño requerido
        while(strlen($numero02)<5){
            $numero02='0'.$numero02;
        }
        $texto=$texto.$numero02;
        
        //Posicion 109-Liquidacion - IVA Devengado [03] (17= 15 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $numero03=desFormateaNumeroContabilidad($resultado['03']);
        $numero03=$numero03*100;
        //ahora añado ceros a la izda sino llega al tamaño requerido
        while(strlen($numero03)<17){
            $numero03='0'.$numero03;
        }
        $texto=$texto.$numero03;
        
        //Posicion 126-Liquidacion - IVA Devengado [04] (17= 15 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $numero04=desFormateaNumeroContabilidad($resultado['04']);
        $numero04=$numero04*100;
        //ahora añado ceros a la izda sino llega al tamaño requerido
        while(strlen($numero04)<17){
            $numero04='0'.$numero04;
        }
        $texto=$texto.$numero04;
        
        //Posicion 143-Liquidacion - IVA Devengado [05] (5= 3 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $numero05=desFormateaNumeroContabilidad($resultado['05']);
        $numero05=$numero05*100;
        //ahora añado ceros a la izda sino llega al tamaño requerido
        while(strlen($numero05)<5){
            $numero05='0'.$numero05;
        }
        $texto=$texto.$numero05;
        
        //Posicion 148-Liquidacion - IVA Devengado [06] (17= 15 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $numero06=desFormateaNumeroContabilidad($resultado['06']);
        $numero06=$numero06*100;
        //ahora añado ceros a la izda sino llega al tamaño requerido
        while(strlen($numero06)<17){
            $numero06='0'.$numero06;
        }
        $texto=$texto.$numero06;
        
        //Posicion 165-Liquidacion - IVA Devengado [07] (17= 15 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $numero07=desFormateaNumeroContabilidad($resultado['07']);
        $numero07=$numero07*100;
        //ahora añado ceros a la izda sino llega al tamaño requerido
        while(strlen($numero07)<17){
            $numero07='0'.$numero07;
        }
        $texto=$texto.$numero07;
        
        //Posicion 182-Liquidacion - IVA Devengado [08] (5= 3 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $numero08=desFormateaNumeroContabilidad($resultado['08']);
        $numero08=$numero08*100;
        //ahora añado ceros a la izda sino llega al tamaño requerido
        while(strlen($numero08)<5){
            $numero08='0'.$numero08;
        }
        $texto=$texto.$numero08;
        
        //Posicion 187-Liquidacion - IVA Devengado [09] (17= 15 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $numero09=desFormateaNumeroContabilidad($resultado['09']);
        $numero09=$numero09*100;
        //ahora añado ceros a la izda sino llega al tamaño requerido
        while(strlen($numero09)<17){
            $numero09='0'.$numero09;
        }
        $texto=$texto.$numero09;
        
        //Posicion 204-Adquisiciones intracomunitarias.. [10] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 221-Adquisiciones intracomunitarias.. [11] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 238-Otras operaciones con inversion.. [12] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 255-Otras operaciones con inversion.. [13] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 272-Modificacion bases y cuotas.. [14] (17= 3 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 289-Modificacion bases y cuotas.. [15] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;

        //Posicion 306-Recargo equivalencia.. [16] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 323-Recargo equivalencia.. [17] (5= 3 enteros y 2 decimales)
        //se incluyen directamente 5 ceros
        $ceros='';
        while(strlen($ceros)<5){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 328-Recargo equivalencia.. [18] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;

        //Posicion 345-Recargo equivalencia.. [19] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;

        //Posicion 362-Recargo equivalencia.. [20] (5= 3 enteros y 2 decimales)
        //se incluyen directamente 5 ceros
        $ceros='';
        while(strlen($ceros)<5){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 367-Recargo equivalencia.. [21] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 384-Recargo equivalencia.. [22] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 401-Recargo equivalencia.. [23] (5= 3 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<5){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 406-Recargo equivalencia.. [24] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 423-Modificacion Bases y cuotas.. [25] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 440-Modificacion Bases y cuotas.. [26] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 457-Total cuota devengada [27] (17= 15 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $numero27=desFormateaNumeroContabilidad($resultado['27']);
        $numero27=$numero27*100;
        //si el numero es negativo se indica una N delante
        if($numero27>=0){
            //ahora añado ceros a la izda sino llega al tamaño requerido
            while(strlen($numero27)<17){
                $numero27='0'.$numero27;
            }
        }else{//menor de cero
            //se quita primero el signo (cambio de signo)
            $numero27=-$numero27;
            //ahora añado ceros a la izda sino llega al tamaño requerido menos un lugar
            while(strlen($numero27)<16){
                $numero27='0'.$numero27;
            }
            //en ese lugar se indica 'N'
            $numero27='N'.$numero27;
        }
        $texto=$texto.$numero27;

        //Posicion 474-Por cuotas soportadas en operaciones.. [28] (17= 15 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $numero28=desFormateaNumeroContabilidad($resultado['28']);
        $numero28=$numero28*100;
        while(strlen($numero28)<17){
            $numero28='0'.$numero28;
        }
        $texto=$texto.$numero28;
        
        //Posicion 491-Por cuotas soportadas en operaciones.. [29] (17= 15 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $numero29=desFormateaNumeroContabilidad($resultado['29']);
        $numero29=$numero29*100;
        while(strlen($numero29)<17){
            $numero29='0'.$numero29;
        }
        $texto=$texto.$numero29;
        
        //Posicion 508-Por cuotas soportadas en operaciones.. [30] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 525-Por cuotas soportadas en operaciones.. [31] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 542-Por cuotas soportadas en operaciones.. [32] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 559-Por cuotas soportadas en operaciones.. [33] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 576-Por cuotas soportadas en operaciones.. [34] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 593-Por cuotas soportadas en operaciones.. [35] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 610-En adquisiciones intracomunitarias.. [36] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 627-En adquisiciones intracomunitarias.. [37] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 644-En adquisiciones intracomunitarias.. [38] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 661-En adquisiciones intracomunitarias.. [39] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 678-Rectificacion de deducciones.. [40] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 695-Rectificacion de deducciones.. [41] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 712-Compensaciones de regimen especial.. [42] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 729-Regularizacion inversiones.. [43] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 746-Regularizacion por aplicacion.. [44] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 763-Total a deducir.. [45] (17= 15 enteros y 2 decimales)
        //copia numero29
        $texto=$texto.$numero29;
        
        //Posicion 780-Resultado regimen general [46] (17= 15 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $numero46=desFormateaNumeroContabilidad($resultado['46']);
        $numero46=$numero46*100;
        //si el numero es negativo se indica una N delante
        if($numero46>=0){
            //ahora añado ceros a la izda sino llega al tamaño requerido
            while(strlen($numero46)<17){
                $numero46='0'.$numero46;
            }
        }else{//menor de cero
            //se quita primero el signo (cambio de signo)
            $numero46=-$numero46;
            //ahora añado ceros a la izda sino llega al tamaño requerido menos un lugar
            while(strlen($numero46)<16){
                $numero46='0'.$numero46;
            }
            //en ese lugar se indica 'N'
            $numero46='N'.$numero46;
        }
        $texto=$texto.$numero46;
        
        //Posiciones 797 a 1379-Resto de campo no incluimos nada (582)
        //indicamos 582 blancos
        $blancos='';
        while(strlen($blancos)<582){
            $blancos=' '.$blancos;
        }
        $texto=$texto.$blancos;
        
        //Posiciones 1379 a 1392-Resto de campo no incluimos nada (13)
        //indicamos 13 blancos
        $blancos='';
        while(strlen($blancos)<13){
            $blancos=' '.$blancos;
        }
        $texto=$texto.$blancos;
        
        $texto=$texto."</T30301>";
        //DP30301 - Fin

        //DP30302
        //Posiciones 1 a 8
        $texto=$texto."<T30302>";
        
        //Posicion 9-Indicador de pagina complementaria: Blanco (NO) o C (SI)
        $texto=$texto." ";

        //Posiciones 10 a 108- (98 ceros)
        //se incluyen directamente 98 ceros
        $ceros='';
        while(strlen($ceros)<98){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posiciones 109 a 112 (4 en blanco)
        //indicamos 4 blancos
        $blancos='';
        while(strlen($blancos)<4){
            $blancos=' '.$blancos;
        }
        $texto=$texto.$blancos;
        
        //Posiciones 113 a 458- (346 ceros)
        //se incluyen directamente 346 ceros
        $ceros='';
        while(strlen($ceros)<346){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posiciones 459 a 462 (4 en blanco)
        //indicamos 4 blancos
        $blancos='';
        while(strlen($blancos)<4){
            $blancos=' '.$blancos;
        }
        $texto=$texto.$blancos;
        
        //Posiciones 463 a 1692- (1230 ceros)
        //se incluyen directamente 1230 ceros
        $ceros='';
        while(strlen($ceros)<1230){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;

        $texto=$texto."</T30302>";
        //DP30302 - Fin
        
        
        //DP30303
        //Posiciones 1,3,6 y 8
        $texto=$texto.="<T30303>";
        //Posicion 9-Informacion adicional - Entregas intracomunitarias [59]:
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 26-Informacion adicional - Exportaciones  op. asimiladas [60]:
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 43-Informacion adicional - Operaciones no sujetas... [61]:
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 60-Resultado: Suma de Resultados [46] (17= 15 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $numero46=desFormateaNumeroContabilidad($resultado['46']);
        $numero46=$numero46*100;
        //si el numero es negativo se indica una N delante
        if($numero46>=0){
            //ahora añado ceros a la izda sino llega al tamaño requerido
            while(strlen($numero46)<17){
                $numero46='0'.$numero46;
            }
        }else{//menor de cero
            //se quita primero el signo
            $numero46=-$numero46;
            //ahora añado ceros a la izda sino llega al tamaño requerido menos un lugar
            while(strlen($numero46)<16){
                $numero46='0'.$numero46;
            }
            //en ese lugar se indica 'N'
            $numero46='N'.$numero46;
        }
        $texto=$texto.$numero46;

        //Posicion 77-% Atribuible a la administración del estado [65] (5= 3 enteros y 2 decimales)
        //indicamos 100 % (10000)
        $texto=$texto.'10000';
        
        //Posicion 82-Resultado - Atribuible a la administración del estado [66] (17= 15 enteros y 2 decimales)
        //copio $numero46
        $texto=$texto.$numero46;
        
        //Posicion 99-Cuotas a compensar de periodos anteriores [67] (17= 15 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $numero67=desFormateaNumeroContabilidad($resultado['67']);
        $numero67=$numero67*100;
        while(strlen($numero67)<17){
            $numero67='0'.$numero67;
        }
        $texto=$texto.$numero67;
        
        //Posicion 116-Resultado: Excusivamente para sujetos pasivos que tributan... [68]:
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 133-Resultado: Resultado [66]+[77]-[67]+-[68] = [69]:
        //[66]-[67] -> [46]
        $numero69=desFormateaNumeroContabilidad($resultado['46']);
        $numero69=$numero69*100;
        while(strlen($numero69)<17){
            $numero69='0'.$numero69;
        }
        $texto=$texto.$numero69;

        //Posicion 150-A deducir [70] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 167-Resultado de la liquidación [71] (17= 15 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $numero71=desFormateaNumeroContabilidad($resultado['71']);
        $numero71=$numero71*100;
        //si el numero es negativo se indica una N delante
        if($numero71>=0){
            //ahora añado ceros a la izda sino llega al tamaño requerido
            while(strlen($numero71)<17){
                $numero71='0'.$numero71;
            }
        }else{//menor de cero
            //se quita primero el signo (cambio de signo)
            $numero71=-$numero71;
            //ahora añado ceros a la izda sino llega al tamaño requerido menos un lugar
            while(strlen($numero71)<16){
                $numero71='0'.$numero71;
            }
            //en ese lugar se indica 'N'
            $numero71='N'.$numero71;
        }
        $texto=$texto.$numero71;
        
        //Posicion 184-Informacion Adicional - Eclusivamente.. [62] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 201-Informacion Adicional - Eclusivamente.. [63] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 218-Informacion Adicional - Eclusivamente.. [74] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 235-Informacion Adicional - Exclusivamente.. [75] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 252-Declaracion complementaria (1= en blanco)
        $texto=$texto.' ';
        
        //Posicion 253-Declaracion complementaria (13= en blanco)
        $blanco='';
        while(strlen($blanco)<13){
            $blanco=$blanco.' ';
        }
        $texto=$texto.$blanco;

        //Posicion 266-Marca sin actividad (' '=NO, 'X'=SI)
        //busco la vble 'SinActividad', si es NO (que tiene actividad=0) si es SI (no tiene actividad=1)
        if($datosBancarios['SinActividad']==='NO'){
            $actividad=' ';
        }else{
            $actividad='X';
        }
        $texto=$texto.$actividad;
        
        //Posicion 267-Devolucion importe [72] (34= 24 cuenta IBAN y 10 blancos)
        //busco la vble 'SeDomicilia' si se domicilia se indica la cuenta, sino se deja en blanco
        if($datosBancarios['SeDomicilia']==='SI'){
            //Codigo cuenta cliente - IBAN (4)
            $iban=$datosBancarios['cuentaBanco_IBAN'];
            while(strlen($iban)<4){
                $iban='0'.$iban;
            }
            $texto=$texto.$iban;
            
            //Codigo cuenta cliente - Entidad (4)
            $entidad=$datosBancarios['cuentaBanco_Entidad'];
            while(strlen($entidad)<4){
                $entidad='0'.$entidad;
            }
            $texto=$texto.$entidad;

            //Codigo cuenta cliente - Oficina (4)
            $oficina=$datosBancarios['cuentaBanco_Oficina'];
            while(strlen($oficina)<4){
                $oficina='0'.$oficina;
            }
            $texto=$texto.$oficina;

            //Codigo cuenta cliente - DC (2)
            $DC=$datosBancarios['cuentaBanco_DC'];
            while(strlen($DC)<2){
                $DC='0'.$DC;
            }
            $texto=$texto.$DC;

            //Codigo cuenta cliente - Número de Cuenta (10)
            $NCuenta=$datosBancarios['cuentaBanco_NCuenta'];
            while(strlen($NCuenta)<10){
                $NCuenta='0'.$NCuenta;
            }
            $texto=$texto.$NCuenta;
            
            //Codigo cuenta cliente - Número en blanco (10)
            $blancos='';
            while(strlen($blancos)<10){
                $blancos=' '.$blancos;
            }
            $texto=$texto.$blancos;
        }else{
            //Codigo cuenta cliente - En blanco (34 caracteres)
            //indicamos 34 ceros
            $blancos='';
            while(strlen($blancos)<34){
                $blancos=' '.$blancos;
            }
            $texto=$texto.$blancos;
        }

        //Posicion 301,302,306,307,311,312,316,317,321,322,326,327 y 331
        //Información adicional..Declaracion-resumen anual de IVA...
        //indicamos este texto de 31 caracteres = "0    0    0    0    0    0     "
        
        $texto = $texto . "0    0    0    0    0    0     ";
        
        //Posicion 332-Informacion Adicional - Exclusivamente.. [80] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 349-Informacion Adicional - Exclusivamente.. [81] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 366-Informacion Adicional - Exclusivamente.. [82] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 383-Informacion Adicional - Exclusivamente.. [83] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 400-Informacion Adicional - Exclusivamente.. [84] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 417-Informacion Adicional - Exclusivamente.. [85] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 434-Informacion Adicional - Exclusivamente.. [86] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 451-Informacion Adicional - Exclusivamente.. [87] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 468-Resumen anual de IVA a la importación.. [88] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 485-Resultado - Regularización cuotas.. [76] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 502-Resultado - IVA a la importación.. [77] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posiciones 519 a 1092-Resto de campo no incluimos nada (573)
        //indicamos 433 blancos
        $blancos='';
        while(strlen($blancos)<573){
            $blancos=' '.$blancos;
        }
        $texto=$texto.$blancos;

        //por ultimo cerramos la etiqueta
        $texto=$texto."</T30303>";
        //DP30302 - Fin


        //cierro
        $texto="</T3030".$lngEjercicio.$trimestre."0000>";
        
        
        //por ultimo escribo el fichero y cierro
        fwrite($ddf,$texto);
        fclose($ddf);
        
        $datos='';
        //por ultimo compruebo si esta activada la casilla de grabar en el ordenador del cliente el fichero del impuesto
        if($TransmitoImp==='SI'){
            //datos a devolver
            $datos=array(
                "url"=>$dirNombre,
            );
        }
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->generarFicheroIVA303()<Devuelve datos: ".$datos['url']);
        return $datos;
    }
    
    //GENERA FICHERO ANTIGUO
    function generarFicheroIVA303Antiguo($resultado,$lngEjercicio,$trimestre,$datosBancarios,$TransmitoImp){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->generarFicheroIVA303()>");

        $Periodo=$trimestre;

        $nombre=$_SESSION['idEmp'].'-303-'.$lngEjercicio.'-'.$Periodo.'.303';
        $dirNombre='../impuestos/'.$nombre;
        $ddf = fopen($dirNombre,'w');
        
        require_once '../CN/clsCNConsultas.php';
        //extraigo datos de la empresa
        $clsCNConsultas=new clsCNConsultas();
        $clsCNConsultas->setStrBD($_SESSION['dbContabilidad']);
        $datosEmpresa=$clsCNConsultas->datosEmpresa($_SESSION['idEmp']);
        
        //generar el texto del fichero
        //Posiciones 1,3,6, 8 y 9
        $texto="<T30301> ";
        //Posicion 10-PI Tipo de declaracion:
        //C = Solicitud de compensación, D = Devolucion, G = Cuenta corriente Tributaria-ingreso, I = Ingreso,
        //N = Sn actividad/resultado cero, V = cuenta corriente tributaria-devolucion, U = domiciliacion del ingreso en CCC
        if($resultado['48']>0){
            $texto=$texto.'I';
        }else if($resultado['48']==0){
            $texto=$texto.'N';
        }else if($resultado['48']<0){
            $texto=$texto.'D';
        }
        //Posicion 11-Identificacion NIF (9)
        //controlo para que el texto tenga espacios en blanco si no tiene el tamaño requerido
        $NIF=$datosEmpresa['strCIF'];
        while(strlen($NIF)<9){
            $NIF=$NIF.' ';
        }
        $texto=$texto.$NIF;

        //Posicion 20-Identificacion Apellidos o Razon Social (30)
        //controlo para que el texto tenga espacios en blanco si no tiene el tamaño requerido
        $nomEmpresa=$datosEmpresa['strSesion'];
        while(strlen($nomEmpresa)<30){
            $nomEmpresa=$nomEmpresa.' ';
        }
        //si el tamaño es superior lo recorto
        if(strlen($nomEmpresa)>30){
            $nomEmpresa=substr($nomEmpresa,0,30);
        }
        $texto=$texto.$nomEmpresa;

        //Posicion 50-Identificacion Nombre (15)
        //Este campo no le estamos guardando por el momento
        //se incluyen directamente 15 espacios en blanco
        $nombre='';
        while(strlen($nombre)<15){
            $nombre=$nombre.' ';
        }
        $texto=$texto.$nombre;

        //Posicion 65-inscrito en el registro de devolucion mensual (1)
        //Este campo siempre asignamos 2
        $texto=$texto.'2';

        //Posicion 66-Devengo - Ejercicio (4)       
        $texto=$texto.$resultado['Ejercicio'];
        
        //Posicion 70-Devengo - Periodo (2)       
        $texto=$texto.$resultado['Trimestre'];
        
        //Posicion 72-Liquidacion - IVA Devengado [01] (17= 15 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $numero01=desFormateaNumeroContabilidad($resultado['01']);
        $numero01=$numero01*100;
        //ahora añado ceros a la izda sino llega al tamaño requerido
        while(strlen($numero01)<17){
            $numero01='0'.$numero01;
        }
        $texto=$texto.$numero01;
        
        //Posicion 89-Liquidacion - IVA Devengado [02] (5= 3 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $numero02=desFormateaNumeroContabilidad($resultado['02']);
        $numero02=$numero02*100;
        //ahora añado ceros a la izda sino llega al tamaño requerido
        while(strlen($numero02)<5){
            $numero02='0'.$numero02;
        }
        $texto=$texto.$numero02;
        
        //Posicion 94-Liquidacion - IVA Devengado [03] (17= 15 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $numero03=desFormateaNumeroContabilidad($resultado['03']);
        $numero03=$numero03*100;
        //ahora añado ceros a la izda sino llega al tamaño requerido
        while(strlen($numero03)<17){
            $numero03='0'.$numero03;
        }
        $texto=$texto.$numero03;
        
        //Posicion 111-Liquidacion - IVA Devengado [04] (17= 15 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $numero04=desFormateaNumeroContabilidad($resultado['04']);
        $numero04=$numero04*100;
        //ahora añado ceros a la izda sino llega al tamaño requerido
        while(strlen($numero04)<17){
            $numero04='0'.$numero04;
        }
        $texto=$texto.$numero04;
        
        //Posicion 128-Liquidacion - IVA Devengado [05] (5= 3 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $numero05=desFormateaNumeroContabilidad($resultado['05']);
        $numero05=$numero05*100;
        //ahora añado ceros a la izda sino llega al tamaño requerido
        while(strlen($numero05)<5){
            $numero05='0'.$numero05;
        }
        $texto=$texto.$numero05;
        
        //Posicion 133-Liquidacion - IVA Devengado [06] (17= 15 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $numero06=desFormateaNumeroContabilidad($resultado['06']);
        $numero06=$numero06*100;
        //ahora añado ceros a la izda sino llega al tamaño requerido
        while(strlen($numero06)<17){
            $numero06='0'.$numero06;
        }
        $texto=$texto.$numero06;
        
        //Posicion 150-Liquidacion - IVA Devengado [07] (17= 15 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $numero07=desFormateaNumeroContabilidad($resultado['07']);
        $numero07=$numero07*100;
        //ahora añado ceros a la izda sino llega al tamaño requerido
        while(strlen($numero07)<17){
            $numero07='0'.$numero07;
        }
        $texto=$texto.$numero07;
        
        //Posicion 167-Liquidacion - IVA Devengado [08] (5= 3 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $numero08=desFormateaNumeroContabilidad($resultado['08']);
        $numero08=$numero08*100;
        //ahora añado ceros a la izda sino llega al tamaño requerido
        while(strlen($numero08)<5){
            $numero08='0'.$numero08;
        }
        $texto=$texto.$numero08;
        
        //Posicion 172-Liquidacion - IVA Devengado [09] (17= 15 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $numero09=desFormateaNumeroContabilidad($resultado['09']);
        $numero09=$numero09*100;
        //ahora añado ceros a la izda sino llega al tamaño requerido
        while(strlen($numero09)<17){
            $numero09='0'.$numero09;
        }
        $texto=$texto.$numero09;
        
        //Posicion 189-Liquidacion - IVA Devengado [10] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 206-Liquidacion - IVA Devengado [11] (5= 3 enteros y 2 decimales)
        //se incluyen directamente 5 ceros
        $ceros='';
        while(strlen($ceros)<5){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 211-Liquidacion - IVA Devengado [12] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 228-Liquidacion - IVA Devengado [13] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 245-Liquidacion - IVA Devengado [14] (5= 3 enteros y 2 decimales)
        //se incluyen directamente 5 ceros
        $ceros='';
        while(strlen($ceros)<5){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 250-Liquidacion - IVA Devengado [15] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;

        //Posicion 267-Liquidacion - IVA Devengado [16] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 284-Liquidacion - IVA Devengado [17] (5= 3 enteros y 2 decimales)
        //se incluyen directamente 5 ceros
        $ceros='';
        while(strlen($ceros)<5){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 289-Liquidacion - IVA Devengado [18] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;

        //Posicion 306-Liquidacion - IVA Devengado [19] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;

        //Posicion 323-Liquidacion - IVA Devengado [20] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;

        //Posicion 340-Liquidacion - IVA Devengado [21] (17= 15 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $numero21=desFormateaNumeroContabilidad($resultado['21']);
        $numero21=$numero21*100;
        //ahora añado ceros a la izda sino llega al tamaño requerido
        while(strlen($numero21)<17){
            $numero21='0'.$numero21;
        }
        $texto=$texto.$numero21;

        //Posicion 357-Liquidacion - IVA Deducible [22] (17= 15 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $numero22=desFormateaNumeroContabilidad($resultado['22']);
        $numero22=$numero22*100;
        //ahora añado ceros a la izda sino llega al tamaño requerido
        while(strlen($numero22)<17){
            $numero22='0'.$numero22;
        }
        $texto=$texto.$numero22;

        //Posicion 374-Liquidacion - IVA Deducible [23] (17= 15 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $numero23=desFormateaNumeroContabilidad($resultado['23']);
        $numero23=$numero23*100;
        //ahora añado ceros a la izda sino llega al tamaño requerido
        while(strlen($numero23)<17){
            $numero23='0'.$numero23;
        }
        $texto=$texto.$numero23;

        //Posicion 391-Liquidacion - IVA Deducible [24] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $numero24='';
        while(strlen($numero24)<17){
            $numero24=$numero24.'0';
        }
        $texto=$texto.$numero24;
        
        //Posicion 408-Liquidacion - IVA Deducible [25] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $numero25='';
        while(strlen($numero25)<17){
            $numero25=$numero25.'0';
        }
        $texto=$texto.$numero25;
        
        //Posicion 425-Liquidacion - IVA Deducible [26] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $numero26='';
        while(strlen($numero26)<17){
            $numero26=$numero26.'0';
        }
        $texto=$texto.$numero26;
        
        //Posicion 442-Liquidacion - IVA Deducible [27] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 459-Liquidacion - IVA Deducible [28] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 476-Liquidacion - IVA Deducible [29] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 493-Liquidacion - IVA Deducible [30] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 510-Liquidacion - IVA Deducible [31] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 527-Liquidacion - IVA Deducible [32] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 544-Liquidacion - IVA Deducible [33] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 561-Liquidacion - IVA Deducible [34] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 578-Liquidacion - IVA Deducible [35] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 595-Liquidacion - IVA Deducible [36] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 612-Liquidacion - IVA Deducible [37] (17= 15 enteros y 2 decimales)
        //por el momento solo incluyo el numero 23
        //en su dia sera la suma de (23+25+27+29+31+33+34+35+36)
        $texto=$texto.$numero23;
        
        //Posicion 629-Liquidacion - Diferencia [38] (17= 15 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $numero38=desFormateaNumeroContabilidad($resultado['38']);
        $numero38=$numero38*100;
        //si el numero es negativo se indica una N delante
        if($numero38>=0){
            //ahora añado ceros a la izda sino llega al tamaño requerido
            while(strlen($numero38)<17){
                $numero38='0'.$numero38;
            }
        }else{//menor de cero
            //se quita primero el signo
            $numero38=-$numero38;
            //ahora añado ceros a la izda sino llega al tamaño requerido menos un lugar
            while(strlen($numero38)<16){
                $numero38='0'.$numero38;
            }
            //en ese lugar se indica 'N'
            $numero38='N'.$numero38;
        }
        $texto=$texto.$numero38;
        
        //Posicion 646-Atribuible a la administración del estado [39] (5= 3 enteros y 2 decimales)
        //indicamos 100 % (10000)
        $texto=$texto.'10000';
        
        //Posicion 651-Atribuible a la administración del estado [40] (17= 15 enteros y 2 decimales)
        //copio el $numero38
        $texto=$texto.$numero38;

        //Posicion 668-Cuotas a compensar de periodos anteriores [41] (17= 15 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $numero41=desFormateaNumeroContabilidad($resultado['41']);
        $numero41=$numero41*100;
        //si el numero es negativo se indica una N delante
        if($numero41>=0){
            //ahora añado ceros a la izda sino llega al tamaño requerido
            while(strlen($numero41)<17){
                $numero41='0'.$numero41;
            }
        }else{//menor de cero
            //se quita primero el signo
            $numero41=-$numero41;
            //ahora añado ceros a la izda sino llega al tamaño requerido menos un lugar
            while(strlen($numero41)<16){
                $numero41='0'.$numero41;
            }
            //en ese lugar se indica 'N'
            $numero41='N'.$numero41;
        }
        $texto=$texto.$numero41;
        
        //Posicion 685-Entregas intracomunitarias [42] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 702-Exportaciones y operaciones asimiladas [43] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 719-Operaciones no sujetas o con inversión del sujeto pasivo. Derecho a deducción [44] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 736-Exclusivamente tributación conjunta Estado y Diputaciones Forales [45] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 753-Resultado (40-41+45) [46] (17= 15 enteros y 2 decimales)
        //copio el $numero38
        $texto=$texto.$numero38;
        
        //Posicion 770-A deducir [47] (17= 15 enteros y 2 decimales)
        //se incluyen directamente 17 ceros
        $ceros='';
        while(strlen($ceros)<17){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 787-Resultado de la liquidación [48] (17= 15 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $numero48=desFormateaNumeroContabilidad($resultado['48']);
        $numero48=$numero48*100;
        //si el numero es negativo se indica una N delante
        if($numero48>=0){
            //ahora añado ceros a la izda sino llega al tamaño requerido
            while(strlen($numero48)<17){
                $numero48='0'.$numero48;
            }
        }else{//menor de cero
            //se quita primero el signo (cambio de signo)
            $numero48=-$numero48;
            //ahora añado ceros a la izda sino llega al tamaño requerido menos un lugar
            while(strlen($numero48)<16){
                $numero48='0'.$numero48;
            }
            //en ese lugar se indica 'N'
            $numero48='N'.$numero48;
        }
        $texto=$texto.$numero48;
        
        //Posicion 804-Compensación - Importe a compensar (si sale negativo [48]) [49] (17= 15 enteros y 2 decimales)
        //compruebo que $resultado[48] es negativo
        if($resultado['48']<0){
            //si es negativo lo escribo
            //desformateo el numero de contabilidad 
            $numero49=desFormateaNumeroContabilidad($resultado['48']);
            $numero49=$numero49*100;
            $numero49=-$numero49;
            //ahora añado ceros a la izda sino llega al tamaño requerido
            while(strlen($numero49)<17){
                $numero49='0'.$numero49;
            }
        }else{
            //si es 0 o positivo escribo en cero
            $numero49='';
            while(strlen($numero49)<17){
                $numero49=$numero49.'0';
            }
        }
        $texto=$texto.$numero49;
        
        //Posicion 821-Marca sin actividad (0=NO, 1=SI)
        //busco la vble 'SinActividad', si es NO (que tiene actividad=0) si es SI (no tiene actividad=1)
        if($datosBancarios['SinActividad']==='NO'){
            $actividad='0';
        }else{
            $actividad='1';
        }
        $texto=$texto.$actividad;

        //Posicion 822-Devolucion importe [50] (17= 15 enteros y 2 decimales)
        //busco la vble 'SeDomicilia' si se domicilia se indica la cantidad, sino no se ponen 0
        if($resultado['48']<0){
            if($datosBancarios['SeDomicilia']==='SI'){
                //repito la casilla49
                $numero50=$numero49;
                $texto=$texto.$numero50;

                //Posicion 839-Devolucion- Codigo cuenta cliente - Entidad (4)
                $entidad=$datosBancarios['cuentaBanco_Entidad'];
                while(strlen($entidad)<4){
                    $entidad='0'.$entidad;
                }
                $texto=$texto.$entidad;

                //Posicion 843-Devolucion- Codigo cuenta cliente - Oficina (4)
                $oficina=$datosBancarios['cuentaBanco_Oficina'];
                while(strlen($oficina)<4){
                    $oficina='0'.$oficina;
                }
                $texto=$texto.$oficina;

                //Posicion 847-Devolucion- Codigo cuenta cliente - DC (2)
                $DC=$datosBancarios['cuentaBanco_DC'];
                while(strlen($DC)<2){
                    $DC='0'.$DC;
                }
                $texto=$texto.$DC;

                //Posicion 849-Devolucion- Codigo cuenta cliente - Número de Cuenta (10)
                $NCuenta=$datosBancarios['cuentaBanco_NCuenta'];
                while(strlen($NCuenta)<10){
                    $NCuenta='0'.$NCuenta;
                }
                $texto=$texto.$NCuenta;
            }else{
                //pongo esta casilla a 0
                $numero50='';
                while(strlen($numero50)<17){
                    $numero50=$numero50.'0';
                }
                $texto=$texto.$numero50;

                //Posicion 839-Devolucion- Codigo cuenta cliente - Entidad (4)
                //indicamos 4 ceros
                $blancos='';
                while(strlen($blancos)<4){
                    $blancos=' '.$blancos;
                }
                $texto=$texto.$blancos;

                //Posicion 843-Devolucion- Codigo cuenta cliente - Oficina (4)
                //indicamos 4 ceros
                $blancos='';
                while(strlen($blancos)<4){
                    $blancos=' '.$blancos;
                }
                $texto=$texto.$blancos;

                //Posicion 847-Devolucion- Codigo cuenta cliente - DC (2)
                //indicamos 2 ceros
                $blancos='';
                while(strlen($blancos)<2){
                    $blancos=' '.$blancos;
                }
                $texto=$texto.$blancos;

                //Posicion 849-Devolucion- Codigo cuenta cliente - Número de Cuenta (10)
                //indicamos 10 blancos
                $blancos='';
                while(strlen($blancos)<10){
                    $blancos=' '.$blancos;
                }
                $texto=$texto.$blancos;
            }
        }else{
            //pongo esta casilla a 0
            $numero50='';
            while(strlen($numero50)<17){
                $numero50=$numero50.'0';
            }
            $texto=$texto.$numero50;
                
            //todo el espacio de los campos 839, 843, 847 y 849 en blanco (4+4+2+10=20)
            //indicamos 10 blancos
            $blancos='';
            while(strlen($blancos)<20){
                $blancos=' '.$blancos;
            }
            $texto=$texto.$blancos;
        }

        //Posicion 859-Ingreso - Forma de pago (1)
        //0=No cosnta
        //1=Efectivo
        //2=Adeudo en cuenta
        //3=Domiciliación
        if($datosBancarios['SeDomicilia']==='SI'){
            $formaPago='3';
        }else{
            $formaPago='2';
        }
        $texto=$texto.$formaPago;
        
        //Posicion 860-Ingreso - Importe [I] (17= 15 enteros y 2 decimales)
        //compruebo que $resultado[48] es 0 o positivo
        if($resultado['48']>=0){
            //si es 0 o positivo lo escribo
            //desformateo el numero de contabilidad 
            $numeroI=desFormateaNumeroContabilidad($resultado['48']);
            $numeroI=$numeroI*100;
            //ahora añado ceros a la izda sino llega al tamaño requerido
            while(strlen($numeroI)<17){
                $numeroI='0'.$numeroI;
            }
        }else{
            //si es negativo escribo en cero
            $numeroI='';
            while(strlen($numeroI)<17){
                $numeroI=$numeroI.'0';
            }
        }
        $texto=$texto.$numeroI;

        ////casillas 877, 881, 885 y 887 de banco
        if($resultado['48']>=0){
            if($datosBancarios['SeDomicilia']==='SI'){
                //Posicion 877-Ingreso- Codigo cuenta cliente - Entidad (4)
                $entidad=$datosBancarios['cuentaBanco_Entidad'];
                while(strlen($entidad)<4){
                    $entidad='0'.$entidad;
                }
                $texto=$texto.$entidad;

                //Posicion 881-Ingreso- Codigo cuenta cliente - Oficina (4)
                $oficina=$datosBancarios['cuentaBanco_Oficina'];
                while(strlen($oficina)<4){
                    $oficina='0'.$oficina;
                }
                $texto=$texto.$oficina;

                //Posicion 885-Ingreso- Codigo cuenta cliente - DC (2)
                $DC=$datosBancarios['cuentaBanco_DC'];
                while(strlen($DC)<2){
                    $DC='0'.$DC;
                }
                $texto=$texto.$DC;

                //Posicion 887-Ingreso- Codigo cuenta cliente - Número de Cuenta (10)
                $NCuenta=$datosBancarios['cuentaBanco_NCuenta'];
                while(strlen($NCuenta)<10){
                    $NCuenta='0'.$NCuenta;
                }
                $texto=$texto.$NCuenta;
            }else{
                //Posicion 877-Ingreso- Codigo cuenta cliente - Entidad (4)
                //indicamos 4 ceros
                $blancos='';
                while(strlen($blancos)<4){
                    $blancos=' '.$blancos;
                }
                $texto=$texto.$blancos;

                //Posicion 881-Ingreso- Codigo cuenta cliente - Oficina (4)
                //indicamos 4 ceros
                $blancos='';
                while(strlen($blancos)<4){
                    $blancos=' '.$blancos;
                }
                $texto=$texto.$blancos;

                //Posicion 885-Ingreso- Codigo cuenta cliente - DC (2)
                //indicamos 2 ceros
                $blancos='';
                while(strlen($blancos)<2){
                    $blancos=' '.$blancos;
                }
                $texto=$texto.$blancos;

                //Posicion 887-Ingreso- Codigo cuenta cliente - Número de Cuenta (10)
                //indicamos 10 blancos
                $blancos='';
                while(strlen($blancos)<10){
                    $blancos=' '.$blancos;
                }
                $texto=$texto.$blancos;
            }
        }else{
            //todo el espacio de los campos 877, 881, 885 y 887 en blanco (4+4+2+10=20)
            //indicamos 10 blancos
            $blancos='';
            while(strlen($blancos)<20){
                $blancos=' '.$blancos;
            }
            $texto=$texto.$blancos;
        }

        //Posicion 897-Complementaria - Indicador de Autoliquidacion complementaria (1)
        $texto=$texto.'0';
        
        //Posicion 898-Complementaria - Indicador de Autoliquidacion complementaria (13)
        $texto=$texto.'             ';
        
        //Posiciones 911 a 1343-Resto de campo no incluimos nada (433)
        //indicamos 433 blancos
        $blancos='';
        while(strlen($blancos)<432){
            $blancos=' '.$blancos;
        }
        $texto=$texto.$blancos;

        //por ultimo cerramos la etiqueta
        $texto=$texto."</T30301>";

        
        //por ultimo escribo el fichero y cierro
        fwrite($ddf,$texto);
        fclose($ddf);
        
        $datos='';
        //por ultimo compruebo si esta activada la casilla de grabar en el ordenador del cliente el fichero del impuesto
        if($TransmitoImp==='SI'){
            //datos a devolver
            $datos=array(
                "url"=>$dirNombre,
            );
        }
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->generarFicheroIVA303()<Devuelve datos: ".$datos['url']);
        return $datos;
    }
    
    function generarFicheroIRPF($datos){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->generarFicheroIRPF()>");

        $Periodo=$datos['Trimestre'];

        $nombre=$_SESSION['idEmp'].'-111-'.$datos['Ejercicio'].'-'.$Periodo.'.111';
        $dirNombre='../impuestos/'.$nombre;
        $ddf = fopen($dirNombre,'w');
    
        require_once '../CN/clsCNConsultas.php';
        //extraigo datos de la empresa
        $clsCNConsultas=new clsCNConsultas();
        $clsCNConsultas->setStrBD($_SESSION['dbContabilidad']);
        $datosEmpresa=$clsCNConsultas->datosEmpresa($_SESSION['idEmp']);
        
        
        //generar el texto del fichero
        //Posiciones 1,3,6, 8 y 9
        $texto="<T11101> ";
        //Posicion 10-PI Tipo de declaracion:
        //I = Ingreso, U = DDomiciliación, G = ingreso a anotar en CCT y N = Negativa
        $casilla30=$datos['casilla03']+$datos['casilla09'];
        if($casilla30>0){
            $texto=$texto.'U';
        }else if($casilla30<=0){
            $texto=$texto.'N';
        }
        
        //Posicion 11-Identificacion NIF (9)
        //controlo para que el texto tenga espacios en blanco si no tiene el tamaño requerido
        $NIF=$datosEmpresa['strCIF'];
        while(strlen($NIF)<9){
            $NIF=$NIF.' ';
        }
        $texto=$texto.$NIF;

        //Posicion 20-Identificacion Apellidos o Razon Social (45)
        //controlo para que el texto tenga espacios en blanco si no tiene el tamaño requerido
        $nomEmpresa=$datosEmpresa['strSesion'];
        while(strlen($nomEmpresa)<45){
            $nomEmpresa=$nomEmpresa.' ';
        }
        //si el tamaño es superior lo recorto
        if(strlen($nomEmpresa)>45){
            $nomEmpresa=substr($nomEmpresa,0,45);
        }
        $texto=$texto.$nomEmpresa;

        //Posicion 65 - Ejercicio (4)       
        $texto=$texto.$datos['Ejercicio'];
        
        //Posicion 69 - Periodo (2)       
        $texto=$texto.$datos['Trimestre'];
        
        //Posicion 71 - I.Rendimientos del trabajo: Rendimientos dinerarios - Perceptores [01] (8 enteros)
        //desformateo el numero de contabilidad 
        $casilla01=$datos['casilla01'];
        //ahora añado ceros a la izda sino llega al tamaño requerido
        while(strlen($casilla01)<8){
            $casilla01='0'.$casilla01;
        }
        $texto=$texto.$casilla01;
        
        //Posicion 79 - I.Rendimientos del trabajo: Rendimientos dinerarios - Importe percepciones [02] (17= 15 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $casilla02=desFormateaNumeroContabilidad($datos['casilla02']);
        $casilla02=$casilla02*100;
        //ahora añado ceros a la izda sino llega al tamaño requerido
        while(strlen($casilla02)<17){
            $casilla02='0'.$casilla02;
        }
        $texto=$texto.$casilla02;
        
        //Posicion 96 - I.Rendimientos del trabajo: Rendimientos dinerarios - Importe retenciones [03] (17= 15 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $casilla03=desFormateaNumeroContabilidad($datos['casilla03']);
        $casilla03=$casilla03*100;
        //ahora añado ceros a la izda sino llega al tamaño requerido
        while(strlen($casilla03)<17){
            $casilla03='0'.$casilla03;
        }
        $texto=$texto.$casilla03;
        
        //Posicion 113 - I.Rendimientos del trabajo: Rendimientos en especie [04][05][06] (8+17+17=42 enteros)
        $casilla04a06='';
        //ahora añado ceros a la izda sino llega al tamaño requerido
        while(strlen($casilla04a06)<42){
            $casilla04a06='0'.$casilla04a06;
        }
        $texto=$texto.$casilla04a06;
        
        //Posicion 155 - II.Rendimientos Actividades Economicas: Rendimientos dinerarios - Perceptores [07] (8 enteros)
        //desformateo el numero de contabilidad 
        $casilla07=$datos['casilla07'];
        //ahora añado ceros a la izda sino llega al tamaño requerido
        while(strlen($casilla07)<8){
            $casilla07='0'.$casilla07;
        }
        $texto=$texto.$casilla07;
        
        //Posicion 163 - II.Rendimientos Actividades Economicas: Rendimientos dinerarios - Importe percepciones [08] (17= 15 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $casilla08=desFormateaNumeroContabilidad($datos['casilla08']);
        $casilla08=$casilla08*100;
        //ahora añado ceros a la izda sino llega al tamaño requerido
        while(strlen($casilla08)<17){
            $casilla08='0'.$casilla08;
        }
        $texto=$texto.$casilla08;
        
        //Posicion 180 - II.Rendimientos Actividades Economicas: Rendimientos dinerarios - Importe retenciones [09] (17= 15 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $casilla09=desFormateaNumeroContabilidad($datos['casilla09']);
        $casilla09=$casilla09*100;
        //ahora añado ceros a la izda sino llega al tamaño requerido
        while(strlen($casilla09)<17){
            $casilla09='0'.$casilla09;
        }
        $texto=$texto.$casilla09;
        
        //Posicion 197 - II.Rendimientos Actividades Economicas: Rendimientos en especie [10][11][12] (8+17+17=42 enteros)
        $casilla10a12='';
        //ahora añado ceros a la izda sino llega al tamaño requerido
        while(strlen($casilla10a12)<42){
            $casilla10a12='0'.$casilla10a12;
        }
        $texto=$texto.$casilla10a12;
        
        //Posicion 239 - III, IV y V [13] a [27] ((8+17+17=42 enteros) x 5=210)
        $casilla13a27='';
        //ahora añado ceros a la izda sino llega al tamaño requerido
        while(strlen($casilla13a27)<210){
            $casilla13a27='0'.$casilla13a27;
        }
        $texto=$texto.$casilla13a27;
        
        //Posicion 449 - Total Liquidación: Suma de retenciones e ingresos a cuenta [28] (17= 15 enteros y 2 decimales)
        $casilla28=$casilla03+$casilla09;
        while(strlen($casilla28)<17){
            $casilla28='0'.$casilla28;
        }
        $texto=$texto.$casilla28;
        
        //Posicion 466 - Total Liquidación: Resultado de anteriores liquidaciones [29] (17= 15 enteros y 2 decimales)
        $casilla29='';
        //ahora añado ceros a la izda sino llega al tamaño requerido
        while(strlen($casilla29)<17){
            $casilla29='0'.$casilla29;
        }
        $texto=$texto.$casilla29;
        
        //Posicion 483 - Total Liquidación: Resultado a Ingresar [30] (17= 15 enteros y 2 decimales)
        while(strlen($casilla28)<17){
            $casilla28='0'.$casilla28;
        }
        $texto=$texto.$casilla28;
        
        //datos de la cuenta bancaria (si hay)
        if($datos['SeDomicilia']==='SI'){
            //Posicion 500 - Codigo cuenta cliente - Entidad (4)
            $entidad=$datos['cuentaBanco_Entidad'];
            while(strlen($entidad)<4){
                $entidad='0'.$entidad;
            }
            $texto=$texto.$entidad;

            //Posicion 504 - Codigo cuenta cliente - Oficina (4)
            $oficina=$datos['cuentaBanco_Oficina'];
            while(strlen($oficina)<4){
                $oficina='0'.$oficina;
            }
            $texto=$texto.$oficina;

            //Posicion 508 - Codigo cuenta cliente - DC (2)
            $DC=$datos['cuentaBanco_DC'];
            while(strlen($DC)<2){
                $DC='0'.$DC;
            }
            $texto=$texto.$DC;

            //Posicion 510 - Codigo cuenta cliente - Número de Cuenta (10)
            $NCuenta=$datos['cuentaBanco_NCuenta'];
            while(strlen($NCuenta)<10){
                $NCuenta='0'.$NCuenta;
            }
            $texto=$texto.$NCuenta;
        }else{
            //Posicion 500 - Codigo cuenta cliente - Entidad (4)
            //indicamos 4 ceros
            $blancos='';
            while(strlen($blancos)<4){
                $blancos=' '.$blancos;
            }
            $texto=$texto.$blancos;

            //Posicion 504 - Codigo cuenta cliente - Oficina (4)
            //indicamos 4 ceros
            $blancos='';
            while(strlen($blancos)<4){
                $blancos=' '.$blancos;
            }
            $texto=$texto.$blancos;

            //Posicion 508 - Codigo cuenta cliente - DC (2)
            //indicamos 2 ceros
            $blancos='';
            while(strlen($blancos)<2){
                $blancos=' '.$blancos;
            }
            $texto=$texto.$blancos;

            //Posicion 510 - Codigo cuenta cliente - Número de Cuenta (10)
            //indicamos 10 blancos
            $blancos='';
            while(strlen($blancos)<10){
                $blancos=' '.$blancos;
            }
            $texto=$texto.$blancos;
        }
        
        //Posicion 520 - Declaración Complementaria 
        $texto=$texto.'0';
        
        //Posicion 521 - Resto de datos
        //indicamos 671 blancos (13+16+100+9+9+50+13+1+1+459)
        $blancos='';
        while(strlen($blancos)<671){
            $blancos=' '.$blancos;
        }
        $texto=$texto.$blancos;

        
        //por ultimo cerramos la etiqueta
        $texto=$texto."</T11101>";

        
        //por ultimo escribo el fichero y cierro
        fwrite($ddf,$texto);
        fclose($ddf);
        
        $TransmitoImp='';
        //por ultimo compruebo si esta activada la casilla de grabar en el ordenador del cliente el fichero del impuesto
        if($datos['TransmitoImp']==='SI'){
            //datos a devolver
            $TransmitoImp=array(
                "url"=>$dirNombre,
            );
        }
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->generarFicheroIRPF()<Devuelve datos ");
        return $TransmitoImp;
    }
    
    function ListadoIRPF111_Presentados($idEmp){
        //listo los ficheros que hay en la carpeta '../impuestos/' que comienzen por idEmp-111*

        $directorio = opendir("../impuestos/"); 
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
        
        //ahora filtro los ficheros por los que comienzen por $idEmp
        $ficherosFin=array();
        $j=0;
        if(is_array($ficheros)){
            //recorro el array y el que cumpla la condicion lo incluyo en el array $ficherosFin
            for ($i = 0; $i < count($ficheros); $i++) {
                //divido el nombre del fichero por partes por el caracter '-'
                $ficheroPartes=explode('-',$ficheros[$i]);
                //la primera parte es el numero de la empresa
                if($ficheroPartes[0]===$idEmp){
                    //ahora compruebo que sea el impuesto 111
                    if($ficheroPartes[1]==='111'){
                        //lo incuyo en el array final
                        $ficherosFin[$j]=$ficheros[$i];
                        $j++;
                    }
                }
            }
        }
        //devolvemos el array final
        return $ficherosFin;
    }

    function ListadoAutonomo130_Presentados($idEmp){
        //listo los ficheros que hay en la carpeta '../impuestos/' que comienzen por idEmp-130*

        $directorio = opendir("../impuestos/"); 
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
        
        //ahora filtro los ficheros por los que comienzen por $idEmp
        $ficherosFin=array();
        $j=0;
        if(is_array($ficheros)){
            //recorro el array y el que cumpla la condicion lo incluyo en el array $ficherosFin
            for ($i = 0; $i < count($ficheros); $i++) {
                //divido el nombre del fichero por partes por el caracter '-'
                $ficheroPartes=explode('-',$ficheros[$i]);
                //la primera parte es el numero de la empresa
                if($ficheroPartes[0]===$idEmp){
                    //ahora compruebo que sea el impuesto 130
                    if($ficheroPartes[1]==='130'){
                        //lo incuyo en el array final
                        $ficherosFin[$j]=$ficheros[$i];
                        $j++;
                    }
                }
            }
        }
        //devolvemos el array final
        return $ficherosFin;
    }

    function ListadoIVA303_Presentados($idEmp){
        //listo los ficheros que hay en la carpeta '../impuestos/' que comienzen por idEmp-303*

        $directorio = opendir("../impuestos/"); 
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
        
        //ahora filtro los ficheros por los que comienzen por $idEmp
        $ficherosFin=array();
        $j=0;
        if(is_array($ficheros)){
            //recorro el array y el que cumpla la condicion lo incluyo en el array $ficherosFin
            for ($i = 0; $i < count($ficheros); $i++) {
                //divido el nombre del fichero por partes por el caracter '-'
                $ficheroPartes=explode('-',$ficheros[$i]);
                //la primera parte es el numero de la empresa
                if($ficheroPartes[0]===$idEmp){
                    //ahora compruebo que sea el impuesto 303
                    if($ficheroPartes[1]==='303'){
                        //lo incuyo en el array final
                        $ficherosFin[$j]=$ficheros[$i];
                        $j++;
                    }
                }
            }
        }
        //devolvemos el array final
        return $ficherosFin;
    }
    
    function LeeArchivoIVA303($IdFichero){
        
        $urlFichero="../impuestos/".$IdFichero;
        $file = fopen($urlFichero, "r") or exit("No hay fichero");

        $texto=fread($file,filesize($urlFichero));

        return $texto;
    }
    
    function LeeArchivoIRPF111($IdFichero){
        
        $urlFichero="../impuestos/".$IdFichero;
        $file = fopen($urlFichero, "r") or exit("No hay fichero");

        $texto=fread($file,filesize($urlFichero));

        return $texto;
    }
    
    function LeeArchivoAutonomo130($IdFichero){
        
        $urlFichero="../impuestos/".$IdFichero;
        $file = fopen($urlFichero, "r") or exit("No hay fichero");

        $texto=fread($file,filesize($urlFichero));

        return $texto;
    }
    
    function pasarNumeroFichero($textos){
        //primero vemos si viene la N como 1 caracter (es negativo)
        $primerCaracter=substr($textos,0,1);
        if($primerCaracter==='N'){
            //lo es, lo quetamos y pasamos el numero a float, lo dividimos entre 100 y le cambiamos el signo
            $restoCaracteres=(float)substr($textos,1,strlen($textos));
            $numero=$restoCaracteres/100;
            $numero=-$numero;
            $numero=formateaNumeroContabilidad($numero);
        }else{//no es negativo
            $restoCaracteres=(float)substr($textos,0,strlen($textos));
            $numero=$restoCaracteres/100;
            $numero=formateaNumeroContabilidad($numero);
        }
        
        return $numero;
    }
    
    function pasarNumeroEnteroFichero($textos){
        //primero vemos si viene la N como 1 caracter (es negativo)
        $primerCaracter=substr($textos,0,1);
        if($primerCaracter==='N'){
            //lo es, lo quetamos y pasamos el numero
            $restoCaracteres=(float)substr($textos,1,strlen($textos));
            $numero=$restoCaracteres;
            $numero=-$numero;
        }else{//no es negativo
            $restoCaracteres=(float)substr($textos,0,strlen($textos));
            $numero=$restoCaracteres;
        }
        
        return $numero;
    }
    
    function DatosAsientoSF($Asiento,$esAbono){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->DatosAsientoSF($Asiento,$esAbono)>");
        
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->DatosAsiento($Asiento,'SF',$esAbono);
    }
    
    function DatosAsientoCFIVA1SIRPF($Asiento,$esAbono){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->DatosAsientoCFIVA1SIRPF($Asiento,$esAbono)>");
        
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->DatosAsiento($Asiento,'CFIVA1SIRPF',$esAbono);
    }
    
    function DatosAsientoCFIVA1SIRPFVC($Asiento,$esAbono){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->DatosAsientoCFIVA1SIRPFVC($Asiento,$esAbono)>");
        
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->DatosAsiento($Asiento,'CFIVA1SIRPFVC',$esAbono);
    }
    
    function DatosAsientoCFIVA1CIRPF($Asiento,$esAbono){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->DatosAsientoCFIVA1CIRPF($Asiento,$esAbono)>");
        
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->DatosAsiento($Asiento,'CFIVA1CIRPF',$esAbono);
    }
    
    function DatosAsientoCFIVAV($Asiento,$esAbono){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->DatosAsientoCFIVAV($Asiento,$esAbono)>");
        
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->DatosAsiento($Asiento,'CFIVAV',$esAbono);
    }
    
    function DatosAsientoCFIVAVCIRPF($Asiento,$esAbono){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->DatosAsientoCFIVAVCIRPF($Asiento,$esAbono)>");
        
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->DatosAsiento($Asiento,'CFIVAVCIRPF',$esAbono);
    }
    
    function periodo($lngPeriodo){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->periodo($lngPeriodo)>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->periodo($lngPeriodo);
    }
    
    function DarBajaAsiento($Asiento){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->DarBajaAsiento($Asiento)>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->DarAltaBajaAsiento($Asiento,'Baja');
    }
    
    function DarAltaBajaPresupuesto($id,$opcion){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->DarAltaBajaPresupuesto($id,$opcion)>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->DarAltaBajaPresupuesto($id,$opcion);
    }
    
    function DarAltaBajaFactura($id,$opcion){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->DarAltaBajaFactura($id,$opcion)>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->DarAltaBajaFactura($id,$opcion);
    }
    
    function DarAltaBajaPedido($id,$opcion){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->DarAltaBajaPedido($id,$opcion)>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->DarAltaBajaPedido($id,$opcion);
    }
    
    function DarAltaAsiento($Asiento){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->DarBajaAsiento($Asiento)>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->DarAltaBajaAsiento($Asiento,'Alta');
    }
    
    function LeeResultados($fechaForm){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->LeeResultados($fechaForm)>");
        
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->LeeResultados($fechaForm);
    }
    
    function LeeTesoreria($fechaForm){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->LeeTesoreria($fechaForm)>");
        
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        //calculo de tesoreria
        //donde voy a guardar los datos
        $datos=array(
            'caja'=>0,
            'bancos'=>0
        );
        
        $cuentas=array("Cuenta"=>'570000000');
        $caja=$this->ListadoAsientosCuenta($cuentas,0);
        
        //realizo la suma de la caja
        $datos['caja']=$caja[count($caja)-1]['Saldo'];
        
        //saco el listado de bancos
        $ListadoCuentasBancos=$this->LeeCuentas('5720');
        
        $banco=0;
        foreach($ListadoCuentasBancos as $cuentas){
            //$cuenta=array("Cuenta"=>$cuentas);
            $banco=$this->ListadoAsientosCuenta($cuentas,0);
            
            //realizo la suma de los bancos
            $datos['bancos']=$datos['bancos']+$banco[count($banco)-1]['Saldo'];
        }

        return $datos;
    }
    
    function LeeCuentas($parametro){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->LeeCuentas($parametro)>");
        
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->LeeCuentas($parametro);
    }
    
    function LeeImpuestos($fechaForm){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->LeeImpuestos($fechaForm)>");
        
        $lngEjercicio=explode('/',$fechaForm);
        //primero leo los datos del IVA y de IRPF (usados en otra parte de la app)
        $datosIVA = $this->calculoDatosIVA($lngEjercicio[2]);
        $datosIRPF=$this->calculoDatosIRPF($lngEjercicio[2]);
  
        //ver el trimestre actual
        $mesActual=date('m');
        
        $trimestreActual='';
        $trimestreAnterior='';
        if($mesActual==='1' || $mesActual==='2' || $mesActual==='3'){
            $trimestreActual='1T';
            $trimestreAnterior='0T';
        }else
        if($mesActual==='4' || $mesActual==='5' || $mesActual==='6'){
            $trimestreActual='2T';
            $trimestreAnterior='1T';
        }else
        if($mesActual==='7' || $mesActual==='8' || $mesActual==='9'){
            $trimestreActual='3T';
            $trimestreAnterior='2T';
        }else
        if($mesActual==='10' || $mesActual==='11' || $mesActual==='12'){
            $trimestreActual='4T';
            $trimestreAnterior='3T';
        }
        
        //preparo los datos a presentar
        $datos='';
        $datos['IVA']['TrimestreActual']=  $datosIVA[$trimestreActual]['Resultado'];
        if($datosIVA[$trimestreActual]['Esta_Cerrado']==='NO'){
            $datos['IVA']['TrimestreAnterior']=  $datosIVA[$trimestreAnterior]['Resultado'];
        }else{
            $datos['IVA']['TrimestreAnterior']=  'Pagado';
        }
        
        
        //SIN HACER PARTE IRPF PREGUNTAR JM 27/11/2014

        return $datos;
    }
    
    function LeeAlquileres($fechaForm){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->LeeAlquileres($fechaForm)>");
        
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->LeeAlquileres($fechaForm);
    }
    
    function LeePagos($fechaForm){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->LeePagos($fechaForm)>");
        
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->LeePagos($fechaForm);
    }
    
    function CobrosPagosPendientes($cuentas,$fechaForm){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->CobrosPagosPendientes($cuentas,$fechaForm)>");
        
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->CobrosPagosPendientes($cuentas,$fechaForm);
    }
    
    function DatosCuentaParaResultados($cuenta){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->DatosCuentaParaResultados($cuenta)>");
        
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->DatosCuentaParaResultados($cuenta);
    }
    
    function PerceptoresIRPF($lngEjercicio,$Periodo,$clave){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->PerceptoresIRPF($lngEjercicio,$Periodo,$clave)>");
        
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->PerceptoresIRPF($lngEjercicio,$Periodo,$clave);
    }
    
    function AsientoEditable($ejercicio,$periodo){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->AsientoEditable($ejercicio,$periodo)>");
        
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->AsientoEditable($ejercicio,$periodo);
    }
    
    function consultaCerradoAutonomo130(){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->consultaCerradoAutonomo130()>");
        
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->consultaCerradoAutonomo130();
    }
    
    function consultaAbiertoAutonomo130($lngEjercicio){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->consultaAbiertoAutonomo130($lngEjercicio)>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->consultaAbiertoAutonomo130($lngEjercicio);
    }
    
    function calcularCuota($parametroBuscar,$fechaInicio,$fechaFin){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->calcularCuota($parametroBuscar,$fechaInicio,$fechaFin)>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->calcularCuotaLlamada($parametroBuscar,$fechaInicio,$fechaFin);
    }
    
    function calculoDatosAutonomo130($lngEjercicio){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->consultaCerradoAutonomo130()>");
        $datosCerradoAut130 = $this->consultaCerradoAutonomo130();
        
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->consultaAbiertoAutonomo130()>");
        $datosAbiertoAut130 = $this->consultaAbiertoAutonomo130($lngEjercicio);

        //a continuación comienzo a preparar los datos que saldran en la consulta
        //voy a recojer los datos que presentaré en un array
        //el tamaño del array es 4 (trimestres) 
        //hago un primer recorrido rellenando los datos que vienen del $datosCerradoAut130
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                ' clsCNContabilidad->calculoDatosAutonomo130(): Introduzco en $datos todos los resultados por trimestre');
        $datos = '';
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->calculoDatosAutonomo130(): Primero los que vienen de la tabla 'tbautonomo130' que son periodos cerrados");

        if(!isset($datosCerradoAut130[0])){
            //no hay datos de resultados cerrados, creo esta variable con el año en curso y periodo 0 
            $ultimoTrimestreCerrado=array(
                "Ejercicio"=>$lngEjercicio,
                "Trimestre"=>0,  //asi al sumar mas adelante no hay incongruencias
            );
        }else{
            for ($i = 0; $i < count($datosCerradoAut130); $i++) {
                //veo si el 4 trimestre del ejercicio anterior esta cerrado
                if($datosCerradoAut130[$i]["Ejercicio"]===(string)($lngEjercicio-1) && $datosCerradoAut130[$i]["Trimestre"]==='4'){
                    $datos[] = array(
                        "Ejercicio" => $datosCerradoAut130[$i]["Ejercicio"],
                        "Trimestre" => $datosCerradoAut130[$i]["Trimestre"],
                        "Ingresos" => $datosCerradoAut130[$i]["Ingresos"],
                        "Gastos" => $datosCerradoAut130[$i]["Gastos"],
                        "Resultado" => $datosCerradoAut130[$i]["Resultado"],
                        "Cuota" => $datosCerradoAut130[$i]["Cuota"],
                        "CuotasAnt" => $datosCerradoAut130[$i]["CuotaAnterior"],
                        "Liquidacion" => $datosCerradoAut130[$i]["Liquidacion"],
                        "Esta_Cerrado" => "SI"
                    );
                }
                
                if($datosCerradoAut130[$i]["Ejercicio"]==$lngEjercicio){
                    $datos[] = array(
                        "Ejercicio" => $datosCerradoAut130[$i]["Ejercicio"],
                        "Trimestre" => $datosCerradoAut130[$i]["Trimestre"],
                        "Ingresos" => $datosCerradoAut130[$i]["Ingresos"],
                        "Gastos" => $datosCerradoAut130[$i]["Gastos"],
                        "Resultado" => $datosCerradoAut130[$i]["Resultado"],
                        "Cuota" => $datosCerradoAut130[$i]["Cuota"],
                        "CuotasAnt" => $datosCerradoAut130[$i]["CuotaAnterior"],
                        "Liquidacion" => $datosCerradoAut130[$i]["Liquidacion"],
                        "Esta_Cerrado" => "SI"
                    );
                }
            }
            //existen datos de IVAs cerrados, los coje  ESTE COMENTARIO ACTUALIZARLO
            $ultimoTrimestreCerrado = $datosCerradoAut130[count($datosCerradoAut130)-1];
            if($ultimoTrimestreCerrado['Ejercicio']<>$lngEjercicio){
                //no hay datos de resultados cerrados, creo esta variable con el año en curso y periodo 0 
                $ultimoTrimestreCerrado=array(
                    "Ejercicio"=>$lngEjercicio,
                    "Trimestre"=>0,  //asi al sumar mas adelante no hay incongruencias
                );
            }
        }

        $trimestreActual = $ultimoTrimestreCerrado['Trimestre'] + 1;
        $ejercicioActual=$ultimoTrimestreCerrado['Ejercicio'];
        if($trimestreActual>4){//si el trimestre es 4 el sigueinte trimestre es 1 del año siguiente
            $trimestreActual=1;
            $ejercicioActual=$ejercicioActual+1;
        }
        
        //recorro los $datosAbiertoAut130 y los introduzco en el array $datos
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                ' clsCNContabilidad->calculoDatosAutonomo130(): Segundo los que vienen del array $datosAbiertoAut130 que son periodos abiertos');

        $ultimoEjercicioCerrado=$ejercicioActual;
        $ultimoTrimestreCerrado=$trimestreActual-1;//es el trimestre anterior
        //calculo el primer periodo sin cerrar
        $primerEjercicioSinCerrar=$ultimoEjercicioCerrado;
        $primerTrimestreSinCerrar=$ultimoTrimestreCerrado+1;
        if($primerTrimestreSinCerrar>=5){
            $primerEjercicioSinCerrar++;
            $primerTrimestreSinCerrar=1;
        }
        
        //voy recorriendo los trimestres que quedan por recorrer
        if($primerEjercicioSinCerrar==$lngEjercicio){
            for ($j = $primerTrimestreSinCerrar; $j <= 4; $j++) { //4 trimestres como máximo
                //calculo los datos a introducir en al array
                $ejercicioActual=$primerEjercicioSinCerrar;
                if($j==1){
                    $trimestreActual='1T';
                }else if($j==2){
                    $trimestreActual='2T';
                }else if($j==3){
                    $trimestreActual='3T';
                }else if($j==4){
                    $trimestreActual='4T';
                }

                //paso los datos al array $datos
                $datos[] = array(
                        "Ejercicio" => $ejercicioActual,
                        "Trimestre" => $j,
                        "Ingresos" => $datosAbiertoAut130[$trimestreActual]["Ingresos"],
                        "Gastos" => $datosAbiertoAut130[$trimestreActual]["Gastos"],
                        "Resultado" => $datosAbiertoAut130[$trimestreActual]["Resultado"],
                        "Cuota" => $datosAbiertoAut130[$trimestreActual]["Cuota"],
                        "CuotasAnt" => $datosAbiertoAut130[$trimestreActual]["CuotaAnt"],
                        "Liquidacion" => $datosAbiertoAut130[$trimestreActual]["Liquidacion"],
                        "Esta_Cerrado" => "NO"
                );
                //$trimestreActual++;
                //si $trimestreActual pasa de 4 (5) es que es el 1 trimestre del ejercicio siguiente
//                if($trimestreActual>=5){
//                    $trimestreActual=1;
//                    $ejercicioActual++;
//                }
            }
        
        }
        //presentar segun Ejercicio y periodo (copia de los anteriores)
        
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->calculoDatosAutonomo130(): Por ultimo introduzco los datos que se van a presentar en pantalla en un array");
        //ahora introduzco los datos a presentar en un array
        $trimestreDatos = array(
            "Ingresos" => 0,
            "Gastos" => 0,
            "Resultado" => 0,
            "Cuota" => 0,
            "CuotasAnt" => 0,
            "Liquidacion" => 0,
            "Esta_Cerrado" => ""
        );
        $datosPresentar = array(
            "0T" => $trimestreDatos,
            "1T" => $trimestreDatos,
            "2T" => $trimestreDatos,
            "3T" => $trimestreDatos,
            "4T" => $trimestreDatos,
        );
        
        //comienzo a introducir los datos
        foreach ($datos as $valor) {
            //introduzco los datos
            
            //primero los del 4 trimestre del ejercico anterior ??????????????????????????????????????????
            if ($valor['Ejercicio'] == ($lngEjercicio-1) && $valor['Trimestre']==='4') {
                $datosPresentar['0T']['Esta_Cerrado']=$valor['Esta_Cerrado'];
            }
            
            if ($valor['Ejercicio'] == $lngEjercicio) {
                if ($valor['Trimestre'] == 1) {
                    $datosPresentar['1T']['Ingresos']= formateaNumeroContabilidad($valor['Ingresos']);
                    $datosPresentar['1T']['Gastos']= formateaNumeroContabilidad($valor['Gastos']);
                    $datosPresentar['1T']['Resultado']= formateaNumeroContabilidad($valor['Resultado']);
                    $datosPresentar['1T']['Cuota']= formateaNumeroContabilidad($valor['Cuota']);
                    $datosPresentar['1T']['CuotasAnt']= formateaNumeroContabilidad($valor['CuotasAnt']);
                    $datosPresentar['1T']['Liquidacion']= formateaNumeroContabilidad($valor['Liquidacion']);
                    $datosPresentar['1T']['Esta_Cerrado']= $valor['Esta_Cerrado'];
                } else if ($valor['Trimestre'] == 2) {
                    $datosPresentar['2T']['Ingresos']= formateaNumeroContabilidad($valor['Ingresos']);
                    $datosPresentar['2T']['Gastos']= formateaNumeroContabilidad($valor['Gastos']);
                    $datosPresentar['2T']['Resultado']= formateaNumeroContabilidad($valor['Resultado']);
                    $datosPresentar['2T']['Cuota']= formateaNumeroContabilidad($valor['Cuota']);
                    $datosPresentar['2T']['CuotasAnt']= formateaNumeroContabilidad($valor['CuotasAnt']);
                    $datosPresentar['2T']['Liquidacion']= formateaNumeroContabilidad($valor['Liquidacion']);
                    $datosPresentar['2T']['Esta_Cerrado']= $valor['Esta_Cerrado'];
                } else if ($valor['Trimestre'] == 3) {
                    $datosPresentar['3T']['Ingresos']= formateaNumeroContabilidad($valor['Ingresos']);
                    $datosPresentar['3T']['Gastos']= formateaNumeroContabilidad($valor['Gastos']);
                    $datosPresentar['3T']['Resultado']= formateaNumeroContabilidad($valor['Resultado']);
                    $datosPresentar['3T']['Cuota']= formateaNumeroContabilidad($valor['Cuota']);
                    $datosPresentar['3T']['CuotasAnt']= formateaNumeroContabilidad($valor['CuotasAnt']);
                    $datosPresentar['3T']['Liquidacion']= formateaNumeroContabilidad($valor['Liquidacion']);
                    $datosPresentar['3T']['Esta_Cerrado']= $valor['Esta_Cerrado'];
                } else if ($valor['Trimestre'] == 4) {
                    $datosPresentar['4T']['Ingresos']= formateaNumeroContabilidad($valor['Ingresos']);
                    $datosPresentar['4T']['Gastos']= formateaNumeroContabilidad($valor['Gastos']);
                    $datosPresentar['4T']['Resultado']= formateaNumeroContabilidad($valor['Resultado']);
                    $datosPresentar['4T']['Cuota']= formateaNumeroContabilidad($valor['Cuota']);
                    $datosPresentar['4T']['CuotasAnt']= formateaNumeroContabilidad($valor['CuotasAnt']);
                    $datosPresentar['4T']['Liquidacion']= formateaNumeroContabilidad($valor['Liquidacion']);
                    $datosPresentar['4T']['Esta_Cerrado']= $valor['Esta_Cerrado'];
                }
            }
        }
        
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                ' clsCNContabilidad->calculoDatosAutonomo130()<TERMINA y DEVUELVE $datosPresentar');
        return $datosPresentar;
    }
    
    function guardarAutonomo130($Ejercicio,$Trimestre,$casilla01,$casilla02,
                                $casilla03,$casilla04,$casilla05,$casilla06){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->guardarAutonomo130($Ejercicio,$Trimestre,$casilla01,$casilla02,
                                $casilla03,$casilla04,$casilla05,$casilla06)>");

        if($Trimestre==='1T'){
            $numTrimestre=1;
        }else if($Trimestre==='2T'){
            $numTrimestre=2;
        }else if($Trimestre==='3T'){
            $numTrimestre=3;
        }else if($Trimestre==='4T'){
            $numTrimestre=4;
        }
        //desformateo los numeros de contabilidad
        $casilla01 =  desFormateaNumeroContabilidad($casilla01);
        $casilla02 =  desFormateaNumeroContabilidad($casilla02);
        $casilla03 =  desFormateaNumeroContabilidad($casilla03);
        $casilla04 =  desFormateaNumeroContabilidad($casilla04);
        $casilla05 =  desFormateaNumeroContabilidad($casilla05);
        $casilla06 =  desFormateaNumeroContabilidad($casilla06);
        
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->guardarAutonomo130($Ejercicio,$numTrimestre,$casilla01,$casilla02,
                                $casilla03,$casilla04,$casilla05,$casilla06);
    }
    
    function generarFicheroAutonomo130($datos,$datosUsuario){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->generarFicheroAutonomo130()>");

        $Periodo=$datos['Trimestre'];
        
        $nombre=$_SESSION['idEmp'].'-130-'.$datos['Ejercicio'].'-'.$Periodo.'.130';
        $dirNombre='../impuestos/'.$nombre;
        $ddf = fopen($dirNombre,'w');
    
        require_once '../CN/clsCNConsultas.php';
        //extraigo datos de la empresa
        $clsCNConsultas=new clsCNConsultas();
        $clsCNConsultas->setStrBD($_SESSION['dbContabilidad']);
        $datosEmpresa=$clsCNConsultas->datosEmpresa($_SESSION['idEmp']);
        
        //generar el texto del fichero
        //Posiciones 1,4 y 6
        $texto="13001 ";

        //Posicion 7-PI Tipo de declaracion:
        //I = Ingreso, B = Resultado a deducir, U = domiciliación del ingreso en CCT, G = cuenta corriente tributaria-ingreso y N = Negativa
        $casilla19=$datos['casilla19'];
        if($casilla19>0){
            $texto=$texto.'I';
        }else if($casilla19<=0){
            $texto=$texto.'N';
        }
        
        //Posicion 8-Código administración
        //se incluyen directamente 5 ceros
        $ceros='';
        while(strlen($ceros)<5){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 13-Declarante NIF (9)
        //controlo para que el texto tenga espacios en blanco si no tiene el tamaño requerido
        $NIF=$datosEmpresa['strCIF'];
        while(strlen($NIF)<9){
            $NIF=$NIF.' ';
        }
        $texto=$texto.$NIF;
        
        //Posicion 22-Declarante Comienzo del primer apellido persona fisica (4)
        //controlo para que el texto tenga espacios en blanco si no tiene el tamaño requerido
        $comPrimerAp=substr($datosUsuario['strApellidos'],0,4);
        while(strlen($comPrimerAp)<4){
            $comPrimerAp=$comPrimerAp.' ';
        }
        $texto=$texto.$comPrimerAp;
        
        //Posicion 26-Apellidos (30)
        //controlo para que el texto tenga espacios en blanco si no tiene el tamaño requerido
        $Apellidos=substr($datosUsuario['strApellidos'],0,30);
        while(strlen($Apellidos)<31){
            $Apellidos=$Apellidos.' ';
        }
        $texto=$texto.$Apellidos;
        
        //Posicion 56-Nombre (15)
        //controlo para que el texto tenga espacios en blanco si no tiene el tamaño requerido
        $nombre=substr($datosUsuario['strNombre'],0,15);
        while(strlen($nombre)<15){
            $nombre=$nombre.' ';
        }
        $texto=$texto.$nombre;
        
        //Posicion 71 - Ejercicio (4)       
        $texto=$texto.$datos['Ejercicio'];
        
        //Posicion 75 - Periodo (2)       
        $texto=$texto.$datos['Trimestre'];
        
        //Posicion 77 - I. Activ. económicas - Ingresos [01] (11 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $casilla01=desFormateaNumeroContabilidad($datos['casilla01']);
        $casilla01=$casilla01*100;
        //ahora añado ceros a la izda sino llega al tamaño requerido
        while(strlen($casilla01)<13){
            $casilla01='0'.$casilla01;
        }
        $texto=$texto.$casilla01;
        
        //Posicion 90 - I. Activ. económicas - Gastos [02] (11 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $casilla02=desFormateaNumeroContabilidad($datos['casilla02']);
        $casilla02=$casilla02*100;
        //ahora añado ceros a la izda sino llega al tamaño requerido
        while(strlen($casilla02)<13){
            $casilla02='0'.$casilla02;
        }
        $texto=$texto.$casilla02;
        
        //Posicion 103 - I. Activ. económicas - Rendimiento [03] (11 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $casilla03=desFormateaNumeroContabilidad($datos['casilla03']);
        $casilla03=$casilla03*100;
        //si el numero es negativo se indica una N delante
        if($casilla03>=0){
            //ahora añado ceros a la izda sino llega al tamaño requerido
            while(strlen($casilla03)<13){
                $casilla03='0'.$casilla03;
            }
        }else{//menor de cero
            //se quita primero el signo
            $casilla03=-$casilla03;
            //ahora añado ceros a la izda sino llega al tamaño requerido menos un lugar
            while(strlen($casilla03)<12){
                $casilla03='0'.$casilla03;
            }
            //en ese lugar se indica 'N'
            $casilla03='N'.$casilla03;
        }
        $texto=$texto.$casilla03;
        
        //Posicion 116 - I. Activ. económicas - 20% casilla 3 [04] (11 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $casilla04=desFormateaNumeroContabilidad($datos['casilla04']);
        $casilla04=$casilla04*100;
        //ahora añado ceros a la izda sino llega al tamaño requerido
        while(strlen($casilla04)<13){
            $casilla04='0'.$casilla04;
        }
        $texto=$texto.$casilla04;
        
        //Posicion 129 - I. Activ. económicas - De los trimstres anteriores [05] (11 enteros y 2 decimales)
        //desformateo el numero de contabilidad 
        $casilla05=desFormateaNumeroContabilidad($datos['casilla05']);
        $casilla05=$casilla05*100;
        //ahora añado ceros a la izda sino llega al tamaño requerido
        while(strlen($casilla05)<13){
            $casilla05='0'.$casilla05;
        }
        $texto=$texto.$casilla05;
        
        //Posicion 142 Casillas [06] al [18] (11 enteros y 2 decimales) x 13 = 169
        //se incluyen directamente 169 ceros
        $ceros='';
        while(strlen($ceros)<169){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;

        //Posicion 311 - I. Activ. económicas. Resultado de la declaración [19] (11 enteros y 2 decimales)
        $texto=$texto.$casilla04;
   
        //Posicion 324 - Ingreso. Importe de Ingreso (11 enteros y 2 decimales)
        $texto=$texto.$casilla04;
   
        //Posicion 337-Ingreso - Forma de pago (1)
        //0=No cosnta
        //1=Efectivo
        //2=Adeudo en cuenta
        //3=Domiciliación
        if($datos['SeDomicilia']==='SI'){
            $formaPago='3';
            $texto=$texto.$formaPago;
            
            //datos de la cuenta bancaria (si hay)
            //Posicion 338 - Codigo cuenta cliente - Entidad (4)
            $entidad=$datos['cuentaBanco_Entidad'];
            while(strlen($entidad)<4){
                $entidad='0'.$entidad;
            }
            $texto=$texto.$entidad;

            //Posicion 342 - Codigo cuenta cliente - Oficina (4)
            $oficina=$datos['cuentaBanco_Oficina'];
            while(strlen($oficina)<4){
                $oficina='0'.$oficina;
            }
            $texto=$texto.$oficina;

            //Posicion 346 - Codigo cuenta cliente - DC (2)
            $DC=$datos['cuentaBanco_DC'];
            while(strlen($DC)<2){
                $DC='0'.$DC;
            }
            $texto=$texto.$DC;

            //Posicion 348 - Codigo cuenta cliente - Número de Cuenta (10)
            $NCuenta=$datos['cuentaBanco_NCuenta'];
            while(strlen($NCuenta)<10){
                $NCuenta='0'.$NCuenta;
            }
            $texto=$texto.$NCuenta;
        }else{
            $formaPago='2';
            $texto=$texto.$formaPago;
            
            //Posicion 338 - Codigo cuenta cliente - Entidad (4)
            //indicamos 4 ceros
            $blancos='';
            while(strlen($blancos)<4){
                $blancos=' '.$blancos;
            }
            $texto=$texto.$blancos;

            //Posicion 342 - Codigo cuenta cliente - Oficina (4)
            //indicamos 4 ceros
            $blancos='';
            while(strlen($blancos)<4){
                $blancos=' '.$blancos;
            }
            $texto=$texto.$blancos;

            //Posicion 346 - Codigo cuenta cliente - DC (2)
            //indicamos 2 ceros
            $blancos='';
            while(strlen($blancos)<2){
                $blancos=' '.$blancos;
            }
            $texto=$texto.$blancos;

            //Posicion 348 - Codigo cuenta cliente - Número de Cuenta (10)
            //indicamos 10 blancos
            $blancos='';
            while(strlen($blancos)<10){
                $blancos=' '.$blancos;
            }
            $texto=$texto.$blancos;
        }

        //Posicion 358 - A deducir: (Blanco o X)
        //se incluyen directamente 1 espacio en blanco
        $texto=$texto.' ';
        
        //Posicion 359 - Complementaria: Código electrónico declaración anterior 
        //se incluyen directamente 16 ceros
        $ceros='';
        while(strlen($ceros)<16){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 375 - Complementaria: nº justificante declaración anterior 
        //se incluyen directamente 13 ceros
        $ceros='';
        while(strlen($ceros)<13){
            $ceros=$ceros.'0';
        }
        $texto=$texto.$ceros;
        
        //Posicion 388-Persona de Contacto (100)
        //controlo para que el texto tenga espacios en blanco si no tiene el tamaño requerido
        $personaContacto=$datosUsuario['strNombre'].' '.$datosUsuario['strApellidos'];
        while(strlen($personaContacto)<101){
            $personaContacto=$personaContacto.' ';
        }
        $texto=$texto.$personaContacto;
        
        //Posiciones 488 a 879 - Resto de campo no incluimos nada (391)
        //indicamos 391 blancos
        $blancos='';
        while(strlen($blancos)<391){
            $blancos=' '.$blancos;
        }
        $texto=$texto.$blancos;
        
        
        //por ultimo Fin de Registro. Constante CRLF (Hexadecimal 0D0A, Decimal 1310)
        $texto=$texto."\r\n";

        
        //por ultimo escribo el fichero y cierro
        fwrite($ddf,$texto);
        fclose($ddf);

        $TransmitoImp='';
        //por ultimo compruebo si esta activada la casilla de grabar en el ordenador del cliente el fichero del impuesto
        if($datos['TransmitoImp']==='SI'){
            //datos a devolver
            $TransmitoImp=array(
                "url"=>$dirNombre,
            );
        }
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->generarFicheroAutonomo130()<Devuelve datos ");
        return $TransmitoImp;
    }
    
    function ListadoModContactos($strNomEmpresa,$StrNombre,$strCIF,$strApellidos,$lngCP,$strCiudad) {
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->ListadoModContactos($strNomEmpresa,$StrNombre,$strCIF,$strApellidos,$lngCP,$strCiudad)>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        $clsCADContabilidad->setStrBDCliente($this->getStrBDCliente());

        return $clsCADContabilidad->ListadoModContactos($strNomEmpresa,$StrNombre,$strCIF,$strApellidos,$lngCP,$strCiudad);
    }

    function DatosContacto($IdContacto){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->DatosContacto($IdContacto)>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->DatosContacto($IdContacto);
    }
    
    function EditarContacto($usuario,$IdContacto,$strNomEmpresa,$strCIF,$strDireccion,$strMunicipio,$lngCP,$strProvincia,$strNombre,
                                        $strApellidos,$strTelefono,$strMovil,$strEmail,$strNotas,$strFormaPago){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->EditarContacto($usuario,$IdContacto,$strNomEmpresa,$strCIF,$strDireccion,$strMunicipio,$lngCP,$strProvincia,$strNombre,
                                        $strApellidos,$strTelefono,$strMovil,$strEmail,$strNotas,$strFormaPago)>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->EditarContacto($usuario,$IdContacto,$strNomEmpresa,$strCIF,$strDireccion,$strMunicipio,$lngCP,$strProvincia,$strNombre,
                                        $strApellidos,$strTelefono,$strMovil,$strEmail,$strNotas,$strFormaPago);
    }
    
    function AltaContacto($usuario,$strNomEmpresa,$strCIF,$strDireccion,$strMunicipio,$lngCP,$strProvincia,$strNombre,
                                        $strApellidos,$strTelefono,$strMovil,$strEmail,$strNotas,$strFormaPago){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->AltaContacto($usuario,$strNomEmpresa,$strCIF,$strDireccion,$strMunicipio,$lngCP,$strProvincia,$strNombre,
                                        $strApellidos,$strTelefono,$strMovil,$strEmail,$strNotas,$strFormaPago)>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->AltaContacto($usuario,$strNomEmpresa,$strCIF,$strDireccion,$strMunicipio,$lngCP,$strProvincia,$strNombre,
                                        $strApellidos,$strTelefono,$strMovil,$strEmail,$strNotas,$strFormaPago);
    }
    
//    function AltaClienteDeContactoImportado($usuario,$IdContacto,$strNomEmpresa,$strCIF,$strDireccion,$strMunicipio,$lngCP,$strProvincia,$strNombre,
//                                        $strApellidos,$strTelefono,$strMovil,$strEmail,$strNotas,$strFormaPago,$lngTipo,$lngCodigo){
//        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
//                " clsCNContabilidad->AltaClienteDeContactoImportado()>");
//
//        require_once '../CAD/clsCADContabilidad.php';
//        $clsCADContabilidad = new clsCADContabilidad();
//        $clsCADContabilidad->setStrBD($this->getStrBD());
//
//        
//        
//        
//        
//        
//    }
    
    function AltaClienteDeContacto($usuario,$IdContacto,$strNomEmpresa,$strCIF,$strDireccion,$strMunicipio,$lngCP,$strProvincia,$strNombre,
                                        $strApellidos,$strTelefono,$strMovil,$strEmail,$strNotas,$strFormaPago,$lngTipo,$lngCodigo){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->AltaClienteDeContacto()>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        //primero busco en la tabla 'tbcliprov' de la BBDD de contabilidad el CIF/NIF 
        //si existe cojo su IdCliProv y lo guardo en la tabla 'tbmiscontactos.IdCliProv' de la BBDD del cliente
        
        $IdCliProv=$clsCADContabilidad->leerIdCliProv_tbcliprov($strCIF);
        
        require_once '../CN/clsCNUsu.php';
        require_once '../general/funcionesGenerales.php';
        $clsCNUsu=new clsCNUsu();
        $clsCNUsu->setStrBD($_SESSION['dbContabilidad']);
        $clsCNUsu->setStrBDCliente($_SESSION['mapeo']);

        $nuevoIdCliProv=$clsCNUsu->IdCliProv();
            
        //ahora compruebo si esta variable contiene algun dato numérico (existe cliente/proveedor) o no
        if($IdCliProv==null){
            //es nuevo
            //insert en la tabla 'tbcliprov' de la BBDD contabilidad el nuevo cliente, en la tabla 'tbcuenta' de la BBDD cliente
            //la cuenta asociada a este cliente y en la tabla 'tbrelacioncliprov' del la BBDD contabilidad
            //la relacion de este cliente con su cuenta (entre 'tbcliprov' y 'tbuenta')
            //(llamo a la funcion $clsCNUsu->AltaClienteNuevo()
            $numEmpresa=$_SESSION["idEmp"];
            if(strlen($lngTipo)==9){
                $numCuenta=$lngTipo;
                
                //SIN HACER
                $varRes=$clsCNUsu->PasarContactoAClienteNuevo($nuevoIdCliProv,$strNomEmpresa,$strCIF,"",$lngCP,$strDireccion,
                                       $strMunicipio,$strProvincia,$strEmail,$strTelefono,
                                       $strMovil,"",$lngCodigo,$numCuenta,$numEmpresa,$cliProv);

                if($varRes==true){
                    //se ha insertado correctamente en la operacion anterior
                    //actualizo la tabla 'tbmiscontactos' de la BBDD cliente
                    return $clsCADContabilidad->Actualizar_tbmiscontactos_IdCliProv_IdContacto($nuevoIdCliProv,$IdContacto);
                }else{
                    return false;
                }
                //SIN HACER FIN edicion-2
                
            }else{
                $numCuenta=$lngTipo.formatearCodigo($lngCodigo);
                
                //cliente=4300
                $cliProv=4300;

                $varRes=$clsCNUsu->AltaClienteNuevo($nuevoIdCliProv,$strNomEmpresa,$strCIF,"",$lngCP,$strDireccion,
                                       $strMunicipio,$strProvincia,$strEmail,$strTelefono,
                                       $strMovil,"",formatearCodigo($lngCodigo),$numCuenta,$numEmpresa,$cliProv);
                if($varRes==true){
                    //se ha insertado correctamente en la operacion anterior
                    //actualizo la tabla 'tbmiscontactos' de la BBDD cliente
                    return $clsCADContabilidad->Actualizar_tbmiscontactos_IdCliProv_IdContacto($nuevoIdCliProv,$IdContacto);
                }else{
                    return false;
                }
            }
        }else{
            //existe
            //inserto en la tabla 'tbrelacioncliprov' de la BBDD contabilidad 
            //recojo su IdCliProv y lo guardo en la tabla 'tbmiscontactos' de la BBDD cliente
            //guardo la cuenta en 'tbcuenta' de la BBDD cliente
            //la relacion de este cliente con su cuenta (entre 'tbcliprov' y 'tbuenta')
            //(llamo a la funcion $clsCNUsu->AltaClienteNuevo()
            $numCuenta=$lngTipo.formatearCodigo($lngCodigo);
            $numEmpresa=$_SESSION["idEmp"];
            //0-cliente
            $cliProv=0;
            
            $varRes=$clsCADContabilidad->AltaClienteExistente($IdCliProv,$strNomEmpresa,$strCIF,$lngCP,$strDireccion,
                                   $strMunicipio,$strProvincia,$strEmail,$strTelefono,
                                   formatearCodigo($lngCodigo),$numCuenta,$numEmpresa,$cliProv);
            
            if($varRes==true){
                //se ha insertado correctamente en la operacion anterior
                //actualizo la tabla 'tbmiscontactos' de la BBDD cliente
                return $clsCADContabilidad->Actualizar_tbmiscontactos_IdCliProv_IdContacto($IdCliProv,$IdContacto);
            }else{
                return false;
            }
        }
    }

    function contactoBorrar($id){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->contactoBorrar($id)");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        return $clsCADContabilidad->contactoBorrar($id);
    }
    
    function listadoContactos(){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->listadoContactos()");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        return $clsCADContabilidad->listadoContactos();
    }
    
    function listadoClientes(){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->listadoClientes()");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        return $clsCADContabilidad->listadoClientes();
    }
    
    function AltaPresupuesto($usuario,$post,$AltaEdicion){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->AltaPresupuesto()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->AltaPresupuesto($usuario,$post,$AltaEdicion);
    }
    
    function AltaFactura($usuario,$post){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->AltaFactura()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->AltaFactura($usuario,$post);
    }
    
    function AltaPedido($usuario,$post){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->AltaPedido()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->AltaPedido($usuario,$post);
    }
    
    function EditarPresupuesto($usuario,$post){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->EditarPresupuesto()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        //ahora damos de alta el nuevo presupuesto
        $varRes=$this->AltaPresupuesto($usuario, $post,'Edicion');
            
        if($varRes !== 'false'){
            $this->DarAltaBajaPresupuesto($post['IdPresupuesto'], 'baja');
            return $varRes;
        }else{
            return false;
        }
    }
    
    function EditarFactura($usuario,$post){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->EditarFactura()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        //ahora editamos la factura
        $varRes=$clsCADContabilidad->EditarFactura($usuario, $post);
            
        if($varRes === 'false' || $varRes === false){
            return 'false';
        }else{
            $this->DarAltaBajaFactura($post['IdFactura'], 'baja');
            return $varRes;
        }
    }
    
    function EditarPedido($usuario,$post){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->EditarPedido()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        //ahora editamos el pedido
        $varRes=$clsCADContabilidad->EditarPedido($usuario, $post);
        
        if($varRes !== 'false'){
            $this->DarAltaBajaPedido($post['IdPedido'], 'baja');
            return $varRes;
        }else{
            return false;
        }
            
//        //primero doy de baja el pedido actual
//        $OK_Baja=$this->DarAltaBajaPedido($post['IdPedido'], 'baja');
//        if($OK_Baja==true){
//            //compruebo que devuelve true, sino es que no se a insertado el pedido nuevo 
//            //y tengo que dar de alta el existente
//        }

        //ahora compruebo que las dos comprobaciones son true (se a hecho correctamente)
//        if($varRes<>'false' && $OK_Baja==true){
//            return $varRes;
//        }else{
//            return false;
//        }
    }
    
    function ListadoPresupuestos($strNomContacto,$estado){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->ListadoPresupuestos()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        $clsCADContabilidad->setStrBDCliente($this->getStrBDCliente());
        
        return $clsCADContabilidad->ListadoPresupuestos($strNomContacto,$estado);
    }
    
    function ListadoFacturas($strNomContacto,$estado,$ejercicio){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->ListadoFacturas()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        $clsCADContabilidad->setStrBDCliente($this->getStrBDCliente());
        
        return $clsCADContabilidad->ListadoFacturas($strNomContacto,$estado,$ejercicio);
    }
    
    function ListadoFacturasDetalleIVA($get){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->ListadoFacturasDetalleIVA()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        $clsCADContabilidad->setStrBDCliente($this->getStrBDCliente());
        
        return $clsCADContabilidad->ListadoFacturasDetalleIVA($get);
    }
    
    function ListadoFacturasRectificativas($strNomContacto,$estado,$ejercicio){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->ListadoFacturasRectificativas()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        $clsCADContabilidad->setStrBDCliente($this->getStrBDCliente());
        
        $listadoFacturas = $clsCADContabilidad->ListadoFacturas($strNomContacto,$estado,$ejercicio);
        
        //var_dump($listadoFacturas);die;
        
        //preparo el array de las facturas (no rectificativas) y que no esten abonadas
        $listadoFacturasFinal = '';
        $listadoFacturasQueTienenAbono = '';
        for ($i = 0; $i < count($listadoFacturas); $i++) {
            //lleno e array con las facturas que no tenga letra (con letra son facturas rectificativas)
            if(is_numeric($listadoFacturas[$i]['NumFactura'])){
                $listadoFacturasFinal[] = $listadoFacturas[$i];
            }else{
                //estas son las facturas rectificativas, lleno un array auxiliar con el campo "esAbono"
                $listadoFacturasQueTienenAbono[] = $listadoFacturas[$i]['esAbono'];
            }
        }
        
        
        for ($i = 0; $i < count($listadoFacturasQueTienenAbono); $i++) {
            for ($j = 0; $j < count($listadoFacturasFinal); $j++) {
                if($listadoFacturasQueTienenAbono[$i] === $listadoFacturasFinal[$j]['NumFactura']){
                    //quito esta factura, porque ya está abonada
                    unset($listadoFacturasFinal[$j]);
                    $listadoFacturasFinal = array_values($listadoFacturasFinal);
                    break;
                }
            }
        }
        $listado = array_values($listadoFacturasFinal);
        
        //var_dump($listadoFacturasFinal);die;

        return $listado;
    }
    
    function ListadoPedidos($strNomContacto,$estado){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->ListadoPedidos()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        $clsCADContabilidad->setStrBDCliente($this->getStrBDCliente());
        
        return $clsCADContabilidad->ListadoPedidos($strNomContacto,$estado);
    }
    
    function ListadoPedidosAFacturar($strNomContacto,$estado,$filtroFecha){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->ListadoPedidosAFacturar()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        $clsCADContabilidad->setStrBDCliente($this->getStrBDCliente());
        
        $listado = $clsCADContabilidad->ListadoPedidosAFacturar($strNomContacto,$estado,$filtroFecha);
        
        //ordenar este listado por fecha
        return $clsCADContabilidad->orderMultiDimensionalArray($listado, 'FechaProximaFacturaPeriodicaOrd', false);
    }
    
    function ListadoFacturasACobrar(){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->ListadoFacturasACobrar()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        $clsCADContabilidad->setStrBDCliente($this->getStrBDCliente());
        
        //extraigo el listado de facturas
        $listadoFacturas=$clsCADContabilidad->ListadoFacturas('','');

        //ahora filtro este listado por los siguientes campos:
        //Estado (Emitida=SI, Anulada=NO y Contabilizada=SI)
        //Situacion (En Plazo=SI, Vencida=SI, Cobro Pacial=SI y Cobrada=NO)
        //ahora las filtro para que solo salgan 'Estado=Emitidas'
        $listadoFacturasSinCobrar = '';
        foreach($listadoFacturas as $propiedad=>$valor){
            $ok = true;
            if(($valor['Estado']==='Anulada') || ($valor['Situacion']==='Cobrada')){
                $ok = false;
            }
            
            //si ok = true incluimos este registro en el array, cumple los filtros
            if($ok === true){
                //antes de incluir este registro vamos a añadirle datos de la
                //tabla tbmisfacturas_cobros, donde nos dira si a cobrado algo o no
                $cantidadCobradaFactura = $clsCADContabilidad->cobrosFactura($valor['IdFactura']);
                
                //ahora resto esta cantidad con $valor[totalImporte]
                $pendienteCobro = round($valor['totalImporte'] - (float)$cantidadCobradaFactura,2);
                //y lo añado al registro
                $valor['pendiente'] = $pendienteCobro;
                
                //si $pendienteCobro = 0, es que ya esta cobrada, entonces cambiamos su Situación y no se incluye
                //en el array final
                if($pendienteCobro === (float)0){
                    $this->ActualizarSituacionFactura($valor['IdFactura'],'Cobrada');
                }else{
                    //sino, si lo añadimos al array final
                    $listadoFacturasSinCobrar[] = $valor;
                }
            }
        }
        
        foreach ($listadoFacturasSinCobrar as $key => $row) {
            $aux[$key] = $row['NumFactura'];
        }
        
        array_multisort($aux, SORT_ASC, $listadoFacturasSinCobrar);
        
        return $listadoFacturasSinCobrar;
    }
    
    function ActualizarSituacionFactura($IdFactura,$situacion){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->ActualizarSituacionFactura()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->ActualizarSituacionFactura($IdFactura,$situacion);
    }
    
    function ListadoFacturasAContabilizar($datFechaInicio,$datFechaFin,$lngPeriodo,$strNFacturaIni,$strNFacturaFin){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->ListadoFacturasAContabilizar()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        $clsCADContabilidad->setStrBDCliente($this->getStrBDCliente());
        
        //ejercicio
        $ejercicio = date('Y');
        if(isset($datFechaInicio) && $datFechaInicio !== ''){
            $ejercicio = explode('/',$datFechaInicio);
            $ejercicio = $ejercicio[2];
        }
        
        //extraigo el listado de facturas
        $listadoFacturas=$clsCADContabilidad->ListadoFacturas('','',$ejercicio);
        
        //ahora las filtro para que solo salgan 'Estado=Emitidas'
        $listadoFacturasEmitidas='';
        foreach($listadoFacturas as $propiedad=>$valor){
            if($valor['Estado']==='Emitida'){
                $ok=true;
                //ahora veo los otros filtros de seleccion
                if($datFechaInicio<>''){
                    //como es fecha de inicio restamos a la fecha de la factura la fecha de inicio
                    //si es positivo (la fecha de la factura es igual o superior si entra en el filtro, sino no
                    $difFecha=strtotime(fecha_to_DATETIME($valor['FechaFactura']))- strtotime(fecha_to_DATETIME($datFechaInicio));
                    if($difFecha<0){
                        $ok=false;
                    }
                }
                
                if($datFechaFin<>''){
                    //como es fecha de fin restamos esta fecha con la de la factura
                    //si es positivo (la fecha de la factura es igual o inferior si entra en el filtro, sino no
                    $difFecha=strtotime(fecha_to_DATETIME($datFechaFin)) - strtotime(fecha_to_DATETIME($valor['FechaFactura'])) ;
                    if($difFecha<0){
                        $ok=false;
                    }
                }
                
                if($lngPeriodo<>''){
                    //viene por numeros (1=Enero, 2=Febrero y asi)
                    //asignamos una fecha de inicio y fin de cada mes del ejercicio actual
                    switch ($lngPeriodo) {
                        case 1:
                            $datPeriodoInicio=date('Y').'-01-01 00:00:00';
                            $datPeriodoFin=date('Y').'-01-31 23:59:59';
                            break;
                        case 2:
                            $datPeriodoInicio=date('Y').'-02-01 00:00:00';
                            //compruebo si es ejercicio actual es bisiesto
                            $resto=date('Y')%4;
                            if($resto==0){
                                $datPeriodoFin=date('Y').'-02-29 23:59:59';
                            }else{
                                $datPeriodoFin=date('Y').'-02-28 23:59:59';
                            }
                            break;
                        case 3:
                            $datPeriodoInicio=date('Y').'-03-01 00:00:00';
                            $datPeriodoFin=date('Y').'-03-31 23:59:59';
                            break;
                        case 4:
                            $datPeriodoInicio=date('Y').'-04-01 00:00:00';
                            $datPeriodoFin=date('Y').'-04-30 23:59:59';
                            break;
                        case 5:
                            $datPeriodoInicio=date('Y').'-05-01 00:00:00';
                            $datPeriodoFin=date('Y').'-05-31 23:59:59';
                            break;
                        case 6:
                            $datPeriodoInicio=date('Y').'-06-01 00:00:00';
                            $datPeriodoFin=date('Y').'-06-30 23:59:59';
                            break;
                        case 7:
                            $datPeriodoInicio=date('Y').'-07-01 00:00:00';
                            $datPeriodoFin=date('Y').'-07-31 23:59:59';
                            break;
                        case 8:
                            $datPeriodoInicio=date('Y').'-08-01 00:00:00';
                            $datPeriodoFin=date('Y').'-08-31 23:59:59';
                            break;
                        case 9:
                            $datPeriodoInicio=date('Y').'-09-01 00:00:00';
                            $datPeriodoFin=date('Y').'-09-30 23:59:59';
                            break;
                        case 10:
                            $datPeriodoInicio=date('Y').'-06-10 00:00:00';
                            $datPeriodoFin=date('Y').'-10-31 23:59:59';
                            break;
                        case 11:
                            $datPeriodoInicio=date('Y').'-11-01 00:00:00';
                            $datPeriodoFin=date('Y').'-11-30 23:59:59';
                            break;
                        case 12:
                            $datPeriodoInicio=date('Y').'-12-01 00:00:00';
                            $datPeriodoFin=date('Y').'-12-31 23:59:59';
                            break;
                    }
                    
                    $difPeriodoIni=strtotime(fecha_to_DATETIME($valor['FechaFactura']))- strtotime($datPeriodoInicio);
                    $difPeriodoFin=strtotime($datPeriodoFin) - strtotime(fecha_to_DATETIME($valor['FechaFactura'])) ;
                    
                    if($difPeriodoIni<0 || $difPeriodoFin<0){
                        $ok=false;
                    }
                }

                if($strNFacturaIni<>'' || $strNFacturaFin<>''){
                    $tipoContador=$this->Parametro_general('Tipo Contador',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));
                }
                    
                if($strNFacturaIni<>''){
                    //Factura inicial
                    //la convierto a 20140003 y asi poder restar o sumar con las que cumplan este filtro

                    //ahora segun el tipo de contador presento el numero del presupuesto
                    $strNFacturaIniFormateado='';
                    switch ($tipoContador) {
                        case 'simple':
                            $strNFacturaIniFormateado=$strNFacturaIni;
                            break;
                        case 'compuesto1':
                            $convt=explode('/',$strNFacturaIni);
                            $numero4cifras=$convt[0];
                            while(strlen($numero4cifras)<4){
                                $numero4cifras='0'.$numero4cifras;
                            }
                            $strNFacturaIniFormateado=$convt[1].$numero4cifras;
                            break;
                        case 'compuesto2':
                            $convt=explode('/',$strNFacturaIni);
                            $numero4cifras=$convt[1];
                            while(strlen($numero4cifras)<4){
                                $numero4cifras='0'.$numero4cifras;
                            }
                            $strNFacturaIniFormateado=$convt[0].$numero4cifras;
                            break;
                        default://ningun contador
                            $strNFacturaIniFormateado=$strNFacturaIni;
                            break;
                    }

                    $difNFIni=$valor['NumFactura'] - $strNFacturaIniFormateado;
                            
                    if($difNFIni<0){
                        $ok=false;
                    }
                }
                
                if($strNFacturaFin<>''){
                    $strNFacturaFinFormateado='';
                    switch ($tipoContador) {
                        case 'simple':
                            $strNFacturaFinFormateado=$strNFacturaFin;
                            break;
                        case 'compuesto1':
                            $convt=explode('/',$strNFacturaFin);
                            $numero4cifras=$convt[0];
                            while(strlen($numero4cifras)<4){
                                $numero4cifras='0'.$numero4cifras;
                            }
                            $strNFacturaFinFormateado=$convt[1].$numero4cifras;
                            break;
                        case 'compuesto2':
                            $convt=explode('/',$strNFacturaFin);
                            $numero4cifras=$convt[1];
                            while(strlen($numero4cifras)<4){
                                $numero4cifras='0'.$numero4cifras;
                            }
                            $strNFacturaFinFormateado=$convt[0].$numero4cifras;
                            break;
                        default://ningun contador
                            $strNFacturaFinFormateado=$strNFacturaFin;
                            break;
                    }
                
                    $difNFFin=$strNFacturaFinFormateado - $valor['NumFactura'] ;
                            
                    if($difNFFin<0){
                        $ok=false;
                    }
                }
                
                //si ok=true incluimos este registro en el array, cumple los filtros
                if($ok===true){
                    $listadoFacturasEmitidas[]=$valor;
                }
            }
        }
        
        return $listadoFacturasEmitidas;
    }
    
    function datosPresupuesto($IdPresupuesto){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->datosPresupuesto($IdPresupuesto)>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->datosPresupuesto($IdPresupuesto);
    }
    
    function datosPresupuestoDiferencia($IdPresupuesto){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->datosPresupuestoDiferencia($IdPresupuesto)>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        //extraigo los datos con la funcion 'datosPresupuesto' 
        $resultado=$clsCADContabilidad->datosPresupuesto($IdPresupuesto);
        //como presento la factura que sale de lo que le queda pendiente de facturar,
        //copio CantidadPEN, ImportePEN y CuotaIvaPEN en cantidad, importe y cuota en $resultadoFinal 
        foreach($resultado['DetallePresupuesto'] as $propiedad=>$datosLinea){
            //si ImportePEN es 0, quitamos esta linea
            if($datosLinea['ImportePEN']==='0'){
                unset($resultado['DetallePresupuesto'][$propiedad]);
            }else{
                //sino hago la copia
                $resultado['DetallePresupuesto'][$propiedad]['cantidad']=$datosLinea['CantidadPEN'];
                $resultado['DetallePresupuesto'][$propiedad]['importe']=$datosLinea['ImportePEN'];
                $resultado['DetallePresupuesto'][$propiedad]['cuota']=$datosLinea['CuotaIvaPEN'];
            }
        }
        
        //por ultimo renumeramos $resultado['DetallePresupuesto']
        $resultadoFinal=$resultado;
        unset($resultadoFinal['DetallePresupuesto']);
        foreach($resultado['DetallePresupuesto'] as $propiedad=>$datosLinea){
            $resultadoFinal['DetallePresupuesto'][]=$datosLinea;
        }
        return $resultadoFinal;
    }
    
    function datosFactura($IdFactura){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->datosFactura($IdFactura)>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->datosFactura($IdFactura);
    }
    
    function datosPedido($IdPedido){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->datosPedido($IdPedido)>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->datosPedido($IdPedido);
    }
    
    function datosDuplicarPresupuesto($IdPresupuesto,$numeroNuevoPresupuesto){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->datosDuplicarPresupuesto($IdPresupuesto,$numeroNuevoPresupuesto)>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->datosDuplicarPresupuesto($IdPresupuesto,$numeroNuevoPresupuesto);
    }
    
    function datosDuplicarFactura($IdFactura,$numeroNuevaFactura){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->datosDuplicarFactura($IdFactura,$numeroNuevaFactura)>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->datosDuplicarFactura($IdFactura,$numeroNuevaFactura);
    }
    
    function datosDuplicarFacturaRectificativa($IdFactura,$numeroNuevaFactura){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->datosDuplicarFacturaRectificativa($IdFactura,$numeroNuevaFactura)>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->datosDuplicarFacturaRectificativa($IdFactura,$numeroNuevaFactura);
    }
    
    function datosDuplicarPedido($IdPedido,$numeroNuevoPedido){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->datosDuplicarPedido($IdPedido,$numeroNuevoPedido)>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->datosDuplicarPedido($IdPedido,$numeroNuevoPedido);
    }
    
    function datosNuestraEmpresaPresupuesto(){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->datosNuestraEmpresaPresupuesto()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->datosNuestraEmpresaPresupuesto();
    }
    
//    function datosNuestraEmpresaPedido(){
//        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
//               " clsCNContabilidad->datosNuestraEmpresaPedido()>");
//        require_once '../CAD/clsCADContabilidad.php';
//        $clsCADContabilidad=new clsCADContabilidad();
//        $clsCADContabilidad->setStrBD($this->getStrBD());
//        
//        return $clsCADContabilidad->datosNuestraEmpresaPedido();
//    }
    
    function datosPresupuestoImprimir($IdPresupuesto){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->datosPresupuestoImprimir($IdPresupuesto)>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->datosPresupuestoImprimir($IdPresupuesto);
    }
    
    function ParametrosGenerales_email(){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->ParametrosGenerales_email()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->ParametrosGenerales_email();
    }
    
    function FechaAltaEmpresa(){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->FechaAltaEmpresa()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->FechaAltaEmpresa();
    }
    
    function NumeroNuevoPresupuesto(){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->NumeroNuevoPresupuesto()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBDCliente());
        
        //primero busco la variable de 'Tipo de Contador' de la tabla 'tbparametros_generales'
        $tipoContador=$clsCADContabilidad->Parametro_general('Tipo Contador',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));
        
        //ahora segun el tipo de contador calculo en nuevo numero
        $numeroNuevoPresupuesto='';
        switch ($tipoContador) {
            case 'simple':
                $numeroNuevoPresupuesto=$clsCADContabilidad->Contador_Simple_NuevoNumero('NumPresupuesto','tbmispresupuestos');
                break;
            case 'compuesto1':
                $numeroNuevoPresupuesto=$clsCADContabilidad->Contador_Compuesto1_NuevoNumero('NumPresupuesto','tbmispresupuestos');
                break;
            case 'compuesto2':
                $numeroNuevoPresupuesto=$clsCADContabilidad->Contador_Compuesto2_NuevoNumero('NumPresupuesto','tbmispresupuestos');
                break;
            default://ningun contador
                break;
        }
        
        return $numeroNuevoPresupuesto;
    }
    
    function NumeroNuevaFactura(){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->NumeroNuevaFactura()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBDCliente());
        
        //primero busco la variable de 'Tipo de Contador' de la tabla 'tbparametros_generales'
        $tipoContador=$clsCADContabilidad->Parametro_general('Tipo Contador',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));
        
        //ahora segun el tipo de contador calculo en nuevo numero
        $NumeroNuevaFactura='';
        switch ($tipoContador) {
            case 'simple':
                $NumeroNuevaFactura = $clsCADContabilidad->Contador_Simple_NuevoNumero2('NumFactura','tbmisfacturas');
                break;
            case 'compuesto1':
                $NumeroNuevaFactura=$clsCADContabilidad->Contador_Compuesto1_NuevoNumero2('NumFactura','tbmisfacturas');
                break;
            case 'compuesto2':
                //HABRA QUE REVISAR POR LAS FACTURAS CON LETRAS (ABONOS) 1/4/2016
                $NumeroNuevaFactura=$clsCADContabilidad->Contador_Compuesto2_NuevoNumero('NumFactura','tbmisfacturas');
                break;
            default://ningun contador
                break;
        }
        
        return $NumeroNuevaFactura;
    }
    
    function NumeroNuevaFacturaRectificativa(){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->NumeroNuevaFacturaRectificativa()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBDCliente());
        
        //primero busco la variable de 'Tipo de Contador' de la tabla 'tbparametros_generales'
        $tipoContador=$clsCADContabilidad->Parametro_general('Tipo Contador',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));
        
        //ahora segun el tipo de contador calculo en nuevo numero
        $NumeroNuevaFactura='';
        switch ($tipoContador) {
            case 'simple':
                $NumeroNuevaFactura = $clsCADContabilidad->Contador_Simple_NuevoNumeroRectificativa('NumFactura','tbmisfacturas');
                break;
            case 'compuesto1':
                $NumeroNuevaFactura=$clsCADContabilidad->Contador_Compuesto1_NuevoNumeroRectificativa('NumFactura','tbmisfacturas');
                break;
            case 'compuesto2':
                //HABRA QUE REVISAR POR LAS FACTURAS CON LETRAS (ABONOS) 1/4/2016
                $NumeroNuevaFactura=$clsCADContabilidad->Contador_Compuesto2_NuevoNumero('NumFactura','tbmisfacturas');
                break;
            default://ningun contador
                break;
        }
        
        return $NumeroNuevaFactura;
    }
    
    function NumeroNuevoPedido(){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->NumeroNuevoPedido()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBDCliente());
        
        //primero busco la variable de 'Tipo de Contador' de la tabla 'tbparametros_generales'
        $tipoContador=$clsCADContabilidad->Parametro_general('Tipo Contador',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));
        
        //ahora segun el tipo de contador calculo en nuevo numero
        $NumeroNuevoPedido='';
        switch ($tipoContador) {
            case 'simple':
                $NumeroNuevoPedido=$clsCADContabilidad->Contador_Simple_NuevoNumero('NumPedido','tbmispedidos');
                break;
            case 'compuesto1':
                $NumeroNuevoPedido=$clsCADContabilidad->Contador_Compuesto1_NuevoNumero('NumPedido','tbmispedidos');
                break;
            case 'compuesto2':
                $NumeroNuevoPedido=$clsCADContabilidad->Contador_Compuesto2_NuevoNumero('NumPedido','tbmispedidos');
                break;
            default://ningun contador
                break;
        }
        
        return $NumeroNuevoPedido;
    }
    
    function Parametro_general($parametroBuscar,$fechaInicio,$fechaFin){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->Parametro_general($parametroBuscar,$fechaInicio,$fechaFin)>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->Parametro_general($parametroBuscar,$fechaInicio,$fechaFin);
    }
    
    function Actualizar_tbmispresupuestos_Contacto_Cliente($contacto,$numCuenta){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->Actualizar_tbmispresupuestos_Contacto_Cliente($contacto,$numCuenta)>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->Actualizar_tbmispresupuestos_Contacto_Cliente($contacto,$numCuenta);
    }
    
    function DatosEmpresa(){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->DatosEmpresa()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->DatosEmpresa();
    }
    
    function DatosEmpresa_tbempresas($idEmp){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->DatosEmpresa_tbempresas()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->DatosEmpresa_tbempresas($idEmp);
    }
    
    function guardarParametros_generales($post){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->guardarParametros_generales()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->guardarParametros_generales($post);
    }
    
    function Actualizar_tbempresas($post){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->Actualizar_tbempresas()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->Actualizar_tbempresas($post);
    }
    
    function Actualizar_Logo_tbparametros_generales($doc){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->Actualizar_Logo_tbparametros_generales($doc)>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->Actualizar_Logo_tbparametros_generales($doc);
    }
    
    function generarFacturaDePresupuesto($usuario,$post){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->generarFacturaDePresupuesto()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->generarFacturaDePresupuesto($usuario,$post);
    }
    
    function generarPedidoDePresupuesto($usuario,$post){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->generarPedidoDePresupuesto()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->generarPedidoDePresupuesto($usuario,$post);
    }
    
    function ListadoPresupuestosPendientesFacturar($strNomContacto,$estado){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->ListadoPresupuestosPendientesFacturar($strNomContacto,$estado)>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->ListadoPresupuestosPendientesFacturar($strNomContacto,$estado);
    }
    
    function listadoFacturasEmitidas($IdPresupuesto){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->listadoFacturasEmitidas($IdPresupuesto)>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->listadoFacturasEmitidas($IdPresupuesto);
    }
    
    function listadoPedidosEmitidos($IdPresupuesto){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->listadoPedidosEmitidos($IdPresupuesto)>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->listadoPedidosEmitidos($IdPresupuesto);
    }
    
    function comprobarSiEstaInsertadoAsiento($IdFactura){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->comprobarSiEstaInsertadoAsiento($IdFactura)>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->comprobarSiEstaInsertadoAsiento($IdFactura);
    }
    
    function actualizarAsientoEnFactura($IdFactura,$asiento){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->actualizarAsientoEnFactura($IdFactura,$asiento)>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->actualizarAsientoEnFactura($IdFactura,$asiento);
    }
    
    function contabilizarAsiento($IdFactura,$datosFactura){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->contabilizarAsiento()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        
        //ahora preparo los datos necesarios para insertar el asiento
        //1- sumamos el importe, el iva, distinguiendo el tipo de iva en este caso y total
        $importes = '';
        for ($i = 0; $i < 30; $i++) {
            $importes[$i] = 0;
        }
        $cuotas = '';
        for ($i = 0; $i < 30; $i++) {
            $cuotas[$i] = 0;
        }
        

        $ivas = '';
        for ($i = 0; $i < 30; $i++) {
            $ivas[$i] = 'NO';
        }

        foreach($datosFactura['DetalleFactura'] as $prop2=>$valor2){
            //sumamos el importe
            $importe=$importe+$valor2['importe'];
            //sumamos los ivas y cambiamos a SI
            
            $importes[$valor2['iva']] = $importes[$valor2['iva']]+$valor2['importe'];
            $cuotas[$valor2['iva']] = $cuotas[$valor2['iva']]+$valor2['cuota'];
            $cuota = $cuota + $valor2['cuota'];
            
            $ivas[$valor2['iva']]='SI';
        }
        
        //$cuota=$cuota4+$cuota10+$cuota21;
        $total=$importe+$cuota;

        //ahora segun vengan los datos vemos la opción de inserción en las tablas 'tbmovimientos' y 'tbmovimientos_iva'

        //1º - Averiguamos si tiene un solo IVA o varios
        //cuento en el array $ivas los SI que hay, si hay uno es un solo iva y si hay mas de 1 son varios
        $tiposIVA='UNO';
        $contarIVA=0;
        foreach($ivas as $tipoIVA=>$valorTipoIVA){
            if($valorTipoIVA==='SI'){
                $contarIVA=$contarIVA+1;
                //indico el iva único que es
                $IVAunico=$tipoIVA;
            }
        }
        if($contarIVA>1){
            $tiposIVA='VARIOS';
        }

        //2º - Ahora averiguamos si tiene IRPF o no
        //viene el campo $datosFactura['Retencion'] el % retenido, si es 0 no hay retencion y si es >0 si hay
        $hayRetencion='NO';
        if($datosFactura['Retencion']<>'0'){
            $hayRetencion='SI';
        }

        //3º Preparo un array con las cuentas de ventas, su cantidad y su cuota IVA
        $cuentaVentas = "";
        // primero inserto las cuentas en el array
        for ($i = 0; $i < count($datosFactura['DetalleFactura']); $i++) {
            //busco si existe esta cuenta en el array
            if(is_array($cuentaVentas)){
                //compruebo si la cuenta e iva existe
                $encontrado = 'NO';
                for ($ii = 0; $ii < count($cuentaVentas); $ii++) {
                    if($cuentaVentas[$ii]['cuenta'] === $datosFactura['DetalleFactura'][$i]['cuentaArticulo']
                        && $cuentaVentas[$ii]['iva'] === $datosFactura['DetalleFactura'][$i]['iva']){
                        //la cuenta existe en $cuentaVentas, devuelvo la posicion en el array
                        $encontrado = $ii;
                        break;
                    }
                }
                
                //ahora compruebo si la ha encontrado o no
                if($encontrado === 'NO'){
                    //inserto un nuevo valor al array
                    $ventas['cuenta'] = $datosFactura['DetalleFactura'][$i]['cuentaArticulo'];
                    $ventas['iva'] = $datosFactura['DetalleFactura'][$i]['iva'];
                    $ventas['importe'] = (float)$datosFactura['DetalleFactura'][$i]['importe'];
                    $ventas['cuota'] = (float)$datosFactura['DetalleFactura'][$i]['cuota'];
                    $cuentaVentas[] = $ventas;
                }else{
                    //si lo a encontrado, entonces sumo en cantidad la nueva cantidad
                    $cuentaVentas[$encontrado]['importe'] = (float)$cuentaVentas[$encontrado]['importe']+(float)$datosFactura['DetalleFactura'][$i]['importe'];
                    //y en cuota sumo la nueva cuota
                    $cuentaVentas[$encontrado]['cuota'] = (float)$cuentaVentas[$encontrado]['cuota']+(float)$datosFactura['DetalleFactura'][$i]['cuota'];
                }
            }else{
                //no se ha introducido todavia ningun dato a $cuentaVentas
                $ventas['cuenta'] = $datosFactura['DetalleFactura'][$i]['cuentaArticulo'];
                $ventas['iva'] = $datosFactura['DetalleFactura'][$i]['iva'];
                $ventas['importe'] = (float)$datosFactura['DetalleFactura'][$i]['importe'];
                $ventas['cuota'] = (float)$datosFactura['DetalleFactura'][$i]['cuota'];
                $cuentaVentas[] = $ventas;
            }
        }
        
        //ahora pongo los valores absolutos (sin negativo)
        //controlo el numero de cuentas de ventas (UNA o VARIAS)
        $numeroCuentas = 'UNA';
        $numCuentaAux = 0;
        for ($i = 0; $i < count($cuentaVentas); $i++) {
            $cuentaVentas[$i]['importe'] = abs($cuentaVentas[$i]['importe']);
            $cuentaVentas[$i]['cuota'] = abs($cuentaVentas[$i]['cuota']);
            //voy comparando la posicion actual con la anterior y si son iguales son VARIAS, sino es UNA
            //una vez que el dato es VARIAS esta comparacion ya no es relevante
            if($i > 0 && $cuentaVentas[$i-1]['cuenta'] !== $cuentaVentas[$i]['cuenta']){
                $numeroCuentas = 'VARIAS';
            }
        }
        
        
//        //tipo de cuenta
//        $numeroCuentas = 'UNA';
//        if(count($cuentaVentas)>1){
//            $numeroCuentas = 'VARIAS';
//        }
        
        
        //ahora segun las combinaciones de estas tres variables (IVA, IRPF y cuentas)
        // salen los tipos de asientos
        // 
        //Ingreso 1 IVA - Sin IRPF
        $datosAInsertar = '';
        if($tiposIVA==='UNO' && $hayRetencion==='NO'){
            // tipo Asiento '11N'
            
            //preparo los datos a introducir en la funcion
            //$strCuenta='700000000';//cuenta general de ventas
            $strCuenta = $cuentaVentas[0]['cuenta'];
            //veo si el total es negativo, si es asi es abono
            if($total < 0){
                $esAbono = 'SI';
                $lngIngreso = -$total;
                $lngCantidad = -$importe;
                $lngIva = -$cuota;
                $strConcepto = 'Factura Rectificativa '.$datosFactura['NumFactura'];
            }else{
                $esAbono='NO';
                $lngIngreso=$total;
                $lngCantidad=$importe;
                $lngIva=$cuota;
                $strConcepto='Factura '.$datosFactura['NumFactura'];
            }
            
            $strCuentaCli=$datosFactura['Cliente'];
            $lngPorciento=$IVAunico;
            $FechaFactura=explode('/',$datosFactura['FechaFactura']);
            $datFecha=$FechaFactura[2].'/'.$FechaFactura[1].'/'.$FechaFactura[0];
            $optTipo=0;
            $strCuentaBancos='';
            while(substr($FechaFactura[1],0,1)==='0'){
                $FechaFactura[1]=substr($FechaFactura[1],1);
            }
            $strPeriodo=$FechaFactura[1];
            $lngEjercicio=$FechaFactura[0];
            $strUsuario=$_SESSION["strUsuario"];
            
            //11N - Ingreso 1 IVA - Sin IRPF - 1 Cuenta
            if($numeroCuentas === 'UNA'){
//                //insertamos la factura en el asiento
//                $asiento=$this->AltaIngresosMovimientos(0, $_SESSION["idEmp"], $strCuenta, $lngIngreso, $strCuentaCli, $lngCantidad,
//                        $lngIva, $lngPorciento, $datFecha, $optTipo, $strCuentaBancos, $strPeriodo, $lngEjercicio, $strConcepto, $esAbono, $strUsuario);

                $asiento=$this->AltaIngresosMovimientos_VariasCuentas(0, $_SESSION["idEmp"], $cuentaVentas, $lngIngreso, $strCuentaCli, $lngCantidad,
                        $lngIva, $lngPorciento, $datFecha, $optTipo, $strCuentaBancos, $strPeriodo, $lngEjercicio, $strConcepto, $esAbono, $strUsuario);
                
                
                //una vez insertado, actualizamos la tabla 'tbmisfacturas' con el numero de asiento
                $OK_Contabilizado=$this->actualizarAsientoEnFactura($IdFactura,$asiento);
            }else
            //15N - Ingreso 1 IVA - Sin IRPF - VARIAS Cuenta
            if($numeroCuentas === 'VARIAS'){
                //insertamos la factura en el asiento
                $asiento=$this->AltaIngresosMovimientos_VariasCuentas(0, $_SESSION["idEmp"], $cuentaVentas, $lngIngreso, $strCuentaCli, $lngCantidad,
                        $lngIva, $lngPorciento, $datFecha, $optTipo, $strCuentaBancos, $strPeriodo, $lngEjercicio, $strConcepto, $esAbono, $strUsuario);

                
                //una vez insertado, actualizamos la tabla 'tbmisfacturas' con el numero de asiento
                $OK_Contabilizado=$this->actualizarAsientoEnFactura($IdFactura,$asiento);
            }
        }else
        //Ingreso 1 IVA y con IRPF
        if($tiposIVA==='UNO' && $hayRetencion==='SI'){
            $tipoAsiento='12N';

            //preparo los datos a introducir en la funcion
            //$strCuenta='700000000';//cuenta general de ventas
            $strCuenta = $cuentaVentas[0]['cuenta'];
            $strCuentaCli = $datosFactura['Cliente'];
            
            //veo si el total es negativo, si es asi es abono
            if($importe < 0){
                $esAbono = 'SI';
                $lngCantidad = -$importe;
                $lngIva = -$cuota;
                $lngIRPF = -round($datosFactura['Retencion']*$importe/100,2);
                $strConcepto = 'Factura Rectificativa '.$datosFactura['NumFactura'];
            }else{
                $esAbono = 'NO';
                $lngCantidad = $importe;
                $lngIva = $cuota;
                $lngIRPF = round($datosFactura['Retencion']*$importe/100,2);
                $strConcepto = 'Factura '.$datosFactura['NumFactura'];
            }
            
            $lngPorciento=$IVAunico;
            $lngPorcientoIRPF=$datosFactura['Retencion'];
            $FechaFactura=explode('/',$datosFactura['FechaFactura']);
            $datFecha=$FechaFactura[2].'/'.$FechaFactura[1].'/'.$FechaFactura[0];
            $optTipo=0;
            $strCuentaBancos='';
            while(substr($FechaFactura[1],0,1)==='0'){
                $FechaFactura[1]=substr($FechaFactura[1],1);
            }
            $lngPeriodo=$FechaFactura[1];
            switch ($lngPeriodo) {
                case '1':
                    $strPeriodo='ENERO';
                    break;
                case '2':
                    $strPeriodo='FEBRERO';
                    break;
                case '3':
                    $strPeriodo='MARZO';
                    break;
                case '4':
                    $strPeriodo='ABRIL';
                    break;
                case '5':
                    $strPeriodo='MAYO';
                    break;
                case '6':
                    $strPeriodo='JUNIO';
                    break;
                case '7':
                    $strPeriodo='JULIO';
                    break;
                case '8':
                    $strPeriodo='AGOSTO';
                    break;
                case '9':
                    $strPeriodo='SEPTIEMBRE';
                    break;
                case '10':
                    $strPeriodo='OCTUBRE';
                    break;
                case '11':
                    $strPeriodo='NOVIEMBRE';
                    break;
                case '12':
                    $strPeriodo='DICIEMBRE';
                    break;
            }
            $lngEjercicio=$FechaFactura[0];
            $strUsuario=$_SESSION["strUsuario"];

            //12N - Ingreso 1 IVA - Con IRPF - 1 Cuenta
            if($numeroCuentas === 'UNA'){
//                //insertamos la factura en el asiento
//                $asiento=$this->AltaIngresosMovimientosIRPF(0, $_SESSION["idEmp"], $strCuenta, $strCuentaCli, $lngCantidad, $lngIva,
//                        $lngPorciento, $lngIRPF, $lngPorcientoIRPF, $datFecha, $optTipo, $strCuentaBancos, $lngPeriodo, $strPeriodo,
//                        $lngEjercicio, $strConcepto, $esAbono, $strUsuario);
                
                $asiento=$this->AltaIngresosMovimientosIRPF_VariasCuentas(0, $_SESSION["idEmp"], $cuentaVentas, $strCuentaCli, $lngCantidad, $lngIva,
                        $lngPorciento, $lngIRPF, $lngPorcientoIRPF, $datFecha, $optTipo, $strCuentaBancos, $lngPeriodo, $strPeriodo,
                        $lngEjercicio, $strConcepto, $esAbono, $strUsuario);
                
                //una vez insertado, actualizamos la tabla 'tbmisfacturas' con el numero de asiento
                $OK_Contabilizado=$this->actualizarAsientoEnFactura($IdFactura,$asiento);
            }else
            //16N - Ingreso 1 IVA - Con IRPF - VARIAS Cuenta
            if($numeroCuentas === 'VARIAS'){
                //insertamos la factura en el asiento
                $asiento=$this->AltaIngresosMovimientosIRPF_VariasCuentas(0, $_SESSION["idEmp"], $cuentaVentas, $strCuentaCli, $lngCantidad, $lngIva,
                        $lngPorciento, $lngIRPF, $lngPorcientoIRPF, $datFecha, $optTipo, $strCuentaBancos, $lngPeriodo, $strPeriodo,
                        $lngEjercicio, $strConcepto, $esAbono, $strUsuario);
                //una vez insertado, actualizamos la tabla 'tbmisfacturas' con el numero de asiento
                $OK_Contabilizado=$this->actualizarAsientoEnFactura($IdFactura,$asiento);
            }
        }else
        //Ingreso varios IVA y sin IRPF
        if($tiposIVA==='VARIOS' && $hayRetencion==='NO'){
            $tipoAsiento='13N';
            
            //preparo los datos a introducir en la funcion
            //$strCuenta='700000000';//cuenta general de ventas
            $strCuenta=$cuentaVentas[0]['cuenta'];
            $strCuentaCli=$datosFactura['Cliente'];
            
            //veo si el total es negativo, si es asi es abono
            if($total < 0){
                $esAbono = 'SI';
                $lngIngreso = -$total;
                $lngCantidad = -$importe;
                $lngIva = -$cuota;
                $strConcepto = 'Factura Rectificativa '.$datosFactura['NumFactura'];
            }else{
                $esAbono='NO';
                $lngIngreso=$total;
                $lngCantidad=$importe;
                $lngIva=$cuota;
                $strConcepto='Factura '.$datosFactura['NumFactura'];
            }
            
//            $lngIngreso=$total;
//            $lngCantidad=$importe;
//            $lngIva=$cuota;
            $FechaFactura=explode('/',$datosFactura['FechaFactura']);
            $datFecha=$FechaFactura[2].'/'.$FechaFactura[1].'/'.$FechaFactura[0];
            $optTipo=0;
            $strCuentaBancos='';
            while(substr($FechaFactura[1],0,1)==='0'){
                $FechaFactura[1]=substr($FechaFactura[1],1);
            }
            $strPeriodo=$FechaFactura[1];
            $lngEjercicio=$FechaFactura[0];
//            $strConcepto='Factura '.$datosFactura['NumFactura'];
//            $esAbono='NO';
            $strUsuario=$_SESSION["strUsuario"];
            
            $lngCantidad1=$importes[0]; $lngIva1='0'; $lngPorciento1='0';
            $lngCantidad2=$importes[4]; $lngIva2=$cuotas[4]; $lngPorciento2='4';
            $lngCantidad3=$importes[10]; $lngIva3=$cuotas[10]; $lngPorciento3='10';
            $lngCantidad4=$importes[21]; $lngIva4=$cuotas[21]; $lngPorciento4='21';
            
            //13N - Ingreso VARIOS IVA - Sin IRPF - 1 Cuenta
            if($numeroCuentas === 'UNA'){
//                //insertamos la factura en el asiento
//                $asiento=$this->AltaIngresosMovimientosIVA_Varios(0, $_SESSION["idEmp"], $strCuenta, $lngIngreso, $strCuentaCli, $lngCantidad, $lngIva,
//                        $datFecha, $optTipo, $strCuentaBancos, $strPeriodo, $lngEjercicio, $strConcepto, $strUsuario,
//                        $lngCantidad1, $lngIva1, $lngPorciento1,
//                        $lngCantidad2, $lngIva2, $lngPorciento2,
//                        $lngCantidad3, $lngIva3, $lngPorciento3,
//                        $lngCantidad4, $lngIva4, $lngPorciento4, $esAbono);
                
                $asiento=$this->AltaIngresosMovimientosIVA_Varios_VariasCuentas(0, $_SESSION["idEmp"], $cuentaVentas, $lngIngreso, $strCuentaCli, $lngCantidad, $lngIva,
                        $datFecha, $optTipo, $strCuentaBancos, $strPeriodo, $lngEjercicio, $strConcepto, $strUsuario,
                        $lngCantidad1, $lngIva1, $lngPorciento1,
                        $lngCantidad2, $lngIva2, $lngPorciento2,
                        $lngCantidad3, $lngIva3, $lngPorciento3,
                        $lngCantidad4, $lngIva4, $lngPorciento4, $esAbono);
                
                //una vez insertado, actualizamos la tabla 'tbmisfacturas' con el numero de asiento
                $OK_Contabilizado=$this->actualizarAsientoEnFactura($IdFactura,$asiento);
            }else
            //17N - Ingreso VARIOS IVA - Sin IRPF - VARIAS Cuenta
            if($numeroCuentas === 'VARIAS'){
                //insertamos la factura en el asiento
                $asiento=$this->AltaIngresosMovimientosIVA_Varios_VariasCuentas(0, $_SESSION["idEmp"], $cuentaVentas, $lngIngreso, $strCuentaCli, $lngCantidad, $lngIva,
                        $datFecha, $optTipo, $strCuentaBancos, $strPeriodo, $lngEjercicio, $strConcepto, $strUsuario,
                        $lngCantidad1, $lngIva1, $lngPorciento1,
                        $lngCantidad2, $lngIva2, $lngPorciento2,
                        $lngCantidad3, $lngIva3, $lngPorciento3,
                        $lngCantidad4, $lngIva4, $lngPorciento4, $esAbono);
                //una vez insertado, actualizamos la tabla 'tbmisfacturas' con el numero de asiento
                $OK_Contabilizado=$this->actualizarAsientoEnFactura($IdFactura,$asiento);
            }
        }else
        //14N - Ingreso varios IVA y con IRPF
        if($tiposIVA==='VARIOS' && $hayRetencion==='SI'){
            $tipoAsiento='14N';
            
            //preparo los datos a introducir en la funcion
            //$strCuenta='700000000';//cuenta general de ventas
            $strCuenta=$cuentaVentas[0]['cuenta'];
            $strCuentaCli=$datosFactura['Cliente'];
            
            //veo si el total es negativo, si es asi es abono
            if($total < 0){
                $esAbono = 'SI';
                $lngIngreso = -$total;
                $lngCantidad = -$importe;
                $lngIva = -$cuota;
                $strConcepto = 'Factura Rectificativa '.$datosFactura['NumFactura'];
            }else{
                $esAbono='NO';
                $lngIngreso=$total;
                $lngCantidad=$importe;
                $lngIva=$cuota;
                $strConcepto='Factura '.$datosFactura['NumFactura'];
            }
            
//            $lngIngreso=$total;
//            $lngCantidad=$importe;
//            $lngIva=$cuota;
            $FechaFactura=explode('/',$datosFactura['FechaFactura']);
            $datFecha=$FechaFactura[2].'/'.$FechaFactura[1].'/'.$FechaFactura[0];
            $optTipo=0;
            $strCuentaBancos='';
            while(substr($FechaFactura[1],0,1)==='0'){
                $FechaFactura[1]=substr($FechaFactura[1],1);
            }
            $strPeriodo=$FechaFactura[1];
            $lngEjercicio=$FechaFactura[0];
//            $strConcepto='Factura '.$datosFactura['NumFactura'];
//            $esAbono='NO';
            $strUsuario=$_SESSION["strUsuario"];
            
            $lngCantidad1=$importes[0]; $lngIva1='0'; $lngPorciento1='0';
            $lngCantidad2=$importes[4]; $lngIva2=$cuotas[4]; $lngPorciento2='4';
            $lngCantidad3=$importes[10]; $lngIva3=$cuotas[10]; $lngPorciento3='10';
            $lngCantidad4=$importes[21]; $lngIva4=$cuotas[21]; $lngPorciento4='21';
            
            $lngPorcientoIRPF=$datosFactura['Retencion'];
            $lngIRPF=round($datosFactura['Retencion']*$importe/100,2);
            
            //14N - Ingreso VARIOS IVA - Con IRPF - 1 Cuenta
            if($numeroCuentas === 'UNA'){
                //insertamos la factura en el asiento
//                $asiento=$this->AltaIngresosMovimientosIVA_VariosIRPF(0, $_SESSION["idEmp"], $strCuenta, $lngIngreso, $strCuentaCli, $lngCantidad, $lngIva,
//                        $datFecha, $optTipo, $strCuentaBancos, $strPeriodo, $lngEjercicio, $strConcepto, $strUsuario,
//                        $lngCantidad1, $lngIva1, $lngPorciento1,
//                        $lngCantidad2, $lngIva2, $lngPorciento2,
//                        $lngCantidad3, $lngIva3, $lngPorciento3,
//                        $lngCantidad4, $lngIva4, $lngPorciento4,
//                        $esAbono,$lngPorcientoIRPF,$lngIRPF);
                
                $asiento=$this->AltaIngresosMovimientosIVA_VariosIRPF_VariasCuentas(0, $_SESSION["idEmp"], $cuentaVentas, $lngIngreso, $strCuentaCli, $lngCantidad, $lngIva,
                        $datFecha, $optTipo, $strCuentaBancos, $strPeriodo, $lngEjercicio, $strConcepto, $strUsuario,
                        $lngCantidad1, $lngIva1, $lngPorciento1,
                        $lngCantidad2, $lngIva2, $lngPorciento2,
                        $lngCantidad3, $lngIva3, $lngPorciento3,
                        $lngCantidad4, $lngIva4, $lngPorciento4,
                        $esAbono,$lngPorcientoIRPF,$lngIRPF);
                
                //una vez insertado, actualizamos la tabla 'tbmisfacturas' con el numero de asiento
                $OK_Contabilizado=$this->actualizarAsientoEnFactura($IdFactura,$asiento);
            }else
            //18N - Ingreso VARIOS IVA - Con IRPF - VARIAS Cuenta
            if($numeroCuentas === 'VARIAS'){
                //insertamos la factura en el asiento
                $asiento=$this->AltaIngresosMovimientosIVA_VariosIRPF_VariasCuentas(0, $_SESSION["idEmp"], $cuentaVentas, $lngIngreso, $strCuentaCli, $lngCantidad, $lngIva,
                        $datFecha, $optTipo, $strCuentaBancos, $strPeriodo, $lngEjercicio, $strConcepto, $strUsuario,
                        $lngCantidad1, $lngIva1, $lngPorciento1,
                        $lngCantidad2, $lngIva2, $lngPorciento2,
                        $lngCantidad3, $lngIva3, $lngPorciento3,
                        $lngCantidad4, $lngIva4, $lngPorciento4,
                        $esAbono,$lngPorcientoIRPF,$lngIRPF);
                //una vez insertado, actualizamos la tabla 'tbmisfacturas' con el numero de asiento
                $OK_Contabilizado=$this->actualizarAsientoEnFactura($IdFactura,$asiento);
            }
        }


        return $OK_Contabilizado;
    }
    
    
    //BORRAR
    function ExportarAsientoContabil($post){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->ExportarAsientoContabil()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        //extraigo un listado de todos los movimientos filtrados segun las fechas
        $listadoMovimientos=$clsCADContabilidad->listadoMovimientosContabil($post);
        
        //ahora actualizo los datos de la BBDD de access ../MovimientosImpExp/Contabil.Mdb
        //ahora borro los datos e inserto los nuevos en la tabla 'movimientos'
        $listadoResultadosMovimientosContabil=$clsCADContabilidad->ActualizarMovimientosContabil($listadoMovimientos);
        
        if(!$listadoResultadosMovimientosContabil){
            $listadosResultados=array(
                'Exportado'=>'NO',
                'error'=>"No se ha preparado la tabla movimientos<br/>",
            );
        }
        
        //ahora extraigo los movimientos que son de facturas (el campo asiento no esta vacio)
        $listadoMovFacturas='';
        if(is_array($listadoMovimientos)){
            foreach($listadoMovimientos as $movimiento){
                if($movimiento['asientoF']<>''){
                    $listadoMovFacturas[]=$movimiento;
                }
            }
        }

        //ahora borro los datos e inserto los nuevos en la tabla 'movimientosFactura'
        $listadoResultadosMovFacturasContabil=$clsCADContabilidad->ActualizarMovimientosFacturasContabil($listadoMovFacturas);
        
        if(!$listadoResultadosMovFacturasContabil){
            $listadosResultados=array(
                'Exportado'=>'NO',
                'error'=>$listadosResultados['error']."No se ha preparado la tabla movimientosFactura<br/>",
            );
        }

        //extraigo un listado de todos los movimientos_IVA filtrados segun las fechas
        $listadoMovimientosIva=$clsCADContabilidad->listadoMovimientosIvaContabil($post);
        
        //por utlimo borro los datos e inserto los nuevos en la tabla 'movimientosIva'
        $listadoResultadosMovIvaContabil=$clsCADContabilidad->ActualizarMovimientosIvaContabil($listadoMovimientosIva);
        
        if(!$listadoResultadosMovIvaContabil){
            $listadosResultados=array(
                'Exportado'=>'NO',
                'error'=>$listadosResultados['error']."No se ha preparado la tabla movimientosIva<br/>Los datos seleccionados ya estan Exportados anteriormente.",
            );
        }
        
        //por ultimo actualizo los datos del campo 'Exportado' de la tabla 'tbmovimientos'
        if(is_array($listadoResultadosMovimientosContabil)){
            $clsCADContabilidad->arrayResultadosContabil($listadoResultadosMovimientosContabil);

            $listadosResultados=array(
                'Exportado'=>'SI',
                'Movimientos'=>$listadoResultadosMovimientosContabil,
                'MovimientosFactura'=>$listadoResultadosMovFacturasContabil,
                'MovimientosIva'=>$listadoResultadosMovIvaContabil,
            );
        }
        
        return $listadosResultados;
    }
    
    function ListarAsientosContabil($name){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->ListarAsientosContabil()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->ListarAsientosContabil($name);
    }
    
    function listadoMovimientosContabil2($post){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->listadoMovimientosContabil()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->listadoMovimientosContabil2($post);
    }
    
    function listadoMovimientosIvaContabil2($post){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->listadoMovimientosIvaContabil()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->listadoMovimientosIvaContabil2($post);
    }
    
    function NuevoNumeroProcesoContabil(){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->BorrarMovimientosContabil()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());//ESTO CREO QUE NO HACE FALTA
        
        return $clsCADContabilidad->NuevoNumeroProcesoContabil();
    }
    
    function BorrarMovimientosContabil(){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->BorrarMovimientosContabil()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());//ESTO CREO QUE NO HACE FALTA
        
        return $clsCADContabilidad->BorrarMovimientosContabil();
    }
    
    function BorrarFacturasContabil(){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->BorrarFacturasContabil()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->BorrarFacturasContabil();
    }
    
    function BorrarMovimientosIvasContabil(){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->BorrarMovimientosIvasContabil()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->BorrarMovimientosIvasContabil();
    }
    
    //BORRAR
//    function ExportarAsientoContabil2($post){
//        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
//               " clsCNContabilidad->ExportarAsientoContabil()>");
//        require_once '../CAD/clsCADContabilidad.php';
//        $clsCADContabilidad=new clsCADContabilidad();
//        $clsCADContabilidad->setStrBD($this->getStrBD());
//
////        //extraigo un listado de todos los movimientos filtrados segun las fechas
////        $listadoMovimientos=$clsCADContabilidad->listadoMovimientosContabil($post);
//
//        
//        
//        
//        //ahora actualizo los datos de la BBDD de access ../MovimientosImpExp/Contabil.Mdb
//        //ahora borro los datos e inserto los nuevos en la tabla 'movimientos'
//        $listadoResultadosMovimientosContabil=$clsCADContabilidad->ActualizarMovimientosContabil($listadoMovimientos);
//        
//        if(!$listadoResultadosMovimientosContabil){
//            $listadosResultados=array(
//                'Exportado'=>'NO',
//                'error'=>"No se ha preparado la tabla movimientos<br/>",
//            );
//        }
//        
//        //ahora extraigo los movimientos que son de facturas (el campo asiento no esta vacio)
//        $listadoMovFacturas='';
//        if(is_array($listadoMovimientos)){
//            foreach($listadoMovimientos as $movimiento){
//                if($movimiento['asientoF']<>''){
//                    $listadoMovFacturas[]=$movimiento;
//                }
//            }
//        }
//
//        //ahora borro los datos e inserto los nuevos en la tabla 'movimientosFactura'
//        $listadoResultadosMovFacturasContabil=$clsCADContabilidad->ActualizarMovimientosFacturasContabil($listadoMovFacturas);
//        
//        if(!$listadoResultadosMovFacturasContabil){
//            $listadosResultados=array(
//                'Exportado'=>'NO',
//                'error'=>$listadosResultados['error']."No se ha preparado la tabla movimientosFactura<br/>",
//            );
//        }
//
//        //extraigo un listado de todos los movimientos_IVA filtrados segun las fechas
//        $listadoMovimientosIva=$clsCADContabilidad->listadoMovimientosIvaContabil($post);
//        
//        //por utlimo borro los datos e inserto los nuevos en la tabla 'movimientosIva'
//        $listadoResultadosMovIvaContabil=$clsCADContabilidad->ActualizarMovimientosIvaContabil($listadoMovimientosIva);
//        
//        if(!$listadoResultadosMovIvaContabil){
//            $listadosResultados=array(
//                'Exportado'=>'NO',
//                'error'=>$listadosResultados['error']."No se ha preparado la tabla movimientosIva<br/>Los datos seleccionados ya estan Exportados anteriormente.",
//            );
//        }
//        
//        //por ultimo actualizo los datos del campo 'Exportado' de la tabla 'tbmovimientos'
//        if(is_array($listadoResultadosMovimientosContabil)){
//            $clsCADContabilidad->arrayResultadosContabil($listadoResultadosMovimientosContabil);
//
//            $listadosResultados=array(
//                'Exportado'=>'SI',
//                'Movimientos'=>$listadoResultadosMovimientosContabil,
//                'MovimientosFactura'=>$listadoResultadosMovFacturasContabil,
//                'MovimientosIva'=>$listadoResultadosMovIvaContabil,
//            );
//        }
//        
//        return $listadosResultados;
//    }
    
    function archivoZIP(){
        //ahora preparo el fichero comprimido contabil.zip para poder enviar por mail
        $zip= new ZipArchive();
//        $zip->open('../MovimientosImpExp/contabil-'.date('YmdHms').'.zip', ZipArchive::CREATE);
        $zip->open('../MovimientosImpExp/contabil.zip', ZipArchive::CREATE);
        $ficheroMDB="../MovimientosImpExp/Contabil.Mdb";
        $zip->addFile($ficheroMDB);
        $zip->close();
    }
    
    function existeAsiento($Asiento){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->existeAsiento()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->existeAsiento($Asiento);
    }

    function importarMovimientosIvaContabil($name,$asiento){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->importarMovimientosIvaContabil()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->importarMovimientosIvaContabil($name,$asiento);
    }
    
    //BORRAR
//    function ImportarAsientoContabil($url){
//        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
//               " clsCNContabilidad->ImportarAsientoContabil()>");
//        require_once '../CAD/clsCADContabilidad.php';
//        $clsCADContabilidad=new clsCADContabilidad();
//        $clsCADContabilidad->setStrBD($this->getStrBD());
//        
////        $max_execution_time=  ini_get('max_execution_time');
////        set_time_limit(0);
//        
//        $name=explode('/',$url);
//        $name=$name[count($name)-1];
//        
//        //extraigo un listado de la tabla 'movimientos', si no existe la tabla dev false
//        $listadotablaMovimientos=$clsCADContabilidad->importarMovimientosContabil($name);
//        
//        if($listadotablaMovimientos==FALSE){
//            $listadosResultados=array(
//                'Importado'=>'NO',
//                'error'=>"En esta BBDD importada no existe tabla movimientos o su estructura no es la correcta<br/>",
//            );
//        }
//        
//        //VEO QUE NO NECESITO USAR ESTE LISTADO, HABRIA QUE QUITARLO Y BORRAR LA FUNCION EN SI
//        //extraigo un listado de la tabla 'movimientosFactura', si no existe la tabla dev false
////        $listadotablaMovimientosFactura=$clsCADContabilidad->importarMovimientosFacturaContabil($name);
//        
//        //termino la funcion si $listadosResultados[Importado]=NO
//        if($listadosResultados['Importado']==='NO'){
//            return $listadosResultados;
//        }
//        
//        //ahora listo los asientos a importar y preparo un array con los datos, recorro el array $listadotablaMovimientos
//        $listadoAsientos='';
//        foreach($listadotablaMovimientos as $mov){
//
//            //voy introduciendo en el array $listadoAsientos los datos de este asiento
//            $listadoAsientos[$mov['Asiento']]['Asiento']=$mov['Asiento'];
//            $listadoAsientos[$mov['Asiento']]['FechaApunte']=$mov['Fecha'];
//            $listadoAsientos[$mov['Asiento']]['Periodo']=$mov['Periodo'];
//            $listadoAsientos[$mov['Asiento']]['concepto'.$mov['CargoAbono'].$mov['CodigoCuenta']]=$mov['Comentario'];
//            $listadoAsientos[$mov['Asiento']][$mov['CargoAbono'].$mov['CodigoCuenta']]=(float)$mov['Importe'];
//        }
//
//        //ahora con este listado, lo que hacemos es recorrerlo para ir insertando cada asiento
//        foreach($listadoAsientos as $asiento){
//            //primero compruebo si existe este asiento en nuestra BBDD
//            //si existe Asiento, lo que hago es darlo de baja
//            if($clsCADContabilidad->existeAsiento($asiento['Asiento'])==='SI'){
//                $OK=$this->DarBajaAsiento($asiento['Asiento']);
//            }
//
//            //extraigo un listado de la tabla 'movimientosIva', si no existe la tabla dev false
//            $listadotablaMovimientosIva=$clsCADContabilidad->importarMovimientosIvaContabil($name,$asiento['Asiento']);
//
//            //recorro el listado y lo introsuzco en un array de ivas
//            $ivas=array(
//                '0'=>'NO',
//                'Base0'=>0.00,
//                '4'=>'NO',
//                'Base4'=>0.00,
//                'Cuota4'=>0.00,
//                '10'=>'NO',
//                'Base10'=>0.00,
//                'Cuota10'=>0.00,
//                '21'=>'NO',
//                'Base21'=>0.00,
//                'Cuota21'=>0.00,
//            );
//
//            if(is_array($listadotablaMovimientosIva)){
//                foreach($listadotablaMovimientosIva as $movIva){
//                    if($movIva['CodigoIva']==='0'){
//                        $ivas['0']='SI';
//                        $ivas['Base0']=$ivas['Base0']+(float)$movIva['BaseIva'];
//                    }else
//                    if($movIva['CodigoIva']==='4'){
//                        $ivas['4']='SI';
//                        $ivas['Base4']=$ivas['Base4']+(float)$movIva['BaseIva'];
//                        $ivas['Cuota4']=$ivas['Cuota4']+(float)$movIva['CuotaIva'];
//                    }else
//                    if($movIva['CodigoIva']==='10'){
//                        $ivas['10']='SI';
//                        $ivas['Base10']=$ivas['Base10']+(float)$movIva['BaseIva'];
//                        $ivas['Cuota10']=$ivas['Cuota10']+(float)$movIva['CuotaIva'];
//                    }else
//                    if($movIva['CodigoIva']==='21'){
//                        $ivas['21']='SI';
//                        $ivas['Base21']=$ivas['Base21']+(float)$movIva['BaseIva'];
//                        $ivas['Cuota21']=$ivas['Cuota21']+(float)$movIva['CuotaIva'];
//                    }
//                }
//            }
//            
//            //compruebo los ivas (cuento os NOes o SIes que hay en el array $ivas
//            $contIVA=0;
//            foreach($ivas as $prop=>$valor){
//                if($valor==='SI'){
//                    $contIVA++;
//                }
//            }
//            
//            //voy a recorrer todo el asiento, controlo si existen las cuentas antes definidas arriba
//            //(7, 6, 43, 40, 4770, 4720, 4730, 4751, 57) y OTRAS (array)
//            $cuentasAsiento=array(
//                '7D'=>0,
//                '7H'=>0,
//                '6D'=>0,
//                '6H'=>0,
//                '43D'=>0,
//                '43H'=>0,
//                '40D'=>0,
//                '40H'=>0,
//                '4770D'=>0,
//                '4770H'=>0,
//                '4720D'=>0,
//                '4720H'=>0,
//                '4730D'=>0,
//                '4730H'=>0,
//                '4751D'=>0,
//                '4751H'=>0,
//                '57D'=>0,
//                '57H'=>0,
//                'OCUENTAS'=>0,
//                'OTRAS'=>'',
//            );
//            
//            //ahora con las cuentas y los ivas sabremos el tipo de asiento que es
//            $concepto='';
//            foreach($asiento as $prop=>$valor){
//                //comprobobar si es asiento normal o abono (7-H, 4770-H, 43-D)
//                if(substr($prop,1,1)==='7'){
//                    $cuenta7=substr($prop,1,9);
//                    $cantidad7=(float)$valor;
//                    if(substr($prop,0,1)==='H'){
//                        $cuentasAsiento['7H']=$cuentasAsiento['7H']+1;
//                    }else{
//                        $cuentasAsiento['7D']=$cuentasAsiento['7D']+1;
//                    }
//                }
//                if(substr($prop,1,4)==='4770'){
//                    $cantidad4770=(float)$valor;
//                    if(substr($prop,0,1)==='H'){
//                        $cuentasAsiento['4770H']=$cuentasAsiento['4770H']+1;
//                    }else{
//                        $cuentasAsiento['4770D']=$cuentasAsiento['4770D']+1;
//                    }
//                }
//                if(substr($prop,1,2)==='43'){
//                    $cuenta43=substr($prop,1,9);
//                    $cantidad43=(float)$valor;
//                    if(substr($prop,0,1)==='D'){
//                        $cuentasAsiento['43D']=$cuentasAsiento['43D']+1;
//                    }else{
//                        $cuentasAsiento['43H']=$cuentasAsiento['43H']+1;
//                    }
//                }
//                
//                //comprobobar si es asiento normal o abono (6-D, 4720-D, 40-H)
//                if(substr($prop,1,1)==='6'){
//                    $cuenta6=substr($prop,1,9);
//                    $cantidad6=(float)$valor;
//                    if(substr($prop,0,1)==='D'){
//                        $cuentasAsiento['6D']=$cuentasAsiento['6D']+1;
//                    }else{
//                        $cuentasAsiento['6H']=$cuentasAsiento['6H']+1;
//                    }
//                }
//                if(substr($prop,1,4)==='4720'){
//                    $cantidad4720=(float)$valor;
//                    if(substr($prop,0,1)==='D'){
//                        $cuentasAsiento['4720D']=$cuentasAsiento['4720D']+1;
//                    }else{
//                        $cuentasAsiento['4720H']=$cuentasAsiento['4720H']+1;
//                    }
//                }
//                if(substr($prop,1,2)==='40'){
//                    $cuenta40=substr($prop,1,9);
//                    $cantidad40=(float)$valor;
//                    if(substr($prop,0,1)==='H'){
//                        $cuentasAsiento['40H']=$cuentasAsiento['40H']+1;
//                    }else{
//                        $cuentasAsiento['40D']=$cuentasAsiento['40D']+1;
//                    }
//                }
//                
//                if(substr($prop,1,4)==='4730'){
//                    $cantidad4730=(float)$valor;
//                    if(substr($prop,0,1)==='D'){
//                        $cuentasAsiento['4730D']=$cuentasAsiento['4730D']+1;
//                    }else{
//                        $cuentasAsiento['4730H']=$cuentasAsiento['4730H']+1;
//                    }
//                }
//                
//                if(substr($prop,1,4)==='4751'){
//                    $cantidad4751=(float)$valor;
//                    if(substr($prop,0,1)==='D'){
//                        $cuentasAsiento['4751D']=$cuentasAsiento['4751D']+1;
//                    }else{
//                        $cuentasAsiento['4751H']=$cuentasAsiento['4751H']+1;
//                    }
//                }
//                
//                //busco si hay banco o caja (cuenta 57)
//                $optTipo=0;
//                if(substr($prop,1,2)==='57'){
//                    $optTipo=1;
//                    $cuenta57=substr($prop,1,9);
//                    if(substr($prop,0,1)==='H'){
//                        $cuentasAsiento['57H']=$cuentasAsiento['57H']+1;
//                    }else{
//                        $cuentasAsiento['57D']=$cuentasAsiento['57D']+1;
//                    }
//                }
//                
//                //busco si hay otras cuentas (posiciones 1 a 9 son numericas)
//                if(is_numeric(substr($prop,1,9))){
//                    $cuentasAsiento['OTRAS'][]=array("IdMovimiento"=>0,
//                                                "Cuenta"=>substr($prop,1,9),
//                                                "Concepto"=>addslashes($asiento['concepto'.$prop]),
//                                                "Cantidad"=>$valor,
//                                                "DoH"=>substr($prop,0,1)
//                    );
//                }
//                
//                if(substr($prop,0,8)==='concepto'){
//                    $concepto=addslashes($valor);
//                }
//            }
//            
//            //ivas (si solo es uno)
//            $porciento=0;
//            $iva=0;
//            
//            if($ivas['0']==='SI'){
//                $porciento=0;
//                $iva=0;
//            }else
//            if($ivas['4']==='SI'){
//                $porciento=4;
//                $iva=$ivas['Cuota4'];
//            }else
//            if($ivas['10']==='SI'){
//                $porciento=10;
//                $iva=$ivas['Cuota10'];
//            }else
//            if($ivas['21']==='SI'){
//                $porciento=21;
//                $iva=$ivas['Cuota21'];
//            }
//
//            //calculo %IRPF de las cuentas 4730(INGRESO) y 4751(GASTO)
//            //compruebo que existen
//            if(isset($cantidad4730)){
//                $PorcientoIRPF=(int)round($cantidad4730/$cantidad7*100,0);
//            }
//            if(isset($cantidad4751)){
//                $PorcientoIRPF=(int)round($cantidad4751/$cantidad6*100,0);
//            }
//
//            //tipos 0 o 1
//            $c6D=$cuentasAsiento['6D'];
//            $c6H=$cuentasAsiento['6H'];
//            $c7D=$cuentasAsiento['7D'];
//            $c7H=$cuentasAsiento['7H'];
//            $c40D=$cuentasAsiento['40D'];
//            $c40H=$cuentasAsiento['40H'];
//            $c43D=$cuentasAsiento['43D'];
//            $c43H=$cuentasAsiento['43H'];
//            $c4720D=$cuentasAsiento['4720D'];
//            $c4720H=$cuentasAsiento['4720H'];
//            $c4770D=$cuentasAsiento['4770D'];
//            $c4770H=$cuentasAsiento['4770H'];
//            $c4730D=$cuentasAsiento['4730D'];
//            $c4730H=$cuentasAsiento['4730H'];
//            $c4751D=$cuentasAsiento['4751D'];
//            $c4751H=$cuentasAsiento['4751H'];
//            $c57D=$cuentasAsiento['57D'];
//            $c57H=$cuentasAsiento['57H'];
//
//            //aqui averiguamos de que tipo son segun esta estructura
//            //en la vbel $cuentasAsientos vienen estas variables con cantidades (6,7,40,43,4720,4770,4730,4751 y 57)
//            //
//            //
//            //00N                              00A
//            //----------------------------------------------------------
//            //$cuentasAsiento[6D]=1            $cuentasAsiento[6D]=0
//            //$cuentasAsiento[6H]=0            $cuentasAsiento[6H]=1
//            //$cuentasAsiento[7D]=0            $cuentasAsiento[7D]=0
//            //$cuentasAsiento[7H]=0            $cuentasAsiento[7H]=0
//            //$cuentasAsiento[40D]=0           $cuentasAsiento[40D]=1
//            //$cuentasAsiento[40H]=1           $cuentasAsiento[40H]=0
//            //$cuentasAsiento[43D]=0           $cuentasAsiento[43D]=0
//            //$cuentasAsiento[43H]=0           $cuentasAsiento[43H]=0
//            //$cuentasAsiento[4720D]=0         $cuentasAsiento[4720D]=0
//            //$cuentasAsiento[4720H]=0         $cuentasAsiento[4720H]=0
//            //$cuentasAsiento[4770D]=0         $cuentasAsiento[4770D]=0
//            //$cuentasAsiento[4770H]=0         $cuentasAsiento[4770H]=0
//            //$cuentasAsiento[4730D]=0         $cuentasAsiento[4730D]=0
//            //$cuentasAsiento[4730H]=0         $cuentasAsiento[4730H]=0
//            //$cuentasAsiento[4751D]=0         $cuentasAsiento[4751D]=0
//            //$cuentasAsiento[4751H]=0         $cuentasAsiento[4751H]=0
//            //$cuentasAsiento[57D]=0           $cuentasAsiento[57D]=0
//            //$cuentasAsiento[57H]=0           $cuentasAsiento[57H]=0
//            //
//
//            if($c6D===1 && $c7D===0 && $c40D===0 && $c43D===0 && $c4720D===0 && $c4770D===0 && $c4730D===0 && $c4751D===0 && $c57D===0
//               && $c6H===0 && $c7H===0 && $c40H===1 && $c43H===0 && $c4720H===0 && $c4770H===0 && $c4730H===0 && $c4751H===0 && $c57H===0){
//                $tipo='00N';
//            }else
//
//            if($c6D===0 && $c7D===0 && $c40D===1 && $c43D===0 && $c4720D===0 && $c4770D===0 && $c4730D===0 && $c4751D===0 && $c57D===0
//               && $c6H===1 && $c7H===0 && $c40H===0 && $c43H===0 && $c4720H===0 && $c4770H===0 && $c4730H===0 && $c4751H===0 && $c57H===0){
//                $tipo='00A';
//            }else
//
//            //00N (banco)                      00A (banco)
//            //----------------------------------------------------------
//            //$cuentasAsiento[6D]=1            $cuentasAsiento[6D]=0
//            //$cuentasAsiento[6H]=0            $cuentasAsiento[6H]=1
//            //$cuentasAsiento[7D]=0            $cuentasAsiento[7D]=0
//            //$cuentasAsiento[7H]=0            $cuentasAsiento[7H]=0
//            //$cuentasAsiento[40D]=1           $cuentasAsiento[40D]=1
//            //$cuentasAsiento[40H]=1           $cuentasAsiento[40H]=1
//            //$cuentasAsiento[43D]=0           $cuentasAsiento[43D]=0
//            //$cuentasAsiento[43H]=0           $cuentasAsiento[43H]=0
//            //$cuentasAsiento[4720D]=0         $cuentasAsiento[4720D]=0
//            //$cuentasAsiento[4720H]=0         $cuentasAsiento[4720H]=0
//            //$cuentasAsiento[4770D]=0         $cuentasAsiento[4770D]=0
//            //$cuentasAsiento[4770H]=0         $cuentasAsiento[4770H]=0
//            //$cuentasAsiento[4730D]=0         $cuentasAsiento[4730D]=0
//            //$cuentasAsiento[4730H]=0         $cuentasAsiento[4730H]=0
//            //$cuentasAsiento[4751D]=0         $cuentasAsiento[4751D]=0
//            //$cuentasAsiento[4751H]=0         $cuentasAsiento[4751H]=0
//            //$cuentasAsiento[57D]=0           $cuentasAsiento[57D]=1
//            //$cuentasAsiento[57H]=1           $cuentasAsiento[57H]=0
//            //
//
//            if($c6D===1 && $c7D===0 && $c40D===1 && $c43D===0 && $c4720D===0 && $c4770D===0 && $c4730D===0 && $c4751D===0 && $c57D===0
//               && $c6H===0 && $c7H===0 && $c40H===1 && $c43H===0 && $c4720H===0 && $c4770H===0 && $c4730H===0 && $c4751H===0 && $c57H===1){
//                $tipo='00N';
//            }else
//
//            if($c6D===0 && $c7D===0 && $c40D===1 && $c43D===0 && $c4720D===0 && $c4770D===0 && $c4730D===0 && $c4751D===0 && $c57D===1
//               && $c6H===1 && $c7H===0 && $c40H===1 && $c43H===0 && $c4720H===0 && $c4770H===0 && $c4730H===0 && $c4751H===0 && $c57H===0){
//                $tipo='00A';
//            }else
//
//            //01N                              01A
//            //----------------------------------------------------------
//            //$cuentasAsiento[6D]=1            $cuentasAsiento[6D]=0
//            //$cuentasAsiento[6H]=0            $cuentasAsiento[6H]=1
//            //$cuentasAsiento[7D]=0            $cuentasAsiento[7D]=0
//            //$cuentasAsiento[7H]=0            $cuentasAsiento[7H]=0
//            //$cuentasAsiento[40D]=0           $cuentasAsiento[40D]=1
//            //$cuentasAsiento[40H]=1           $cuentasAsiento[40H]=0
//            //$cuentasAsiento[43D]=0           $cuentasAsiento[43D]=0
//            //$cuentasAsiento[43H]=0           $cuentasAsiento[43H]=0
//            //$cuentasAsiento[4720D]=1         $cuentasAsiento[4720D]=0
//            //$cuentasAsiento[4720H]=0         $cuentasAsiento[4720H]=1
//            //$cuentasAsiento[4770D]=0         $cuentasAsiento[4770D]=0
//            //$cuentasAsiento[4770H]=0         $cuentasAsiento[4770H]=0
//            //$cuentasAsiento[4730D]=0         $cuentasAsiento[4730D]=0
//            //$cuentasAsiento[4730H]=0         $cuentasAsiento[4730H]=0
//            //$cuentasAsiento[4751D]=0         $cuentasAsiento[4751D]=0
//            //$cuentasAsiento[4751H]=0         $cuentasAsiento[4751H]=0
//            //$cuentasAsiento[57D]=0           $cuentasAsiento[57D]=0
//            //$cuentasAsiento[57H]=0           $cuentasAsiento[57H]=0
//            //
//            // y $contIVA===1
//
//            if($c6D===1 && $c7D===0 && $c40D===0 && $c43D===0 && $c4720D===1 && $c4770D===0 && $c4730D===0 && $c4751D===0 && $c57D===0
//               && $c6H===0 && $c7H===0 && $c40H===1 && $c43H===0 && $c4720H===0 && $c4770H===0 && $c4730H===0 && $c4751H===0 && $c57H===0 && $contIVA===1){
//                $tipo='01N';
//            }else
//
//            if($c6D===0 && $c7D===0 && $c40D===1 && $c43D===0 && $c4720D===0 && $c4770D===0 && $c4730D===0 && $c4751D===0 && $c57D===0
//               && $c6H===1 && $c7H===0 && $c40H===0 && $c43H===0 && $c4720H===1 && $c4770H===0 && $c4730H===0 && $c4751H===0 && $c57H===0 && $contIVA===1){
//                $tipo='01A';
//            }else
//
//            //01N (Banco)                      01A (Banco)
//            //----------------------------------------------------------
//            //$cuentasAsiento[6D]=1            $cuentasAsiento[6D]=0
//            //$cuentasAsiento[6H]=0            $cuentasAsiento[6H]=1
//            //$cuentasAsiento[7D]=0            $cuentasAsiento[7D]=0
//            //$cuentasAsiento[7H]=0            $cuentasAsiento[7H]=0
//            //$cuentasAsiento[40D]=1           $cuentasAsiento[40D]=1
//            //$cuentasAsiento[40H]=1           $cuentasAsiento[40H]=1
//            //$cuentasAsiento[43D]=0           $cuentasAsiento[43D]=0
//            //$cuentasAsiento[43H]=0           $cuentasAsiento[43H]=0
//            //$cuentasAsiento[4720D]=1         $cuentasAsiento[4720D]=0
//            //$cuentasAsiento[4720H]=0         $cuentasAsiento[4720H]=1
//            //$cuentasAsiento[4770D]=0         $cuentasAsiento[4770D]=0
//            //$cuentasAsiento[4770H]=0         $cuentasAsiento[4770H]=0
//            //$cuentasAsiento[4730D]=0         $cuentasAsiento[4730D]=0
//            //$cuentasAsiento[4730H]=0         $cuentasAsiento[4730H]=0
//            //$cuentasAsiento[4751D]=0         $cuentasAsiento[4751D]=0
//            //$cuentasAsiento[4751H]=0         $cuentasAsiento[4751H]=0
//            //$cuentasAsiento[57D]=0           $cuentasAsiento[57D]=1
//            //$cuentasAsiento[57H]=1           $cuentasAsiento[57H]=0
//            //
//            // y $contIVA===1
//
//            if($c6D===1 && $c7D===0 && $c40D===1 && $c43D===0 && $c4720D===1 && $c4770D===0 && $c4730D===0 && $c4751D===0 && $c57D===0
//               && $c6H===0 && $c7H===0 && $c40H===1 && $c43H===0 && $c4720H===0 && $c4770H===0 && $c4730H===0 && $c4751H===0 && $c57H===1 && $contIVA===1){
//                $tipo='01N';
//            }else
//
//            if($c6D===0 && $c7D===0 && $c40D===1 && $c43D===0 && $c4720D===0 && $c4770D===0 && $c4730D===0 && $c4751D===0 && $c57D===1
//               && $c6H===1 && $c7H===0 && $c40H===1 && $c43H===0 && $c4720H===1 && $c4770H===0 && $c4730H===0 && $c4751H===0 && $c57H===0 && $contIVA===1){
//                $tipo='01A';
//            }else
//
//            //02N                              02A
//            //----------------------------------------------------------
//            //$cuentasAsiento[6D]=1            $cuentasAsiento[6D]=0
//            //$cuentasAsiento[6H]=0            $cuentasAsiento[6H]=1
//            //$cuentasAsiento[7D]=0            $cuentasAsiento[7D]=0
//            //$cuentasAsiento[7H]=0            $cuentasAsiento[7H]=0
//            //$cuentasAsiento[40D]=0           $cuentasAsiento[40D]=1
//            //$cuentasAsiento[40H]=1           $cuentasAsiento[40H]=0
//            //$cuentasAsiento[43D]=0           $cuentasAsiento[43D]=0
//            //$cuentasAsiento[43H]=0           $cuentasAsiento[43H]=0
//            //$cuentasAsiento[4720D]=1         $cuentasAsiento[4720D]=0
//            //$cuentasAsiento[4720H]=0         $cuentasAsiento[4720H]=1
//            //$cuentasAsiento[4770D]=0         $cuentasAsiento[4770D]=0
//            //$cuentasAsiento[4770H]=0         $cuentasAsiento[4770H]=0
//            //$cuentasAsiento[4730D]=0         $cuentasAsiento[4730D]=0
//            //$cuentasAsiento[4730H]=0         $cuentasAsiento[4730H]=0
//            //$cuentasAsiento[4751D]=0         $cuentasAsiento[4751D]=1
//            //$cuentasAsiento[4751H]=1         $cuentasAsiento[4751H]=0
//            //$cuentasAsiento[57D]=0           $cuentasAsiento[57D]=0
//            //$cuentasAsiento[57H]=0           $cuentasAsiento[57H]=0
//            //
//            // y $contIVA===1
//
//            if($c6D===1 && $c7D===0 && $c40D===0 && $c43D===0 && $c4720D===1 && $c4770D===0 && $c4730D===0 && $c4751D===0 && $c57D===0
//               && $c6H===0 && $c7H===0 && $c40H===1 && $c43H===0 && $c4720H===0 && $c4770H===0 && $c4730H===0 && $c4751H===1 && $c57H===0 && $contIVA===1){
//                $tipo='02N';
//            }else
//
//            if($c6D===0 && $c7D===0 && $c40D===1 && $c43D===0 && $c4720D===0 && $c4770D===0 && $c4730D===0 && $c4751D===1 && $c57D===0
//               && $c6H===1 && $c7H===0 && $c40H===0 && $c43H===0 && $c4720H===1 && $c4770H===0 && $c4730H===0 && $c4751H===0 && $c57H===0 && $contIVA===1){
//                $tipo='02A';
//            }else
//
//            //02N (Banco)                      02A (Banco)
//            //----------------------------------------------------------
//            //$cuentasAsiento[6D]=1            $cuentasAsiento[6D]=0
//            //$cuentasAsiento[6H]=0            $cuentasAsiento[6H]=1
//            //$cuentasAsiento[7D]=0            $cuentasAsiento[7D]=0
//            //$cuentasAsiento[7H]=0            $cuentasAsiento[7H]=0
//            //$cuentasAsiento[40D]=1           $cuentasAsiento[40D]=1
//            //$cuentasAsiento[40H]=1           $cuentasAsiento[40H]=1
//            //$cuentasAsiento[43D]=0           $cuentasAsiento[43D]=0
//            //$cuentasAsiento[43H]=0           $cuentasAsiento[43H]=0
//            //$cuentasAsiento[4720D]=1         $cuentasAsiento[4720D]=0
//            //$cuentasAsiento[4720H]=0         $cuentasAsiento[4720H]=1
//            //$cuentasAsiento[4770D]=0         $cuentasAsiento[4770D]=0
//            //$cuentasAsiento[4770H]=0         $cuentasAsiento[4770H]=0
//            //$cuentasAsiento[4730D]=0         $cuentasAsiento[4730D]=0
//            //$cuentasAsiento[4730H]=0         $cuentasAsiento[4730H]=0
//            //$cuentasAsiento[4751D]=0         $cuentasAsiento[4751D]=1
//            //$cuentasAsiento[4751H]=1         $cuentasAsiento[4751H]=0
//            //$cuentasAsiento[57D]=0           $cuentasAsiento[57D]=1
//            //$cuentasAsiento[57H]=1           $cuentasAsiento[57H]=0
//            //
//            // y $contIVA===1
//
//            if($c6D===1 && $c7D===0 && $c40D===1 && $c43D===0 && $c4720D===1 && $c4770D===0 && $c4730D===0 && $c4751D===0 && $c57D===0
//               && $c6H===0 && $c7H===0 && $c40H===1 && $c43H===0 && $c4720H===0 && $c4770H===0 && $c4730H===0 && $c4751H===1 && $c57H===1 && $contIVA===1){
//                $tipo='02N';
//            }else
//
//            if($c6D===0 && $c7D===0 && $c40D===1 && $c43D===0 && $c4720D===0 && $c4770D===0 && $c4730D===0 && $c4751D===1 && $c57D===1
//               && $c6H===1 && $c7H===0 && $c40H===1 && $c43H===0 && $c4720H===1 && $c4770H===0 && $c4730H===0 && $c4751H===0 && $c57H===0 && $contIVA===1){
//                $tipo='02A';
//            }else
//
//            //03N                              03A 
//            //----------------------------------------------------------
//            //$cuentasAsiento[6D]=1            $cuentasAsiento[6D]=0
//            //$cuentasAsiento[6H]=0            $cuentasAsiento[6H]=1
//            //$cuentasAsiento[7D]=0            $cuentasAsiento[7D]=0
//            //$cuentasAsiento[7H]=0            $cuentasAsiento[7H]=0
//            //$cuentasAsiento[40D]=0           $cuentasAsiento[40D]=1
//            //$cuentasAsiento[40H]=1           $cuentasAsiento[40H]=0
//            //$cuentasAsiento[43D]=0           $cuentasAsiento[43D]=0
//            //$cuentasAsiento[43H]=0           $cuentasAsiento[43H]=0
//            //$cuentasAsiento[4720D]=1         $cuentasAsiento[4720D]=0
//            //$cuentasAsiento[4720H]=0         $cuentasAsiento[4720H]=1
//            //$cuentasAsiento[4770D]=0         $cuentasAsiento[4770D]=0
//            //$cuentasAsiento[4770H]=0         $cuentasAsiento[4770H]=0
//            //$cuentasAsiento[4730D]=0         $cuentasAsiento[4730D]=0
//            //$cuentasAsiento[4730H]=0         $cuentasAsiento[4730H]=0
//            //$cuentasAsiento[4751D]=0         $cuentasAsiento[4751D]=0
//            //$cuentasAsiento[4751H]=0         $cuentasAsiento[4751H]=0
//            //$cuentasAsiento[57D]=0           $cuentasAsiento[57D]=0
//            //$cuentasAsiento[57H]=0           $cuentasAsiento[57H]=0
//            //
//            // y $contIVA>1
//
//            if($c6D===1 && $c7D===0 && $c40D===0 && $c43D===0 && $c4720D===1 && $c4770D===0 && $c4730D===0 && $c4751D===0 && $c57D===0
//               && $c6H===0 && $c7H===0 && $c40H===1 && $c43H===0 && $c4720H===0 && $c4770H===0 && $c4730H===0 && $c4751H===0 && $c57H===0 && $contIVA>1){
//                $tipo='03N';
//            }else
//
//            if($c6D===0 && $c7D===0 && $c40D===1 && $c43D===0 && $c4720D===0 && $c4770D===0 && $c4730D===0 && $c4751D===0 && $c57D===0
//               && $c6H===1 && $c7H===0 && $c40H===0 && $c43H===0 && $c4720H===1 && $c4770H===0 && $c4730H===0 && $c4751H===0 && $c57H===0 && $contIVA>1){
//                $tipo='03A';
//            }else
//
//            //03N (Banco)                      03A (Banco)
//            //----------------------------------------------------------
//            //$cuentasAsiento[6D]=1            $cuentasAsiento[6D]=0
//            //$cuentasAsiento[6H]=0            $cuentasAsiento[6H]=1
//            //$cuentasAsiento[7D]=0            $cuentasAsiento[7D]=0
//            //$cuentasAsiento[7H]=0            $cuentasAsiento[7H]=0
//            //$cuentasAsiento[40D]=1           $cuentasAsiento[40D]=1
//            //$cuentasAsiento[40H]=1           $cuentasAsiento[40H]=1
//            //$cuentasAsiento[43D]=0           $cuentasAsiento[43D]=0
//            //$cuentasAsiento[43H]=0           $cuentasAsiento[43H]=0
//            //$cuentasAsiento[4720D]=1         $cuentasAsiento[4720D]=0
//            //$cuentasAsiento[4720H]=0         $cuentasAsiento[4720H]=1
//            //$cuentasAsiento[4770D]=0         $cuentasAsiento[4770D]=0
//            //$cuentasAsiento[4770H]=0         $cuentasAsiento[4770H]=0
//            //$cuentasAsiento[4730D]=0         $cuentasAsiento[4730D]=0
//            //$cuentasAsiento[4730H]=0         $cuentasAsiento[4730H]=0
//            //$cuentasAsiento[4751D]=0         $cuentasAsiento[4751D]=0
//            //$cuentasAsiento[4751H]=0         $cuentasAsiento[4751H]=0
//            //$cuentasAsiento[57D]=0           $cuentasAsiento[57D]=1
//            //$cuentasAsiento[57H]=1           $cuentasAsiento[57H]=0
//            //
//            // y $contIVA>1
//
//            if($c6D===1 && $c7D===0 && $c40D===1 && $c43D===0 && $c4720D===1 && $c4770D===0 && $c4730D===0 && $c4751D===0 && $c57D===0
//               && $c6H===0 && $c7H===0 && $c40H===1 && $c43H===0 && $c4720H===0 && $c4770H===0 && $c4730H===0 && $c4751H===0 && $c57H===1 && $contIVA>1){
//                $tipo='03N';
//            }else
//
//            if($c6D===0 && $c7D===0 && $c40D===1 && $c43D===0 && $c4720D===0 && $c4770D===0 && $c4730D===0 && $c4751D===0 && $c57D===1
//               && $c6H===1 && $c7H===0 && $c40H===1 && $c43H===0 && $c4720H===1 && $c4770H===0 && $c4730H===0 && $c4751H===0 && $c57H===0 && $contIVA>1){
//                $tipo='03A';
//            }else
//
//            //04N                              04A
//            //----------------------------------------------------------
//            //$cuentasAsiento[6D]=1            $cuentasAsiento[6D]=0
//            //$cuentasAsiento[6H]=0            $cuentasAsiento[6H]=1
//            //$cuentasAsiento[7D]=0            $cuentasAsiento[7D]=0
//            //$cuentasAsiento[7H]=0            $cuentasAsiento[7H]=0
//            //$cuentasAsiento[40D]=0           $cuentasAsiento[40D]=1
//            //$cuentasAsiento[40H]=1           $cuentasAsiento[40H]=0
//            //$cuentasAsiento[43D]=0           $cuentasAsiento[43D]=0
//            //$cuentasAsiento[43H]=0           $cuentasAsiento[43H]=0
//            //$cuentasAsiento[4720D]=1         $cuentasAsiento[4720D]=0
//            //$cuentasAsiento[4720H]=0         $cuentasAsiento[4720H]=1
//            //$cuentasAsiento[4770D]=0         $cuentasAsiento[4770D]=0
//            //$cuentasAsiento[4770H]=0         $cuentasAsiento[4770H]=0
//            //$cuentasAsiento[4730D]=0         $cuentasAsiento[4730D]=0
//            //$cuentasAsiento[4730H]=0         $cuentasAsiento[4730H]=0
//            //$cuentasAsiento[4751D]=0         $cuentasAsiento[4751D]=1
//            //$cuentasAsiento[4751H]=1         $cuentasAsiento[4751H]=0
//            //$cuentasAsiento[57D]=0           $cuentasAsiento[57D]=0
//            //$cuentasAsiento[57H]=0           $cuentasAsiento[57H]=0
//            //
//            // y $contIVA>1
//
//            if($c6D===1 && $c7D===0 && $c40D===0 && $c43D===0 && $c4720D===1 && $c4770D===0 && $c4730D===0 && $c4751D===0 && $c57D===0
//               && $c6H===0 && $c7H===0 && $c40H===1 && $c43H===0 && $c4720H===0 && $c4770H===0 && $c4730H===0 && $c4751H===1 && $c57H===0 && $contIVA>1){
//                $tipo='04N';
//            }else
//
//            if($c6D===0 && $c7D===0 && $c40D===1 && $c43D===0 && $c4720D===0 && $c4770D===0 && $c4730D===0 && $c4751D===1 && $c57D===0
//               && $c6H===1 && $c7H===0 && $c40H===0 && $c43H===0 && $c4720H===1 && $c4770H===0 && $c4730H===0 && $c4751H===0 && $c57H===0 && $contIVA>1){
//                $tipo='04A';
//            }else
//
//            //04N (Banco)                      04A (Banco)
//            //----------------------------------------------------------
//            //$cuentasAsiento[6D]=1            $cuentasAsiento[6D]=0
//            //$cuentasAsiento[6H]=0            $cuentasAsiento[6H]=1
//            //$cuentasAsiento[7D]=0            $cuentasAsiento[7D]=0
//            //$cuentasAsiento[7H]=0            $cuentasAsiento[7H]=0
//            //$cuentasAsiento[40D]=1           $cuentasAsiento[40D]=1
//            //$cuentasAsiento[40H]=1           $cuentasAsiento[40H]=1
//            //$cuentasAsiento[43D]=0           $cuentasAsiento[43D]=0
//            //$cuentasAsiento[43H]=0           $cuentasAsiento[43H]=0
//            //$cuentasAsiento[4720D]=1         $cuentasAsiento[4720D]=0
//            //$cuentasAsiento[4720H]=0         $cuentasAsiento[4720H]=1
//            //$cuentasAsiento[4770D]=0         $cuentasAsiento[4770D]=0
//            //$cuentasAsiento[4770H]=0         $cuentasAsiento[4770H]=0
//            //$cuentasAsiento[4730D]=0         $cuentasAsiento[4730D]=0
//            //$cuentasAsiento[4730H]=0         $cuentasAsiento[4730H]=0
//            //$cuentasAsiento[4751D]=0         $cuentasAsiento[4751D]=1
//            //$cuentasAsiento[4751H]=1         $cuentasAsiento[4751H]=0
//            //$cuentasAsiento[57D]=0           $cuentasAsiento[57D]=1
//            //$cuentasAsiento[57H]=1           $cuentasAsiento[57H]=0
//            //
//            // y $contIVA>1
//
//            if($c6D===1 && $c7D===0 && $c40D===1 && $c43D===0 && $c4720D===1 && $c4770D===0 && $c4730D===0 && $c4751D===0 && $c57D===0
//               && $c6H===0 && $c7H===0 && $c40H===1 && $c43H===0 && $c4720H===0 && $c4770H===0 && $c4730H===0 && $c4751H===1 && $c57H===1 && $contIVA>1){
//                $tipo='04N';
//            }else
//
//            if($c6D===0 && $c7D===0 && $c40D===1 && $c43D===0 && $c4720D===0 && $c4770D===0 && $c4730D===0 && $c4751D===1 && $c57D===1
//               && $c6H===1 && $c7H===0 && $c40H===1 && $c43H===0 && $c4720H===1 && $c4770H===0 && $c4730H===0 && $c4751H===0 && $c57H===0 && $contIVA>1){
//                $tipo='04A';
//            }else
//
//            //10N                              10A
//            //----------------------------------------------------------
//            //$cuentasAsiento[6D]=0            $cuentasAsiento[6D]=0
//            //$cuentasAsiento[6H]=0            $cuentasAsiento[6H]=0
//            //$cuentasAsiento[7D]=0            $cuentasAsiento[7D]=1
//            //$cuentasAsiento[7H]=1            $cuentasAsiento[7H]=0
//            //$cuentasAsiento[40D]=0           $cuentasAsiento[40D]=0
//            //$cuentasAsiento[40H]=0           $cuentasAsiento[40H]=0
//            //$cuentasAsiento[43D]=1           $cuentasAsiento[43D]=0
//            //$cuentasAsiento[43H]=0           $cuentasAsiento[43H]=1
//            //$cuentasAsiento[4720D]=0         $cuentasAsiento[4720D]=0
//            //$cuentasAsiento[4720H]=0         $cuentasAsiento[4720H]=0
//            //$cuentasAsiento[4770D]=0         $cuentasAsiento[4770D]=0
//            //$cuentasAsiento[4770H]=0         $cuentasAsiento[4770H]=0
//            //$cuentasAsiento[4730D]=0         $cuentasAsiento[4730D]=0
//            //$cuentasAsiento[4730H]=0         $cuentasAsiento[4730H]=0
//            //$cuentasAsiento[4751D]=0         $cuentasAsiento[4751D]=0
//            //$cuentasAsiento[4751H]=0         $cuentasAsiento[4751H]=0
//            //$cuentasAsiento[57D]=0           $cuentasAsiento[57D]=0
//            //$cuentasAsiento[57H]=0           $cuentasAsiento[57H]=0
//            //
//
//            if($c6D===0 && $c7D===0 && $c40D===0 && $c43D===1 && $c4720D===0 && $c4770D===0 && $c4730D===0 && $c4751D===0 && $c57D===0
//               && $c6H===0 && $c7H===1 && $c40H===0 && $c43H===0 && $c4720H===0 && $c4770H===0 && $c4730H===0 && $c4751H===0 && $c57H===0){
//                $tipo='10N';
//            }else
//
//            if($c6D===0 && $c7D===1 && $c40D===0 && $c43D===0 && $c4720D===0 && $c4770D===0 && $c4730D===0 && $c4751D===0 && $c57D===0
//               && $c6H===0 && $c7H===0 && $c40H===0 && $c43H===1 && $c4720H===0 && $c4770H===0 && $c4730H===0 && $c4751H===0 && $c57H===0){
//                $tipo='10A';
//            }else
//
//            //10N (banco)                      10A (banco)
//            //----------------------------------------------------------
//            //$cuentasAsiento[6D]=0            $cuentasAsiento[6D]=0
//            //$cuentasAsiento[6H]=0            $cuentasAsiento[6H]=0
//            //$cuentasAsiento[7D]=0            $cuentasAsiento[7D]=1
//            //$cuentasAsiento[7H]=1            $cuentasAsiento[7H]=0
//            //$cuentasAsiento[40D]=0           $cuentasAsiento[40D]=0
//            //$cuentasAsiento[40H]=0           $cuentasAsiento[40H]=0
//            //$cuentasAsiento[43D]=1           $cuentasAsiento[43D]=1
//            //$cuentasAsiento[43H]=1           $cuentasAsiento[43H]=1
//            //$cuentasAsiento[4720D]=0         $cuentasAsiento[4720D]=0
//            //$cuentasAsiento[4720H]=0         $cuentasAsiento[4720H]=0
//            //$cuentasAsiento[4770D]=0         $cuentasAsiento[4770D]=0
//            //$cuentasAsiento[4770H]=0         $cuentasAsiento[4770H]=0
//            //$cuentasAsiento[4730D]=0         $cuentasAsiento[4730D]=0
//            //$cuentasAsiento[4730H]=0         $cuentasAsiento[4730H]=0
//            //$cuentasAsiento[4751D]=0         $cuentasAsiento[4751D]=0
//            //$cuentasAsiento[4751H]=0         $cuentasAsiento[4751H]=0
//            //$cuentasAsiento[57D]=1           $cuentasAsiento[57D]=0
//            //$cuentasAsiento[57H]=0           $cuentasAsiento[57H]=1
//            //
//
//            if($c6D===0 && $c7D===0 && $c40D===0 && $c43D===1 && $c4720D===0 && $c4770D===0 && $c4730D===0 && $c4751D===0 && $c57D===1
//               && $c6H===0 && $c7H===1 && $c40H===0 && $c43H===1 && $c4720H===0 && $c4770H===0 && $c4730H===0 && $c4751H===0 && $c57H===0){
//                $tipo='10N';
//            }else
//
//            if($c6D===0 && $c7D===1 && $c40D===0 && $c43D===1 && $c4720D===0 && $c4770D===0 && $c4730D===0 && $c4751D===0 && $c57D===0
//               && $c6H===0 && $c7H===0 && $c40H===0 && $c43H===1 && $c4720H===0 && $c4770H===0 && $c4730H===0 && $c4751H===0 && $c57H===1){
//                $tipo='10A';
//            }else
//
//            //11N                              11A
//            //----------------------------------------------------------
//            //$cuentasAsiento[6D]=0            $cuentasAsiento[6D]=0
//            //$cuentasAsiento[6H]=0            $cuentasAsiento[6H]=0
//            //$cuentasAsiento[7D]=0            $cuentasAsiento[7D]=1
//            //$cuentasAsiento[7H]=1            $cuentasAsiento[7H]=0
//            //$cuentasAsiento[40D]=0           $cuentasAsiento[40D]=0
//            //$cuentasAsiento[40H]=0           $cuentasAsiento[40H]=0
//            //$cuentasAsiento[43D]=1           $cuentasAsiento[43D]=0
//            //$cuentasAsiento[43H]=0           $cuentasAsiento[43H]=1
//            //$cuentasAsiento[4720D]=0         $cuentasAsiento[4720D]=0
//            //$cuentasAsiento[4720H]=0         $cuentasAsiento[4720H]=0
//            //$cuentasAsiento[4770D]=0         $cuentasAsiento[4770D]=1
//            //$cuentasAsiento[4770H]=1         $cuentasAsiento[4770H]=0
//            //$cuentasAsiento[4730D]=0         $cuentasAsiento[4730D]=0
//            //$cuentasAsiento[4730H]=0         $cuentasAsiento[4730H]=0
//            //$cuentasAsiento[4751D]=0         $cuentasAsiento[4751D]=0
//            //$cuentasAsiento[4751H]=0         $cuentasAsiento[4751H]=0
//            //$cuentasAsiento[57D]=0           $cuentasAsiento[57D]=0
//            //$cuentasAsiento[57H]=0           $cuentasAsiento[57H]=0
//            //
//            // y $contIVA===1
//
//            if($c6D===0 && $c7D===0 && $c40D===0 && $c43D===1 && $c4720D===0 && $c4770D===0 && $c4730D===0 && $c4751D===0 && $c57D===0
//               && $c6H===0 && $c7H===1 && $c40H===0 && $c43H===0 && $c4720H===0 && $c4770H===1 && $c4730H===0 && $c4751H===0 && $c57H===0 && $contIVA===1){
//                $tipo='11N';
//            }else
//
//            if($c6D===0 && $c7D===1 && $c40D===0 && $c43D===0 && $c4720D===0 && $c4770D===1 && $c4730D===0 && $c4751D===0 && $c57D===0
//               && $c6H===0 && $c7H===0 && $c40H===0 && $c43H===1 && $c4720H===0 && $c4770H===0 && $c4730H===0 && $c4751H===0 && $c57H===0 && $contIVA===1){
//                $tipo='11A';
//            }else
//
//            //11N (Banco)                      11A (Banco)
//            //----------------------------------------------------------
//            //$cuentasAsiento[6D]=0            $cuentasAsiento[6D]=0
//            //$cuentasAsiento[6H]=0            $cuentasAsiento[6H]=0
//            //$cuentasAsiento[7D]=0            $cuentasAsiento[7D]=1
//            //$cuentasAsiento[7H]=1            $cuentasAsiento[7H]=0
//            //$cuentasAsiento[40D]=0           $cuentasAsiento[40D]=0
//            //$cuentasAsiento[40H]=0           $cuentasAsiento[40H]=0
//            //$cuentasAsiento[43D]=1           $cuentasAsiento[43D]=1
//            //$cuentasAsiento[43H]=1           $cuentasAsiento[43H]=1
//            //$cuentasAsiento[4720D]=0         $cuentasAsiento[4720D]=0
//            //$cuentasAsiento[4720H]=0         $cuentasAsiento[4720H]=0
//            //$cuentasAsiento[4770D]=0         $cuentasAsiento[4770D]=1
//            //$cuentasAsiento[4770H]=1         $cuentasAsiento[4770H]=0
//            //$cuentasAsiento[4730D]=0         $cuentasAsiento[4730D]=0
//            //$cuentasAsiento[4730H]=0         $cuentasAsiento[4730H]=0
//            //$cuentasAsiento[4751D]=0         $cuentasAsiento[4751D]=0
//            //$cuentasAsiento[4751H]=0         $cuentasAsiento[4751H]=0
//            //$cuentasAsiento[57D]=1           $cuentasAsiento[57D]=0
//            //$cuentasAsiento[57H]=0           $cuentasAsiento[57H]=1
//            //
//            // y $contIVA===1
//
//            if($c6D===0 && $c7D===0 && $c40D===0 && $c43D===1 && $c4720D===0 && $c4770D===0 && $c4730D===0 && $c4751D===0 && $c57D===1
//               && $c6H===0 && $c7H===1 && $c40H===0 && $c43H===1 && $c4720H===0 && $c4770H===1 && $c4730H===0 && $c4751H===0 && $c57H===0 && $contIVA===1){
//                $tipo='11N';
//            }else
//
//            if($c6D===0 && $c7D===1 && $c40D===0 && $c43D===1 && $c4720D===0 && $c4770D===1 && $c4730D===0 && $c4751D===0 && $c57D===0
//               && $c6H===0 && $c7H===0 && $c40H===0 && $c43H===1 && $c4720H===0 && $c4770H===0 && $c4730H===0 && $c4751H===0 && $c57H===1 && $contIVA===1){
//                $tipo='11A';
//            }else
//
//            //12N                              12A
//            //----------------------------------------------------------
//            //$cuentasAsiento[6D]=0            $cuentasAsiento[6D]=0
//            //$cuentasAsiento[6H]=0            $cuentasAsiento[6H]=0
//            //$cuentasAsiento[7D]=0            $cuentasAsiento[7D]=1
//            //$cuentasAsiento[7H]=1            $cuentasAsiento[7H]=0
//            //$cuentasAsiento[40D]=0           $cuentasAsiento[40D]=0
//            //$cuentasAsiento[40H]=0           $cuentasAsiento[40H]=0
//            //$cuentasAsiento[43D]=1           $cuentasAsiento[43D]=0
//            //$cuentasAsiento[43H]=0           $cuentasAsiento[43H]=1
//            //$cuentasAsiento[4720D]=0         $cuentasAsiento[4720D]=0
//            //$cuentasAsiento[4720H]=0         $cuentasAsiento[4720H]=0
//            //$cuentasAsiento[4770D]=0         $cuentasAsiento[4770D]=1
//            //$cuentasAsiento[4770H]=1         $cuentasAsiento[4770H]=0
//            //$cuentasAsiento[4730D]=1         $cuentasAsiento[4730D]=0
//            //$cuentasAsiento[4730H]=0         $cuentasAsiento[4730H]=1
//            //$cuentasAsiento[4751D]=0         $cuentasAsiento[4751D]=0
//            //$cuentasAsiento[4751H]=0         $cuentasAsiento[4751H]=0
//            //$cuentasAsiento[57D]=0           $cuentasAsiento[57D]=0
//            //$cuentasAsiento[57H]=0           $cuentasAsiento[57H]=0
//            //
//            // y $contIVA===1
//
//            if($c6D===0 && $c7D===0 && $c40D===0 && $c43D===1 && $c4720D===0 && $c4770D===0 && $c4730D===1 && $c4751D===0 && $c57D===0
//               && $c6H===0 && $c7H===1 && $c40H===0 && $c43H===0 && $c4720H===0 && $c4770H===1 && $c4730H===0 && $c4751H===0 && $c57H===0 && $contIVA===1){
//                $tipo='12N';
//            }else
//
//            if($c6D===0 && $c7D===1 && $c40D===0 && $c43D===0 && $c4720D===0 && $c4770D===1 && $c4730D===0 && $c4751D===0 && $c57D===0
//               && $c6H===0 && $c7H===0 && $c40H===0 && $c43H===1 && $c4720H===0 && $c4770H===0 && $c4730H===1 && $c4751H===0 && $c57H===0 && $contIVA===1){
//                $tipo='12A';
//            }else
//
//            //12N (Banco)                      12A (Banco)
//            //----------------------------------------------------------
//            //$cuentasAsiento[6D]=0            $cuentasAsiento[6D]=0
//            //$cuentasAsiento[6H]=0            $cuentasAsiento[6H]=0
//            //$cuentasAsiento[7D]=0            $cuentasAsiento[7D]=1
//            //$cuentasAsiento[7H]=1            $cuentasAsiento[7H]=0
//            //$cuentasAsiento[40D]=0           $cuentasAsiento[40D]=0
//            //$cuentasAsiento[40H]=0           $cuentasAsiento[40H]=0
//            //$cuentasAsiento[43D]=1           $cuentasAsiento[43D]=1
//            //$cuentasAsiento[43H]=1           $cuentasAsiento[43H]=1
//            //$cuentasAsiento[4720D]=0         $cuentasAsiento[4720D]=0
//            //$cuentasAsiento[4720H]=0         $cuentasAsiento[4720H]=0
//            //$cuentasAsiento[4770D]=0         $cuentasAsiento[4770D]=1
//            //$cuentasAsiento[4770H]=1         $cuentasAsiento[4770H]=0
//            //$cuentasAsiento[4730D]=1         $cuentasAsiento[4730D]=0
//            //$cuentasAsiento[4730H]=0         $cuentasAsiento[4730H]=1
//            //$cuentasAsiento[4751D]=0         $cuentasAsiento[4751D]=0
//            //$cuentasAsiento[4751H]=0         $cuentasAsiento[4751H]=0
//            //$cuentasAsiento[57D]=1           $cuentasAsiento[57D]=0
//            //$cuentasAsiento[57H]=0           $cuentasAsiento[57H]=1
//            //
//            // y $contIVA===1
//
//            if($c6D===0 && $c7D===0 && $c40D===0 && $c43D===1 && $c4720D===0 && $c4770D===0 && $c4730D===1 && $c4751D===0 && $c57D===1
//               && $c6H===0 && $c7H===1 && $c40H===0 && $c43H===1 && $c4720H===0 && $c4770H===1 && $c4730H===0 && $c4751H===0 && $c57H===0 && $contIVA===1){
//                $tipo='12N';
//            }else
//
//            if($c6D===0 && $c7D===1 && $c40D===0 && $c43D===1 && $c4720D===0 && $c4770D===1 && $c4730D===0 && $c4751D===0 && $c57D===0
//               && $c6H===0 && $c7H===0 && $c40H===0 && $c43H===1 && $c4720H===0 && $c4770H===0 && $c4730H===1 && $c4751H===0 && $c57H===1 && $contIVA===1){
//                $tipo='12A';
//            }else
//
//            //13N                              13A
//            //----------------------------------------------------------
//            //$cuentasAsiento[6D]=0            $cuentasAsiento[6D]=0
//            //$cuentasAsiento[6H]=0            $cuentasAsiento[6H]=0
//            //$cuentasAsiento[7D]=0            $cuentasAsiento[7D]=1
//            //$cuentasAsiento[7H]=1            $cuentasAsiento[7H]=0
//            //$cuentasAsiento[40D]=0           $cuentasAsiento[40D]=0
//            //$cuentasAsiento[40H]=0           $cuentasAsiento[40H]=0
//            //$cuentasAsiento[43D]=1           $cuentasAsiento[43D]=0
//            //$cuentasAsiento[43H]=0           $cuentasAsiento[43H]=1
//            //$cuentasAsiento[4720D]=0         $cuentasAsiento[4720D]=0
//            //$cuentasAsiento[4720H]=0         $cuentasAsiento[4720H]=0
//            //$cuentasAsiento[4770D]=0         $cuentasAsiento[4770D]=1
//            //$cuentasAsiento[4770H]=1         $cuentasAsiento[4770H]=0
//            //$cuentasAsiento[4730D]=0         $cuentasAsiento[4730D]=0
//            //$cuentasAsiento[4730H]=0         $cuentasAsiento[4730H]=0
//            //$cuentasAsiento[4751D]=0         $cuentasAsiento[4751D]=0
//            //$cuentasAsiento[4751H]=0         $cuentasAsiento[4751H]=0
//            //$cuentasAsiento[57D]=0           $cuentasAsiento[57D]=0
//            //$cuentasAsiento[57H]=0           $cuentasAsiento[57H]=0
//            //
//            // y $contIVA>1
//
//            if($c6D===0 && $c7D===0 && $c40D===0 && $c43D===1 && $c4720D===0 && $c4770D===0 && $c4730D===0 && $c4751D===0 && $c57D===0
//               && $c6H===0 && $c7H===1 && $c40H===0 && $c43H===0 && $c4720H===0 && $c4770H===1 && $c4730H===0 && $c4751H===0 && $c57H===0 && $contIVA>1){
//                $tipo='13N';
//            }else
//
//            if($c6D===0 && $c7D===1 && $c40D===0 && $c43D===0 && $c4720D===0 && $c4770D===1 && $c4730D===0 && $c4751D===0 && $c57D===0
//               && $c6H===0 && $c7H===0 && $c40H===0 && $c43H===1 && $c4720H===0 && $c4770H===0 && $c4730H===0 && $c4751H===0 && $c57H===0 && $contIVA>1){
//                $tipo='13A';
//            }else
//
//            //13N (Banco)                      13A (Banco)
//            //----------------------------------------------------------
//            //$cuentasAsiento[6D]=0            $cuentasAsiento[6D]=0
//            //$cuentasAsiento[6H]=0            $cuentasAsiento[6H]=0
//            //$cuentasAsiento[7D]=0            $cuentasAsiento[7D]=1
//            //$cuentasAsiento[7H]=1            $cuentasAsiento[7H]=0
//            //$cuentasAsiento[40D]=0           $cuentasAsiento[40D]=0
//            //$cuentasAsiento[40H]=0           $cuentasAsiento[40H]=0
//            //$cuentasAsiento[43D]=1           $cuentasAsiento[43D]=1
//            //$cuentasAsiento[43H]=1           $cuentasAsiento[43H]=1
//            //$cuentasAsiento[4720D]=0         $cuentasAsiento[4720D]=0
//            //$cuentasAsiento[4720H]=0         $cuentasAsiento[4720H]=0
//            //$cuentasAsiento[4770D]=0         $cuentasAsiento[4770D]=1
//            //$cuentasAsiento[4770H]=1         $cuentasAsiento[4770H]=0
//            //$cuentasAsiento[4730D]=0         $cuentasAsiento[4730D]=0
//            //$cuentasAsiento[4730H]=0         $cuentasAsiento[4730H]=0
//            //$cuentasAsiento[4751D]=0         $cuentasAsiento[4751D]=0
//            //$cuentasAsiento[4751H]=0         $cuentasAsiento[4751H]=0
//            //$cuentasAsiento[57D]=1           $cuentasAsiento[57D]=0
//            //$cuentasAsiento[57H]=0           $cuentasAsiento[57H]=1
//            //
//            // y $contIVA>1
//
//            if($c6D===0 && $c7D===0 && $c40D===0 && $c43D===1 && $c4720D===0 && $c4770D===0 && $c4730D===0 && $c4751D===0 && $c57D===1
//               && $c6H===0 && $c7H===1 && $c40H===0 && $c43H===1 && $c4720H===0 && $c4770H===1 && $c4730H===0 && $c4751H===0 && $c57H===0 && $contIVA>1){
//                $tipo='13N';
//            }else
//
//            if($c6D===0 && $c7D===1 && $c40D===0 && $c43D===1 && $c4720D===0 && $c4770D===1 && $c4730D===0 && $c4751D===0 && $c57D===0
//               && $c6H===0 && $c7H===0 && $c40H===0 && $c43H===1 && $c4720H===0 && $c4770H===0 && $c4730H===0 && $c4751H===0 && $c57H===1 && $contIVA>1){
//                $tipo='13A';
//            }else
//
//            //14N                              14A
//            //----------------------------------------------------------
//            //$cuentasAsiento[6D]=0            $cuentasAsiento[6D]=0
//            //$cuentasAsiento[6H]=0            $cuentasAsiento[6H]=0
//            //$cuentasAsiento[7D]=0            $cuentasAsiento[7D]=1
//            //$cuentasAsiento[7H]=1            $cuentasAsiento[7H]=0
//            //$cuentasAsiento[40D]=0           $cuentasAsiento[40D]=0
//            //$cuentasAsiento[40H]=0           $cuentasAsiento[40H]=0
//            //$cuentasAsiento[43D]=1           $cuentasAsiento[43D]=0
//            //$cuentasAsiento[43H]=0           $cuentasAsiento[43H]=1
//            //$cuentasAsiento[4720D]=0         $cuentasAsiento[4720D]=0
//            //$cuentasAsiento[4720H]=0         $cuentasAsiento[4720H]=0
//            //$cuentasAsiento[4770D]=0         $cuentasAsiento[4770D]=1
//            //$cuentasAsiento[4770H]=1         $cuentasAsiento[4770H]=0
//            //$cuentasAsiento[4730D]=1         $cuentasAsiento[4730D]=0
//            //$cuentasAsiento[4730H]=0         $cuentasAsiento[4730H]=1
//            //$cuentasAsiento[4751D]=0         $cuentasAsiento[4751D]=0
//            //$cuentasAsiento[4751H]=0         $cuentasAsiento[4751H]=0
//            //$cuentasAsiento[57D]=0           $cuentasAsiento[57D]=0
//            //$cuentasAsiento[57H]=0           $cuentasAsiento[57H]=0
//            //
//            // y $contIVA>1
//
//            if($c6D===0 && $c7D===0 && $c40D===0 && $c43D===1 && $c4720D===0 && $c4770D===0 && $c4730D===1 && $c4751D===0 && $c57D===0
//               && $c6H===0 && $c7H===1 && $c40H===0 && $c43H===0 && $c4720H===0 && $c4770H===1 && $c4730H===0 && $c4751H===0 && $c57H===0 && $contIVA>1){
//                $tipo='14N';
//            }else
//
//            if($c6D===0 && $c7D===1 && $c40D===0 && $c43D===0 && $c4720D===0 && $c4770D===1 && $c4730D===0 && $c4751D===0 && $c57D===0
//               && $c6H===0 && $c7H===0 && $c40H===0 && $c43H===1 && $c4720H===0 && $c4770H===0 && $c4730H===1 && $c4751H===0 && $c57H===0 && $contIVA>1){
//                $tipo='14A';
//            }else
//
//            //14N (Banco)                      14A (Banco)
//            //----------------------------------------------------------
//            //$cuentasAsiento[6D]=0            $cuentasAsiento[6D]=0
//            //$cuentasAsiento[6H]=0            $cuentasAsiento[6H]=0
//            //$cuentasAsiento[7D]=0            $cuentasAsiento[7D]=1
//            //$cuentasAsiento[7H]=1            $cuentasAsiento[7H]=0
//            //$cuentasAsiento[40D]=0           $cuentasAsiento[40D]=0
//            //$cuentasAsiento[40H]=0           $cuentasAsiento[40H]=0
//            //$cuentasAsiento[43D]=1           $cuentasAsiento[43D]=1
//            //$cuentasAsiento[43H]=1           $cuentasAsiento[43H]=1
//            //$cuentasAsiento[4720D]=0         $cuentasAsiento[4720D]=0
//            //$cuentasAsiento[4720H]=0         $cuentasAsiento[4720H]=0
//            //$cuentasAsiento[4770D]=0         $cuentasAsiento[4770D]=1
//            //$cuentasAsiento[4770H]=1         $cuentasAsiento[4770H]=0
//            //$cuentasAsiento[4730D]=1         $cuentasAsiento[4730D]=0
//            //$cuentasAsiento[4730H]=0         $cuentasAsiento[4730H]=1
//            //$cuentasAsiento[4751D]=0         $cuentasAsiento[4751D]=0
//            //$cuentasAsiento[4751H]=0         $cuentasAsiento[4751H]=0
//            //$cuentasAsiento[57D]=1           $cuentasAsiento[57D]=0
//            //$cuentasAsiento[57H]=0           $cuentasAsiento[57H]=1
//            //
//            // y $contIVA>1
//
//            if($c6D===0 && $c7D===0 && $c40D===0 && $c43D===1 && $c4720D===0 && $c4770D===0 && $c4730D===1 && $c4751D===0 && $c57D===1
//               && $c6H===0 && $c7H===1 && $c40H===0 && $c43H===1 && $c4720H===0 && $c4770H===1 && $c4730H===0 && $c4751H===0 && $c57H===0 && $contIVA>1){
//                $tipo='14N';
//            }else
//
//            if($c6D===0 && $c7D===1 && $c40D===0 && $c43D===1 && $c4720D===0 && $c4770D===1 && $c4730D===0 && $c4751D===0 && $c57D===0
//               && $c6H===0 && $c7H===0 && $c40H===0 && $c43H===1 && $c4720H===0 && $c4770H===0 && $c4730H===1 && $c4751H===0 && $c57H===1 && $contIVA>1){
//                $tipo='14A';
//            }else{
//                //sino es ninguna de las anteriores de 0 o 1 será tipo2 (por defecto)
//                $tipo='Tipo2';
//            }
////            }
//            
//            
//            //fecha 6/5/2014
//            $fechas =explode('-',$asiento['FechaApunte']);
//            $fecha=substr($fechas[2],0,2).'/'.$fechas[1].'/'.$fechas[0];
//            $ejercicio =$fechas[0];
//            
//            //preparamos los datos para la insercion
//
//            //ahora segun sea $tipo sabemos el tipo de asiento
//            switch ($tipo) {
//                case '10N':
//                    $OK2=$this->AltaIngresosMovimientosSinIVA($asiento['Asiento'], $_SESSION['idEmp'], $cuenta7, $cantidad7, $cuenta43,
//                                                              $cantidad43, $fecha, $optTipo, $cuenta57, $asiento['Periodo'],
//                                                              $ejercicio, $concepto, 'NO', $_SESSION['strUsuario']);
//                    //indico la fecha de la importacion en la tabla tbmovimientos
//                    if($OK2<>FALSE){
//                        $clsCADContabilidad->AsientoImportado_tbmovimientos($asiento['Asiento']);
//                        $clsCADContabilidad->ActualizarAsientoImportado_tbmovimientos($asiento['Asiento']);
//                    }
//                    break;
//                case '10A':
//                    $OK2=$this->AltaIngresosMovimientosSinIVA($asiento['Asiento'], $_SESSION['idEmp'], $cuenta7, $cantidad7, $cuenta43,
//                                                              $cantidad43, $fecha, $optTipo, $cuenta57, $asiento['Periodo'],
//                                                              $ejercicio, $concepto, 'SI', $_SESSION['strUsuario']);
//                    //indico la fecha de la importacion en la tabla tbmovimientos
//                    if($OK2<>FALSE){
//                        $clsCADContabilidad->AsientoImportado_tbmovimientos($asiento['Asiento']);
//                        $clsCADContabilidad->ActualizarAsientoImportado_tbmovimientos($asiento['Asiento']);
//                    }
//                    break;
//                case '11N':
//                    $OK2=$this->AltaIngresosMovimientos($asiento['Asiento'], $_SESSION['idEmp'], $cuenta7, $cantidad43, $cuenta43, $cantidad7,
//                                                        $iva, $porciento, $fecha, $optTipo, $cuenta57, $asiento['Periodo'],
//                                                        $ejercicio, $concepto, 'NO', $_SESSION['strUsuario']);
//                    //indico la fecha de la importacion en la tabla tbmovimientos
//                    if($OK2<>FALSE){
//                        $clsCADContabilidad->AsientoImportado_tbmovimientos($asiento['Asiento']);
//                        $clsCADContabilidad->ActualizarAsientoImportado_tbmovimientos($asiento['Asiento']);
//                    }
//                    break;
//                case '11A':
//                    $OK2=$this->AltaIngresosMovimientos($asiento['Asiento'], $_SESSION['idEmp'], $cuenta7, $cantidad43, $cuenta43, $cantidad7,
//                                                        abs($iva), $porciento, $fecha, $optTipo, $cuenta57, $asiento['Periodo'],
//                                                        $ejercicio, $concepto, 'SI', $_SESSION['strUsuario']);
//                    //indico la fecha de la importacion en la tabla tbmovimientos
//                    if($OK2<>FALSE){
//                        $clsCADContabilidad->AsientoImportado_tbmovimientos($asiento['Asiento']);
//                        $clsCADContabilidad->ActualizarAsientoImportado_tbmovimientos($asiento['Asiento']);
//                    }
//                    break;
//                case '13N':
//                    $OK2=$this->AltaIngresosMovimientosIVA_Varios($asiento['Asiento'], $_SESSION['idEmp'], $cuenta7, $cantidad43, $cuenta43, $cantidad7,
//                                                                  $cantidad4770, $fecha, $optTipo, $cuenta57, $asiento['Periodo'], $ejercicio,
//                                                                  $concepto, $_SESSION['strUsuario'],
//                                                                  $ivas['Base0'], 0, 0,
//                                                                  $ivas['Base4'], $ivas['Cuota4'], 4,
//                                                                  $ivas['Base10'], $ivas['Cuota10'], 10,
//                                                                  $ivas['Base21'], $ivas['Cuota21'], 21, 'NO');
//                    //indico la fecha de la importacion en la tabla tbmovimientos
//                    if($OK2<>FALSE){
//                        $clsCADContabilidad->AsientoImportado_tbmovimientos($asiento['Asiento']);
//                        $clsCADContabilidad->ActualizarAsientoImportado_tbmovimientos($asiento['Asiento']);
//                    }
//                    break;
//                case '13A':
//                    $OK2=$this->AltaIngresosMovimientosIVA_Varios($asiento['Asiento'], $_SESSION['idEmp'], $cuenta7, $cantidad43, $cuenta43, $cantidad7,
//                                                                  $cantidad4770, $fecha, $optTipo, $cuenta57, $asiento['Periodo'], $ejercicio,
//                                                                  $concepto, $_SESSION['strUsuario'],
//                                                                  abs($ivas['Base0']), 0, 0,
//                                                                  abs($ivas['Base4']), abs($ivas['Cuota4']), 4,
//                                                                  abs($ivas['Base10']), abs($ivas['Cuota10']), 10,
//                                                                  abs($ivas['Base21']), abs($ivas['Cuota21']), 21, 'SI');
//                    //indico la fecha de la importacion en la tabla tbmovimientos
//                    if($OK2<>FALSE){
//                        $clsCADContabilidad->AsientoImportado_tbmovimientos($asiento['Asiento']);
//                        $clsCADContabilidad->ActualizarAsientoImportado_tbmovimientos($asiento['Asiento']);
//                    }
//                    break;
//                case '12N':
//                    $OK2=$this->AltaIngresosMovimientosIRPF($asiento['Asiento'], $_SESSION['idEmp'], $cuenta7, $cuenta43, $cantidad7, $cantidad4770,
//                                                            $porciento, $cantidad4730, $PorcientoIRPF, $fecha, $optTipo, $cuenta57, $asiento['Periodo'], 
//                                                            $this->periodo($asiento['Periodo']), $ejercicio,  $concepto, 'NO', $_SESSION['strUsuario']);
//                    //indico la fecha de la importacion en la tabla tbmovimientos
//                    if($OK2<>FALSE){
//                        $clsCADContabilidad->AsientoImportado_tbmovimientos($asiento['Asiento']);
//                        $clsCADContabilidad->ActualizarAsientoImportado_tbmovimientos($asiento['Asiento']);
//                    }
//                    break;
//                case '12A':
//                    $OK2=$this->AltaIngresosMovimientosIRPF($asiento['Asiento'], $_SESSION['idEmp'], $cuenta7, $cuenta43, $cantidad7, $cantidad4770,
//                                                            $porciento, $cantidad4730, $PorcientoIRPF, $fecha, $optTipo, $cuenta57, $asiento['Periodo'], 
//                                                            $this->periodo($asiento['Periodo']), $ejercicio,  $concepto, 'SI', $_SESSION['strUsuario']);
//                    //indico la fecha de la importacion en la tabla tbmovimientos
//                    if($OK2<>FALSE){
//                        $clsCADContabilidad->AsientoImportado_tbmovimientos($asiento['Asiento']);
//                        $clsCADContabilidad->ActualizarAsientoImportado_tbmovimientos($asiento['Asiento']);
//                    }
//                    break;
//                case '14N':
//                    $OK2=$this->AltaIngresosMovimientosIVA_VariosIRPF($asiento['Asiento'], $_SESSION['idEmp'], $cuenta7, $cantidad43, $cuenta43, $cantidad7,
//                                                                      $cantidad4770, $fecha, $optTipo, $cuenta57, $asiento['Periodo'],
//                                                                      $ejercicio, $concepto, $_SESSION['strUsuario'],
//                                                                      $ivas['Base0'], 0, 0,
//                                                                      $ivas['Base4'], $ivas['Cuota4'], 4,
//                                                                      $ivas['Base10'], $ivas['Cuota10'], 10,
//                                                                      $ivas['Base21'], $ivas['Cuota21'], 21,
//                                                                      'NO', $PorcientoIRPF, $cantidad4730);
//                    //indico la fecha de la importacion en la tabla tbmovimientos
//                    if($OK2<>FALSE){
//                        $clsCADContabilidad->AsientoImportado_tbmovimientos($asiento['Asiento']);
//                        $clsCADContabilidad->ActualizarAsientoImportado_tbmovimientos($asiento['Asiento']);
//                    }
//                    break;
//                case '14A':
//                    $OK2=$this->AltaIngresosMovimientosIVA_VariosIRPF($asiento['Asiento'], $_SESSION['idEmp'], $cuenta7, $cantidad43, $cuenta43, $cantidad7,
//                                                                      $cantidad4770, $fecha, $optTipo, $cuenta57, $asiento['Periodo'],
//                                                                      $ejercicio, $concepto, $_SESSION['strUsuario'],
//                                                                      abs($ivas['Base0']), 0, 0,
//                                                                      abs($ivas['Base4']), abs($ivas['Cuota4']), 4,
//                                                                      abs($ivas['Base10']), abs($ivas['Cuota10']), 10,
//                                                                      abs($ivas['Base21']), abs($ivas['Cuota21']), 21,
//                                                                      'SI', $PorcientoIRPF, $cantidad4730);
//                    //indico la fecha de la importacion en la tabla tbmovimientos
//                    if($OK2<>FALSE){
//                        $clsCADContabilidad->AsientoImportado_tbmovimientos($asiento['Asiento']);
//                        $clsCADContabilidad->ActualizarAsientoImportado_tbmovimientos($asiento['Asiento']);
//                    }
//                    break;
//                case '00N':
//                    $OK2=$this->AltaGastosMovimientosSinIVA($asiento['Asiento'], $_SESSION['idEmp'], $cuenta6, $cantidad6, $cuenta40, $cantidad40,
//                                                            $fecha, $optTipo, $cuenta57, $asiento['Periodo'], $ejercicio,
//                                                            $concepto, 'NO', $_SESSION['strUsuario']);
//                    //indico la fecha de la importacion en la tabla tbmovimientos
//                    if($OK2<>FALSE){
//                        $clsCADContabilidad->AsientoImportado_tbmovimientos($asiento['Asiento']);
//                        $clsCADContabilidad->ActualizarAsientoImportado_tbmovimientos($asiento['Asiento']);
//                    }
//                    break;
//                case '00A':
//                    $OK2=$this->AltaGastosMovimientosSinIVA($asiento['Asiento'], $_SESSION['idEmp'], $cuenta6, $cantidad6, $cuenta40, $cantidad40,
//                                                            $fecha, $optTipo, $cuenta57, $asiento['Periodo'], $ejercicio,
//                                                            $concepto, 'SI', $_SESSION['strUsuario']);
//                    //indico la fecha de la importacion en la tabla tbmovimientos
//                    if($OK2<>FALSE){
//                        $clsCADContabilidad->AsientoImportado_tbmovimientos($asiento['Asiento']);
//                        $clsCADContabilidad->ActualizarAsientoImportado_tbmovimientos($asiento['Asiento']);
//                    }
//                    break;
//                case '01N':
//                    $OK2=$this->AltaGastosMovimientos($asiento['Asiento'], $_SESSION['idEmp'], $cuenta6, $cantidad40, $cuenta40, $cantidad6, $cantidad4720,
//                                                      $porciento, $fecha, $optTipo, $cuenta57, $asiento['Periodo'], $ejercicio,
//                                                      $concepto, 'NO', $_SESSION['strUsuario']);
//                    //indico la fecha de la importacion en la tabla tbmovimientos
//                    if($OK2<>FALSE){
//                        $clsCADContabilidad->AsientoImportado_tbmovimientos($asiento['Asiento']);
//                        $clsCADContabilidad->ActualizarAsientoImportado_tbmovimientos($asiento['Asiento']);
//                    }
//                    break;
//                case '01A':
//                    $OK2=$this->AltaGastosMovimientos($asiento['Asiento'], $_SESSION['idEmp'], $cuenta6, $cantidad40, $cuenta40, $cantidad6, $cantidad4720,
//                                                      $porciento, $fecha, $optTipo, $cuenta57, $asiento['Periodo'], $ejercicio,
//                                                      $concepto, 'SI', $_SESSION['strUsuario']);
//                    //indico la fecha de la importacion en la tabla tbmovimientos
//                    if($OK2<>FALSE){
//                        $clsCADContabilidad->AsientoImportado_tbmovimientos($asiento['Asiento']);
//                        $clsCADContabilidad->ActualizarAsientoImportado_tbmovimientos($asiento['Asiento']);
//                    }
//                    break;
//                case '03N':
//                    $OK2=$this->AltaGastosMovimientosIVA_Varios($asiento['Asiento'], $_SESSION['idEmp'], $cuenta6, $cantidad40, $cuenta40, $cantidad6, 
//                                                                $cantidad4720, $fecha, $optTipo, $cuenta57, $asiento['Periodo'], $ejercicio, $concepto, $_SESSION['strUsuario'],
//                                                                abs($ivas['Base0']), 0, 0,
//                                                                abs($ivas['Base4']), abs($ivas['Cuota4']), 4,
//                                                                abs($ivas['Base10']), abs($ivas['Cuota10']), 10,
//                                                                abs($ivas['Base21']), abs($ivas['Cuota21']), 21, 'NO');
//                    //indico la fecha de la importacion en la tabla tbmovimientos
//                    if($OK2<>FALSE){
//                        $clsCADContabilidad->AsientoImportado_tbmovimientos($asiento['Asiento']);
//                        $clsCADContabilidad->ActualizarAsientoImportado_tbmovimientos($asiento['Asiento']);
//                    }
//                    break;
//                case '03A':
//                    $OK2=$this->AltaGastosMovimientosIVA_Varios($asiento['Asiento'], $_SESSION['idEmp'], $cuenta6, $cantidad40, $cuenta40, $cantidad6, 
//                                                                $cantidad4720, $fecha, $optTipo, $cuenta57, $asiento['Periodo'], $ejercicio, $concepto, $_SESSION['strUsuario'],
//                                                                abs($ivas['Base0']), 0, 0,
//                                                                abs($ivas['Base4']), abs($ivas['Cuota4']), 4,
//                                                                abs($ivas['Base10']), abs($ivas['Cuota10']), 10,
//                                                                abs($ivas['Base21']), abs($ivas['Cuota21']), 21, 'SI');
//                    //indico la fecha de la importacion en la tabla tbmovimientos
//                    if($OK2<>FALSE){
//                        $clsCADContabilidad->AsientoImportado_tbmovimientos($asiento['Asiento']);
//                        $clsCADContabilidad->ActualizarAsientoImportado_tbmovimientos($asiento['Asiento']);
//                    }
//                    break;
//                case '02N':
//                    $OK2=$this->AltaGastosMovimientosIRPF($asiento['Asiento'], $_SESSION['idEmp'], $cuenta6, $cuenta40, $cantidad6, $cantidad4720, $porciento,
//                                                          $cantidad4751, $PorcientoIRPF, $fecha, $optTipo, $cuenta57, $asiento['Periodo'],
//                                                          $this->periodo($asiento['Periodo']), $ejercicio, $concepto, 'NO', $_SESSION['strUsuario']);
//                    //indico la fecha de la importacion en la tabla tbmovimientos
//                    if($OK2<>FALSE){
//                        $clsCADContabilidad->AsientoImportado_tbmovimientos($asiento['Asiento']);
//                        $clsCADContabilidad->ActualizarAsientoImportado_tbmovimientos($asiento['Asiento']);
//                    }
//                    break;
//                case '02A':
//                    $OK2=$this->AltaGastosMovimientosIRPF($asiento['Asiento'], $_SESSION['idEmp'], $cuenta6, $cuenta40, $cantidad6, $cantidad4720, $porciento,
//                                                          $cantidad4751, $PorcientoIRPF, $fecha, $optTipo, $cuenta57, $asiento['Periodo'],
//                                                          $this->periodo($asiento['Periodo']), $ejercicio, $concepto, 'SI', $_SESSION['strUsuario']);
//                    //indico la fecha de la importacion en la tabla tbmovimientos
//                    if($OK2<>FALSE){
//                        $clsCADContabilidad->AsientoImportado_tbmovimientos($asiento['Asiento']);
//                        $clsCADContabilidad->ActualizarAsientoImportado_tbmovimientos($asiento['Asiento']);
//                    }
//                    break;
//                case '04N':
//                    $OK2=$this->AltaGastosMovimientosIVA_VariosIRPF($asiento['Asiento'], $_SESSION['idEmp'], $cuenta6, $cantidad40, $cuenta40, $cantidad6, $cantidad4720,
//                                                                    $fecha, $optTipo, $cuenta57, $asiento['Periodo'], $ejercicio, $concepto, $_SESSION['strUsuario'], 
//                                                                    abs($ivas['Base0']), 0, 0,
//                                                                    abs($ivas['Base4']), abs($ivas['Cuota4']), 4,
//                                                                    abs($ivas['Base10']), abs($ivas['Cuota10']), 10,
//                                                                    abs($ivas['Base21']), abs($ivas['Cuota21']), 21,
//                                                                    'NO', $PorcientoIRPF, $cantidad4751);
//                    //indico la fecha de la importacion en la tabla tbmovimientos
//                    if($OK2<>FALSE){
//                        $clsCADContabilidad->AsientoImportado_tbmovimientos($asiento['Asiento']);
//                        $clsCADContabilidad->ActualizarAsientoImportado_tbmovimientos($asiento['Asiento']);
//                    }
//                    break;
//                case '04A':
//                    $OK2=$this->AltaGastosMovimientosIVA_VariosIRPF($asiento['Asiento'], $_SESSION['idEmp'], $cuenta6, $cantidad40, $cuenta40, $cantidad6, $cantidad4720,
//                                                                    $fecha, $optTipo, $cuenta57, $asiento['Periodo'], $ejercicio, $concepto, $_SESSION['strUsuario'], 
//                                                                    abs($ivas['Base0']), 0, 0,
//                                                                    abs($ivas['Base4']), abs($ivas['Cuota4']), 4,
//                                                                    abs($ivas['Base10']), abs($ivas['Cuota10']), 10,
//                                                                    abs($ivas['Base21']), abs($ivas['Cuota21']), 21,
//                                                                    'SI', $PorcientoIRPF, $cantidad4751);
//                    //indico la fecha de la importacion en la tabla tbmovimientos
//                    if($OK2<>FALSE){
//                        $clsCADContabilidad->AsientoImportado_tbmovimientos($asiento['Asiento']);
//                        $clsCADContabilidad->ActualizarAsientoImportado_tbmovimientos($asiento['Asiento']);
//                    }
//                    break;
//                case 'Tipo2':
//                    //extraemos los datos de este asiento original
//                    $datosDebeAsiento=$this->leeAsiento($asiento['Asiento'],'D');
//                    $datosHaberAsiento=$this->leeAsiento($asiento['Asiento'],'H');
//
//                    $datosAsientoOriginal='';
//                    for($i=1;$i<=count($datosDebeAsiento);$i++){
//                        $datosAsientoOriginal[]=array(
//                                                    "IdMovimiento"=>$datosDebeAsiento[$i]["IdMovimiento"],
//                                                    "asiento"=>$datosDebeAsiento[$i]["asiento"],
//                                                    "cuenta"=>$datosDebeAsiento[$i]["cuenta"],
//                                                    "periodo"=>$datosDebeAsiento[$i]["periodo"],
//                                                    "ejercicio"=>$datosDebeAsiento[$i]["ejercicio"],
//                                                    "orden"=>$datosDebeAsiento[$i]["orden"],
//                                                    "concepto"=>$datosDebeAsiento[$i]["concepto"],
//                                                    "cantidad"=>$datosDebeAsiento[$i]["cantidad"],
//                                                    "DoH"=>"D"
//                                                    );
//                    }
//                    for($i=1;$i<=count($datosHaberAsiento);$i++){
//                        $datosAsientoOriginal[]=array(
//                                                    "IdMovimiento"=>$datosHaberAsiento[$i]["IdMovimiento"],
//                                                    "asiento"=>$datosDebeAsiento[$i]["asiento"],
//                                                    "cuenta"=>$datosHaberAsiento[$i]["cuenta"],
//                                                    "periodo"=>$datosHaberAsiento[$i]["periodo"],
//                                                    "ejercicio"=>$datosHaberAsiento[$i]["ejercicio"],
//                                                    "orden"=>$datosHaberAsiento[$i]["orden"],
//                                                    "concepto"=>$datosHaberAsiento[$i]["concepto"],
//                                                    "cantidad"=>$datosHaberAsiento[$i]["cantidad"],
//                                                    "DoH"=>"H"
//                                                    );
//                    }
//        
//                    $OK2 = $this->EditarIngresosGastos($asiento['Asiento'],$datosAsientoOriginal, $_SESSION["idEmp"],
//                            $cuentasAsiento['OTRAS'],$fecha,$asiento['Periodo'], $ejercicio, $_SESSION["strUsuario"]);   
////                    $OK2 = $this->AltaIngresosGastos($asiento['Asiento'],$cuentasAsiento['OTRAS'],$fecha,$asiento['Periodo'], $ejercicio, $_SESSION["strUsuario"]);   
//                    
//                    //indico la fecha de la importacion en la tabla tbmovimientos
//                    if($OK2<>FALSE){
//                        $clsCADContabilidad->AsientoImportado_tbmovimientos($asiento['Asiento']);
//                        $clsCADContabilidad->ActualizarAsientoImportado_tbmovimientos($asiento['Asiento']);
//                    }
//                    break;
//            }
//
//
//            //si hubiese error al insertar volvemos a dar de alta el asiento antiguo (si existiese , claro)
//            if($OK2==FALSE && $clsCADContabilidad->existeAsiento($asiento['Asiento'])==='SI'){
//                //como ha fallado la insercion de los nuevos datos volvemos a dar de alta el asiento que habias dado de baja antes
//                $this->DarAltaAsiento($mov['Asiento']);
//            }
//        }
//        
//        //se a importado correctamente
//        $listadosResultados=array(
//            'Exportado'=>'SI',
//                'error'=>"Se a importado correctamente los datos de la BBDD<br/>",
//        );
//        
//        return $listadosResultados;
//    }

    function AsientoImportado_tbmovimientos($Asiento){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->AsientoImportado_tbmovimientos()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->AsientoImportado_tbmovimientos($Asiento);
    }
    
    function ActualizarAsientoImportado_tbmovimientos($Asiento){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->ExportarAsientoContabil()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->ActualizarAsientoImportado_tbmovimientos($Asiento);
    }
    
    function NuevoAsiento(){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->NuevoAsiento()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->NuevoAsiento();
    }

    public function ExisteCuenta($mov) {
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->ExisteCuenta()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->ExisteCuenta($mov);
    }

    function datosIncidencia($IdIncidencia){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->datosIncidencia($IdIncidencia)>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->datosIncidencia($IdIncidencia);
    }
    
    function EditarIncidencia($post,$listIdEmpleados,$usuario){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->EditarIncidencia()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->EditarIncidencia($post,$listIdEmpleados,$usuario);
    }
    
    function AltaIncidencia($post,$usuario){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->AltaIncidencia()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->AltaIncidencia($post,$usuario);
    }
    
    function Incidencia_adjunto_nuevo_id(){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->Incidencia_adjunto_nuevo_id()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->Incidencia_adjunto_nuevo_id();
    }
    
    function AltaEmpleado_incidencia_adj($IdIncidencia,$IdAdjunto,$nombre,$strDescFichero){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->AltaEmpleado_incidencia_adj()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->AltaEmpleado_incidencia_adj($IdIncidencia,$IdAdjunto,$nombre,$strDescFichero);
    }
    
    function ListadoIncidencias($get)
    {
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->ListadoIncidencias()>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->ListadoIncidencias($get);
    }        
    
    function ListadoEmpleadosIncidencia($IdIncidencia){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->ListadoEmpleadosIncidencia($IdIncidencia)>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->ListadoEmpleadosIncidencia($IdIncidencia);
    }
    
    function calculoDatosNominas($lngEjercicio){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->calculoDatosNominas($lngEjercicio)>");

        require_once '../general/Classes/PHPExcel.php';
        
        
        //leere el fichero xls del año seleccionado (formato "Nominas 2014.xls")
        //directorio
        $directorio = "../doc/doc-".$_SESSION['base'].'/';
        $fichero = 'Nominas '.$lngEjercicio.'.xls';
        
        $url = $directorio.$fichero;

        //leo el fichero
        $XLFileType = PHPExcel_IOFactory::identify($url);  
        $objReader = PHPExcel_IOFactory::createReader($XLFileType);  
        $objPHPExcel = $objReader->load($url);  
        
        //leo los nombres de las hojas (meses)
        $meses = $objReader->listWorksheetNames($url);
        
        
        //array donde guardo los datos a extraer
        $nominas['TOTAL DEVENGOS'] = '';
        $nominas['DEDUCCIONES S.S.'] = '';
        $nominas['RETENCION IRPF'] = '';
        $nominas['TOTAL LIQUIDO'] = '';
        $nominas['TOTAL COSTE S.S.'] = '';
        $nominas['TOTAL'] = '';
        foreach($meses as $mes){
            //nombre del mes
            $mesTxt = $mes;
            $datoMes = $objPHPExcel->setActiveSheetIndexByName($mesTxt);
            
            //ahora leo los datos que tengan este apartado y sea los que estan en este array
            $apartadosBuscados[0] = "TOTAL DEVENGOS";
            $apartadosBuscados[1] = "838";//DEDUCCIONES S.S.
            $apartadosBuscados[2] = "840";//DEDUCCIONES S.S.
            $apartadosBuscados[3] = "762 RETEN.IRPF";//RETENCION IRPF
            $apartadosBuscados[4] = "862 RETEN.IRPF";//RETENCION IRPF
            $apartadosBuscados[5] = "TOTAL LIQUIDO";
            $apartadosBuscados[6] = "TOTAL COSTE S.S.";
            $apartadosBuscados[7] = "TOTAL";

            //para extraerlos recorro con otro while de arriba a abajo la columna A (titulos de los datos)
            // y la columna que se este leyendo en ese momento (del empleado)
            $posDatosNominasFila=13;
            while(true){
                //ahora extraigo los datos de las nominas
                //voy comprobando que la columna A que leo no este vacia
                $datoTitulo = trim(utf8_decode($datoMes->getCell('A'.$posDatosNominasFila)->getFormattedValue()));
                if($datoTitulo<>''){
                    //ahora compruebo, si este valor es valido lo guardo, sino no
                    if($datoTitulo === $apartadosBuscados[0] || $datoTitulo === $apartadosBuscados[5] ||
                       $datoTitulo === $apartadosBuscados[6] || $datoTitulo === $apartadosBuscados[7]){
                        $nominas[$datoTitulo][$mesTxt] = $this->formatearNumeroExcel($datoMes->getCell('B'.$posDatosNominasFila)->getFormattedValue());
                    }else if((strpos($datoTitulo,$apartadosBuscados[1]) !== false) || (strpos($datoTitulo,$apartadosBuscados[2]) !== false)){
                        $cantidad = desFormateaNumeroContabilidad($nominas['DEDUCCIONES S.S.'][$mesTxt]);
                        $cantidad = $cantidad + desFormateaNumeroContabilidad($this->formatearNumeroExcel($datoMes->getCell('B'.$posDatosNominasFila)->getFormattedValue()));
                        $nominas['DEDUCCIONES S.S.'][$mesTxt] = formateaNumeroContabilidad($cantidad);
                    }else if((strpos($datoTitulo,$apartadosBuscados[3]) !== false) || (strpos($datoTitulo,$apartadosBuscados[4]) !== false)){
                        $cantidad = desFormateaNumeroContabilidad($nominas['RETENCION IRPF'][$mesTxt]);
                        $cantidad = $cantidad + desFormateaNumeroContabilidad($this->formatearNumeroExcel($datoMes->getCell('B'.$posDatosNominasFila)->getFormattedValue()));
                        $nominas['RETENCION IRPF'][$mesTxt] = formateaNumeroContabilidad($cantidad);
                    }
                }else{
                    //dejo de insertar datos de este empleado
                    break;
                }
                //bajo una posicion
                $posDatosNominasFila++;
            }
        }
        
        return $nominas;

        
        
        //CODIGO PARA EL DIA QUE HAYA QUE EXTRAER A TODOS LOS EMPLEADOS POR MESES DE UN EJERCICIO (AÑO)
        //CREO QUE HABRA QUE HACERLO POR AJAX,TARDA BASTANTE ENEXTRAER LOS DATOS DEL EXCEL (19-01-2015)
//        //array donde guardo los datos a extraer
//        $nominas = '';
//        foreach($sheets as $sheet){
//            //nombre del mes
//            $mesTxt = $sheet;
//            $datoMes = $objPHPExcel->setActiveSheetIndexByName($mesTxt);
//
//            //recorro la hoja en sentido de izda a dcha
//            //busco desde la celda C8 (la primera que tiene valores)
//            //este bucle (while) terminara cuando alguna celda de la serie C8,D8,E8,F8... este vacia
//
//            //buscamos el empleado
//            $posColumn='C';
//            $posNumEmpleado=8;
//            $posNombreEmpleado=9;
//            $posApellido1Empleado=10;
//            $posApellido2Empleado=11;
//            $posFechaContratoEmpleado=12;
//
//            $posInicial = $posColumn.$posNumEmpleado;
//            
//            $indice=1;
//            while (true) {
//                //extraigo dato
//                $numeroEmpleado = $datoMes->getCell($posInicial)->getFormattedValue();
//                //compruebo que haya datos
//                if($numeroEmpleado<>''){
//                    //si lo hay los extraigo en el array
//                    $nominas[$sheet][$indice]['Numero'] = $numeroEmpleado;
//
//                    //extraigo el nombre y apellidos
//                    $nominas[$sheet][$indice]['Nombre'] = utf8_decode($datoMes->getCell($posColumn.$posNombreEmpleado)->getFormattedValue());
//                    $nominas[$sheet][$indice]['Apellido1'] = utf8_decode($datoMes->getCell($posColumn.$posApellido1Empleado)->getFormattedValue());
//                    $nominas[$sheet][$indice]['Apellido2'] = utf8_decode($datoMes->getCell($posColumn.$posApellido2Empleado)->getFormattedValue());
//                    $nominas[$sheet][$indice]['FechaContrato'] = utf8_decode($datoMes->getCell($posColumn.$posFechaContratoEmpleado)->getFormattedValue());
//
//                    //para extraerlos recorro con otro while de arriba a abajo la columna A (titulos de los datos)
//                    // y la columna que se este leyendo en ese momento (del empleado)
//                    $posDatosNominasFila=13;
//                    while(true){
//                        //ahora extraigo los datos de las nominas
//                        //voy comprobando que la columna A que leo no este vacia
//                        $datoTitulo = trim(utf8_decode($datoMes->getCell('A'.$posDatosNominasFila)->getFormattedValue()));
//                        if($datoTitulo<>''){
//                            //ahora leo los datos que tengan este apartado y sea los que stan en este array
//                            $apartadosBuscados[0] = "TOTAL DEVENGOS";
//                            $apartadosBuscados[1] = "TOTAL RETENCION";
//                            $apartadosBuscados[2] = "TOTAL LIQUIDO";
//                            $apartadosBuscados[3] = "TOTAL COSTE S.S.";
//                            $apartadosBuscados[4] = "TOTAL";
//                            
//                            //ahora compruebo, si este valor es valido lo guardo, sino no
//                            if($datoTitulo === $apartadosBuscados[0] || $datoTitulo === $apartadosBuscados[1] ||
//                               $datoTitulo === $apartadosBuscados[2] || $datoTitulo === $apartadosBuscados[3]
//                               || $datoTitulo === $apartadosBuscados[4]){
//                                $nominas[$sheet][$indice][$datoTitulo] = utf8_decode($datoMes->getCell($posColumn.$posDatosNominasFila)->getFormattedValue());
//                               }
//                        }else{
//                            //dejo de insertar datos de este empleado
//                            break;
//                        }
//                        //bajo una posicion
//                        $posDatosNominasFila++;
//                    }
//
//                }else{
//                    //salgo del while
//                    break;
//                }
//                //avanzo la posicion inicial
//                $this->avanzarLetra($posColumn);
//                $posInicial = $posColumn.$posNumEmpleado;
//                $indice ++;
//            }
//        }
//        var_dump($nominas);die;
        //FIN
    }
    
    //cambiar comas por puntos y puntos por comas en los numeros
    private function formatearNumeroExcel($numero){
        //cambio , por ; (valor intermedio
        $numero = str_replace(',',';',$numero);
        $numero = str_replace('.',',',$numero);
        $numero = str_replace(';','.',$numero);
        
        return $numero;
    }
    
    //para avanzar las columnas, que son letras
    private function avanzarLetra(&$var){
        //compruebo que la ultima letra es Z (Ej-> Z, CZ)
        if(substr($var,-1) === 'Z'){
            //extraigo el resto de las letras anteriores (Sobre Ej anterior -> Vacio, C)
            $resto = substr($var,0,strlen($var)-1);
            if($resto === ''){
                //si Vacio
                $var = 'AA';
            }else{
                // si tiene letras
                $resto = chr(ord($resto)+1);
                $var = $resto.'A';
            }
        }else{
            //sino no es Z la ultima letra
            //compruebo l numero de letras es superior a 1
            if(strlen($var) > 1){
                //divido el texto (Ej: BC: ultima C, restoLetras B)
                $ultima = substr($var,-1);
                $restoLetras = substr($var,0,strlen($var)-1);
                //avanzo la ultima letra (Ej C: pasa a D)
                $nuevaLetra = chr(ord($ultima)+1);
                //la nueva posicion es (Ej restoLetras: B + nuevaLetra:D -> BD
                $var = $restoLetras.$nuevaLetra;
            }else{
                //solo hay una letra y no es la Z
                $var = chr(ord($var)+1); 
            } 
        }

        return true; 
    }
    
    
    function ejerciciosNominas(){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->ejerciciosNominas()>");

        //leemos de la carpeta los ficheros de excel que se llamen 'Nominas 2014.xls' 
        //y son los que incluiremos en el listado a devolver 
        //sera un array con [año][nombre fichero]
        
        $directorio = opendir("../doc/doc-".$_SESSION['base']); //ruta
        $listado = '';
        $ii = 0;
        while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
        {
            if (!is_dir($archivo))//verificamos si es o no un directorio
            {
                //veo si comienza por 'Nominas' y termina por 'xls', es el que buscamos
                if((substr($archivo,0,7) == 'Nominas') && (substr($archivo,-3) === 'xls')){
                    $listado[$ii]['ejercicio'] = substr($archivo,8,4);
                    $listado[$ii]['archivo'] = $archivo;
                    $ii++;
                }
            }
        }        
        
        return $listado;
    }
    
    function listadoEmpleadosInicial(){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNContabilidad->listadoEmpleadosInicial()>");

        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad = new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        $listadoEmpleadoInicial = $clsCADContabilidad->listadoEmpleadosInicial();
        
        //ahora veo la gente que tiene en vigor el contrato a dia de hoy
        //veo el campo fechaBaja >= hoy
        //y veo el campo fechaVtoContrato >= hoy
        //(he preferido hacer esto aqui y no en la consulta de SQL)

        $listadoEmpleado = '';
        for ($i = 0; $i < count($listadoEmpleadoInicial); $i++) {
            //para ser valido se tiene que cumplir que fechaBaja y fechaVtoContrato sea validos
            //para ello se tiene que cumplir una de estas condiciones para ambos:
            //1º fechaBaja = NULL
            //2º fechaBaja = 00/00/0000
            //3º fechaBaja >= hoy
            //(lo mismo para fechaVtoContrato)
            
            $validoBaja = false;
            $validoVto = false;
            
            $valorBaja = $listadoEmpleadoInicial[$i]['fechaBaja'];
            $valorVto = $listadoEmpleadoInicial[$i]['VtoContrato'];
            
            //fechaBaja
            if(($valorBaja === null) || ($valorBaja === '00/00/0000') || (fecha_to_DATETIME($valorBaja) >= date('Y-m-d H:i:s'))){
                $validoBaja = true;
            }
            
            //fechaBaja
            if(($valorVto === null) || ($valorVto === '00/00/0000') || (fecha_to_DATETIME($valorVto) >= date('Y-m-d H:i:s'))){
                $validoVto = true;
            }
            
            //para que sea valido ambos deben haber cumplidos los requisitos anteriores
            if(($validoBaja === true) && ($validoVto === true)){
                //lo incluimos en el listado final
                $listadoEmpleado[] = $listadoEmpleadoInicial[$i];
            }
        }

        //devuelto la lista final
        return $listadoEmpleado;
    }
    
    function EmpleadoNumPregunta($IdEmpleado){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->EmpleadoNumPregunta($IdEmpleado)>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->EmpleadoNumPregunta($IdEmpleado);
    }
    
    function tieneRespuestasLaPreguntaDelEmpleado($IdEmpleado){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->tieneRespuestasLaPreguntaDelEmpleado($IdEmpleado)>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->tieneRespuestasLaPreguntaDelEmpleado($IdEmpleado);
    }
    
    function IncidenciasCerrarPorListadoEmpleados($listIdEmpleados){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->IncidenciasCerrarPorListadoEmpleados()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->IncidenciasCerrarPorListadoEmpleados($listIdEmpleados);
    }
    
    function IncidenciasCerrarPorListadoIncidencias($listIdIncidencias){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->IncidenciasCerrarPorListadoIncidencias()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->IncidenciasCerrarPorListadoIncidencias($listIdIncidencias);
    }
    
    function FacturaCobro($numeroFactura,$cantidad,$fecha,$strCuentaBancos){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->FacturaCobro()>");
        
        //preparo el dato de la cuenta de la forma de cobro
        $cuenta = substr($strCuentaBancos,0,9);
        
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->FacturaCobro($numeroFactura,$cantidad,$fecha,$cuenta);
    }
    
    function FacturasCobrosGrafica(){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->FacturasCobrosGrafica()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->FacturasCobrosGrafica();
    }
    
    function listadoTiposFactura(){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->listadoTiposFactura()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->listadoTiposFactura();
    }
    
    function nombreFacturaFichero($FacturaTipo){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->nombreFacturaFichero($FacturaTipo)>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->nombreFacturaFichero($FacturaTipo);
    }
    
    function listadoCuentas($filtro){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->listadoCuentas($filtro)>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->listadoCuentas($filtro);
    }
    
    function ListadoArticulos($get){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->ListadoArticulos()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->ListadoArticulos($get);
    }
    
    function LeeArticulo($Id){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->LeeArticulo($Id)>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->LeeArticulo($Id);
    }
    
    function AltaArticulo($post){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->AltaArticulo()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->AltaArticulo($post);
    }
    
    function BorrarArticulo($Id){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->BorrarArticulo($Id)>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->BorrarArticulo($Id);
    }
    
    function EditarArticulo($post){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->EditarArticulo()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->EditarArticulo($post);
    }
    
    function listarCuentasArticulos(){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->listarCuentasArticulos()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->listarCuentasArticulos();
    }
    
    function ListadoGruposArticulos(){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->ListadoGruposArticulos()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->ListadoGruposArticulos();
    }
    
    function ListadoArticulosDeGrupo($IdGrupo){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->ListadoArticulosDeGrupo($IdGrupo)>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->ListadoArticulosDeGrupo($IdGrupo);
    }
    
    function nombreGrupoArticulo($IdGrupoListar){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->nombreGrupoArticulo($IdGrupoListar)>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->nombreGrupoArticulo($IdGrupoListar);
    }
    
    function LeeGrupo($Id){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->LeeGrupo($Id)>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->LeeGrupo($Id);
    }
    
    function EditarGrupoArticulo($post){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->EditarGrupoArticulo()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->EditarGrupoArticulo($post);
    }
    
    function AltaGrupoArticulo($post){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->AltaGrupoArticulo()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->AltaGrupoArticulo($post);
    }
    
    function PonerIdArticuloACeroPresupuesto($varRes){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->PonerIdArticuloACeroPresupuesto($varRes)>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->PonerIdArticuloACeroPresupuesto($varRes);
    }
    
    function PonerIdArticuloACeroFactura($varRes){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->PonerIdArticuloACeroFactura($varRes)>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->PonerIdArticuloACeroFactura($varRes);
    }
    
    function PonerIdArticuloACeroPedido($varRes){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->PonerIdArticuloACeroPedido($varRes)>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->PonerIdArticuloACeroPedido($varRes);
    }
    
    function ActualizarLineaPresupuesto($post,$IdArticulo){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->ActualizarLineaPresupuesto()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->ActualizarLineaPresupuesto($post,$IdArticulo);
    }
    
    function ActualizarLineaFactura($post,$IdArticulo){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->ActualizarLineaFactura()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->ActualizarLineaFactura($post,$IdArticulo);
    }
    
    function ActualizarLineaPedido($post,$IdArticulo){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->ActualizarLineaPedido()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->ActualizarLineaPedido($post,$IdArticulo);
    }
    
    function ArticuloIdArticuloACeroEnPresupuesto($IdPresupLinea){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->ArticuloIdArticulACeroEnPresupuesto()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->ArticuloIdArticuloACeroEnPresupuesto($IdPresupLinea);
    }
    
    function ArticuloIdArticuloACeroEnFactura($IdFacturaLinea){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->ArticuloIdArticuloACeroEnFactura($IdFacturaLinea)>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->ArticuloIdArticuloACeroEnFactura($IdFacturaLinea);
    }
    
    function AltaAsientoMovimientos_SinIRPF($post,$idEmp, $strUsuario){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->AltaAsientoMovimientos_SinIRPF()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        //voy a preparar el array con las cuentas de ventas y sus datos
        $cuentaVentas = '';
        //var_dump($post);die;//*************************************************
        foreach ($post as $key => $value) {
            if(substr($key,0,6) === 'cuenta'){
                $num = substr($key,6,1);
                
                $idCuenta = $post['nombreCuenta'.$num];
                $cuentaVentas[$num]['idCuenta'] = $idCuenta;
 
                
                $cantidad = $post['importe'.$num];
                if($cantidad < 0){
                    $cantidad = substr($cantidad,1);
                }
                $cuentaVentas[$num]['cantidad'] = $cantidad;
                
                
                $iva = $post['iva'.$num];
                $cuentaVentas[$num]['iva'] = $iva;
                
                
                $cuota = $post['cuota'.$num];
                if($cuota < 0){
                    $cuota = substr($cuota,1);
                }
                $cuentaVentas[$num]['cuota'] = $cuota;
            }
        }

        $cuentaVentas = array_values($cuentaVentas);
        
        return $clsCADContabilidad->AltaAsientoMovimientos_SinIRPF($post,$cuentaVentas,$idEmp, $strUsuario);
    }
    
    function generarFacturaDePedido($usuario,$IdPedido,$fechaHoy){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->generarFacturaDePedido()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->generarFacturaDePedido($usuario,$IdPedido,$fechaHoy);
    }
    
    function PedidoActualizarFechaProximaFactura($IdPedido){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->PedidoActualizarFechaProximaFactura($IdPedido)>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->PedidoActualizarFechaProximaFactura($IdPedido);
    }
    
    function listadoFacturasDelPedido($IdPedido){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->listadoFacturasDelPedido($IdPedido)>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->listadoFacturasDelPedido($IdPedido);
    }
    
    function fechaUltimaFactura(){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->fechaUltimaFactura()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->fechaUltimaFactura();
    }
    
    function verEjerciciosFacturas(){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->verEjerciciosFacturas()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());

        return $clsCADContabilidad->verEjerciciosFacturas();
    }
    
    function contabilizarVentas($datos){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->contabilizarVentas()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->contabilizarVentas($datos);
    }
    
    function contabilizarBancos($datos){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->contabilizarBancos()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->contabilizarBancos($datos);
    }
    
    function contabilizarTarjetas($datos){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->contabilizarTarjetas()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->contabilizarTarjetas($datos);
    }
    
    function contabilizarCheque($datos){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->contabilizarCheque()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->contabilizarCheque($datos);
    }
    
    function diario($get){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->diario()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->diario($get);
    }
    
    function DatosAsientoNomina($Asiento,$esAbono){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->DatosAsientoNomina()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->DatosAsientoNomina($Asiento,$esAbono);
    }
    
    function AltaNomina($post, $strUsuario,$idEmp){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->AltaNomina()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->AltaNomina($post, $strUsuario,$idEmp);
    }
    
    function DatosLineaMovimientos($IdLinea){
        logger('traza', 'clsCNContabilidad.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
               " clsCNContabilidad->DatosLineaMovimientos()>");
        require_once '../CAD/clsCADContabilidad.php';
        $clsCADContabilidad=new clsCADContabilidad();
        $clsCADContabilidad->setStrBD($this->getStrBD());
        
        return $clsCADContabilidad->DatosLineaMovimientos($IdLinea);
    }
}

?>
