<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Listado libros - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Lista de libros - <?= APP_NAME ?>">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Lista de libros') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Libros'=>null])?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>
       		<h2>Lista completa de libros</h2>
       		
      		<?php if($libros){ ?>
      		
      		<!--  FILTR DE BÚSQUEDA -->
      		<?php 
      		//si hay filtro guardado en sesión
      		if($filtro){
      			
      			//pone el formulario de "quitar filtro
      			//el metrodo removeFilterForm necesita conocer el filtro
      			// y ka ruta a la que se envia el formulario
      			echo $template->removeFilterForm($filtro,'/Libro/list');
      		//en caso contrario
      		} else {
      			//pone el formulario de "nuevo filtro"
      			echo $template->filterForm(
      			[
      				'Titulo' => 'titulo',
					'Editorial' => 'editorial',
					'Autor' => 'autor',
					'ISBN' => 'isbn'
 
      			],
      			//lista de campos para el desplegable "ordenado por "
      			[
      			'Titulo' => 'titulo',
      			'Editorial' => 'editorial',
      			'Autor' => 'autor',
      			'ISBN' => 'isbn'
    				
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
       			<table class="table w100">
       					<tr>
       						<th>Portada</th>
       						<th>ISBN</th>
       						<th>Título</th>
       						<th>Autor</th>
       						<th>Editorial</th>
       						<th>Año</th>
       						<th>Ejemplares</th>
       						<th class="centrado">Operaciones</th>
		<?php foreach($libros as $libro){   ?>
			<tr>
				<td class="centrado">
					<a href='/Libro/show/<?= $libro->id ?>'>
						<img src="<?=BOOK_IMAGE_FOLDER.'/'.($libro->portada ?? DEFAULT_BOOK_IMAGE)?>"
							class="table-image" alt="Portada de <?= $libro->titulo ?>"
							title="Portada de <?=$libro->titulo?>">
					</a></td>
				<td><?=$libro->isbn?></td>
				<td><a href='/Libro/show/<?=$libro->id?>' ><?= $libro->titulo?></a></td>
				<td><?=$libro->autor?></td>
				<td><?=$libro->editorial?></td>
				<td><?=$libro->anyo?></td>
				<td><?=$libro->ejemplares?></td>
				<td class="centrado">
					<a class="button" href='/libro/show/<?=$libro->id?>'>
						<img src="/images/icons/show.png" alt="Ver" style="width:20px;height:20px;"></a>
					<a class="button" href='/libro/edit/<?=$libro->id?>'><img src="/images/icons/edit.png" alt="Editar" style="width:20px;height:20px;"></a>
					<?php if(!$libro->ejemplares){ ?>
						<a class="button-danger" href='/libro/delete/<?=$libro->id?>'><img src="/images/icons/delete.png" alt="Borrar" style="width:20px;height:20px;"></a>
					<?php } ?>
					
				</td>
			</tr>
			
			<?php } ?>
			</table>	
			<?php } else { ?>
				<div class="danger p2">
					<p>No hay libros que mostrar</p>
				</div>
				<?php } ?>
			</main>
			<?= $paginator->ellipsisLinks()?>
			<?= $template->footer() ?>
</body>

</html>