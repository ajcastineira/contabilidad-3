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
<TITLE>CALIDAD -OPERACI&Oacute;N REALIZADA CON &Eacute;XITO</TITLE>

<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>

        
</head>
<body>
           
<div data-role="page" id="cliprov_exito">
<?php
eventosInputText();
?>
<script language="JavaScript">
function inicio(){
    window.location='../movil/default2.php';
}

function nuevoCliente(){
    tipo='<?php echo $_GET['tipo'];?>';
    if(tipo==='cliente'){
        window.location='../movil/altacliprov.php?tipo=cliente';
    }else if(tipo==='proveedor'){
        window.location='../movil/altacliprov.php?tipo=proveedor';
    }    
}



</script>

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>

    <div data-role="content" data-theme="a">
        <p><strong>La informaci&oacute;n se a actualizado correctamente en su Base de Datos</strong>
        </p>
        <?php
        if(isset($_GET['Id'])){echo trim($_GET['Id']);}
        ?>

        <table border="0" style="width: 100%;">
            <tbody>
                <tr>
                    <td style="width: 22%;"></td>
                    <td style="width: 23%;"></td>
                    <td style="width: 23%;"></td>
                    <td style="width: 22%;"></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <input type="button" data-theme="a" data-icon="check" name="eleccion" value="Inicio" 
                               onclick="inicio();" />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <input data-theme="a" data-icon="check" type="button" name="eleccion" 
                               value="Nuevo <?php echo $_GET['tipo'];?>" onclick="nuevoCliente();"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div align="center">
                            <a href="<?php echo '../movil/default2.php';?>" data-ajax="false">
                                <IMG height=70 alt="Ir al menú" src="../images/<?php echo $_SESSION["logo"]; ?>" width=140 border="0">
                            </a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table> 
    </div>
</div>
</body>
</html>
