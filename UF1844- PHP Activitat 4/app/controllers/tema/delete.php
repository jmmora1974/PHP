<?php
// recupera el ID
$id=intval($_GET['id']);

//recupera el tema a partir del ID.
$tema=Tema::findOrFail($id,'No se encontró el tema');

//carga la vista con el formulario de confirmación de borrado
require '../views/tema/borrar.php';
	