<?php
session_start ();
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

logger('info','gastos_entrada.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
       " ||||Operaciones->Mis Gastos||(Menu eleccion)");

?>
<!DOCTYPE html>
<html>
<head>
<TITLE>Alta de Ingresos - Opciones</TITLE>

<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>

        
</head>
<body>
           
<div data-role="page" id="ingresos_entrada">
<?php
eventosInputText();
?>
<script language="JavaScript">

function ActivaForm(objeto){
    if(objeto.value==='ConFactura'){
        document.getElementById('formOpciones').style.display='block';
    }else{
        document.getElementById('formOpciones').style.display='none';
    }
}

</script>        

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>
    
    <div data-role="content" data-theme="a">
        <h4>Contabilizar Ingresos</h4>
        <form action="../vista/ingresos_entrada.php" name="form1" method="POST" data-ajax="false">
            <table border="0" style="width: 100%;">
                <tr>
                    <td>
                    <label>Factura</label>
                    </td>
                </tr>
                <tr>
                    <td>
                    <div class="ui-field-contain">
                        <fieldset data-role="controlgroup" data-mini="true">
                            <input type="radio" name="optFactura" id="optFacturaCon" class="custom" value="ConFactura" checked="checked"
                                   data-theme="a" data-iconpos="right" onClick="ActivaForm(this);">
                            <label for="optFacturaCon">Con Factura</label>
                            <input type="radio" name="optFactura" id="optFacturaSin" class="custom" value="SinFactura"
                                   data-theme="a" data-iconpos="right" onClick="ActivaForm(this);">
                            <label for="optFacturaSin">Sin Factura</label>
                        </fieldset>
                    </div>
                    </td>
                </tr>
            </table>
            
            <div id="formOpciones" style="display:block">
            <table border="0" style="width: 100%;">
                <tr>
                    <td>
                    <label>IVA</label>
                    </td>
                </tr>
                <tr>
                    <td>
                    <div class="ui-field-contain">
                        <fieldset data-role="controlgroup" data-mini="true">
                            <input type="radio" name="optTipoIVA" id="IVA1" class="custom" value="IVA1" checked="checked"
                                   data-theme="a" data-iconpos="right" onClick="">
                            <label for="IVA1">1 sólo tipo de IVA</label>
                            <input type="radio" name="optTipoIVA" id="IVA_Varios" class="custom" value="IVA_Varios"
                                   data-theme="a" data-iconpos="right" onClick="">
                            <label for="IVA_Varios">Varios tipos de IVA</label>
                        </fieldset>
                    </div>
                    </td>
                </tr>
                <tr>
                    <td height="15px"></td>
                </tr>
                <tr>
                    <td>
                    <label>IRPF</label>
                    </td>
                </tr>
                <tr>
                    <td>
                    <div class="ui-field-contain">
                        <fieldset data-role="controlgroup" data-mini="true">
                            <input type="radio" name="optRetIRPF" id="SinRetencionIRPF" class="custom" value="SinRetencionIRPF" checked="checked"
                                   data-theme="a" data-iconpos="right" onClick="">
                            <label for="SinRetencionIRPF">Factura sin retención IRPF</label>
                            <input type="radio" name="optRetIRPF" id="ConRetencionIRPF" class="custom" value="ConRetencionIRPF"
                                   data-theme="a" data-iconpos="right" onClick="">
                            <label for="ConRetencionIRPF">Factura con retención IRPF</label>
                        </fieldset>
                    </div>
                    </td>
                </tr>
                <tr>
                    <td height="15px"></td>
                </tr>
            </table>
            </div>
            
            <table border="0" style="width: 100%;">
                <tr>
                    <td style="width: 22%;"></td>
                    <td style="width: 23%;"></td>
                    <td style="width: 23%;"></td>
                    <td style="width: 22%;"></td>
                </tr>
                <tr>
                    <td colspan="4">
                    <label>Abono (Factura rectificativa)</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                    <div class="ui-field-contain">
                        <fieldset data-role="controlgroup" data-mini="true">
                            <input type="radio" name="optAbono" id="NO" class="custom" value="NO" checked="checked"
                                   data-theme="a" data-iconpos="right" onClick="">
                            <label for="NO">No</label>
                            <input type="radio" name="optAbono" id="SI" class="custom" value="SI"
                                   data-theme="a" data-iconpos="right" onClick="">
                            <label for="SI">Si</label>
                        </fieldset>
                    </div>
                    </td>
                </tr>
                <tr>
                    <td height="15px"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2">
                    <div align="center">
                        <input type="submit" data-theme="a" data-icon="forward" data-iconpos="right" value = "Continuar" /> 
                    </div>
                    </td>
                </tr>
            </table>
        </form>
        
    </div>
</div>
</body>
</html>
