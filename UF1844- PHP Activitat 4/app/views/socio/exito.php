<?php
require '../templates/template.php';
?>
<!DOCTYPE html>
<html lang="es">
<?php head() ?>
<body>
	<?php menu("Exito")?>
	<div class="exito">
		<h2>Éxito</h2>
		<p><?= $mensaje ?> </p>
	</div>
	
	<?php botonListado()?>
</body>
</html>
