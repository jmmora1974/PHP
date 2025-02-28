<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Maralioteca - Confirmación de borrado de socio - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="borrado de Socio - <?= APP_NAME ?>">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Confirmación borrado de un socio') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['socios'=>'/Socio','Confirmar borrado'=>null]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
	<main>
	<h1><?=APP_NAME?></h1>
	<h2>Borrar socio</h2>
	
	<form method="POST" enctype="multipart/form-data" class="p2 m2 centered" action="/Socio/destroy">
		<p>Confirmar el borrado del socio:<b>"<?= $socio->nombre.' '.$socio->apellidos ?>"</b></p>
		
		<input type="hidden" name="id" value="<?= $socio->id ?>">
		 <?=  $socio->hasAny('Prestamo') ?			
			'El socio dispone de prestamos. No se puede eliminar.':
		 '<input type="submit" class="button-danger" name="borrar" value="Borrar">';
		 ?>
		
	</form>
	
		<div class="centered">
			<a class="button" onclick="history.back()">Atrás</a>
			<a class="button" href="/Socio/list">Lista de socios</a>
			<a class="button" href="/Socio/show/<?=$socio->id?>">Detalles</a>
			<a class="button" href="/Socio/edit/<?=$socio->id?>">Edición</a>
		</div>		
	
</main>		
	
	
</body>
</html>
