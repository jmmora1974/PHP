<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Nuevo lugar - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Nuevo lugar - <?= APP_NAME ?>">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Nuevo lugar') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Lugares'=>'/Lugar','Nuevo'=>null]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
	<main>
	
	<h2>Nuevo lugar en <?=APP_NAME?> </h2>
	<section id="detalles" class="flex-container gap2">
	<form method="POST" enctype="multipart/form-data" action="/lugar/store" class="flex-container gap2">
		
		<div class="flex2">
			<input type="hidden" name="iduser" value="<?= user()->id?>">
			
			<label for="name">Nombre</label>
			<input type="text" name="name" value="<?= old('name')?>" required>
			<br>
			<label for="type">Tipo</label>
			<input type="text" name="type" value="<?= old('type')?>" required>
			<br>
			<label for="description">Descripción</label>
			<input type="text" name="description" value="<?= old('description')?>" required>
			<br>
			<label for="location">Localización</label>
			<input type="text" name="location" value="<?= old('location')?>" >
			<br>
			<label for="latitude">Latitud</label>
			<input type="number" name="latitude" step="0.1" value="<?= old('latitude')?>">
			<br>
			<label for="longitude">Longitud</label>
			<input type="number" name="longitude" step="0.1" value="<?= old('longitude')?>">
			<br>
		</div>
		<div class="flex2">
			
					<div  id="previewcanvascontainer" >
						<figure class="flex1 centrado p2">
						<div style="display:none;">
										<img id="fotodefault" src="<?=LUGAR_IMAGE_FOLDER.'/'.($lugar->mainpicture ?? DEFAULT_LUGAR_IMAGE)?>"
				 								class="cover enlarge-image" alt="Foto de <?= $lugar->nane?>">	
									</div>
							<canvas id="previewcanvas">
									
							</canvas>		
							<figcaption>Foto del lugar</figcaption>
									<script>
									const canvas = document.getElementById("previewcanvas");
									const ctx = canvas.getContext("2d");
									const image = document.getElementById("fotodefault");
									
									image.addEventListener("load", (e) => {
									  ctx.drawImage(image, 10, 5, 200, 150);
									});
									</script>

						</figure>	
						<input type="file" name="imagen" accept="image/*"  style="max-width:300px"
			 id="file-with-preview" value="<?= old('imagen', $lugar->mainpicture)?>"  onchange="return ShowImagePreview( this.files );">
			<br>
			
					</div>
			</div>
			
		
							
		<div class="centered mt2 w100">
		<?php  if( Login::role('ROLE_USER' )) {// autorización(solo autenticados) ?>
				<input type="submit" class="button" name="guardar" value="Guardar">
		<?php }?>
				<input type="reset" class="button" value="Reset">	
		</div>
		
		</form>
		</section>
		<div class="centrado my2">
			<a class="button" onclick="history.back()">Atrás</a>
			<a class="button" href="/Lugar/list">Lista de lugares</a>
		</div>		
	
	
</main>		
	
<script src="/js/PreviewUpload.js"></script>
	
</body>
</html>
