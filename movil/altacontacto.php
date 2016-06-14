<?php
session_start();
require_once '../CN/clsCNContabilidad.php';
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

$clsCNContabilidad=new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['dbContabilidad']);


if(isset($_GET['IdContacto'])){
    logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
           " ||||Configuracion->Mis Contactos->Editar||");

    $datosContacto=$clsCNContabilidad->DatosContacto($_GET['IdContacto']);
    //print_r($datosContacto);die;
}else{
    logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
           " ||||Configuracion->Mis Contactos->Alta||");
}

//averiguamos si el contacto es igual al nombre de empresa(contactoNombre+contactoApellidos = nombreEmpresa
$nombreEmpresa=$datosContacto['NombreEmpresa'];
$contacto=$datosContacto['NombreContacto'].' '.$datosContacto['ApellidosContacto'];
        
$contactoSiEmpresa='No';
if($nombreEmpresa==$contacto){        
    $contactoSiEmpresa='Si';
}

?>
<!DOCTYPE html>
<html>
<head>
<TITLE><?php if(isset($_GET['IdContacto'])){echo 'Contacto - EDITAR';}else{echo 'Contacto - ALTA';}?></TITLE>

<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>

</head> 
    <body>
    <div data-role="page" id="altacontacto">
<?php
eventosInputText();
?>
<script language="JavaScript">
function validarP1(){
  esValido=true;
  textoError='';

  //comprobacion del campo 'strNombre'
  if (document.form1.strNombre.value == ''){ 
    textoError=textoError+"Es necesario introducir el nombre del contacto.\n";
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


  //indicar el mensaje de error si es 'esValido' false
  if (!esValido){
          alert(textoError);
  }

  if(esValido==true){
      $('#pantalla1').slideUp(1000);
      $('#pantalla2').slideDown(1000);
  }else{
      return false;
  }  
}

function validar2(){
    document.getElementById("cmdAlta2").value = "Enviando...";
    document.getElementById("cmdAlta2").disabled = true;
    document.form1.submit();
}





function pasarACliente(){
    document.form1.opcion.value='altaClienteDeContacto';
    document.getElementById("cmdAlta2").disabled = true;
    $('#cuenta').show(1000);
}

function pasarAClienteContactoOK(){
  esValido=true;
  textoError='';

  //comprobacion del campo 'strNombreEmpresa'
  if (document.form1.strNomEmpresa.value == ''){ 
    textoError=textoError+"Es necesario introducir el nombre de la Empresa.\n";
    document.form1.strNomEmpresa.style.borderColor='#FF0000';
    document.form1.strNomEmpresa.title ='Se debe introducir el nombre de la Empresa';
    esValido=false;
  }
  //comprobacion del campo 'strCIF'
  if (document.form1.strCIF.value == ''){ 
    textoError=textoError+"Es necesario introducir el CIF.\n";
    document.form1.strCIF.style.borderColor='#FF0000';
    document.form1.strCIF.title ='Se debe introducir el CIF';
    esValido=false;
  }
  //comprobacion del campo 'strEmail'
  if (document.form1.strEmail.value === ''){ 
  }else{
    //compruebo que el e-mail tenga un formato correcto 'admin@admin.com'  
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(document.form1.strEmail.value) ){
        textoError=textoError+"El E-mail " + document.form1.strEmail.value + " es incorrecto.\n";
        document.form1.strEmail.style.borderColor='#FF0000';
        document.form1.strEmail.title ='El E-mail es incorrecto';
        esValido=false;
    }
  }

  //indicar el mensaje de error si es 'esValido' false
  if (!esValido){
          alert(textoError);
  }

  if(esValido==true){
//      document.form1.opcion.value='altaClienteDeContactoImportado';
      document.getElementById("cmdPasarClienteOK").value = "Enviando...";
      document.getElementById("cmdPasarClienteOK").disabled = true;
      document.form1.submit();
  }else{
      return false;
  }  
}

function pasarAClienteOK(){
  esValido=true;
  textoError='';
  
  //comprobacion del campo 'strNombreEmpresa'
  if (document.form1.strNomEmpresa.value == ''){ 
    textoError=textoError+"Es necesario introducir el nombre de la Empresa.\n";
    document.form1.strNomEmpresa.style.borderColor='#FF0000';
    document.form1.strNomEmpresa.title ='Se debe introducir el nombre de la Empresa';
    esValido=false;
  }
  //comprobacion del campo 'strCIF'
  if (document.form1.strCIF.value == ''){ 
    textoError=textoError+"Es necesario introducir el CIF.\n";
    document.form1.strCIF.style.borderColor='#FF0000';
    document.form1.strCIF.title ='Se debe introducir el CIF';
    esValido=false;
  }
  //comprobacion del campo 'strEmail'
  if (document.form1.strEmail.value === ''){ 
  }else{
    //compruebo que el e-mail tenga un formato correcto 'admin@admin.com'  
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(document.form1.strEmail.value) ){
        textoError=textoError+"El E-mail " + document.form1.strEmail.value + " es incorrecto.\n";
        document.form1.strEmail.style.borderColor='#FF0000';
        document.form1.strEmail.title ='El E-mail es incorrecto';
        esValido=false;
    }
  }
  //comprobacion del campo 'lngCodigo'
  if (document.form1.lngCodigo.value == ''){ 
    textoError=textoError+"Es necesario introducir un codigo de la cuenta.\n";
    document.form1.lngCodigo.style.borderColor='#FF0000';
    document.form1.lngCodigo.title ='Se debe introducir un codigo de la cuenta';
    esValido=false;
  }
  //comprobacion qeu no exista cuenta en la BBDD (en el txt_cuenta)
  texto=document.getElementById("txt_cuenta").innerHTML;
  if (texto.indexOf('error') != -1){
    textoError=textoError+"El numero de cuenta ya existe.\n";
    document.form1.lngCodigo.style.borderColor='#FF0000';
    esValido=false;
  }
  
  //indicar el mensaje de error si es 'esValido' false
  if (!esValido){
          alert(textoError);
  }

  if(esValido==true){
//      document.form1.opcion.value='altaClienteDeContacto';
      document.getElementById("cmdPasarClienteOK").value = "Enviando...";
      document.getElementById("cmdPasarClienteOK").disabled = true;
      document.form1.submit();
  }else{
      return false;
  }  
}

//borrar contacto/cliente cde tbmiscontactos
function borrarContacto(id){
    if (confirm("¿Desea borrar el registro del contacto de la base de datos?"))
    {
        window.location='../vista/contactoBorrar.php?id='+id;
    }
}

function avisoContacto(){
    alert('Este contacto no se puede borrar. Tiene datos asociados en la Base de Datos');
}

//limpia el texto de verificacion de NIF/CIF
function limpiarTxtValidar(){
    document.getElementById('txt_validar').innerHTML='';
}

//si el select tiene elvalor de 'Si' rellenamos el campo 'strNomEmpresa' con los datos 
//de 'strNombre' + 'strApellidos'
function comprobarContactoSiEmpresa(){
    if(document.form1.contactoSiEmpresa.value==='Si'){
        document.form1.strNomEmpresa.value=document.form1.strNombre.value + ' ' + document.form1.strApellidos.value;
    }
}

function leer(){
    //extraig la url de la que venimos
    var url=document.referrer;
    //parto este texto por el simbolo '/'
    var partes=url.split("/");
    //guardo el ultimo valor (esla pagina mas si tiene parametros)
    var ultimo=partes[partes.length-1];
    var response='';
    if(ultimo.indexOf('?') != -1){
        //dividimos el texto por ste simbolo ?
        var partesUltimo=ultimo.split("?");
        if(partesUltimo[0]==='altapresupuesto.php'){
            response='PresupuestoEditado?'+partesUltimo[1];
        }else if(partesUltimo[0]==='default2.php'){
            response='Principal';
        }
    }else{
        if(ultimo==='altapresupuesto.php'){
            response='PresupuestoNuevo';
        }else if(ultimo==='default2.php'){
            response='Principal';
        }
    }

    //ahora vemos que fichero es y le asignamos un valor a 'document.form1.url_inicial.value'
    document.form1.url_inicial.value=response;
}

</script>

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>

    <div data-role="content" data-theme="a">
    <form name="form1" method="post" action="../vista/altacontacto.php"  data-ajax="false">
        <div id="pantalla1">
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
                            <label><b>Contacto</b></label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <label for="strNombre">Nombre</label>
                            <input type="text" name="strNombre" maxlength="30" id="strNombre" onfocus="onFocusInputTextM(this);"
                                   value="<?php if(isset($datosContacto)){echo $datosContacto['NombreContacto'];} ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <label>Apellidos</label>
                            <input type="text" name="strApellidos" maxlength="50" id="strApellidos"
                                   value="<?php if(isset($datosContacto)){echo $datosContacto['ApellidosContacto'];} ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label>Teléfono</label>
                            <input type="text" name="strTelefono" id="strTelefono" maxlength="15" 
                                   onfocus="onFocusInputTextM(this);" onblur="solonumerosM(this);"
                                   value="<?php if(isset($datosContacto)){echo $datosContacto['Telefono'];} ?>" />
                        </td>
                        <td colspan="2">
                            <label>Teléfono Móvil</label>
                            <input type="text" name="strMovil" id="strMovil" maxlength="15"
                                   onfocus="onFocusInputTextM(this);" onblur="solonumerosM(this);"
                                   value="<?php if(isset($datosContacto)){echo $datosContacto['TelefonoMovil'];} ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <label>Correo Electrónico</label>
                            <input type="text" name="strEmail" maxlength="100" id="strEmail" onfocus="onFocusInputTextM(this);" 
                                   value="<?php if(isset($datosContacto)){echo $datosContacto['Correo'];} ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <label>Notas</label>
                            <textarea name="strNotas" rows=4 cols="20"><?php if(isset($datosContacto['Notas'])){echo $datosContacto['Notas'];}?></textarea>
                        </td>
                    </tr>
                        <tr>
                            <td colspan="4">
                                <label>¿Nombre de empresa igual a contacto?</label>
                                <select name="contactoSiEmpresa" onChange="comprobarContactoSiEmpresa();" data-native-menu="false" data-theme='a'>
                                    <option value="No" <?php if($contactoSiEmpresa==='No'){echo 'selected';}?>>No</option>
                                    <option value="Si" <?php if($contactoSiEmpresa==='Si'){echo 'selected';}?>>Si</option>
                                </select>
                            </td>
                        </tr>
                </tbody>
            </table>    
            <input type="button" id="cmdAlta1" value = "Continuar" onclick="javascript:validarP1();" />
        </div>

        <div id="pantalla2" style="display:none;">
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
                            <label><b>Empresa</b></label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <label>Nombre</label>
                            <input type="text" name="strNomEmpresa" maxlength="150" id="strNomEmpresa" 
                                   value="<?php if(isset($datosContacto)){echo $datosContacto['NombreEmpresa'];} ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label>CIF</label>
                            <input type="text" name="strCIF" id="strCIF" maxlength="20"
                                   value="<?php if(isset($datosContacto)){echo $datosContacto['CIF'];} ?>" 
                                   onfocus="limpiarTxtValidar();" onblur="validarNIFCIF(this);" />
                        </td>
                        <td colspan="2">
                            <span class="validar" id="txt_validar"></span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <label>Dirección</label>
                            <input type="text" name="strDireccion" maxlength="255" id="strDireccion" 
                                   value="<?php if(isset($datosContacto)){echo $datosContacto['Direccion'];} ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <label>Municipio</label>
                            <input type="text" name="strMunicipio" maxlength="50" id="strMunicipio" 
                                   value="<?php if(isset($datosContacto)){echo $datosContacto['Ciudad'];} ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label>Código Postal</label>
                            <input type="text" name="lngCP" maxlength="5" id="lngCP" 
                                   onfocus="onFocusInputTextM(this);" onblur="solonumerosM(this);"
                                   value="<?php if(isset($datosContacto)){echo $datosContacto['CodPostal'];} ?>" />
                        </td>
                        <td colspan="2">
                            <label>Provincia</label>
                            <input type="text" name="strProvincia" maxlength="50" id="strProvincia" 
                                   value="<?php if(isset($datosContacto)){echo $datosContacto['Provincia'];} ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label>Forma Pago Hab.</label>
                            <select name="strFormaPago" data-native-menu="false" data-theme='a'>
                                <option value=""></option>
                                <option value="Contado" <?php if($datosContacto['FormaPagoHabitual']==='Contado'){echo 'selected';}?>>Contado</option>
                                <option value="Pagare" <?php if($datosContacto['FormaPagoHabitual']==='Pagare'){echo 'selected';}?>>Pagaré</option>
                                <option value="Recibo" <?php if($datosContacto['FormaPagoHabitual']==='Recibo'){echo 'selected';}?>>Recibo</option>
                                <option value="Talon" <?php if($datosContacto['FormaPagoHabitual']==='Talon'){echo 'selected';}?>>Talón</option>
                                <option value="Transferencia" <?php if($datosContacto['FormaPagoHabitual']==='Transferencia'){echo 'selected';}?>>Transferencia</option>
                            </select>
                        </td>
                        <td colspan="2">
                            <?php
                            //si es contacto nuevo no aparece este boton de pasar a Cliente, si se edita si aparece
                            if(isset($_GET['IdContacto'])){
                            ?>
                              <div align="left">
                                  <label>¿Es Cliente?</label>
                                <input type="text" 
                                <?php
                                //compruebo como viene $datosContacto['IdCliProv']
                                if(isset($datosContacto['IdCliProv']) && $datosContacto['IdCliProv']<>'0'){
                                    echo 'value="SI"';
                                }else{
                                    echo 'value="NO"';
                                }
                                ?>       
                                readonly />
                              </div>
                            <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td height="15px"></td>
                    </tr>
                    
                    
                    <tr>
                        <td colspan="2">
                            <input type="button" id="cmdAlta2" data-theme="a" data-icon="check" value = "<?php if(isset($_GET['IdContacto'])){echo 'Grabar';}else{echo 'Alta';} ?>" onclick="javascript:validar2();" />
                        </td>
                        <td colspan="2">
                            <?php
                            //si es contacto nuevo no aparece este boton de pasar a Cliente, si se edita si aparece
                            if(isset($_GET['IdContacto'])){
                                if($datosContacto['TienePresupuestos']==='NO'){
                                ?>
                                <input type="button" data-theme="a" data-icon="delete" value="Eliminar" name="cmdBorrar" onclick="javascript:borrarContacto(<?php echo $_GET['IdContacto']; ?>);" />
                                <?php }else{?>
                                <input type="button" data-theme="a" data-icon="delete" value="Eliminar" name="cmdBorrar" onclick="javascript:avisoContacto();" />
                                <?php }?>
                            <?php }?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <?php
                            //si es cliente no aparece el boton
                            if(!isset($datosContacto['IdCliProv']) || $datosContacto['IdCliProv']==='0'){
                                //si es contacto nuevo no aparece este boton de pasar a Cliente, si se edita si aparece
                                if(isset($_GET['IdContacto'])){
                            ?>
                            <input type="button" name="cmdPasarCliente" id="cmdPasarCliente" value = "Generar Cliente" 
                                    data-theme="a" data-icon="arrow-d" onclick="javascript:pasarACliente();" />

                            <div id="cuenta" style="display: none;">
                                <?php if(!isset($datosContacto['NumCuenta']) || $datosContacto['NumCuenta']===''){?>
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
                                            <label>Nº Cuenta</label>
                                        </td>
                                    </tr>
                                    <tr> 
                                      <td colspan="1">
                                          <input type="text" name="lngTipo" id="lngTipo" maxlength="4"
                                                 value="4300" readonly />
                                      </td>
                                      <td colspan="2"> 
                                          <label></label>
                                          <input type="text" name="lngCodigo" id="lngCodigo" maxlength="5" 
                                                 onKeyUp="check_cuenta(this.value,document.form1.lngTipo.value);"
                                                 onfocus="onFocusInputTextM(this);"
                                                 onblur="onBlurInputText(this);solonumerosM(this);" />
                                      </td>
                                      <td colspan="1">
                                          <table border="0">
                                              <tr>
                                                  <td height="5">&nbsp;</td>
                                              </tr>
                                              <tr>
                                                  <td height="20">
                                                     <span valign="top" id="txt_cuenta"><img src='../images/error.png' width='15' height='15' /></span>
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <td></td>
                                              </tr>
                                              <tr>
                                                  <td></td>
                                              </tr>
                                          </table>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td></td>
                                      <td colspan="2">
                                        <input type="button" name="cmdPasarClienteOK" id="cmdPasarClienteOK" value = "OK"
                                               data-theme="a" data-icon="check"
                                               onclick="javascript:pasarAClienteOK();" />
                                      </td>
                                      <td></td>
                                    </tr>
                                <tbody>
                                </table>
                                <?php }else{ ?>
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
                                            <label>Nº Cuenta</label>
                                        </td>
                                    </tr>
                                    <tr> 
                                      <td colspan="4">
                                          <label>Nº Cuenta</label>
                                          <input type="text" name="lngTipo" id="lngTipo" maxlength="4"
                                                 value="<?php echo $datosContacto['NumCuenta']; ?>" readonly />
                                      </td>
                                    </tr>
                                    <tr>
                                      <td></td>
                                      <td colspan="2">
                                        <input type="button" name="cmdPasarClienteOK" id="cmdPasarClienteOK" value = "OK" 
                                               onclick="javascript:pasarAClienteContactoOK();" />
                                      </td>
                                      <td></td>
                                    </tr>
                                </tbody>
                                </table>
                                <?php } ?>
                            </div>


                            <?php
                                }
                            }
                            ?>
                            <input type="hidden"  name="opcion" value="<?php if(isset($_GET['IdContacto'])){echo 'editarContacto';}else{echo 'altaContacto';} ?>" />
                            <input type="hidden"  name="IdContacto" value="<?php if(isset($_GET['IdContacto'])){echo $_GET['IdContacto'];} ?>" />

                            <input type="hidden" name="url_inicial" onload="leer();" />
                            
                        </td>
                    </tr>
                </tbody>
            </table>    
        </div>
        
        
    </form>
    </div>

    </div>    
    </body>
</html>
