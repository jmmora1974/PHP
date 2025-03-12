<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Listado de temas - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Lista de temas - <?= APP_NAME ?>">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Lista de temas') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Temas'=>null])?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>
       		<h2>Lista completa de temas</h2>
       		
      		
		      		<!--  FILTR DE BÚSQUEDA -->
		      		<?php 
		      		//si hay filtro guardado en sesión
		      		if($filtro){
		      					      			//pone el formulario de "quitar filtro
		      			//el metrodo removeFilterForm necesita conocer el filtro
		      			// y ka ruta a la que se envia el formulario
		      			echo $template->removeFilterForm($filtro,'/Tema/list');
		      		//en caso contrario
		      		} else {
		      			//pone el formulario de "nuevo filtro"
		      			echo $template->filterForm(
			      			[
			      				'ID' => 'id',
			      				'Tema' => 'tema',
								'Descripcion' => 'descripcion'
								
			 
			      			],
			      			//lista de campos para el desplegable "ordenado por "
			      			[
			      			'ID' => 'id',
			      			'Tema' => 'tema',
			      			'Descripcion' => 'descripcion'
			    				
			    			],
			    			// valor por defecto para "buscar en"
			    			'Tema',
			    			// valor por defecto para "ordenado por"
			    			'Tema'
						);
		      			
		      		}?>
		       		
		       		<!--  Enlaces creados por el paginador -->
		       		<div class="rigth">
		       			<?=$paginator->stats()?>
		       		</div>
       		
       		
       		<?php if($temas){ ?>
       		
       			<table class="table w100">
       					<tr>
       						<th>Tema</th>
       						<th>Descripción</th>
       						<th class="centrado">Acciones</th>
		<?php foreach($temas as $tema){   ?>
				<tr>
				
				<td><a href='/Tema/show/<?=$tema->id?>'><?= $tema->tema?></a></td>
				<td><?=$tema->descripcion?></td>
				<td class="centrado">
					<a class="button" href='/tema/show/<?=$tema->id?>'>
					<img src="/images/icons/show.png" alt="Ver" style="width:20px;height:20px;"></a>
					<?php  
					if( Login::role('ROLE_LIBRARIAN' )) {// autorización(solo bibliotecarios) ?>
						
						<a class="button" href='/tema/edit/<?=$tema->id?>'><img src="/images/icons/edit.png" alt="Editar" style="width:20px;height:20px;"></a>
							<?php  if(!$tema->hasAny('TemaLibro')){ ?>
									<a class="button-danger" href='/tema/delete/<?=$tema->id?>'><img src="/images/icons/delete.png" alt="Borrar" style="width:20px;height:20px;"></a>
							<?php }?>
					<?php }?>
				</td>
			</tr>
			
			<?php } ?>
			</table>	
			<?php } else { ?>
				<div class="danger p2">
					<p>No hay temas que mostrar</p>
				</div>
				<?php } ?>
			</main>
				<?= $paginator->ellipsisLinks()?>
			<?= $template->footer() ?>
</body>

</html>