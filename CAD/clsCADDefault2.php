<?php
class clsCADDefault2{
    
    private $strDB='';

    function setStrBD($str){
        $this->strDB=$str;
    }

    function getStrBD(){
        return $this->strDB;
    }
    
    function eventosPendientes($usuario){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());
        
        //los eventos pendientes a buscar varia segun el perfil del usuario
        //
        //1-si es Usuario, buscamos las preguntas que hayan echo los asesores
        //y las respuestas a nuestras preguntas que hayan echo los asesores y que esten con el campo leido=0
        //
        //2-si es Asesor busco las preguntas de los usuarios que no hayan sido leidas (leido=0)
        //y busco las respuestas que no hayan sido leidas (tanto de usuarios como asesores
        // menos la del propio asesor)
        
        
        //primero averiguo si es Usuario o Asesor
        $strSQL="
                SELECT U.strPuesto
                FROM tbusuarios U
                WHERE U.lngIdEmpleado=$usuario 
                ";
        
        logger('traza','clsCADDefault2.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADDefault2->eventosPendientes()|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        
        if($stmt){
            $row=  mysql_fetch_array($stmt);
            $tipo=$row['strPuesto'];
        }else{
            return false;
        }
        
        if(substr($tipo,0,7)==='Usuario'){
            //1
            //primero busco en la tabla 'tbconsulta_pregunta' todas las preguntas de los asesores 
            //con leido=9 y NOT strEstado=Cerrada y en la tabla 'tbconsulta_pregunta_asesor' busco
            //por la lngIdPregunta y que el usuario aparezca, y que este leido=0
            $strSQL="
                    SELECT CONCAT(E.strNombre,' ',E.strApellidos) AS usuario,P.lngIdPregunta,
                    LEFT(P.strPregunta,100) AS strPregunta,P.datFechaStatus AS Fecha
                    FROM tbconsulta_pregunta P,tbusuarios U,tbempleados E,tbconsulta_pregunta_asesor PA
                    WHERE P.lngIdUsuario=U.lngIdEmpleado
                    AND U.lngIdEmpleado=E.lngIdEmpleado
                    AND P.lngIdPregunta=PA.lngIdPregunta
                    AND U.strPuesto LIKE 'Asesor%'
                    AND NOT P.strEstado='Cerrada'
                    AND P.leido=9
                    AND PA.lngIdEmpleado=$usuario
                    AND PA.Leido=0
                    ";

            logger('traza','clsCADDefault2.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADDefault2->eventosPendientes()|| SQL : ".$strSQL);
            $stmt = $db->ejecutar ( $strSQL );

            //guardo en un array los datos
            $resultado='';
            if($stmt){
                while($row=  mysql_fetch_array($stmt)){
                    $reg='';
                    foreach($row as $propiedad=>$valor){
                        if(!is_numeric($propiedad)){
                            $reg[$propiedad]=$valor;
                        }
                    }
                    $resultado[]=$reg;
                }
            }

            //ahora busco las respuestas con leido=0 que hayan hecho a nuestras preguntas 
            //(tanto asesores como usuarios menos el propio usuario)
            $strSQL="
                    SELECT CONCAT(E.strNombre,' ',E.strApellidos) AS usuario,R.lngIdRespuesta,
                    LEFT(R.strRespuesta,100) AS strRespuesta,R.datFechaStatus AS Fecha
                    FROM tbconsulta_pregunta P,tbconsulta_respuestas R,tbempleados E
                    WHERE P.lngIdPregunta=R.lngIdPregunta
                    AND R.lngIdUsuario=E.lngIdEmpleado
                    AND P.lngIdUsuario=$usuario
                    AND R.leido=0 AND NOT R.lngIdUsuario=$usuario
                    ";
            
            logger('traza','clsCADDefault2.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADConsultas->eventosPendientes()|| SQL : ".$strSQL);
            $stmt = $db->ejecutar ( $strSQL );

            //guardo en un array los datos
            if($stmt){
                while($row=  mysql_fetch_array($stmt)){
                    $reg='';
                    foreach($row as $propiedad=>$valor){
                        if(!is_numeric($propiedad)){
                            $reg[$propiedad]=$valor;
                        }
                    }
                    $resultado[]=$reg;
                }
            }
        }else if(substr($tipo,0,6)==='Asesor'){
            //2
            //busco las preguntas de los usuarios que no hayan sido leidas
            $strSQL="
                    SELECT CONCAT(E.strNombre,' ',E.strApellidos) AS usuario,P.lngIdPregunta,
                    LEFT(P.strPregunta,100) AS strPregunta,P.datFechaStatus AS Fecha
                    FROM tbconsulta_pregunta P,tbusuarios U,tbempleados E
                    WHERE P.lngIdUsuario=U.lngIdEmpleado
                    AND U.lngIdEmpleado=E.lngIdEmpleado
                    AND U.strPuesto LIKE 'Usuario%'
                    AND NOT P.strEstado='Cerrada'
                    AND P.leido=0
                    ";
            
            logger('traza','clsCADDefault2.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADConsultas->eventosPendientes()|| SQL : ".$strSQL);
            $stmt = $db->ejecutar ( $strSQL );

            //guardo en un array los datos
            $resultado='';
            if($stmt){
                while($row=  mysql_fetch_array($stmt)){
                    $reg='';
                    foreach($row as $propiedad=>$valor){
                        if(!is_numeric($propiedad)){
                            $reg[$propiedad]=$valor;
                        }
                    }
                    $resultado[]=$reg;
                }
            }

            //ahora leo todas las respuestas de los usuarios u otros asesores que esten sin leer 
            //(leido=0 en la tabla 'tbconsulta_respuestas')
            $strSQL="
                    SELECT CONCAT(E.strNombre,' ',E.strApellidos) AS usuario,
                                     R.lngIdRespuesta,LEFT(R.strRespuesta,100) AS strRespuesta,
                                     R.datFechaStatus AS Fecha
                    FROM tbconsulta_respuestas R, tbusuarios U, tbempleados E
                    WHERE U.lngIdEmpleado=R.lngIdUsuario
                    AND E.lngIdEmpleado=U.lngIdEmpleado
                    AND NOT R.lngIdUsuario=$usuario
                    AND R.leido=0
                    ";
            
            logger('traza','clsCADDefault2.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADConsultas->eventosPendientes()|| SQL : ".$strSQL);
            $stmt = $db->ejecutar ( $strSQL );

            //guardo en un array los datos
            if($stmt){
                while($row=  mysql_fetch_array($stmt)){
                    $reg='';
                    foreach($row as $propiedad=>$valor){
                        if(!is_numeric($propiedad)){
                            $reg[$propiedad]=$valor;
                        }
                    }
                    $resultado[]=$reg;
                }
            }
        }
        
        //ahora ordeno el array, primero usuario ASC y por fecha ASC
        
        // Obtener una lista de columnas usuarios y Fechas a ordenar
        foreach ($resultado as $clave => $fila) {
            $usuarios[$clave] = $fila['usuario'];
            $Fecha[$clave] = $fila['Fecha'];
        }

        // Ordenar los datos con usuarios ASC, Fecha ASC
        // Agregar $resultado como el último parámetro, para ordenar por la clave común
        array_multisort($usuarios, SORT_ASC, $Fecha, SORT_ASC, $resultado); 

        return $resultado;
    }
    
    function PreguntaSegunRespuesta($lngIdRespuesta){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());

        //averiguar el id de la pregunta segun el id de la respuesta 
        $strSQL="
                SELECT P.lngIdPregunta
                FROM tbconsulta_pregunta P, tbconsulta_respuestas R
                WHERE P.lngIdPregunta=R.lngIdPregunta
                AND R.lngIdRespuesta=$lngIdRespuesta
                ";

        logger('traza','clsCADDefault2.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADDefault2->PreguntaSegunRespuesta()|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );

        //guardo en un array los datos
        if($stmt){
            $row=  mysql_fetch_array($stmt);
            return $row['lngIdPregunta'];
        }else{
            return false;
        }
    }
}
?>