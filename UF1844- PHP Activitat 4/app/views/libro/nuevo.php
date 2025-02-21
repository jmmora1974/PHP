<?php
require '../templates/template.php';
?>
<!DOCTYPE html>
<html lang="es">
<?php head() ?>
		<body>
			<h3>Creación de un nuevo libro</h3>
			<form method="POST" action="index.php?controlador=libro/store">
				<label for="isbn">ISBN</label>
				<input type="text" name="isbn">
				<br>
				<label for="titulo">Título</label>
				<input type="text" name="titulo">
				<br>
				<label for="editorial">Editorial</label>
				<input type="text" name="editorial">
				<br>
				<label for="autor">Autor</label>
				<input type="text" name="autor">
				<br>
				<label for="idioma">Idioma</label>
				<select name="idioma">
					<option value="Castellano">Castellano</option>
					<option value="catalan">Catalan</option>
					<option value="otros">Otros</option>
				</select>
				<br>
				<label for="edicion">Edicion</label>
				<input type="number" min="0" name="edicion">
				<br>
				<label for="edadrecomendada">Edad</label>
				<input type="number" min="0" max="99" name="edadrecomendada">
				<br>
				<input type="submit" class="button" name="guardar" value="Guardar">		
			</form>
			
			<?php botonListado()?>
		</body>
	</html>
	
	
