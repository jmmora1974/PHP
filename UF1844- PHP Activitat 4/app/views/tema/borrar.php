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
?>
		<body>
		<?php menu("Borrado de tema");
		migas([
				"Inicio"=>"index.php",
				"Listado temas"=>"index.php?controlador=tema/list",
				"Borrado tema"=>"'index.php?controlador=tema/delete&id='.$tema->id"]);
		?>
		
		<h2>Borrado de tema de temas</h2>
		<p>Confirmar el borrado del tema de temas</p>
		
		<form method="POST" class="centrado" action="index.php?controlador=tema/destroy">
			<input type="hidden" name="id" value="<?=$id?>">
			
			<label>Estas seguro que deseas borrar el tema  '<?=$tema->tema?>' ? </label>
			<input type="submit" class="button" name="confirmarborrado" value="Borrar">
		</form>
		
		<?php botonListado() ?>
			
</body>

</html>