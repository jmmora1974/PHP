<?php
require '../templates/template.php';
?>
<!DOCTYPE html>
<html lang="es">
<?php head() ?>
		<body>
			<h2>Detalles del socio</h2>
			<h3><?=$socio->nombre?> <?= $socio->apellidos?></h3>
			
			<p><b>Nombre:</b>  	<?= $socio->nombre ?></p>
			<p><b>Apellidos:</b>  	<?= $socio->apellidos ?></p>
			<p><b>Nacimiento:</b>  	<?= $socio->nacimiento ?></p>
			<p><b>email:</b>  	<?= $socio->email ?></p>
			<p><b>Direccion:</b>  	<?= $socio->direccion ?></p>
			<p><b>cp:</b>  	<?= $socio->cp ?></p>
			<p><b>poblacion:</b>  	<?= $socio->poblacion ?></p>
			<p><b>provincia:</b>  	<?= $socio->provincia ?></p>
			<p><b>telefono:</b>  	<?= $socio->telefono ?></p>
			<p><b>foto:</b>  	<?= $socio->foto ?></p>
			<p><b>conformidad:</b>  	<?= $socio->conformidad ?></p>
			<p><b>alta:</b>  	<?= $socio->alta ?></p>
			
			<?php botonListado()?><?php botonListadoSocios()?>
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