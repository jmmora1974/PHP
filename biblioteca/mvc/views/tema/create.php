<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Nuevo Socio - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Lista de socios - <?= APP_NAME ?>">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Lista de socios') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Socios'=>'/Socio','Nuevo'=>null]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
	<main>
	<h1><?=APP_NAME?></h1>
	<h2>Nuevo socio</h2>
	
	<form method="POST" enctype="multipart/form-data" action="/socio/store">
		<div class="flex2">
		<label for="dni">DNI</label>
		<input type="text" name="dni" value="<?= old('dni')?>" required>
		<br>
		<label for="nombre">Nombre</label>
		<input type="text" name="nombre" value="<?= old('nombre')?>" required>
		<br>
		<label for="apellidos">Apellidos</label>
		<input type="text" name="apellidos" value="<?= old('apellidos')?>" >
		<br>
		<label for="poblacion">Poblacion</label>
		<input type="text" name="poblacion" value="<?= old('poblacion')?>" >
		<br>
		<label for="telefono">Telefono</label>
		<input type="number" min="0" name="telefono" value="<?=old('telefono')?>">
		<br>
		<label for="email">Email</label>
		<input type="email" name="email" value="<?=old('email')?>">
		<br>
		<div class="centered mt2">
				<input type="submit" class="button" name="guardar" value="Guardar">
				<input type="reset" class="button" value="Reset">	
			</div>
		</div>
		<div class="centrado my2">
			<a class="button" onclick="history.back()">Atrás</a>
			<a class="button" href="/socio/list">Lista de socios</a>
		</div>		
	</form>
</main>		
	
	
</body>
</html>
