<?php

if(isset($_POST["submit"]))

{

 $nombre_archivo = $_FILES["archivo"]["name"];

 $tipo_archivo = $_FILES["archivo"]["type"];

 $tamano_archivo = $_FILES["archivo"]["size"];



 $limite = $_POST["limite"];

 if($tamano_archivo<=$_POST['limite'])

 {
 
 echo $nombre_archivo;
 echo "<br>";
 echo $_FILES["archivo"]["tmp_name"];
 $nombre_archivo = "../contabilidad/doc/doc-Contabilidad/".$nombre_archivo;
 echo "<br>";
 echo $nombre_archivo;
 echo "<br>";

 
 
 if(move_uploaded_file($_FILES["archivo"]["tmp_name"], $nombre_archivo))

 {

 echo "El archivo " . $nombre_archivo . " se ha transferido correctamente. <br />";

 echo "Su tamaño es de: " . $tamano_archivo . " bytes.";

 echo "El tipo de archivo es: " . $tipo_archivo;

 }

 else

 {

 echo "No se ha podido transferir el archivo, verifique el tamaño del archivo e intente nuevamente.";

 }

 }

 echo "<a href='.$nombre_archivo.'>";

}

?>