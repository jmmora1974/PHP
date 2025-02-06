<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<meta name="keywords" content="HTML, CSS, JavaScript">
<meta name="description"
    content="PHP 18 Ejemplos">
    <meta name="author" content="Jose Miguel Mora Perez">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- frameworks predefinidos..-->
    <!-- estilo propio.-->
    <title>PHP 18 Ejemplos</title>
    
    <base href="./" target="_blank">
    <link rel="stylesheet" type="text/css" href="https://robertsallent.com/css/generic.css">
    <!--   <script src="js/Preview.js"></script> -->
    </head>
    
    <body>
    <h1>PHP 18 Ejemplo 2</h1>
    <p>Ejemplo 2 Galerioa de fotos con scandirs</p> 
    
	<section class="gallery w75 centered-block my2">
	    <?php
	   //recupera la lista de ficheros del directorio y
	   // retorna directamente como array
	   $archivos= scandir("imagenes");
	   
	   //quita el . t el ..
	   array_splice($archivos, array_search(".",$archivos),1);
	   array_splice($archivos, array_search("..",$archivos),1);
	   
	   sort($archivos); //ordena el array
		
		//Lista de fiicheros que hemos encontrado
		foreach($archivos as $foto)
			echo "<figure class='card'><img src='imagenes/$foto'></figure>";
		?>
	</section>
</body>
</html>
