<?php
include 'config/config.php';
include 'libraries/autoload.php';

//lista de direcciones dpara el mailing
//podrian haber sido sacadas de una base de datos
$direcciones =[
		'robert@prueba.com',
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
	try{
		 $email->send($direccion);  
		echo "<p>Enviado correctamente.</p> " ;
	//En caso de error...(luego seguira con la siguiente)
	} catch(EmailException $e){
		echo "<p>No se pudo enviar a $direccion.</p>";
	 }
}
		
