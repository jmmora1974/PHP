<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Portada - <?= APP_NAME ?></title>

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
		<?= $template->header('Lista de libros') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs() ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
	<main>
		<h1><?=APP_NAME?></h1>
		<section>
			<h2>Detalles del libro</h2>
			<h3><?=$libro->titulo?></h3>

			<p>
				<b>ISBN:</b>  	<?= $libro->isbn ?></p>
			<p>
				<b>Titulo:</b>  	<?= $libro->titulo ?></p>
			<p>
				<b>Editorial:</b>  	<?= $libro->editorial ?></p>
			<p>
				<b>Autor:</b>  	<?= $libro->autor ?></p>
			<p>
				<b>Idioma:</b>  	<?= $libro->idioma ?></p>
			<p>
				<b>Edicion:</b>  	<?= $libro->edicion ?></p>
			<p>
				<b>Edad Recomendada:</b> 	<?= $libro->edadrecomendada ?? 'Pdt calificación' ?></p>
			<p>
				<b>Año:</b>  	<?= $libro->anyo ?? ' -- '?></p>
			<p>
				<b>Páginas:</b>  	<?= $libro->paginas ?? ' -- '?></p>
			<p>
				<b>Características:</b>  	<?= $libro->caracterisitcas ?? ' -- '?></p>
		</section>
		<section>
			<h2>Sinopsis</h2>
			<p><?= $libro->sinopsis ? paragraph($libro->sinopsis) : 'SIN DETALLES'?></p>
		</section>

		<div class="centrado">
			<a class="button" onclick="history.back()">Atrás</a> <a
				class="button" href="/Libro/list">Lista de libros</a> <a
				class="button" href="/Libro/edit/<?=$libro->id?>">Editar</a> <a
				class="button danger" href="/Libro/delete/<?=$libro->id?>">Borrar</a>
		</div>
	</main>
</body>

</html>