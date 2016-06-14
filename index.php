<?php
session_start();
//borramos todas la variables de sesion
session_destroy();

?>
<!DOCTYPE html>
<html>
    <head>
        <script>
            
            
//        var ua = navigator.userAgent.toLowerCase();
//        alert(ua);
        var device = navigator.userAgent;
        //aqui detecto si es un SO de windos (windows Phone)
        //si es asi es version movil
        if (device.match(/IEMobile/i) || device.match(/Mobile/i) || device.match(/Windows Phone/i) || device.match(/windows mobile/i) || device.match(/nokia/i) || device.match(/symbian/i)){
            window.location.href= "indexRedireccionar.php?nav=movil&op=<?php if(isset($_GET['op'])){echo $_GET['op'];} ?>";
        //si no es windows Phone, es otro SO    
        }else{
            //detectoel tamaño de pantalla
            if(window.devicePixelRatio===null)
            {
                var ancho = 300;
                var alto = 400;
                
                if ((screen.width < ancho) && (screen.height < alto))
                {
                    window.location.href= "indexRedireccionar.php?nav=movil&op=<?php if(isset($_GET['op'])){echo $_GET['op'];} ?>";
                }else{
                    window.location.href= "indexRedireccionar.php?nav=vista&op=<?php if(isset($_GET['op'])){echo $_GET['op'];} ?>";
                }
            }else{
                if (((screen.width / window.devicePixelRatio) < ancho) && ((screen.height / window.devicePixelRatio) < alto))
                {
                    window.location.href= "indexRedireccionar.php?nav=movil&op=<?php if(isset($_GET['op'])){echo $_GET['op'];} ?>";
                }else{
                    window.location.href= "indexRedireccionar.php?nav=vista&op=<?php if(isset($_GET['op'])){echo $_GET['op'];} ?>";
                }
            }
        }
        </script>
    </head>
    <body></body>
</html>
