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

logger('info','gastos_entrada.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
       " ||||Operaciones->Compras y Gastos||(Menu eleccion)");

?>
<!DOCTYPE html>
<html>
<head>
<TITLE>Alta de Gastos - Opciones</TITLE>

<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>

        
</head>
<body>
           
<div data-role="page" id="gastos_entrada">
<?php
eventosInputText();
?>
<script language="JavaScript">

function ActivaForm(objeto){
    if(objeto.value==='ConFactura'){
        document.getElementById('formOpciones').style.display='block';
    }else{
        document.getElementById('formOpciones').style.display='none';
        alert("Salvo excepciones, la entrega de productos y servicios debe realizarse mediante la correspondiente factura. Mediante esta opción podrá contabilizar gastos no sujetos a la obligación de expedir factura (ej.: impuestos, seguros, etc.). ");
    }
}

</script>        

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>

    <div data-role="content" data-theme="a">
        <form action="../vista/gastos_entrada.php" name="form1" method="POST" data-ajax="false">
            <table border="0" style="width: 100%;">
                <tr>
                    <td>
                    <label>Tipo de Asiento</label>
                    </td>
                </tr>
                <tr>
                    <td>
                    <div class="ui-field-contain">
                        <fieldset data-role="controlgroup" data-mini="true">
                            <input type="radio" name="optTipoAsiento" id="optTipoAsientoGen" class="custom" value="General" checked="checked"
                                   data-theme="a" data-iconpos="right">
                            <label for="optTipoAsientoGen">Asiento General</label>
                            <input type="radio" name="optTipoAsiento" id="optTipoAsientoNom" class="custom" value="Nomina"
                                   data-theme="a" data-iconpos="right">
                            <label for="optTipoAsientoNom">Nómina</label>
                        </fieldset>
                    </div>
                    </td>
                </tr>
            </table>
                
            <table border="0" style="width: 100%;">
                <tr>
                    <td style="width: 22%;"></td>
                    <td style="width: 23%;"></td>
                    <td style="width: 23%;"></td>
                    <td style="width: 22%;"></td>
                </tr>
                <tr>
                    <td height="15px"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2">
                    <div align="center">
                        <input type="submit" data-theme="a" data-icon="forward" data-iconpos="right" value = "Continuar" /> 
                    </div>
                    </td>
                </tr>
            </table>
        </form>
        
    </div>
</div>
</body>
</html>
