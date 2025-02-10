<?php
include 'config/config.php';
include 'libraries/autoload.php';


//Preparacion de los parametros a pasarle a	la funcion mail()
$from = "JM@hotmail.com";
$name="Joselito";
$to  = "jmmora1974@gmail.com"; //receptor
$subject ="Test de envio mail local";
$message = "Esto es una prueba de mail por PHP.";

//Cabecra adicionales
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=uft-8\r\n";
$headers .= "To: <$to>\r\n";
$headers .="From: NO REPLY Jose M Mora (local) <jmmora1974@gmail.com";



//crea el nuevo mail
$email = new Email($to, $from, $name, $subject, $message, $headers);

//llamamos a la funcion mail con los parametros adecuaods
echo $email->send()? "ENVIADO" : "NO ENVIADO";
