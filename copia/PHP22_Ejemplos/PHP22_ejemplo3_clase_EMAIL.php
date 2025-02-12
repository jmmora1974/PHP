<?php
include 'config/config.php';
include 'libraries/autoload.php';

try{
//Preparacion de los parametros a pasarle a	la funcion mail()
$to  = "jmmora1974@gmail.com"; //receptor
$from = "JM@hotmail.com";
$name="Joselito";
$subject ="Test de envio mail local";
$message = "Esto es una prueba de mail por PHP.";


//crea el nuevo mail y lo envia
$email = new Email($to, $from, $name, $subject, $message);
$email-> send();
echo "ENVIADO";

//En caso de error de envío de email..
}catch (EmailException $e) {
	echo "NO ENVIADO: ".$e->getMessage();
}


/*   Otra opcion si el  try catch
//llamamos a la funcion mail con los parametros adecuaods
echo $email->send()? "ENVIADO" : "NO ENVIADO";  
*/
