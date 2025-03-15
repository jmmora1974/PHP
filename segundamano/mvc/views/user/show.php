<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Visualización de un usuario - <?= APP_NAME ?></title>

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
		<?= $template->header('Detalles del usuario') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Usuarios'=>'/User','Detalles'=>null]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
	<main>
	
		<?php 	Auth::check(); // autorización(solo usuarios propietario o administradores 
if (  (!Login::role ('ROLE_ADMIN')&& user()->id!=$user->id)) {
	Session::error(("Transación no autorizada!. "));
		return redirect ('/'.user()->id);
	}?>
		<h1><?=APP_NAME?></h1>
		<section id="detalles" class="flex-container gap2">
	<div class="flex2 centered">	
		
			<input type="hidden" name="id" value="<?= $user->id ?>" >
		<label for="displayname">Displayname</label>
			<input type="text" name="displayname" value="<?= $user->displayname ?>" required disabled>
			<br>
			<label for="telefono">Telefono</label>
			<input type="number" min="0" name="telefono" value="<?=$user->phone?>" disabled>
			<br>
			<label for="email">Email</label>
			<input type="email" name="email" value="<?=$user->email ?>" disabled >
			<br>
			<label for="poblacion">Población</label>
			<input type="text" name="poblacion" value="<?=$user->poblacion ?>" disabled>
			<br>
			<label for="cp">Codigo Postal</label>
			<input type="text" name="cp" value="<?=$user->cp ?>" disabled>
			<br>
			
	<?php    //Los administradores podran ver las siguientes opciones

		if ( Login::role ( 'ROLE_ADMIN' )) { ?>
			<label for="password">Password</label>
			<input type="password" name="password" value="<?=$user->password ?>" disabled>
			<br>
			<label for="alta">Alta</label>
			<input type="text" name="alta" value="<?=  $user->created_at?>" disabled>
			<br>
			<label for="alta">Bloqueado</label>
			<input type="text" name="blocked" value="<?= $user->blocked_at?>" disabled>
			<br>
			<label for="alta">Ultima actualización </label>
			<input type="text" name="updated" value="<?=  $user->updated_at?>" disabled>
			<br>
			<label>Rol</label>
			<input type="text" name="updated" value="<?= arrayToString($user->roles, false, false)?>" disabled>
			
				
			
		<?php } ?>
		
		
			
				
		
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
			<?php Login::isAdmin() ??
				'<a class="button" href="/User/list">Lista de usuarios</a>'; ?>
			<a class="button" href="/User/edit/<?=$user->id?>">Editar</a>
			
		</div>
	</main>
</body>

</html>