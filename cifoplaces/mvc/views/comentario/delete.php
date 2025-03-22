<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Confirmación de borrado de comentario - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="borrado de Comentario - <?= APP_NAME ?>">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Confirmación borrado de un comentario') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['comentarios'=>'/Comentario','Confirmar borrado'=>null]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
	<main>
	<h1><?=APP_NAME?></h1>
	<h2>Borrar comentario</h2>
	
	<form method="POST" enctype="multipart/form-data" class="p2 m2 centered" action="/Comentario/destroy">
		<p>Confirmar el borrado del comentario:<b>"<?= $comentario->text?>"</b></p>
		<?php  if( $comentario->iduser == Login::user()->id || Login::oneRole(['ROLE_ADMIN','ROLE_MODERADOR'])) {
			// autorización(solo  el que lo ha publidado y administradores) ?>
				<input type="hidden" name="id" value="<?= $comentario->id ?>">
				 <input type="submit" class="button-danger" name="borrar" value="Borrar">
			<?php }?>
		
	</form>
	
		<div class="centered">
			<a class="button" onclick="history.back()">Atrás</a>
			<a class="button" href="/Comentario/list">Lista de comentarios</a>
			<a class="button" href="/Comentario/show/<?=$comentario->id?>">Detalles</a>
			<a class="button" href="/Comentario/edit/<?=$comentario->id?>">Edición</a>
		</div>		
	
</main>		
	
	
</body>
</html>
