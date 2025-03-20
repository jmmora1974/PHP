<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Visualización de un lugar - <?= APP_NAME ?></title>

<!-- META -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Ver lugares - <?= APP_NAME ?>">
<meta name="author" content="Jose Miguel Mora Perez">

<!-- FAVICON -->
<link rel="shortcut icon" href="/favicon.ico" type="image/png">

<!-- CSS -->
		<?= $template->css() ?>
	</head>
<body>
		<?= $template->login() ?>
		<?= $template->header('Detalles del lugar') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Lugares'=>'/Lugar',$lugar->name=>null]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
<<<<<<< HEAD
	<main>
		<h1>Detalles del lugar en <?=APP_NAME?></h1>
		<section id="detalles" class="flex-container gap2">
=======
		
	<main>
		<h1>Detalles del <?=$lugar->name?> lugar en <?=APP_NAME?></h1>
		<section id="detalles" class="flex-container gap2">
		<script src="/js/BigPicture.js"></script>
			<div class="centered w100 flex1 ">
			<figure class="w100 centrado p2" >
				<img src="<?=LUGAR_IMAGE_FOLDER.'/'.($lugar->mainpicture ?? DEFAULT_LUGAR_IMAGE)?>"
					 	class="cover enlarge-image" alt="Foto del lugar <?= $lugar->name?>">
									 					 		
				 <figcaption>Foto de  <?= $lugar->name?> </figcaption>
			</figure>
			</div>
>>>>>>> b641c60dc8de95b84b3e4e24f56fd938cd1e845a
			<div class="flex2 centered">
				<h2>Detalles del lugar <b><?=$lugar->name?></b></h2>
				<p>
					<b>Nombre del lugar:</b>  	<?= $lugar->name ?></p>
				<p>
					<b>Tipo:</b>  	<?= $lugar->type ?></p>
				<p>
					<b>Descripcion:</b>  	<?= $lugar->description ?></p>
				<p>
					<b>Localización:</b>  	<?= $lugar->location ?></p>
				<p>
					<b>Latitud:</b>  	<?= $lugar->latitude ?></p>
				<p>
					<b>Longitud:</b>  	<?= $lugar->longitude ?></p>
				<p>
<<<<<<< HEAD
					<b>Creador:</b>  	<?= $lugar->username ?></p>
				<p>
					<b>Fecha:</b>  	<?= $lugar->created_at ?></p>
				
				
			</div>
			<script src="/js/BigPicture.js"></script>
			
			<figure class="flex1 centrado p2">
				<img src="<?=LUGAR_IMAGE_FOLDER.'/'.($lugar->mainpicture ?? DEFAULT_LUGAR_IMAGE)?>"
					 	class="cover enlarge-image" alt="Foto del lugar <?= $lugar->name?>">
									 					 		
				 <figcaption>Foto de  <?= $lugar->name?> </figcaption>
			</figure>
=======
					<b>Creado por </b>  	<?= $lugar->username ?> el 	<?= $lugar->created_at ?></p>
				
				
			</div>
			<section id="seccomments " class="w100">
			<?php if($lugarcomments){ ?>
      			<h2 >Comentaris de <?=$lugar->name?></h2>
       			
				<?php foreach($lugarcomments as $comentario){   ?>
				<div class="comentario"><?=$comentario->text.' por '.$lugarcomments->username.' el '.$lugarcomments->created_at?>  
				 
							<a class="button" href='/lugar/edit/<?=$lugar->id?>'><img src="/images/icons/edit.png" alt="Editar" style="width:20px;height:20px;"></a>
							<?php  if( Login::user()->id == $lugar->iduser) {// autorización(solo propietario) ?>
								<a class="button-danger" href='/lugar/delete/<?=$lugar->id?>'><img src="/images/icons/delete.png" alt="Borrar" style="width:20px;height:20px;"></a>
							<?php } ?>
					</div>	
					<?php } ?>
					
			<?php } else { ?>
				<div class="danger p2">
					<p>No hay comentarios del sitio</p>
				</div>
				<?php } ?>
		</section>
>>>>>>> b641c60dc8de95b84b3e4e24f56fd938cd1e845a
		</section>
		
		
		<div class="centrado">
			<a class="button" onclick="history.back()">Atrás</a> 
					<a class="button" href="/Lugar/list">Lista de lugares</a> 
<<<<<<< HEAD
			
			
=======
					
>>>>>>> b641c60dc8de95b84b3e4e24f56fd938cd1e845a
		<!-- Solo el usuario propietario puede realizar las siguientes operaciones-->
		<?php  if( Login::user()->id == $lugar->iduser) {// autorización(solo propietario) ?>
				<a class="button" href="/Lugar/edit/<?=$lugar->id?>">Editar</a>
				
			<?php }?>
		</div>
<<<<<<< HEAD
	</main>
=======
		
		<section id="secphotos">
		
		
			<h3>Fotos de <?=$lugar->name?></h3>
				
				<div class="carrusel">

						<?php
						$archivos4x4 = [$lugar->mainpicture];
						//$archivos4x4 = FileList::get ( 'images/galeria/Rutas 4x4', '/\.(gif|jpe?g|png|webp)$/i' );
						foreach($fotocomments as $fotoco){
							
							$archivos4x4 []= $fotoco->file;
						}
						
						
						$f = 1; // contador de foto principal
						foreach ( $archivos4x4 as $arch4x4 ) {
							?>
								<div class="mySlides">
									<div class="numbertext"> <?= $f ?> / <?= count($archivos4x4) ?></div>
									<img src="<?= LUGAR_IMAGE_FOLDER.'/'.$arch4x4 ?>" style="width: 50vw"
										alt="Foto  <?= $arch4x4 ?>">
								</div>
						<?php $f++; }?>
				</div>
			
			<!-- Botones anterior y siguientes -->
				<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
				<a class="resume" onclick="plusSlides(1)">&#9654;</a> 
				<a class="pause" onclick="plusSlides(0)">&#9724;</a>
				<a class="next" onclick="plusSlides(1)">&#10095;</a>

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
						<img class="demo cursor" src="<?= LUGAR_IMAGE_FOLDER.'/'.$arch4x4 ?>" style="width: 100%"
							onclick="currentSlide(<?= $fm ?>)" alt="<?= 'Foto '.$fm ?>">
					</div>
				
				<?php $fm++ ?>  
			
					<?php }?>
				
			</div>
		</section>
		
	</main>
	<script src="/js/Carrousel.js"></script>
>>>>>>> b641c60dc8de95b84b3e4e24f56fd938cd1e845a
</body>

</html>