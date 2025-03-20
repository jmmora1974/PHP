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
    <h1>PHP 18 Ejemplo 3</h1>
    	<p>Ejemplo 3 Listado de directorio con Filelist</p>
    <main>
    	<h1 class="centered">Galeria </h1>
    	
    	<section class="gallery w75 centered-block my2">
    	<?php 
    	include 'libraries/FileList.php'; //carga la libreria
    	
    	// Usaremos el metodo estatico FileList::get()
    	// primer parametros: directorio (opcional, por defecto la carpeta actual)
    	//segundo parametro : expresion regular o lista de extensiones (opcional)
    	$archivos = FileList::get('imagenes', '/\.(gif|jpe?g|png)$/i');
    	
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
    	 
    </main>
	
</body>
</html>
