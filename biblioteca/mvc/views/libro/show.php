<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Visualización de un libro - <?= APP_NAME ?></title>

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
		<?= $template->breadCrumbs(['Libros'=>'/Libro',$libro->titulo=>'/Libro/show/'.$libro->id,'Detalles'=>null]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
	<main>
		<h1><?=APP_NAME?></h1>
		<section>
			<DIV class="flex2 centered">
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
				<p>
					<b>Ejemplares:</b>  	<?= $libro->ejemplares ?? ' -- '?></p>
			</DIV>
			<div class="centrado">
			<a class="button" onclick="history.back()">Atrás</a> 
			<a class="button" href="/Libro/list">Lista de libros</a> 
			<a	class="button" href="/Libro/edit/<?=$libro->id?>">Editar</a>
			<?php if(!$libro->hasAny('Ejemplar')){ ?>
				<a class="button-danger" href="/Libro/delete/<?=$libro->id ?>">Borrar</a>';
			<?php }?>
				
				
		</div>
		</section>
		<section>
			<h2>Sinopsis</h2>
			<p><?= $libro->sinopsis ? paragraph($libro->sinopsis) : 'SIN DETALLES'?></p>
		</section>
		<section>
			<h2>Ejemplares</h2>
			<?php 
			if(!$ejemplares){
					echo "<div class='warning p2'><p>No hay ejemplares de este libro.</p></div>";
			} else { ?>
				<table class="table w100 centered-block">
					<tr>
						<th>ID</th><th>Año</th><th>Precio</th><th>Estado</th>
					</tr>
					<?php 
					foreach($ejemplares as $ejemplar){ ?>
						<tr>
							<td> <?=$ejemplar->id ?></td>
							<td> <?=$ejemplar->anyo ?></td>
							<td> <?=$ejemplar->precio ?></td>
							<td> <?=$ejemplar->estado ?></td>
						</tr>
					<?php } ?>	
				</table>
				<div class="p1 right">
					Existen <?= sizeof($ejemplares) ?> ejemplares de este libro.
				</div>				
				
			<?php } ?>
			<div class="centrado">
			<a class="button" onclick="history.back()">Atrás</a> 
			<a class="button" href="/Libro/list">Lista de libros</a> 
			<a	class="button" href="/Libro/edit/<?=$libro->id?>">Editar</a>			
				
		</div>
		</section>
		<section>
			<h2>Temas en <b>"<?= $libro->titulo?>"</b></h2>
			<?php 
			if(!$temas){
				echo "<div class='warning p2'><p>No se han indicado temas.</p></div>";
			} else { ?>
				<table class="table w100">
					<tr>
						<th>ID</th>
						<th>Tema</th>
					</tr>
				<?php foreach($temas as $tema){?>
					<tr>
						<td><?= $tema->id ?></td>
						<td><a href='/Tema/show/<?=$tema->id ?>'>
							<?= $tema->tema?></a>
						</td>
					</tr>
					<?php } ?>
				</table>
			<?php } ?>
			
		</section>

		<div class="centrado">
			<a class="button" onclick="history.back()">Atrás</a> 
			<a class="button" href="/Libro/list">Lista de libros</a> 
			<a	class="button" href="/Libro/edit/<?=$libro->id?>">Editar</a>
			
				
				
		</div>
	</main>
</body>

</html>