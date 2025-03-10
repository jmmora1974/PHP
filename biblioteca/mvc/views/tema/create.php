<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Nuevo Tema - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Creación de temas - <?= APP_NAME ?>">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Crear de tema') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Temas'=>'/Tema','Nuevo'=>null]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
	<main>
	<h1><?=APP_NAME?></h1>
	<h2>Nuevo tema</h2>
	
	<form method="POST" enctype="multipart/form-data" action="/tema/store">
		<div class="flex2">
		<label for="tema">Tema</label>
		<input type="text" name="tema" value="<?= old('tema')?>" required>
		<br>
		<label for="descripcion">Descripción</label>
		<input type="text" name="descripcion" value="<?= old('descripcion')?>" required>
		<br>
		<div class="centered mt2">
		<?php  if( Login::role('ROLE_LIBRARIAN' )) {// autorización(solo bibliotecarios) ?>
				<input type="submit" class="button" name="guardar" value="Guardar">
			<?php }  ?>
				<input type="reset" class="button" value="Reset">	
			</div>
		</div>
		<div class="centrado my2">
			<a class="button" onclick="history.back()">Atrás</a>
			<a class="button" href="/tema/list">Lista de temas</a>
		</div>		
	</form>
</main>		
	
	
</body>
</html>
