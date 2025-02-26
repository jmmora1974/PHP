<?php
//recupera la lista de temas mediante el modelo 
$temas = Tema::all();

//carga la vista que muestra el lista
require '../views/tema/lista.php';