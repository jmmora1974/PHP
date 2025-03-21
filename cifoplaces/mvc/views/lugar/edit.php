<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Edición de lugar  en - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Edición de lugares - <?= APP_NAME ?>">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Edición de un lugar') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Lugares'=>'/Lugar','Edicion de '.$lugar->name=>null]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
	<main>
	<h1><?=APP_NAME?></h1>
	<h2>Edición del lugar: <b>"<?= $lugar->name?>"</b></h2>
	<section id="detalles" class="flex-container gap2">
	<div class="flex2 centered">
	
	<?php  if( Login::user()->id == $lugar->iduser || Login::oneRole(['ROLE_ADMIN','ROLE_MODERADOR'])) {// autorización(solo propietario) ?>
	
		<form method="POST" enctype="multipart/form-data" action="/Lugar/update">
			
			<input type="hidden" name="id" value="<?= $lugar->id?>">
			<input type="hidden" name="iduser" value="<?= $lugar->iduser?>">
			<input type="hidden" name="name" value="<?= $lugar->name ?>"  required>
			<h2><?= $lugar->name ?></h2>
			
			<br>
			<label for="type">Tipo</label>
			<input name="type" value="<?= $lugar->type?>" required>
			<br>
			<label for="description">Descripción</label>
			<input name="description" value="<?= $lugar->description?>" required>
			<br>
			<label for="location">Localización</label>
			<input name="location" value="<?= $lugar->location?>">
			<br>
			<label for="latitude">Latitud:</label>
			<input type="int"  name="latitude" value="<?=$lugar->latitude?>">
			<br>
			<label for="longitude">Longitud:</label>
			<input type="int"  name="longitude" value="<?=$lugar->longitude?>">
			<br>
			<!--  Si se quiere realizar alguna modificación, podemos usar este campo -->
			<p for="created_at" class="x-small">Creado el <?=$lugar->created_at?></p>
			
			<br>
	<?php } else{ ?>
				<p>Si deseas modificar los datos, puedes contacta con el vendedor.</p>  
		<?php } ?>
					
				
			<div class="centered mt2 ">
			
				<input type="submit" class="button" name="actualizar" value="Actualizar">
				<input type="reset" class="button" value="Reset" onclick="<?php redirect('/Lugar/edit/$lugar->id');?>">
				
			</div>
		</form>
	</div>
			<div class="flex2">
			<script src="/js/BigPicture.js"></script>
				<figure class="flex1 centrado p2">
				<img src="<?=LUGAR_IMAGE_FOLDER.'/'.($lugar->mainpicture ?? DEFAULT_LUGAR_IMAGE)?>"
				 	class="cover enlarge-image" alt="Foto de <?= $lugar->name?>" id="preview-image">				 		
				 <figcaption>Foto de <?= $lugar->name?> </figcaption>
		
			<br>
				<!-- Botón de eliminar la portada (sin cambiar nada mas) -->
				<form method="POST" action="/Lugar/changefotolugar" enctype="multipart/form-data"  class="no-border" id="formfoto" name="formfoto">
					<input type="hidden" name="id" value="<?= $lugar->id?>">
						
			<?php  if( Login::user()->id == $lugar->iduser) {// autorización(solo propietario) ?>
							<input type="file" name="imagen" accept="image/*" id="file-with-preview" value="<?= old('alta', $lugar->foto)?>">
							
							<input type="submit" class="button" name="cambiar" value="Cambiar foto del lugar">
							<?php if($lugar->mainpicture)
								echo '<input type="submit" class="button-danger" name="borrar" value="Eliminar foto del lugar">';
								?>
			<?php } ?>
			
				</form>
			</figure>
			</div>
		
		</section>
			
		
			
			
		<div class="centrado m1">
			<a class="button" onclick="history.back()">Atrás</a>
			<?php  if( Login::role('ROLE_MODERADOR' )) {// autorización(solo bibliotecarios) ?>
			<a class="button" href="/Lugar/list">Lista de lugares</a>
						<a class="button" href="/Lugar/show/<?=$lugar->id?>">Detalles</a>
			
						<?php if(!$lugar->iduser==user()->id){ ?>
							<a class="button-danger" href='/lugar/delete/<?=$lugar->id?>'>
								Borrado <img src="/images/icons/delete.png" alt="Borrar" style="width:20px;height:20px;"> 
							</a>
						<?php } 
				}?>
					
		</div>		
	
</main>		
	
	
</body>
</html>
