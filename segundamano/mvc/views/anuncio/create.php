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
	<form method="POST" enctype="multipart/form-data" action="/anuncio/store" class="flex-container gap2">
		<div class="flex2">
			
					<div  id="previewcanvascontainer" >
						<figure class="flex1 centrado p2">
							<canvas id="previewcanvas">
									<div style="display:none;">
										<img id="fotodefault" src="<?=ANUNCIO_IMAGE_FOLDER.'/'.($anuncio->imagen ?? DEFAULT_ANUNCIO_IMAGE)?>"
				 								class="cover enlarge-image" alt="Foto de <?= $anuncio->titulo?>">	
									</div>
							</canvas>		
							<figcaption>Foto del anuncio</figcaption>
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
			 id="file-with-preview" value="<?= old('imagen', $anuncio->imagen)?>"  onchange="return ShowImagePreview( this.files );">
			<br>
			
					</div>
			</div>
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
			<a class="button" href="/socio/list">Lista de socios</a>
		</div>		
	
	
</main>		
	
<script src="/js/PreviewUpload.js"></script>
	
</body>
</html>
