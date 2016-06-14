<?php
session_start();
$_SESSION['navegacion']=$_GET['nav'];
$_SESSION['dbContabilidad'] = 'c-dbContabilidad';
//$_SESSION['dbContabilidad'] = 'qqf261';

header('Location: '.$_SESSION['navegacion'].'/login.php?op='.$_GET['op']);

?>