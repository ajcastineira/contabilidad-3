<?php
require_once '../general/funcionesGenerales.php';

class clsCNConsultas {

    private $strDB = '';

    function setStrBD($str) {
        $this->strDB = $str;
    }

    function getStrBD() {
        return $this->strDB;
    }
    
    function leePreguntas($IdPregunta){
        logger('traza', 'clsCNConsultas.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNConsultas->leePreguntas($IdPregunta)>");

        require_once '../CAD/clsCADConsultas.php';
        $clsCADConsultas = new clsCADConsultas();
        $clsCADConsultas->setStrBD($this->getStrBD());

        return $clsCADConsultas->leePreguntas($IdPregunta);
    }
    
    function leeRespuestasAPregunta($IdPregunta){
        logger('traza', 'clsCNConsultas.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNConsultas->leeRespuestasAPregunta($IdPregunta)>");

        require_once '../CAD/clsCADConsultas.php';
        $clsCADConsultas = new clsCADConsultas();
        $clsCADConsultas->setStrBD($this->getStrBD());

        return $clsCADConsultas->leeRespuestasAPregunta($IdPregunta);
    }
    
    function ListadoConsultas($strClasificacion,$strEstado,$datFechaInicio,$datFechaFin){
        logger('traza', 'clsCNConsultas.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNConsultas->ListadoConsultas($strClasificacion,$strEstado,$datFechaInicio,$datFechaFin)>");

        require_once '../CAD/clsCADConsultas.php';
        $clsCADConsultas = new clsCADConsultas();
        $clsCADConsultas->setStrBD($this->getStrBD());

        return $clsCADConsultas->ListadoConsultas($strClasificacion,$strEstado,$datFechaInicio,$datFechaFin);
    }
    
    function AltaPregunta($lngIdUsuario,$strConsulta,$nombreDoc){
        logger('traza', 'clsCNConsultas.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNConsultas->AltaPregunta($lngIdUsuario,$strConsulta,$nombreDoc)>");

        require_once '../CAD/clsCADConsultas.php';
        $clsCADConsultas = new clsCADConsultas();
        $clsCADConsultas->setStrBD($this->getStrBD());

        return $clsCADConsultas->AltaPregunta($lngIdUsuario,$strConsulta,$nombreDoc);
    }
    
    function AltaPreguntaAsesor($lngIdUsuario,$post,$nombreDoc){
        logger('traza', 'clsCNConsultas.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNConsultas->AltaPreguntaAsesor()>");

        require_once '../CAD/clsCADConsultas.php';
        $clsCADConsultas = new clsCADConsultas();
        $clsCADConsultas->setStrBD($this->getStrBD());

        return $clsCADConsultas->AltaPreguntaAsesor($lngIdUsuario,$post,$nombreDoc);
    }
    
    function AltaRespuestaAPregunta($lngIdUsuario,$strRespuesta,$numPregunta,$nombreDoc){
        logger('traza', 'clsCNConsultas.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNConsultas->AltaRespuestaAPregunta($lngIdUsuario,$strRespuesta,$numPregunta,$nombreDoc)>");

        require_once '../CAD/clsCADConsultas.php';
        $clsCADConsultas = new clsCADConsultas();
        $clsCADConsultas->setStrBD($this->getStrBD());

        return $clsCADConsultas->AltaRespuestaAPregunta($lngIdUsuario,$strRespuesta,$numPregunta,$nombreDoc);
    }
    
    function ActualizarPregunta($IdPregunta,$strClasificacion,$strEstado){
        logger('traza', 'clsCNConsultas.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNConsultas->ActualizarPregunta($IdPregunta,$strClasificacion,$strEstado)>");

        require_once '../CAD/clsCADConsultas.php';
        $clsCADConsultas = new clsCADConsultas();
        $clsCADConsultas->setStrBD($this->getStrBD());

        return $clsCADConsultas->ActualizarPregunta($IdPregunta,$strClasificacion,$strEstado);
    }
    
    function RespuestaEstadoRespondida($idPregunta){
        logger('traza', 'clsCNConsultas.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNConsultas->RespuestaEstadoRespondida($idPregunta)>");

        require_once '../CAD/clsCADConsultas.php';
        $clsCADConsultas = new clsCADConsultas();
        $clsCADConsultas->setStrBD($this->getStrBD());

        return $clsCADConsultas->RespuestaEstadoRespondida($idPregunta);
    }

    function RespuestaEstadoEnCurso($idPregunta){
        logger('traza', 'clsCNConsultas.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNConsultas->RespuestaEstadoEnCurso($idPregunta)>");

        require_once '../CAD/clsCADConsultas.php';
        $clsCADConsultas = new clsCADConsultas();
        $clsCADConsultas->setStrBD($this->getStrBD());

        return $clsCADConsultas->RespuestaEstadoEnCurso($idPregunta);
    }
    
    function fechaUltimaRespuesta($IdPregunta){
        logger('traza', 'clsCNConsultas.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNConsultas->fechaUltimaRespuesta()>");

        require_once '../CAD/clsCADConsultas.php';
        $clsCADConsultas = new clsCADConsultas();
        $clsCADConsultas->setStrBD($this->getStrBD());

        return $clsCADConsultas->fechaUltimaRespuesta($IdPregunta);
    }
    
    function AltaDocumento($versionDoc,$optTipo,$optTipo2,$nombreDoc,$nombre,
                           $optCategoria,$strUrl,$strDescripcion,$lngIdEmpleado){
        logger('traza', 'clsCNConsultas.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNConsultas->AltaDocumento($versionDoc,$optTipo,$optTipo2,$nombreDoc,$nombre,
                           $optCategoria,$strUrl,$strDescripcion,$lngIdEmpleado)>");

        require_once '../CAD/clsCADConsultas.php';
        $clsCADConsultas = new clsCADConsultas();
        $clsCADConsultas->setStrBD($this->getStrBD());

        return $clsCADConsultas->AltaDocumento($versionDoc,$optTipo,$optTipo2,$nombreDoc,$nombre,
                           $optCategoria,$strUrl,$strDescripcion,$lngIdEmpleado);
    }
    
    function ListadoDocumentos($criterio){
        logger('traza', 'clsCNConsultas.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNConsultas->ListadoDocumentos($criterio)>");

        require_once '../CAD/clsCADConsultas.php';
        $clsCADConsultas = new clsCADConsultas();
        $clsCADConsultas->setStrBD($this->getStrBD());

        return $clsCADConsultas->ListadoDocumentos($criterio);
    }
    
    function datosEmpresa($idEmp){
        logger('traza', 'clsCNConsultas.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNConsultas->datosEmpresa($idEmp)>");
        
        require_once '../CAD/clsCADConsultas.php';
        $clsCADConsultas = new clsCADConsultas();
        $clsCADConsultas->setStrBD($this->getStrBD());

        return $clsCADConsultas->datosEmpresa($idEmp);
    }
    
    function actualizaLeidosPreguntas($preguntas){
        logger('traza', 'clsCNConsultas.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNConsultas->actualizaLeidosPreguntas()>");
        
        require_once '../CAD/clsCADConsultas.php';
        $clsCADConsultas = new clsCADConsultas();
        $clsCADConsultas->setStrBD($this->getStrBD());

        return $clsCADConsultas->actualizaLeidosPreguntas($preguntas);
    }
    
    function ActualizaLeidosRespuestas($respApregunta){
        logger('traza', 'clsCNConsultas.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNConsultas->ActualizaLeidosRespuestas()>");
        
        require_once '../CAD/clsCADConsultas.php';
        $clsCADConsultas = new clsCADConsultas();
        $clsCADConsultas->setStrBD($this->getStrBD());

        return $clsCADConsultas->ActualizaLeidosRespuestas($respApregunta);
    }
    
    function PreguntaEstado($IdPregunta){
        logger('traza', 'clsCNConsultas.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNConsultas->PreguntaEstado()>");
        
        require_once '../CAD/clsCADConsultas.php';
        $clsCADConsultas = new clsCADConsultas();
        $clsCADConsultas->setStrBD($this->getStrBD());

        return $clsCADConsultas->PreguntaEstado($IdPregunta);
    }
    
    function RespuestaEstado($IdRespuesta){
        logger('traza', 'clsCNConsultas.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNConsultas->RespuestaEstado()>");
        
        require_once '../CAD/clsCADConsultas.php';
        $clsCADConsultas = new clsCADConsultas();
        $clsCADConsultas->setStrBD($this->getStrBD());

        return $clsCADConsultas->RespuestaEstado($IdRespuesta);
    }
    
    function ListadoEmpresas(){
        logger('traza', 'clsCNConsultas.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNConsultas->ListadoEmpresas()>");
        
        require_once '../CAD/clsCADConsultas.php';
        $clsCADConsultas = new clsCADConsultas();
        $clsCADConsultas->setStrBD($this->getStrBD());

        return $clsCADConsultas->ListadoEmpresas();
    }
    
    function ListadoClaseEmpresas(){
        logger('traza', 'clsCNConsultas.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNConsultas->ListadoClaseEmpresas()>");
        
        require_once '../CAD/clsCADConsultas.php';
        $clsCADConsultas = new clsCADConsultas();
        $clsCADConsultas->setStrBD($this->getStrBD());

        return $clsCADConsultas->ListadoClaseEmpresas();
    }
    
    function ListadoUsuarios(){
        logger('traza', 'clsCNConsultas.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNConsultas->ListadoUsuarios()>");
        
        require_once '../CAD/clsCADConsultas.php';
        $clsCADConsultas = new clsCADConsultas();
        $clsCADConsultas->setStrBD($this->getStrBD());

        return $clsCADConsultas->ListadoUsuarios();
    }
    
    function LeerLeidoPreguntaAsesorUsuario($IdPregunta,$usuario){
        logger('traza', 'clsCNConsultas.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNConsultas->LeerLeidoPreguntaAsesorUsuario()>");
        
        require_once '../CAD/clsCADConsultas.php';
        $clsCADConsultas = new clsCADConsultas();
        $clsCADConsultas->setStrBD($this->getStrBD());

        return $clsCADConsultas->LeerLeidoPreguntaAsesorUsuario($IdPregunta,$usuario);
    }
}
?>
