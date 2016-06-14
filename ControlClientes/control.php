<?php
require_once './clsCNControl.php';

$clsCNControl = new clsCNControl();
$clsCNControl->setStrBD('c-dbContabilidad');
//$clsCNControl->setStrBD('qqf261');

//$clsCNControl->setStrBDCliente($_SESSION['mapeo']);

//extraigo el listado de empresas
$listadoEmpresas = $clsCNControl->ListadoEmpresas();
//var_dump($listadoEmpresas);die;

?>
<html>
<head>
<TITLE>Control de Clientes en Tablas de dbContabilidad(tbcliprov y tbrelacioncliprov) y dbCliente(tbcuenta)</TITLE>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../images/q.ico">
</head>
<body>
    <?php
    if(isset($_GET['id']) && $_GET['id'] !== ''){//hay seleccionada empresa
        //se presentan los datos de las tablas dbContabilidad.tbrelacioncliprov y cliente.tbcuenta
        $listados = $clsCNControl->listadoClientes($_GET['id'],$_GET['mapeo']);
        //var_dump($listados);
        
        //ahora vamos a ir leyendo los dos arrays y hacemos uno con las cuentas de los dos
        //asi preparo una tabla donde sale la cuenta y los datos de las dos BBDD
        $listadoConjunto = array();
        for ($i = 0; $i < count($listados['contabilidad']); $i++) {
            $clave = array_search($listados['contabilidad'][$i]['Codigo'], $listadoConjunto);
            if($clave === false){
                //no existe, se añade a la lista
                $listadoConjunto[$listados['contabilidad'][$i]['Codigo']]['cont-Nombre'] = $listados['contabilidad'][$i]['Nombre'];
            }
        }
        
        for ($i = 0; $i < count($listados['cliente']); $i++) {
            $listadoConjunto[$listados['cliente'][$i]['Codigo']]['cliente-Nombre'] = $listados['cliente'][$i]['Nombre'];
        }
        
        //ahora preparo la tabla
        ?>
        <table border="0" style="width: 90%;">
        <tr>
            <th style="width: 10%;">Cuenta</th>
            <th style="width: 5%;"></th>
            <th style="width: 35%;">Contabilidad-Nombre</th>
            <th style="width: 5%;"></th>
            <th style="width: 35%;">Cliente-Nombre</th>
            <th style="width: 10%;"></th>
        </tr>
        <?php
        foreach ($listadoConjunto as $key => $value) {
            //si salen distinto los marco en color
            $background = '';
            if($value['cont-Nombre'] !== $value['cliente-Nombre']){
                $background = '#f7c0c0';
            }
            
            
            echo "<tr>";
            echo "<td style='background: $background;'>".$key."</td>";
            echo "<td style='background: $background;'></td>";
            echo "<td style='background: $background;'>".$value['cont-Nombre']."</td>";
            echo "<td style='background: $background;'></td>";
            echo "<td style='background: $background;'>".$value['cliente-Nombre']."</td>";
            echo "<td style='background: $background;'>";
            if($background !== ''){
                echo "<a href='./control.php?idEmp=".$_GET['id']."&cuenta=".$key."&mapeo=".$_GET['mapeo']."&igualar=SI'>Igualar</a>";
            }
            echo "</td>";
            echo "</tr>";
            
        }
        ?>
        </table>
    
        <a href="./control.php">Volver</a>
    
    
    <?php
    }else 
    if(isset($_GET['igualar']) && $_GET['igualar'] === 'SI' && 
       isset($_GET['cuenta']) && $_GET['cuenta'] !== ''){

        //copiamos los datos de la cuenta dbContabilidad.tbcliprov a cliente.tbcuenta (nombre) 
        //el dato principal es la cuenta y la empresa
        $cuenta = $_GET['cuenta'];
        
        $OK = $clsCNControl->Igualar($_GET['idEmp'],$_GET['mapeo'],$cuenta);
        
        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../ControlClientes/control.php?id='.$_GET['idEmp'].'&mapeo='.$_GET['mapeo'].'">';
        
    }else{//no hay seleccionada empresa
    ?>
    <label>Listado de empresas</label>
    <table border="1" style="width: 70%;">
        <tr>
            <th>Nº</th>
            <th>Empresa</th>
            <th>Conexion</th>
            <th></th>
        </tr>
        <?php
        if(is_array($listadoEmpresas)){
            for ($i = 0; $i < count($listadoEmpresas); $i++) {
                echo "<tr>";
                echo "<td>".$listadoEmpresas[$i]['IdEmpresa']."</td>";
                echo "<td>".$listadoEmpresas[$i]['strSesion']."</td>";
                echo "<td>".$listadoEmpresas[$i]['strMapeo']."</td>";
                echo "<td><a href='./control.php?id=".$listadoEmpresas[$i]['IdEmpresa']."&mapeo=".$listadoEmpresas[$i]['strMapeo']."'>Ver</a></td>";
                echo "</tr>";
            }
        }
        ?>
    </table>
    <?php
    }
    ?>
    
    
</body>
</html>