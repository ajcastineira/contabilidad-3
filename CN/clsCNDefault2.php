<?php
require_once '../CAD/clsCADmenu.php';

class clsCNDefault2{
    //función que extrae un array de los nombres de los ficheros
    function extraeNombreFicheros() {
        $tbMenu=array();
        $ficheros=array();
        $tbMenu =  extrae_tbMenu();
        //recorro el array, extraigo el idx y el str_destino
        foreach($tbMenu as $elemento_array){
            $ficheros[$elemento_array->getIdx()] = $elemento_array->getStr_destino();
        }
        return $ficheros;
    }

    //función que extrae un array de los nombres de los textos del menu
    function extraeTextosMenu() {
        $tbMenu=array();
        $textos=array();
        $tbMenu =  extrae_tbMenu();
        //recorro el array, extraigo el idx y el str_texto
        foreach($tbMenu as $elemento_array){
            $textos[$elemento_array->getIdx()] = $elemento_array->getStr_texto();
        }
        return $textos;
    }
    
    //función que extrae un array de los nombres de los textos del menu
    function extraeTextosCabeceras() {
        $tbMenu=array();
        $cabeceras=array();
        $tbMenu =  extrae_tbMenu();
        //recorro el array, extraigo el idx y el texto_superior,texto_principal y descripcion
        foreach($tbMenu as $elemento_array){
            $cabeceras[$elemento_array->getIdx()] =array(
                                                         "superior"=>$elemento_array->getTexto_superior(),
                                                         "principal"=>$elemento_array->getTexto_principal(),
                                                         "descripcion"=>$elemento_array->getDescripcion(),
                                                    );
        }
        return $cabeceras;
    }
    
    //función que extrae un array de los nombres de los textos del menu
    function claseEmpresa($idEmp) {
        return extrae_claseEmpresa($idEmp);
    }
    
    function eventosPendientes($usuario){
        logger('traza', 'clsCNDefault2.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNDefault2->eventosPendientes()>");
        
        require_once '../CAD/clsCADDefault2.php';
        $clsCADDefault2 = new clsCADDefault2();
        $clsCADDefault2->setStrBD($_SESSION['dbContabilidad']);

        return $clsCADDefault2->eventosPendientes($usuario);
    }
    
    function PreguntaSegunRespuesta($lngIdRespuesta){
        logger('traza', 'clsCNDefault2.php-', "Usuario: " . $_SESSION['strUsuario'] . ', Empresa: ' . $_SESSION['strBD'] . ', SesionID: ' . session_id() .
                " clsCNDefault2->PreguntaSegunRespuesta()>");
        
        require_once '../CAD/clsCADDefault2.php';
        $clsCADDefault2 = new clsCADDefault2();
        $clsCADDefault2->setStrBD($_SESSION['dbContabilidad']);

        return $clsCADDefault2->PreguntaSegunRespuesta($lngIdRespuesta);
    }
}
?>