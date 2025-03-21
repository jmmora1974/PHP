<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Visualización de un lugar - <?= APP_NAME ?></title>

<!-- META -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Ver lugares - <?= APP_NAME ?>">
<meta name="author" content="Jose Miguel Mora Perez">

<!-- FAVICON -->
<link rel="shortcut icon" href="/favicon.ico" type="image/png">

<!-- CSS -->
		<?= $template->css() ?>
	</head>
<body>
		<?= $template->login() ?>
		<?= $template->header('Detalles del lugar') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Lugares'=>'/Lugar',$lugar->name=>null]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
		
	<main>
		<h1>Detalles del <?=$lugar->name?> lugar en <?=APP_NAME?></h1>
		<section id="detalles" class="flex-container gap2">
		<script src="/js/BigPicture.js"></script>
			<div class="centered w100 flex1 ">
			<figure class="w100 centrado p2" >
				<img src="<?=LUGAR_IMAGE_FOLDER.'/'.($lugar->mainpicture ?? DEFAULT_LUGAR_IMAGE)?>"
					 	class="cover enlarge-image" alt="Foto del lugar <?= $lugar->name?>">
									 					 		
				 <figcaption>Foto de  <?= $lugar->name?> </figcaption>
			</figure>
			<a class="button"  href="/Lugar/nuevafoto/<?=$lugar->id?>">Nueva foto</a>
			</div>
			<section class="flex2 centered">
				<h2><b><?=$lugar->name?></b></h2>
				<p>
					<b>Tipo:</b>  	<?= $lugar->type ?></p>
				<p>
					<b>Descripcion:</b>  	<?= $lugar->description ?></p>
				<p>
					<b>Localización:</b>  	<?= $lugar->location ?></p>
				<p>
					<b>Latitud:</b>  	<?= $lugar->latitude ?></p>
				<p>
					<b>Longitud:</b>  	<?= $lugar->longitude ?></p>
				<p>
					<b>Creado por </b>  	<?= $lugar->username ?> el 	<?= $lugar->created_at ?></p>
				
				
			</section>
			<h2 class="centered w100">Comentarios de <?=$lugar->name?></h2>
			<form method="POST" enctype="multipart/form-data"  action="/comentario/store" class="w75" >
					<input type="hidden" name="iduser" value="<?= user()->id ?>">
					<input type="hidden" name="idplace" value="<?= $lugar->id ?>">
					<input type="text" name="text" min-lenght="1" class="w50" placeholder="Escriba su comentario (solo usuarios registrados)"  required>
					
					<?php  if( Login::user()->id ){ ?>
						<input type="submit" class="button" name="nuevocomentario" 
								value="Nuevo comentario"  <?= user()->id ??'disabled'?> >
						<?php } else { ?>
							<label class="small">Solo usuarios registrados.</label>
							<?php } ?>
				</form>
			<section id="seccomentarios" class="flex-container w100">
			
				
			<?php if($lugarcomments){ ?>
      			
       		 <div id="comentarioslugar ">
				<?php foreach($lugarcomments as $comentario){   ?>
				<div class="comentario justificado w100 m1  ">
					<figure >
						
						<img src="<?=USER_IMAGE_FOLDER.'/'.($comentario->userpicture ?? DEFAULT_USER_IMAGE)?>"
							 class="icon-image enlarge-image" alt="Foto del lugar <?= $comentario->name?>">
						
					</figure>
					<p>	<?=$comentario->username.' ---> '.$comentario->text.'.<br>
						<small> Creado el '.$comentario->created_at.'</small>' ?>
					
					<div class="derecha">
							<a class="button" href='/lugar/edit/<?=$lugar->id?>'><img src="/images/icons/edit.png" alt="Editar" style="width:20px;height:20px;"></a>

							<?php  if( Login::user()->id == $comentario->iduser || 
							Login::oneRole(['ROLE_ADMIN','ROLE_MODERADOR']))  {// autorización(solo propietario o administradores) ?>
								<a class="button-danger" href='/comentario/destroy/<?=$comentario->id?>'><img src="/images/icons/delete.png" alt="Borrar" style="width:20px;height:20px;"></a>
							<?php } ?>
					</div>	
							</div>
					<?php } ?>
							</div>
			<?php } else { ?>
				<div class="danger p2">
					<p>No hay comentarios del sitio</p>
				</div>
				<?php } ?>
		</section>
		</section>
		
		
		<div class="centrado">
			<a class="button" onclick="history.back()">Atrás</a> 
					<a class="button" href="/Lugar/list">Lista de lugares</a> 
					
		<!-- Solo el usuario propietario puede realizar las siguientes operaciones-->
		<?php  if( Login::user()->id == $lugar->iduser || Login::oneRole(['ROLE_ADMIN','ROLE_MODERADOR'])) {// autorización(solo propietario) ?>
				<a class="button" href="/Lugar/edit/<?=$lugar->id?>">Editar</a>
				
			<?php }?>
		</div>
		
		<section id="secphotos">
		
		
			<h3>Fotos de <?=$lugar->name?></h3>
				
				<div class="carrusel centrado">

						<?php
						$archivosfoto = [];
						//$archivosfoto = FileList::get ( 'images/galeria/Rutas foto', '/\.(gif|jpe?g|png|webp)$/i' );
				 if($fotocomments){ 
					
						foreach($fotocomments as $fotoco){
							
							$archivosfoto []= $fotoco->file;
						}
						
						
						$f = 1; // contador de foto principal
						foreach ( $archivosfoto as $archfoto ) {
							?>
								<div class="mySlides">
									<div class="numbertext"> <?= $f ?> / <?= count($archivosfoto) ?></div>
									<img class="enlarge-image" src="<?= LUGAR_IMAGE_FOLDER.'/'.$archfoto ?>" style="width: 50vw"
										alt="Foto  <?= $archfoto ?>">
								</div>
						<?php $f++; }
				} else { ?>
					<p>No hay ninguna foto aún</p>
				<?php }	?>

				</div>
			
			<!-- Botones anterior y siguientes -->
			 <div class="centrado">
				<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
				<a class="resume" onclick="plusSlides(999999)">&#9654;</a> 
				<a class="pause" onclick="plusSlides(0)">&#9724;</a>
				<a class="next" onclick="plusSlides(1)">&#10095;</a>
				<a class="button"  href="/Lugar/nuevafoto/<?=$lugar->id?>">Nueva foto</a>
			</div>
				<!-- Image text -->
				<div class="caption-container">
					
					<h2 class="centered w100">Comentarios de <?=$fotocomments->name?></h2>
			<form method="POST" enctype="multipart/form-data"  action="/comentario/store" class="w75" >
					<input type="hidden" name="iduser" value="<?= user()->id ?>">
					<input type="hidden" name="idphoto" value="<?= $lugar->id ?>">
					<input type="text" name="text" min-lenght="1" class="w50" placeholder="Escriba su comentario (solo usuarios registrados)"  required>
					
					<?php  if( Login::user()->id ){ ?>
						<input type="submit" class="button" name="nuevofotocomentario" 
								value="Nuevo comentario de foto"  <?= user()->id ??'disabled'?> >
						<?php } else { ?>
							<label class="small">Solo usuarios registrados.</label>
							<?php } ?>
				</form>
			<section id="seccomentariosfotos" class="flex-container w100">
			
				
			<?php if($fotocomments){ ?>
      			
       		 <div id="comentariosFotos ">
				<?php foreach($fotocomments as $comentario){   ?>
				<div class="comentario justificado w100 m1  ">
					<figure >
						
						<img src="<?=USER_IMAGE_FOLDER.'/'.($comentario->userpicture ?? DEFAULT_USER_IMAGE)?>"
							 class="icon-image enlarge-image" alt="Foto del lugar <?= $comentario->name?>">
						
					</figure>
					<p>	<?=$comentario->username.' ---> '.$comentario->text.'.<br>
						<small> Creado el '.$comentario->created_at.'</small>' ?>
					
					<div class="derecha">
							<a class="button" href='/lugar/edit/<?=$lugar->id?>'><img src="/images/icons/edit.png" alt="Editar" style="width:20px;height:20px;"></a>

							<?php  if( Login::user()->id == $comentario->iduser || 
							Login::oneRole(['ROLE_ADMIN','ROLE_MODERADOR']))  {// autorización(solo propietario o administradores) ?>
								<a class="button-danger" href='/comentario/destroy/<?=$comentario->id?>'><img src="/images/icons/delete.png" alt="Borrar" style="width:20px;height:20px;"></a>
							<?php } ?>
					</div>	
							</div>
					<?php } ?>
							</div>
			<?php } else { ?>
				<div class="danger p2">
					<p>No hay comentarios del sitio</p>
				</div>
				<?php } ?>
		</section>
					
				</div>

				<!-- Thumbnail images -->
				<div class="row">
			<?php
			$fm = 1; // contador de foto principal
			foreach ( $archivosfoto as $archfoto ) {
				?>
					<div class="column">
						<img class="demo cursor" src="<?= LUGAR_IMAGE_FOLDER.'/'.$archfoto ?>" style="width: 100%"
							onclick="currentSlide(<?= $fm ?>)" alt="<?= 'Foto '.$fm ?>">
					</div>
				
				<?php $fm++ ?>  
			
					<?php }?>
				
			</div>
		</section>
		
	</main>
	<script src="/js/Carrousel.js"></script>
</body>

</html>