<main>
	<h1><?=APP_NAME ?></h1>
	<section>
		<p><b>ISBN:</b>  	<?= $libro->isbn ?></p>
		<p><b>Titulo:</b>  	<?= $libro->titulo ?></p>
		<p><b>Editorial:</b>  	<?= $libro->editorial ?></p>
		<p><b>Autor:</b>  	<?= $libro->autor ?></p>
		<p><b>Idioma:</b>  	<?= $libro->idioma ?></p>
		<p><b>Edicion:</b>  	<?= $libro->edicion ?></p>
		<p><b>Edad Recomendada:</b><?= $libro->edadrecomendada ?? 
								'Pendiente de calificación'; ?></p>
		<p><b>Año:</b><?=$libro->anyo ?? ' -- ';?> </p>
		<p><b>Páginas: <?= $libro->paginas ?? ' -- ' ?></b></p>
		<p><b>Caracteristicas:</b><?= $libro->caracteristicas ?? ' -- ' ?></p>
	</section>
	<section>
		<h2> Sinopsis </h2>
		<p> <?= $libro->sinopsis ? paragraph($libro->sinopsis) :'SIN DETALLES'?></p>
	</section>
	
	<div class="centrado">
		<a class="button" onclick="history.back()">Atrás</a>
		<a class="button" href="/libro/list">Lista de libros</a>
		<a class="button" href="/libro/edit/<?=$libro->id?>">Editar</a>
		<a class="button" href="/libro/delete/<?=$libro->id?>">Borrar</a>		
	</div>
</main>
	
	