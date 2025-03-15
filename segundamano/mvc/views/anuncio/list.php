<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Listado de anuncios - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Lista de anuncios - <?= APP_NAME ?>">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Lista de anuncios') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Anuncios'=>null])?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
		
		<main>
    		<h1></h1>
       		<h2>Lista completa de anuncios en <b><?= APP_NAME ?></b></h2>
       		<a class="button" href='/Anuncio/create'>Nuevo Anuncio</a>
     		
		      		<!--  FILTR DE BÚSQUEDA -->
		      		<?php 
		      		//si hay filtro guardado en sesión
		      		if($filtro){
		      					      			//pone el formulario de "quitar filtro
		      			//el metrodo removeFilterForm necesita conocer el filtro
		      			// y ka ruta a la que se envia el formulario
		      			echo $template->removeFilterForm($filtro,'/Anuncio/list');
		      		//en caso contrario
		      		} else {
		      			//pone el formulario de "nuevo filtro"
		      			echo $template->filterForm(
			      			[
			      				'Titulo' => 'titulo',
			      				'Descripción' => 'descripcion',
								'Precio' => 'precio',
								'Población' => 'poblacion',
								'Fecha' => 'fecha'
			 
			      			],
			      			//lista de campos para el desplegable "ordenado por "
			      			[
			      			'Titulo' => 'titulo',
			      			'Descripción' => 'descripcion',
			      			'Precio' => 'precio',
			      			'Población' => 'poblacion',
			      			'Fecha' => 'fecha'
			    				
			    			],
			    			// valor por defecto para "buscar en"
			    			'Titulo',
			    			// valor por defecto para "ordenado por"
			    			'Titulo'
						);
		      			
		      		}?>
		       		
		       		<!--  Enlaces creados por el paginador -->
		       		<div class="rigth">
		       			<?=$paginator->stats()?>
		       		</div>
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
			</main>
			<?= $paginator->ellipsisLinks()?>
			<?= $template->footer() ?>
</body>

</html>