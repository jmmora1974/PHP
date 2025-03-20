<?php
//recupera el libro a partir del ID.
// si no llega el ID o si no se encuentra el libro, lanza expcepciones
$libro = Libro::findOrFail(intval($_GET['id']), 'No se encontró el libro');

//carga el formulario de edición
require '../views/libro/actualizar.php';