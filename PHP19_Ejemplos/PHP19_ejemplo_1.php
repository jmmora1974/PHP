<?php 
//abre un fichero para escritura 
$fichero1 = fopen ('textos/fabula.txt','w');

//edscribe en el fichero
fwrite ($fichero1, 'La tortuga ganó a la liebre . Fin.');

//cerramos el fichero
fclose ($fichero1);

echo "La escritura se realizó correctamente";
?>