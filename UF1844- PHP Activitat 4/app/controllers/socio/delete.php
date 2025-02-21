<?php
// recupera el ID
$id=intval($_GET['id']);

//recupera el socio a partir del ID.
$socio=Socio::findOrFail($id,'No se encontró el socio');

//carga la vista con el formulario de confirmación de borrado
require '../views/socio/borrar.php';
