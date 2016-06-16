<?php
require_once '../CN/clsCNDatosVentas.php';


$_SESSION['mapeo'] = $_POST['mapeo'];



$clsCNDatosVentas = new clsCNDatosVentas();
//$clsCNDatosVentas->setStrBD($_SESSION['dbContabilidad']);
$clsCNDatosVentas->setStrBDCliente($_SESSION['mapeo']);


$get['mes'] = $_POST['mes'];
$get['ejercicio'] = $_POST['ejercicio'];
$get['cmdConsultar'] = 'Consultar';
$get['cmdListar'] = 'OK';


$arResult = $clsCNDatosVentas->ListadoVentas($get);

$datos = '';
if(is_array($arResult)){
    //voy a recorrer todos los dias del mes y ejercicio
    $mes = date('m');
    if(isset($get['mes'])){
        $mes = $get['mes'];
    }
    $ejercicio = date('Y');
    if(isset($get['ejercicio'])){
        $ejercicio = $get['ejercicio'];
    }

    //indico el recorrido por los dias del mes 
    $fechaInicio = 1;
    $month = $ejercicio.'-'.$mes;
    $aux = date('Y-m-d', strtotime("{$month} + 1 month"));
    $fechaFin = date('d', strtotime("{$aux} - 1 day"));

    $par = 'NO';
    //vbles de sumas parciales de ventas
    $ventas_dia = 0;
    $BaseI_dia = 0;
    $IVA_dia = 0;
    $dia_calculo = '';

    $sumaBaseI = 0;
    $sumaIVA = 0;
    $sumaVentas = 0;

    $sumaBruto = 0;
    $sumaComision = 0;
    $sumaLiquido = 0;

    for($i = $fechaInicio; $i <= $fechaFin; $i++){
        //preparo el array de $arResult[$i] para enviar por url
        $link="";

        $dia = $i.'/'.$mes.'/'.$ejercicio;
        if(strlen($dia)<10){
            $dia = '0' . $dia;
        }

        for ($ii = 0; $ii < count($arResult); $ii++) {
            if($dia === $arResult[$ii]['Fecha']){
                $fecha = explode('/',$dia);
                $fecha = $fecha[2].$fecha[1].$fecha[0];
                $dia_calculo = $arResult[$ii]['Fecha'];
                $dia_calculo_anterior = $arResult[$ii+1]['Fecha'];

//                $colorBkgd = 'ffffff';
//                if($par === 'NO'){
//                    $colorBkgd = 'e8f4ff';
//                    $par = 'SI';
//                }else{
//                    $par = 'NO';
//                }

                //suma parcial
                $sumaDistribuir = (float)$sumaDistribuir + (float)$arResult[$ii]['Cantidad_distribuir'];
                $sumaCantidades = (float)$sumaCantidades + (float)$arResult[$ii]['Cantidad'];
                $sumaDiferencia = $sumaDistribuir - $sumaCantidades;

                $sumaBruto = (float)$sumaBruto + (float)$arResult[$ii]['Bruto'];
                $sumaComision = (float)$sumaComision + (float)$arResult[$ii]['Comision'];
                $sumaLiquido = (float)$sumaLiquido + (float)$arResult[$ii]['Liquido'];

                //Ventas
                //1º veo si hay datos guardado (vienen en el array $arResult)
                //veo $arResult[$ii]['DatoALeerDe'] != 'BBDD'
                //si es asi, escribo los datos del array (de la BBDD)
                //sino los calculo de los datos de las tablas "tbventas_bancos" y "tbventas_tarjetas"
                if($arResult[$ii]['DatoALeerDe'] === 'BBDD'){
                    //escribo del array de la BBDD
                    $ventas = $arResult[$ii]['Ventas'];
                    $BaseI = $arResult[$ii]['BaseI'];
                    $IVA = $arResult[$ii]['IVA'];
                }else{
                    //hago los calculos necesarios para los campos de Base I. IVA y Ventas
                    //Ventas = C.Distribuir + Bruto
                    //BaseI = Ventas /(1+IVA)
                    //IVA = Ventas - BaseI
                    $ventas = $arResult[$ii]['Cantidad_distribuir'] + $arResult[$ii]['Bruto'];
                    $BaseI = round($ventas / (($IvaGenerico / 100) + 1),2);
                    $IVA = $ventas - $BaseI;
                }

                //sumo a las vbles parciales
                $ventas_dia = (float)$ventas_dia + (float)$ventas;
                $BaseI_dia = (float)$BaseI_dia + (float)$BaseI;
                $IVA_dia = (float)$IVA_dia + (float)$IVA;


                //ahora compruebo si el dia de hoy es distinto o no al anterior
                //si es distinto, escribo stos valores en el cuadro
                $txtBaseI = '';
                $txtIVA = '';
                $txtVentas = '';
                if($dia_calculo !== $dia_calculo_anterior){
                    $dato = '';
                    //escribo las sumas en el cuadro
                    $txtBaseI = $BaseI_dia;//BORRAR
                    $txtIVA = $IVA_dia;//BORRAR
                    $txtVentas = $ventas_dia;//BORRAR
                    
                    $dato['Fecha'] = $dia_calculo;
                    $dato['Base'] = $BaseI_dia;
                    $dato['IVA'] = $IVA_dia;
                    $dato['Ventas'] = $ventas_dia;
                    $datos[] = $dato;
                    
                    //las sumas
                    $sumaBaseI = (float)$sumaBaseI + (float)$BaseI_dia;
                    $sumaIVA =  (float)$sumaIVA + (float)$IVA_dia;
                    $sumaVentas =  (float)$sumaVentas + (float)$ventas_dia;

                    
                    
                    //pongo las vbles a 0
                    $BaseI_dia = 0;
                    $IVA_dia = 0;
                    $ventas_dia = 0;
                }


            }
        }

    }
    
    
}


echo json_encode($datos);
?>
