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
		
	<main>
		<h1>Detalles del <?=$lugar->name?> lugar en <?=APP_NAME?></h1>
		<section id="detalles" class="flex-container gap2">
		<script src="/js/BigPicture.js"></script>
			<div class="centered w100 flex4 ">
			<figure class="w100 centrado p2" >
				<img src="<?=LUGAR_IMAGE_FOLDER.'/'.($lugar->mainpicture ?? DEFAULT_LUGAR_IMAGE)?>"
					 	class=" enlarge-image" alt="Foto del lugar <?= $lugar->name?>">
									 					 		
				 <figcaption>Foto de  <?= $lugar->name?> </figcaption>
			</figure>
			
			</div>
			<section class="flex2 centered" id="seccomentarios">
				<h2><b><?=$lugar->name?></b></h2>
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
				<p class="mini">
					<b>Creado por </b>  	<?= $lugar->username ?> el 	<?= $lugar->created_at ?></p>
				<?php  if( Login::user()->id == $lugar->iduser || 
										Login::oneRole(['ROLE_ADMIN','ROLE_MODERADOR']))  {
											// autorización(solo propietario o administradores)	?>
												<a class="button-danger" href="/lugar/delete/<?= $lugar->id?>">
													<img src="/images/icons/eliminar.jpg" alt="Eliminar" style="width:20px;height:20px;"></a>
										<?php }?>	
<iframe class="mapa"  src="https://maps.google.com/maps?q=<?=$lugar->location?>&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
			</section >
			<h2 class="centered w100">Comentarios de <?=$lugar->name?></h2>
			<form method="POST" enctype="multipart/form-data"  action="/comentario/store" class="w75" >
					<input type="hidden" name="iduser" value="<?= user()->id ?>">
					<input type="hidden" name="idplace" value="<?= $lugar->id ?>">
					<input type="hidden" name="retorno" value="#seccomentarios">
					
					<input type="text" name="text" min-lenght="1" class="w50" placeholder="Escriba su comentario (solo usuarios registrados)"  required>
					
					<?php  if( Login::user()->id ){ ?>
						<input type="submit" class="button" name="nuevocomentario" 
								value="Añadir comentario"  <?= user()->id ??'disabled'?> >
						<?php } else { ?>
							<label class="small">Solo usuarios registrados.</label>
							<?php } ?>
				</form>
			<section  class="flex-container w100">
			
				
			<?php if($lugarcomments){ ?>
      			
       		 <div id="comentarioslugar" class="flex2 w100 m0 p0" >
				<?php foreach($lugarcomments as $comentario){   ?>
				<div class="comentario centered   w100 m0 p0 flex2">
					<figure class="p0">
						
						<img src="<?=USER_IMAGE_FOLDER.'/'.($comentario->userpicture ?? DEFAULT_USER_IMAGE)?>"
							 class="icon-image enlarge-image" alt="Foto del lugar <?= $comentario->name?>">
						
					</figure>
					
					<p>	<?=$comentario->username.' ---> <b>'.$comentario->text ?></b></p>
					
					<div class="derecha">
					<label class="mini p0 inline"> Creado el <?= $comentario->created_at?></label>
							<?php  if( Login::user()->id == $comentario->iduser || 
										Login::oneRole(['ROLE_ADMIN','ROLE_MODERADOR']))  {
											// autorización(solo propietario o administradores)	?>
									<a class="button-danger" onclick="confirmar('borrar',<?=$comentario->id?>,'seccomentarios')">
									<img src="/images/icons/delete.png" alt="Borrar" style="width:20px;height:20px;"></a>								
								<?php } 
								
								if(Login::oneRole(['ROLE_ADMIN','ROLE_MODERADOR'])) { ?>
									<a class="button" onclick="confirmar('bloquear',<?= $comentario->iduser ?>,<?=$this->url?>)">
									   <img src="/images/icons/blocked.jpg" alt="Bloquear" style="width:20px;height:20px;"></a>
								
								<?php } ?>
						
					</div>	
							</div>
					<?php } ?>
							</div>
			<?php } else { ?>
				<div class="danger p2">
					<p>No hay comentarios del sitio</p>
				</div>
				<?php } ?>
		</section>
		</section>
		
		
		<div class="centrado">
			<a class="button" onclick="history.back()">Atrás</a> 
					<a class="button" href="/Lugar/list">Lista de lugares</a> 
					
		<!-- Solo el usuario propietario puede realizar las siguientes operaciones-->
		<?php  if( Login::user()->id == $lugar->iduser || Login::oneRole(['ROLE_ADMIN','ROLE_MODERADOR'])) {// autorización(solo propietario) ?>
				<a class="button" href="/Lugar/edit/<?=$lugar->id?>">Editar</a>
				
			<?php }?>
		</div>
		
		<section id="secphotos">
				<h3 class="centered">Fotos de <?=$lugar->name?></h3>
			<section id="seccarrousel" >
								
				<div  >
					
				<?php						
					//$archivosfoto = FileList::get ( 'images/galeria/Rutas foto', '/\.(gif|jpe?g|png|webp)$/i' );
				 if($fotoslugar){ 
						$f = 1; // contador de foto principal
						$listaidsfotos=[]; //Creamos una lista o para conservar los datos de la foto
						foreach ( $fotoslugar as $archfoto ) {
							$listaidsfotos.=intval($archfoto->id);
							?>
								<div class="mySlides  flex-container gap2">
										<div class="flex2">
										<figure>
										<img class="enlarge-image" 
											src="<?= LUGAR_IMAGE_FOLDER.'/'.$archfoto->file ?>" 
											alt="<?=$archfoto->alt?>" title="<?=$archfoto->alt?>">
											
										<figcaption>
										
											<!-- Botones anterior y siguientes -->
											 <div class="centrado m1">
												<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
												<a class="resume" onclick="plusSlides(999999)">&#9654;</a> 
												<a class="pause" onclick="plusSlides(0)">&#9724;</a>
												<a class="next" onclick="plusSlides(1)">&#10095;</a>
												<a class="button"  href="/Lugar/nuevafoto/<?=$lugar->id?>">Nueva foto</a>
												<?php  if( Login::user()->id == $archfoto->iduser || 
										Login::oneRole(['ROLE_ADMIN','ROLE_MODERADOR']))  {
											// autorización(solo propietario o administradores)	?>
												<a class="button-danger" onclick="confirmar('borrar',<?= $archfoto->id?>,'seccomentarios')">
													<img src="/images/icons/eliminar.jpg" alt="Eliminar" style="width:20px;height:20px;"></a>
										<?php }?>	
											</div>	
											<h3> <?= $f ?> / <?= count($fotoslugar) ?> - <?=$archfoto->name?></h3><br>
														<?=$archfoto->description?>	
																
										</figcaption>
									
									</figure>
									</div>
									<section class="flex2 ">
									
									<form method="POST" enctype="multipart/form-data"  action="/comentario/store" class="w100" >
											<input type="hidden" name="iduser" value="<?= user()->id ?>">
											<input type="hidden" name="idplace" value="<?=NULL?>">
											<input type="hidden" name="idphoto" value="<?= $archfoto->id ?>">
											<input type="hidden" name="retorno" value="#seccarrousel">
					
											<input type="text" name="text" min-lenght="1" class="w50" placeholder="Escriba su comentario (solo usuarios registrados)"  required>
					
										<?php  if( Login::user()->id ){ ?>
											<input type="submit" class="button" name="nuevofotocomentario" 
													value="Añadir comentario de foto"  <?= user()->id ??'disabled'?> >
											<?php } else { ?>
												<label class="small">Solo usuarios registrados.</label>
												<?php } ?>
									</form>
									
									
										<h2 class="centered w100">Comentarios de la foto  <?=$archfoto->name?></h2>
										<?php $comentariosfoto= $archfoto->getComentarios(); ?>
									<?php if($comentariosfoto){ ?>
						      			 <div id="comentariosfotoslugar" class="flex2 w100 m0 p0" >
								 	 	  <?php foreach($comentariosfoto as $comentariofoto ){  
								  	  	
											if ($comentariofoto->idphoto==$archfoto->id){?>
													<div class="comentario centered   w100 m0 p0 flex2">
														<figure >
															<img src="<?=USER_IMAGE_FOLDER.'/'.($comentariofoto->userpicture ?? DEFAULT_USER_IMAGE)?>"
																 class="icon-image enlarge-image" alt="Foto del lugar <?= $comentariofoto->name?>">
															
														</figure>
														
														<p>	<?=$comentariofoto->username.' ---> <b> '.$comentariofoto->text.'</b>' ?>
									
														<div class="right">
																 
																<label class="mini"> Creado el <?= $comentariofoto->created_at?></label>
																<?php // Boton de eliminar
																  if( Login::user()->id == $comentariofoto->iduser || 
																Login::oneRole(['ROLE_ADMIN','ROLE_MODERADOR']))  {// autorización(solo propietario o administradores) ?>
																	<a class="button-danger" onclick="confirmar('borrar',<?=$comentariofoto->id?>,'seccomentariosfotos')">
																	<img src="/images/icons/delete.png" alt="Borrar" style="width:20px;height:20px;"></a>
																<?php } 
																
																// Boton de bloqueo 
																if(Login::oneRole(['ROLE_ADMIN','ROLE_MODERADOR'])) {?>
																	<a class="button" onclick="confirmar('bloquear',<?=$comentariofoto->id?>,'seccomentariosfotos')">
																		<img src="/images/icons/blocked.jpg" alt="Bloquear" style="width:20px;height:20px;"></a>
																<?php } ?>
										
														</div>	
															<?php } ?>
												</div>
												<?php } ?>
									</div>
						
					
				
		
						
			<?php } else { ?>
				<div class="danger p2">
					<p>No hay comentarios del sitio</p>
				</div>
				<?php } ?>
				
		</section>
									
								</div>
						
				<?php $f++; }?>
				</div>
			
			</section>
			
		</section>
			<section>
			
				<!-- Image text -->
				<div class="caption-container">
					
					
					
				</div>

				<!-- Thumbnail images -->
				<div class="row">
			<?php
			$fm = 1; // contador de foto principal
			
			foreach ( $fotoslugar as $archfoto ) {
				?>
					<div class="column">
						
						<img class="demo cursor" src="<?= LUGAR_IMAGE_FOLDER.'/'.$archfoto->file ?>" style="width: 100%"
							onclick="currentSlide(<?= $fm ?>)" alt="<?= 'Foto '.$fm ?>">
						
					</div>
					
				
				<?php $fm++ ?>  
			
					<?php }?>
				
			</div>
			<?php } else { ?>
					
					<p>No hay ninguna foto aún. Sube la primera foto de la galeria.</p><br>
					<a class="button"  href="/Lugar/nuevafoto/<?=$lugar->id?>">Nueva foto</a>
				<?php }	?>
			
		</section>
		<div class="centrado my2">
			<a class="button" onclick="history.back()">Atrás</a>
			<a class="button" href="/Lugar/list">Lista de lugares</a>
			<a class="button" href="<?=request()->url?>">Arriba</a>
		</div>
		
	</main>
	<script>
		function confirmar(accion,id,retorno=""){
			if(confirm('Seguro que deseas '+ accion+ '?')){
				switch (accion){
					case 'borrar':
						location.href='/Comentario/destroy/'+id+'/'+retorno;	
						break;
					case 'bloquear':
						location.href='/User/blocked/'+id+'/'+retorno;	
						break;
				  default:
 				   throw new Exception ("No se ha indicado la operación");
				}
			}		
		}
	</script>
	<script src="/js/Carrousel.js"></script>
</body>

</html>