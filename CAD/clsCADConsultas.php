<?php
class clsCADConsultas{
    
    function setStrBD($str){
        $this->strDB=$str;
    }

    function getStrBD(){
        return $this->strDB;
    }

    function leePreguntas($IdPregunta){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());
        
        //si $IdPregunta es distinto de 0 hay que extraer los datos de esa pregunta
        //(esta opción es porque un usuario ASESOR a seleccionado una pregunta)
        //sino = 0 extraigo los datos del usuario en sesion
        //(un usuario cliente a entrado para ver sus preguntas y respuestas
        //y todas las preguntas de los asesores con NOT strEstado='Cerrada' y Leido=9

        $strSQL="(SELECT CONCAT(E.strNombre,' ',E.strApellidos) AS Usuario,U.strPuesto,P.lngIdPregunta,P.strPregunta,P.strDoc,
                 P.strClasificacion,P.strEstado,P.datFechaStatus AS Fecha,
                 P.lngIdUsuario,P.leido
                 FROM tbconsulta_pregunta P,tbempleados E,tbusuarios U";
        if($IdPregunta==''){
            $strSQL=$strSQL." WHERE P.lngIdUsuario=".$_SESSION['usuario']." AND P.lngStatus=1";
        }else{
            $strSQL=$strSQL." WHERE P.lngIdPregunta=$IdPregunta AND P.lngStatus=1";
        }
        $strSQL=$strSQL." AND P.lngIdUsuario=E.lngIdEmpleado AND E.lngIdEmpleado=U.lngIdEmpleado)";
        //con este codigo busco las preguntas de los asesores que no esten cerradas y leido=9 y que sean para el usuario
        if($IdPregunta==''){
            $strSQL=$strSQL."
                            UNION
                            (SELECT CONCAT(E.strNombre,' ',E.strApellidos) AS Usuario,U.strPuesto,P.lngIdPregunta,P.strPregunta,P.strDoc,
                            P.strClasificacion,P.strEstado,P.datFechaStatus AS Fecha,
                            P.lngIdUsuario,P.leido
                            FROM tbconsulta_pregunta P,tbempleados E,tbusuarios U, tbconsulta_pregunta_asesor PA
                            WHERE P.lngIdUsuario=E.lngIdEmpleado
                            AND E.lngIdEmpleado=U.lngIdEmpleado
                            AND P.lngIdPregunta=PA.lngIdPregunta
                            AND U.strPuesto LIKE 'Asesor%'
                            AND NOT P.strEstado='Cerrada'
                            AND P.leido=9
                            AND PA.lngIdEmpleado=".$_SESSION['usuario'].")
                            ORDER BY Fecha DESC
                            ";
        }
        logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADConsultas->leePreguntas($IdPregunta)|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        
        //guardo en un array los datos
        if($stmt){
            logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADConsultas->leePreguntas($IdPregunta)<TRUE");
            $result='';
            $idx=0;
            while ($row=  mysql_fetch_array($stmt)){
                //guardo los datos en un array
                $result[$idx]=array(
                                "lngIdUsuario"=>$row["lngIdUsuario"],
                                "Usuario"=>$row["Usuario"],
                                "strPuesto"=>$row["strPuesto"],
                                "IdPregunta"=>$row["lngIdPregunta"],
                                "Pregunta"=>$row["strPregunta"],
                                "Clasificacion"=>$row["strClasificacion"],
                                "Estado"=>$row["strEstado"],
                                "url"=>$row["strDoc"],
                                "Fecha"=>$row["Fecha"],
                                "Leido"=>$row["leido"]
                                );
                $idx++;
            }
            
            //ahora ordeno este array por Fecha DESC
            // Obtener una lista de columnas usuarios y Fechas a ordenar
            foreach ($result as $clave => $fila) {
                $Fecha[$clave] = $fila['Fecha'];
            }
            
            // Ordenar los datos con Fecha DESC
            // Agregar $resultado como el último parámetro, para ordenar por la clave común
            array_multisort($Fecha, SORT_DESC, $result); 
            
            return $result;
        }else{
            logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADConsultas->leePreguntas($IdPregunta)<FALSE");
            return false;
        }
    }

    function leeRespuestasAPregunta($IdPregunta){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());

        $strSQL="
                SELECT R.lngIdRespuesta,R.strRespuesta,DATE_FORMAT(R.datFechaStatus,'%d/%m/%Y %H:%i') AS Fecha,
                                 R.lngIdUsuario,R.strDoc,R.leido,U.strPuesto
                FROM tbconsulta_respuestas R, tbusuarios U
                WHERE R.lngIdPregunta=$IdPregunta AND R.lngStatus=1
                AND R.lngIdUsuario=U.lngIdEmpleado
                ORDER BY Fecha ASC            
                ";
        logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADConsultas->leeRespuestasAPregunta($IdPregunta)|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        $db->desconectar();
        
        //guardo en un array los datos
        if($stmt){
            logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADConsultas->leeRespuestasAPregunta($IdPregunta)<TRUE");
            $result='';
            $idx=0;
            while ($row=  mysql_fetch_array($stmt)){
                //guardo los datos en un array
                $result[$idx]=array(
                                "lngIdRespuesta"=>$row["lngIdRespuesta"],
                                "strRespuesta"=>$row["strRespuesta"],
                                "Fecha"=>$row["Fecha"],
                                "url"=>$row["strDoc"],
                                "IdUsuario"=>$row["lngIdUsuario"],
                                "Leido"=>$row["leido"],
                                "Puesto"=>$row["strPuesto"]
                                );
                $idx++;
            }
            return $result;
        }else{
            logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADConsultas->leeRespuestasAPregunta($IdPregunta)<FALSE");
            return false;
        }
    }
    
    function ListadoConsultas($strClasificacion,$strEstado,$datFechaInicio,$datFechaFin){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());

        $strSQL="
                    SELECT P.lngIdPregunta,EP.strSesion,CONCAT(E.strNombre,' ',E.strApellidos) AS Cliente,U.strPuesto,P.strPregunta,
                    P.strClasificacion,P.strEstado,DATE_FORMAT(P.datFechaStatus,'%d/%m/%Y') AS Fecha,P.leido
                    FROM tbconsulta_pregunta P,tbempleados E,tbempresas EP,tbusuarios U
                    WHERE P.lngStatus=1
                    AND P.lngIdUsuario=E.lngIdEmpleado
                    AND E.IdEmpresa=EP.IdEmpresa
                    AND E.lngIdEmpleado=U.lngIdEmpleado
                 ";
        //añado los filtros
        if($strClasificacion<>''){
            $strSQL=$strSQL." AND P.strClasificacion='$strClasificacion'";
        }
        if($strEstado<>''){
            $strSQL=$strSQL." AND P.strEstado='$strEstado'";
        }
        if($datFechaFin<>''){
            $strSQL=$strSQL." AND P.datFechaStatus<='".fecha_to_DATETIME_F($datFechaFin)."'";
        }
        if($datFechaInicio<>''){
            $strSQL=$strSQL." AND P.datFechaStatus>='".fecha_to_DATETIME($datFechaInicio)."'";
        }
        
        logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADConsultas->ListadoConsultas($strClasificacion,$strEstado,$datFechaInicio,$datFechaFin)|| SQL : ".$strSQL);
        
        $stmt = $db->ejecutar ( $strSQL );
        $db->desconectar();
        
        //guardo en un array los datos
        if($stmt){
            logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADConsultas->ListadoConsultas($strClasificacion,$strEstado,$datFechaInicio,$datFechaFin)<TRUE");
            $result='';
            $idx=0;
            while ($row=  mysql_fetch_array($stmt)){
                //guardo los datos en un array
                $result[$idx]=array(
                                "IdPregunta"=>$row["lngIdPregunta"],
                                "Empresa"=>$row["strSesion"],
                                "Cliente"=>$row["Cliente"],
                                "Perfil"=>$row["strPuesto"],
                                "Consulta"=>$row["strPregunta"],
                                "Clasificacion"=>$row["strClasificacion"],
                                "Estado"=>$row["strEstado"],
                                "Fecha"=>$row["Fecha"],
                                "Leido"=>$row["leido"]
                                );
                $idx++;
            }
            return $result;
        }else{
            logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADConsultas->ListadoConsultas($strClasificacion,$strEstado,$datFechaInicio,$datFechaFin)<FALSE");
            return false;
        }
    }
    
    function AltaPregunta($lngIdUsuario,$strConsulta,$nombreDoc){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());

        //como voy a realizar varias operaciones contra la BBDD
        //lo hare utilizando las transacciones en MySQL
        $db->ejecutar ("START TRANSACTION");
        logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADConsultas->AltaPregunta($lngIdUsuario,$strConsulta,$nombreDoc) || START TRANSACTION");
        
        //extraigo el lngIdPregunta mas alto que haya
        $strSQL = 'SELECT lngIdPregunta FROM tbconsulta_pregunta ORDER BY lngIdPregunta DESC LIMIT 0,1';
        logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADConsultas->AltaPregunta($lngIdUsuario,$strConsulta,$nombreDoc)|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        if($stmt){
            $num=  mysql_num_rows($stmt);
            $IdPregunta=0;
            if($num>0){
                $row=  mysql_fetch_assoc($stmt);
                $IdPregunta=$row['lngIdPregunta']+1;
            }else{
                $IdPregunta=1;
            }
        }else{
            //si ha fallado la consulta hacemos ROLLBACK Y DEVOLVEMOS false
            $db->ejecutar ("ROLLBACK");
            $db->desconectar ();
            logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADConsultas->AltaPregunta($lngIdUsuario,$strConsulta,$nombreDoc)<ROLLBACK");
            return false;
        }
        logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADConsultas->AltaPregunta($lngIdUsuario,$strConsulta,$nombreDoc)|| IdPregunta : ".$IdPregunta);

        //ahora hago la insercion en la tabla
        $strSQL = "INSERT INTO tbconsulta_pregunta (lngIdPregunta, lngIdUsuario, strPregunta, strClasificacion, strEstado,
                   strDoc, lngStatus, datFechaStatus)
                   VALUES ($IdPregunta,$lngIdUsuario,'".mysql_real_escape_string($strConsulta)."','','Abierto','$nombreDoc',1,now())";
        logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADConsultas->AltaPregunta($lngIdUsuario,$strConsulta,$nombreDoc)|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );

        if(!$stmt){
            //si ha fallado la insercion hacemos ROLLBACK Y DEVOLVEMOS false
            $db->ejecutar ("ROLLBACK");
            $db->desconectar ();
            logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADConsultas->AltaPregunta($lngIdUsuario,$strConsulta,$nombreDoc)<ROLLBACK");
            return false;
        }
        
        //si todas las operaciones contra la BBDD se han efectuado correctamente se hace COMMIT y devolvemos true
        $db->ejecutar ("COMMIT");
        $db->desconectar ();
        logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADConsultas->AltaPregunta($lngIdUsuario,$strConsulta,$nombreDoc)<COMMIT");
        return $IdPregunta;
    }
    
    function AltaPreguntaAsesor($lngIdUsuario,$post,$nombreDoc){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());

        //como voy a realizar varias operaciones contra la BBDD
        //lo hare utilizando las transacciones en MySQL
        $db->ejecutar ("START TRANSACTION");
        logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADConsultas->AltaPreguntaAsesor() || START TRANSACTION");

        //primero extraigo el numero mas alto sin usar de 'tbconsulta_pregunta'
        $strSQL = 'SELECT IF(ISNULL(MAX(lngIdPregunta)),1,MAX(lngIdPregunta)+1) AS lngIdPregunta FROM tbconsulta_pregunta';
        logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADConsultas->AltaPreguntaAsesor()|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        if($stmt){
            $row=  mysql_fetch_assoc($stmt);
            $IdPregunta=$row['lngIdPregunta'];
        }else{
            //si ha fallado la consulta hacemos ROLLBACK Y DEVOLVEMOS false
            $db->ejecutar ("ROLLBACK");
            $db->desconectar ();
            logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADConsultas->AltaPreguntaAsesor()<ROLLBACK");
            return false;
        }
        logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADConsultas->AltaPreguntaAsesor()|| IdPregunta : ".$IdPregunta);

        
        //extraigo los id de los check (son las IdFactura a contabilizar) del POST
        $listIdUsuarios='';
        foreach($post as $prop=>$valor){
            if(substr($prop,0,2)==='id'){
                $IdUsuario=substr($prop,2,3);
                $listIdUsuarios[]=$IdUsuario;
            }
        }
        $strConsulta=$post['strConsulta'];
        
        //ahora hago la insercion en la tabla 'tbconsulta_pregunta'
        $strSQL = "INSERT INTO tbconsulta_pregunta (lngIdPregunta, lngIdUsuario, strPregunta, strClasificacion, strEstado,
                   strDoc, lngStatus, datFechaStatus,leido)
                   VALUES ($IdPregunta,$lngIdUsuario,'".mysql_real_escape_string($strConsulta)."','','Abierto','$nombreDoc',1,now(),9)";
        logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADConsultas->AltaPreguntaAsesor()|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );

        if(!$stmt){
            //si ha fallado la insercion hacemos ROLLBACK Y DEVOLVEMOS false
            $db->ejecutar ("ROLLBACK");
            $db->desconectar ();
            logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADConsultas->AltaPreguntaAsesor()<ROLLBACK");
            return false;
        }
        
        //y por último inserto en la tabla 'tbconsulta_pregunta_asesor' el listado de usuarios al que va esta pregunta
        for($i=0;$i<count($listIdUsuarios);$i++){
            //primero extraigo el numero mas alto sin usar de 'tbconsulta_pregunta_asesor'
            $strSQL = 'SELECT IF(ISNULL(MAX(id)),1,MAX(id)+1) AS id FROM tbconsulta_pregunta_asesor';
            logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADConsultas->AltaPreguntaAsesor()|| SQL : ".$strSQL);
            $stmt = $db->ejecutar ( $strSQL );
            if($stmt){
                $row=  mysql_fetch_assoc($stmt);
                $id=$row['id'];
            }else{
                //si ha fallado la consulta hacemos ROLLBACK Y DEVOLVEMOS false
                $db->ejecutar ("ROLLBACK");
                $db->desconectar ();
                logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                        " clsCADConsultas->AltaPreguntaAsesor()<ROLLBACK");
                return false;
            }
            logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADConsultas->AltaPreguntaAsesor()|| Id : ".$id);
            
            //ahora hago la insercion en la tabla 'tbconsulta_pregunta_asesor'
            $strSQL = "INSERT INTO tbconsulta_pregunta_asesor (id, lngIdPregunta,lngIdEmpleado,Leido)
                       VALUES ($id,$IdPregunta,".$listIdUsuarios[$i].",0)";
            logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADConsultas->AltaPreguntaAsesor()|| SQL : ".$strSQL);
            $stmt = $db->ejecutar ( $strSQL );

            if(!$stmt){
                //si ha fallado la insercion hacemos ROLLBACK Y DEVOLVEMOS false
                $db->ejecutar ("ROLLBACK");
                $db->desconectar ();
                logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                        " clsCADConsultas->AltaPreguntaAsesor()<ROLLBACK");
                return false;
            }
        }
        
        //si todas las operaciones contra la BBDD se han efectuado correctamente se hace COMMIT y devolvemos true
        $db->ejecutar ("COMMIT");
        $db->desconectar ();
        logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADConsultas->AltaPreguntaAsesor()<COMMIT");
        return $IdPregunta;
    }
    
    function ActualizarPregunta($IdPregunta,$strClasificacion,$strEstado){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());
        
        //actualizo la pregunta en cuestion
        $strSQL = "UPDATE tbconsulta_pregunta SET strClasificacion='$strClasificacion', strEstado='$strEstado' WHERE lngIdPregunta=$IdPregunta";
        logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADConsultas->ActualizarPregunta($IdPregunta,$strClasificacion,$strEstado)|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        
        if($stmt){
            return true;
        }else{
            return false;
        }
        
    }
    
    function AltaRespuestaAPregunta($lngIdUsuario,$strRespuesta,$numPregunta,$nombreDoc){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());

        //como voy a realizar varias operaciones contra la BBDD
        $db->ejecutar ("START TRANSACTION");
        logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADConsultas->AltaRespuestaAPregunta($lngIdUsuario,$strRespuesta,$numPregunta,$nombreDoc) || START TRANSACTION");
        
        //extraigo el lngIdPregunta mas alto que haya
        $strSQL = 'SELECT lngIdRespuesta FROM tbconsulta_respuestas ORDER BY lngIdRespuesta DESC LIMIT 0,1';
        logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADConsultas->AltaRespuestaAPregunta($lngIdUsuario,$strRespuesta,$numPregunta,$nombreDoc)|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        if($stmt){
            $num=  mysql_num_rows($stmt);
            $IdRespuesta=0;
            if($num>0){
                $row=  mysql_fetch_assoc($stmt);
                $IdRespuesta=$row['lngIdRespuesta']+1;
            }else{
                $IdRespuesta=1;
            }
        }else{
            //si ha fallado la consulta hacemos ROLLBACK Y DEVOLVEMOS false
            $db->ejecutar ("ROLLBACK");
            $db->desconectar ();
            logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADConsultas->AltaRespuestaAPregunta($lngIdUsuario,$strRespuesta,$numPregunta,$nombreDoc)<ROLLBACK");
            return false;
        }
        logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADConsultas->AltaRespuestaAPregunta($lngIdUsuario,$strRespuesta,$numPregunta,$nombreDoc)|| IdRespuestas : ".$IdRespuesta);

        //ahora hago la insercion en la tabla
        $strSQL = "INSERT INTO tbconsulta_respuestas (lngIdRespuesta,lngIdPregunta, lngIdUsuario, strRespuesta, strDoc, lngStatus, datFechaStatus)
                   VALUES ($IdRespuesta,$numPregunta,$lngIdUsuario,'".mysql_real_escape_string($strRespuesta)."','$nombreDoc',1,now())";
        logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADConsultas->AltaRespuestaAPregunta($lngIdUsuario,$strRespuesta,$numPregunta,$nombreDoc)|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        
        if(!$stmt){
            //si ha fallado la insercion hacemos ROLLBACK Y DEVOLVEMOS false
            $db->ejecutar ("ROLLBACK");
            $db->desconectar ();
            logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADConsultas->AltaRespuestaAPregunta($lngIdUsuario,$strRespuesta,$numPregunta,$nombreDoc)<ROLLBACK");
            return false;
        }
        //si todas las operaciones contra la BBDD se han efectuado correctamente se hace COMMIT y devolvemos true
        $db->ejecutar ("COMMIT");
        $db->desconectar ();
        logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADConsultas->AltaRespuestaAPregunta($lngIdUsuario,$strRespuesta,$numPregunta,$nombreDoc)<COMMIT");
        return $IdRespuesta;
    }
    
    function RespuestaEstadoRespondida($idPregunta){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());
        
        $strSQL = "UPDATE tbconsulta_pregunta SET strEstado='Respondida' WHERE lngIdPregunta=".$idPregunta;
        logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADConsultas->RespuestaEstadoRespondida($idPregunta)|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        
        if($stmt){
            return true;
        }else{
            return false;
        }
    }
    
    function RespuestaEstadoEnCurso($idPregunta){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());
        
        $strSQL = "UPDATE tbconsulta_pregunta SET strEstado='En Curso' WHERE lngIdPregunta=".$idPregunta;
        logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADConsultas->RespuestaEstadoEnCurso($idPregunta)|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        
        if($stmt){
            return true;
        }else{
            return false;
        }
    }
    
    function fechaUltimaRespuesta($IdPregunta){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());
        
        //extraigo un listado de las respuesta ordenadas por fecha desc, 
        //cojo el primer valor que es el que busco
        $strSQL = "
                    SELECT DATE_FORMAT(R.datFechaStatus,'%d/%m/%Y') AS FechaResp,R.lngIdRespuesta,R.leido,R.lngIdUsuario 
                    FROM tbconsulta_pregunta P
                    LEFT JOIN tbconsulta_respuestas R
                    ON R.lngIdPregunta=P.lngIdPregunta
                    WHERE P.lngIdPregunta=".$IdPregunta."
                    ORDER BY R.datFechaStatus DESC
                    ";
        logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADConsultas->fechaUltimaRespuesta($IdPregunta)|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        
        if($stmt){
            $row=  mysql_fetch_assoc($stmt);
            logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADConsultas->fechaUltimaRespuesta($IdPregunta)|| Fecha : ".$row['FechaResp']);
            
            return $row;
        }else{
            logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADConsultas->fechaUltimaRespuesta($IdPregunta)|| Fecha : false");
            return false;
        }
    }
    
    function AltaDocumento($versionDoc,$optTipo,$optTipo2,$nombreDoc,$nombre,
                           $optCategoria,$strUrl,$strDescripcion,$lngIdEmpleado){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());

        //como voy a realizar varias operaciones contra la BBDD
        $db->ejecutar ("START TRANSACTION");
        logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADConsultas->AltaDocumento() || START TRANSACTION");
        
        //extraigo el lngIdPregunta mas alto que haya
        $strSQL = 'SELECT IdDocumento FROM tbdocumentos ORDER BY IdDocumento DESC LIMIT 0,1';
        logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADConsultas->AltaDocumento()|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        if($stmt){
            $num=  mysql_num_rows($stmt);
            $IdDoc=0;
            if($num>0){
                $row=  mysql_fetch_assoc($stmt);
                $IdDoc=$row['IdDocumento']+1;
            }else{
                $IdDoc=1;
            }
        }else{
            //si ha fallado la consulta hacemos ROLLBACK Y DEVOLVEMOS false
            $db->ejecutar ("ROLLBACK");
            $db->desconectar ();
            logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADConsultas->AltaDocumento()<ROLLBACK");
            return false;
        }
        logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADConsultas->AltaDocumento()|| IdDocumento : ".$IdDoc);
        
        //para averiguar el lngOrden (este campo vale para ordenar por tematicas del 1 al 8)
        //miramos los dos primeros caracateres del fichero
        $dosCarac=substr($nombreDoc, 0, 2);
        $lngOrden=8; //el mas bajo
        if($dosCarac==='MC'){
            $lngOrden=1;
        }else if($dosCarac==='PC'){
            $lngOrden=2;
        }else if($dosCarac==='PC'){
            $lngOrden=2;
        }else if($dosCarac==='IT'){
            $lngOrden=3;
        }else if($dosCarac==='FP'){
            $lngOrden=4;
        }
        
        //ahora hago la insercion en la tabla
        $strSQL = "INSERT INTO tbdocumentos (IdDocumento,IdVersion, lngTipo,lngTipo2,strDocumento,strNombre,Categoria,datFecha,
                   link,strDescripcion,lngIdResponsable,lngIdDepartamento,lngEstado,lngIdRespRevisado,lngIdRespAprobado,
                   lngOrden,lngStatus,datFechaStatus,lngIdEmpleadoStatus)
                   VALUES ($IdDoc,$versionDoc,$optTipo,'$optTipo2','$nombreDoc','$nombre','$optCategoria',now(),
                   '$strUrl','$strDescripcion',$lngIdEmpleado,0,2,0,0,
                   $lngOrden,1,now(),$lngIdEmpleado)";
        logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADConsultas->AltaDocumento()|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        
        if(!$stmt){
            //si ha fallado la insercion hacemos ROLLBACK Y DEVOLVEMOS false
            $db->ejecutar ("ROLLBACK");
            $db->desconectar ();
            logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADConsultas->AltaDocumento()<ROLLBACK");
            return false;
        }
        //si todas las operaciones contra la BBDD se han efectuado correctamente se hace COMMIT y devolvemos true
        $db->ejecutar ("COMMIT");
        $db->desconectar ();
        logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADConsultas->AltaDocumento()<COMMIT");
        return true;
    }
    
    function ListadoDocumentos($criterio){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());

        //preparo la consulta general de todos los documentos
        $strSQL="
                SELECT tbdocumentos.IdDocumento AS Id, tbdocumentos.strDocumento, tbdocumentos.IdVersion, DATE_FORMAT(tbdocumentos.datFecha,'%d/%m/%Y') AS Fecha,
                tbdocumentos.lngTipo,tbdocumentos.strDescripcion AS Descripcion,
                tbdocumentos.strNombre,tbdocumentos.link,tbdocumentos.lngOrden
                FROM tbdocumentos, tbdepartamentos, tbempleados
                WHERE tbdocumentos.lngIdResponsable = tbempleados.lngIdEmpleado
                AND tbdocumentos.lngIdDepartamento = tbdepartamentos.lngId
                AND tbdocumentos.lngStatus<>0
                ";

        //preparo la consulta segun el criterio $criterio
        switch($criterio){
            case 'Total':
                $strSQL=$strSQL.' AND tbdocumentos.lngEstado=2';
                break;
            case 'Interno':
                $strSQL=$strSQL.' AND tbdocumentos.lngEstado=2 AND tbdocumentos.lngTipo=0';
                break;
            case 'Externo':
                $strSQL=$strSQL.' AND tbdocumentos.lngEstado=2 AND tbdocumentos.lngTipo=1';
                break;
        }
        logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                " clsCADConsultas->ListadoDocumentos()|| SQL : ".$strSQL);
        
        $stmt = $db->ejecutar ( $strSQL );
        $db->desconectar ();
        $arDoc='';
        //aqui guardo los datos de la consulta
        if($stmt){
            //tengo datos
            while($row=  mysql_fetch_array($stmt,MYSQL_ASSOC)){
                $reg='';
                foreach($row as $propiedad=>$valor){
                    if(!is_numeric($propiedad)){
                        $reg[$propiedad]=$valor;
                    }
                }
                $arDoc[]=$reg;
            }
            logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADConsultas->ListadoDocumentos()|| < Devuelve Datos. ");
            return $arDoc;
        }else{
            logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                    " clsCADConsultas->ListadoDocumentos()|| < No hay Datos. ");
            //no hay datos
            return '';
        }
       
    }
    
    function datosEmpresa($idEmp){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());
                  
        $strSQL = "SELECT * FROM tbempresas WHERE IdEmpresa=$idEmp";
        logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADConsultas->datosEmpresa()|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        $db->desconectar ();
        
        if($stmt){
            $row=  mysql_fetch_array($stmt);
        }
        return $row;
    }
    
    function actualizaLeidosPreguntas($preguntas){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());

        for($i=0;$i<count($preguntas);$i++){
            //primero averiguo si es Asesor o Usuario
            $strSQL = "
                        SELECT U.strPuesto
                        FROM tbusuarios U
                        WHERE U.lngIdEmpleado=".$preguntas[$i]['lngIdUsuario']."
                      ";
            
            logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADConsultas->actualizaLeidosPreguntas()|| SQL : ".$strSQL);
            $stmt = $db->ejecutar ( $strSQL );
            
            if(!$stmt){
                $db->desconectar ();
                return false;
            }
            $row=  mysql_fetch_array($stmt);
            $tipo=$row['strPuesto'];
            
            //ahora, si es asesor (la pregunta la ha hecho un asesor) buscamos en la tabla
            //'tbconsulta_pregunta_asesor' por la pregunta y el lngIdUsuario y si esta cambiamos el leido=1
            if(substr($tipo,0,6)==='Asesor'){
                $strSQL = "
                            UPDATE tbconsulta_pregunta_asesor
                            SET leido=1
                            WHERE lngIdPregunta=".$preguntas[$i]['IdPregunta']."
                            AND lngIdEmpleado=".$_SESSION['usuario']."    
                          ";

                logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " clsCADConsultas->actualizaLeidosPreguntas()|| SQL : ".$strSQL);
                $stmt = $db->ejecutar ( $strSQL );

                if(!$stmt){
                    $db->desconectar ();
                    return false;
                }
            }else if(substr($tipo,0,7)==='Usuario'){
                $strSQL = "
                            UPDATE tbconsulta_pregunta
                            SET leido=1
                            WHERE lngIdPregunta=".$preguntas[$i]['IdPregunta']."
                            AND NOT lngIdUsuario=".$_SESSION['usuario']."    
                          ";
                logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " clsCADConsultas->actualizaLeidosPreguntas()|| SQL : ".$strSQL);
                $stmt = $db->ejecutar ( $strSQL );

                if(!$stmt){
                    $db->desconectar ();
                    return false;
                }
            }
            
            
            
            
        }
        $db->desconectar ();
        return true;
    }
    
    function ActualizaLeidosRespuestas($respApregunta){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());

        for($i=0;$i<count($respApregunta);$i++){
            
            //actualizamos las respuestas que hayan echo los usuarios, no los otros asesores y uno mismo
            //compruebo que $_SESSION[usuario] sea Usuario o Asesor
            //si es usuario puede cambiar a leido, si es Asesor no (los asesores no cambian el stado de la
            //resuesta leida, solo los usuarios)
            if(substr($respApregunta[$i]['Puesto'],0,6)<>substr($_SESSION['cargo'],0,6)){
                //NOT lngIdUsuario=$_SESSION[usuario] -> con esto compruebo que el propio usuario cambie el campo leido

                $strSQL = "
                            UPDATE tbconsulta_respuestas
                            SET leido=1
                            WHERE lngIdRespuesta=".$respApregunta[$i]['lngIdRespuesta']."
                            AND NOT lngIdUsuario=".$_SESSION['usuario']."    
                          ";
                logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " clsCADConsultas->ActualizaLeidosRespuestas()|| SQL : ".$strSQL);
                $stmt = $db->ejecutar ( $strSQL );

                if(!$stmt){
                    return false;
                }
            }
        }
        $db->desconectar ();
        return true;
    }
    
    function PreguntaEstado($IdPregunta){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());

        $strSQL = "
                    SELECT C.strEstado
                    FROM tbconsulta_pregunta C
                    WHERE C.lngIdPregunta=$IdPregunta
                  ";
        logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADConsultas->PreguntaEstado()|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );

        if($stmt){
            $row=  mysql_fetch_array($stmt);
            return $row['strEstado'];
        }else{
            return false;
        }
    }
    
    function RespuestaEstado($IdRespuesta){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());

        $strSQL = "
                    SELECT C.strEstado
                    FROM tbconsulta_respuestas R,tbconsulta_pregunta C
                    WHERE R.lngIdPregunta=C.lngIdPregunta
                    AND R.lngIdRespuesta=$IdRespuesta
                  ";
        logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADConsultas->RespuestaEstado()|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );

        if($stmt){
            $row=  mysql_fetch_array($stmt);
            return $row['strEstado'];
        }else{
            return false;
        }
    }
    
    function ListadoEmpresas(){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());

        $strSQL = "
                    SELECT E.IdEmpresa,E.strSesion
                    FROM tbempresas E
                    WHERE E.borrado=0
                  ";
        logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADConsultas->RespuestaEstado()|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );

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
        return $resultado;
    }
    
    function ListadoClaseEmpresas(){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());

        $strSQL = "
                    SELECT DISTINCT E.claseEmpresa
                    FROM tbempresas E
                    WHERE E.borrado=0
                  ";
        logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADConsultas->RespuestaEstado()|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );

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
        return $resultado;
    }
    
    function ListadoUsuarios(){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());

        //extraigo el listado de los usuarios que no son asesores con los datos suyos y de la empresa
        //a la que pertenecen
        $strSQL = "
                    SELECT E.lngIdEmpleado,EM.strSesion,CONCAT(E.strNombre,' ',E.strApellidos) AS usuario,EM.claseEmpresa 
                    FROM tbempleados E,tbempresas EM,tbusuarios U
                    WHERE E.IdEmpresa=EM.IdEmpresa
                    AND U.lngIdEmpleado=E.lngIdEmpleado
                    AND E.lngStatus=1
                    AND EM.borrado=0
                    AND U.strPuesto LIKE 'Usuario%'
                    ORDER BY EM.strSesion,usuario
                  ";
        logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADConsultas->RespuestaEstado()|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );

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
        return $resultado;
    }
    
    function LeerLeidoPreguntaAsesorUsuario($IdPregunta,$usuario){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());

        //extraigo el listado de los usuarios que no son asesores con los datos suyos y de la empresa
        //a la que pertenecen
        $strSQL = "
                    SELECT A.Leido
                    FROM tbconsulta_pregunta_asesor A
                    WHERE A.lngIdPregunta=$IdPregunta
                    AND A.lngIdEmpleado=$usuario
                  ";
        logger('traza','clsCADConsultas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " clsCADConsultas->RespuestaEstado()|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        
        if($stmt){
            $row=  mysql_fetch_array($stmt);
            return $row['Leido'];
        }else{
            return false;
        }
    }
}
?>
