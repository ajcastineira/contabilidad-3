<!--                        MENU-->
<?php
$desplazamientoCorto = '&nbsp;&nbsp;';
$desplazamiento = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

//extraer listado de ficheros en vista y movil
$listFicherosMovil=$clsCADLogin->listFicheros("../movil/");
//print_r($listFicherosMovil);die;

function urlNavegacion($fichero,$array,$navegacion){
    $encontrado='no';
    for($i=0;$i<count($array);$i++){
        if($array[$i]===$fichero){
            $encontrado='si';
            break;
        }
    }

    //ahora si existe fichero ($encontrado=si) le pongo la ruta que me marca $
    if($encontrado==='si'){
        $url=$navegacion.$fichero;
    }else{
        $url='../vista/'.$fichero;
    }
    
    
    return $url;
}


?>
<table border='0' cellpadding='0' height='240'>
    <tr>
        <td><div class='menu_list' id='firstpane'>
                <p class='menu_head1'><img class="icono" src='../images/01Configuracion.png' /><?php echo $desplazamientoCorto . $textos['01']; ?></p>
                <div class='menu_body2'>
                    <a href='<?php echo urlNavegacion($ficheros['0106'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['0106']; ?></a>
                    <p class='menu_head2'><?php echo $desplazamiento; ?><?php echo $textos['0105']; ?></p>
                    <div class='menu_body3'>
                        <a href='<?php echo urlNavegacion($ficheros['010501'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['010501']; ?></a>
                        <a href='<?php echo urlNavegacion($ficheros['010502'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['010502']; ?></a>
                    </div>
                    <p class='menu_head2'><?php echo $desplazamiento; ?><?php echo $textos['0102']; ?></p>
                    <div class='menu_body3'>
                        <a href='<?php echo urlNavegacion($ficheros['010201'],$listFicherosMovil,$navegacion).'?tipo=cliente'; ?>'><?php echo $desplazamiento . $textos['010201']; ?></a>
                        <a href='<?php echo urlNavegacion($ficheros['010202'],$listFicherosMovil,$navegacion).'?tipo=cliente'; ?>'><?php echo $desplazamiento . $textos['010202']; ?></a>
                    </div>
                    <p class='menu_head2'><?php echo $desplazamiento; ?><?php echo $textos['0103']; ?></p>
                    <div class='menu_body3'>
                        <a href='<?php echo urlNavegacion($ficheros['010301'],$listFicherosMovil,$navegacion).'?tipo=proveedor'; ?>'><?php echo $desplazamiento . $textos['010301']; ?></a>
                        <a href='<?php echo urlNavegacion($ficheros['010302'],$listFicherosMovil,$navegacion).'?tipo=proveedor'; ?>'><?php echo $desplazamiento . $textos['010302']; ?></a>
                    </div>
                    <p class='menu_head2'><?php echo $desplazamiento; ?><?php echo $textos['0104']; ?></p>
                    <div class='menu_body3'>
                        <a href='<?php echo urlNavegacion($ficheros['010401'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['010401']; ?></a>
                        <a href='<?php echo urlNavegacion($ficheros['010402'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['010402']; ?></a>
                    </div>
                    <p class='menu_head2'><?php echo $desplazamiento; ?><?php echo $textos['0101']; ?></p>
                    <div class='menu_body3'>
                        <?php if(substr($_SESSION['cargo'],0,6)==='Asesor'){// es asesor ?>
                        <a href='<?php echo urlNavegacion($ficheros['010101'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['010101']; ?></a>
                        <a href='<?php echo urlNavegacion($ficheros['010103'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['010103']; ?></a>
                        <?php }else{//es usuario, sale deshabilitadas estas opciones ?>
                        <a style="color:#99C8E6;" href='#'><?php echo $desplazamiento . $textos['010101']; ?></a>
                        <a href='<?php echo urlNavegacion($ficheros['010103'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['010103']; ?></a>
                        <?php } ?>
                    </div>
                    <?php
                    //si esta habilitada esta opcion (Articulos)
                    if($tieneArticulos==='on'){
                    ?>
                    <a href='<?php echo urlNavegacion($ficheros['0107'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['0107']; ?></a>
                    <?php
                    }
                    ?>
                    
                </div>
                
                <p class='menu_head1'><img class="icono" src='../images/05MisPresupuestos.png' /><?php echo $desplazamientoCorto . $textos['05']; ?></p>
                <div class='menu_body2'>
                    <a href='<?php echo urlNavegacion($ficheros['0501'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['0501']; ?></a>
                    <a href='<?php echo urlNavegacion($ficheros['0502'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['0502']; ?></a>
                    <a href='<?php echo urlNavegacion($ficheros['0503'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['0503']; ?></a>
                    <a href='<?php echo urlNavegacion($ficheros['0504'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['0504']; ?></a>
                </div>
                
                
                <p class='menu_head1'><img class="icono" src='../images/10Pedidos.png' /><?php echo $desplazamientoCorto . $textos['10']; ?></p>
                <div class='menu_body2'>
                    <a href='<?php echo urlNavegacion($ficheros['1001'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['1001']; ?></a>
                    <a href='<?php echo urlNavegacion($ficheros['1002'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['1002']; ?></a>
                    <a href='<?php echo urlNavegacion($ficheros['1003'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['1003']; ?></a>
                </div>
                
                
                <p class='menu_head1'><img class="icono" src='../images/06MisFacturas.png' /><?php echo $desplazamientoCorto . $textos['06']; ?></p>
                <div class='menu_body2'>
                    <a href='<?php echo urlNavegacion($ficheros['0601'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['0601']; ?></a>
                    <a href='<?php echo urlNavegacion($ficheros['0602'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['0602']; ?></a>
                    <a href='<?php echo urlNavegacion($ficheros['0603'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['0603']; ?></a>
                    <a href='<?php echo urlNavegacion($ficheros['0603b'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['0603b']; ?></a>
                    <a href='<?php echo urlNavegacion($ficheros['0604'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['0604']; ?></a>
                    <a href='<?php echo urlNavegacion($ficheros['0206'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['0206']; ?></a>
                    <a href='<?php echo urlNavegacion($ficheros['0607'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['0607']; ?></a>
                </div>
                
                <p class='menu_head1'><img class="icono" src='../images/02Operaciones.png' /><?php echo $desplazamientoCorto . $textos['02']; ?></p>
                <div class='menu_body2'>
                    <a href='<?php echo urlNavegacion($ficheros['0201'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['0201']; ?></a>
                    <a href='<?php echo urlNavegacion($ficheros['0202'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['0202']; ?></a>
                    <a href='<?php echo urlNavegacion($ficheros['0203'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['0203']; ?></a>
                    <a href='<?php echo urlNavegacion($ficheros['0204'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['0204']; ?></a>
                    <a href='<?php echo urlNavegacion($ficheros['0205'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['0205']; ?></a>
                </div>
                
                
                <p class='menu_head1'><img class="icono" src='../images/03Consultas.png' /><?php echo $desplazamientoCorto . $textos['03']; ?></p>
                <div class='menu_body2'>
                    <a href='<?php echo urlNavegacion($ficheros['0304'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['0304']; ?></a>
                    <a href='<?php echo urlNavegacion($ficheros['0305'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['0305']; ?></a>
                    <a href='<?php echo urlNavegacion($ficheros['0306'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['0306']; ?></a>
                    <a href='<?php echo urlNavegacion($ficheros['0307'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['0307']; ?></a>
                    <a href='<?php echo urlNavegacion($ficheros['0308'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['0308']; ?></a>
                </div>
                
                <p class='menu_head1'><img class="icono" src='../images/07Fiscal.png' /><?php echo $desplazamientoCorto . $textos['07']; ?></p>
                <div class='menu_body2'>
                    <p class='menu_head2'><?php echo $desplazamiento; ?><?php echo $textos['0301']; ?></p>
                    <div class='menu_body3'>
                        <a href='<?php echo urlNavegacion($ficheros['030101'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['030101']; ?></a>
                        <a href='<?php echo urlNavegacion($ficheros['030102'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['030102']; ?></a>
                    </div>
                    <p class='menu_head2'><?php echo $desplazamiento; ?><?php echo $textos['0302']; ?></p>
                    <div class='menu_body3'>
                        <a href='<?php echo urlNavegacion($ficheros['030201'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['030201']; ?></a>
                        <a href='<?php echo urlNavegacion($ficheros['030202'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['030202']; ?></a>
                    </div>
                    <!-- aqui aparece la opcion Consulta->Autonomos o Consulta->Sociedades (Empresas) -->
                    <?php
                    if($claseEmpresa==='Sociedades'){
                    ?>
                    <p class='menu_head2'><?php echo $desplazamiento; ?><?php echo $textos['0303e']; ?></p>
                    <?php }else{ ?>
                    <p class='menu_head2'><?php echo $desplazamiento; ?><?php echo $textos['0303a']; ?></p>
                    <div class='menu_body3'>
                        <a href='<?php echo urlNavegacion($ficheros['0303a01'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['0303a01']; ?></a>
                        <a href='<?php echo urlNavegacion($ficheros['0303a02'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['0303a02']; ?></a>
                    </div>
                    <?php } ?>
                </div>
                
                
                <p class='menu_head1'><img class="icono" src='../images/08Laboral.png' /><?php echo $desplazamientoCorto . $textos['08']; ?></p>
                <div class='menu_body2'>
                    <p class='menu_head2'><?php echo $desplazamiento; ?><?php echo $textos['0801']; ?></p>
                    <div class='menu_body3'>
                        <a href='<?php echo urlNavegacion($ficheros['080101'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['080101']; ?></a>
                        <a href='<?php echo urlNavegacion($ficheros['080102'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['080102']; ?></a>
                    </div>
                    <p class='menu_head2'><?php echo $desplazamiento; ?><?php echo $textos['0802']; ?></p>
                    <div class='menu_body3'>
                        <a href='<?php echo urlNavegacion($ficheros['080201'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['080201']; ?></a>
                        <a href='<?php echo urlNavegacion($ficheros['080202'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['080202']; ?></a>
                    </div>
                    <a href='<?php echo urlNavegacion($ficheros['0803'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['0803']; ?></a>
                    <a href='<?php echo urlNavegacion($ficheros['0804'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['0804']; ?></a>
                </div>

                
                <p class='menu_head1'><img class="icono" src='../images/04Comunicaciones.png' /><?php echo $desplazamientoCorto . $textos['04']; ?></p>
                <div class='menu_body2'>
                    <p class='menu_head2'><?php echo $desplazamiento; ?><?php echo $textos['0801']; ?></p>
                    <div class='menu_body3'>
                        <a href='<?php echo urlNavegacion($ficheros['080101'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['080101']; ?></a>
                        <a href='<?php echo urlNavegacion($ficheros['080102'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['080102']; ?></a>
                    </div>
                    <a href='<?php echo urlNavegacion($ficheros['0402'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['0402']; ?></a>
                    <a href='<?php echo urlNavegacion($ficheros['0403'],$listFicherosMovil,$navegacion); ?>'><?php echo $desplazamiento . $textos['0403']; ?></a>
                </div>
                <a href='../index.php'><p class='menu_head1'><img class="icono" src='../images/09Salir.png' /><?php echo $desplazamientoCorto.$textos['09']; ?></p></a>
                
                
                
            </div>
        </td>
    </tr>
</table>

<!--                        MENU   FIN-->
