<!DOCTYPE>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="keywords" content="HTML, CSS, JavaScript, PHP">
<meta name="description"
		content="Lista libros PHP 31 CRUD MVC ">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- frameworks predefinidos..-->
		<!--<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		-->
		
		<link rel="stylesheet" type="text/css" href="https://robertsallent.com/css/generic.css">
		<!-- estilo propio.-->		
		
		<title>Listado libros de la biblioteca</title>
		<link rel="icon" type="image/x-icon" href="./images/favicon.ico">
		
		
		</head>
		<body>
			<h2>Detalles del libro</h2>
			<h3><?=$libro->titulo?></h3>
			
			<p><b>ISBN:</b>  	<?= $libro->isbn ?></p>
			<p><b>Titulo:</b>  	<?= $libro->titulo ?></p>
			<p><b>Editorial:</b>  	<?= $libro->editorial ?></p>
			<p><b>Autor:</b>  	<?= $libro->autor ?></p>
			<p><b>Idioma:</b>  	<?= $libro->idioma ?></p>
			<p><b>Edicion:</b>  	<?= $libro->edicion ?></p>
			<p><b>Edad Recomendada:</b>  	
				<?= $libro->edadrecomendada ? $libro->edadrecomendada : 'TP' ?></p>
				
			<div class="centrado">
				<a class="button" href="index.php?controlador=libro/list">Lista de libros</a>
			</div>
		</body>
</html>