<?php
require_once 'exceptions/UploadException.php';
require_once 'libraries/Upload.php';


try{
//Sube el fichero, hace las omprobaciones y retorna la ruta
$ruta = Upload::save(
    'fichero',   // clave de $_FILES(nombre del input)
    'imagenes', //carpeta destino
    true,       //generar nombre único
    1048576,     //tamaño maximo
    'image/*',   //tipo MIME(* es el comodin)       
    'img_',    //prefijo para el nombre generado
    true        //retornar la ruta completa
    );

// muestra el mensaje de exito
echo "<p> Exito en la operación, fichjero subido a $ruta.</p>";

} catch (UploadException $e){
    echo "<p> ERROR : ".$e->getMessage()."</p>";  ///mostramos el error
}


   