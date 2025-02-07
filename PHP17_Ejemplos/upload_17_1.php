<?php
    //si se produce error en la subida, lanza una excepcion
    if($codigo = $_FILES['fichero']['error'])
        throw new Exception ("ERROR con código $codigo.");
    
    //Comprobaremos que el tamaño no sea superior a 1.240.000 bytes...
        $tamano = $_FILES['fichero']['size'];
        
        if ($tamano > 1240000) 
        throw new Exception ("El fichero supera el tamaño permitido.");
        
    //Si todo ha ido bien....
    echo "<p>El tamaño es $tamano bytes, el fichero es correcto.</p>";
  
   