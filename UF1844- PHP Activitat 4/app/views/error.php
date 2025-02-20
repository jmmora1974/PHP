<?php
require '../templates/template.php';
?>
<!DOCTYPE html>
<html lang="es">
<?php head() ?>
<body>
	
	<?php menu("Error")?>
	
	<div class="error">
		<h2>Error</h2>
		<p><?= $mensaje ?> </p>
	</div>
	<?php botonListado()?>
</body>


</html>