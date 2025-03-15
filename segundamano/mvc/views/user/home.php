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
		//Auth::check(); // autorización(solo usuarios identificados
		?>
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
    		</section>
    		<section id="secmisanuncios">
    			<?php if($anuncios){ ?>
      		
       			<table class="table w100">
       					<tr>
       						<th>Foto</th>
       						<th>Titulo</th>
       						<th>Descripcion</th>
       						<th>Precio</th>
       						<th>Fecha</th>
       						<th>Población</th>
       						<th class="centrado">Acciones</th>
       					
				<?php foreach($anuncios as $anuncio){   ?>
					<tr>
						<td><script src="/js/BigPicture.js"></script>
			
							<figure class="flex1 centrado p2">
						
								<img src="<?=ANUNCIO_IMAGE_FOLDER.'/'.($anuncio->imagen ?? DEFAULT_ANUNCIO_IMAGE)?>"
								 	class="table-image enlarge-image" alt="Foto del anuncio <?= $anuncio->titulo?>">
										 		
								 <figcaption>Foto del anuncio <?= $anuncio->titulo?> </figcaption>
								 
							</figure>
						</td>
						<td><a href='/Anuncio/show/<?=$anuncio->id?>'><?=$anuncio->titulo?></a></td>
						<td><?=$anuncio->descripcion?></td>
						<td><?=$anuncio->precio?></td>
						<td><?=$anuncio->fecha?></td>
						<td><?=$anuncio->poblacion?></td>
						<td class="centrado">
							<a class="button" href='/anuncio/show/<?=$anuncio->id?>'>
								<img src="/images/icons/show.png" alt="Ver" style="width:20px;height:20px;"></a>
							<a class="button" href='/anuncio/edit/<?=$anuncio->id?>'><img src="/images/icons/edit.png" alt="Editar" style="width:20px;height:20px;"></a>
							<?php  if( Login::user()->id == $anuncio->iduser) {// autorización(solo propietario) ?>
								<a class="button-danger" href='/anuncio/delete/<?=$anuncio->id?>'><img src="/images/icons/delete.png" alt="Borrar" style="width:20px;height:20px;"></a>
							<?php } ?>
						</td>
					</tr>
					
					<?php } ?>
				</table>	
			<?php } else { ?>
				<div class="danger p2">
					<p>No hay anuncios que mostrar</p>
				</div>
				<?php } ?>
    		</section>
    	</main>
    </body>
 </html>
 
       		