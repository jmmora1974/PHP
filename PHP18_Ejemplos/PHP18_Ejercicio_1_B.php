<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<meta name="keywords" content="HTML, CSS, JavaScript">
<meta name="description"
    content="PHP 18 Ejercicio 1">
    <meta name="author" content="Jose Miguel Mora Perez">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- frameworks predefinidos..-->
    <!-- estilo propio.-->
    <title>PHP 18 Ejercicio 1</title>
    <base href="./" target="_blank">
    <link rel="stylesheet" type="text/css" href="https://robertsallent.com/css/generic.css">
  <script src="js/Preview.js"></script>
    </head>
    
    <body>
        <?php
        
        $archivos = []; //Definimos la lista para la galeria
        
            //======================================================================
            // PROCESAR IMAGENES 
            //======================================================================
            // Comprobamos si nos llega los datos por POST
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Iteramos todos los archivos
            	foreach ($_FILES["imagen"]["error"] as $indice => $error) {
                    // Comprobamos si se ha subido correctamente
                    if ($error == UPLOAD_ERR_OK) {
                    	
                    	//Comprobaremos que el tamaño no sea superior a 500 kbytes...
                    	$tamano = $_FILES['imagen']['size'][$indice];
                    	
                    	if ($tamano > 500000)
                    		throw new Exception ("El fichero supera el tamaño permitido.");
                    		
                    		//recupera el nombre original del fichero
                    		$nombreFichero= $_FILES['imagen']['name'][$indice];
                    		$extension = pathinfo($nombreFichero, PATHINFO_EXTENSION);
                    		
                    		$nuevoNombre = uniqid('img_').'.'.$extension; //genera el nombre unico
                    		
                    		
                    		
                    		//recupera la ruta que se le asigna al fichero en la carpeta temporal
                    		$rutaTemporal  = $_FILES['imagen']['tmp_name'][$indice];
                    		//FORMA ORIENTADA A OBJETOS
                    		
                    		$tipoMime= (new finfo(FILEINFO_MIME_TYPE))->file($rutaTemporal);  // recupera el tipo MIME
                    		
                    		                    		
                    		// Comprobar si es de imagen (comienza por image/
                    		if( !preg_match("/^image/", $tipoMime) )
                    			throw new Exception ("El fichero no es de imagen");
                    			
                    			
                    		// Definir directorio donde se guardará
                    		$dir_subida = './galeria/';
                    		
                    		//ruta final donde ubucaremos el fichero, debe ser accesible
                    		$rutaFinal = "$dir_subida/$nuevoNombre";
                    		
                        
                        // Definir la ruta final del archivo
                       // $fichero_subido = $dir_subida . basename($_FILES['imagen']['name'][$posicion]); //para mantener el nombre original
                        // Mueve el archivo de la carpeta temporal a la ruta definida
                        if (move_uploaded_file($rutaTemporal, $rutaFinal)) {
                            // Mensaje de confirmación donde todo ha ido bien
                        	echo '<p>Se subió perfectamente' . $_FILES['imagen']['name'][$indice] .' como '.$rutaFinal . '.</p>';
                            // Muestra la imagen que acaba de ser subida
                            echo '<p><img width="500" src="' . $rutaFinal . '"></p>';
                            $archivos = FileList::get('galeria', '/\.(gif|jpe?g|png)$/i');
                        } else {
                            // Mensaje de error: ¿Límite de tamaño? ¿Ataque?
                            echo '<p>¡Ups! Algo ha pasado.</p>';
                        }
                    }
                }
            }
        ?>
        <h1>PHP 18 Ejercicio 1 (segunda opcion B)- Subir fotos a la galeriad.</h1>
    <h2> SUBIDA DE IMAGENES </h2>
        <!-- Formulario -->
        <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <p>
                <!-- Campos de imágenes -->
                <input type="file" accept="image/*" multiple name="imagen[]">
                
            </p>
            <p>
                <!-- Botón submit -->
                <input type="submit" value="Enviar">
            </p>
        </form>
        <h1 class="centered">Galeria </h1>
    	
    	<section class="gallery w75 centered-block my2">
    	<?php 
    	include 'libraries/FileList.php'; //carga la libreria
    	
    	// Usaremos el metodo estatico FileList::get()
    	// primer parametros: directorio (opcional, por defecto la carpeta actual)
    	//segundo parametro : expresion regular o lista de extensiones (opcional)
    	$archivos = FileList::get('galeria', '/\.(gif|jpe?g|png)$/i');
    	
    	// con una lista de extensiones queda más sencillo:
    	//$archivos = FileList::get('imagenes', ['gif','jpg', 'jprg', 'png'];
    	
    	// genera las figuras de la galeria
    	foreach($archivos as $archivo){  //genera las figuras
    		?>
	 		<figure class="small card">
	 			<img src='<?= "$archivo" ?>'>
	 			<figcaption><?= "$archivo" ?></figcaption>
	 		</figure>
    	<?php } ?>
    	</section>
    </body>
</html>
