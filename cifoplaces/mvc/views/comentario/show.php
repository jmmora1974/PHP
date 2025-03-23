<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Visualización de un comentario - <?= APP_NAME ?></title>

<!-- META -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Ver usuairos - <?= APP_NAME ?>">
<meta name="author" content="Jose Miguel Mora Perez">

<!-- FAVICON -->
<link rel="shortcut icon" href="/favicon.ico" type="image/png">

<!-- CSS -->
		<?= $template->css() ?>
	</head>
<body>
		<?= $template->login() ?>
		<?= $template->header('Detalles del comentario') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Comentarios'=>'/Cometario','Detalles'=>null]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
	<main>
	
		<?php 	Auth::check(); // autorización(solo comentarios propietario o administradores 
if (  (!Login::oneRole (['ROLE_MODERADOR','ROLE_ADMIN'])&& user()->id!=$user->id)) {
	Session::error(("Transación no autorizada!. "));
		return redirect ('/'.user()->id);
	}?>
		<h1><?=APP_NAME?></h1>
		<section id="detalles" class="flex-container gap2">
	<div class="flex2 centered">	
		
			<input type="hidden" name="id" value="<?= $comentario->id ?>" >
			<label for="username">Usuario</label>
			<input type="text" name="username" value="<?= $comentario->username ?>" required disabled>
			<br>
			<label for="text">Comentario</label>
			<input type="text" name="text" value="<?=$comentario->text?>" disabled>
			<br>
			<label for="lugar">Lugar</label>
			<input type="text" name="lugar" value="<?=$comentario->placename ?>" disabled >
			<br>
			<label for="foto">Población</label>
			<input type="text" name="foto" value="<?=$comentario->photoname ?>" disabled>
			<br>
			<label for="fecha">Fecha</label>
			<input type="date" name="fecha" value="<?=$comentario->created_at ?>" disabled>
			<br>
			
	
		
			
				
		
	</div>
		<div class="flex2">
			<script src="/js/BigPicture.js"></script>
				<figure class="flex1 centrado p2">
				<img src="<?=USER_IMAGE_FOLDER.'/'.($user->picture ?? DEFAULT_USER_IMAGE)?>"
				 	class="cover enlarge-image" alt="Foto de perfil de <?= $user->displayname ?>">				 		
				 <figcaption>Foto de perfil de <?= $user->displayname ?> </figcaption>
		
			<br>
				
			</figure>
			</div>
		
		</section>
		
		<div class="centrado">
			<a class="button" onclick="history.back()">Atrás</a> 
			<?php Login::role('ROLE_MODERADOR') ??
				'<a class="button" href="/User/list">Lista de comentarios</a>'; ?>
			<a class="button" href="/User/edit/<?=$user->id?>">Editar</a>
			
		</div>
	</main>
</body>

</html>