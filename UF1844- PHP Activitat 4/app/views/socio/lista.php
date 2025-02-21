<?php
require '../templates/template.php';
?>
<!DOCTYPE html>
<html lang="es">
<?php head() ?>
		<body>
		<?php menu("Listado Socios")?>
		<form method="POST" class="search" action="index.php?controlador=libro/search">
		
			<label for="nombre">Nombre:</label>
			<input type="text" name="nombre" value="<?= $nombre ?? '' ?>">
			
			<label for="orden">Orden</label>
			<select name="orden">
				<option value="titulo"
				<?= !empty($campo)&&$campo=='titulo'?'selected' : '' ?>
				>Titulo</option>
				<option value="editorial"
				<?= !empty($campo)&&$campo=='editorial'?'selected' : '' ?>
				>Editorial</option>
				<option value="autor"
				<?= !empty($campo)&&$campo=='autor'?'selected' : '' ?>
				>Autor</option>
				
			</select>
			
			<input type="radio" name="sentido" value="ASC"
				<?= empty($sentido) || $sentido=='ASC'?'checked':'' ?>>
			<label>ASC</label>
			
			<input type="radio" name="sentido" value="DESC"
				<?= !empty($sentido) && $sentido=='DESC'?'checked':'' ?>>
			<label>DESC</label>
			
			<input type="submit" class="button" name="filtro" value="Filtrar">
			
			<a class="button" href="index.php?controlador=libro/list">Quitar filtros</a>
		</form>
		
		<h2>Lista de libros</h2>
		<table class="bloqueCentrado w100">
			<tr>
				<th> Nombre</th><th>Apellidos</th><th>email</th><th>telefono</th>
			</tr>
			<?php foreach($socios as $socio){   ?>
				<tr>
				<td><?=$socio->nombre?></td>
				<td><?=$socio->apellidos?></td>
				<td><?=$socio->email?></td>
				<td>
					<a class="button" href='index.php?controlador=libro/show&id=<?=$socio->id?>'>Ver</a>
					<a class="button" href='index.php?controlador=libro/edit&id=<?=$socio->id?>'>Editar</a>
					<a class="button" href='index.php?controlador=libro/delete&id=<?=$socio->id?>'>Borrar</a>
					
				</td>
			</tr>
			
			<?php } ?>
			</table>	
</body>

</html>