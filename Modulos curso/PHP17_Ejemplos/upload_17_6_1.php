<?php
require_once 'exceptions/UploadException.php';
require_once 'libraries/Upload.php';


//para cada clave  en $_FILES (para cada fichero subido)
foreach ($_FILES as $clave => $valor ) {
    
    try {
        $nombre = $_FILES[$clave]['name'];
        //Sube el fichero, hace las omprobaciones y retorna la ruta
        $ruta = Upload::save(
            $clave,   // clave de $_FILES(nombre del input)
            'imagenes', //carpeta destino
            true,       //generar nombre único
            1048576,     //tamaño maximo
            'image/*'
            );
        
        // muestra el mensaje de exito
        echo "<p> Fichero $nombre subido a $ruta.</p>";
        
        
    }  catch (UploadException $e){
        echo "<p> ERROR en $nombre: ".$e->getMessage()."</p>";  ///mostramos el error
    }
    //Si falla un fichero muestr error , luego intentara el siguiente
}




   