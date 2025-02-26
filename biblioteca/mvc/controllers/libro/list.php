<?php
//recupera la lista de libros mediante el modelo 
$libros = Libro::all();

//carga la vista que muestra el lista
require '../views/libro/lista.php';