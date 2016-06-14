<?php
session_start();
require_once '../general/funcionesGenerales.php';
require_once '../CN/clsCNContabilidad.php';

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



logger('info','empleados_list.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
       " ||||Comunicaciones->Transmitir Apuntes||");

$clsCNContabilidad=new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['mapeo']);


date_default_timezone_set('Europe/Madrid');
$fechaForm=date('d/m/Y');


////cuando nos hemos submitido con exportar
//if(isset($_POST['Exportar']) && $_POST['Exportar']==='OK'){
//    //exportamos los asientos comprendidos entre las dos fechas del formulario
//    $post=$_POST;
//    $post =  serialize($post);
//    $post = urlencode($post); 
//    
//    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/transmitir_apuntes_exportar.php?parametros='.$post.'">';
//    die;
//}

////cuando nos hemos submitido con importar
//if(isset($_POST['Importar']) && $_POST['Importar']==='OK'){
//    //indicamos el lugar y nombre del fichero a subir
//    $url="../MovimientosImpExp/ContabilImp.mdb";
//    if(move_uploaded_file($_FILES['doc']['tmp_name'], $url)){
//        logger('traza','transmitir_apuntes.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
//               " El fichero ".$_FILES['doc']['name'].' a sido subido correctamente al servidor');
//        //importamos los datos del fichero subido
//        logger('traza','transmitir_apuntes.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
//               " importamos los datos del fichero MDB subido: clsCNConsultas->ImportarAsientoContabil()>");
//        //QUITAR ESTA LINEA
////        $varRes=$clsCNContabilidad->ImportarAsientoContabil($url);
//        $post=$_POST;
//        $post =  serialize($post);
//        $post = urlencode($post); 
//    
//        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/transmitir_apuntes_importar.php?url='.$url.'&parametros='.$post.'">';
//        die;
//        
//    }else{
//        logger('traza','transmitir_apuntes.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
//               " El fichero ".$_FILES['doc']['name'].' NO a sido subido al servidor. Error en COPY');
////        $OK=false;
////        $errorFile='Error al subir el fichero: '.$_FILES['doc']['name'];
//        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../vista/error.php?id=No se a leido el fichero Contabil.Mdb">';
//        die;
//    }
//    
//    
//}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="../images/q.ico">
        <title>Transmitir Apuntes</title>
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
        <link href="../css/Estilos_Qualidad.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="../css/calidad2.css" type="text/css">

        <!--            HE INCLUIDO AQUI ESTAS LIBRERIAS DE jQuery PACO-->
        <?php
        librerias_jQuery();
        ?>
        <script src="../js/jQuery/ui/jquery.blockUI.js"></script> 
        
        
        <!--       FIN     HE INCLUIDO AQUI ESTAS LIBRERIAS DE jQuery PACO-->
        <link rel="stylesheet" type="text/css" media="all" href="../js/jQuery/fancybox/style.css">
        <link rel="stylesheet" type="text/css" media="all" href="../js/jQuery/fancybox/jquery.fancybox.css">
        <script type="text/javascript" src="../js/jQuery/fancybox/jquery.fancybox.js?v=2.0.6"></script>



<script LANGUAGE="JavaScript"> 
function validarExportar(){
    //bloqueo la pantalla
    $.blockUI(
      {message:'Por favor. Espere...',
      css: { 
          border: 'none', 
          padding: '10px', 
          backgroundColor: '#000', 
          '-webkit-border-radius': '10px', 
          '-moz-border-radius': '10px', 
          opacity: .5, 
          color: '#fff' 
      }}
    );

    document.frmExportar.Exportar.value='OK';
    document.frmExportar.cmdExportar.value="Enviando...";
    document.frmExportar.cmdExportar.disabled=true;
    document.frmExportar.submit();
}

function validarMDB(){
  
  esValido=true;
  textoError='';

  //compruebo que no haya error en el span AJAX (de la carga del fichero)
  if ((document.getElementById("txt_file").innerHTML.indexOf('NO es fichero MDB access')!=-1)){
    textoError=textoError+"El fichero a adjuntar no es MDB access.\n";
    esValido=false;
  }
     
  //compruebo que haya datos en doc
  if ((document.getElementById("doc").value==='')){
    textoError=textoError+"No hay fichero adjuntado.\n";
    esValido=false;
  }
     
  
  //indicar el mensaje de error si es 'esValido' false
  if (!esValido){
          alert(textoError);
  }

  if(esValido==true){
      //bloqueo la pantalla
      $.blockUI(
        {message:'Por favor. Espere...',
        css: { 
            border: 'none', 
            padding: '10px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        }}
      ); 
      
//      //para que salga el gif de subir en las respuestas  
//      if(document.getElementById('doc').value.length>0){
//          document.getElementById('loading').style.display='inline';
//      }
      
      document.formConsulta.Importar.value='OK';
      document.formConsulta.btnConsulta.value="Enviando...";
      document.formConsulta.btnConsulta.disabled=true;
      document.formConsulta.submit();
  }else{
      return false;
  }  
}

//AJAX jQuery chequea cuenta exista en la BD
function check_fileMDB(file){
    $.ajax({
      data:{"file":file},  
      url: '../vista/ajax/buscar_fileMDB.php',
      type:"get",
      success: function(data) {
        $('#txt_file').html(data);
      }
    });
}


</script>
        
<?php
//Funciones generales - carga las funciones auxiliares de eventos de los input text
    eventosInputText();
?>
    </head>
    <SCRIPT LANGUAGE="JavaScript"> 
 
        <!-- Inicio
        function MakeArrayday(size) {
            this.length = size;
            for(var i = 1; i <= size; i++) {
                this[i] = ""
            }
            return this
        }
 
        function funClock() {
            if (!document.layers && !document.all)
                return;
            var runTime = new Date()
            var hours = runTime.getHours()
            var minutes = runTime.getMinutes()
            var seconds = runTime.getSeconds()
            var dn = "am";
 
 
            if (minutes <= 9) {
                minutes = "0" + minutes;
            }
            if (seconds <= 9) {
                seconds = "0" + seconds;
            }
            movingtime = "<b>"+ hours + ":" + minutes + ":" + seconds + " " +  "</b>";
            if (document.layers) {
                document.layers.clock.document.write(movingtime);
                document.layers.clock.document.close();
            }
            else if (document.all) {
               // clock.innerHTML = movingtime;
            }
            setTimeout("funClock()", 1000)
        }
        window.onload = funClock;
        //  Fin -->
    </script>


    <SCRIPT LANGUAGE="JavaScript"> 
        <!-- Hide from JavaScript-Impaired Browsers
        function initArray() {
            for(i=0;i<initArray.arguments.length; i++)
            this[i] = initArray.arguments[i];
        }
 
        var isnMonths=new initArray("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre")
        var isnDays= new initArray("Domingo","Lunes","Martes","Mi&eacute;rcoles","Jueves","Viernes","Sabado","Domingo")
        today=new Date()
        hrs=today.getHours()
        min=today.getMinutes()
        sec=today.getSeconds()
        clckh=""
        clckm=""
        clcks=""
        clck=""
 
        var stnr=""
        var ns="0123456789"
        var a="";
        // End Hiding -->
    </script>
    
    <body>
    <?php require_once '../vista/cabecera2.php'; ?>
<div id="form_inicial" <?php if(isset($resultado) && $resultado==='SI'){echo 'style="display:none;"';} ?>>
<table align="center">
    <tr>
        <td>
    <h3 align="center" color="#FFCC66">
        <font size="3px">Transmitir Apuntes</font>
    </h3> 
    <table class="filtro" align="center" border="0" width="954">
        <tr></tr>
        <tr><td>
    <table class="filtro" align="center" border="0" width="700">
    <tr> 
      <td colspan="5"></td>
    </tr>
   <script languaje="JavaScript">
       function formOnOff(form1,form2){
            if(form1.style.display==='none'){
                $(form2).hide(1000);
                $(form1).show(1000);
            }else{
                $(form1).hide(1000);
            }
       }
   </script>
      <tr align="center">
         <td colspan="5">
             <input type="button" class="button" value="Exportar" onclick="formOnOff(document.getElementById('formExportar'),document.getElementById('formImportar'));" tabindex="1" />
             <input type="button" class="button" value="Importar" onclick="formOnOff(document.getElementById('formImportar'),document.getElementById('formExportar'));" tabindex="2" />
         </td>
     </tr>
     </table>
    </td></tr>
    <tr></tr>
    </table>
    <div id="formExportar" style="display: none;" align="center">
        <form name="frmExportar" action="../vista/transmitir_apuntes_exportar.php" method="post">
            <table width="400px" border="0">
                <tr> 
                  <td height="15px"></td>
                </tr>
            </table>

            <table width="400px" border="0" class="filtro">
                <tr> 
                  <td height="15px"></td>
                </tr>
                <tr>
                    <td class="nombreCampo" rowspan="2" width="20%"><div align="right"><I>Fecha:</I></div></td>
                    <td class="nombreCampo" width="30%"><div align="right">Desde:</div></td>
                    <td width="30%">
                        <input class="textbox1" type="text" name="datFechaInicio" id="datFechaInicio" size="12" maxlength="38" 
                             value="<?php if(isset($_GET['datFechaInicio'])){echo $_GET['datFechaInicio'];}else{echo '01/01/'.date('Y');}?>"
                             onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                             onKeyUp="this.value=formateafechaEntrada(this.value);" 
                             onfocus="onFocusInputText(this);"
                             onblur="onBlurInputText(this);"
                             />
                    </td>
                    <td width="20%"></td>
                </tr>
                <?php
                datepicker_español('datFechaInicio');
                datepicker_español('datFechaFin');
                ?>
                <style type="text/css">
                /* para que no salga el rectangulo inferior */        
                .ui-widget-content {
                    border: 0px solid #AAAAAA;
                }
                </style>
                <tr>
                    <td class="nombreCampo"><div align="right">Hasta:</div></td>
                    <td>
                        <input class="textbox1" type="text" name="datFechaFin" id="datFechaFin" size="12" maxlength="38" value="<?php if(isset($_GET['datFechaFin'])){echo $_GET['datFechaFin'];}else{echo $fechaForm;}?>"
                             onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                             onKeyUp="this.value=formateafechaEntrada(this.value);" 
                             onfocus="onFocusInputText(this);"
                             onblur="onBlurInputText(this);comprobarVacioFecha(this,'<?php echo $fechaForm;?>');"
                             />
                    </td>
                </tr>
                <tr>
                    <td align="center" colspan="4">
                         <input type="button" class="button" value="Comienzo Exportacion" onclick="validarExportar();" name="cmdExportar" />
                         <input type="hidden" name="Exportar" />
                    </td>
                </tr>
                <tr> 
                  <td height="15px"></td>
                </tr>
            </table>
        </form>
    </div>  
            
    <div id="formImportar" style="display: none;" align="center">
        <form name="formConsulta" enctype="multipart/form-data" method="post" action="../vista/transmitir_apuntes_importar.php">
            <table width="400px" border="0">
                <tr> 
                  <td height="15px"></td>
                </tr>
            </table>

            <table width="400px" border="0">
              <tr>
                  <td width="20"></td>
                  <td align="center">
                      <input type="file" class="file" id="doc" name="doc" onchange="check_fileMDB(this.value);" /><br/>
                      <span class="nombreCampo" id="txt_file">El documento debe ser MDB (Access)</span><br/>
                      <input type="button" name="btnConsulta" class="button" value = "Importar" onclick="validarMDB();"/>
                      <input type="hidden" name="Importar" />
                      <img id="loading" src="../images/cargar.gif" width="25" height="25" style="display:none" />
                  </td>
              </tr>
              <tr>
                  <td height="15x"></td>
              </tr>
            </table>
        </form>
    </div>  
        </td>
        </tr>
        <tr>
            <td>
                <?php include '../vista/IndicacionIncidencia.php'; ?>
            </td>
        </tr>
        </table>
</div>
    </body>
</html>
