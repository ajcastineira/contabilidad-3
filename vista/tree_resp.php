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



?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Selección de Documento</title>
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

        <script type="text/javascript" charset="utf-8">
            $(document).ready(function(){
                //formatear y traducir los datos de la tabla
                $('#datatablesMod').dataTable({
                    "bProcessing": true,
                    "sPaginationType":"full_numbers",
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
			null,
			null
                    ],                    
                    "bJQueryUI":true,
                    "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]]
                });
            });
        </script>
    <style type="text/css">
    /* para que no salga el rectangulo inferior */        
    /*.ui-widget-content {
        border: 0px solid #AAAAAA;
    }*/
    </style>      

    </head>
    
    <body>

            <?php
            //tenemos que hacer la busqueda y guardar los datos en la variable $arcDoc
            require_once '../CN/clsCNConsultas.php';
            //traigo los datos de la consulta
            $clsCNConsultas = new clsCNConsultas();
            $clsCNConsultas->setStrBD($_SESSION['dbContabilidad']);

            $arResult = $clsCNConsultas->ListadoDocumentos('Total');
            ?>
            <h3 align="center" color="#FFCC66"><font size="3px">Listado de Documentos Generales</font></h3>
            <table id="datatablesMod" class="display">
                <thead>
                    <tr>
                        <th width="15%">Codigo</th>
                        <th width="5%">Edición</th>
                        <th width="10%">Fecha</th>
                        <th width="70%">Descripción</th>
                    </tr>
                </thead>
                <tbody>
                <script type="text/javascript">
                    function onMouseClickFila(row_id){
                        window.opener.nombreDocumento(row_id);
                        window.close();
                    };
                </script>
                    <?php
                    if(is_array($arResult)){
                        for ($i = 0; $i < count($arResult); $i++) {
                            //print_r($arDoc);
                            if($arResult[$i]['lngTipo']==='0'){
                                $link="javascript:onMouseClickFila('".$arResult[$i]['strNombre']."');";
                            }else{
                                $link="javascript:onMouseClickFila('".$arResult[$i]['link']."');";
                            }
                            ?>
                            <tr onClick="<?php echo $link; ?>">
                                <td onClick="<?php echo $link; ?>"><?php echo '&nbsp;&nbsp;&nbsp;<!-- '.$arResult[$i]['lngOrden'].' -->'.$arResult[$i]['strDocumento']; ?></td>
                                <td align="center" onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['IdVersion']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['datFecha']; ?></td>
                                <td onClick="<?php echo $link; ?>"><?php echo $arResult[$i]['Descripcion']; ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
    </body>
</html>
