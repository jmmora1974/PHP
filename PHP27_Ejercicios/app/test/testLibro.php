<h1>Probando los metodos de Model</h1>
<?php
require_once '../config/config.php';
require_once '../autoload.php';
?>

<h2> Recuperando todos los libros...</h2>
<p> Usamos el método estático <code>all()</code>.</p>
<p>Este método puede recibir opcionalmente LIMIT y OFFSET por parámetro.</p>

<ul>
<?php 
	$libros = Libro::all();
	
	foreach ($libros as $libro)	
		echo "<li>$libro</li>";
?>
</ul>


<h2> Recuperalibros con orden...</h2>
<p> Usamos el método estático <code>orderBy()</code>.</p>

<p> Los parámetros de este método son:; campo, sentido, limit, offset.
Todos son opcionales (por defecto id, ASC, 0, 0)</p>
<p>Ruperaremos los dos primeros libros oedenados por titulo ASC.</p>

<ul>
<?php 
	$libros = Libro::orderBy('titulo','ASC', 2);
	
	foreach ($libros as $libro)	
		echo "<li>$libro</li>";
?>
</ul>


<h2> Recupera una entidad por ID.</h2>
<p> Usamos el método estático <code>find()</code>.</p>

<p> Es obligatorio pasarle el identificador de la entidad a buscar</p>
<p>Ruperaremos el libro existente e intentaremos recuperar otro que no..</p>

<ul>
<?php 

	$libro = Libro::find(3);
	echo "<p>".($libro ?? 'NO EXISTE')."</p>";
	
	$libro = Libro::find(103);
	echo "<p>".($libro ?? 'NO EXISTE')."</p>";
	
?>
</ul>



<h2> Recupera una entidad por ID o lanza NotFoundException</h2>
<p> Usamos el método estático <code>find()</code>.</p>

<p> Es obligatorio pasarle el identificador de la entidad a buscar</p>
<p>Ruperaremos el libro existente e intentaremos recuperar otro que no.. para evitar que el programa se detenga, trataremos la exception</p>

<ul>
<?php 
try{
	$libro = Libro::findOrFail(3);
	echo "<p>$libro</p>";
	
	$libro = Libro::find(100);
	echo "<p>$libro</p>";
	
	
	$libro = Libro::find(2);
	echo "<p>$libro</p>";
	
	
}catch(NotFoundException $e){
	echo "<p>Se produjo una NotFoundException</p>";
	}
?>
</ul>

<h2> Recupera entidades aplicando filtor simple.</h2>
<p> Usamos el método estático <code>getFiltered()</code>.</p>

<p> Los parametros que se reecibe son: campo, valor, orden, sentido. Son todos opcionales pero lo normal es indicar al menos el campo y valor</p>

<p>Ruperaremos los libros de la editorial planeta, ordenados por titulo ascendente</p>

<ul>
<?php 
try{
	$libros = Libro::getFiltered('editorial','Planeta','titulo','ASC');
	
	foreach ($libros as $libro)
		echo "<li>$libro</li>";
	
	
}catch(NotFoundException $e){
	echo "<p>Se produjo una NotFoundException</p>";
	}
?>
</ul>

h2> Recupera entidades aplicando lista de condiciones.</h2>
<p> Usamos el método estático <code>where()</code>.</p>

<p> Recibe un array asociativo con los pares de campo/valor.</p>

<p>Libros de Date que tienen en el titulo la palabra SQL</p>

<ul>
<?php 
try{
	$libros = Libro::where([
		'autor'=> 'Date',
			'titulo'=>'SQL'
	]);
	
	foreach ($libros as $libro)
		echo "<li>$libro</li>";
	
	
}catch(NotFoundException $e){
	echo "<p>Se produjo una NotFoundException</p>";
	}
?>
</ul>