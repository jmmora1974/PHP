<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Maralioteca - Confirmación de borrado de libro - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Lista de libros - <?= APP_NAME ?>">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Confirmación borrado de un libro') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Libros'=>'/Libro','Confirmar borrado'=>null]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
	<main>
	<h1><?=APP_NAME?></h1>
	<h2>Borrar libro</h2>
	
	<form method="POST" enctype="multipart/form-data" class="p2 m2 centered" action="/Libro/destroy">
		<p>Confirmar el borrado del libro:<b>"<?= $libro->titulo ?>"</b></p>
		
		<input type="hidden" name="id" value="<?= $libro->id ?>">
		 <?=  $libro->hasAny('Ejemplar') ?			
			'El libro dispone de ejemplares. No se puede eliminar.':
		 '<input type="submit" class="button-danger" name="borrar" value="Borrar">';
		 ?>
		
	</form>
	
		<div class="centered">
			<a class="button" onclick="history.back()">Atrás</a>
			<a class="button" href="/Libro/list">Lista de libros</a>
			<a class="button" href="/Libro/show/<?=$libro->id?>">Detalles</a>
			<a class="button" href="/Libro/edit/<?=$libro->id?>">Edición</a>
		</div>		
	
</main>		
	
	
</body>
</html>
