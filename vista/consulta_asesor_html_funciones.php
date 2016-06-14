<?php
//session_start ();
//
//require_once '../CN/clsCNContabilidad.php';
//require_once '../CN/clsCNConsultas.php';
//require_once '../CN/clsCNUsu.php';
//require_once '../general/funcionesGenerales.php';


function html_paginaEmpleadosMobil($errorFile,$txtActualizado,$datosUsuarioActivo,$idPregunta){
$clsCNConsultas=new clsCNConsultas();
$clsCNConsultas->setStrBD($_SESSION['dbContabilidad']);
$clsCNUsu=new clsCNUsu();
$clsCNUsu->setStrBD($_SESSION['dbContabilidad']);
?>
<script language="JavaScript">
    
function validarRespuesta(num,esAsesor)
{
  esValido=true;
  textoError='';
  var objetotxt="txt_file"+num;
  
  if(esAsesor=='NO'){
    //compruebo que no haya error en el span AJAX (de la carga del fichero)
    if ((document.getElementById(objetotxt).innerHTML.indexOf('Nombre de fichero existe ya')!=-1) ||
        (document.getElementById(objetotxt).innerHTML.indexOf('Este fichero NO es PDF')!=-1)){
      textoError=textoError+"El fichero a adjuntar no es correcto.\n";
      esValido=false;
    }
  }
  
  var nameForm='formRespuesta'+num;

  //comprobacion del campo 'strRespuesta'
  if (document.getElementById(nameForm).strRespuesta.value==''){ 
    textoError=textoError+"Hay que rellenar la respuesta.\n";
    document.getElementById(nameForm).strRespuesta.style.borderColor='#FF0000';
    document.getElementById(nameForm).strRespuesta.title ='Hay que rellenar la respuesta.';
    esValido=false;
  }
     
  //indicar el mensaje de error si es 'esValido' false
  if (!esValido){
    alert(textoError);
  }

  if(esValido==true){
    document.getElementById(nameForm).btnRespuesta.value="Enviando...";
    document.getElementById(nameForm).btnRespuesta.disabled=true;
    document.getElementById(nameForm).submit();
  }else{
    return false;
  }  
}

function validarConsulta(num){
  
  esValido=true;
  textoError='';

  //compruebo que no haya error en el span AJAX (de la carga del fichero)
  if ((document.getElementById("txt_file").innerHTML.indexOf('Nombre de fichero existe ya')!=-1) ||
      (document.getElementById("txt_file").innerHTML.indexOf('Este fichero NO es PDF')!=-1)){
    textoError=textoError+"El fichero a adjuntar no es correcto.\n";
    esValido=false;
  }
     
  //comprobacion del campo 'strConsulta'
  if (document.formConsulta.strConsulta.value == ''){ 
    textoError=textoError+"Hay que rellenar la consulta.\n";
    document.formConsulta.strConsulta.style.borderColor='#FF0000';
    document.formConsulta.strConsulta.title ='Hay que rellenar la consulta.';
    esValido=false;
  }
  
  //indicar el mensaje de error si es 'esValido' false
  if (!esValido){
          alert(textoError);
  }

  if(esValido==true){
      //para que salga el gif de subir en las respuestas  
      if(document.getElementById('doc').value.length>0){
          document.getElementById('loading').style.display='inline';
      }
      
      document.formConsulta.cmdAltaConsulta.value='Aceptar';
      document.formConsulta.btnConsulta.value="Enviando...";
      document.formConsulta.btnConsulta.disabled=true;
      document.formConsulta.submit();
  }else{
      return false;
  }  
}

function abreListado(IdPregunta){
    var elemento='div'+IdPregunta;
    if(document.getElementById(elemento).style.display=='block'){
        document.getElementById(elemento).style.display='none';
    }else{
        document.getElementById(elemento).style.display='block';
    }    
}

function abreFormRespuesta(IdPregunta){
    var elemento='resp'+IdPregunta;
    if(document.getElementById(elemento).style.display=='block'){
        document.getElementById(elemento).style.display='none';
    }else{
        document.getElementById(elemento).style.display='block';
    }    
}

function abreDoc(url){
    //si viene texto es la url del doc, lo abrimos en una nueva ventana
    if(url!=''){
        window.open(url);
    }
}

//AJAX jQuery chequea cuenta exista en la BD
function check_fileRespuesta(file,objeto){
    $.ajax({
      data:{"file":file},  
      url: '../vista/ajax/buscar_file.php',
      type:"get",
      success: function(data) {
        $('#'+objeto).html(data);
      }
    });
}

//AJAX jQuery chequea cuenta exista en la BD
function check_fileConsulta(file){
    $.ajax({
      data:{"file":file},  
      url: '../vista/ajax/buscar_file.php',
      type:"get",
      success: function(data) {
        $('#txt_file').html(data);
      }
    });
}

function AddAdj() 
{
    window.open ("../movil/tree_resp.php","nueva","resizable=yes, scrollbars=yes, width=650,height=450");
}

function BorraAdj() 
{
    document.getElementById('text_fileResp').value = '';
}

    
</script>

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>

    <div data-role="content" data-theme="a">

    <?php 
    //extraigo las consultas
    $preguntas=$clsCNConsultas->leePreguntas($idPregunta);
    ?>
        
    <h3 align="center" color="#FFCC66"><font size="3px">Consultas</font></h3>
        
        <?php
    if(is_array($preguntas)){
      //ahora presento los datos en la tabla
      $numP=1;
      foreach ($preguntas as $pregunta) {
        ?>
        <div id="content-wrapper">
        <?php 
        if(substr($_SESSION['cargo'],0,6)<>'Asesor'){
          $leidoR='<font color="red">Sin Leer</font>';
          if($pregunta['Leido']==='9'){
              //busco si esta leida esta pregunta por el usuario
              $leidoResp=$clsCNConsultas->LeerLeidoPreguntaAsesorUsuario($pregunta['IdPregunta'],$_SESSION['usuario']);
              if($leidoResp==='1'){
                  $leidoR='Leido';
              }
          }else if($pregunta['Leido']==1){
            $leidoR='Leido';
          }
        }
        
        $fechaBuena = explode(' ',$pregunta['Fecha']);
        $fechaBuenaD = explode('-',$fechaBuena[0]);
        $fechaBuenaD = $fechaBuenaD[2] . '/' . $fechaBuenaD[1] . '/' . $fechaBuenaD[0];
        $fechaBuenaH = substr($fechaBuena[1],0,-3);
        $fechaBuena = $fechaBuenaD . ' '. $fechaBuenaH;
        if(substr($pregunta['strPuesto'],0,6)==='Asesor'){
            echo '<font style="color: #30a53b;"><small>Comunicado</small></font><br/>';
            echo '<font style="color: #30a53b;"><small>'.$pregunta['Usuario'].'</small></font><br/>';
            echo '<small>'.$fechaBuena.'</small><br/>';
            echo '<small>'.$leidoR.'</small><br/>';
            echo '<hr class="lineaSeparacion" />';
        }else{
            echo '<small>'.$pregunta['Usuario'].'</small><br/>';
            echo '<small>'.$fechaBuena.'</small><br/>';
            echo '<small>'.$leidoR.'</small><br/>';
            echo '<hr class="lineaSeparacion" />';
        }
        echo ''.$pregunta['Pregunta'].'<br/><br/>';
        
        //compruebo si hay documento adjuntado, si hay presento boton para poder verlo
        if($pregunta['url']<>''){
        ?>
        <a href="#" onclick='abreDoc("<?php echo $pregunta['url']; ?>");'>Ver Documento Adj</a><br/><br/>
        <?php
        }

        ?>
            
            
        <?php
            
        $respApregunta=$clsCNConsultas->leeRespuestasAPregunta($pregunta['IdPregunta']);
        $clsCNConsultas->ActualizaLeidosRespuestas($respApregunta);
        if(is_array($respApregunta)){
            echo '<i>Respuestas</i>';
            foreach($respApregunta as $respuesta){
                $datosUsuario=$clsCNUsu->DatosUsuario($respuesta['IdUsuario']);
                ?>
                <article id="post-2" class="hentry">
                <div class="entry-summary">
                <?php
                echo '<small>'.$datosUsuario['strNombre'].' '.$datosUsuario['strApellidos'].'</small><br/>';
                echo '<small>'.$respuesta['Fecha'].'</small><br/>';
                $leidoR='<font color="red">Sin Leer</font>';
                if($respuesta['Leido']==1){$leidoR='Leido';}
                echo '<small>'.$leidoR.'</small>';
                echo '<hr class="lineaSeparacion" />';
                echo '<small>'.$respuesta['strRespuesta'].'</small><br/><br/><br/>';
                //compruebo si hay documento adjuntado, si hay presento el ancla para poder verlo
                if($respuesta['url']<>''){
                    //es cliente, indicamos el ancla con ver documento adjunto
                    if(substr($_SESSION['cargo'],0,6)<>'Asesor'){
                      ?>
                      <a href="#" onclick='abreDoc("<?php echo $respuesta['url']; ?>");'>Ver Documento Adj</a><br/><br/>
                    <?php
                    }else{
                      //extraigo el nombre del fichero de la url  
                      $url=explode('/',$respuesta['url']);
                      $num=count($url);
                      $fichero=$url[$num-1];
                    ?>
                      <a href="#" onclick='abreDoc("<?php echo $respuesta['url']; ?>");'><?php echo $fichero;?></a><br/><br/>
                    <?php
                    }
                }else if($respuesta['link']<>''){
                    //es cliente, indicamos el ancla con ver documento adjunto
                    if(substr($_SESSION['cargo'],0,6)<>'Asesor'){
                      ?>
                      <a href="#" onclick='abreDoc("<?php echo $respuesta['link']; ?>");'>Ver Documento Adj</a><br/><br/>
                      <?php
                    }else{
                      //extraigo el nombre del fichero de la url  
                      $url=explode('/',$respuesta['link']);
                      $num=count($url);
                      $fichero=$url[$num-1];
                      ?>
                      <a href="#" onclick='abreDoc("<?php echo $respuesta['link']; ?>");'><?php echo $fichero;?></a><br/><br/>
                      <?php
                    }
                }
                
                
                ?>
                </div>
                </article>
            <?php
            }
            $numP++;
        }
        ?>
        <table border="0" style="width: 100%;">
            <tbody>
                <tr>
                    <td style="width: 22%;"></td>
                    <td style="width: 23%;"></td>
                    <td style="width: 23%;"></td>
                    <td style="width: 22%;"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <?php
                        if(substr($_SESSION['cargo'],0,6)<>'Asesor'){//ASESOR
                            if($pregunta['Estado']==='Cerrada'){//Estado='Cerrada' o Leido=9 (pregunta del asesor)
                                echo '<br/>';
                            }else{
                                echo '<input type="button" data-mini="true" value="Añadir" onclick="abreFormRespuesta('.$pregunta['IdPregunta'].');"/>';
                            }
                        }else{
                            echo '<input type="button" data-mini="true" value="Añadir" onclick="abreFormRespuesta('.$pregunta['IdPregunta'].');"/>';
                        }
                        ?>
                    </td>
                </tr>
          </tbody>
        </table>
        <?php
        echo '<div id="resp'.$pregunta['IdPregunta'].'" style="display:none;">';
        ?>
            
        <form name="formRespuesta" enctype="multipart/form-data" id="formRespuesta<?php echo $pregunta['IdPregunta'];?>" method="post" action="../vista/consulta_asesor.php" data-ajax="false">
        <table border="0" style="width: 100%;">
            <tbody>
                <tr>
                    <td style="width: 22%;"></td>
                    <td style="width: 23%;"></td>
                    <td style="width: 23%;"></td>
                    <td style="width: 22%;"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label>Nueva Respuesta</label>
                    </td>
                </tr>
                <tr> 
                  <td colspan="4">
                      <textarea name="strRespuesta" rows=4 cols="20"
                                onfocus="onFocusInputTextM(this);"></textarea> 
                  </td>
                </tr>
                <tr>
                    <td colspan="4">Usuario: <?php echo $datosUsuarioActivo['strNombre'].' '.$datosUsuarioActivo['strApellidos'] ; ?></td>
                </tr>
                <tr>
                    <td colspan="4">
                      <?php date_default_timezone_set('Europe/Madrid'); ?>
                      Fecha: <?php print date("d/m/y"); ?>
                    </td>
                </tr>
                <?php if(substr($_SESSION['cargo'],0,6) === 'Asesor'){?>
                <tr>
                    <td colspan="3">
                        <script type="text/javascript">        
                          function nombreDocumento(val1){
                              document.getElementById('text_fileResp').value = val1;
                          }
                        </script>
                        <input type="button" data-theme="a" data-mini="true" value="Adjuntar Documento" name="btnAdjunto" onClick="AddAdj();" />
                    </td>
                    <td colspan="1">
                        <input type="button" data-theme="a" data-mini="true" value="Borrar" name="btnBorrar" onClick="BorraAdj();" />
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <input type="text" class="textbox1" name="fileResp" id="text_fileResp" readonly />
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <input type="button" data-mini="true" name="btnRespuesta" id="btn<?php echo $numP;?>" value = "Enviar" onclick="validarRespuesta('<?php echo $pregunta['IdPregunta'];?>','SI');"/>
                    </td>
                </tr>
                <?php }else{ ?>
                <tr>
                    <td colspan="4">Adjuntar PDF</td>
                </tr>
                <tr>
                    <td colspan="4">
                        <input type="file" class="file" id="docResp<?php echo $pregunta['IdPregunta'];?>" name="docResp" onchange="check_fileRespuesta(this.value,'txt_file<?php echo $pregunta['IdPregunta'];?>');" />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <span style="font-size: 0.8em;" id="txt_file<?php echo $pregunta['IdPregunta'];?>">El documento debe ser PDF y no superior a 1 MB</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">Foto</td>
                </tr>
                <tr>
                    <td colspan="4">
                        <input type="file" class="file" id="docRespFoto<?php echo $pregunta['IdPregunta'];?>" name="docRespFoto" accept="image/*" capture="camera" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="button" data-mini="true" name="btnRespuesta" id="btn<?php echo $numP;?>" value = "Enviar" onclick="validarRespuesta(<?php echo $pregunta['IdPregunta'];?>,'NO');"/>
                    </td>
                </tr>
                <?php } ?>
                <input type="hidden" name="cmdAltaRespuesta" value="<?php echo $pregunta['IdPregunta'];?>" />
                <input type="hidden" name="esAsesor" value="<?php if(isset($IdPregunta)){echo 'SI';}else{echo 'NO';}?>" />
                <input type="hidden" name="Usuario" value="<?php echo $pregunta['Usuario'];?>" />
          </tbody>
        </table>
        </form>
        
        
        <?php
        echo '</div>';
          
        ?>
        
        
        </div>
        <div style="height: 20px;"></div>
        <?php
      }
    }
    ?>
    </div>
<?php
//por ultimo actualizo las prguntas leidas (al presentarlas ya se consideran leidas por el usuario)
$clsCNConsultas->actualizaLeidosPreguntas($preguntas);
}




function html_paginaEmpleados($errorFile,$txtActualizado,$datosUsuarioActivo,$idPregunta){
$clsCNConsultas=new clsCNConsultas();
$clsCNConsultas->setStrBD($_SESSION['dbContabilidad']);
$clsCNUsu=new clsCNUsu();
$clsCNUsu->setStrBD($_SESSION['dbContabilidad']);
?>

<script language="JavaScript">
    
function validarRespuesta(num,esAsesor)
{
  esValido=true;
  textoError='';
  objetotxt="txt_file"+num;
  
  if(esAsesor=='NO'){
    //compruebo que no haya error en el span AJAX (de la carga del fichero)
    if ((document.getElementById(objetotxt).innerHTML.indexOf('Nombre de fichero existe ya')!=-1) ||
        (document.getElementById(objetotxt).innerHTML.indexOf('Este fichero NO es PDF')!=-1)){
      textoError=textoError+"El fichero a adjuntar no es correcto.\n";
      esValido=false;
    }
  }
  
  nameForm='formRespuesta'+num;

  //comprobacion del campo 'strRespuesta'
  if (document.getElementById(nameForm).strRespuesta.value==''){ 
    textoError=textoError+"Hay que rellenar la respuesta.\n";
    document.getElementById(nameForm).strRespuesta.style.borderColor='#FF0000';
    document.getElementById(nameForm).strRespuesta.title ='Hay que rellenar la respuesta.';
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
          
      document.getElementById(nameForm).btnRespuesta.value="Enviando...";
      document.getElementById(nameForm).btnRespuesta.disabled=true;
      document.getElementById(nameForm).submit();
  }else{
      return false;
  }  
}

function validarConsulta(num){
  
  esValido=true;
  textoError='';

  //compruebo que no haya error en el span AJAX (de la carga del fichero)
  if ((document.getElementById("txt_file").innerHTML.indexOf('Nombre de fichero existe ya')!=-1) ||
      (document.getElementById("txt_file").innerHTML.indexOf('Este fichero NO es PDF')!=-1)){
    textoError=textoError+"El fichero a adjuntar no es correcto.\n";
    esValido=false;
  }
     
  //comprobacion del campo 'strConsulta'
  if (document.formConsulta.strConsulta.value == ''){ 
    textoError=textoError+"Hay que rellenar la consulta.\n";
    document.formConsulta.strConsulta.style.borderColor='#FF0000';
    document.formConsulta.strConsulta.title ='Hay que rellenar la consulta.';
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
      
      //para que salga el gif de subir en las respuestas  
      if(document.getElementById('doc').value.length>0){
          document.getElementById('loading').style.display='inline';
      }
      
      document.formConsulta.cmdAltaConsulta.value='Aceptar';
      document.formConsulta.btnConsulta.value="Enviando...";
      document.formConsulta.btnConsulta.disabled=true;
      document.formConsulta.submit();
  }else{
      return false;
  }  
}

function abreListado(IdPregunta){
    var elemento='div'+IdPregunta;
    if(document.getElementById(elemento).style.display=='block'){
        document.getElementById(elemento).style.display='none';
    }else{
        document.getElementById(elemento).style.display='block';
    }    
}

function abreFormRespuesta(IdPregunta){
    var elemento='resp'+IdPregunta;
    if(document.getElementById(elemento).style.display=='block'){
        document.getElementById(elemento).style.display='none';
    }else{
        document.getElementById(elemento).style.display='block';
    }    
}

function abreDoc(url){
    //si viene texto es la url del doc, lo abrimos en una nueva ventana
    if(url!=''){
        window.open(url);
    }
}

$(document).ready(function() {
        $("input.file").file();
});

//AJAX jQuery chequea cuenta exista en la BD
function check_fileRespuesta(file,objeto){
    $.ajax({
      data:{"file":file},  
      url: '../vista/ajax/buscar_file.php',
      type:"get",
      success: function(data) {
        $('#'+objeto).html(data);
      }
    });
}

//AJAX jQuery chequea cuenta exista en la BD
function check_fileConsulta(file){
    $.ajax({
      data:{"file":file},  
      url: '../vista/ajax/buscar_file.php',
      type:"get",
      success: function(data) {
        $('#txt_file').html(data);
      }
    });
}

function AddAdj() 
{
  window.open ("../vista/tree_resp.php","nueva","resizable=yes, scrollbars=yes, width=650,height=450");
}

function BorraAdj() 
{
    document.getElementById('text_fileResp').value = '';
}


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
<script languaje="JavaScript"  type="text/JavaScript">
<!--
function Modificar(menu)
{

		document.form1.strTipReclamacion.value = menu.options[menu.selectedIndex].text
}
//-->
</script>
<link href="../css/Estilos_Qualidad.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../css/calidad2.css" type="text/css">
<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
    eventosInputText();
?>
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
clock.innerHTML = movingtime;
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

<!--    <div class="blocker" style="display:none;"></div>-->
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<!-- Cabecera-->
  <tr>
   <td width="40%"></td>
   <td width="780" bgcolor="#FFFFFF" class="Text2">
   <table border="<?php echo MARCO_BORDER; ?>" width="780">
   <tr>
   <!-- contenido pagina -->
   <td width="768" valign="top">
   <!--<br><p></p>-->

<center>
    
<?php
$tituloForm="CONSULTAS AL ASESOR";
$cabeceraNumero='0402';
$paginaForm='';
//require_once 'CodFormat.php';
//$codFormat=new CodFormat();
//$codFormat->setStrBD($_SESSION['mapeo']);
//$formatoForm=$codFormat->SelectFormato(62);
//$numeroForm=$datosReclamacion['strReclamacion'];
$disabledForm='disabled';
date_default_timezone_set('Europe/Madrid');
$fechaForm=date('d/m/Y');
require_once 'cabeceraForm.php';
?>
  <div class="doc"> 
<!--    <br/><br/>-->

    <b class="fileError">
        <?php
        if(isset($errorFile) && $errorFile<>''){
        ?>
        <script languaje="JavaScript">
        $.blockUI(
          {message:'<?php echo $errorFile;?>',
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
        setTimeout($.unblockUI, 2000);    
        </script>
        <?php
        }
        ?>
    </b>
        
    
<!--    <label class="subtitulo" onclick="onOff();">Comentarios...</label>-->
    <?php 
    //extraigo las consultas
    $preguntas=$clsCNConsultas->leePreguntas($idPregunta);
    //este formulario para añadir preguntas se presenta si somos clientes
    ?>
    
    <br/><br/>
    
    <table width="640" border="0" class="tablaComentarios" cellspacing="10px">
    <tr class="subtitulo">
    <td colspan="4" style="text-align: left;">Observaciones</td>
    <tbody>
    </tr>
    <?php
    //print_r($preguntas);
    //compruebo que vuelva un listado (es un array)
    if(is_array($preguntas)){
      //ahora presento los datos en la tabla
      $numP=1;
      foreach ($preguntas as $pregunta) {
          //averiguo si es Usuario o Asesor
          if(substr($pregunta['strPuesto'],0,7)==='Usuario'){
              $classLinea='class="impares"';
          }else{
              $classLinea='class="pares"';
          }
          echo "<tr $classLinea>";
//          echo '<td class="icono" style="background-color: #f3f4d7;">';
//          echo "<img src='../images/comentarios.png' height='42' width='42' onclick='abreListado(".$pregunta['IdPregunta'].");'>";
//          echo '</td>';
          echo '<td class="preguntaTD">';
          echo '<table width="100%" border="0" class="tablaComentariosDatos">';
          echo '<tr>';
          echo '<td>';
          echo '<div align="left">';
          if(substr($pregunta['strPuesto'],0,6)==='Asesor'){
              echo '<b style="color: #000000;">Comunicado</b><br/>';
              echo '<b style="color: #000000;">'.$pregunta['Usuario'].'</b>';
          }else{
              echo '<b>'.$pregunta['Usuario'].'</b>';
          }
          echo '</div>';
          echo '</td>';
          echo '<td>';
          echo '<div align="right">';
          $fechaBuena = explode(' ',$pregunta['Fecha']);
          $fechaBuenaD = explode('-',$fechaBuena[0]);
          $fechaBuenaD = $fechaBuenaD[2] . '/' . $fechaBuenaD[1] . '/' . $fechaBuenaD[0];
          $fechaBuenaH = substr($fechaBuena[1],0,-3);
          $fechaBuena = $fechaBuenaD . ' '. $fechaBuenaH;
          if(substr($_SESSION['cargo'],0,6)<>'Asesor'){
              echo '<font style="color: #000000;">'.$fechaBuena.'</font><br/>';
          }else{
              echo ''.$fechaBuena.'<br/>';
          }
          if(substr($_SESSION['cargo'],0,6)<>'Asesor'){
            $leidoR='<font color="red">Sin Leer</font>';
            if($pregunta['Leido']==='9'){
                //busco si esta leida esta pregunta por el usuario
                $leidoResp=$clsCNConsultas->LeerLeidoPreguntaAsesorUsuario($pregunta['IdPregunta'],$_SESSION['usuario']);
                if($leidoResp==='1'){
                    $leidoR='Leido';
                }
            }else if($pregunta['Leido']==1){
              $leidoR='Leido';
            }
            echo ''.$leidoR.'';
          }
          echo '</div>';
          echo '</td>';
          echo '</tr>';
          if(substr($_SESSION['cargo'],0,6)==='Asesor'){//ASESOR 
            echo '<tr>';
            echo '<td>';
            echo '<div align="left">';
            echo '<b>'.$pregunta['Clasificacion'].'</b>';
            echo '</div>';
            echo '</td>';
            echo '<td>';
            echo '<div align="right">';
            echo '<font>'.$pregunta['Estado'].'</font>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
          }
          echo '</table>';
          echo '<hr class="lineaSeparacion" />';
          echo '<br/>';
          echo '<p class="tablaComentariosDatosB">'.str_replace("\r\n","<br/>",$pregunta['Pregunta']).'</p><br/><br/>';
          //compruebo si hay documento adjuntado, si hay presento boton para poder verlo
          if($pregunta['url']<>''){
          ?>
          <a class="textbox1 tablaComentariosDatosB" href="#" onclick='abreDoc("<?php echo $pregunta['url']; ?>");'>Ver Documento Adj</a><br/><br/>
          <?php
          }
          echo '<div id="div'.$pregunta['IdPregunta'].'" style="display:block;">';
          //aqui van las respuesta y un pequeño formulario para indicar mas respuestas
          //primero busco las respuestas de la BBDD
          $respApregunta=$clsCNConsultas->leeRespuestasAPregunta($pregunta['IdPregunta']);
          $clsCNConsultas->ActualizaLeidosRespuestas($respApregunta);
          if(is_array($respApregunta)){
            echo '<br/>';  
            echo '<div align="right">';  
            echo '<table border="0" class="tablaComentarios" width="99%">';
            echo '<tbody>';
            echo '<tr>';
            echo '<td style="text-align: left;" valign="bottom">Respuestas</td>';
            foreach($respApregunta as $respuesta){
              echo '<tr>';
              //busco los datos del usuario
              $datosUsuario=$clsCNUsu->DatosUsuario($respuesta['IdUsuario']);
              if(substr($respuesta['Puesto'],0,6)==='Asesor'){
                  //es asesor
                  echo '<td class="respBgColorAsesor">';
              }else{
                  //es cliente
                  echo '<td class="respBgColorCliente">';
              }
              echo '<table width="100%" border="0" class="tablaComentariosDatos">';
              echo '<tr>';
              echo '<td>';
              echo '<div align="left">';
              echo '<b>'.$datosUsuario['strNombre'].' '.$datosUsuario['strApellidos'].'</b>';
              echo '</div>';
              echo '</td>';
              echo '<td>';
              echo '<div align="right">';
              echo ''.$respuesta['Fecha'].'<br/>';
              $leidoR='<font color="red">Sin Leer</font>';
              if($respuesta['Leido']==1){$leidoR='Leido';}
              echo ''.$leidoR.'';
              echo '</div>';
              echo '</td>';
              echo '</tr>';
              echo '</table>';
              echo '<hr class="lineaSeparacion" />';
              echo '<br/>';
              echo '<p class="tablaComentariosDatosB">'.$respuesta['strRespuesta'].'</p><br/><br/>';
              //compruebo si hay documento adjuntado, si hay presento el ancla para poder verlo
              if($respuesta['url']<>''){
                  //es cliente, indicamos el ancla con ver documento adjunto
                  if(substr($_SESSION['cargo'],0,6)<>'Asesor'){
                    ?>
                    <a class="textbox1 tablaComentariosDatosB" href="#" onclick='abreDoc("<?php echo $respuesta['url']; ?>");'>Ver Documento Adj</a><br/><br/>
                    <?php
                  }else{
                    //extraigo el nombre del fichero de la url  
                    $url=explode('/',$respuesta['url']);
                    $num=count($url);
                    $fichero=$url[$num-1];
                    ?>
                    <a class="textbox1 tablaComentariosDatosB" href="#" onclick='abreDoc("<?php echo $respuesta['url']; ?>");'>Ver Documento Adj</a><br/><br/>
                    <?php
                  }
              }else if($respuesta['link']<>''){
                  //es cliente, indicamos el ancla con ver documento adjunto
                  if(substr($_SESSION['cargo'],0,6)<>'Asesor'){
                    ?>
                    <a class="textbox1 tablaComentariosDatosB" href="#" onclick='abreDoc("<?php echo $respuesta['link']; ?>");'>Ver Documento Adj</a><br/><br/>
                    <?php
                  }else{
                    //extraigo el nombre del fichero de la url  
                    $url=explode('/',$respuesta['link']);
                    $num=count($url);
                    $fichero=$url[$num-1];
                    ?>
                    <a class="textbox1 tablaComentariosDatosB" href="#" onclick='abreDoc("<?php echo $respuesta['link']; ?>");'><?php echo $fichero;?></a><br/><br/>
                    <?php
                  }
              }
              echo '</td>';
              echo '</tr>';
              echo '<tr>';
              echo '<td height="15px">';
              echo '</td>';
              echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
            $numP++;
          }
            if(substr($_SESSION['cargo'],0,6)<>'Asesor'){//ASESOR
                if($pregunta['Estado']==='Cerrada'){//Estado='Cerrada' o Leido=9 (pregunta del asesor)
                    echo '<br/>';
                }else{
                    echo '<input type="button" class="button" value="Añadir" onclick="abreFormRespuesta('.$pregunta['IdPregunta'].');"/>';
                }
            }else{
                echo '<input type="button" class="button" value="Añadir" onclick="abreFormRespuesta('.$pregunta['IdPregunta'].');"/>';
            }
            echo '<div id="resp'.$pregunta['IdPregunta'].'" style="display:none;">';
            ?>        
            <form name="formRespuesta" enctype="multipart/form-data" id="formRespuesta<?php echo $pregunta['IdPregunta'];?>" method="post" action="../vista/consulta_asesor.php">
            <table width="100%" border="0">
              <tr> 
                <td align="left" colspan="4">
                    <label style="font-size: 0.8em;">Nueva Respuesta</label>
                    <textarea class="textbox1area" name="strRespuesta" rows=4 
                              cols="20" onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                              onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"></textarea> 
                </td>
              </tr>
              <tr>
                  <td width="200" class="nombreCampo">Usuario:<br/> <?php echo $datosUsuarioActivo['strNombre'].' '.$datosUsuarioActivo['strApellidos'] ; ?></td>
                  <td width="150" class="nombreCampo">
                    <?php date_default_timezone_set('Europe/Madrid'); ?>
                    Fecha:<br/> <?php print date("d/m/y"); ?>
                  </td>
                  <td align="left">
                      <?php if(substr($_SESSION['cargo'],0,6) === 'Asesor'){?>
                      <script type="text/javascript">        
                        function nombreDocumento(val1){
                            document.getElementById('text_fileResp').value = val1;
                        }
                      </script>
                      <input type="button" class="button" value="Adjuntar Documento" name="btnAdjunto" onClick="AddAdj();" />
                      <input type="button" class="button" value="Borrar" name="btnBorrar" onClick="BorraAdj();" /><br/>
                      <input type="text" class="textbox1" name="fileResp" id="text_fileResp" readonly />
                      <input type="button" name="btnRespuesta" id="btn<?php echo $numP;?>" class="button" value = "Enviar" onclick="validarRespuesta(<?php echo $pregunta['IdPregunta'];?>,'SI');"/>
                      <?php }else{ ?>
                      <input type="file" class="file" id="docResp<?php echo $pregunta['IdPregunta'];?>" name="docResp" onchange="check_fileRespuesta(this.value,'txt_file<?php echo $pregunta['IdPregunta'];?>');" /><br/>
                      <span style="font-size: 0.8em;" id="txt_file<?php echo $pregunta['IdPregunta'];?>">El documento debe ser PDF y no superior a 1 MB</span><br/>
                      <input type="button" name="btnRespuesta" id="btn<?php echo $numP;?>" class="button" value = "Enviar" onclick="validarRespuesta(<?php echo $pregunta['IdPregunta'];?>,'NO');"/>
                      <?php } ?>
                      <input type="hidden" name="cmdAltaRespuesta" value="<?php echo $pregunta['IdPregunta'];?>" />
                      <input type="hidden" name="esAsesor" value="<?php if(isset($idPregunta)){echo 'SI';}else{echo 'NO';}?>" />
                      <input type="hidden" name="Usuario" value="<?php echo $pregunta['Usuario'];?>" />
                      <img id="loading<?php echo $pregunta['IdPregunta'];?>" src="../images/cargar.gif" width="25" height="25" style="display:none" />
                  </td>
              </tr>
            </table>
            </form>
            <?php
            echo '</div>';
          echo '</div>';
          echo '</td>';
          echo '</tr>';
          echo '<tr>';
          echo '<td style="height: 15px;">';
          echo '</td>';
          echo '</tr>';
//          if($classLinea=='class="impares"'){
//              $classLinea='class="pares"';
//          }else{
//              $classLinea='class="impares"';
//          }
          $numP++;
      }
    }
    ?>
    </tbody>
    </table>
    
  </div>  
</center>

   </td>
   <!-- contenido pagina -->
  </tr>
  </table>
</td>
    <td  width="40%" height="100%" border="0" alt=""  ></td>
  </tr>
<!-- presentacion-->   
</table>
<?php
//por ultimo actualizo las prguntas leidas (al presentarlas ya se consideran leidas por el usuario)
$clsCNConsultas->actualizaLeidosPreguntas($preguntas);

}//fin 





function html_pagina($errorFile,$txtActualizado,$datosUsuarioActivo){
$clsCNConsultas=new clsCNConsultas();
$clsCNConsultas->setStrBD($_SESSION['dbContabilidad']);
$clsCNUsu=new clsCNUsu();
$clsCNUsu->setStrBD($_SESSION['dbContabilidad']);
?>
<!DOCTYPE html>
<HTML>
<HEAD>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../images/q.ico">
<TITLE>Comentario - SOLUCIÓN</TITLE>

<!--            HE INCLUIDO AQUI ESTAS LIBRERIAS DE jQuery PACO-->
<script src="https://code.jquery.com/jquery-1.8.3.js"></script>
<script src="../js/jQuery/js/jquery.dataTables.qualidad.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />

<link rel="stylesheet" href="../js/jQuery/css/jquery-ui.qualidad.css" />
<script src="https://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
<script src="../js/jQuery/ui/jquery.blockUI.js"></script>

<style type="text/css">
    @import "../js/jQuery/css/demo_table_jui.css";
    @import "../js/jQuery/themes/smoothness/jquery-ui-1.8.4.custom.css";
    @import "../js/jQuery/css/table_qualidad.css";
</style>
<!--       FIN     HE INCLUIDO AQUI ESTAS LIBRERIAS DE jQuery PACO-->

<link href="../js/jQuery/input-file/jquery.file.css" rel="stylesheet" type="text/css" />
<script src="../js/jQuery/input-file/jquery.file.js" type="text/javascript"></script>

<script language="JavaScript">
    
function validarRespuesta(num,esAsesor)
{
  esValido=true;
  textoError='';
  objetotxt="txt_file"+num;
  
  if(esAsesor=='NO'){
    //compruebo que no haya error en el span AJAX (de la carga del fichero)
    if ((document.getElementById(objetotxt).innerHTML.indexOf('Nombre de fichero existe ya')!=-1) ||
        (document.getElementById(objetotxt).innerHTML.indexOf('Este fichero NO es PDF')!=-1)){
      textoError=textoError+"El fichero a adjuntar no es correcto.\n";
      esValido=false;
    }
  }
  
  nameForm='formRespuesta'+num;

  //comprobacion del campo 'strRespuesta'
  if (document.getElementById(nameForm).strRespuesta.value==''){ 
    textoError=textoError+"Hay que rellenar la respuesta.\n";
    document.getElementById(nameForm).strRespuesta.style.borderColor='#FF0000';
    document.getElementById(nameForm).strRespuesta.title ='Hay que rellenar la respuesta.';
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
          
      document.getElementById(nameForm).btnRespuesta.value="Enviando...";
      document.getElementById(nameForm).btnRespuesta.disabled=true;
      document.getElementById(nameForm).submit();
  }else{
      return false;
  }  
}

function validarConsulta(num){
  
  esValido=true;
  textoError='';

  //compruebo que no haya error en el span AJAX (de la carga del fichero)
  if ((document.getElementById("txt_file").innerHTML.indexOf('Nombre de fichero existe ya')!=-1) ||
      (document.getElementById("txt_file").innerHTML.indexOf('Este fichero NO es PDF')!=-1)){
    textoError=textoError+"El fichero a adjuntar no es correcto.\n";
    esValido=false;
  }
     
  //comprobacion del campo 'strConsulta'
  if (document.formConsulta.strConsulta.value == ''){ 
    textoError=textoError+"Hay que rellenar la consulta.\n";
    document.formConsulta.strConsulta.style.borderColor='#FF0000';
    document.formConsulta.strConsulta.title ='Hay que rellenar la consulta.';
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
      
      //para que salga el gif de subir en las respuestas  
      if(document.getElementById('doc').value.length>0){
          document.getElementById('loading').style.display='inline';
      }
      
      document.formConsulta.cmdAltaConsulta.value='Aceptar';
      document.formConsulta.btnConsulta.value="Enviando...";
      document.formConsulta.btnConsulta.disabled=true;
      document.formConsulta.submit();
  }else{
      return false;
  }  
}

function abreListado(IdPregunta){
    var elemento='div'+IdPregunta;
    if(document.getElementById(elemento).style.display=='block'){
        document.getElementById(elemento).style.display='none';
    }else{
        document.getElementById(elemento).style.display='block';
    }    
}

function abreFormRespuesta(IdPregunta){
    var elemento='resp'+IdPregunta;
    if(document.getElementById(elemento).style.display=='block'){
        document.getElementById(elemento).style.display='none';
    }else{
        document.getElementById(elemento).style.display='block';
    }    
}

function abreDoc(url){
    //si viene texto es la url del doc, lo abrimos en una nueva ventana
    if(url!=''){
        window.open(url);
    }
}

$(document).ready(function() {
        $("input.file").file();
});

//AJAX jQuery chequea cuenta exista en la BD
function check_fileRespuesta(file,objeto){
    $.ajax({
      data:{"file":file},  
      url: '../vista/ajax/buscar_file.php',
      type:"get",
      success: function(data) {
        $('#'+objeto).html(data);
      }
    });
}

//AJAX jQuery chequea cuenta exista en la BD
function check_fileConsulta(file){
    $.ajax({
      data:{"file":file},  
      url: '../vista/ajax/buscar_file.php',
      type:"get",
      success: function(data) {
        $('#txt_file').html(data);
      }
    });
}

function AddAdj() 
{
  window.open ("../vista/tree_resp.php","nueva","resizable=yes, scrollbars=yes, width=650,height=450");
}

function BorraAdj() 
{
    document.getElementById('text_fileResp').value = '';
}


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
<!--<SCRIPT language="JavaScript" SRC="/include/frames.js"></SCRIPT>-->
<script languaje="JavaScript"  type="text/JavaScript">
<!--
function Modificar(menu)
{

		document.form1.strTipReclamacion.value = menu.options[menu.selectedIndex].text
}
//-->
</script>
<!--<SCRIPT LANGUAGE="JavaScript" SRC="../js/valida.js">

	alert('Error en el fichero valida.js');
// 
</SCRIPT>-->
<link href="../css/Estilos_Qualidad.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../css/calidad2.css" type="text/css">
<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
    eventosInputText();
?>
</HEAD>
<!--<SCRIPT language="JavaScript" SRC="../js/car_valido.js">

</SCRIPT>-->
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
clock.innerHTML = movingtime;
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

<BODY bgColor=#ffffff leftMargin=0 topMargin=0 rightMargin=0 bottomMargin=0 marginwidth="0" marginheight="0"  background="<?php echo FONDO; ?>" 
      onLoad="rotulo_status();">
<!--    <div class="blocker" style="display:none;"></div>-->
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<!-- Cabecera-->
  <tr>
  <td width="40%" height="100%" border="0"></td>
   <td  width="780" height="35" border="0" alt="" bgcolor="#FFFFFF"  class="Text2">
       
       
   <table border="<?php echo MARCO_BORDER; ?>" cellpadding="0" cellspacing="0" width="780">

   <tr>
   <!-- contenido pagina -->
   <td width="768" height="854" border="0" alt="" valign="top">
   <br><p></p>

<center>
    
<?php
$tituloForm="CONSULTAS AL ASESOR";
$cabeceraNumero='0402';
$paginaForm='';
//require_once 'CodFormat.php';
//$codFormat=new CodFormat();
//$codFormat->setStrBD($_SESSION['mapeo']);
//$formatoForm=$codFormat->SelectFormato(62);
//$numeroForm=$datosReclamacion['strReclamacion'];
$disabledForm='disabled';
date_default_timezone_set('Europe/Madrid');
$fechaForm=date('d/m/Y');
require_once 'cabeceraForm.php';
?>
  <div class="doc"> 
    <hr color = "#FF9900">
      
    <br/><br/>

    <b class="fileError">
        <?php
        if(isset($errorFile) && $errorFile<>''){
        ?>
        <script languaje="JavaScript">
        $.blockUI(
          {message:'<?php echo $errorFile;?>',
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
        setTimeout($.unblockUI, 2000);    
        </script>
        <?php
        }
        ?>
    </b><br/>
        
    
<!--    <label class="subtitulo" onclick="onOff();">Comentarios...</label>-->
    <?php 
    //extraigo las consultas
    if(isset($_GET['IdPregunta'])){
        $preguntas=$clsCNConsultas->leePreguntas($_GET['IdPregunta']);
    }else{
        $preguntas=$clsCNConsultas->leePreguntas(0);
    }
    if(substr($_SESSION['cargo'],0,6)==='Asesor'){
//    if(isset($_GET['IdPregunta'])){
    ?>
    <form name="formActualizar" method="get" action="../vista/consulta_asesor.php">
    <table class="filtro" align="center" border="0" width="300">
    <tr> 
      <td class="nombreCampo"><div align="right">Clasificación:</div></td>
      <td colspan="2" width="250">
          <div align="right">
              <select name="strClasificacion" class="textbox1"
                      onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);">
                    <option value = "" <?php if($preguntas[0]['Clasificacion']==''){echo $preguntas[0]['Clasificacion'];}?>></option>
                    <option value = "Contable"
                            <?php
                            if($preguntas[0]['Clasificacion']=='Contable'){
                                echo ' selected';
                            }
                            ?>
                            >Contable</option>
                    <option value = "Fiscal"
                            <?php
                            if($preguntas[0]['Clasificacion']=='Fiscal'){
                                echo ' selected';
                            }
                            ?>
                            >Fiscal</option>
                    <option value = "Laboral"
                            <?php
                            if($preguntas[0]['Clasificacion']=='Laboral'){
                                echo ' selected';
                            }
                            ?>
                            >Laboral</option>
                    <option value = "Mercantil"
                            <?php
                            if($preguntas[0]['Clasificacion']=='Mercantil'){
                                echo ' selected';
                            }
                            ?>
                            >Mercantil</option>
                    <option value = "Técnico"
                            <?php
                            if($preguntas[0]['Clasificacion']=='Técnico'){
                                echo ' selected';
                            }
                            ?>
                            >Técnico</option>
              </select>
          </div>
      </td>
    </tr>
    <tr> 
      <td class="nombreCampo"> <div align="right">Estado:</div></td>
      <td colspan="2">
          <div align="right">
              <select name="strEstado" class="textbox1"
                      onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);">
                    <?php
                    //si esta en estado 'Cerrada' no habilito el combo, para los demas estados si
                    if($preguntas[0]['Estado']<>'Cerrada'){
                    ?>
                    <option value = "" <?php if($preguntas[0]['Estado']==''){echo 'selected';}?>></option>
                    <option value = "Abierto"
                            <?php
                            if($preguntas[0]['Estado']=='Abierto'){
                                echo ' selected';
                            }
                            ?>
                            >Abierto</option>
                    <option value = "En Curso"
                            <?php
                            if($preguntas[0]['Estado']=='En Curso'){
                                echo ' selected';
                            }
                            ?>
                            >En Curso</option>
                    <option value = "Respondida"
                            <?php
                            if($preguntas[0]['Estado']=='Respondida'){
                                echo ' selected';
                            }
                            ?>
                            >Respondida</option>
                    <?php } ?>
                    <option value = "Cerrada"
                            <?php
                            if($preguntas[0]['Estado']=='Cerrada'){
                                echo ' selected';
                            }
                            ?>
                            >Cerrada</option>
              </select>
          </div>
      </td>
    </tr>
    <tr> 
      <td colspan="8"><hr align="left"></td>
    </tr>
     <tr align="center">
         <td colspan="8">
             <input type="Reset" class="button" value="Vaciar Datos" name="cmdReset"/>
             <input type="submit" class="button" value="Actualizar" name="cmdConsultar"  />
             <input name="cmdActualizar" type="hidden" value="OK"/>
             <input name="IdPregunta" type="hidden" value="<?php echo $_GET['IdPregunta'];?>"/><br/>
             <b style="font-size: 15px;"><?php if(isset($txtActualizado)){echo $txtActualizado;}?></b><br/>
         </td>
     </tr>
    </table>
    </form>
    <br/><br/>
    <?php
    }
    ?>
    
    <?php
    //este formulario para añadir preguntas se presenta si somos clientes
    //si somos ASESOR no (se comprueba por el $_GET['IdPregunta']
    if(!isset($_GET['IdPregunta'])){ //if
    ?>
    <form name="formConsulta" enctype="multipart/form-data" method="post" action="../vista/consulta_asesor.php">
    <table width="640" border="0" class="zonaactiva">
      <tr> 
        <td colspan="4" class="subtitulo">Nueva Consulta</td>
      </tr>
      <tr> 
        <td colspan="4">
            <textarea class="textbox1area" name="strConsulta" rows=4 
                      cols="20" onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                      onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"><?php if(isset($_POST['strConsulta'])){echo $_POST['strConsulta'];}?></textarea> 
        </td>
      </tr>
      <tr>
          <td width="200" class="nombreCampo">Usuario:<br/> <?php echo $datosUsuarioActivo['strNombre'].' '.$datosUsuarioActivo['strApellidos'] ; ?></td>
          <td width="50" class="nombreCampo">
            <?php date_default_timezone_set('Europe/Madrid'); ?>
            Fecha:<br/> <?php print date("d/m/y"); ?>
          </td>
          <td width="20"></td>
          <td align="left">
              <input type="file" class="file" id="doc" name="doc" onchange="check_fileConsulta(this.value);" /><br/>
              <span class="nombreCampo" id="txt_file">El documento debe ser PDF y no superior a 1 MB</span><br/>
              <input type="button" name="btnConsulta" class="button" value = "Enviar" onclick="validarConsulta(<?php if(isset($respApregunta)) {echo count($respApregunta);}else{echo '0';}?>);"/>
              <input type="hidden" name="cmdAltaConsulta" />
              <img id="loading" src="../images/cargar.gif" width="25" height="25" style="display:none" />
          </td>
      </tr>
        <tr>
            <td height="15x"></td>
        </tr>
    </table>
    </form>
    <?php
    } //fin if
    ?>
    
    <br/><br/>
    
    <table width="640" border="0" class="tablaComentarios" cellspacing="10px">
    <tr class="subtitulo">
    <td colspan="4" style="text-align: left;">Consultas</td>
    <tbody>
    </tr>
    <?php
    //print_r($preguntas);
    //compruebo que vuelva un listado (es un array)
    if(is_array($preguntas)){
      //ahora presento los datos en la tabla
      $numP=1;
      foreach ($preguntas as $pregunta) {
          //averiguo si es Usuario o Asesor
          if(substr($pregunta['strPuesto'],0,7)==='Usuario'){
              $classLinea='class="impares"';
          }else{
              $classLinea='class="pares"';
          }
          echo "<tr $classLinea>";
//          echo '<td class="icono" style="background-color: #f3f4d7;">';
//          echo "<img src='../images/comentarios.png' height='42' width='42' onclick='abreListado(".$pregunta['IdPregunta'].");'>";
//          echo '</td>';
          echo '<td class="preguntaTD">';
          echo '<table width="100%" border="0" class="tablaComentariosDatos">';
          echo '<tr>';
          echo '<td>';
          echo '<div align="left">';
          if(substr($pregunta['strPuesto'],0,6)==='Asesor'){
              echo '<b style="color: #000000;">Comunicado</b><br/>';
              echo '<b style="color: #000000;">'.$pregunta['Usuario'].'</b>';
          }else{
              echo '<b>'.$pregunta['Usuario'].'</b>';
          }
          echo '</div>';
          echo '</td>';
          echo '<td>';
          echo '<div align="right">';
          //formateamos la fecha (viene DATETIME Ej:2015-01-26 09:45:28)
          $fechaBuena = explode(' ',$pregunta['Fecha']);
          $fechaBuenaD = explode('-',$fechaBuena[0]);
          $fechaBuenaD = $fechaBuenaD[2] . '/' . $fechaBuenaD[1] . '/' . $fechaBuenaD[0];
          $fechaBuenaH = substr($fechaBuena[1],0,-3);
          $fechaBuena = $fechaBuenaD . ' '. $fechaBuenaH;
          if(substr($_SESSION['cargo'],0,6)<>'Asesor'){
              echo '<font style="color: #000000;">'.$fechaBuena.'</font><br/>';
          }else{
              echo ''.$fechaBuena.'<br/>';
          }
          if(substr($_SESSION['cargo'],0,6)<>'Asesor'){
            $leidoR='<font color="red">Sin Leer</font>';
            if($pregunta['Leido']==='9'){
                //busco si esta leida esta pregunta por el usuario
                $leidoResp=$clsCNConsultas->LeerLeidoPreguntaAsesorUsuario($pregunta['IdPregunta'],$_SESSION['usuario']);
                if($leidoResp==='1'){
                    $leidoR='Leido';
                }
            }else if($pregunta['Leido']==1){
              $leidoR='Leido';
            }
            echo ''.$leidoR.'';
          }
          echo '</div>';
          echo '</td>';
          echo '</tr>';
          if(substr($_SESSION['cargo'],0,6)==='Asesor'){//ASESOR 
            echo '<tr>';
            echo '<td>';
            echo '<div align="left">';
            echo '<b>'.$pregunta['Clasificacion'].'</b>';
            echo '</div>';
            echo '</td>';
            echo '<td>';
            echo '<div align="right">';
            echo '<font>'.$pregunta['Estado'].'</font>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
          }
          echo '</table>';
          echo '<hr class="lineaSeparacion" />';
          echo '<br/>';
          echo '<p class="tablaComentariosDatosB">'.str_replace("\r\n","<br/>",$pregunta['Pregunta']).'</p><br/><br/>';
          //compruebo si hay documento adjuntado, si hay presento boton para poder verlo
          if($pregunta['url']<>''){
          ?>
          <a class="textbox1 tablaComentariosDatosB" href="#" onclick='abreDoc("<?php echo $pregunta['url']; ?>");'>Ver Documento Adj</a><br/><br/>
          <?php
          }
          echo '<div id="div'.$pregunta['IdPregunta'].'" style="display:block;">';
          //aqui van las respuesta y un pequeño formulario para indicar mas respuestas
          //primero busco las respuestas de la BBDD
          $respApregunta=$clsCNConsultas->leeRespuestasAPregunta($pregunta['IdPregunta']);
          $clsCNConsultas->ActualizaLeidosRespuestas($respApregunta);
          if(is_array($respApregunta)){
            echo '<br/>';  
            echo '<div align="right">';  
            echo '<table border="0" class="tablaComentarios" width="99%">';
            echo '<tbody>';
            echo '<tr>';
            echo '<td style="text-align: left;" valign="bottom">Respuestas</td>';
            foreach($respApregunta as $respuesta){
              echo '<tr>';
              //busco los datos del usuario
              $datosUsuario=$clsCNUsu->DatosUsuario($respuesta['IdUsuario']);
              if(substr($respuesta['Puesto'],0,6)==='Asesor'){
                  //es asesor
                  echo '<td class="respBgColorAsesor">';
              }else{
                  //es cliente
                  echo '<td class="respBgColorCliente">';
              }
              echo '<table width="100%" border="0" class="tablaComentariosDatos">';
              echo '<tr>';
              echo '<td>';
              echo '<div align="left">';
              echo '<b>'.$datosUsuario['strNombre'].' '.$datosUsuario['strApellidos'].'</b>';
              echo '</div>';
              echo '</td>';
              echo '<td>';
              echo '<div align="right">';
              echo ''.$respuesta['Fecha'].'<br/>';
              $leidoR='<font color="red">Sin Leer</font>';
              if($respuesta['Leido']==1){$leidoR='Leido';}
              echo ''.$leidoR.'';
              echo '</div>';
              echo '</td>';
              echo '</tr>';
              echo '</table>';
              echo '<hr class="lineaSeparacion" />';
              echo '<br/>';
              echo '<p class="tablaComentariosDatosB">'.$respuesta['strRespuesta'].'</p><br/><br/>';
              //compruebo si hay documento adjuntado, si hay presento el ancla para poder verlo
              if($respuesta['url']<>''){
                  //es cliente, indicamos el ancla con ver documento adjunto
                  if(substr($_SESSION['cargo'],0,6)<>'Asesor'){
                    ?>
                    <a class="textbox1 tablaComentariosDatosB" href="#" onclick='abreDoc("<?php echo $respuesta['url']; ?>");'>Ver Documento Adj</a><br/><br/>
                    <?php
                  }else{
                    //extraigo el nombre del fichero de la url  
                    $url=explode('/',$respuesta['url']);
                    $num=count($url);
                    $fichero=$url[$num-1];
                    ?>
                    <a class="textbox1 tablaComentariosDatosB" href="#" onclick='abreDoc("<?php echo $respuesta['url']; ?>");'>Ver Documento Adj</a><br/><br/>
                    <?php
                  }
              }else if($respuesta['link']<>''){
                  //es cliente, indicamos el ancla con ver documento adjunto
                  if(substr($_SESSION['cargo'],0,6)<>'Asesor'){
                    ?>
                    <a class="textbox1 tablaComentariosDatosB" href="#" onclick='abreDoc("<?php echo $respuesta['link']; ?>");'>Ver Documento Adj</a><br/><br/>
                    <?php
                  }else{
                    //extraigo el nombre del fichero de la url  
                    $url=explode('/',$respuesta['link']);
                    $num=count($url);
                    $fichero=$url[$num-1];
                    ?>
                    <a class="textbox1 tablaComentariosDatosB" href="#" onclick='abreDoc("<?php echo $respuesta['link']; ?>");'><?php echo $fichero;?></a><br/><br/>
                    <?php
                  }
              }
              echo '</td>';
              echo '</tr>';
              echo '<tr>';
              echo '<td height="15px">';
              echo '</td>';
              echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
            $numP++;
          }
            if(substr($_SESSION['cargo'],0,6)<>'Asesor'){//ASESOR
                if($pregunta['Estado']==='Cerrada'){//Estado='Cerrada' o Leido=9 (pregunta del asesor)
                    echo '<br/>';
                }else{
                    echo '<input type="button" class="button" value="Añadir" onclick="abreFormRespuesta('.$pregunta['IdPregunta'].');"/>';
                }
            }else{
                echo '<input type="button" class="button" value="Añadir" onclick="abreFormRespuesta('.$pregunta['IdPregunta'].');"/>';
            }
            echo '<div id="resp'.$pregunta['IdPregunta'].'" style="display:none;">';
            ?>        
            <form name="formRespuesta" enctype="multipart/form-data" id="formRespuesta<?php echo $pregunta['IdPregunta'];?>" method="post" action="../vista/consulta_asesor.php">
            <table width="100%" border="0">
              <tr> 
                <td align="left" colspan="4">
                    <label style="font-size: 0.8em;">Nueva Respuesta</label>
                    <textarea class="textbox1area" name="strRespuesta" rows=4 
                              cols="20" onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);"
                              onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);"></textarea> 
                </td>
              </tr>
              <tr>
                  <td width="200" class="nombreCampo">Usuario:<br/> <?php echo $datosUsuarioActivo['strNombre'].' '.$datosUsuarioActivo['strApellidos'] ; ?></td>
                  <td width="150" class="nombreCampo">
                    <?php date_default_timezone_set('Europe/Madrid'); ?>
                    Fecha:<br/> <?php print date("d/m/y"); ?>
                  </td>
                  <td align="left">
                      <?php if(isset($_GET['IdPregunta'])){?>
                      <script type="text/javascript">        
                        function nombreDocumento(val1){
                            document.getElementById('text_fileResp').value = val1;
                        }
                      </script>
                      <input type="button" class="button" value="Adjuntar Documento" name="btnAdjunto" onClick="AddAdj();" />
                      <input type="button" class="button" value="Borrar" name="btnBorrar" onClick="BorraAdj();" /><br/>
                      <input type="text" class="textbox1" name="fileResp" id="text_fileResp" readonly />
                      <input type="button" name="btnRespuesta" id="btn<?php echo $numP;?>" class="button" value = "Enviar" onclick="validarRespuesta(<?php echo $pregunta['IdPregunta'];?>,'SI');"/>
                      <?php }else{ ?>
                      <input type="file" class="file" id="docResp<?php echo $pregunta['IdPregunta'];?>" name="docResp" onchange="check_fileRespuesta(this.value,'txt_file<?php echo $pregunta['IdPregunta'];?>');" /><br/>
                      <span style="font-size: 0.8em;" id="txt_file<?php echo $pregunta['IdPregunta'];?>">El documento debe ser PDF y no superior a 1 MB</span><br/>
                      <input type="button" name="btnRespuesta" id="btn<?php echo $numP;?>" class="button" value = "Enviar" onclick="validarRespuesta(<?php echo $pregunta['IdPregunta'];?>,'NO');"/>
                      <?php } ?>
                      <input type="hidden" name="cmdAltaRespuesta" value="<?php echo $pregunta['IdPregunta'];?>" />
                      <input type="hidden" name="esAsesor" value="<?php if(isset($_GET['IdPregunta'])){echo 'SI';}else{echo 'NO';}?>" />
                      <input type="hidden" name="Usuario" value="<?php echo $pregunta['Usuario'];?>" />
                      <img id="loading<?php echo $pregunta['IdPregunta'];?>" src="../images/cargar.gif" width="25" height="25" style="display:none" />
                  </td>
              </tr>
            </table>
            </form>
            <?php
            echo '</div>';
          echo '</div>';
          echo '</td>';
          echo '</tr>';
          echo '<tr>';
          echo '<td style="height: 15px;">';
          echo '</td>';
          echo '</tr>';
//          if($classLinea=='class="impares"'){
//              $classLinea='class="pares"';
//          }else{
//              $classLinea='class="impares"';
//          }
          $numP++;
      }
    }
    ?>
    </tbody>
    </table>
    
    <input type="button" class="button" value="Volver" onclick="javascript:history.back();" />


  </div>  
</center>

   </td>
   <!-- contenido pagina -->
  </tr>
  </table>
</td>
    <td  width="40%" height="100%" border="0" alt=""  ></td>
  </tr>
<!-- presentacion-->   
</table>
</body>
</html>
<?php
//por ultimo actualizo las prguntas leidas (al presentarlas ya se consideran leidas por el usuario)
$clsCNConsultas->actualizaLeidosPreguntas($preguntas);

}//fin else principal

function html_paginaMobil($errorFile,$txtActualizado,$datosUsuarioActivo){
$clsCNConsultas=new clsCNConsultas();
$clsCNConsultas->setStrBD($_SESSION['dbContabilidad']);
$clsCNUsu=new clsCNUsu();
$clsCNUsu->setStrBD($_SESSION['dbContabilidad']);
?>
<!DOCTYPE html>
<html>
<head>
<TITLE>Comentario - SOLUCIÓN</TITLE>
<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>
<link rel="stylesheet" href="../css/estiloMovil.css" />

</head> 
    <body class="api jquery-mobile archive category category-widgets category-2 listing single-author">
    <div data-role="page" id="consultaAsesor">
<?php
eventosInputText();
?>
<script language="JavaScript">
    
function validarRespuesta(num,esAsesor)
{
  esValido=true;
  textoError='';
  objetotxt="txt_file"+num;
  
  if(esAsesor=='NO'){
    //compruebo que no haya error en el span AJAX (de la carga del fichero)
    if ((document.getElementById(objetotxt).innerHTML.indexOf('Nombre de fichero existe ya')!=-1) ||
        (document.getElementById(objetotxt).innerHTML.indexOf('Este fichero NO es PDF')!=-1)){
      textoError=textoError+"El fichero a adjuntar no es correcto.\n";
      esValido=false;
    }
  }
  
  nameForm='formRespuesta'+num;

  //comprobacion del campo 'strRespuesta'
  if (document.getElementById(nameForm).strRespuesta.value==''){ 
    textoError=textoError+"Hay que rellenar la respuesta.\n";
    document.getElementById(nameForm).strRespuesta.style.borderColor='#FF0000';
    document.getElementById(nameForm).strRespuesta.title ='Hay que rellenar la respuesta.';
    esValido=false;
  }
     
  //indicar el mensaje de error si es 'esValido' false
  if (!esValido){
          alert(textoError);
  }

  if(esValido==true){
      document.getElementById(nameForm).btnRespuesta.value="Enviando...";
      document.getElementById(nameForm).btnRespuesta.disabled=true;
      document.getElementById(nameForm).submit();
  }else{
      return false;
  }  
}

function validarConsulta(num){
  
  esValido=true;
  textoError='';

  //compruebo que no haya error en el span AJAX (de la carga del fichero)
  if ((document.getElementById("txt_file").innerHTML.indexOf('Nombre de fichero existe ya')!=-1) ||
      (document.getElementById("txt_file").innerHTML.indexOf('Este fichero NO es PDF')!=-1)){
    textoError=textoError+"El fichero a adjuntar no es correcto.\n";
    esValido=false;
  }
     
  //comprobacion del campo 'strConsulta'
  if (document.formConsulta.strConsulta.value == ''){ 
    textoError=textoError+"Hay que rellenar la consulta.\n";
    document.formConsulta.strConsulta.style.borderColor='#FF0000';
    document.formConsulta.strConsulta.title ='Hay que rellenar la consulta.';
    esValido=false;
  }
  
  //indicar el mensaje de error si es 'esValido' false
  if (!esValido){
          alert(textoError);
  }

  if(esValido==true){
      //para que salga el gif de subir en las respuestas  
      if(document.getElementById('doc').value.length>0){
          document.getElementById('loading').style.display='inline';
      }
      
      document.formConsulta.cmdAltaConsulta.value='Aceptar';
      document.formConsulta.btnConsulta.value="Enviando...";
      document.formConsulta.btnConsulta.disabled=true;
      document.formConsulta.submit();
  }else{
      return false;
  }  
}

function abreListado(IdPregunta){
    var elemento='div'+IdPregunta;
    if(document.getElementById(elemento).style.display=='block'){
        document.getElementById(elemento).style.display='none';
    }else{
        document.getElementById(elemento).style.display='block';
    }    
}

function abreFormRespuesta(IdPregunta){
    var elemento='resp'+IdPregunta;
    if(document.getElementById(elemento).style.display=='block'){
        document.getElementById(elemento).style.display='none';
    }else{
        document.getElementById(elemento).style.display='block';
    }    
}

function abreDoc(url){
    //si viene texto es la url del doc, lo abrimos en una nueva ventana
    if(url!=''){
        window.open(url);
    }
}

//AJAX jQuery chequea cuenta exista en la BD
function check_fileRespuesta(file,objeto){
    $.ajax({
      data:{"file":file},  
      url: '../vista/ajax/buscar_file.php',
      type:"get",
      success: function(data) {
        $('#'+objeto).html(data);
      }
    });
}

//AJAX jQuery chequea cuenta exista en la BD
function check_fileConsulta(file){
    $.ajax({
      data:{"file":file},  
      url: '../vista/ajax/buscar_file.php',
      type:"get",
      success: function(data) {
        $('#txt_file').html(data);
      }
    });
}

function AddAdj() 
{
    window.open ("../movil/tree_resp.php","nueva","resizable=yes, scrollbars=yes, width=650,height=450");
}

function BorraAdj() 
{
    document.getElementById('text_fileResp').value = '';
}

    
</script>

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>

    <div data-role="content" data-theme="a">

        <?php 
        //extraigo las consultas
        if(isset($_GET['IdPregunta'])){
            $preguntas=$clsCNConsultas->leePreguntas($_GET['IdPregunta']);
        }else{
            $preguntas=$clsCNConsultas->leePreguntas(0);
        }
        if(substr($_SESSION['cargo'],0,6)==='Asesor'){
        ?>
        <form name="formActualizar" method="get" action="../vista/consulta_asesor.php" data-ajax="false">
        <table border="0" style="width: 100%;">
            <tbody>
                <tr>
                    <td style="width: 22%;"></td>
                    <td style="width: 23%;"></td>
                    <td style="width: 23%;"></td>
                    <td style="width: 22%;"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label>Clasificación</label>
                    </td>
                    <td colspan="2">
                        <div align="right">
                            <select name="strClasificacion" data-native-menu="false" data-theme='a' data-mini="true">
                                  <option value = "" <?php if($preguntas[0]['Clasificacion']==''){echo 'selected';}?>></option>
                                  <option value = "Contable"
                                          <?php
                                          if($preguntas[0]['Clasificacion']=='Contable'){
                                              echo ' selected';
                                          }
                                          ?>
                                          >Contable</option>
                                  <option value = "Fiscal"
                                          <?php
                                          if($preguntas[0]['Clasificacion']=='Fiscal'){
                                              echo ' selected';
                                          }
                                          ?>
                                          >Fiscal</option>
                                  <option value = "Laboral"
                                          <?php
                                          if($preguntas[0]['Clasificacion']=='Laboral'){
                                              echo ' selected';
                                          }
                                          ?>
                                          >Laboral</option>
                                  <option value = "Mercantil"
                                          <?php
                                          if($preguntas[0]['Clasificacion']=='Mercantil'){
                                              echo ' selected';
                                          }
                                          ?>
                                          >Mercantil</option>
                                  <option value = "Técnico"
                                          <?php
                                          if($preguntas[0]['Clasificacion']=='Técnico'){
                                              echo ' selected';
                                          }
                                          ?>
                                          >Técnico</option>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label>Estado</label>
                    </td>
                    <td colspan="2">
                        <div align="right">
                            <select name="strEstado" data-native-menu="false" data-theme='a' data-mini="true">
                                  <?php
                                  //si esta en estado 'Cerrada' no habilito el combo, para los demas estados si
                                  if($preguntas[0]['Estado']<>'Cerrada'){
                                  ?>
                                  <option value = "" <?php if($preguntas[0]['Estado']==''){echo 'selected';}?>></option>
                                  <option value = "Abierto"
                                          <?php
                                          if($preguntas[0]['Estado']=='Abierto'){
                                              echo ' selected';
                                          }
                                          ?>
                                          >Abierto</option>
                                  <option value = "En Curso"
                                          <?php
                                          if($preguntas[0]['Estado']=='En Curso'){
                                              echo ' selected';
                                          }
                                          ?>
                                          >En Curso</option>
                                  <option value = "Respondida"
                                          <?php
                                          if($preguntas[0]['Estado']=='Respondida'){
                                              echo ' selected';
                                          }
                                          ?>
                                          >Respondida</option>
                                  <?php } ?>
                                  <option value = "Cerrada"
                                          <?php
                                          if($preguntas[0]['Estado']=='Cerrada'){
                                              echo ' selected';
                                          }
                                          ?>
                                          >Cerrada</option>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="Reset" data-theme="a"
                               data-mini="true" value="Vaciar Datos" name="cmdReset"/>
                    </td>
                    <td colspan="2">
                        <input type="submit" data-icon="check" data-theme="a"
                               data-mini="true" value="Actualizar" name="cmdConsultar"  />
                    </td>
                </tr>
            </tbody>
        </table>    
        <input name="cmdActualizar" type="hidden" value="OK"/>
        <input name="IdPregunta" type="hidden" value="<?php echo $_GET['IdPregunta'];?>"/><br/>
        <label><b style="font-size: 12px; text-align: center; color:#3ba5ba;"><i><?php if(isset($txtActualizado)){echo $txtActualizado;}?></i></b></label><br/><br/><br/>
        </form>
        <?php
        }
        
        //este formulario para añadir preguntas se presenta si somos clientes
        //si somos ASESOR no (se comprueba por el $_GET['IdPregunta']
        if(!isset($_GET['IdPregunta'])){ //if
        ?>
        <form name="formConsulta" enctype="multipart/form-data" method="post" action="../vista/consulta_asesor.php" data-ajax="false">
        <table border="0" style="width: 100%;">
            <tbody>
                <tr>
                    <td style="width: 22%;"></td>
                    <td style="width: 23%;"></td>
                    <td style="width: 23%;"></td>
                    <td style="width: 22%;"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label>Nueva Consulta</label>
                    </td>
                </tr>
                <tr> 
                  <td colspan="4">
                      <textarea name="strConsulta" rows=4 cols="20"
                                onfocus="onFocusInputTextM(this);"><?php if(isset($_POST['strConsulta'])){echo $_POST['strConsulta'];}?></textarea> 
                  </td>
                </tr>
                <tr>
                    <td colspan="4">Usuario: <?php echo $datosUsuarioActivo['strNombre'].' '.$datosUsuarioActivo['strApellidos'] ; ?></td>
                </tr>
                <tr>
                    <td colspan="4">
                      <?php date_default_timezone_set('Europe/Madrid'); ?>
                      Fecha: <?php print date("d/m/y"); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <input type="file" data-mini="true" class="file" id="doc" name="doc" onchange="check_fileConsulta(this.value);" /><br/>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <span class="nombreCampo" id="txt_file">El documento debe ser PDF y no superior a 1 MB</span><br/>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" height="20px"><hr/></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label>Subir Foto:</label>
                        <input type="file" data-mini="true" id="foto" name="foto" accept="image/*" capture="camera" /><br/>
                    </td>
                </tr>                
                <tr>
                    <td></td>
                    <td colspan="2">
                        <input type="button" data-mini="true" name="btnConsulta" class="button" value = "Enviar" onclick="validarConsulta(<?php if(isset($respApregunta)) {echo count($respApregunta);}else{echo '0';}?>);"/>
                        <input type="hidden" name="cmdAltaConsulta" />
                        <img id="loading" src="../images/cargar.gif" width="25" height="25" style="display:none" />
                    </td>
                </tr>
            </tbody>
        </table>
        </form>
        <br/>
        
    <?php
    } //fin if
    ?>
        
    <h3 align="center" color="#FFCC66"><font size="3px">Consultas</font></h3>
        
        <?php
    if(is_array($preguntas)){
      //ahora presento los datos en la tabla
      $numP=1;
      foreach ($preguntas as $pregunta) {
        ?>
        <div id="content-wrapper">
        <?php 
        if(substr($_SESSION['cargo'],0,6)<>'Asesor'){
          $leidoR='<font color="red">Sin Leer</font>';
          if($pregunta['Leido']==='9'){
              //busco si esta leida esta pregunta por el usuario
              $leidoResp=$clsCNConsultas->LeerLeidoPreguntaAsesorUsuario($pregunta['IdPregunta'],$_SESSION['usuario']);
              if($leidoResp==='1'){
                  $leidoR='Leido';
              }
          }else if($pregunta['Leido']==1){
            $leidoR='Leido';
          }
        }
        
        $fechaBuena = explode(' ',$pregunta['Fecha']);
        $fechaBuenaD = explode('-',$fechaBuena[0]);
        $fechaBuenaD = $fechaBuenaD[2] . '/' . $fechaBuenaD[1] . '/' . $fechaBuenaD[0];
        $fechaBuenaH = substr($fechaBuena[1],0,-3);
        $fechaBuena = $fechaBuenaD . ' '. $fechaBuenaH;
        if(substr($pregunta['strPuesto'],0,6)==='Asesor'){
            echo '<font style="color: #30a53b;"><small>Comunicado</small></font><br/>';
            echo '<font style="color: #30a53b;"><small>'.$pregunta['Usuario'].'</small></font><br/>';
            echo '<small>'.$fechaBuena.'</small><br/>';
            echo '<small>'.$leidoR.'</small><br/>';
            echo '<hr class="lineaSeparacion" />';
        }else{
            echo '<small>'.$pregunta['Usuario'].'</small><br/>';
            echo '<small>'.$fechaBuena.'</small><br/>';
            echo '<small>'.$leidoR.'</small><br/>';
            echo '<hr class="lineaSeparacion" />';
        }
        echo ''.$pregunta['Pregunta'].'<br/><br/>';
        
        //compruebo si hay documento adjuntado, si hay presento boton para poder verlo
        if($pregunta['url']<>''){
        ?>
        <a href="#" onclick='abreDoc("<?php echo $pregunta['url']; ?>");'>Ver Documento Adj</a><br/><br/>
        <?php
        }

        ?>
            
            
        <?php
            
        $respApregunta=$clsCNConsultas->leeRespuestasAPregunta($pregunta['IdPregunta']);
        $clsCNConsultas->ActualizaLeidosRespuestas($respApregunta);
        if(is_array($respApregunta)){
            echo '<i>Respuestas</i>';
            foreach($respApregunta as $respuesta){
                $datosUsuario=$clsCNUsu->DatosUsuario($respuesta['IdUsuario']);
                ?>
                <article id="post-2" class="hentry">
                <div class="entry-summary">
                <?php
                echo '<small>'.$datosUsuario['strNombre'].' '.$datosUsuario['strApellidos'].'</small><br/>';
                echo '<small>'.$respuesta['Fecha'].'</small><br/>';
                $leidoR='<font color="red">Sin Leer</font>';
                if($respuesta['Leido']==1){$leidoR='Leido';}
                echo '<small>'.$leidoR.'</small>';
                echo '<hr class="lineaSeparacion" />';
                echo '<small>'.$respuesta['strRespuesta'].'</small><br/><br/><br/>';
                //compruebo si hay documento adjuntado, si hay presento el ancla para poder verlo
                if($respuesta['url']<>''){
                    //es cliente, indicamos el ancla con ver documento adjunto
                    if(substr($_SESSION['cargo'],0,6)<>'Asesor'){
                      ?>
                      <a href="#" onclick='abreDoc("<?php echo $respuesta['url']; ?>");'>Ver Documento Adj</a><br/><br/>
                    <?php
                    }else{
                      //extraigo el nombre del fichero de la url  
                      $url=explode('/',$respuesta['url']);
                      $num=count($url);
                      $fichero=$url[$num-1];
                    ?>
                      <a href="#" onclick='abreDoc("<?php echo $respuesta['url']; ?>");'><?php echo $fichero;?></a><br/><br/>
                    <?php
                    }
                }else if($respuesta['link']<>''){
                    //es cliente, indicamos el ancla con ver documento adjunto
                    if(substr($_SESSION['cargo'],0,6)<>'Asesor'){
                      ?>
                      <a href="#" onclick='abreDoc("<?php echo $respuesta['link']; ?>");'>Ver Documento Adj</a><br/><br/>
                      <?php
                    }else{
                      //extraigo el nombre del fichero de la url  
                      $url=explode('/',$respuesta['link']);
                      $num=count($url);
                      $fichero=$url[$num-1];
                      ?>
                      <a href="#" onclick='abreDoc("<?php echo $respuesta['link']; ?>");'><?php echo $fichero;?></a><br/><br/>
                      <?php
                    }
                }
                
                
                ?>
                </div>
                </article>
            <?php
            }
            $numP++;
        }
        ?>
        <table border="0" style="width: 100%;">
            <tbody>
                <tr>
                    <td style="width: 22%;"></td>
                    <td style="width: 23%;"></td>
                    <td style="width: 23%;"></td>
                    <td style="width: 22%;"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <?php
                        if(substr($_SESSION['cargo'],0,6)<>'Asesor'){//ASESOR
                            if($pregunta['Estado']==='Cerrada'){//Estado='Cerrada' o Leido=9 (pregunta del asesor)
                                echo '<br/>';
                            }else{
                                echo '<input type="button" data-mini="true" value="Añadir" onclick="abreFormRespuesta('.$pregunta['IdPregunta'].');"/>';
                            }
                        }else{
                            echo '<input type="button" data-mini="true" value="Añadir" onclick="abreFormRespuesta('.$pregunta['IdPregunta'].');"/>';
                        }
                        ?>
                    </td>
                </tr>
          </tbody>
        </table>
        <?php
        echo '<div id="resp'.$pregunta['IdPregunta'].'" style="display:none;">';
        ?>
            
        <form name="formRespuesta<?php echo $pregunta['IdPregunta'];?>" enctype="multipart/form-data" id="formRespuesta<?php echo $pregunta['IdPregunta'];?>" method="post" action="../vista/consulta_asesor.php" data-ajax="false">
        <table border="0" style="width: 100%;">
            <tbody>
                <tr>
                    <td style="width: 22%;"></td>
                    <td style="width: 23%;"></td>
                    <td style="width: 23%;"></td>
                    <td style="width: 22%;"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label>Nueva Respuesta</label>
                    </td>
                </tr>
                <tr> 
                  <td colspan="4">
                      <textarea name="strRespuesta" rows=4 cols="20"
                                onfocus="onFocusInputTextM(this);"></textarea> 
                  </td>
                </tr>
                <tr>
                    <td colspan="4">Usuario: <?php echo $datosUsuarioActivo['strNombre'].' '.$datosUsuarioActivo['strApellidos'] ; ?></td>
                </tr>
                <tr>
                    <td colspan="4">
                      <?php date_default_timezone_set('Europe/Madrid'); ?>
                      Fecha: <?php print date("d/m/y"); ?>
                    </td>
                </tr>
                <?php if(isset($_GET['IdPregunta'])){?>
                <tr>
                    <td colspan="3">
                        <script type="text/javascript">        
                          function nombreDocumento(val1){
                              document.getElementById('text_fileResp').value = val1;
                          }
                        </script>
                        <input type="button" data-theme="a" data-mini="true" value="Adjuntar Documento" name="btnAdjunto" onClick="AddAdj();" />
                    </td>
                    <td colspan="1">
                        <input type="button" data-theme="a" data-mini="true" value="Borrar" name="btnBorrar" onClick="BorraAdj();" />
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <input type="text" class="textbox1" name="fileResp" id="text_fileResp" readonly />
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <input type="button" data-mini="true" name="btnRespuesta" id="btn<?php echo $numP;?>" value = "Enviar" onclick="validarRespuesta(<?php echo $pregunta['IdPregunta'];?>,'SI');"/>
                    </td>
                </tr>
                <?php }else{ ?>
                <tr>
                    <td colspan="4">
                        <input type="file" class="file" id="docResp<?php echo $pregunta['IdPregunta'];?>" name="docResp" onchange="check_fileRespuesta(this.value,'txt_file<?php echo $pregunta['IdPregunta'];?>');" />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <span style="font-size: 0.8em;" id="txt_file<?php echo $pregunta['IdPregunta'];?>">El documento debe ser PDF y no superior a 1 MB</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">Foto</td>
                </tr>
                <tr>
                    <td colspan="4">
                        <input type="file" class="file" id="docRespFoto<?php echo $pregunta['IdPregunta'];?>" name="docRespFoto" accept="image/*" capture="camera" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="button" data-mini="true" name="btnRespuesta" id="btn<?php echo $numP;?>" value = "Enviar" onclick="validarRespuesta(<?php echo $pregunta['IdPregunta'];?>,'NO');"/>
                    </td>
                </tr>
                <?php } ?>
                <input type="hidden" name="cmdAltaRespuesta" value="<?php echo $pregunta['IdPregunta'];?>" />
                <input type="hidden" name="esAsesor" value="<?php if(isset($_GET['IdPregunta'])){echo 'SI';}else{echo 'NO';}?>" />
                <input type="hidden" name="Usuario" value="<?php echo $pregunta['Usuario'];?>" />
          </tbody>
        </table>
        </form>
        
        
        <?php
        echo '</div>';
          
        ?>
        
        
        </div>
        <div style="height: 20px;"></div>
        <?php
      }
    }
    ?>
    </div>

    </div>    
    </body>
</html>
<?php
//por ultimo actualizo las prguntas leidas (al presentarlas ya se consideran leidas por el usuario)
$clsCNConsultas->actualizaLeidosPreguntas($preguntas);
}
?>