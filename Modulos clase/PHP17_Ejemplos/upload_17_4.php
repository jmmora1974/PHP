<?php

//si se produce error en la subida, lanza una excepcion
if($codigo = $_FILES['fichero']['error'])
    throw new Exception ("ERROR con código $codigo.");

    $rutaTemporal = $_FILES['fichero']['tmp_name']; //ruta del fichero en la carpeta temporal
    
    $nombreFichero = $_FILES['fichero']['name']; //nombre del fichero original
    $extension = pathinfo($nombreFichero, PATHINFO_EXTENSION);
    
    $nuevoNombre = uniqid('file_'); //genera el nombre unico
    
    $rutaFinal ="files/$nuevoNombre.$extension"; //calcular la ruta final
        
       
     
     
     //mueve el fichero de la ruta temporal a la ruta final
     echo move_uploaded_file($rutaTemporal, $rutaFinal) ?
     "<p>Fichero $nombreFichero se subió correctamente a $rutaFinal.</p>" :
     "<p>Error al mover el fichero $nombreFichero.</p>" ;
     
    
    
   