<?php
require_once '../CN/clsCNDefault2.php';
$clsCNDefault2 = new clsCNDefault2();
$cabeceras = $clsCNDefault2->extraeTextosCabeceras();

?>
<table border="0" class="cabecera" style="background: aliceblue;" height="82" width="640">
    <tr> 
        <td width="177" align="middle" valign="center">
            <div align="center">
                <a href="../<?php echo $_SESSION['navegacion'];?>/default2.php">
                    <IMG height=67 alt="Ir al menú" src="../images/<?php echo $_SESSION['logo']; ?>" width=132 border="0">
                </a>
            </div>
        </td>
        <td>
            <table border="0" style="width: 100%;">
                <tr>
                    <td rowspan="4" width="15"></td>
                </tr>
                <tr>
                    <td width="330" height="25"><?php echo '<font style="font-size: 16px;">'.$cabeceras[$cabeceraNumero]['superior'].'</font>'; ?></td>
                    <td height="25" rowspan="2">
                            <label>Fecha:</label>
                            <input readonly type="text" class="textbox1readonly" name="datFechaAlta" value="<?php echo $fechaForm; ?>" style="width:80%;" />
                    </td>
                </tr>
                <tr>
                    <td height="25"><?php echo '<font style="color: #D14;font-size: 18px;">'.$cabeceras[$cabeceraNumero]['principal'].'</font>'; ?></td>
                </tr>
                <tr>
                    <td colspan="2" height="25"><?php echo '<font style="color: #000;">'.$cabeceras[$cabeceraNumero]['descripcion'].'</font>'; ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
