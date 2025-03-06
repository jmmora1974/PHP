<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title> Prestamos - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Incidencia prestamo  - <?= APP_NAME ?>">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Incidencia prestamo') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Prestamos'=>'/Prestamo','Incidencia'=>null]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
	<main>
	<h1><?=APP_NAME?></h1>
	<h2>Incidencia prestamo de libros</h2>
	<p>Estás a punto de crear una incidencia para el prestamo <b><?=$prestamo->id ?></b></p>
	<form method="POST" enctype="multipart/form-data" action="/Prestamo/guardaincidencia">
		<div class="flex2">
		<input type="text" name="id"  value="<?= $prestamo->id ?>" hidden >
		<br>
		<label for="idsocio">ID Socio: <?= $prestamo->idsocio ?></label>
		<br>
		<label for="idejemplar" >ID Ejemplar: <?= $prestamo->idejemplar ?></label>
		
		<br>
		
		<label for="incidencia">Incidencia</label>
		<input type="text" name="incidencia" value="<?=$prestamo->incidencia ?? old('incidencia'); ?>" >
		
		
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
