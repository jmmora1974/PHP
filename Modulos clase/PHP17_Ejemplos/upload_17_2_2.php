<?php






    //ruta del fichero en la carpeta temporal
    $ruta = $_FILES['fichero']['tmp_name'];
    
    //FORMA ORIENTADA A OBJETOS
    
    $finfo = new finfo(FILEINFO_MIME_TYPE); //crea  el objeto files info
    $tipoMime= $finfo->file($ruta);  // recupera el tipo MIME
    
    echo "<p> El tipo MIME del fichero es $tipoMime.</p>";
    
    //para comprobar podemos user expresiones regulares 
    // Comprobar si es de imagen (comienza por image/
    echo preg_match("/^image\//", $tipoMime) ? 
    "<p>Es una imagen.</p>" : "No es una imagen.</p>";
    
    //comprobar si es mp4 u mpeg (video/mp4, video/mpeg).
    echo preg_match("/^video\/(mp4|mpeg)$/", $tipoMime) ?
    "<p>Es mp4 o mpeg.</p>" : "No es  mp4 o mpeg.</p>";
    
    
    //comprobar si es csv o pdf
    echo preg_match("/^(txt\/csv|application\/pdf)$/", $tipoMime) ?
    "<p>Es csv o pdf.</p>" : "No es csv ni pdf.</p>";