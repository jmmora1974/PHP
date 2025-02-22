<?php
// esto no es necesario, pero por si nos intentan abrir la vista directamente...
if(empty($libro))
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
		<?php menu("Borrado de libro");
		migas([
				"Inicio"=>"index.php",
				"Listado libros"=>"index.php?controlador=libro/list",
				"Borrado libro"=>"'index.php?controlador=libro/delete&id='.$libro->id"]);
		?>
		
		<h2>Borrado de libro de la biblioteca</h2>
		<p>Confirmar el borrado del libro de la biblioteca</p>
		
		<form method="POST" class="centrado" action="index.php?controlador=libro/destroy">
			<input type="hidden" name="id" value="<?=$id?>">
			
			<label>Estas seguro que deseas borrar '<?=$libro->titulo?>' ? </label>
			<input type="submit" class="button" name="confirmarborrado" value="Borrar">
		</form>
		
		<?php botonListado() ?>
			
</body>

</html>