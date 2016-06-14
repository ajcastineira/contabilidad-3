<?php
require_once '../general/myLogger.php';

//constantes generales
//imagen de fondo
define('FONDO', "../images/fondo.jpg");
define('MARCO_BORDER', 0);
//Pagos a Cuenta=(Ingresos - gastos) x 20%
define('PAGOS_CUENTA', 20);//CREO QUE BORRAR 22/11/2013


//funcion para controlar la sesion en cada pagina, y el tiempo de expiración 
//(sino se accede en un tiempo determinado) de la pagina
function ControlaLoginTimeOut()
{
    if ($_SESSION["autentificado"] != "SI") { 
       //si no está logueado lo envío a la página de autentificación 
       header("Location: ../index.php?op=no"); 
       die;
    } else {
       $fechaGuardada = $_SESSION["ultimoAcceso"]; 
       $ahora = date("Y-n-j H:i:s"); 
       $tiempo_transcurrido = (strtotime($ahora)-strtotime($fechaGuardada)); 


       //comparamos el tiempo transcurrido 
       if($tiempo_transcurrido >= 1200) { //He puesto 20 minutos (20*60 segundos) 
         //si pasaron 10 minutos o más 
         session_destroy(); // destruyo la sesión 
         header("Location: ../index.php?op=tiempo"); //envío a la página de inicio 
         die;
         //sino, actualizo la fecha de la sesión 
       }else { 
         $_SESSION["ultimoAcceso"] = $ahora; 
       } 
    }
}


//funcion para preparar el número de la factura/pedido/presupuesto
function numeroFormateado($numero,$tipoContador){
    switch ($tipoContador) {
        case 'simple':
//            $numeroNuevoPresupuesto=$numero;
            
            //ahora formateo el numero de presupuesto para que tenga 4 cifras
            //$numPresupuesto=explode('/',$numero);

            while(strlen($numero)<4){
                $numero='0'.$numero;
            }
            $numeroNuevoPresupuesto=date('Y').$numero;
            break;
        case 'compuesto1':
            //ahora formateo el numero de presupuesto para que tenga 4 cifras
            $numPresupuesto=explode('/',$numero);

            while(strlen($numPresupuesto[0])<4){
                $numPresupuesto[0]='0'.$numPresupuesto[0];
            }
            $numeroNuevoPresupuesto=$numPresupuesto[1].$numPresupuesto[0];
            break;
        case 'compuesto2':
            //ahora formateo el numero de presupuesto para que tenga 4 cifras
            $numPresupuesto=explode('/',$numero);

            while(strlen($numPresupuesto[1])<4){
                $numPresupuesto[1]='0'.$numPresupuesto[1];
            }
            $numeroNuevoPresupuesto=$numPresupuesto[0].$numPresupuesto[1];
            break;
        default://ningun contador
            $numeroNuevoPresupuesto=$numero;
            break;
    }
    
    return $numeroNuevoPresupuesto;
}

//desformatear el número de la factura/pedido/presupuesto
function numeroDesformateado($numero,$tipoContador){
    switch ($tipoContador) {
        case 'simple':
            if($numero === null){
//                $numero = '0';
                $numero = date('Y').'0000';
                break;
            }
//            $numPresupuesto=$numero;
            
            
            $num=substr($numero,4,20);
            while(substr($num,0,1)==='0'){
                $num=substr($num,1);
            }
            $ejercicio=substr($numero,0,4);
            $numPresupuesto=$num;
            break;
        case 'compuesto1':
            if($numero === null){
                $numero = date('Y').'0000';
                break;
            }
            
            $num=substr($numero,4,20);
            while(substr($num,0,1)==='0'){
                $num=substr($num,1);
            }
            $ejercicio=substr($numero,0,4);
            $numPresupuesto=$num.'/'.$ejercicio;
            break;
        case 'compuesto2':
            if($numero === null){
                $numero = date('Y').'0000';
                break;
            }
            
            $num=substr($numero,4,20);
            while(substr($num,0,1)==='0'){
                $num=substr($num,1);
            }
            $ejercicio=substr($numero,0,4);
            $numPresupuesto=$ejercicio.'/'.$num;
            break;
        default://ningun contador
            if($numero === null){
                $numero = '0';
                break;
            }
            $numPresupuesto=$numero;
            break;
    }
    
    
    return $numPresupuesto;
}





////funcion para controlar la sesion en cada pagina, y el tiempo de expiración 
////(sino se accede en un tiempo determinado) de la pagina
//function ControlaLoginTimeOutMobil()
//{
//    $valido = 0;
//    if ($_SESSION["autentificado"] != "SI") { 
//       //si no está logueado lo envío a la página de autentificación 
//    } else {
//       $fechaGuardada = $_SESSION["ultimoAcceso"]; 
//       $ahora = date("Y-n-j H:i:s"); 
//       $tiempo_transcurrido = (strtotime($ahora)-strtotime($fechaGuardada)); 
//
//
//       //comparamos el tiempo transcurrido 
//       if($tiempo_transcurrido >= 6) { //Paco He puesto 10 minutos (10*60 segundos) 
//         //si pasaron 10 minutos o más 
//         session_destroy(); // destruyo la sesión 
//        $valido = -1;
//         //sino, actualizo la fecha de la sesión 
//       }else { 
//         $_SESSION["ultimoAcceso"] = $ahora; 
//        $valido = 1;
//       } 
//    }
//    
//    return $valido;
//}

//Control de errores de permisos
function ControlErrorPermiso(){
    
//    echo "ERROR DE BASE 2";
    //si no está logueado lo envío a la página de autentificación 
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../index.php">';
    
    
}

//Control de errores de permisos
function ControlAvisoPermiso(){
    
    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../'.$_SESSION['navegacion'].'/aviso.php">';
    
    
}


//Devuelve la página desde la que se invoca la petición. 
function dameURL(){
  
//$cadena=$_SERVER['REQUEST_URI']; 
//$maximo= strlen ($cadena);
//$ide= "vista/";
//$ide2= ".php";
//$total= strpos($cadena,$ide);
//$total2= stripos($cadena,$ide2);
//$total3= ($maximo-$total2-5);
//$final= substr ($cadena,$total,-$total3);

// return $final;
    return basename($_SERVER['PHP_SELF']);
}

function AccesoUsuarioPagina($strPagina, $strCargo){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($_SESSION['dbContabilidad']);
        $strSQL='SELECT ' . $strCargo . ' AS Cargo FROM tbpermisoscargos WHERE strPagina="' . $strPagina . '"';
        logger('warning',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " funcionesGenerales->AccesoUsuarioPagina($strPagina, $strCargo)|| SQL : ".$strSQL);
        $stmt = $db->ejecutar ( $strSQL );
        $db->desconectar ();
//        apaño momentaneo hasta que tenga toda la tabla tbpermisoscargos
//        return 1;
        
        if($stmt){
            $row=  mysql_fetch_array($stmt);
        logger('warning',basename($_SERVER['PHP_SELF']).'-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
               " funcionesGenerales->AccesoUsuarioPagina($strPagina, $strCargo)|| Cargo : ".$row['Cargo']);
            return $row['Cargo'];
        }else{
            return -1;
        }
}

function ControllingAccesoByStr($strPagina, $strCargo){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($_SESSION['dbContabilidad']);
        $strSQL='SELECT * tbcargopaginas WHERE strCargo = "' . $strCargo . '" and  strPagina = "' .  $strPagina  . '"';
        $stmt = $db->ejecutar ( $strSQL );
        $db->desconectar ();
        if($stmt){
            $row= mysql_fetch_array($stmt);
			 if(!mysql_fetch_array($row))
			 {
				return "KO";   // Si el usurio no tiene acceso entonces devolvemos "KO"
			 }else{
			      return "OK";  //Si el usuario tiene permiso entonces "OK"
			 }	
        
		}else{
            return -1;       //Si se ha producido un error en la conexión devolvemos -1. INTRODUCIR LOG ERROR 
			
        }
    }
	
function ControllingAccesoById($idPagina, $idCargo){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($_SESSION['dbContabilidad']);
        $strSQL='SELECT * tbCargoPaginas where lngCargo = ' . $idCargo . ' and  idPagina = ' .  $idPagina;
        $stmt = $db->ejecutar ( $strSQL );
        $db->desconectar ();
        
		if($stmt){
            $row=  mysql_fetch_array($stmt);
			if(!mysql_fetch_array($row))
			 {
				return "KO";   // Si el usurio no tiene acceso entonces devolvemos "KO"
			 }else{
			      return "OK";  //Si el usuario tiene permiso entonces "OK"
			 }	
        }else{
            return -1;
        }
    }
	
function DameIdCargoUsuario(){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($_SESSION['dbContabilidad']);
        $strSQL= 'SELECT lngId from tbcargos where strCargo = "' . $_SESSION['cargo'] . '"';
        $stmt = $db->ejecutar ( $strSQL );
        $db->desconectar ();
        
		if($stmt){
            $row=  mysql_fetch_array($stmt);
			if(!mysql_fetch_array($row))
			 {
				return $row['lngId'];;   // Si el usurio no tiene acceso entonces devolvemos "KO"
			 }else{
			      return "OK";  //Si el usuario tiene permiso entonces "OK"
			 }	
        }else{
            return -1;
        }
    }
	
	
//ENVIO DE MAILS
function EnviaEmail($destinos, $origen, $titulo, $mensaje, $copia, $copiaOculta){
/*	// Incluir varios destinatarios
	//$para  = 'aidan@example.com' . ', '; // atención a la coma
	//$para .= 'wez@example.com';
      $para = $destinos;
	// subject
	$titulo = 'Prueba Manuel';
	$titulo = $titulo;
	// message
	//$mensaje = '<html><head><title>Prueba Manu</title></head><body><p>¡Estos son los cumpleaños para Agosto!</p><table><tr><th>Quien</th><th>Día</th><th>Mes</th><th>Año</th></tr><tr>		  <td>Joe</td><td>3</td><td>Agosto</td><td>1970</td></tr><tr><td>Sally</td><td>17</td><td>Agosto</td><td>1973</td></tr></table></body></html>';
    $mensaje=$mensaje;
	
	// Para enviar un correo HTML mail, la cabecera Content-type debe fijarse
	$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $to = 'To: ' . $destinos . "\r\n";
	$from = 'From: ' . $origen . "\r\n";
	$copia = 'Cc: ' . $copia. "\r\n";
	$copiaOculta = 'Bcc: ' . $copiaOculta. "\r\n";
	
	$cabeceras .= $to . $from . $copia . $copiaOculta;
	
	// Cabeceras adicionales
	//$cabeceras .= 'To: manuel <manu@example.com>, Loza <loza@example.com>' . "\r\n";
	//$cabeceras .= 'From: Recordatorio <cumples@example.com>' . "\r\n";
	//$cabeceras .= 'Cc: birthdayarchive@example.com' . "\r\n";
	//$cabeceras .= 'Bcc: birthdaycheck@example.com' . "\r\n";
          
	// Mail it
	mail($para, $titulo, $mensaje, $cabeceras);*/
}


//funciones generales jQuery Mobile
//carga de librerias (tengo que buscar unas buenas para guardarlas en el proyecto)
function librerias_jQuery_Mobile(){
?>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
  
    
<!--    <link rel="stylesheet" type="text/css" href="../js/jqm/jquery.mobile-1.3.2.css">
    <script type="text/javascript" src="../js/jqm/jquery.mobile-1.3.2.min.js"></script>-->


    <!--themeroller-->
    <link rel="stylesheet" href="../css/themes/qualidad.css" />
    <link rel="stylesheet" href="../css/themes/jquery.mobile.icons.min.css" />
    
    <link rel="stylesheet" type="text/css" href="../js/jqm145/jquery.mobile-1.4.5.css">
    <script type="text/javascript" src="../js/jqm145/jquery.mobile-1.4.5.js"></script>

    <!--<link rel="stylesheet" href="../css/themes/jquery.mobile.icons.min.css" />-->
    
<?php
}

    

//funciones generales jQuery
//carga de librerias (tengo que buscar unas buenas para guardarlas en el proyecto)
function librerias_jQuery(){
?>
<!--<link rel="stylesheet" href="../css/jquery-ui.css" />
<script src="../js/jQuery/jquery-1.8.3.js"></script>
<script src="../js/jQuery/jquery-ui.js"></script> -->

<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
<script src="https://code.jquery.com/jquery-1.8.3.min.js"></script>
<script src="https://code.jquery.com/ui/1.10.0/jquery-ui.min.js"></script> 
<script src="https://ajax.cdnjs.com/ajax/libs/json2/20110223/json2.min.js"></script> 

<link rel="stylesheet" href="../js/jQuery/css/jquery-ui.qualidad.css" /><!-- PACO -->

<!-- Latest compiled and minified CSS -->
<!--<link rel="stylesheet" href="../js/bootstrap/css/bootstrap.min.css">-->

<!-- Latest compiled and minified JavaScript -->
<!--<script src="../js/bootstrap/js/bootstrap.min.js"></script>-->
<?php
}

//funciones generales jQuery
//carga de librerias (tengo que buscar unas buenas para guardarlas en el proyecto)
function librerias_jQuery_listado(){
?>
<script src="https://code.jquery.com/jquery-1.8.3.min.js"></script>
<script src="../js/jQuery/js/jquery.dataTables.qualidad.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />

<style type="text/css">
    @import "../js/jQuery/css/demo_table_jui.css";
    @import "../js/jQuery/themes/smoothness/jquery-ui-1.8.4.custom.css";
    @import "../js/jQuery/css/table_qualidad.css";
</style>

<script src="https://code.jquery.com/ui/1.10.0/jquery-ui.min.js"></script>
<script type="text/javascript" src="../js/jQuery/js/jquery.corner.js"></script>
<link rel="stylesheet" href="../js/jQuery/css/jquery-ui.qualidad.css" />

<!-- Latest compiled and minified CSS -->
<!--<link rel="stylesheet" href="../js/bootstrap/css/bootstrap.min.css">-->

<!-- Latest compiled and minified JavaScript -->
<!--<script src="../js/bootstrap/js/bootstrap.min.js"></script>-->
<?php
}


//datepicker español
function datepicker_español($id){
?>
<script language="JavaScript">
jQuery(function($){
   $.datepicker.regional['es'] = {
      closeText: 'Cerrar',
      prevText: '&#x3c;Ant',
      nextText: 'Sig&#x3e;',
      currentText: 'Hoy',
      monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
      monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
      dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
      dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
      dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
      weekHeader: 'Sm',
      dateFormat: 'dd/mm/yy',
      firstDay: 1,
      isRTL: false,
      showMonthAfterYear: false,
      yearSuffix: ''};
   $.datepicker.setDefaults($.datepicker.regional['es']);
});

$(function() {
    $("#<?php echo $id;?>").datepicker({
        changeMonth: true, 
        changeYear: true, 
    });
});
</script>
<?php
}

//autocomplete oficinas NO SE USA COMPROBAR
function autocomplete_oficinas($id){
?>
<script language="JavaScript">
$(function() {
$("#<?php echo $id;?>").autocomplete({
    source: '../vista/ajax/oficinas.php?bd=<?php echo $_SESSION['mapeo']; ?>',
    select : function(event, ui){
        $('#<?php echo $id;?>').html(
            //ui.item.value
        );
    }
    });
});
</script>
<?php
}

//autocomplete departamentos
function autocomplete_departamentos($id){
?>
<script language="JavaScript">
$(function() {
$("#<?php echo $id;?>").autocomplete({
    source: '../vista/ajax/departamentos.php?bd=<?php echo $_SESSION['dbContabilidad']; ?>',
    select : function(event, ui){
        $('#<?php echo $id;?>').html(
            //ui.item.value+'<br/>'
        );
    }
    });
});
</script>
<?php
}

//autocomplete cuentas
function autocomplete_cuentas($id){
?>
<script language="JavaScript">
$(function() {
$("#<?php echo $id;?>").autocomplete({
    source: '../vista/ajax/ingresos_gastos_cuentas.php?bd=<?php echo $_SESSION['mapeo']; ?>',
    autoFill: true,
    selectFirst: true
    }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
        var txt=item.value.split('-');
        var inner_html = "<a><small><font color='Grey'>"+txt[0]+"</font></small> - <b><font color='Teal'>"+txt[1]+"</font></b></a>";
        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append(inner_html)
            .appendTo( ul );
    };
});
</script>
<?php
}

//autocomplete cuentas filtrando por filtro
function autocomplete_cuentas_SubGrupo4($id,$filtro){
?>
<script language="JavaScript">
$(function() {
$("#<?php echo $id;?>").autocomplete({
    source: "../vista/ajax/ingresos_gastos_cuentas_filtros.php?bd=<?php echo $_SESSION['mapeo']; ?>&filtro=<?php echo $filtro;?>",
    autoFill: true,
    selectFirst: true
//    select : function(event,ui){
//        $("#<?php //echo $id;?>").html(ui.item.value);
//    }
//    });
    }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
        var txt=item.value.split('-');
        var inner_html = "<a><small><font color='Grey'>"+txt[0]+"</font></small> - <b><font color='Teal'>"+txt[1]+"</font></b></a>";
        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append(inner_html)
            .appendTo( ul );
    };
});

</script>
<?php
}

//autocomplete cuentas filtrando por filtro
function autocomplete_cuentas_SubGrupo40y41($id){
?>
<script language="JavaScript">
$(function() {
$("#<?php echo $id;?>").autocomplete({
    source: "../vista/ajax/ingresos_gastos_cuentas_filtros40y41.php?bd=<?php echo $_SESSION['mapeo']; ?>",
    autoFill: true,
    selectFirst: true
    }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
        var txt=item.value.split('-');
        var inner_html = "<a><small><font color='Grey'>"+txt[0]+"</font></small> - <b><font color='Teal'>"+txt[1]+"</font></b></a>";
        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append(inner_html)
            .appendTo( ul );
    };
});


</script>
<?php
}

//autocomplete cuentas filtrando por filtro
function autocomplete_cuentas_SubGrupo2y6($id){
?>
<script language="JavaScript">
$(function() {
$("#<?php echo $id;?>").autocomplete({
    source: "../vista/ajax/ingresos_gastos_cuentas_filtros2y6.php?bd=<?php echo $_SESSION['mapeo']; ?>",
    autoFill: true,
    selectFirst: true
    }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
        var txt=item.value.split('-');
        var inner_html = "<a><small><font color='Grey'>"+txt[0]+"</font></small> - <b><font color='Teal'>"+txt[1]+"</font></b></a>";
        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append(inner_html)
            .appendTo( ul );
    };
});


</script>
<?php
}

//funcion para incorporar el atributo placeholder en os input text (en algunos navegadores no funciona)
function activarPlaceHolder(){
?>
<script language="JavaScript">
(function($){
  $.fn.placeholder = function(){
    // Ingnoramos si el navegador soporta nativamente esta funcionalidad
    if ($.fn.placeholder.supported()){
      return $(this);
    }else{

      // En el evento submit del formulario reseteamos los values de los inputs
      // cuyo value es igual al placeholder
      $(this).parent('form').submit(function(e){
        $('input[placeholder].placeholder', this).val('');
      });

      // activamos el placeholder
      $(this).each(function(){
        $.fn.placeholder.on(this);
      });

      return $(this)
        // Evento on focus
        .focus(function(){
          // Desactivamos el placeholder si vamos a introducir nuevo texto
          if ($(this).hasClass('placeholder')){
            $.fn.placeholder.off(this);
          }
        })
        // Evento on blur
        .blur(function(){
          // Activamos el placeholder si no tiene contenido
          if ($(this).val() == ''){
            $.fn.placeholder.on(this);
          }
        });
    }
  };

  // Función que detecta si el navegdor soporta el placeholder nativamente
  $.fn.placeholder.supported = function(){
    var input = document.createElement('input');
    return !!('placeholder' in input);
  };

  // Añade el contenido del placeholder en el value del input
  $.fn.placeholder.on = function(el){
    var $el = $(el);
    $el.val($el.attr('placeholder')).addClass('placeholder');
  };
  // Borra el contenido del value
  $.fn.placeholder.off = function(el){
    $(el).val('').removeClass('placeholder');
  };
})(jQuery);

$(document).ready(function(){
  $('input[placeholder]').placeholder();
});
</script>                                
<?php
}

//funciones de eventos de los input text
function eventosInputText(){
?>
<script language="JavaScript">
//AJAX jQuery chequea que el fichero sea PDF
function check_fileAnexo(){
    var inputFileImage = document.getElementById("doc");
    
    if(navigator.appVersion.indexOf("MSIE 6.")!=-1 || navigator.appVersion.indexOf("MSIE 7.")!=-1
       || navigator.appVersion.indexOf("MSIE 8.")!=-1 || navigator.appVersion.indexOf("MSIE 9.")!=-1){
        var url=inputFileImage.value;
        var ficheroI=url.split("\\");
        var fichero=ficheroI[ficheroI.length-1];
        var ficheroDiv=fichero.split(".");
        var ext=ficheroDiv[ficheroDiv.length-1];
        ext=ext.toUpperCase();

        if(ext != 'PDF'){
            $('#txt_file').html("<b class='fileError'>&nbsp;&nbsp;&nbsp;El documento no es PDF o supera el tamaño maximo (1MB)</b>");
            document.getElementById('docCorrecto').value='NO';
        }else{
            $('#txt_file').html("<b>&nbsp;&nbsp;&nbsp;El documento es correcto</b>");
            $.ajax({
              data:{"name":fichero,"size":"10","type":"application/pdf"}, 
              url: '../vista/ajax/buscar_fileCorrecto.php',
              type:"POST",
              success: function(data) {
                if(data==='SI'){
                    $('#txt_file').html("<b>&nbsp;&nbsp;&nbsp;El documento es correcto</b>");
                }else{
                    $('#txt_file').html("<b class='fileError'>&nbsp;&nbsp;&nbsp;El documento no es PDF o supera el tamaño maximo (1MB)</b>");
                }
                document.getElementById('docCorrecto').value=data;
              }
            });
        }
    }else{
        //para el resto de navegadores
        var file = inputFileImage.files[0];
        $.ajax({
          data:{"name":file.name,"size":file.size,"type":file.type}, 
          url: '../vista/ajax/buscar_fileCorrecto.php',
          type:"POST",
          success: function(data) {
            if(data==='SI'){
                $('#txt_file').html("<b>&nbsp;&nbsp;&nbsp;El documento es correcto</b>");
            }else{
                $('#txt_file').html("<b class='fileError'>&nbsp;&nbsp;&nbsp;El documento no es PDF o supera el tamaño maximo (1MB)</b>");
            }
            document.getElementById('docCorrecto').value=data;
          }
        });
    }
}
    
//cambia el color de input text cuando estamos en el
function onFocusInputTextM(campo){
    $(campo).parent().css('border-color','#aaa666');
}

function solonumerosM(objeto){
    if($(objeto).val()!=''){
        if(isNaN($(objeto).val())){
            alert('Este campo es numérico');
            objeto.value='';
            $(objeto).parent().css('border-color','red');
        }
    }
}

//pone el color del marco por defecto
function defaultBorder(campo){
//    campo.style.borderColor='#eeeeee';
//    campo.title='';
}

//cambia el color de input text cuando estamos en el
function onFocusInputText(campo){
    campo.style.backgroundColor='#eeeeee';
    campo.style.borderColor='#aaa666';
}

//vuelve a dejar el color blanco de input text cuando lo abandonamos
function onBlurInputText(campo){
    campo.style.backgroundColor='#ffffff';
    campo.style.borderColor='#cccccc';
}

//cuando pasa por encima cambia el borde de color
function onMouseOverInputText(campo){
    campo.style.borderColor='#aaa666';
}

//cuando pasa por encima cambia el borde de color
function onMouseOutInputText(campo){
    campo.style.borderColor='#cccccc';
}

//validar la fecha
function esFechaValida(fecha){
    if (fecha != undefined && fecha.value != "" ){
        var dia  =  parseInt(fecha.value.substring(0,2),10);
        var mes  =  parseInt(fecha.value.substring(3,5),10);
        var anio =  parseInt(fecha.value.substring(6),10);

    switch(mes){
        case 1:
        case 3:
        case 5:
        case 7:
        case 8:
        case 10:
        case 12:
            numDias=31;
            break;
        case 4: case 6: case 9: case 11:
            numDias=30;
            break;
        case 2:
            if (comprobarSiBisisesto(anio)){ numDias=29 }else{ numDias=28};
            break;
        default:
//            alert("Fecha introducida errónea (dd/mm/yyyy)");
            return false;
    }

        if (dia>numDias || dia==0){
//            alert("Fecha introducida errónea (dd/mm/yyyy)");
            return false;
        }
        return true;
    }else{
        return true;
    }
}

function comprobarSiBisisesto(anio){
if ( ( anio % 100 != 0) && ((anio % 4 == 0) || (anio % 400 == 0))) {
    return true;
    }
else {
    return false;
    }
}

//comprobar que los campos solo sean numericos
function solonumeros(e)
{

    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = "0123456789";
    especiales = [8,9,37,39,46];

    tecla_especial = false
    for(var i in especiales){
         if(key == especiales[i]){
             tecla_especial = true;
             break;
         }
     }

     if(letras.indexOf(tecla)==-1 && !tecla_especial){
         return false;
     }    
}

//comprobar que los campos solo sean numericos
function solonumerosNeg(e)
{

    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = "0123456789";
    especiales = [8,9,37,39,45,46];

    tecla_especial = false
    for(var i in especiales){
         if(key == especiales[i]){
             tecla_especial = true;
             break;
         }
     }

     if(letras.indexOf(tecla)==-1 && !tecla_especial){
         return false;
     }    
}

//comprobar que los campos solo sean numericos
function facturasCaracteresDescartadosNO(e)
{

    key = e.keyCode || e.which;
//    keyChar=String.fromCharCode(key);
    alert(key);
//    tecla = String.fromCharCode(key).toLowerCase();
//    letras = " áéíóúabcdefghijklmnñopqrstuvwxyzÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789";
//    especiales = [8,9,37,39,46];
//
//    tecla_especial = false
//    for(var i in especiales){
//         if(key == especiales[i]){
//             tecla_especial = true;
//             break;
//         }
//     }
//
//     if(letras.indexOf(tecla)==-1 && !tecla_especial){
//         return false;
//     }    
}

//comprobar que los campos solo sean numericos
function facturasCaracteresDescartados(e)
{

    key = e.keyCode || e.which;
//    alert(key);
    tecla = String.fromCharCode(key).toLowerCase();
    especiales = [92];

    tecla_especial = false
    for(var i in especiales){
         if(key == especiales[i]){
             return false;
         }
     }

//     if(letras.indexOf(tecla)==-1 && !tecla_especial){
//         return false;
//     }    
}

//ESTE ES PARA COMPROBAR QUE HAY POSITIVO O NEGATIVO (ESTOY EN ELLO) NO VALE
//comprobar que los campos solo sean - o +
function soloPositivoONegativo(e)
{

    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = "-+";
    especiales = [8,9,37,39,46];

    tecla_especial = false
    for(var i in especiales){
         if(key == especiales[i]){
             tecla_especial = true;
             break;
         }
     }

     if(letras.indexOf(tecla)==-1 && !tecla_especial){
         return false;
     }    
}

//para poder editar el numero
function entradaCantidad(objeto,campo){
    if(objeto.value===''){
//        objeto.value='0,00';
        objeto.value='';
        campo.value='0.00';
    }else{
        objeto.value=campo.value;
    }
}

//para poder editar el numero
function actualizaCampoHidden(objeto,oculto){
    var valor=desFormateaNumeroContabilidad(objeto.value);
    oculto.value=valor;
}

/** libreria de funciones javascript para validaciones de CIF/NIF **/
function isValidCif(abc){
	par = 0;
	non = 0;
	letras = "ABCDEFGHKLMNPQS";
	let = abc.charAt(0);
 
	if (abc.length!=9) {
		return false;
	}
 
	if (letras.indexOf(let.toUpperCase())==-1) {
		return false;
	}
 
	for (zz=2;zz<8;zz+=2) {
		par = par+parseInt(abc.charAt(zz));
	}
 
	for (zz=1;zz<9;zz+=2) {
		nn = 2*parseInt(abc.charAt(zz));
		if (nn > 9) nn = 1+(nn-10);
		non = non+nn;
	}
 
	parcial = par + non;
	control = (10 - ( parcial % 10));
	if (control==10) control=0;
 
	if (control!=abc.charAt(8)) {
		return false;
	}
	return true;
}
 
 
function isValidNif(abc){
	dni=abc.substring(0,abc.length-1);
	let=abc.charAt(abc.length-1);
	if (!isNaN(let)) {
		return false;
	}else{
		cadena = "TRWAGMYFPDXBNJZSQVHLCKET";
		posicion = dni % 23;
		letra = cadena.substring(posicion,posicion+1);
		if (letra!=let.toUpperCase()){
			//alert("Nif no válido");
			return false;
		}
	}
	return true;
}

/**    **/
function validarNIFCIF(abc){
 
if(isValidCif(abc.value)){  
    document.getElementById('txt_validar').innerHTML='';
    return true;
}
 
if(isValidNif(abc.value)){ 
    document.getElementById('txt_validar').innerHTML='';
    return true;
}
document.getElementById('txt_validar').innerHTML=document.getElementById('txt_validar').innerHTML+'<font color="#FF0000">El NIF/CIF no es correcto.  </font>\n\n'; 
return false;
}

function vaciarCampo(campo){
    document.getElementById(campo).innerHTML='';
}

//selecciona el texto dentro de un input
function selecciona_value(objInput) { 

    var valor_input = objInput.value; 
    var longitud = valor_input.length; 

    if (objInput.setSelectionRange) { 
        objInput.focus(); 
        objInput.setSelectionRange (0, longitud); 
    } 
    else if (objInput.createTextRange) { 
        var range = objInput.createTextRange() ; 
        range.collapse(true); 
        range.moveEnd('character', longitud); 
        range.moveStart('character', 0); 
        range.select(); 
    } 
} 

//el puntero del cursor se va en un input al final, para poder editar mejor el dato
function selecciona_final(objInput){

//var event = document.createEvent("HTMLEvents"); 
//event.initEvent("focus", true, true); 
//element.dispatchEvent(event);         
//objInput.scrollTop = 999999;        
        
        
        
    if (objInput.createTextRange) {  
        //IE  
        var FieldRange = objInput.createTextRange();  
        FieldRange.moveStart('character', objInput.value.length);  
        FieldRange.collapse();  
        FieldRange.select();  
        }  
     else {  
        //Firefox and Opera  
        objInput.focus();  
        var length = objInput.value.length;  
        objInput.setSelectionRange(length, length);  
    }      
}

//AJAX jQuery chequea cuenta exista en la BD
function check_cuenta(cuenta,tipo){
    $.ajax({
      data:{"cuenta":cuenta,"tipo":tipo},  
      url: '../vista/ajax/buscar_cuenta.php',
      type:"get",
      success: function(data) {
        $('#txt_cuenta').html(data);
      }
    });
}

//AJAX jQuery chequea cuenta exista en la BD
function check_cuentaEmpresa(cuenta,tipo){
    $.ajax({
      data:{"cuenta":cuenta,"tipo":tipo},  
      url: '../vista/ajax/buscar_cuentaEmpresa.php',
      type:"get",
      success: function(data) {
        $('#txt_cuenta').html(data);
      }
    });
}

//esta funcion es la principal para el calculo del IVA (Entrada base) 
function CalculaIvaMas(ingreso,IVA){
    if (isNaN(ingreso)) {
        document.form1.lngIngreso.value='';
        document.form1.lngIngresoContabilidad.value='0,00';
        document.form1.lngIva.value='';
        document.form1.lngIvaContabilidad.value='0,00';
    }else
    if(ingreso != ''){
        ingreso=truncar2dec(ingreso);
        var cantidad=redondeo2dec(ingreso*((IVA/100)+1));
//        alert('cantidad: '+cantidad);
        var iva=redondeo2dec(cantidad-ingreso);
//        alert('iva: '+iva);
        
        //ahora guardamos en las vbles hiden los valores numericos de ingreso, cantida e iva
        // y en la variables de contabilidad lo que se presenta en los formatos
        //Cantidad
        document.form1.lngCantidad.value=ingreso;
        
        //Ingreso
        document.form1.lngIngreso.value=cantidad;
        cantidad=cantidad.toString();
        cantidad=formateaNumeroContabilidad(cantidad);
        document.form1.lngIngresoContabilidad.value=cantidad;

        //Iva
        document.form1.lngIva.value=iva;
        iva=iva.toString();
        iva=formateaNumeroContabilidad(iva);
        document.form1.lngIvaContabilidad.value=iva;
    }else{
        document.form1.lngIngreso.value='';
        document.form1.lngIngresoContabilidad.value='0,00';
        document.form1.lngIva.value='';
        document.form1.lngIvaContabilidad.value='0,00';
    }
}

//esta funcion es la principal para el calculo del IVA 
function CalculaIva(ingreso,IVA){
    if (isNaN(ingreso)) {
        document.form1.lngCantidad.value='';
        document.form1.lngCantidadContabilidad.value='0,00';
        document.form1.lngIva.value='';
        document.form1.lngIvaContabilidad.value='0,00';
    }else
    if(ingreso != ''){
        ingreso=truncar2dec(ingreso);
        var cantidad=redondeo2dec(ingreso/((IVA/100)+1));
        var iva=redondeo2dec(ingreso-cantidad);
        
        //ahora guardamos en las vbles hiden los valores numericos de ingreso, cantida e iva
        // y en la variables de contabilidad lo que se presenta en los formatos
        //Ingreso
        document.form1.lngIngreso.value=ingreso;
        
        //Cantidad
        document.form1.lngCantidad.value=cantidad;
        cantidad=cantidad.toString();
        cantidad=formateaNumeroContabilidad(cantidad);
        document.form1.lngCantidadContabilidad.value=cantidad;

        //Iva
        document.form1.lngIva.value=iva;
        iva=iva.toString();
        iva=formateaNumeroContabilidad(iva);
        document.form1.lngIvaContabilidad.value=iva;
    }else{
        document.form1.lngCantidad.value='';
        document.form1.lngCantidadContabilidad.value='0,00';
        document.form1.lngIva.value='';
        document.form1.lngIvaContabilidad.value='0,00';
    }
}

//Estas funciones son para la pagina 'gastos_*.php'
function CalculaIva1(ingreso,IVAP){
    if (isNaN(ingreso)) {
        document.form1.lngCantidad.value='';
        document.form1.lngCantidadContabilidad.value='0,00';
        document.form1.lngIva.value='';
        document.form1.lngIvaContabilidad.value='0,00';
    }else
    if(ingreso !== ''){
        ingreso=truncar2dec(ingreso);
        var cantidad=redondeo2dec(ingreso*((IVAP/100)+1));
        var iva=redondeo2dec(cantidad-ingreso);
        
        //ahora guardamos en las vbles hiden los valores numericos de ingreso, cantida e iva
        // y en la variables de contabilidad lo que se presenta en los formatos
        //Ingreso
        document.form1.lngCantidad1.value=ingreso;
        
        //Iva
        document.form1.lngIva1.value=iva;
        iva=iva.toString();
        iva=formateaNumeroContabilidad(iva);
        document.form1.lngIvaContabilidad1.value=iva;
    }else{
        document.form1.lngIva1.value='';
        document.form1.lngIvaContabilidad1.value='';
    }
}

function CalculaIva2(ingreso,IVAP){
    if (isNaN(ingreso)) {
        document.form1.lngCantidad.value='';
        document.form1.lngCantidadContabilidad.value='0,00';
        document.form1.lngIva.value='';
        document.form1.lngIvaContabilidad.value='0,00';
    }else
    if(ingreso !== ''){
        ingreso=truncar2dec(ingreso);
        var cantidad=redondeo2dec(ingreso*((IVAP/100)+1));
        var iva=redondeo2dec(cantidad-ingreso);
        
        //ahora guardamos en las vbles hiden los valores numericos de ingreso, cantida e iva
        // y en la variables de contabilidad lo que se presenta en los formatos
        //Ingreso
        document.form1.lngCantidad2.value=ingreso;
        
        //Iva
        document.form1.lngIva2.value=iva;
        iva=iva.toString();
        iva=formateaNumeroContabilidad(iva);
        document.form1.lngIvaContabilidad2.value=iva;
    }else{
        document.form1.lngIva2.value='';
        document.form1.lngIvaContabilidad2.value='';
    }
}

function CalculaIva3(ingreso,IVAP){
    if (isNaN(ingreso)) {
        document.form1.lngCantidad.value='';
        document.form1.lngCantidadContabilidad.value='0,00';
        document.form1.lngIva.value='';
        document.form1.lngIvaContabilidad.value='0,00';
    }else
    if(ingreso !== ''){
        ingreso=truncar2dec(ingreso);
        var cantidad=redondeo2dec(ingreso*((IVAP/100)+1));
        var iva=redondeo2dec(cantidad-ingreso);
        
        //ahora guardamos en las vbles hiden los valores numericos de ingreso, cantida e iva
        // y en la variables de contabilidad lo que se presenta en los formatos
        //Ingreso
        document.form1.lngCantidad3.value=ingreso;
        
        //Iva
        document.form1.lngIva3.value=iva;
        iva=iva.toString();
        iva=formateaNumeroContabilidad(iva);
        document.form1.lngIvaContabilidad3.value=iva;
    }else{
        document.form1.lngIva3.value='';
        document.form1.lngIvaContabilidad3.value='';
    }
}

function CalculaIva4(ingreso,IVAP){
    if (isNaN(ingreso)) {
        document.form1.lngCantidad.value='';
        document.form1.lngCantidadContabilidad.value='0,00';
        document.form1.lngIva.value='';
        document.form1.lngIvaContabilidad.value='0,00';
    }else
    if(ingreso !== ''){
        ingreso=truncar2dec(ingreso);
        var cantidad=redondeo2dec(ingreso*((IVAP/100)+1));
        var iva=redondeo2dec(cantidad-ingreso);
        
        //ahora guardamos en las vbles hiden los valores numericos de ingreso, cantida e iva
        // y en la variables de contabilidad lo que se presenta en los formatos
        //Ingreso
        document.form1.lngCantidad4.value=ingreso;
        
        //Iva
        document.form1.lngIva4.value=iva;
        iva=iva.toString();
        iva=formateaNumeroContabilidad(iva);
        document.form1.lngIvaContabilidad4.value=iva;
    }else{
        document.form1.lngIva4.value='';
        document.form1.lngIvaContabilidad4.value='';
    }
}

function SumasFactura(){
    //sumas de base imponible
    var bi1,bi2,bi3,bi4;
    if(document.form1.lngCantidad1.value===''){
        bi1='0';
    }else{
        bi1=document.form1.lngCantidad1.value;
    }
    if(document.form1.lngCantidad2.value===''){
        bi2='0';
    }else{
        bi2=document.form1.lngCantidad2.value;
    }
    if(document.form1.lngCantidad3.value===''){
        bi3='0';
    }else{
        bi3=document.form1.lngCantidad3.value;
    }
    if(document.form1.lngCantidad4.value===''){
        bi4='0';
    }else{
        bi4=document.form1.lngCantidad4.value;
    }
    var baseImponible=parseFloat(bi1)+parseFloat(bi2)+parseFloat(bi3)+parseFloat(bi4);
    baseImponible=Math.round(baseImponible*100)/100;
    document.form1.lngCantidadTotal.value=baseImponible;
    var txtBaseImponible=formateaNumeroContabilidad(baseImponible.toString());
    document.form1.lngCantidadContabilidadTotal.value=txtBaseImponible;

    //sumas de ivas
    var iva1,iva2,iva3,iva4;
    if(document.form1.lngIva1.value===''){
        iva1='0';
    }else{
        iva1=document.form1.lngIva1.value;
    }
    if(document.form1.lngIva2.value===''){
        iva2='0';
    }else{
        iva2=document.form1.lngIva2.value;
    }
    if(document.form1.lngIva3.value===''){
        iva3='0';
    }else{
        iva3=document.form1.lngIva3.value;
    }
    if(document.form1.lngIva4.value===''){
        iva4='0';
    }else{
        iva4=document.form1.lngIva4.value;
    }
    var IvaTotal=parseFloat(iva1)+parseFloat(iva2)+parseFloat(iva3)+parseFloat(iva4);
    IvaTotal=Math.round(IvaTotal*100)/100;
    document.form1.lngIvaTotal.value=IvaTotal;
    var txtIvaTotal=formateaNumeroContabilidad(IvaTotal.toString());
    document.form1.lngIvaContabilidadTotal.value=txtIvaTotal;

    //suma total factura
    var Total=parseFloat(baseImponible)+parseFloat(IvaTotal);
    Total=Math.round(Total*100)/100;
    document.form1.Total.value=Total;
    Total=formateaNumeroContabilidad(Total.toString());
    document.form1.ContabilidadTotal.value=Total;
}

function SumasFactura2(){
    //sumas de base imponible
    var bi1,bi2,bi3,bi4;
    if(document.form1.lngCantidad1.value===''){
        bi1='0';
    }else{
        bi1=document.form1.lngCantidad1.value;
    }
    if(document.form1.lngCantidad2.value===''){
        bi2='0';
    }else{
        bi2=document.form1.lngCantidad2.value;
    }
    if(document.form1.lngCantidad3.value===''){
        bi3='0';
    }else{
        bi3=document.form1.lngCantidad3.value;
    }
    if(document.form1.lngCantidad4.value===''){
        bi4='0';
    }else{
        bi4=document.form1.lngCantidad4.value;
    }
    var baseImponible=parseFloat(bi1)+parseFloat(bi2)+parseFloat(bi3)+parseFloat(bi4);
    baseImponible=Math.round(baseImponible*100)/100;
    document.form1.lngCantidadTotal.value=baseImponible;
    var txtBaseImponible=formateaNumeroContabilidad(baseImponible.toString());
    document.form1.lngCantidadContabilidadTotal.value=txtBaseImponible;

    //sumas de ivas
    var iva1,iva2,iva3,iva4;
    if(document.form1.lngIva1.value===''){
        iva1='0';
    }else{
        iva1=document.form1.lngIva1.value;
    }
    if(document.form1.lngIva2.value===''){
        iva2='0';
    }else{
        iva2=document.form1.lngIva2.value;
    }
    if(document.form1.lngIva3.value===''){
        iva3='0';
    }else{
        iva3=document.form1.lngIva3.value;
    }
    if(document.form1.lngIva4.value===''){
        iva4='0';
    }else{
        iva4=document.form1.lngIva4.value;
    }
    var IvaTotal=parseFloat(iva1)+parseFloat(iva2)+parseFloat(iva3)+parseFloat(iva4);
    IvaTotal=Math.round(IvaTotal*100)/100;
    document.form1.lngIvaTotal.value=IvaTotal;
    var txtIvaTotal=formateaNumeroContabilidad(IvaTotal.toString());
    document.form1.lngIvaContabilidadTotal.value=txtIvaTotal;

    //suma total factura
    var Total=parseFloat(baseImponible)+parseFloat(IvaTotal);
    Total=Math.round(Total*100)/100;
    document.form1.lngTotal.value=Total;
    Total=formateaNumeroContabilidad(Total.toString());
    document.form1.lngTotalContabilidad.value=Total;
}

function CalculaIRPF(ingreso,IRPF){
    if (isNaN(ingreso)) {
        document.form1.lngCantidad.value='';
        document.form1.lngCantidadContabilidad.value='0,00';
        document.form1.lngIva.value='';
        document.form1.lngIvaContabilidad.value='0,00';
    }else
    if(ingreso !== ''){
        ingreso=truncar2dec(ingreso);
        var IRPF_descontar=redondeo2dec(ingreso*(IRPF/100));
        //var iva=redondeo2dec(cantidad-ingreso);
        
        //ahora guardamos en las vbles hiden los valores numericos de ingreso, cantida e iva
        // y en la variables de contabilidad lo que se presenta en los formatos
        //IRPF
        document.form1.lngIRPF.value=IRPF_descontar;
        
        IRPF_descontar=IRPF_descontar.toString();
        IRPF_descontar=formateaNumeroContabilidad(IRPF_descontar);
        document.form1.lngIRPFContabilidad.value=IRPF_descontar;
    }else{
        document.form1.lngIRPF.value='';
        document.form1.lngIRPFContabilidad.value='';
    }
}

function TotalIRPF(){
    var baseImponible=document.form1.lngCantidad1.value;
    var IVA=document.form1.lngIva1.value;
    var IRPF=document.form1.lngIRPF.value;

    var suma=parseFloat(baseImponible)+parseFloat(IVA)-parseFloat(IRPF);
    suma=Math.round(suma*100)/100;

    if(isNaN(suma)){
        document.form1.lngIngreso.value='0.00';
        document.form1.lngTotalContabilidad.value='';
    }else{
        document.form1.lngIngreso.value=suma.toString();
        document.form1.lngTotalContabilidad.value=formateaNumeroContabilidad(suma.toString());
    }
}

function TotalIRPF2(){
    var baseImponible=document.form1.lngCantidadTotal.value;
    var IVA=document.form1.lngIvaTotal.value;
    var IRPF=document.form1.lngIRPF.value;

    var suma=parseFloat(baseImponible)+parseFloat(IVA)-parseFloat(IRPF);
    suma=Math.round(suma*100)/100;

    if(isNaN(suma)){
        document.form1.lngTotal.value='0.00';
        document.form1.lngTotalContabilidad.value='';
    }else{
        document.form1.lngTotal.value=suma.toString();
        document.form1.lngTotalContabilidad.value=formateaNumeroContabilidad(suma.toString());
    }
}

function CalculaDesdeTotal(Total,IVA,IRPF){
    Total=parseFloat(Total);
    IVA=parseFloat(IVA);
    IRPF=parseFloat(IRPF);
    
    //calculo la base imponible, el IVA y el IRPF
    var Base=Total/(1+((IVA-IRPF)/100));
    if(isNaN(Base)){
        Base=0;
        CuotaIVA='';
        CuotaIRPF='';
    }else{
        Base=Math.round(Base*100)/100;
        var CuotaIVA=(IVA*Total)/(100+IVA-IRPF);
        CuotaIVA=Math.round(CuotaIVA*100)/100;
        var CuotaIRPF=(IRPF*Total)/(100+IVA-IRPF);
        CuotaIRPF=Math.round(CuotaIRPF*100)/100;
    }
    //ahora se escriben en los campos correspondientes        
    document.form1.lngCantidad1.value=Base;
    Base=Base.toString();
    Base=formateaNumeroContabilidad(Base.toString());
    document.form1.lngCantidadContabilidad1.value=Base;

    document.form1.lngIva1.value=CuotaIVA;
    CuotaIVA=CuotaIVA.toString();
    CuotaIVA=formateaNumeroContabilidad(CuotaIVA.toString());
    document.form1.lngIvaContabilidad1.value=CuotaIVA;
    
    document.form1.lngIRPF.value=CuotaIRPF;
    CuotaIRPF=CuotaIRPF.toString();
    CuotaIRPF=formateaNumeroContabilidad(CuotaIRPF.toString());
    document.form1.lngIRPFContabilidad.value=CuotaIRPF;
    
    document.form1.lngIngreso.value=Total;
}

function redondeo2dec(numero) {
    var original = parseFloat(numero);
    var result = Math.round(original * 100) / 100;
    return result;
}

function truncar2dec(numero){
    numero=Math.round(numero*100);
    parte_entera=parseInt(numero);
    numero=parte_entera/100;
    return numero;
}

function truncar4dec(numero){
    numero=Math.round(numero*10000);
    parte_entera=parseInt(numero);
    numero=parte_entera/10000;
    return numero;
}

//ANTIGUA 11/2/2016
////formatear valores numericos con puntos de miles y comas para decimales
//function formateaNumeroContabilidad(valor) {
//    var nums = new Array();
//    var numsDec = new Array();
//    var divEnteroDecimal=new Array();
//    divEnteroDecimal = valor.split("."); //dividimos enteros y decimales
//    
//    //primero formateamos los enteros
//    nums = divEnteroDecimal[0].split(""); //Se vacia el valor en un arreglo
//    var lon = nums.length - 1; // Se saca la longitud del arreglo
//    var patron = 3; //Indica cada cuanto se ponen las comas
//    var prox = 2; // Indica en que lugar se debe insertar la siguiente coma
//    var res = "";
//    var resDec="";
// 
//    while (lon > prox) {
//        nums.splice((lon - prox),0,"."); //Se agrega el punto
//        prox += patron; //Se incrementa la posición próxima para colocar el punto
//    }
// 
//    for (var i = 0; i <= nums.length-1; i++) {
//        res += nums[i]; //Se crea la nueva cadena para devolver el valor formateado
//    }
//    
//    //ahora formateamos la parte decimal (solo dos digitos), si hay
//    if(divEnteroDecimal[1]!=null){
//        numsDec = divEnteroDecimal[1].split(""); //Se vacia el valor en un arreglo
//
//        var j=0;//el indice del array comienza por 0
//        var tamMax=2; //2 decimales
//        while(numsDec.length > j){
//            if(j < tamMax){
//                resDec += numsDec[j]; //Se crea la nueva cadena para devolver el valor formateado
//            }
//            j++;
//        }
//        //vemos si al recorrer la pate decimal quedaban valores a recorrer (Ej si hemos introducido
//        //4. nos quedan dos posisiones (hasta 4.00) o 4.5 (hasta 4.50) nos quedaria una posision
//        var cerosDcha=tamMax-numsDec.length; 
//        while(cerosDcha>0){
//            resDec=resDec+'0';
//            cerosDcha=cerosDcha-1;
//        }
//    }else{
//        resDec='00';
//    }
//    
//    //compruebo que el valor res no este vacio
//    if(res==''){
//        res='0';
//    }
//    
//    //se junta la parte entera y decimal separado por una coma
//    var resFinal=res+','+resDec;
//    
//    return resFinal;
//}

//formatear valores numericos con puntos de miles y comas para decimales
function formateaNumeroContabilidad(valor) {
    //cojo el primer valor de la cadena
    var primerCaracter = valor.substring(0,1);
    var primerCaracterFinal = '';
    if(primerCaracter === '-'){
        primerCaracterFinal = '-';
        valor = valor.substring(1);
    }
    
    var nums = new Array();
    var numsDec = new Array();
    var divEnteroDecimal=new Array();
    divEnteroDecimal = valor.split("."); //dividimos enteros y decimales
    
    //primero formateamos los enteros
    nums = divEnteroDecimal[0].split(""); //Se vacia el valor en un arreglo
    var lon = nums.length - 1; // Se saca la longitud del arreglo
    var patron = 3; //Indica cada cuanto se ponen las comas
    var prox = 2; // Indica en que lugar se debe insertar la siguiente coma
    var res = "";
    var resDec="";
 
    while (lon > prox) {
        nums.splice((lon - prox),0,"."); //Se agrega el punto
        prox += patron; //Se incrementa la posición próxima para colocar el punto
    }
 
    for (var i = 0; i <= nums.length-1; i++) {
        res += nums[i]; //Se crea la nueva cadena para devolver el valor formateado
    }
    
    //ahora formateamos la parte decimal (solo dos digitos), si hay
    if(divEnteroDecimal[1]!=null){
        numsDec = divEnteroDecimal[1].split(""); //Se vacia el valor en un arreglo

        var j=0;//el indice del array comienza por 0
        var tamMax=2; //2 decimales
        while(numsDec.length > j){
            if(j < tamMax){
                resDec += numsDec[j]; //Se crea la nueva cadena para devolver el valor formateado
            }
            j++;
        }
        //vemos si al recorrer la pate decimal quedaban valores a recorrer (Ej si hemos introducido
        //4. nos quedan dos posisiones (hasta 4.00) o 4.5 (hasta 4.50) nos quedaria una posision
        var cerosDcha=tamMax-numsDec.length; 
        while(cerosDcha>0){
            resDec=resDec+'0';
            cerosDcha=cerosDcha-1;
        }
    }else{
        resDec='00';
    }
    
    //compruebo que el valor res no este vacio
    if(res==''){
        res='0';
    }
    
    //se junta la parte entera y decimal separado por una coma
    var resFinal=res+','+resDec;
    
    return primerCaracterFinal+resFinal;
}

function vaciarSiEs0(valor){
    if(valor.value==='0,00'){
        valor.value='';
    }
}

function desFormateaNumeroContabilidad(valor) {
    if(valor!==''){
    var divEnteroDecimal = valor.split(","); //dividimos enteros y decimales
    var res='';
    var resDec='';
    
    //primero quitamos los puntos de la parte entera
    var nums = divEnteroDecimal[0].split(""); //Se vacia el valor en un arreglo

    for (var i = 0; i <= nums.length-1; i++) {
        if(nums[i]!='.'){
            res += nums[i]; //Se crea la nueva cadena para devolver el valor formateado
        }
    }


    //ahora extraemos la parte decimal, si hay
    if(divEnteroDecimal[1]!=null){
        resDec=divEnteroDecimal[1];
    }else{
        resDec='00';
    }
    //se junta la parte entera y decimal separado por un punto
    var resFinal=res+'.'+resDec;
    }else{
        resFinal=0;
    }
    return resFinal;
}

//al entrar en la pagina se situe en el campo de fecha
function focusFecha(){
    document.getElementById('datFecha').focus();
}

//control de numerico a nombre del mes (Periodo)
function fechaMes(objeto){
    var mesNumero=objeto.value.split('/')[1];
    var year=objeto.value.split('/')[2];
    if(mesNumero=='01'){
        document.getElementById('strPeriodo').value='ENERO';
        document.getElementById('lngPeriodo').value='1';
    }else if(mesNumero=='02'){
        document.getElementById('strPeriodo').value='FEBRERO';
        document.getElementById('lngPeriodo').value='2';
    }else if(mesNumero=='03'){
        document.getElementById('strPeriodo').value='MARZO';
        document.getElementById('lngPeriodo').value='3';
    }else if(mesNumero=='04'){
        document.getElementById('strPeriodo').value='ABRIL';
        document.getElementById('lngPeriodo').value='4';
    }else if(mesNumero=='05'){
        document.getElementById('strPeriodo').value='MAYO';
        document.getElementById('lngPeriodo').value='5';
    }else if(mesNumero=='06'){
        document.getElementById('strPeriodo').value='JUNIO';
        document.getElementById('lngPeriodo').value='6';
    }else if(mesNumero=='07'){
        document.getElementById('strPeriodo').value='JULIO';
        document.getElementById('lngPeriodo').value='7';
    }else if(mesNumero=='08'){
        document.getElementById('strPeriodo').value='AGOSTO';
        document.getElementById('lngPeriodo').value='8';
    }else if(mesNumero=='09'){
        document.getElementById('strPeriodo').value='SEPTIEMBRE';
        document.getElementById('lngPeriodo').value='9';
    }else if(mesNumero=='10'){
        document.getElementById('strPeriodo').value='OCTUBRE';
        document.getElementById('lngPeriodo').value='10';
    }else if(mesNumero=='11'){
        document.getElementById('strPeriodo').value='NOVIEMBRE';
        document.getElementById('lngPeriodo').value='11';
    }else if(mesNumero=='12'){
        document.getElementById('strPeriodo').value='DICIEMBRE';
        document.getElementById('lngPeriodo').value='12';
    }else{
        document.getElementById('strPeriodo').value='';
        document.getElementById('lngPeriodo').value='0';
    }
    //paso los datos por innerHTML (app movil)
    document.getElementById('strPeriodo').innerHTML=document.getElementById('strPeriodo').value;
    
    //actualizar el capo ejercicio (año)
    if(year!=null){
        document.getElementById('lngEjercicio').value=year;
        document.getElementById('lngEjercicio').innerHTML=document.getElementById('lngEjercicio').value;
    }
}

//control de numerico a nombre del mes (Periodo)
function fechaMes_MovilAsiento(objeto){
    var mesNumero=objeto.value.split('/')[1];
    var year=objeto.value.split('/')[2];
    if(mesNumero=='01'){
        document.getElementById('strPeriodo').value='ENERO';
        document.getElementById('lngPeriodo').value='1';
    }else if(mesNumero=='02'){
        document.getElementById('strPeriodo').value='FEBRERO';
        document.getElementById('lngPeriodo').value='2';
    }else if(mesNumero=='03'){
        document.getElementById('strPeriodo').value='MARZO';
        document.getElementById('lngPeriodo').value='3';
    }else if(mesNumero=='04'){
        document.getElementById('strPeriodo').value='ABRIL';
        document.getElementById('lngPeriodo').value='4';
    }else if(mesNumero=='05'){
        document.getElementById('strPeriodo').value='MAYO';
        document.getElementById('lngPeriodo').value='5';
    }else if(mesNumero=='06'){
        document.getElementById('strPeriodo').value='JUNIO';
        document.getElementById('lngPeriodo').value='6';
    }else if(mesNumero=='07'){
        document.getElementById('strPeriodo').value='JULIO';
        document.getElementById('lngPeriodo').value='7';
    }else if(mesNumero=='08'){
        document.getElementById('strPeriodo').value='AGOSTO';
        document.getElementById('lngPeriodo').value='8';
    }else if(mesNumero=='09'){
        document.getElementById('strPeriodo').value='SEPTIEMBRE';
        document.getElementById('lngPeriodo').value='9';
    }else if(mesNumero=='10'){
        document.getElementById('strPeriodo').value='OCTUBRE';
        document.getElementById('lngPeriodo').value='10';
    }else if(mesNumero=='11'){
        document.getElementById('strPeriodo').value='NOVIEMBRE';
        document.getElementById('lngPeriodo').value='11';
    }else if(mesNumero=='12'){
        document.getElementById('strPeriodo').value='DICIEMBRE';
        document.getElementById('lngPeriodo').value='12';
    }else{
        document.getElementById('strPeriodo').value='';
        document.getElementById('lngPeriodo').value='0';
    }
    //paso los datos por innerHTML (app movil)
    document.getElementById('strPeriodo').innerHTML=document.getElementById('strPeriodo').value;
    
    //actualizar el capo ejercicio (año)
    if(year!=null){
        document.getElementById('lngEjercicio').value=year;
        document.getElementById('lngEjercicio').innerHTML=document.getElementById('lngEjercicio').value;
        document.getElementById('lngEjercicioH').value=document.getElementById('lngEjercicio').value;
    }
}

function comprobarFechaEsCerrada(objeto){
    $.ajax({
      data:{"fecha":objeto.value},  
      url: '../vista/ajax/comprobarFechaEsCerrada.php',
      type:"get",
      success: function(data) {
          if(data=='CERRADO'){
              alert('Esta fecha esta en un periodo que está CERRADO PARCIAL.');
              document.getElementById('datFecha').focus();
          }
      }
    });
}

//control de numerico a nombre del mes (Periodo)
function fechaMes_Mobil(objeto){
    var mesNumero=objeto.value.split('-')[1];
    var year=objeto.value.split('-')[0];
    if(mesNumero=='01'){
        document.getElementById('strPeriodo').value='ENERO';
        document.getElementById('lngPeriodo').value='1';
    }else if(mesNumero=='02'){
        document.getElementById('strPeriodo').value='FEBRERO';
        document.getElementById('lngPeriodo').value='2';
    }else if(mesNumero=='03'){
        document.getElementById('strPeriodo').value='MARZO';
        document.getElementById('lngPeriodo').value='3';
    }else if(mesNumero=='04'){
        document.getElementById('strPeriodo').value='ABRIL';
        document.getElementById('lngPeriodo').value='4';
    }else if(mesNumero=='05'){
        document.getElementById('strPeriodo').value='MAYO';
        document.getElementById('lngPeriodo').value='5';
    }else if(mesNumero=='06'){
        document.getElementById('strPeriodo').value='JUNIO';
        document.getElementById('lngPeriodo').value='6';
    }else if(mesNumero=='07'){
        document.getElementById('strPeriodo').value='JULIO';
        document.getElementById('lngPeriodo').value='7';
    }else if(mesNumero=='08'){
        document.getElementById('strPeriodo').value='AGOSTO';
        document.getElementById('lngPeriodo').value='8';
    }else if(mesNumero=='09'){
        document.getElementById('strPeriodo').value='SEPTIEMBRE';
        document.getElementById('lngPeriodo').value='9';
    }else if(mesNumero=='10'){
        document.getElementById('strPeriodo').value='OCTUBRE';
        document.getElementById('lngPeriodo').value='10';
    }else if(mesNumero=='11'){
        document.getElementById('strPeriodo').value='NOVIEMBRE';
        document.getElementById('lngPeriodo').value='11';
    }else if(mesNumero=='12'){
        document.getElementById('strPeriodo').value='DICIEMBRE';
        document.getElementById('lngPeriodo').value='12';
    }else{
        document.getElementById('strPeriodo').value='';
        document.getElementById('lngPeriodo').value='0';
    }
    //actualizar el capo ejercicio (año)
    if(year!=null){
        document.getElementById('lngEjercicio').value=year;
    }
}

function comprobarFechaEsCerradaDefinitiva(objeto){
    $.ajax({
      data:{"fecha":objeto.value},  
      url: '../vista/ajax/comprobarFechaEsCerradaDefinitiva.php',
      type:"get",
      success: function(data) {
          if(data=='CERRADO'){
              alert('Esta fecha esta en un periodo que está CERRADO DEFINITIVO.');
              document.getElementById('datFecha').focus();
          }
      }
    });
}

//compruebo si lo que se escribe existe en la BBDD, sino no deja seguir escribiendo
function comprobarCuenta(objeto,comprobacion){
$.ajax({
  data:{"q":objeto.value},  
  url: '../vista/ajax/ingresos_gastos_comprobar_cuenta.php',
  type:"get",
  success: function(data) {
    if(data=='NO'){
        $(objeto).css('color','#ff0000');
//        comprobacion.value='NO';
    }else{
        $(objeto).css('color','#666666');
//        comprobacion.value='SI';
    }
  }
});
}

//compruebo si lo que se escribe existe en la BBDD, sino no deja seguir escribiendo
function comprobarCuentaM(objeto,comprobacion){
$.ajax({
  data:{"q":objeto.value},  
  url: '../vista/ajax/ingresos_gastos_comprobar_cuenta.php',
  type:"get",
  success: function(data) {
    if(data=='NO'){
        $(objeto).css('color','#ff0000');
        comprobacion.value='NO';
    }else{
        $(objeto).css('color','#666666');
        comprobacion.value='SI';
    }
  }
});
}

//si al salir de este campo la cuenta existe o no
function comprobarCuentaBlur(objeto,comprobacion){
$.ajax({
  data:{"q":objeto.value},  
  url: '../vista/ajax/ingresos_gastos_comprobar_cuenta_blur.php',
  type:"get",
  success: function(data) {
    if(data=='NO'){
        $(objeto).css('color','#ff0000');
        objeto.value='';
        comprobacion.value='NO';
    }else{
        $(objeto).css('color','#666666');
        comprobacion.value='SI';
    }
  }
});
}

//pasar a NO los campos de comprobacion de cuenta en evento onFocus
function desactivaCampoComprobacionCuenta(campo){
    campo.value='NO';
}

//FALLA, POR EL MOMENTO NO LA USO, PERO NO LA BORRES
//ES IGUAL QUE LA FUNCION comprobarCuenta PERO CON UN FILTRO PARA LAS CUENTAS A BUSCAR PERO NO FUNCIONA
//8/11/2013
//compruebo si lo que se escribe existe en la BBDD, sino no deja seguir escribiendo
function comprobarCuentaFiltro(objeto,comprobacion,filtro){
$.ajax({
//  data:{"q":objeto.value}, 
  data:'q='+objeto.value+'&filtro='+filtro,
  url: '../vista/ajax/ingresos_gastos_form_cuenta.php',
  type:"get",
  success: function(data) {
    if(data==='NO'){
        $(objeto).css('color','#ff0000');
        comprobacion.value='NO';
    }else{
        $(objeto).css('color','#666666');
        comprobacion.value='SI';
    }
  }
});
}

//FALLA, POR EL MOMENTO NO LA USO, PERO NO LA BORRES
//ES IGUAL QUE LA FUNCION comprobarCuentaBlur PERO CON UN FILTRO PARA LAS CUENTAS A BUSCAR PERO NO FUNCIONA
//8/11/2013
//si al salir de este campo la cuenta existe o no
function comprobarCuentaFiltroBlur(objeto,comprobacion,filtro){
$.ajax({
  data:'q='+objeto.value+'&filtro='+filtro,
  url: '../vista/ajax/ingresos_gastos_form_cuenta_blur.php',
  type:"get",
  success: function(data) {
    if(data=='NO'){
        $(objeto).css('color','#ff0000');
        comprobacion.value='NO';
    }else{
        $(objeto).css('color','#666666');
        comprobacion.value='SI';
    }
  }
});
}

//si al salir de este campo la cuenta existe o no
function comprobarCuentaFiltroBlur2(objeto,comprobacion,filtro){
    if (objeto.value.length===0){ 
//        document.getElementById("txt_cuenta").innerHTML="";
        comprobacion.innerHTML="";
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
        if (xmlhttp.readyState===4 && xmlhttp.status===200)
        {
//            document.getElementById("txt_cuenta").innerHTML=xmlhttp.responseText;
            comprobacion.innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","../vista/ajax/ingresos_gastos_form_cuenta_blur2.php?q="+objeto.value+'&filtro='+filtro,true);
    xmlhttp.send();

}

//limpiar el campo de fecha segun llegamos a el
function limpiaCampoFecha(objeto){
    objeto.value='';
}    

//pasamos el número a negativo
function formateaNegativoContabilidad(objetoPresentar,esAbono){
    if(esAbono==='SI'){
        var txt='-';
        objetoPresentar.value=txt.concat(objetoPresentar.value);
        objetoPresentar.style.color='#FF0000';
    }
}

//pasamos el campo el color del texto a rojo
function formateoCampoColor(objetoPresentar,esAbono,color){
    objetoPresentar.style.color=color;
}

function IsNumericFecha(valor) 
{ 
var log=valor.length; var sw="S"; 
for (x=0; x<log; x++) 
{ v1=valor.substr(x,1); 
v2 = parseInt(v1); 
//Compruebo si es un valor numérico 
if (isNaN(v2)) { sw= "N";} 
} 
if (sw=="S") {return true;} else {return false; } 
} 
function formateafechaEntrada(fecha) 
{ 
var primerslap=false; 
var segundoslap=false; 
var long = fecha.length; 
var dia; 
var mes; 
var ano; 
if ((long>=2) && (primerslap==false)) { dia=fecha.substr(0,2); 
if ((IsNumericFecha(dia)==true) && (dia<=31) && (dia!="00")) { fecha=fecha.substr(0,2)+"/"+fecha.substr(3,7); primerslap=true; } 
else { fecha=""; primerslap=false;} 
} 
else 
{ dia=fecha.substr(0,1); 
if (IsNumericFecha(dia)==false) 
{fecha="";} 
if ((long<=2) && (primerslap=true)) {fecha=fecha.substr(0,1); primerslap=false; } 
} 
if ((long>=5) && (segundoslap==false)) 
{ mes=fecha.substr(3,2); 
if ((IsNumericFecha(mes)==true) &&(mes<=12) && (mes!="00")) { fecha=fecha.substr(0,5)+"/"+fecha.substr(6,4); segundoslap=true; } 
else { fecha=fecha.substr(0,3);; segundoslap=false;} 
} 
else { if ((long<=5) && (segundoslap=true)) { fecha=fecha.substr(0,4); segundoslap=false; } } 
if (long>=7) 
{ ano=fecha.substr(6,4); 
if (IsNumericFecha(ano)==false) { fecha=fecha.substr(0,6); } 
else { if (long==10){ if ((ano==0) || (ano<1900) || (ano>2100)) { fecha=fecha.substr(0,6); } } } 
} 
if (long>=10) 
{ 
fecha=fecha.substr(0,10); 
dia=fecha.substr(0,2); 
mes=fecha.substr(3,2); 
ano=fecha.substr(6,4); 
// Año no viciesto y es febrero y el dia es mayor a 28 
if ( (ano%4 != 0) && (mes ==02) && (dia > 28) ) { fecha=fecha.substr(0,2)+"/"; } 
} 
return (fecha); 
}

//comprobar que el formato de la fecha es correcto
function fechaCorrecta(fecha){
    alert(fecha);
}

function comprobarVacioFecha(objeto,hoy){
    if(objeto.value===''){
        objeto.value=hoy;
    }
    //ahora compruebo que la fecha este en el ejercicio en curso
    var Date=objeto.value.split('/');
    var ejercicio=Date[2];
    var DateHoy=hoy.split('/');
    var ejercicioHoy=DateHoy[2];

    if(ejercicio!==ejercicioHoy){
        alert('Ha cambiado usted la fecha al ejercicio '+ejercicio+'. ¿Es correcto?');
    }
    return true;
}




//funciones para presupuestos y facturas
//
////formateo de numeros
//function formateaCantidad2(objeto){
//    objeto.value=formateaNumeroContabilidad3(objeto.value);
//}    
//
//function formateaNumeroContabilidad3(numero) {
//    decimales=2;
//    separador_decimal=',';
//    separador_miles='.';
//    numero=parseFloat(numero);
//    if(isNaN(numero)){
//        return "";
//    }
//
//    if(decimales!==undefined){
//        // Redondeamos
//        numero=numero.toFixed(decimales);
//    }
//
//    // Convertimos el punto en separador_decimal
//    numero=numero.toString().replace(".", separador_decimal!==undefined ? separador_decimal : ",");
//
//    if(separador_miles){
//        // Añadimos los separadores de miles
//        var miles=new RegExp("(-?[0-9]+)([0-9]{3})");
//        while(miles.test(numero)) {
//            numero=numero.replace(miles, "$1" + separador_miles + "$2");
//        }
//    }
//
//    return numero;
//}    
//
//function desFormateaCantidad2(objeto){
//    objeto.value=desFormateaNumeroContabilidad3(objeto.value);
//}    
//
//function desFormateaNumeroContabilidad3(numero) {
//    //contar los puntos que hay
//    var punto=".";
//    var cont=0;
//    for(i=0;i<numero.length;i++){
//        var let=numero.substring(i,(i+1));
//        if(punto===let){
//            cont=cont + 1;
//        }
//    }
//    //quitar los puntos de miles
//    for (j=0;j<cont;j++){
//        numero=numero.replace(".", "");
//    }
//    //cambiar la coma de decimales por punto
//    numero=numero.replace(",", ".");
//    
//    return numero;
//}
//
//
//
////funcion para los calculos de la linea (importe=cantidad x precio, cuota= importe x IVA y total= importe + cuota)
////como parametros entran los objetos de los inputs en este orden: cantidad,precio,importe,iva,cuota,total
//function facturaCalculoCantidad2(ObjCantidad,ObjPrecio,ObjImporte,ObjIva,ObjCuota,ObjTotal)
//{
//    
//}
//


//funcion para los calculos de la linea (importe=cantidad x precio, cuota= importe x IVA y total= importe + cuota)
//como parametros entran los objetos de los inputs en este orden: cantidad,precio,importe,iva,cuota,total
function facturaCalculoCantidad(ObjCantidad,ObjPrecio,ObjImporte,ObjIva,ObjCuota,ObjTotal)
{
    var cantidad=desFormateaNumeroContabilidad(ObjCantidad.value);
    //var precio=desFormateaNumeroContabilidad(ObjPrecio.value);
    var precio=ObjPrecio.value;
    var iva=desFormateaNumeroContabilidad(ObjIva.value);
    
    //primero compruebo que cantidad no este vacia
    //si esta vacia no hago nada
    //y sino lo esta hago el siguiente calculo: importe = cantidad x precio, cuota = importe x iva y total= importe + cuota
    if(isNaN(cantidad)){
    }else{
        //si hay datos en los campos cantidad y precio
        //hacemos los tres calculos
        if(cantidad!=='' && precio!==''){
            if(cantidad!=='0.00'){
                //importe = cantidad x precio
                var nuevoImporte=cantidad*precio;
                nuevoImporte=truncar2dec(nuevoImporte);
                nuevoImporte=formateaNumeroContabilidad(nuevoImporte.toString());
                ObjImporte.value=nuevoImporte;
                //cuota = importe x iva
                var nuevaCuota=desFormateaNumeroContabilidad(nuevoImporte)*iva/100;
                nuevaCuota=truncar2dec(nuevaCuota);
                nuevaCuota=formateaNumeroContabilidad(nuevaCuota.toString());
                ObjCuota.value=nuevaCuota;
                //total= importe + cuota
                var nuevoTotal=parseFloat(desFormateaNumeroContabilidad(nuevoImporte))+parseFloat(desFormateaNumeroContabilidad(nuevaCuota));
                nuevoTotal=truncar2dec(nuevoTotal);
                nuevoTotal=formateaNumeroContabilidad(nuevoTotal.toString());
                ObjTotal.value=nuevoTotal;
            }else{//la cantidad es 0, ponemos el precio a 0
                ObjPrecio.value='0,00';
            }
        }
    }
}

//funcion para los calculos de la linea (importe=cantidad x precio, cuota= importe x IVA y total= importe + cuota)
//como parametros entran los objetos de los inputs en este orden: cantidad,precio,importe,iva,cuota,total
function facturaCalculoCantidadM(ObjCantidad,ObjPrecio,ObjImporte,ObjIva,ObjCuota,ObjTotal)
{
    var cantidad=desFormateaNumeroContabilidad(ObjCantidad.value);
    //var precio=desFormateaNumeroContabilidad(ObjPrecio.value);
    var precio=ObjPrecio.value;
    var iva=desFormateaNumeroContabilidad(ObjIva.value);
    
    //primero compruebo que cantidad no este vacia
    //si esta vacia no hago nada
    //y sino lo esta hago el siguiente calculo: importe = cantidad x precio, cuota = importe x iva y total= importe + cuota
    if(isNaN(cantidad)){
    }else{
        //si hay datos en los campos cantidad y precio
        //hacemos los tres calculos
        if(cantidad!=='' && precio!==''){
            if(cantidad!=='0.00'){
                //importe = cantidad x precio
                var nuevoImporte=cantidad*precio;
                nuevoImporte=truncar2dec(nuevoImporte);
                nuevoImporte=formateaNumeroContabilidad(nuevoImporte.toString());
                ObjImporte.value=nuevoImporte;
                //cuota = importe x iva
                var nuevaCuota=desFormateaNumeroContabilidad(nuevoImporte)*iva/100;
                nuevaCuota=truncar2dec(nuevaCuota);
                nuevaCuota=formateaNumeroContabilidad(nuevaCuota.toString());
                ObjCuota.value=nuevaCuota;
                //total= importe + cuota
                var nuevoTotal=parseFloat(desFormateaNumeroContabilidad(nuevoImporte))+parseFloat(desFormateaNumeroContabilidad(nuevaCuota));
                nuevoTotal=truncar2dec(nuevoTotal);
                nuevoTotal=formateaNumeroContabilidad(nuevoTotal.toString());
                ObjTotal.value=nuevoTotal;
            }else{//la cantidad es 0, ponemos el precio a 0
                ObjPrecio.value='0,00';
            }
        }
    }
}

function facturaCalculoPrecio(ObjCantidad,ObjPrecio,ObjPrecioHidden,ObjImporte,ObjIva,ObjCuota,ObjTotal,ObjEsValido)
{
    //mientras opero pongo esValido a false
    ObjEsValido.value=false;
 
    //var cantidad=desFormateaNumeroContabilidad(ObjCantidad.value);
    var cantidad=ObjCantidad.value;
    var precio=ObjPrecioHidden.value;
    ObjPrecio.value=ObjPrecioHidden.value;
    var iva=desFormateaNumeroContabilidad(ObjIva.value);

    //primero compruebo que precio no este vacio
    //si esta vacia no hago nada
    //y sino lo esta hago el siguiente calculo: importe = cantidad x precio, cuota = importe x iva y total= importe + cuota
    if(isNaN(precio)){
    }else{
        //si hay datos en los campos cantidad y precio
        //hacemos los tres calculos
        if(cantidad!=='' && precio!==''){
            if(precio!=='0.00'){
                //importe = cantidad x precio
                var nuevoImporte=cantidad*precio;
                nuevoImporte=truncar2dec(nuevoImporte);
                nuevoImporte=formateaNumeroContabilidad(nuevoImporte.toString());
                ObjImporte.value=nuevoImporte;
                //cuota = importe x iva
                var nuevaCuota=desFormateaNumeroContabilidad(nuevoImporte)*iva/100;
                nuevaCuota=truncar2dec(nuevaCuota);
                nuevaCuota=formateaNumeroContabilidad(nuevaCuota.toString());
                ObjCuota.value=nuevaCuota;
                //total= importe + cuota
                var nuevoTotal=parseFloat(desFormateaNumeroContabilidad(nuevoImporte))+parseFloat(desFormateaNumeroContabilidad(nuevaCuota));
                nuevoTotal=truncar2dec(nuevoTotal);
                nuevoTotal=formateaNumeroContabilidad(nuevoTotal.toString());
                ObjTotal.value=nuevoTotal;
            }else{//la cantidad es 0, ponemos la cantidad a 0
                ObjCantidad.value='0,00';
            }
        }
    }
    //al teminar coloco esValido a true
    ObjEsValido.value=true;
}

function facturaCalculoPrecioM(ObjCantidad,ObjPrecio,ObjPrecioHidden,ObjImporte,ObjIva,ObjCuota,ObjTotal,ObjEsValido)
{
    //mientras opero pongo esValido a false
    ObjEsValido.value=false;
 
    //var cantidad=desFormateaNumeroContabilidad(ObjCantidad.value);
    var cantidad=ObjCantidad.value;
    var precio=ObjPrecioHidden.value;
    //ObjPrecio.value=ObjPrecioHidden.value;
    var iva=desFormateaNumeroContabilidad(ObjIva.value);

    //primero compruebo que precio no este vacio
    //si esta vacia no hago nada
    //y sino lo esta hago el siguiente calculo: importe = cantidad x precio, cuota = importe x iva y total= importe + cuota
    if(isNaN(precio)){
    }else{
        //si hay datos en los campos cantidad y precio
        //hacemos los tres calculos
        if(cantidad!=='' && precio!==''){
            if(precio!=='0.00'){
                //importe = cantidad x precio
                var nuevoImporte=cantidad*precio;
                nuevoImporte=truncar2dec(nuevoImporte);
                nuevoImporte=formateaNumeroContabilidad(nuevoImporte.toString());
                ObjImporte.value=nuevoImporte;
                //cuota = importe x iva
                var nuevaCuota=desFormateaNumeroContabilidad(nuevoImporte)*iva/100;
                nuevaCuota=truncar2dec(nuevaCuota);
                nuevaCuota=formateaNumeroContabilidad(nuevaCuota.toString());
                ObjCuota.value=nuevaCuota;
                //total= importe + cuota
                var nuevoTotal=parseFloat(desFormateaNumeroContabilidad(nuevoImporte))+parseFloat(desFormateaNumeroContabilidad(nuevaCuota));
                nuevoTotal=truncar2dec(nuevoTotal);
                nuevoTotal=formateaNumeroContabilidad(nuevoTotal.toString());
                ObjTotal.value=nuevoTotal;
            }else{//la cantidad es 0, ponemos la cantidad a 0
                ObjCantidad.value='0,00';
            }
        }
    }
    //al teminar coloco esValido a true
    ObjEsValido.value=true;
}

function facturaCalculoImporte(ObjCantidad,ObjPrecio,ObjImporte,ObjIva,ObjCuota,ObjTotal,ObjEsValido)
{
    //mientras opero pongo esValido a false
    ObjEsValido.value=false;
    
    var cantidad=desFormateaNumeroContabilidad(ObjCantidad.value);//sino hay datos en el campo sale 0
    var precio=desFormateaNumeroContabilidad(ObjPrecio.value);//sino hay datos en el campo sale 0
    var importe=desFormateaNumeroContabilidad(ObjImporte.value);
    var iva=desFormateaNumeroContabilidad(ObjIva.value);

    
    if(isNaN(precio) || isNaN(cantidad)){
    }else{
        if(cantidad===0 || precio===0 || cantidad==='0.00' || precio==='0.00'){
            //actualizo os valores de cuota y total
            facturaCalculoIVA(ObjImporte,ObjIva,ObjCuota,ObjTotal);
            //al teminar coloco esValido a true
            ObjEsValido.value=true;
        }else{
            //compruebo si hay datos en cantidad y precio que se cumpla la ecuacion -> importe = cantidad x precio
            //sino indico que hay ese error y lo marco en las casillas de cantidad, precio e importe
            var importeComp=cantidad*precio;
            importeComp=truncar2dec(importeComp);
            if(parseFloat(importe)!==importeComp){
                ObjCantidad.style.borderColor='#FF0000';
                ObjPrecio.style.borderColor='#FF0000';
                ObjImporte.style.borderColor='#FF0000';
                facturaCalculoIVA(ObjImporte,ObjIva,ObjCuota,ObjTotal);
                alert('Los datos introducidos no son correctos, hay una incongruencia en cantidad, precio o importe');
            }else{
                //si esta bien calculo los valores de cuota y total
                facturaCalculoIVA(ObjImporte,ObjIva,ObjCuota,ObjTotal);
                //al teminar coloco esValido a true
                ObjEsValido.value=true;
            }
        }
    }
}

function facturaCalculoIVA(ObjImporte,ObjIVA,ObjCuota,ObjTotal){

    var iva=desFormateaNumeroContabilidad(ObjIVA.value);
    var importe=desFormateaNumeroContabilidad(ObjImporte.value);
    
    //entra como dado el IVA, calculo los campos cuota y total
    //cuota = IVA/100 x importe
    var nuevaCuota=parseInt(iva)/100*importe;
    nuevaCuota=truncar2dec(nuevaCuota);
    nuevaCuota=formateaNumeroContabilidad(nuevaCuota.toString());
    ObjCuota.value=nuevaCuota;
    
    //total = cuota + importe
    var nuevoTotal=parseFloat(importe)+parseFloat(desFormateaNumeroContabilidad(nuevaCuota));
    nuevoTotal=truncar2dec(nuevoTotal);
    nuevoTotal=formateaNumeroContabilidad(nuevoTotal.toString());
    ObjTotal.value=nuevoTotal;
}

function facturaCalculoIRPF(ObjTotalImporte,ObjTotal,ObjIrpf,ObjCuotaIrpf,ObjTotalFinal){

    var totalImporte=desFormateaNumeroContabilidad(ObjTotalImporte.value);
    var irpf=desFormateaNumeroContabilidad(ObjIrpf.value);
    
    //cuota IRPF
    var cuotaIrpf=parseFloat(totalImporte)*parseFloat(irpf)/100;    
    cuotaIrpf=truncar2dec(cuotaIrpf);
    cuotaIrpf=formateaNumeroContabilidad(cuotaIrpf.toString());
    ObjCuotaIrpf.value=cuotaIrpf;
    
    //totalFinal
    var total=desFormateaNumeroContabilidad(ObjTotal.value);
    var totalFinal=parseFloat(total)-parseFloat(desFormateaNumeroContabilidad(cuotaIrpf));
    totalFinal=truncar2dec(totalFinal);
    totalFinal=formateaNumeroContabilidad(totalFinal.toString());
    ObjTotalFinal.value=totalFinal;
}

function facturaCalculoIRPF_M(Importe,Cuota,irpf,totalIrpf,totalFinal){
    var totalImporte=desFormateaNumeroContabilidad(Importe);
    var cuotaIVA=desFormateaNumeroContabilidad(Cuota);
    //cuota IRPF
    var cuotaIrpf=parseFloat(totalImporte)*parseFloat(irpf)/100;    
    var total=parseFloat(totalImporte)+parseFloat(cuotaIVA)-parseFloat(cuotaIrpf);
    
    cuotaIrpf=truncar2dec(cuotaIrpf);
    cuotaIrpf=formateaNumeroContabilidad(cuotaIrpf.toString());
    totalIrpf.innerHTML=cuotaIrpf;
    
    total=truncar2dec(total);
    total=formateaNumeroContabilidad(total.toString());
    totalFinal.innerHTML=total;
    
    //ahora actualizo la variable de sesion (por ajax)
    $.ajax({
      data:{"irpf":irpf,"cuotaIrpf":cuotaIrpf},  
      url: '../vista/ajax/actualizarIRPFsEnSession.php',
      type:"get",
    });
    
}

function onOff_filtro(objeto){
    if(objeto.style.display==='none'){
        $(objeto).slideDown(1000);
    }else{
        $(objeto).slideUp(1000);
    }
}

function comprobarFechaFactura(fecha,fechaUltimaFactura){
    var fechaSeleccionada = fecha.split('/');
    fechaSeleccionada = fechaSeleccionada[2]+'-'+fechaSeleccionada[1]+'-'+fechaSeleccionada[0];

    if(Date.parse(fechaSeleccionada) < Date.parse(fechaUltimaFactura)){
        var fechaU = fechaUltimaFactura.split('-');
        alert ('Existe alguna factura con fecha posterior a la indicada.\nLa fecha de la última factura emitida es '+fechaU[2]+'/'+fechaU[1]+'/'+fechaU[0]);
    }
}

//ventas
function ventasCalcularBruto(Bruto,Comision,Liquido){
    //aqui calculo los datos de los otros dos campos segun el dato del Bruto
    var valorBruto = desFormateaNumeroContabilidad(Bruto.value);
    var valorComision = desFormateaNumeroContabilidad(Comision.value);
    var valorLiquido = desFormateaNumeroContabilidad(Liquido.value);
    
    //Liquido = Bruto - Comision
    valorLiquido = parseFloat(valorBruto) - parseFloat(valorComision);
    
    //actualizo valorComision
    Liquido.value = formateaNumeroContabilidad(valorLiquido.toString());
    return true;
}

function ventasCalcularComision(Bruto,Comision,Liquido){
    //aqui calculo los datos de los otros dos campos segun el dato de la comision
    var valorBruto = desFormateaNumeroContabilidad(Bruto.value);
    var valorComision = desFormateaNumeroContabilidad(Comision.value);
    var valorLiquido = desFormateaNumeroContabilidad(Liquido.value);
    
    //Liquido = Bruto - Comision
    valorLiquido = parseFloat(valorBruto) - parseFloat(valorComision);
    
    //actualizo valorLiquido
    Liquido.value = formateaNumeroContabilidad(valorLiquido.toString());
    return true;
}

function ventasCalcularLiquido(Bruto,Comision,Liquido){
    //aqui calculo los datos de los otros dos campos segun el dato del liquido
    var valorBruto = desFormateaNumeroContabilidad(Bruto.value);
    var valorComision = desFormateaNumeroContabilidad(Comision.value);
    var valorLiquido = desFormateaNumeroContabilidad(Liquido.value);
    
    //Liquido = Bruto - Comision
    valorComision = parseFloat(valorBruto) - parseFloat(valorLiquido);
    
    //actualizo valorComision
    Comision.value = formateaNumeroContabilidad(valorComision.toString());
    return true;
}

</script>
<?php
}

//extrae un listado de los tipos de reclamacion
//esta funcion se utiliza en los ficheros:
//reclalta.php
//reclmodlist.php
//reclmod.php
function TiposReclamacion($selec){
    require_once '../CN/clsCNUsu.php';
    $clsCNUsu=new clsCNRecl();
    $clsCNUsu->setStrBD($_SESSION['mapeo']);
//    $Tipificacion=array();
    $Tipificacion=$clsCNUsu->Tipificaciones();
    //vemos si la vble $selec tiene datos o no
    $strHTML='';
    if($selec==''){
        $strHTML='<OPTION></OPTION>';
        for ($i=1;$i<=count($Tipificacion);$i++){
            $strHTML =$strHTML."<OPTION>".$Tipificacion[$i]."</OPTION>";
        }
    }else{
        for ($i=1;$i<=count($Tipificacion);$i++){
            if(strcmp($selec, $Tipificacion[$i]) == 0){
                $strHTML =$strHTML."<OPTION selected>".$Tipificacion[$i]."</OPTION>";
            }else{
                $strHTML =$strHTML."<OPTION>".$Tipificacion[$i]."</OPTION>";
            }
        }
    }
    return $strHTML;
}

//funcion que escribe la fecha 'dd/mm/yyyy' a date time '0000-00-00 00:00:00'
function fecha_to_DATETIME($fecha){
    $trozos=explode('/',$fecha);
    //compruebo que tenga 2 digitos el formato de dia, sino le añado ceros a la izda
    $long=strlen($trozos[0]);
    for($i=1;$i<=2-$long;$i++){
        $trozos[0]='0'.$trozos[0];
    }
    //compruebo que tenga 2 digitos el formato de dia, sino le añado ceros a la izda
    $long=strlen($trozos[1]);
    for($i=1;$i<=2-$long;$i++){
        $trozos[1]='0'.$trozos[1];
    }
 
    return $trozos[2].'-'.$trozos[1].'-'.$trozos[0].' 00:00:00';
}

//funcion que escribe la fecha 'dd/mm/yyyy' a date time '0000-00-00 23:59:59' (incluye todo el dia)
function fecha_to_DATETIME_F($fecha){
    $trozos=explode('/',$fecha);
    //compruebo que tenga 2 digitos el formato de dia, sino le añado ceros a la izda
    $long=strlen($trozos[0]);
    for($i=1;$i<=2-$long;$i++){
        $trozos[0]='0'.$trozos[0];
    }
    //compruebo que tenga 2 digitos el formato de dia, sino le añado ceros a la izda
    $long=strlen($trozos[1]);
    for($i=1;$i<=2-$long;$i++){
        $trozos[1]='0'.$trozos[1];
    }
 
    return $trozos[2].'-'.$trozos[1].'-'.$trozos[0].' 23:59:59';
}

//codigo de cuenta con 5 digitos
//si hay menos de 5 digitos pongo ceros a la derecha
function formatearCodigo($codigo){
    $long=strlen($codigo);
    for($i=1;$i<=5-$long;$i++){
        $codigo='0'.$codigo;
    }
    return $codigo;
}

//BORRAR PRUEBA A RENOMBRAR Y SI FALLA ES QUE SE USA TODAVIA
//funcion para formatear las cantidades a contabilidad desde PHP
//(copiado del de javascript 'formateaNumeroContabilidad')
//function formateaCantidadCont($valor){
//function formateaCantidadCont2($valor){
//    //$nums = Array();
//    //$numsDec = Array();
//    //$divEnteroDecimal=Array();
//    //$divEnteroDecimal = $valor.split("."); //dividimos enteros y decimales
//    $divEnteroDecimal = explode($valor,"."); //dividimos enteros y decimales
//    
//    //primero formateamos los enteros
//    $nums = explode($divEnteroDecimal[0],""); //Se vacia el valor en un arreglo
//    $lon = strlen($nums) - 1; // Se saca la longitud del arreglo
//    $patron = 3; //Indica cada cuanto se ponen las comas
//    $prox = 2; // Indica en que lugar se debe insertar la siguiente coma
//    $res = "";
//    $resDec="";
// 
//    while ($lon > $prox) {
//        //nums.splice((lon - prox),0,"."); //Se agrega el punto
//        $pos = strpos($lon-$prox, ".");
//        echo $pos;
//        substr($nums, 0, $pos);
//        $prox += $patron; //Se incrementa la posición próxima para colocar el punto
//    }
// 
//    for ($i=0; $i <= count($nums)-1; $i++) {
//        $res += $nums[$i]; //Se crea la nueva cadena para devolver el valor formateado
//    }
//    
//    //ahora formateamos la parte decimal (solo dos digitos), si hay
//    if($divEnteroDecimal[1]!=null){
//        $numsDec = $divEnteroDecimal[1].split(""); //Se vacia el valor en un arreglo
//
//        $j=0;//el indice del array comienza por 0
//        $tamMax=2; //2 decimales
//        while(strlen($numsDec) > $j){
//            if($j < $tamMax){
//                $resDec += $numsDec[$j]; //Se crea la nueva cadena para devolver el valor formateado
//            }
//            $j++;
//        }
//        //vemos si al recorrer la pate decimal quedaban valores a recorrer (Ej si hemos introducido
//        //4. nos quedan dos posisiones (hasta 4.00) o 4.5 (hasta 4.50) nos quedaria una posision
//        $cerosDcha=$tamMax-count($numsDec); 
//        while($cerosDcha>0){
//            $resDec=$resDec.'0';
//            $cerosDcha=$cerosDcha-1;
//        }
//    }else{
//        $resDec='00';
//    }
//    
//    //compruebo que el valor res no este vacio
//    if($res==''){
//        $res='0';
//    }
//    
//    //se junta la parte entera y decimal separado por una coma
//    $resFinal=$res.','.$resDec;
//    
//    return $resFinal;
//    
//}//fin formateaCantidadCont

//prepara una seleccion de las cuentas segun el parametro de entrada que le demos
function CuentasSelect($GRoSUBGR,$valor){
    $clsCNContabilidad=new clsCNContabilidad();
    $clsCNContabilidad->setStrBD($_SESSION['mapeo']);
    $Cuentas=array();
    $Cuentas=$clsCNContabilidad->SelectCuentas($GRoSUBGR,$valor);
    $strHTML="<option></option>";
    for ($i=1;$i<=count($Cuentas);$i++){
        $strHTML =$strHTML."<option value='".$Cuentas[$i]['NumCuenta']."'>".$Cuentas[$i]['cuentas']."</option>";
    }
    return $strHTML;
}

//prepara una seleccion de las cuentas segun el parametro de entrada que le demos
//ESTA ES UNA NUEVA FUNCION QUE IRA SUSTITUYENDO A LA ANTIGUA CuentasSelect
function CuentasSeleccion($GRoSUBGR,$valor,$defecto){
    $clsCNContabilidad=new clsCNContabilidad();
    $clsCNContabilidad->setStrBD($_SESSION['mapeo']);
    $Cuentas=array();
    $Cuentas=$clsCNContabilidad->SelectCuentas($GRoSUBGR,$valor);
    $strHTML="<option></option>";
    for ($i=1;$i<=count($Cuentas);$i++){
        if($Cuentas[$i]['NumCuenta']===$defecto){
            $strHTML =$strHTML."<option value='".$Cuentas[$i]['NumCuenta']."' selected>".$Cuentas[$i]['cuentas']."</option>";
        }else{
            $strHTML =$strHTML."<option value='".$Cuentas[$i]['NumCuenta']."'>".$Cuentas[$i]['cuentas']."</option>";
        }
    }
    return $strHTML;
}

//formatear valores numericos con puntos de miles y comas para decimales
function formateaNumeroContabilidad($valor) {
    if(!is_numeric($valor)){
        return '';
    }else{
        return number_format($valor,2,",",".");
    }
}

function desFormateaNumeroContabilidad($valor){
    //divido la parte entera de la decimal ','
    $numero=explode(",",$valor);
    
    //ahora cojo la parte entera y la divido por los puntos'.'
    $entera=explode(".",$numero[0]);
    
    //ahora recorro este array de enteros y voy añadiendo los trozos
    // entre los puntos para conseguir el numero seguido
    $valorFinal='';
    for($i=0;$i<count($entera);$i++){
        $valorFinal=$valorFinal.$entera[$i];
    }
    //por ultimo lo junto con la parte decimal indicando en punto de estos decimales
    $valorFinal=$valorFinal.'.'.$numero[1];
    return $valorFinal;
}

//funcion de listado de años para el select
function selectEjercicios($lngEjercicio){
    $clsCNContabilidad=new clsCNContabilidad();
    $clsCNContabilidad->setStrBD($_SESSION['dbContabilidad']);
    //primero extraigo el año de alta de la empresa
    $FechaAltaEmpresa=$clsCNContabilidad->FechaAltaEmpresa();
    
    $yearAlta=date('Y',strtotime($FechaAltaEmpresa));
    $yearActual=date('Y');
    
    //ahora generamos el html a presentar del select
    echo '<select name="lngEjercicio" class="textbox1" onchange="submitirEjercicio();">';
    for($i=$yearAlta;$i<=$yearActual;$i++){
        //compruebo si $lngEjercicio=''
        if($lngEjercicio===''){
            if((string)$i===$yearActual){
                echo "<option value = '$i' selected> $i</option>";
            }else{
                echo "<option value = '$i'> $i</option>";
            }
        }else{
            if((string)$i===$lngEjercicio){
                echo "<option value = '$i' selected> $i</option>";
            }else{
                echo "<option value = '$i'> $i</option>";
            }
        }
    }
    echo '</select>';
}

function formateoContador($numeroSinFormatear,$tipoContador){
    $ejercicio=substr($numeroSinFormatear,0,4);
    $numero=substr($numeroSinFormatear,4,4);

    $numero4cifras=$numero;//??
    while(substr($numero,0,1)==='0'){
        $numero=substr($numero,1);
    }

    //ahora segun el tipo de contador presento el numero del presupuesto
    $numeroFactura='';
    switch ($tipoContador) {
        case 'simple':
            $numeroFactura=$numeroSinFormatear;
            break;
        case 'compuesto1':
            $numeroFactura=$numero.'/'.$ejercicio;
            break;
        case 'compuesto2':
            $numeroFactura=$ejercicio.'/'.$numero;
            break;
        default://ningun contador
            $numeroFactura=$numeroSinFormatear;
            break;
    }

    return $numeroFactura;
}

function fechaCabecera($fechaForm){
    //preparo la fecha en forma 20 de diciembre de 2013
    $fechaPartes=explode('/',$fechaForm);
    //escribir mes en texto
    switch ($fechaPartes[1]) {
        case '01':
            $mes='Enero';
            break;
        case '02':
            $mes='Febrero';
            break;
        case '03':
            $mes='Marzo';
            break;
        case '04':
            $mes='Abril';
            break;
        case '05':
            $mes='Mayo';
            break;
        case '06':
            $mes='Junio';
            break;
        case '07':
            $mes='Julio';
            break;
        case '08':
            $mes='Agosto';
            break;
        case '09':
            $mes='Septiembre';
            break;
        case '10':
            $mes='Octubre';
            break;
        case '11':
            $mes='Noviembre';
            break;
        case '12':
            $mes='Diciembre';
            break;
    }
    //unas veces vendra la fecha con formato Y/m/d (2013/12/22) y otras con d/m/Y (22/12/2013)
    //para saber el año se comprueba que [0] o [2] tenga 4 digitos
    if(strlen($fechaPartes[0])==4){
        $year=$fechaPartes[0];
        $day=$fechaPartes[2];
    }else{
        $year=$fechaPartes[2];
        $day=$fechaPartes[0];
    }

    return $day.' de '.$mes.' de '.$year;
}

//mapeo periodo
function macheaPeriodo($periodo){
    // HAY QUE PONER 0, 13 Y 14 BIEN
    switch ($periodo) {
        case 'APERTURA':
            return 1;
        case 'ENERO':
            return 1;
        case 'FEBRERO':
            return 2;
        case 'MARZO':
            return 3;
        case 'ABRIL':
            return 4;
        case 'MAYO':
            return 5;
        case 'JUNIO':
            return 6;
        case 'JULIO':
            return 7;
        case 'AGOSTO':
            return 8;
        case 'SEPTIEMBRE':
            return 9;
        case 'OCTUBRE':
            return 10;
        case 'NOVIEMBRE':
            return 11;
        case 'DICIEMBRE':
            return 12;
        case 'CIERRE_E':
            return 12;
        case 'CIERRE_C':
            return 12;
        default:
            return 1;
    }
}

//mapeo periodo Nombre
function mapeaPeriodoNombre($periodo){
    // HAY QUE PONER 0, 13 Y 14 BIEN
    switch ($periodo) {
        case 'APERTURA':
            return 'Apertura';
        case 'ENERO':
            return 'Enero';
        case 'FEBRERO':
            return 'Febrero';
        case 'MARZO':
            return 'Marzo';
        case 'ABRIL':
            return 'Abril';
        case 'MAYO':
            return 'Mayo';
        case 'JUNIO':
            return 'Junio';
        case 'JULIO':
            return 'Julio';
        case 'AGOSTO':
            return 'Agosto';
        case 'SEPTIEMBRE':
            return 'Septiembre';
        case 'OCTUBRE':
            return 'Octubre';
        case 'NOVIEMBRE':
            return 'Noviembre';
        case 'DICIEMBRE':
            return 'Diciembre';
        case 'CIERRE_E':
            return 'Cierre Ejercicio';
        case 'CIERRE_C':
            return 'Cierre Contable';
        default:
            return '';
    }
}

//Ventas
function presentarAsiento($nombre,$dato,$i,$tab){
    $html = "<select id='AsientoBanco".$nombre."' name='AsientoBanco".$nombre."' tabindex='".$nombre.$tab."' onchange='actAsiento(".$i.",this.value);'>";
    $seleP = '';
    $seleX = '';
    if($dato === 'P'){
        $seleP = 'selected';
    }else{
        $seleX = 'selected';
    }
    $html = $html . '<option value="P" '.$seleP.'>P</option>';
    $html = $html . '<option value="X" '.$seleX.'>X</option>';
    $html = $html . '</select>';
    
    return $html;
}

function presentarCuentas($nombre,$ii,$cuentaSelecc,$IdBanco,$tab){
    $clsCNDatosVentas = new clsCNDatosVentas();
    $clsCNDatosVentas->setStrBD($_SESSION['dbContabilidad']);
    $clsCNDatosVentas->setStrBDCliente($_SESSION['mapeo']);
    
    if($cuentaSelecc !== null){
        $listado = $clsCNDatosVentas->ListadoBancosCuenta();

        $html = "<select id='".$nombre.$ii."' name='".$nombre.$ii."' tabindex='".$ii.$tab."' onchange='actCuenta(this.value,".$ii.");'>";
        $html = $html . '<option value="570000000" selected>0 - Caja</option>';

        for ($i = 0; $i < count($listado); $i++) {
            $cuenta = (int) substr($listado[$i]['NumCuenta'],4);
//            if($cuenta !== 0){
                if((int)$cuentaSelecc === (int)$listado[$i]['NumCuenta']){
                    $html = $html . '<option value="'.$listado[$i]['NumCuenta'].'" selected>'.$cuenta.' - '.$listado[$i]['Nombre']. '</option>';
                }else{
                    $html = $html . '<option value="'.$listado[$i]['NumCuenta'].'">'.$cuenta.' - '.$listado[$i]['Nombre']. '</option>';
                }
//            }
        }
        $html = $html . '</select>';
    }else{
        $html = '';
    }
    
    return $html;
}


?>

