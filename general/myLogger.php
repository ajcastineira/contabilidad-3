<?php

//Función para loguear información, errores, warnings etc...
//Hay que crear la carpeta log. 
//Ejemplo:   logger("INFO","ofc.php->Se loguea " . $Usuario);

function logger($tipo, $nivel, $texto) {
    //sino exite carpeta, se crea
    if(!file_exists('../log/' . $_SESSION['base'])){
        mkdir('../log/' . $_SESSION['base']);
        copy('../log/index.php','../log/' . $_SESSION['base'].'/index.php');
    }
    
    $cerrar = 0;
    if ($_SESSION['InfoLog'] == 1) {
        if ($tipo == "info") {
            $ddf = fopen('../log/' . $_SESSION['base'] . '/info.txt', 'a');
            $cerrar = 1;
        }
    }
    if ($_SESSION['ErrorLog'] == 1) {
        if ($tipo == "error") {
            $ddf = fopen('../log/' . $_SESSION['base'] . '/error.txt', 'a');
            $cerrar = 1;
        }
    }
    if ($_SESSION['WarningLog'] == 1) {
        if ($tipo == "warning") {
            $ddf = fopen('../log/' . $_SESSION['base'] . '/warning.txt', 'a');
            $cerrar = 1;
        }
    }
    if ($_SESSION['Traza'] == 1) {
        if ($tipo == "traza") {
            $ddf = fopen('../log/' . $_SESSION['base'] . '/traza.txt', 'a');
            $cerrar = 1;
        }
    }
    if ($cerrar == 1) {
        date_default_timezone_set('Europe/Madrid');
        fwrite($ddf, "[" . date("r") . " - IP:".$_SERVER['REMOTE_HOST']."] $nivel $texto\n");
        fclose($ddf);
    }
}
