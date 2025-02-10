<?php
include 'config/config.php';
include 'libraries/autoload.php';

//lista de direcciones dpara el mailing
//podrian haber sido sacadas de una base de datos
$direcciones =[
		'robert@juegayestudia.com',
		'jmmora1974@gmail.com',
		'pepito@hotmail.com'
];

//Creamos un mensaje sin indicar receptor
$email = new Email(
		'',  //Receptor en blanco de momento
		'promocionesJM@josemi.com',			//emisor del mensaje
		'Tu tienda amiga',					//nombre dek emiso
		'Promociones Febrero',			  	//asunto
		'Este mes esta de oferta todo.'   	//mensaje
		);

//para cada entrada de la lista de direcciones
foreach ($direcciones as $direccion){
	//envia el mail a cada una de ellas
	echo $email->send($direccion) ? 
			"<p>Enviado correctamente.</p> " : 
			"<p>No se pudo enviar a $direccion.</p>";
}
		
