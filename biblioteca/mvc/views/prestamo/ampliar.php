<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title> Prestamos - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Ampliación prestamo  - <?= APP_NAME ?>">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Ampliación prestamo') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Prestamos'=>'/Prestamo','Nuevo'=>null]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
	<main>
	<h1><?=APP_NAME?></h1>
	<h2>Ampliación prestamo de libros</h2>
	<p>Estás a punto de crear un nuevo Prestamo para <b><?=$prestamo->id ?></b></p>
	<form method="POST" enctype="multipart/form-data" action="/Prestamo/ampliacion">
		<div class="flex2">
		<input type="text" name="id"  value="<?= $prestamo->id ?>" hidden>
		
		<label for="idsocio">ID Socio</label>
		<input type="text" name="idsocio"  value="<?= $socio->id ?>" >
		<label for="nombre" name="nombresocio"><?=$socio->nombre.' '.$socio->apellidos ?></label>
		<br>
		
		<label for="idejemplar">ID Ejemplar: </label>
		<input type="text" name="idejemplar" value="<?= $prestamo->idejemplar ?>" >
		<br>
		<label for="limite">Limite</label>
		<input type="date" name="limite" value="<?php
					$date = new DateTime();
					$date->modify('+1 week');
					echo $date->format('Y-m-d'); 
			?>" required>
		<br>
		<div class="centered mt2">
				<input type="submit" class="button" name="ampliar" value="Ampliar">
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
