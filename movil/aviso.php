<?php
session_start ();
require_once '../general/funcionesGenerales.php';


//Control de Sesion
ControlaLoginTimeOut();

//Control de Permisos. Hay que incluirlo en todas las páginas
/**************************************************************/
$strPagina=dameURL();
$strCargo = trim($_SESSION['cargo']);   //Esto es el puesto al que le hacemos un trim

$lngPermiso = AccesoUsuarioPagina ($strPagina, $strCargo);  // Le pasamos la página y el cargo. 

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

    
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<TITLE>CALIDAD - NO TIENE PERMISOS PARA ESTA PÁGINA</TITLE>

<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>

        
</head>
<body>
           
<div data-role="page" id="aviso">
<?php
eventosInputText();
?>
<script language="JavaScript">
function volver(){
    javascript:history.back();
}    
</script>

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>

    <div data-role="content" data-theme="a">
        <p><strong><font color="#FF0000">¡¡NO TIENE PERMISOS PARA ESTA PÁGINA!!</font></strong></p>
        <p><strong>Disculpe las molestias</strong></p>
        <div align="center">
            <a href="<?php echo '../movil/default2.php';?>" data-ajax="false">
                <IMG height=67 alt="Ir al menú" src="../images/<?php echo $_SESSION["logo"]; ?>" width=132 border="0">
            </a>
        </div>
    </div>
</div>
</body>
</html>
