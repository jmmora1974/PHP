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
       		<a class="button" href="/Prestamo/create/">Nuevo Prestamo</a>
       		
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
						<a href="/Prestamo/ampliar/<?php $prestamo->id?>">Ampliar</a> -
						<a href="/Prestamo/devolver/<?php $prestamo->id?>">Devolver</a> -
						<a href="/Prestamo/incidencia/<?php $prestamo->id?>">Incidencia</a>  
							
				</td>
			</tr>
			
			<?php } ?>
			</table>	
			<?php } else { ?>
				<div class="danger p2">
					<p>No hay prestamos que mostrar</p>
				</div>
				<?php } ?>
			</main>
			<?= $template->footer() ?>
</body>

</html>