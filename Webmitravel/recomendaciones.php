<?php require 'templates/template.php' ?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="keywords" content="HTML, CSS, JavaScript">
	<meta name="description"
		content="Web de busqueda de aventuras, eventos, actividades, que hacer, what to do, planificador de actividades, agenda.">
	<meta name="author" content="Jose Miguel Mora Perez">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- frameworks predefinidos..-->
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<!-- estilo propio.-->
	<link rel="stylesheet" href="./css/estilo.css">
	<title>Mitravel</title>
	<link rel="icon" type="image/x-icon" href="./images/favicon.ico">
	<base href="./" target="_blank">
</head>

<body>
	
<?php
		cabecera('&#9807;Mitravel','Planifica tus aventuras');
		menu('recomendaciones');
	?>
		
	<main>

		<div class="principal" id="principal">

			<div class="superior">
				<h3>Excursiones 4x4</h3>
				<label>Escapada relajada y divertida en 4x4. Circuidos adaptados a las necesidades. </label>
				<div class="carrusel">

					<!-- Full-width images with number text -->
					<div class="mySlides">
						<div class="numbertext">1 / 6</div>
						<img src="images/foto1.jpg" style="width:100%" alt="foto 1">
					</div>

					<div class="mySlides">
						<div class="numbertext">2 / 6</div>
						<img src="images/foto2.jpg" style="width:100%" alt="foto 2">
					</div>

					<div class="mySlides">
						<div class="numbertext">3 / 6</div>
						<img src="images/foto3.jpg" style="width:100%" alt="foto 3">
					</div>

					<div class="mySlides">
						<div class="numbertext">4 / 6</div>
						<img src="images/foto4.jpg" style="width:100%" alt="foto 4">
					</div>

					<div class="mySlides">
						<div class="numbertext">5 / 6</div>
						<img src="images/foto5.jpg" style="width:100%" alt="foto 5">
					</div>

					<div class="mySlides">
						<div class="numbertext">6 / 6</div>
						<img src="images/foto6.jpg" style="width:100%" alt="foto 6">
					</div>
					

					<!-- Next and previous buttons -->
					<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
					<a class="next" onclick="plusSlides(1)">&#10095;</a>

					<!-- Image text -->
					<div class="caption-container">
						<p id="caption"></p>
					</div>

					<!-- Thumbnail images -->
					<div class="row">
						<div class="column">
							<img class="demo cursor" src="images/foto1.jpg" style="width:100%" onclick="currentSlide(1)"
								alt="Foto 1">
						</div>
						<div class="column">
							<img class="demo cursor" src="images/foto2.jpg" style="width:100%" onclick="currentSlide(2)"
								alt="Foto 2">
						</div>
						<div class="column">
							<img class="demo cursor" src="images/foto3.jpg" style="width:100%" onclick="currentSlide(3)"
								alt="Foto 3">
						</div>
						<div class="column">
							<img class="demo cursor" src="images/foto4.jpg" style="width:100%" onclick="currentSlide(4)"
								alt="Foto 4">
						</div>
						<div class="column">
							<img class="demo cursor" src="images/foto5.jpg" style="width:100%" onclick="currentSlide(5)"
								alt="Foto 5">
						</div>
						<div class="column">
							<img class="demo cursor" src="images/foto6.jpg" style="width:100%" onclick="currentSlide(6)"
								alt="Foto 6">
						</div>
					</div>

				</div>

				<h3> Circuitos nocturnos</h3>
				<label>Puedes disfrutar del apasionado y divertido circuito noctuno. Sensaciones nunca vividas...Lo disfrutaras. </label>
				<p> Simulacion mapa web . 
					
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc eget lectus vel neque luctus volutpat
					in nec est. Donec ultrices imperdiet purus, vel interdum nibh tempus ac. Interdum et malesuada fames ac
					ante ipsum primis in faucibus. Ut maximus auctor erat, pellentesque aliquet nulla elementum sed. Suspendisse
					non vulputate libero. Vivamus vel rutrum nulla, at viverra lectus. Aliquam condimentum fermentum
					sodales. </p>
					
				<video id="video1" src="videos/video1.mp4" controls autoplay>Tu navegador no es compatible con este
					video.</video>
					<p>Nunc sit amet neque ac augue pulvinar feugiat. Nullam pretium vel magna et iaculis. Pellentesque ac lorem sit
						amet  lorem consectetur vehicula nec a ipsum. Quisque non eros fringilla, iaculis ligula ac, dapibus
						magna. Duis vel dignissim ante, sed molestie tellus. Integer vulputate turpis a bibendum pellentesque.</p>
				
						<iframe  id="video2" width="600vw" height="400vh" src="https://www.youtube.com/embed/-FHJTZEMiwI" title="Conducción 4X4 por las DUNAS y acampada en mitad del DESIERTO 🔥" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>

						</iframe>
			</div>

			<div class="inferior">
				<?php chatservice();?>

			</div>
			 
			
			<div class="clearfix"></div>
		</div>
			<?php mapaweb();?>
	</main>
		<?php piedepagina();?>

	<script src="./js/mitravelreco.js"></script>
	<script src="./js/chatservice.js"></script>

</body>

</html>