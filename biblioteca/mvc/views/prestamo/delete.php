<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Moralioteca - Confirmación de borrado de prestamo - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Borrado de prestamo de libros - <?= APP_NAME ?>">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Confirmación borrado de un prestamo de libro') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Prestamos'=>'/Prestamo','Confirmar borrado'=>null]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
	<main>
	<h1><?=APP_NAME?></h1>
	<h2>Borrar prestamo</h2>
	
	<form method="POST" enctype="multipart/form-data" class="p2 m2 centered" action="/Prestamo/destroy">
		<p>Confirmar el borrado del prestamo:<b>"<?= $prestamo->id ?>"</b></p>
		
		<input type="hidden" name="id" value="<?= $prestamo->id ?>">
		 <?=  !$prestamo->devolucion ?			
			'El ejemplares del libro aún no está devuelto. No se puede eliminar.':
		 '<input type="submit" class="button-danger" name="borrar" value="Borrar">';
		 ?>
		
	</form>
	
		<div class="centered">
			<a class="button" onclick="history.back()">Atrás</a>
			<a class="button" href="/Prestamo">Lista de prestamos</a>
			
		</div>		
	
</main>		
	
	
</body>
</html>
