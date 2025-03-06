<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Visualización de un prestamo - <?= APP_NAME ?></title>

<!-- META -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Ver prestamos - <?= APP_NAME ?>">
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
		<?= $template->breadCrumbs(['Prestamos'=>'/Prestamo','Detalles'=>null]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
	<main>
		<h1><?=APP_NAME?></h1>
		<section>
			<DIV class="flex2 centered">
				<h2>Detalles del prestamo</h2>
				<h3><?=$prestamo->titulo?></h3>

				<p>
					<b>DNI:</b>  	<?= $prestamo->dni ?></p>
				<p>
					<b>Nombre:</b>  	<?= $prestamo->nombre ?></p>
				<p>
					<b>Apellidos:</b>  	<?= $prestamo->apellidos ?></p>
				<p>
					<b>Población:</b>  	<?= $prestamo->poblacion ?></p>
				<p>
					<b>Telefono:</b>  	<?= $prestamo->telefono ?></p>
				<p>
					<b>Email:</b>  	<?= $prestamo->email ?></p>
				<p >
					<b>Alta:</b> 	<?= $prestamo->alta ?></p>
			
				
			</DIV>
		</section>
		<section>
			<h3>Prestamos del prestamo</h3>
			<a class="button" href="/Prestamo/create/<?=$socio->id?>">Nuevo Prestamo</a>
			<table class="table w100 centered-block">
					<tr>
						<th>ID</th><th>Prestamo</th><th>Titulo</th><th>Ejemplar</th><th>Limite</th><th>Devolución</th><th>Incidencias</th><th>Operaciones</th>
					</tr>
				<?php 
				$prestamos = $prestamo->getPrestamos();
				if(!$prestamos){ ?>
							<p><b> El prestamo tiene prestamos vigentes </b></p>
						
				<?php } else {
					
					foreach($prestamos as $prestamo ){ ?>
						<tr>
							<td> <?=$prestamo->id ?></td>
							<td> <?=$prestamo->nombre.' '.$prestamo->apellidos ?></td>
							<td> <?=$prestamo->titulo ?></td>
							<td> <?=$prestamo->idejemplar ?></td>							
							<td> <?=$prestamo->limite ?></td>
							<td> <?=$prestamo->devolucion ?? '<b>PENDIENTE<b>' ?></td>
							<td> <?=$prestamo->incidencia ?? 'SIN INCIDENCIAS' ?></td>
							<td class="centrado">	
							<a class="button" href="/Prestamo/incidencia/<?=$prestamo->id?>">Inicidencia</a>
							<?php
							if ($prestamo->devolucion){ ?>
										
									<a class="button-danger" href="/Prestamo/delete/<?=$prestamo->id?>">Eliminar</a>
									<?php }?>
									
							</td>
						</tr>
						<?php }
				}?>	
									
				
				
			</table>
		</section>
		
		<div class="centrado">
			<a class="button" onclick="history.back()">Atrás</a> 
			<a class="button" href="/Prestamo/list">Lista de prestamos</a> 
			<a class="button" href="/Prestamo/edit/<?=$prestamo->id?>">Editar</a>
			<?php if(!$prestamo->hasAny('Prestamo')){ ?> 
				<a class="button-danger" href="/Prestamo/delete/<?=$prestamo->id?>">Borrar</a>
			<?php } ?>
		</div>
	</main>
</body>

</html>