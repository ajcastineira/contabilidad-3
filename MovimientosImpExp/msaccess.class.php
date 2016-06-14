<?php
/* CLASE PARA LA CONEXION DE PHP CON ACCES 2003 */
class msaccess {
 # variable para almacenar la conexion
 private $conexion;  
 #Base de datos access 2003
 private  $name = 'Contabil.mdb';

function setMDB($name) {
    $this->name = $name;
}

function getMDB() {
    return $this->name;
}
 
function selfURLApp() { 
	$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : ""; 
	//$protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s; 
	$protocol = explode('/',$_SERVER["SERVER_PROTOCOL"]); 
	$protocol = strtolower($protocol[0]).$s; 
	$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]); 
	return $protocol."://".$_SERVER['SERVER_NAME'].$port;
}
 
    /* METODO PARA CONECTAR CON LA BASE DE DATOS*/
 public function conectar()
 {
    # Directorio actual de la base de datos
//    $db = $this->selfURLApp()."/Contabilidad/MovimientosImpExp/Contabil.Mdb";
    $db =$_SERVER['DOCUMENT_ROOT']. "/Contabilidad/MovimientosImpExp/".$this->name;
    # Se forma la cadena de conexi�n
    $dsn = "DRIVER={Microsoft Access Driver (*.mdb)};DBQ=".$db;
    # Se realiza la conex�n con Access -> Si hay error se detiene todo
//    $this->conexion = odbc_connect( $dsn, '', '' ) or die( odbc_errormsg() );
    $this->conexion = odbc_connect( $dsn, '', '' ) or logger('error','msaccess.class.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['base'].', SesionID: '.  session_id(). ' -Error Access= '.  odbc_errormsg());
    
    if(!$this->conexion){
        return false;
    }
    return true;
//     echo 'Conexi�n a ['.$this->name.' ]: Establecida';
 }

 /* METODO PARA CERRAR LA CONEXION A LA BASE DE DATOS*/ 
 public function desconectar()
 {
  odbc_close( $this->conexion );
//  echo 'Conexion a ['.$this->name.'] : Terminado ';
 }

 /*METODO PARA HACER UN INSERT
 * INPUT: 
 * $tabla -> Nombre tabla 
 * $campos -> String con nombres de los campos -> campo1, campo2, campo_n
 * $valores -> Valores a insertar -> 'Valor1','Valor2','Valor_n'
 * OUTPUT:
 * boolean -> TRUE/FALSE: 
 */
 function insert($tabla, $campos, $valores){
  #se forma la instruccion SQL 
  $q = 'INSERT INTO '.$tabla.' ('.$campos.') VALUES ('.$valores.')';
  $resultado = $this->consulta($q);
  if($resultado) return true;
  else return false;
 }   

//function SQL($SQL){
//	$resultado = odbc_result_all($SQL);
//	if($resultado) return true;
//	else return false;
//}
 
 /* METODO PARA REALIZAR UNA CONSULTA 
 * INPUT: 
 * $q -> consulta SQL
 *OUTPUT: 
 * $result
 */
 public function consulta($q)
 {
//    $resultado = odbc_exec( $this->conexion, $q) or die( odbc_errormsg() );
    $resultado = odbc_exec( $this->conexion, $q);
    if(!$resultado){
        //QUITA ESTA OBSERVACION
        logger('error','msaccess.class.php-' ,"Usuario: ".$_SESSION['strUsuario'].', Empresa: '.$_SESSION['base'].', SesionID: '.  session_id(). ' -Error Access= '.  odbc_errormsg());
        //die( odbc_errormsg());
        return false;
    }
    return $resultado; 
 }

}//fin clase
?>

