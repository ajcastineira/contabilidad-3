<?php
class menu{
    private $idx;
    private $lng_nivel;
    private $lng_posicion;
    private $lng_anterior;
    private $str_texto;
    private $lng_standard;
    private $lng_profesional;
    private $lng_premiun;
    private $str_destino;
    private $texto_superior;
    private $texto_principal;
    private $descripcion;

    //idx
    public function getIdx() {
            return $this->idx;
    }
    public function setIdx($idx) {
            $this->idx=$idx;
    }
    
    //lng_nivel
    public function getLng_nivel() {
            return $this->lng_nivel;
    }
    public function setLng_nivel($lng_nivel) {
            $this->lng_nivel=$lng_nivel;
    }
    
    //lng_posicion
    public function getLng_posicion() {
            return $this->lng_posicion;
    }
    public function setLng_posicion($lng_posicion) {
            $this->lng_posicion=$lng_posicion;
    }
    
    //lng_anterior
    public function getLng_anterior() {
            return $this->lng_anterior;
    }
    public function setLng_anterior($lng_anterior) {
            $this->lng_anterior=$lng_anterior;
    }
    
    //str_texto
    public function getStr_texto() {
            return $this->str_texto;
    }
    public function setStr_texto($str_texto) {
            $this->str_texto=$str_texto;
    }
    
    //lng_standard
    public function getLng_standard() {
            return $this->lng_standard;
    }
    public function setLng_standard($lng_standard) {
            $this->lng_standard=$lng_standard;
    }
    
    //lng_profesional
    public function getLng_profesional() {
            return $this->lng_profesional;
    }
    public function setLng_profesional($lng_profesional) {
            $this->lng_profesional=$lng_profesional;
    }
    
    //lng_premiun
    public function getLng_premiun() {
            return $this->lng_premiun;
    }
    public function setLng_premiun($lng_premiun) {
            $this->lng_premiun=$lng_premiun;
    }
    
    //str_destino
    public function getStr_destino() {
            return $this->str_destino;
    }
    public function setStr_destino($str_destino) {
            $this->str_destino=$str_destino;
    }
    
    //texto_superior
    public function getTexto_superior() {
            return $this->texto_superior;
    }
    public function setTexto_superior($texto_superior) {
            $this->texto_superior=$texto_superior;
    }
    
    //texto_principal
    public function getTexto_principal() {
            return $this->texto_principal;
    }
    public function setTexto_principal($texto_principal) {
            $this->texto_principal=$texto_principal;
    }
    
    //descripcion
    public function getDescripcion() {
            return $this->descripcion;
    }
    public function setDescripcion($descripcion) {
            $this->descripcion=$descripcion;
    }
}

function extrae_tbMenu(){
    require_once '../general/conexion.php';
    $db = new DbC();
    $db->conectar($_SESSION['dbContabilidad']);
    //extraigo de la tabla 'tbmenu'
    $sql = 'SELECT * FROM tbmenu';
    $stmt = $db->ejecutar ( $sql );
    $db->desconectar ();
    //array donde guardo la tabla de objetos 'menu'
    $tbMenu=array();
    while ($row = mysql_fetch_assoc($stmt)) {
        $menu_registro=new menu();
        $menu_registro->setIdx($row['idx']);
        $menu_registro->setLng_nivel($row['lng_nivel']);
        $menu_registro->setLng_posicion($row['lng_posicion']);
        $menu_registro->setLng_anterior($row['lng_anterior']);
        $menu_registro->setStr_texto($row['str_texto']);
        $menu_registro->setLng_standard($row['lng_standard']);
        $menu_registro->setLng_profesional($row['lng_profesional']);
        $menu_registro->setLng_premiun($row['lng_premiun']);
        $menu_registro->setStr_destino($row['str_destino']);
        $menu_registro->setTexto_superior($row['textoSuperior']);
        $menu_registro->setTexto_principal($row['textoPrincipal']);
        $menu_registro->setDescripcion($row['descripcion']);
        array_push($tbMenu,$menu_registro);
    }
    return $tbMenu;
}

function extrae_claseEmpresa($idEmp){
    require_once '../general/conexion.php';
    $db = new DbC();
    $db->conectar($_SESSION['dbContabilidad']);
    //extraigo de la tabla 'tbmenu'
    $sql = 'SELECT claseEmpresa FROM tbempresas WHERE IdEmpresa='.$idEmp;
    $stmt = $db->ejecutar ( $sql );
    $db->desconectar ();
    
    if($stmt){
        $row = mysql_fetch_assoc($stmt);
        return $row['claseEmpresa'];
    }else{
        return false;
    }
}
?>