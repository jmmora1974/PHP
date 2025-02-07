<?php
require_once 'exceptions/UploadException.php';
require_once 'libraries/Upload.php';

$subidos=[];


try {


//para cada clave  en $_FILES (para cada fichero subido)
foreach ($_FILES as $clave => $valor ) {

        $nombre = $_FILES[$clave]['name'];
        
        //Guarda el fichero actual 
       
        $nuevoNombre= Upload::save(
            $clave,   // clave de $_FILES(nombre del input)
            'imagenes', //carpeta destino
            true,       //generar nombre único
            1048576,     //tamaño maximo
            'image/*',   //tipo MIME(* es el comodin)       
            '',          //prefijo para el nombre generado
            true        //retornar la ruta completa
            );
        
        $subidos[]=$nuevoNombre;
        
        // muestra el mensaje de exito
        echo "<p> Fichero $nombre subido como $nuevoNombre.</p>";
        
        
   
    }
    //Si falla un fichero muestr error , luego intentara el siguiente

}  catch (UploadException $e){
    echo "<p> ERROR en la subida: ".$e->getMessage()."</p>";  ///mostramos el error
    
    //hay que boorar laos fichers ya subidos
    foreach($subidos as $aBorrar){
        echo "<p> Borrando $aBorrar ....</p>";
        @unlink($aBorrar);
    }

    echo "<p> Se eliminaron todos los ficheros subidos.</p>";
    

}
   