<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Usuario - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="usuarios - <?= APP_NAME ?>">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Lista de libros') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Libros'=>null])?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
		
		<main>
    		<section class="flex-container" id="user-data">
    			<div class="flex2">
    				<h2>"Home de <?= $user->displayname?>"</h2>
    				
    				<p><b>Nombre:</b> 				<?= $user->displayname ?></p>
    				<p><b>Email:</b> 				<?= $user->email ?></p>
    				<p><b>Telefono:</b> 			<?= $user->phone ?></p>
    				<p><b>Fecha de alta:</b> 		<?= $user->create_at ?></p>
    				<p><b>Última modificación:</b> 	<?= $user->updated_at ?? '--'?></p>
    			</div>
    			<!-- Esta parte solamente si creais la carpeta para las fotos de perfil  -->
    			<figure class="flex1 centrado">
    				<img src="<?= USER_IMAGE_FOLDER.'/'.($user->picture ?? DEFAULT_USER_IMAGE)?>"
    					class="cover elnarge-image" alt="Emagen de perfil de <?=$user->displayname ?>">
    				<figcaption>Imagen de perfil de <?=$user->displayname ?></figcaption>				
    			</figure>			    			
    		</section>
    	</main>
    </body>
 </html>
 
       		