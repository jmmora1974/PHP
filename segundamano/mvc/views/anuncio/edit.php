<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Edición de anuncio  en - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Edición de anuncios - <?= APP_NAME ?>">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Edición de un anuncio') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Anuncios'=>'/Anuncio','Edicion'=>null]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
	<main>
	<h1><?=APP_NAME?></h1>
	<h2>Edición del anuncio: <b>"<?= $anuncio->titulo?>"</b></h2>
	<section id="detalles" class="flex-container gap2">
	<div class="flex2 centered">
	
	<?php  if( Login::user()->id == $anuncio->iduser) {// autorización(solo propietario) ?>
	
		<form method="POST" enctype="multipart/form-data" action="/Anuncio/update">
			
			<input type="hidden" name="id" value="<?= $anuncio->id?>">
			<input type="hidden" name="iduser" value="<?= user()->id?>">
			<label for="titulo">Titulo</label>
			<input type="text" name="titulo" value="<?= $anuncio->titulo ?>" required>
			<br>
			<label for="descripcion">Descripción</label>
			<textarea name="descripcion" required><?= $anuncio->descripcion?></textarea>
			<br>
			<label for="precio">Precio</label>
			<input type="number" name="precio" value="<?=$anuncio->precio?>" required>
			<br>
			<label for="poblacion">Poblacion</label>
			<input type="text" name="poblacion" value="<?=$anuncio->poblacion?>">
			<br>
			<!--  Si se quiere realizar alguna modificación, podemos usar este campo -->
			<input type="date" name="fecha" value="<?=$anuncio->fecha?>" hidden>
			<br>
	<?php } else{ ?>
				<p>Si deseas modificar los datos, puedes contacta con el vendedor.</p>  
		<?php } ?>
					
				
			<div class="centered mt2 ">
			
				<input type="submit" class="button" name="actualizar" value="Actualizar">
				<input type="reset" class="button" value="Reset" onclick="<?php redirect('/Anuncio/edit/$anuncio->id');?>">
				
			</div>
		</form>
	</div>
			<div class="flex2">
			<script src="/js/BigPicture.js"></script>
				<figure class="flex1 centrado p2">
				<img src="<?='/'.ANUNCIO_IMAGE_FOLDER.'/'.($anuncio->imagen ?? DEFAULT_ANUNCIO_IMAGE)?>"
				 	class="cover enlarge-image" alt="Foto de <?= $anuncio->titulo?>">				 		
				 <figcaption>Foto de <?= $anuncio->titulo?> </figcaption>
		
			<br>
				<!-- Botón de eliminar la portada (sin cambiar nada mas) -->
				<form method="POST" action="/Anuncio/changefotoanuncio" enctype="multipart/form-data"  class="no-border" id="formfoto" name="formfoto">
					<input type="hidden" name="id" value="<?= $anuncio->id?>">
						
			<?php  if( Login::user()->id == $anuncio->iduser) {// autorización(solo propietario) ?>
							<input type="file" name="imagen" accept="image/*" id="file-with-preview" value="<?= old('alta', $anuncio->foto)?>">
							
							<input type="submit" class="button" name="cambiar" value="Cambiar foto del anuncio">
							<?php if($anuncio->imagen)
								echo '<input type="submit" class="button-danger" name="borrar" value="Eliminar foto del anuncio">';
								?>
			<?php } ?>
			
				</form>
			</figure>
			</div>
		
		</section>
			
		
			
			
		<div class="centrado m1">
			<a class="button" onclick="history.back()">Atrás</a>
			<?php  if( Login::role('ROLE_LIBRARIAN' )) {// autorización(solo bibliotecarios) ?>
			<a class="button" href="/Anuncio/list">Lista de anuncios</a>
						<a class="button" href="/Anuncio/show/<?=$anuncio->id?>">Detalles</a>
			
						<?php if(!$anuncio->iduser==user()->id){ ?>
							<a class="button-danger" href='/anuncio/delete/<?=$anuncio->id?>'>
								Borrado <img src="/images/icons/delete.png" alt="Borrar" style="width:20px;height:20px;"> 
							</a>
						<?php } 
				}?>
					
		</div>		
	
</main>		
	
	
</body>
</html>
