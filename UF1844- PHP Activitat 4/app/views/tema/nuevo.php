<?php
require '../templates/template.php';
?>
<!DOCTYPE html>
<html lang="es">
<?php head(); 
	menu("Nuevo tema");
	migas([
			"Inicio"=>"index.php",
			"Listado temas"=>"index.php?controlador=tema/list",
			"Nuevo tema"=>"'index.php?controlador=tema/edit&id='.$tema->id"]);

		?>
		<body>
			<h3>Creación de un nuevo tema</h3>
			<form method="POST" action="index.php?controlador=tema/store">
				<label for="tema">Tema</label>
				<input type="text" name="tema" required>
				<br>
				<label for="descripcion">Descripción</label>
				<input type="text" name="descripcion">
				<br>
				<input type="submit" class="button" name="guardar" value="Guardar">
				<input type="reset" class="button" value="Reset">		
			</form>
			
			<?php botonListado()?>
		</body>
	</html>
	
	
