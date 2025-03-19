<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Confirmación de borrado de anuncio - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="borrado de Anuncio - <?= APP_NAME ?>">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Confirmación borrado de un anuncio') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['anuncios'=>'/Anuncio','Confirmar borrado'=>null]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
	<main>
	<h1><?=APP_NAME?></h1>
	<h2>Borrar anuncio</h2>
	
	<form method="POST" enctype="multipart/form-data" class="p2 m2 centered" action="/Anuncio/destroy">
		<p>Confirmar el borrado del anuncio:<b>"<?= $anuncio->titulo?>"</b></p>
		<?php  if( $anuncio->iduser == Login::user()->id) {// autorización(solo  el que lo ha publidado) ?>
				<input type="hidden" name="id" value="<?= $anuncio->id ?>">
				 <input type="submit" class="button-danger" name="borrar" value="Borrar">
			<?php }?>
		
	</form>
	
		<div class="centered">
			<a class="button" onclick="history.back()">Atrás</a>
			<a class="button" href="/Anuncio/list">Lista de anuncios</a>
			<a class="button" href="/Anuncio/show/<?=$anuncio->id?>">Detalles</a>
			<a class="button" href="/Anuncio/edit/<?=$anuncio->id?>">Edición</a>
		</div>		
	
</main>		
	
	
</body>
</html>
