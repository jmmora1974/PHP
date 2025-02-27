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
	<h2>Nuevo libro</h2>
	
	<form method="POST" action="index.php?url=libro/store">
		<div class="flex2">
		<label for="isbn">ISBN</label>
		<input type="text" name="isbn" value="<?= old('isbn')?>" required>
		<br>
		<label for="titulo">Título</label>
		<input type="text" name="titulo" value="<?= old('titulo')?>" required>
			<br>
			<label for="editorial">Editorial</label>
			<input type="text" name="editorial" value="<?= old('editorial')?>" required>
			<br>
			<label for="autor">Autor</label>
			<input type="text" name="autor" value="<?= old('autor')?>" required>
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
			<input type="number" min="0" name="edicion" value="<?=old('edicion')?>">
			<br>
			<label for="anyo">Año</label>
			<input type="number" min="0" name="anyo" value="<?=old('anyo')?>">
			<br>
			<label for="edadrecomendada">Edad rec.</label>
			<input type="number" min="0" max="99" name="edadrecomendada" value="<?=old('edadrecomendada')?>">
			<br>
			<label for="paginas">Páginas</label>
			<input type="number" min="0" name="paginas" value="<?=old('paginas')?>">
			<br>
			<label for="caracteristicas">Caracterís.</label>
			<input type="number" min="0" name="caracteristicas" value="<?=old('caracteristicas')?>">
			<br>
			<label for="sinopsis">Sinopsis</label>
			<textarea name="sinopsis" class="w50"><?=old('sinopsis')?></textarea>
			<br>
			<div class="centered mt2">
				<input type="submit" class="button" name="guardar" value="Guardar">
				<input type="reset" class="button" value="Reset">	
			</div>
		</div>
		<div class="centrado my2">
			<a class="button" onclick="history.back()">Atrás</a>
			<a class="button" href="/Libro/list">Lista de libros</a>
		</div>		
	</form>
</main>		
	
	
</body>
</html>
