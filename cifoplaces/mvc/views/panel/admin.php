<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Panel del administrador- <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Panel del administrador <?= APP_NAME ?>">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Panel del administrador') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Panel del administrador'=>null])?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>
       		<h2>Panel del administrador</h2>
       		<p>Aquí encontrarés los enlaces a las distintas operaciones.</p>
       		<div class="flex-container gap2">
       			<section class="flex1">
       				<h3><b>Operaciones con usuarios</b></h3>
       				<ul>
       					<li><a href='/User'>Usuarios</a></li>
     					<li><a href='/User/create'>Nuevo usuario</a></li>
					</ul>
       			</section>
       			
       		</div>
       		
			</main>
			<?= $template->footer() ?>
</body>

</html>