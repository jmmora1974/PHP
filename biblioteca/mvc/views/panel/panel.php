<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Panel del bibliotecario- <?= APP_NAME ?></title>

<!-- META -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description"
	content="Panel del bibliotecario- <?= APP_NAME ?>">
<meta name="author" content="Jose Miguel Mora Perez">

<!-- FAVICON -->
<link rel="shortcut icon" href="/favicon.ico" type="image/png">

<!-- CSS -->
		<?= $template->css() ?>
	</head>
<body>
		<?= $template->login() ?>
		<?= $template->header('Panel del bibliotecario') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Panel del bibliotecario'=>null])?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
		
		<main>
		<h1><?= APP_NAME ?></h1>
		<h2>Panel del bibliotecario</h2>
		<p>Aquí encontrarés los enlaces a las distintas operaciones.</p>
		<div class="flex-container gap2">
			<section class="flex1">
				<h3>
					<b>Operaciones con libros</b>
				</h3>
				<ul>
					<li><a href='/Libro'>Libros</a></li>
					<li><a href='/Libro/create'>Nuevo libro</a></li>
				</ul>
			</section>
			<section class="flex1">
				<h3>
					<b>Operaciones con Ejemplares</b>
				</h3>
				<ul>
					<li><a href='/Ejemplar'>Ejemplares</a></li>
					<li><a href='/Ejemplar/create'>Nuevo Ejemplar</a></li>

				</ul>
			</section>
			<section class="flex1">
				<h3>
					<b>Operaciones con temas</b>
				</h3>
				<ul>
					<li><a href='/Tema'>Temas</a></li>
					<li><a href='/Tema/create'>Nuevo Tema</a></li>

				</ul>
			</section>

		</div>
		<div class="flex-container gap2">
			<section class="flex1">
				<h3>
					<b>Operaciones con socios</b>
				</h3>
				<ul>
					<li><a href='/Socio'>Socios</a></li>
					<li><a href='/Socio/create'>Nuevo Socio</a></li>
				</ul>
			</section>
			<section class="flex1">
				<h3>
					<b>Operaciones con Prestamos</b>
				</h3>
				<ul>
					<li><a href='/Prestamo'>Prestamos</a></li>
					<li><a href='/Prestamo/create'>Nuevo Prestamo</a></li>

				</ul>
			</section>

		</div>
		
	</main>
			<?= $template->footer() ?>
</body>

</html>