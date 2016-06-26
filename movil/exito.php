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


//borro vbles de session
unset($_SESSION['ingresos_CFIVA1SIRPFVC']);
    

?>
<!DOCTYPE html>
<html>
<head>
<TITLE>CALIDAD -OPERACI&Oacute;N REALIZADA CON &Eacute;XITO</TITLE>

<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>

        
</head>
<body>
           
<div data-role="page" id="exito">
<?php
eventosInputText();
?>

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>

    <div data-role="content" data-theme="a">
        <p><strong>La informaci&oacute;n se ha actualizado correctamente en su Base de Datos</strong>
        </p>
<?php
if(isset($_GET['Id'])){echo trim($_GET['Id']);}
?>        
        <div align="center">
            <a href="<?php echo '../movil/default2.php';?>" data-ajax="false">
                <IMG height=70 alt="Ir al menú" src="../images/<?php echo $_SESSION["logo"]; ?>" width=140 border="0">
            </a>
        </div>
    </div>
</div>
</body>
</html>
