<?php
//recupera el socio a partir del ID.
// si no llega el ID o si no se encuentra el socio, lanza expcepciones
$socio = Socio::findOrFail(intval($_GET['id']), 'No se encontró el socio');

//carga el formulario de edición
require '../views/socio/actualizar.php';