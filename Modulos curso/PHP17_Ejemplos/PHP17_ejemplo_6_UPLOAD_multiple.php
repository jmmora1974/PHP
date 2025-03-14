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
    <h1>PHP 17 Ejemplo 6</h1>
    <p>Ejemplo  6 - Probando la clase Upload con multiplpe ficheros.</p>
    <p> Su alguno falla no se sube pero el resto sí.</p>
    
    <form method="POST" enctype="multipart/form-data" action="upload_17_6_2.php">
    <label> Sube las fotos del producto: </label>
    <br>
    
    <input type="file" accept="image/*" accept="image/*" name="fichero1"> 
    <br>       
    <input type="file" accept="image/*" accept="image/*" name="fichero2"> 
    <br>       
    <input type="file" accept="image/*" accept="image/*" name="fichero3"> 
    <br>       
    
    <input type="submit" value="Enviar">
    </form>
    



</body>


</html>
