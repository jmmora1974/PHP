<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Usuario - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="usuarios - <?= APP_NAME ?>">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Home') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Home'=>null])?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
		
		<main>
		<?php 
			//	comprobamos que el usuario está loginado
	 	Auth::check(); 
	 	// autorización(solo usuarios propietario o administradores 
	 	if (  (!Login::role ('ROLE_ADMIN')&& user()->id!=$user->id)) {
		Session::warning(("Transación no autorizada!. "));
		return redirect ('/User/edit/'.user()->id);
	}?>
    		<section class="flex-container" id="user-data">
    			<div class="flex2">
    				<h2>"Home de <?= $user->displayname?>"</h2>
    				
    				<p><b>Nombre:</b> 				<?= $user->displayname ?></p>
    				<p><b>Email:</b> 				<?= $user->email ?></p>
    				<p><b>Telefono:</b> 			<?= $user->phone ?></p>
    				<p><b>Fecha de alta:</b> 		<?= $user->create_at ?></p>
    				<p><b>Última modificación:</b> 	<?= $user->updated_at ?? '--'?></p>
    				<a class="button" href="/User/cambiaContrasenya">Cambiar contraseña</a>
    			</div>
    			<!-- Esta parte solamente si creais la carpeta para las fotos de perfil  -->
    			<figure class="flex1 centrado">
    				<img src="<?= USER_IMAGE_FOLDER.'/'.($user->picture ?? DEFAULT_USER_IMAGE)?>"
    					class="cover elnarge-image" alt="Emagen de perfil de <?=$user->displayname ?>">
    				<figcaption>Imagen de perfil de <?=$user->displayname ?></figcaption>				
    			</figure>
    			<div class="centrado">
			<a class="button" onclick="history.back()">Atrás</a> 
			<?php Login::isAdmin() ??
				'<a class="button" href="/User/list">Lista de usuarios</a>'; ?>
				
				<a class="button" href="/User/edit/<?=$user->id?>">Editar</a>
				<a class="button-danger" href='/user/delete/<?=$user->id?>'>
						Borrado <img src="/images/icons/delete.png" alt="Borrar" style="width:20px;height:20px;"> 
					</a>
			
		</div>			    			
    		</section>
    		<section id="secmislugares">
    			<?php if($lugares){ ?>
      		
       			<table class="table w100">
       					
       					<tr>
       						<th>Foto</th>
       						<th>Lugar</th>
							<th>Tipo</th>
       						<th>Descripcion</th>
       						<th>Localizacion</th>
							<th>Latitud</th>
							<th>Longitud</th>
							<th>Creador</th>
							<th>Fecha</th>
       						<th class="centrado">Acciones</th>
						</tr>
       						
						<script src="/js/BigPicture.js"></script>
				<?php foreach($lugares as $lugar){   ?>
					
						<tr>

							
					
							<td>
								<figure class="flex1 centrado p2">
						
									<img src="<?=LUGAR_IMAGE_FOLDER.'/'.($lugar->mainpicture ?? DEFAULT_LUGAR_IMAGE)?>"
								 		class="table-image enlarge-image" alt="Foto del lugar <?= $lugar->name?>">
									
								</figure>
							</td>
						<td><a href='/Lugar/show/<?=$lugar->id?>'><?=$lugar->name?></a></td>
						<td><?=$lugar->type?></td>
						<td><?=$lugar->description?></td>
						<td><?=$lugar->location?></td>
						<td><?=$lugar->latitude?></td>
						<td><?=$lugar->longitude?></td>
						<td><?=$lugar->username ?></td>
						<td><?=$lugar->created_at?></td>
						<td class="centrado">
							<a class="button" href='/lugar/show/<?=$lugar->id?>'>
								<img src="/images/icons/show.png" alt="Ver" style="width:20px;height:20px;"></a>
							<a class="button" href='/lugar/edit/<?=$lugar->id?>'><img src="/images/icons/edit.png" alt="Editar" style="width:20px;height:20px;"></a>
							<?php  if( Login::user()->id == $lugar->iduser) {// autorización(solo propietario) ?>
								<a class="button-danger" href='/lugar/delete/<?=$lugar->id?>'><img src="/images/icons/delete.png" alt="Borrar" style="width:20px;height:20px;"></a>
							<?php } ?>
						</td>
					</tr>
					
					<?php } ?>
				</table>	
			<?php } else { ?>
				<div class="danger p2">
					<p>No hay lugares que mostrar</p>
				</div>
				<?php } ?>
    		</section>
    	</main>
    </body>
 </html>
 
       		