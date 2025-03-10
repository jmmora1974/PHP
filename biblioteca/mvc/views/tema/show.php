<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Visualización de un tema - <?= APP_NAME ?></title>

<!-- META -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Ver temas - <?= APP_NAME ?>">
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
		<?= $template->breadCrumbs(['Temas'=>'/Tema','Detalles'=>null]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
	<main>
		<h1><?=APP_NAME?></h1>
		<section>
			<DIV class="flex2 centered">
				<h2>Detalles del tema</h2>
				<h3><?=$tema->tema?></h3>

				<p>
					<b>Tema:</b>  	<?= $tema->tema ?></p>
				<p>
					<b>Descripción:</b>  	<?= $tema->descripcion ?></p>
				
				
			</DIV>
		</section>
		
		<div class="centrado">
			<a class="button" onclick="history.back()">Atrás</a> 
			<a class="button" href="/Tema/list">Lista de temas</a> 
			<?php  
				if( Login::role('ROLE_LIBRARIAN' )) {// autorización(solo bibliotecarios) ?>
					<a class="button" href="/Tema/edit/<?=$tema->id?>">Editar</a>
					<?php 
					if(!$tema->hasAny('TemaLibro')){ ?>
						<a class="button-danger" href="/Tema/delete/<?=$tema->id?>">Borrar</a>
				<?php } 
				} ?>
		</div>
		<section>
			<h2>Libros del tema <b>"<?= $tema->tema?>"</b></h2>
			<?php 
			if(!$libros){
				echo "<div class='warning p2'><p>No hay libros de este tema.</p></div>";
			} else { ?>
				<table class="table w100">
					<tr>
						<th>ID</th>
						<th>Titulo</th>
						<th>Editorial</th>
						<th>Autor</th>
						<th>Año</th>
					
					</tr>
				<?php foreach($libros as $libro){?>
					<tr>
						<td><?= $libro->id ?></td>
						<td><a href='/Tema/show/<?=$libro->id ?>'>
							<?= $libro->titulo?></a>
						</td>
						<td><?= $libro->editorial ?></td>
						<td><?= $libro->autor ?></td>
						<td><?= $libro->anyo ?></td>
					</tr>
					<?php } ?>
				</table>
			<?php } ?>
			
		</section>
	</main>
</body>

</html>