<?php
// esto no es necesario, pero por si nos intentan abrir la vista directamente...
if (empty ( $tema ))
	throw new Exception ( "NO PUEDES ABRIR DIRECTAMENTE UNA VISTA!" );
?>
<?php
require '../templates/template.php';
?>
<!DOCTYPE html>
<html lang="es">
<?php

head ();
menu ( "Detalles tema" );
migas ( [ 
		"Inicio" => "index.php",
		"Listado temas" => "index.php?controlador=tema/list",
		"Detalles tema" => "'index.php?controlador=tema/show&id='.$tema->id"
] );

?>

		<body>
	<h2>Detalles del tema</h2>
	<h3><?=$tema->tema?></h3>

	<p>
		<b>Tema:</b>  	<?= $tema->tema ?></p>
	<p>
		<b>Descripción:</b>  	<?= $tema->descripcion ?></p>

	<p>
		<b>Libros:</b>
	</p>
			<?php

			$libros = $tema->belongsToMany ( 'Libro', 'temas_libros' );

			?>
			<ul>
				<?php foreach ($libros as $libro){ ?> 
				<li>
						
				<?php
					// Obtenemos la lista de ejemplares del libro.
					// $ejemplares = $libro->getEjemplares(); // Una forma de obtener la lsta
					// $ejemplares = Prestamo::whereExactMatch(['idtema'=> intval($tema->id)]); Es otra forma de conseguir la lista de prestamos

					$ejemplares = $libro->hasMany ( 'Ejemplar' ); // Equivale a $tema->hasMany('Ejemplar','idtema','id');
				?>
				
				<h3 class="centrado">Ejemplares de <?=$libro->titulo?>.</h3>
				<table class="bloqueCentrado w100">
				<tr>
					<th>ID</th>
					<th>Año</th>
					<th>Precio</th>
					<th>Estado</th>
					<th>operaciones</th>
				</tr>
				<?php foreach ($ejemplares as $ejemplar){   ?>
					<tr>
					<td><?=$ejemplar->id?></td>
					<td><?=$ejemplar->anyo?></td>
					<td><?=$ejemplar->precio?></td>
					<td><?=$ejemplar->estado ? $ejemplar->estado : '' ?></td>
					<td><a class="button"
						href='index.php?controlador=ejemplar/show&id=<?=$ejemplar->id?>'>Ver</a>
						<a class="button"
						href='index.php?controlador=ejemplar/edit&id=<?=$ejemplar->id?>'>Editar</a>
						<a class="button"
						href='index.php?controlador=ejemplar/delete&id=<?=$ejemplar->id?>'>Borrar</a>
	
					</td>
				</tr>
					
	<?php } ?>
	
			</table>
			</li>	
	<?php }?>
			</ul>	
			<?php botonListado()?>
		</body>
</html>