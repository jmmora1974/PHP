<?php
require '../templates/template.php';
?>
<!DOCTYPE>
<html lang="es">
<?php head() ?>

		<body>
			<h3>Edición de un libro: <?=$libro->titulo?></h3>
			<form method="POST" action="index.php?controlador=libro/update">
				<input type="hidden" name="id" value="<?=$libro->id?>">
				
				<label for="isbn">ISBN</label>
				<input type="text" name="isbn" value="<?=$libro->isbn?>">
				<br>
				<label for="titulo">Título</label>
				<input type="text" name="titulo" value="<?=$libro->titulo?>">
				<br>
				<label for="editorial">Editorial</label>
				<input type="text" name="editorial" value="<?=$libro->editorial?>">
				<br>
				<label for="autor">Autor</label>
				<input type="text" name="autor" value="<?=$libro->autor?>">
				<br>
				<label for="idioma">Idioma</label>
				<select name="idioma">
					<option value="Castellano" <?=$libro->idioma=='Castellano'?'selected':''?>>Castellano</option>
					<option value="catalán" <?=$libro->idioma=='Catalán'?'selected':''?>>Catalán</option>
					<option value="Inglés"<?=$libro->idioma=='Inglés'?'selected':''?>>Inglés</option>
					<option value="Otros" <?=$libro->idioma=='Otros'?'selected':''?>>Otros</option>
				</select>
				<br>
				<label for="edicion">Edicion</label>
				<input type="number" min="0" name="edicion" value="<?=$libro->edicion?>">
				<br>
				<label for="edadrecomendada">Edad</label>
				<input type="number" min="0" max="99" name="edadrecomendada" value="<?=$libro->edadrecomendada?>">
				<br>
				<input type="submit" class="button" name="actualizar" value="Actualizar">	
				<input type="reset" class="button" value="Reset">		
			</form>
			
			<?php botonListado() ?>
		</body>
	</html>
	
	
