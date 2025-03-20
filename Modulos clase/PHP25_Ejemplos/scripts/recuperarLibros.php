<?php

//lanza la consulta
$resultado = $conexion->query("SELECT * FROM libros");

//prepara una lista de libros
$libros =[];

//convierte cada fila del resultado en un objeto Libro...
while($libro=$resultado->fetch_object('Libro')){
	$libros[]=$libro;  //Lo añade a la lista
}

$resultado -> free();  //libera memoria

//hemos convertido el resultado de la consulta en una lista de libros.

//echo implode ('',$libros);  // para probar...