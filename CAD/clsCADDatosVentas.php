<?php

class clsCADDatosVentas {
    
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
        require_once '../general/'.$_SESSION['mapeo'];
        $db = new Db();
        $db->conectar($this->getStrBD());
        
        try{
            //ahora preparo los datos a guardar en un array final de datos
            //para poder hacer esto primero guardo en un array con todos los dias del mes
            //y todos los datos de la tabla tbventas_bancos (puede haber dias repetidos)
            //y segundo hago los mismo con la tabla tbventas_tarjetas
            //y tercero hago los mismo con la tabla tbventas
            //al final lo que hago es fusionar los tres arrays
            
            
            //hago el filtro de la fecha
            $mes = date('m');
            if(isset($get['mes'])){
                $mes = $get['mes'];
            }
            $ejercicio = date('Y');
            if(isset($get['ejercicio'])){
                $ejercicio = $get['ejercicio'];
            }
            
            //indico las fechas en timestamp, que es lo que me hace falta para la consulta en MySQL
//            $fechaInicio = strtotime("01-".$mes."-".$ejercicio);
            $month = $ejercicio.'-'.$mes;
            $aux = date('Y-m-d', strtotime("{$month} + 1 month"));
            $last_day = date('Y-m-d', strtotime("{$aux} - 1 day"));
//            $fechaFin = strtotime($last_day);

            $fechaFin = date('d',strtotime($last_day));
            
            $datos = '';
            //recorro todos los dias del 1 al ultimo dia de mes
            for($index = 1; $index <= $fechaFin; $index++){
            //for($dia = $fechaInicio; $dia <= $fechaFin; $dia+= 86400){
                if(strlen($index)<2){
                    $txtI = '0'.$index;
                }else{
                    $txtI = $index;
                }
                $dia = $month . '-' . $txtI;
                
                //primero los bancos
                $strSQL = "
                            SELECT B.IdBanco,DATE_FORMAT(B.Fecha,'%d/%m/%Y') AS Fecha, B.Cantidad_distribuir, B.Distribuir, 
                            B.Cantidad, B.Cuenta, B.Asiento AS AsientoBanco
                            FROM tbventas_bancos B
                            WHERE B.Borrado=1
                            AND B.Fecha = '$dia'
                          ";
//                $strSQL = "
//                            SELECT B.IdBanco,DATE_FORMAT(B.Fecha,'%d/%m/%Y') AS Fecha, B.Cantidad_distribuir, B.Distribuir, 
//                            B.Cantidad, B.Cuenta, B.Asiento AS AsientoBanco
//                            FROM tbventas_bancos B
//                            WHERE B.Borrado=1
//                            AND UNIX_TIMESTAMP(B.Fecha) = '$dia'
//                          ";
                logger('traza','clsCADDatosVentas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " clsCADDatosVentas->ListadoVentas()|| SQL : ".$strSQL);
                $stmt = $db->ejecutar ( $strSQL );
                
                $bancos = '';
                if($stmt){
                    while($row=mysql_fetch_array($stmt)){
                        $reg='';
                        foreach($row as $propiedad=>$valor){
                            if(!is_numeric($propiedad)){
                                $reg[$propiedad]=$valor;
                            }
                        }
                        $bancos[] = $reg;
                    }
                }else{
                    throw new Exception('Error Consulta: ' . $strSQL);
                }

                
                
                $datosBancos = '';
                if(is_array($bancos)){//hay datos
                    for ($j = 0; $j < count($bancos); $j++) {
                        //compruebo que la primera vez no avance el indice general (lo hago al final)
                        // si veo que j=0 esta fila se avanzara al final, si veo que j >0 avanzo este indice
                        if($j > 0){
                            $x++;
                        }
                        $datosBanco['IdBanco'] = $bancos[$j]['IdBanco'];
                        $datosBanco['Cantidad_distribuir'] = $bancos[$j]['Cantidad_distribuir'];
                        $datosBanco['Distribuir'] = $bancos[$j]['Distribuir'];
                        $datosBanco['Cantidad'] = $bancos[$j]['Cantidad'];
                        $datosBanco['Cuenta'] = $bancos[$j]['Cuenta'];
                        $datosBanco['AsientoBanco'] = $bancos[$j]['AsientoBanco'];
                        $datosBancos[] = $datosBanco;
                    }
                }else{
                    $datosBanco['IdBanco'] = '';
                    $datosBanco['Cantidad_distribuir'] = '';
                    $datosBanco['Distribuir'] = '';
                    $datosBanco['Cantidad'] = '';
                    $datosBanco['Cuenta'] = '';
                    $datosBanco['AsientoBanco'] = '';
                    $datosBancos[] = $datosBanco;
                }
                
                
                
                //extraigo el listado de las ventas (tabla tbventas_tarjetas)
                $strSQL = "
                            SELECT V.IdTarjeta,DATE_FORMAT(V.Fecha,'%d/%m/%Y') AS Fecha,V.TipoTarjeta,V.Bruto,
                            V.Comision,V.Liquido,V.CuentaTarjeta,V.Asiento AS AsientoTarjeta
                            FROM tbventas_tarjetas V
                            WHERE V.Borrado=1
                            AND V.Fecha = '$dia'
                          ";
//                $strSQL = "
//                            SELECT V.IdTarjeta,DATE_FORMAT(V.Fecha,'%d/%m/%Y') AS Fecha,V.TipoTarjeta,V.Bruto,
//                            V.Comision,V.Liquido,V.CuentaTarjeta,V.Asiento AS AsientoTarjeta
//                            FROM tbventas_tarjetas V
//                            WHERE V.Borrado=1
//                            AND UNIX_TIMESTAMP(V.Fecha) = '$dia'
//                          ";
                logger('traza','clsCADDatosVentas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " clsCADDatosVentas->ListadoVentas()|| SQL : ".$strSQL);
                $stmt = $db->ejecutar ( $strSQL );

                $visa = '';
                if($stmt){
                    while($row=mysql_fetch_array($stmt)){
                        $reg='';
                        foreach($row as $propiedad=>$valor){
                            if(!is_numeric($propiedad)){
                                $reg[$propiedad]=$valor;
                            }
                        }
                        $visa[] = $reg;
                    }
                }else{
                    throw new Exception('Error Consulta: ' . $strSQL);
                }
                
                
                $datosTarjetas = '';
                if(is_array($visa)){
                    for ($j = 0; $j < count($visa); $j++) {
                        //compruebo que la primera vez no avance el indice general (lo hago al final)
                        // si veo que j=0 esta fila se avanzara al final, si veo que j >0 avanzo este indice
                        if($j > 0){
                            $x++;
                        }
                        $datosTarjeta['IdTarjeta'] = $visa[$j]['IdTarjeta'];
                        $datosTarjeta['TipoTarjeta'] = $visa[$j]['TipoTarjeta'];
                        $datosTarjeta['Bruto'] = $visa[$j]['Bruto'];
                        $datosTarjeta['Comision'] = $visa[$j]['Comision'];
                        $datosTarjeta['Liquido'] = $visa[$j]['Liquido'];
                        $datosTarjeta['CuentaTarjeta'] = $visa[$j]['CuentaTarjeta'];
                        $datosTarjeta['AsientoTarjeta'] = $visa[$j]['AsientoTarjeta'];
                        $datosTarjetas[] = $datosTarjeta;
                    }
                }else{
                    $datosTarjeta['IdTarjeta'] = '';
                    $datosTarjeta['TipoTarjeta'] = '';
                    $datosTarjeta['Bruto'] = '';
                    $datosTarjeta['Comision'] = '';
                    $datosTarjeta['Liquido'] = '';
                    $datosTarjeta['CuentaTarjeta'] = '';
                    $datosTarjeta['AsientoTarjeta'] = '';
                    $datosTarjetas[] = $datosTarjeta;
                }
                
                
                //ahora extraigo el array de la tabla "tbventas"
                $strSQL = "
                            SELECT V.IdVenta,DATE_FORMAT(V.Fecha,'%d/%m/%Y') AS Fecha, V.BaseI,
                            V.IVA, V.Ventas, V.Asiento  AS AsientoVentas, V.Factura
                            FROM tbventas V
                            WHERE V.Borrado=1
                            AND V.Fecha = '$dia'
                          ";
//                $strSQL = "
//                            SELECT V.IdVenta,DATE_FORMAT(V.Fecha,'%d/%m/%Y') AS Fecha, V.BaseI,
//                            V.IVA, V.Ventas, V.Asiento  AS AsientoVentas, V.Factura
//                            FROM tbventas V
//                            WHERE V.Borrado=1
//                            AND UNIX_TIMESTAMP(V.Fecha) = '$dia'
//                          ";
                logger('traza','clsCADDatosVentas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " clsCADDatosVentas->ListadoVentas()|| SQL : ".$strSQL);
                $stmt = $db->ejecutar ( $strSQL );

                $dVentas = '';
                if($stmt){
                    while($row=mysql_fetch_array($stmt)){
                        foreach($row as $propiedad=>$valor){
                            if(!is_numeric($propiedad)){
                                $dVentas[$propiedad]=$valor;
                            }
                        }
                    }
                }else{
                    throw new Exception('Error Consulta: ' . $strSQL);
                }
                
                
                //ahora fusiono estos dos arrays de este dia
                $maxBancos = count($datosBancos)-1;
                $maxTarjetas = count($datosTarjetas)-1;
                $max = $maxBancos;
                if($maxBancos < $maxTarjetas){
                    $max = $maxTarjetas;
                }
                $diaFormateado = explode('-', $dia);
                $diaFormateado = $diaFormateado[2] . '/' . $diaFormateado[1] . '/' .$diaFormateado[0];
                
                //recorro los dos arrays (ire comprobando que no me salgo del indice de uno de los dos arrays)
                for ($i = 0; $i <= $max; $i++) {
                    $dato['Fecha'] = $diaFormateado;
                    if(isset($datosBancos[$i])){
                        $dato['IdBanco'] = $datosBancos[$i]['IdBanco'];
                        $dato['Cantidad_distribuir'] = $datosBancos[$i]['Cantidad_distribuir'];
                        $dato['Distribuir'] = $datosBancos[$i]['Distribuir'];
                        $dato['Cantidad'] = $datosBancos[$i]['Cantidad'];
                        $dato['Cuenta'] = $datosBancos[$i]['Cuenta'];
                        $dato['AsientoBanco'] = $datosBancos[$i]['AsientoBanco'];
                    }else{
                        $dato['IdBanco'] = '';
                        $dato['Cantidad_distribuir'] = '';
                        $dato['Distribuir'] = '';
                        $dato['Cantidad'] = '';
                        $dato['Cuenta'] = '';
                        $dato['AsientoBanco'] = '';
                    }
                    
                    if(isset($datosTarjetas[$i])){
                        $dato['IdTarjeta'] = $datosTarjetas[$i]['IdTarjeta'];
                        $dato['TipoTarjeta'] = $datosTarjetas[$i]['TipoTarjeta'];
                        $dato['Bruto'] = $datosTarjetas[$i]['Bruto'];
                        $dato['Comision'] = $datosTarjetas[$i]['Comision'];
                        $dato['Liquido'] = $datosTarjetas[$i]['Liquido'];
                        $dato['CuentaTarjeta'] = $datosTarjetas[$i]['CuentaTarjeta'];
                        $dato['AsientoTarjeta'] = $datosTarjetas[$i]['AsientoTarjeta'];
                    }else{
                        $dato['IdTarjeta'] = '';
                        $dato['TipoTarjeta'] = '';
                        $dato['Bruto'] = '';
                        $dato['Comision'] = '';
                        $dato['Liquido'] = '';
                        $dato['CuentaTarjeta'] = '';
                        $dato['AsientoTarjeta'] = '';
                    }
                    
                    //ahora incluyo datos de la tabla "tbventas"
                    //veo si $dVentas['IdVenta'] != '' y $dVentas['AsientoVentas'] sea numerico
                    //si es asi, pongo el dato a leer de BBDD, sino del calculo 
                    $dato['DatoALeerDe'] = 'calculo';
                    if($dVentas['IdVenta'] !== '' && is_numeric($dVentas['AsientoVentas'])){
                        $dato['DatoALeerDe'] = 'BBDD';
                    }
                    
                    $datos[] = $dato;
                }
                
                //y ahora incluyo los datos de la tabla "tbventas" en esta ultima linea (que es la del dia)
                $datos[count($datos)-1]['IdVenta'] = $dVentas['IdVenta'];
                $datos[count($datos)-1]['BaseI'] = $dVentas['BaseI'];
                $datos[count($datos)-1]['IVA'] = $dVentas['IVA'];
                $datos[count($datos)-1]['Ventas'] = $dVentas['Ventas'];
                $datos[count($datos)-1]['Factura'] = $dVentas['Factura'];
                $datos[count($datos)-1]['AsientoVentas'] = $dVentas['AsientoVentas'];
            }
            
            
            
            
            
            $db->desconectar ();
            
            logger('traza','clsCADDatosVentas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADDatosVentas->ListadoVentas()|| TRUE (Devuelvo datos");
            return $datos;
            
        }  catch (Exception $e){
            //si hay error lo capturamos y salimos
            $db->desconectar ();
            logger('error','clsCADDatosVentas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADDatosVentas->ListadoVentas()|| ERROR : ".$e->getMessage());
            return 'false';
        }
    }

    function ListadoVentasBancos($get){
        require_once '../general/'.$_SESSION['mapeo'];
        $db = new Db();
        $db->conectar($this->getStrBD());
        
        try{
            //ahora preparo los datos a guardar en un array final de datos
            //para poder hacer esto primero guardo en un array on todos los dias del mes
            //y todos los datos de la tabla tbventas_bancos (puede haber diras repetidos
            //y segundo hago los mismo con la tabla tbventas_tarjetas
            //al final lo que hago es fusionar los dos arrays
            
            
            //hago el filtro de la fecha
            $mes = date('m');
            if(isset($get['mes'])){
                $mes = $get['mes'];
            }
            $ejercicio = date('Y');
            if(isset($get['ejercicio'])){
                $ejercicio = $get['ejercicio'];
            }
            
            //indico las fechas en timestamp, que es lo que me hace falta para la consulta en MySQL
//            $fechaInicio = strtotime("01-".$mes."-".$ejercicio);
            $month = $ejercicio.'-'.$mes;
            $aux = date('Y-m-d', strtotime("{$month} + 1 month"));//avanzo un mes
            $last_day = date('Y-m-d', strtotime("{$aux} - 1 day"));//resto un dia, asi es el ultimo dia del mes anterior
//            $fechaFin = strtotime($last_day);

            $fechaFin = date('d',strtotime($last_day));
            
            $datos = '';
            //recorro todos los dias del 1 al ultimo dia de mes
            for($index = 1; $index <= $fechaFin; $index++){
            //for($dia = $fechaInicio; $dia <= $fechaFin; $dia+= 86400){
                if(strlen($index)<2){
                    $txtI = '0'.$index;
                }else{
                    $txtI = $index;
                }
                $dia = $month . '-' . $txtI;
                
                //primero los bancos
                $strSQL = "
                            SELECT B.IdBanco,DATE_FORMAT(B.Fecha,'%d/%m/%Y') AS Fecha, B.Cantidad_distribuir, B.Distribuir, 
                            B.Cantidad, B.Cuenta, B.Asiento AS AsientoBanco
                            FROM tbventas_bancos B
                            WHERE B.Borrado=1
                            AND B.Fecha = '$dia'
                          ";
//                $strSQL = "
//                            SELECT B.IdBanco,DATE_FORMAT(B.Fecha,'%d/%m/%Y') AS Fecha, B.Cantidad_distribuir, B.Distribuir, 
//                            B.Cantidad, B.Cuenta, B.Asiento AS AsientoBanco
//                            FROM tbventas_bancos B
//                            WHERE B.Borrado=1
//                            AND UNIX_TIMESTAMP(B.Fecha) = '$dia'
//                          ";
                logger('traza','clsCADDatosVentas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " clsCADDatosVentas->ListadoVentasBancos()|| SQL : ".$strSQL);
                $stmt = $db->ejecutar ( $strSQL );
                
                $bancos = '';
                if($stmt){
                    while($row=mysql_fetch_array($stmt)){
                        $reg='';
                        foreach($row as $propiedad=>$valor){
                            if(!is_numeric($propiedad)){
                                $reg[$propiedad]=$valor;
                            }
                        }
                        $bancos[] = $reg;
                    }
                }else{
                    throw new Exception('Error Consulta: ' . $strSQL);
                }

                
                
                $datosBancos = '';
                if(is_array($bancos)){//hay datos
                    for ($j = 0; $j < count($bancos); $j++) {
                        //compruebo que la primera vez no avance el indice general (lo hago al final)
                        // si veo que j=0 esta fila se avanzara al final, si veo que j >0 avanzo este indice
                        if($j > 0){
                            $x++;
                        }
                        $datosBanco['IdBanco'] = $bancos[$j]['IdBanco'];
                        $datosBanco['Cantidad_distribuir'] = $bancos[$j]['Cantidad_distribuir'];
                        $datosBanco['Distribuir'] = $bancos[$j]['Distribuir'];
                        $datosBanco['Cantidad'] = $bancos[$j]['Cantidad'];
                        $datosBanco['Cuenta'] = $bancos[$j]['Cuenta'];
                        $datosBanco['AsientoBanco'] = $bancos[$j]['AsientoBanco'];
                        $datosBancos[] = $datosBanco;
                    }
                }else{
                    $datosBanco['IdBanco'] = '';
                    $datosBanco['Cantidad_distribuir'] = '';
                    $datosBanco['Distribuir'] = '';
                    $datosBanco['Cantidad'] = '';
                    $datosBanco['Cuenta'] = '';
                    $datosBanco['AsientoBanco'] = '';
                    $datosBancos[] = $datosBanco;
                }
                
                
                //ahora fusiono estos dos arrays de este dia
                $maxBancos = count($datosBancos)-1;
                $max = $maxBancos;
                $diaFormateado = explode('-', $dia);
                $diaFormateado = $diaFormateado[2] . '/' . $diaFormateado[1] . '/' .$diaFormateado[0];
                
                //recorro los dos arrays (ire comprobando que no me salgo del indice de uno de los dos arrays)
                for ($i = 0; $i <= $max; $i++) {
                    $dato['Fecha'] = $diaFormateado;
                    if(isset($datosBancos[$i])){
                        $dato['IdBanco'] = $datosBancos[$i]['IdBanco'];
                        $dato['Cantidad_distribuir'] = $datosBancos[$i]['Cantidad_distribuir'];
                        $dato['Distribuir'] = $datosBancos[$i]['Distribuir'];
                        $dato['Cantidad'] = $datosBancos[$i]['Cantidad'];
                        $dato['Cuenta'] = $datosBancos[$i]['Cuenta'];
                        $dato['AsientoBanco'] = $datosBancos[$i]['AsientoBanco'];
                    }else{
                        $dato['IdBanco'] = '';
                        $dato['Cantidad_distribuir'] = '';
                        $dato['Distribuir'] = '';
                        $dato['Cantidad'] = '';
                        $dato['Cuenta'] = '';
                        $dato['AsientoBanco'] = '';
                    }
                    $datos[] = $dato;
                }
            }
            
            $db->desconectar ();
            
            logger('traza','clsCADDatosVentas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADDatosVentas->ListadoVentasBancos()|| TRUE (Devuelvo datos");
            return $datos;
            
        }  catch (Exception $e){
            //si hay error lo capturamos y salimos
            $db->desconectar ();
            logger('error','clsCADDatosVentas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADDatosVentas->ListadoVentasBancos()|| ERROR : ".$e->getMessage());
            return 'false';
        }
    }

    function ListadoVentasTarjetas($get){
        require_once '../general/'.$_SESSION['mapeo'];
        $db = new Db();
        $db->conectar($this->getStrBD());
        
        try{
            //ahora preparo los datos a guardar en un array final de datos
            //para poder hacer esto primero guardo en un array on todos los dias del mes
            //y todos los datos de la tabla tbventas_bancos (puede haber diras repetidos
            //y segundo hago los mismo con la tabla tbventas_tarjetas
            //al final lo que hago es fusionar los dos arrays
            
            
            //hago el filtro de la fecha
            $mes = date('m');
            if(isset($get['mes'])){
                $mes = $get['mes'];
            }
            $ejercicio = date('Y');
            if(isset($get['ejercicio'])){
                $ejercicio = $get['ejercicio'];
            }
            
            //indico las fechas en timestamp, que es lo que me hace falta para la consulta en MySQL
//            $fechaInicio = strtotime("01-".$mes."-".$ejercicio);
            $month = $ejercicio.'-'.$mes;
            $aux = date('Y-m-d', strtotime("{$month} + 1 month"));
            $last_day = date('Y-m-d', strtotime("{$aux} - 1 day"));
//            $fechaFin = strtotime($last_day);

            $fechaFin = date('d',strtotime($last_day));
            
            $datos = '';
            //recorro todos los dias del 1 al ultimo dia de mes
            for($index = 1; $index <= $fechaFin; $index++){
            //for($dia = $fechaInicio; $dia <= $fechaFin; $dia+= 86400){
                if(strlen($index)<2){
                    $txtI = '0'.$index;
                }else{
                    $txtI = $index;
                }
                $dia = $month . '-' . $txtI;
                //extraigo el listado de las ventas (tabla tbventas_tarjetas)
                $strSQL = "
                            SELECT V.IdTarjeta,DATE_FORMAT(V.Fecha,'%d/%m/%Y') AS Fecha,V.TipoTarjeta,V.Bruto,
                            V.Comision,V.Liquido,V.CuentaTarjeta,V.Asiento AS AsientoTarjeta
                            FROM tbventas_tarjetas V
                            WHERE V.Borrado=1
                            AND V.Fecha = '$dia'
                          ";
//                $strSQL = "
//                            SELECT V.IdTarjeta,DATE_FORMAT(V.Fecha,'%d/%m/%Y') AS Fecha,V.TipoTarjeta,V.Bruto,
//                            V.Comision,V.Liquido,V.CuentaTarjeta,V.Asiento AS AsientoTarjeta
//                            FROM tbventas_tarjetas V
//                            WHERE V.Borrado=1
//                            AND UNIX_TIMESTAMP(V.Fecha) = '$dia'
//                          ";
                
                //filtro de la tarjeta
                if(isset($get['tarjeta']) && $get['tarjeta'] !== '' && $get['tarjeta'] !== 'Todas'){
                    $strSQL = $strSQL . " AND V.TipoTarjeta = '".$get['tarjeta']."'";
                }
                
                logger('traza','clsCADDatosVentas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                       " clsCADDatosVentas->ListadoVentasTarjetas()|| SQL : ".$strSQL);
                $stmt = $db->ejecutar ( $strSQL );

                $visa = '';
                if($stmt){
                    while($row=mysql_fetch_array($stmt)){
                        $reg='';
                        foreach($row as $propiedad=>$valor){
                            if(!is_numeric($propiedad)){
                                $reg[$propiedad]=$valor;
                            }
                        }
                        $visa[] = $reg;
                    }
                }else{
                    throw new Exception('Error Consulta: ' . $strSQL);
                }
                
                
                $datosTarjetas = '';
                if(is_array($visa)){
                    for ($j = 0; $j < count($visa); $j++) {
                        //compruebo que la primera vez no avance el indice general (lo hago al final)
                        // si veo que j=0 esta fila se avanzara al final, si veo que j >0 avanzo este indice
                        if($j > 0){
                            $x++;
                        }
                        $datosTarjeta['IdTarjeta'] = $visa[$j]['IdTarjeta'];
                        $datosTarjeta['TipoTarjeta'] = $visa[$j]['TipoTarjeta'];
                        $datosTarjeta['Bruto'] = $visa[$j]['Bruto'];
                        $datosTarjeta['Comision'] = $visa[$j]['Comision'];
                        $datosTarjeta['Liquido'] = $visa[$j]['Liquido'];
                        $datosTarjeta['CuentaTarjeta'] = $visa[$j]['CuentaTarjeta'];
                        $datosTarjeta['AsientoTarjeta'] = $visa[$j]['AsientoTarjeta'];
                        $datosTarjetas[] = $datosTarjeta;
                    }
                }else{
                    $datosTarjeta['IdTarjeta'] = '';
                    $datosTarjeta['TipoTarjeta'] = '';
                    $datosTarjeta['Bruto'] = '';
                    $datosTarjeta['Comision'] = '';
                    $datosTarjeta['Liquido'] = '';
                    $datosTarjeta['CuentaTarjeta'] = '';
                    $datosTarjeta['AsientoTarjeta'] = '';
                    $datosTarjetas[] = $datosTarjeta;
                }
                
                //ahora fusiono estos dos arrays de este dia
                $maxTarjetas = count($datosTarjetas)-1;
                $max = $maxTarjetas;
                $diaFormateado = explode('-', $dia);
                $diaFormateado = $diaFormateado[2] . '/' . $diaFormateado[1] . '/' .$diaFormateado[0];
                
                //recorro los dos arrays (ire comprobando que no me salgo del indice de uno de los dos arrays)
                for ($i = 0; $i <= $max; $i++) {
                    $dato['Fecha'] = $diaFormateado;
                    if(isset($datosTarjetas[$i])){
                        $dato['IdTarjeta'] = $datosTarjetas[$i]['IdTarjeta'];
                        $dato['TipoTarjeta'] = $datosTarjetas[$i]['TipoTarjeta'];
                        $dato['Bruto'] = $datosTarjetas[$i]['Bruto'];
                        $dato['Comision'] = $datosTarjetas[$i]['Comision'];
                        $dato['Liquido'] = $datosTarjetas[$i]['Liquido'];
                        $dato['CuentaTarjeta'] = $datosTarjetas[$i]['CuentaTarjeta'];
                        $dato['AsientoTarjeta'] = $datosTarjetas[$i]['AsientoTarjeta'];
                    }else{
                        $dato['IdTarjeta'] = '';
                        $dato['TipoTarjeta'] = '';
                        $dato['Bruto'] = '';
                        $dato['Comision'] = '';
                        $dato['Liquido'] = '';
                        $dato['CuentaTarjeta'] = '';
                        $dato['AsientoTarjeta'] = '';
                    }
                    $datos[] = $dato;
                }
            }
            
            $db->desconectar ();
            
            logger('traza','clsCADDatosVentas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADDatosVentas->ListadoVentasTarjetas()|| TRUE (Devuelvo datos");
            return $datos;
            
        }  catch (Exception $e){
            //si hay error lo capturamos y salimos
            $db->desconectar ();
            logger('error','clsCADDatosVentas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADDatosVentas->ListadoVentasTarjetas()|| ERROR : ".$e->getMessage());
            return 'false';
        }
    }


    function ListadoCuentasBancos(){
        require_once '../general/'.$_SESSION['mapeo'];
        $db = new Db();
        $db->conectar($this->getStrBD());
        
        try{
            //primero las polizas
            $strSQL = "
                        SELECT C.NumCuenta, C.Nombre
                        FROM tbcuenta C
                        WHERE C.NumCuenta LIKE '5201%' AND C.Borrado = 0
                      ";
            logger('traza','clsCADDatosVentas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADDatosVentas->ListadoCuentasBancos()|| SQL : ".$strSQL);
            $stmt = $db->ejecutar ( $strSQL );

            $bancos = '';
            if($stmt){
                while($row=mysql_fetch_array($stmt)){
                    $reg='';
                    foreach($row as $propiedad=>$valor){
                        if(!is_numeric($propiedad)){
                            $reg[$propiedad]=$valor;
                        }
                    }
                    $bancos[] = $reg;
                }
            }else{
                throw new Exception('Error Consulta: ' . $strSQL);
            }
            
            
            //segundo los bancos
            $strSQL = "
                        SELECT C.NumCuenta, C.Nombre
                        FROM tbcuenta C
                        WHERE C.NumCuenta LIKE '5720%' AND C.Borrado = 0
                      ";
            logger('traza','clsCADDatosVentas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADDatosVentas->ListadoCuentasBancos()|| SQL : ".$strSQL);
            $stmt = $db->ejecutar ( $strSQL );

            if($stmt){
                while($row=mysql_fetch_array($stmt)){
                    $reg='';
                    foreach($row as $propiedad=>$valor){
                        if(!is_numeric($propiedad)){
                            $reg[$propiedad]=$valor;
                        }
                    }
                    $bancos[] = $reg;
                }
            }else{
                throw new Exception('Error Consulta: ' . $strSQL);
            }
        
            $db->desconectar ();
            
            logger('traza','clsCADDatosVentas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADDatosVentas->ListadoCuentasBancos()|| TRUE (Devuelvo datos");
            return $bancos;
        
        }  catch (Exception $e){
            //si hay error lo capturamos y salimos
            $db->desconectar ();
            logger('error','clsCADDatosVentas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADDatosVentas->ListadoCuentasBancos()|| ERROR : ".$e->getMessage());
            return 'false';
        }
    }

    function actualizarBancoFilaCampoCD($datos){
        require_once '../general/'.$_SESSION['mapeo'];
        $db = new Db();
        $db->conectar($this->getStrBD());
        
        try{
            //consulta SQL
            $strSQL = "
                        UPDATE tbventas_bancos
                        SET Cantidad_distribuir = ".$datos['Cantidad_distribuir']."
                        WHERE IdBanco = ".$datos['IdBanco']."
                      ";
            logger('traza','clsCADDatosVentas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADDatosVentas->actualizarBancoFilaCampoCD()|| SQL : ".$strSQL);
            $stmt = $db->ejecutar ( $strSQL );
            
            $db->desconectar ();
            if($stmt){
                return true;
            }else{
                return false;
            }
        }  catch (Exception $e){
            //si hay error lo capturamos y salimos
            $db->desconectar ();
            logger('error','clsCADDatosVentas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADDatosVentas->actualizarBancoFilaCampoCD()|| ERROR : ".$e->getMessage());
            return 'false';
        }
    }
    
    function nuevaBancoFilaCampoCD($datos,$cuentaBanco){
        require_once '../general/'.$_SESSION['mapeo'];
        $db = new Db();
        $db->conectar($this->getStrBD());
        
        try{
            //consultas SQL
            $strSQL = "
                        SELECT IF(ISNULL(MAX(IdBanco)),1,MAX(IdBanco)+1) AS IdBanco FROM tbventas_bancos
                      ";
            logger('traza','clsCADDatosVentas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADDatosVentas->nuevaBancoFilaCampoCD()|| SQL : ".$strSQL);
            $stmt = $db->ejecutar ( $strSQL );

            if(!$stmt){
                $db->desconectar ();
                return false;
            }
            $row = mysql_fetch_array($stmt);
            $IdBanco = $row['IdBanco'];
            
            $strSQL = "
                        INSERT INTO tbventas_bancos
                        (IdBanco,Fecha,Cantidad_distribuir,Cuenta,Asiento,Borrado)
                        VALUES
                        ($IdBanco,'".$datos['fechaFila']."',".$datos['Cantidad_distribuir'].",$cuentaBanco,'P',1)
                      ";
            
            $stmt = $db->ejecutar ( $strSQL );
            $db->desconectar ();
            if($stmt){
                return true;
            }else{
                return false;
            }
        }  catch (Exception $e){
            //si hay error lo capturamos y salimos
            $db->desconectar ();
            logger('error','clsCADDatosVentas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADDatosVentas->nuevaBancoFilaCampoCD()|| ERROR : ".$e->getMessage());
            return 'false';
        }
    }
    
    function ListadoBancosJS(){
        require_once '../general/'.$_SESSION['mapeo'];
        $db = new Db();
        $db->conectar($this->getStrBD());
        
        try{
            //primero las polizas
            $strSQL = "
                        SELECT C.NumCuenta, C.Nombre
                        FROM tbcuenta C
                        WHERE C.NumCuenta LIKE '5201%' AND C.Borrado = 0
                      ";
            logger('traza','clsCADDatosVentas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADDatosVentas->ListadoBancosJS()|| SQL : ".$strSQL);
            $stmt = $db->ejecutar ( $strSQL );

            $bancos = '';
            if($stmt){
                while($row=mysql_fetch_array($stmt)){
                    $reg='';
                    foreach($row as $propiedad=>$valor){
                        if(!is_numeric($propiedad)){
                            $reg[$propiedad]=$valor;
                        }
                    }
                    $bancos[] = $reg;
                }
            }else{
                throw new Exception('Error Consulta: ' . $strSQL);
            }
            
            
            //segundo los bancos
            $strSQL = "
                        SELECT C.NumCuenta, C.Nombre
                        FROM tbcuenta C
                        WHERE C.NumCuenta LIKE '5720%' AND C.Borrado = 0
                      ";
            logger('traza','clsCADDatosVentas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADDatosVentas->ListadoBancosJS()|| SQL : ".$strSQL);
            $stmt = $db->ejecutar ( $strSQL );

            if($stmt){
                while($row=mysql_fetch_array($stmt)){
                    $reg='';
                    foreach($row as $propiedad=>$valor){
                        if(!is_numeric($propiedad)){
                            $reg[$propiedad]=$valor;
                        }
                    }
                    $bancos[] = $reg;
                }
            }else{
                throw new Exception('Error Consulta: ' . $strSQL);
            }
        
            $db->desconectar ();
            
            logger('traza','clsCADDatosVentas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADDatosVentas->ListadoBancosJS()|| TRUE (Devuelvo datos");
            return $bancos;
        
        }  catch (Exception $e){
            //si hay error lo capturamos y salimos
            $db->desconectar ();
            logger('error','clsCADDatosVentas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADDatosVentas->ListadoBancosJS()|| ERROR : ".$e->getMessage());
            return 'false';
        }
    }
    
    function ListadoTarjetas($filtro){
        require_once '../general/'.$_SESSION['mapeo'];
        $db = new Db();
        $db->conectar($this->getStrBD());
        
        try{
            //primero los bancos
            $strSQL = "
                        SELECT C.NumCuenta, C.Nombre FROM tbcuenta C
                        WHERE C.Borrado=0
                        AND C.NumCuenta LIKE '$filtro%'
                      ";
            logger('traza','clsCADDatosVentas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADDatosVentas->ListadoTarjetas()|| SQL : ".$strSQL);
            $stmt = $db->ejecutar ( $strSQL );

            $bancos = '';
            if($stmt){
                while($row=mysql_fetch_array($stmt)){
                    $reg='';
                    foreach($row as $propiedad=>$valor){
                        if(!is_numeric($propiedad)){
                            $reg[$propiedad]=$valor;
                        }
                    }
                    $bancos[] = $reg;
                }
            }else{
                throw new Exception('Error Consulta: ' . $strSQL);
            }
        
            $db->desconectar ();
            
            logger('traza','clsCADDatosVentas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADDatosVentas->ListadoTarjetas()|| TRUE (Devuelvo datos");
            return $bancos;
        
        }  catch (Exception $e){
            //si hay error lo capturamos y salimos
            $db->desconectar ();
            logger('error','clsCADDatosVentas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADDatosVentas->ListadoTarjetas()|| ERROR : ".$e->getMessage());
            return 'false';
        }
    }
    
    function nombreTarjeta($TipoTarjeta){
        require_once '../general/'.$_SESSION['mapeo'];
        $db = new Db();
        $db->conectar($this->getStrBD());
        
        try{
            //primero los bancos
            $strSQL = "
                        SELECT C.Nombre
                        FROM tbcuenta C
                        WHERE C.NumCuenta = '$TipoTarjeta'
                        AND C.Borrado=0
                      ";
            logger('traza','clsCADDatosVentas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADDatosVentas->nombreTarjeta()|| SQL : ".$strSQL);
            $stmt = $db->ejecutar ( $strSQL );
            $db->desconectar ();

            $nombre = '';
            if($stmt){
                $row = mysql_fetch_array($stmt);
                $nombre = $row['Nombre'];
            }else{
                throw new Exception('Error Consulta: ' . $strSQL);
            }
        
            
            logger('traza','clsCADDatosVentas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADDatosVentas->nombreTarjeta()|| TRUE (Devuelvo datos");
            return $nombre;
        
        }  catch (Exception $e){
            //si hay error lo capturamos y salimos
            logger('error','clsCADDatosVentas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADDatosVentas->nombreTarjeta()|| ERROR : ".$e->getMessage());
            return 'false';
        }
    }
    
    function nombreCuenta($cuenta){
        require_once '../general/'.$_SESSION['mapeo'];
        $db = new Db();
        $db->conectar($this->getStrBD());
        
        try{
            //primero los bancos
            $strSQL = "
                        SELECT C.Nombre
                        FROM tbcuenta C
                        WHERE C.NumCuenta = '$cuenta'
                        AND C.Borrado=0
                      ";
            logger('traza','clsCADDatosVentas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADDatosVentas->nombreTarjeta()|| SQL : ".$strSQL);
            $stmt = $db->ejecutar ( $strSQL );
            $db->desconectar ();

            $nombre = '';
            if($stmt){
                $row = mysql_fetch_array($stmt);
                $nombre = $row['Nombre'];
            }else{
                throw new Exception('Error Consulta: ' . $strSQL);
            }

            logger('traza','clsCADDatosVentas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADDatosVentas->nombreTarjeta()|| TRUE (Devuelvo datos");
            //ahora preparamos el nombre, que está compuesto de el numero sin la parte 4 primeras cifras
            //si viene null o vacio la respuesta es texto vacio
            if($cuenta === null || $cuenta === ''){
                return '';
            }
            $num = (int)substr($cuenta, 4);
            
            return $num . ' - ' . $nombre;
        
        }  catch (Exception $e){
            //si hay error lo capturamos y salimos
            logger('error','clsCADDatosVentas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
                   " clsCADDatosVentas->nombreTarjeta()|| ERROR : ".$e->getMessage());
            return 'false';
        }
    }
}
