<?php
session_start();
require_once '../CAD/clsCADLogin.php';
$clsCADLogin=new clsCADLogin();

require_once '../CN/clsCNDefault2.php';
require_once '../general/funcionesGenerales.php';

//Control de Sesion
ControlaLoginTimeOut();

//Control de Permisos. Hay que incluirlo en todas las páginas
/**************************************************************/
$strPagina=dameURL();
$strCargo = trim($_SESSION['cargo']);   //Esto es el puesto al que le hacemos un trim

$lngPermiso = AccesoUsuarioPagina ($strPagina, $strCargo);  // Le pasamos la página y el cargo. 
logger('warning',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
       "  lngPermiso : ".$lngPermiso);

if ($lngPermiso==-1)
{//Se ha producido un error de base. TENDREMOS QUE PASAR A LA FUNCION ERROR
    ControlErrorPermiso();
    die;
}
if ($lngPermiso==0)
{//El usuario no tiene permisos por tanto mostramos error
    ControlAvisoPermiso();
    die;
}

//Si devuelve 1 entonces que siga el flujo 
/**************************************************************/
$clsCNDefault2 = new clsCNDefault2();

//busco los avisos pendientes qe tiene el usuario
//busco en las tablas 'tbconsulta_pregunta' y 'tbconsulta_respuestas' los que tengan el valor
//de campo leido=0 yque sean de su lngIdUsuario
$eventosPendientes=$clsCNDefault2->eventosPendientes($_SESSION['usuario']);
$numEventos=0;
if(is_array($eventosPendientes)){
    $numEventos=count($eventosPendientes);
}

//extraigo los arrays de los ficheros y los textos de los menus
$ficheros = $clsCNDefault2->extraeNombreFicheros();
$textos = $clsCNDefault2->extraeTextosMenu();
$claseEmpresa=$clsCNDefault2->claseEmpresa($_SESSION['idEmp']);

require_once '../CN/clsCNUsu.php';
$clsCNUsu = new clsCNUsu();
$clsCNUsu->setStrBD($_SESSION['dbContabilidad']);
$datosUsuario = $clsCNUsu->DatosEmpleado($_SESSION['usuario'], 0);

require_once '../CN/clsCNContabilidad.php';
$clsCNContabilidad = new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['mapeo']);

$tieneArticulos = $clsCNContabilidad->Parametro_general('articulo', date('Y-m-d H:i:s'), date('Y-m-d H:i:s'));

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <link rel="shortcut icon" href="../images/q.ico">
        <title>Sistema de Gesti&oacute;n de la Contabilidad</title>
        <style type="text/css"> 
            <!--
            a {  text-decoration: none}
            -->
        </style>
        <SCRIPT LANGUAGE="Javascript"> 
            <!--
            function msgAlertaACP(){
                window.alert('Acciones Correctivas/Preventivas Pendientes.');
            }
            //-->
        </SCRIPT>
        <script language="JavaScript">
            <!-- //
            var txt="-    Sistema de Gestión de la Calidad    ";
            var espera=120;
            var refresco=null;
 
            function rotulo_status() {
                window.status=txt;
                txt=txt.substring(1,txt.length)+txt.charAt(0);        
                refresco=setTimeout("rotulo_status()",espera);
            }
 
            // --></script>
<!--        <SCRIPT language="JavaScript" SRC="/include/frames.js"> 
        </SCRIPT>-->
        <SCRIPT LANGUAGE="JavaScript"> 
            <!-- 
            function nueva(ventana, nombre, activo) 
            { 
                if (activo == 1)
                { 
                    var statusConfirm = confirm ('¿Acepta las Condiciones de Uso?');
                    if (statusConfirm == true) 
                    { 
                        open(ventana, nombre, 'width=800,height=600,top=20,resizable=1,scrollbars=yes,toolbar=no')
                    }else{ 
                        history.back ();
                    } 
                } 
            } 
            //--> 
        </SCRIPT> 
        <link rel="stylesheet" href="../css/Estilos_Qualidad.css" type="text/css">
        <link href="../css/calidad2.css" rel="stylesheet" type="text/css">

        <?php
        //colores de fondo
        $fondo1 = '#bdbdbd';
        $fondo2 = '#cccccc';
        $fondo3 = '#dddddd';
        $fondo4 = '#eeeeee';
        
        // http://www.colorzilla.com/gradient-editor/
        // grey Pipe
        // corro la barra central o Location=100 y despues Hue/Saturation lo voy desplazando o introduzco cantidad
        $fondo1="
                background: #f5f6f6; /* Old browsers */
                /* IE9 SVG, needs conditional override of 'filter' to 'none' */
                background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2Y1ZjZmNiIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjIxJSIgc3RvcC1jb2xvcj0iI2RiZGNlMiIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjgwJSIgc3RvcC1jb2xvcj0iI2RkZGZlMyIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNiOGJhYzYiIHN0b3Atb3BhY2l0eT0iMSIvPgogICAgPHN0b3Agb2Zmc2V0PSIxMDAlIiBzdG9wLWNvbG9yPSIjZjVmNmY2IiBzdG9wLW9wYWNpdHk9IjEiLz4KICA8L2xpbmVhckdyYWRpZW50PgogIDxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIxIiBoZWlnaHQ9IjEiIGZpbGw9InVybCgjZ3JhZC11Y2dnLWdlbmVyYXRlZCkiIC8+Cjwvc3ZnPg==);
                background: -moz-linear-gradient(top,  #f5f6f6 0%, #dbdce2 21%, #dddfe3 80%, #b8bac6 100%, #f5f6f6 100%); /* FF3.6+ */
                background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f5f6f6), color-stop(21%,#dbdce2), color-stop(80%,#dddfe3), color-stop(100%,#b8bac6), color-stop(100%,#f5f6f6)); /* Chrome,Safari4+ */
                background: -webkit-linear-gradient(top,  #f5f6f6 0%,#dbdce2 21%,#dddfe3 80%,#b8bac6 100%,#f5f6f6 100%); /* Chrome10+,Safari5.1+ */
                background: -o-linear-gradient(top,  #f5f6f6 0%,#dbdce2 21%,#dddfe3 80%,#b8bac6 100%,#f5f6f6 100%); /* Opera 11.10+ */
                background: -ms-linear-gradient(top,  #f5f6f6 0%,#dbdce2 21%,#dddfe3 80%,#b8bac6 100%,#f5f6f6 100%); /* IE10+ */
                background: linear-gradient(to bottom,  #f5f6f6 0%,#dbdce2 21%,#dddfe3 80%,#b8bac6 100%,#f5f6f6 100%); /* W3C */
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f5f6f6', endColorstr='#f5f6f6',GradientType=0 ); /* IE6-8 */
                ";
        $fondo2="
                background: #f9f9f9; /* Old browsers */
                /* IE9 SVG, needs conditional override of 'filter' to 'none' */
                background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2Y5ZjlmOSIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjIxJSIgc3RvcC1jb2xvcj0iI2U2ZTZlYSIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjgwJSIgc3RvcC1jb2xvcj0iI2U3ZThlYiIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9Ijk4JSIgc3RvcC1jb2xvcj0iI2NjY2RkNiIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNmOWY5ZjkiIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
                background: -moz-linear-gradient(top,  #f9f9f9 0%, #e6e6ea 21%, #e7e8eb 80%, #cccdd6 98%, #f9f9f9 100%); /* FF3.6+ */
                background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f9f9f9), color-stop(21%,#e6e6ea), color-stop(80%,#e7e8eb), color-stop(98%,#cccdd6), color-stop(100%,#f9f9f9)); /* Chrome,Safari4+ */
                background: -webkit-linear-gradient(top,  #f9f9f9 0%,#e6e6ea 21%,#e7e8eb 80%,#cccdd6 98%,#f9f9f9 100%); /* Chrome10+,Safari5.1+ */
                background: -o-linear-gradient(top,  #f9f9f9 0%,#e6e6ea 21%,#e7e8eb 80%,#cccdd6 98%,#f9f9f9 100%); /* Opera 11.10+ */
                background: -ms-linear-gradient(top,  #f9f9f9 0%,#e6e6ea 21%,#e7e8eb 80%,#cccdd6 98%,#f9f9f9 100%); /* IE10+ */
                background: linear-gradient(to bottom,  #f9f9f9 0%,#e6e6ea 21%,#e7e8eb 80%,#cccdd6 98%,#f9f9f9 100%); /* W3C */
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f9f9f9', endColorstr='#f9f9f9',GradientType=0 ); /* IE6-8 */
                ";
        $fondo3="
                background: #fbfbfb; /* Old browsers */
                /* IE9 SVG, needs conditional override of 'filter' to 'none' */
                background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2ZiZmJmYiIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjIxJSIgc3RvcC1jb2xvcj0iI2YxZjFmMyIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjgwJSIgc3RvcC1jb2xvcj0iI2YyZjNmNCIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNlMmUzZTgiIHN0b3Atb3BhY2l0eT0iMSIvPgogICAgPHN0b3Agb2Zmc2V0PSIxMDAlIiBzdG9wLWNvbG9yPSIjZmJmYmZiIiBzdG9wLW9wYWNpdHk9IjEiLz4KICA8L2xpbmVhckdyYWRpZW50PgogIDxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIxIiBoZWlnaHQ9IjEiIGZpbGw9InVybCgjZ3JhZC11Y2dnLWdlbmVyYXRlZCkiIC8+Cjwvc3ZnPg==);
                background: -moz-linear-gradient(top,  #fbfbfb 0%, #f1f1f3 21%, #f2f3f4 80%, #e2e3e8 100%, #fbfbfb 100%); /* FF3.6+ */
                background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#fbfbfb), color-stop(21%,#f1f1f3), color-stop(80%,#f2f3f4), color-stop(100%,#e2e3e8), color-stop(100%,#fbfbfb)); /* Chrome,Safari4+ */
                background: -webkit-linear-gradient(top,  #fbfbfb 0%,#f1f1f3 21%,#f2f3f4 80%,#e2e3e8 100%,#fbfbfb 100%); /* Chrome10+,Safari5.1+ */
                background: -o-linear-gradient(top,  #fbfbfb 0%,#f1f1f3 21%,#f2f3f4 80%,#e2e3e8 100%,#fbfbfb 100%); /* Opera 11.10+ */
                background: -ms-linear-gradient(top,  #fbfbfb 0%,#f1f1f3 21%,#f2f3f4 80%,#e2e3e8 100%,#fbfbfb 100%); /* IE10+ */
                background: linear-gradient(to bottom,  #fbfbfb 0%,#f1f1f3 21%,#f2f3f4 80%,#e2e3e8 100%,#fbfbfb 100%); /* W3C */
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fbfbfb', endColorstr='#fbfbfb',GradientType=0 ); /* IE6-8 */
                ";
        $fondo4="
                background: #fcfcfc; /* Old browsers */
                /* IE9 SVG, needs conditional override of 'filter' to 'none' */
                background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2ZjZmNmYyIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjIxJSIgc3RvcC1jb2xvcj0iI2Y0ZjRmNiIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjgwJSIgc3RvcC1jb2xvcj0iI2Y0ZjVmNiIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNlOWU5ZWQiIHN0b3Atb3BhY2l0eT0iMSIvPgogICAgPHN0b3Agb2Zmc2V0PSIxMDAlIiBzdG9wLWNvbG9yPSIjZmNmY2ZjIiBzdG9wLW9wYWNpdHk9IjEiLz4KICA8L2xpbmVhckdyYWRpZW50PgogIDxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIxIiBoZWlnaHQ9IjEiIGZpbGw9InVybCgjZ3JhZC11Y2dnLWdlbmVyYXRlZCkiIC8+Cjwvc3ZnPg==);
                background: -moz-linear-gradient(top,  #fcfcfc 0%, #f4f4f6 21%, #f4f5f6 80%, #e9e9ed 100%, #fcfcfc 100%); /* FF3.6+ */
                background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#fcfcfc), color-stop(21%,#f4f4f6), color-stop(80%,#f4f5f6), color-stop(100%,#e9e9ed), color-stop(100%,#fcfcfc)); /* Chrome,Safari4+ */
                background: -webkit-linear-gradient(top,  #fcfcfc 0%,#f4f4f6 21%,#f4f5f6 80%,#e9e9ed 100%,#fcfcfc 100%); /* Chrome10+,Safari5.1+ */
                background: -o-linear-gradient(top,  #fcfcfc 0%,#f4f4f6 21%,#f4f5f6 80%,#e9e9ed 100%,#fcfcfc 100%); /* Opera 11.10+ */
                background: -ms-linear-gradient(top,  #fcfcfc 0%,#f4f4f6 21%,#f4f5f6 80%,#e9e9ed 100%,#fcfcfc 100%); /* IE10+ */
                background: linear-gradient(to bottom,  #fcfcfc 0%,#f4f4f6 21%,#f4f5f6 80%,#e9e9ed 100%,#fcfcfc 100%); /* W3C */
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fcfcfc', endColorstr='#fcfcfc',GradientType=0 ); /* IE6-8 */
                ";
        
        $hover="
                background: #f5f6f6; /* Old browsers */
                /* IE9 SVG, needs conditional override of 'filter' to 'none' */
                background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2Y1ZjZmNiIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjIxJSIgc3RvcC1jb2xvcj0iI2RiZGNlMiIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjgwJSIgc3RvcC1jb2xvcj0iI2RkZGZlMyIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNiOGJhYzYiIHN0b3Atb3BhY2l0eT0iMSIvPgogICAgPHN0b3Agb2Zmc2V0PSIxMDAlIiBzdG9wLWNvbG9yPSIjZjVmNmY2IiBzdG9wLW9wYWNpdHk9IjEiLz4KICA8L2xpbmVhckdyYWRpZW50PgogIDxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIxIiBoZWlnaHQ9IjEiIGZpbGw9InVybCgjZ3JhZC11Y2dnLWdlbmVyYXRlZCkiIC8+Cjwvc3ZnPg==);
                background: -moz-linear-gradient(top,  #f5f6f6 0%, #dbdce2 21%, #eaf0fc 80%, #b8bac6 100%, #f5f6f6 100%); /* FF3.6+ */
                background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f5f6f6), color-stop(21%,#dbdce2), color-stop(80%,#eaf0fc), color-stop(100%,#b8bac6), color-stop(100%,#f5f6f6)); /* Chrome,Safari4+ */
                background: -webkit-linear-gradient(top,  #f5f6f6 0%,#dbdce2 21%,#eaf0fc 80%,#b8bac6 100%,#f5f6f6 100%); /* Chrome10+,Safari5.1+ */
                background: -o-linear-gradient(top,  #f5f6f6 0%,#dbdce2 21%,#eaf0fc 80%,#b8bac6 100%,#f5f6f6 100%); /* Opera 11.10+ */
                background: -ms-linear-gradient(top,  #f5f6f6 0%,#dbdce2 21%,#eaf0fc 80%,#b8bac6 100%,#f5f6f6 100%); /* IE10+ */
                background: linear-gradient(to bottom,  #f5f6f6 0%,#dbdce2 21%,#eaf0fc 80%,#b8bac6 100%,#f5f6f6 100%); /* W3C */
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f5f6f6', endColorstr='#f5f6f6',GradientType=0 ); /* IE6-8 */
                ";
        $hover2="
                background: #f9f9f9; /* Old browsers */
                /* IE9 SVG, needs conditional override of 'filter' to 'none' */
                background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2Y5ZjlmOSIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjIxJSIgc3RvcC1jb2xvcj0iI2U2ZTZlYSIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjgwJSIgc3RvcC1jb2xvcj0iI2U3ZThlYiIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9Ijk4JSIgc3RvcC1jb2xvcj0iI2NjY2RkNiIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNmOWY5ZjkiIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
                background: -moz-linear-gradient(top,  #f9f9f9 0%, #e6e6ea 21%, #eaf0fc 80%, #cccdd6 98%, #f9f9f9 100%); /* FF3.6+ */
                background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f9f9f9), color-stop(21%,#e6e6ea), color-stop(80%,#eaf0fc), color-stop(98%,#cccdd6), color-stop(100%,#f9f9f9)); /* Chrome,Safari4+ */
                background: -webkit-linear-gradient(top,  #f9f9f9 0%,#e6e6ea 21%,#eaf0fc 80%,#cccdd6 98%,#f9f9f9 100%); /* Chrome10+,Safari5.1+ */
                background: -o-linear-gradient(top,  #f9f9f9 0%,#e6e6ea 21%,#eaf0fc 80%,#cccdd6 98%,#f9f9f9 100%); /* Opera 11.10+ */
                background: -ms-linear-gradient(top,  #f9f9f9 0%,#e6e6ea 21%,#eaf0fc 80%,#cccdd6 98%,#f9f9f9 100%); /* IE10+ */
                background: linear-gradient(to bottom,  #f9f9f9 0%,#e6e6ea 21%,#eaf0fc 80%,#cccdd6 98%,#f9f9f9 100%); /* W3C */
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f9f9f9', endColorstr='#f9f9f9',GradientType=0 ); /* IE6-8 */
                ";
        $hover3="
                background: #fbfbfb; /* Old browsers */
                /* IE9 SVG, needs conditional override of 'filter' to 'none' */
                background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2ZiZmJmYiIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjIxJSIgc3RvcC1jb2xvcj0iI2YxZjFmMyIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjgwJSIgc3RvcC1jb2xvcj0iI2YyZjNmNCIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNlMmUzZTgiIHN0b3Atb3BhY2l0eT0iMSIvPgogICAgPHN0b3Agb2Zmc2V0PSIxMDAlIiBzdG9wLWNvbG9yPSIjZmJmYmZiIiBzdG9wLW9wYWNpdHk9IjEiLz4KICA8L2xpbmVhckdyYWRpZW50PgogIDxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIxIiBoZWlnaHQ9IjEiIGZpbGw9InVybCgjZ3JhZC11Y2dnLWdlbmVyYXRlZCkiIC8+Cjwvc3ZnPg==);
                background: -moz-linear-gradient(top,  #fbfbfb 0%, #f1f1f3 21%, #ffffff 80%, #e2e3e8 100%, #fbfbfb 100%); /* FF3.6+ */
                background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#fbfbfb), color-stop(21%,#f1f1f3), color-stop(80%,#ffffff), color-stop(100%,#e2e3e8), color-stop(100%,#fbfbfb)); /* Chrome,Safari4+ */
                background: -webkit-linear-gradient(top,  #fbfbfb 0%,#f1f1f3 21%,#ffffff 80%,#e2e3e8 100%,#fbfbfb 100%); /* Chrome10+,Safari5.1+ */
                background: -o-linear-gradient(top,  #fbfbfb 0%,#f1f1f3 21%,#ffffff 80%,#e2e3e8 100%,#fbfbfb 100%); /* Opera 11.10+ */
                background: -ms-linear-gradient(top,  #fbfbfb 0%,#f1f1f3 21%,#ffffff 80%,#e2e3e8 100%,#fbfbfb 100%); /* IE10+ */
                background: linear-gradient(to bottom,  #fbfbfb 0%,#f1f1f3 21%,#ffffff 80%,#e2e3e8 100%,#fbfbfb 100%); /* W3C */
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fbfbfb', endColorstr='#fbfbfb',GradientType=0 ); /* IE6-8 */
                ";
        $hover4="
                background: #fcfcfc; /* Old browsers */
                /* IE9 SVG, needs conditional override of 'filter' to 'none' */
                background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2ZjZmNmYyIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjIxJSIgc3RvcC1jb2xvcj0iI2Y0ZjRmNiIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjgwJSIgc3RvcC1jb2xvcj0iI2Y0ZjVmNiIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNlOWU5ZWQiIHN0b3Atb3BhY2l0eT0iMSIvPgogICAgPHN0b3Agb2Zmc2V0PSIxMDAlIiBzdG9wLWNvbG9yPSIjZmNmY2ZjIiBzdG9wLW9wYWNpdHk9IjEiLz4KICA8L2xpbmVhckdyYWRpZW50PgogIDxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIxIiBoZWlnaHQ9IjEiIGZpbGw9InVybCgjZ3JhZC11Y2dnLWdlbmVyYXRlZCkiIC8+Cjwvc3ZnPg==);
                background: -moz-linear-gradient(top,  #fcfcfc 0%, #f4f4f6 21%, #ffffff 80%, #e9e9ed 100%, #fcfcfc 100%); /* FF3.6+ */
                background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#fcfcfc), color-stop(21%,#f4f4f6), color-stop(80%,#ffffff), color-stop(100%,#e9e9ed), color-stop(100%,#fcfcfc)); /* Chrome,Safari4+ */
                background: -webkit-linear-gradient(top,  #fcfcfc 0%,#f4f4f6 21%,#ffffff 80%,#e9e9ed 100%,#fcfcfc 100%); /* Chrome10+,Safari5.1+ */
                background: -o-linear-gradient(top,  #fcfcfc 0%,#f4f4f6 21%,#ffffff 80%,#e9e9ed 100%,#fcfcfc 100%); /* Opera 11.10+ */
                background: -ms-linear-gradient(top,  #fcfcfc 0%,#f4f4f6 21%,#ffffff 80%,#e9e9ed 100%,#fcfcfc 100%); /* IE10+ */
                background: linear-gradient(to bottom,  #fcfcfc 0%,#f4f4f6 21%,#ffffff 80%,#e9e9ed 100%,#fcfcfc 100%); /* W3C */
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fcfcfc', endColorstr='#fcfcfc',GradientType=0 ); /* IE6-8 */
                ";
        
        ?>
        <style type="text/css">
            .menu_list {
                text-align: left;
                width: 300px;
                margin:1px;
            }

            p.menu_head1{
                text-align: left;
                font-size:16px;
                padding: 5px 10px;
/*                color:#0b3861;*/
                color: #d11010;
                cursor: pointer;
                margin:1px;
                <?php echo $fondo1; ?>;
                text-decoration:none;
                border-radius: 7px;
            }
            
            p.menu_head1:hover{
                <?php echo $hover; ?>;
            }
            div.menu_body2 {
                display:none;
                padding-left: 30px;
            }
            div.menu_body2 a{
                text-align: left;
                font-size:14px;
                display:block;
                color:#0D6091;
                <?php echo $fondo2; ?>;
                margin:1px;
                padding: 5px 10px;
                text-decoration:none;
                border-radius: 7px;
            }
            div.menu_body2 a:hover{
                <?php echo $hover2; ?>;
            }

            p.menu_head2{
                text-align: left;
                font-size:14px;
                padding: 5px 10px;
                color:#0D6091;
                cursor: pointer;
                margin:1px;
                <?php echo $fondo2; ?>;
                text-decoration:none;
                border-radius: 7px;
            }
            p.menu_head2:hover{
                <?php echo $hover2; ?>;
            }
            div.menu_body3 {
                display:none;
                padding-left: 30px;
            }
            div.menu_body3 a{
                text-align: left;
                font-size:14px;
                display:block;
                color:#7E47CC;
                <?php echo $fondo3; ?>;
                margin:1px;
                padding: 5px 10px;
                text-decoration:none;
                border-radius: 7px;
            }
            div.menu_body3 a:hover{
                <?php echo $hover3; ?>;
            }

            p.menu_head3{
                text-align: left;
                font-size:14px;
                padding: 5px 10px;
                color:#7E47CC;
                cursor: pointer;
                margin:1px;
                <?php echo $fondo3; ?>;
                text-decoration:none;
                border-radius: 7px;
            }
            p.menu_head3:hover{
                <?php echo $hover3; ?>;
            }
            div.menu_body4 {
                display:none;
            }
            div.menu_body4 a{
                text-align: left;
                font-size:14px;
                display:block;
                color:#A818B2;
                <?php echo $fondo4; ?>;
                margin:1px;
                padding: 5px 10px;
                text-decoration:none;
                border-radius: 7px;
            }
            div.menu_body4 a:hover{
                <?php echo $hover4; ?>;
            }

            .icono{
                width: 25px;
                height: 25px;
                border:none;
            }
            
            .btn_general{
                text-align: left;
                font-size:16px;
                padding: 5px 10px;
                color: #3067D2;
                cursor: pointer;
                margin:1px;
                <?php echo $fondo1; ?>;
                text-decoration:none;
                border-radius: 7px;
            }
        </style>
        <script src='../js/jQuery/js/jquery.min.js' type='text/javascript'></script>
        <script type='text/javascript'>
//            function menuOver(menuTexto){
//                $(menuTexto).mouseover(function(){$(menuTexto).css("backgroundColor","#99C8E6");});
//            }
//            
//            function menuOut(menuTexto,color){
//                $(menuTexto).mouseout(function(){$(menuTexto).css("backgroundColor",color);});
//            }
            
            $(document).ready(function()
            {
                $("p.menu_head1").click(function()
                {
                    $(this).next("div.menu_body2").slideToggle(300).siblings("div.menu_body2").slideUp("slow");
                });
                $("p.menu_head2").click(function()
                {
                    $(this).next("div.menu_body3").slideToggle(300).siblings("div.menu_body3").slideUp("slow");
                });
                $("p.menu_head3").click(function()
                {
                    $(this).next("div.menu_body4").slideToggle(300).siblings("div.menu_body4").slideUp("slow");
                });
            });
        </script>

    </head>
    <body bgcolor="#ffffff" onLoad="rotulo_status();nueva('../qualidad/doc-Qualidad/polcal.pdf','polcal', 0);">
        <div align="center">
        <form name="form1">
            <table width="774" height="550" border="0">
                <tr height="148"> 
                    <td colspan="5" align="middle" valign="top" nowrap> <p> 
                        <table id="prueba" border="0" width="701" height="148">
                            <tr> 
                                <td width="954" height="100" align="middle" valign="top" nowrap>
                                    <a href="../<?php echo $_SESSION['navegacion'];?>/default2.php">
                                        <p><img height="100" src="../images/cabecera.jpg" width="954" id="cabecera" border="0"></p>
                                    </a>
                                </td>
                            </tr>
                        </table>

                        </p>
                    </td>
                </tr>
                <tr> 
                    <td width="350" height="93" valign="top">
                        <!--                        MENU-->
                        <?php require_once '../vista/default2_menu.php';?>
                        <!--                        MENU   FIN-->
                    </td>
                    <td valign="top">
                        <table border="0" width="600" border="0"> 
                            <tr>
                                <td width="300" height="70" bordercolor="#FFFFFF">
                                    <p>
                                    <div align="center">
                                        <img height=67 alt="Qualidad Consulting de Sistemas S.L." src="../images/<?php echo $_SESSION['logo']; ?>" width=132 border="0"> 
                                        <p><?php echo $_SESSION['sesion']; ?></p>
                                    </div>    
                                    </p>
                                </td>           
                                <td width="80" bordercolor="#FFFFFF">
                                    <div align="center"> 
                                        <p><a href="../index.php"><img src="../images/Salir_juan.png" align="right" border="0" alt="Cerrar Sesión Usuario"></a></p>
                                    </div>
                                </td>
                                <td width="140" bordercolor="#FFFFFF">
                                    <div align="center">
                                        <a onClick="javascript:window.open('http://www.qualidad.com/qualidad/ayuda/ayuda.htm')">
                                            <img src="../images/ayuda_juan.gif" alt="Ayuda en Línea" width="52" height="56" border="0">
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <?php
                                if(substr($_SESSION['cargo'],0,6)==='Asesor'){
                                ?>
                                <td colspan="3">
                                    <hr/>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>
                                    <script>
                                        function OnOffCambioMenu(){
                                            window.location.href='../<?php echo $_SESSION['navegacion'];?>/defaultAsesor.php';
                                        }
                                    </script>
                                    <div onclick="OnOffCambioMenu();" style="cursor: pointer; width: 150px;" align="center">
                                        <br/>
                                        <font class="btn_general">Acceso Asesor</font>
                                    </div>
                                    <br/>
                                </td>
                                <?php }?>
                            </tr>
                            <tr>
                                <td colspan="3"><hr/></td>
                            </tr>
                            <tr> 
                                <td valign="top" colspan="2" height="260" bordercolor="#FFFFFF" align="left">
                                    <p style="font-size:0.9em;"><font style="color: #0000cc; font-weight: bold;">Qualidad</font> Aplicación informática para la gestión integral de su empresa. </p>
                                    <p style="font-size:0.9em;">Desde su ordenador, tablet o smartphone puede crear y enviar ofertas, presupuestos, facturas, consultar cobros y pagos pendientes, contabilizar sus gastos e ingresos, tramitar sus impuestos , gestionar altas y bajas de trabajadores o enviar consultas a su asesor.</p>

                                    <p style="font-size:0.9em;"><font style="font-size: 12px;">© Qualidad Consulting de Sistemas S.L.</font></p>
                                    <p style="font-size:0.9em;" align="left"> </p>
                                </td>
                                <td valign="top">
                                    <script>
                                        function verEventos(){
                                            $('.cajaEventos').toggle(1000);
                                        }
                                        function irEvento(num){
                                            window.location="../vista/consulta_asesor.php?IdPregunta="+num;
                                        }
                                    </script>
                                    <div class="divComunicadoEventos" align="center">
                                        <br/>
                                        <p>Comunicaciones</p>
                                        <?php if(is_array($eventosPendientes)){ ?>
                                            <div class="divAvisoEventos">
                                                <?php echo '<p class="avisoEventos" onclick="verEventos();">Pendientes: <b>'.$numEventos .'</b></p>';?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <br/><br/>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <?php if(is_array($eventosPendientes)){ ?>
                        <div class="cajaEventos">
                        <p class="evento" style="text-align:center;">Avisos Pendientes</p>
                        <?php
                        for ($i=0;$i<count($eventosPendientes);$i++) {
                            if(isset($eventosPendientes[$i]['lngIdPregunta'])){
                                $num=$eventosPendientes[$i]['lngIdPregunta'];
                            }else if(isset($eventosPendientes[$i]['lngIdRespuesta'])){
                                //averiguo la pregunta de esta respuesta
                                $num=$clsCNDefault2->PreguntaSegunRespuesta($eventosPendientes[$i]['lngIdRespuesta']);
                                //$num=$eventosPendientes[$i]['lngIdRespuesta'];
                            }
                            echo '<div class="eventos" onclick="irEvento('.$num.');">';
                            echo '<p class="evento"><font color="0000ff">'.($i+1) . "- Enviado por " . $eventosPendientes[$i]['usuario'].'</font></p>';
                            //formateo bien la fecha
                            //puede venir asi (viene 2015-01-26)
                            //o puede venir bien (26/01/2015)
                            
                            
                            $fechaBuena = explode(' ',$eventosPendientes[$i]['Fecha']);
                            $fechaBuena = explode('-',$fechaBuena[0]);
                            $fechaBuena = $fechaBuena[2] . '/' . $fechaBuena[1] . '/' . $fechaBuena[0];
                            echo '<p class="evento"><font color="0000ff">'.$fechaBuena.'</font></p>';
                            if($eventosPendientes[$i]['strPregunta']){
                                echo '<p class="evento">'.$eventosPendientes[$i]['strPregunta'].'</p>';
                            }else if($eventosPendientes[$i]['strRespuesta']){
                                echo '<p class="evento">'.$eventosPendientes[$i]['strRespuesta'].'</p>';
                            }
                            echo '</div>';
                        }
                        ?>
                        </div>
                        <?php } ?>
                    </td>
                </tr>
            </table>
        </form>
        </div>    
    </body>
</html>
