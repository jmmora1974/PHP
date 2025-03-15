<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title> <?=APP_NAME?> - Confirmación de borrado de usuario - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="borrado de usuario - <?= APP_NAME ?>">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Confirmación borrado de un usuario') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Usuarios'=>'/User','Confirmar borrado'=>null]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
	<main>
	<?php 	Auth::check(); // autorización(solo usuarios propietario o administradores 
if (  (!Login::role ('ROLE_ADMIN')&& user()->id!=$user->id)) {
		Session::warning(("Transación no autorizada!. "));
		return redirect ('/User/edit/'.user()->id);
	}?>
	<h1><?=APP_NAME?></h1>
	<h2>Borrar usuario</h2>
	
	<form method="POST" enctype="multipart/form-data" class="p2 m2 centered" action="/User/destroy">
		<p>Confirmar el borrado del usuario:<b>"<?= $user->displayname?>"</b></p>
		<?php
			//Enlace solo para el administrador
		if(Login::role('ROLE_ADMIN') || user()->id==$user->id){?>
		<input type="hidden" name="id" value="<?= $user->id ?>">
		<?php }?>
				<input type="submit" class="button-danger" name="borrar" value="Borrar">
	</form>
	
		<div class="centered">
			<a class="button" onclick="history.back()">Atrás</a>
			
			
			<?php
			//Enlace solo para el administrador
        	if(Login::role('ROLE_ADMIN')){?>
        		<a class="button" href="/User/list">Lista de users</a>
				<a class="button" href="/User/show/<?=$user->id?>">Detalles</a>
				<a class="button" href="/User/edit/<?=$user->id?>">Edición</a>
			<?php }?>
		</div>		
	
</main>		
	
	
</body>
</html>
