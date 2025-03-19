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
		<h1>Detalles del lugar en <?=APP_NAME?></h1>
		<section id="detalles" class="flex-container gap2">
			<div class="flex2 centered">
				<h2>Detalles del lugar <b><?=$lugar->name?></b></h2>
				<p>
					<b>Nombre del lugar:</b>  	<?= $lugar->name ?></p>
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
					<b>Creador:</b>  	<?= $lugar->username ?></p>
				<p>
					<b>Fecha:</b>  	<?= $lugar->created_at ?></p>
				
				
			</div>
			<script src="/js/BigPicture.js"></script>
			
			<figure class="flex1 centrado p2">
				<img src="<?=LUGAR_IMAGE_FOLDER.'/'.($lugar->mainpicture ?? DEFAULT_LUGAR_IMAGE)?>"
					 	class="cover enlarge-image" alt="Foto del lugar <?= $lugar->name?>">
									 					 		
				 <figcaption>Foto de  <?= $lugar->name?> </figcaption>
			</figure>
		</section>
		
		
		<div class="centrado">
			<a class="button" onclick="history.back()">Atrás</a> 
					<a class="button" href="/Lugar/list">Lista de lugares</a> 
			
			
		<!-- Solo el usuario propietario puede realizar las siguientes operaciones-->
		<?php  if( Login::user()->id == $lugar->iduser) {// autorización(solo propietario) ?>
				<a class="button" href="/Lugar/edit/<?=$lugar->id?>">Editar</a>
				
			<?php }?>
		</div>
	</main>
</body>

</html>