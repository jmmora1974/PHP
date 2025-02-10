<?php
//Preparacion de los parametros a pasarle a	la funcion mail()
$to  = "jmmora1974@gmail.com"; //receptor
$subject ="Test de envio mail local";
$message = "Esto es una prueba de mail por PHP.";

//Cabecra adicionales
$headers = "MIME-Version: 1.0\r\n";  
$headers .= "Content-type: text/html; charset=uft-8\r\n";
$headers .= "To: <$to>\r\n";
$headers .="From: NO REPLY Jose M Mora (local) <jmmora1974@gmail.com";



//mensaje 	en HTML (uso sintaxuis HEREDOC 	que es mas sencilla para  esto)
$message='<HTML lang="es">
	<head>
		<title> Test de envio de mail </title>
	</head>
	<body>
	 	<h3> Test </h3>
	 	<p> Hola mundo!!</p>
	 	<img src="https://media.istockphoto.com/id/153222234/es/foto/otay-lakes-sunrise.jpg?s=2048x2048&w=is&k=20&c=O3xPi34PsEvsr4aIKk10g1J0W6twGdazUCjFBT_rh6g=" >
	 	<a href="https://mitravel.atwebpages.com/index.html">Click me </a>
	 </body>
	 
</html>';

//llamamos a la funcion mail con los parametros adecuaods
echo mail($to, $subject, $message, $headers)? "ENVIADO" : "NO ENVIADO";