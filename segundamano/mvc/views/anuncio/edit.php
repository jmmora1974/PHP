<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Maralioteca - Edición de anuncio - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Lista de anuncios - <?= APP_NAME ?>">
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
	<h2>Edición del anuncio: <b>"<?= $anuncio->nombre.' '.$anuncio->apellidos ?>"</b></h2>
	<section id="detalles" class="flex-container gap2">
	<div class="flex2 centered">	
		<form method="POST" enctype="multipart/form-data" action="/Anuncio/update">
			
			<input type="hidden" name="iduser" value="<?= user()->id?>">
			<label for="titulo">Titulo</label>
			<input type="text" name="titulo" value="<?= $anuncio->titulo ?>" required>
			<br>
			<label for="descripcion">Descripción</label>
			<textarea name="descripcion" required> <?= $anuncio->descripcion?>" </textarea>
			<br>
			<label for="precio">Precio</label>
			<input type="number" name="precio" value="<?=$anuncio->precio?>" required>
			<br>
			<label for="foto">Foto anuncio</label>
			<input type="file" name="foto" accept="image/*" id="file-with-preview" value="<?=  $anuncio->imagen?>">
			<br>
			
					
				
			<div class="centered mt2 ">
			<?php  if( Login::role('ROLE_PUBLISHER' )) {// autorización(solo bibliotecarios) ?>
				<input type="submit" class="button" name="actualizar" value="Actualizar">
				<input type="reset" class="button" value="Reset" onclick="<?php redirect('/Anuncio/edit/$anuncio->id');?>">
				<?php }?>	
			</div>
		</form>
	</div>
			<div class="flex2">
			<script src="/js/BigPicture.js"></script>
				<figure class="flex1 centrado p2">
				<img src="<?=PROFILE_IMAGE_FOLDER.'/'.($anuncio->foto ?? DEFAULT_PROFILE_IMAGE)?>"
				 	class="cover enlarge-image" alt="Foto de perfil de <?= $anuncio->nombre.' ',$anuncio->apellidos?>">				 		
				 <figcaption>Foto de perfil de <?= $anuncio->nombre.' ',$anuncio->apellidos?> </figcaption>
		
			<br>
				<!-- Botón de eliminar la portada (sin cambiar nada mas) -->
				<form method="POST" action="/Anuncio/changefotoprofile" enctype="multipart/form-data"  class="no-border" id="formfoto" name="formfoto">
					<input type="hidden" name="id" value="<?= $anuncio->id?>">
						<label for="foto">Foto perfil</label>
					
			<?php  if( Login::role('ROLE_LIBRARIAN')|| Login::user()->email == $anuncio->email) {// autorización(solo bibliotecarios) ?>
							<input type="file" name="foto" accept="image/*" id="file-with-preview" value="<?= old('alta', $anuncio->foto)?>">
							
							<input type="submit" class="button" name="cambiar" value="Cambiar foto perfil">
							<?php if($anuncio->foto)
								echo '<input type="submit" class="button-danger" name="borrar" value="Eliminar foto perfil">';
								?>
			<?php } ?>
			
				</form>
			</figure>
			</div>
		
		</section>
			<section>
			<h3>Prestamos del anuncio</h3>
			<a class="button" href="/prestamo/create/<?=$anuncio->id?>">Nuevo Prestamo</a>
			<table class="table w100 centered-block">
					<tr>
						<th>ID</th><th>Anuncio</th><th>Ejemplar</th><th>Titulo</th><th>Limite</th><th>Devolución</th><th>Incidencias</th><th>Operaciones</th>
					</tr>
				<?php 
					
					foreach($prestamos as $prestamo ){ ?>
						<tr>
							<td> <?=$prestamo->id ?></td>
							<td> <?=$prestamo->nombre.' '.$prestamo->apellidos ?></td>
							<td> <?=$prestamo->titulo ?></td>
							<td> <?=$prestamo->idejemplar ?></td>							
							<td> <?=$prestamo->limite ?></td>
							<td> <?=$prestamo->devolucion ?></td>
							<td> <?=$prestamo->incidencia?></td>
							<td class="centrado">
					<?php  
					if( Login::role('ROLE_LIBRARIAN' )) {// autorización(solo bibliotecarios) ?>
							<a class="button" href="/Prestamo/incidencia/<?=$prestamo->id?>">Inicidencia</a>
							<?php
							if ($prestamo->devolucion){ ?>
										
									<a class="button-danger" href="/Prestamo/delete/<?=$prestamo->id?>">Eliminar</a>
									<?php }?>
						<?php }?>			
							</td>
						</tr>
					<?php }?>					
			</table>
		</section>
		
			
			
		<div class="centrado m1">
			<a class="button" onclick="history.back()">Atrás</a>
			<?php  if( Login::role('ROLE_LIBRARIAN' )) {// autorización(solo bibliotecarios) ?>
			<a class="button" href="/Anuncio/list">Lista de anuncios</a>
						<a class="button" href="/Anuncio/show/<?=$anuncio->id?>">Detalles</a>
			
						<?php if(!$anuncio->hasAny('Prestamo')){ ?>
							<a class="button-danger" href='/anuncio/delete/<?=$anuncio->id?>'>
								Borrado <img src="/images/icons/delete.png" alt="Borrar" style="width:20px;height:20px;"> 
							</a>
						<?php } 
				}?>
					
		</div>		
	
</main>		
	
	
</body>
</html>
