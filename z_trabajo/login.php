<?php
session_start();
require_once '../general/funcionesGenerales.php';

//reviso si vengo con $_SESSION['navegacion']
if(!isset($_SESSION['navegacion'])){
    //sino vengo redirecciono a './index.php'
    header('Location: ./index.php');die;
}

//require_once '../CAD/clsCADLogin.php';
//$clsCADLogin=new clsCADLogin();

//$_SESSION['navegacion']=$clsCADLogin->navegacion();

//texto del banner
$texto="
        <strong><font color='#0000FF'>Opciones on-line</font></strong>
    
        Generar presupuestos
        Facturar servicios
        Controlar los gastos
        Consultar resultados
        Ver cobros pendientes
        Transmitir impuestos
        Consultar al asesor
        Altas de empleados

        <strong><font color='#0000FF'>Desde tu móvil</font></strong>
        
        ";

//$texto=  stripslashes($texto);
$texto = str_replace(chr(13),"<br>",$texto);

?>
<html>
    <head>
        <title>Q-Conta</title>
        <link rel="stylesheet" href="../css/normalize.css" type="text/css">
        <script src="../js/modernizr.js"></script>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <link href="../css/Estilos_Qualidad.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="../css/calidad2.css" type="text/css">
        <!--            HE INCLUIDO AQUI ESTAS LIBRERIAS DE jQuery PACO-->
        <?php
        librerias_jQuery_listado();
        ?>
        <!--       FIN     HE INCLUIDO AQUI ESTAS LIBRERIAS DE jQuery PACO-->
        <?php
        //Funciones generales - carga las funciones auxiliares de eventos de los inputText
        eventosInputText();
        ?>
        
        <SCRIPT LANGUAGE="JavaScript">
        
        $(document).ready(function() {
            $('#cajaclaves').corner("round 15px");
            $('#banner').corner("round 15px");
        });
        </script>

        <SCRIPT LANGUAGE="JavaScript">
            //<!-- Begin
            function Foco1Elem() {
                if (document.forms.length > 0) {
                    var field = document.forms[0];
                    for (i = 0; i < field.length; i++) {
                        if (((field.elements[i].type == "text") || (field.elements[i].type == "textarea") || (field.elements[i].type.toString().charAt(0) == "s")) && field.elements[i].readOnly == false) {
                            document.forms[0].elements[i].focus();
                            break;
                        }
                    }
                }
            }
            //  End -->
        </script>
        <script language="JavaScript">
            <!-- //
            var txt="-    Sistema de Gestión de la Calidad    ";
            var espera=120;
            var refresco=null;
	
            function rotulo_status() {
                window.status=txt;
                txt=txt.substring(1,txt.length)+txt.charAt(0);        
                refresco=setTimeout("rotulo_status()",espera);
            }
	
            // --></script>
        <link rel="shortcut icon" href="../images/q.ico">
        <script type="text/javascript">
            //comprueba si hay texto en este campo, si l hay desactiva el boton de nueva Empresa,
            // sino lo activa
            function onOffBtnNuevempresa(){
                if (document.formulario.nombre_empresa.value==='' && document.formulario.password_empresa.value===''){ 
                    document.getElementById("cmdNuevaEmp").disabled=false;
                    document.getElementById("cmdNuevaEmp").className='button';
                }else{
                    document.getElementById("cmdNuevaEmp").disabled=true;
                    document.getElementById("cmdNuevaEmp").className='buttonDesactivado';
                }
            }


            //AJAX chequea nombre de empresa en la BD
            function check_nombre_empresa(str){
                if (str.length==0){ 
                    document.getElementById("txt_nombre_empresa").innerHTML="";
                    return;
                }
                if (window.XMLHttpRequest)
                {// code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp=new XMLHttpRequest();
                }
                else
                {// code for IE6, IE5
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange=function()
                {
                    if (xmlhttp.readyState==4 && xmlhttp.status==200)
                    {
                        document.getElementById("txt_nombre_empresa").innerHTML=xmlhttp.responseText;
                    }
                }
                xmlhttp.open("GET","../vista/ajax/login_buscar_nombre_empresa.php?q="+str,true);
                xmlhttp.send();
            };

            //AJAX chequea password de empresa que está OK en 'nombre_empresa' en la BD
            function check_password_empresa(str){
                //primero compruebo que el campo 'nombre_empresa' este correcto (exista la empresa)
                //lo veo en el texto de comprobación del campo 'Identificador Empresa' con id "txt_nombre_empresa"
                texto=document.getElementById("txt_nombre_empresa").innerHTML;
                if(texto.indexOf('ok.png')!=-1){
                    if (str.length==0){ 
                        document.getElementById("txt_password_empresa").innerHTML="";
                        return;
                    }
                    if (window.XMLHttpRequest)
                    {// code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp=new XMLHttpRequest();
                    }
                    else
                    {// code for IE6, IE5
                        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange=function()
                    {
                        if (xmlhttp.readyState==4 && xmlhttp.status==200)
                        {
                            document.getElementById("txt_password_empresa").innerHTML=xmlhttp.responseText;
                            respuesta=xmlhttp.responseText;
                        }
                    }
                    xmlhttp.open("GET","../vista/ajax/login_buscar_password_empresa.php?e="+document.getElementById("nombre_empresa").value+"&q="+str,true);
                    xmlhttp.send();
                }else if(document.getElementById("txt_nombre_empresa").innerHTML==''){
                    document.getElementById("txt_password_empresa").innerHTML="<img src='../images/error.png' width='20' height='20' />";
                }else{
                    document.getElementById("txt_password_empresa").innerHTML="";
                }
            };

            //AJAX chequea usuario
            function check_usuario(str){
                if (str.length==0){ 
                    document.getElementById("txt_usuario").innerHTML="";
                    return;
                }
                if (window.XMLHttpRequest)
                {// code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp=new XMLHttpRequest();
                }
                else
                {// code for IE6, IE5
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange=function()
                {
                    if (xmlhttp.readyState==4 && xmlhttp.status==200)
                    {
                        document.getElementById("txt_usuario").innerHTML=xmlhttp.responseText;
                    }
                }
                xmlhttp.open("GET","../vista/ajax/login_buscar_usuario.php?usuario="+str,true);
                xmlhttp.send();
            };

            //AJAX chequea password del usuario que está OK en 'usuario' en la BD
            function check_password_usuario(str){
                //primero compruebo que el campo 'nombre_empresa' este correcto (exista la empresa)
                //lo veo en el texto de comprobación del campo 'Identificador Empresa' con id "txt_nombre_empresa"
                texto=document.getElementById("txt_usuario").innerHTML;
                if(texto.indexOf('ok.png')!=-1){
                    if (str.length==0){ 
                        document.getElementById("txt_password_usuario").innerHTML="";
                        return;
                    }
                    if (window.XMLHttpRequest)
                    {// code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp=new XMLHttpRequest();
                    }
                    else
                    {// code for IE6, IE5
                        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange=function()
                    {
                        if (xmlhttp.readyState==4 && xmlhttp.status==200)
                        {
                            document.getElementById("txt_password_usuario").innerHTML=xmlhttp.responseText;
                        }
                    }
                    xmlhttp.open("GET","../vista/ajax/login_buscar_password_usuario.php?usuario="+
                            document.getElementById("usuario").value+"&clave="+str,true);
                    xmlhttp.send();
                }else if(document.getElementById("txt_usuario").innerHTML==''){
                    document.getElementById("txt_password_usuario").innerHTML="<img src='../images/error.png' width='20' height='20' />";
                }else{
                    document.getElementById("txt_password_usuario").innerHTML='';
                }
            };

            //funcion que activa el cuadro de introducir datos para la empresa (los asesores)
            function activaCuadroEmpresa(){
                var usuario=document.getElementById("txt_usuario").innerHTML;
                var password=document.getElementById("txt_password_usuario").innerHTML;
                if(usuario.indexOf('ok.png')!=-1 && password.indexOf('ok.png')!=-1){
                    if(password.indexOf('asesor')!=-1){
                        $('#caja_Empresa').fadeIn(1000);
                    }else{
                        $('#caja_Empresa').fadeOut(1000);
                    }
                }else{
                    $('#caja_Empresa').fadeOut(1000);
                }
            }

            //comprueba si todos los campos son correctos y deja entrar o no
            function check_todo(){
                esValido=true;
                mensaje='';
                
                $.ajax({
                  data:{
                      "usuario":document.formulario.usuario.value,
                      "usuarioPass":document.formulario.password.value,
                      "empresa":document.formulario.nombre_empresa.value,
                      "empresaPass":document.formulario.password_empresa.value,
                      "empresaNueva":document.formulario.nuevaEmpresa.value
                  },  
                  url: '../vista/ajax/login_comprobar_todo.php',
                  type:"post",
                  success: function(data) {
                      //compruebo si viene OK submito, sino doy error
                      if(data==='OK'){
                          window.document.formulario.submit();
                      }else{
                          alert('Los Datos de entrada no son correctos');
                      }    
                  }
                });
            }
            
            function nueva_empresa(){
                window.document.formulario.nuevaEmpresa.value='SI';
                check_todo();
            }
            
            function nueva_empresa_init(){
                window.document.formulario.nuevaEmpresa.value='NO';
            }
            
            //valida si los campos estan vacios y lo indica
            function checkForm(){
                esValido=true;
                mensaje='';
                
                //compruebo si en txt_password_usuario vuelve el texto'asesor' o 'ciente'
                //si es asesor debo comprobar las cuatro comprobaciones de los campos
                //sino solo los del usuario
                var password=document.getElementById("txt_password_usuario").innerHTML;
                if(password.indexOf('asesor')!=-1){//eres asesor
                    if(!(document.getElementById("txt_nombre_empresa").innerHTML.indexOf('ok.png')!=-1) ||
                       !(document.getElementById("txt_password_empresa").innerHTML.indexOf('ok.png')!=-1) ||
                       !(document.getElementById("txt_usuario").innerHTML.indexOf('ok.png')!=-1) ||
                       !(document.getElementById("txt_password_usuario").innerHTML.indexOf('ok.png')!=-1)){
                        mensaje+="Los Datos de entrada no son correctos\n";
                        esValido=false;
                    }			
                    if (window.document.formulario.nombre_empresa.value == "") {
                        mensaje+="Identificador de empresa no puede estar vacio\n";
                        window.document.formulario.nombre_empresa.style.borderColor='#FF0000';
                        esValido=false;
                    }
                    if(window.document.formulario.password_empresa.value == ""){
                        mensaje+="El password de empresa no puede estar vacio\n";
                        window.document.formulario.password_empresa.style.borderColor='#FF0000';
                        esValido=false;
                    }
                    if(window.document.formulario.usuario.value == ""){
                        mensaje+="El nombre de usuario no puede estar vacio\n";
                        window.document.formulario.usuario.style.borderColor='#FF0000';
                        esValido=false;
                    }
                    if(window.document.formulario.password.value == ""){
                        mensaje+="El password de usuario no puede estar vacio\n";
                        window.document.formulario.password.style.borderColor='#FF0000';
                        esValido=false;
                    }
                }
                //eres cliente
                else{
                    if(!(document.getElementById("txt_usuario").innerHTML.indexOf('ok.png')!=-1) ||
                       !(document.getElementById("txt_password_usuario").innerHTML.indexOf('ok.png')!=-1)){
                        mensaje+="Los Datos de entrada no son correctos\n";
                        esValido=false;
                    }			
                    if(window.document.formulario.usuario.value == ""){
                        mensaje+="El nombre de usuario no puede estar vacio\n";
                        window.document.formulario.usuario.style.borderColor='#FF0000';
                        esValido=false;
                    }
                    if(window.document.formulario.password.value == ""){
                        mensaje+="El password de usuario no puede estar vacio\n";
                        window.document.formulario.password.style.borderColor='#FF0000';
                        esValido=false;
                    }
                }
                
                //indicar el mensaje de error si es 'esValido' false
                if (!esValido){
                    alert(mensaje);
                }else{
                    window.document.formulario.submit();
                }	
            };

            //limpiar el campo (fondo en blanco)
            function limpiarCampo(campo){
                campo.style.borderColor='#c3bbaf';
                campo.title='';
            }


            //indicacion de tiempo expirado de la sesion
            function txtSobreimpresionado(){
                //comprobar si vienen datos por GET[op]
                var op='<?php echo $_GET['op'];?>';
                if(op!=''){
                    $(function() {
                        $('#textoSobreimpresionado').html('<h3>Ha excedido el tiempo sin utilizar la aplicación<br/>Debe conectarse de nuevo para poder continuar</h3><input type="button" value="OK" onclick="$(\'#textoSobreimpresionado\').dialog(\'destroy\');" />');
                        $('#textoSobreimpresionado').dialog({ modal: true});
                        $(".ui-dialog-titlebar").hide();
                        $('#textoSobreimpresionado').delay(1000);
                    }); 
                }
            }
        </script>

    </head>
    <body OnLoad="Foco1Elem();rotulo_status();nueva_empresa_init();txtSobreimpresionado();">
        <?php include_once("../vista/analyticstracking.php"); ?>
        <div id="textoSobreimpresionado" style="display: none;" align="center"></div>
        <style>
        .ui-dialog .ui-dialog-content {
            background: #d4f2bc;
        }
        </style>
        <div align="center">
        <form action="../CN/clsCNLogin.php" method="post" name="formulario" id="formulario">
            <div>
                <table width="774" height="550" border="0">
                    <tr>
                        <td height="25%" colspan="4" align="middle" valign="top" nowrap>

                            <table id="prueba" border="0" width="701" height="148">
                                <tr>
                                    <td width="954" height="100" align="middle" valign="top" nowrap>
                                        <a href="../<?php echo $_SESSION['navegacion'];?>/login.php">
                                            <p>
                                                <img height="100" src="../images/cabecera.jpg" width="954"
                                                     id="cabecera" border="0">
                                            </p>
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p></p>
                        </td>
                    </tr>
                    <tr>
                        <td align="middle" valign="top" nowrap>
                            <div id="cajaclaves" class="cuadros" align="left" style="border-radius: 15px; border-style: solid; border-width: 1px; border-color:#9FAFD1;">
                                <table border="0">
                                    <tr>
                                        <td>
                                            <table border="0" width="250">
                                                <tr>
                                                    <td height="26" colspan="3">
                                                        <div align="center"><strong>Acceso Clientes</strong></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="85" height="32">
                                                        <div align="left">&nbsp;&nbsp;Usuario:
                                                        </div>
                                                    </td>
                                                    <td width="85">
                                                        <input class="textbox1" type="text" name="usuario" id="usuario"
                                                               onKeyUp="check_usuario(this.value);"
                                                               onfocus="check_usuario(this.value);"
                                                               onchange="check_usuario(this.value);"
                                                               onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                                                               onblur="check_usuario(this.value);"
                                                               onKeyDown="limpiarCampo(this);" />
                                                    </td>
                                                    <td width="40"><span id="txt_usuario"></span></td>
                                                </tr>
                                                <tr>
                                                    <td height="31">
                                                        <div align="left">&nbsp;&nbsp;Contrase&ntilde;a:</div>
                                                    </td>
                                                    <td><input class="textbox1" type="password" name="password" id="password"
                                                               onKeyUp="check_password_usuario(this.value);activaCuadroEmpresa();"
                                                               onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                                                               onchange="check_password_usuario(this.value);activaCuadroEmpresa();"
                                                               onfocus="check_password_usuario(this.value);activaCuadroEmpresa();"
                                                               onblur="check_password_usuario(this.value);activaCuadroEmpresa();"
                                                               onKeyDown="limpiarCampo(this);" />
                                                    </td>
                                                    <td><span id="txt_password_usuario"></span></td>
                                                </tr>
<!--                                                <tr>
                                                    <td height="26" colspan="3">
                                                    </td>
                                                </tr>-->
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <div id="caja_Empresa" style="display: none;">
                                <table border="0">
                                    <tr>
                                        <td style="height: 100px;">
                                            <table border="0" width=250>
                                                <tr>
                                                    <td colspan="3">
                                                        <div align="center">
                                                            <strong>Identificaci&oacute;n Empresa</strong>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="85" height=30>
                                                        <div align="left">&nbsp;&nbsp;Empresa:</div>
                                                    </td>
                                                    <td width="85">
                                                        <input class="textbox1" type="text" name="nombre_empresa"
                                                               id="nombre_empresa" onKeyUp="check_nombre_empresa(this.value);onOffBtnNuevempresa();"
                                                               onblur="check_nombre_empresa(this.value);onOffBtnNuevempresa();"
                                                               onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                                                               onfocus="check_nombre_empresa(this.value)"
                                                               onKeyDown="limpiarCampo(this)" />
                                                    </td>
                                                    <td width=40><span id="txt_nombre_empresa"></span></td>
                                                </tr>
                                                <tr>
                                                    <td height="30">
                                                        <div align="left">&nbsp;&nbsp;Contrase&ntilde;a:</div>
                                                    </td>
                                                    <td>
                                                        <input class="textbox1" type="password" name="password_empresa" id="password_empresa"
                                                               onKeyUp="check_password_empresa(this.value);onOffBtnNuevempresa();"
                                                               onblur="check_password_empresa(this.value);onOffBtnNuevempresa();"
                                                               onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                                                               onfocus="check_password_empresa(this.value)"
                                                               onKeyDown="limpiarCampo(this)"/>
                                                    </td>
                                                    <td><span id="txt_password_empresa"></span></td>
                                                </tr>
                                                <tr>
                                                    <td align="center" colspan="3">
                                                    <input type="button" value="Nueva Empresa" name="cmdNuevaEmp" id="cmdNuevaEmp"
                                                           class="button" tabindex="4" onclick="nueva_empresa();" />
                                                    <input type="hidden" name="nuevaEmpresa" value="NO" />
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                            </table>
                            </div>
                                <table border="0"  width=250>
                                    <tr>
                                        <td height="26">
                                            <div align="center">
                                                <input type="button" value="Conectar" name="cmdConectar" id="cmdConectar"
                                                       class="button" tabindex="3" onclick="check_todo();" />
                                            </div>
                                        </td>
                                    </tr>
                                </table>
<!--                            <p align="left">&nbsp;</p>-->
                            </div>
                            <br/><br/>
                            <div id="banner" align="center" style="border-radius: 15px;
                                                     border-style: solid;
                                                     border-width: 1px;
                                                     border-color:#9FAFD1;
                                                     background-color: #efe4a7;
                                                     word-wrap: break-word;
                                                     "
                            >
                                <table border="0">
                                    <tr>
                                        <td>
                                            <?php echo $texto; ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            
                        </td>
                        <td>&nbsp;&nbsp;&nbsp;</td>
                        <td width="50%" valign="top">
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <font color="#999999">
                                <font color="#666666" size="3">Seleccione el &aacute;rea de servicios que desea
                                utilizar y a continuaci&oacute;n, introduzca las claves de
                                identificaci&oacute;n de su empresa:</font>
                            </font><br>
                            <div align="left">
                                <font size="+1" color="#0000FF">
                                <p align="left">
                                    <input type="radio" name="ir" value="0" disabled> &nbsp; <font
                                            size="3">Sistema de Gestión de la Calidad</font><font
                                        size="+1" color="#0000FF"> </font>
                                </p>
                                </font><font size="+1" color="#0000FF">
                                <p align="left">
                                    <input type="radio" name="ir" value="1" disabled> &nbsp; <font
                                            size="3">&Aacute;rea de Recursos Humanos</font>
                                </p>
                                </font><font size="+1" color="#0000FF"><p align="left">
                                    <input type="radio" name="ir" value="2" checked> &nbsp; <font
                                            size="3">Gesti&oacute;n de Contabilidad</font>
                                </p> </font><font size="+1" color="#0000FF">
                                <p align="left">
                                    <input type="radio" name="ir" value="3" disabled> &nbsp; <font
                                            size="3">&Aacute;rea de Informaci&oacute;n Fiscal</font>
                                </p>
                                </font>
                            </div></td>
                        <td width="25%" valign="top">
                            <div align="center">
                                <br/>
                                <br/>
                                <br/>
                                <br/>
                                <img src="../images/direcciones.png">
                                <script>
                                    function irNueva(numero){
                                        if(numero===1){
                                            window.open ("../Videos/verHD.php","nueva","resizable=yes, scrollbars=yes, width=650,height=450");
                                        }else
                                        if(numero===2){
                                            window.open ("../Videos/verNormal.php","nueva","resizable=yes, scrollbars=yes, width=650,height=450");
                                        }    
                                        if(numero===3){
                                            window.open ("../Videos/verMovil.php","nueva","resizable=yes, scrollbars=yes, width=650,height=450");
                                        }    
                                        if(numero===4){
                                            window.open ("../Videos/Presentacion.php","nueva","resizable=yes, scrollbars=yes, width=650,height=450");
                                        }    
                                    }
                                </script>
                                <br/>
                                <br/>
                                <br/>
                                <br/>
                                <br/>
                                <table border="0">
                                    <tr>
                                        <td style="font-size: 12px;">
                                            Alta Factura desde PC (HD)
                                        </td>
                                        <td>
                                            <a href="javascript:irNueva(1);">
                                                <img src="../images/cam.png" width="25" height="25"
                                                     alt="Video HD">
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 12px;">
                                            Alta Factura desde PC (Normal)
                                        </td>
                                        <td>
                                            <a href="javascript:irNueva(2);">
                                                <img src="../images/cam.png" width="25" height="25"
                                                     alt="Video Normal">
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 12px;">
                                            Alta Factura desde Móvil
                                        </td>
                                        <td>
                                            <a href="javascript:irNueva(3);">
                                                <img src="../images/cam.png" width="25" height="25"
                                                     alt="Video Móvil">
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 12px;">
                                            Presentación
                                        </td>
                                        <td>
                                            <a href="javascript:irNueva(4);">
                                                <img src="../images/cam.png" width="25" height="25"
                                                     alt="Video Móvil">
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td> &nbsp;
                    </tr>
                </table>

            </div>
        </form>
        </div>    
    </body>
</html>
