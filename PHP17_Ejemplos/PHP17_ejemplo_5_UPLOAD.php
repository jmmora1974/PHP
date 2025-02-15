<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<meta name="keywords" content="HTML, CSS, JavaScript">
<meta name="description"
    content="PHP 17 Ejemplos">
    <meta name="author" content="Jose Miguel Mora Perez">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- frameworks predefinidos..-->
    <!-- estilo propio.-->
    <title>PHP 17 Ejemplos</title>
    <base href="./" target="_blank">
    <link rel="stylesheet" type="text/css" href="https://robertsallent.com/css/generic.css">
  <script src="js/Preview.js"></script>
    </head>
    
    <body>
    <h1>PHP 17 Ejemplo 5</h1>
    <p>Ejemplo  5 - Probando la clase Upload.</p>
    
    <form method="POST" enctype="multipart/form-data" action="upload_17_5_2.php">
    <label> Sube tu imagen de perfil: </label>
    <br>
    <input type="hidden" name="MAX_FILE_SIZE" value="1240000">
    <input type="file" accept="image/*" accept=".jpg, .jpeg, .gif, .png" 
            name="fichero" id="file-with-preview"> 
    <br>       
    <input type="submit" value="Enviar">
    </form>
    



</body>


</html>
