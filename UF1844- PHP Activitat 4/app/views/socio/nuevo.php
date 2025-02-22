<?php
require '../templates/template.php';
?>
<!DOCTYPE html>
<html lang="es">
<?php head(); menu("Nuevo socio"); 
migas([
		"Inicio"=>"index.php",
		"Listado Socios"=>"index.php?controlador=socio/list",
		"Nuevo Socio"=>"index.php?controlador=socio/create"]);?>
<script src="../js/Preview.js"></script>
		<body>
			<h3>Creación de un nuevo socio</h3>
			
			<form method="POST" action="index.php?controlador=socio/store" enctype="multipart/form-data" id="formNuevoSocio" name="formNuevoSocio">
			 	<label> Sube tu imagen de perfil: </label>
			 	<input type="hidden" name="MAX_FILE_SIZE" value="1240000">
			    <input type="file" accept=".jpg, .jpeg, .gif, .png"
			           name="fichero" id="file-with-preview"> 
			    <br>
			    <figure>
			    	<img src="./imagenes/prf/default.jpg" id="preview-image" width="200" name="foto">
			    </figure>
			    
			    <br> 
				<label for="nombre" >Nombre</label>
				<input type="text" name="nombre" required>
				<br>
				<label for="apellidos" >Apellidos</label>
				<input type="text" name="apellidos" required>
				<br>
				<label for="dni">dni</label>
				<input type="text" name="dni" minlength="9" maxlength="9" pattern="[a-z]{1}[0-9]{7}[a-z]{1}" required>   
				<br>
				<label for="nacimiento" required>nacimiento</label>
				<input type="date" name="nacimiento">
				<br>
				<label for="email" >email</label>
				<input type="email" name="email" required>
				<br>
				<label for="direccion">direccion</label>
				<input type="text" name="direccion">
				<br>
				<label for="cp">cp</label>
				<input type="text" name="cp" minlength="5" maxlength="5">
				<br>
				<label for="poblacion">poblacion</label>
				<input type="text" name="poblacion">
				<br>
				<label for="provincia">provincia</label>
				<input type="text" name="provincia">
				<br>
				<label for="telefono">telefono</label>
				<input type="number"  name="telefono" minlength="9" maxlength="9">
				<br>
				<label for="conformidad">Conformidad</label>
				<select name="conformidad">
					<option value="Si">Si</option>
					<option value="No">No</option>
				</select>
				<br>
				
				<div class="centrado">
					<input type="submit" class="button" name="guardar"  value="Guardar" >	
					<input type="reset" class="button" value="Reset">
				</div>		
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