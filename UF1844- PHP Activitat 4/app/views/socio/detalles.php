<?php
// esto no es necesario, pero por si nos intentan abrir la vista directamente...
if(empty($socio))
	throw new Exception("NO PUEDES ABRIR DIRECTAMENTE UNA VISTA!");
?>
<?php
require '../templates/template.php';
?>
<!DOCTYPE html>
<html lang="es">
<?php head();
	menu("Detalles Socio"); 
	migas([
			"Inicio"=>"index.php",
			"Listado Socios"=>"index.php?controlador=socio/list",
			"Detalles Socio"=>"'index.php?controlador=socio/show&id='.$socio->id"]);
	?>
		<body>
			<h2>Detalles del socio</h2>
			<h3><?=$socio->nombre?> <?= $socio->apellidos?></h3>
			<figure>
			    	<img src="<?= $socio->foto ?>" id="preview-image" width="100" name="foto">
			</figure>
			  	
			<p><b>Nombre:</b>  	<?= $socio->nombre ?></p>
			<p><b>Apellidos:</b>  	<?= $socio->apellidos ?></p>
			<p><b>Nacimiento:</b>  	<?= $socio->nacimiento ?></p>
			<p><b>email:</b>  	<?= $socio->email ?></p>
			<p><b>Direccion:</b>  	<?= $socio->direccion ?></p>
			<p><b>cp:</b>  	<?= $socio->cp ?></p>
			<p><b>poblacion:</b>  	<?= $socio->poblacion ?></p>
			<p><b>provincia:</b>  	<?= $socio->provincia ?></p>
			<p><b>telefono:</b>  	<?= $socio->telefono ?></p>
			
			<p><b>conformidad:</b>  	<?= $socio->conformidad ?></p>
			<p><b>alta:</b>  	<?= $socio->alta ?></p>
			
			
			<h3>Prestamos del socio</h3>
			<p> <?= $socio->hasAny('Prestamo') ?
					 "Los prestamos del socio $socio->nombre $socio->apellidos son:"  :
					"El socio  $socio->nombre $socio->apellidos no tiene ningún prestamo.";
				?> </p>
	
	


<?php 
		
	//Obtenemos la lista de prestamos del socio.
	//$pretamos = $socio->getPrestamos();  // Una forma de obtener la lsta  
	//$pretamos = Prestamo::whereExactMatch(['idsocio'=> intval($socio->id)]);  Es otra forma de conseguir la lista de prestamos
$pretamos = $socio->hasMany('Prestamo','idsocio','id');// Equivale a  $socio->hasMany('Prestamo','idsocio','id');
?>
	<table class="bloqueCentrado w100">
	<tr>
	<th> Ejemplar</th><th>Prestamo</th><th>Limite</th><th>devolucion</th><th>incidencia</th><th>operaciones</th>
	</tr>
	<?php foreach ($pretamos as $pretamo){   ?>
				<tr>
				<td><?=$pretamo->idejemplar?></td>
				<td><?=$pretamo->prestamo?></td>
				<td><?=$pretamo->limite?></td>
				<td><?=$pretamo->devolucion?></td>
				<td><?=$pretamo->incidencia ? $pretamo->incidencia : 'En buen estado' ?></td>
				<td>
					<a class="button" href='index.php?controlador=prestamo/show&id=<?=$pretamo->id?>'>Ver</a>
					<a class="button" href='index.php?controlador=prestamo/edit&id=<?=$pretamo->id?>'>Editar</a>
					<a class="button" href='index.php?controlador=prestamo/delete&id=<?=$pretamo->id?>'>Borrar</a>
					
				</td>
			</tr>
	<?php } ?>
	
			</table>	
	

			
				<?php botonListado()?>
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