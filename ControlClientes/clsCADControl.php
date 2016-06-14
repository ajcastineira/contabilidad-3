<?php
class clsCADControl{
    
    private $strDB = '';
    private $strDBCliente='';
    
    function setStrBD($str) {
        $this->strDB = $str;
    }

    function getStrBD() {
        return $this->strDB;
    }

    function setStrBDCliente($str){
        $this->strDBCliente=$str;
    }

    function getStrBDCliente(){
        return $this->strDBCliente;
    }

    
    function ListadoEmpresas(){
        require_once '../general/conexion.php';
        $db = new DbC();
        $db->conectar($this->getStrBD());

        
        $strSQL = "
                    SELECT E.IdEmpresa,E.strSesion,E.strMapeo
                    FROM tbempresas E
                  ";
        
        $stmt = $db->ejecutar ( $strSQL );
        $db->desconectar ();

        $resultado='';
        if($stmt){
            while($row=  mysql_fetch_array($stmt)){
                $reg='';
                foreach($row as $propiedad=>$valor){
                    if(!is_numeric($propiedad)){
                        $reg[$propiedad]=$valor;
                    }
                }
                $resultado[]=$reg;
            }
        }
        
        return $resultado;
    }
    
    function listadoClientes($id,$mapeo){
        
        //primero extraigo el listado de tbcliporv y tbrelacioncliprov (que es la que prevalece)
        require_once '../general/conexion.php';
        $dbC = new DbC();
        $dbC->conectar($this->getStrBD());
        
        $strSQL = "
                    select R.codigo AS Codigo,C.nombre AS Nombre
                    from tbcliprov C, tbrelacioncliprov R
                    where C.IdCliProv=R.IdCliProv
                    and R.Borrado=0
                    and R.IdEmpresa=$id
                    order by R.codigo
                  ";
        
        $stmt = $dbC->ejecutar ( $strSQL );
        $dbC->desconectar ();
        
        $listContabilidad='';
        if($stmt){
            while($row=  mysql_fetch_array($stmt)){
                $reg='';
                foreach($row as $propiedad=>$valor){
                    if(!is_numeric($propiedad)){
                        $reg[$propiedad]=$valor;
                    }
                }
                $listContabilidad[]=$reg;
            }
        }
        
        
        //segundo extraigo listado de la tabla cliente.tbcuenta
        //echo $mapeo;die;
        require_once '../general/'.$mapeo;
        $dbCL = new Db();
        $dbCL->conectar($this->getStrBD());

        $strSQL = "
                    select C.NumCuenta AS Codigo,C.Nombre
                    from tbcuenta C
                    where C.Borrado=0
                    and (C.NumCuenta like '4000%' OR C.NumCuenta like '4300%')
                    and not C.NumCuenta='400000000'
                    and not C.NumCuenta='430000000'
                    order by C.NumCuenta
                  ";
        
        $stmt = $dbCL->ejecutar ( $strSQL );
        $dbCL->desconectar ();
        
        $listCliente='';
        if($stmt){
            while($row=  mysql_fetch_array($stmt)){
                $reg='';
                foreach($row as $propiedad=>$valor){
                    if(!is_numeric($propiedad)){
                        $reg[$propiedad]=$valor;
                    }
                }
                $listCliente[]=$reg;
            }
        }
        
        $resultado = array(
            "contabilidad" => $listContabilidad,
            "cliente" => $listCliente
        );

        return $resultado;
    }
    
    function Igualar($idEmp,$mapeo,$cuenta){
        //primero extraigo el nombre de la tabla tbcliprov
        require_once '../general/conexion.php';
        $dbC = new DbC();
        $dbC->conectar($this->getStrBD());
        
        $strSQL = "
                    select C.nombre
                    from tbcliprov C, tbrelacioncliprov R
                    where C.IdCliProv=R.IdCliProv
                    and R.codigo='$cuenta'
                    and R.IdEmpresa=$idEmp
                  ";
        
        $stmt = $dbC->ejecutar ( $strSQL );
        $dbC->desconectar ();

        if(!$stmt){
            return false;
        }
        
        $row = mysql_fetch_array($stmt);
        $nombre = $row['nombre'];
        
        //ahora inserto el nombre en la tabla cliente.tbcuenta
        require_once '../general/'.$mapeo;
        $dbCL = new Db();
        $dbCL->conectar($this->getStrBD());

        $strSQL = "
                    update tbcuenta C
                    set C.Nombre='$nombre'
                    where C.NumCuenta='$cuenta'
                    and C.Borrado=0
                  ";
        
        $stmt = $dbCL->ejecutar ( $strSQL );
        $dbCL->desconectar ();
        
        if($stmt){
            return true;
        }else{
            return false;
        }
    }
    
    
}
?>
