<?php
// recupera el ID
$id=intval($_GET['id']);

//recupera el libro a partir del ID.
$libro=Libro::findOrFail($id,'No se encontró el libro');

//carga la vista con el formulario de confirmación de borrado
require '../views/libro/borrar.php';
	