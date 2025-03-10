<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Maralioteca - Edición de tema - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Edicion de tema - <?= APP_NAME ?>">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Edición de un tema') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Temas'=>'/Tema','Edicion'=>null]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
	<main>
	<h1><?=APP_NAME?></h1>
	<h2>Edición del tema: <b>"<?= $tema->tema ?>"</b></h2>
	
	<form method="POST" enctype="multipart/form-data" action="/Tema/update">
		<div class="centrado">
		
		<input type="hidden" name="id" value="<?= $tema->id ?>" >
		
		<label for="tema">Tema</label>
		<input type="text" name="tema" value="<?= old('tema',$tema->tema)?>" required>
		<br>
		<label for="descripcion">Descripción</label>
		<input type="text" name="descripcion" value="<?= old('descripcion', $tema->descripcion)?>" >
		
		<!--   Si existen libros del tema, muestra el mensaje-->
		<?= $tema->hasAny('TemaLibro') ?
				'<p>Existen libros de este tema</p>': ' ';
		?>
			
			<div class="centered mt2">
			<?php  if( Login::role('ROLE_LIBRARIAN' )) {// autorización(solo bibliotecarios) ?>
				<input type="submit" class="button" name="actualizar" value="Actualizar">
			<?php }?>
				<input type="reset" class="button" value="Reset" onclick="<?php redirect('/Tema/edit/$tema->id');?>">	
			</div>
		</div>
		<div class="centrado m1">
			<a class="button" onclick="history.back()">Atrás</a>
			<a class="button" href="/Tema/list">Lista de temas</a>
			<a class="button" href="/Tema/show/<?=$tema->id?>">Detalles</a>
			<?php  if( Login::role('ROLE_LIBRARIAN' )) {// autorización(solo bibliotecarios) ?>
					<?= !$tema->hasAny('TemaLibro') ?
					"<a class='button-danger' href='/tema/delete/<?=$tema->id?>'>Borrado <img src='/images/icons/delete.png' alt='Borrar' style='width:20px;height:20px;'>
					</a>" : '';		
					
					}?>
			
		
					
		</div>		
	</form>
</main>		
	
	
</body>
</html>
