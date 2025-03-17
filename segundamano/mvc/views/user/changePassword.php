<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Cambio contraseña de usuario - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Cambio contraseña de usuario - <?= APP_NAME ?>">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Cambio contraseña de usuario') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Usuarios'=>'/User','Cambio contraseña'=>null]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
	<main>
	<?php 	Auth::check(); // autorización(solo usuarios identificados ?>
	
	<h1><?=APP_NAME?></h1>
	<h2>Cambio contraseña de  <b>"<?= $user->displayname?>"</b></h2>
	<section id="detalles" class="flex-container gap2">
	<div class="flex2 centered">	
		<form method="POST" enctype="multipart/form-data" action="/User/changePassword">
			<input type="hidden" name="id" value="<?= $user->id ?>" >
					

			<label for="oldpassword">Contraseña antigua:</label>
			<input type="password" name="oldpassword">
			<br>
			<label for="newpassword">Nueva contraseña:</label>
			<input type="password" name="newpassword" >
			<br>
			<label for="repeatpassword">Repetir contraseña:</label>
			<input type="password" name="repeatpassword" >
			<br>
			
		
				
			<div class="centered mt2 ">
				<input type="submit" class="button" name="cambiar" value="Cambiar">
				
			</div>
		</form>
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
				<div class="centrado m1">
			<a class="button" onclick="history.back()">Atrás</a>
			<a class="button" href="/User/list">Lista de usuarios</a>
			<a class="button" href="/User/show/<?=$user->id?>">Detalles</a>
		
				
		
					
		</div>	
			<?php if(Login::role('ROLE_ADMIN')){ ?>
			<section id="roles">
				<h3>Roles del usuario</h3>
					<form method="POST" action="/User/agregarrol" enctype="multipart/form-data"> 
					<input type="hidden" name="id" value="<?=$user->id ?>">
					<select name="roles">
					 	<?php  foreach(array_diff(USER_ROLES,$user->roles) as $roleName =>$roleValue){ ?>
					 		<option value="<?= $roleValue ?>"><?= $roleName ?></option>
					 	<?php } ?>
					 </select>
					<input type="submit" name="agregarrol" value="Agregar rol" class="button">
				</form>
				<table class="table w100 centered-block">
					<tr>
						<th>ROL</th>
						<th>Operaciones</th>
					</tr>
						
					<?php 
						$roles = $user->roles;
						foreach($roles as $role ){ ?>
							<tr>
								<td> <?=$role ?></td>
								
								<td class="centrado">	
									<form method="POST" action="/User/quitarol" enctype="multipart/form-data" class="no-border"> 
										<input type="hidden" name="id" value="<?=$user->id ?>">
										<input type="hidden" name="role" value="<?=$role?>">
										<input type="submit" name="quitarrol" value="Quitar rol" class="button-danger">
						
									</form>	
								</td>
							</tr>
						<?php }?>
				</table>
				</section>
			
			<?php }?>
		
			
			
		
	
</main>		
	
	
</body>
</html>
