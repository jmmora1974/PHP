<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Visualización de un anuncio - <?= APP_NAME ?></title>

<!-- META -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Ver anuncios - <?= APP_NAME ?>">
<meta name="author" content="Jose Miguel Mora Perez">

<!-- FAVICON -->
<link rel="shortcut icon" href="/favicon.ico" type="image/png">

<!-- CSS -->
		<?= $template->css() ?>
	</head>
<body>
		<?= $template->login() ?>
		<?= $template->header('Detalles del anuncio') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Anuncios'=>'/Anuncio','Detalles'=>null]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
	<main>
		<h1>Detalles del anuncio en <?=APP_NAME?></h1>
		<section id="detalles" class="flex-container gap2">
			<div class="flex2 centered">
				<h2>Detalles del anuncio <b><?=$anuncio->titulo?></b></h2>

				<p>
					<b>Descripcion:</b>  	<?= $anuncio->descripcion ?></p>
				<p>
					<b>Precio:</b>  	<?= $anuncio->precio ?></p>
				<p>
					<b>Poblacion:</b>  	<?= $anuncio->poblacion ?></p>
				<p>
					<b>Fecha:</b>  	<?= $anuncio->fecha ?></p>
				
				
			</div>
			<script src="/js/BigPicture.js"></script>
			
			<figure class="flex1 centrado p2">
				<img src="<?=ANUNCIO_IMAGE_FOLDER.'/'.($anuncio->imagen ?? DEFAULT_ANUNCIO_IMAGE)?>"
					 	class="cover enlarge-image" alt="Foto del anuncio <?= $anuncio->titulo?>">
									 					 		
				 <figcaption>Foto de perfil de <?= $anuncio->titulo?> </figcaption>
			</figure>
		</section>
		
		
		<div class="centrado">
			<a class="button" onclick="history.back()">Atrás</a> 
					<a class="button" href="/Anuncio/list">Lista de anuncios</a> 
			
			
		<!-- Solo el usuario propietario puede realizar las siguientes operaciones-->
		<?php  if( Login::user()->id == $anuncio->iduser) {// autorización(solo propietario) ?>
				<a class="button" href="/Anuncio/edit/<?=$anuncio->id?>">Editar</a>
				
			<?php }?>
		</div>
	</main>
</body>

</html>