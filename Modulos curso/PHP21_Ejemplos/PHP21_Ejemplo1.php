<?php
//carga los ficheros de las clases
require_once 'models/Vehiculo.php';
require_once 'models/Coche.php';
require_once 'models/Moto.php';

//Crea una moto
$moto = new Moto("Honda", "X2");
echo "<p>Se ha creado la moto $moto.</p>";

$moto->arrancar();

//Crea un coche
$coche = new Coche("Toyota", "Prius");
echo "<p>Se ha creado el coche $coche.</p>";

$coche->arracnar();
