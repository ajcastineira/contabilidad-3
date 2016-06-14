<?php header('Access-Control-Allow-Origin: *'); ?>

<!DOCTYPE html>
<html> 
  <head> 
     <title>Evaluar una variable que contiene notación JSON</title> 
     <meta http-equiv="Content-Type" 
              content="text/html; charset=UTF-8">
     <script src="http://code.jquery.com/jquery-1.11.3.min.js" type="text/javascript"></script> 
 </head> 
 <body> 
   <span style="color:#33CC33; font-size:24px" id="texto"></span>
   <script type="text/javascript">
       $(document).ready(function () {
           //$("#boton1").click(function () {
               var cad = "Los libros en el archivo JSON son:<br />";
               //var cadena = $.getJSON("http://localhost:8080/json/datos.json", function (data) {
               var cadena = $.getJSON("http://www.qualidad-asesores.es/orders.php?from=1", function (data) {
                   for (indice in data) {
                       cad += ("<br />" + data[indice].virtuemart_order_id + " de " +
                           data[indice].virtuemart_user_id +
                           "<br />").replace("y undefined", "").replace(", undefined", "");
                    }
                   $("#texto").html(cad);
               })     
           //})
       });
	</script>  		    		   
    </body> 
</html>