<?php
require_once 'exceptions/UploadException.php';
require_once 'libraries/Upload.php';


/*$filtroDeserializados = serialize($_FILES);
var_dump($filtroDeserializados);
echo "<br>";*/

//para cada clave  en $_FILES (para cada fichero subido)
foreach ($_FILES as $fichero){
	var_dump ($fichero);
	echo "<br>";
	echo count($_FILES);
	echo count($fichero);
	echo "<br>";
	for($x=0 ; $x<count($fichero) ;$x++ ){
	
    try {
    	$clave=unserialize($fichero);
    	var_dump($clave);
    	$nombre = $fichero[$x];
    	echo "<br> Nome: $nombre <br>";
	        //Sube el fichero, hace las omprobaciones y retorna la ruta
	        $ruta = Upload::save(
	        		$clave,   // clave de $_FILES(nombre del input)
	            'galeria', //carpeta destino
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
	}
	
    //Si falla un fichero muestr error , luego intentara el siguiente
}




   