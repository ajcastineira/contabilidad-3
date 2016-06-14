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



$clsCNContabilidad=new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['mapeo']);


logger('info','presentar_irpf.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
       " ||||Consulta->I.R.P.F.||");


//recojo la vble lngEjercicio que venga por GET (si viene) o del año actual
if(isset($_GET['lngEjercicio'])){
    $lngEjercicio=$_GET['lngEjercicio'];
}else{
    date_default_timezone_set('Europe/Madrid');
    $lngEjercicio=date('Y');
}

//calculo los datos que se presentan en esta consulta
logger('traza','presentar_irpf.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
       " clsCNContabilidad->calculoDatosIRPF($lngEjercicio)>");
$datosPresentar=$clsCNContabilidad->calculoDatosIRPF($lngEjercicio);  

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="../images/q.ico">
        <title>Consulta I.R.P.F.</title>
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
        <SCRIPT language="JavaScript" src="../js/car_valido.js"> 
        </SCRIPT>
        <SCRIPT languaje="JavaScript" src="../js/valida.js"> 
            <!--
            alert('Error en el fichero valida.js');
            // -->
        </SCRIPT>
        <link href="../css/Estilos_Qualidad.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="../css/calidad2.css" type="text/css">

        <!--            HE INCLUIDO AQUI ESTAS LIBRERIAS DE jQuery PACO-->
        <?php
        librerias_jQuery_listado();
        ?>
        <!--       FIN     HE INCLUIDO AQUI ESTAS LIBRERIAS DE jQuery PACO-->

        <style>
            *{
                /*font-family: arial;*/
            }
        </style>
<style type="text/css">
/* para que no salga el rectangulo inferior */        
.ui-widget-content {
    border: 0px solid #AAAAAA;
}
</style>      

<script LANGUAGE="JavaScript"> 

function avisarAnteriorAbierto(trimestre){
    if(trimestre=='Cierre1T'){
        trimestreTxt=' el 4 trimestre del año anterior';
    }else if(trimestre=='Cierre2T'){
        trimestreTxt=' el 1 trimestre';
    }else if(trimestre=='Cierre3T'){
        trimestreTxt=' el 2 trimestre';
    }else if(trimestre=='Cierre4T'){
        trimestreTxt=' el 3 trimestre';
    }
    alert('No se puede cerrar este trimestre sin haber cerrado antes'+trimestreTxt);
}

function submitirEjercicio(){
    document.form1.submit();
}
function Volver(){
    window.location='../vista/default2.php';
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
<table align="center" border="0" width="701">
    <tr>
        <td>
            <h3 align="center" color="#FFCC66">Resultados IRPF</h3>

            <form name="form1" action="../vista/presentar_irpf.php" method="get">
                <table class="filtro" align="center" border="0" width="954">
                    <tr></tr>
                    <tr><td>
                <table class="filtro" align="center" border="0" width="300">
                    <tr> 
                      <td class="nombreCampo">
                          <div align="right">
                            <h3 color="#FFCC66"><font size="3px">Ejercicio:</font></h3>
                          </div>
                    </td>
                    <td width="60">
                        <div align="left">
                        <?php selectEjercicios($lngEjercicio); ?>    
                        </div>
                    </td>
                    <td>
                        <input type="submit" class="button" value="Consultar" />
                    </td>
                    </tr>
                </table>
                </td></tr>
                <tr></tr>
                </table>   
            </form> 
            <br/><br/><br/>
            <div align="center">
                <table class="tablaPresentacion" border="0">
                    <thead>
                        <tr class="tablaPresentacionCabecera" style="height:20px;">
                            <td colspan="5" ><strong>&nbsp;I. Rendimientos del Trabajo</strong></td>
                            <td class="tablaEspacio"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th></th>
                            <th>1T</th>
                            <th>2T</th>
                            <th>3T</th>
                            <th>4T</th>
                            <th class="tablaEspacio"></th>
                            <th>TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="pares">
                            <td><strong>Base</strong></td>
                            <td><!-- BaseA 1T --><table class="tablaPresentacionCasilla"><tr><td><?php echo $datosPresentar['1T']['BaseA'];?></td></tr></table></td>
                            <td><!-- BaseA 2T --><table class="tablaPresentacionCasilla"><tr><td><?php echo $datosPresentar['2T']['BaseA'];?></td></tr></table></td>
                            <td><!-- BaseA 3T --><table class="tablaPresentacionCasilla"><tr><td><?php echo $datosPresentar['3T']['BaseA'];?></td></tr></table></td>
                            <td><!-- BaseA 4T --><table class="tablaPresentacionCasilla"><tr><td><?php echo $datosPresentar['4T']['BaseA'];?></td></tr></table></td>
                            <td class="tablaEspacio"></td>
                            <td><table class="tablaPresentacionCasilla"><tr><td><strong><?php echo $datosPresentar['Total']['BaseA'];?></strong></td></tr></table></td>
                        </tr>
                        <tr class="impares">
                            <td><strong>Retenciones</strong></td>
                            <td><!-- RetencionesA 1T --><table class="tablaPresentacionCasilla"><tr><td><?php echo $datosPresentar['1T']['RetencionesA'];?></td></tr></table></td>
                            <td><!-- RetencionesA 2T --><table class="tablaPresentacionCasilla"><tr><td><?php echo $datosPresentar['2T']['RetencionesA'];?></td></tr></table></td>
                            <td><!-- RetencionesA 3T --><table class="tablaPresentacionCasilla"><tr><td><?php echo $datosPresentar['3T']['RetencionesA'];?></td></tr></table></td>
                            <td><!-- RetencionesA 4T --><table class="tablaPresentacionCasilla"><tr><td><?php echo $datosPresentar['4T']['RetencionesA'];?></td></tr></table></td>
                            <td class="tablaEspacio"></td>
                            <td><table class="tablaPresentacionCasilla"><tr><td><strong><?php echo $datosPresentar['Total']['RetencionesA'];?></strong></td></tr></table></td>
                        </tr>
                    </tbody>
                    <thead>
                        <tr class="tablaPresentacionCabecera" style="height:20px;">
                            <td colspan="5" ><strong>&nbsp;II. Rendimientos de Actividades Económicas</strong></td>
                            <td class="tablaEspacio"></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="pares">
                            <td><strong>Base</strong></td>
                            <td><!-- BaseG 1T --><table class="tablaPresentacionCasilla"><tr><td><?php echo $datosPresentar['1T']['BaseG'];?></td></tr></table></td>
                            <td><!-- BaseG 2T --><table class="tablaPresentacionCasilla"><tr><td><?php echo $datosPresentar['2T']['BaseG'];?></td></tr></table></td>
                            <td><!-- BaseG 3T --><table class="tablaPresentacionCasilla"><tr><td><?php echo $datosPresentar['3T']['BaseG'];?></td></tr></table></td>
                            <td><!-- BaseG 4T --><table class="tablaPresentacionCasilla"><tr><td><?php echo $datosPresentar['4T']['BaseG'];?></td></tr></table></td>
                            <td class="tablaEspacio"></td>
                            <td><table class="tablaPresentacionCasilla"><tr><td><strong><?php echo $datosPresentar['Total']['BaseG'];?></strong></td></tr></table></td>
                        </tr>
                        <tr class="impares">
                            <td><strong>Retenciones</strong></td>
                            <td><!-- RetencionesG 1T --><table class="tablaPresentacionCasilla"><tr><td><?php echo $datosPresentar['1T']['RetencionesG'];?></td></tr></table></td>
                            <td><!-- RetencionesG 2T --><table class="tablaPresentacionCasilla"><tr><td><?php echo $datosPresentar['2T']['RetencionesG'];?></td></tr></table></td>
                            <td><!-- RetencionesG 3T --><table class="tablaPresentacionCasilla"><tr><td><?php echo $datosPresentar['3T']['RetencionesG'];?></td></tr></table></td>
                            <td><!-- RetencionesG 4T --><table class="tablaPresentacionCasilla"><tr><td><?php echo $datosPresentar['4T']['RetencionesG'];?></td></tr></table></td>
                            <td class="tablaEspacio"></td>
                            <td><table class="tablaPresentacionCasilla"><tr><td><strong><?php echo $datosPresentar['Total']['RetencionesG'];?></strong></td></tr></table></td>
                        </tr>
                        <tr style="height:10px"></tr>
                        <tr class="totales">
                            <td><strong>A Ingresar</strong></td>
                            <td><!-- A Ingresar 1T --><table class="tablaPresentacionCasilla"><tr><td><strong><?php echo $datosPresentar['TrimestresTotal']['1T'];?></strong></td></tr></table></td>
                            <td><!-- A Ingresar 2T --><table class="tablaPresentacionCasilla"><tr><td><strong><?php echo $datosPresentar['TrimestresTotal']['2T'];?></strong></td></tr></table></td>
                            <td><!-- A Ingresar 3T --><table class="tablaPresentacionCasilla"><tr><td><strong><?php echo $datosPresentar['TrimestresTotal']['3T'];?></strong></td></tr></table></td>
                            <td><!-- A Ingresar 4T --><table class="tablaPresentacionCasilla"><tr><td><strong><?php echo $datosPresentar['TrimestresTotal']['4T'];?></strong></td></tr></table></td>
                            <td class="tablaEspacio"></td>
                            <td><table class="tablaPresentacionCasilla"><tr><td><strong><?php echo $datosPresentar['TrimestresTotal']['Total'];?></strong></td></tr></table></td>
                        </tr>
                        <tr style="height:10px"></tr>
                        <?php
                        //ahora presentamos los botones de cierre trimestral
                        //si el cierre esta hecho aparece indicado y desactivado
                        //sino aparece activado
                        ?>
                        <tr bgcolor="#FFFFFF">
                            <form name="form" action="../vista/irpf_datosPresentar.php" method="get">
                            <td></td>
                            <td width="50%" height="50%">
                                <?php
                                if($datosPresentar['1T']['Esta_Cerrado']=='NO'){
                                    //ahora reviso si la fecha de hoy y compruebo si:
                                    //ACTUAL- Está dentro del trimestre
                                    //ANTERIOR- O es superior al trimestre (trimestres anteriores sin cerrar)
                                    //POSTERIOR- O es un trimestre superior
                                    $trimestreEnFecha=$clsCNContabilidad->trimestreEnFecha('1T',$lngEjercicio);

                                    //segun sea ACTUAL, ANTERIOR o POSTERIOR aparece el boton activado o no
                                    if($trimestreEnFecha=='ACTUAL'){
                                        //compruebo si es trimestre anterior esta cerrado o no
                                        if($datosPresentar['0T']['Esta_Cerrado']=='SI'){
                                            $datosIRPF=  serialize($datosPresentar['1T']);
                                            $datosIRPF = urlencode($datosIRPF); 
                                            ?>
                                            <input type="hidden" name="lngEjercicio" value="<?php echo $lngEjercicio;?>" />
                                            <input type="hidden" name="datosIRPF" value="<?php echo $datosIRPF;?>" />
                                            <input type="submit" class="button" value="Cierre 1T" name="cmdCierre" />
                                            <?php
                                        }else{
                                            //si el trimestre esta abierto NO dejo cerrar
                                            ?>    
                                            <input type="button" class="button" value="Cierre 1T" name="cmdCierre" onclick="avisarAnteriorAbierto('Cierre1T');" />
                                            <?php
                                        }
                                    }else if($trimestreEnFecha=='ANTERIOR'){
                                        //compruebo si es trimestre anterior esta cerrado o no
                                        if($datosPresentar['0T']['Esta_Cerrado']=='SI'){
                                            $datosIRPF=  serialize($datosPresentar['1T']);
                                            $datosIRPF = urlencode($datosIRPF); 
                                            ?>
                                            <input type="hidden" name="lngEjercicio" value="<?php echo $lngEjercicio;?>" />
                                            <input type="hidden" name="datosIRPF" value="<?php echo $datosIRPF;?>" />
                                            <input type="submit" class="button" value="Cierre 1T" name="cmdCierre" />
                                        <?php
                                        }else{
                                            //si el trimestre esta abierto NO dejo cerrar
                                            ?>    
                                            <input type="button" class="button" value="Cierre 1T" name="cmdCierre" onclick="avisarAnteriorAbierto('Cierre1T');" />
                                            <?php
                                        }
                                    }else if($trimestreEnFecha=='POSTERIOR'){
                                    ?>
                                    <input type="submit" class="buttonDesactivado" value="Cierre 1T" disabled />
                                    <?php
                                    }
                                //si no esta cerrado el trimestre NO podemos cerrar
                                }else if($datosPresentar['1T']['Esta_Cerrado']=='SI'){
                                ?>
                                <input type="submit" class="buttonDesactivado" value="Trimestre Cerrado" disabled />
                                <?php
                                }else{
                                ?>
                                <input type="submit" class="buttonDesactivado" value="Cierre 1T" disabled />
                                <?php
                                }
                                
//BORRAR                                
                                ?>
                            </td>
                            <td width="50%" height="50%">
                                <?php
                                if($datosPresentar['2T']['Esta_Cerrado']=='NO'){
                                    //ahora reviso si la fecha de hoy y compruebo si:
                                    //ACTUAL- Está dentro del trimestre
                                    //ANTERIOR- O es superior al trimestre (trimestres anteriores sin cerrar)
                                    //POSTERIOR- O es un trimestre superior
                                    $trimestreEnFecha=$clsCNContabilidad->trimestreEnFecha('2T',$lngEjercicio);

                                    //segun sea ACTUAL, ANTERIOR o POSTERIOR aparece el boton activado o no
                                    if($trimestreEnFecha=='ACTUAL'){
                                        //compruebo si es trimestre anterior esta cerrado o no
                                        if($datosPresentar['1T']['Esta_Cerrado']=='SI'){
                                            $datosIRPF=  serialize($datosPresentar['2T']);
                                            $datosIRPF = urlencode($datosIRPF); 
                                            ?>
                                            <input type="hidden" name="lngEjercicio" value="<?php echo $lngEjercicio;?>" />
                                            <input type="hidden" name="datosIRPF" value="<?php echo $datosIRPF;?>" />
                                            <input type="submit" class="button" value="Cierre 2T" name="cmdCierre" />
                                            <?php
                                        }else{
                                            //si el trimestre esta abierto NO dejo cerrar
                                            ?>    
                                            <input type="button" class="button" value="Cierre 2T" name="cmdCierre" onclick="avisarAnteriorAbierto('Cierre2T');" />
                                            <?php
                                        }
                                    }else if($trimestreEnFecha=='ANTERIOR'){
                                        //compruebo si es trimestre anterior esta cerrado o no
                                        if($datosPresentar['1T']['Esta_Cerrado']=='SI'){
                                            $datosIRPF=  serialize($datosPresentar['2T']);
                                            $datosIRPF = urlencode($datosIRPF); 
                                            ?>
                                            <input type="hidden" name="lngEjercicio" value="<?php echo $lngEjercicio;?>" />
                                            <input type="hidden" name="datosIRPF" value="<?php echo $datosIRPF;?>" />
                                            <input type="submit" class="button" value="Cierre 2T" name="cmdCierre" />
                                        <?php
                                        }else{
                                            //si el trimestre esta abierto NO dejo cerrar
                                            ?>    
                                            <input type="button" class="button" value="Cierre 2T" name="cmdCierre" onclick="avisarAnteriorAbierto('Cierre2T');" />
                                            <?php
                                        }
                                    }else if($trimestreEnFecha=='POSTERIOR'){
                                    ?>
                                    <input type="submit" class="buttonDesactivado" value="Cierre 2T" disabled />
                                    <?php
                                    }
                                //si no esta cerrado el trimestre NO podemos cerrar
                                }else if($datosPresentar['2T']['Esta_Cerrado']=='SI'){
                                ?>
                                <input type="submit" class="buttonDesactivado" value="Trimestre Cerrado" disabled />
                                <?php
                                }else{
                                ?>
                                <input type="submit" class="buttonDesactivado" value="Cierre 2T" disabled />
                                <?php
                                }
                                ?>
                            </td>
                            <td width="50%" height="50%">
                                <?php
                                if($datosPresentar['3T']['Esta_Cerrado']=='NO'){
                                    //ahora reviso si la fecha de hoy y compruebo si:
                                    //ACTUAL- Está dentro del trimestre
                                    //ANTERIOR- O es superior al trimestre (trimestres anteriores sin cerrar)
                                    //POSTERIOR- O es un trimestre superior
                                    $trimestreEnFecha=$clsCNContabilidad->trimestreEnFecha('3T',$lngEjercicio);

                                    //segun sea ACTUAL, ANTERIOR o POSTERIOR aparece el boton activado o no
                                    if($trimestreEnFecha=='ACTUAL'){
                                        //compruebo si es trimestre anterior esta cerrado o no
                                        if($datosPresentar['2T']['Esta_Cerrado']=='SI'){
                                            $datosIRPF=  serialize($datosPresentar['3T']);
                                            $datosIRPF = urlencode($datosIRPF); 
                                            ?>
                                            <input type="hidden" name="lngEjercicio" value="<?php echo $lngEjercicio;?>" />
                                            <input type="hidden" name="datosIRPF" value="<?php echo $datosIRPF;?>" />
                                            <input type="submit" class="button" value="Cierre 3T" name="cmdCierre" />
                                            <?php
                                        }else{
                                            //si el trimestre esta abierto NO dejo cerrar
                                            ?>    
                                            <input type="button" class="button" value="Cierre 3T" name="cmdCierre" onclick="avisarAnteriorAbierto('Cierre3T');" />
                                            <?php
                                        }
                                    }else if($trimestreEnFecha=='ANTERIOR'){
                                        //compruebo si es trimestre anterior esta cerrado o no
                                        if($datosPresentar['2T']['Esta_Cerrado']=='SI'){
                                            $datosIRPF=  serialize($datosPresentar['3T']);
                                            $datosIRPF = urlencode($datosIRPF); 
                                            ?>
                                            <input type="hidden" name="lngEjercicio" value="<?php echo $lngEjercicio;?>" />
                                            <input type="hidden" name="datosIRPF" value="<?php echo $datosIRPF;?>" />
                                            <input type="submit" class="button" value="Cierre 3T" name="cmdCierre" />
                                        <?php
                                        }else{
                                            //si el trimestre anterior esta abierto NO dejo cerrar
                                            ?>    
                                            <input type="button" class="button" value="Cierre 3T" name="cmdCierre" onclick="avisarAnteriorAbierto('Cierre3T');" />
                                            <?php
                                        }
                                    }else if($trimestreEnFecha=='POSTERIOR'){
                                    ?>
                                    <input type="submit" class="buttonDesactivado" value="Cierre 3T" disabled />
                                    <?php
                                    }
                                //si no esta cerrado el trimestre NO podemos cerrar
                                }else if($datosPresentar['3T']['Esta_Cerrado']=='SI'){
                                ?>
                                <input type="submit" class="buttonDesactivado" value="Trimestre Cerrado" disabled />
                                <?php
                                }else{
                                ?>
                                <input type="submit" class="buttonDesactivado" value="Cierre 3T" disabled />
                                <?php
                                }
                                ?>
                            </td>
                            <td width="50%" height="50%">
                                <?php
                                if($datosPresentar['4T']['Esta_Cerrado']=='NO'){
                                    //ahora reviso si la fecha de hoy y compruebo si:
                                    //ACTUAL- Está dentro del trimestre
                                    //ANTERIOR- O es superior al trimestre (trimestres anteriores sin cerrar)
                                    //POSTERIOR- O es un trimestre superior
                                    $trimestreEnFecha=$clsCNContabilidad->trimestreEnFecha('4T',$lngEjercicio);

                                    //segun sea ACTUAL, ANTERIOR o POSTERIOR aparece el boton activado o no
                                    if($trimestreEnFecha=='ACTUAL'){
                                        //compruebo si es trimestre anterior esta cerrado o no
                                        if($datosPresentar['3T']['Esta_Cerrado']=='SI'){
                                            $datosIRPF=  serialize($datosPresentar['4T']);
                                            $datosIRPF = urlencode($datosIRPF); 
                                            ?>
                                            <input type="hidden" name="lngEjercicio" value="<?php echo $lngEjercicio;?>" />
                                            <input type="hidden" name="datosIRPF" value="<?php echo $datosIRPF;?>" />
                                            <input type="submit" class="button" value="Cierre 4T" name="cmdCierre" />
                                            <?php
                                        }else{
                                            //si el trimestre esta abierto NO dejo cerrar
                                            ?>    
                                            <input type="button" class="button" value="Cierre 4T" name="cmdCierre" onclick="avisarAnteriorAbierto('Cierre4T');" />
                                            <?php
                                        }
                                    }else if($trimestreEnFecha=='ANTERIOR'){
                                        //compruebo si es trimestre anterior esta cerrado o no
                                        if($datosPresentar['3T']['Esta_Cerrado']=='SI'){
                                            $datosIRPF=  serialize($datosPresentar['4T']);
                                            $datosIRPF = urlencode($datosIRPF); 
                                            ?>
                                            <input type="hidden" name="lngEjercicio" value="<?php echo $lngEjercicio;?>" />
                                            <input type="hidden" name="datosIRPF" value="<?php echo $datosIRPF;?>" />
                                            <input type="submit" class="button" value="Cierre 4T" name="cmdCierre" />
                                        <?php
                                        }else{
                                            //si el trimestre anterior esta abierto NO dejo cerrar
                                            ?>    
                                            <input type="button" class="button" value="Cierre 4T" name="cmdCierre" onclick="avisarAnteriorAbierto('Cierre4T');" />
                                            <?php
                                        }
                                    }else if($trimestreEnFecha=='POSTERIOR'){
                                    ?>
                                    <input type="submit" class="buttonDesactivado" value="Cierre 4T" disabled />
                                    <?php
                                    }
                                //si no esta cerrado el trimestre NO podemos cerrar
                                }else if($datosPresentar['4T']['Esta_Cerrado']=='SI'){
                                ?>
                                <input type="submit" class="buttonDesactivado" value="Trimestre Cerrado" disabled />
                                <?php
                                }else{
                                ?>
                                <input type="submit" class="buttonDesactivado" value="Cierre 4T" disabled />
                                <?php
                                }
                                ?>
                            </td>
                            <td class="tablaEspacio"></td>
                            </form>
<!--                            <form name="form" action="../vista/xxxxxxx" method="get">-->
                            <td width="50%" height="50%">
                                <input type="button" class="button" value="Cierre Ejercicio" />
                            </td>
<!--                            </form>-->
                        </tr>
                        <tr>
                            <td colspan="7">
                                <input type="button" class="button" value="Volver" onclick="Volver();" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <br/><br/><br/>
            <?php include '../vista/IndicacionIncidencia.php'; ?>
        </td>
        </tr>
        </table>
    </body>
</html>
