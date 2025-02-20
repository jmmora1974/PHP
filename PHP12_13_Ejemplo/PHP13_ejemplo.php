<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<meta name="keywords" content="HTML, CSS, JavaScript">
<meta name="description"
    content="PHP 13 Ejemplo  ">
    <meta name="author" content="Jose Miguel Mora Perez">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://robertsallent.com/css/generic.css">
    <!-- frameworks predefinidos..-->
    <!-- estilo propio.-->
    <title>PHP 13 Ejemplo</title>
    <base href="./" target="_blank">
    
    </head>
    
    <body>
    <h1>PHP 13 Ejemplo Circulo</h1>
    <p>Pruebas unitarias de los distintos metodos de Circulo.</p>
    
    <?php
    require_once 'classes/Punto.php';
    require_once 'classes/Circulo.php';
    ?> 
    
    <h2>Pruebas de construccion</h2>
    <?php  
        $punto1=new Punto(2,3);
        $circulo1 = new Circulo($punto1,5);
        
        echo " $punto1 <br>";
        echo " $circulo1 <br>";//Imprime CIRCULO (2,3) radio: 5
     
     ?> 

	<h3> Pruebas de metodo mover</h3>
	<?php
	$circulo1->mover(10,20)->mover(5)->mover();
	echo "$circulo1 <br>"; //imprime CIRCULO /17,23) radio: 5
	?>

</body>


</html>