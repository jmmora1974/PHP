<?php require 'templates/template.php' ?>
<!DOCTYPE html>
<html lang="es">

<?php head();?>
 <script
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA6UK4XPWfiFX7c_W-_9d-Qh3H3yaDG5DM&callback=initMap&libraries=geometry,places&v=weekly&callback=initMap"
		async defer></script>
	<script src="./js/mitravel.js"></script>
 <script src="js/galeria.js"></script>
<body>
	<?php
	try{
		cabecera('&#9807;Mitravel','Planifica tus aventuras');
		menu('planificador');
		migas ( [
				"Inicio" => "index.php",
				"Planificador" => "planificador.php"
		] );
		
		if(empty($_COOKIE['consentimiento']))
			aceptarCookies();
	?>
		

	<main>
		
		<div class="principal" id="principal">
						
			<div class="superior">
				<div id="divciudad">
					<section id="secbuscador" class="flex-container  ">
						<h2> En que ciudad/zona/region quieres planificar tu dia: </h2>
						<div>
							<input type="search" id="ciudad" name="ciudad" value="Catalunya">
							<input type="button" onclick="enviarconsulta.click()" class="button" value="Buscar">
						</div>
					</section>
				</div>
				<div id="formularios">
					<div class="mananas">
						<form id="buscador" target="_self" >
							<fieldset>
								<legend>Actividades</legend>
								¿Qué actividades deseas realizar?<br>

								<label for="airelibre"> Que hacer en <input type="checkbox"
										class="actividad" id="quehaceren" name="quehaceren"> </label>
								<label for="airelibre"> Actividades al aire libre <input type="checkbox"
										class="actividad" id="airelibre" name="airelibre"> </label>
								<label for="entretenimiento"> Entrenenimiento <input type="checkbox" class="actividad"
										id="entretenimiento" name="entretenimiento"></label>
								<label for="museos"> Museos <input type="checkbox" class="actividad" id="museos"
										name="museos"></label>
								<label for="arte"> Arte <input type="checkbox" class="actividad" id="arte"
										name="arte"></label>
								<label for="karting"> Karting <input type="checkbox" class="actividad" id="karting"
										name="karting">
								</label>
								<label for="compras"> Shopping <input type="checkbox" class="actividad" id="compras"
										name="compras"></label>
								<label for="deportesriegos"> Deportes de riesgo<input type="checkbox" class="actividad"
										id="deportesriegos" name="deportesriegos"></label>
								<label for="bares"> Bares y tapas <input type="checkbox" class="actividad" id="bares"
										name="bares"></label>
								<label for="espectaculos"> Espectaculos <input type="checkbox" class="actividad"
										id="espectaculos" name="espectaculos"></label>
								<label for="ruta4x4"> Rutas 4x4 <input type="checkbox" class="actividad" id="ruta4x4"
										name="ruta4x4"></label><br>

								<input type="text" id="textoconsulta" hidden>

								<label for="pac-input"></label>
								<input id="pac-input" list="listaactividades" class="control" type="search"
									onchange="enviarconsulta.click()"
									placeholder="Escribe que deseas hacer, separado por comas">
								<i class="fa fa-info"
									title=" Puedes introducir varias actividades separadas por coma. Por ejemplo, submarinismo, visitar islas.."></i>

								<datalist id="listaactividades">
									<option value="Motociclismo"></option>
									<option value="Pescar"></option>
									<option value="Bucear"></option>
									<option value="Monta a caballo"></option>
									<option value="Vistas increíbles"></option>
								</datalist>

								<input type="button" value="Buscar actividades" id="enviarconsulta">

								<span id="consejos" title="Consejos"> </span>

							</fieldset>

						</form>
					</div>


				</div>

				<div class="contenedormapa" id="contenedormapa">
					<div id="mapapepemi">
						Algo ha ocurrido, deberia haber un mapa!!.
						<div id="contentpopups" class="contentpopups"></div>
					</div>
					<div id="listado">
						<div class="place-overview">
							<div id="info">
								<div id="heading"></div>
								<div id="summary"></div>
							</div>
							<div id="gallery"></div>
						</div>
						<div id="expanded-image"></div>
						<h3 id="titulotextoconsulta"> Las recomendaciones de Mitravel son: </h3>
						<div id="detalleslugar" class="detalleslugar"></div>
						<div id="parrafo"> </div>

					</div>
				</div>
			</div>

			<h2>Agenda</h2>
			
			<div class="inferior">

				<div id="agenda" class="grid-agenda responsive">
					<div> </div>
					<div>Hora</div>
					<div>Nombre</div>
					<div>Direccion</div>
					<div>Telefono</div>
					<div>Web</div>
					<div><button class="btntrash"><i class="fa fa-trash"></i> Borra agenda</button></div>
				</div>
			</div>
			
			<section>
				<fieldset id="planificador">
					<legend>Planificador</legend>
					<h3>Quieres que mitravel te planifique el dia? </h3>
					<label>Hora inicio:
						<input type="time" name="horainicio" value="09:00">
					</label><br>
					<input type="button" value="Planifica un dia" id="enviarplan">
					<i class="fa fa-search"></i>

				</fieldset>


			</section>
		<!--  <?php chatservice() ?>  DESACTIVADO -->	
		</div>
		<div class="clearfix"></div>
		
		

	<?php mapaweb()?>

	</main>
	
	
		<?php piedepagina ('Jose Miguel Mora Perez')?>
		
	<?php } catch (Exception $e) {
	 		error_log($e->getMessage(). PHP_EOL, 3, "errores.log");
	 	}?>
	

</body>

</html>