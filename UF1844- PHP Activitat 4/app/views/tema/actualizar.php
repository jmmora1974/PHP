<?php
// esto no es necesario, pero por si nos intentan abrir la vista directamente...
if(empty($tema))
	throw new Exception("NO PUEDES ABRIR DIRECTAMENTE UNA VISTA!");
?>
<?php
require '../templates/template.php';
?>
<!DOCTYPE html>
<html lang="es">
<?php head();
menu("Edicion tema");
migas([
		"Inicio"=>"index.php",
		"Listado temas"=>"index.php?controlador=tema/list",
		"Edicion tema"=>"'index.php?controlador=tema/edit&id='.$tema->id"]); ?>

		<body>
			<h3>Edición del tema: <?=$tema->tema?></h3>
			<form method="POST" action="index.php?controlador=tema/update">
				<input type="hidden" name="id" value="<?=$tema->id?>">
				
				<label for="tema">Tema</label>
				<input type="text" name="tema" value="<?=$tema->tema?> required">
				<br>
				<label for="descripcion">Descripcion</label>
				<input type="text" name="descripcion" value="<?=$tema->descripcion?>">
				<br>
				
				<input type="submit" class="button" name="actualizar" value="Actualizar">	
				<input type="reset" class="button" value="Reset">		
			</form>
			
			<?php botonListado() ?>
		</body>
	</html>
	
	
