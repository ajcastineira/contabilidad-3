<?php
session_start ();
require_once '../CN/clsCNContabilidad.php';
require_once '../general/funcionesGenerales.php';

//Control de Sesion
ControlaLoginTimeOut();

//Control de Permisos. Hay que incluirlo en todas las páginas
/**************************************************************/
$strPagina = dameURL();
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

function listadoAsesores($lngAsesor){
    require_once '../CN/clsCNUsu.php';
    $clsCNUsu=new clsCNUsu();
    $clsCNUsu->setStrBD($_SESSION['dbContabilidad']);
    $listadoAsesores=$clsCNUsu->listadoAsesores();
    $strHTML='';
    for ($i=0;$i<count($listadoAsesores);$i++){
        if($lngAsesor==$i){
            $strHTML =$strHTML."<OPTION value='".$listadoAsesores[$i]['lngIdEmpleado']."' selected>".$listadoAsesores[$i]['Asesor']."</OPTION>";
        }else{
            $strHTML =$strHTML."<OPTION value='".$listadoAsesores[$i]['lngIdEmpleado']."'>".$listadoAsesores[$i]['Asesor']."</OPTION>";
        }
    }
    return $strHTML;
}


//generar el codigo HTML para el select del tipo de factura
//lee de la tabla tbContabilidad.tbtipofactura
function listadoTiposFactura($IdTipo){
    require_once '../CN/clsCNContabilidad.php';
    $clsCNContabilidad=new clsCNContabilidad();
    $clsCNContabilidad->setStrBD($_SESSION['dbContabilidad']);

    $listado = $clsCNContabilidad->listadoTiposFactura();
    $strHTML='';
    for ($i=0;$i<count($listado);$i++){
        if($listado[$i]['IdTipo'] === $IdTipo){
            $strHTML =$strHTML."<OPTION value='".$listado[$i]['IdTipo']."' selected>".$listado[$i]['Nombre']."</OPTION>";
        }else{
            $strHTML =$strHTML."<OPTION value='".$listado[$i]['IdTipo']."'>".$listado[$i]['Nombre']."</OPTION>";
        }
    }
    return $strHTML;
}


logger('info',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
       " ||||Configuracion->Mi Empresa||");

$datosEmpresa=$clsCNContabilidad->DatosEmpresa($_SESSION['idEmp']);

//datos de la empresa guardados en la tabla tbempresas
$datosEmpresa_tbempresas=$clsCNContabilidad->DatosEmpresa_tbempresas($_SESSION['idEmp']);
    
?>
<!DOCTYPE html>
<html>
<head>
<TITLE>Configuración Mi Empresa</TITLE>

<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>

        
</head>
<body>
           
<div data-role="page" id="configuracion_empresa">
<?php
eventosInputText();
?>
<script language="JavaScript">

function validarP1(){
  esValido=true;
  textoError='';
  
  //comprobacion del campo 'strSesion'
  if (document.form1.strSesion.value == ''){ 
    textoError=textoError+"Es necesario introducir el nombre de la empresa.\n";
    document.form1.strSesion.style.borderColor='#FF0000';
    document.form1.strSesion.title ='Es necesario introducir el nombre de la empresa';
    esValido=false;
  }
  //comprobacion del campo 'strDireccion'
  if (document.form1.strDireccion.value == ''){ 
    textoError=textoError+"Es necesario introducir la dirección de la empresa.\n";
    document.form1.strDireccion.style.borderColor='#FF0000';
    document.form1.strDireccion.title ='Es necesario introducir la dirección de la empresa';
    esValido=false;
  }
  //comprobacion del campo 'strMunicipio'
  if (document.form1.strMunicipio.value == ''){ 
    textoError=textoError+"Es necesario introducir el municipio de la empresa.\n";
    document.form1.strMunicipio.style.borderColor='#FF0000';
    document.form1.strMunicipio.title ='Es necesario introducir el municipio de la empresa';
    esValido=false;
  }
  //comprobacion del campo 'provincia'
  if (document.form1.provincia.value == ''){ 
    textoError=textoError+"Es necesario introducir la provincia de la empresa.\n";
    document.form1.provincia.style.borderColor='#FF0000';
    document.form1.provincia.title ='Es necesario introducir la provincia de la empresa';
    esValido=false;
  }
  //comprobacion del campo 'lngCP'
  if (document.form1.lngCP.value == ''){ 
    textoError=textoError+"Es necesario introducir el código postal de la empresa.\n";
    document.form1.lngCP.style.borderColor='#FF0000';
    document.form1.lngCP.title ='Es necesario introducir el código postal de la empresa';
    esValido=false;
  }
  //comprobacion del campo 'lngTelefono'
  if (document.form1.lngTelefono.value == ''){ 
    textoError=textoError+"Es necesario introducir el teléfono de la empresa.\n";
    document.form1.lngTelefono.style.borderColor='#FF0000';
    document.form1.lngTelefono.title ='Es necesario introducir el teléfono de la empresa';
    esValido=false;
  }
  //comprobacion del campo 'strEmail1'
  if (document.form1.strEmail1.value == ''){ 
    textoError=textoError+"Es necesario introducir el e-mail 1 de la empresa.\n";
    document.form1.strEmail1.style.borderColor='#FF0000';
    document.form1.strEmail1.title ='Es necesario introducir el e-mail 1 de la empresa';
    esValido=false;
  }else{
    //compruebo que el e-mail tenga un formato correcto 'admin@admin.com'  
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(document.form1.strEmail1.value) ){
        textoError=textoError+"El E-mail " + document.form1.strEmail1.value + " es incorrecto.\n";
        document.form1.strEmail1.style.borderColor='#FF0000';
        document.form1.strEmail1.title ='El E-mail es incorrecto';
        esValido=false;
    }
  }
  //comprobacion del campo 'strEmail2'
  if (document.form1.strEmail2.value == ''){ 
  }else{
    //compruebo que el e-mail tenga un formato correcto 'admin@admin.com'  
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(document.form1.strEmail2.value) ){
        textoError=textoError+"El E-mail " + document.form1.strEmail2.value + " es incorrecto.\n";
        document.form1.strEmail2.style.borderColor='#FF0000';
        document.form1.strEmail2.title ='El E-mail es incorrecto';
        esValido=false;
    }
  }
  //comprobacion del campo 'fechaAlta'
  if (document.form1.fechaAlta.value == ''){ 
    textoError=textoError+"Es necesario introducir la fecha de alta de la empresa.\n";
    document.form1.fechaAlta.style.borderColor='#FF0000';
    document.form1.fechaAlta.title ='Es necesario introducir la fecha de alta de la empresa';
    esValido=false;
  }
  //comprobacion del campo 'fechaVencimiento'
  if (document.form1.fechaVencimiento.value == ''){ 
    textoError=textoError+"Es necesario introducir la fecha de vencimiento de la empresa.\n";
    document.form1.fechaVencimiento.style.borderColor='#FF0000';
    document.form1.fechaVencimiento.title ='Es necesario introducir la fecha de vencimiento de la empresa';
    esValido=false;
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

function validarP2(){
  esValido=true;
  textoError='';
  
  //comprobacion del campo 'strNombre'
  if (document.form1.strNombre.value == ''){ 
    textoError=textoError+"Es necesario introducir el nombre.\n";
    document.form1.strNombre.style.borderColor='#FF0000';
    document.form1.strNombre.title ='Se debe introducir el nombre';
    esValido=false;
  }
  //comprobacion del campo 'strPassword'
  if (document.form1.strPassword.value == ''){ 
    textoError=textoError+"Es necesario introducir la contraseña.\n";
    document.form1.strPassword.style.borderColor='#FF0000';
    document.form1.strPassword.title ='Se debe introducir la contraseña';
    esValido=false;
  }
  //comprobacion del campo 'strPassword2'
  if (document.form1.strPassword2.value == ''){ 
    textoError=textoError+"Es necesario introducir la repetición de la contraseña.\n";
    document.form1.strPassword2.style.borderColor='#FF0000';
    document.form1.strPassword2.title ='Se debe introducir repetición de la contraseña';
    esValido=false;
  }
  //comprobacion del campo 'strPassword' y 'strPassword2' son iguales
  if ((document.form1.strPassword.value != '')&&(document.form1.strPassword2.value != '') &&
       (document.form1.strPassword.value != document.form1.strPassword2.value) ){ 
    textoError=textoError+"La contraseña debe coincidir en los campos contraseña y repetir contraseña.\n";
    document.form1.strPassword.style.borderColor='#FF0000';
    document.form1.strPassword2.style.borderColor='#FF0000';
    document.form1.strPassword.title ='Esta contraseña debe coincidir con la del campo repetir';
    document.form1.strPassword2.title ='Esta repetición de contraseña debe coincidor con la del campo contraseña';
    esValido=false;
  }

  //comprobacion de que el nombre de usuario no esta repetido
  texto=document.getElementById("txt_usuario").innerHTML;
  if (texto.indexOf('error') != -1){
    textoError=textoError+"El nombre de usuario ya existe.\n";
    document.form1.strUsuario.style.borderColor='#FF0000';
    esValido=false;
  }
    
    
  //indicar el mensaje de error si es 'esValido' false
  if (!esValido){
          alert(textoError);
  }

  if(esValido==true){
      $('#pantalla2').slideUp(1000);
      $('#pantalla3').slideDown(1000);
  }else{
      return false;
  }  
}

function validarP3(){
    //aqui no hay que validar nada, esta todo en select
      $('#pantalla3').slideUp(1000);
      $('#pantalla4').slideDown(1000);
}


function validar2()
{
  esValido=true;
  textoError='';
  
  //comprobacion del campo 'PorcAutonomos'
  if (document.form1.PorcAutonomo.value == ''){ 
    textoError=textoError+"Es necesario introducir la cantidad de retención de porcentaje de autonomos.\n";
    document.form1.PorcAutonomo.style.borderColor='#FF0000';
    document.form1.PorcAutonomo.title ='Es necesario introducir la cantidad de retención de porcentaje de autonomos';
    esValido=false;
  }
  //comprobacion del campo 'PagosCuentas'
  if (document.form1.PagosCuentas.value == ''){ 
    textoError=textoError+"Es necesario introducir la cantidad de retención de pago a cuenta.\n";
    document.form1.PagosCuentas.style.borderColor='#FF0000';
    document.form1.PagosCuentas.title ='Es necesario introducir la cantidad de retención de pago a cuenta';
    esValido=false;
  }
  //comprobacion del campo 'email'
  if (document.form1.email.value === ''){ 
  }else{
    //compruebo que el e-mail tenga un formato correcto 'admin@admin.com'  
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(document.form1.email.value) ){
        textoError=textoError+"El E-mail " + document.form1.email.value + " es incorrecto.\n";
        document.form1.email.style.borderColor='#FF0000';
        document.form1.email.title ='El E-mail es incorrecto';
        esValido=false;
    }
  }
  
  //comprobacion que no haya frases con error en el txt_file
  texto=document.getElementById("txt_file").innerHTML;
  if (texto.indexOf('NO es JPG o PNG') != -1){
    textoError=textoError+"El fichero NO es JPG o PNG.\n";
    esValido=false;
  }
  if (texto.indexOf('Este fichero EXISTE') != -1){
    textoError=textoError+"Este fichero EXISTE.\n";
    esValido=false;
  }
  
  //indicar el mensaje de error si es 'esValido' false
  if (!esValido){
          alert(textoError);
  }

  if(esValido==true){
      document.getElementById("cmdAlta").value = "Enviando...";
      document.getElementById("cmdAlta").disabled = true;
      document.form1.opcion.value='true';
      document.form1.submit();
  }else{
      return false;
  }  
}

function actualizaHiddenEstado(check,hidden){
    if(check.checked===true){
        hidden.value='on';
    }else{
        hidden.value='off';
    }
}

//AJAX jQuery chequea cuenta exista en la BD
function check_fileConsulta(file){
    $.ajax({
      data:{"file":file},  
      url: '../vista/ajax/buscar_fileLogo.php',
      type:"get",
      success: function(data) {
          data='<font color="#FF0000">'+data+'</font>';
          $('#txt_file').html(data);
      }
    });
}

//AJAX jQuery chequea usuario exista en la BD
function check_usuario(str){
    $.ajax({
      data:{"q":str},  
      url: '../vista/ajax/buscar_empresa.php',
      type:"get",
      success: function(data) {
        //cambio el tamaño de la imagen
        data=data.replace("'15'","'20'");
        $('#txt_usuario').html(data);
      }
    });
}


</script>        
<style>
input[type=checkbox]
{
  /* Double-sized Checkboxes */
  -ms-transform: scale(2); /* IE */
  -moz-transform: scale(2); /* FF */
  -webkit-transform: scale(2); /* Safari and Chrome */
  -o-transform: scale(2); /* Opera */
  padding: 10px;
}
</style> 

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>

    <div data-role="content" data-theme="a">
        <form action="../vista/configuracion_empresa.php" name="form1" method="POST" enctype="multipart/form-data" data-ajax="false">
            
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
                                <label>Nombre de la Empresa</label>
                                <input type="text" name="strSesion" maxlength="50" value="<?php if(isset($datosEmpresa_tbempresas)){echo $datosEmpresa_tbempresas['strSesion'];} ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <label>CIF (Lectura)</label>
                                <input type="text" readonly value="<?php if(isset($datosEmpresa_tbempresas)){echo $datosEmpresa_tbempresas['strCIF'];} ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <label>Dirección</label>
                                <input type="text" name="strDireccion" maxlength="50" value="<?php if(isset($datosEmpresa_tbempresas)){echo $datosEmpresa_tbempresas['direccion'];} ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <label>Municipio</label>
                                <input type="text" name="strMunicipio" maxlength="50" value="<?php if(isset($datosEmpresa_tbempresas)){echo $datosEmpresa_tbempresas['municipio'];} ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <label>Provincia</label>
                                <input type="text" name="provincia" maxlength="50" value="<?php if(isset($datosEmpresa_tbempresas)){echo $datosEmpresa_tbempresas['provincia'];} ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1">
                                <label>C.P.</label>
                                <input type="text" name="lngCP" maxlength="5" onkeypress="javascript:return solonumeros(event);"
                                       value="<?php if(isset($datosEmpresa_tbempresas)){echo $datosEmpresa_tbempresas['CP'];} ?>" />
                            </td>
                            <td colspan="3">
                                <label>Telefono</label>
                                <input type="text" name="lngTelefono" maxlength="11" onkeypress="javascript:return solonumeros(event);"
                                       value="<?php if(isset($datosEmpresa_tbempresas)){echo $datosEmpresa_tbempresas['telefono'];} ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <label>E-mail 1</label>
                                <input type="text" name="strEmail1" maxlength="50" value="<?php if(isset($datosEmpresa_tbempresas)){echo $datosEmpresa_tbempresas['email1'];} ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <label>E-mail 2</label>
                                <input type="text" name="strEmail2" maxlength="50" value="<?php if(isset($datosEmpresa_tbempresas)){echo $datosEmpresa_tbempresas['email2'];} ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <label>CC Transferencias</label>
                                <input type="text" name="CCTrans" maxlength="30" value="<?php if(isset($datosEmpresa)){echo $datosEmpresa['CCTrans'];} ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <label>Versión</label>
                                <input type="text" name="version" maxlength="11" onkeypress="javascript:return solonumeros(event);"
                                       value="<?php if(isset($datosEmpresa_tbempresas)){echo $datosEmpresa_tbempresas['Version'];} ?>" />
                            </td>
                            <td colspan="2">
                                <label>Número Apuntes</label>
                                <input type="text" name="numApuntes" maxlength="11" onkeypress="javascript:return solonumeros(event);"
                                       value="<?php if(isset($datosEmpresa_tbempresas)){echo $datosEmpresa_tbempresas['numApuntes'];} ?>" />
                            </td>
                        </tr>
                        <tr>
                            <?php
                            datepicker_español('fechaAlta');
                            datepicker_español('fechaVencimiento');
                            ?>
                            <td colspan="2">
                                <label>Fecha Alta</label>
                                <input type="text" name="fechaAlta" maxlength="38" id="fechaAlta"
                                       onKeyUp="this.value=formateafechaEntrada(this.value);"
                                       value="<?php if(isset($datosEmpresa_tbempresas)){echo $datosEmpresa_tbempresas['fechaAlta'];} ?>" />
                            </td>
                            <td colspan="2">
                                <label>Fecha Vencimiento</label>
                                <input type="text" name="fechaVencimiento" maxlength="38" id="fechaVencimiento"
                                       onKeyUp="this.value=formateafechaEntrada(this.value);"
                                       value="<?php if(isset($datosEmpresa_tbempresas)){echo $datosEmpresa_tbempresas['fechaVencimiento'];} ?>" />
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
                            <td colspan="3">
                                <label>Nombre</label>
                                <input type="text" name="strNombre" maxlength="30" 
                                       value="<?php if(isset($datosEmpresa_tbempresas)){echo $datosEmpresa_tbempresas['strNombre'];} ?>"
                                       onKeyUp="check_usuario(this.value);" onblur="check_usuario(this.value);" />
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
                                <input type="password" name="strPassword" maxlength="10" 
                                       value="<?php if(isset($datosEmpresa_tbempresas)){echo $datosEmpresa_tbempresas['strPassword'];} ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <label>Repetir Contraseña</label><br/>
                                <input type="password" name="strPassword2" maxlength="10" 
                                       value="<?php if(isset($datosEmpresa_tbempresas)){echo $datosEmpresa_tbempresas['strPassword'];} ?>" />
                            </td>
                        </tr>
                    </tbody>
                </table>    
                <input type="button" id="cmdAlta1" value = "Continuar" onclick="javascript:validarP2();" />
            </div>

            <div id="pantalla3" style="display:none;">
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
                                <label>Asesor</label>
                                <select id="IdAsesor" name="IdAsesor" data-native-menu="false" data-theme='a'>
                                    <?php
                                    //funcion general
                                    echo listadoAsesores($datosEmpresa_tbempresas['lngAsesor']);
                                    ?>
                                </select>    
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <label>Base Datos (Lectura)</label>
                                <input type="text" readonly value="<?php if(isset($datosEmpresa_tbempresas)){echo $datosEmpresa_tbempresas['strMapeo'];} ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <label>Asesor</label>
                                <select id="claseEmpresa" name="claseEmpresa" data-native-menu="false" data-theme='a'>
                                    <?php
                                    $selectedVacio='';
                                    $selectedAutonomo='';
                                    $selectedSociedades='';
                                    $selectedAsocSAL='';
                                    if($datosEmpresa_tbempresas['claseEmpresa']===''){
                                        $selectedVacio='selected';
                                    }else
                                    if($datosEmpresa_tbempresas['claseEmpresa']==='Autonomo'){
                                        $selectedAutonomo='selected';
                                    }else
                                    if($datosEmpresa_tbempresas['claseEmpresa']==='Sociedades'){
                                        $selectedSociedades='selected';
                                    }else
                                    if($datosEmpresa_tbempresas['claseEmpresa']==='AsocSAL'){
                                        $selectedAsocSAL='selected';
                                    }
                                    ?>
                                    <option value="" <?php echo $selectedVacio;?>></option>
                                    <option value="Autonomo" <?php echo $selectedAutonomo;?>>Autonomo</option>
                                    <option value="Sociedades" <?php echo $selectedSociedades;?>>Sociedades (PYMES)</option>
                                    <option value="AsocSAL" <?php echo $selectedAsocSAL;?>>Asociaciones (Sin Animo de Lucro)</option>
                                </select>    
                            </td>
                        </tr>
                    </tbody>
                </table>    
                <input type="button" id="cmdAlta1" value = "Continuar" onclick="javascript:validarP3();" />
            </div>

            <div id="pantalla4" style="display:none;">
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
                                <label>Autonomos (%)</label>
                                <input type="text" name="PorcAutonomo" maxlength="5" value="<?php if(isset($datosEmpresa)){echo $datosEmpresa['Porcentaje Autonomo'];}else{echo '20';} ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <label>Pagos Cuenta (%)</label>
                                <input type="text" name="PagosCuentas" maxlength="5" value="<?php if(isset($datosEmpresa)){echo $datosEmpresa['Pagos Cuenta'];}else{echo '20';} ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <label>Email Envios</label>
                                <input type="text" name="email" maxlength="40" value="<?php if(isset($datosEmpresa)){echo $datosEmpresa['Email Envios'];} ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td height='15px'></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <label>¿Desea que aparezca el Logotipo en los documentos que se generen?</label>
                            </td>
                            <td>
                                <input type="checkbox" name="checkLogoDocumento" onclick="actualizaHiddenEstado(this,document.form1.logoDocumento);" <?php if(isset($datosEmpresa)){if($datosEmpresa['Logo en Documentos']==='on'){echo 'checked';}} ?> />
                                <input type="hidden" name="logoDocumento" value="<?php if(isset($datosEmpresa)){echo $datosEmpresa['Logo en Documentos'];} ?>" />
                            </td>            
                        </tr>
                        <tr>
                            <td height='15px'></td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <label>¿Desea que aparezca el Logotipo en la aplicación?</label>
                            </td>
                            <td>
                                <input type="checkbox" name="checkLogoAplicacion" onclick="actualizaHiddenEstado(this,document.form1.logoAplicacion);" <?php if(isset($datosEmpresa)){if($datosEmpresa['Logo en Aplicacion']==='on'){echo 'checked';}} ?> />
                                <input type="hidden" name="logoAplicacion" value="<?php if(isset($datosEmpresa)){echo $datosEmpresa['Logo en Aplicacion'];} ?>" />
                            </td>            
                        </tr>
                        <tr>
                            <td height='15px'></td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <label>Tipo de Contador</label>
                                <select id="tipoContador" name="tipoContador" data-native-menu="false" data-theme='a'>
                                    <option value=" " <?php if($datosEmpresa['Tipo Contador']===''){echo 'selected';}?>>Ninguno</option>
                                    <option value="simple" <?php if($datosEmpresa['Tipo Contador']==='simple'){echo 'selected';}?>>Simple</option>
                                    <option value="compuesto1" <?php if($datosEmpresa['Tipo Contador']==='compuesto1'){echo 'selected';}?>>Compuesto Número/Año</option>
                                    <option value="compuesto2" <?php if($datosEmpresa['Tipo Contador']==='compuesto2'){echo 'selected';}?>>Compuesto Año/Número</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <label>Alias de la Empresa</label>
                                <input type="text" name="alias" maxlength="25" value="<?php if(isset($datosEmpresa)){echo $datosEmpresa['Alias'];} ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <label>Logo de la Empresa</label>
                                <input type="file" class="file" id="doc" name="doc" onchange="check_fileConsulta(this.value);" />
                                <span id="txt_file"></span><br/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <span id="img_file">
                                    <?php if(isset($datosEmpresa)){echo '<img height="70" width="140" src="../images/'.$datosEmpresa['Logo'].'" />';} ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <label>Titulo del Presupuesto</label>
                                <select id="tituloPrep" name="tituloPrep" data-native-menu="false" data-theme='a'>
                                    <option value="presupuesto" <?php if($datosEmpresa['Titulo Presupuesto']==='presupuesto'){echo 'selected';}?>>Presupuesto</option>
                                    <option value="oferta" <?php if($datosEmpresa['Titulo Presupuesto']==='oferta'){echo 'selected';}?>>Oferta</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <label>Texto a pie de página</label>
                                <textarea name="txtPie" rows=4 cols="20"><?php if(isset($datosEmpresa)){echo $datosEmpresa['Texto Pie'];} ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <label>Si emite facturas con retención IRPF, escoja el tipo</label>
                                <select id="tipoIRPF" name="tipoIRPF" data-native-menu="false" data-theme='a'>
                                    <option value="0" <?php if($datosEmpresa['Tipo IRPF']==='0'){echo 'selected';}?>>NO</option>
                                    <option value="9" <?php if($datosEmpresa['Tipo IRPF']==='9'){echo 'selected';}?>>9</option>
                                    <option value="14" <?php if($datosEmpresa['Tipo IRPF']==='14'){echo 'selected';}?>>14</option>
                                    <option value="21" <?php if($datosEmpresa['Tipo IRPF']==='21'){echo 'selected';}?>>21</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td height='15px'></td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <div align="center">
                                    <label>Tipo Factura</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <script>
                                function verImgFactura(fichero){
                                    window.open ("../images/"+fichero,"nueva","resizable=yes, scrollbars=yes, width=650,height=450");
                                }

                                function cambiarImg(objeto){
                                    $.ajax({
                                      data:{"IdTipo":objeto.value},  
                                      url: '../vista/buscarFicheroTipoFactura.php',
                                      type:"get",
                                      success: function(data) {
                                        //actualizamos el fichero a ver del select
                                        document.form1.imgTextFicheroHidden.value = data;
                                      }
                                    });
                                }
                                </script>  
                                <select id="FacturaTipo" name="FacturaTipo" onchange="cambiarImg(this);" data-native-menu="false" data-theme='a'>
                                <?php
                                echo listadoTiposFactura($datosEmpresa['Factura Tipo']);
                                ?>
                                </select>
                            </td>
                            <td colspan="2">
                                <?php
                                //buscar imagen
                                $nombreFichero = $clsCNContabilidad->nombreFacturaFichero($datosEmpresa['Factura Tipo']);
                                ?>
                                <div align="center">
                                <img id="imgTipoFichero" height="30" width="30" src="../images/kview.png" 
                                     onclick="verImgFactura(document.form1.imgTextFicheroHidden.value);" />
                                <input type="hidden" name="imgTextFicheroHidden" value="<?php echo $nombreFichero; ?>" />
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td height='15px'></td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <script>
                                function actualizaHiddenEstado(check,hidden){
                                    if(check.checked===true){
                                        hidden.value='on';
                                    }else{
                                        hidden.value='off';
                                    }
                                }
                                </script>
                                <label>Utilizar la Base de Datos de Artículos</label>
                            </td>
                            <td>
                                <input type="checkbox" name="checkArticulo" onclick="actualizaHiddenEstado(this,document.form1.articulo);" <?php if(isset($datosEmpresa['articulo'])){if($datosEmpresa['articulo']==='on'){echo 'checked';}} ?> />
                                <input type="hidden" name="articulo" value="<?php if(isset($datosEmpresa['articulo'])){echo $datosEmpresa['articulo'];} ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" height='30px'></td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <div align="left">
                                    <label>Cuenta Contable de Ventas</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <script>
                                function cambioCuentaContable(objeto,objHidden){
                                    objHidden.value=objeto.value;
                                }    
                                </script>
                                <select name="" data-native-menu="false" data-theme='a'
                                        onchange="cambioCuentaContable(this,document.form1.cuentaContable);">
                                        <?php
                                        $listadoCuentasContables = $clsCNContabilidad->listarCuentasArticulos();
                                        //preparo el listado
                                        for ($i = 0; $i < count($listadoCuentasContables); $i++) {
                                            $selected='';
                                            if($datosEmpresa['cuentaContable']===$listadoCuentasContables[$i]['NumCuenta']){
                                                $selected='selected';
                                            }
                                            echo"<option value='".$listadoCuentasContables[$i]['NumCuenta']."' ".$selected.">".$listadoCuentasContables[$i]['cuenta']."</option>";
                                        }
                                        ?>
                                </select>
                                <input type="hidden" name="cuentaContable" value="<?php echo $datosEmpresa['cuentaContable']; ?>" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td colspan="4" height='30px'><hr/></td>
                        </tr>
                        <tr>
                            <script>
                            function autorizacion(objeto){
                                if(objeto.checked===true){
                                    $('#cmdAlta').button('enable');
                                }else{
                                    $('#cmdAlta').button('disable');
                                }
                            }
                            </script>
                            <td>
                                <input type="checkbox" name="chkAutorizacion" onclick="autorizacion(this);" />
                            </td>
                            <td colspan="3">
                                <label>Declaro que todos los datos son ciertos bajo mi responsabilidad, y estoy autorizado a utilizar las direcciones de e-mail para el envío de correos.</label>
                            </td>
                        </tr>
                        <tr>
                            <td height='15px'></td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <input type="button" id="cmdAlta" data-theme="a" data-icon="check" 
                                       value = "Guardar" onclick="javascript:validar2();" disabled />
                                <input type="hidden" name="opcion" value="false" />
                            </td>
                        </tr>
                    </tbody>
                </table>  
            </div>
        </form>
        
    </div>
</div>
    
<!--    
    Este addEventListener es para el input de fichero id=doc
    asi puede uno cargar la imagen en donde esta el logo
-->
<script language="JavaScript">
  function handleFileSelect(evt) {
    var files = evt.target.files; // FileList object

    // Loop through the FileList and render image files as thumbnails.
    for (var i = 0, f; f = files[i]; i++) {

      // Only process image files.
      if (!f.type.match('image.*')) {
        continue;
      }

      var reader = new FileReader();

      // Closure to capture the file information.
      reader.onload = (function(theFile) {
        return function(e) {
          // Render thumbnail.
          var span = document.getElementById('img_file');
          span.innerHTML = ['<img width="140" height="70" src="', e.target.result,
                            '" title="', escape(theFile.name), '"/>'].join('');
        };
      })(f);

      // Read in the image file as a data URL.
      reader.readAsDataURL(f);
    }
  }

  document.getElementById('doc').addEventListener('change', handleFileSelect, false);

</script>

</body>
</html>
