<?php
session_start();
require_once '../CN/clsCNUsu.php';
require_once '../general/funcionesGenerales.php';

$clsCNUsu=new clsCNUsu();
$clsCNUsu->setStrBD($_SESSION['mapeo']);


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

logger('info','consultacuentas.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
       " ||||Configuracion->Mis Cuentas->Consulta/Modificación||");
//cargar los datos del cliente/proveedor
$datosCuenta=$clsCNUsu->DatosCuenta($_GET['IdCuenta']);


?>
<!DOCTYPE html>
<html>
<head>
<TITLE>Cuenta - Editar</TITLE>

<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>

</head> 
    <body>
    <div data-role="page" id="consultacuentas">
<?php
eventosInputText();
?>
<script language="JavaScript">
function validar()
{
  esValido=true;
  textoError='';
  //comprobacion del campo 'strNombre'
  if (document.form1.strNombre.value == ''){ 
    textoError=textoError+"Es necesario introducir el nombre.\n";
    $('#strNombre').parent().css('border-color','red');
    esValido=false;
  }
  
  
  //indicar el mensaje de error si es 'esValido' false
  if (!esValido){
          alert(textoError);
  }

  if(esValido==true){
      document.form1.submit();
  }else{
      return false;
  }  
}

//borrar cliente/proveedor
function borrarCuenta(id){
    if (confirm("¿Desea borrar el registro del usuario de la base de datos?"))
    {
        window.location='../vista/cuentaBorrar.php?id='+id;
    }
}

</script>

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>

    <div data-role="content" data-theme="a">
    <form name="form1" method="post" action="../vista/consultacuentas.php"  data-ajax="false">
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
                        <label><b>Datos de la Cuenta</b></label>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>Número</label>
                        <input type="text" name="lngNumCuenta" readonly
                               value="<?php if(isset($datosCuenta)){echo $datosCuenta['NumCuenta'];} ?>" />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>Nombre</label>
                        <input type="text" name="strNombre" maxlength="50" id="strApellidos" onfocus="onFocusInputTextM(this);"
                               value="<?php if(isset($datosCuenta)){echo $datosCuenta['Nombre'];} ?>" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="button" id="cmdAlta" data-theme="a" data-icon="check" value = "Grabar" onclick="javascript:validar();" />
                    </td>
                    <td colspan="2">
                        <input type="button" data-theme="a" data-icon="delete" value="Eliminar" name="cmdBorrar" onclick="javascript:borrarCuenta(<?php echo $_GET['IdCuenta']; ?>);" />
                    </td>
                </tr>
            </tbody>
        </table>    
        <input type="hidden"  name="cmdAlta" value="Aceptar" />
        <input name="IdCuenta" type="hidden" value="<?php echo $_GET['IdCuenta'];?>"/>
    </form>
    </div>

    </div>    
    </body>
</html>
