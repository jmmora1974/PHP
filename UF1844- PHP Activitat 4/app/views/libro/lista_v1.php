<?php
require '../templates/template.php';
?>
<!DOCTYPE html>
<html lang="es">
<?php head() ?>
		<body>
		<h1> Libros de la biblioteca</h1>
		<menu>
		<li><a href="index.php">Inicio</a></li>
		<li><a href="index.php?controlador=libro/list">Lista de libros</a></li>
		<li><a href="index.php?controlador=libro/create">Nuevo Libro</a></li>
		</menu>
		<h2>Lista de libros</h2>
		<table class="bloqueCentrado w100">
			<tr>
				<th> Título</th><th>Autor</th><th>Editoria</th><th>Operaciones</th>
			</tr>
			<?php foreach($libros as $libro){   ?>
				<tr>
				<td><?=$libro->titulo?></td>
				<td><?=$libro->autor?></td>
				<td><?=$libro->editorial?></td>
				<td>
					<a class="button" href='index.php?controlador=libro/show&id=<?=$libro->id?>'>Ver</a>
					<a class="button" href='index.php?controlador=libro/edit&id=<?=$libro->id?>'>Editar</a>
					<a class="button" href='index.php?controlador=libro/delete&id=<?=$libro->id?>'>Borrar</a>
					
				</td>
			</tr>
			
			<?php } ?>
			</table>	
</body>

</html>