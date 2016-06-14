<?php



$json = file_get_contents("http://www.qualidad-asesores.es/orders.php?from=1");
$data = json_decode($json);

echo "Datos de la url: http://www.qualidad-asesores.es/orders.php?from=1<br/><br/>";
var_dump($data);die;


?>
<!DOCTYPE html>
<html>
    <head>
        <script>
            function enviar(){
                document.form1.submit();
            }
        </script>
    </head>
    <body onload="enviar();">
        <div style="display: none;">
        <form name="form1" method="post" action="https://www.qualidad.es/contabilidad/vista/innovae_listado.php">
            <input type="hidden" name="json" value="<?php echo $json; ?>" />
        </form>
        </div>
    </body>
</html>