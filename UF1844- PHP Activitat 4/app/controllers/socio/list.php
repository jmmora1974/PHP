<?php
//recupera la lista de libros mediante el modelo
$socios = Socio::all();

//carga la vista que muestra el lista
require '../views/socio/lista.php';