<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title> Ejemplares - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Nuevo de ejemplar - <?= APP_NAME ?>">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Nuevo de ejemplar') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Ejemplares'=>'/Ejemplar','Nuevo'=>null]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
	<main>
	<h1><?=APP_NAME?></h1>
	<h2>Nuevo ejemplar para el libro <b>"<?=$libro->titulo?>"</b></h2>
	<p>Estás a punto de crear un nuevo ejemplar para el libro <b>"<?=$libro->titulo?>"</b></p>
	<form method="POST" enctype="multipart/form-data" action="/Ejemplar/store">
		<div class="flex2">
		
		
		<input type="text" name="idlibro" value="<?=$libro->id?><?= old('idlibro')?>" hidden>
		<br>
		
		<label for="anyo">Año</label>
		<input type="text" name="anyo" value="<?= old('anyo')?>" required>
		<br>
		<label for="precio">Precio</label>
		<input type="number" step="0.01" name="precio" value="<?= old('precio')?>" required>
			<br>
			<label for="estado">Estado</label>
			<input type="text" name="estado" value="<?= old('estado')?>" required>
			<br>
			<div class="centered mt2">
				<input type="submit" class="button" name="guardar" value="Guardar">
				<input type="reset" class="button" value="Reset">	
			</div>
		</div>
		<div class="centrado my2">
			<a class="button" onclick="history.back()">Atrás</a>
			<a class="button" href="/Libro/list">Lista de libros</a>
		</div>		
	</form>
</main>		
	
	
</body>
</html>
