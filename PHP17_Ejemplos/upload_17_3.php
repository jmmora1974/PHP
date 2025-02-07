<?php

//si se produce error en la subida, lanza una excepcion
if($codigo = $_FILES['fichero']['error'])
    throw new Exception ("ERROR con código $codigo.");

    //Comprobaremos que el tamaño no sea superior a 1.240.000 bytes...
    $tamano = $_FILES['fichero']['size'];
    
    if ($tamano > 1240000)
        throw new Exception ("El fichero supera el tamaño permitido.");


        $nombreFichero = $_FILES['fichero']['name']; //nombre del fichero original
        
        $rutaTemporal = $_FILES['fichero']['tmp_name']; //ruta del fichero en la carpeta temporal
    
        
    //FORMA ORIENTADA A OBJETOS
    
        $tipoMime= (new finfo(FILEINFO_MIME_TYPE))->file($rutaTemporal);  // recupera el tipo MIME
    
 
 
    // Comprobar si es de imagen (comienza por image/
    if( !preg_match("/^image/", $tipoMime) )
     throw new Exception ("El fichero no es de imagen");
    
     
     $rutaFinal ="imagenes/$nombreFichero"; //calcular la ruta final
     
     
     //mueve el fichero de la ruta temporal a la ruta finbal
     echo move_uploaded_file($rutaTemporal, $rutaFinal) ?
     "<p>Fichero $nombreFichero movido correctamente.</p>" :
     "<p>Error al mover el fichero $nombreFichero.</p>" ;
     
    
    
   