<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title> Prestamos - <?= APP_NAME ?></title>
		
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
		<?= $template->header('Nuevo de prestamo') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Prestamos'=>'/Prestamo','Nuevo'=>null]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
	<main>
	<h1><?=APP_NAME?></h1>
	<h2>Nuevo prestamo de libros</h2>
	<p>Estás a punto de crear un nuevo prestamo para <b><?=$socio->nombre.' '.$socio->apellidos ?></b></p>
	<form method="POST" enctype="multipart/form-data" action="/Prestamo/store">
		<div class="flex2">

	
		<label for="idsocio">ID Socio</label>
		<input type="text" name="idsocio"  value="<?= $socio->id ?>" id="idsocio">
		<input type="text" id="nombresocio" name="nombresocio" value="<?=$socio->nombre ?>" disabled>
		<input type="text" id="apellidossocio" name="apellidossocio" value="<?=$socio->apellidos ?>" disabled>
		<br>
		
		<label for="idejemplar">ID Ejemplar</label>
		<input type="text" name="idejemplar" id="idejemplar" value="<?= old('idejemplar')?>">
		<output id="outejemplar"></output>
		<br>
		<label for="limite">Limite</label>
		<input type="date" name="limite" value="<?php
					$date = new DateTime();
					$date->modify('+1 week');
					echo $date->format('Y-m-d'); 
			?>" >
		<br>
		<div class="centered mt2"  id="nuevoejemplar">
				<input type="submit" class="button" name="guardar" value="Guardar">
				<input type="reset" class="button" value="Reset">	
			</div>
		</div>
		<div class="centrado my2">
			<a class="button" onclick="history.back()">Atrás</a>
			<a class="button" href="/Libro/list">Lista de libros</a>
		</div>		
	</form>
			<script>	
			$(document).load(function(){  
				$('#idsocio').change(function(){
					location.href='/Prestamo/create/12';
				}
            
        }
    </script>
</main>		
	
</body>
</html>
