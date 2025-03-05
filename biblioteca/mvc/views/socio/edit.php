<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Maralioteca - Edición de socio - <?= APP_NAME ?></title>
		
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
		<?= $template->header('Edición de un socio') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Socios'=>'/Socio','Edicion'=>null]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
	<main>
	<h1><?=APP_NAME?></h1>
	<h2>Edición del socio: <b>"<?= $socio->nombre.' '.$socio->apellidos ?>"</b></h2>
	
	<form method="POST" enctype="multipart/form-data" action="/Socio/update">
		<div class="centrado">
		
		<input type="hidden" name="id" value="<?= $socio->id ?>" >
		
		<label for="dni">DNI</label>
		<input type="text" name="dni" maxlength="9" value="<?= old('dni',$socio->dni)?>" required>
		<br>
		<label for="nombre">Nombre</label>
		<input type="text" name="nombre" value="<?= old('nombre', $socio->nombre)?>" required>
			<br>
			<label for="apellidos">Apellidos</label>
			<input type="text" name="apellidos" value="<?= old('apellidos', $socio->apellidos)?>" >
			<br>
			<label for="telefono">Telefono</label>
			<input type="text" name="telefono" value="<?= old('telefono', $socio->telefono)?>" >
			<br>
			<label for="email">Email</label>
			<input type="text" name="email" value="<?= old('email', $socio->email)?>" >
			<br>
			<label for="alta">Alta</label>
			<input type="text" name="alta" value="<?= old('alta', $socio->alta)?>" disabled>
			<br>
			<section>
			<h3>Prestamos del socio</h3>
			<a class="button" href="/Prestamo/create/">Nuevo Prestamo</a>
			<table class="table w100 centered-block">
					<tr>
						<th>ID</th><th>Socio</th><th>Ejemplar</th><th>Titulo</th><th>Limite</th><th>Devolución</th><th>Incidencias</th><th>Operaciones</th>
					</tr>
				<?php 
					$prestamos = $socio->getPrestamos();
					foreach($prestamos as $prestamo ){ ?>
						<tr>
							<td> <?=$prestamo->idprestamo ?></td>
							<td> <?=$prestamo->nombre.' '.$prestamo->apellidos ?></td>
							<td> <?=$prestamo->titulo ?></td>
							<td> <?=$prestamo->idejemplar ?></td>							
							<td> <?=$prestamo->limite ?></td>
							<td> <?=$prestamo->devolucion ?></td>
							<td> <?=$prestamo->incidencia?></td>
							<td class="centrado">	
							<a class="button" href="/Prestamo/incidencia/<?=$prestamo->idprestamo?>">Inicidencia</a>
							<?php
							if ($prestamo->devolucion){ ?>
										
									<a class="button-danger" href="/Prestamo/delete/<?=$prestamo->idprestamo?>">Eliminar</a>
									<?php }?>
									
							</td>
						</tr>
					<?php }?>					
			</table>
		</section>
			<?php if(!$socio->hasAny('Prestamo')){ ?>
					<p>El socio no tiene prestamos vigentes.</p>
			<?php } ?>
			
			<div class="centered mt2">
				<input type="submit" class="button" name="actualizar" value="Actualizar">
				<input type="reset" class="button" value="Reset" onclick="<?php redirect('/Socio/edit/$socio->id');?>">	
			</div>
		</div>
		<div class="centrado m1">
			<a class="button" onclick="history.back()">Atrás</a>
			<a class="button" href="/Socio/list">Lista de socios</a>
			<a class="button" href="/Socio/show/<?=$socio->id?>">Detalles</a>
			<?php if(!$socio->hasAny('Prestamo')){ ?>
					<a class="button-danger" href='/socio/delete/<?=$socio->id?>'>
						Borrado <img src="/images/icons/delete.png" alt="Borrar" style="width:20px;height:20px;"> 
					</a>
			<?php } ?>
					
		</div>		
	</form>
</main>		
	
	
</body>
</html>
