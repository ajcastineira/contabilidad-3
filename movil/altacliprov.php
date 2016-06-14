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
    <div data-role="page" id="altacliprov">
<?php
eventosInputText();
?>
<script language="JavaScript">
function validar2()
{
  esValido=true;
  textoError='';
  //comprobacion del campo 'strCIF'
  if (document.form1.strCIF.value == ''){ 
    textoError=textoError+"Es necesario introducir el CIF.\n";
    $('#strCIF').parent().css('border-color','red');
    esValido=false;
  }
  //comprobacion del campo 'strNombre'
  if (document.form1.strNombre.value == ''){ 
    textoError=textoError+"Es necesario introducir el nombre.\n";
    $('#strNombre').parent().css('border-color','red');
    esValido=false;
  }
  //comprobacion del campo 'strEmail'
  if (document.form1.strEmail.value === ''){ 
  }else{
    //compruebo que el e-mail tenga un formato correcto 'admin@admin.com'  
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(document.form1.strEmail.value) ){
        textoError=textoError+"El E-mail " + document.form1.strEmail.value + " es incorrecto.\n";
        $('#strEmail').parent().css('border-color','red');
        esValido=false;
    }
  }
  //comprobacion del campo 'strDireccion'
  if (document.form1.strDireccion.value == ''){ 
    textoError=textoError+"Es necesario introducir la direccion.\n";
    $('#strDireccion').parent().css('border-color','red');
    esValido=false;
  }
  //comprobacion del campo 'strMunicipio'
  if (document.form1.strMunicipio.value == ''){ 
    textoError=textoError+"Es necesario introducir el nombre del municipio.\n";
    $('#strMunicipio').parent().css('border-color','red');
    esValido=false;
  }
  //comprobacion del campo 'strProvincia'
  if (document.form1.strProvincia.value == ''){ 
    textoError=textoError+"Es necesario introducir la provincia.\n";
    $('#strProvincia').parent().css('border-color','red');
    esValido=false;
  }
  //comprobacion del campo 'lngCodigo'
  if (document.form1.lngCodigo.value == ''){ 
    textoError=textoError+"Es necesario introducir un codigo de la cuenta.\n";
    $('#lngCodigo').parent().css('border-color','red');
    esValido=false;
  }
  //comprobacion qeu no exista cuenta en la BBDD (en el txt_cuenta)
  texto=document.getElementById("txt_cuenta").innerHTML;
  if (texto.indexOf('error') != -1){
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

//AJAX jQuery verifica si existe el cliente
function verificar_CIF(str,tipo){
    document.getElementById('txt_validar').innerHTML='';
    $.ajax({
      data:{"q":str.value,"tipo":tipo},  
      url: '../vista/ajax/verificarCIF.php',
      type:"get",
      success: function(data) {
        var cliente = JSON.parse(data);
        $('#strNombre').val(cliente.Nombre);
        $('#strActividad').val(cliente.Actividad);
        $('#strDireccion').val(cliente.direccion);
        $('#strMunicipio').val(cliente.municipio);
        $('#strProvincia').val(cliente.provincia);
        $('#strEmail').val(cliente.Correo);
        $('#strEmail2').val(cliente.Correo2);
        $('#lngTelefono1').val(cliente.Telefono1);
        $('#lngTelefono2').val(cliente.Telefono2);
        $('#lngFax').val(cliente.Fax);
        $('#lngCP').val(cliente.CP);
        $('#strCCRecibos').val(cliente.strCCRecibos);
        //indicar si el cliente no existe
        if(cliente.IdCliProv != null){
            //el cliente existe
            document.form1.existeCliProv.value='SI';
            document.form1.num2.value=cliente.IdCliProv;
        }else{
            if(document.form1.strCIF.value==''){
                document.getElementById('txt_validar').innerHTML='El campo está vacio.';
                //document.form1.strCIF.focus();
            }else{
                //el cliente NO existe
                document.form1.existeCliProv.value='NO';
                document.getElementById('txt_validar').innerHTML=document.getElementById('txt_validar').innerHTML+'No existe cliente correspodientes a ese NIF/CIF.Debe darlo de alta rellenando todos los campos\n';
            }
        }
        if(cliente.ExisteCuenta==='SI'){
            alert('Este cliente/proveedor existe. No se puede dar de alta');
            document.getElementById("cmdAlta").disabled = true;
        }else{
            document.getElementById("cmdAlta").disabled = false;
        }
      }
    });
}

</script>

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>

    <div data-role="content" data-theme="a">
    <form name="form1" method="post" action="../vista/altacliprov.php?tipo=<?php echo $_GET['tipo'];?>" data-ajax="false">
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
                        <label><b>Validación de CIF/NIF</b></label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label>CIF</label>
                        <input type="text" name="strCIF" id="strCIF" maxlength="50" onfocus="onFocusInputTextM(this);"
                               onblur="verificar_CIF(this,'<?php if($_GET['tipo']=='cliente'){echo '4300';}else{echo '4000';}?>');
                                       validarNIFCIF(this);" />
                    </td>
                    <td colspan="2">
                        <span class="validar" id="txt_validar"></span>
                    </td>
                </tr>
                <tr>
                    <td height="15px"><span class="validar" id="txt_usuario"></span></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label><b>Datos del <?php echo $_GET['tipo'];?></b></label>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>Nombre</label>
                        <input type="text" name="strNombre" maxlength="50" id="strNombre"
                               onfocus="onFocusInputTextM(this);" />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>Actividad</label>
                        <input type="text" name="strActividad" maxlength="50" id="strActividad" />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>Dirección</label>
                        <input type="text" name="strDireccion" maxlength="50" id="strDireccion"
                               onfocus="onFocusInputTextM(this);" />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>Municipio</label>
                        <input type="text" name="strMunicipio" maxlength="50" id="strMunicipio"
                               onfocus="onFocusInputTextM(this);" />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>Provincia</label>
                        <input type="text" name="strProvincia" maxlength="50" id="strProvincia"
                               onfocus="onFocusInputTextM(this);" />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>E-mail</label>
                        <input type="text" name="strEmail" maxlength="50" id="strEmail"
                               onfocus="onFocusInputTextM(this);" />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>E-mail 2</label>
                        <input type="text" name="strEmail2" maxlength="50" id="strEmail2"
                               onfocus="onFocusInputTextM(this);" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label>Telefono 1</label>
                        <input type="text" name="lngTelefono1" maxlength="11" id="lngTelefono1"
                               onfocus="onFocusInputTextM(this);" onblur="solonumerosM(this);" />
                    </td>
                    <td colspan="2">
                        <label>Telefono 2</label>
                        <input type="text" name="lngTelefono2" maxlength="11" id="lngTelefono2"
                               onfocus="onFocusInputTextM(this);" onblur="solonumerosM(this);" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label>CP</label>
                        <input type="text" name="lngCP" maxlength="11" id="lngCP"
                               onfocus="onFocusInputTextM(this);" onblur="solonumerosM(this);" />
                    </td>
                    <td colspan="2">
                        <label>Fax</label>
                        <input type="text" name="lngFax" maxlength="11" id="lngFax"
                               onfocus="onFocusInputTextM(this);" onblur="solonumerosM(this);" />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>CC. Recibos</label>
                        <input type="text" name="strCCRecibos" maxlength="30" id="strCCRecibos"
                               onfocus="onFocusInputTextM(this);" />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>Nº Cuenta</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="text" name="lngTipo" maxlength="4" id="lngTipo"
                               value="<?php if($_GET['tipo']=='cliente'){echo '4300';}else{echo '4000';}?>" readonly />
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <input type="text" name="lngCodigo" maxlength="5" id="lngCodigo" onKeyUp="check_cuenta(this.value,document.form1.lngTipo.value);"
                               onfocus="onFocusInputTextM(this);" onblur="solonumerosM(this);" />
                    </td>
                    <td>
                        <span valign="top" id="txt_cuenta"><img src='../images/error.png' width='15' height='15' /></span>
                    </td>
                </tr>
            </tbody>
        </table>    
        <input type="button" data-theme="a" data-icon="check" name="cmdAlta" id="cmdAlta" value = "Proceder al Alta" onclick="javascript:validar2();" /> 
        <input type="hidden" name="cmdAlta" value="Aceptar" />
        <input type="hidden" name="existeCliProv" value="NO" />
        <input type="hidden" name="num2" value="" />
        
    </form>
    </div>

    </div>    
    </body>
</html>
