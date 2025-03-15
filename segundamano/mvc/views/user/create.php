<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Nuevo usuario - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Nuevo usuario e <?= APP_NAME ?>">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Nuevo usuario') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Usuarios'=>'/User','Nuevo usuario'=>null]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
	<main>
	
								
	<h1><?=APP_NAME?></h1>
	
	<section id="new-user" >
	<h2>Nuevo usuario</h2>
	<div class="flex-container gap2">
		<form method="POST" enctype="multipart/form-data" action="/User/store">
		 <div class="flex2">
			<label for="displayname">Displayname</label>
			<input type="text" name="displayname" value="<?= old('displayname')?>" required>
			<br>
			<!--   Campos no incluidos por el momento
			<label for="nombre">Nombre</label>
			<input type="text" name="nombre" value="<?= old('nombre')?>" required>
			<br>
			<label for="apellidos">Apellidos</label>
			<input type="text" name="apellidos" value="<?= old('apellidos')?>" >
			<br>
			 -->
			<label for="telefono">Telefono</label>
			<input type="number" min="0" name="telefono" value="<?=old('telefono')?>">
			<br>
			<label for="email">Email</label>
			<input type="email" name="email" value="<?=old('email')?>">
			<br>
			<label for="password">Password</label>
			<input type="password" name="password" >
			<br>
			<label for="repeatpassword">Repetir password</label>
			<input type="password" name="repeatpassword" >
			<br>
			<label for="poblacion">Poblacion</label>
			<input type="text" name="poblacion" value="<?=old('poblacion')?>">
			<br>
			<label for="cp">Codigo postal</label>
			<input type="text" name="cp" value="<?=old('cp')?>">
			<br>
			<label for="picture">Imagen de  perfil</label>
			<input type="file" name="picture" accept="image/*" id="file-with-preview" >
			<br>
			<?php  if ( Login::role ( 'ROLE_ADMIN' )) { ?>
			<label>Rol</label>
			<!--  
				Este desplegable se genera a partir de la lista de roles 
				indicados en el fichero config.hp
				Añadid a esta lista el rol: 'Bibliotecario0 => 'ROLE_LIBRARIAN'
			 -->
			 <select name="roles">
			 	<?php  foreach(USER_ROLES as $roleName =>$roleValue){ ?>
			 		<option value="<?= $roleValue ?>"><?= $roleName ?></option>
			 	<?php } ?>
			 </select>
			 
			 <?php } ?>
			
		</div>
		
		
		<div class="centered mt3">
				<input type="submit" class="button" name="guardar" value="Guardar">
				<input type="reset" class="button" value="Reset">	
		</div>
		
		</form>
		
		<div class="flex2">
		<script src="/js/BigPicture.js"></script>
			<figure class="flex1 centrado p2">
					<img src="<?=USER_IMAGE_FOLDER.'/'.DEFAULT_USER_IMAGE?>"
					 	class="cover enlarge-image" alt="Previsualización foto de perfil">				 		
					 <figcaption>Previsualización foto de perfil</figcaption>
			
				<br>
			</figure>		
		
			</div>
		</div>
		</section>
		
	
	
</main>		
	
	
</body>
</html>
