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
	<section id="detalles" class="flex-container gap2">
	<form method="POST" enctype="multipart/form-data" action="/socio/store">
		<div class="flex2">
			<label for="dni">DNI</label>
			<input type="text" name="dni" value="<?= old('dni')?>" pattern="[XYZ\d]\d{7}[A-Z]$" 
						title="DNI- 8 dígitos y una letra, NIF Letra 7 digitos Letra"    required>
			<br>
			<label for="nombre">Nombre</label>
			<input type="text" name="nombre" value="<?= old('nombre')?>" required>
			<br>
			<label for="apellidos">Apellidos</label>
			<input type="text" name="apellidos" value="<?= old('apellidos')?>" >
			<br>
			<label for="poblacion">Poblacion</label>
			<input type="text" name="poblacion" value="<?= old('poblacion')?>" required >
			<br>
			<label for="telefono">Telefono</label>
			<input type="number" min="0" name="telefono" value="<?=old('telefono')?>" required>
			<br>
			<label for="email">Email</label>
			<input type="email" name="email" value="<?=old('email')?>" required>
			<br>
			<label for="foto">Foto perfil</label>
			<input type="file" name="foto" accept="image/*" id="file-with-preview" value="<?= old('alta', $socio->foto)?>">
			<br>
		</div>
		
		
		<div class="centered mt2">
				<input type="submit" class="button" name="guardar" value="Guardar">
				<input type="reset" class="button" value="Reset">	
		</div>
		</form>
		<div class="flex2">
			<figure class="flex1 centrado p2">
					<img src="<?=PROFILE_IMAGE_FOLDER.'/'.($socio->foto ?? DEFAULT_PROFILE_IMAGE)?>"
					 	class="cover enlarge-image" alt="Foto de perfil de <?= $socio->nombre.' ',$socio->apellidos?>">				 		
					 <figcaption>Foto de perfil de <?= $socio->nombre.' ',$socio->apellidos?> </figcaption>
			
				<br>
			</figure>		
		
			
		</div>
		</section>
		<div class="centrado my2">
			<a class="button" onclick="history.back()">Atrás</a>
			<a class="button" href="/socio/list">Lista de socios</a>
		</div>		
	
	
</main>		
	
	
</body>
</html>
