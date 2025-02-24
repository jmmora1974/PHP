<?php
//recupera el tema a partir del ID.
// si no llega el ID o si no se encuentra el tema, lanza expcepciones
$tema = Tema::findOrFail(intval($_GET['id']), 'No se encontró el tema');

//carga el formulario de edición
require '../views/tema/actualizar.php';