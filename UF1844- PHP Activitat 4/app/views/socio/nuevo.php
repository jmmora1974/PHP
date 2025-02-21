<?php
require '../templates/template.php';
?>
<!DOCTYPE html>
<html lang="es">
<?php head() ?>
		<body>
			<h3>Creación de un nuevo socio</h3>
			<form method="POST" action="index.php?controlador=socio/store">
				<label for="nombre">Nombre</label>
				<input type="text" name="nombre">
				<br>
				<label for="apellidos">Apellidos</label>
				<input type="text" name="apellidos">
				<br>
				<label for="dni">dni</label>
				<input type="text" name="dni">
				<br>
				<label for="nacimiento">nacimiento</label>
				<input type="date" name="nacimiento">
				<br>
				<label for="email">email</label>
				<input type="email" name="email">
				<br>
				<label for="direccion">direccion</label>
				<input type="text" name="direccion">
				<br>
				<label for="cp">cp</label>
				<input type="text" name="cp">
				<br>
				<label for="poblacion">poblacion</label>
				<input type="text" name="poblacion">
				<br>
				<label for="provincia">provincia</label>
				<input type="text" name="provincia">
				<br>
				<label for="telefono">telefono</label>
				<input type="number"  name="telefono">
				<br>
				<label> Sube tu imagen de perfil: </label>
			    <br>
			     <figure>
			    	<img src="./imagenes/prf/default.jpg" id="preview-image" width="200" name="foto">
			    </figure>
			    <input type="hidden" name="MAX_FILE_SIZE" value="1240000">
			    <input type="file" accept=".jpg, .jpeg, .gif, .png"
			           name="fichero" id="file-with-preview"> 
			    <br>       
	   
			   
				
				<label for="conformidad">Conformidad</label>
				<select name="conformidad">
					<option value="Si">Si</option>
					<option value="No">No</option>
				</select>
				<br>
				
			
				<input type="submit" class="button" name="guardar" value="Guardar">		
			</form>
			
			<?php botonListado()?>
		</body>
	</html>

<!--   CAMPS DE TABLA SOCIOS
	id










foto
conformidad
alta
 -->	