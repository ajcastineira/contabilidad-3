<?php
session_start();
require_once '../general/funcionesGenerales.php';


//reviso si vengo con $_SESSION['navegacion']
if(!isset($_SESSION['navegacion'])){
    //sino vengo redirecciono a './index.php'
    header('Location: ./index.php');die;
}

?>
<!DOCTYPE html>
<html>
<head>
	<TITLE>Q-Conta</TITLE>
<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>
</head>
<body onload="txtSobreimpresionado();">

<div data-role="page" id="login">
<?php
eventosInputText();
?>
<script type="text/javascript">
            //comprueba si hay texto en este campo, si l hay desactiva el boton de nueva Empresa,
            // sino lo activa
            function onOffBtnNuevempresa(){
//                if (document.formulario.nombre_empresa.value==='' && document.formulario.password_empresa.value===''){ 
//                    document.getElementById("cmdNuevaEmp").disabled=false;
//                    $("#cmdNuevaEmp").button("refresh");
//                }else{
//                    document.getElementById("cmdNuevaEmp").disabled=true;
//                    $("#cmdNuevaEmp").button("refresh");
//                }
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
                    $(document).ready(function() {
                        window.location.href='#login2';
                        
                        
                        
//                        $('#textoSobreimpresionado').html('<h3>Ha excedido el tiempo sin utilizar la aplicación<br/>Debe logearse de nuevo para poder continuar</h3><input type="button" value="OK" onclick="$(\'#textoSobreimpresionado\').dialog(\'destroy\');" />');
////                        $('#textoSobreimpresionado').show();
//                        $('#textoSobreimpresionado').dialog({ modal: true});
//                        $(".ui-dialog-titlebar").hide();
//                        $('#textoSobreimpresionado').delay(1000);
                    }); 
                }
            }
</script>
    <!--<div id="textoSobreimpresionado" style="display: none;" align="center"></div>-->
    <style>
    .ui-dialog .ui-dialog-content {
        background: #d4f2bc;
    }
    </style>

    <div data-role="header" data-theme="a" data-position="fixed">
        <a href="#" data-role="none" data-ajax="false">
            <IMG SRC="../images/qualidadMovil.png" width="40" height="40">
        </a>
        <h1>Q-Conta</h1>
    </div>

    <div data-role="content" data-theme="a">
        <form action="../CN/clsCNLogin.php" name="formulario" method="POST" data-ajax="false" autocomplete="off">
            <label>Usuario</label>
            <table border="0" style="width: 100%;">
                <tbody>
                    <tr>
                        <td style="width: 90%;">
                            <input type="text" name="usuario" id="usuario" placeholder="Nombre"
                                    onKeyUp="check_usuario(this.value);"
                                    onfocus="check_usuario(this.value);"
                                    onchange="check_usuario(this.value);"
                                    onblur="check_usuario(this.value);"
                                    onKeyDown="limpiarCampo(this);" />
                        </td>
                        <td>
                            <span id="txt_usuario"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="password" name="password" id="password" placeholder="Password"
                                    onKeyUp="check_password_usuario(this.value);activaCuadroEmpresa();"
                                    onchange="check_password_usuario(this.value);activaCuadroEmpresa();"
                                    onfocus="check_password_usuario(this.value);activaCuadroEmpresa();"
                                    onblur="check_password_usuario(this.value);activaCuadroEmpresa();"
                                    onKeyDown="limpiarCampo(this);" />
                        </td>
                        <td>
                            <span id="txt_password_usuario"></span>
                        </td>            
                    </tr>
                </tbody>
            </table>    
            <div id="caja_Empresa" style="display: none;">
            <label>Empresa</label>
            <table border="0" style="width: 100%;">
                <tbody>
                    <tr>
                        <td style="width: 90%;">
                            <input type="text" name="nombre_empresa" id="nombre_empresa" placeholder="Empresa"
                                    id="nombre_empresa" onKeyUp="check_nombre_empresa(this.value);onOffBtnNuevempresa();"
                                    onblur="check_nombre_empresa(this.value);onOffBtnNuevempresa();"
                                    onfocus="check_nombre_empresa(this.value);"
                                    onKeyDown="limpiarCampo(this)" />
                        </td>
                        <td>
                            <span id="txt_nombre_empresa"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                <input type="password" name="password_empresa" id="password_empresa" placeholder="Password"
                        onKeyUp="check_password_empresa(this.value)"
                        onblur="check_password_empresa(this.value)"
                        onfocus="check_password_empresa(this.value)"
                        onKeyDown="limpiarCampo(this)"/>
                        </td>
                        <td>
                            <span id="txt_password_empresa"></span>
                        </td>            
                    </tr>
                </tbody>
            </table>    
<!--            <input type="button" value="Nueva Empresa" onclick="nueva_empresa();"
                   name="cmdNuevaEmp" id="cmdNuevaEmp" data-theme="e" />-->
            <input type="hidden" name="nuevaEmpresa" value="NO" />
            </div>    

            <input type="button" value="Conectar" onclick="check_todo();" data-theme="a" />
        </form>
    </div>
</div>

<div data-role="page" id="login2">
    <div data-role="header" data-theme="a" data-position="fixed">
        <a href="#" data-role="none" data-ajax="false">
            <IMG SRC="../images/qualidadMovil.png" width="40" height="40">
        </a>
        <h1>Q-Conta</h1>
    </div>
    <div data-role="content" data-theme="a">
        <h3>Ha excedido el tiempo sin utilizar la aplicación<br/>Debe conectarse de nuevo para poder continuar</h3>
        <input type="button" value="OK" onclick="javascript:window.location.href='#login'" data-theme="a" />
    </div>
</div>
    
</body>
</html>
