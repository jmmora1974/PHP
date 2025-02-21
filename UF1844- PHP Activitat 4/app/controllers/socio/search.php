<?php
//toma los valores que llegan del formulario de busqueda 
//se indican valores por defecto (que funcionen) por si no llegan
$campo = $_POST['campo'] ?? 'nombre';
$valor = $_POST['valor'] ?? '';
$orden = $_POST['orden'] ?? 'nombre';
$sentido = $_POST['sentido'] ?? 'ASC';

// recupera los libros aplicando el filtro
$socios = Socio::getFiltered($campo, $valor, $orden,$sentido);

//carga la vista con el listado de libros
//(es la misma vista que para la operación listar)
require '../views/socio/lista.php';