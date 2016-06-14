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
       " ||||Operaciones->Compras y Gastos||(Menu eleccion)");

?>
<!DOCTYPE html>
<html>
<head>
<TITLE>Nóminas</TITLE>

<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>

        
</head>
<body>
           
<div data-role="page" id="gastos_entrada">
<?php
eventosInputText();

//funcion de los javascripts comunes
function javascriptPagina(){
?>    

<script language="JavaScript">
//para los asientos de nóminas
//calcula este algoritmo:
//bruto = liquido + IRPF + SStrab
function Calcula(opcion,objeto){
    //guardo el dato en el campo hidden
    //var dato = desFormateaNumeroContabilidad(objeto.value);
    
    if(isNaN(objeto.value) === false){
        if(objeto.value !== ''){
            document.getElementById(opcion).value = objeto.value;

            //recoje los datos de:
            //bruto, IRPF, SSTrab y Liquido
            //y hago el calculo

            var bruto = parseFloat($('#lngBruto').val()).toFixed(2);
            var irpf = parseFloat($('#lngIRPF').val()).toFixed(2);
            var SSTrab = parseFloat($('#lngSSTrab').val()).toFixed(2);
            var liquido = parseFloat($('#lngLiquido').val()).toFixed(2);

            switch(opcion) {
                case 'lngBruto':
                    var calculo = parseFloat(bruto - irpf - SSTrab).toFixed(2);
                    $('#lngLiquido').val(calculo);
                    var dato = formateaNumeroContabilidad(calculo.toString());
                    $('#lngLiquidoContabilidad').val(dato);
                    break;
                case 'lngIRPF':
                    var calculo = parseFloat(bruto - irpf - SSTrab).toFixed(2);
                    $('#lngLiquido').val(calculo);
                    var dato = formateaNumeroContabilidad(calculo.toString());
                    $('#lngLiquidoContabilidad').val(dato);
                    break;
                case 'lngSSTrab':
                    var calculo = parseFloat(bruto - irpf - SSTrab).toFixed(2);
                    $('#lngLiquido').val(calculo);
                    var dato = formateaNumeroContabilidad(calculo.toString());
                    $('#lngLiquidoContabilidad').val(dato);
                    break;
                case 'lngLiquido':
                    var calculo = parseFloat(irpf) + parseFloat(SSTrab) + parseFloat(liquido);
                    $('#lngBruto').val(calculo.toFixed(2));
                    var dato = formateaNumeroContabilidad(calculo.toFixed(2));
                    $('#lngBrutoContabilidad').val(dato);
                    break;
            } 
        }else{
            alert("Debe rellenar el campo");
        }
    }else{
        alert("No es numérico el valor introducido");
    }
}

function recojeOculto(opcion,objeto){
    objeto.value = $('#'+opcion).val();
    return false;
}

function textoDefectoConcepto(){
    document.getElementById('strConcepto').value = 'Nómina del mes de '+document.getElementById('strPeriodo').value+' de '+document.getElementById('lngEjercicio').value;
}

</script>
<?php    
}
    
include_once '../movil/cabeceraMovil.php';
?>

    <div data-role="content" data-theme="b">
        <form action="../vista/gastos_entrada.php" name="form1" method="POST" data-ajax="false">
            <table border="0" style="width: 100%;">
                <tr>
                    <td>
                    <label>Tipo de Asiento</label>
                    </td>
                </tr>
                <tr>
                    <td>
                    <div class="ui-field-contain">
                        <fieldset data-role="controlgroup" data-mini="true">
                            <input type="radio" name="optTipoAsiento" id="optTipoAsientoGen" class="custom" value="General" checked="checked"
                                   data-theme="c" data-iconpos="right">
                            <label for="optTipoAsientoGen">Asiento General</label>
                            <input type="radio" name="optTipoAsiento" id="optTipoAsientoNom" class="custom" value="Nomina"
                                   data-theme="c" data-iconpos="right">
                            <label for="optTipoAsientoNom">Nómina</label>
                        </fieldset>
                    </div>
                    </td>
                </tr>
            </table>
                
            <table border="0" style="width: 100%;">
                <tr>
                    <td style="width: 22%;"></td>
                    <td style="width: 23%;"></td>
                    <td style="width: 23%;"></td>
                    <td style="width: 22%;"></td>
                </tr>
                <tr>
                    <td height="15px"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2">
                    <div align="center">
                        <input type="submit" data-theme="b" data-icon="forward" data-iconpos="right" value = "Continuar" /> 
                    </div>
                    </td>
                </tr>
            </table>
        </form>
        
    </div>
</div>
</body>
</html>
