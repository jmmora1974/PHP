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
    <h1>PHP 18 Ejemplo 1</h1>
    <p>Ejemplo  1 -Listado directorio</p>
    
	<ul>
	    <?php
	    $directorio = "imagenes";
	    $archivos =[]; //array donde guardaremos los nombres
	    
	    $handler = opendir($directorio); //abre directorio
	    
	    //mientras haya entradas en el directorio
	    while ($file = readdir ($handler))
	    	$archivos[]=$file;  //mete el nombre del fichero  en el array
	    	
		closedir ($handler);    //cierra el directorio
		sort($archivos); //ordena el array
		
		//Lista de fiicheros que hemos encontrado
		foreach($archivos as $archivo)
			echo "<li>$directorio/$archivo</li>";
		?>
	</ul>
	
</body>
</html>
