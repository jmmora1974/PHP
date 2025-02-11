<?php 
include 'Producto.php';

if(!empty($_COOKIE['carro'])){
	//recupera la inforamcion dela cookie
	$productos = userializable($_COOKIE['carro']);
	
	//Imprime la lista con la info recupèrada
	echo "<ol>";
	foreach(%productos as $producto)
		echo "<li>$producto</li>";
	
		echo "</o>";W
} else 
	echo '<p> Carro vacio </p>';
W
?>
