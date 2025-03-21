<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Listado de lugares - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Lista de lugares - <?= APP_NAME ?>">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Lista de lugares') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Lugares'=>null])?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
		
		<main>
    		<h1></h1>
       		<h2>Lista completa de lugares en <b><?= APP_NAME ?></b></h2>
       		<a class="button" href='/Lugar/create'>Nuevo Lugar</a>
     		
		      		<!--  FILTR DE BÚSQUEDA -->
		      		<?php 
		      		//si hay filtro guardado en sesión
		      		if($filtro){
		      					      			//pone el formulario de "quitar filtro
		      			//el metrodo removeFilterForm necesita conocer el filtro
		      			// y ka ruta a la que se envia el formulario
		      			echo $template->removeFilterForm($filtro,'/Lugar/list');
		      		//en caso contrario
		      		} else {
		      			//pone el formulario de "nuevo filtro"
		      			echo $template->filterForm(
			      			[
			      				'Lugar' => 'name',
			      				'Tipo' => 'type',
								'Localización' => 'location',
								'Descripción' => 'description',
								'Fecha' => 'created_at'
			 
			      			],
			      			//lista de campos para el desplegable "ordenado por "
			      			[
			      				'Lugar' => 'name',
			      				'Tipo' => 'type',
								'Localización' => 'location',
								'Descripción' => 'description',
								'Fecha' => 'created_at'
			    				
			    			],
			    			// valor por defecto para "buscar en"
			    			'Lugar',
			    			// valor por defecto para "ordenado por"
			    			'Lugar'
						);
		      			
		      		}?>
		       		
		       		<!--  Enlaces creados por el paginador -->
		       		<div class="rigth">
		       			<?=$paginator->stats()?>
		       		</div>
       		<?php if($lugares){ ?>
      		
       			<table class="table w100">
       					<tr>
       						<th>Foto</th>
       						<th>Lugar</th>
							<th>Tipo</th>
       						<th>Descripcion</th>
       						<th>Localizacion</th>
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
						<td><?=$lugar->username ?></td>
						<td><?=$lugar->created_at?></td>
						<td class="centrado">
							<a class="button" href='/lugar/show/<?=$lugar->id?>'>
								<img src="/images/icons/show.png" alt="Ver" style="width:20px;height:20px;"></a>
							<a class="button" href='/lugar/edit/<?=$lugar->id?>'><img src="/images/icons/edit.png" alt="Editar" style="width:20px;height:20px;"></a>
							<?php  if( Login::user()->id == $lugar->iduser || Login::oneRole(['ROLE_ADMIN','ROLE_MODERADOR'])) {// autorización(solo propietario) ?>
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
			</main>
			<?= $paginator->ellipsisLinks()?>
			<?= $template->footer() ?>
</body>

</html>