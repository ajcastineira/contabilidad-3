<?php
session_start();
require_once '../CN/clsCNUsu.php';
require_once '../general/funcionesGenerales.php';

$clsCNUsu=new clsCNUsu();
$clsCNUsu->setStrBD($_SESSION['dbContabilidad']);

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

logger('info','altaempleado.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id(). " ||||Configuracion->Mis Usuario->Alta|| ");

?>
<!DOCTYPE html>
<html>
<head>
<TITLE>Empleado - ALTA</TITLE>

<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>

</head> 
    <body>
    <div data-role="page" id="altaempleado">
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
  //comprobacion del campo 'strApellidos'
  if (document.form1.strApellidos.value == ''){ 
    textoError=textoError+"Es necesario introducir los apellidos.\n";
    $('#strApellidos').parent().css('border-color','red');
    esValido=false;
  }
  //comprobacion del campo 'strCorreos'
  if (document.form1.strCorreos.value == ''){ 
    textoError=textoError+"Es necesario introducir un E-mail.\n";
    $('#strCorreos').parent().css('border-color','red');
    esValido=false;
  }else{
    //compruebo que el e-mail tenga un formato correcto 'admin@admin.com'  
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(document.form1.strCorreos.value) ){
        textoError=textoError+"El E-mail " + document.form1.strCorreos.value + " es incorrecto.\n";
        $('#strCorreos').parent().css('border-color','red');
        esValido=false;
    }
  }
  //comprobacion del campo 'strUsuario'
  if (document.form1.strUsuario.value == ''){ 
    textoError=textoError+"Es necesario introducir el nombre.\n";
    $('#strUsuario').parent().css('border-color','red');
    esValido=false;
  }
  //comprobacion del campo 'strPassword'
  if (document.form1.strPassword.value == ''){ 
    textoError=textoError+"Es necesario introducir la contraseña.\n";
    $('#strPassword').parent().css('border-color','red');
    esValido=false;
  }
  //comprobacion del campo 'strPassword2'
  if (document.form1.strPassword2.value == ''){ 
    textoError=textoError+"Es necesario introducir la repetición de la contraseña.\n";
    $('#strPassword2').parent().css('border-color','red');
    esValido=false;
  }
  //comprobacion del campo 'strPassword' y 'strPassword2' son iguales
  if ((document.form1.strPassword.value != '')&&(document.form1.strPassword2.value != '') &&
       (document.form1.strPassword.value != document.form1.strPassword2.value) ){ 
    textoError=textoError+"La contraseña debe coincidir en los campos contraseña y repetir contraseña.\n";
    $('#strPassword').parent().css('border-color','red');
    $('#strPassword2').parent().css('border-color','red');
    esValido=false;
  }

  //comprobacion de que el nombre de usuario no esta repetido
  texto=document.getElementById("txt_usuario").innerHTML;
  if (texto.indexOf('error') != -1){
    textoError=textoError+"El nombre de usuario ya existe.\n";
    $('#strUsuario').parent().css('border-color','red');
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

//AJAX jQuery chequea usuario exista en la BD
function check_usuario(str){
    $.ajax({
      data:{"q":str},  
      url: '../vista/ajax/buscar_usuario.php',
      type:"get",
      success: function(data) {
        $('#txt_usuario').html(data);
      }
    });
}

</script>

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>

    <div data-role="content" data-theme="a">
    <form name="form1" method="post" action="../vista/altaempleado.php" data-ajax="false">
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
                        <label><b>Datos del Usuario</b></label>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>Nombre</label>
                        <input type="text" name="strNombre" maxlength="30" id="strNombre"
                               onfocus="onFocusInputTextM(this);" />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>Apellidos</label>
                        <input type="text" name="strApellidos" maxlength="30" id="strApellidos"
                               onfocus="onFocusInputTextM(this);" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label>Teléfono</label>
                        <input type="text" name="lngTelefono" maxlength="12" id="lngTelefono"
                               onfocus="onFocusInputTextM(this);" onblur="solonumerosM(this);" />
                    </td>
                    <td colspan="2">
                        <label>Movil</label>
                        <input type="text" name="lngMovil" maxlength="20" id="lngMovil"
                               onfocus="onFocusInputTextM(this);" onblur="solonumerosM(this);" />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>E-mail</label>
                        <input type="text" name="strCorreos" maxlength="50" id="strCorreos"
                               onfocus="onFocusInputTextM(this);" />
                    </td>
                </tr>
                <tr>
                    <td height="15px"></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label><b>Datos se Sesión del Usuario</b></label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <label>Nombre de Usuario</label>
                        <input type="text" name="strUsuario" id="strUsuario" maxlength="30" 
                               onKeyUp="check_usuario(this.value);" 
                               onfocus="onFocusInputTextM(this);" onblur="check_usuario(this.value);" />
                    </td>
                    <td><br/>
                        <span valign="top" id="txt_usuario"></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <label>Contraseña</label><br/>
                        <label><i>NOTA: El nombre y la contraseña serán de 10 caracteres como máximo</i></label>
                        <input type="password" name="strPassword" id="strPassword" maxlength="10" onfocus="onFocusInputTextM(this);" />
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <label>Repetir Contraseña</label><br/>
                        <input type="password" name="strPassword2" id="strPassword2" maxlength="10" onfocus="onFocusInputTextM(this);" />
                    </td>
                </tr>
            </tbody>
        </table>    
        <input type="button" data-theme="a" data-icon="check" name="cmdAlta" id="cmdAlta" value = "Proceder al Alta" onclick="javascript:validar();" /> 
        <input type="hidden"  name="cmdAlta" value="Aceptar" />
        <input type="hidden"  name="idEmpresa" value="<?php if(isset($_GET['idEmp'])){echo $_GET['idEmp'];}?>" />
        
    </form>
    </div>

    </div>    
    </body>
</html>
