<?php

class clsCADJoomla{
    
    function setStrBD($str){
        $this->strDB=$str;
    }

    function getStrBD(){
        return $this->strDB;
    }

    
    function listadoForm_Suscripcion(){
        require_once '../general/conexion_joomla.php';
        $dbJ = new DbJ();
        require_once '../general/conexion.php';
        $dbC = new DbC();

        
        //extraigo un listado de la tabla de control 'tbempresas_joomla_control'
        $strSQL = "
                    SELECT C.id,C.id_joomla,DATE_FORMAT(C.fecha_alta,'%d/%m/%Y') AS Fecha
                    FROM tbempresas_joomla_control C
                  ";
        logger('traza','clsCADJoomla.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADJoomla->listadoForm_Suscripcion()|| SQL : ".$strSQL);
        $dbC->conectar($this->getStrBD());
        $stmt = $dbC->ejecutar ( $strSQL );
        $dbC->desconectar();

        $listado='';
        if($stmt){
            while($row=  mysql_fetch_array($stmt)){
                $reg='';
                foreach($row as $propiedad=>$valor){
                    if(!is_numeric($propiedad)){
                        $reg[$propiedad]=$valor;
                    }
                }
                $listado[]=$reg;
            }
        }

        
        //filtrando por elcampo form=3 (nuestro formulario)
        $strSQL = "
                    SELECT R.id,R.submitted
                    FROM msal1_facileforms_records R
                    WHERE R.form=3
                  ";
        logger('traza','clsCADJoomla.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADJoomla->listadoForm_Suscripcion()|| SQL : ".$strSQL);
        $dbJ->conectar($this->getStrBD());
        $stmt = $dbJ->ejecutar ( $strSQL );
        
        $listadoJoomla='';
        if($stmt){
            while($row=  mysql_fetch_array($stmt)){
                $reg='';
                foreach($row as $propiedad=>$valor){
                    if(!is_numeric($propiedad)){
                        $reg[$propiedad]=$valor;
                    }
                }
                $listadoJoomla[]=$reg;
            }
        }
        
        
        $listadoFinal='';
        for($i=0;$i<count($listadoJoomla);$i++){
            //compruebo que no exista en el array $listado
            $encontrado='NO';
            for($ii=0;$ii<count($listado);$ii++){
                if($listado[$ii]['id_joomla']==$listadoJoomla[$i]['id']){
                    $encontrado='SI';
                    break;
                }
            }
            
            //si no existe busco los datos en las tablas 
            //'msal1_facileforms_records' y 'msal1_facileforms_subrecords'
            if($encontrado==='NO'){
                $strSQL = "
                            SELECT R.id, DATE_FORMAT(R.submitted,'%d/%m/%Y') AS submitted, S.title, S.value
                            FROM msal1_facileforms_records R,msal1_facileforms_subrecords S
                            WHERE R.id=S.record
                            AND R.form=3 AND R.id=".$listadoJoomla[$i]['id']."
                          ";
                logger('traza','clsCADJoomla.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " clsCADJoomla->listadoForm_Suscripcion()|| SQL : ".$strSQL);
                $stmt = $dbJ->ejecutar ( $strSQL );

                $registro='';
                if($stmt){
                    while($row=  mysql_fetch_array($stmt)){
                        $reg='';
                        foreach($row as $propiedad=>$valor){
                            if(!is_numeric($propiedad)){
                                $reg[$propiedad]=$valor;
                            }
                        }
                        $registro[]=$reg;
                    }
                }else{
                    return false;
                }
            
                //ahora este registro lo guardo en el array $listadoFinal
                $registroEstructura=array(
                    "id_joomla"=>$registro[0]['id'],
                    "nombre_empresa"=>null,
                    "tipo_empresa"=>null,
                    "contacto"=>array(
                        "nombre"=>null,
                        "apellido1"=>null,
                        "apellido2"=>null,
                    ),
                    "telefono"=>null,
                    "email"=>null,
                    "fecha"=>$registro[0]['submitted'],
                );
                for($j=0;$j<count($registro);$j++){
                    //busco por cada title que coincida con nuestros datos buscados 
                    //y los introducimos en el array $registro
                    if($registro[$j]['title']==='Nombre de la Empresa'){
                        $registroEstructura['nombre_empresa']=$registro[$j]['value'];
                    }else 
                    if($registro[$j]['title']==='Teléfono'){
                        $registroEstructura['telefono']=$registro[$j]['value'];
                    }else 
                    if($registro[$j]['title']==='e-mail'){
                        $registroEstructura['email']=$registro[$j]['value'];
                    }else 
                    if($registro[$j]['title']==='Nombre'){
                        $registroEstructura['contacto']['nombre']=$registro[$j]['value'];
                    }else 
                    if($registro[$j]['title']==="Primer Apellido"){
                        $registroEstructura['contacto']['apellido1']=$registro[$j]['value'];
                    }else 
                    if($registro[$j]['title']==="Segundo Apellido"){
                        $registroEstructura['contacto']['apellido2']=$registro[$j]['value'];
                    }else 
                    if($registro[$j]['title']==="Tipo de Empresa"){
                        $registroEstructura['tipo_empresa']=$registro[$j]['value'];
                    }
                }

                $listadoFinal[]=$registroEstructura;
            }
            
        }
        
        $dbJ->desconectar();
        
        return $listadoFinal;
    }

    function datosForm_Suscripcion($id_joomla){
        require_once '../general/conexion_joomla.php';
        $dbJ = new DbJ();
        $dbJ->conectar($this->getStrBD());

        //filtrando por elcampo form=3 (nuestro formulario)
        $strSQL = "
                    SELECT S.name,S.value
                    FROM msal1_facileforms_subrecords S
                    WHERE S.record=$id_joomla
                  ";
        logger('traza','clsCADJoomla.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADJoomla->datosForm_Suscripcion()|| SQL : ".$strSQL);
        $stmt = $dbJ->ejecutar ( $strSQL );
        $dbJ->desconectar();
        
        $datosJoomla='';
        if($stmt){
            while($row=  mysql_fetch_array($stmt)){
                $reg='';
                foreach($row as $propiedad=>$valor){
                    if(!is_numeric($propiedad)){
                        $reg[$propiedad]=$valor;
                    }
                }
                $datosJoomla[]=$reg;
            }
        }
        
        $datosFinales='';
        
        //preparo un array tipo dato[key]=value
        foreach ($datosJoomla as $dato) {
            $keyFinal='';
            foreach ($dato as $key => $value) {
                if($key==='name'){
                    $keyFinal=$value;
                }else
                if($key==='value'){
                    $datosFinales[$keyFinal]=$value;
                }
            }
        }
        
        return $datosFinales;
    }
    
    function BBDD_libre(){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());

        //si el valor es 0 devuelvo FALSE, si es mas de 0 devuelvo TRUE
        $strSQL = "
                    SELECT COUNT(B.id) AS bbdd
                    FROM tbasignacion_bbdd B
                    WHERE B.libre_ocupado='Libre'
                  ";
        logger('traza','clsCADJoomla.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADJoomla->BBDD_libre()|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        $db->desconectar();

        if($stmt){
            $row=  mysql_fetch_array($stmt);
        }else{
            return false;
        }
        
        if($row['bbdd']>0){
            return true;
        }else{
            return false;
        }
    }
}
?>