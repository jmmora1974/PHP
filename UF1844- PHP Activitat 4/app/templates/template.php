<?php 
function head(){ ?>
<head>
<meta charset="UTF-8">
<meta name="keywords" content="HTML, CSS, JavaScript, PHP">
<meta name="description"
		content="CRUD Libros y socios de la biblioteca ">
		<meta name="author" content="Jose Miguel Mora Perez">
		
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- frameworks predefinidos..-->
		<!--<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		-->
		
		<link rel="stylesheet" type="text/css" href="https://robertsallent.com/css/generic.css">
		<!-- estilo propio.-->
		<link rel="stylesheet" href="./css/estilo.css">
		<title>Libros y socios de la biblioteca</title>
		<link rel="icon" type="image/x-icon" href="./imagenes/favicon.ico">
		
		
		</head>
		<?php cabecera("Libros y socios de la biblioteca","Activitat PHP UF1844 by Jose M Mora Perez");
 } ?>

<?php
// pone el header de la pagina
// como hay mucho HTML seguido, sale a cuenta cortar el php
function cabecera(string $titulo = '', string $subtitulo = '') {
	?>

<header class="flex-container header">
	<figure id="logo" class="text-start  logo">
		<a href="index.php" class="flex1" target="_self"><img
			src="./imagenes/logo.png" alt="Logo Biblioteca"
			style="width: 100px; height: 100px"></a>
	</figure>
	<hgroup class="flex2">
		<h1><?=$titulo ?></h1>
		<h2><?= $subtitulo ?></h2>
	</hgroup>
	<div class="search-container">
		<form action="/action_page.php">
			<input type="text" placeholder="Search.." name="search">
			<button type="submit">
				<i class="fa fa-search"></i>
			</button>
		</form>
	</div>

	<a class="button" href="index.php?controlador=login">Login</a>
</header>
<?php
}

// pone el menu de la pagina
// como hay mucho HTML seguido, sale a cuenta cortar el php
function menu(string $actual = 'ini') {
	?>


<h1>Libros de la biblioteca - $actual</h1>
<nav class=" topnav ">
	<menu>
		<li><a href="index.php">Inicio</a></li>
		<li><a href="index.php?controlador=libro/list">Lista de libros</a></li>
		<li><a href="index.php?controlador=libro/create">Nuevo Libro</a></li>
		<li><a href="index.php?controlador=socio/list">Lista de socios</a></li>
		<li><a href="index.php?controlador=socio/create">Nuevo socio</a></li>
	</menu>
</nav>

<?php
}

// pone el migas de la pagina
function migas(array $entradas = NULL) {
	
	if($entradas){
		echo "\t\t <ul class='migas'> \n"; 
		foreach ($entradas as $pagina=>$enlace) 
			echo "\t\t\t <li><a href='$enlace>$pagina</a></li>\n"; 
		echo "\t\t </ul> \n";
	}
}


// pone el pie de la pagina
function piedepagina(string $autor = '') {
	?>
<footer>
	<div class="w3-container w3-teal">
		<details>

			<summary>
				<b>Biblioteca Activitat UF1844 ®</b>. Web para CRUD de libros y socios de la biblioteca.
				 @author:<?=$autor?>
				<i class="fa fa-copyright" aria-hidden="true"></i><i
					class="fa fa-envelope-o" aria-hidden="true"></i>

			</summary>

		</details>

	</div>
</footer>
<?php
} ?>

<?php 
//Pone el boton de ir a la pagina de listado de libros
function botonListado(){ ?>
	<div class="centrado">
	<a class="button" href="index.php?controlador=libro/list">Lista de libros</a>
	</div>
<?php } ?>

<?php 
//Pone el boton de ir a la pagina de listado de socios
function botonListadoSocios(){ ?>
	<div class="centrado">
	<a class="button" href="index.php?controlador=socio/list">Lista de libros</a>
	</div>
<?php } ?>

