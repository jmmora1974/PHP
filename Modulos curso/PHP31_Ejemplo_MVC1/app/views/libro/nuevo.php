<!DOCTYPE>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="keywords" content="HTML, CSS, JavaScript, PHP">
<meta name="description"
		content="Nuevo libro PHP 31 CRUD MVC ">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- frameworks predefinidos..-->
		<!--<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		-->
		
		<link rel="stylesheet" type="text/css" href="https://robertsallent.com/css/generic.css">
		<!-- estilo propio.-->
		<link rel="stylesheet" href="./css/estilo.css">
		<title>Nuevo libro</title>
		<link rel="icon" type="image/x-icon" href="./images/favicon.ico">
		
		
		</head>
		<body>
			<h3>Creación de un nuevo libro</h3>
			<form method="POST" action="index.php?controlador=libro/store">
				<label for="isbn">ISBN</label>
				<input type="text" name="isbn">
				<br>
				<label for="titulo">Título</label>
				<input type="text" name="titulo">
				<br>
				<label for="editorial">Editorial</label>
				<input type="text" name="editorial">
				<br>
				<label for="autor">Autor</label>
				<input type="text" name="autor">
				<br>
				<label for="idioma">Idioma</label>
				<select name="idioma">
					<option value="Castellano">Castellano</option>
					<option value="catalan">Catalan</option>
					<option value="otros">Otros</option>
				</select>
				<br>
				<label for="edicion">Edicion</label>
				<input type="number" min="0" name="edicion">
				<br>
				<label for="edadrecomendada">Edad</label>
				<input type="number" min="0" max="99" name="edadrecomendada">
				<br>
				<input type="submit" class="button" name="guardar" value="Guardar">		
			</form>
			
			<div clas="centrado">
				<a class="button" href="index.php?controlador=libro/list">Lista de libros</a>
			</div>
		</body>
	</html>
	
	
