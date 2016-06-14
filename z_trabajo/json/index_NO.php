<?php header('Access-Control-Allow-Origin: *'); ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    
    $.getJSON("http://www.qualidad-asesores.es/orders.php?from=1", function(data){
    //$.getJSON("http://localhost:8080/json/innovae.json", function(data){
        var cad = '';
        for (indice in data){
            cad = cad + data[indice].virtuemart_order_id + " - " + data[indice].order_item_name + "<br/>";
        }
        $("#texto").html(cad);
    });


});
</script>
    </head>
    <body>
        <span id="texto"></span>        
        
    </body>
</html>