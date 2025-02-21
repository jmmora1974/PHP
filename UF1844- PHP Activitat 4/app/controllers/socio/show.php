<?php


//Recupera el socio a partir del ID.
// si no llega ID o si no se envuentra lanza una excepcion
$socio = Socio::findOrFail(intval($_GET['id']),'No se envontró el socio');


// carga la vista de detealles del socio
require '../views/socio/detalles.php';