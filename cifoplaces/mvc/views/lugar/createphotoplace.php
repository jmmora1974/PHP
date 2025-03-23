<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Nueva foto de lugar - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Nueva foto del lugar - <?= APP_NAME ?>">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Nueva foto del lugar') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Lugares'=>'/Lugar',$lugar->name=>'/Lugar/show/'.$lugar->id,'Nueva foto'=>null]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
	<main>
	
	<h2>Nuevo foto en <?= $lugar->name?> </h2>
	<section id="detalles" class="flex-container gap2">
	<form method="POST" enctype="multipart/form-data" action="/lugar/storephotoplace" class="flex-container gap2">
		
		<div class="flex2">
			<input type="hidden" name="iduser" value="<?= user()->id?>">
			<input type="hidden" name="idplace" value="<?= $lugar->id?>">
			
			<label for="name">Titulo</label>
			<input type="text" name="name" value="<?= old('name')?>" required>
			<br>
			<label for="alt">Titulo alternativo</label>
			<input type="text" name="alt" value="<?= old('alt')?>" required>
			<br>
			<label for="description">Descripción</label>
			<input type="text" name="description" value="<?= old('description')?>" required>
			<br>
			
			<label for="date">Fecha</label>
			
			<input type="date" name="date" value="<?php
					$date = new DateTime();
					echo $date->format('Y-m-d'); 
			?>" >
			<br>
			<label for="time">Hora</label>
			
			<input type="time" name="time" value="<?php
					$date = new DateTime();
					echo $date->format('H:i:s'); 
			?>" >
			<br>
			
		</div>
		<div class="flex2">
			
					<div  id="previewcanvascontainer" >
						<figure class="flex1 centrado p2">
							<canvas id="previewcanvas">
									<div style="display:none;">
										<img id="fotodefault" src="<?=LUGAR_IMAGE_FOLDER.'/'. DEFAULT_LUGAR_IMAGE?>"
				 								class="cover enlarge-image" >	
									</div>
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
			 id="file-with-preview" value="<?= old('imagen')?>"  onchange="return ShowImagePreview( this.files );">
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
