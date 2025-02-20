<h1>Probando los metodos de Model</h1>
<?php
require_once '../config/config.php';
require_once '../autoload.php';
?>

<h2> Recuperando todos los prestamos...</h2>
<p> Usamos el método estático <code>all()</code>.</p>
<p>Este método puede recibir opcionalmente LIMIT y OFFSET por parámetro.</p>

<ul>
<?php 
	$prestamos = Prestamo::all();  //limitado a 10 registros y ignomos los 3 primeros
	
	foreach ($prestamos as $prestamo)	
		echo "<li>$prestamo</li>";
?>
</ul>


<h2> Recupera prestamos con orden...</h2>
<p> Usamos el método estático <code>orderBy()</code>.</p>

<p> Los parámetros de este método son: campo, sentido, limit, offset.
Todos son opcionales (por defecto id, ASC, 0, 0)</p>
<p>Ruperaremos los tres ultimos prestamos oedenados por prestamo DESC.</p>

<ul>
<?php  
	$prestamos1 = Prestamo::orderBy('prestamo','DESC', 3);
	
	foreach ($prestamos1 as $prestamo1)	
		echo "<li>$prestamo1</li>";
?>
</ul>


<h2> Recupera una entidad por ID.</h2>
<p> Usamos el método estático <code>find()</code>.</p>

<p> Es obligatorio pasarle el identificador de la entidad a buscar</p>
<p>Ruperaremos el libro existente e intentaremos recuperar otro que no..</p>

<ul>
<?php 

	$pretamo = Prestamo::find(3);
	echo "<p>".($pretamo ?? 'NO EXISTE')."</p>";
	
	$pretamo = Prestamo::find(3303);
	echo "<p>".($pretamo ?? 'NO EXISTE')."</p>";
	
?>
</ul>



<h2> Recupera una entidad por ID o lanza NotFoundException</h2>
<p> Usamos el método estático <code>find()</code>.</p>

<p> Es obligatorio pasarle el identificador de la entidad a buscar</p>
<p>Ruperaremos el libro existente e intentaremos recuperar otro que no.. para evitar que el programa se detenga, trataremos la exception</p>

<ul>
<?php 
try{
	$pretamo = Prestamo::findOrFail(3);
	echo "<p>$pretamo</p>";
	
	$pretamo = Prestamo::find(1000);
	echo "<p>$pretamo</p>";
	
	
	$pretamo = Prestamo::find(2);
	echo "<p>$pretamo</p>";
	
	
}catch(NotFoundException $e){
	echo "<p>Se produjo una NotFoundException</p>";
	}
?>
</ul>

<h2> Recupera entidades aplicando filtor simple.</h2>
<p> Usamos el método estático <code>getFiltered()</code>.</p>

<p> Los parametros que se reecibe son: campo, valor, orden, sentido. Son todos opcionales pero lo normal es indicar al menos el campo y valor</p>

<p>Ruperaremos los ejemplares con id 4 y orden por prestado  ascendente</p>

<ul>
<?php 
try{
	$pretamos = Prestamo::getFiltered('idejemplar',4,'prestamo','ASC');
	$pretamos = Prestamo::getFiltered('idsocio','4','prestamo','DESC');
	foreach ($pretamos as $pretamo)
		echo "<li>$pretamo</li>";
	
	
}catch(NotFoundException $e){
	echo "<p>Se produjo una NotFoundException</p>";
	}
?>
</ul>

<h2> Recupera entidades aplicando lista de condiciones.</h2>
<p> Usamos el método estático <code>where()</code>.</p>

<p> Recibe un array asociativo con los pares de campo/valor.</p>

<p>Prestamos de Date que tienen en el titulo la palabra SQL</p>

<ul>
<?php 
try{
	$pretamos = Prestamo::where([
		'idejemplar'=> '2',
			'limite'=>'2022-01-06'
	]);
	
	foreach ($pretamos as $pretamo)
		echo "<li>$pretamo</li>";
	
	
}catch(NotFoundException $e){
	echo "<p>Se produjo una NotFoundException</p>";
	}
?>
</ul>

<h2>isNull().</h2>
<p> Usamos el método estático <code>isNull()</code>.</p>

<p>Ejemplo libros sin portada</p>

<ul>
<?php 

	$pretamos = Prestamo::isNull('incidencia');
	
	foreach ($pretamos as $pretamo)
		echo "<li>$pretamo->id <b>".($pretamo->incidencia ?? 'SIN INCIDENCIA')."</b>.</li>"
	
?>
</ul>


<h2>save().</h2>
<p> Usamos el método de objeto <code>save()</code>.</p>


<ul>
<?php 
	$pretamo = new Prestamo();  //crea un objeto Prestamo
	
	//Pone los valores  a las propiedades, (vendrian del un formulario)
	$pretamo->idsocio = 5;
	$pretamo->idejemplar = 20;
	$pretamo->prestamo = '2025-02-01 13:45:00';
	$pretamo->limite  = '2025-03-01';
	
	
	//https://fastlight-demo.robertsallent.com/test/model_create_update_delete#save
	$pretamo->save();
	echo "<p> Guardado correctamente con ID: $pretamo->id .</p>";
		
	//recupera el libro desde la bdd para comprobar que realmente lo guardó
	echo "<p><b>".Prestamo::find($pretamo->id)."</b></p>";
	
?>
</ul>