<?php
// esto no es necesario, pero por si nos intentan abrir la vista directamente...
if(empty($libro))
	throw new Exception("NO PUEDES ABRIR DIRECTAMENTE UNA VISTA!");
	?>
<?php
require '../templates/template.php';
?>
<!DOCTYPE html>
<html lang="es">
<?php head(); menu("Detalles libro"); ?>

		<body>
			<h2>Detalles del libro</h2>
			<h3><?=$libro->titulo?></h3>
			
			<p><b>ISBN:</b>  	<?= $libro->isbn ?></p>
			<p><b>Titulo:</b>  	<?= $libro->titulo ?></p>
			<p><b>Editorial:</b>  	<?= $libro->editorial ?></p>
			<p><b>Autor:</b>  	<?= $libro->autor ?></p>
			<p><b>Idioma:</b>  	<?= $libro->idioma ?></p>
			<p><b>Edicion:</b>  	<?= $libro->edicion ?></p>
			<p><b>Edad Recomendada:</b> 	<?= $libro->edadrecomendada ? $libro->edadrecomendada : 'TP' ?></p>
			<p><b>Temas:</b></p>
			<?php
		
			$temas=$libro->belongsToMany('Tema','temas_libros');
		
			?>
			<ul>
				<?php foreach ($temas as $tema){ ?> 
					<li><?=$tema->tema?></li>					
				<?php }?>
			</ul>
	<?php 
	//Obtenemos la lista de ejemplares del libro.
	// $ejemplares = $libro->getEjemplares();  // Una forma de obtener la lsta  
	// $ejemplares = Prestamo::whereExactMatch(['idlibro'=> intval($libro->id)]);  Es otra forma de conseguir la lista de prestamos
	
			$ejemplares = $libro->hasMany('Ejemplar');// Equivale a  $libro->hasMany('Ejemplar','idlibro','id');
?>
	<h3 class="centrado">Ejemplares</h3>
	<table class="bloqueCentrado w100">
	<tr>
	<th> ID</th><th>Año</th><th>Precio</th><th>Estado</th><th>operaciones</th>
	</tr>
	<?php foreach ($ejemplares as $ejemplar){   ?>
				<tr>
				<td><?=$ejemplar->id?></td>
				<td><?=$ejemplar->anyo?></td>
				<td><?=$ejemplar->precio?></td>
				<td><?=$ejemplar->estado ? $ejemplar->estado : '' ?></td>
				<td>
					<a class="button" href='index.php?controlador=ejemplar/show&id=<?=$ejemplar->id?>'>Ver</a>
					<a class="button" href='index.php?controlador=ejemplar/edit&id=<?=$ejemplar->id?>'>Editar</a>
					<a class="button" href='index.php?controlador=ejemplar/delete&id=<?=$ejemplar->id?>'>Borrar</a>
					
				</td>
			</tr>
	<?php } ?>
	
			</table>	
	
			<?php botonListado()?>
		</body>
</html>