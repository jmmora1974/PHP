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
		<link rel="stylesheet" href="./css/estilo.css">
		<title>Listado libros de la biblioteca</title>
		<link rel="icon" type="image/x-icon" href="./images/favicon.ico">
		
		
		</head>
		<body>
		<h1> Libros de la biblioteca</h1>
		<menu>
		<li><a href="index.php">Inicio</a></li>
		<li><a href="index.php?controlador=libro/list">Lista de libros</a></li>
		<li><a href="index.php?controlador=libro/create">Nuevo Libro</a></li>
		</menu>
		<h2>Lista de libros</h2>
		<table class="bloqueCentrado w100">
			<tr>
				<th> Título</th><th>Autor</th><th>Editoria</th><th>Operaciones</th>
			</tr>
			<?php foreach($libros as $libro){   ?>
				<tr>
				<td><?=$libro->titulo?></td>
				<td><?=$libro->autor?></td>
				<td><?=$libro->editorial?></td>
				<td>
					<a class="button" href='index.php?controlador=libro/show&id=<?=$libro->id?>'>Ver</a>
					<a class="button" href='index.php?controlador=libro/edit&id=<?=$libro->id?>'>Editar</a>
					<a class="button" href='index.php?controlador=libro/delete&id=<?=$libro->id?>'>Borrar</a>
					
				</td>
			</tr>
			
			<?php } ?>
			</table>	
</body>

</html>