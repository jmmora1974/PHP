<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Edición de usuario - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Edición de usuario  - <?= APP_NAME ?>">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Edición de usuario') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Usuarios'=>'/User','Edicion'=>null]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
	<main>
	<?php 	Auth::check(); // autorización(solo usuarios propietario o administradores 
if (  (!Login::role ('ROLE_ADMIN')&& user()->id!=$user->id)) {
		Session::error(("Transación no autorizada!. "));
		return redirect ('/User/edit/'.user()->id);
	}?>
		
	<h1><?=APP_NAME?></h1>
	<h2>Edición del usuairo: <b>"<?= $user->displayname?>"</b></h2>
	<section id="detalles" class="flex-container gap2">
	<div class="flex2 centered">	
		<form method="POST" enctype="multipart/form-data" action="/User/update">
			<input type="hidden" name="id" value="<?= $user->id ?>" >
		<label for="displayname">Displayname</label>
			<input type="text" name="displayname" value="<?= $user->displayname ?>" required>
			<br>
			<label for="telefono">Telefono</label>
			<input type="number" min="0" name="telefono" value="<?=$user->phone?>">
			<br>
			<label for="email">Email</label>
			<input type="email" name="email" value="<?=$user->email ?>">
			<br>
			<label for="poblacion">Población</label>
			<input type="text" name="poblacion" value="<?=$user->poblacion ?>">
			<br>
			<label for="cp">Codigo Postal</label>
			<input type="text" name="cp" value="<?=$user->cp ?>">
			<br>
			
			
	<?php    //Los administradores podran ver las siguientes opciones

		if ( Login::role ( 'ROLE_ADMIN' )) { ?>
			<label for="password">Password</label>
			<input type="password" name="password" value="<?=$user->password ?>">
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
			
			
		<?php } 
//Esta operación solamente la puede hacer el administrador
		if(Login::isAdmin() || user()->id==$user->id){  ?>
			<div class="centered mt2 ">
				<input type="submit" class="button" name="actualizar" value="Actualizar">
				<input type="reset" class="button" value="Reset" onclick="<?php redirect('/User/edit/$user->id');?>">	
					<a class="button-danger" href='/user/delete/<?=$user->id?>'>
						Borrado <img src="/images/icons/delete.png" alt="Borrar" style="width:20px;height:20px;"> 
					</a>
			</div>
			<?php } ?>
		</form>
	</div>
		<div class="flex2">
			<script src="/js/BigPicture.js"></script>
				<figure class="flex1 centrado p2">
				<img src="<?=USER_IMAGE_FOLDER.'/'.($user->picture ?? DEFAULT_USER_IMAGE)?>"
				 	class="cover enlarge-image" alt="Foto de perfil de <?= $user->displayname ?>">				 		
				 <figcaption>Foto de perfil de <?= $user->displayname ?> </figcaption>
		
			<br>
				<!-- Botón de eliminar la portada (sin cambiar nada mas) -->
				<form method="POST" action="/User/changeuserfoto" enctype="multipart/form-data"  class="no-border">
					<input type="hidden" name="id" value="<?= $user->id?>">
						<label for="picture">Foto perfil</label>
			<input type="file" name="picture" accept="image/*" id="file-with-preview" value="<?= old('picture', $user->picture)?>">
					<input type="submit" class="button" name="cambiar" value="Cambiar foto perfil">
					<?php if($user->picture)
						echo '<input type="submit" class="button-danger" name="borrar" value="Eliminar foto perfil">';
						?>
				</form>
			</figure>
			</div>
		
		</section>
				<div class="centrado m1">
			<a class="button" onclick="history.back()">Atrás</a>
			<?php Login::isAdmin()?  '<a class="button" href="/User/list">Lista de usuarios</a>':'' ?>
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
