<?php
include '../config/config.php';
include '../autoload.php';

//Pruebas de select()

echo "<h2>Recuperando el socio 5...</h2>";
echo "<pre>";
var_dump(DBMysqli::select("SELECT * FROM socios WHERE id=5"));
echo "</pre>";

echo "<h2>Recuperando el socio 50000  .. no exxiste...</h2>";
echo "<pre>";
var_dump(DBMysqli::select("SELECT * FROM socios WHERE id=5000"));
echo "</pre>";

//pruebas de selectAll()
echo "<h2>Recuperandolos temas</h2>";
echo "<pre>";
var_dump(DBMysqli::selectAll("SELECT * FROM socios temas"));
echo "</pre>";

echo "<h2>Recuperando libros de Stephen King (no hay)</h2>";
echo "<pre>";
var_dump(DBMysqli::select("SELECT * FROM libros WHERE autor='Stephen King'"));
echo "</pre>";

//pruebas de Inserrt()
echo "<h2>Guardando un tema/h2>";

$consulta1 = "INSERT INTO temas(tema, descripcion)
			VALUES ('Viajes','Viaje con nosotros si quiere jugar')";

$id = DBMysqli::insert($consulta1);

echo "<p> El ID del nuevo tema es $id</p>";

// prueba de updaate()
echo "<h2> Actualizando un tema</h2>";

$consulta2 = "UPDATE temas SET tema='Test de Tema' WHERE id=10";
$filas = DBMysqli::update($consulta2);

echo "<p> Filas afectas $filas</p>";

//comprobacion de que se ha actualizado corectamentee
echo "<pre>";
var_dump(DBMysqli::select("SELECT * FROM temas WHERE id=10"));
echo "</pre>";


//prueba de delete()
echo "<h2>Borrando un tema>/p>";

$filas = DBMysqli::delete("DELETE FROM temas WHERE id=5");
echo "<p> Filas afectas $filas</p>";


//comprobacion de que se ha borrado corectamentee
echo "<pre>";
var_dump(DBMysqli::select("SELECT * FROM temas WHERE id=5"));
echo "</pre>";


//pruebas totales
echo "<h2>Totales..</h2>";

echo "<p>Total de socios: ".DBMysqli::total('socios')."</p>";
echo "<p>Fecha de alta del ultimo socio: ".DBMysqli::total('socios','MAX'.'alta')."</p>";
echo "<p>Nacimiento del socio mayor: ".DBMysqli::total('socios','MIN'.'nacimiento')."</p>";
echo "<p>Precio medio de ejemplares: ".DBMysqli::total('ejemplares','AVG'.'precio')."</p>";
