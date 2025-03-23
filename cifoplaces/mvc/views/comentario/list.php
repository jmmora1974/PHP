<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Listado de comentarios - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Lista de comentarios - <?= APP_NAME ?>">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Lista de comentarios') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Comentarios'=>null])?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
		
		<main>
    		<h1></h1>
       		<h2>Lista completa de comentarios en <b><?= APP_NAME ?></b></h2>
       	
     		
		      		<!--  FILTR DE BÚSQUEDA -->
		      		<?php 
		      		//si hay filtro guardado en sesión
		      		if($filtro){
		      					      			//pone el formulario de "quitar filtro
		      			//el metrodo removeFilterForm necesita conocer el filtro
		      			// y ka ruta a la que se envia el formulario
		      			echo $template->removeFilterForm($filtro,'/Comentario/list');
		      		//en caso contrario
		      		} else {
		      			//pone el formulario de "nuevo filtro"
		      			echo $template->filterForm(
			      			[
			      				'Comentario' => 'text',
			      				'Usuario' => 'username',
								'Lugar' => 'placename',
								'Localización' => 'location',
								'Fecha' => 'created_at'
			 
			      			],
			      			//lista de campos para el desplegable "ordenado por "
			      			[
			      			'Comentario' => 'text',
			      			'Usuario' => 'username',
			      			'Lugar' => 'placename',
			      			'Localización' => 'location',
			      			'Fecha' => 'created_at'
			    				
			    			],
			    			// valor por defecto para "buscar en"
			    			'Comentario',
			    			// valor por defecto para "ordenado por"
			    			'Fecha'
						);
		      			
		      		}?>
		       		
		       		<!--  Enlaces creados por el paginador -->
		       		<div class="rigth">
		       			<?=$paginator->stats()?>
		       		</div>
       		<?php if($comentarios){ ?>
      		<script src="/js/BigPicture.js"></script>
       			<table class="table w100">
       					<tr>
       						<th>Foto</th>
       						<th>ID</th>
       						<th>Comentario</th>
							<th>Lugar</th>
       						<th>Foto</th>       						
							<th>Creador</th>
							<th>Fecha</th>
       						<th class="centrado">Acciones</th>
						</tr>
						
					

							<?php foreach($comentarios as $comentario){   ?>
								<tr>
							<td>
								<figure class="flex1 centrado p2">
						
									<img src="<?=USER_IMAGE_FOLDER.'/'.($comentario->userpicture ?? DEFAULT_USER_IMAGE)?>"
								 		class="table-image enlarge-image" alt="Foto del usuario <?= $comentario->username?>">
									
								</figure>
						</td>
						<td><a href='/Comentario/show/<?=$comentario->id?>'><?=$comentario->id?></a></td>
						<td><a href='/Comentario/show/<?=$comentario->id?>'><?=$comentario->text?></a></td>
						<td><?=$comentario->idplace.' - '.$comentario->placename?></td>
						<td><?=$comentario->idphoto.' - '.$comentario->photoname?></td>
						<td><?=$comentario->username ?></td>
						<td><?=$comentario->created_at?></td>
						<td class="centrado">
							<a class="button" href='/comentario/show/<?=$comentario->id?>'>
								<img src="/images/icons/show.png" alt="Ver" style="width:20px;height:20px;"></a>
							<a class="button" href='/comentario/edit/<?=$comentario->id?>'><img src="/images/icons/edit.png" alt="Editar" style="width:20px;height:20px;"></a>
							<?php  if( Login::user()->id == $comentario->iduser || Login::oneRole(['ROLE_ADMIN','ROLE_MODERADOR'])) {// autorización(solo propietario) ?>
								<a class="button-danger" href='/comentario/delete/<?=$comentario->id?>'><img src="/images/icons/delete.png" alt="Borrar" style="width:20px;height:20px;"></a>
							<?php } ?>
						</td>
					</tr>
					
					<?php } ?>
				</table>	
			<?php } else { ?>
				<div class="danger p2">
					<p>No hay comentarios que mostrar</p>
				</div>
				<?php } ?>
			</main>
			<?= $paginator->ellipsisLinks()?>
			<?= $template->footer() ?>
</body>

</html>