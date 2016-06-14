<?php
session_start();
require_once '../CN/clsCNUsu.php';
require_once '../general/funcionesGenerales.php';

$clsCNUsu=new clsCNUsu();
$clsCNUsu->setStrBD($_SESSION['dbContabilidad']);
$clsCNUsu->setStrBDCliente($_SESSION['mapeo']);

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

if($_GET['tipo']=='cliente'){
    logger('info','altaClientes.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
           " ||||Configuracion->Mis Clientes->Alta||");
}else{
    logger('info','altaClientes.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
           " ||||Configuracion->Mis Proveedores->Alta||");
}

?>
<!DOCTYPE html>
<html>
<head>
<TITLE><?php if($_GET['tipo']=='cliente'){echo 'Cliente - ALTA';}else{echo 'Proveedor - ALTA';}?></TITLE>

<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>

</head> 
    <body>
    <div data-role="page" id="altacuentas">
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
    textoError=textoError+"Es necesario introducir el nombre de la cuenta.\n";
    $('#strNombre').parent().css('border-color','red');
    esValido=false;
  }
  //comprobacion del campo 'lngCodigo'
  if (document.form1.lngCodigo.value == ''){ 
    textoError=textoError+"Es necesario introducir el código de la cuenta.\n";
    $('#lngCodigo').parent().css('border-color','red');
    esValido=false;
  }
  //comprobacion qeu no exista cuenta en la BBDD (en el txt_cuenta)
  texto=document.getElementById("txt_cuenta").innerHTML;
  if (texto.indexOf('error') != -1){
    textoError=textoError+"El numero de cuenta ya existe.\n";
    $('#lngCodigo').parent().css('border-color','red');
    esValido=false;
  }
  
  
  //indicar el mensaje de error si es 'esValido' false
  if (!esValido){
          alert(textoError);
  }

  if(esValido==true){
      document.getElementById("cmdAlta").value = "Enviando...";
      document.getElementById("cmdAlta").disabled = true;
      document.form1.submit();
  }else{
      return false;
  }  
}

</script>

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>

    <div data-role="content" data-theme="a">
    <form name="form1" method="post" action="../vista/altacuentas.php" data-ajax="false">
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
                        <label>Seleccione tipo de Cuenta</label>
                        <select name="lngTipo" onchange="check_cuenta(document.form1.lngCodigo.value,this.value);" 
                                data-native-menu="false" data-theme='a'>
                            <option value="5720">Bancos</option>
                            <option value="5510">Cuentas con Socios</option>
                            <option value="5020">Tarjetas de Crédito (Gastos)</option>
                            <option value="5750">Tarjetas TPV (Cobros a cliente)</option>
                            <option value="5201">Pólizas de Crédito</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <label>Número de Cuenta</label>
                        <input type="text" name="lngCodigo" maxlength="5" id="lngCodigo" onKeyUp="check_cuentaEmpresa(this.value,document.form1.lngTipo.value);"
                               onfocus="onFocusInputTextM(this);" onblur="solonumerosM(this);" />
                    </td>
                    <td>
                        <br/>
                        <span valign="center" id="txt_cuenta"></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>Nombre de la Cuenta</label>
                        <input type="text" name="strNombre" maxlength="255" id="strNombre"
                               onfocus="onFocusInputTextM(this);" />
                    </td>
                </tr>
            </tbody>
        </table>    
        <input type="button" data-theme="a" data-icon="check" name="cmdAlta" id="cmdAlta" value = "Proceder al Alta" onclick="javascript:validar();" /> 
        <input type="hidden"  name="cmdAlta" value="Aceptar" />
        
    </form>
    </div>

    </div>    
    </body>
</html>
