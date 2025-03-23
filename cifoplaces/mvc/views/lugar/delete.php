<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Confirmación de borrado de lugar - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="borrado de Lugar - <?= APP_NAME ?>">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Confirmación borrado de un lugar') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['lugares'=>'/Lugar','Confirmar borrado'=>null]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
	<main>
	<h1><?=APP_NAME?></h1>
	<h2>Borrar lugar</h2>
	
	<form method="POST" enctype="multipart/form-data" class="p2 m2 centered" action="/Lugar/destroy">
		<p>Confirmar el borrado del lugar:<b>"<?= $lugar->name?>"</b></p>
		<?php  if( $lugar->iduser == Login::user()->id  || Login::oneRole(['ROLE_ADMIN','ROLE_MODERADOR']))  {// autorización(solo  el que lo ha publidado) ?>
				<input type="hidden" name="id" value="<?= $lugar->id ?>">
				 <input type="submit" class="button-danger" name="borrar" value="Borrar">
			<?php }?>
		
	</form>
	
		<div class="centered">
			<a class="button" onclick="history.back()">Atrás</a>
			<a class="button" href="/Lugar/list">Lista de lugares</a>
			<a class="button" href="/Lugar/show/<?=$lugar->id?>">Detalles</a>
			<a class="button" href="/Lugar/edit/<?=$lugar->id?>">Edición</a>
		</div>		
	
</main>		
	
	
</body>
</html>
