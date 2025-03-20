<?php
//toma los valores que llegan del formulario de busqueda 
//se indican valores por defecto (que funcionen) por si no llegan
$campo = $_POST['campo'] ?? 'titulo';
$valor = $_POST['valor'] ?? 'valor';
$orden = $_POST['orden'] ?? 'orden';
$sentido = $_POST['sentido'] ?? 'sentido';

// recupera los libros aplicando el filtro
$libros = Libro::getFiltered($campo, $valor, $orden,$sentido);

//carga la vista con el listado de libros
//(es la misma vista que para la operación listar)
require '../views/libro/lista.php';