<?php
require '../templates/template.php';
?>
<!DOCTYPE html>
<html lang="es">
<?php head() ?>
		<body>
		<?php menu("Listado temas");
		migas(["Inicio"=>"index.php","listado temas"=>"index.php?controlador=tema/list"]);?>
		<form method="POST" class="search" action="index.php?controlador=tema/search">
			
			<label for="campo">Campo</label>
			<select name="campo">
				<option value="tema"
				<?= !empty($campo)&&$campo=='tema'?'selected' : '' ?>
				>Tema</option>
				<option value="descripcion"
				<?= !empty($campo)&&$campo=='descripcion'?'selected' : '' ?>
				>Descripción</option>
				
				
			</select>
			<label for="valor">Valor:</label>
			<input type="text" name="valor" value="<?= $valor ?? '' ?>">
			
			<label for="orden">Orden</label>
			<select name="orden">
				<option value="tema"
				<?= !empty($orden)&&$orden=='tema'?'selected' : '' ?>
				>Tema</option>
				<option value="descripcion"
				<?= !empty($orden)&&$orden=='descripcion'?'selected' : '' ?>
				>Descripcion</option>	
			</select>
			
			<input type="radio" name="sentido" value="ASC"
				<?= empty($sentido) || $sentido=='ASC'?'checked':'' ?>>
			<label>ASC</label>
			
			<input type="radio" name="sentido" value="DESC"
				<?= !empty($sentido) && $sentido=='DESC'?'checked':'' ?>>
			<label>DESC</label>
			
			<input type="submit" class="button" name="filtro" value="Filtrar">
			
			<a class="button" href="index.php?controlador=tema/list">Quitar filtros</a>
		</form>
		
		<h2>Lista de temas</h2>
		<table class="bloqueCentrado w100">
			<tr>
				<th> ID</th><th>Tema</th><th>Descripción</th><th>Operaciones</th>
			</tr>
			<?php foreach($temas as $tema){   ?>
				<tr>
				<td><?=$tema->id?></td>
				<td><?=$tema->tema?></td>
				<td><?=$tema->descripcion?></td>
				<td>
					<a class="button" href='index.php?controlador=tema/show&id=<?=$tema->id?>'>Ver</a>
					<a class="button" href='index.php?controlador=tema/edit&id=<?=$tema->id?>'>Editar</a>
					<a class="button" href='index.php?controlador=tema/delete&id=<?=$tema->id?>'>Borrar</a>
					
				</td>
			</tr>
			
			<?php } ?>
			</table>	
</body>

</html>