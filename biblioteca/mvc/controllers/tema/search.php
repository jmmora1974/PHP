<?php
require '../libraries/filtrado.php'; //función de saneamiento básico
//toma los valores que llegan del formulario de busqueda 
//se indican valores por defecto (que funcionen) por si no llegan
$campo = filtrado($_POST['campo'] ?? 'tema');
$valor = filtrado($_POST['valor'] ?? 'valor');
$orden = filtrado($_POST['orden'] ?? 'orden');
$sentido = $_POST['sentido'] ?? 'ASC';

// recupera los temas aplicando el filtro
$temas = Tema::getFiltered($campo, $valor, $orden,$sentido);

//carga la vista con el listado de temas
//(es la misma vista que para la operación listar)
require '../views/tema/lista.php';