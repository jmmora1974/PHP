<?php
	require '../templates/template.php';
?>
<!DOCTYPE>
<html lang="es">
<?php head()?>
		<body>
			<h2>Detalles del libro</h2>
			<h3><?=$libro->titulo?></h3>
			
			<p><b>ISBN:</b>  	<?= $libro->isbn ?></p>
			<p><b>Titulo:</b>  	<?= $libro->titulo ?></p>
			<p><b>Editorial:</b>  	<?= $libro->editorial ?></p>
			<p><b>Autor:</b>  	<?= $libro->autor ?></p>
			<p><b>Idioma:</b>  	<?= $libro->idioma ?></p>
			<p><b>Edicion:</b>  	<?= $libro->edicion ?></p>
			<p><b>Edad Recomendada:</b>  	
				<?= $libro->edadrecomendada ? $libro->edadrecomendada : 'TP' ?></p>
				
			<?php botonListado()?>
		</body>
</html>