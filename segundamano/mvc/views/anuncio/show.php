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
		<section id="detalles" class="flex-container gap2">
			<div class="flex2 centered">
				<h2>Detalles del socio</h2>
				
				<h3><?=$socio->nombre?></h3>

				<p>
					<b>DNI:</b>  	<?= $socio->dni ?></p>
				<p>
					<b>Nombre:</b>  	<?= $socio->nombre ?></p>
				<p>
					<b>Apellidos:</b>  	<?= $socio->apellidos ?></p>
				<p>
					<b>Población:</b>  	<?= $socio->poblacion ?></p>
				<p>
					<b>Codigo Postal:</b>  	<?= $socio->cp ?></p>
				<p>
					<b>Telefono:</b>  	<?= $socio->telefono ?></p>
				<p>
					<b>Email:</b>  	<?= $socio->email ?></p>
				<p >
					<b>Alta:</b> 	<?= $socio->alta ?></p>
			
				
			</DIV>
			<script src="/js/BigPicture.js"></script>
			
			<figure class="flex1 centrado p2">
				<img src="<?=PROFILE_IMAGE_FOLDER.'/'.($socio->foto ?? DEFAULT_PROFILE_IMAGE)?>"
				 	class="cover enlarge-image" alt="Foto de perfil de <?= $socio->nombre.' ',$socio->apellidos?>">				 		
				 <figcaption>Foto de perfil de <?= $socio->nombre.' ',$socio->apellidos?> </figcaption>
			</figure>
		</section>
		<section>
			<h3>Prestamos del socio <b>"<?= $socio->nombre.' '.$socio->apellidos ?>"</b></h3>
		
		<?php  // autorización(solo bibliotecarios 
			if( Login::role('ROLE_LIBRARIAN')) { ?>
				<a class="button" href="/Prestamo/create/<?=$socio->id?>">Nuevo Prestamo</a>
		<?php }?>
			
			<table class="table w100 centered-block">
			
					<tr>
						<th>ID</th><th>Socio</th><th>Titulo</th><th>Ejemplar</th><th>Limite</th><th>Devolución</th><th>Incidencias</th><th>Operaciones</th>
					</tr>
				<?php 
					
				
				
				foreach($prestamos as $prestamo ){ ?>
						<tr>
							<td> <?=$prestamo->id ?></td>
							<td> <?=$prestamo->nombre.' '.$prestamo->apellidos ?></td>
							<td> <?=$prestamo->titulo ?></td>
							<td> <?=$prestamo->idejemplar ?></td>							
							<td> <?=$prestamo->limite ?></td>
							<td> <?=$prestamo->devolucion ?></td>
							<td> <?=$prestamo->incidencia?></td>
							<td class="centrado">
							
							<?php  // autorización(solo bibliotecarios) 
							  if( Login::role('ROLE_LIBRARIAN')|| Login::user()->email == $socio->email) { ?>
								
									<a class="button" href="/Prestamo/incidencia/<?=$prestamo->id?>">Inicidencia</a>
									<?php
									if ($prestamo->devolucion){ ?>
												
											<a class="button-danger" href="/Prestamo/delete/<?=$prestamo->id?>">Eliminar</a>
											<?php } else {?>
										<a class="button-success" href="/Prestamo/devolucion/<?=$prestamo->id?>">Devolución</a>
									<?php }
							  }?>	
									
							</td>
						</tr>
						<?php } ?>
						
						
					<?php 	
						if(!$prestamos) { 
							echo "<p><b> El socio tiene prestamos vigentes </b></p>";
					}?>	
									
				
				
			</table>
		</section>
		
		<div class="centrado">
			<a class="button" onclick="history.back()">Atrás</a> 
		<?php  // autorización(solo bibliotecarios 
		if( Login::role('ROLE_LIBRARIAN')) { ?>
			<a class="button" href="/Socio/list">Lista de socios</a> 
			<a class="button" href="/Socio/edit/<?=$socio->id?>">Editar</a>
			<?php if(!$prestamos){ ?> 
				<a class="button-danger" href="/Socio/delete/<?=$socio->id?>">Borrar</a>
			<?php } 
		}?>
		</div>
	</main>
</body>

</html>