<?php
require '../templates/template.php';
?>
<!DOCTYPE html>
<html lang="es">
<?php head() ?>
		<body>
		<?php menu("Listado Socios")?>
		<form method="POST" class="search" action="index.php?controlador=socio/search">
		
			<label for="campo">Campo:</label>
			<select name="campo">
				<option value="nombre"
				<?= !empty($campo)&&$campo=='nombre'?'selected' : '' ?>
				>Nombre</option>
				<option value="apellidos"
				<?= !empty($campo)&&$campo=='apellidos'?'selected' : '' ?>
				>Apellidos</option>
				<option value="alta"
				<?= !empty($campo)&&$campo=='alta'?'selected' : '' ?>
				>Alta</option>
				
			</select>
			<input type="text" name="valor" value="<?= $nombre ?? '' ?>">
			
			<label for="orden">Orden</label>
			<select name="orden">
				<option value="nombre"
				<?= !empty($campo)&&$campo=='nombre'?'selected' : '' ?>
				>Nombre</option>
				<option value="apellidos"
				<?= !empty($campo)&&$campo=='apellidos'?'selected' : '' ?>
				>Apellidos</option>
				<option value="alta"
				<?= !empty($campo)&&$campo=='alta'?'selected' : '' ?>
				>Alta</option>
				
			</select>
			
			<input type="radio" name="sentido" value="ASC"
				<?= empty($sentido) || $sentido=='ASC'?'checked':'' ?>>
			<label>ASC</label>
			
			<input type="radio" name="sentido" value="DESC"
				<?= !empty($sentido) && $sentido=='DESC'?'checked':'' ?>>
			<label>DESC</label>
			
			<input type="submit" class="button" name="filtro" value="Filtrar">
			
			<a class="button" href="index.php?controlador=socio/list">Quitar filtros</a>
		</form>
		
		<h2>Lista de socios</h2>
		<table class="bloqueCentrado w100">
			<tr>
				<th> Nombre</th><th>Apellidos</th><th>telefono</th><th>email</th><th>alta</th><th>operaciones</th>
			</tr>
			<?php foreach($socios as $socio){   ?>
				<tr>
				<td><?=$socio->nombre?></td>
				<td><?=$socio->apellidos?></td>
				<td><?=$socio->telefono?></td>
				<td><?=$socio->email?></td>
				<td><?=$socio->alta?></td>
				<td>
					<a class="button" href='index.php?controlador=socio/show&id=<?=$socio->id?>'>Ver</a>
					<a class="button" href='index.php?controlador=socio/edit&id=<?=$socio->id?>'>Editar</a>
					<a class="button" href='index.php?controlador=socio/delete&id=<?=$socio->id?>'>Borrar</a>
					
				</td>
			</tr>
			
			<?php } ?>
			</table>	
</body>
</html>
<!--   CAMPS DE TABLA SOCIOS
	id
dni
nombre
apellidos
nacimiento
email
direccion
cp
poblacion
provincia
telefono
foto
conformidad
alta
 -->	