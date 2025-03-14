<?php
//Este fichero es el que tenemos que probar 
//carga todos los recursos necesarios, conecta, recupera los libros
//haciendo uso del script y carga la vista q mostrara elñ libro

//carga la configuracion y el autoload
include 'config/config.php';
include 'libraries/autoload.php';

//ejecuta los scripts de conectar y recuperar libros
include 'scripts/conectar.php';
include 'scripts/recuperarLibros.php';

//carga la vista de listado
include 'views/booklist.php';
//include 'view/booktable.php'; 