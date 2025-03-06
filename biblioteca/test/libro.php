<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Biblio Mora -Test  de Libro - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Lista de libros - <?= APP_NAME ?>">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Test de un libro') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(['Libros'=>'/Libro','Edicion'=>null]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
	<main>
		<h2> Test del modelo Libro</h2>
		
		<p> Este ejemplo también nos sirve para ver cómo realizar pruebas unitarias con las herramientas de FastLight.</p>
		
		<section id="recuperandoTemas">
			<h2>belongsToMany() </h2>
			
			<p>Recuperando los temas del libro 1.</p>
			<?php 
				$libro = Libro::find(1);
				dump($libro->belongsToMany('Tema','temas_libros')); //SQL, BDD
			?>
		</section>