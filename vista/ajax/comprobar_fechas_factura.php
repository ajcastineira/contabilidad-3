<?php
session_start();
class facturas{

    public function buscarFechas($NumFacturaBBDD){
        require_once '../../general/'.$_SESSION['mapeo'];
        $db = new Db();
        $db->conectar($_SESSION['mapeo']);

        //calculo el numero de factura anterior
        $NumFacturaBBDD_Anterior = $NumFacturaBBDD - 1;
        //calculo el numero de factura posterior
        $NumFacturaBBDD_Posterior = $NumFacturaBBDD + 1;

        //busco las fechas de las facturas anteriores a esta factura
        $strSQL="
                SELECT F.NumFactura,DATE_FORMAT(F.FechaFactura, '%Y-%m-%d') AS FechaFactura, F.Borrado
                FROM tbmisfacturas F
                WHERE F.NumFactura <= '$NumFacturaBBDD_Anterior'
                ORDER BY F.NumFactura DESC
                ";
        
        $stmt = $db->ejecutar ( $strSQL );

        $listadoAnteriores = '';
        while($row = mysql_fetch_array($stmt)){
            $reg = '';
            foreach($row as $propiedad => $valor){
                if(!is_numeric($propiedad)){
                    $reg[$propiedad] = $valor;
                }
            }
            $listadoAnteriores[] = $reg;
        }
        
        $datos = '';
        $datos["fechaAnterior"] = '';
        //recorro este listado de facturas anteriores hasta encontrar la primera factura valida
        for ($i1 = 0; $i1 < count($listadoAnteriores); $i1++) {
            if($listadoAnteriores[$i1]['Borrado'] === '1'){
                if(isset($listadoAnteriores[$i1]["FechaFactura"])){
                    $datos["fechaAnterior"] = $listadoAnteriores[$i1]["FechaFactura"];
                    $datos["NumFacturaBBDD_Anterior"] = $listadoAnteriores[$i1]["NumFactura"];
                    break;
                }
            }
        }
        
        
        //busco las fechas de las facturas posteriores a esta factura
        $strSQL="
                SELECT F.NumFactura,DATE_FORMAT(F.FechaFactura, '%Y-%m-%d') AS FechaFactura, F.Borrado
                FROM tbmisfacturas F
                WHERE F.NumFactura>='$NumFacturaBBDD_Posterior'
                ORDER BY F.NumFactura ASC
                ";

        $stmt = $db->ejecutar ( $strSQL );
        $db->desconectar ();

        $listadoPosteriores = '';
        while($row = mysql_fetch_array($stmt)){
            $reg = '';
            foreach($row as $propiedad => $valor){
                if(!is_numeric($propiedad)){
                    $reg[$propiedad] = $valor;
                }
            }
            $listadoPosteriores[] = $reg;
        }
        
        //recorro este listado de facturas posteriores hasta encontrar la primera factura valida
        $datos["fechaPosterior"] = '';
        for ($i1 = 0; $i1 < count($listadoPosteriores); $i1++) {
            if($listadoPosteriores[$i1]['Borrado'] === '1'){
                if(isset($listadoPosteriores[$i1]["FechaFactura"])){
                    $datos["fechaPosterior"] = $listadoPosteriores[$i1]["FechaFactura"];
                    $datos["NumFacturaBBDD_Posterior"] = $listadoPosteriores[$i1]["NumFactura"];
                    break;
                }
            }
        }
        
        return $datos;
    }
}

$facturas = new facturas();

$datos = json_encode($facturas->buscarFechas($_GET['NumFacturaBBDD']));

echo $datos;
?>

