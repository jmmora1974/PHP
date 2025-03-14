<?php
    //ruta del fichero en la carpeta temporal
    $ruta = $_FILES['fichero']['tmp_name'];
    
    //FORMA ORIENTADA A OBJETOS
    
    $finfo = new finfo(FILEINFO_MIME_TYPE); //crea  el objeto files info
    echo $finfo->file($ruta).'<br>';  // muestra el tipo