<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Listado de prestamos - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Lista de prestamos - <?= APP_NAME ?>">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Contacto') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Contacto'=>null])?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
		
		<main>
    		
    		<div class="flex-container gap2">
    			<section>
    				<h2>Contacto</h2>
    				<p>Utiliza el formulario de contacto para enviar un mensaje al administrador  de <?= APP_NAME ?></p>
    				
    				<form method="POST" action="/Contacto/send">
    					<label>Email</label>
    					<input type="text" name="email" required value="<?= old('email')?>">
    					<br>
    					<label>Nombre</label>
    					<input type="text" name="nombre" required value="<?= old('"nombre"')?>">
    					<br>
    					<label>Asunto</label>
    					<input type="text" name="asunto" required value="<?= old('asunto')?>">
    					<br>
    					<label>Mensaje</label>
    					<textarea name="mensaje" required value="<?= old('mensaje')?>"></textarea>
    					<br>
    					<div class="centered mt2">
    						<input class="button" type="submit" name="enviar" value="Enviar" >
    					</div>    					
    				</form>       				
    			</section>
    			<section class="flex1">
    				<h2>Ubicación y mapa</h2>
				
						<iframe class="mapa"  src="https://maps.google.com/maps?q=cifo%20valles&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
				
					<h3>Datos</h3>
					<p><b>Cifo Sabadell</b> Ctra Nac.... 08227 Terrassa<br>
						Telefono 94949494949
						
					</p>
    			</section>
    		</div>   		
       		
       		</main>
			<?= $template->footer() ?>
</body>
	
</html>