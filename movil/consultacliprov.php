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

if($_GET['tipo']=='cliente'){
    logger('info','consultacliprov.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
           " ||||Configuracion->Mis Clientes->Consulta/Modificacion||");
}else{
    logger('info','consultacliprov.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
           " ||||Configuracion->Mis Proveedores->Consulta/Modificacion||");
}
//cargar los datos del cliente/proveedor
$datosCliProv=$clsCNUsu->DatosCliProv($_GET['IdRelacionCliProv']);

?>
<!DOCTYPE html>
<html>
<head>
<TITLE><?php if($_GET['tipo']=='cliente'){echo 'Consulta Cliente';}else{echo 'Consulta Proveedor';}?></TITLE>

<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>

</head> 
    <body>
    <div data-role="page" id="consultacliprov">
<?php
eventosInputText();
?>
<script language="JavaScript">
function validar2()
{
  esValido=true;
  textoError='';
  
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
  //comprobacion del campo 'lngCP'
  if (document.form1.lngCP.value == ''){ 
    textoError=textoError+"Es necesario introducir el código postal.\n";
    $('#lngCP').parent().css('border-color','red');
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
function borrarCliProv(id){
    if (confirm("¿Desea borrar el registro del usuario de la base de datos?"))
    {
        window.location='../vista/cliprovBorrar.php?id='+id;
    }
}

function avisoCliProv(){
    alert('Esta cuenta tiene datos asociados en la Base de Datos. NO se puede borrar.');
}

</script>

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>

    <div data-role="content" data-theme="a">
    <form name="form1" method="post" action="../vista/consultacliprov.php" data-ajax="false">
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
                        <label><b>Datos del <?php echo $_GET['tipo'];?></b></label>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>Nombre</label>
                        <input type="text" name="strNombre" maxlength="50" id="strNombre" onfocus="onFocusInputTextM(this);"
                               value="<?php if(isset($datosCliProv)){echo $datosCliProv['nombre'];} ?>" />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>CIF</label>
                        <?php
                        $tipoCliente=explode('-',$_GET['IdRelacionCliProv']);
                        ?>
                        <input type="text" name="strCIF" maxlength="50" id="strCIF"
                               <?php if($tipoCliente[0]==='CliProv'){echo 'readonly';} ?>
                               value="<?php if(isset($datosCliProv)){echo $datosCliProv['CIF'];} ?>" />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>Actividad</label>
                        <input type="text" name="strActividad" maxlength="50" id="strActividad"
                               value="<?php if(isset($datosCliProv)){echo $datosCliProv['actividad'];} ?>" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label>CP</label>
                        <input type="text" name="lngCP" maxlength="5" id="lngCP"
                               onfocus="onFocusInputTextM(this);" onblur="solonumerosM(this);"
                               value="<?php if(isset($datosCliProv)){echo $datosCliProv['CP'];} ?>" />
                    </td>
                    <td colspan="2">
                        <label>Fax</label>
                        <input type="text" name="lngFax" maxlength="11" id="lngFax"
                               onfocus="onFocusInputTextM(this);" onblur="solonumerosM(this);"
                               value="<?php if(isset($datosCliProv)){echo $datosCliProv['Fax'];} ?>" />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>Dirección</label>
                        <input type="text" name="strDireccion" maxlength="50" id="strDireccion"
                               onfocus="onFocusInputTextM(this);"
                               value="<?php if(isset($datosCliProv)){echo $datosCliProv['direccion'];} ?>" />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>Municipio</label>
                        <input type="text" name="strMunicipio" maxlength="50" id="strMunicipio"
                               onfocus="onFocusInputTextM(this);"
                               value="<?php if(isset($datosCliProv)){echo $datosCliProv['municipio'];} ?>" />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>Provincia</label>
                        <input type="text" name="strProvincia" maxlength="50" id="strProvincia"
                               onfocus="onFocusInputTextM(this);"
                               value="<?php if(isset($datosCliProv)){echo $datosCliProv['provincia'];} ?>" />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>E-mail</label>
                        <input type="text" name="strEmail" maxlength="50" id="strEmail"
                               onfocus="onFocusInputTextM(this);"
                               value="<?php if(isset($datosCliProv)){echo $datosCliProv['Correo'];} ?>" />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>E-mail 2</label>
                        <input type="text" name="strEmail2" maxlength="50" id="strEmail2"
                               onfocus="onFocusInputTextM(this);"
                               value="<?php if(isset($datosCliProv)){echo $datosCliProv['Correo2'];} ?>" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label>Telefono 1</label>
                        <input type="text" name="lngTelefono1" maxlength="11" id="lngTelefono1"
                               onfocus="onFocusInputTextM(this);" onblur="solonumerosM(this);"
                               value="<?php if(isset($datosCliProv)){echo $datosCliProv['Telefono1'];} ?>" />
                    </td>
                    <td colspan="2">
                        <label>Telefono 2</label>
                        <input type="text" name="lngTelefono2" maxlength="11" id="lngTelefono2"
                               onfocus="onFocusInputTextM(this);" onblur="solonumerosM(this);"
                               value="<?php if(isset($datosCliProv)){echo $datosCliProv['Telefono2'];} ?>" />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>CC. Recibos</label>
                        <input type="text" name="strCCRecibos" maxlength="30" id="strCCRecibos"
                               onfocus="onFocusInputTextM(this);"
                               value="<?php if(isset($datosCliProv)){echo $datosCliProv['strCCRecibos'];} ?>" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="button" id="cmdAlta" data-theme="a" data-icon="check" value = "Grabar" onclick="javascript:validar2();" />
                    </td>
                    <td colspan="2">
                        <?php $id=explode('-',$_GET['IdRelacionCliProv']); ?>
                        <?php if($datosCliProv['TieneAsientos']==='NO' && $datosCliProv['TienePresupuestos']==='NO' && $datosCliProv['TieneFacturas']==='NO'){?>
                        <input type="button" data-theme="a" data-icon="delete" value="Eliminar" name="cmdBorrar" onclick="javascript:borrarCliProv(<?php echo $id[1]; ?>);" />
                        <?php }else{?>
                        <input type="button" data-theme="a" data-icon="delete" value="Eliminar" name="cmdBorrar" onclick="javascript:avisoCliProv();" />
                        <?php }?>
                    </td>
                </tr>
            </tbody>
        </table>    
        <input type="hidden"  name="cmdAlta" value="Aceptar" />
        <input name="tipo" type="hidden" value="<?php echo $_GET['tipo'];?>"/>
        <input name="IdRelacionCliProv" type="hidden" value="<?php echo $_GET['IdRelacionCliProv'];?>"/>
        
    </form>
    </div>

    </div>    
    </body>
</html>
