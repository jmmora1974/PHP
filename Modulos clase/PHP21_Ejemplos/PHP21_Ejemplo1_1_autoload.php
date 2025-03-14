<?php
include 'config/config.php';
include 'libraries/autoload.php';


//a partir de este pùnto no haran falta más includeo o requires


//Crea una moto
$moto = new Moto("Honda", "X2");
echo "<p>Se ha creado la moto $moto.</p>";

$moto->arrancar();

//Crea un coche
$coche = new Coche("Toyota", "Prius");
echo "<p>Se ha creado el coche $coche.</p>";

$coche->arrancar();
