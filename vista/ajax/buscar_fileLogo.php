<?phpsession_start();//cojemos el parametro del fichero$file=$_GET["file"];//extraigo la extension$ext=explode('.',$file);$ext=$ext[1];$response='';//si no es JPG y PNG devuelvo el error$JPG_text='OK';if(strtoupper($ext)<>'JPG'){    $JPG_text="NO";}$PNG_text='OK';if(strtoupper($ext)<>'PNG'){    $PNG_text="NO";}if($PNG_text==='NO' && $JPG_text==='NO'){    $response="<b class='fileError'>&nbsp;&nbsp;&nbsp;NO es JPG o PNG</b>";}//creamos la URL donde se guarda$root=getenv('DOCUMENT_ROOT');$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');$uri=explode('/',$uri);$url=$root.'/'.$uri[1].'/images';//reviso si existe este fichero en la carpeta images$directorio = opendir($url);$existeFichero='NO';while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente{    if (!is_dir($archivo))//verificamos si es o no un directorio    {        if(strtoupper($archivo)===strtoupper($file)){            $existeFichero='SI';        }    }}//si existe fichero lo indicamosif($existeFichero==='SI'){    $response="<b class='fileError'>&nbsp;&nbsp;&nbsp;Este fichero EXISTE.</b>";}    //devuelvo la respuesta echo $response;?>