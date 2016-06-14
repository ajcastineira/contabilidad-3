<?php
session_start();
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


require_once '../CN/clsCNContabilidad.php';
$clsCNContabilidad=new clsCNContabilidad();
$clsCNContabilidad->setStrBD($_SESSION['dbContabilidad']);
$clsCNContabilidad->setStrBDCliente($_SESSION['mapeo']);


$listadoCuentasContables = $clsCNContabilidad->listarCuentasArticulos();

$arResult = $clsCNContabilidad->datosFactura($_GET['IdFactura']);



                
logger('info','facturaCuenta.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['strBD'].', SesionID: '.  session_id().
       " ||||Mis Facturas->Contabilizar Factura (Ver cuentas)||");

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="../images/q.ico">
        <title>Contabilizar Facturas - Listado</title>
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
 
            // -->
        </script>
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
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function(){
                //formatear y traducir los datos de la tabla
                $('#datatablesMod').dataTable({
                    "bProcessing": true,
                    "sPaginationType":"full_numbers",
                    "bPaginate": false,
                    "oLanguage": {
                        "sLengthMenu": "Ver _MENU_ registros por pagina",
                        "sZeroRecords": "No se han encontrado registros",
                        "sInfo": "Ver _START_ al _END_ de _TOTAL_ Registros",
                        "sInfoEmpty": "Ver 0 al 0 de 0 registros",
                        "sInfoFiltered": "(filtrados _MAX_ total registros)",
                        "sSearch": "Busqueda:"
                    },
                    "bSort":true,
                    "aaSorting": [[ 0, "asc" ]],
                    "aoColumns": [
			{ "sType": 'string' },
			null,
			null
                    ],                    
                    "bJQueryUI":true
                });
            });
        </script>
    </head>
    <body>
        <h3 align="center" color="#FFCC66"><font size="3px">Relacción de Cuentas de la Factura <?php echo $arResult['NumFactura']; ?></font></h3>
        <script type="text/javascript">
            //actualizo por AJAX esta cuenta
            function cambioCuentaContable(objeto,IdFacturaLineas){
                //actualizo la cuenta en la linea factura
                $.ajax({
                  data:{"cuenta":objeto.value,"IdFacturaLineas":IdFacturaLineas},  
                  url: '../vista/ajax/facturaCambiarCuentaLinea.php',
                  type:"get",
                  success: function(data) {
                      if(data === 'SI'){
                          alert('Actualizado correctamente');
                      }else{
                          alert('NO se actualizó correctamente');
                      }
                  }
                });
                
            };
        </script>
        <table id="datatablesMod" class="display">
            <thead>
                <tr>
                    <th style="width: 40%;">Cuenta</th>
                    <th style="width: 45%;">Concepto</th>
                    <th style="width: 15%;">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(is_array($arResult['DetalleFactura'])){
                    for ($i = 0; $i < count($arResult['DetalleFactura']); $i++) {
                        $link="";
                        ?>
                        <tr>
                            <td onClick="<?php echo $link; ?>">
                                <select class="textbox1" name="" onchange="cambioCuentaContable(this,<?php echo $arResult['DetalleFactura'][$i]['IdFacturaLineas']; ?>);">
                                <?php 
                                //preparo el listado
                                for ($j = 0; $j < count($listadoCuentasContables); $j++) {
                                    $selected='';
                                    if((int)$arResult['DetalleFactura'][$i]['cuentaArticulo'] === (int)$listadoCuentasContables[$j]['NumCuenta']){
                                        $selected='selected';
                                    }
                                    echo"<option value='".$listadoCuentasContables[$j]['NumCuenta']."' ".$selected.">".$listadoCuentasContables[$j]['cuenta']."</option>";
                                }
                                ?>
                                </select>
                            </td>
                            <td onClick="<?php echo $link; ?>"><?php echo $arResult['DetalleFactura'][$i]['concepto']; ?></td>
                            <td onClick="<?php echo $link; ?>">
                                <div align="right">
                                <?php echo formateaNumeroContabilidad($arResult['DetalleFactura'][$i]['total']); ?>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
        <table align="center" border="0" width="100%">
            <tbody>
                <tr>
                    <td align="center">
                        <input type="button" class="button" value="Cerrar" onclick="window.close();" />
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
</html>