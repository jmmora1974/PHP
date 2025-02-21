<!DOCTYPE>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="keywords" content="HTML, CSS, JavaScript, PHP">
<meta name="description"
		content="actualizacion/edición libro PHP 31 CRUD MVC ">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- frameworks predefinidos..-->
		<!--<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		-->
		
		<link rel="stylesheet" type="text/css" href="https://robertsallent.com/css/generic.css">
		<!-- estilo propio.-->
		<link rel="stylesheet" href="./css/estilo.css">
		<title>Edición libro</title>
		<link rel="icon" type="image/x-icon" href="./images/favicon.ico">
		
		
		</head>
		<body>
			<h3>Edición de un libro: <?=$libro->titulo?></h3>
			<form method="POST" action="index.php?controlador=libro/update">
				<input type="hidden" name="id" value="<?=$libro->id?>">
				
				<label for="isbn">ISBN</label>
				<input type="text" name="isbn" value="<?=$libro->isbn?>">
				<br>
				<label for="titulo">Título</label>
				<input type="text" name="titulo" value="<?=$libro->titulo?>">
				<br>
				<label for="editorial">Editorial</label>
				<input type="text" name="editorial" value="<?=$libro->editorial?>">
				<br>
				<label for="autor">Autor</label>
				<input type="text" name="autor" value="<?=$libro->autor?>">
				<br>
				<label for="idioma">Idioma</label>
				<select name="idioma">
					<option value="Castellano" <?=$libro->idioma=='Castellano'?'selected':''?>>Castellano</option>
					<option value="catalán" <?=$libro->idioma=='Catalán'?'selected':''?>>Catalán</option>
					<option value="Inglés"<?=$libro->idioma=='Inglés'?'selected':''?>>Inglés</option>
					<option value="Otros" <?=$libro->idioma=='Otros'?'selected':''?>>Otros</option>
				</select>
				<br>
				<label for="edicion">Edicion</label>
				<input type="number" min="0" name="edicion" value="<?=$libro->edicion?>">
				<br>
				<label for="edadrecomendada">Edad</label>
				<input type="number" min="0" max="99" name="edadrecomendada" value="<?=$libro->edadrecomendada?>">
				<br>
				<input type="submit" class="button" name="actualizar" value="Actualizar">	
				<input type="reset" class="button" value="Reset">		
			</form>
			
			<div clas="centrado">
				<a class="button" href="index.php?controlador=libro/list">Lista de libros</a>
			</div>
		</body>
	</html>
	
	
