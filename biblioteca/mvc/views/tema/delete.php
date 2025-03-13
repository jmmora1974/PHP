<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Maralioteca - Confirmación de borrado de tema - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="borrado de Tema - <?= APP_NAME ?>">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Confirmación borrado de un tema') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['temas'=>'/Tema','Confirmar borrado'=>null]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
	<main>
	<h1><?=APP_NAME?></h1>
	<h2>Borrar tema</h2>
	
	<form method="POST" enctype="multipart/form-data" class="p2 m2 centered" action="/Tema/destroy">
		<p>Confirmar el borrado del tema:<b>"<?= $tema->tema ?>"</b></p>
		
		<input type="hidden" name="id" value="<?= $tema->id ?>">
		<?= $tema->hasAny('TemaLibro') ?
		'<p>Existen libros de este tema</p>':
		'<input type="submit" class="button-danger" name="borrar" value="Borrar">';		
		?>
		
	</form>
	
		<div class="centered">
			<a class="button" onclick="history.back()">Atrás</a>
			<a class="button" href="/Tema/list">Lista de temas</a>
			<a class="button" href="/Tema/show/<?=$tema->id?>">Detalles</a>
			<?php if($tema->hasAny('TemaLibro')){ ?>
				<?php  if( Login::role('ROLE_LIBRARIAN' )) {// autorización(solo bibliotecarios) ?> 
					<a class="button" href="/Tema/edit/<?=$tema->id?>">Edición</a>
				<?php } ?>
			<?php }?>
		</div>		
	
</main>		
	
	
</body>
</html>
