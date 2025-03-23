<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Panel del Moderador- <?= APP_NAME ?></title>

<!-- META -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description"
	content="Panel del moderador- <?= APP_NAME ?>">
<meta name="author" content="Jose Miguel Mora Perez">

<!-- FAVICON -->
<link rel="shortcut icon" href="/favicon.ico" type="image/png">

<!-- CSS -->
		<?= $template->css() ?>
	</head>
<body>
		<?= $template->login() ?>
		<?= $template->header('Panel del moderador') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Panel del moderador'=>null])?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
		
		<main>
		<h1><?= APP_NAME ?></h1>
		<h2>Panel del moderador</h2>
		<p>Aquí encontrarés los enlaces a las distintas operaciones.</p>
		<div class="flex-container gap2">
			<section class="flex1">
				<h3>
					<b>Operaciones con Lugares</b>
				</h3>
				<ul>
					<li><a href='/Lugar'>Lugares</a></li>
					<li><a href='/Lugar/create'>Nuevo Lugar</a></li>
				</ul>
			</section>
			<section class="flex1">
				<h3>
					<b>Operaciones con comentarios</b>
				</h3>
				<ul>
					<li><a href='/Comentario'>Listado Comentarios</a></li>
					

				</ul>
			</section>

		</div>
		
		
	</main>
			<?= $template->footer() ?>
</body>

</html>