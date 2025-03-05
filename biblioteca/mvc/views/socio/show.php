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
			<a class="button" href="/Prestamo/create/">Nuevo Prestamo</a>
			<table class="table w100 centered-block">
			<?php 
				$prestamos = $socio->getPrestamos();
				if(!sizeof($prestamos)>0){ ?>
							<p><b> El socio tiene prestamos vigentes </b></p>
						
				<?php } else { ?>
					<tr>
						<th>ID</th><th>Socio</th><th>Titulo</th><th>Ejemplar</th><th>Limite</th><th>Devolución</th><th>Incidencias</th><th>Operaciones</th>
					</tr>
				<?php 
					
					foreach($prestamos as $prestamo ){ ?>
						<tr>
							<td> <?=$prestamo->idprestamo ?></td>
							<td> <?=$prestamo->nombre.' '.$prestamo->apellidos ?></td>
							<td> <?=$prestamo->titulo ?></td>
							<td> <?=$prestamo->idejemplar ?></td>							
							<td> <?=$prestamo->limite ?></td>
							<td> <?=$prestamo->devolucion ?? '<b>PENDIENTE<b>' ?></td>
							<td> <?=$prestamo->incidencia ?? 'SIN INCIDENCIAS' ?></td>
							<td class="centrado">	
							<a class="button" href="/Prestamo/incidencia/<?=$prestamo->idprestamo?>">Inicidencia</a>
							<?php
							if ($prestamo->devolucion){ ?>
										<a class="button-danger" href="/Prestamo/delete/<?=$prestamo->idprestamo?>">Eliminar</a>
							<?php } else {?>
								<a class="button-success" href="/Prestamo/devolucion/<?=$prestamo->idprestamo?>">Devolución</a>
							<?php }?>		
							</td>
						</tr>
						<?php }
				}?>	
									
				
				
			</table>
		</section>
		
		<div class="centrado">
			<a class="button" onclick="history.back()">Atrás</a> 
			<a class="button" href="/Socio/list">Lista de socios</a> 
			<a class="button" href="/Socio/edit/<?=$socio->id?>">Editar</a>
			<?php if(!$prestamos){ ?> 
				<a class="button-danger" href="/Socio/delete/<?=$socio->id?>">Borrar</a>
			<?php } ?>
		</div>
	</main>
</body>

</html>