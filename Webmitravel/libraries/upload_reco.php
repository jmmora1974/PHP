	
<?php
require_once 'exceptions/UploadException.php';
require_once 'Upload.php';

/* $filtroDeserializados = serialize($_FILES);
var_dump($filtroDeserializados);
echo "<br>"; */

//capturamos la actividad para clasificar la carpeta
if (!empty($_POST['actividad'])){
	$actividad = $_POST['actividad'];
	$carpetaact = "../images/galeria/$actividad";
}

//Comprobamos si existe la carpeta actividad, si no la crea nueva.
//OJO ... es inseguro por el momento para la practica es válido, 
// pero se ha de sanear y securizar
if(!file_exists($carpetaact)){
	mkdir($carpetaact, 0774);
}
//para cada clave  en $_FILES (para cada fichero subido)
foreach ($_FILES as $fichero){

    try {
    	$nombre = $fichero['name'];
    	    //Sube el fichero, hace las omprobaciones y retorna la ruta
	        $ruta = Upload::save(
	        	'fichero', // clave de $_FILES(nombre del input)
	        	$carpetaact, //carpeta destino
	            true,       //generar nombre único
	            500000,     //tamaño maximo
        		'image/*',   //tipo MIME(* es el comodin)
        		'img_',    //prefijo para el nombre generado
        		true        //retornar la ruta completa
        
	        		
	            );
	        
	        // muestra el mensaje de exito
        echo "<p> Fichero $nombre subido a $ruta.</p>";
    	
        
    }  catch (UploadException $e){
        echo "<p> ERROR en $nombre: ".$e->getMessage()."</p>";  ///mostramos el error
    }
	
	
    //Si falla un fichero muestr error , luego intentara el siguiente
}

