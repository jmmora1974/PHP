<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Nuevo Libro - <?= APP_NAME ?></title>
		
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
		<?= $template->breadCrumbs(['Libros'=>'/Libro','Nuevo'=>null]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
	<main>
	<h1><?=APP_NAME?></h1>
	<h2>Nuevo libro</h2>
	
	<form method="POST" class="flex-container gap2" enctype="multipart/form-data" action="/Libro/store">
		<div class="flex2">
		<label for="isbn">ISBN</label>
		<input type="text" name="isbn" value="<?= old('isbn')?>" minlength="9" maxlenght="17" required>
		<br>
		<label for="titulo">Título</label>
		<input type="text" name="titulo" value="<?= old('titulo')?>" maxlenght="64" required>
			<br>
			<label for="editorial">Editorial</label>
			<input type="text" name="editorial" value="<?= old('editorial')?>" maxlenght="64" required>
			<br>
			<label for="autor">Autor</label>
			<input type="text" name="autor" value="<?= old('autor')?>" maxlength="256" required>
			<br>
			<label for="idioma">Idioma</label>
			<select name="idioma">
				<option value="Castellano" <?= oldSelected('idioma','Castellano')?>>Castellano</option>
				<option value="Catalán" <?= oldSelected('idioma','Catalán')?>>Catalán</option>
				<option value="Ingles" <?= oldSelected('idioma','Inglés')?>>Inglés</option>
				<option value="Otros" <?= oldSelected('idioma','Otros')?>>Otros</option>
			</select>
			<br>
			<label for="edicion">Edicion</label>
			<input type="number" min="0" name="edicion" maxlength="256"  value="<?=old('edicion')?>">
			<br>
			<label for="anyo">Año</label>
			<input type="number" min="0" name="anyo">
			<br>
			<label for="edadrecomendada">Edad rec.</label>
			<input type="number" min="0" max="120" name="edadrecomendada" required>
			<br>
			<label for="paginas">Páginas</label>
			<input type="number" min="0" name="paginas" value="<?=old('paginas')?>">
			<br>
			<label for="caracteristicas">Caracterís.</label>
			<input type="text" name="caracteristicas" value="<?=old('caracteristicas')?>">
			<br>
			<label for="portada">Portada</label>
			<input type="file" name="portada" accept="image/*" id="file-with-preview" maxlength="512" >
			<br>
			
			<label>Tema</label>
			<select name="idtema">
				<?php 
					foreach($listaTemas as $nuevoTema)
						echo "<option value='$nuevoTema->id'>$nuevoTema->tema </option>";
				?>
			</select>
			<p>Puedes añadir más temas posteriormente, desde la operación de edición del libro.</p>
			<label for="sinopsis">Sinopsis</label>
			<textarea name="sinopsis" class="w50"><?=old('sinopsis')?></textarea>
			<br>
			<div class="centered mt2">
				<input type="submit" class="button" name="guardar" value="Guardar">
				<input type="reset" class="button" value="Reset">	
			</div>
		</div>
		<figure class="flex1 centrado">
			<img src="<?=BOOK_IMAGE_FOLDER.'/'.($libro->portada ?? DEFAULT_BOOK_IMAGE)?>"
				 	class="cover enlarge-image" alt="Previsualización de la portada del libro <?= $libro->titulo?>">				 		
				 <figcaption>Previsualización de la portada del libro <?= "$libro->titulo, de $libro->autor"?> </figcaption>
		</figure>
			
	</form>
	<div class="centrado my2">
			<a class="button" onclick="history.back()">Atrás</a>
			<a class="button" href="/Libro/list">Lista de libros</a>
		</div>	
</main>		
	
	
</body>
</html>
