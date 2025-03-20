
<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<meta name="keywords" content="HTML,PHP, CSS, JavaScript">
<meta name="description" content="PHP 25 Ejemplos">
<meta name="author" content="Jose Miguel Mora Perez">

<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- frameworks predefinidos..-->
<!-- estilo propio.-->
<title>PHP 25 Ejemplos</title>

<base href="./" target="_blank">
<link rel="stylesheet" type="text/css"
	href="https://robertsallent.com/css/generic.css">
<!--   <script src="js/Preview.js"></script> -->
</head>

<body>
	<h1>PHP 25 Ejemplo</h1>
	<p>Ejemplo Lista libros</p>

	<ul>
			<?php
			foreach ( $libros as $libro )
				echo "<li>$libro</li>";
			?>
		</ul>
</body>
</html>