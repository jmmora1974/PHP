<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<meta name="keywords" content="HTML, CSS, JavaScript">
<meta name="description"
    content="PHP 16 Ejemplos - 2 Subida ficheros">
    <meta name="author" content="Jose Miguel Mora Perez">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- frameworks predefinidos..-->
    <!-- estilo propio.-->
    <title>PHP 16 Ejemplos - 2 Subida ficheros</title>
    <base href="./" target="_blank">
    <link rel="stylesheet" type="text/css" href="https://robertsallent.com/css/generic.css">
    <!--   <script src="js/Preview.js"></script> -->
    </head>
    
    <body>
    <h1>PHP 16 Ejemplos - 2 Subida ficheros</h1>
    <p>Ejemplo 21 - Subida multiple de ficheros </p>
    
    <form method="POST" enctype="multipart/form-data" action="upload_16_2.php">
    <label> Sube tres ficheros: </label>
    <br>
    <input type="hidden" name="MAX_FILE_SIZE" value="500000">
    <input type="file"   name="fichero1"> 
    <br>       
    <input type="hidden" name="MAX_FILE_SIZE" value="700000">
    <input type="file"   name="fichero2"> 
    <br>       
    <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
    <input type="file"   name="fichero3"> 
    <br>       
    <input type="submit" value="Enviar">
    </form>
 

</body>


</html>
