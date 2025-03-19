<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Listado de usuarios - <?= APP_NAME ?></title>

<!-- META -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Lista de usuarios - <?= APP_NAME ?>">
<meta name="author" content="Jose Miguel Mora Perez">

<!-- FAVICON -->
<link rel="shortcut icon" href="/favicon.ico" type="image/png">

<!-- CSS -->
		<?= $template->css() ?>
	</head>
<body>
		<?= $template->login() ?>
		<?= $template->header('Lista de usuarios') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Usuarios'=>null])?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
		
		<main>
		<?php
		// Si tenemos la lista de usuarios y somos administradores, mostrara el listado
		// Si no se ha obtenido la lista de usuarios
		// para evitar que se acceda directamente o una vista incorrecta
		
		if ( $users && Login::role ('ROLE_ADMIN' )) {	?>
     		<h1><?= APP_NAME ?></h1>
      	<h2>Lista completa de usuarios</h2>
		<a class="button" href='/User/create'>Nuevo usuario</a>
		
					      		<!--  FILTR DE BÚSQUEDA -->
		      		<?php
								// si hay filtro guardado en sesión
								if ($filtro) {
									// pone el formulario de "quitar filtro
									// el metrodo removeFilterForm necesita conocer el filtro
									// y ka ruta a la que se envia el formulario
									echo $template->removeFilterForm ( $filtro, '/User/list' );
									// en caso contrario
								} else {
									// pone el formulario de "nuevo filtro"
									echo $template->filterForm ( [ 
											'Displayname' => 'displayname',
											'Email' => 'email',
											'Telefono' => 'phone',
											'Alta' => 'created_at'
									], 
											// lista de campos para el desplegable "ordenado por "
											[ 
													'Displayname' => 'displayname',
													'Email' => 'email',
													'Telefono' => 'phone',
													'Alta' => 'created_at'
											], 
											// valor por defecto para "buscar en"
											'Displayname', 
											// valor por defecto para "ordenado por"
											'Displayname' );
								}
								?>
		       		
		       		<!--  Enlaces creados por el paginador -->
		<div class="rigth">
		       			<?=$paginator->stats()?>
		       		</div>

		<table class="table w100">
			<tr>
				<th>Foto</th>
				<th>Displayname</th>
				<th>Email</th>
				<th>Telefono</th>
				<th>Alta</th>
				<th>Roles</th>
				<th class="centrado">Acciones</th>
				<?php foreach($users as $user){   ?>
						
			
			
			<tr>
				<td><script src="/js/BigPicture.js"></script>

					<figure class="flex1 centrado p2">

						<img
							src="<?=USER_IMAGE_FOLDER.'/'.($user->picture ?? DEFAULT_USER_IMAGE)?>"
							class="table-image enlarge-image"
							alt="Foto de perfil de <?= $user->displayname ?>">

						<figcaption>Foto de perfil de <?= $user->displayname ?></figcaption>

					</figure>
				
				<td><a href='/User/show/<?=$user->id?>'><?=$user->displayname?></a></td>
				<td><?=$user->email?></td>
				<td><?=$user->phone?></td>
				<td><?=$user->created_at?></td>
				<td><?=arrayToString($user->roles, false,false)?></td>
				<td class="centrado"><a class="button"
					href='/User/show/<?=$user->id?>'> <img src="/images/icons/show.png"
						alt="Ver" style="width: 20px; height: 20px;"></a> <a
					class="button" href='/user/edit/<?=$user->id?>'><img
						src="/images/icons/edit.png" alt="Editar"
						style="width: 20px; height: 20px;"></a> <a class="button-danger"
					href='/user/delete/<?=$user->id?>'><img
						src="/images/icons/delete.png" alt="Borrar"
						style="width: 20px; height: 20px;"></a></td>
			</tr>
					
					<?php } ?>
				</table>	


			<?php }	?>				
			</main>
			<?= $paginator->ellipsisLinks()?>
			<?= $template->footer() ?>
</body>

</html>