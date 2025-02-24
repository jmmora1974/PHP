<?php require 'templates/template.php' ?>
<!DOCTYPE html>
<html lang="es">
<?php head();?>
<script src="js/galeria.js"></script>
<body>
	
<?php
try{
cabecera ( '&#9807;Mitravel', 'Planifica tus aventuras' );
menu ( 'recomendaciones' );
migas ( [
		"Inicio" => "index.php",
		"Recomendaciones" => "recomendaciones.php"
] );

if(empty($_COOKIE['consentimiento']))
	aceptarCookies();
?>
		
	<main>
		<h1>Recomendaciones</h1>
			
				
    	<?php
					include 'libraries/FileList.php'; // carga la libreria

					// recupera la lista de ficheros del directorio y
					// retorna directamente como array
					$carpActividades = scandir ( "images/galeria" );

					// quita el . t el ..
					array_splice ( $carpActividades, array_search ( ".", $carpActividades ), 1 );
					array_splice ( $carpActividades, array_search ( "..", $carpActividades ), 1 );

					sort ( $carpActividades ); // ordena el array
					?>
				<h2>SUBIDA DE IMAGENES</h2>
		<p>Puedes compartir tus actividades para que otros mitraveleros puedan
			conocer. Gracias por tu aportación.</p>
		<form method="POST" enctype="multipart/form-data"
			action="libraries/upload_reco.php">
			<label>Actividad:</label> <input type="text"  name="actividad" list="listaActividades">
			<datalist id="listaActividades" required>
						<?php
						foreach ( $carpActividades as $capActividad ) {
							?> 
							<option value="<?=$capActividad?>">
							<?php } ?>
					   			
			</datalist>	<br> 
			<label>Ciudad:</label>
				 <input type="text" name="ciudad" required><br> 
			 <label>Descripcion:</label>
				 <textarea id="descfoto" name="descfoto" rows="2" cols="30"></textarea> <br>
			<label> Sube tus imagenes a la galeria: </label> <br> 
				<input type="hidden" name="MAX_FILE_SIZE" value="500000"> <input type="file"
				accept="image/*" accept=".jpg, .jpeg, .gif, .png, .jfif" 
				name="fichero" required> <br>
			
			
			<?= isset($_COOKIE['isLogged']) ?
				 '<input type="submit" value="Enviar">	<br>':'<p>Solo para usuarios registrados!</p>'; 		
			
			?>
			 		
			
		</form>


		<h1 class="centered">Galeria</h1>

	
				<?php
				// Lista de fiicheros que hemos encontrado
				foreach ( $carpActividades as $capActividad ) {
					// Imprimos el titulo de la actividad.
					echo "<h1 class='centered'>$capActividad</h1>";
					?>
				<section id="galeria" class="gallery w75 centered-block my2">
					
				<?php

					// Usaremos el metodo estatico FileList::get()
					// primer parametros: directorio (opcional, por defecto la carpeta actual)
					// segundo parametro : expresion regular o lista de extensiones (opcional)
					$archivos = FileList::get ( 'images/galeria/' . $capActividad, '/\.(gif|jpe?g|png|webp|jfif)$/i' );

					// con una lista de extensiones queda más sencillo:
					// $archivos = FileList::get('imagenes', ['gif','jpg', 'jprg', 'png'];

					// genera las figuras de la galeria
					foreach ( $archivos as $archivo ) { // genera las figuras
						?>
	    			
		 				<figure class="small card">
				<img src='<?= "$archivo" ?>'>
				<figcaption><?= "$archivo" ?></figcaption>
			</figure>
		 	    	<?php } ?>
		 	    		</section>
    				<?php } ?>
    				
    	<div class="principal" id="principal">

			<div class="superior">




				<h3>Excursiones 4x4</h3>
				<label>Escapada relajada y divertida en 4x4. Circuidos adaptados a
					las necesidades. </label>
				<div class="carrusel">

						<?php
						$archivos4x4 = FileList::get ( 'images/galeria/Rutas 4x4', '/\.(gif|jpe?g|png|webp)$/i' );
						$f = 1; // contador de foto principal
						foreach ( $archivos4x4 as $arch4x4 ) {
							?>
								<div class="mySlides">
									<div class="numbertext"> <?= $f ?> / <?= count($archivos4x4) ?></div>
									<img src="<?= $arch4x4 ?>" style="width: 100%"
										alt="<?= $arch4x4 ?>">
								</div>
						<?php $f++; }?>
				</div>
			
			<!-- Botones anterior y siguientes -->
				<a class="prev" onclick="plusSlides(-1)">&#10094;</a> <a
					class="next" onclick="plusSlides(1)">&#10095;</a>

				<!-- Image text -->
				<div class="caption-container">
					<p id="caption"></p>
				</div>

				<!-- Thumbnail images -->
				<div class="row">
			<?php
			$fm = 1; // contador de foto principal
			foreach ( $archivos4x4 as $arch4x4 ) {
				?>
					<div class="column">
						<img class="demo cursor" src="<?= $arch4x4 ?>" style="width: 100%"
							onclick="currentSlide(<?= $fm ?>)" alt="<?= 'Foto '.$fm ?>">
					</div>
				
				<?php $fm++ ?>  
			
					<?php }?>
				
			</div>

			</div>

			<h3>Circuitos nocturnos</h3>
			<label>Puedes disfrutar del apasionado y divertido circuito noctuno.
				Sensaciones nunca vividas...Lo disfrutaras. </label>
			<p>Simulacion mapa web . Lorem ipsum dolor sit amet, consectetur
				adipiscing elit. Nunc eget lectus vel neque luctus volutpat in nec
				est. Donec ultrices imperdiet purus, vel interdum nibh tempus ac.
				Interdum et malesuada fames ac ante ipsum primis in faucibus. Ut
				maximus auctor erat, pellentesque aliquet nulla elementum sed.
				Suspendisse non vulputate libero. Vivamus vel rutrum nulla, at
				viverra lectus. Aliquam condimentum fermentum sodales.</p>

			<video id="video1" src="videos/video1.mp4" controls autoplay>Tu
				navegador no es compatible con este video.
			</video>
			<p>Nunc sit amet neque ac augue pulvinar feugiat. Nullam pretium vel
				magna et iaculis. Pellentesque ac lorem sit amet lorem consectetur
				vehicula nec a ipsum. Quisque non eros fringilla, iaculis ligula ac,
				dapibus magna. Duis vel dignissim ante, sed molestie tellus. Integer
				vulputate turpis a bibendum pellentesque.</p>

			<iframe id="video2" width="600vw" height="400vh"
				src="https://www.youtube.com/embed/-FHJTZEMiwI"
				title="Conducción 4X4 por las DUNAS y acampada en mitad del DESIERTO 🔥"
				frameborder="0"
				allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
				referrerpolicy="strict-origin-when-cross-origin" allowfullscreen> </iframe>
		</div>



		<div class="clearfix"></div>
		</div>
		<?php } catch (Exception $e) {
	 		error_log($e->getMessage(). PHP_EOL, 3, "errores.log");
	 	}?>
			<?php mapaweb();?>
	</main>
	<?php piedepagina ('Jose Miguel Mora Perez')?>

	<script src="./js/mitravelreco.js"></script>
	<script src="./js/chatservice.js"></script>

</body>

</html>