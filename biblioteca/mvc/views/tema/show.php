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
			<a class="button" href="/Tema/edit/<?=$tema->id?>">Editar</a>
			<?php if(!$tema->hasAny('TemaLibro')){ ?> 
				<a class="button-danger" href="/Tema/delete/<?=$tema->id?>">Borrar</a>
			<?php } ?>
		</div>
	</main>
</body>

</html>