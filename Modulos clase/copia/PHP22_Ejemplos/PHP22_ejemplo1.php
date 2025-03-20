<?php
//Preparacion de los parametros a pasarle a	la funcion mail()
$to  = "jmmora1974@gmail.com"; //receptor
$subject ="Test de envio mail local";
$message = "Esto es una prueba de mail por PHP.";

//Cabecra adicionales
$headers = "To: <$to>\r\n";
$headers .="From: Jose M Mora (local) <jmmora1974@gmail.com";

//llamamos a la funcion mail con los parametros adecuaods
echo mail($to, $subject, $message, $headers)? "ENVIADO" : "NO ENVIADO";