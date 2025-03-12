<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Listado de prestamos - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Lista de prestamos - <?= APP_NAME ?>">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Lista de prestamos') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Prestamos'=>null])?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>
       		<h2>Lista completa de prestamos</h2>
       		<a class="button" href="/Prestamo/create/0">Nuevo Prestamo</a>
       		
       		
      		
		      		<!--  FILTR DE BÚSQUEDA -->
		      		<?php 
		      		//si hay filtro guardado en sesión
		      		if($filtro){
		      					      			//pone el formulario de "quitar filtro
		      			//el metrodo removeFilterForm necesita conocer el filtro
		      			// y ka ruta a la que se envia el formulario
		      			echo $template->removeFilterForm($filtro,'/Prestamo/list');
		      		//en caso contrario
		      		} else {
		      			//pone el formulario de "nuevo filtro"
		      			echo $template->filterForm(
			      			[
			      				'ID' => 'id',
			      				'Prestamo' => 'prestamo',
			      				'Titulo' => 'titulo',
			      				'Limite' => 'limite',
			      				'Devolucion' => 'devolucion'								
			 
			      			],
			      			//lista de campos para el desplegable "ordenado por "
			      			[
			      			'Prestamo' => 'prestamo',
			      			'Titulo' => 'titulo',
			      			'Limite' => 'limite',
			      			'Devolucion' => 'devolucion'
			    				
			    			],
			    			// valor por defecto para "buscar en"
			    			'Prestamo',
			    			// valor por defecto para "ordenado por"
			    			'Prestamo'
						);
		      			
		      		}?>
		       		
		       		<!--  Enlaces creados por el paginador -->
		       		<div class="rigth">
		       			<?=$paginator->stats()?>
		       		</div>
       		<?php if($prestamos){ ?>
       			
       		<table class="table w100">
       					<tr>
       						<th>ID</th>
       						<th>Socio</th>
       						<th>Ejemplar</th>
       						<th>Titulo</th>
       						<th>Prestamo</th>
       						<th>Limite</th>
       						<th>Devolución</th>
       						<th>Incidencias</th>
       						<th class="centrado">Acciones</th>
		<?php foreach($prestamos as $prestamo){   ?>
				<tr>
					<td><?=$prestamo->id?></td>
					<td><?=$prestamo->nombre.' '.$prestamo->apellidos ?></td>
					<td><?=$prestamo->idejemplar?></td>
					<td><?=$prestamo->titulo?></td>
					<td><?=$prestamo->prestamo?></td>
					<td><?=$prestamo->limite?></td>
					<td><?=$prestamo->devolucion?></td>
					<td><?=$prestamo->incidencia?></td>
					<td class="centrado">
						<a href="/Prestamo/incidencia/<?=$prestamo->id?>">Incidencia</a> - 
						<?php if (!$prestamo->devolucion){?>
							<a href="/Prestamo/ampliar/<?=$prestamo->id?>">Ampliar</a> -
							<a href="/Prestamo/devolucion/<?= $prestamo->id?>">Devolucion</a> 
						<?php }else {?>
							<a href="/Prestamo/delete/<?=$prestamo->id?>">Eliminar</a>  
						<?php }?>
							
				</td>
			</tr>
			
			<?php } ?>
			</table>	
			<?php } else { ?>
				<div class="danger p2">
					<p>No hay prestamos que mostrar</p>
				</div>
				<?php } ?>
				<?= $paginator->ellipsisLinks()?>
			</main>
			
			<?= $template->footer() ?>
</body>

</html>