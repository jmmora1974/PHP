<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Visualización de un socio - <?= APP_NAME ?></title>

<!-- META -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Ver socios - <?= APP_NAME ?>">
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
		<?= $template->breadCrumbs(['Socios'=>'/Socio','Detalles'=>null]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
	<main>
		<h1><?=APP_NAME?></h1>
		<section>
			<DIV class="flex2 centered">
				<h2>Detalles del socio</h2>
				<h3><?=$socio->titulo?></h3>

				<p>
					<b>DNI:</b>  	<?= $socio->dni ?></p>
				<p>
					<b>Nombre:</b>  	<?= $socio->nombre ?></p>
				<p>
					<b>Apellidos:</b>  	<?= $socio->apellidos ?></p>
				<p>
					<b>Población:</b>  	<?= $socio->poblacion ?></p>
				<p>
					<b>Telefono:</b>  	<?= $socio->telefono ?></p>
				<p>
					<b>Email:</b>  	<?= $socio->email ?></p>
				<p >
					<b>Alta:</b> 	<?= $socio->alta ?></p>
			
				
			</DIV>
		</section>
		<section>
			<h3>Prestamos del socio</h3>
			<table class="table w100 centered-block">
					<tr>
						<th>ID</th><th>Socio</th><th>Ejemplar</th><th>Titulo</th><th>Limite</th><th>Devolución</th><th>Operaciones</th>
					</tr>
				<?php 
					$prestamos = $socio->getPrestamos();
					foreach($prestamos as $prestamo ){ ?>
						<tr>
							<td> <?=$prestamo->id ?></td>
							<td> <?=$socio->nombre.' '.$socio->apellidos ?></td>
							<td> <?=$prestamo->idejemplar ?></td>
							<td> <?=$prestamo->titulo ?></td>
							<td> <?=$prestamo->limite ?></td>
							<td> <?=$prestamo->devolucion ?></td>
							<td class="centrado">	<?php
									if(!$prestamos){ ?>
										<a class="button-danger" href="/Ejemplar/delete/<?=$prestamo->idejemplar?>">Borrar</a>
									<?php }?>
						</td>
						</tr>
						<?php }?>	
													
				<?php
				if(!$prestamos){ ?>
							<p><b> El socio tiene prestamos vigentes </b></p>
						
			<?php }?>
			</table>
		</section>
		
		<div class="centrado">
			<a class="button" onclick="history.back()">Atrás</a> 
			<a class="button" href="/Socio/list">Lista de socios</a> 
			<a class="button" href="/Socio/edit/<?=$socio->id?>">Editar</a>
			<?php if(!$socio->hasAny('Prestamo')){ ?> 
				<a class="button-danger" href="/Socio/delete/<?=$socio->id?>">Borrar</a>
			<?php } ?>
		</div>
	</main>
</body>

</html>