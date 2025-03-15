<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Nuevo anuncio - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Nuevo anuncio - <?= APP_NAME ?>">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Nuevo anuncio') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Anuncios'=>'/Anuncio','Nuevo'=>null]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
	<main>
	
	<h2>Nuevo anuncio en <?=APP_NAME?> </h2>
	<section id="detalles" class="flex-container gap2">
	<form method="POST" enctype="multipart/form-data" action="/anuncio/store">
		<div class="flex2">
			<input type="hidden" name="iduser" value="<?= user()->id?>">
			<input type="hidden" name="poblacion" value="<?= user()->poblacion?>">
			<label for="titulo">Titulo</label>
			<input type="text" name="titulo" value="<?= old('titulo')?>" required>
			<br>
			<label for="descripcion">Descripción</label>
			<textarea  name="descripcion"  required><?= old('descripcion')?></textarea>
			<br>
			<label for="precio">Precio</label>
			<input type="number" name="precio" value="<?=old('precio')?>" required>
			<br>
			<label for="imagen">Foto anuncio</label>
			<input type="file" name="imagen" accept="image/*" id="file-with-preview" value="<?= old('imagen', $anuncio->imagen)?>">
			<br>
		</div>
		
		
		<div class="centered mt2">
		<?php  if( Login::role('ROLE_USER' )) {// autorización(solo bibliotecarios) ?>
				<input type="submit" class="button" name="guardar" value="Guardar">
		<?php }?>
				<input type="reset" class="button" value="Reset">	
		</div>
		</form>
		<div class="flex2">
			<figure class="flex1 centrado p2">
					<img src="<?=ANUNCIO_IMAGE_FOLDER.'/'.($anuncio->imagen ?? DEFAULT_ANUNCIO_IMAGE)?>"
					 	class="cover enlarge-image" alt="Foto deL anuncio de <?= $anuncio->titulo ?>">				 		
					 <figcaption>Foto deL anuncio de <?= $anuncio->titulo ?> </figcaption>
			
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
