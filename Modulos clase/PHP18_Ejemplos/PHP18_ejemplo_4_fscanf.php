<?php
//abre el fichero para lectura
$fichero1 = fopen('datos/usuarios.dat','r');

//OPCION 1
//prepara la consulta
$consulta1 ="INSERT INTO usuarios(nombre, edad, telefono) VALUES ";
//va concatenando los valores que recupera del fichero
while (fscanf($fichero1,"%s\t%i\t%s\n", $n, $e, $t))
	$consulta1 .="('$n','$e','$t'),";

$consulta1=rtrim($consulta1,',');  //quita la ultima cosa
echo "<p> La consulta resultante en la opcion 1 es: </p>";
echo "<p><code>$consulta1</code>.</p>";

fclose($fichero1);  //cierra el fichero


	
//OPCION 2

//abre el fichero para lectura
$fichero2 = fopen('datos/usuarios.dat','r');
//prepara la consulta
$consulta2 ="INSERT INTO usuarios(nombre, edad, telefono) VALUES ";
//va concatenando los valores que recupera del fichero
while ($entrada2= fscanf($fichero2,"%s\t%i\t%s\n"))
	$consulta2 .="('".$entrada2[0]."',".$entrada2[1]."',".$entrada2[2]."'),";
	
	$consulta2=rtrim($consulta2,',');  //quita la ultima cosa
	echo "<p> La consulta resultante en la opcion 2 es: </p>";
	echo "<p><code>$consulta2</code>.</p>";

	fclose($fichero2);  //cierra el fichero
	