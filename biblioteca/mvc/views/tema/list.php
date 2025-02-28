<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Listado de socios - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Lista de socios - <?= APP_NAME ?>">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Lista de socios') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Socios'=>null])?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>
       		<h2>Lista completa de socios</h2>
       		
       		<?php if($socios){ ?>
       			<table class="table w100">
       					<tr>
       						<th>DNI</th>
       						<th>Nombre</th>
       						<th>Apellidos</th>
       						<th>Población</th>
       						<th>Telefono</th>
       						<th>Email</th>
       						<th>Alta</th>
       						<th class="centrado">Acciones</th>
		<?php foreach($socios as $socio){   ?>
				<tr>
					<td><?=$socio->dni?></td>
				<td><a href='/Socio/show/<?=$socio->id?>'><?= $socio->nombre?></a></td>
				<td><?=$socio->apellidos?></td>
				<td><?=$socio->poblacion?></td>
				<td><?=$socio->telefono?></td>
				<td><?=$socio->email?></td>
				<td><?=$socio->alta?></td>
				<td class="centrado">
					<a class="button" href='/socio/show/<?=$socio->id?>'>
						<img src="/images/icons/show.png" alt="Ver" style="width:20px;height:20px;"></a>
					<a class="button" href='/socio/edit/<?=$socio->id?>'><img src="/images/icons/edit.png" alt="Editar" style="width:20px;height:20px;"></a>
					<?php if(!$socio->hasAny('Prestamo')){ ?>
						<a class="button-danger" href='/socio/delete/<?=$socio->id?>'><img src="/images/icons/delete.png" alt="Borrar" style="width:20px;height:20px;"></a>
					<?php } ?>
					
				</td>
			</tr>
			
			<?php } ?>
			</table>	
			<?php } else { ?>
				<div class="danger p2">
					<p>No hay socios que mostrar</p>
				</div>
				<?php } ?>
			</main>
			<?= $template->footer() ?>
</body>

</html>