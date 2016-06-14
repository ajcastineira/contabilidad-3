<?php
require_once '../general/funcionesGenerales.php';

class clsCNUsu{
    
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

    function ListadoASP_Borra($strNombre,$strApellidos){
        logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCNUsu->ListadoASP_Borra()");
        require_once '../CAD/clsCADUsu.php';
        $clsCADUsu=new clsCADUsu();
        $clsCADUsu->setStrBD($this->getStrBD());

        return $clsCADUsu->ListadoASP_Borra($strNombre,$strApellidos);
    }
    
    function ListadoASPModifFilter($empresa,$strNombre,$strApellidos,$strDepartamento){
        logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCNUsu->ListadoASPModifFilter($empresa,$strNombre,$strApellidos,$strDepartamento)");
        require_once '../CAD/clsCADUsu.php';
        $clsCADUsu=new clsCADUsu();
        $clsCADUsu->setStrBD($this->getStrBD());

        return $clsCADUsu->ListadoASP_Borra($empresa,$strNombre,$strApellidos,$strDepartamento);
    }
    
    function ListadoCuentas($strNombre,$lngNumCuenta){
        logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCNUsu->ListadoCuentas($strNombre,$lngNumCuenta)>");
        require_once '../CAD/clsCADUsu.php';
        $clsCADUsu=new clsCADUsu();
        $clsCADUsu->setStrBD($this->getStrBD());

        return $clsCADUsu->ObtieneListaAprob_Cuentas($strNombre,$lngNumCuenta);
    }
    
    function IdUsuarioNuevo(){
        logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCNUsu->IdUsuarioNuevo()");
        require_once '../CAD/clsCADUsu.php';
        $clsCADUsu=new clsCADUsu();
        $clsCADUsu->setStrBD($this->getStrBD());
        return $clsCADUsu->IdUsuarioNuevo();
    }
    
    function IdCliProv(){
        logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCNUsu->IdCliProv()");
        require_once '../CAD/clsCADUsu.php';
        $clsCADUsu=new clsCADUsu();
        $clsCADUsu->setStrBD($this->getStrBD());
        return $clsCADUsu->IdCliProv();
    }
    
    function DatosCuenta($IdCuenta){
        logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCNUsu->DatosCuenta($IdCuenta)");
        require_once '../CAD/clsCADUsu.php';
        $clsCADUsu=new clsCADUsu();
        $clsCADUsu->setStrBD($this->getStrBD());
        return $clsCADUsu->DatosCuenta($IdCuenta);
    }
    
    
    function Alta($num,$idEmp,$strNombre,$strApellidos,$lngTelefono,$lngMovil,$strCorreos,
                  $strUsuario,$strPassword){
        logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCNUsu->Alta()>");
        if($lngTelefono==""){
            $lngTelefono=0;
        }
        if($lngMovil==""){
            $lngMovil=0;
        }
        
//        //Control del departamento
//        //si el dato del departamento viene vacio o no existe en la tabla tbdepartamentos, le asigno el departamento del usuario
//        $datos=$this->ObtieneDepartamentoUsuario($_SESSION['usuario']);
//        $lngDepartamento=0;
//        $existeDpto=$this->existeDpto($strDepartamento);
//        if(isset($strDepartamento) && $strDepartamento=='' || $existeDpto=='NO'){
//            $lngDepartamento=$datos['lngDepartamento'];
//        }else{
//            //sino busco el $lngDepartamento
//            require_once '../CN/clsCNDep.php';
//            $clsCNDep=new clsCNDep();
//            $clsCNDep->setStrBD($this->getStrBD());
//            $lngDepartamento=$clsCNDep->ObtieneIdDep($strDepartamento);
//        }
        
        require_once '../CAD/clsCADUsu.php';
        $clsCADUsu=new clsCADUsu();
        $clsCADUsu->setStrBD($this->getStrBD());
        $alta=$clsCADUsu->Alta($num,$idEmp,$strNombre,$strApellidos,$lngTelefono,$lngMovil,$strCorreos,
                  $strUsuario,$strPassword);
        if($alta==1){
            logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCNUsu->Alta()<TRUE");
            return true;
        }else{
            logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCNUsu->Alta()<Se ha producido un error al intentar el alta");
            return 'Se ha producido un error al intentar el alta.';
        }
    }

    function AltaEmpresa($strEmpresa,$strCIF,$strPassword){
        logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCNUsu->AltaEmpresa($strEmpresa,$strCIF,$strPassword)>");
        require_once '../CAD/clsCADUsu.php';
        $clsCADUsu=new clsCADUsu();
        $clsCADUsu->setStrBD($this->getStrBD());
        $datos=$clsCADUsu->AltaEmpresa($strEmpresa,$strCIF,$strPassword);
        if($datos['correcto']==1){
            logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCNUsu->AltaEmpresa($strEmpresa,$strCIF,$strPassword)<TRUE");
            return $datos;
        }else{
            logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCNUsu->AltaEmpresa($strEmpresa,$strCIF,$strPassword)<Se ha producido un error al intentar el alta de empresa.");
            return 'Se ha producido un error al intentar el alta de empresa.';
        }
    }

    function Modificacion($num,$idEmp,$strNombre,$strApellidos,$lngTelefono,$lngMovil,$strCorreos,
                  $strDepartamento,$strUsuario,$strPassword){
        logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCNUsu->Modificacion()>");
        if($lngTelefono==""){
            $lngTelefono=0;
        }
        if($lngExtension==""){
            $lngExtension=0;
        }
        
//        //Control del departamento
//        //si el dato del departamento viene vacio o no existe en la tabla tbdepartamentos, le asigno el departamento del usuario
//        $datos=$this->ObtieneDepartamentoUsuario($_SESSION['usuario']);
//        $lngDepartamento=0;
//        $existeDpto=$this->existeDpto($strDepartamento);
//        if(isset($strDepartamento) && $strDepartamento=='' || $existeDpto=='NO'){
//            $lngDepartamento=$datos['lngDepartamento'];
//        }else{
//            //sino busco el $lngDepartamento
//            require_once '../CN/clsCNDep.php';
//            $clsCNDep=new clsCNDep();
//            $clsCNDep->setStrBD($this->getStrBD());
//            $lngDepartamento=$clsCNDep->ObtieneIdDep($strDepartamento);
//        }
        
        require_once '../CAD/clsCADUsu.php';
        $clsCADUsu=new clsCADUsu();
        $clsCADUsu->setStrBD($this->getStrBD());
        $alta=$clsCADUsu->Modificacion($num,$idEmp,$strNombre,$strApellidos,$lngTelefono,$lngMovil,$strCorreos,
                  $strDepartamento,$strUsuario,$strPassword);
        if($alta==1){
            logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCNUsu->Modificacion()<TRUE");
            return true;
        }else{
            logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCNUsu->Modificacion()<Se ha producido un error al intentar actualizar los datos.");
            return 'Se ha producido un error al intentar actualizar los datos.';
        }
    }

    private function existeDpto($strDepartamento){
        logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCNUsu->existeDpto($strDepartamento)");
        require_once '../CAD/clsCADDep.php';
        $clsCADDep=new clsCADDep();
        $clsCADDep->setStrBD($this->getStrBD());
        return $clsCADDep->existeDpto($strDepartamento);
    }

    function DatosUsuario($id){
        logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCNUsu->DatosUsuario($id)");
        require_once '../CAD/clsCADUsu.php';
        $clsCADUsu=new clsCADUsu();
        $clsCADUsu->setStrBD($this->getStrBD());
        return $clsCADUsu->DatosUsuario($id);
    }
    
    function usuarioBorrar($id){
        logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCNUsu->usuarioBorrar($id)");
        require_once '../CAD/clsCADUsu.php';
        $clsCADUsu=new clsCADUsu();
        $clsCADUsu->setStrBD($this->getStrBD());
        return $clsCADUsu->usuarioBorrar($id);
    }
    
    function cliprovBorrar($id){
        logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCNUsu->cliprovBorrar($id)");
        require_once '../CAD/clsCADUsu.php';
        $clsCADUsu=new clsCADUsu();
        $clsCADUsu->setStrBD($this->getStrBD());
        return $clsCADUsu->cliprovBorrar($id);
    }
    
    function cuentaBorrar($id){
        logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCNUsu->cuentaBorrar($id)");
        require_once '../CAD/clsCADUsu.php';
        $clsCADUsu=new clsCADUsu();
        $clsCADUsu->setStrBD($this->getStrBD());
        return $clsCADUsu->cuentaBorrar($id);
    }
    
    function ListadoCliProv($tipo,$strNombre,$strCIF){
        logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCNUsu->ListadoCliProv($tipo,$strNombre,$strCIF)");
        require_once '../CAD/clsCADUsu.php';
        $clsCADUsu=new clsCADUsu();
        $clsCADUsu->setStrBD($this->getStrBD());
        $clsCADUsu->setStrBDCliente($this->getStrBDCliente());
        return $clsCADUsu->ObtieneListaAprob_CliProv($strNombre,$strCIF,$tipo);
    }
    
    function AltaCuenta($numCuenta,$grupo,$subGrupo2,$subGrupo4,$strNombre){
        logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCNUsu->AltaCuenta($numCuenta,$grupo,$subGrupo2,$subGrupo4,$strNombre)>");
        require_once '../CAD/clsCADUsu.php';
        $clsCADUsu=new clsCADUsu();
        $clsCADUsu->setStrBD($this->getStrBD());

        return $clsCADUsu->AltaCuenta($numCuenta,$grupo,$subGrupo2,$subGrupo4,$strNombre);
    }
    
    
    function ObtieneDepartamentoUsuario($usuario){
        logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCNUsu->ObtieneDepartamentoUsuario($usuario)");
        require_once '../CAD/clsCADUsu.php';
        $clsCADUsu=new clsCADUsu();
        $clsCADUsu->setStrBD($this->getStrBD());

        return $clsCADUsu->ObtieneDepartamentoUsuario($usuario);
    }
    
    
    function DatosEmpleado($varlngId,$varstrUsuario){
        logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCNUsu->DatosEmpleado(".$varlngId.",".$varstrUsuario.")>");
        require_once '../CAD/clsCADUsu.php';
        $clsCADUsu=new clsCADUsu();
        $clsCADUsu->setStrBD($this->getStrBD());
        $row=$clsCADUsu->DatosEmpleado($varlngId,$varstrUsuario);
        logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCNUsu->DatosEmpleado(".$varlngId.",".$varstrUsuario.")<Datos Empleado");
        return $row;
    }

    function AltaCliente($num,$strNombre,$strCIF,$strActividad,$lngCP,$strDireccion,$strMunicipio,$strProvincia,
                         $strEmail,$strEmail2,$lngTelefono1,$lngTelefono2,$lngFax,$lngCodigo,$numCuenta,$numEmpresa,$cliProv,$strCCRecibos){
        logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCNUsu->AltaCliente()>");
        
        require_once '../CAD/clsCADUsu.php';
        $clsCADUsu=new clsCADUsu();
        $clsCADUsu->setStrBD($this->getStrBD());
        $clsCADUsu->setStrBDCliente($this->getStrBDCliente());
        $btnalta=$clsCADUsu->AltaCliente($num,$strNombre,$strCIF,$strActividad,$lngCP,$strDireccion,$strMunicipio,$strProvincia,
                                       $strEmail,$strEmail2,$lngTelefono1,$lngTelefono2,$lngFax,$lngCodigo,$numCuenta,$numEmpresa,$cliProv,$strCCRecibos);
        if($btnalta){
            logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCNUsu->AltaCliente()<TRUE");
            return true;
        }else{
            logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCNUsu->AltaCliente()<Se ha producido un error al intentar el alta.");
            return 'Se ha producido un error al intentar el alta.';            
        }
    }

    function AltaClienteNuevo($num,$strNombre,$strCIF,$strActividad,$lngCP,$strDireccion,$strMunicipio,$strProvincia,
                         $strEmail,$strEmail2,$lngTelefono1,$lngTelefono2,$lngFax,$lngCodigo,$numCuenta,$numEmpresa,$cliProv,$strCCRecibos){
        logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCNUsu->AltaClienteNuevo()>");
        
        require_once '../CAD/clsCADUsu.php';
        $clsCADUsu=new clsCADUsu();
        $clsCADUsu->setStrBD($this->getStrBD());
        $clsCADUsu->setStrBDCliente($this->getStrBDCliente());
        $btnalta=$clsCADUsu->AltaClienteNuevo($num,$strNombre,$strCIF,$strActividad,$lngCP,$strDireccion,$strMunicipio,$strProvincia,
                                       $strEmail,$strEmail2,$lngTelefono1,$lngTelefono2,$lngFax,$lngCodigo,$numCuenta,$numEmpresa,$cliProv,$strCCRecibos);
        if($btnalta){
            logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCNUsu->AltaClienteNuevo()<TRUE");
            return true;
        }else{
            logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCNUsu->AltaClienteNuevo()<Se ha producido un error al intentar el alta.");
            return false;            
        }
    }
    
    function PasarContactoAClienteNuevo($num,$strNombre,$strCIF,$strActividad,$lngCP,$strDireccion,$strMunicipio,$strProvincia,
                         $strEmail,$lngTelefono1,$lngTelefono2,$lngFax,$lngCodigo,$numCuenta,$numEmpresa,$cliProv){
        logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCNUsu->AltaClienteNuevo()>");
        
        require_once '../CAD/clsCADUsu.php';
        $clsCADUsu=new clsCADUsu();
        $clsCADUsu->setStrBD($this->getStrBD());
        $clsCADUsu->setStrBDCliente($this->getStrBDCliente());
        $btnalta=$clsCADUsu->PasarContactoAClienteNuevo($num,$strNombre,$strCIF,$strActividad,$lngCP,$strDireccion,$strMunicipio,$strProvincia,
                                       $strEmail,$lngTelefono1,$lngTelefono2,$lngFax,$lngCodigo,$numCuenta,$numEmpresa,$cliProv);
        if($btnalta){
            logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCNUsu->AltaClienteNuevo()<TRUE");
            return true;
        }else{
            logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCNUsu->AltaClienteNuevo()<Se ha producido un error al intentar el alta.");
            return 'Se ha producido un error al intentar el alta.';            
        }
    }
    
    function DatosCliProv($IdRelacionCliProv){
        logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCNUsu->DatosCliProv($IdRelacionCliProv)");
        require_once '../CAD/clsCADUsu.php';
        $clsCADUsu=new clsCADUsu();
        $clsCADUsu->setStrBD($this->getStrBD());
        return $clsCADUsu->DatosCliProv($IdRelacionCliProv);
    }

    function ModificarCli($IdRelacionCliProv,$strNombre, $strCIF,$strActividad, $lngCP, $strDireccion,
                          $strMunicipio, $strProvincia,$strEmail,$strEmail2,$lngTelefono1,$lngTelefono2,
                          $lngFax,$lngCNAE,$lngNumSS,$strCCRecibos){
        logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCNUsu->ModificarCli()>");

        require_once '../CAD/clsCADUsu.php';
        $clsCADUsu=new clsCADUsu();
        $clsCADUsu->setStrBD($this->getStrBD());
        $clsCADUsu->setStrBDCliente($this->getStrBDCliente());
        
        $btnModificar=$clsCADUsu->ModificarCli($IdRelacionCliProv,$strNombre, $strCIF,$strActividad, $lngCP, $strDireccion,
                                  $strMunicipio, $strProvincia,$strEmail,$strEmail2,$lngTelefono1,$lngTelefono2,
                                  $lngFax,$lngCNAE,$lngNumSS,$strCCRecibos);
        if($btnModificar){
            logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCNUsu->ModificarCli()<TRUE");
            return true;
        }else{
            logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCNUsu->ModificarCli()<Se ha producido un error al intentar el Modificar.");
            return 'Se ha producido un error al intentar el Modificar.';            
        }
    }
    
    function ModificarCuentas($IdCuenta,$strNombre){
        logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCNUsu->ModificarCuentas($IdCuenta,$strNombre)>");
        
        require_once '../CAD/clsCADUsu.php';
        $clsCADUsu=new clsCADUsu();
        $clsCADUsu->setStrBD($this->getStrBD());
        
        $btnModificar=$clsCADUsu->ModificarCuentas($IdCuenta,$strNombre);

        if($btnModificar){
            logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCNUsu->ModificarCuentas($IdCuenta,$strNombre)<TRUE");
            return true;
        }else{
            logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCNUsu->ModificarCuentas($IdCuenta,$strNombre)<Se ha producido un error al intentar Modificar.");
            return 'Se ha producido un error al intentar Modificar.';            
        }
    }
    
    function DatosAsesor($idEmp){
        logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCNUsu->DatosAsesor($idEmp)");
        require_once '../CAD/clsCADUsu.php';
        $clsCADUsu=new clsCADUsu();
        $clsCADUsu->setStrBD($this->getStrBD());
        return $clsCADUsu->DatosAsesor($idEmp);
    }
    
    function ExisteNIF_CIF($idEmp){
        logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCNUsu->ExisteNIF_CIF($idEmp)>");
        
        require_once '../CAD/clsCADUsu.php';
        $clsCADUsu=new clsCADUsu();
        $clsCADUsu->setStrBD($this->getStrBD());

        return $clsCADUsu->ExisteNIF_CIF($idEmp);
    }

    function AltaCuentaContactos($CodigoCuenta,$nombre){
        logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCNUsu->AltaCuentaContactos()>");
        
        require_once '../CAD/clsCADUsu.php';
        $clsCADUsu=new clsCADUsu();
        $clsCADUsu->setStrBD($this->getStrBD());

        return $clsCADUsu->AltaCuentaContactos($CodigoCuenta,$nombre);
    }
    
    function listadoAsesores(){
        logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCNUsu->listadoAsesores()>");
        
        require_once '../CAD/clsCADUsu.php';
        $clsCADUsu=new clsCADUsu();
        $clsCADUsu->setStrBD($this->getStrBD());

        return $clsCADUsu->listadoAsesores();
    }
    
    function listadoBBDDLibres(){
        logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCNUsu->listadoBBDDLibres()>");
        
        require_once '../CAD/clsCADUsu.php';
        $clsCADUsu=new clsCADUsu();
        $clsCADUsu->setStrBD($this->getStrBD());

        return $clsCADUsu->listadoBBDDLibres();
    }
    
    function AltaEmpresaNueva($strNombre,$strCIF,$strPassword,$strDireccion,$strSesion,$strMunicipio,$strCP,$strTelefono,$email1,$email2,$version,$numApuntes
                                    ,$IdAsesor,$strMapeo,$claseEmpresa){
        logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCNUsu->AltaEmpresaNueva()>");
        
        require_once '../CAD/clsCADUsu.php';
        $clsCADUsu=new clsCADUsu();
        $clsCADUsu->setStrBD($this->getStrBD());

        return $clsCADUsu->AltaEmpresaNueva($strNombre,$strCIF,$strPassword,$strDireccion,$strSesion,$strMunicipio,$strCP,$strTelefono,$email1,$email2,$version,$numApuntes
                                    ,$IdAsesor,$strMapeo,$claseEmpresa);
    }
    
    function AltaEmpresaNuevaDesdeJoomla($post){
        logger('traza','clsCNUsu.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCNUsu->AltaEmpresaNuevaDesdeJoomla()>");
        
        require_once '../CAD/clsCADUsu.php';
        $clsCADUsu=new clsCADUsu();
        $clsCADUsu->setStrBD($this->getStrBD());

        return $clsCADUsu->AltaEmpresaNuevaDesdeJoomla($post);
    }
}
?>
