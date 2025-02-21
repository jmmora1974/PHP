<?php
require '../templates/template.php';
?>
<!DOCTYPE html>
<html lang="es">
<?php head() ?>

		<body>
			<h3>Edición de un socio: <?=$socio->nombre?> <?=$socio->apellidos?></h3>
			<form method="POST" action="index.php?controlador=socio/update">
			
			<input type="hidden" name="id" value="<?=$socio->id?>">
			
			<label for="nombre">Nombre</label>
				<input type="text" name="nombre"  value="<?=$socio->nombre?>">
				<br>
			<label for="apellidos">Apellidos</label>
				<input type="text" name="apellidos" value="<?=$socio->apellidos?>">
				<br>
				<label for="dni">dni</label>
				<input type="text" name="dni" value="<?=$socio->dni?>">
				<br>
				<label for="nacimiento">nacimiento</label>
				<input type="date" name="nacimiento" value="<?=$socio->nacimiento?>">
				<br>
				<label for="email">email</label>
				<input type="email" name="email" value="<?=$socio->email?>">
				<br>
				<label for="direccion">direccion</label>
				<input type="text" name="direccion" value="<?=$socio->direccion?>">
				<br>
				<label for="cp">cp</label>
				<input type="text" name="cp" value="<?=$socio->cp?>">
				<br>
				<label for="poblacion">poblacion</label>
				<input type="text" name="poblacion" value="<?=$socio->poblacion?>">
				<br>
				<label for="provincia">provincia</label>
				<input type="text" name="provincia" value="<?=$socio->provincia?>">
				<br>
				<label for="telefono">telefono</label>
				<input type="number"  name="telefono" value="<?=$socio->telefono?>">
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
				<select name="conformidad" >
					<option value="Si" <?=$socio->conformidad=='Si'?'selected':''?>>Si</option>
					<option value="No" <?=$socio->conformidad=='No'?'selected':''?>>No</option>
				</select>
				<br>
				
				
				
				<input type="submit" class="button" name="actualizar" value="Actualizar">	
				<input type="reset" class="button" value="Reset">		
			</form>
			
			<?php botonListado() ?>
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
