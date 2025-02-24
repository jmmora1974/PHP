<?php
require '../templates/template.php';
?>
<!DOCTYPE html>
<html lang="es">
<?php head(); 
	menu("Nuevo libro");
	migas([
			"Inicio"=>"index.php",
			"Listado libros"=>"index.php?controlador=libro/list",
			"Nuevo libro"=>"'index.php?controlador=libro/edit&id='.$libro->id"]);

		?>
		<body>
			<h3>Creación de un nuevo libro</h3>
			<form method="POST" action="index.php?controlador=libro/store">
				<label for="isbn">ISBN</label>
				<input type="text" name="isbn" required>
				<br>
				<label for="titulo">Título</label>
				<input type="text" name="titulo" required>
				<br>
				<label for="editorial">Editorial</label>
				<input type="text" name="editorial" required>
				<br>
				<label for="autor">Autor</label>
				<input type="text" name="autor" required>
				<br>
				<label for="idioma">Idioma</label>
				<select name="idioma">
					<option value="Castellano">Castellano</option>
					<option value="Catalán">Catalán</option>
					<option value="Ingles">Inglés</option>
					<option value="Otros">Otros</option>
				</select>
				<br>
				<label for="edicion">Edicion</label>
				<input type="number" min="0" name="edicion">
				<br>
				<label for="edadrecomendada">Edad</label>
				<input type="number" min="0" max="99" name="edadrecomendada">
				<br>
				<input type="submit" class="button" name="guardar" value="Guardar">
				<input type="reset" class="button" value="Reset">		
			</form>
			
			<?php botonListado()?>
		</body>
	</html>
	
	
