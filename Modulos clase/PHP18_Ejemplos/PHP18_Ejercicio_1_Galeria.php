<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<meta name="keywords" content="HTML, CSS, JavaScript">
<meta name="description"
    content="PHP 18 Ejercicio 1">
    <meta name="author" content="Jose Miguel Mora Perez">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- frameworks predefinidos..-->
    <!-- estilo propio.-->
    <title>PHP 18 Ejercicio 1</title>
    <base href="./" target="_blank">
    <link rel="stylesheet" type="text/css" href="https://robertsallent.com/css/generic.css">
  <script src="js/Preview.js"></script>
    </head>
    
    <body>
    <h1>PHP 18 Ejercicio 1- Subir fotos a la galeriad.</h1>
    <h2> SUBIDA DE IMAGENES </h2>
    <form method="POST"  enctype="multipart/form-data" action="upload_18_1_3.php">
    <label> Sube tus imagenes a la galeria: </label>
    <br>
    <input type="hidden" name="MAX_FILE_SIZE" value="500000">
    <input type="file" accept="image/*" accept=".jpg, .jpeg, .gif, .png" 
           multiple name="fichero[]"> 
    <br>       
    <input type="submit" value="Enviar">
    <h1 class="centered">Galeria </h1>
    	
    	<section class="gallery w75 centered-block my2">
    	<?php 
    	include 'libraries/FileList.php'; //carga la libreria
    	
    	// Usaremos el metodo estatico FileList::get()
    	// primer parametros: directorio (opcional, por defecto la carpeta actual)
    	//segundo parametro : expresion regular o lista de extensiones (opcional)
    	$archivos = FileList::get('galeria', '/\.(gif|jpe?g|png)$/i');
    	
    	// con una lista de extensiones queda más sencillo:
    	//$archivos = FileList::get('imagenes', ['gif','jpg', 'jprg', 'png'];
    	
    	// genera las figuras de la galeria
    	foreach($archivos as $archivo){  //genera las figuras
    		?>
	 		<figure class="small card">
	 			<img src='<?= "$archivo" ?>'>
	 			<figcaption><?= "$archivo" ?></figcaption>
	 		</figure>
    	<?php } ?>
    	</section>
    
    </form>
	
	
	



</body>


</html>
