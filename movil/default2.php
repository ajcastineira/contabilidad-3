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

//borro la vble de session
unset($_SESSION['presupuestoActivo']);
unset($_SESSION['ingresos_CFIVA1SIRPFVC']);


logger('info','gastos_entrada.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['mapeo'].', SesionID: '.  session_id().
       " ||||Operaciones->Mis Gastos||(Menu eleccion)");

?>
<!DOCTYPE html>
<html>
<head>
<TITLE>Alta de Gastos - Opciones</TITLE>

<?php
//Funciones generales - carga las funciones auxiliares de eventos de los inputText
librerias_jQuery_Mobile();
?>
<style>
    .iconoMovil{
        width: 60px;
        height: 60px;
    }
    
    .enlaceIconoMovil{
        text-decoration: none;
        font-size: 12px;
    }
</style>
</head>
<body>
           
<div data-role="page" id="default2">
<?php
eventosInputText();
?>
<script language="JavaScript">

//function ActivaForm(objeto){
//    if(objeto.value==='ConFactura'){
//        document.getElementById('formOpciones').style.display='block';
//    }else{
//        document.getElementById('formOpciones').style.display='none';
//        alert("Salvo excepciones, la entrega de productos y servicios debe realizarse mediante la correspondiente factura. Mediante esta opción podrá contabilizar gastos no sujetos a la obligación de expedir factura (ej.: impuestos, seguros, etc.). ");
//    }
//}

</script>        

    <?php
    include_once '../movil/cabeceraMovil.php';
    ?>

    <div data-role="content" data-theme="a">
        <table border="0" style="width: 100%;">
            <tr>
                <td height="15px"></td>
            </tr>
            <tr>
                <td style="width: 40%;" align="center">
                    <a class="enlaceIconoMovil" href="../movil/defaultPresupuestos.php" data-ajax="false"><img class="iconoMovil" src="../images/05MisPresupuestos.png"><br/>Presupuestos</a>
                </td>
                <td style="width: 40%;" align="center">
                    <a class="enlaceIconoMovil" href="../movil/defaultFacturas.php" data-ajax="false"><img class="iconoMovil" src="../images/06MisFacturas.png"><br/>Facturas</a>
                </td>
            </tr>
            <tr>
                <td height="30px"></td>
            </tr>
            <tr>
                <td align="center">
                    <a class="enlaceIconoMovil" href="../movil/defaultOperaciones.php" data-ajax="false"><img class="iconoMovil" src="../images/02Operaciones.png"><br/>Operaciones</a>
                </td>
                <td align="center">
                    <a class="enlaceIconoMovil" href="../vista/resultados.php" data-ajax="false"><img class="iconoMovil" src="../images/grafica.png"><br/>Resultados</a>
                </td>
            </tr>
            <tr>
                <td height="30px"></td>
            </tr>
            <tr>
                <td align="center">
                    <a class="enlaceIconoMovil" href="../movil/defaultLaboral.php" data-ajax="false"><img class="iconoMovil" src="../images/08Laboral.png"><br/>Laboral</a>
                </td>
                <td align="center">
                    <a class="enlaceIconoMovil" href="../movil/defaultComunicaciones.php" data-ajax="false"><img class="iconoMovil" src="../images/04Comunicaciones.png"><br/>Comunicaciones</a>
                </td>
            </tr>
            <tr>
                <td height="40px"></td>
            </tr>
            <tr>
                <td colspan="2">
                <div align="center">
                    <a href="../movil/default2m.php" data-role="button" data-mini="true" data-icon="forward" data-ajax="false">Menu Principal</a>
                </div>
                </td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>
