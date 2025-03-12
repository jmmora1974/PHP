<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Maralioteca - Edición de libro - <?= APP_NAME ?></title>
		
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
		<?= $template->header('Edició de un libro') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Libros'=>'/Libro',$libro->titulo=>'/Libro/show/'.$libro->id,'Edicion'=>null]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
	<main>
	<h1><?=APP_NAME?></h1>
	<h2>Edición del libro: <b>"<?= $libro->titulo ?>"</b></h2>
	<section class="flex-container gap2">
	<form method="POST" enctype="multipart/form-data" action="/Libro/update" class="flex2 no-border">
		<div class="centrado">
		
		<input type="hidden" name="id" value="<?= $libro->id ?>" required>
		
		<label for="isbn">ISBN</label>
		<input type="text" name="isbn" value="<?= old('isbn',$libro->isbn)?>" required>
		<br>
		<label for="titulo">Título</label>
		<input type="text" name="titulo" value="<?= old('titulo', $libro->titulo)?>" required>
			<br>
			<label for="editorial">Editorial</label>
			<input type="text" name="editorial" value="<?= old('editorial', $libro->editorial)?>" >
			<br>
			<label for="autor">Autor</label>
			<input type="text" name="autor" value="<?= old('autor', $libro->autor)?>" >
			<br>
			<label for="idioma">Idioma</label>
			<input type="text" name="idioma" value="<?= old('idioma', $libro->idioma)?>" >
			<br>
			<label for="edicion">Edicion</label>
			<input type="number" min="0" name="edicion" value="<?=old('edicion', $libro->edicion)?>">
			<br>
			<label for="anyo">Año</label>
			<input type="number" min="0" name="anyo" value="<?=old('anyo', $libro->anyo)?>">
			<br>
			<label for="edadrecomendada">Edad rec.</label>
			<input type="number" min="0" max="99" name="edadrecomendada" value="<?=old('edadrecomendada', $libro->edadrecomendada)?>">
			<br>
			<label for="paginas">Páginas</label>
			<input type="number" min="0" name="paginas" value="<?=old('paginas', $libro->paginas)?>">
			<br>
			<label for="caracteristicas">Caracterís.</label>
			<input type="number" min="0" name="caracteristicas" value="<?=old('caracteristicas', $libro->caracteristicas)?>">
			<br>
			<label for="portada">Portada</label>
			<input type="file" name="portada" accept="image/*" id="file-with-preview">
			<br>
			<label for="sinopsis">Sinopsis</label>
			<textarea name="sinopsis" class="w50"><?=old('sinopsis')?></textarea>
			<br>
			<div class="centered mt2">
				<input type="submit" class="button" name="actualizar" value="Actualizar">
				<input type="reset" class="button" value="Reset" onclick="<?php redirect('/Libro/edit/$libro->id');?>">	
			</div>
		</div>
		</form>
		<figure class="flex1 centrado p2">
				<img src="<?=BOOK_IMAGE_FOLDER.'/'.($libro->portada ?? DEFAULT_BOOK_IMAGE)?>"
				 	class="cover enlarge-image" alt="Portada del libro <?= $libro->titulo?>">				 		
				 <figcaption>Portada del libro <?= "$libro->titulo, de $libro->autor"?> </figcaption>
				<!-- Botón de eliminar la portada (sin cambiar nada mas) -->
				<form method="POST" action="/Libro/dropcover" enctype="multipart/form-data" class="no-border">
					<input type="hidden" name="id" value="<?= $libro->id?>">
					<input type="submit" class="button-danger" name="borrar" value="Eliminar portada">
				</form>
			</figure>
			
		</section>
		<div class="centrado m1">
			<a class="button" onclick="history.back()">Atrás</a>
			<a class="button" href="/Libro/list">Lista de libros</a>
			<a class="button" href="/Libro/show/<?=$libro->id?>">Detalles</a>
			<?php if(!$libro->hasAny('Ejemplar')){ ?> 
				<a class="button-danger" href="/Libro/delete/<?=$libro->id?>">Borrado</a>
			<?php } ?>
		</div>	
		<section id="secejemplares">
			<script>
				function confirmar(id){
					if(confirm('Seguro que deseas eliminar?'))
						location.href='/Ejemplar/destroy/'+id;
				}
			</script>
			<h2>Ejemplares de <b>"<?=$libro->titulo?>"</b></h2>
						<div class="centrado">
					<a class="button" href="/Ejemplar/create/<?=$libro->id ?>">Nuevo ejemplar</a>
					
				</div>
			<?php 
			if(!$ejemplares){
					echo "<div class='warning p2'><p>No hay ejemplares de este libro.</p></div>";
			} else { ?>
				<table class="table w100 centered-block">
					<tr>
						<th>ID</th><th>Año</th><th>Precio</th><th>Estado</th><th>Operacion</th>
					</tr>
					<?php 
					foreach($ejemplares as $ejemplar ){ ?>
						<tr>
							<td> <?=$ejemplar->id ?></td>
							<td> <?=$ejemplar->anyo ?></td>
							<td> <?=$ejemplar->precio ?></td>
							<td> <?=$ejemplar->estado ?></td>
							<td class="centrado">
							<a class="button" href="/ejemplar/edit/<?=$ejemplar->id ?>">Editar</a> 
							<?php
							//$prestado=$ejemplar->getPrestamoActual();
							
							if(!$ejemplar->hasAny('Prestamo')){ ?> 
							
								<a class="button-danger" onclick="confirmar(<?=$ejemplar->id ?>)">Borrar</a>
							<?php } ?>
							</td>
					<?php } ?>
						</tr>
					<?php } ?>	
				</table>
				<div class="p1 right">
					Existen <?= sizeof($ejemplares) ?> ejemplares de este libro.
				</div>	
							
		</section>
		<div class="centrado m1">
			<a class="button" onclick="history.back()">Atrás</a>
			<a class="button" href="/Libro/list">Lista de libros</a>
			<a class="button" href="/Libro/show/<?=$libro->id?>">Detalles</a>
			
		</div>	
		<section id="sectemas">
			<h2>Temas en <b>"<?= $libro->titulo?>"</b></h2>
			<?php 
			if(!$temas){
				echo "<div class='warning p2'><p>No se han indicado temas.</p></div>";
			} else { ?>
				<table class="table w100">
					<tr>
						<th>ID</th>
						<th>Tema</th>
						<th>Operaciones</th>
					</tr>
				<?php foreach($temas as $tema){?>
					<tr>
						<td><?= $tema->id ?></td>
						<td><a href='/Tema/show/<?=$tema->id ?>'>
							<?= $tema->tema?></a>
						</td>
						<td class="centrado">
							<form method="POST" class="no-border" action="/Libro/removetema">
								<input type="hidden" name="idlibro" value="<?= $libro->id ?>">
								<input type="hidden" name="idtema" value="<?= $tema->id ?>">
								<input type="submit" class="button-danger" name="remove" value="Borrar">
							</form>
						</td>
					</tr>
					<?php } ?>
				</table>
				
				
			<?php } ?>
			<form class="w50 m0 no-border centrado" method="POST" action="/Libro/addtema">
					<input type="hidden" name="idlibro" value="<?= $libro->id ?>">
					<select name="idtema">
					<?php 
					foreach($listaTemas as $nuevoTema){
						echo "<option value='$nuevoTema->id'>$nuevoTema->tema</option>\n";
					}?>
					</select>
					<input type="submit" class="button-success" name="add" value="Añadir tema">
				</form>
			
		</section>
		<div class="centrado m1">
			<a class="button" onclick="history.back()">Atrás</a>
			<a class="button" href="/Libro/list">Lista de libros</a>
			<a class="button" href="/Libro/show/<?=$libro->id?>">Detalles</a>
			
		</div>	
		
	
</main>		
	
	
</body>
</html>
