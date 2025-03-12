<?php
//funcion para filtrar los datos.
function filtrado($datos){
	
	$palabrasprohibidas = array('script', '<?', 'admin'); // Lista de palabras no autorizadas
	if ($datos){
		
		if(intval($datos) == $datos){
				$datos = intval($datos);
			//	echo "Ha entrado un int : $datos";
		}
		$datos= str_replace($palabrasprohibidas, ' ', $datos);
		$datos = trim($datos); // Elimina espacios antes y después de los datos
		$datos = stripslashes($datos); // Elimina backslashes \
		$datos = htmlspecialchars($datos); // Traduce caracteres especiales en entidades HTML
	}
	
	return $datos;
}
?>