<?php
require '../templates/template.php';
?>
<!DOCTYPE html>
<html lang="es">
<?php head()?>
		<body>
		<?php menu("Borrado de socio");
		migas([
				"Inicio"=>"index.php",
				"Listado socios"=>"index.php?controlador=socio/list",
				"Borrado socio"=>"'index.php?controlador=socio/delete&id='.$socio->id"]);?>
		
		<h2>Borrado de socio de la biblioteca</h2>
		<p>Confirmar el borrado del socio de la biblioteca</p>
		
		<form method="POST" class="centrado" action="index.php?controlador=socio/destroy">
			<input type="hidden" name="id" value="<?=$id?>">
			
			<label>Estas seguro que deseas borrar '<?=$socio->nombre.' '.$socio->apellidos?>' ? </label>
			<input type="submit" class="button" name="confirmarborrado" value="Borrar">
		</form>
		
		<?php botonListado() ?>
			
</body>

</html>